<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desctiption'
    ];

    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
