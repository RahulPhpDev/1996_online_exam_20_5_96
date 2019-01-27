
 @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')
<style>
.navigation li:hover {background: #fff}
.navigation li:hover a{color:#428BCA}
.navigation li {float: left; margin: 0; padding: 0;}
.navigation li a {padding: 20px 30px; float: left;}
.navigation li.active a {background: #428BCA; color: #fff;border-top: 2px solid #428BCA;}
.navigation > li.active > a:focus {    background-color: #428BCA; border-top:2px solid #428BCA;}
.tab-content{height:450px;}
.nav-tabs > li > a {    border-top: 2px solid #428BCA;}
.img_style {height: auto; max-width: 50%;}
   </style>
<link href="{{ asset('css/validation.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>

<div class="maincontent">
        <section class="section">
            
        <div class="container mycontainer ">
        @include('admin.messages.return-messages')
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

                <div id="profile_image" class="tab-pane fade">
                    @include('auth.layout.profile-image')
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
