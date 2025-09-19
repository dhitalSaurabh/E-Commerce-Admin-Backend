<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVarient extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVarientFactory> */
    use HasFactory;
    protected $fillable = [
        // 'user_id',
        'product_id',
        'size',
        'color',
        'material',
        'price',
        'sku',
        'image',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'variant_id');
    }
    public function ordereditems()
    {
    return $this->hasMany(OrderedItem::class);
    }
    public function carts()
    {
    return $this->hasMany(Cart::class);
    }
}
