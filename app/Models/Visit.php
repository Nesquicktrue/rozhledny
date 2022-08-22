<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = array('tower_id', 'visited_at','user_id');


    public function getUser() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function getTower() {
        return $this->belongsTo('App\Models\Tower','tower_id');
    }
}
