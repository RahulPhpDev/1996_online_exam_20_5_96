<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Service\PayUService\Exception;
use Illuminate\Database\QueryException;
use DB;
// MODEL 

use Image;
use File;


use App\Model\Course;
use App\Model\Exam;
use App\Model\Subscription;
use App\Model\ExamSubscription;
use App\Model\ExamQuestion;
use App\Model\QuestionOption;
use App\Model\QuestionRightAnswer;
use App\Model\Question;
use App\User;

// request
use Redirect;


use App\Http\Requests\QuestionRequest;
class ExamController extends Controller
{
   
//    var  $date =  date("Y-m-d");

    public function examList(){
        $title = 'Exam';
        $examDetails = Exam::where('status', 1)->orderBy('id','DESC')->paginate(10);
        return view('admin.exam.exam-list', compact('examDetails','title'));
    }
    public function addExam(){
        $title = 'Exam Step 1';
        $allCourse = Course::where('status', 1)->pluck('name','id')->toArray();
        $allSubscription = Subscription::where('status', 1)->pluck('name','id')->toArray(); 
        return view('admin.exam.add-exam',compact('allCourse','allSubscription'))->with('title',$title);
    }
    
    public function saveAddExam(Request $request){
        $startDate = $endDate = '0000-00-00 00:00:00';
        $spacific_date = 0;
       if(isset($request['spacific_date'])) {
        $startDate = $request['start_date'].' '.$request['start_time'];
        $endDate = $request['end_date'].' '.$request['end_time'];
        $spacific_date = 1;
       }
       
        DB::beginTransaction();
        try{
            $exam = new Exam();
            $isPayable = $amount =  0;
            if(isset($request['payable'])){
                $isPayable =1;
                $amount = $request['amount'];
                $request['exam_type'] = 4;
            }
            $examData = array(
               'exam_name' => $request['exam_name'],
                'is_payable' => $isPayable,
                'payable_amount' => $amount,
                'description' => $request['description'],
                'notes' => $request['notes'],
                'add_date' =>   date("Y-m-d"),
                'status' => 0,
                'exam_visible_status' => $request['exam_type'] ,
                'particular_date'=> $spacific_date,
                'start_date' =>  $startDate,
                'end_date' =>  $endDate,
            );
            $id =  $exam::create($examData)->id;

            if(isset($request['course'])){
              $examDetailsById = Exam::find($id);
            foreach($request['course'] as $course){
              //$food = Food::find(1);
//$food->allergies()->sync([1 => ['severity' => 3], 4 => ['severity' => 1]]);
                $examDetailsById->Courses()->attach(array('course_id' => $course));
           }
          }
            if(isset($request['subscription'])){
            foreach($request['subscription'] as $sub){
                if($sub == "all") { $sub = 0;}
                $subdata = array(
                        'exam_id' => $id,
                        'subscription_id' => $sub,
                        'status' => 0,
                    );
                    ExamSubscription::create($subdata);
                }
            }

            if( $request['exam_type'] == 2){
              foreach($request['student_id'] as $userId){
                 $extraFieldInUserExam = array(
                    'status' => 1, 
                    'user_id' => $userId,
                    'start_date' => date('Y-m-d')
                  );

                 $userDetails =  User::find($userId);
                 $userDetails->Exam()->attach($id,$extraFieldInUserExam);
               }
             }
          
          $msg = 'Inserted Successfully';

          if(isset($request['image'])){
            $detailsByID = Exam::find($id);
            $image = $request['image'];
            $imageName = 'exam_'.$id.'.'.$image->getClientOriginalExtension();
            
            $imagesPath =  public_path().'/images';
            $imgPath =  $imagesPath.'/exam';
            if(!File::exists($imgPath)) {
                File::makeDirectory($imgPath, 0777, true, true);
           }
           $destinationPath =$imgPath.'/thumbnail';
           if(!File::exists($destinationPath)) {
              File::makeDirectory($destinationPath, 0777, true, true);
             }
           $thumb_img = Image::make($image->getRealPath())->resize(250, 200);
           $thumb_img->save($destinationPath.'/'. $imageName,80);
    
            // first load profile page in original
            $originalPath =  $imgPath.'/original';
            if(!File::exists($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
            }
            $image->move($originalPath, $imageName);
            $detailsByID->image = $imageName;
            $detailsByID->save();
        }
        DB::commit();
          return redirect()->route('add-exam-question',Crypt::encrypt($id))->with('success',$msg);     
        }
        catch (QueryException $e) {
            $msg =  $e->getMessage();
            return redirect()->back()->with('err_success',$msg);
        } catch (Exception $e) {
            $msg =  $e->getMessage();
            return redirect()->back()->with('err_success',$msg);
        } catch (Throwable $e) {
            $msg = $e->getMessage();
        
            return redirect()->back()->with('err_success',$msg);
        }
       }

       public function upload(Request $request){
// dd($request['upload']);
//          if(isset($request['upload'])){
//             // $detailsByID = Exam::find($id);
//             $image = $request['upload'];
//             $imageName = 'exam_18'.'.'.$image->getClientOriginalExtension();
            
//             $imagesPath =  public_path().'/images';
//             $imgPath =  $imagesPath.'/exam';
//             if(!File::exists($imgPath)) {
//                 File::makeDirectory($imgPath, 0777, true, true);
//            }
//            $destinationPath =$imgPath.'/thumbnail';
//            if(!File::exists($destinationPath)) {
//               File::makeDirectory($destinationPath, 0777, true, true);
//              }
//            $thumb_img = Image::make($image->getRealPath())->resize(250, 200);
//            $thumb_img->save($destinationPath.'/'. $imageName,80);
    
//             // first load profile page in original
//             $originalPath =  $imgPath.'/original';
//             if(!File::exists($originalPath)) {
//                     File::makeDirectory($originalPath, 0777, true, true);
//             }
//             $image->move($originalPath, $imageName);
//             // $detailsByID->image = $imageName;
//             // $detailsByID->save();
//         }
//         $imgUrl = ""

//         $arr = array('fileName' => $image->originalName, 'uploaded' => 1, "url" => "'");

// echo json_encode($arr);

//         $message = 'fileupload';
//         $funcNum = "QuickUpload" ;
//          $url ="http://127.0.0.1:2000/images/exam/thumbnail/exam_10.jpg";
//        echo $url;
//        die();
// http://127.0.0.1:2000/images/exam/thumbnail/exam_10.jpg
//           echo "<script type='text/javascript'>alert($url);</script>";

//         echo
       }
public function upload_image(Request $request){
  $CKEditor = Input::get('CKEditor');
    $funcNum = Input::get('CKEditorFuncNum');
    $message = $url = '';
    if (Input::hasFile('upload')) {
        $file = Input::file('upload');
        if ($file->isValid()) {
            $filename = $file->getClientOriginalName();
             $file->move(public_path().'/images/equation_icon/', $filename);
            $url = "http://127.0.0.1:2000/images/equation_icon/". $filename;
        } else {
            $message = 'An error occured while uploading the file.';
        }
    } else {
        $message = 'No file uploaded.';
    }
    // echo $url;
$arr = array('fileName' =>  $filename, 'uploaded' => 1, "url" => "$url");

echo json_encode($arr);
  
  }
       public function updateExamImg(Request $request){
        $message = 'No Image Found';
        if(isset($request['image'])){
            $image = $request['image'];
            $Id = $request->exam_id;
            $imageName = 'package_'.$Id.'.'.$image->getClientOriginalExtension();
            $imagesPath =  public_path().'/images';
            $imgPath =  $imagesPath.'/exam';
            if(!File::exists($imgPath)) {
                File::makeDirectory($imgPath, 0777, true, true);
           }
           $destinationPath =$imgPath.'/thumbnail';
           if(!File::exists($destinationPath)) {
              File::makeDirectory($destinationPath, 0777, true, true);
             }
           $thumb_img = Image::make($image->getRealPath())->resize(250, 200);
           $thumb_img->save($destinationPath.'/'. $imageName,80);
    
            // first load profile page in original
            $originalPath =  $imgPath.'/original';
            if(!File::exists($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
            }
            $image->move($originalPath, $imageName);
            $data = ['image'=> $imageName];
            Exam::where('id',$Id)->update($data);
            $message = 'Image Updated';
           }
           return redirect('exam')->with('success', $message);
      }

       public function addExamQuestion($id){
         $id =  Crypt::decrypt($id);
         $getExamData =    Exam::findOrFail($id);
         // dd($getExamData->toArray());
         $title = $getExamData['exam_name'];
         return view('admin.exam.add-exam-question',compact('getExamData','id'))->with('title',$title);
       }

      public function saveExamQuestion(Request $request , $id){
        // dd($request->all());
       DB::beginTransaction();
       try{
          $examData =   Exam::Find($id);
          $total_mark = (($examData->total_marks) > 0) ? $examData->total_marks : 0;
          $is_required = 0;
        //   (($examData->is_required) > 0) ? $examData->is_required : 0;
          $totalQuestion = (($examData->total_question) >0 ) ? $examData->total_question  :  0;

          $negative_question = (($examData->negative_question) >0 ) ? $examData->negative_question :  0;
          $negative_marks  =  (($examData->negative_marks) >0 ) ? $examData->negative_marks  :  0;

         
          // $totalQuestion =  $request['total_mark'];$is_required = $totalQuestion = 0;
           if(isset($request['total_mark'])){ 
            $total_mark = $examData->total_marks + array_sum($request['total_mark']);
          }
           if(isset($request['question'])){ 
            $totalQuestion = $examData->total_question   + count($request['question']);
          }

          if(isset($request['is_negative'])){ 
            $negative_question = $examData->negative_question   + count($request['is_negative']);
          }

          if(isset($request['negative_mark'])){ 
            $negative_marks = $examData->negative_marks   + array_sum($request['negative_mark']);
          }
            $examData->total_marks = $total_mark;
            $examData->required_question =   $is_required ;
            $examData->total_question = $totalQuestion;
            $examData->negative_question = $negative_question;
            $examData->negative_marks = $negative_marks;
            $examData->save();

            $questionArray = $request['question'];
            foreach($questionArray as $qk => $qv){
               $total_per_question = 0;
                if(isset($request['total_mark'][$qk])){
                  $total_per_question = $request['total_mark'][$qk];
                }
            //    $isRequired = (isset($request['is_required'][$qk])) ? 1 : 0;
               $is_negative = (isset($request['is_negative'][$qk])) ? 1 : 0;
               $negative_marks = ($is_negative == 1) ? $request['negative_mark'][$qk] : 0;
               $questionData = array(
                    'question' => htmlentities($qv[0]),
                    'type' => 1,
                    'marks' => $total_per_question,
                    'is_required' => 0,
                    // $isRequired,
                    'is_negative_marking' => $is_negative,
                    'negative_marks' => $negative_marks,
                    'status' => 1,
                    'add_date' => date("Y-m-d"),
                    'add_by' => 1,
                );
               $questionId =  Question::create($questionData)->id;
              
              $getQuestionOptions = $request['option'][$qk];
                foreach($getQuestionOptions as $opK => $opV){
                  if(!is_null( $opV)){
                    $optionData = array(
                        'question_id' => $questionId ,
                        'question_option' => htmlentities($opV),
                        'option_type' =>  1,
                        'add_date' =>  date("Y-m-d"),
                    );
                   $optId =  QuestionOption::create($optionData)->id;
                 
                  if(isset($request['answer'][$qk])){
                    if($opK  == $request['answer'][$qk]){
                        $answerData = array(
                                'question_id' => $questionId,
                                'option_id' =>  $optId,
                                'status' => 1,
                        ); 
                        QuestionRightAnswer::create($answerData); 
                    }
                 }
                }
               }
               $examQuestionData  = array(
                      'exam_id' => $id,
                      'question_id' => $questionId,
                      'status' => 1,
               );
               ExamQuestion::create($examQuestionData); 
            }
          DB::commit();
          $msg = 'Inserted Successfully';
         if($request['save'] == 'continue'){
          return redirect()->route('add-exam-question',Crypt::encrypt($id))->with('success',$msg);
         }else{ 
          return redirect()->route('confirm-exam',Crypt::encrypt($id))->with('success',$msg);
               
          }
       }
       catch (QueryException $e) {
           $msg =  $e->getMessage();
           return redirect()->back()->with('err_success',$msg);
       } catch (Exception $e) {
           $msg =  $e->getMessage();
           return redirect()->back()->with('err_success',$msg);
       } catch (Throwable $e) {
           $msg = $e->getMessage();
       
           return redirect()->back()->with('err_success',$msg);
       }
     }

       public function confirmExam($id){
        $questionObj = new Question();
        $de_id =  Crypt::decrypt($id);
        $exam = new Exam();
        $examQuestion =  $exam->getExamDetailsById($de_id);
        $title = $examQuestion['exam_details']->exam_name;
        return view('admin.exam.confirm-exam',compact('examQuestion', 'id'))->with('title',$title);
        // 
    }

     public function saveConfirmExam(Request $request , $id){
    //   dd($request->all());
         $de_id =  Crypt::decrypt($id);
         $examDetails = Exam::find($de_id);
         $title = 'Confirm Exam';
         $examDetails->minimum_passing_marks = $request['passing_mark'];
         $examDetails->passing_marks_type = $request['passing_mark_type'];
         $examDetails->time = $request['time'];
         $examDetails->status = 1;
         $examDetails->save();
        
         $examDetails = Exam::find($de_id);
        //  dd($examDetails);
        // $examData = Exam::find($)
         return view('admin.exam.confirm-exam-post',compact('title','examDetails'));
     }

     public function editExam($id){
         $de_id =  Crypt::decrypt($id);
         $examDetails = Exam::find($de_id);
        //  dd($examDetails->toArray());
         $title = 'Edit '.$examDetails['exam_name']. ' Exam';
         // dd( $title );
         return view('admin.exam.edit-exam',compact('examDetails','id', 'title'));
     }

     public function updateExam(Request $req, $id){
        $input = Input::only('exam_name', 'passing_marks_type','minimum_passing_marks','description','notes','spacific_date','start_date','start_time','end_date','end_time' );
        $startDate = $endDate = '0000-00-00 00:00:00';
        $spacific_date = 0;
        if(isset($req['spacific_date'])) {
            $startDate = DateTimeConvert($req['start_date'].' '.$req['start_time']);
            $endDate = DateTimeConvert($req['end_date'].' '.$req['end_time']);
            $spacific_date = 1;
        }
        $de_id =  Crypt::decrypt($id);
        $examDetails = Exam::find($de_id);
        $examDetails->exam_name = $input['exam_name'];
        $examDetails->passing_marks_type = $input['passing_marks_type'];
        $examDetails->minimum_passing_marks = $input['minimum_passing_marks'];
        $examDetails->description = $input['description'];
        $examDetails->particular_date = $spacific_date;
        $examDetails->start_date = $startDate;
        $examDetails->end_date =  $endDate;
        $examDetails->save();
        return redirect()->route('exam')->with('success', 'Exam Details are updated!');
     }

     public function examPostSuccess($id){
        $de_id =  Crypt::decrypt($id);
        $examDetails = Exam::find($de_id);
     }

     public function moreQuestion($id){
        return view('admin.exam.more-questions',compact('id'));
     }

     public function examQuestion($id){
        $e_id = Crypt::decrypt($id);
        $exam = new Exam();
        $examQuestion =  $exam->getExamDetailsById($e_id);
        $title = $examQuestion['exam_details']->exam_name;
        return view('admin.exam.exam-question',compact('examQuestion', 'id'))->with('title',$title);
     }

     public function editExamQuestion($id, $examID){
         $e_id = Crypt::decrypt($id);
         $questionData =  Question::find($e_id);
         $title =  'Edit Question';
         return view('admin.exam.edit-question', compact('questionData','title','e_id','id','examID'));
     }

     public function removeExamQuestion($e_question_id, $e_examID){
         $question_id = Crypt::decrypt($e_question_id);
         $examID = Crypt::decrypt($e_examID);         
        $examData = Exam::findOrFail($examID);
        $questionData = Question::findOrFail($question_id);
        //dd($questionData);
        $examData->total_marks = $examData['total_marks'] - $questionData['marks'];
        $examData->total_question = $examData['total_question'] - 1;
        $examData->required_question = $examData['required_question'] - ($questionData['is_required'] == 1) ? 1 : 0;
         $examData->negative_question = $examData['negative_question'] - ($questionData['is_negative_marking'] == 1) ? 1 : 0;
         if($questionData['is_negative_marking'] == 1){
          $examData->negative_marks = $examData['negative_marks'] - $questionData['negative_marks'];
         } 
        $examData->save();
        $questionData->rightAnswer()->delete();
        $questionData->Options()->delete();
        $examData->ExamQuestion()->detach($question_id);
        $questionData->delete();
        return redirect()->back()->with('success', 'Question Removed!');
     }

     

     public function updateExamQuestion(Request $req, $id) {  
         $e_id = Crypt::decrypt($id);
        $questionData =  Question::find($e_id);
        $questionData->rightAnswer['option_id'] = $req['answer'];
        $questionData->rightAnswer->save();

        $req['is_required'] = 0;
        // ($req['is_required']) ? $req['is_required'] : 0;
        $questionData->question = htmlentities($req['question']);
        $questionData->is_required = $req['is_required'];
        $questionData->marks = $req['total_mark'];

        $negativeMarks = ($req['is_negative'] == 1) ? $req['negative_mark'] : '0';
        $questionData->is_negative_marking = ($req['is_negative']) ? 1 : 0;

        $questionData->negative_marks =  $negativeMarks;
        $questionData->save();
        
        foreach($questionData->Options as $key => $opData){
            $opData->question_option =  $req['option'][$opData->id];
            $opData->save();
        }
        // return redirect()->route('profile', ['id' => 1]);
        $exam_id = $req['exam_id'];
        return redirect()->route('confirm-exam',  ['id' => $exam_id]);
        // confirmExam
    }

    public function deleteExam($id){
        $examId = Crypt::decrypt($id);
        $examDetails = Exam::find($examId);
        $examSubscriptionID = $examDetails->Subscriptions()->allRelatedIds()->toArray();
        foreach($examSubscriptionID as $eSi){
          $examDetails->Subscriptions()->sync( array( 
           $eSi => array( 'status' => 0 ),
          ), false);
        }
        $examUserID = $examDetails->UserExamData()->allRelatedIds()->toArray();
 
        foreach($examUserID as $eUi){
         $examDetails->UserExamData()->sync( array( 
           $eUi => array( 'status' => 0 ),
          ), false);
        }
        $examDetails->status = 0;
        $examDetails->save();
        return Redirect::back()->withErrors(['success', 'Exam Is Disable']);
      }
    
    public function examAccessbility($id){
       $e_id = Crypt::decrypt($id);
       $examDetails =  Exam::findOrFail($e_id);

       return view('admin.exam.exam-accessbility',compact('examDetails', 'id','examAccessbilityData'));
    }

    public function removeExamUser( Request $req, $id){
       $e_id = Crypt::decrypt($id);
        $examData = Exam::find($e_id);
        foreach($req['all_ids'] as $ids){ 
          $examData->UserExamData()->updateExistingPivot(
            $ids, array('status' => 0), false);
        }
    }

    public function examDetails($id){
         $e_id = Crypt::decrypt($id);
         $examDetails = Exam::find($e_id);
        //  dd($examDetails);
         return view('admin.exam.exam-details',compact('examDetails'));
    }
   }

