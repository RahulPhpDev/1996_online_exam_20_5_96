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
        $feedbackMetaData =  FeedbackMeta::where('sender', $userId)
                            ->with('hasFeedback')
                            ->orWhere('receiver', $userId)
                            ->select('*',
                                 (DB::raw("(select count(*) from feedback_meta where isRead = 0 And  `receiver` = $userId)  as unread_count")),
                                  (DB::raw("(select max(create_date) from feedback_meta where  `receiver` = $userId)  as last_message_date"))
                                 )
                            ->groupBy('feedback_id')
                            ->get();
       $finalFeedback = array();
       foreach ($feedbackMetaData->toArray() as $key => $feedback) {
           $finalFeedback[$key] = $feedback;
           $finalFeedback[$key]['last_message_date'] = extractDateTime('d-M-Y h:i A',$feedback['last_message_date']);
           $finalFeedback[$key]['has_feedback']['encrypted_id'] = Crypt::encrypt($feedback['has_feedback']['id']);
       }
        $feedbackMetaJson =  Response::json($finalFeedback);
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
        Session::flash('success', 'Your Message has send to User!You Can send message with new Subject'); 
        return redirect()->route('feedback.create');
       }

// http://127.0.0.1:8000/feedback/reply_meta/d8Jzj740MGK7r9v4WAxCVd250lZaRRediFgrfLVmX2ARSpiIn4
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

    public function saveFeedbackShow(request $request,$id){
        // dd('dks');
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
         return redirect('feedback');
        // dd('insert');    
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
