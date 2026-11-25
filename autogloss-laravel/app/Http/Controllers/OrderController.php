<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource (Method Index - Week 9).
     * Eloquent ORM: Eager loading relasi customer dan order items.
     */
    public function index(Request $request)
    {
        $query = Order::with('customer', 'items.product');

        // Filter status pembayaran (Belum Lunas / Lunas)
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // Filter status pesanan
        if ($request->filled('order_status')) {
            $query->where('order_status', $request->input('order_status'));
        }

        // Pencarian nomor pesanan / nama pelanggan
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order with all items.
     */
    public function show(string $id)
    {
        $order = Order::with('customer', 'items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Update order status or confirm payment (Verifikasi Pembayaran Admin).
     */
    public function updateStatus(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'nullable|string|in:Belum Lunas,Menunggu Verifikasi,Lunas,Ditolak',
            'order_status' => 'nullable|string|in:Pending,Diproses,Sedang Dikirim,Selesai,Dibatalkan',
        ]);

        if (isset($validated['payment_status'])) {
            $order->payment_status = $validated['payment_status'];
        }
        if (isset($validated['order_status'])) {
            $order->order_status = $validated['order_status'];
        }

        $order->save();

        return back()->with('success', 'Status pesanan ' . $order->order_code . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $code = $order->order_code;
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan ' . $code . ' berhasil dihapus!');
    }
}
