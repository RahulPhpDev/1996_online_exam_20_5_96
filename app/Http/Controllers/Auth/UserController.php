<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Auth;


use App\User;
use App\Model\Subscription;
use App\Model\Question;
use App\Model\Exam;
use App\Model\Student;
use App\Model\UserAnswer;
use App\Model\Result;
use Session;
use App\helpers\helper;

use Redirect;
use DB;
use Image; 
use PDF;
use Dompdf\Dompdf;
use Mpdf;
use Response;


use Cache;


use App\Http\Requests\updateProfileRequest; #form-validation
use File;
use stdClass;
use Illuminate\Support\Facades\Hash;
use Notifications;
use App\Notifications\notifyExamSubmission;
class UserController extends Controller
{

  public function profile(){
    $user = Auth::user();
    $title  = 'My Profile';
    return view('auth.profile',compact('title', 'user'));
 }

 public function updateProfile(updateProfileRequest $request){
        $user = Auth::user();
        $userDetails = User::FindorFail($user['id']);
        $userDetails->fname = $request['fname'];
        $userDetails->lname = $request['lname'];
        $userDetails->phone_no = $request['phone_no'];
        $userDetails->save();
        if(isset($request['address'])) {
          $data = ['address' => $request['address'] ];
          Student::where('user_id', $user['id'])->update($data);
        }
        return redirect()-> route('myprofile')->with('success', 'Update Successfully');
 }


    public function savePackageExam($c_id){
       $id =  Crypt::decrypt($c_id);
       $userData = Auth::user();
       $userId = $userData['id'];
      
         $package =  Subscription::find($id);
         $examIdArray = array();
         foreach($package->Exam as $examId){
            $examIdArray[] = $examId['id'];
         }
        $userDetails =  User::find($userId);
        // dd($userDetails);
    $package->User()->attach($id, [
      'user_id' => $userId,
      'status' => 1,
      'start_date' => date('Y-m-d'),
      'created_at' => date('Y-m-d') ]
    );
    
    $extraFieldInUserExam = array(
      'status' => 1, 
      'user_id' => $userId,
      'start_date' => date('Y-m-d')
    );
    foreach($examIdArray as $eid){
       $userDetails->Exam()->attach($eid,$extraFieldInUserExam);
   }
    $msg = 'Congratulation !! Please Explore Package';
   return redirect()->route('subscrption-exam',Crypt::encrypt($id))->with('success',$msg); 
    }

    public function subscrptionExam($id = ''){
       $sid =  Crypt::decrypt($id);
       $package =  Subscription::find($sid);
      return view('permit.exam.package-exam',compact('package'));

    }
   
    public function examInstruction($e_id){
      $id = Crypt::decrypt($e_id);
      $examData = Exam::find($id);
      forgetSession($id.'_'.Auth::user()->id);
      $topTen =   Result::where('exam_id', '=',$id)
                  ->where('result_status' ,'=', 1)
                  ->orderBy(DB::raw('max(obtain_mark)'), 'desc')
                  ->take(10)
                  ->groupBy('user_id')
                  ->get(['user_id', DB::raw('max(obtain_mark) as max')] );
                     
      
      return view('permit.exam.exam-instruction',compact('examData','topTen'));
    }
/************************* Start Of New ATTempt ********************/
    public function attemptExam($e_id){
     $id =  Crypt::decrypt($e_id);
     $examData = Cache::remember('examDetails'.$id, 60, function() use ($id) {
       return Exam::find($id);
     });
     $session_array_key = $id.'_'.Auth::user()->id.'.'; 
     $allQuestionArray = array();
      
     if(!session()->has($session_array_key.'exam_process')) { 
           $examData->UserExamData()->attach($id, ['user_id' => Auth::user()->id, 'status' => 1,
          'start_date' => date('Y-m-d')] );
            if(!Session::has($session_array_key.'total_time')){
            session([$session_array_key.'total_time' => $examData->time]);
           }
      }      
     $passArray = array(
               'examDetails' => Response::json($examData),
               'en_eId' => $e_id,
               'total_time' =>  $examData->time,
               'session_array_key' =>  $session_array_key,
        );  
      return view('permit.exam.attempt-exam',$passArray);
    }

