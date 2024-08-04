<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'name', 'description',
    ];
    public function user()
    {
        return $this->belongsToMany('App\User', 'user_role', 'role_id', 'user_id');
    }
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'role_permission', 'role_id', 'permission_id');
    }
}
