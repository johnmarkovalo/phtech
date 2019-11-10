<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'community';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $casts = [
        'location' => 'array'
    ];

    protected $fillable = [
        'organizer_id',
        'name',
        'description',
        'location',
        'photo',
        'status',
    ];

    public function organizer() {
        return $this->belongsTo('App\User','organizer_id', 'id');
    }

    public function user_community() {
        return $this->hasMany('App\user_community', 'community_id', 'id');
    }
    
    public function event_community() {
        return $this->hasMany('App\event_community', 'community_id', 'id');
    }
    
    public function community_tech() {
        return $this->hasMany('App\info_tech', 'info_id', 'id');
    }

}
