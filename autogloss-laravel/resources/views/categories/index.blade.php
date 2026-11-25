@extends('layouts.app')

@section('title', 'Kategori Cat & Perlengkapan - AutoGloss Paint Hub')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-brand-crimson/20 text-brand-crimson border border-brand-crimson/30">
                    Master Kategori
                </span>
                <span class="text-xs text-slate-400">Total: <strong>{{ $categories->count() }}</strong> Kategori</span>
            </div>
            <h1 class="text-2xl font-black text-white mt-1">Kategori Produk Cat & Alat</h1>
            <p class="text-xs text-slate-400">Relasi Eloquent ORM One-to-Many: <code>Category::withCount('products')</code></p>
        </div>

        <div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-brand-crimson to-brand-crimsonDark text-white shadow-lg shadow-brand-crimson/20 hover:brightness-110 transition-all">
                <i class="fa-solid fa-folder-plus"></i>
                Tambah Kategori Baru
            </a>
        </div>
    </div>

    <!-- Category Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($categories as $category)
            <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col justify-between hover:border-cyan-500/50 transition-all group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-cyan-400 text-xl group-hover:scale-110 group-hover:bg-cyan-500/10 group-hover:border-cyan-500/40 transition-all">
                            <i class="fa-solid {{ $category->icon ?: 'fa-spray-can' }}"></i>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-slate-800 text-cyan-400 border border-slate-700">
                            {{ $category->products_count }} Produk
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-white group-hover:text-cyan-300 transition-colors">
                        {{ $category->name }}
                    </h3>
                    <p class="text-xs font-mono text-slate-500 mb-2">slug: /{{ $category->slug }}</p>
                    <p class="text-xs text-slate-300 leading-relaxed line-clamp-3">
                        {{ $category->description ?: 'Kategori perlengkapan dan cat resmi AutoGloss Hub.' }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-700/60 flex items-center justify-between gap-2">
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="text-xs font-bold text-cyan-400 hover:underline">
                        Lihat Produk &rarr;
                    </a>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('categories.edit', $category->id) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta produk terkait?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-brand-card p-8 rounded-xl text-center text-slate-400 text-xs">
                Belum ada kategori terdaftar. Silakan tambahkan kategori pertama Anda.
            </div>
        @endforelse
    </div>
</div>
@endsection

