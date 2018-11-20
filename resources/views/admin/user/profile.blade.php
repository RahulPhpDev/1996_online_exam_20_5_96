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
           fname: { required: true,minlength: 3  },
           lname: { required: true,minlength: 3  },
           phone_no: { required: true,digits:true, minlength: 8,maxlength: 10   },    
           password: { minlength: 3  },
           password_confirmation:{minlength: 3,equalTo : "#password"  },
        },
        messages: {
        
          fname: {required :"First Name is required",minlength : "First Name Should have 3 character"},
          lname: {required :"Last Name is required",minlength : "Last Should have 3 character"},
          phone_no: {required :"Phone Number Can't be null",digit:"Only Digit",minlength : "atleast 8 Characters", maxlength : "maximum 10 Characters"},
          password: {required :"Password is required",minlength : "password Should have 3 character"},
          password_confirmation: {required :"Confirm Password is required",equalTo: "Password Not Match"},
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
            <h5>Update User Profile</h5>
          </div>
          <div class="widget-content nopadding">
            
                {{ Form::open(array('route' => 'update-profile','class' => 'form-horizontal', 'id'=>'basic_validate'))}}

              
             

              <div class="control-group">
                  {{ Form::label('name','First Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('fname', $user['fname']) }}
                </div>
              </div>
            
             <div class="control-group">
                  {{ Form::label('surname','Sur Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('lname', $user['lname']) }}
                </div>
              </div>
            
                
                <div class="control-group">
                    {{ Form::label('email','Email',array('class' => 'control-label'))}}
                  <div class="controls">
                  
                    <h5 style = "">{{ $user['email'] }}</h5>
                  </div>
                </div>

                <div class="control-group">
                    {{ Form::label('mobile','Phone Number',array('class' => 'control-label'))}}
                  <div class="controls">
                    {{ Form::text('phone_no', $user['phone_no']) }}
                  </div>
                </div>

                    <div class="control-group">
                        {{ Form::label('password','Change Password',array('class' => 'control-label'))}}
                        <div class="controls">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                    </div>

          <div class="control-group">
               {{ Form::label('confirm_password','Confirm Password',array('class' => 'control-label'))}}
                <div class="controls">
                     <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">   
                </div>
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
@endsection