@extends('layouts.app')

@section('title', 'Katalog Produk Cat & Aksesoris - AutoGloss Paint Hub')

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-brand-crimson/20 text-brand-crimson border border-brand-crimson/30">
                    Laravel CRUD + ORM
                </span>
                <span class="text-xs text-slate-400">Total: <strong>{{ $products->total() }}</strong> Produk</span>
            </div>
            <h1 class="text-2xl font-black text-white mt-1">Katalog Produk AutoGloss</h1>
            <p class="text-xs text-slate-400">Menampilkan data dengan relasi Eloquent ORM <code>Product::with('category')</code>.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-brand-crimson to-brand-crimsonDark text-white shadow-lg shadow-brand-crimson/20 hover:brightness-110 transition-all">
                <i class="fa-solid fa-circle-plus"></i>
                Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-brand-card p-4 rounded-xl border border-slate-700/60 shadow-md">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
            <!-- Search Text -->
            <div class="lg:col-span-5">
                <label for="search" class="block text-xs font-semibold text-slate-300 mb-1">Cari Nama / Kode Produk</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Contoh: Candy Red, Clear Coat, PRD-001..." class="w-full pl-9 pr-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500">
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="lg:col-span-4">
                <label for="category_id" class="block text-xs font-semibold text-slate-300 mb-1">Kategori Produk</label>
                <select name="category_id" id="category_id" class="w-full py-2 px-3 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white focus:outline-none focus:border-cyan-500">
                    <option value="">Semua Kategori ({{ $categories->sum('products_count') }})</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Promo Checkbox -->
            <div class="lg:col-span-1 flex items-center h-10">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_promo" value="1" {{ request('is_promo') ? 'checked' : '' }} class="sr-only peer">
                    <div class="relative w-9 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-crimson"></div>
                    <span class="ms-2 text-xs font-semibold text-slate-300">Promo</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-3 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg text-xs font-bold transition-colors">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
                @if(request()->hasAny(['search', 'category_id', 'is_promo']))
                    <a href="{{ route('products.index') }}" class="py-2 px-3 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Product Grid Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($products as $prod)
            <div class="bg-brand-card rounded-2xl border border-slate-700/60 overflow-hidden flex flex-col hover:border-brand-crimson/50 hover:shadow-xl transition-all group">
                <!-- Product Thumbnail with Badge -->
                <div class="relative h-44 w-full bg-slate-900 overflow-hidden">
                    <img src="{{ $prod->image ?: 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    
                    <!-- Top Badges -->
                    <div class="absolute top-2 left-2 flex gap-1 flex-wrap">
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-slate-900/90 text-cyan-300 backdrop-blur-sm border border-cyan-500/30 font-mono">
                            {{ $prod->code }}
                        </span>
                        @if($prod->badge)
                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-brand-crimson text-white shadow-sm">
                                {{ $prod->badge }}
                            </span>
                        @endif
                    </div>

                    <!-- Category Pill (ORM BelongsTo) -->
                    <div class="absolute bottom-2 left-2">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-800/90 text-slate-200 border border-slate-600/50 backdrop-blur-sm">
                            <i class="fa-solid fa-tag text-[9px] mr-1 text-amber-400"></i>
                            {{ $prod->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>

                <!-- Product Content -->
                <div class="p-4 flex flex-col flex-grow">
                    <div class="text-[11px] text-slate-400 font-medium mb-1">
                        {{ $prod->sub_category ?: 'Automotive Coating' }}
                    </div>
                    <h3 class="text-sm font-bold text-white group-hover:text-cyan-300 transition-colors line-clamp-2 mb-2" title="{{ $prod->name }}">
                        {{ $prod->name }}
                    </h3>

                    <!-- Price & Discount -->
                    <div class="mt-auto pt-2 border-t border-slate-700/50">
                        <div class="flex items-baseline gap-2">
                            <span class="text-base font-black text-emerald-400">
                                Rp {{ number_format($prod->price, 0, ',', '.') }}
                            </span>
                            @if($prod->original_price && $prod->original_price > $prod->price)
                                <span class="text-[11px] text-slate-400 line-through">
                                    Rp {{ number_format($prod->original_price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between mt-1 text-[11px] text-slate-400">
                            <span>Stok: <strong class="{{ $prod->stock <= 10 ? 'text-rose-400' : 'text-slate-200' }}">{{ $prod->stock }}</strong> {{ $prod->unit }}</span>
                            <span class="text-amber-400">
                                <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($prod->rating, 1) }}
                            </span>
                        </div>
                    </div>

                    <!-- CRUD Action Buttons -->
                    <div class="mt-4 pt-3 border-t border-slate-800 flex items-center gap-1.5">
                        <a href="{{ route('products.show', $prod->id) }}" class="flex-1 text-center py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 transition-colors" title="Lihat Detail">
                            <i class="fa-solid fa-eye mr-1"></i> Detail
                        </a>
                        <a href="{{ route('products.edit', $prod->id) }}" class="flex-1 text-center py-1.5 rounded-lg bg-cyan-600/20 hover:bg-cyan-600/30 text-cyan-400 border border-cyan-500/30 text-xs font-semibold transition-colors" title="Edit Produk">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                        </a>
                        <form action="{{ route('products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $prod->name }}?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 text-xs font-semibold transition-colors" title="Hapus Produk">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-brand-card p-12 rounded-2xl border border-slate-700/60 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center mx-auto text-2xl mb-4">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-base font-bold text-white">Tidak ada produk ditemukan</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                    Katalog tidak memiliki produk yang sesuai dengan pencarian atau filter yang dipilih.
                </p>
                <a href="{{ route('products.create') }}" class="inline-block mt-4 px-4 py-2 rounded-lg bg-brand-crimson text-white text-xs font-bold">
                    Tambah Produk Baru
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection

