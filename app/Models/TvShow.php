<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvShow extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'year'
    ];

    public function actors(){
        return $this->belongsToMany(Actor::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function seassons(){
        return $this->hasMany(Seasson::class);
    }

}
