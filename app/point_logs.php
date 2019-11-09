<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class point_logs extends Model
{
    protected $table = 'point_logs';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'point_id',
        'event_id',
        'position',
        'point',
    ];

    public function point() {
        return $this->belongsTo('App\point_logs', 'point_id', 'id');
    }

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
