<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'year',
        'tv_show_id'
    ];

    public function tvShow(){
        return $this->belongsTo(TvShow::class);
    }
    public function episodes(){
        return $this->hasMany(Episode::class);
    }
}
