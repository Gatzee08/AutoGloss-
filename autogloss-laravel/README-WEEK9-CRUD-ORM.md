# DOKUMENTASI MATERI WEEK 9: LARAVEL CRUD + ELOQUENT ORM
**Mata Kuliah:** Pemrograman Web (Semester 5)  
**Aplikasi:** AutoGloss Paint Hub (Toko Cat Mobil & Perlengkapan Coating)  
**Teknologi:** Laravel Framework 11 / 12, PHP 8.3 (XAMPP), MySQL / SQLite, Eloquent ORM, Blade Templating, Tailwind CSS, FontAwesome 6  

---

## 📌 Ringkasan Implementasi Tugas Week 9

Pada materi Week 9, website **AutoGloss Paint Hub** yang sebelumnya berupa SPA berbasis JavaScript & REST API lokal dikembangkan menjadi aplikasi berbasis **Laravel Framework** dengan penerapan konsep **CRUD (Create, Read, Update, Delete)** dan **Eloquent ORM (Object-Relational Mapping)** secara menyeluruh.

---

## 🛠️ Rincian 7 Langkah Pengerjaan

### 1. Instalasi Laravel
- Framework Laravel berhasil diinisialisasi menggunakan Composer:
  ```bash
  composer create-project laravel/laravel autogloss-laravel --prefer-dist
  ```
- Dependency pendukung dan Application Key (`APP_KEY`) telah terkonfigurasi.

### 2. Setting Database (.env)
File konfigurasi [`.env`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/.env) disesuaikan untuk menghubungkan Laravel ke MySQL (XAMPP):
```env
APP_NAME="AutoGloss Paint Hub"
APP_ENV=local
APP_KEY=base64:U3WA46Ti4U5+VbBZpTXhAA0lWLL3VyjvIFg9Oo0KWWA=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=autogloss_db
DB_USERNAME=root
DB_PASSWORD=
```
*(Catatan: SQLite lokal pada `database/database.sqlite` juga telah disiapkan dan di-seed jika ingin menguji instan tanpa menjalankan service MySQL).*

---

### 3. Buat Table di Database (Migrations)
Dibuat 5 file migrasi terstruktur sesuai domain bisnis AutoGloss:

| Nama Tabel | File Migrasi | Deskripsi Field & Relasi |
|---|---|---|
| `categories` | [`2026_11_09_123000_create_categories_table.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/database/migrations/2026_11_09_123000_create_categories_table.php) | `id`, `name`, `slug` (unique), `description`, `icon`, `timestamps` |
| `products` | [`2026_11_09_123008_create_products_table.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/database/migrations/2026_11_09_123008_create_products_table.php) | `id`, `category_id` (foreign key on delete cascade), `code` (unique), `name`, `sub_category`, `price`, `original_price`, `is_promo`, `discount_percent`, `stock`, `unit`, `rating`, `sold_count`, `image`, `badge`, `description`, `features` (json), `timestamps` |
| `customers` | [`2026_11_09_123009_create_customers_table.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/database/migrations/2026_11_09_123009_create_customers_table.php) | `id`, `customer_code` (unique), `name`, `phone`, `email`, `address`, `city`, `total_orders`, `total_spent`, `timestamps` |
| `orders` | [`2026_11_09_123010_create_orders_table.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/database/migrations/2026_11_09_123010_create_orders_table.php) | `id`, `order_code` (unique), `customer_id` (foreign key nullable), `customer_name`, `customer_phone`, `customer_email`, `fulfillment_type`, `pickup_location`, `pickup_date_time`, `delivery_address`, `delivery_courier`, `shipping_fee`, `subtotal`, `discount`, `grand_total`, `payment_method`, `payment_status` (Belum Lunas/Lunas), `order_status`, `payment_proof`, `notes`, `timestamps` |
| `order_items` | [`2026_11_09_123011_create_order_items_table.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/database/migrations/2026_11_09_123011_create_order_items_table.php) | `id`, `order_id` (foreign key cascade), `product_id` (foreign key nullable), `product_name`, `price`, `quantity`, `total`, `timestamps` |

---

### 4. Buat Model untuk Masing-masing Table (Eloquent ORM)
Dibuat 5 model Eloquent dengan konfigurasi `$table`, `$fillable`, `$casts`, dan metode relasi ORM:

1. **[`Category.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Models/Category.php)**:
   - Relasi: `hasMany(Product::class)` (Satu kategori memiliki banyak produk).
2. **[`Product.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Models/Product.php)**:
   - Relasi: `belongsTo(Category::class)` (Produk terhubung ke satu kategori).
   - Relasi: `hasMany(OrderItem::class)` (Produk dapat muncul di banyak item order).
3. **[`Customer.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Models/Customer.php)**:
   - Relasi: `hasMany(Order::class)` (Satu pelanggan memiliki banyak riwayat transaksi).
