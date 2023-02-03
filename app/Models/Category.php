<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function task()
    {
        $this->hasMany(Task::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
