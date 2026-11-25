<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'customer_code',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'total_orders',
        'total_spent',
    ];

    protected $casts = [
        'total_orders' => 'integer',
        'total_spent' => 'decimal:2',
    ];

    /**
     * Relasi ORM: Satu pelanggan memiliki banyak riwayat pesanan (One-to-Many)
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
