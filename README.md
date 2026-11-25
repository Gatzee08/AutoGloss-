# AUTO GLOSS PAINT HUB

Proyek Aplikasi Penjualan Cat Mobil & Body Coating - Mata Kuliah Pemrograman Web (Semester 5).

---

## 📂 Struktur & Modul Perkuliahan

1. **`autogloss-laravel/` (Aplikasi Utama Berbasis Laravel Framework)**
   - **Materi Week 10 — From CRUD to Application Flow & REST API (Pertemuan 10):**
     - Penerapan arsitektur alur lengkap: `USER -> ROUTE -> CONTROLLER -> MODEL -> DATABASE -> VIEW -> USER`.
     - Controller REST API [`ProductApiController.php`](autogloss-laravel/app/Http/Controllers/Api/ProductApiController.php) memproses request HTTP, validasi, dan persistensi database.
     - Routing lengkap: `GET`, `POST`, `PUT/PATCH`, `DELETE`.
     - Validasi data: aturan `required`, batasan `max`, penanganan galat `422 Unprocessable Content`, dan penyimpanan data valid.
     - Respons JSON terstruktur & kode status HTTP yang tepat (`200 OK`, `201 Created`, `404 Not Found`, `422 Unprocessable Content`).
     - Halaman Web Interactive Flow & REST API Playground: `http://127.0.0.1:8000/week10`.
     - File koleksi Postman Week 10: [`AutoGloss_Week10_REST_API.postman_collection.json`](autogloss-laravel/AutoGloss_Week10_REST_API.postman_collection.json).
     - Dokumentasi lengkap materi Week 10: [README-WEEK10-APPLICATION-FLOW.md](autogloss-laravel/README-WEEK10-APPLICATION-FLOW.md).

   - **Materi Week 11 — JWT Authentication (Pertemuan 11):**
     - Endpoint login publik `POST /api/login` menghasilkan token JWT HS256 (`access_token`, `token_type: bearer`).
     - Middleware proteksi [`JwtMiddleware.php`](autogloss-laravel/app/Http/Middleware/JwtMiddleware.php) yang memvalidasi bearer token dan signature.
     - Protected route `GET /api/programs` sesuai alur pengujian Task 03 Slide 1 & 2.
     - Penolakan HTTP 401 saat token tidak ada (`Unauthorized`) atau token tidak valid (`Token invalid`).
     - Halaman live testing playground: `http://127.0.0.1:8000/jwt-testing`.
     - File koleksi Postman Week 11: [`AutoGloss_Week11_JWT.postman_collection.json`](autogloss-laravel/AutoGloss_Week11_JWT.postman_collection.json).
     - Dokumentasi lengkap materi Week 11: [README-WEEK11-JWT-AUTHENTICATION.md](autogloss-laravel/README-WEEK11-JWT-AUTHENTICATION.md).

   - **Materi Week 9 — Laravel CRUD + Eloquent ORM (Pertemuan 9):**
     - Migrasi 6 tabel (`categories`, `products`, `customers`, `orders`, `order_items`, `programs`).
     - Model Eloquent ORM dengan relasi One-to-Many (`hasMany`, `belongsTo`), agregasi, dan eager loading.
     - Resource Controller & Blade templating responsif bertema dark otomotif + Tailwind CSS + FontAwesome 6.
     - Dokumentasi lengkap materi Week 9: [README-WEEK9-CRUD-ORM.md](autogloss-laravel/README-WEEK9-CRUD-ORM.md).

2. **`Pem. Web - Copy/` (Arsip Materi Sebelumnya: Frontend SPA & Fetch API)**
   - Versi prototipe statis HTML/CSS/JavaScript.
   - Menggunakan Fetch API ke `data/products.json` dan penyimpanan client-side `localStorage`.

---

## ⚡ Pintasan Menjalankan Aplikasi (Double-Click Batches)

1. **Jalankan Server Laravel:**
   - Klik ganda **`jalankan-server.bat`**, lalu buka browser di:
     - Dashboard Web: `http://127.0.0.1:8000`
     - Week 10 Flow & REST API: `http://127.0.0.1:8000/week10`
     - Week 11 JWT Authentication: `http://127.0.0.1:8000/jwt-testing`
2. **Uji Otomatis Week 10 (REST API CRUD):**
   - Klik ganda **`test-week10.bat`** untuk mengeksekusi 7 pengujian REST API via terminal.
3. **Uji Otomatis Week 11 (JWT Auth):**
   - Klik ganda **`test-jwt.bat`** untuk mengeksekusi 5 pengujian Task 03 via terminal.
4. **Migrasi & Seeding Database:**
   - Klik ganda **`migrate-database.bat`** untuk reset & seed ulang seluruh database.
