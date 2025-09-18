<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderedItemFactory> */
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'order_id',
        'variant_id',
        'quantity',
        'price',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVarient::class, 'variant_id');
    }



}
