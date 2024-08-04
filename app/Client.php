<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'name', 'phone_number', 'address', 'note', 'email'
    ];
    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
