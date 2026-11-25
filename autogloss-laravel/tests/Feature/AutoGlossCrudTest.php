<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoGlossCrudTest extends TestCase
{
    public function test_dashboard_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('AutoGloss');
    }

    public function test_products_index_renders_with_products(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Katalog Produk');
    }

    public function test_categories_index_renders(): void
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
        $response->assertSee('Kategori Produk');
    }

    public function test_customers_index_renders(): void
    {
        $response = $this->get('/customers');
        $response->assertStatus(200);
        $response->assertSee('Data Pelanggan');
    }

    public function test_orders_index_renders(): void
    {
        $response = $this->get('/orders');
        $response->assertStatus(200);
        $response->assertSee('Daftar Pesanan');
    }
}

