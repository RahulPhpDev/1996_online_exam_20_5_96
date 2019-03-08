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

    public function hasFeedback(){
    	// die(' check');
    	return $this->belongsTo(Feedback::class, 'feedback_id');
    }

}
