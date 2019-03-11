<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Institution;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

use Image;
use File;


use \Throwable ;
 use App\Services\PayUService\Exception;
use Illuminate\Database\QueryException;
use App\Model\Subscription;
use App\Model\EmailForward;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Config;
// use Mail;
use stdClass;
use App\Model\Alert;

use App\User;
//use Illuminate\Http\Request; #form-validation

class AdminController extends Controller
{
    public function institutionList(){
        $title = 'Instutions';
        $institutionObj  = new institution();
       $allData =  $institutionObj::where('status', 1)->get();
       $witharray = array('allData' => $allData, 'title' =>$title);
       return view('admin.institution-list')->with($witharray);
    }
    
    public function editInstitution($id){
       $insId =  Crypt::decrypt($id);
       $institutionObj  = new institution();
       $getData =  $institutionObj->findOrFail($insId);
       
       return view('admin.edit-institution')->with('getData' ,  $getData);
    }
    
    public function updateInstitution(Request $request){
//        echo $id;
        print_r($request);die();
    }

    public function subscriptionList(){ 
        $title = 'Subscription Package';
        $allData = Subscription::where(array('status' => 1))->paginate(10);
        return view('admin/subscription/subscription-list',compact('allData','title'));
    }
    
    public function addSubscription(){
        $title = 'Add Subscription Package';
        return view('admin.subscription.add-subscription',compact('title'));
    }
    
    public function saveSubscription(Request $request){
        
        $isDatePermitted = 0;
         $start_date = $end_date = "";
         $duration = $request->duration;
        if($request->start_date){
            $isDatePermitted = 1;
            $start_date = $request->start_date."00:00:00";
            $end_date = $request->end_date."00:00:00";
            $duration = 0;
         }
      try{
          $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'isDatePermit' =>$isDatePermitted,
            'start_date' =>$request->start_date,
            'end_date' => $request->end_date,
            'status'=> 1,
            'duration' => $duration
        );
        $subId =  Subscription::create($data)->id;
       if(isset($request['image'])){
        $image = $request['image'];
        $detailsByID = Subscription::find($subId);
        $imageName = 'package_'.$subId.'.'.$image->getClientOriginalExtension();
        $imagesPath =  public_path().'/images';
        $imgPath =  $imagesPath.'/package';
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
       return redirect('subscription')->with('success', 'Package Saved');
        } catch (QueryException $e) {
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

    public function updateSubscriptionImg(Request $request){
        $message = 'No Image Found';
        if(isset($request['image'])){
            $image = $request['image'];
            $subId = $request->sub_id;
            $imageName = 'package_'.$subId.'.'.$image->getClientOriginalExtension();
            $imagesPath =  public_path().'/images';
            $imgPath =  $imagesPath.'/package';
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
            Subscription::where('id', $request->sub_id)->update($data);
            $message = 'Image Updated';
           }
           return redirect('subscription')->with('success', $message);
    }
    
    public function editSubscription($id){
         $title = 'Edit Course';
         $newId =  Crypt::decrypt($id);
         $editData = Subscription::findOrFail($newId);
        // dd($editData);
     	 return view('admin.subscription.edit-subscription',compact('title','editData'));
    }

    public function updateSubscription(Request $request, $id){
        $newId =  Crypt::decrypt($id);
        $isDatePermitted = 0;
        $start_date = $end_date = "";
        $duration = $request->duration;
       if($request->start_date){
           $isDatePermitted = 1;
           $start_date = $request->start_date."00:00:00";
           $end_date = $request->end_date."00:00:00";
           $duration = 0;
        }
      try{
         $data = array(
           'name' => $request->name,
           'description' => $request->description,
           'price' => $request->price,
           'isDatePermit' =>$isDatePermitted,
           'start_date' =>$request->start_date,
           'end_date' => $request->end_date,
           'status'=> 1,
           'duration' => $duration
       );
      Subscription::where('id', $newId)->update($data);
      $msg = 'Data Updated'; 
      return redirect()->route('subscription')->with('success',$msg);
    } catch (QueryException $e) {
        
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

   public function deleteSubscription($id){
       $newId =  Crypt::decrypt($id);
       $subscriptionData = Subscription::find($newId);
       $inputValue = Input::get('save');
       if($inputValue == 'Yes'){
        $allExamData = $subscriptionData->Exam()->allRelatedIds()->toArray();
        foreach($allExamData  as $examId){
            $subscriptionData->Exam()->sync( array( 
                $examId => array( 'status' => 0 ),
               ), false);
        }
       }
       $allReletedUser = $subscriptionData->User()->allRelatedIds()->toArray();
        foreach($allReletedUser  as $userId){
            $subscriptionData->User()->sync( array( 
                $userId => array( 'status' => 0 ),
            ), false);
        }
        Subscription::where('id', $newId)->update(['status' => 0]);
        $msg = 'Package Removed';
        return redirect()->back()->with('success',$msg);
   }
   public function readEmail(){
      $emails = EmailForward::take(10)->orderBy('id', 'desc')->get();
      // dd($emails);
      return View('read-email', compact('emails'));
   }  

   public function sendEmail($id){
    $examAttemptToday = \DB::table('exams as r')
                            ->where('id', 42)
                            ->first();
         
        $emailParams = new stdClass;
        $emailParams->alert_id = 5;
        /*
            Subject :New Exam (==exam==) created
            Message: (==user==),(==exam==),(==totalQuestion==),(==time==),(==exam==)
        

        */
        $alertObj = new Alert();
        $allUser = User::where(array(
                ['user_type' ,'<>', 1 ],
                ['status', '=' , 1])
                )

                 ->whereBetween('id', array(40, 42))
                      ->get(['email', 'fname','lname', 'id']);
        dd($allUser);
        foreach($allUser as $user){    
             $userName = $user->getFullName(($user->id));    
            $emailParams->user_id = $user->id;
            $emailParams->user_email =  $user->email;    
            $emailParams->subject_params = [$examAttemptToday->exam_name];

            $emailParams->msg_params = [$userName,$examAttemptToday->exam_name,$examAttemptToday->total_question,$examAttemptToday->time,$examAttemptToday->exam_name];

            $outputData =  $alertObj->sendEmail($emailParams);
            $data = array(
                   'email'   =>  $emailParams->user_email,
                   'subject' =>  $outputData['subject'],
                   'msg'     =>  $outputData['msg'],
                );

            Mail::send('mail', $data, function( $message ) use ($data)
            {
                $message->to( $data['email'] )
                ->from( Config::get('mail.from.address'), Config('app.name'))
                ->subject( $data['subject']);
            });
   }
 }
}
