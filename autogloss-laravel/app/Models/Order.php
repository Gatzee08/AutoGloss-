<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'fulfillment_type',
        'pickup_location',
        'pickup_date_time',
        'delivery_address',
        'delivery_courier',
        'shipping_fee',
        'subtotal',
        'discount',
        'grand_total',
        'payment_method',
        'payment_status',
        'order_status',
        'payment_proof',
        'notes',
    ];

    protected $casts = [
        'shipping_fee' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    /**
     * Relasi ORM: Pesanan milik satu pelanggan (Belongs-to)
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ORM: Satu pesanan memiliki banyak item detail (One-to-Many)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
