<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'duration',
        'director_id',
        'season_id'
    ];

    public function director(){
        return $this->belongsTo(Director::class);
    }
    public function season(){
        return $this->belongsTo(Season::class);
    }
}
