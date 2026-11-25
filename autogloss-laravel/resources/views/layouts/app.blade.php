<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AutoGloss Paint Hub') - Laravel CRUD & Eloquent ORM</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            crimson: '#e63946',
                            crimsonDark: '#c1121f',
                            cyan: '#06b6d4',
                            dark: '#0f172a',
                            darker: '#090d16',
                            card: '#1e293b'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-brand-darker text-slate-100 min-h-screen flex flex-col">

    <!-- Navbar Header -->
    <nav class="bg-brand-dark/95 border-b border-slate-800 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-crimson to-orange-500 flex items-center justify-center text-white shadow-lg shadow-brand-crimson/30 group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-spray-can text-xl"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-lg tracking-wider text-white flex items-center gap-1.5">
                                AUTOGLOSS <span class="text-xs px-2 py-0.5 rounded-full bg-brand-crimson text-white font-bold uppercase tracking-widest">HUB</span>
                            </div>
                            <p class="text-[11px] text-slate-400 font-medium">Laravel 11 CRUD & ORM</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-brand-crimson text-white shadow-md shadow-brand-crimson/20' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-gauge mr-1.5"></i> Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('products.*') ? 'bg-brand-crimson text-white shadow-md shadow-brand-crimson/20' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-boxes-stacked mr-1.5"></i> Produk
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('categories.*') ? 'bg-brand-crimson text-white shadow-md shadow-brand-crimson/20' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-tags mr-1.5"></i> Kategori
                    </a>
                    <a href="{{ route('customers.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('customers.*') ? 'bg-brand-crimson text-white shadow-md shadow-brand-crimson/20' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-users mr-1.5"></i> Pelanggan
                    </a>
                    <a href="{{ route('orders.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('orders.*') ? 'bg-brand-crimson text-white shadow-md shadow-brand-crimson/20' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-receipt mr-1.5"></i> Pesanan
                    </a>
                </div>

                <!-- Right Action / Info -->
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Week 9: CRUD + ORM
                    </span>
                    <a href="{{ route('products.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs sm:text-sm font-bold bg-gradient-to-r from-brand-crimson to-brand-crimsonDark text-white shadow-md hover:brightness-110 transition-all">
                        <i class="fa-solid fa-plus"></i>
                        <span class="hidden sm:inline">Tambah Produk</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Notification Success / Error -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">Operasi Berhasil</p>
                        <p class="text-xs text-emerald-300/80">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-950/60 border border-rose-500/40 text-rose-300 shadow-lg">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center text-rose-400 font-bold">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <p class="font-semibold text-sm">Terjadi Kesalahan Validasi Form:</p>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 ml-11 text-rose-200/80">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-dark border-t border-slate-800 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
            <div class="flex items-center gap-2">
                <span class="font-bold text-slate-200">AutoGloss Paint Hub</span> &bull; 
                <span>Materi Kuliah Pemrograman Web - Semester 5 (Week 9)</span>
            </div>
            <div class="flex items-center gap-4 text-slate-500">
                <span>Laravel Framework v{{ Illuminate\Foundation\Application::VERSION }}</span>
                <span>&bull;</span>
                <span>PHP v{{ PHP_VERSION }}</span>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>

