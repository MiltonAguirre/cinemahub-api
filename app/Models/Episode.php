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
        'seasson_id'
    ];

    public function director(){
        return $this->belongsTo(Director::class);
    }
    public function seasson(){
        return $this->belongsTo(Seasson::class);
    }
}
