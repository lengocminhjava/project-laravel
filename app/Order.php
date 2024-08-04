<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'num', 'total', 'client_id', 'note', 'status_id', 'id_status', 'code'
    ];
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id');
    }
    function status()
    {
        return $this->belongsTo('App\StatusOrder', 'id_status', 'id');
    }
}
