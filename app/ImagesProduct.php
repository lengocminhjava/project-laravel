<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ImagesProduct extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'name', 'product_id', 'thumbnail'
    ];
    function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
