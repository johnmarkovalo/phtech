<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $table = 'technology';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
    ];

    public function info_tech() {
        return $this->hasMany('App\info_tech', 'tech_id', 'id');
    }

    public function community_tech() {
        return $this->hasMany('App\community_tech', 'tech_id', 'id');
    }

    public function event_tech() {
        return $this->hasMany('App\event_tech', 'tech_id', 'id');
    }
}
