<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subscription;
use Illuminate\Support\Facades\Crypt;
use App\Model\Exam;
use Image; 
use PDF;
use Dompdf\Dompdf;
use Mpdf;
use Auth;
use App\User;

use App\helpers\helper;
// use Session;

class GuestController extends Controller
{
    public function index(){
      
	    	$SubscriptionData  = Subscription::where('status', 1)->get();

            $nonSubscriptionExams =  Exam::where('status' , 1)
                                            ->where('exam_visible_status', 1)
                                            ->get(['id','exam_name','total_question', 'total_marks']);
             $examDetails = $allExam = array();                                         
                if(Auth::user()){
                    $user = User::find(Auth::user()->id);
                    foreach($user->Exam as $exam){
                  if($exam['exam_visible_status'] == 2){    
                      $examDetails[] = array(
                            'id' => $exam->id,
                            'exam_name' => $exam->exam_name,
                            'total_question' => $exam->total_question,
                            'total_marks' => $exam->total_marks,
                        );  
                      }
                    }
                } 
                $allExam = array_merge($nonSubscriptionExams->toArray(), $examDetails);
            // dd($allExam);
                                         // ->where(function($q){
                                         // $q->where('exam_visible_status', 2)
                                         //   ->orWhere('exam_visible_status', 1);
                                         //  })->get();
	    	return view('welcome',compact('SubscriptionData','nonSubscriptionExams','userExamDetails','allExam'));
    }

   
     public function aboutUs()
    {
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

    public function allpackage(){
       $allPackage = Subscription::get()->where('status', 1);
    	return view('guest.allpackage',compact('allPackage'));
    }

    
    public function payment(){
        return view('guest.payment');
    }

    public function sessionTest(){
       // $data = session()->all();
       // session()->flush();
        // session('exam_id', '2');
          session(['exam_id' => '2']);
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
        echo __LINE__.session('exam_id');
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
