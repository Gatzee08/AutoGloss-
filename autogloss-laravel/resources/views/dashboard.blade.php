@extends('layouts.app')

@section('title', 'Dashboard - AutoGloss Paint Hub')

@section('content')
<div class="space-y-8">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-card via-slate-800 to-brand-card p-6 sm:p-8 border border-slate-700/60 shadow-xl">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-block px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-brand-crimson/20 text-brand-crimson border border-brand-crimson/30 mb-3">
                Sistem Manajemen Toko Cat & Body Coating
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Selamat Datang di <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-crimson to-amber-400">AutoGloss Paint Hub</span>
            </h1>
            <p class="mt-2 text-sm text-slate-300 leading-relaxed">
                Implementasi Materi <strong>Week 9: Laravel CRUD & Eloquent ORM</strong> (One-to-Many, Belongs-to, Aggregations, Eager Loading, Query Builder). Kelola produk cat, kategori, pelanggan, dan verifikasi status pembayaran pesanan secara terintegrasi.
            </p>
        </div>
        <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-10 bg-[radial-gradient(#e63946_1px,transparent_1px)] [background-size:16px_16px]"></div>
    </div>

    <!-- Stat Cards (Eloquent ORM Aggregations) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Produk -->
        <div class="bg-brand-card p-5 rounded-xl border border-slate-700/60 shadow-lg relative overflow-hidden group hover:border-brand-crimson/50 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Produk</p>
                    <h3 class="text-3xl font-black text-white mt-1">{{ $totalProducts }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Dalam {{ $totalCategories }} kategori aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-brand-crimson/10 border border-brand-crimson/30 flex items-center justify-center text-brand-crimson text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-700/50 flex justify-between items-center text-xs">
                <span class="text-slate-400">Model: <code class="text-brand-crimson font-mono">Product::count()</code></span>
                <a href="{{ route('products.index') }}" class="text-cyan-400 hover:underline font-semibold">Kelola &rarr;</a>
            </div>
        </div>

        <!-- Card 2: Total Pesanan -->
        <div class="bg-brand-card p-5 rounded-xl border border-slate-700/60 shadow-lg relative overflow-hidden group hover:border-cyan-500/50 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pesanan</p>
                    <h3 class="text-3xl font-black text-white mt-1">{{ $totalOrders }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Transaksi online & pickup</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-700/50 flex justify-between items-center text-xs">
                <span class="text-slate-400">Model: <code class="text-cyan-400 font-mono">Order::count()</code></span>
                <a href="{{ route('orders.index') }}" class="text-cyan-400 hover:underline font-semibold">Lihat &rarr;</a>
            </div>
        </div>

        <!-- Card 3: Menunggu Verifikasi Pembayaran -->
        <div class="bg-brand-card p-5 rounded-xl border border-slate-700/60 shadow-lg relative overflow-hidden group hover:border-amber-500/50 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Belum Lunas</p>
                    <h3 class="text-3xl font-black text-amber-400 mt-1">{{ $pendingPaymentOrders }}</h3>
                    <p class="text-[11px] text-amber-400/80 mt-1">Perlu konfirmasi admin</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-700/50 flex justify-between items-center text-xs">
                <span class="text-slate-400">Status verifikasi kasir</span>
                <a href="{{ route('orders.index', ['payment_status' => 'Belum Lunas']) }}" class="text-amber-400 hover:underline font-semibold">Proses &rarr;</a>
            </div>
        </div>

        <!-- Card 4: Total Pelanggan & Omset -->
        <div class="bg-brand-card p-5 rounded-xl border border-slate-700/60 shadow-lg relative overflow-hidden group hover:border-emerald-500/50 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Omset Lunas</p>
                    <h3 class="text-2xl font-black text-emerald-400 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-400 mt-1">Dari {{ $totalCustomers }} pelanggan terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-700/50 flex justify-between items-center text-xs">
                <span class="text-slate-400">Model: <code class="text-emerald-400 font-mono">Order::sum('grand_total')</code></span>
                <a href="{{ route('customers.index') }}" class="text-emerald-400 hover:underline font-semibold">Pelanggan &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 2 Column Section: Pesanan Terbaru & Stok Kritis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pesanan Terbaru (2 Cols) -->
        <div class="lg:col-span-2 bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-brand-crimson"></i>
                        Pesanan Masuk Terbaru
                    </h2>
                    <p class="text-xs text-slate-400">Relasi Eloquent ORM: Order belongsTo Customer, hasMany OrderItem</p>
                </div>
                <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-brand-crimson hover:underline">
                    Semua Pesanan &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-800/80 uppercase tracking-wider text-slate-400 border-b border-slate-700">
                        <tr>
                            <th class="py-3 px-3">Kode Order</th>
                            <th class="py-3 px-3">Pelanggan</th>
                            <th class="py-3 px-3">Total Belanja</th>
                            <th class="py-3 px-3">Pembayaran</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="py-3 px-3 font-mono font-bold text-cyan-400">{{ $order->order_code }}</td>
                                <td class="py-3 px-3">
                                    <div class="font-semibold text-white">{{ $order->customer_name }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="py-3 px-3 font-semibold text-slate-200">
                                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3">
                                    @if($order->payment_status === 'Lunas')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                            <i class="fa-solid fa-check-circle mr-1"></i> LUNAS
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                            <i class="fa-solid fa-clock mr-1"></i> {{ $order->payment_status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('orders.show', $order->id) }}" class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-white font-medium transition-colors">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-slate-400">Belum ada pesanan transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stok Cat Kritis (1 Col) -->
        <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-400"></i>
                        Peringatan Stok Cat
                    </h2>
                    <p class="text-xs text-slate-400">Stok &le; 25 unit perlu restock</p>
                </div>
            </div>

            <div class="space-y-3 flex-grow">
                @forelse($lowStockProducts as $prod)
                    <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/50 flex items-center gap-3">
                        <img src="{{ $prod->image }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-lg object-cover bg-slate-700 flex-shrink-0">
                        <div class="flex-grow min-w-0">
                            <h4 class="text-xs font-bold text-white truncate">{{ $prod->name }}</h4>
                            <p class="text-[11px] text-slate-400">{{ $prod->category->name ?? 'Umum' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="px-2 py-1 rounded-md text-xs font-black {{ $prod->stock <= 15 ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }}">
                                {{ $prod->stock }} {{ $prod->unit }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">Semua stok produk dalam kondisi aman.</p>
                @endforelse
            </div>

            <div class="mt-4 pt-3 border-t border-slate-700">
                <a href="{{ route('products.index') }}" class="block text-center py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300 transition-all">
                    Lihat Semua Katalog Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

