<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    public function password(): Attribute
    {
        return new Attribute(
            null,
            set: fn ($value) => Hash::make($value)
        );
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function user_session()
    {
        return $this->belongsTo(UserSession::class);
    }
}
