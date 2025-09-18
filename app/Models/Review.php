<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'rating',
        'comment',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
     public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
