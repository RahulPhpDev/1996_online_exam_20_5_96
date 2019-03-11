<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subscription;
use Illuminate\Support\Facades\Crypt;
use App\Model\Exam;
use App\Model\Course;
use Image; 
use PDF;
use Dompdf\Dompdf;
use Mpdf;
use Auth;
use App\User;
use App\Model\Feedback;
use App\helpers\helper;
use Session;
use App\Model\Alert;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Mail;
use Config;
use App;
// use Session;

class GuestController extends Controller
{


    public function contactUs(){


         return View('guest/contact-us');
    }

   public function saveContactUs(Request $request){
    // dd($request->all());
         $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'name' => 'required|string|max:50',
           'subject' => 'required',
           'message' => 'required'
       ]);
        
       if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
       }

       Feedback::create([
        'name' => $request->name,
        'email' => $request->email,
        'subject' => $request->subject,
        'message' => $request->message,
        ]);
       
       
        $emailParams = new stdClass;
        $emailParams->user_id = 4;
        $emailParams->user_email =  'mrrahul2016@gmail.com';
        $emailParams->alert_id = 2;
        $emailParams->subject_params = [$request->subject];
        $emailParams->msg_params = [$request->message, $request->name , $request->email,date('d-m-Y')];
        $alertObj = new Alert();
        $outputData =  $alertObj->sendEmail($emailParams);
        /*
        Mail::send( 'mail', $outputData, function( $message ) use ($outputData)
        {
            $message->to( $outputData['email'] )
            ->subject( $outputData['subject']);
        });
        */
        Session::flash('status', 'Your Message has send to Admin!'); 
        return redirect()->route('contactUs');

   }  

    public function index(){
        $courseObj = new Course;
        $SubscriptionData  = Subscription::where('status', 1)->get();
        $upcomingExams =  Exam::where('particular_date', 1)
                                        ->where('end_date', '>=', date('Y-m-d H:i:s'))
                                        ->orderBy('id', 'DESC')
                                        ->take(6)
                                        ->get(['id','exam_name','total_question', 'total_marks','image','time','start_date','end_date','description']);
                                        // ::
        $nonSubscriptionExams =  Exam::where('status' , 1)
                                        ->where('exam_visible_status', 1)
                                        ->where('particular_date', 0)
                                        ->orderBy('id', 'DESC')
                                        ->take(8)
                                        ->get(['id','exam_name','total_question', 'total_marks','image','time']);
                                    

            $courseData =   $courseObj->getCourseHaveExam();         
            $examDetails = $allExam = array();                                         
            if(Auth::user()){
                $user = User::find(Auth::user()->id);
                foreach($user->Exam as $exam){
                if($exam['exam_visible_status'] == 2 && $exam['particular_date'] == 0){    
                    $examDetails[] = array(
                        'id' => $exam->id,
                        'exam_name' => $exam->exam_name,
                        'total_question' => $exam->total_question,
                        'total_marks' => $exam->total_marks,
                        'image' => $exam->image,
                        'time' => $exam->time,
                    );  
                    }
                }
            } 
            $allExam = array_merge($nonSubscriptionExams->toArray(), $examDetails);
// dd($courseData);
        return view('welcome',compact('SubscriptionData','nonSubscriptionExams','allExam','courseData','upcomingExams'));
    }

   
     public function aboutUs()
    {          
     $examAttemptToday = \DB::table('exams as r')
                            ->where('id', 42)
                            ->first();
         
        // dd($examAttemptToday->exam_name);  
        $emailParams = new stdClass;
        $emailParams->alert_id = 5;
      
        $alertObj = new Alert();
        $allUser = User::where(array(
                ['user_type' ,'<>', 1 ],
                ['status', '=' , 1]
                )
            )->get(['email', 'fname','lname', 'id']);
        // dd($allUser);

        foreach($allUser as $user){  
            $userName = $user->getFullName(($user->id));    
            $emailParams->user_id = $user->id;
            $emailParams->user_email =  $user->email;    
            $emailParams->subject_params = [$examAttemptToday->exam_name];

            $emailParams->msg_params = [$userName,$examAttemptToday->exam_name,$examAttemptToday->total_question,$examAttemptToday->time,$examAttemptToday->exam_name];
// dd($emailParams);
            $outputData =  $alertObj->sendEmail($emailParams, 'crone');
            dd($outputData);
            $data = array(
                   'email'   =>  $emailParams->user_email,
                   'subject' =>  $outputData->subject,
                   'msg'     =>  $outputData->message
                );
            // dd($data);

        //     Mail::send('mail', $data, function( $message ) use ($data)
        //     {
        //         $message->to( $data['email'] )
        //         ->from( Config::get('mail.from.address'), Config('app.name'))
        //         ->subject( $data['subject']);
        //     });
        //     dd('check');
        }  
        return view('guest.about-us');
    }

    public function package($eid){
        $id =  Crypt::decrypt($eid);
        $package =  Subscription::find($id);
        $otherPackage = Subscription::get()->where('id', '!=', $id);
        if(Auth::user()){
            $permit_redirect = true;
            $res = $package->User()->where('user_id', Auth::user()->id)->exists();
            if($res === true){
                return redirect()->route('save-package-exam', array('id' => $eid));
            }
        }

    	return view('guest.package',compact('package','otherPackage'));
    }

    public function allExam(){
        $courseObj = new Course;
        $upcomingExams =  Exam::where('particular_date', 1)
                                        ->where('end_date', '>=', date('Y-m-d H:i:s'))
                                        ->orderBy('id', 'DESC')
                                        ->get(['id','exam_name','total_question', 'total_marks','image','time','start_date','end_date','description']);
                                        // ::
        $nonSubscriptionExams =  Exam::where('status' , 1)
                                        ->where('exam_visible_status', 1)
                                        ->where('particular_date', 0)
                                        ->orderBy('id', 'DESC')
                                        ->get(['id','exam_name','total_question', 'total_marks','image','time']);
                                    

            $courseData =   $courseObj->getCourseHaveExam();         
            $examDetails = $allExam = array();                                         
            if(Auth::user()){
                $user = User::find(Auth::user()->id);
                foreach($user->Exam as $exam){
                if($exam['exam_visible_status'] == 2 && $exam['particular_date'] == 0){    
                    $examDetails[] = array(
                        'id' => $exam->id,
                        'exam_name' => $exam->exam_name,
                        'total_question' => $exam->total_question,
                        'total_marks' => $exam->total_marks,
                        'image' => $exam->image,
                        'time' => $exam->time,
                    );  
                    }
                }
            } 
        $allExam = array_merge($nonSubscriptionExams->toArray(), $examDetails);
        $limit = 8;
        $totalPage = 0;
        $paginate = false;
            if(count($allExam) > $limit){
                $countArr = count($allExam) - 1;
                $paginate = true;
                $totalPage =   $countArr/$limit ;

            }
            if( isset($_GET['page'])){
                // echo ('data here');
            }

            $pageId = isset($_GET['page']) ? $_GET['page']-1 : 0;
            $offset = 0;
            if($pageId > 0){
                $offset =  $pageId * $limit;
            }
        $allExam = array_slice($allExam , $offset, $limit);
        // // $allExam = Exam::get();
         return view('guest.allexam',compact('allExam','totalPage','paginate'));
     }

    public function allpackage(){
       $allPackage = Subscription::get()->where('status', 1);
    	return view('guest.allpackage',compact('allPackage'));
    }

    
    public function payment(){
        return view('guest.payment');
    }

    public function sessionTest(){
        $passArray = array(
          
           'difference' => '0'
          );
      return view('permit.exam.exam-questions_test',$passArray);
    }


    public function sessionTestold(){
        echo base_path();


        die();
        $chd = '2018-12-11 16:04:22';
       $date =    DateManipulation( $chd , 'Y-m-d H:i:s');
    //  dd($date);
         session()->flush();
         $request['que_id']  = 12;
         $currentQuestionClass = 'answerdfsa';
         Session::put('lastanswer.'.$request['que_id'],$currentQuestionClass);
         if(session()->has('lastanswer')) {
             $class = session('lastanswer.'.$request['que_id']);
            echo ($class);  
         }
         session()->forget('lastanswer.'.$request['que_id']);
          if(session()->has('lastanswer')) {
             $class = session('lastanswer.'.$request['que_id']);
            echo __LINE__.($class);  
         }
        //  die();
       // $data = session()->all();
       // session()->flush();
        // session('exam_id', '2');
        $last_attempt_question = 2;
          session(['exam_id' => '2']);
          Session()->push('all_questions_class.'.$last_attempt_question,'not_answered');
          $last_attempt_question = 4;
          Session()->push('all_questions_class.'.$last_attempt_question,'review');
        session()->push('ids', '1');
        session()->push('ids', '2');
        session()->push('ids', '3');
        // session()->push('user.teams', 'developers');
        // session(['next_question' => 'question_id_2']);
// session()->push(
        // $value = session()->pull('next_question');
        // echo $value;
        // if(session()->has('current_question')) {
        //      session('current_question');
        // }


        // session()->push('current_question.new[]', 'developers ');
        //echo __LINE__.session('exam_id');
        // Session::save();

        dd(session()->all());
    }

    public function nextSession(){
        // session()->flush();
        // session(['exam_id' => '2']);
        // session()->push('ids', '1');
        // session()->push('ids', '2');
        // session()->push('ids', '3');
        dd(session()->all());
    }

    public function checkSession(){
       \Session::put('somekey', 'somevalue');

        dd(session('somekey'));
    }

    public function intervation(){
        // die('this');
        // open an image file
            // $img = Image::make('images/backend_images/gallery/imgbox3.jpg');

            // // // resize image instance
            // $img->resize(320, 240);

            // // insert a watermark
            // $img->insert('images/backend_images/gallery/imgbox1.jpg');

            // // save image in desired format
            // $img->save('images/backend_images/gallery/update_img.jpg');


            $watermark =  Image::make('images/backend_images/watermark.jpg');
            $img = Image::make('images/backend_images/logo.png');
            //#1
            $watermarkSize = $img->width() - 20; //size of the image minus 20 margins
            //#2
            $watermarkSize = $img->width() / 2; //half of the image size
            //#3
            $resizePercentage = 70;//70% less then an actual image (play with this value)
            $watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2); //watermark will be $resizePercentage less then the actual width of the image

            // resize watermark width keep height auto
            $watermark->resize($watermarkSize, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //insert resized watermark to image center aligned
            $img->insert($watermark, 'center');
            //save new image
            $img->save('images/backend_images/watermark-logo.png');


    }
    function downloadPDF($id =''){
$user = User::find(1);
        $pdf = PDF::loadView('pdf',$user);
$pdf->setWatermarkImage(public_path('images/backend_images/watermark.jpg'));
$pdf->save(public_path('file.pdf'));
die('here');
$watermark =  Image::make('images/backend_images/watermark.jpg');
$watermarkSize = $img->width() - 20; //size of the image minus 20 margins
//#2
$watermarkSize = $img->width() / 2; //half of the image size
//#3
$resizePercentage = 70;//70% less then an actual image (play with this value)
$watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2); //watermark will be $resizePercentage less then the actual width of the image

// resize watermark width keep height auto
$watermark->resize($watermarkSize, null, function ($constraint) {
    $constraint->aspectRatio();
});
$img->insert($watermark, 'center');
        // dd($dompdf);
        // $id = 1;
        // $user = User::find($id);

        // $dompdf->loadHtml($html);
        // $dompdf->render();
        // $canvas = $dompdf->getCanvas();
        // $dompdf->SetWatermarkImage("http://127.0.0.1:8000/images/backend_images/watermark.jpg");
        // $canvas->page_script('
        //   $pdf->set_opacity(.5);
        //   $pdf->image("http://127.0.0.1:8000/images/backend_images/watermark.jpg", {100px}, {100px}, {80%}, {80%});
        // ');
        // $dompdf->stream("invoice.pdf");
        // return $dompdf->download('invoice.pdf');
        // die('check');



        // $pdf = PDF::loadView('pdf', compact('user'));
        // $pdf->setWatermarkImage('images/backend_images/watermark.jpg');
        // return $pdf->download('invoice.pdf');
    }

}
