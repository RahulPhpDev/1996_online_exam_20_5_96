<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExamSubscription extends Model
{
   	protected $table = "exam_subscription";
    // protected  $primaryKey = 'id';
//    protected $fillable =array ('l_name', 't_status','created_at', 'updated_at');
    protected $guarded = array();
    public $timestamps = false;
}
