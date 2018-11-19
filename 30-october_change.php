// 19 Novermber Changes


Route::get('/exam-accessibility/{id}', 'Admin\ExamController@examAccessibility')->name('exam-accessibility');

Route::any('/remove-exam-user/{id}', 'Admin\ExamController@removeExamUser')->name('remove-exam-user');

public function examAccessibility($examId){
        $eId =  Crypt::decrypt($examId);
        // dd($eId);
        $examDetails =  Exam::findOrFail($eId);
        // dd($examDetails->UserExam);
        return view('admin.exam.exam-accessibility',compact('examDetails','eId' ));
    }

    public function removeExamUser( $id){
        $userId = 8;
        $examId = 1;
        $examData = Exam::find($examId);

        $examData->UsersExam()->updateExistingPivot([9,7,8], array('status' => 0), false);
   
        die('ho gaya');
    }

ExamMODAL

    public function UsersExam(){
 
        $res = $this->belongsToMany(User::class,'user_exam')->wherePivot('status' , "=", 1);
        return $res;
    }


exam-accessbility.blade.php
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> Delete </th>
                  <th>Exam Name</th>
                  <th>User Name</th>
                  <th>User Email</th>
                </tr>
              </thead>
              <tbody>
           <?php foreach($examDetails->UsersExam  as $data) { ?>     
                <tr class="odd">
                <td> <input class ="chk_user" type = "checkbox" value = "{{$data->id}}" name = "remove[]"></td>
                  <td>{{$examDetails->exam_name}}</td>
                  <td>{{$data->fname. ' '.$data->fname}}</td>
                  <td>{{$data->email}}</td>                
                  
                 
                </tr>
                
           <?php } ?>
              </tbody>
            </table>
            <input class = "save" type = "submit" name = "save">
          </div>

          
<script>
$(function(){
   

  $(".save").on("click",function(){
    var arr = [];
        $('input.chk_user:checkbox:checked').each(function () {
            arr.push($(this).val());
        });
        // alert(arr);
       var Id = 1;
   $.ajax({
     url:"/remove-exam-user/"+Id,
     type:"POST",
     data:{all_ids: arr, "_token":"{{ csrf_token() }}"},
     success:function(adata){
       console.log(adata);
     }
   });
  });
});
</script>


exam List
@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<style>
/* .popup {
  width: 100%;
  height: 100%;
  display: none;
  position: fixed;
  top: 0px;
  left: 0px;
  background: rgba(0, 0, 0, 0.75);
}

.popup {
  text-align: center;
}

.popup:before {
  content: '';
  display: inline-block;
  height: 100%;
  margin-right: -4px;
  vertical-align: middle;
}

.popup-inner {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
  position: relative;
  max-width: 700px;
  width: 90%;
  padding: 40px;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 1);
  border-radius: 3px;
  background: #fff;
  text-align: center;
}

.popup-inner h1 {
  font-family: 'Roboto Slab', serif;
  font-weight: 700;
}

.popup-inner p {
  font-size: 24px;
  font-weight: 400;
}

.popup-close {
  width: 34px;
  height: 34px;
  padding-top: 4px;
  display: inline-block;
  position: absolute;
  top: 20px;
  right: 20px;
  -webkit-transform: translate(50%, -50%);
  transform: translate(50%, -50%);
  border-radius: 100%;
  background: transparent;
  border: solid 4px #808080;
}

.popup-close:after,
.popup-close:before {
  content: "";
  position: absolute;
  top: 11px;
  left: 5px;
  height: 4px;
  width: 16px;
  border-radius: 30px;
  background: #808080;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}

.popup-close:after {
  -webkit-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

.popup-close:hover {
  -webkit-transform: translate(50%, -50%) rotate(180deg);
  transform: translate(50%, -50%) rotate(180deg);
  background: #f00;
  text-decoration: none;
  border-color: #f00;
}

.popup-close:hover:after,
.popup-close:hover:before {
  background: #fff;
}*/
</style> 
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Visible To</th>
                  <th>Total Question</th>
                  <th>Total Mark</th>
                  <th>Passing Mark</th>
                  <th> Other Details </th>
                  <th> View/Edit Question </th>
                  <th> Edit </th>
                  <th> Disable </th>
                </tr>
              </thead>
              <tbody>
           <?php foreach($examDetails as $data) { ?>     
                <tr class="odd">
                  <td>{{$data['exam_name']}}</td>
                  <td> <button type = "button" class ="btn btn-success access"  data-toggle="modal" data-target="#popupNew"   data-id="{{Crypt::encrypt($data['id']) }}"> Visible To </button> </td>
                  <td> {{$data['total_question']}} </td>
                  <td> {{$data['total_marks']}}</td>
                  <td> {{$data['minimum_passing_marks']}} </td>
                  <td> <button type = "button" class ="btn btn-success" > Other </button></td>
                  <td> <a class ="btn btn-success" href="{{ route('exam-question', ['id' => Crypt::encrypt($data['id']) ]) }}">Questions <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                   </td>
                  <td> <button type = "button"class ="btn btn-success"> Edit </button> </td>
                  <td> <button type = "button"class ="btn btn-success"> Disable </button> </td>
                </tr>
                
           <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
        </div>
</div>
</div>



  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>

 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>This is a large modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<div class="popup modal" id="popupNew">
    <div class="popup-inner">
       

<table>
  <tr>
    <th>Shop</th>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>City</th>
  </tr>
  @foreach($shopDetails->Product as $details)
  <tr>
    <td>{{$shopDetails->name}}</td>
    <td>{{$details->name}}</td>
    <td>{{$details->pivot->price}}</td>
    <td>{{$details->quantity}}</td>
    <td>{{$shopDetails->city}}</td>
  </tr>
  @endforeach

  
</table>

       
        <p><a data-dismiss="modal" href="#" class="btn btn-danger">Close</a></p>
        <a class="popup-close" pd-popup-close="popupNew" href="#"> </a>
    </div>
</div>

<script>
$(function(){
  $(".access").on("click",function(){
   var Id =  $(this).data("id");
   $.ajax({
     url:"exam-accessibility/"+Id,
     type:"GET",
     success:function(data){
       $(".custom_data").html(data);
     }
   });
  });
});
</script>
@endsection
