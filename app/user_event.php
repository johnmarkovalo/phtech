<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_event extends Model
{
    protected $table = 'user_event';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
