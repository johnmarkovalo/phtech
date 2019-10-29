<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class community_tech extends Model
{
    protected $table = 'community_tech';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'community_id',
        'tech_id',
    ];

    public function community() {
        return $this->belongsTo('App\Community', 'community_id', 'id');
    }

    public function technology() {
        return $this->belongsTo('App\Technology', 'tech_id', 'id');
    }
}
