<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    // protected $table = "exam_question";
    // protected  $primaryKey = 'id';
//    protected $fillable =array ('l_name', 't_status','created_at', 'updated_at');
    protected $guarded = array();
    public $timestamps = false;
}
// chosen-drop
// chosen-single