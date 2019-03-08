<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\FeedbackMeta;

class Feedback extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function FeedbackMeta(){
    	return $this->hasOne(FeedbackMeta::class);
    }

    public function MutipleFeedbackMetaData(){    	
    	return $this->hasMany(FeedbackMeta::class);
    }
}


