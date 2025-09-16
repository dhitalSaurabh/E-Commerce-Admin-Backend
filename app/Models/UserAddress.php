<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /** @use HasFactory<\Database\Factories\UserAddressFactory> */
    use HasFactory;
    protected $fillable = [
'full_name',
'phone',
'city',
'state',
'is_default',
    ];
public function user()
    {
        return $this->belongsTo(Customer::class);
    }

}
