<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_url',
        'shortener_url',
        'title',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}