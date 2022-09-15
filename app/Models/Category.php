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



    public function search(string $search, array $range)
    {
        $query = self::query();
        $query->where("id", "like", "%$search%")->orWhere("name", "like", "%search%");
        if ($range["range"] and $range["range_from"] !== false and $range["range_to"] !== false) {
            $query->whereBetween($range["range"], [$range["range_from"], $range["range_to"]]);
        }
        return $query;
    }
}
