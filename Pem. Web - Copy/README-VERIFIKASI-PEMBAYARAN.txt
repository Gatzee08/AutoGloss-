AUTO GLOSS PAINT HUB — VERIFIKASI PEMBAYARAN ADMIN

Perubahan:
1. Pesanan baru selalu berstatus pembayaran "Belum Lunas".
2. Hanya aksi Admin "Konfirmasi Masuk" / "Tandai Lunas" yang mengubah pembayaran menjadi "Lunas".
3. Halaman pelanggan menampilkan badge besar LUNAS atau BELUM LUNAS.
4. Bukti pembayaran tidak otomatis membuat pesanan Lunas; bukti hanya menjadi bahan pemeriksaan Admin.
5. Pembayaran yang ditolak tetap BELUM LUNAS dan pelanggan dapat mengunggah bukti baru.
6. Dashboard dan tabel Admin memprioritaskan pesanan yang belum terkonfirmasi.
7. Status pembayaran dan status pesanan dipisahkan.
8. Jika halaman pelanggan dan admin dibuka pada tab berbeda di browser/device yang sama, perubahan localStorage akan menyegarkan status pelanggan otomatis.

CATATAN PENTING:
Versi proyek ini masih menggunakan localStorage karena proyek asal berupa website HTML/CSS/JavaScript tanpa backend/database.
Artinya data pesanan dan konfirmasi Admin hanya tersimpan pada browser/device yang sama.
Untuk penggunaan produksi dengan pelanggan dan Admin pada perangkat berbeda, localStorage perlu diganti dengan backend/database (mis. PHP+MySQL, Node/Express+PostgreSQL/MySQL, atau Firebase/Supabase).
