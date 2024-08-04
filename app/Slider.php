<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'user_id', 'status_id', 'thumbnail'
    ];
    //
    function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }
}
