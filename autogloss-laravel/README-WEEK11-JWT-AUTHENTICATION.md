# DOKUMENTASI MATERI WEEK 11: JWT AUTHENTICATION
**Mata Kuliah:** Pemrograman Web (Semester 5)  
**Aplikasi:** AutoGloss Paint Hub  
**Topik:** Task 03 - Test JWT Authentication (Postman & Insomnia) & Completion Checklist  

---

## 📌 Ringkasan Implementasi Tugas Week 11

Pada materi Week 11, aplikasi **AutoGloss Paint Hub** di-upgrade dengan sistem keamanan **JSON Web Token (JWT) Authentication** berbasis algoritma **HS256 (HMAC SHA-256)** untuk mengamankan REST API.

Implementasi ini mencakup alur lengkap **Task 03 (5 Langkah Pengujian)** dan memenuhi seluruh **16 item Completion Checklist**:

```
[01. POST /api/login] ──> [02. Simpan Bearer Token] ──> [03. GET /api/programs (200 OK)]
                                                            │
    [05. Invalid Token -> 401 Token invalid] <──────────────┴──> [04. Remove Token -> 401 Unauthorized]
```

---

## 🛠️ Rincian 5 Langkah Task 03 (Slide 1)

### 01. Login & Generate Token
- **Endpoint:** `POST /api/login`
- **Headers:** `Content-Type: application/json`, `Accept: application/json`
- **Request Body (JSON):**
  ```json
  {
    "email": "user@example.com",
    "password": "password"
  }
  ```
- **Response HTTP 200 OK:**
  ```json
  {
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "token_type": "bearer",
    "user": {
      "id": 1,
      "name": "Demo User (Week 11)",
      "email": "user@example.com"
    }
  }
  ```

---

### 02. Copy Token & Atur Authorization
- Nilai `access_token` yang diperoleh disalin.
- Pada Postman atau Insomnia, pilih tab **Auth / Authorization** &rarr; tipe **Bearer Token** &rarr; masukkan nilai token.

---

### 03. Akses Protected API dengan Valid Token
- **Endpoint:** `GET /api/programs`
- **Headers:** `Authorization: Bearer <access_token>`, `Accept: application/json`
- **Response HTTP 200 OK:**
  ```json
  {
    "data": [
      {
        "id": 1,
        "name": "Program A",
        "description": "Program Pelatihan AutoGloss Ceramic Coating Specialist"
      },
      {
        "id": 2,
        "name": "Program B",
        "description": "Program Sertifikasi Paint Protection Film (PPF) AutoGloss"
      },
      {
        "id": 3,
        "name": "Program C",
        "description": "Program Kemitraan Bengkel Body Repair & Oven Painting"
      }
    ]
  }
  ```

---

### 04. Remove Token (Request Tanpa Token)
- **Endpoint:** `GET /api/programs`
- **Headers:** Tanpa header `Authorization`
- **Response HTTP 401 Unauthorized:**
  ```json
  {
    "message": "Unauthorized"
  }
  ```

---

### 05. Invalid Token (Request dengan Token Palsu / Rusak)
- **Endpoint:** `GET /api/programs`
- **Headers:** `Authorization: Bearer invalidtoken`
- **Response HTTP 401 Unauthorized:**
  ```json
  {
    "message": "Token invalid"
  }
  ```

---

## ✅ Matriks Completion Checklist (Slide 2)

