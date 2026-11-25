@extends('layouts.app')

@section('title', 'Tambah Pelanggan Baru - AutoGloss')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('customers.index') }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1.5 mb-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pelanggan
        </a>
        <h1 class="text-2xl font-black text-white">Tambah Pelanggan / Bengkel Baru</h1>
        <p class="text-xs text-slate-400">Registrasi pelanggan ke tabel <code>customers</code>.</p>
    </div>

    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 sm:p-8 shadow-xl">
        <form action="{{ route('customers.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="customer_code" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Kode Pelanggan <span class="text-rose-400">*</span></label>
                    <input type="text" name="customer_code" id="customer_code" value="{{ old('customer_code', 'CUST-' . rand(100, 999)) }}" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson font-mono">
                </div>

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap / Bengkel <span class="text-rose-400">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Budi Santoso / Bengkel Maju" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp <span class="text-rose-400">*</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="081234567890" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="budi@example.com" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <div>
                    <label for="city" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Kota Domisili</label>
                    <input type="text" name="city" id="city" value="{{ old('city', 'Jakarta') }}" placeholder="Jakarta / Tangerang / Surabaya" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" placeholder="Jl. Raya Otomotif No. 10..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-700 flex justify-end gap-3">
                <a href="{{ route('customers.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-crimson to-brand-crimsonDark hover:brightness-110 text-white text-sm font-bold shadow-lg shadow-brand-crimson/25 transition-all">
                    Simpan Pelanggan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

