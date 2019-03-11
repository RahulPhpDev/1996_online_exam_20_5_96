<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Feedback;
use App\Model\Announcement;

use App\Events\FeedbackReply;
use Event;
use Auth;
use Response;
use Session;
class ArticleController extends Controller
{
    public function feedback(){
    	$allFeedback = Feedback::orderBy('add_date','desc')
    							->groupBy('email')->where(['status' => 1],['feedback_id' => 0])
    							->distinct('email')
    							->select('id', 'subject', 'email','name','add_date', DB::raw('count(*) as total'))
    							// ->get(['id', 'subject', 'email','name','add_date']);
    							->get();
        $title = 'Feedback';    							
    	return view('admin/article/feedback',compact('allFeedback','title'));
    }

    public function feedbackMessage($id){
    	$feedback = Feedback::findOrFail($id);
    	$userEmail = $feedback->email;
    	$userFeedback = Feedback::orderBy('add_date','desc')
    							->where(['email' => $userEmail],['status' => 1],['feedback_id' => 0])
    							->select('id', 'subject', 'email','name','add_date')
    							->get();				
		return view('admin/article/feedback-message',compact('userFeedback'));    							
    }

    public function feedbackReply(Request $request, $id){
    	$feedback = Feedback::findOrFail($id);
        $feedback->status = 2;
        $feedback->save();
    	$title = 'Feedback Reply';

    	 if ($request->isMethod('POST')) {
             $feedbackId =    Feedback::create([
                    'feedback_id' => $feedback->id,
                    'name' => Auth::user()->fname.' '.Auth::user()->lname,
                    'email' => Auth::user()->email,
                    'subject' => $feedback->subject,
                    'message' => $request->reply,
                ]);
            Event::fire(new FeedbackReply($feedbackId['feedback_id']));
            return redirect()->route('feedback');
         }
    	return view('admin/article/feedback-reply', compact('feedback','title'));
    }

    public function addAnnouncement(Request $request){

         if ($request->isMethod('POST')) {
            // dd($request->all());
             $feedbackId =    Announcement::create([
                'content' =>$request->content,
                'status' => 1,
                // 'add_date' => date('Y-m-d'),
            ]);
             return redirect()->route('announcement');
            }
        return view('admin/article/add-announcement');
    }

    public function announcement(){
        $allData = Announcement::all(); 
        // $allData = json_encode($allDataS->toArray());
        $allData = Response::json($allData);
    //   echo 'hk';  dd($allData->getContent());
        return view('admin/article/announcement', compact('allData'));
    }

    public function editAnnouncement(request $request, $id){
        $announcementData = Announcement::findOrFail($id);
         if ($request->isMethod('POST')) {
             $announcementData->content = $request->content;
             $announcementData->save();
             return redirect()->route('announcement');
        }
       return view('admin/article/edit-announcement',compact('announcementData'));
    }

    public function deleteAnnouncement($id){
        $announcementData = Announcement::findOrFail($id);
        $announcementData->delete();
        Session::flash('success', 'Announcement Delete!'); 
        return redirect()->route('announcement');
    }
}