  public function fetchExamQuestion($id){
    $examId = Crypt::decrypt($id);
    $examData = Cache::remember('examDetails'.$examId, 60, function() use ($examId) {
       return Exam::find($examId);
     });
     $questionData = Cache::remember('questionData'.$examId, 60, function() use ($examData) {
        return $questionData = array_column($examData->ExamQuestion->toArray(), 'id');
     });
      $session_array_key = $examId.'_'.Auth::user()->id.'.'; 
      $questionWithDetails = array();
      if(!session()->has($session_array_key.'exam_process')) { 
          $current_question = $questionData[0];
          session([$session_array_key.'current_question' => $current_question]);
          session()->put($session_array_key.'exam_process' , 1);
       }else{
         $current_question = session($session_array_key.'current_question');
      }
       if(!session()->has($session_array_key.'question_class')) {   
          foreach($questionData as $key => $que){
              $questionWithDetailsClass['question_class'][$que]  = ($key == 0) ?  'current':  'pending';
            }
            session([$session_array_key.'question_class' =>  $questionWithDetailsClass['question_class']]);
          }else{
              Session::put($session_array_key.'question_class.'.$current_question,'current');
        } 
        session::save();       
       
      $questionDetails    = Question::find($current_question);
      $questionWithDetails['question'] =  $questionDetails;
      $questionWithDetails['question']['encoded_question'] = htmlspecialchars_decode($questionDetails->question);
      $questionWithDetails['question_class'] = session($session_array_key.'question_class');

      $oldAnswer =   (session($session_array_key.'questions_answer.'.session($session_array_key.'current_question'))) ??  -9; 
    
      $difference = 0;
      if(!session()->has($session_array_key.'start_time')) {
         session([$session_array_key.'start_time' => date('Y-m-d H:i:s')]);
      }else{
       $difference =  timeDifference(session($session_array_key.'start_time'));
      }
     foreach($questionDetails->Options->toArray() as $key => $data){
        $questionWithDetails['optionsdata'][$key]['id'] = $data['id'];
        $questionWithDetails['optionsdata'][$key]['question_option'] = htmlspecialchars_decode($data['question_option']);
        $questionWithDetails['old_answer']= $oldAnswer;
        $questionWithDetails['difference']= $difference;
        $questionWithDetails['currentQuestionNumber'] =   array_search($current_question, array_keys($questionWithDetails['question_class']));

     }

      return json_encode($questionWithDetails);
  }

  public function getDirectQuestion(Request $request){
    $examId = Crypt::decrypt($request->examId);
    $session_array_key = $examId.'_'.Auth::user()->id.'.'; 
    $last_attempt_question = session($session_array_key.'current_question');
     if(session()->has($session_array_key.'questions_answer.'.$last_attempt_question) && (session($session_array_key.'questions_answer.'.$last_attempt_question ) > 0) ) {
             Session::put($session_array_key.'question_class.'.$last_attempt_question, 'answered');
      }else{
        Session::put($session_array_key.'question_class.'.$last_attempt_question,'review');
      }
    session([$session_array_key.'current_question' => $request->questionId]);
  }  

