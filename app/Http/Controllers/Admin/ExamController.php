<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Service\PayUService\Exception;
use Illuminate\Database\QueryException;
use DB;
use Auth;
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
        if(isset($_GET['filter'])){
            $filter = $_GET['filter'];
            $whereData =  getExamStatusMeaning($filter);
        }else{
            $whereData = array('status', '=',  '1');
        }
        $title = 'Exam';
        $examDetails = Exam::where([$whereData])->orderBy('id','DESC')->get();
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
              $examDetailsById = Exam::findorfail($id);
            foreach($request['course'] as $course){
              //$food = Food::findorfail(1);
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

                 $userDetails =  User::findorfail($userId);
                 $userDetails->Exam()->attach($id,$extraFieldInUserExam);
               }
             }
          
          $msg = 'Inserted Successfully';

          if(isset($request['image'])){
            $detailsByID = Exam::findorfail($id);
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

       public function assignExam(){
           $id = 15;
        $e_id = 15;
        $examDetails =  Exam::findOrFail($e_id);
        $userData = User::where('user_type',3)->orderBy('fname')->get(['fname','id','lname','email']);
        $allSelectedUser = array();
        foreach($examDetails->UserExamData as $data) { 
         $allSelectedUser[] = $data->id;
       }
    //    dd($allSelectedUser);
     $title = 'Assign Exam';
        return view('admin.exam.assign-exam',compact('examDetails', 'allSelectedUser','userData','title'));
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
          $examData =   Exam::findorfail($id);
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
         $examDetails = Exam::findorfail($de_id);
         $title = 'Confirm Exam';
         $examDetails->minimum_passing_marks = $request['passing_mark'];
         $examDetails->passing_marks_type = 1;
         // $request['passing_mark_type'];
         $examDetails->time = $request['time'];
         $examDetails->status = 1;
         $examDetails->save();
        
         $examDetails = Exam::findorfail($de_id);
        //  dd($examDetails);
        // $examData = Exam::findorfail($)
         return view('admin.exam.confirm-exam-post',compact('title','examDetails'));
     }

     public function editExam($id){
         $de_id =  Crypt::decrypt($id);
         $examDetails = Exam::findorfail($de_id);
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
        $examDetails = Exam::findorfail($de_id);
        $examDetails->exam_name = $input['exam_name'];
        $examDetails->passing_marks_type = 1;
        // $input['passing_marks_type'];
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
        $examDetails = Exam::findorfail($de_id);
     }

     public function moreQuestion($id){
        return view('admin.exam.more-questions',compact('id'));
     }

     public function examQuestion($id){
        $e_id = Crypt::decrypt($id);
        $exam = new Exam();
        $examQuestion =  $exam->getExamDetailsById($e_id);
        if(count($examQuestion['question']) == 0 ){
            return redirect()->route('add-exam-question',$id )->with('error','Add Few Question ');
        }
        $title = $examQuestion['exam_details']->exam_name;
        return view('admin.exam.exam-question',compact('examQuestion', 'id'))->with('title',$title);
     }

     public function editExamQuestion($id, $examID){
         $e_id = Crypt::decrypt($id);
         $questionData =  Question::findorfail($e_id);
         $title =  'Edit Question';
         return view('admin.exam.edit-question', compact('questionData','title','e_id','id','examID'));
     }

     public function removeExamQuestion($e_question_id, $e_examID){
         $question_id = Crypt::decrypt($e_question_id);
        //  echo $question_id;
         $examID = Crypt::decrypt($e_examID);         
        $examData = Exam::findOrFail($examID);
        $questionData = Question::findOrFail($question_id);
        // dd($questionData);
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
         // dd($req->all());
         $e_id = Crypt::decrypt($id);
         $questionData =  Question::findorfail($e_id);

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
      
         $rightAnswerTaken = false;
         if(isset($req['option_new'])) {
          $getQuestionOptions = $req['option_new'];
          foreach($getQuestionOptions as $opK => $opV){
              if(!is_null( $opV)){
                      $optionData = array(
                          'question_id' => $e_id ,
                          'question_option' => htmlentities($opV),
                          'option_type' =>  1,
                          'add_date' =>  date("Y-m-d"),
                      );
                    $optId =  QuestionOption::create($optionData)->id;

                    if(isset($req['answer']) && ($rightAnswerTaken != true)){
                     if (strpos($req['answer'], 'new_') !== false) { 
                      $answerArr =  explode('_' ,$req['answer']);
                      if($opK  == $answerArr[1]){
                          $questionData->rightAnswer['option_id'] = $optId;
                          $questionData->rightAnswer->save();
                          $rightAnswerTaken = true;
                        }
                      }
                    }
                  }
                }
              }
             if(isset($req['answer']) && ($rightAnswerTaken != true)){
                $questionData->rightAnswer['option_id'] = $req['answer'];
                $questionData->rightAnswer->save();
            }
        $exam_id = $req['exam_id'];
        return redirect()->route('confirm-exam',  ['id' => $exam_id]);
    }

    public function deleteExam($id){
        $examId = Crypt::decrypt($id);
        $examDetails = Exam::findorfail($examId);
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
        $examDetails->status = 2;
        $examDetails->save();
        return Redirect::back()->withErrors(['success', 'Exam Is Disable']);
      }
    
    public function examAccessbility($id){
       $e_id = Crypt::decrypt($id);
       $examDetails =  Exam::findOrFail($e_id);
       $selectUsers =  $examDetails->UserExamData;
    //    dd($selectUsers);
       $userData = Auth::user();
       $userId = $userData['id'];
       $selectUsersArray = [$userId];
       foreach($selectUsers as $seUs){
          $selectUsersArray[] = $seUs['id'];
       }
       $allUser =  User::whereNotIn('id', $selectUsersArray)->where(['status' => 1])->orderBy('fname')->get();
       return view('admin.exam.exam-accessbility',compact('examDetails', 'id','examAccessbilityData','allUser','selectUsersArray'));
    }

    public function examPackageAccessbility($id){
       $e_id = Crypt::decrypt($id);
       $examDetails =  Exam::findOrFail($e_id);
       $subscriptionsData =  $examDetails->Subscriptions;
       $selectSubscriptionArray = [];
       foreach($subscriptionsData as $subId){
          $selectSubscriptionArray[] = $subId['id'];
       }
       $allSubscription =  Subscription::whereNotIn('id', $selectSubscriptionArray)->where(['status' => 1])->orderBy('name')->get();
       // dd( $allSubscription);
       return view('admin.exam.exam-package-accessbility',compact('examDetails', 'id','allSubscription','subscriptionsData','selectSubscriptionArray'));
    }

    public function removeExamUser( Request $req, $id){
       $e_id = Crypt::decrypt($id);
        $examData = Exam::findorfail($e_id);
        foreach($req['all_ids'] as $ids){ 
          $examData->UserExamData()->updateExistingPivot(
            $ids, array('status' => 0), false);
        }
    }

    public function examDetails($id){
         $e_id = Crypt::decrypt($id);
         $examDetails = Exam::findorfail($e_id);
         return view('admin.exam.exam-details',compact('examDetails'));
    }

    public function assignUsersExam( $req, $id){
       $e_id =  Crypt::decrypt($id);
       $examData = Exam::findorfail($e_id);
       $status = array('status' => 1);
       $syncData = array();
      if($req['exam_type'] == 2) { 
         foreach($req['add'] as $user_id){
              $syncData[$user_id] = $status;
        }
      }
      if(!empty($syncData)) {
        $examData->UserExamData()->sync($syncData);
      }
      $msg = 'Update';
      return redirect()->back()->with('success',$msg);
      $examData->UserExamData()->sync($syncData);
    
    }

    public function assignPackageExam(Request $req, $id){
       $e_id =  Crypt::decrypt($id);
       $examData = Exam::findorfail($e_id);
       $status = array('status' => 1);
       $syncData = array();
       foreach($req['add'] as $sub_id){
            $syncData[$sub_id] = $status;
      }
      if(!empty($syncData)) {
         $examData->Subscriptions()->sync($syncData);
      }
       if($req['exam_type'] == 3) {
           foreach($req['add'] as $sub_id){
                $syncData[$sub_id] = $status;
          }
        }
      $examData->Subscriptions()->sync($syncData);
    
    }

    public function editExamAccessbility($id){
       $e_id = Crypt::decrypt($id);
       $examDetails =  Exam::findOrFail($e_id);
       // dd($examDetails);
       return view('admin.exam.edit-exam-accessbility',compact('examDetails', 'id'));
    }
    public function updateExamAccessbility(Request $req,$id){
       $e_id =  Crypt::decrypt($id);
       $examData = Exam::findorfail($e_id);
       $requestedExamVisibleTo = $req['exam_type'];
       $perviousExamVisibleTo = $examData['exam_visible_status'];
       if($requestedExamVisibleTo == $perviousExamVisibleTo){

       }else{
        switch ($perviousExamVisibleTo) {
            case '2':
            #Remove For Student
             $this->assignUsersExam($req,$id);
            break;
          
           case '3':
              $this->assignPackageExam($req,$id);
            break;
        }
        switch ($requestedExamVisibleTo) {
            case '2':
                $this->assignUsersExam($req,$id);
            break;
          
           case '3':
               $this->assignPackageExam($req,$id);
            break;
        }
       }
      
      $data = ['exam_visible_status' => $requestedExamVisibleTo];
      Exam::where('id',$e_id)->update($data);
      $msg = 'Update';
      return redirect()->route('exam')->with('success',$msg);
    }
  }

