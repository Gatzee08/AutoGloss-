<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'sub_category',
        'price',
        'original_price',
        'is_promo',
        'discount_percent',
        'stock',
        'unit',
        'rating',
        'sold_count',
        'image',
        'badge',
        'description',
        'features',
    ];

    protected $casts = [
        'is_promo' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'float',
        'stock' => 'integer',
        'discount_percent' => 'integer',
        'sold_count' => 'integer',
        'features' => 'array',
    ];

    /**
     * Relasi ORM: Setiap produk milik satu kategori (Belongs-to)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ORM: Produk dapat muncul di banyak detail order item (One-to-Many)
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
