<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bithdate',
    ];

    public function movies(){
        return $this->hasMany(Movie::class);
    }

    public function episodes(){
        return $this->hasMany(Episode::class);
    }
}
