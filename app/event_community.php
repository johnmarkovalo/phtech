<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event_community extends Model
{
    protected $table = 'event_community';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'community_id',
        'position',
    ];

    public function community() {
        return $this->belongsTo('App\Community', 'community_id', 'id');
    }

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
