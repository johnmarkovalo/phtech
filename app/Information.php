<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'lastname',
        'firstname',
        'affiliation',
        'position',
        'occupation',
        'bio',
        'avatar'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function info_tech() {
        return $this->hasMany('App\info_tech', 'info_id', 'id');
    }

    public function technologies() {
        return $this->belongsToMany('App\Technology', 'info_tech', 'info_id', 'tech_id');
    }
}
