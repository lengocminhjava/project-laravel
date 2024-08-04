<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = [
        'name', 'slug', 'description'
    ];
    public function roles()
    {
        // return $this->belongsToMany(Role::class);
        return $this->belongsToMany('App\Role', 'role_permission', 'permission_id', 'role_id');
    }
}
