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
class FeedbackController extends Controller
{
    protected $expiry_time;
    public function __construct(){

         $this->expiry_time = date("Y-m-d H:i:s", strtotime('+2 hours'));
    }
    public function index()
    {
   // select *, (select count(*) as unread_count from feedback_meta where isRead = 0 And  `receiver` = 35) as unread from `feedback_meta` where `sender` = 35 or `receiver` = 35 group by `feedback_id`

        $userId = Auth::user()->id;
        // ->select(DB::raw('count(*) as user_count, status'))
        $feedbackMetaData =  FeedbackMeta::where('sender', $userId)
                            ->with('hasFeedback')
                            ->orWhere('receiver', $userId)
                            ->select('*',
                                 (DB::raw("(select count(*) from feedback_meta where isRead = 0 And  `receiver` = $userId)  as unread_count")),
                                  (DB::raw("(select max(create_date) from feedback_meta where  `receiver` = $userId)  as last_message_date"))
                                 )
                            ->groupBy('feedback_id')
                            ->get();
                            // dd($feedbackMetaData);
       $feedbackJson = FeedbackMeta::with('hasFeedback')->where('sender', $userId)->orWhere('receiver', $userId)->groupBy('feedback_id')->get();

        $feedbackMetaJson =  Response::json($feedbackMetaData);
        // dd($feedbackMetaJson->getData());
        return View('feedback.index',compact('feedbackMetaData','feedbackMetaJson'));
    }

    public function create()
    {
        return View('feedback/add_feedback');
    }

    
    public function store(Request $request)
    {
        // dd($request->all());
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

    public function feedbackReply(Request $request, $subject_id){
       $token =  generate_string(50);
       $feedbackData =  Feedback::find($subject_id);
       if($request->isMethod('post')){
         $feedbackData->token = $token;
         $feedbackData->expiry = $this->expiry_time;
         $feedbackData->save();
         $sendBy = 1;
         $feed = array(
            'message' => Input::get('reply'),
            'sender' => $sendBy,
            'receiver' => 1,
            'status' => 0,
            'create_date' => date('Y-m-d H:i:s')
        );

        $feedbackData->FeedbackMeta()->save(new FeedbackMeta($feed ));
        Session::flash('success', 'Your Message has send to User!'); 
        return redirect()->route('feedback/reply',1);
       }
       return View('feedback/feedback_reply', compact('feedbackData'));
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
        Session::flash('success', 'Your Message has send to User!'); 
        return redirect()->route('feedback/reply',1);
       }

// http://127.0.0.1:8000/feedback/reply_meta/d8Jzj740MGK7r9v4WAxCVd250lZaRRediFgrfLVmX2ARSpiIn4
        return View('feedback/reply_meta',compact('feedbackData','userId'));
    }
   
    public function show($id)
    {
        
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
}
