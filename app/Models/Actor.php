<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'birthdate',
    ];

    public function movies(){
        return $this->belongsToMany(Movie::class, 'actor_movie', 'actor_id');
    }

    public function tvShows(){
        return $this->belongsToMany(TvShow::class, 'actor_tv_show', 'actor_id');
    }
}
