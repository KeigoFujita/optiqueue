<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
