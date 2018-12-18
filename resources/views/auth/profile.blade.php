
 @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')
<style>
.navigation li {float: left; margin: 0; padding: 0;}
   .navigation li a {padding: 20px 30px; float: left;}
   .navigation li.active a {background: #428BCA; color: #fff;}
   </style>
<link href="{{ asset('css/validation.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
  $("#post_req").validate({
            ignore: [], 
            rules: {
               fname: {required: true,minlength: 3,maxlength: 60},
               lname: {required: true,minlength: 3,maxlength: 60},
               email:{required:true,email:true},
               address:{required:true},
                password: { required: true,minlength: 5  },
                password_confirmation:{ required: true,equalTo:"#password" },
            },
            messages: {
               fname:{required:" First Name is required!",minlength:" First Name require minimum 3 characters!",maxlength:" First Name require max 60 characters!"},
               lname:{required:" Sur Name is required!",minlength:" Sur Name require minimum 3 characters!",maxlength:" Sur Name require max 60 characters!"},
               email: {required:" Email is required!",email:" Wrong Email!", },
               
               address: {required:" Address is required!" },
                 password: {required :"Password is required",minlength : "password Should have 5 character"},
          password_confirmation: {required :"Confirm Password is required",equalTo: "Password is not matching "}
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
            <ul class="nav nav-tabs navigation">
                <li class="active"><a data-toggle="tab" href="#home">Profile</a></li>
                <li><a data-toggle="tab" href="#menu1">Update Profile</a></li>
                <li><a data-toggle="tab" href="#profile_image">Change Profile Image</a></li>
                <li><a data-toggle="tab" href="#menu3">Change Password</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    @include('auth.layout.my-profile')
                </div>

                <div id="menu1" class="tab-pane fade">
                    @include('auth.layout.edit-profile')
                </div>

            <div id="menu3" class="tab-pane fade">
                @include('auth.layout.change-password')
            </div>
        </div>
    </section>       
 </div>

 <script>
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