| Kategori | Item Checklist | Status | Bukti Implementasi / Kode |
|---|---|:---:|---|
| **1. Authentication** | Login API dibuat | ✅ | Route `POST /api/login` pada [`routes/api.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/routes/api.php) |
| | Credential diverifikasi | ✅ | `Hash::check($password, $user->password)` di [`AuthController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/Api/AuthController.php) |
| | JWT berhasil dibuat | ✅ | Metode `JwtService::generateToken()` dengan HS256 di [`JwtService.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Services/JwtService.php) |
| | JWT dikembalikan | ✅ | JSON response berisi field `access_token` dan `token_type: bearer` |
| **2. JWT** | Token dapat digunakan | ✅ | Format standar 3 segmen (`header.payload.signature`) dengan klaim `sub`, `exp`, `iat` |
| | Bearer token digunakan | ✅ | Header request `Authorization: Bearer <token>` |
| | Token dikirim pada request | ✅ | Dibaca otomatis melalui `$request->bearerToken()` |
| **3. Middleware** | Protected route | ✅ | Route group `middleware('jwt.auth')` melindungi `/api/programs`, `/api/user`, `/api/orders` |
| | JWT middleware | ✅ | Kelas [`JwtMiddleware.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Middleware/JwtMiddleware.php) terdaftar di `bootstrap/app.php` |
| | Token valid diterima | ✅ | Request lolos ke controller dan mengembalikan status **200 OK** |
| | Token invalid ditolak | ✅ | Signature salah / token rusak ditolak dengan status **401 Token invalid** |
| | Request tanpa token ditolak | ✅ | Request tanpa header ditolak dengan status **401 Unauthorized** |
| **4. API Testing** | Login berhasil | ✅ | Berhasil diautentikasi dengan email `user@example.com` |
| | Protected API berhasil | ✅ | `GET /api/programs` mengembalikan list program |
| | No token diuji | ✅ | Menghasilkan respons HTTP 401 |
| | Invalid token diuji | ✅ | Menghasilkan respons HTTP 401 |
| | Response diperiksa | ✅ | Struktur respons dicek menggunakan script otomatis & browser simulator |

---

## 🚀 4 Cara Menjalankan & Menguji Aplikasi

### Cara 1: Menggunakan Browser Testing Playground (Paling Praktis)
1. Jalankan server dengan klik ganda [`jalankan-server.bat`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/jalankan-server.bat).
2. Buka browser pada alamat: **`http://127.0.0.1:8000/jwt-testing`** (atau klik menu **"JWT Testing"** di navbar).
3. Anda dapat menguji tiap langkah (Step 01 hingga 05) satu per satu atau klik tombol **"Jalankan Semua Tes Sekaligus"**.
4. Seluruh checklist 16 item akan tercentang otomatis berwarna hijau saat pengujian berjalan.

### Cara 2: Menggunakan File Postman / Insomnia Collection
1. Buka aplikasi **Postman** atau **Insomnia**.
2. Klik tombol **Import** &rarr; pilih file:
   [`AutoGloss_Week11_JWT.postman_collection.json`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/AutoGloss_Week11_JWT.postman_collection.json).
3. Jalankan request secara berurutan:
   - `01. Login (Generate JWT Token)` &rarr; Token tersimpan otomatis di variabel koleksi.
   - `03. Get Programs (Valid Bearer Token - 200 OK)`
   - `04. Get Programs (Remove Token - 401 Unauthorized)`
   - `05. Get Programs (Invalid Token - 401 Token Invalid)`

### Cara 3: Menggunakan File Script Batch Otomatis
- Cukup klik ganda file [`test-jwt.bat`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/test-jwt.bat) pada folder utama proyek. Skrip akan mengeksekusi ke-5 uji kasus secara langsung dan menampilkan hasil `PASS` di terminal Windows.

### Cara 4: Menggunakan Perintah cURL di Terminal
```bash
# 1. Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "{\"email\":\"user@example.com\",\"password\":\"password\"}"

# 2. Akses dengan Token Valid (ganti <TOKEN> dengan hasil dari step 1)
curl -X GET http://127.0.0.1:8000/api/programs \
  -H "Authorization: Bearer <TOKEN>" \
  -H "Accept: application/json"

# 3. Akses Tanpa Token (Menghasilkan 401 Unauthorized)
curl -X GET http://127.0.0.1:8000/api/programs \
  -H "Accept: application/json"

# 4. Akses dengan Token Invalid (Menghasilkan 401 Token invalid)
curl -X GET http://127.0.0.1:8000/api/programs \
  -H "Authorization: Bearer invalidtoken" \
  -H "Accept: application/json"
```
