<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'fname','lname', 'email', 'password','user_type','status','add_date','edit_date'
    // ];
protected $guarded = array();
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $timestamps = false;


    // USER ROLES
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }
}
