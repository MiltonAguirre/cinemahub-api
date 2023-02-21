<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'year',
        'duration',
        'director_id'
    ];

    public function actors(){
        return $this->belongsToMany(Actor::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function director(){
        return $this->belongsTo(Director::class);
    }
}
