<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /** @use HasFactory<\Database\Factories\UserAddressFactory> */
    use HasFactory;
    // The attributes that are mass assignable
    protected $fillable = [
        'customer_id',
        'full_name',
        'phone',
        'city',
        'state',
        'is_default',
    ];
public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
// Scope to get default address
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
