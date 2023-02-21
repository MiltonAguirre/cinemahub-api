<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];

   
    public function movies(){
        return $this->belongsToMany(Movie::class, 'category_movie', 'category_id');
    }

    public function tvShows(){
        return $this->belongsToMany(TvShow::class, 'category_tv_show', 'category_id');
    }
}
