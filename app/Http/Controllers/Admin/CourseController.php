<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Service\PayUService\Exception;
use Illuminate\Database\QueryException;

class CourseController extends Controller
{
     public function testing(){
        $title = 'Welcome';
//       return view('layouts/partials_testing/test_list')->compact('page_title');
        return view('layouts/partials_testing/test_list', compact('title'));

     }
     public function courseList(){
         $title = 'Course';
         $allData = Course::where('status', 1)->paginate(10);;
     	 return view('admin.course.course_list',compact('title','allData'));
     }
     
      public function addCourse(){
         $title = 'Add Course';
         return view('admin.course.add-course')->with('title', $title);
     }
     
     public function saveCourse(Request $request){
        try{
            $courseObj = new Course();
            $courseObj->name = $request['course'];
            $courseObj->description = $request['description'];
            $courseObj->status = 1;
            $courseObj->add_date = date("Y-m-d");
            $courseObj->edit_date = date("Y-m-d");
            $courseObj->save();
            return redirect()-> route('course')->with('success', 'Insert Successfully');
       }
       catch(Exception $e){
        return redirect()->route('add-course')->with('error', $e->getMessage());
       }

       catch(QueryException $e){
        return redirect()->route('add-course')->with('error', $e->getMessage());
       }
     }
     

     public function editCourse($id){
         $title = 'Edit Course';
         $newId =  Crypt::decrypt($id);
         $editData = Course::findOrFail($newId);
         
     	 return view('admin.course.edit-course',compact('title','editData'));
     }
    
     public function updateCourse(Request $request, $id){
//         dd($request);
         $newId =  Crypt::decrypt($id);
         $editData = Course::findOrFail($newId);
//         echo '<pre>';print_r($editData);die();
        $editData->name = $request['course'];
        $editData->description = $request['description'];
        $editData->save();
        return redirect()-> route('course')->with('success_msg', 'Data Update');
     }

     public function deleteCourse($id){
         $newId =  Crypt::decrypt($id);
         $editData = Course::findOrFail($newId);
         $editData->status = 0;
         $editData->save();
        return redirect()-> route('course')->with('success', 'Data Removed');
     }
     
     public function courseDescription($id = 2){
         
         $newId =  Crypt::decrypt($id);
         $editData = Course::findOrFail($newId);
         return view('admin.course.course-description',compact('editData'));

     }
}
