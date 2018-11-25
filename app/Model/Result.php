<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Exam;
use DB;
class Result extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function User(){
    	$res = $this->belongsTo(User::class);
        return $res;
    }

    public function Exam(){
    	$res = $this->belongsTo(Exam::class);
        return $res;
    }
}
