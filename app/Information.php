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
        'affiliation',
        'position'
    ];

    public function info_tech() {
        return $this->hasMany('App\info_tech', 'info_id', 'id');
    }
}
