<?php

namespace App\Models;

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

    public function search(string $search, array $range)
    {
        // return self::query()->where("title", "like", "%$search%")->orWhere("description", "like", "%$search%")->orWhere("id", "like", "%$search%");
        $query = self::query();
        if ($range["range"] and $range["range_from"] !== false and $range["range_to"] !== false) {
            $query->whereBetween($range["range"], [$range["range_from"], $range["range_to"]]);
        }
        $query->where("title", "like", "%$search%");
        return $query;
    }
}
