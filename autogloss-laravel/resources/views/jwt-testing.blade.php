@extends('layouts.app')

@section('title', 'Pengujian JWT Authentication - Week 11')

@section('content')
<div class="space-y-8">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-brand-card to-slate-900 p-6 sm:p-8 border border-amber-500/30 shadow-2xl">
        <div class="relative z-10 max-w-4xl">
            <div class="flex items-center gap-2 mb-3">
                <span class="px-3 py-1 rounded-md text-xs font-black uppercase tracking-wider bg-amber-500/20 text-amber-400 border border-amber-500/40">
                    Materi Week 11 &bull; Task 03
                </span>
                <span class="px-3 py-1 rounded-md text-xs font-bold bg-cyan-500/20 text-cyan-400 border border-cyan-500/40">
                    Postman & Insomnia Ready
                </span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                Pengujian Autentikasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-400 to-rose-400">JSON Web Token (JWT)</span>
            </h1>
            <p class="mt-2 text-sm text-slate-300 leading-relaxed">
                Implementasi lengkap rute publik <code>POST /api/login</code>, pembuatan & verifikasi token HS256, <code>JwtMiddleware</code>, proteksi rute <code>GET /api/programs</code>, dan penolakan 401 saat token tidak ada atau tidak valid.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 5 Steps Flowchart Cards (Sesuai Slide 1 Task 03) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-diagram-project text-amber-400"></i>
                Alur Pengujian 5 Langkah (Task 03 - Postman / Insomnia)
            </h2>
            <button onclick="runAllTests()" class="px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950 shadow-lg shadow-amber-500/20 hover:brightness-110 transition-all flex items-center gap-2">
                <i class="fa-solid fa-play"></i> Jalankan Semua Tes Sekaligus
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3.5">
            <!-- Step 01: Login -->
            <div id="stepCard1" class="bg-brand-card rounded-2xl border border-slate-700/60 p-4 flex flex-col justify-between transition-all hover:border-cyan-500/50">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-7 h-7 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xs font-black">01</span>
                        <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">LOGIN</span>
                    </div>
                    <div class="text-[11px] font-mono bg-slate-900 p-2 rounded-lg text-cyan-300 border border-slate-800 mb-2">
                        POST /api/login
                    </div>
                    <p class="text-[11px] text-slate-400 leading-snug">
                        Kirim email: <code class="text-slate-300">user@example.com</code> & password: <code class="text-slate-300">password</code>.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <button onclick="testStep1()" id="btnStep1" class="w-full py-1.5 px-3 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-paper-plane text-[10px]"></i> Uji Step 01
                    </button>
                </div>
            </div>

            <!-- Step 02: Copy Token -->
            <div id="stepCard2" class="bg-brand-card rounded-2xl border border-slate-700/60 p-4 flex flex-col justify-between transition-all hover:border-amber-500/50">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center text-xs font-black">02</span>
                        <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">COPY TOKEN</span>
                    </div>
                    <div class="text-[11px] font-mono bg-slate-900 p-2 rounded-lg text-amber-300 border border-slate-800 mb-2 truncate" id="tokenSnippet">
                        access_token: (belum login)
                    </div>
                    <p class="text-[11px] text-slate-400 leading-snug">
                        Ambil token JWT dari respons dan pasang pada header <code>Authorization: Bearer &lt;token&gt;</code>.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <button onclick="copyCurrentToken()" id="btnCopyToken" class="w-full py-1.5 px-3 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-regular fa-copy text-[10px]"></i> Salin Token
                    </button>
                </div>
            </div>

            <!-- Step 03: Protected Route (Valid Token) -->
            <div id="stepCard3" class="bg-brand-card rounded-2xl border border-slate-700/60 p-4 flex flex-col justify-between transition-all hover:border-emerald-500/50">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-black">03</span>
                        <span class="text-[10px] font-bold uppercase text-emerald-400 tracking-wider">SUCCESS 200</span>
                    </div>
                    <div class="text-[11px] font-mono bg-slate-900 p-2 rounded-lg text-emerald-300 border border-slate-800 mb-2">
                        GET /api/programs
                    </div>
                    <p class="text-[11px] text-slate-400 leading-snug">
                        Akses API terlindungi dengan token valid. Mengharapkan respons data program <strong>200 OK</strong>.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <button onclick="testStep3()" id="btnStep3" class="w-full py-1.5 px-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-lock-open text-[10px]"></i> Uji Step 03
                    </button>
                </div>
            </div>

            <!-- Step 04: Remove Token (No Token) -->
            <div id="stepCard4" class="bg-brand-card rounded-2xl border border-slate-700/60 p-4 flex flex-col justify-between transition-all hover:border-rose-500/50">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-7 h-7 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center text-xs font-black">04</span>
                        <span class="text-[10px] font-bold uppercase text-rose-400 tracking-wider">NO TOKEN 401</span>
                    </div>
                    <div class="text-[11px] font-mono bg-slate-900 p-2 rounded-lg text-rose-300 border border-slate-800 mb-2">
                        GET /api/programs
                    </div>
                    <p class="text-[11px] text-slate-400 leading-snug">
                        Kirim request tanpa header Authorization. Ditolak dengan <strong>401 Unauthorized</strong>.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <button onclick="testStep4()" id="btnStep4" class="w-full py-1.5 px-3 bg-rose-600 hover:bg-rose-500 text-white rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-ban text-[10px]"></i> Uji Step 04
                    </button>
                </div>
            </div>

            <!-- Step 05: Invalid Token -->
            <div id="stepCard5" class="bg-brand-card rounded-2xl border border-slate-700/60 p-4 flex flex-col justify-between transition-all hover:border-purple-500/50">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-7 h-7 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs font-black">05</span>
                        <span class="text-[10px] font-bold uppercase text-purple-400 tracking-wider">INVALID 401</span>
                    </div>
                    <div class="text-[11px] font-mono bg-slate-900 p-2 rounded-lg text-purple-300 border border-slate-800 mb-2">
                        GET /api/programs
                    </div>
                    <p class="text-[11px] text-slate-400 leading-snug">
                        Kirim token palsu <code>Bearer invalidtoken</code>. Ditolak dengan <strong>401 Token invalid</strong>.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <button onclick="testStep5()" id="btnStep5" class="w-full py-1.5 px-3 bg-purple-600 hover:bg-purple-500 text-white rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Uji Step 05
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Column Section: Live Terminal & Completion Checklist -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Live Request / Response Console (7 Cols) -->
        <div class="lg:col-span-7 bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                    <span class="text-xs font-mono text-slate-400 ml-2">Console Response Viewer (HTTP Live Fetch)</span>
                </div>
                <button onclick="clearConsole()" class="text-xs text-slate-400 hover:text-white transition-colors">
                    <i class="fa-solid fa-trash-can mr-1"></i> Bersihkan
                </button>
            </div>

            <!-- Active Test Info Bar -->
            <div id="testInfoBar" class="p-3 rounded-xl bg-slate-900/90 border border-slate-800 mb-3 text-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span id="badgeMethod" class="px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-slate-800 text-slate-400">READY</span>
                    <span id="badgeEndpoint" class="font-mono text-slate-300 text-[11px]">Silakan klik tombol uji di atas</span>
                </div>
                <span id="badgeStatus" class="font-bold text-xs text-slate-400">-</span>
            </div>

            <!-- Console Output Box -->
            <div class="flex-grow">
                <pre id="consoleOutput" class="w-full h-80 p-4 rounded-xl bg-slate-950 font-mono text-xs text-slate-300 overflow-auto border border-slate-800/80 leading-relaxed">// Output respons HTTP JSON akan tampil di sini secara real-time.
