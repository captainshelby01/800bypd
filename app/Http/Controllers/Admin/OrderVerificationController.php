<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderVerificationController extends Controller
{
    public function index() {
        $pendingTransfers = Order::where('payment_method', 'bank_transfer')
            ->where('payment_status', 'pending_verification')
            ->latest()
            ->paginate(15);

        $allOrders = Order::latest()->paginate(15);

        return view('admin.verifications', compact('pendingTransfers', 'allOrders'));
    }

    public function approve($id) {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        return back()->with('success', "Order {$order->order_number} bank transfer verified and marked as Paid!");
    }

    public function reject($id) {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'failed',
            'order_status' => 'cancelled',
        ]);

        return back()->with('error', "Order {$order->order_number} bank transfer rejected.");
    }

    public function updateStatus(Request $request, $id) {
        $request->validate([
            'order_status' => 'required|in:pending,processing,dispatched,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->order_status,
        ]);

        return back()->with('success', "Order {$order->order_number} status updated to " . ucfirst($request->order_status) . "!");
    }
}
