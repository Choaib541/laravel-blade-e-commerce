<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "image"
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, "category_products", "category_id", "product_id");
    }


    public function scopeSearch($query, string $search)
    {
        return $query->Where("name", "like", "%$search%")->orWhere("id", "like", "%$search%");
    }

    public function scopeSort($query, string $sort, string $direc)
    {
        return $query->orderBy($sort, $direc);
    }

    public function scopeRange($query, $range, $from, $to)
    {
        return $query->whereBetween($range, [$from, $to]);
    }
}
