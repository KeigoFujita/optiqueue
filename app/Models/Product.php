<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
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
    ];

    /**
     * The product movements (inventory trail) for this product.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class);
    }
}
