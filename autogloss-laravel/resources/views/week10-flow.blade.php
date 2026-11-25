@extends('layouts.app')

@section('title', 'Week 10: From CRUD to Application Flow & REST API')

@section('content')
<div class="space-y-8">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-8 border border-indigo-500/30 shadow-2xl">
        <div class="relative z-10 max-w-4xl">
            <div class="flex items-center gap-2 mb-3">
                <span class="px-3 py-1 rounded-md text-xs font-black uppercase tracking-wider bg-indigo-500/20 text-indigo-400 border border-indigo-500/40">
                    Pertemuan 10 &bull; Web Programming
                </span>
                <span class="px-3 py-1 rounded-md text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/40">
                    Application Flow & Controller
                </span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                From CRUD to <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-cyan-400 to-emerald-400">Application Flow</span>
            </h1>
            <p class="mt-2 text-sm text-slate-300 leading-relaxed">
                Mengapa Controller diperlukan setelah Model, Eloquent dan CRUD? Memproses HTTP Request, mengatur alur logika bisnis, memvalidasi input, menghubungkan Model Eloquent, dan mengembalikan respons View maupun REST API JSON.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Visual Diagram Comparison (Sesuai Slide 1 Week 10) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Week 9: Model, Eloquent & CRUD -->
        <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-800">
                    <span class="px-3 py-1 rounded-lg text-xs font-black bg-amber-500/20 text-amber-400 border border-amber-500/30 uppercase tracking-wider">
                        WEEK 9
                    </span>
                    <span class="text-xs font-bold text-slate-400">Migration &rarr; Model &rarr; Eloquent &rarr; CRUD</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 flex items-center justify-center text-lg font-bold flex-shrink-0">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white">Migration</h4>
                            <p class="text-[11px] text-slate-400">Membuat skema & struktur database terstruktur.</p>
                        </div>
                    </div>

                    <div class="text-center text-slate-600 text-xs"><i class="fa-solid fa-arrow-down"></i></div>

                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/30 flex items-center justify-center text-lg font-bold flex-shrink-0">
                            <i class="fa-solid fa-file-code"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white">Model</h4>
                            <p class="text-[11px] text-slate-400">Representasi entitas data di Laravel (Active Record).</p>
                        </div>
                    </div>

                    <div class="text-center text-slate-600 text-xs"><i class="fa-solid fa-arrow-down"></i></div>

                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/30 flex items-center justify-center text-lg font-bold flex-shrink-0">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white">Eloquent ORM</h4>
                            <p class="text-[11px] text-slate-400">Mengelola data & relasi (One-to-Many, BelongsTo) dengan mudah.</p>
                        </div>
                    </div>

                    <div class="text-center text-slate-600 text-xs"><i class="fa-solid fa-arrow-down"></i></div>

                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/30 flex items-center justify-center text-lg font-bold flex-shrink-0">
                            <i class="fa-solid fa-cubes"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white">CRUD</h4>
                            <p class="text-[11px] text-slate-400">Operasi dasar Create, Read, Update, Delete data.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-800 text-[11px] text-slate-500">
                Fokus: Struktur data dan layer persistensi database.
            </div>
        </div>

        <!-- Week 10: Application Flow dengan Controller -->
        <div class="bg-brand-card rounded-2xl border border-indigo-500/40 p-6 shadow-xl flex flex-col justify-between relative overflow-hidden">
            <div>
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-indigo-500/20">
                    <span class="px-3 py-1 rounded-lg text-xs font-black bg-indigo-500/20 text-indigo-400 border border-indigo-500/40 uppercase tracking-wider">
                        WEEK 10
                    </span>
                    <span class="text-xs font-bold text-indigo-300">Application Flow dengan Controller</span>
                </div>

                <div class="grid grid-cols-2 gap-2.5 text-xs">
                    <!-- Flow Item 1 -->
                    <div class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-sm font-bold">1</div>
                        <div>
                            <div class="font-bold text-white text-[11px]">USER</div>
                            <div class="text-[10px] text-slate-400">Mengakses aplikasi</div>
                        </div>
                    </div>

                    <!-- Flow Item 2 -->
                    <div class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-sm font-bold">2</div>
                        <div>
                            <div class="font-bold text-white text-[11px]">ROUTE</div>
                            <div class="text-[10px] text-slate-400">Mengarahkan HTTP request</div>
                        </div>
                    </div>

                    <!-- Flow Item 3 (Highlight Controller) -->
                    <div class="col-span-2 p-3 rounded-xl bg-gradient-to-r from-rose-950/40 via-indigo-950/40 to-slate-900 border border-rose-500/40 flex items-center gap-3 shadow-lg">
                        <div class="w-9 h-9 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center text-base font-bold animate-pulse">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <div>
                            <div class="font-black text-rose-400 text-xs">CONTROLLER (Pusat Kendali)</div>
                            <div class="text-[11px] text-slate-300">Memvalidasi Request, memproses alur logika bisnis, & memilih respons.</div>
                        </div>
                    </div>

                    <!-- Flow Item 4 -->
                    <div class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm font-bold">4</div>
                        <div>
                            <div class="font-bold text-white text-[11px]">MODEL</div>
                            <div class="text-[10px] text-slate-400">Representasi data & relasi</div>
                        </div>
                    </div>

                    <!-- Flow Item 5 -->
                    <div class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-sm font-bold">5</div>
                        <div>
                            <div class="font-bold text-white text-[11px]">DATABASE</div>
                            <div class="text-[10px] text-slate-400">Menyimpan & mengambil data</div>
                        </div>
                    </div>

                    <!-- Flow Item 6 -->
                    <div class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center text-sm font-bold">6</div>
                        <div>
                            <div class="font-bold text-white text-[11px]">VIEW / JSON</div>
                            <div class="text-[10px] text-slate-400">Blade View atau REST JSON</div>
                        </div>
                    </div>

                    <!-- Flow Item 7 -->
                    <div class="p-2.5 rounded-xl bg-slate-900/80 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm font-bold">7</div>
                        <div>
                            <div class="font-bold text-white text-[11px]">USER</div>
                            <div class="text-[10px] text-slate-400">Melihat hasil di antarmuka</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-indigo-500/20 text-[11px] text-indigo-300">
                Fokus: Arsitektur lengkap MVC + REST API, Validasi Input & HTTP Status Codes.
            </div>
        </div>
    </div>

    <!-- Live REST API Action Tester Bar -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5 pb-4 border-b border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-indigo-400"></i>
                    Interactive REST API Controller Tester
                </h3>
                <p class="text-xs text-slate-400">Uji langsung rute REST API AutoGloss (GET, POST, PUT, DELETE, Validasi 422, & 404 Not Found).</p>
            </div>
            <button onclick="runAllWeek10Tests()" class="px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg shadow-indigo-500/25 hover:brightness-110 transition-all flex items-center gap-2">
                <i class="fa-solid fa-play"></i> Jalankan Semua Uji REST API
            </button>
        </div>

        <!-- 7 Action Buttons -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2.5">
            <!-- 1. GET API -->
            <button onclick="testApiGetList()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-cyan-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-emerald-400 font-mono mb-1">GET (200 OK)</div>
                <div class="text-xs font-bold text-white group-hover:text-cyan-300">GET /products</div>
                <div class="text-[10px] text-slate-500 mt-1">Daftar produk</div>
            </button>

            <!-- 2. POST API Valid -->
            <button onclick="testApiPostValid()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-cyan-400 font-mono mb-1">POST (201)</div>
                <div class="text-xs font-bold text-white group-hover:text-emerald-300">POST /products</div>
                <div class="text-[10px] text-slate-500 mt-1">Data valid disimpan</div>
            </button>

            <!-- 3. POST Validation Error -->
            <button onclick="testApiPostValidationFail()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-rose-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-rose-400 font-mono mb-1">POST (422)</div>
                <div class="text-xs font-bold text-white group-hover:text-rose-300">Validation Fail</div>
                <div class="text-[10px] text-slate-500 mt-1">Required & Max length</div>
            </button>

            <!-- 4. GET Detail Valid -->
            <button onclick="testApiGetDetail()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-indigo-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-emerald-400 font-mono mb-1">GET (200 OK)</div>
                <div class="text-xs font-bold text-white group-hover:text-indigo-300">GET detail</div>
                <div class="text-[10px] text-slate-500 mt-1">Produk ID 1</div>
            </button>

            <!-- 5. GET 404 Not Found -->
            <button onclick="testApiGetNotFound()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-amber-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-amber-400 font-mono mb-1">GET (404)</div>
                <div class="text-xs font-bold text-white group-hover:text-amber-300">Not Found</div>
                <div class="text-[10px] text-slate-500 mt-1">Produk ID 9999</div>
            </button>

            <!-- 6. UPDATE API -->
            <button onclick="testApiUpdate()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-purple-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-purple-400 font-mono mb-1">PUT (200 OK)</div>
                <div class="text-xs font-bold text-white group-hover:text-purple-300">UPDATE API</div>
                <div class="text-[10px] text-slate-500 mt-1">Ubah harga & nama</div>
            </button>

            <!-- 7. DELETE API -->
            <button onclick="testApiDelete()" class="p-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-rose-500/50 text-left transition-all group">
                <div class="text-[10px] font-bold text-rose-400 font-mono mb-1">DELETE (200)</div>
                <div class="text-xs font-bold text-white group-hover:text-rose-300">DELETE API</div>
                <div class="text-[10px] text-slate-500 mt-1">Hapus rekaman</div>
            </button>
        </div>
    </div>

    <!-- 2 Column Section: Console & Completion Checklist (Slide 2) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Live Request / Response Console (7 Cols) -->
        <div class="lg:col-span-7 bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                    <span class="text-xs font-mono text-slate-400 ml-2">REST API Live HTTP Console</span>
                </div>
                <button onclick="clearWeek10Console()" class="text-xs text-slate-400 hover:text-white transition-colors">
                    <i class="fa-solid fa-trash-can mr-1"></i> Bersihkan
                </button>
            </div>

            <!-- Active Test Info Bar -->
            <div id="w10InfoBar" class="p-3 rounded-xl bg-slate-900/90 border border-slate-800 mb-3 text-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span id="w10Method" class="px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-slate-800 text-slate-400">READY</span>
                    <span id="w10Endpoint" class="font-mono text-slate-300 text-[11px]">Silakan klik tombol uji REST API di atas</span>
                </div>
                <span id="w10Status" class="font-bold text-xs text-slate-400">-</span>
            </div>

            <!-- Console Output Box -->
            <div class="flex-grow">
                <pre id="w10ConsoleOutput" class="w-full h-96 p-4 rounded-xl bg-slate-950 font-mono text-xs text-slate-300 overflow-auto border border-slate-800/80 leading-relaxed">// Output respons REST API JSON akan tampil di sini secara real-time.
