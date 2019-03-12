<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Input;

use App\User;

use Illuminate\Support\Facades\Validator;
use App\Model\Feedback;
use App\Model\FeedbackMeta;
use DB;
use Response;
use Crypt;
use stdClass;

use Mail;
use Config;
use App;
use App\Model\Alert;
class FeedbackController extends Controller
{
    protected $expiry_time;
    public function __construct(){
          // $this->middleware('auth')->except(['index']);  
           $this->middleware('auth', ['only' => ['index']]);
         $this->expiry_time = date("Y-m-d H:i:s", strtotime('+2 hours'));
    }
    public function index()
    {

         $userId = Auth::user()->id;
       $feedbackMetaObj = new FeedbackMeta();
        // ->select(DB::raw('count(*) as user_count, status'))
        $feedbackMetaData =  FeedbackMeta::where('sender', $userId)
                            ->with('hasFeedback')
                            ->orWhere('receiver', $userId)
                            ->select( '*')
                            ->groupBy('feedback_id')
                            ->get();     
        $finalFeedback = array();      
        // echo '<pre>';                      
        foreach ($feedbackMetaData->toArray() as $key => $feedback) {
          $unreadCountFeedback = $feedbackMetaObj->getUnreadCountOfFeedback($feedback['feedback_id'], $userId);
          $getFeedbackData =  FeedbackMeta::where('feedback_id',$feedback['feedback_id'])->max('create_date');
          $finalFeedback[$key] = $feedback;
          $finalFeedback[$key]['unread_count'] = $unreadCountFeedback;
          $finalFeedback[$key]['last_message_date'] = extractDateTime('d-M-y h:i A',$getFeedbackData);
           $finalFeedback[$key]['has_feedback']['encrypted_id'] = Crypt::encrypt($feedback['has_feedback']['id']);
       }        
        $feedbackMetaJson =  Response::json($finalFeedback);
        $feedbackMetaJson = $feedbackMetaJson->getContent();
        
        return View('feedback.index',compact('feedbackMetaData','feedbackMetaJson'));
    }

    public function create()
    {
        return View('feedback/add_feedback');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'email' => 'required|email',
           'name' => 'required|string|max:50',
           'subject' => 'required|string|max:200',
           'message' => 'required|min:20'
       ]);
       if($validator->fails()){
          Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
       }
      $status = 1;
       if(!Auth::user()){
           $userData = User::where('email',$request->email)->select(['id'])->first();
           $sendBy = 0;
           if(!empty($userData)){
                $sendBy = $userData->id;
           }
           $status = 2;
       }else{
         $sendBy = Auth::user()->id;
       }
        
        $feedbackObj = new Feedback;
        $feedbackObj->subject     =   $request->get('subject');
        $feedbackObj->name        =   $request->get('name');
        $feedbackObj->email       =   $request->get('email');
        $feedbackObj->status      =   $status;
        $feedbackObj->initiat_by  =   $sendBy;
        $feedbackObj->save();

        $feedbackMetaData = array(
            'message' => Input::get('message'),
            'sender' => $sendBy,
            'receiver' => 1,
            'status' => 0,
            'create_date' => date('Y-m-d H:i:s')
        );
        $feedbackObj->FeedbackMeta()->save(new FeedbackMeta($feedbackMetaData ));
        Session::flash('success', 'Your Message has send to Admin!'); 
        return redirect()->route('feedback.create');
     
    }

    public function feedbackReplyMeta(Request $request, $token){
        $feedbackData =  Feedback::where('token', $token)->first();

        $userId = 0;
        if(Auth::user()){
            $userId = Auth::user()->id;
        }
        if($request->isMethod('post')){
         $feedbackData->token = '';
         $feedbackData->expiry = '0000:00:00';
         $feedbackData->save();
         $feed = array(
            'message' => Input::get('reply'),
            'sender' => $userId,
            'receiver' => 1,
            'status' => 0,
            'create_date' => date('Y-m-d H:i:s')
        );
        $feedbackData->FeedbackMeta()->save(new FeedbackMeta($feed ));

        $emailParams = new stdClass;
        $emailParams->user_id = 1;
        $emailParams->user_email = env('MAIL_USERNAME');
        $emailParams->alert_id = 2;
        $emailParams->subject_params = ['RE: ' .$feedbackData['subject']];
        $emailParams->msg_params = [Input::get('reply'),Auth::user()->fname.' '.Auth::user()->lname, Auth::user()->email, date('Y-m-d H:i:s')];
        $alertObj = new Alert();
        $outputData =  $alertObj->sendEmail($emailParams);


        Session::flash('success', 'Your Message has send to User!You Can send message with new Subject'); 
        return redirect()->route('feedback.create');
       }
    return View('feedback/reply_meta',compact('feedbackData','userId'));
    }
   
    public function show(Request $request,$en_id)
    {
        $id = Crypt::decrypt($en_id);
        $feedbackData = Feedback::find($id);
        $userId = 0;
        if(Auth::user()){
            $userId = Auth::user()->id;
        }
        return View('feedback/show_feedback', compact('feedbackData','userId','en_id'));
    }

    public function updateRead($en_id){
        $id = Crypt::decrypt($en_id);
        $feedbackData = Feedback::find($id);
        $feedbackData->FeedbackMeta()->where('receiver',Auth::user()->id)->update(['isRead' => 1]);

        // $feedbackData->FeedbackMeta()->where(['receiver' => 1])->update(['isRead' => 1]);
    }

    public function saveFeedbackShow(request $request,$eid){
         $id = Crypt::decrypt($eid);
         $feedback = Feedback::find($id);
         $sendBy =  Auth::user()->id;
         $feed = array(
            'feedback_id' => $id ,               
            'message' => Input::get('reply'),
            'sender' => $sendBy,
            'receiver' => 1,
            'status' => 0,
            'create_date' => date('Y-m-d H:i:s')
        );
        FeedbackMeta::create($feed);
        Session::flash('success', 'Your Message has send to User!'); 

        $emailParams = new stdClass;
        $emailParams->user_id = 1;
        $emailParams->user_email = env('MAIL_USERNAME');
        $emailParams->alert_id = 2;
        $emailParams->subject_params = ['RE: ' .$feedback['subject']];
        $emailParams->msg_params = [Input::get('reply'),Auth::user()->fname.' '.Auth::user()->lname, Auth::user()->email, date('Y-m-d H:i:s')];
        $alertObj = new Alert();
        $outputData =  $alertObj->sendEmail($emailParams);

       return redirect('feedback'); 
    }

    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        
    }

    
    public function destroy($id)
    {
        //
    }

     public function updateReadFeedbackByUser($id){
        $feedbackData = Feedback::find($id);        
        $feedbackData->FeedbackMeta()->where(array(['receiver' ,'<>', 1]))->update(['isRead' => 1]);
    }
}