  public function saveAnswer(Request $request){
    print_r($request->all());
      $examId = Crypt::decrypt($request->examId);
      $session_array_key = $examId.'_'.Auth::user()->id.'.';
      $last_attempt_question = session($session_array_key.'current_question');
      if($request['save'] ==  'continue'){
        if(isset($request['answer']) && $request['answer'] > 0 ){
          $answerID = $request['answer'];
          echo __LINE__;
          Session::put($session_array_key.'question_class.'.$last_attempt_question,'answered');
          Session::put($session_array_key.'questions_answer.'.$last_attempt_question,$answerID);
        }else{
          echo __LINE__;
          Session::put($session_array_key.'question_class.'.$last_attempt_question,'review');
          Session::put($session_array_key.'questions_answer.'.$last_attempt_question,-1);
        }
        $nextQuestionId = get_next_key( session($session_array_key.'question_class') ,session($session_array_key.'current_question'));
        session([$session_array_key.'current_question' => $nextQuestionId]);
      }

      else if($request['save'] ==  'skip'){
        $class = 'not_answered';
        Session::put($session_array_key.'question_class.'.$last_attempt_question,$class);
        Session::put($session_array_key.'questions_answer.'.$last_attempt_question,0);
        $nextQuestionId = get_next_key( session($session_array_key.'question_class') ,session($session_array_key.'current_question'));
        session([$session_array_key.'current_question' => $nextQuestionId]);
      }

      else if($request['save'] ==  'preview'){
        Session::put($session_array_key.'question_class.'.$last_attempt_question,'review');
          $nextQuestionId = get_next_key(session($session_array_key.'question_class') ,session($session_array_key.'current_question'));
          session([$session_array_key.'current_question' => $nextQuestionId]);    
        if(session()->has($session_array_key.'questions_answer.'.$last_attempt_question) && (session($session_array_key.'questions_answer.'.$last_attempt_question ) > 0) ) {
             Session::put($session_array_key.'questions_answer.'.$last_attempt_question,-1);
        }
      }

  }


public function submitExam(Request $request, $e_eId){
  dd(session()->all());
    $userData = Auth::user();
    $userId = $userData['id'];
   
    $examId = Crypt::decrypt($e_eId);
    $session_array_key = $examId.'_'.$userId.'.';
    $answerQuestionArray = session($session_array_key.'questions_answer');

    $userAnswerData = array();
    $correctAnswerCount = $correctAnswerMark = $wrongAnswerCount =  $wrongAnswerMark = $totalMark = $false = 0;
    if(!empty($answerQuestionArray)){
      foreach($answerQuestionArray as $qId => $ansId ){
           if($ansId > 0){ 
            $questionData =  Question::find($qId); 
             $rightAnswerId = ($questionData->rightAnswer->option_id);
             $status = $mark = 0;
             if($rightAnswerId ==  $ansId ){
                $status = 1;
                $mark =  $questionData['marks'];
                $correctAnswerCount++;
                $correctAnswerMark += $mark; 
                $totalMark += $mark;
              }
            else if($rightAnswerId !=  $ansId ){
              $status = 2;
              $mark = '-'.$questionData['negative_marks'];
              $wrongAnswerCount++;
              $wrongAnswerMark += $questionData['negative_marks'];
              $totalMark += $mark;
            }

              $lastAnswerid = UserAnswer::create([
                  'user_id' => $userId,
                  'exam_id' => $examId,
                  'question_id' => $qId,
                  'answer_id' => $ansId,
                  'status' => $status,
                  'mark' =>  $mark,
               ])->id;
             $userAnswerData[] =  $lastAnswerid;
            }
            else{
              $lastAnswerid = UserAnswer::create([
                  'user_id' => $userId,
                  'exam_id' => $examId,
                  'question_id' => $qId,
                  'answer_id' => 0,
                  'status' => 3,
                  'mark' =>  0,
               ])->id;
             $userAnswerData[] =  $lastAnswerid;
            }
          }
        }
      $examDetails =  Exam::find($examId);
           // if($false == 0){  
           //      $examUserObj = new UserAnswer();
           //      $examDetails =  Exam::find($examId);
           //      $userExamData  = $examDetails->UserExam()
           //                      ->where('user_exam.user_id','=',$userId)
           //                      ->get()->toArray();                
           //    }

      if($false != 1){ 
        if($examDetails['passing_marks_type'] == 1){
          $passingNumber = $examDetails['minimum_passing_marks'] ;
        }else if($examDetails['passing_marks_type']){
          $passingNumber =  ($examDetails['total_marks'] * $examDetails['minimum_passing_marks'])/100 ;
        }
// End
    $passingStatus = 2; #fail
      if($passingNumber <= $totalMark ){
        $passingStatus = 1; #pass
      }
    $difference =  (session()->has($session_array_key.'start_time')) ? timeDifference(session($session_array_key.'start_time')) : 0;
       $notAttempt =  ($correctAnswerCount + $wrongAnswerCount) - $examDetails['total_question'];
        $resultObj = new Result();
        $resultData = array(
          'exam_id'     => $examId,
          'user_id'     => $userId,
          'obtain_mark' => $totalMark,
          'result_status' => $passingStatus,
          'right_answer_mark' => $correctAnswerMark ,
          'negative_marks' =>  $wrongAnswerMark,
          'correct_answer' => $correctAnswerCount,
          'wrong_answer' =>  $wrongAnswerCount,
          'not_attempt'  =>  $notAttempt,
          'time_taken'   => $difference,
          'user_comment' => ($request->comment) ?? ''
       );
      $id =  $resultObj::create($resultData)->id;  
     
      foreach($userAnswerData as $key => $value){
        $userAnswerDetails =  UserAnswer::find($value);
        $userAnswerDetails->result_id = $id;
        $userAnswerDetails->save();
      }
      
      $viewData = array(
        'examDetails' => Response::json($examDetails), 
        'resultDetails' => Response::json(Result::findOrFail($id)),
        // 'userExamData' => $userExamData,
        'userData' => $userData,
        'totalMark' => $totalMark,
        'r_id' => $id 
      );      
    }
    forgetSession($examId.'_'.$userId);
    return view('permit.exam.exam_overview',$viewData);
  }
  
/************************* End Of New ATTempt ********************/


