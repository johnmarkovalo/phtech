<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'points',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function point_logs() {
        return $this->hasMany('App\point_logs', 'point_id', 'id');
    }
}
