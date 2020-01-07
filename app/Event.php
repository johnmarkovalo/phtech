<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $casts = [
        'location' => 'array'
    ];

    protected $fillable = [
        'organizer_id',
        'code',
        'title',
        'description',
        'location',
        'start',
        'end',
        'photo',
        'fee',
        'limit',
        'exclusive',
        'status',
    ];

    public function organizer() {
        return $this->belongsTo('App\User','organizer_id', 'id');
    }

    public function user_event() {
        return $this->hasMany('App\user_event', 'event_id', 'id');
    }

    public function event_community() {
        return $this->hasMany('App\event_community', 'event_id', 'id');
    }

    public function event_tech() {
        return $this->hasMany('App\event_tech', 'event_id', 'id');
    }
}
