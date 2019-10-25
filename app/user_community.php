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
    ];

    public function user() {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    public function community() {
        return $this->belongsTo('App\Community', 'id', 'community_id');
    }
}
