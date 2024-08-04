<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryProduct extends Model
{
    //
    use SoftDeletes;
    //
    public $table = "category_products";
    protected $fillable = [
        'id', 'name', 'parent_id','status'
    ];
    function products()
    {
        return $this->HasMany('App\Product', 'category_id');
    }
    function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }
}
