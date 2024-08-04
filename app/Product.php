<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Product extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'code', 'price', 'selling', '	stock', 'price_old', 'num_qty', 'description', 'detail_product', 'featured_product', 'thumbnail', 'base_url', 'status_id', 'category_id', 'poster_id'
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
        return $this->belongsTo('App\CategoryProduct', 'category_id', 'id');
    }
    function image()
    {
        return $this->hasMany('App\ImagesProduct', 'id', 'product_id');
    }
    public function detail_order()
    {
        return $this->belongsTo('App\DetailOrder');
    }
}
