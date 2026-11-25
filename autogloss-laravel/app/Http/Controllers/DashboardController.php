<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilan Utama Dashboard / Ringkasan AutoGloss Paint Hub
     */
    public function index()
    {
        // Eloquent ORM: Agregasi dan statistik
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $pendingPaymentOrders = Order::where('payment_status', '!=', 'Lunas')->count();
        $totalRevenue = Order::where('payment_status', 'Lunas')->sum('grand_total');

        // Eloquent ORM: Eager loading relasi dengan with()
        $recentOrders = Order::with('customer', 'items')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 25)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'totalOrders',
            'pendingPaymentOrders',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}
