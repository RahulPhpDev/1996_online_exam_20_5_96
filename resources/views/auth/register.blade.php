
 @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')

<link href="{{ asset('css/validation.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/additional-methods.min.js') }}"></script>
<style type="text/css">
     a{
        color: blue;
        font-size: 17px;
        font-style: italic
        font-weight: 800;
        cursor: pointer;
    }

    .term_check{
        top: 4px !important;
        width: 24px;
        height: 16px;
        position: relative;
        margin-right: 5px;
    }
    .term_span{
      font-size: 19px;
    font-weight: 500;
}
.singin__div, .singin__div div{
  display: inline;
      margin-right: 7px;
}
.singin__div img{
       width: 8%;
         margin-top: -20px;
}
.singup_title {
  margin-bottom: 23px;
}
</style>
<script type="text/javascript">
  $(document).ready(function () {
    $('form#post_req').submit(function(){ 
    if (! $('#accept_term')[0].checked){
       alert('Please Accept Term Policy');
       return false;
    }
}); 

  $("#post_req").validate({
            ignore: [], 
            rules: {
                fname: {required: true,minlength: 3,maxlength: 60},
                lname: {required: true,minlength: 3,maxlength: 60},
                email:{required:true,email:true},
                address:{required:true},
                password: { required: true,minlength: 5  },
                password_confirmation:{ required: true,equalTo:"#password" },
               phone_no:{ digits: true,minlength: 10,maxlength: 11},
               profile: {required: true, extension: "png|jpg|jpeg" },
               accept_term:{required:true},
            },
            messages: {
               fname:{required:" First Name is required!",minlength:" First Name require minimum 3 characters!",maxlength:" First Name require max 60 characters!"},
               lname:{required:" Sur Name is required!",minlength:" Sur Name require minimum 3 characters!",maxlength:" Sur Name require max 60 characters!"},
               email: {required:" Email is required!",email:" Wrong Email!", },
               
               address: {required:" Address is required!" },
               password: {required :"Password is required",minlength : "password Should have 5 character"},
               password_confirmation: {required :"Confirm Password is required",equalTo: "Password is not matching "},
               phone_no:{minlength:" Not valid",maxlength:" Not valid"},
               profile:{required:" Image Is Required",extension:" Not valid"},
               accept_term:{required:" "}
            },
            submitHandler: function(form) {
               $('#disable-button').show();
               $('#enable-button').hide();
               document.post_req.submit();
            },
        });
    });
</script>
<div class="maincontent">
  <section class="section">
    <div class="container mycontainer ">
        <div class="col-md-1"></div>
        <div class="col-md-10">
              <div class="page-heading singup_title">
                  <div class="widget">
                      <h2 class="title-border" style=" border-bottom: none"> Sing Up Using</h2>
                  </div>
                  <div class="singin__div">
                   <div class = "google__singin">
                        <a href = "login/google"> <img src = "{{asset('images/google_icon.png')}}">  </a>
                    </div>
                  <div class="facebook__signin">
                      <a href = "login/facebook"> <img src = "{{asset('images/facebook_icon.png')}}">  </a>
                  </div>
                 </div> 
                 <p class = "welcome_span"> Or </p> 
              </div>

              <div class="page-heading">
                  <div class="widget">
                      <h2 class="title-border"> Registration</h2>
                  </div>
              </div>
            <div class="panel-body">
                 <form id="post_req" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('register') }}">
                    @csrf     
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><small>Email <span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                     </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('First Name') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">

                        <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" required autofocus>                            
                       
                         @if ($errors->has('fname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif

                           </div>
                        </div>

                       <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Last Name') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">

                          <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" required autofocus>                            
                       
                         @if ($errors->has('lname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif

                           </div>
                        </div>

                      <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label">
                            <small>{{ __('Password') }}
                                <span class="text-danger"> *</span></small>
                            </label>

                        <div class="col-sm-4" style = "  display: flex!important">

                         <input id="password" type="password" class=" form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required  >

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                     @endif
                         </div>
                         <input type="checkbox" class = "" onclick="showPassword()" > Show Password
                    </div>


                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Confirm Password') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                             <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>                    
                     </div>
                    </div>

                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Address') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                        <input id="address" type="text" class="form-control" value="{{ old('address') }}" name="address" required>                
                       </div>
                    </div>

                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label">
                            <small>{{ __('Mobile') }}</small>
                            </label>

                        <div class="col-sm-4">

                         <input id="phone_no" type="text" class=" form-control{{ $errors->has('phone_no') ? ' is-invalid' : '' }}" value="{{ old('phone_no') }}" name="phone_no"   >

                                @if ($errors->has('phone_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                     @endif
                         </div>
                    </div>

                    <!-- <div class="form-group">
                        
                        <label for="group_name" class="col-sm-2 control-label"><small>Enrolment Number</small></label>
                        <div class="col-sm-4">
                             <input id="enrollment" type="text" class="form-control{{ $errors->has('enrollment') ? ' is-invalid' : '' }}" name="enrollment" required>

                               @if ($errors->has('enrollment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('enrollment') }}</strong>
                                </span>
                             @endif
                         </div>
                      </div>-->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>Upload Photo</small></label>
                        <div class="col-sm-4">
                        <input type="file" name="profile"  class="" id="profile"/>  
                         @if ($errors->has('profile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('profile') }}</strong>
                                    </span>
                                     @endif     
                        </div>
                    </div>


                    <div class="form-group">
                    <input id ="accept_term" name ="accept_term" class = "term_check" type ="checkbox"><span class = "term_span" > I accept the  <a id = "terms" data-toggle="modal" data-target="#myModal"> Term And Conditions </a> </span> </div>
                    <div class="form-group text-center">
                        <div class="col-sm-offset-2 col-sm-2">
                          <div id = "enable-button">
                        <button type="submit" class="btn btn-success"><span class="fa fa-user"></span> Save</button>
                      </div>
                      <div id = "disable-button" style="display:none">
                         <button type="submit" class="btn btn-success" disabled="disabled"><span class="fa fa-user"></span> Save</button>
                      </div>
                        </div>
                    </div>
                    </form>        
                </div>
        </div>
    </div>
</section>       
 </div>


<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Terms And Policy</h4>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

   </div>
</div>

 <script>
 $("#terms").on('click', function(){
    $.ajax({
      url: 'term',
      type:'GET',
      success:function(data){
        $(".modal-body").html(data)
      }
    });
 });
 function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
 </script>
@endsection
