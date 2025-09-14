<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    // Self-referencing relationship for parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    // Self-referencing relationship for child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
{
    return $this->hasMany(Product::class);
}

}
