@section('header')
<!DOCTYPE html>
<html lang="en">
  
@include('frontend_layouts.partials.fetch_css')  
 @include('frontend_layouts.partials.fetch_js')
<head>
        <title>MaaRula Online Exam:  @yield('title')</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />   
    </head>
    <body class="" ng-app = "frontendApp">

<style>
	@media only screen and (max-width: 600px) {
    .h-wrapper{position: relative;}
    .menu li:not(:first-child) {display: none;}
    .img{width: 81px;height: 78px;}

    .menu.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .menu.responsive li {
    display: block;
    text-align: left;
  }
}
        </style>
<script>
function myFunction() {
    var x = document.getElementById("frontMenu");
    if (x.className === "menu") {
        x.className += " responsive";
    } else {
        x.className = "menu";
    }
}
</script>
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
                        <div  class="logo-text"><a href="{{route('/')}}">
                        <img src="{{ asset('frontend/img/logo.jpg')}}" alt="MaaRula Online test" class="img-responsive front-logo img-circle" /></a>
                    </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <nav class="navbar-right">
                                    <ul  id="frontMenu" class="menu">

                                    <li class="toggle-menu" onclick = "myFunction();"><i class="fa icon_menu"></i></li>
	<li class="{{ request()->is('welcome*') || request()->is('/*')? 'active' : '' }}"><a href="{{route('/welcome')}}"><i class="fa fa-home"></i>&nbsp;Home</a></li>
	<li class="{{ request()->is('about-us*') ? 'active' : '' }}">
    <a href="{{route('about-us')}}"><i class="fa fa-globe"></i>&nbsp;About Us</a>
		
	</li>
    <li class="{{ request()->is('feedback*') ? 'active' : '' }}"><a href="{{route('feedback.create')}}"><i class="fa fa-envelope"></i>&nbsp;Contact Us</a></li>
    @if((Auth::user()) && Auth::user()['user_type'] ==1 )
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a></li>
    @endif
    @if( !(Auth::user()))
	<li class="{{ request()->is('register*') ? 'active' : '' }}"><a href="{{route('register')}}"><i class="fa fa-user"></i>&nbsp;Register</a></li>
	<li class="{{ request()->is('login*') ? 'active' : '' }}"><a href="{{route('login')}}"><i class="fa fa-lock"></i>&nbsp;Login</a></li>
        
        @else


        <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                <?php
                // dd(Auth::user()->profile_image);
                  if(!Auth::user()->profile_image){
                     $profilePic  = Auth::user()->fname[0]. ''.Auth::user()->lname[0];
                    ?>

                   <div class="avatarbox material_avatar showtip tooltipstered" style="background-color: #106eca">{{ $profilePic}}</div>
                   <?php
                    }else{
                      if(Auth::user()->register_from > 0){
                        $profilePic = Auth::user()->profile_image;
                      }else{  
                        $profilePic = asset('/images/profile/thumbnail/'.Auth::user()->profile_image);
                    }
                    ?>
                    <img src="{{  $profilePic}}"  class="avatarbox material_avatar profile_img"/>
                    <?php
                }
            ?>
        

        <b class="caret"></b></a>
      <ul class="dropdown-menu">
        @if(Auth::user()['user_type'] !=1)
        <li><a href="{{route('all-result')}}"><i class="icon-user"></i> Show Result</a></li>
       
        <li class="divider"></li>
        <li><a href="{{route('myprofile')}}"><i class="icon-check"></i> My Profile</a></li>
        @endif
       <!--  
        <li class="divider"></li> -->
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