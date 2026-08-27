<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ordersCount = $user->orders()->count();
        $recentOrders = $user->orders()->with('items')->latest()->take(5)->get();

        return view('account.dashboard', compact('user', 'ordersCount', 'recentOrders'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items')->latest()->paginate(10);

        return view('account.orders', compact('user', 'orders'));
    }

    public function showOrder($orderNumber)
    {
        $user = Auth::user();
        $order = $user->orders()->with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('account.order_detail', compact('user', 'order'));
    }
}
