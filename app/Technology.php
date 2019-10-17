<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $table = 'technology';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
    ];

    public function info_tech() {
        return $this->hasMany('App\info_tech', 'tech_id', 'id');
    }
}
