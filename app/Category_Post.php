<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;

class Category_Post extends Model
{
    use SoftDeletes;
    //
    public $table = "category_posts";
    protected $fillable = [
        'id', 'name', 'parent_id'
    ];
    function post()
    {
        return $this->HasMany('App\Post', 'category_id');
    }
    function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }
}
