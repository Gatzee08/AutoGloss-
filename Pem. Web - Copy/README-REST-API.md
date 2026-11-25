# DOKUMENTASI IMPLEMENTASI REST API & FETCH API (SINGLE PAGE APPLICATION)
**Mata Kuliah:** Pemrograman Web (Semester 5)  
**Aplikasi:** AutoGloss Paint Hub (Single Page Application)  

---

## 📌 Ringkasan Implementasi Tugas

Aplikasi **AutoGloss Paint Hub** telah diimplementasikan dengan arsitektur **Single Page Application (SPA)** yang mengonsumsi data katalog produk melalui **REST API** menggunakan **Fetch API** native JavaScript, dilengkapi penanganan status asinkron lengkap (*Loading*, *Success*, dan *Error* dengan tombol *Coba Lagi*).

---

## 🛠️ Rincian Tugas (Tasks)

### 1. Task 01: Connect to API (Fetch API & Parsing JSON)
- **Fungsi Utama:** [`StoreApp.fetchProducts(customUrl)`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/Pem.%20Web%20-%20Copy/js/store.js) dan [`DataService.fetchProductsFromApi(url, options)`](file:///d:/KULIAH/SMESTER5/PEMROGRAMAN%20WEB/AutoGloss-/Pem.%20Web%20-%20Copy/js/data.js)
- **Endpoint Default:** `data/products.json`
- **Mekanisme Kerja:**
  1. Melakukan request HTTP secara asinkron menggunakan fungsi native `fetch(url, { method: 'GET', headers: { 'Accept': 'application/json' } })`.
  2. Memeriksa validitas status HTTP (`response.ok`). Jika status tidak berada dalam rentang 200–299 (misal HTTP 404 atau 500), dilemparkan `Error` secara terstruktur.
  3. Mem-parsing data body respons JSON secara asinkron menggunakan `await response.json()`.
  4. Mendukung format respons bersarang (`{ status: "success", data: [...] }`) maupun raw array `[...]`.
  5. Seluruh alur dibungkus dalam blok `try...catch` untuk menangani kegagalan jaringan (*Network Failure*, *CORS*, atau *Offline*).

```javascript
// Contoh Cuplikan Kode Task 01 (js/store.js)
async fetchProducts(customUrl = null) {
    const endpoint = customUrl || this.apiState.endpoint;
    this.apiState.status = 'loading';
    this.renderApiState(); // Tampilkan Loading Spinner

    try {
        const response = await fetch(endpoint, {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        });

        if (!response.ok) {
            throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
        }

        const parsedData = await response.json();
        const items = Array.isArray(parsedData) ? parsedData : (parsedData.data || []);
        
        this.products = items;
        this.apiState.status = 'success';
        this.renderApiState();
        this.renderProducts(); // Task 02: Render DOM
        return items;
    } catch (error) {
        this.apiState.status = 'error';
        this.apiState.error = error.message;
        this.renderApiState(); // Tampilkan Error UI & Tombol Coba Lagi
    }
}
```

---

### 2. Task 02: Display API Data (DOM Manipulation Dinamis ke Antarmuka)
- **Fungsi Utama:**
  - `StoreApp.renderProducts()`: Merender kartu produk ke dalam `#productsGrid` secara dinamis menggunakan template literals dan manipulasi DOM.
  - `StoreApp.renderFlashSale()`: Merender produk diskon ke `#flashSaleGrid`.
  - `StoreApp.renderCategoryTiles()`: Menghitung jumlah produk per kategori secara dinamis langsung dari data API.
  - `StoreApp.openProductModal(id)`: Menampilkan pop-up modal detail spesifikasi produk.
  - **Live Filter & Search:** Pencarian teks dan filter kategori bekerja secara reaktif di atas data hasil *fetch*.

---

### 3. Handle API State (Visual Feedback & Interaktivitas)

| State | Komponen Tampilan | Deskripsi Visual & Perilaku |
|---|---|---|
| ⏳ **Loading State** | `#productsLoadingState` & `#apiStatusBadge.loading` | Menampilkan **Loading Spinner** animasi rotasi warna crimson/cyan, ikon spray cat berdenyut (*pulse*), dan **4 Skeleton Cards** dengan efek gradasi kilau (*shimmer animation*). |
| ✅ **Success State** | `#productsGrid` & `#apiStatusBadge.success` | Menampilkan katalog produk secara dinamis, menyembunyikan loader, serta memperbarui badge status menjadi `● 200 OK (Terhubung)` dan total produk (`18 Produk`). |
| ❌ **Error State** | `#productsErrorState` & `#apiStatusBadge.error` | Menampilkan kotak peringatan bergaris merah bercahaya (*glow red*), ikon peringatan segitiga, pesan galat (*error message*), dan tombol **"Coba Lagi"**. |
| 🔄 **Tombol Coba Lagi** | `#btnRetryFetch` | Memanggil fungsi `StoreApp.retryFetch()`. Saat diklik, aplikasi kembali ke *Loading State* lalu memanggil ulang `fetchProducts()` tanpa me-refresh seluruh halaman browser. |

---

## 🎮 Toolbar Pengujian Interaktif (Khusus Dosen / Asisten Lab)

Di bagian atas katalog produk (*section* `#produk`), disediakan **REST API Control Bar**:
1. **Tombol "Refresh"**: Memuat ulang data dari API secara instan.
2. **Tombol "Tes Loading"**: Menambahkan jeda simulasi 1.8 detik agar dosen/penguji dapat melihat animasi *Loading Spinner* dan *Skeleton Loader*.
3. **Tombol "Tes Error"**: Memicu simulasi endpoint galat (HTTP 404) agar dosen/penguji dapat menguji *Error State* dan memverifikasi fungsi tombol **"Coba Lagi"**.
4. **Tombol "URL API"**: Membuka dialog untuk mengganti endpoint dengan REST API eksternal (mis. MockAPI atau JSON Server).

---

## 📁 Struktur File Terkait

```text
Pem. Web - Copy/
├── data/
│   └── products.json          # Endpoint data REST API lokal (18 produk cat & perlengkapan)
├── js/
│   ├── data.js                # DataService.fetchProductsFromApi()
│   ├── store.js               # StoreApp.fetchProducts(), retryFetch(), renderApiState()
│   └── admin.js               # AdminApp.syncWithRestApi()
├── css/
│   ├── style.css              # Styling spinner, shimmer skeleton, error box, retry button
│   └── admin.css              # Styling tombol sinkronisasi admin
├── index.html                 # Antarmuka SPA & container API state
└── README-REST-API.md         # Dokumentasi resmi tugas
```

---

## 🚀 Cara Menjalankan Aplikasi

1. Buka folder `Pem. Web - Copy` di VS Code.
2. Klik kanan file `index.html` lalu pilih **Open with Live Server** (atau jalankan `http-server` pada terminal).
3. Buka peramban di `http://127.0.0.1:5500/index.html`.
4. Gulir ke bagian katalog **Produk** untuk melihat status koneksi API, kartu produk, dan mencoba tombol pengujian state.
