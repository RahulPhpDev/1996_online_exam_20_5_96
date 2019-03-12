<?php

namespace App\Model;
use App\Model\Feedback;
use Auth;
use App\User;

use Illuminate\Database\Eloquent\Model;

class FeedbackMeta extends Model
{
    protected $table = 'feedback_meta';
    public $timestamps = false;
    protected $guarded = [];
	protected $columns = array('id','feedback_id','message','sender','receiver','status','isRead','create_date');
    public function hasFeedback(){
    	// die(' check');
    	return $this->belongsTo(Feedback::class, 'feedback_id');
    }
	public function scopeExclude($query,$value = array()) 
	{
	    return $query->select( array_diff( $this->columns,(array) $value) );
	}

	public function getUnreadCountOfFeedback($feedback_id, $receiver_id = 1){
		$unreadFeedback = $this::where(array(['feedback_id','=',$feedback_id], ['receiver','=',$receiver_id], ['isRead', '=', 0]))->count();
		return $unreadFeedback;
	}

}
