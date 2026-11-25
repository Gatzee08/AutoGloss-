# AUTO GLOSS PAINT HUB

Proyek Aplikasi Penjualan Cat Mobil & Body Coating - Mata Kuliah Pemrograman Web (Semester 5).

---

## 📂 Struktur Proyek

1. **`autogloss-laravel/` (Materi Week 9: Laravel CRUD + Eloquent ORM)**
   - Backend & Frontend terintegrasi menggunakan **Laravel Framework**.
   - Migrasi database 5 tabel (`categories`, `products`, `customers`, `orders`, `order_items`).
   - Model Eloquent ORM dengan relasi One-to-Many (`hasMany`, `belongsTo`), agregasi, dan eager loading (`with()`, `withCount()`).
   - Resource Controller dengan method `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.
   - Blade templating responsif bertema dark otomotif + Tailwind CSS + FontAwesome 6.
   - Resource routing & verifikasi status pembayaran admin.
   - Dokumentasi lengkap materi Week 9: [README-WEEK9-CRUD-ORM.md](autogloss-laravel/README-WEEK9-CRUD-ORM.md).

2. **`Pem. Web - Copy/` (Materi Sebelumnya: Frontend SPA & REST API Fetch)**
   - Versi prototipe statis HTML/CSS/JavaScript.
   - Menggunakan Fetch API ke `data/products.json` dan penyimpanan client-side `localStorage`.

---

## ⚡ Cara Cepat Menjalankan Laravel (Week 9)

1. **Menjalankan Server:**
   - Cukup klik ganda file **`jalankan-server.bat`**, lalu buka browser di `http://127.0.0.1:8000`.
2. **Migrasi Database:**
   - Cukup klik ganda file **`migrate-database.bat`** (pastikan MySQL di XAMPP Control Panel aktif jika menggunakan MySQL).
