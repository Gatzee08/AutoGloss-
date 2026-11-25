@extends('layouts.app')

@section('title', 'Tambah Produk Cat Baru - AutoGloss Paint Hub')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('products.index') }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Produk
            </a>
            <h1 class="text-2xl font-black text-white">Tambah Produk Baru (CRUD Create)</h1>
            <p class="text-xs text-slate-400">Menyimpan data produk baru ke tabel <code>products</code> menggunakan Eloquent ORM.</p>
        </div>
    </div>

    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 sm:p-8 shadow-xl">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kode Produk -->
                <div>
                    <label for="code" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Kode Produk <span class="text-rose-400">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code', 'PRD-' . rand(100, 999)) }}" required placeholder="PRD-019" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson font-mono">
                    <p class="text-[11px] text-slate-400 mt-1">Kode unik identifikasi SKU produk.</p>
                </div>

                <!-- Kategori (ORM Foreign Key) -->
                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Kategori (Relasi ORM) <span class="text-rose-400">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Produk -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Produk Lengkap <span class="text-rose-400">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: SuperGloss Candy Blue Metallic 1L" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Sub Kategori -->
                <div>
                    <label for="sub_category" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Sub Kategori</label>
                    <input type="text" name="sub_category" id="sub_category" value="{{ old('sub_category') }}" placeholder="Body Paint / Clear Coat / Epoxy" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Badge Promosi</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge') }}" placeholder="FLASH SALE / BEST SELLER / PROMO" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Harga Jual -->
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Harga Jual (Rp) <span class="text-rose-400">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="500" placeholder="185000" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Harga Asli / Coret -->
                <div>
                    <label for="original_price" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Harga Coret (Opsional)</label>
                    <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}" min="0" step="500" placeholder="220000" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Jumlah Stok <span class="text-rose-400">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 20) }}" required min="0" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Satuan Kemasan -->
                <div>
                    <label for="unit" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Satuan Kemasan <span class="text-rose-400">*</span></label>
                    <input type="text" name="unit" id="unit" value="{{ old('unit', '1 Liter') }}" required placeholder="1 Liter / 1 Kg Set / 1 Roll" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- URL Gambar Produk -->
                <div class="sm:col-span-2">
                    <label for="image" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">URL Foto Produk</label>
                    <input type="url" name="image" id="image" value="{{ old('image', 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=600&q=80') }}" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">
                </div>

                <!-- Deskripsi Produk -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Deskripsi Spesifikasi Produk</label>
                    <textarea name="description" id="description" rows="4" placeholder="Jelaskan karakteristik cat, daya kilap, perlindungan karat..." class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:border-brand-crimson">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-700 flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-crimson to-brand-crimsonDark hover:brightness-110 text-white text-sm font-bold shadow-lg shadow-brand-crimson/25 transition-all">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan ke Database
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

