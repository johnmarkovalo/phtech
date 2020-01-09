<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSponsor extends Model
{
    protected $table = 'event_sponsors';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'name',
    ];

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
