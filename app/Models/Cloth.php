<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cloth extends Model
{
    /** @use HasFactory<\Database\Factories\ClothFactory> */
    use HasFactory;
protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'image',
    'user_id',
];
 public function user()
    {
        return $this->belongsTo(User::class);
    }
}
