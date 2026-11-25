<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'total' => 'decimal:2',
    ];

    /**
     * Relasi ORM: Detail item milik satu pesanan (Belongs-to)
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ORM: Detail item mengacu pada satu produk (Belongs-to)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
