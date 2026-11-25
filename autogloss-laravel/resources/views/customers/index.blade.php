@extends('layouts.app')

@section('title', 'Data Pelanggan - AutoGloss Paint Hub')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-brand-crimson/20 text-brand-crimson border border-brand-crimson/30">
                    Database Pelanggan
                </span>
                <span class="text-xs text-slate-400">Total: <strong>{{ $customers->total() }}</strong> Orang</span>
            </div>
            <h1 class="text-2xl font-black text-white mt-1">Data Pelanggan & Bengkel Mitra</h1>
            <p class="text-xs text-slate-400">Relasi Eloquent ORM: <code>Customer::withCount('orders')</code></p>
        </div>

        <div>
            <a href="{{ route('customers.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-brand-crimson to-brand-crimsonDark text-white shadow-lg shadow-brand-crimson/20 hover:brightness-110 transition-all">
                <i class="fa-solid fa-user-plus"></i>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    <!-- Filter / Search -->
    <div class="bg-brand-card p-4 rounded-xl border border-slate-700/60 shadow-md">
        <form method="GET" action="{{ route('customers.index') }}" class="flex items-center gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan, nomor HP, atau kode pelanggan..." class="w-full pl-9 pr-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500">
            </div>
            <button type="submit" class="py-2 px-4 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg text-xs font-bold transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('customers.index') }}" class="py-2 px-3 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Customer Table -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-800/80 uppercase tracking-wider text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="py-3.5 px-4">Kode</th>
                        <th class="py-3.5 px-4">Nama Pelanggan</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4">Kota / Alamat</th>
                        <th class="py-3.5 px-4 text-center">Total Pesanan</th>
                        <th class="py-3.5 px-4">Total Belanja</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-cyan-400">{{ $customer->customer_code }}</td>
                            <td class="py-3 px-4 font-bold text-white">{{ $customer->name }}</td>
                            <td class="py-3 px-4">
                                <div class="text-slate-200"><i class="fa-solid fa-phone text-[10px] mr-1 text-slate-500"></i>{{ $customer->phone }}</div>
                                @if($customer->email)
                                    <div class="text-[11px] text-slate-400"><i class="fa-solid fa-envelope text-[10px] mr-1 text-slate-500"></i>{{ $customer->email }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-400 max-w-xs truncate">{{ $customer->city ?: ($customer->address ?: '-') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-800 text-cyan-400 border border-slate-700">
                                    {{ $customer->orders_count }} Transaksi
                                </span>
                            </td>
                            <td class="py-3 px-4 font-bold text-emerald-400">
                                Rp {{ number_format($customer->total_spent, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan {{ $customer->name }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400">Tidak ada pelanggan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection

