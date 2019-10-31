<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event_tech extends Model
{
    protected $table = 'event_tech';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'tech_id',
    ];

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

    public function technology() {
        return $this->belongsTo('App\Technology', 'tech_id', 'id');
    }
}
