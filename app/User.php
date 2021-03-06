<?php

namespace App;

// use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Model\Subscription;
use App\Model\Exam;
use App\Model\Student;
use App\Model\Result;
use App\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ExtraAttemptNotify;

// use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

  protected $guarded = array();
   
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }

    public function Subscription(){
        $subscription = $this->belongsToMany(Subscription::class)->withPivot(['start_date', 'status'])->withTimestamps();
        return $subscription;
    }

    public function Examghgf(){
        $subscription = $this->belongsToMany(Exam::class)->withPivot(['start_date','subscription_id','end_date' ,'status'])->withTimestamps();
        return $subscription;
    }

    public function Exam(){
        $res = $this->belongsToMany(Exam::class,'user_exam')->withPivot(['status'])->where('user_exam.status','=' ,1);
        return $res;
    }

    public function student(){
         return  $this->hasOne(Student::class,'user_id');
    }

    public function UsersExam(){
        $res = $this->belongsToMany(User::class,'user_exam')->wherePivot('status' , "=", 1);
        return $res;
    }
    
    public function Results(){
        $res = $this->hasMany(Result::class);
        return $res;
    }

    public function getFullName(){
          return "{$this->fname} {$this->lname}";
    }

    
}
