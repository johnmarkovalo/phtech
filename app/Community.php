<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'community';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'organizer_id',
        'name',
        'description',
        'location',
        'photo',
    ];

    public function organizer() {
        return $this->belongsTo('App\User','id', 'organizer_id');
    }

    public function user_community() {
        return $this->hasMany('App\user_community', 'community_id', 'id');
    }

    public function community_tech() {
        return $this->hasMany('App\info_tech', 'info_id', 'id');
    }
}
