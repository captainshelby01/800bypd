<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Overview Summary Stats
        $totalOrders = Order::count();
        $totalGoodsSold = Order::where('payment_status', 'paid')->sum('total_amount');
        if ($totalGoodsSold == 0 && $totalOrders > 0) {
            $totalGoodsSold = Order::sum('total_amount');
        }
        $totalProducts = Product::count();
        $pendingVerifications = Order::where('payment_status', 'pending_verification')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        if ($totalCustomers == 0) {
            $totalCustomers = Order::distinct('customer_email')->count('customer_email');
        }

        // 2. Monthly Sales Revenue & Orders Per Month (Past 12 Months)
        $monthlyLabels = [];
        $monthlyRevenue = [];
        $monthlyOrders = [];

        $now = Carbon::now();
        for ($i = 11; $i >= 0; $i--) {
            $monthDate = (clone $now)->subMonths($i);
            $monthKey = $monthDate->format('M Y');
            $year = $monthDate->year;
            $month = $monthDate->month;

            $monthlyLabels[] = $monthKey;

            // Revenue for this month (paid orders or all orders)
            $rev = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where(function($q) {
                    $q->where('payment_status', 'paid')
                      ->orWhere('order_status', 'delivered');
                })
                ->sum('total_amount');
            
            // If zero check if any orders exist without strict paid filter
            if ($rev == 0) {
                $rev = Order::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->sum('total_amount');
            }

            $monthlyRevenue[] = (float) $rev;

            // Orders count for this month
            $ordersCount = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
            $monthlyOrders[] = (int) $ordersCount;
        }

        // 3. Sales by Product (Top 8-10 products)
        $topProductsData = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(8)
            ->get();

        $productLabels = [];
        $productSales = [];

        if ($topProductsData->isNotEmpty()) {
            foreach ($topProductsData as $item) {
                $productLabels[] = $item->product_name;
                $productSales[] = (int) $item->total_sold;
            }
        } else {
            // Fallback to active catalog products if no sales records exist yet
            $products = Product::take(8)->get();
            foreach ($products as $p) {
                $productLabels[] = $p->name;
                $productSales[] = 0;
            }
        }

        // 4. Latest Orders (with search support)
        $query = Order::query()->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('payment_status', 'like', "%{$search}%");
            });
        }

        $latestOrders = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalGoodsSold',
            'totalProducts',
            'pendingVerifications',
            'totalCustomers',
            'monthlyLabels',
            'monthlyRevenue',
            'monthlyOrders',
            'productLabels',
            'productSales',
            'latestOrders'
        ));
    }
}
