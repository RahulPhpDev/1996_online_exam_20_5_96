<?php

namespace App\Policies;

use App\User;
use App\Model\Feedback;
use App\Model\FeedbackMeta;
use Illuminate\Auth\Access\HandlesAuthorization;

class feedbackReplyPolicy
{
    use HandlesAuthorization;

    private $currentData;
    public function __construct()
    {
       $this->currentData = date("Y-m-d H:i:s");
    }

    public function replyOnFeedback(Feedback $feedback, $token){
        
        if(($feedback->token === $token) && ($feedback->expiry > $this->currentData)){
            return true;
        }
    }
}
