<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Exam;
use App\User;
class Subscription extends Model
{
    protected $guarded = [];
    
    public function Exam(){
    	$res = $this->belongsToMany(Exam::class)->withPivot(['status'])->where('exam_subscription.status','=' ,1);
    	    // return $this->belongsToMany('Budget')->where('training_id', '=', $training_id);

    	return $res;
    }

     public function User(){
        $subscription = $this->belongsToMany(User::class,'subscription_user')->withPivot(['start_date', 'status'])->withTimestamps();
        return $subscription;
    }

}
