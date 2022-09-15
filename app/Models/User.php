<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "role_id",
        "picture"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function search(string $search, array $range)
    {
        $query = self::query();
        $query->with("role")->whereHas("role", function (Builder $query) use ($search) {
            $query->where("name", "like", "%$search%");
        })->orWhere("name", "like", "%$search%")->orWhere("email", "like", "%$search%")->orWhere("id", "like", "%$search%");
        if ($range["range"] and $range["range_from"] !== false and $range["range_to"] !== false) {
            $query->whereBetween($range["range"], [$range["range_from"], $range["range_to"]]);
        }
        return $query;
    }

    public function role()
    {
        return $this->hasOne(Role::class, "id", "role_id");
    }
}
