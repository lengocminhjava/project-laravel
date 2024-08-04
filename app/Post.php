<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Category_Post;
use App\Status;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'content', 'thumbnail', 'intro', 'status_id', 'category_id', 'poster_id'
    ];
    function user()
    {
        return $this->belongsTo('App\User', 'poster_id', 'id');
    }
    function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }
    function category()
    {
        return $this->belongsTo('App\Category_Post', 'category_id', 'id');
    }
}
