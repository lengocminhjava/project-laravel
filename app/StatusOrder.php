<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    //
    public $table = "status_orders";
    protected $fillable = [
        'name', 'id'
    ];
}