// Klik "Uji Step 01" atau "Jalankan Semua Tes Sekaligus" untuk memulai.</pre>
            </div>

            <!-- Quick Token Display -->
            <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                <div class="flex items-center gap-2 truncate max-w-md">
                    <i class="fa-solid fa-key text-amber-400"></i>
                    <span class="font-semibold text-slate-300">Active Bearer:</span>
                    <span id="activeTokenDisplay" class="font-mono text-[11px] text-slate-500 truncate">null</span>
                </div>
                <span class="text-[11px] text-emerald-400 font-semibold" id="authStatusText">Belum Login</span>
            </div>
        </div>

        <!-- Completion Checklist (5 Cols) - Sesuai Slide 2 -->
        <div class="lg:col-span-5 bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
                    <h3 class="text-base font-extrabold text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-emerald-400"></i>
                        COMPLETION CHECKLIST
                    </h3>
                    <span id="checklistProgress" class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        0 / 16 Selesai
                    </span>
                </div>

                <div class="space-y-4 max-h-[440px] overflow-y-auto pr-1 text-xs">
                    <!-- Group 1: Authentication -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-cyan-400 mb-2">
                            <i class="fa-solid fa-user-lock"></i> 1. Authentication
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-cyan-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_auth_1" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>Login API dibuat (<code>POST /api/login</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_auth_2" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>Credential diverifikasi (Hash::check)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_auth_3" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>JWT berhasil dibuat (HS256)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_auth_4" disabled class="rounded bg-slate-900 border-slate-700 text-cyan-500">
                                <span>JWT dikembalikan (<code>access_token</code>)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 2: JWT -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-amber-400 mb-2">
                            <i class="fa-solid fa-key"></i> 2. JWT
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-amber-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_jwt_1" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>Token dapat digunakan</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_jwt_2" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>Bearer token digunakan</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_jwt_3" disabled class="rounded bg-slate-900 border-slate-700 text-amber-500">
                                <span>Token dikirim pada request header</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 3: Middleware -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-400 mb-2">
                            <i class="fa-solid fa-shield-halved"></i> 3. Middleware
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-emerald-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_mid_1" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Protected route (<code>/api/programs</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_mid_2" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>JWT middleware (<code>JwtMiddleware</code>)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_mid_3" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Token valid diterima (HTTP 200)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_mid_4" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Token invalid ditolak (HTTP 401)</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_mid_5" disabled class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                                <span>Request tanpa token ditolak (HTTP 401)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Group 4: API Testing -->
                    <div>
                        <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-purple-400 mb-2">
                            <i class="fa-solid fa-vial-circle-check"></i> 4. API Testing
                        </div>
                        <div class="space-y-1.5 pl-2 border-l-2 border-purple-500/30">
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_test_1" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>Login berhasil teruji</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_test_2" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>Protected API berhasil teruji</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_test_3" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>No token diuji terkonfirmasi 401</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_test_4" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>Invalid token diuji terkonfirmasi 401</span>
                            </label>
                            <label class="flex items-center gap-2 text-slate-300">
                                <input type="checkbox" id="chk_test_5" disabled class="rounded bg-slate-900 border-slate-700 text-purple-500">
                                <span>Response JSON diperiksa lengkap</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                <span>Status Kriteria Dosen:</span>
                <span id="allPassBadge" class="font-bold text-slate-500">Menunggu Pengujian</span>
            </div>
        </div>
    </div>

    <!-- Postman & Insomnia Export Box -->
    <div class="bg-brand-card rounded-2xl border border-slate-700/60 p-6 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-code text-orange-400"></i>
                    Postman & Insomnia Collection File
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Download file JSON koleksi Postman yang telah mencakup 5 rute pengujian di atas beserta variabel lingkungan <code>access_token</code>.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="downloadPostmanCollection()" class="px-4 py-2 rounded-xl text-xs font-bold bg-orange-600 hover:bg-orange-500 text-white transition-colors flex items-center gap-2 shadow-lg shadow-orange-600/20">
                    <i class="fa-solid fa-download"></i> Unduh Postman Collection (.json)
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentToken = null;

    function setChecklist(id, checked = true) {
        const el = document.getElementById(id);
        if (el) el.checked = checked;
        updateProgress();
    }

    function updateProgress() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="chk_"]');
        let count = 0;
        checkboxes.forEach(c => { if (c.checked) count++; });
        document.getElementById('checklistProgress').innerText = `${count} / 16 Selesai`;
        const badge = document.getElementById('allPassBadge');
        if (count === 16) {
            badge.innerText = '100% LULUS SEMUA KRITERIA';
            badge.className = 'font-bold text-emerald-400';
        } else if (count > 0) {
            badge.innerText = 'Sebagian Kriteria Teruji';
            badge.className = 'font-bold text-amber-400';
        }
    }

    function logConsole(method, url, status, data, headers = {}) {
        const methodBadge = document.getElementById('badgeMethod');
        const endpointBadge = document.getElementById('badgeEndpoint');
        const statusBadge = document.getElementById('badgeStatus');

        methodBadge.innerText = method;
        endpointBadge.innerText = url;
        statusBadge.innerText = `HTTP ${status}`;

        if (status === 200 || status === 201) {
            methodBadge.className = 'px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
            statusBadge.className = 'font-bold text-xs text-emerald-400';
        } else if (status === 401) {
            methodBadge.className = 'px-2 py-0.5 rounded font-bold font-mono text-[10px] bg-rose-500/20 text-rose-400 border border-rose-500/30';
            statusBadge.className = 'font-bold text-xs text-rose-400';
        }

        const logText = `[${new Date().toLocaleTimeString()}] ${method} ${url}\n` +
            `Status: ${status} ${status === 200 ? 'OK' : (status === 401 ? 'Unauthorized' : '')}\n` +
            `Headers: ${JSON.stringify(headers, null, 2)}\n\n` +
            `Response Body:\n` +
            JSON.stringify(data, null, 2);

        document.getElementById('consoleOutput').innerText = logText;
    }

    function clearConsole() {
        document.getElementById('consoleOutput').innerText = '// Console dibersihkan.';
        document.getElementById('badgeMethod').innerText = 'READY';
        document.getElementById('badgeEndpoint').innerText = '-';
        document.getElementById('badgeStatus').innerText = '-';
    }

    // Step 01: POST /api/login
    async function testStep1() {
        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: 'user@example.com',
                    password: 'password'
                })
            });

            const data = await res.json();
            logConsole('POST', '/api/login', res.status, data);

            if (res.status === 200 && data.access_token) {
                currentToken = data.access_token;
                document.getElementById('tokenSnippet').innerText = `access_token: ${currentToken.substring(0, 20)}...`;
                document.getElementById('activeTokenDisplay').innerText = `${currentToken.substring(0, 30)}...`;
                document.getElementById('authStatusText').innerText = 'Token Tersedia';
                document.getElementById('authStatusText').className = 'text-[11px] text-emerald-400 font-semibold';

                setChecklist('chk_auth_1');
                setChecklist('chk_auth_2');
                setChecklist('chk_auth_3');
                setChecklist('chk_auth_4');
                setChecklist('chk_jwt_1');
                setChecklist('chk_test_1');
                setChecklist('chk_test_5');
            }
            return data;
        } catch (e) {
            logConsole('POST', '/api/login', 'Error', { error: e.message });
        }
    }

    function copyCurrentToken() {
        if (!currentToken) {
            alert('Silakan lakukan Login (Uji Step 01) terlebih dahulu untuk mendapatkan token.');
            return;
        }
        navigator.clipboard.writeText(currentToken).then(() => {
            alert('Bearer Token berhasil disalin ke clipboard!');
            setChecklist('chk_jwt_2');
        });
    }

    // Step 03: GET /api/programs (With Valid Token)
    async function testStep3() {
        if (!currentToken) {
            await testStep1();
        }

        try {
            const headers = {
                'Authorization': `Bearer ${currentToken}`,
                'Accept': 'application/json'
            };

            const res = await fetch('/api/programs', {
                method: 'GET',
                headers: headers
            });

            const data = await res.json();
            logConsole('GET', '/api/programs', res.status, data, { Authorization: `Bearer ${currentToken.substring(0, 15)}...` });

            if (res.status === 200) {
                setChecklist('chk_jwt_2');
                setChecklist('chk_jwt_3');
                setChecklist('chk_mid_1');
                setChecklist('chk_mid_2');
                setChecklist('chk_mid_3');
                setChecklist('chk_test_2');
            }
            return data;
        } catch (e) {
            logConsole('GET', '/api/programs', 'Error', { error: e.message });
        }
    }

    // Step 04: GET /api/programs (Without Token -> 401)
    async function testStep4() {
        try {
            const res = await fetch('/api/programs', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            logConsole('GET', '/api/programs', res.status, data, { Authorization: '(tidak ada)' });

            if (res.status === 401) {
                setChecklist('chk_mid_5');
                setChecklist('chk_test_3');
            }
            return data;
        } catch (e) {
            logConsole('GET', '/api/programs', 'Error', { error: e.message });
        }
    }

    // Step 05: GET /api/programs (With Invalid Token -> 401)
    async function testStep5() {
        try {
            const res = await fetch('/api/programs', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer invalidtoken',
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            logConsole('GET', '/api/programs', res.status, data, { Authorization: 'Bearer invalidtoken' });

            if (res.status === 401) {
                setChecklist('chk_mid_4');
                setChecklist('chk_test_4');
            }
            return data;
        } catch (e) {
            logConsole('GET', '/api/programs', 'Error', { error: e.message });
        }
    }

    // Run Full Automated Suite
    async function runAllTests() {
        clearConsole();
        document.getElementById('consoleOutput').innerText = '// Memulai pengujian otomatis alur Task 03...\n';
        
        await testStep1();
        await new Promise(r => setTimeout(r, 600));
        await testStep3();
        await new Promise(r => setTimeout(r, 600));
        await testStep4();
        await new Promise(r => setTimeout(r, 600));
        await testStep5();

        alert('Pengujian otomatis selesai! Periksa tabel Completion Checklist di sisi kanan.');
    }

    // Download Postman Collection
    function downloadPostmanCollection() {
        const postmanCollection = {
            "info": {
                "name": "AutoGloss Week 11 - JWT Authentication",
                "description": "Koleksi Postman untuk pengujian Materi Week 11 Pemrograman Web: JWT Authentication",
                "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
            },
            "item": [
                {
                    "name": "01. Login (Generate JWT)",
                    "request": {
                        "method": "POST",
                        "header": [
                            { "key": "Content-Type", "value": "application/json" },
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n  \"email\": \"user@example.com\",\n  \"password\": \"password\"\n}"
                        },
                        "url": {
                            "raw": "{{base_url}}/api/login",
                            "host": ["{{base_url}}"],
                            "path": ["api", "login"]
                        }
                    }
                },
                {
                    "name": "03. Get Programs (Valid Bearer Token)",
                    "request": {
                        "method": "GET",
                        "header": [
                            { "key": "Authorization", "value": "Bearer {{access_token}}" },
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/programs",
                            "host": ["{{base_url}}"],
                            "path": ["api", "programs"]
                        }
                    }
                },
                {
                    "name": "04. Get Programs (Remove Token -> 401)",
                    "request": {
                        "method": "GET",
                        "header": [
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/programs",
                            "host": ["{{base_url}}"],
                            "path": ["api", "programs"]
                        }
                    }
                },
                {
                    "name": "05. Get Programs (Invalid Token -> 401)",
                    "request": {
                        "method": "GET",
                        "header": [
                            { "key": "Authorization", "value": "Bearer invalidtoken" },
                            { "key": "Accept", "value": "application/json" }
                        ],
                        "url": {
                            "raw": "{{base_url}}/api/programs",
                            "host": ["{{base_url}}"],
                            "path": ["api", "programs"]
                        }
                    }
                }
            ],
            "variable": [
                { "key": "base_url", "value": "http://127.0.0.1:8000" },
                { "key": "access_token", "value": "" }
            ]
        };

        const blob = new Blob([JSON.stringify(postmanCollection, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'AutoGloss_Week11_JWT.postman_collection.json';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>
@endsection