    public function getExamDummy($e_id){
      $showToast = 0;
      $userData = Auth::user(); 
      $userId = $userData['id'];
      $time = date('Y-m-d H:i:s');
      $difference = 0;
        if(!session()->has('start_time')) {
           session(['start_time' => $time]);
        }else{
         $difference =  timeDifference(session('start_time'));
        }
         $id =  Crypt::decrypt($e_id);
         $examData = Exam::find($id);

         if(!session()->has('exam_process')) { 
           $examData->UserExamData()->attach($id, ['user_id' => $userId, 'status' => 1,
          'start_date' => date('Y-m-d')] );
        $questionData = $examData->ExamQuestion;
        $allQuestionArray = array();
        $i = 0;
        foreach($questionData as $que){
          $allQuestionArray[] = $que['id'];
          $all_questions_class_array[$que['id']]  = ($i == 0) ?  'current':  'pending';
          $i++;
        }
       session(['all_questions_class' => $all_questions_class_array]);
       $time =  $examData->time;
       session()->put('exam_process', 1);
       session(['exam_id' => $id]);
       session(['total_time' => $time]);
       session(['all_questions' => $allQuestionArray]);
       $questionKeys = session('all_questions');
       $current_question = $questionKeys[0];
       session(['current_question' => $current_question]);
      }else{
        $current_question = session('current_question');
      }
      $questionDetails    = Question::find($current_question);
      $passArray = array(
                     'examDetails' => $examData,
                     'questionDetails' => $questionDetails,
                     'examId' => $e_id,
                     'showToast' => $showToast,
                     'all_questions_class' => session('all_questions_class'),
                     'difference' => $difference
              );
      return view('permit.exam.exam-questions',$passArray);
    }

   
  public function saveAnswerDummy(Request $request){
    if(!session()->has('exam_id')) {
      return redirect('/');
     }
    $showToast = 0;
    $userData = Auth::user(); 
    $userId = $userData['id'];
    $examId = session('exam_id');
    $examDetails = Exam::find($examId);
    $allQuestion = session('all_questions');
     if($request['save'] ==  'continue'){
        $last_attempt_question = session('current_question');
        session()->push('attempt_questions.queID', $last_attempt_question);
        $allAttemptQuestion = session('attempt_questions.queID');
        if(isset($request['answer'])){
          $answerID = $request['answer'];
          Session::put('all_questions_class.'.$last_attempt_question,'answered');
          Session::put('questions_answer.'.$last_attempt_question,$answerID);
        }else{
          Session::put('all_questions_class.'.$last_attempt_question,'review');
        }
        $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
        if(!empty($pending_questions)){ 
          $nextQuestionId = current($pending_questions);
          session(['current_question' => $nextQuestionId]);
          Session::put('all_questions_class.'.$nextQuestionId,'current');
        }
      }
      else if($request['save'] ==  'preview'){
        $last_attempt_question = session('current_question');
        session()->push('attempt_questions.queID', $last_attempt_question);
        $allAttemptQuestion = session('attempt_questions.queID');
        Session::put('all_questions_class.'.$last_attempt_question,'review');
        $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
        if(!empty($pending_questions)){ 
          $nextQuestionId = current($pending_questions);
          session(['current_question' => $nextQuestionId]);
          Session::put('all_questions_class.'.$nextQuestionId,'current');
        }       
        //session(['current_question' => $nextQuestionId]);
        if(session()->has('questions_answer.'.$last_attempt_question) && (session('questions_answer.'.$last_attempt_question ) > 0) ) {
             Session::put('questions_answer.'.$last_attempt_question,-1);
        }
      }
      else if($request['save'] ==  'skip'){
        $last_attempt_question = session('current_question');
        session()->push('attempt_questions.queID', $last_attempt_question);
        $class = 'not_answered';
        Session::put('all_questions_class.'.$last_attempt_question,$class);
        $allAttemptQuestion = session('attempt_questions.queID');
        Session::put('questions_answer.'.$last_attempt_question,0);
        $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
        if(!empty($pending_questions)){ 
          $nextQuestionId = current($pending_questions);
          session(['current_question' => $nextQuestionId]);
          Session::put('all_questions_class.'.$nextQuestionId,'current');
        }
      }
      if(count($pending_questions) == 1){
        $showToast =1;
      }
      if(empty($pending_questions)){
        Session::save();
        $nextQuestionId = get_next($allQuestion,session('current_question'));
        $showToast = 1;
        session(['current_question' => $nextQuestionId]);
      } 
     $questionDetails    = Question::find($nextQuestionId);
     $passArray = array(
      'examDetails' => $examDetails,
      'questionDetails' => $questionDetails,
      'showToast' => $showToast,
      'all_questions_class' =>  session('all_questions_class'),
    );
    return view('permit.exam.exam_questions_ajax',$passArray);
  }

