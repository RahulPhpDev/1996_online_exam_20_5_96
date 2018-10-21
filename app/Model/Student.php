<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      
    // protected $fillable = [
    //     'user_id', 'start_date', 'end_date','course_id'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token',
    ];
public $timestamps = false;
    protected $guarded = array();
}
