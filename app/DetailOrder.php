<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    //
    protected $fillable = [
        'num', 'price', 'order_id', 'product_id',
    ];
    public function order()
    {
        return $this->hasMany('App\Order', 'id', 'order_id');
    }
    public function product()
    {
        return $this->hasMany('App\Product', 'id', 'product_id');
    }
}
