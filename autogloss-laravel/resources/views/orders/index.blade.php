@extends('layouts.app')

@section('title', 'Manajemen Transaksi & Verifikasi Pembayaran - AutoGloss')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-brand-crimson/20 text-brand-crimson border border-brand-crimson/30">
                    Verifikasi Pembayaran & Transaksi
                </span>
                <span class="text-xs text-slate-400">Total: <strong>{{ $orders->total() }}</strong> Transaksi</span>
            </div>
            <h1 class="text-2xl font-black text-white mt-1">Daftar Pesanan & Status Pembayaran</h1>
            <p class="text-xs text-slate-400">Relasi Eloquent ORM: <code>Order::with('customer', 'items.product')</code></p>
        </div>
    </div>

    <!-- Filter Tab Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 bg-brand-card p-4 rounded-xl border border-slate-700/60 shadow-md">
        <!-- Quick Status Filter Pills -->
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('orders.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ !request('payment_status') ? 'bg-cyan-600 text-white shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                Semua Pesanan
            </a>
            <a href="{{ route('orders.index', ['payment_status' => 'Belum Lunas']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ request('payment_status') === 'Belum Lunas' ? 'bg-amber-500 text-slate-900 shadow-md' : 'bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-500/20' }}">
                <i class="fa-solid fa-clock mr-1"></i> Belum Lunas
            </a>
            <a href="{{ route('orders.index', ['payment_status' => 'Lunas']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ request('payment_status') === 'Lunas' ? 'bg-emerald-600 text-white shadow-md' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/20' }}">
                <i class="fa-solid fa-check-circle mr-1"></i> Lunas
            </a>
        </div>

        <!-- Search Order -->
        <form method="GET" action="{{ route('orders.index') }}" class="flex items-center gap-2">
            @if(request('payment_status'))
                <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
            @endif
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode order / nama..." class="pl-9 pr-3 py-1.5 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500">
            </div>
            <button type="submit" class="py-1.5 px-3 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-bold">
                Cari
            </button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-800/80 uppercase tracking-wider text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="py-3.5 px-4">No. Order</th>
                        <th class="py-3.5 px-4">Pelanggan</th>
                        <th class="py-3.5 px-4">Tipe Pengiriman</th>
                        <th class="py-3.5 px-4">Total Belanja</th>
                        <th class="py-3.5 px-4">Metode Bayar</th>
                        <th class="py-3.5 px-4">Status Bayar</th>
                        <th class="py-3.5 px-4">Status Pesanan</th>
                        <th class="py-3.5 px-4 text-right">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <!-- Kode Order -->
                            <td class="py-3 px-4">
                                <a href="{{ route('orders.show', $order->id) }}" class="font-mono font-bold text-cyan-400 hover:underline">
                                    {{ $order->order_code }}
                                </a>
                                <div class="text-[10px] text-slate-500 mt-0.5">
                                    {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>

                            <!-- Pelanggan -->
                            <td class="py-3 px-4">
                                <div class="font-bold text-white">{{ $order->customer_name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $order->customer_phone }}</div>
                            </td>

                            <!-- Fulfillment -->
                            <td class="py-3 px-4">
                                @if($order->fulfillment_type === 'pickup')
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-sky-400">
                                        <i class="fa-solid fa-store"></i> Ambil di Toko
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-purple-400">
                                        <i class="fa-solid fa-truck-fast"></i> Kurir Toko
                                    </span>
                                @endif
                            </td>

                            <!-- Total -->
                            <td class="py-3 px-4 font-bold text-white">
                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                <div class="text-[10px] text-slate-500 font-normal">
                                    {{ $order->items->count() }} jenis item
                                </div>
                            </td>

                            <!-- Metode Bayar -->
                            <td class="py-3 px-4 text-slate-300">
                                {{ $order->payment_method }}
                            </td>

                            <!-- Status Bayar (Fitur Verifikasi) -->
                            <td class="py-3 px-4">
                                @if($order->payment_status === 'Lunas')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> LUNAS
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-black bg-amber-500/10 text-amber-400 border border-amber-500/30 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-clock"></i> BELUM LUNAS
                                    </span>
                                @endif
                            </td>

                            <!-- Status Order -->
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $order->order_status }}
                                </span>
                            </td>

                            <!-- Aksi Admin -->
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Tombol Cepat Verifikasi Lunas -->
                                    @if($order->payment_status !== 'Lunas')
                                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="payment_status" value="Lunas">
                                            <input type="hidden" name="order_status" value="Diproses">
                                            <button type="submit" class="px-2 py-1 rounded bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] shadow-sm transition-colors" title="Verifikasi Lunas">
                                                <i class="fa-solid fa-check mr-1"></i> Konfirmasi Lunas
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="payment_status" value="Belum Lunas">
                                            <button type="submit" class="px-2 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-400 font-medium text-[11px] transition-colors" title="Ubah ke Belum Lunas">
                                                Tandai Belum
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('orders.show', $order->id) }}" class="p-1.5 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors" title="Lihat Rincian">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </a>

                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan {{ $order->order_code }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 transition-colors" title="Hapus Order">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-400">Tidak ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

