<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "image",
        "description",
        "price",
        "in_stock",
        "stock"
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, "category_products", "product_id", "category_id");
    }

    public function scopeSearch($query, string $search)
    {
        return $query->whereHas("categories", function (Builder $query) use ($search) {
            $query->where("name", "like", "%$search%");
        })->orWhere("title", "like", "%$search%")->orWhere("price", "like", "%$search%")->orWhere("description", "like", "%$search%");
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