  public function getQuestion(Request $request){
    $last_attempt_question = session('current_question');
    $showToast = 0;
    session(['current_question' => $request['que_id']]);  
    $currentQuestionClass = session('all_questions_class.'. $request['que_id']);

    if(!session()->has('questions_answer.'.$last_attempt_question) ) {
      Session::put('questions_answer.'.$last_attempt_question,-1);
    }
    $id = $request['que_id'];
    Session::put('all_questions_class.'.$id,'current');
    $questionDetails    = Question::find($id);
    $passArray = array(
      'questionDetails' => $questionDetails,
      'all_questions_class' =>  session('all_questions_class'),
      'showToast' => $showToast,
    );
    return view('permit.exam.exam_questions_ajax',$passArray);
  }

  

  public function viewResult($exam_id  = ''){
    if(session()->has('exam_id')) {
        Session::save();
      }
      $difference = '0';
      if(session()->has('start_time')) {
        $difference =  timeDifference(session('start_time'));
      }
      if(!session()->has('exam_id')) {
       return redirect('/');
      }
       $userData = Auth::user();
       $userId = $userData['id'];
      $false = 0;
      $sessionExamId = session('exam_id');
      $examId =$sessionExamId;
        $answerQuestionArray = session('questions_answer');
       $userAnswerData = array(); 
       $correctAnswerCount = $correctAnswerMark = $wrongAnswerCount =  $wrongAnswerMark = $totalMark =  0;
        if(!empty($answerQuestionArray)){
          foreach($answerQuestionArray as $qId => $ansId ){
           if($ansId > 0){ 
            $questionData =  Question::find($qId); 
             $rightAnswerId = ($questionData->rightAnswer->option_id);
             $status = $mark = 0;
             if($rightAnswerId ==  $ansId ){
                $status = 1;
                $mark =  $questionData['marks'];
                $correctAnswerCount++;
                $correctAnswerMark += $mark; 
                $totalMark += $mark;
              }
            else if($rightAnswerId !=  $ansId ){
              $status = 2;
              $mark = '-'.$questionData['negative_marks'];
              $wrongAnswerCount++;
              $wrongAnswerMark += $questionData['negative_marks'];
              $totalMark += $mark;
            }

            $lastAnswerid = UserAnswer::create([
              'user_id' => $userId,
              'exam_id' => $examId,
              'question_id' => $qId,
              'answer_id' => $ansId,
              'status' => $status,
              'mark' =>  $mark,
           ])->id;
           $userAnswerData[] =  $lastAnswerid;
            }else{
              $lastAnswerid = UserAnswer::create([
                'user_id' => $userId,
                'exam_id' => $examId,
                'question_id' => $qId,
                'answer_id' => 0,
                'status' => 3,
                'mark' =>  0,
             ])->id;
           $userAnswerData[] =  $lastAnswerid;
            }
          }
        }
// here is ending of answer to show 
      if($false == 0){  
        $examUserObj = new UserAnswer();
        $examDetails =  Exam::find($examId);
        $userExamData  = $examDetails->UserExam()
                        ->where('user_exam.user_id','=',$userId)
                        ->get()->toArray();                
      }

      if($false != 1){ 
        if($examDetails['passing_marks_type'] == 1){
          $passingNumber = $examDetails['minimum_passing_marks'] ;
        }else if($examDetails['passing_marks_type']){
          $passingNumber =  ($examDetails['total_marks'] * $examDetails['minimum_passing_marks'])/100 ;
        }
// End
    $passingStatus = 2; #fail
      if($passingNumber <= $totalMark ){
        $passingStatus = 1; #pass
      }
      
       $notAttempt =  ($correctAnswerCount + $wrongAnswerCount) -$examDetails['total_question'];
        $resultObj = new Result();
        $resultData = array(
          'exam_id' => $sessionExamId,
          'user_id' => $userId,
          'obtain_mark' => $totalMark,
          'result_status' => $passingStatus,
          'right_answer_mark' => $correctAnswerMark ,
          'negative_marks' =>  $wrongAnswerMark,
          'correct_answer' => $correctAnswerCount,
          'wrong_answer' =>  $wrongAnswerCount,
          'not_attempt' =>  $notAttempt,
          'time_taken' => $difference 
       );
      $id =  $resultObj::create($resultData)->id;  
     
      foreach($userAnswerData as $key => $value){
        $userAnswerDetails =  UserAnswer::find($value);
        $userAnswerDetails->result_id = $id;
        $userAnswerDetails->save();
      }
      forgetSession();
      $viewData = array(
        'examDetails' => $examDetails,
        'userExamData' => $userExamData,
        'userData' => $userData,
        'totalMark' => $totalMark,
        'r_id' => $id 
      );
      return view('permit.exam.result', $viewData);
    }else{
      return redirect()->route('/');
    }
   }

