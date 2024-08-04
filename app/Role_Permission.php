<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_Permission extends Model
{
    //
    public $table = "role_permission";
    protected $fillable = [
        'role_id', 'permission_id'
    ];
}
