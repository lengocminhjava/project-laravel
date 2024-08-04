<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Status;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'status', 'page_id', 'status_id', 'content'
    ];
    //
    function user()
    {
        return $this->belongsTo('App\User', 'page_id', 'id');
    }
    function statu()
    {
        return $this->belongsTo('App\Status', 'status_id', 'id');
    }
}
