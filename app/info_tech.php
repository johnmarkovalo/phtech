<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class info_tech extends Model
{
    protected $table = 'info_tech';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'info_id',
        'tech_id',
    ];

    public function information() {
        return $this->belongsTo('App\Information', 'info_id', 'id');
    }

    public function technology() {
        return $this->belongsTo('App\Technology', 'tech_id', 'id');
    }
}