     public function allResult(){
      $userData = Auth::user();
      $userId = $userData['id'];
      $examCount =   Result::where(['user_id' =>$userId,'status' => 1])->groupBy('exam_id')->count();

      $resultData = Result::where(['user_id' =>$userId,'status' => 1])
                           ->groupBy('exam_id')->select('*', DB::raw('count(*) as total'), DB::raw('max(add_date) as add_date')) ->paginate(10);
                           // dd($resultData);
      return view('permit.exam.all-result', compact('resultData','examCount'));
     }

     public function examResult($id){
        $examId = Crypt::decrypt($id);
        $userData = Auth::user();
        $userId = $userData['id'];
        $resultData =   Result::where(['user_id' => $userId, 'exam_id' => $examId,'status' => 1]) 
                              ->orderBy('id','DESC')
                              ->paginate(10); 
        return view('permit.exam.exam-result', compact('resultData'));                       
     }

     public function downloadExamPdf($id){
       $resultId = Crypt::decrypt($id);
       $userData = Auth::user();
       $userId = $userData['id'];
       $data = Result::find($resultId);
        $pdf = PDF::loadView('permit.exam.download-exam-pdf',compact('data'));
        $examName = $data->Exam->exam_name;
        return $pdf->download('MaaRula_'.$examName.'_'.($resultId+15).'.pdf');
     }
   
