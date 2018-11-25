<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Institution;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use DB;
use \Throwable ;
 use App\Services\PayUService\Exception;
use Illuminate\Database\QueryException;
use App\Model\Subscription;
use App\Model\Result;
//use Illuminate\Http\Request; #form-validation

class ResultController extends Controller
{
    public function view(){
       $title = 'Result';
       $resultObj  = new Result();
       $allData =  Result::All();
    
       $witharray = array('allData' => $allData, 'title' =>$title);
       return view('admin.result.result_view')->with($witharray);
    }
    
   

}
