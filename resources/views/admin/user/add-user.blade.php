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



<script type="text/javascript">
  
$(document).ready(function () {
    $('#basic_validate').validate({ // initialize the plugin
        ignore: [],
              debug: false,
        rules: {
           user_type: { required: true },
           fname: { required: true,minlength: 3  },
           lname: { required: true,minlength: 3  },
           email: { required: true, email: true,minlength: 3  },
       //    join_date: { required: true },
        //   end_date: { required: true,minlength: 3  },
           password: { required: true,minlength: 3  },
           confirm_password:{ required: true,minlength: 3  },
        },
        messages: {
          user_type: {required :"Select User Type",},
          fname: {required :"First Name is required",minlength : "First Name Should have 3 character"},
          lname: {required :"Last Name is required",minlength : "Last Should have 3 character"},
          email: {required :"Email is required",email :"Not a valid email", minlength : "Email should have 3 character"},
         // join_date: {required :"Last Name",minlength : "First Should have 3 character"},
         // end_date: {required :"Last Name",minlength : "First Should have 3 character"},
          password: {required :"Password is required",minlength : "password Should have 3 character"},
          confirm_password: {required :"Confirm Password is required"},
                  }
    });

});
</script>
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Add User</h5>
          </div>
          <div class="widget-content nopadding">
            
                {{ Form::open(array('route' => 'save-user','class' => 'form-horizontal', 'id'=>'basic_validate'))}}

                <div class="control-group">
                    {{ Form::label('usertype','Select User',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::select('user_type', array('3' => 'Student','2' => 'Course Admin' ), 'default',array('id' => 'user_type')) }}
                  </div>
                </div>

                

<!--                <div class="control-group">
                  {{-- Form::label('user','User Name',array('class' => 'control-label'))--}}
                <div class="controls">
                    {{-- Form::text('username') --}}
                    <a class="tip" style="margin-left:10px" href="#" title="Use For Login Credidtials"><i class=" icon-question-sign"></i></a> 
                </div>

              </div>-->

              <div class="control-group">
                  {{ Form::label('name','First Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('fname') }}
                </div>
              </div>
            
             <div class="control-group">
                  {{ Form::label('surname','Sur Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('lname') }}
                </div>
              </div>
            
                
                <div class="control-group">
                    {{ Form::label('email','Email',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::text('email') }}
                  </div>
                </div>

                <div class="control-group">
                    {{ Form::label('mobile','Phone Number',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::text('phone_no') }}
                  </div>
                </div>
                
             <div id = "student_other_details" style="display: none">
                <div class="control-group">
                  {{ Form::label('couse','Course',array('class' => 'control-label'))}}
                <div class="controls">
                  <select name= "course_id">
                    <option value="0">Select Course</option>
                    @foreach($allCourse as $k => $v)
                     <option value="{{$k}}"> {{$v}}</option>
                    @endforeach
                  </select>
                   
                </div>
              </div>

              

               <div class="control-group">
                  {{ Form::label('start_date','Join Date',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('join_date',null,array('class' => 'datepicker')) }}
                </div>
              </div>

               <div class="control-group">
                  {{ Form::label('end_date','End Date',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('end_date',null,array('class' => 'datepicker')) }}
                </div>
              </div>
                  
          </div>

          <div class="control-group">
                {{ Form::label('password','Password',array('class' => 'control-label'))}}
                <div class="controls">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        <?php
                        /*
                        if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            */
                            ?>
                </div>
              </div>

           <div class="control-group">
               {{ Form::label('confirm_password','Confirm Password',array('class' => 'control-label'))}}
                <div class="controls">
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>   
                </div>
              </div>   

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
        if(usertype == 3){
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