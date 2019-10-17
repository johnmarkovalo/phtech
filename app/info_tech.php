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
        return $this->belongsTo('App\Information', 'id', 'info_id');
    }

    public function technology() {
        return $this->belongsTo('App\Technology', 'id', 'tech_id');
    }
}