     function updateProfileImage(Request $data){
          if(isset($data['profile'])){
              $fileArray = array('image' => $data['profile']);
               $rules = array(
                  'image' => 'mimes:jpeg,jpg,png,gif|required|max:20000' // max 10000kb
                );
               $validator = Validator::make($fileArray, $rules);

                if ($validator->fails())
                {
                  // dd($validator->errors()->getMessages());
                     return redirect()->back()->withErrors(['error' => $validator->errors()->getMessages()['image'][0]]);
             }

              $image = $data['profile'];
              $user = Auth::user();
              $id = $user['id'];
              $userDetailsByID = User::FindorFail($id);
              $input['imagename'] = 'profile_'.$id.'.'.$image->getClientOriginalExtension();
              $imagesPath =  public_path().'/images';
              $profilePath =  $imagesPath.'/profile';
              if(!File::exists($profilePath)) {
                  File::makeDirectory($profilePath, 0777, true, true);
            }
            $destinationPath =$profilePath.'/thumbnail';
            if(!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
              }
            $thumb_img = Image::make($image->getRealPath())->resize(250, 200);
            $thumb_img->save($destinationPath.'/'. $input['imagename'],80);

              // first load profile page in original
              $originalPath =  $profilePath.'/original';
              if(!File::exists($originalPath)) {
                      File::makeDirectory($originalPath, 0777, true, true);
              }
              $image->move($originalPath, $input['imagename']);
              $userDetailsByID->profile_image = $input['imagename'];
              $userDetailsByID->save();
            }
            return redirect()->back();
          }

          public function updateUserPassword(Request $request){
            // dd($request);
            $userData = Auth::user();
            $id =$userData['id'];
            $user = User::findOrFail($id);
            $validateFields = array(  'password' => 'required|string|min:6|confirmed',);

            $validatedData =  $this->validate($request, $validateFields);
            if($validatedData){
                $user->fill([
                  'password' =>  bcrypt($request['password'])
                  ])->save();
                 $request->session()->flash('success', 'Password changed');
            } else{
              $request->session()->flash('error', 'Password does not match');
            }
            
            return redirect()->back();


            // $oldPassword  =   bcrypt($request['old_password']);
            // $validator = Validator::make($request, [
            //   'old_password' =>  $oldPassword ,
            //   'password' => 'required|string|min:6|confirmed',
            //  ]);

            //  dd('this');
  
            // if ($validator->fails()){
            //     return redirect()->back();
            // }
            // $user = Auth::user();
            // $userDetails = User::FindorFail($user['id']);
            // $userDetails->password = $request['password'];
            // $userDetails->save();
            // return redirect()->back();
          }

          public function notPermitExam($id){
             $exam_data = Exam::find(Crypt::decrypt($id));
             // dd($exam_data);
             return view('permit.exam.not-permit-exam', compact('exam_data'));
          }
}
