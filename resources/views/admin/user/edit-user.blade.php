@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<style>
.select2-container{
  width: 30%;
}
</style>  
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Edit User</h5>
          </div>
          <div class="widget-content nopadding">
              <form class="form-horizontal" action="{{ route('update-user',Crypt::encrypt($userData->id))}}" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">

                  
                @csrf
                <div class="control-group">
                    {{ Form::label('usertype','Select User',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::select('user_type', array('2' => 'Course Admin', '3' => 'Student'), $userData->user_type,array('id' => 'user_type')) }}
                  </div>
                </div>

                

                <div class="control-group">
                  {{ Form::label('user','User Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('username', $userData->username) }}
                    <a class="tip" style="margin-left:10px" href="#" title="Use For Login Credidtials"><i class=" icon-question-sign"></i></a> 
                </div>

              </div>

              <div class="control-group">
                  {{ Form::label('name','First Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('fname',$userData->fname) }}
                </div>
              </div>
            
             <div class="control-group">
                  {{ Form::label('surname','Sur Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('lname',$userData->lname) }}
                </div>
              </div>
            
                
                <div class="control-group">
                    {{ Form::label('email','Email',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::text('email',$userData->email) }}
                  </div>
                </div>

                <div class="control-group">
                    {{ Form::label('mobile','Phone Number',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::text('phone_no',$userData->phone_no) }}
                  </div>
                </div>
             @if($userData->user_type == 2)   
             <div id = "student_other_details">
                <div class="control-group">
                  {{ Form::label('couse','Course',array('class' => 'control-label'))}}
                <div class="controls">
                  <select name= "course_id">
                    <option value="0">Select Course</option>
                    @foreach($allCourse as $k => $v)
                     <option value="{{$k}}" @if($userData->course_id == $k) {{'selected'}} @endif> {{$v}}</option>
                    @endforeach
                  </select>
                   
                </div>
              </div>

              <div class="control-group">
                  {{ Form::label('enroll','Enrollment Number',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('enroll_number',$userData->enroll_number) }}
                </div>
              </div>

               <div class="control-group">
                  {{ Form::label('start_date','Join Date',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('join_date',$userData->join_date,array('class' => 'datepicker')) }}
                </div>
              </div>

               <div class="control-group">
                  {{ Form::label('end_date','End Date',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('end_date',$userData->end_date,array('class' => 'datepicker')) }}
                </div>
              </div>
                  
          </div>
          @endif

                <div class="control-group">
                  
                <div class="controls">
                    {{ Form::submit('save',array('class' => 'btn btn-success')) }}
                </div>
              </div>
              {{ Form::close() }}
          </div>
        </div>
        </div>
        </div>
</div>
</div>
<script>
		$(function(){
      $("#user_type").on("change", function(){
        var usertype = $("#user_type").val();
        if(usertype == 2){
          $("#student_other_details").show();
        }else{
            $("#student_other_details").hide(); 
        }
      });

      $(".datepicker").datepicker({
        format:'yyyy-mm-dd',
        });
    });
	</script>
@endsection