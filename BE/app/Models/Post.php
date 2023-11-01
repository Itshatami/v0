<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'caption',
        'cover'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }
}
