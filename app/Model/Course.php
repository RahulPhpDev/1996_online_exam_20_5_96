<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
     protected $fillable = [
        'id','name', 'description','add_date','status','edit_date'
    ];
   public $timestamps = false;
   protected $table = "courses";
    protected  $primaryKey = 'id';
////    protected $fillable =array ('l_name', 't_status','created_at', 'updated_at');
//    protected $guarded = array();
    //
}
