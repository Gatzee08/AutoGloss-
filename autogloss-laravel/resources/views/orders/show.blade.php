@extends('layouts.app')

@section('title', 'Nota Pesanan ' . $order->order_code . ' - AutoGloss')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('orders.index') }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
            <h1 class="text-2xl font-black text-white">Rincian Transaksi & Nota Pesanan</h1>
            <p class="text-xs text-slate-400">Model Eloquent ORM: <code>Order::with('customer', 'items.product')</code></p>
        </div>

        <div>
            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-600/20 hover:bg-rose-600/30 text-rose-400 border border-rose-500/30 text-xs font-bold transition-colors">
                    <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus Pesanan
                </button>
            </form>
        </div>
    </div>

    <!-- Payment Status Big Badge & Admin Verification Bar -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Pembayaran Saat Ini:</span>
            @if($order->payment_status === 'Lunas')
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 text-lg font-black tracking-wide shadow-lg">
                    <i class="fa-solid fa-circle-check text-xl"></i> LUNAS (TERVERIFIKASI)
                </div>
            @else
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/40 text-lg font-black tracking-wide shadow-lg">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i> BELUM LUNAS
                </div>
            @endif
        </div>

        <!-- Verification Form -->
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex flex-wrap items-center gap-3">
            @csrf
            @method('PATCH')
            <div>
                <label for="payment_status" class="block text-[11px] font-semibold text-slate-400 mb-1">Ubah Pembayaran:</label>
                <select name="payment_status" id="payment_status" class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white focus:outline-none focus:border-cyan-500">
                    <option value="Belum Lunas" {{ $order->payment_status === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="Menunggu Verifikasi" {{ $order->payment_status === 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="Lunas" {{ $order->payment_status === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Ditolak" {{ $order->payment_status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <label for="order_status" class="block text-[11px] font-semibold text-slate-400 mb-1">Status Pengerjaan:</label>
                <select name="order_status" id="order_status" class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white focus:outline-none focus:border-cyan-500">
                    <option value="Pending" {{ $order->order_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diproses" {{ $order->order_status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Sedang Dikirim" {{ $order->order_status === 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                    <option value="Selesai" {{ $order->order_status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ $order->order_status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="self-end">
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-brand-crimson to-brand-crimsonDark hover:brightness-110 text-white font-bold text-xs rounded-lg shadow-md transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Invoice Details Card -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 sm:p-8 shadow-xl space-y-6">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-700/60 gap-4">
            <div>
                <p class="text-xs uppercase font-extrabold text-slate-400 tracking-wider">No. Invoice</p>
                <h2 class="text-xl font-mono font-black text-cyan-400">{{ $order->order_code }}</h2>
                <p class="text-xs text-slate-400 mt-1">Tanggal: {{ $order->created_at ? $order->created_at->format('d F Y, H:i') : '-' }} WIB</p>
            </div>

            <div class="sm:text-right">
                <p class="text-xs uppercase font-extrabold text-slate-400 tracking-wider">Metode Bayar</p>
                <p class="text-sm font-bold text-white">{{ $order->payment_method }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Pengiriman: <span class="capitalize font-semibold text-slate-200">{{ $order->fulfillment_type }}</span></p>
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs pb-6 border-b border-slate-700/60">
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1.5">
                <h4 class="font-bold text-slate-200 uppercase tracking-wider text-[11px] mb-2 text-cyan-400">
                    <i class="fa-solid fa-user mr-1.5"></i> Informasi Pelanggan
                </h4>
                <p class="font-bold text-white text-sm">{{ $order->customer_name }}</p>
                <p class="text-slate-300"><i class="fa-solid fa-phone mr-1.5 text-slate-500"></i>{{ $order->customer_phone }}</p>
                @if($order->customer_email)
                    <p class="text-slate-400"><i class="fa-solid fa-envelope mr-1.5 text-slate-500"></i>{{ $order->customer_email }}</p>
                @endif
            </div>

            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-1.5">
                <h4 class="font-bold text-slate-200 uppercase tracking-wider text-[11px] mb-2 text-cyan-400">
                    <i class="fa-solid fa-location-dot mr-1.5"></i> Alamat & Pengambilan
                </h4>
                @if($order->fulfillment_type === 'pickup')
                    <p class="font-semibold text-slate-200">Outlet Pengambilan:</p>
                    <p class="text-slate-300">{{ $order->pickup_location ?: 'Outlet Pusat AutoGloss' }}</p>
                    @if($order->pickup_date_time)
                        <p class="text-[11px] text-amber-400"><i class="fa-solid fa-calendar-day mr-1"></i> {{ $order->pickup_date_time }}</p>
                    @endif
                @else
                    <p class="font-semibold text-slate-200">Alamat Pengiriman:</p>
                    <p class="text-slate-300">{{ $order->delivery_address ?: '-' }}</p>
                    @if($order->delivery_courier)
                        <p class="text-[11px] text-slate-400">Kurir: {{ $order->delivery_courier }}</p>
                    @endif
                @endif
            </div>
        </div>

        <!-- Items Table (ORM Relasi HasMany OrderItem) -->
        <div>
            <h4 class="font-bold text-white text-sm mb-3 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-brand-crimson"></i>
                Rincian Produk Dipesan (Eloquent <code>$order->items</code>)
            </h4>
            <div class="overflow-x-auto rounded-xl border border-slate-700/60">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-800/80 uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4 text-right">Harga Satuan</th>
                            <th class="py-3 px-4 text-center">Jumlah (Qty)</th>
                            <th class="py-3 px-4 text-right">Total Sub</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($order->items as $item)
                            <tr class="hover:bg-slate-800/40">
                                <td class="py-3 px-4 font-semibold text-white">
                                    {{ $item->product_name }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-cyan-400">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-3 px-4 text-right font-bold text-slate-100">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Price Calculation Summary -->
        <div class="flex justify-end pt-4">
            <div class="w-full sm:w-72 space-y-2 text-xs">
                <div class="flex justify-between text-slate-400">
                    <span>Subtotal Produk:</span>
                    <span class="font-semibold text-slate-200">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($order->shipping_fee > 0)
                    <div class="flex justify-between text-slate-400">
                        <span>Ongkos Kirim:</span>
                        <span class="font-semibold text-slate-200">Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
                    </div>
                @endif
                @if($order->discount > 0)
                    <div class="flex justify-between text-emerald-400">
                        <span>Potongan Diskon:</span>
                        <span class="font-semibold">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="pt-2 border-t border-slate-700 flex justify-between items-baseline">
                    <span class="text-sm font-bold text-white">Grand Total:</span>
                    <span class="text-xl font-black text-emerald-400">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($order->notes)
            <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-slate-300">
                <span class="font-bold text-slate-400 block mb-0.5">Catatan Pesanan Pelanggan:</span>
                "{{ $order->notes }}"
            </div>
        @endif
    </div>
</div>
@endsection

