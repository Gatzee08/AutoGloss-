<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource (Method Index - Week 9).
     * Eloquent ORM: withCount('orders') dan eager loading riwayat pesanan.
     */
    public function index(Request $request)
    {
        $query = Customer::withCount('orders');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage (CRUD - Create).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Pelanggan "' . $validated['name'] . '" berhasil didaftarkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with('orders.items')->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage (CRUD - Update).
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code,' . $customer->id,
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Data pelanggan "' . $customer->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (CRUD - Delete).
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $name = $customer->name;
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan "' . $name . '" berhasil dihapus!');
    }
}
