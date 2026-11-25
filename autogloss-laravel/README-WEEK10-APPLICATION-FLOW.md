# DOKUMENTASI MATERI WEEK 10: FROM CRUD TO APPLICATION FLOW & REST API
**Mata Kuliah:** Pemrograman Web (Semester 5)  
**Aplikasi:** AutoGloss Paint Hub  
**Topik:** Pertemuan 10 — Application Flow dengan Controller, REST API CRUD, Validasi & HTTP Status Codes  

---

## 📌 Ringkasan Materi Week 10

Pada pertemuan 10, pembelajaran beralih dari sekadar operasi basis data (Migration &rarr; Model &rarr; Eloquent &rarr; CRUD pada Week 9) menuju **Arsitektur Alur Aplikasi Lengkap (Application Flow)** menggunakan **Controller** sebagai pusat orkestrasi:

```
[1. USER] Mengakses Aplikasi
    │
[2. ROUTE] Mengarahkan HTTP Request ke Controller
    │
[3. CONTROLLER] Memproses Request, Validasi Data, & Mengatur Logika Bisnis
    │
[4. MODEL] Representasi Objek & Relasi Data (Active Record)
    │
[5. DATABASE] Persistensi & Pengambilan Data (MySQL / SQLite)
    │
[6. VIEW / JSON] Menampilkan Data (Blade HTML atau REST API JSON)
    │
[7. USER] Melihat Hasil di Antarmuka Web / Aplikasi Client
```

---

## ✅ Matriks Pemenuhan 6 Kategori Completion Checklist (Slide 2)

### 01. Controller
- [x] **Controller dibuat:** Dibuat [`ProductApiController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/Api/ProductApiController.php) dan [`ProductController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/ProductController.php).
- [x] **CRUD dipindahkan ke Controller:** Seluruh logika rute dipindahkan dari Closure rute ke dalam method controller (`index`, `store`, `show`, `update`, `destroy`).
- [x] **Controller dapat menerima Request:** Method `store(Request $request)` dan `update(Request $request, $id)` menerima objek request untuk diproses.

### 02. Routing
- [x] **GET:** `GET /api/products` (daftar produk) dan `GET /api/products/{id}` (detail produk).
- [x] **POST:** `POST /api/products` (membuat produk baru).
- [x] **PUT/PATCH:** `PUT /api/products/{id}` dan `PATCH /api/products/{id}` (memperbarui data produk).
- [x] **DELETE:** `DELETE /api/products/{id}` (menghapus produk dari database).

### 03. Validation
- [x] **Required:** Aturan `'name' => 'required'`, `'code' => 'required'`, `'category_id' => 'required'`, `'price' => 'required'`.
- [x] **Max length:** Batasan panjang string `'name' => 'max:255'`, `'code' => 'max:50'`, `'unit' => 'max:50'`.
- [x] **Validation error:** Jika input tidak valid, controller mengembalikan HTTP **422 Unprocessable Content** berisi rincian pesan kesalahan validasi per field dalam format JSON.
- [x] **Data valid dapat disimpan:** Input yang lolos validasi otomatis dipersistensikan ke database via Eloquent `Product::create($validated)`.

### 04. REST API
- [x] **GET API:** Mengembalikan daftar koleksi produk dalam format JSON.
- [x] **POST API:** Menyimpan produk baru dan mengembalikan objek yang baru dibuat.
- [x] **GET detail:** Mengambil data tunggal produk berdasarkan ID.
- [x] **UPDATE API:** Memperbarui record produk tertentu.
- [x] **DELETE API:** Menghapus record produk dan mengembalikan konfirmasi sukses.
- [x] **JSON response:** Semua respons diformat terstruktur dengan field `status`, `statusCode`, `message`, dan `data`.

### 05. HTTP Status Codes
- [x] **Status code digunakan dengan tepat:**
  - `200 OK`: Sukses mengambil list, detail, update, dan delete.
  - `201 Created`: Sukses membuat resource produk baru via POST.
  - `404 Not Found`: Jika ID produk tidak ditemukan di database.
  - `422 Unprocessable Content`: Jika data input gagal dalam uji validasi.
- [x] **Endpoint diuji:** Diuji menggunakan skrip CLI dan web console.
- [x] **API testing berhasil:** Seluruh skenario pengujian 7/7 lulus (100% PASS).

### 06. Git
- [x] **Commit:** Seluruh perubahan dikomit dengan pesan komit yang deskriptif.
- [x] **Push:** Repositori remote GitHub terkonfigurasi pada `https://github.com/Gatzee08/AutoGloss-.git`.
- [x] **Repository ter-update:** Status git rapi dan tercatat dalam riwayat commit.

---

## 🚀 Cara Menjalankan & Menguji Week 10

### Opsi 1: Interactive Browser Testing (Disarankan)
1. Klik ganda file [`jalankan-server.bat`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/jalankan-server.bat).
2. Buka browser pada: **`http://127.0.0.1:8000/week10`** (atau klik menu **"Week 10 REST"** di navbar).
3. Anda dapat menguji tiap endpoint secara visual, melihat respons JSON real-time, dan memverifikasi checklist 20/20.

### Opsi 2: Pengujian Cepat via Terminal (Skrip Batch)
- Cukup klik ganda file [`test-week10.bat`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/test-week10.bat) di folder utama proyek.

### Opsi 3: Menggunakan Postman / Insomnia
- Import file [`AutoGloss_Week10_REST_API.postman_collection.json`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/AutoGloss_Week10_REST_API.postman_collection.json) ke aplikasi Postman/Insomnia.
- Jalankan ke-7 request yang telah disiapkan.
