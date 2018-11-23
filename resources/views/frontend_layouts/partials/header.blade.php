@section('header')
<!DOCTYPE html>
<html lang="en">
  
@include('frontend_layouts.partials.fetch_css')  
 @include('frontend_layouts.partials.fetch_js')
<head>
        <title>Maarula Online Exam</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />   
    </head>
    <body>


<script type="text/javascript">
    $( document ).ready(function() {

        $( "#products_animation_id" ).hover(
          function() {
                $( "#products_animation" ).show(500);
            }, function() {
                //$( "#products_animation" ).hide(500);
            }
        );

         $( "#products_animation" ).hover(
          function() {
                // $( "#products_animation" ).show(500);
            }, function() {
                $( "#products_animation" ).hide(500);
            }
        );

        $( "#products_animation_id" ).click(function(event) {
            $( "#products_animation" ).toggle();
        });

    });
</script>
<style>
 /* .rpic{
     border:1px solid red;
 } */
 /* .rpic img{
            border-radius: 50%;
        } */
        </style>

<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<div id="wrapper">
    <div class="h-wrapper">
        
                <header class="header-wrapper header-transparent with-topbar">
                            <div class="main-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                        <div  class="logo-text"><a href="index.html">
                        <img src="{{ asset('frontend/img/logo.jpg')}}" alt="MaaRula Online test" class="img-responsive front-logo img-circle" /></a>
                    </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <nav class="navbar-right">
                                    <ul  id="frontMenu" class="menu">
                                        
	<li class="active"><a href="{{route('/welcome')}}"><i class="fa fa-home"></i>&nbsp;Home</a></li>
	<li>
    <a href="{{route('about-us')}}"><i class="fa fa-globe"></i>&nbsp;About Us</a>
		
	</li>
	<li><a href="{{route('allpackage')}}"><i class="fa fa-shopping-cart"></i>&nbsp;Packages</a></li>
    @if( !(Auth::user()))
	<li><a href="{{route('register')}}"><i class="fa fa-user"></i>&nbsp;Register</a></li>
	<li><a href="{{route('login')}}"><i class="fa fa-lock"></i>&nbsp;Login</a></li>
        
        @else

<style>
div.avatarbox {
    background: #106eca;
    border: none;
    border-radius: 40px;
    color: #fff;
    float: left;
    font-size: 10px;
    font-weight: 700;
    line-height: 25px;
    overflow: hidden;
    position: relative;
    text-align: center;
    width: 32px;
    height: 32px;
}
div.material_avatar {
  
    cursor: pointer;
    border-radius: 40px;
    width: 30px;
    height: 30px;
    font-size: 12px;
    padding: 3px;
    margin-top: 2px;
    position: relative;
    float: left;
    margin: 0;
    border: none;
    background: none;
    color: #fff;
    font-weight: bold;
    text-align: center;
    line-height: 25px;
    overflow: hidden;
    -moz-border-radius: 40px;
    -webkit-border-radius: 40px;
}
.profile_img{
    border-radius: 40px;
  
    overflow: hidden;
    position: relative;
    text-align: center;
    width: 32px;
    height: 32px;
}
</style>

        <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                <?php
                  if(!Auth::user()->profile_image){
                    $profilePic  = Auth::user()->fname[0]. ''.Auth::user()->lname[0];
                    ?>

                   <div class="avatarbox material_avatar showtip tooltipstered" style="background-color: #106eca">{{ $profilePic}}</div>
                   <?php
                    }else{
                        $profilePic = '/images/profile/thumbnail/'.Auth::user()->profile_image;
                    ?>
                    <img src="{{ asset( $profilePic )}}"  class="avatarbox material_avatar profile_img"/>
                    <?php
                }
            ?>
        

        <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
        <li class="divider"></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> 
              Logout 
                </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form></li>
      </ul>
    </li>

  
       @endif
      
</ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
    </div>

@endsection