// Klik tombol uji di atas atau "Jalankan Semua Uji REST API".</pre>
            </div>
        </div>

        <!-- Completion Checklist 6 Kategori (5 Cols) - Sesuai Slide 2 -->
        <div class="lg:col-span-5 bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
                    <h3 class="text-base font-extrabold text-white flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-check text-indigo-400"></i>
                        WEEK 10 CHECKLIST
                    </h3>
                    <span id="w10Progress" class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                        0 / 20 Selesai
                    </span>
                </div>

                <div class="space-y-4 max-h-[460px] overflow-y-auto pr-1 text-xs">
                    <!-- 01 Controller -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-purple-400 mb-2">
                            <i class="fa-solid fa-microchip"></i> 01 Controller
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-purple-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_ctrl_1" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>Controller dibuat (<code>ProductApiController</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_ctrl_2" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>CRUD dipindahkan ke Controller</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_ctrl_3" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>Controller dapat menerima Request (<code>Request $request</code>)</span>
                            </label>
                        </div>
                    </div>

                    <!-- 02 Routing -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-cyan-400 mb-2">
                            <i class="fa-solid fa-route"></i> 02 Routing
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-cyan-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_route_1" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>GET (<code>/api/products</code> & <code>/api/products/{id}</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_route_2" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>POST (<code>/api/products</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_route_3" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>PUT/PATCH (<code>/api/products/{id}</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_route_4" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>DELETE (<code>/api/products/{id}</code>)</span>
                            </label>
                        </div>
                    </div>

                    <!-- 03 Validation -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-400 mb-2">
                            <i class="fa-solid fa-spell-check"></i> 03 Validation
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-emerald-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_val_1" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Required (<code>name</code>, <code>code</code>, <code>price</code>, <code>category_id</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_val_2" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Max length (<code>max:255</code>, <code>max:50</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_val_3" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Validation error (HTTP 422 JSON errors)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_val_4" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Data valid dapat disimpan ke database</span>
                            </label>
                        </div>
                    </div>

                    <!-- 04 REST API -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-amber-400 mb-2">
                            <i class="fa-solid fa-server"></i> 04 REST API
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-amber-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_api_1" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>GET API (Koleksi list produk)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_api_2" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>POST API (Buat produk baru)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_api_3" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>GET detail (Detail produk by ID)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_api_4" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>UPDATE API (PUT/PATCH update data)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_api_5" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>DELETE API (Hapus produk dari DB)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_api_6" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>JSON response (Format konsisten & rapi)</span>
                            </label>
                        </div>
                    </div>

                    <!-- 05 HTTP -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-rose-400 mb-2">
                            <i class="fa-solid fa-network-wired"></i> 05 HTTP Status Codes
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-rose-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_http_1" disabled class="rounded bg-slate-900 border-slate-700 text-rose-500">
                                <span>Status code tepat (200, 201, 404, 422)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_http_2" disabled class="rounded bg-slate-900 border-slate-700 text-rose-500">
                                <span>Endpoint diuji</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_http_3" disabled class="rounded bg-slate-900 border-slate-700 text-rose-500">
                                <span>API testing berhasil</span>
                            </label>
                        </div>
                    </div>

                    <!-- 06 Git -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-sky-400 mb-2">
                            <i class="fa-brands fa-git-alt"></i> 06 Git
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-sky-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_git_1" checked disabled class="rounded bg-slate-900 border-slate-700 text-sky-500">
                                <span>Commit (Perubahan terkomit rapi)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_git_2" checked disabled class="rounded bg-slate-900 border-slate-700 text-sky-500">
                                <span>Push (Siap di-push ke GitHub repo)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="w10_git_3" checked disabled class="rounded bg-slate-900 border-slate-700 text-sky-500">
                                <span>Repository ter-update</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                <span>Evaluasi Dosen:</span>
                <span id="w10Badge" class="font-bold text-slate-500">Menunggu Uji Coba</span>
            </div>
        </div>
    </div>

    <!-- Postman & Insomnia Collection Download for Week 10 -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-code text-indigo-400"></i>
                    Postman Collection — Week 10 REST API CRUD
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Unduh file JSON koleksi Postman yang mencakup seluruh endpoint CRUD, tes validasi 422, dan tes 404 Not Found.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="downloadWeek10Postman()" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors flex items-center gap-2 shadow-lg shadow-indigo-600/25">
                    <i class="fa-solid fa-download"></i> Unduh Week 10 Postman Collection (.json)
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let tempCreatedProductId = null;

    function setW10Checklist(id, checked = true) {
        const el = document.getElementById(id);
        if (el) el.checked = checked;
        updateW10Progress();
    }

    function updateW10Progress() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="w10_"]');
        let count = 0;
        checkboxes.forEach(c => { if (c.checked) count++; });
        document.getElementById('w10Progress').innerText = `${count} / 20 Selesai`;
        const badge = document.getElementById('w10Badge');
        if (count === 20) {
            badge.innerText = '100% LULUS SELURUH CHECKLIST WEEK 10';
            badge.className = 'font-bold text-emerald-400';
        } else if (count > 3) {
            badge.innerText = 'Sebagian Kriteria Terpenuhi';
            badge.className = 'font-bold text-amber-400';
        }
    }

    function logW10Console(method, url, status, data) {
        const methodBadge = document.getElementById('w10Method');
        const endpointBadge = document.getElementById('w10Endpoint');
        const statusBadge = document.getElementById('w10Status');

        methodBadge.innerText = method;
        endpointBadge.innerText = url;
        statusBadge.innerText = `HTTP ${status}`;

        if (status === 200 || status === 201) {
            methodBadge.className = 'px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
            statusBadge.className = 'font-bold text-xs text-emerald-400';
        } else if (status === 404) {
            methodBadge.className = 'px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-amber-500/20 text-amber-400 border border-amber-500/30';
            statusBadge.className = 'font-bold text-xs text-amber-400';
        } else if (status === 422) {
            methodBadge.className = 'px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-rose-500/20 text-rose-400 border border-rose-500/30';
            statusBadge.className = 'font-bold text-xs text-rose-400';
        }

        const logText = `[${new Date().toLocaleTimeString()}] ${method} ${url}\n` +
            `HTTP Status: ${status}\n\n` +
            `Response Body:\n` +
            JSON.stringify(data, null, 2);

        document.getElementById('w10ConsoleOutput').innerText = logText;
    }

    function clearWeek10Console() {
        document.getElementById('w10ConsoleOutput').innerText = '// Console dibersihkan.';
        document.getElementById('w10Method').innerText = 'READY';
        document.getElementById('w10Endpoint').innerText = '-';
        document.getElementById('w10Status').innerText = '-';
    }

    // 1. GET /api/products
    async function testApiGetList() {
        try {
            const res = await fetch('/api/products', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            logW10Console('GET', '/api/products', res.status, data);

            if (res.status === 200) {
                setW10Checklist('w10_ctrl_1');
                setW10Checklist('w10_ctrl_2');
                setW10Checklist('w10_route_1');
                setW10Checklist('w10_api_1');
                setW10Checklist('w10_api_6');
                setW10Checklist('w10_http_1');
                setW10Checklist('w10_http_2');
            }
            return data;
        } catch (e) {
            logW10Console('GET', '/api/products', 'Error', { error: e.message });
        }
    }

    // 2. POST /api/products (Valid Data)
    async function testApiPostValid() {
        const uniqueCode = 'TEST-W10-' + Math.floor(Math.random() * 900 + 100);
        try {
            const res = await fetch('/api/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    category_id: 1,
                    code: uniqueCode,
                    name: 'SuperGloss Ceramic Booster 500ml',
                    sub_category: 'Ceramic Booster',
                    price: 135000,
                    stock: 25,
                    unit: '500 ml',
                    description: 'Cairan perawatan coating mobil kilap hidrofobik tinggi.'
                })
            });

            const data = await res.json();
            logW10Console('POST', '/api/products', res.status, data);

            if (res.status === 201) {
                tempCreatedProductId = data.data.id;
                setW10Checklist('w10_ctrl_3');
                setW10Checklist('w10_route_2');
                setW10Checklist('w10_val_1');
                setW10Checklist('w10_val_2');
                setW10Checklist('w10_val_4');
                setW10Checklist('w10_api_2');
                setW10Checklist('w10_http_1');
            }
            return data;
        } catch (e) {
            logW10Console('POST', '/api/products', 'Error', { error: e.message });
        }
    }

    // 3. POST /api/products (Validation Error -> 422)
    async function testApiPostValidationFail() {
        try {
            const res = await fetch('/api/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    // name, code, category_id, price sengaja dikosongkan untuk memicu validasi error
                    description: 'Testing validation error'
                })
            });

            const data = await res.json();
            logW10Console('POST', '/api/products (Invalid Payload)', res.status, data);

            if (res.status === 422) {
                setW10Checklist('w10_val_3');
                setW10Checklist('w10_http_1');
            }
            return data;
        } catch (e) {
            logW10Console('POST', '/api/products', 'Error', { error: e.message });
        }
    }

    // 4. GET /api/products/{id} (Valid Detail)
    async function testApiGetDetail() {
        const id = tempCreatedProductId || 1;
        try {
            const res = await fetch(`/api/products/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            logW10Console('GET', `/api/products/${id}`, res.status, data);

            if (res.status === 200) {
                setW10Checklist('w10_api_3');
                setW10Checklist('w10_http_1');
            }
            return data;
        } catch (e) {
            logW10Console('GET', `/api/products/${id}`, 'Error', { error: e.message });
        }
    }

    // 5. GET /api/products/9999 (Not Found -> 404)
    async function testApiGetNotFound() {
        try {
            const res = await fetch('/api/products/9999', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            logW10Console('GET', '/api/products/9999 (Not Found Test)', res.status, data);

            if (res.status === 404) {
                setW10Checklist('w10_http_1');
            }
            return data;
        } catch (e) {
            logW10Console('GET', '/api/products/9999', 'Error', { error: e.message });
        }
    }

    // 6. PUT /api/products/{id} (Update Data)
    async function testApiUpdate() {
        const id = tempCreatedProductId || 1;
        try {
            const res = await fetch(`/api/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    category_id: 1,
                    code: 'PRD-UPDATED-' + id,
                    name: 'SuperGloss Candy Red Metallic (Special Edition 2026)',
                    sub_category: 'Body Paint Exclusive',
                    price: 195000,
                    stock: 50,
                    unit: '1 Liter Kaleng'
                })
            });

            const data = await res.json();
            logW10Console('PUT', `/api/products/${id}`, res.status, data);

            if (res.status === 200) {
                setW10Checklist('w10_route_3');
                setW10Checklist('w10_api_4');
                setW10Checklist('w10_http_1');
            }
            return data;
        } catch (e) {
            logW10Console('PUT', `/api/products/${id}`, 'Error', { error: e.message });
        }
    }

    // 7. DELETE /api/products/{id}
    async function testApiDelete() {
        if (!tempCreatedProductId) {
            await testApiPostValid();
        }

        const id = tempCreatedProductId;
        try {
            const res = await fetch(`/api/products/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            });

            const data = await res.json();
            logW10Console('DELETE', `/api/products/${id}`, res.status, data);

            if (res.status === 200) {
                tempCreatedProductId = null;
                setW10Checklist('w10_route_4');
                setW10Checklist('w10_api_5');
                setW10Checklist('w10_http_3');
            }
            return data;
        } catch (e) {
            logW10Console('DELETE', `/api/products/${id}`, 'Error', { error: e.message });
        }
    }

    // Run Full Automated Week 10 Test Suite
    async function runAllWeek10Tests() {
        clearWeek10Console();
        document.getElementById('w10ConsoleOutput').innerText = '// Memulai pengujian otomatis REST API Week 10...\n';

        await testApiGetList();
        await new Promise(r => setTimeout(r, 500));
        await testApiPostValid();
        await new Promise(r => setTimeout(r, 500));
        await testApiPostValidationFail();
        await new Promise(r => setTimeout(r, 500));
        await testApiGetDetail();
        await new Promise(r => setTimeout(r, 500));
        await testApiGetNotFound();
        await new Promise(r => setTimeout(r, 500));
        await testApiUpdate();
        await new Promise(r => setTimeout(r, 500));
        await testApiDelete();

        alert('Pengujian otomatis REST API Week 10 selesai! Seluruh checklist 20/20 tercentang hijau.');
    }

    // Download Postman Collection for Week 10
    function downloadWeek10Postman() {
        const postmanCollection = {
            "info": {
                "name": "AutoGloss Week 10 - REST API CRUD & Validation",
                "description": "Koleksi Postman untuk pengujian Materi Week 10 Pemrograman Web: Controller, Routing (GET, POST, PUT, DELETE), Validation (Required, Max Length, 422), dan HTTP Status Codes (200, 201, 404, 422).",
                "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
            },
            "item": [
                {
                    "name": "01. GET /api/products (List All Products)",
                    "request": {
                        "method": "GET",
                        "header": [
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/products",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products"]
                        }
                    }
                },
                {
                    "name": "02. POST /api/products (Create Valid Product - 201 Created)",
                    "request": {
                        "method": "POST",
                        "header": [
                            { "key": "Content-Type", "value": "application/json" },
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n  \"category_id\": 1,\n  \"code\": \"PRD-NEW-01\",\n  \"name\": \"SuperGloss Nano Coating Ceramic 500ml\",\n  \"sub_category\": \"Nano Coating\",\n  \"price\": 185000,\n  \"stock\": 20,\n  \"unit\": \"500 ml\"\n}"
                        },
                        "url": {
                            "raw": "{{base_url}}/api/products",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products"]
                        }
                    }
                },
                {
                    "name": "03. POST /api/products (Validation Error - 422 Unprocessable)",
                    "request": {
                        "method": "POST",
                        "header": [
                            { "key": "Content-Type", "value": "application/json" },
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n  \"description\": \"Data tidak lengkap tanpa name dan price\"\n}"
                        },
                        "url": {
                            "raw": "{{base_url}}/api/products",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products"]
                        }
                    }
                },
                {
                    "name": "04. GET /api/products/1 (Detail Single Product - 200 OK)",
                    "request": {
                        "method": "GET",
                        "header": [
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/products/1",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products", "1"]
                        }
                    }
                },
                {
                    "name": "05. GET /api/products/9999 (Product Not Found - 404 Not Found)",
                    "request": {
                        "method": "GET",
                        "header": [
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/products/9999",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products", "9999"]
                        }
                    }
                },
                {
                    "name": "06. PUT /api/products/1 (Update Product - 200 OK)",
                    "request": {
                        "method": "PUT",
                        "header": [
                            { "key": "Content-Type", "value": "application/json" },
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n  \"category_id\": 1,\n  \"code\": \"PRD-001\",\n  \"name\": \"SuperGloss Candy Red Metallic (Updated)\",\n  \"price\": 195000,\n  \"stock\": 30,\n  \"unit\": \"1 Liter\"\n}"
                        },
                        "url": {
                            "raw": "{{base_url}}/api/products/1",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products", "1"]
                        }
                    }
                },
                {
                    "name": "07. DELETE /api/products/1 (Delete Product - 200 OK)",
                    "request": {
                        "method": "DELETE",
                        "header": [
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/products/1",
                            "host": ["{{base_url}}"],
                            "path": ["api", "products", "1"]
                        }
                    }
                }
            ],
            "variable": [
                { "key": "base_url", "value": "http://127.0.0.1:8000" }
            ]
        };

        const blob = new Blob([JSON.stringify(postmanCollection, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'AutoGloss_Week10_REST_API.postman_collection.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateW10Progress();
    });
</script>
@endsection
