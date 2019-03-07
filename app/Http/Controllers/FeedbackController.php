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

class FeedbackController extends Controller
{
    protected $expiry_time;
    public function __construct(){

         $this->expiry_time = date("Y-m-d H:i:s", strtotime('+2 hours'));
    }
    public function index()
    {
        // dd('check');
       
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
       $userData = User::where('email',$request->email)->select(['id'])->first();
       $sendBy = 0;
       if(!empty($userData)){
            $sendBy = $userData->id;
       }
        $status = 2;
        $category = new Feedback;
        $category->subject = $request->get('subject');
        $category->name = $request->get('name');
        $category->email = $request->get('email');
        $category->status = 1;
        $category->save();

        $feed = array(
            'message' => Input::get('message'),
            'sender' => $sendBy,
            'receiver' => 1,
            'status' => 0,
            'create_date' => date('Y-m-d H:i:s')
        );

        $category->FeedbackMeta()->save(new FeedbackMeta($feed ));
// redirect()->route('profile.show', [$userId]);

        Session::flash('status', 'Your Message has send to Admin!'); 
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
        Session::flash('status', 'Your Message has send to Admin!'); 
        return redirect()->route('feedback/reply',1);
       }
       return View('feedback/feedback_reply', compact('feedbackData'));
    }

    public function feedbackReplyMeta(Request $request, $token){
        if(checkForExpiry($token)){
            
        }
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
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
