@extends('layouts.app')

@section('title', 'Tambah Kategori - AutoGloss Paint Hub')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div>
        <a href="{{ route('categories.index') }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1.5 mb-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kategori
        </a>
        <h1 class="text-2xl font-black text-white">Tambah Kategori Baru</h1>
        <p class="text-xs text-slate-400">Menyimpan kategori ke tabel <code>categories</code>.</p>
    </div>

    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 sm:p-8 shadow-xl">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Kategori <span class="text-rose-400">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Cat Khusus Velg Mobil" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
            </div>

            <div>
                <label for="icon" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Ikon FontAwesome (Class)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', 'fa-spray-can') }}" placeholder="fa-car-side, fa-paint-roller, fa-shield-halved" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson font-mono">
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Deskripsi Kategori</label>
                <textarea name="description" id="description" rows="3" placeholder="Keterangan jenis cat atau peruntukannya..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-700 flex justify-end gap-3">
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-crimson to-brand-crimsonDark hover:brightness-110 text-white text-sm font-bold shadow-lg shadow-brand-crimson/25 transition-all">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

