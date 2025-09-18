<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;
  protected $fillable = [
        'customer_id',
        'variant_id',
        'quantity',
        'added_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVarient::class, 'variant_id');
    }


}
