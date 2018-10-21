<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Institution;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

use \Throwable ;
 use App\Services\PayUService\Exception;
use Illuminate\Database\QueryException;
use App\Model\Subscription;
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
        $allData = Subscription::where(array('status' => 1))->get();
     
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
       Subscription::create($data);
       return redirect('subscription')->with('success', 'New support ticket has been created! Wait sometime to get resolved');
        } catch (QueryException $e) {
            echo 'ey';
            $msg =  $e->getMessage();
            return redirect()->back()->with('err_success',$msg);
        } catch (Exception $e) {
            echo 'ex';
            $msg =  $e->getMessage();
            return redirect()->back()->with('err_success',$msg);
        } catch (Throwable $e) {
            echo 'dfs';
            $msg = $e->getMessage();
          
             return redirect()->back()->with('err_success',$msg);
        }
    }

}
