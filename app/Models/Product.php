<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'type',
        'price',
        'old_price',
        'image_path',
        'badge',
        'badge_color',
        'icon',
        'stocks',
        'status',
    ];

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * The product movements (inventory trail) for this product.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class);
    }
}
