<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_community extends Model
{
    protected $table = 'user_community';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'community_id',
        'position',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function community() {
        return $this->belongsTo('App\Community', 'community_id', 'id');
    }
}
