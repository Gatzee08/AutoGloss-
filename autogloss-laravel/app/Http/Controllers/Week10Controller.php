<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class Week10Controller extends Controller
{
    /**
     * Halaman Materi & Simulator Week 10: From CRUD to Application Flow
     * Menampilkan diagram alur: User -> Route -> Controller -> Model -> Database -> View -> User
     * Serta completion checklist & pengujian langsung REST API CRUD + Validation + HTTP Status
     */
    public function index()
    {
        $categories = Category::all();
        $sampleProduct = Product::first();
        $totalProducts = Product::count();

        return view('week10-flow', compact('categories', 'sampleProduct', 'totalProducts'));
    }
}
