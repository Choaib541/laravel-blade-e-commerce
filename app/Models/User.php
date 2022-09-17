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

    public function role()
    {
        return $this->hasOne(Role::class, "id", "role_id");
    }


    public function scopeSearch($query, string $search)
    {
        return $query->whereHas("role", function (Builder $query) use ($search) {
            $query->where("name", "like", "%$search%");
        })->Where("name", "like", "%$search%")->orWhere("id", "like", "%$search%")->orWhere("email", "like", "%$search%");
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
