<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with AutoGloss Paint Hub data.
     */
    public function run(): void
    {
        // 1. KATEGORI PRODUK
        $categoriesData = [
            [
                'name' => 'Cat Mobil',
                'slug' => 'cat-mobil',
                'description' => 'Cat polyurethane (PU), clear coat wet-look, dan epoxy primer surfacer tahan karat untuk bodi mobil & motor.',
                'icon' => 'fa-car-side',
            ],
            [
                'name' => 'Cat Tembok',
                'slug' => 'cat-tembok',
                'description' => 'Cat interior dan eksterior anti noda, tahan cuaca tropis, dan ramah lingkungan.',
                'icon' => 'fa-paint-roller',
            ],
            [
                'name' => 'Cat Kayu',
                'slug' => 'cat-kayu',
                'description' => 'Wood stain, politur, dan melamic clear gloss untuk furniture dan kusen.',
                'icon' => 'fa-tree',
            ],
            [
                'name' => 'Cat Besi',
                'slug' => 'cat-besi',
                'description' => 'Cat besi anti karat 2-in-1, cat minyak sintetis kilap tinggi untuk pagar & kanopi.',
                'icon' => 'fa-shield-halved',
            ],
            [
                'name' => 'Aksesoris & Alat',
                'slug' => 'aksesoris',
                'description' => 'Spray gun HVLP, thinner PU slow dry, masking tape, dan kompon poles.',
                'icon' => 'fa-spray-can',
            ],
        ];

        $categoriesMap = [];
        foreach ($categoriesData as $cat) {
            $created = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
            $categoriesMap[$cat['name']] = $created->id;
        }

        // 2. PRODUK
        $productsData = [
            // Cat Mobil
            [
                'code' => 'PRD-001',
                'category_name' => 'Cat Mobil',
                'name' => 'SuperGloss Candy Red Metallic (Cat Mobil PU)',
                'sub_category' => 'Body Paint',
                'price' => 185000,
                'original_price' => 220000,
                'is_promo' => true,
                'discount_percent' => 16,
                'stock' => 35,
                'unit' => '1 Liter',
                'rating' => 4.9,
                'sold_count' => 142,
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=600&q=80',
                'badge' => 'FLASH SALE',
                'description' => 'Cat mobil polyurethane premium dengan partikel pearl metallic murni. Memberikan efek candy red mendalam dan tahan paparan sinar UV hingga 5 tahun.',
                'features' => ['Efek Candy Deep Gloss', 'Formula Anti-Kuning (UV Resistant)', 'Cepat Kering & Daya Tutup Tinggi'],
            ],
            [
                'code' => 'PRD-002',
                'category_name' => 'Cat Mobil',
                'name' => 'AutoPro 2K Clear Coat High Solid + Hardener',
                'sub_category' => 'Clear Coat',
                'price' => 145000,
                'original_price' => 175000,
                'is_promo' => true,
                'discount_percent' => 17,
                'stock' => 28,
                'unit' => '1 Liter Set',
                'rating' => 4.9,
                'sold_count' => 230,
                'image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&w=600&q=80',
                'badge' => 'BEST SELLER',
                'description' => 'Pernis pelindung cat mobil kualitas High Solid 2 komponen. Menghasilkan lapisan kaca wet-look tahan gores, tahan bensin, dan kilau abadi.',
                'features' => ['Kilau Ekstrem Wet Look', 'Anti Gores & Tahan Bensin', 'Termasuk Hardener 250ml'],
            ],
            [
                'code' => 'PRD-003',
                'category_name' => 'Cat Mobil',
                'name' => 'Epoxy Primer Surfacer 2K Grey (Anti Karat)',
                'sub_category' => 'Primer Epoxy',
                'price' => 110000,
                'original_price' => 125000,
                'is_promo' => false,
                'discount_percent' => 0,
                'stock' => 40,
                'unit' => '1 Kg Set',
                'rating' => 4.8,
                'sold_count' => 185,
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=600&q=80',
                'badge' => 'STANDARD',
                'description' => 'Dasaran cat mobil anti karat dengan daya rekat sangat kuat pada plat besi, plat galvanis, dan bodi aluminium kendaraan.',
                'features' => ['Daya Rekat Tinggi ke Plat Besi', 'Mudah Diamplas (Sanding)', 'Mencegah Karat Menjalar'],
            ],
            [
                'code' => 'PRD-004',
                'category_name' => 'Cat Mobil',
                'name' => 'Midnight Black Pearl Polyurethane',
                'sub_category' => 'Body Paint',
                'price' => 165000,
                'original_price' => 195000,
                'is_promo' => true,
                'discount_percent' => 15,
                'stock' => 22,
                'unit' => '1 Liter',
                'rating' => 4.9,
                'sold_count' => 98,
                'image' => 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PROMO',
                'description' => 'Cat mobil hitam pekat dengan glitter mutiara biru & silver elegan. Sangat cocok untuk repaint mobil sedan, SUV, dan velg.',
                'features' => ['Warna Hitam Pekat Elegan', 'Butiran Mutiara Halus', 'Formula Oplos Pabrikan'],
            ],
            // Cat Tembok
            [
                'code' => 'PRD-005',
                'category_name' => 'Cat Tembok',
                'name' => 'Nippon Paint Weatherbond Brilliant White 2.5L',
                'sub_category' => 'Eksterior',
                'price' => 240000,
                'original_price' => 280000,
                'is_promo' => true,
                'discount_percent' => 14,
                'stock' => 20,
                'unit' => '2.5 Liter Kaleng',
                'rating' => 4.8,
                'sold_count' => 95,
                'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=600&q=80',
                'badge' => 'BEST SELLER',
                'description' => 'Cat eksterior premium dengan teknologi formulasi Quartz tahan lumut, anti jamur, dan tidak memudar hingga 8 tahun.',
                'features' => ['Anti Lumut & Jamur 8 Tahun', 'Tahan Panas Matahari Ekstrem', 'Mudah Dicuci'],
            ],
            [
                'code' => 'PRD-006',
                'category_name' => 'Cat Tembok',
                'name' => 'Dulux EasyClean Interior Silk White 2.5L',
                'sub_category' => 'Interior',
                'price' => 175000,
                'original_price' => 175000,
                'is_promo' => false,
                'discount_percent' => 0,
                'stock' => 30,
                'unit' => '2.5 Liter Kaleng',
                'rating' => 4.7,
                'sold_count' => 110,
                'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=600&q=80',
                'badge' => 'STANDARD',
                'description' => 'Cat dinding interior bermutu tinggi dengan formula penolak noda cair. Warna awet dan tidak mudah pudar.',
                'features' => ['Anti Noda Cair', 'Rendah VOC (Ramah Lingkungan)', 'Daya Sebar Luas'],
            ],
            // Cat Kayu
            [
                'code' => 'PRD-009',
                'category_name' => 'Cat Kayu',
                'name' => 'Ultralite Wood Stain Teak Brown (Politur Kayu)',
                'sub_category' => 'Wood Coating',
                'price' => 85000,
                'original_price' => 95000,
                'is_promo' => true,
                'discount_percent' => 10,
                'stock' => 45,
                'unit' => '1 Liter',
                'rating' => 4.7,
                'sold_count' => 130,
                'image' => 'https://images.unsplash.com/photo-1546484475-7f7bd55792da?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PROMO',
                'description' => 'Pewarna kayu transparan yang menonjolkan serat kayu alami jati, mahoni, dan kamper dengan perlindungan anti rayap.',
                'features' => ['Menonjolkan Serat Kayu Alami', 'Anti Rayap & Jamur Kayu', 'Kilau Semi-Gloss Mewah'],
            ],
            // Cat Besi
            [
                'code' => 'PRD-011',
                'category_name' => 'Cat Besi',
                'name' => 'Seiv Cat Besi Anti Karat Wrought Iron Black',
                'sub_category' => 'Anti-Rust Paint',
                'price' => 92000,
                'original_price' => 110000,
                'is_promo' => true,
                'discount_percent' => 16,
                'stock' => 32,
                'unit' => '1 Liter',
                'rating' => 4.9,
                'sold_count' => 174,
                'image' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PROMO',
                'description' => 'Cat besi tempa dengan efek tekstur mewah sekaligus fungsi primer anti karat langsung tanpa perlu meni.',
                'features' => ['2 in 1: Primer & Cat Finishing', 'Tahan Hujan & Karat Ekstrem', 'Efek Besi Tempa Elegan'],
            ],
            // Aksesoris
            [
                'code' => 'PRD-015',
                'category_name' => 'Aksesoris & Alat',
                'name' => 'HVLP Spray Gun Professional Nozzle 1.4mm',
                'sub_category' => 'Alat Semprot Cat',
                'price' => 245000,
                'original_price' => 295000,
                'is_promo' => true,
                'discount_percent' => 17,
                'stock' => 14,
                'unit' => '1 Set Box',
                'rating' => 4.9,
                'sold_count' => 88,
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80',
                'badge' => 'PROMO',
                'description' => 'Spray gun HVLP presisi tinggi dengan tabung atas 600ml. Menghasilkan atomisasi cat mobil sangat halus tanpa belang.',
                'features' => ['Atomisasi Partikel Super Halus', 'Kapasitas Tabung 600ml', 'Hemat Cat hingga 30%'],
            ],
            [
                'code' => 'PRD-016',
                'category_name' => 'Aksesoris & Alat',
                'name' => 'Thinner Super High Gloss PU Slow Dry',
                'sub_category' => 'Thinner',
                'price' => 45000,
                'original_price' => 45000,
                'is_promo' => false,
                'discount_percent' => 0,
                'stock' => 55,
                'unit' => '1 Liter Kaleng',
                'rating' => 4.8,
                'sold_count' => 310,
                'image' => 'https://images.unsplash.com/photo-1616401784845-180882ba9ba8?auto=format&fit=crop&w=600&q=80',
                'badge' => 'STANDARD',
                'description' => 'Thinner kualitas PU Slow Dry untuk pengencer cat mobil dan pernis agar hasil semprotan tidak berkabut atau kulit jeruk.',
                'features' => ['Cegah Efek Kulit Jeruk', 'Tingkat Kilap Bertambah', 'Cocok untuk Clear Coat'],
            ],
        ];

        $productModels = [];
        foreach ($productsData as $prod) {
            $catId = $categoriesMap[$prod['category_name']] ?? 1;
            unset($prod['category_name']);
            $prod['category_id'] = $catId;
            $created = Product::firstOrCreate(['code' => $prod['code']], $prod);
            $productModels[$created->code] = $created;
        }

        // 3. DATA PELANGGAN
        $customersData = [
            [
                'customer_code' => 'CUST-001',
                'name' => 'Budi Santoso',
                'phone' => '081234567890',
                'email' => 'budi.s@gmail.com',
                'address' => 'Jl. Kebon Jeruk No. 12, Kebon Jeruk, Jakarta Barat',
                'city' => 'Jakarta Barat',
                'total_orders' => 3,
                'total_spent' => 1250000,
            ],
            [
                'customer_code' => 'CUST-002',
                'name' => 'Rian Pradana (Bengkel Body Repair Rian)',
                'phone' => '085712349988',
                'email' => 'rianrepair@gmail.com',
                'address' => 'Jl. Merdeka Barat No. 42, RT 03/05, Kebayoran Baru, Jakarta Selatan',
                'city' => 'Jakarta Selatan',
                'total_orders' => 5,
                'total_spent' => 3420000,
            ],
            [
                'customer_code' => 'CUST-003',
                'name' => 'Siti Rahmawati',
                'phone' => '082198765432',
                'email' => 'siti.rahma@yahoo.com',
                'address' => 'Ruko Sentra Niaga Blok B3, Tangerang',
                'city' => 'Tangerang',
                'total_orders' => 2,
                'total_spent' => 720000,
            ],
        ];

        $customerModels = [];
        foreach ($customersData as $cust) {
            $customerModels[$cust['customer_code']] = Customer::firstOrCreate(['customer_code' => $cust['customer_code']], $cust);
        }

        // 4. DATA PESANAN & DETAIL ORDER ITEM
        $ordersData = [
            [
                'order_code' => 'ORD-20260928-01',
                'customer_code' => 'CUST-001',
                'customer_name' => 'Budi Santoso',
                'customer_phone' => '081234567890',
                'customer_email' => 'budi.s@gmail.com',
                'fulfillment_type' => 'pickup',
                'pickup_location' => 'Outlet Pusat - Jl. Raya Otomotif No. 88 (Jakarta)',
                'pickup_date_time' => '2026-09-29 10:00 WIB',
                'delivery_address' => null,
                'delivery_courier' => null,
                'shipping_fee' => 0,
                'subtotal' => 515000,
                'discount' => 25000,
                'grand_total' => 490000,
                'payment_method' => 'Transfer Bank BCA',
                'payment_status' => 'Belum Lunas',
                'order_status' => 'Pending',
                'notes' => 'Akan diambil siang oleh adik saya membawa bukti nota',
                'items' => [
                    ['code' => 'PRD-001', 'qty' => 2, 'price' => 185000],
                    ['code' => 'PRD-002', 'qty' => 1, 'price' => 145000],
                ],
            ],
            [
                'order_code' => 'ORD-20260928-02',
                'customer_code' => 'CUST-002',
                'customer_name' => 'Rian Pradana (Bengkel Body Repair Rian)',
                'customer_phone' => '085712349988',
                'customer_email' => 'rianrepair@gmail.com',
                'fulfillment_type' => 'delivery',
                'pickup_location' => null,
                'pickup_date_time' => null,
                'delivery_address' => 'Jl. Merdeka Barat No. 42, RT 03/05, Kebayoran Baru, Jakarta Selatan (12160)',
                'delivery_courier' => 'Kurir Truk Toko (Same Day)',
                'shipping_fee' => 25000,
                'subtotal' => 613000,
                'discount' => 0,
                'grand_total' => 638000,
                'payment_method' => 'QRIS / E-Wallet',
                'payment_status' => 'Lunas',
                'order_status' => 'Sedang Dikirim',
                'notes' => 'Tolong packing kayu spray gun agar aman di perjalanan',
                'items' => [
                    ['code' => 'PRD-011', 'qty' => 4, 'price' => 92000],
                    ['code' => 'PRD-015', 'qty' => 1, 'price' => 245000],
                ],
            ],
            [
                'order_code' => 'ORD-20260927-03',
                'customer_code' => 'CUST-003',
                'customer_name' => 'Siti Rahmawati',
                'customer_phone' => '082198765432',
                'customer_email' => 'siti.rahma@yahoo.com',
                'fulfillment_type' => 'pickup',
                'pickup_location' => 'Cabang Barat - Ruko Sentra Niaga Blok B3 (Tangerang)',
                'pickup_date_time' => '2026-09-27 16:30 WIB',
                'delivery_address' => null,
                'delivery_courier' => null,
                'shipping_fee' => 0,
                'subtotal' => 350000,
                'discount' => 0,
                'grand_total' => 350000,
                'payment_method' => 'Bayar di Kasir (Pick Up)',
                'payment_status' => 'Lunas',
                'order_status' => 'Selesai',
                'notes' => 'Sudah selesai diambil dan lunas di kasir',
                'items' => [
                    ['code' => 'PRD-006', 'qty' => 2, 'price' => 175000],
                ],
            ],
        ];

        foreach ($ordersData as $ord) {
            $items = $ord['items'];
            unset($ord['items']);

            $cust = $customerModels[$ord['customer_code']] ?? null;
            unset($ord['customer_code']);
            $ord['customer_id'] = $cust ? $cust->id : null;

            $createdOrder = Order::firstOrCreate(['order_code' => $ord['order_code']], $ord);

            foreach ($items as $item) {
                $p = $productModels[$item['code']] ?? null;
                OrderItem::firstOrCreate([
                    'order_id' => $createdOrder->id,
                    'product_id' => $p ? $p->id : null,
                ], [
                    'product_name' => $p ? $p->name : 'Produk AutoGloss',
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'total' => $item['price'] * $item['qty'],
                ]);
            }
        }

        // 5. PENGGUNA UNTUK JWT AUTHENTICATION (Sesuai Slide 1 Task 03)
        User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Demo User (Week 11)',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        User::firstOrCreate(['email' => 'admin@autogloss.com'], [
            'name' => 'Admin AutoGloss',
            'email' => 'admin@autogloss.com',
            'password' => Hash::make('password'),
        ]);

        // 6. DATA PROGRAM UNTUK PENGUJIAN PROTECTED API (GET /api/programs)
        $programs = [
            ['name' => 'Program A', 'description' => 'Program Pelatihan AutoGloss Ceramic Coating Specialist'],
            ['name' => 'Program B', 'description' => 'Program Sertifikasi Paint Protection Film (PPF) AutoGloss'],
            ['name' => 'Program C', 'description' => 'Program Kemitraan Bengkel Body Repair & Oven Painting'],
        ];

        foreach ($programs as $prog) {
            Program::firstOrCreate(['name' => $prog['name']], $prog);
        }
    }
}
