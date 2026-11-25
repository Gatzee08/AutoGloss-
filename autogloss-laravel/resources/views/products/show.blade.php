@extends('layouts.app')

@section('title', 'Detail Produk ' . $product->name . ' - AutoGloss')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('products.index') }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Produk
            </a>
            <h1 class="text-2xl font-black text-white">Detail Spesifikasi Produk</h1>
            <p class="text-xs text-slate-400">Model Eloquent ORM: <code>Product::with('category')->find({{ $product->id }})</code></p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('products.edit', $product->id) }}" class="px-3.5 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-bold transition-colors">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit
            </a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-600/20 hover:bg-rose-600/30 text-rose-400 border border-rose-500/30 text-xs font-bold transition-colors">
                    <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 sm:p-8 shadow-xl grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="space-y-4">
            <div class="h-80 w-full rounded-2xl bg-slate-900 border border-slate-700 overflow-hidden relative">
                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @if($product->badge)
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-md text-xs font-black uppercase bg-brand-crimson text-white shadow-md">
                        {{ $product->badge }}
                    </span>
                @endif
            </div>

            <!-- Features Pill List -->
            @if(!empty($product->features) && is_array($product->features))
                <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/60">
                    <h4 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Fitur Unggulan Formula:</h4>
                    <ul class="space-y-1.5">
                        @foreach($product->features as $feat)
                            <li class="text-xs text-slate-300 flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-cyan-400 text-[11px]"></i>
                                {{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Product Information -->
        <div class="flex flex-col justify-between space-y-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded text-xs font-mono font-bold uppercase bg-slate-800 text-cyan-400 border border-cyan-500/30">
                        {{ $product->code }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                        {{ $product->category->name ?? 'Kategori' }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">&bull; {{ $product->sub_category }}</span>
                </div>

                <h2 class="text-2xl font-black text-white leading-tight mb-3">
                    {{ $product->name }}
                </h2>

                <div class="flex items-baseline gap-3 mb-4">
                    <span class="text-3xl font-black text-emerald-400">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="text-sm text-slate-400 line-through">
                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                        </span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-rose-500/20 text-rose-400 border border-rose-500/30">
                            Hemat {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                        </span>
                    @endif
                </div>

                <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800 text-xs text-slate-300 leading-relaxed mb-6">
                    <p class="font-bold text-slate-200 mb-1">Deskripsi:</p>
                    {{ $product->description ?: 'Tidak ada deskripsi rinci untuk produk ini.' }}
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                    <div class="p-3 rounded-lg bg-slate-800/40 border border-slate-700/40">
                        <span class="text-slate-400 block text-[11px]">Sisa Stok</span>
                        <span class="font-bold text-white text-sm">{{ $product->stock }} {{ $product->unit }}</span>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-800/40 border border-slate-700/40">
                        <span class="text-slate-400 block text-[11px]">Rating Pembeli</span>
                        <span class="font-bold text-amber-400 text-sm">
                            <i class="fa-solid fa-star text-xs"></i> {{ number_format($product->rating, 1) }} / 5.0
                        </span>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-800/40 border border-slate-700/40">
                        <span class="text-slate-400 block text-[11px]">Total Terjual</span>
                        <span class="font-bold text-cyan-400 text-sm">{{ $product->sold_count }} kaleng</span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                <span>Ditambahkan: {{ $product->created_at ? $product->created_at->format('d M Y, H:i') : '-' }}</span>
                <span>Terakhir Diperbarui: {{ $product->updated_at ? $product->updated_at->diffForHumans() : '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

