<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function useraddress()
    {
        return $this->hasOne(UserAddress::class, 'customer_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function ordereditems()
    {
        return $this->hasMany(OrderedItem::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
