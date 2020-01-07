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
        'sponsor_name',
    ];

    public function information() {
        return $this->belongsTo('App\Event', 'evenvt_id', 'id');
    }
}