4. **[`Order.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Models/Order.php)**:
   - Relasi: `belongsTo(Customer::class)` (Pesanan milik satu pelanggan).
   - Relasi: `hasMany(OrderItem::class)` (Pesanan memiliki banyak rincian item pesanan).
5. **[`OrderItem.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Models/OrderItem.php)**:
   - Relasi: `belongsTo(Order::class)` dan `belongsTo(Product::class)`.

---

### 5. Buat Controller (Method Index & CRUD)
Dibuat Controller yang mengimplementasikan **Method `index`** dengan pemanfaatan Eloquent ORM:

- **[`DashboardController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/DashboardController.php)**:
  - `index()`: Menggunakan Eloquent aggregations `Product::count()`, `Order::count()`, `Order::where(...)->count()`, `Order::sum('grand_total')`, serta eager loading `Order::with('customer', 'items')`.
- **[`ProductController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/ProductController.php)**:
  - `index()`: Eager loading `Product::with('category')`, filter pencarian teks, filter kategori, toggle promo, dan paginasi `paginate(8)`.
  - Dilengkapi method CRUD: `create()`, `store()`, `show()`, `edit()`, `update()`, `destroy()`.
- **[`CategoryController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/CategoryController.php)**:
  - `index()`: Menghitung jumlah produk relasi secara efisien dengan `Category::withCount('products')`.
- **[`CustomerController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/CustomerController.php)**:
  - `index()`: Mengambil daftar pelanggan beserta `withCount('orders')`.
- **[`OrderController.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/app/Http/Controllers/OrderController.php)**:
  - `index()`: Menampilkan daftar order, filter status pembayaran (Belum Lunas / Lunas), dan fitur verifikasi status kasir.

---

### 6. Buat Views (Index & Blade Layout)
Dibuat antarmuka berbasis Blade Templating dengan desain modern bertema otomotif:

- **Layout Master:** [`resources/views/layouts/app.blade.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/resources/views/layouts/app.blade.php) (Navbar sticky, indikator route aktif, alert flash notifikasi sukses/error, footer).
- **View Dashboard:** [`resources/views/dashboard.blade.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/resources/views/dashboard.blade.php) (Statistik toko, pesanan terbaru, peringatan stok kritis).
- **View Produk Index:** [`resources/views/products/index.blade.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/resources/views/products/index.blade.php) (Grid kartu produk, badge promo, harga diskon, info relasi kategori, tombol aksi CRUD).
- **View Kategori Index:** [`resources/views/categories/index.blade.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/resources/views/categories/index.blade.php) (Daftar kategori beserta jumlah produk relasi).
- **View Pelanggan Index:** [`resources/views/customers/index.blade.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/resources/views/customers/index.blade.php) (Tabel pelanggan, nomor kontak, total pesanan).
- **View Pesanan Index:** [`resources/views/orders/index.blade.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/resources/views/orders/index.blade.php) (Manajemen transaksi, badge status Lunas/Belum Lunas, aksi cepat konfirmasi admin).
- **Form Views:** `products/create.blade.php`, `products/edit.blade.php`, `products/show.blade.php`, `categories/create.blade.php`, `categories/edit.blade.php`, `customers/create.blade.php`, `customers/edit.blade.php`, `orders/show.blade.php`.

---

### 7. Buat Route (Index & Resource Routing)
Didaftarkan pada file [`routes/web.php`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/autogloss-laravel/routes/web.php):

```php
// Dashboard Utama (Method Index)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Resource Routes CRUD (termasuk method index)
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('customers', CustomerController::class);
Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

// REST API Endpoint kompatibel SPA
Route::get('/api/products', function () {
    $products = \App\Models\Product::with('category')->get();
    return response()->json([
        'status' => 'success',
        'data' => $products
    ]);
});
```

---

## 🚀 Cara Menjalankan Aplikasi

Tersedia dua file script praktis yang dapat langsung diklik dua kali (*double click*):

1. **Menjalankan Server Web:**
   - Cukup klik ganda file [`jalankan-server.bat`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/jalankan-server.bat) pada folder utama proyek, atau jalankan via terminal:
     ```powershell
     cd autogloss-laravel
     "D:\xampapp\php\php.exe" artisan serve
     ```
   - Buka browser pada alamat: **`http://127.0.0.1:8000`**

2. **Migrasi Ulang & Seeding Data Awal:**
   - Klik ganda file [`migrate-database.bat`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/migrate-database.bat), atau jalankan via terminal:
     ```powershell
     cd autogloss-laravel
     "D:\xampapp\php\php.exe" artisan migrate:fresh --seed
     ```

