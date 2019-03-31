@section('header')
<!DOCTYPE html>
<html lang="en">
  
@include('layouts.partials.fetch_css')  
 @include('layouts.partials.fetch_js')  
 @include('layouts.partials.fetch_layout_angular')
<head>
        <title>Online Exam :: @yield('title')</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />   
    </head>
    <body ng-app="maarulaapp">



<!--Header-part-->
<div id="header">
 <a href="{{route('/')}}"> <h1>Maarula Admin</h1></a>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">
      @php
      $userData = Auth::user();
        echo $userData['fname'].' '.$userData['lname'];
      @endphp

         </span><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="/profile"><i class="icon-user"></i> My Profile</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
            <li class="divider"></li>
        <li>

          <a class="" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
             <i class="icon-key"></i> Log Out
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>

</li>

       
      </ul>
    </li>

   <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-globe"></i> <span class="text">Notification</span> <span class="label label-important">{{Auth::user()->unreadNotifications->count()}}</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        @foreach(Auth::user()->unreadNotifications->take(4) as $notify)
          <li style="padding:3px">
            <a class="sAdd" title="" href="#">{{ $notify['data']['subject']}}</a>
            <span class="pull-right" style="font-size:9px">{{ extractDateTime('d-M h:i A',$notify['created_at'])}} </span>
            <span class="clearfix"></span>
          </li>
          <li class="divider"></li>
        @endforeach
           <li><a class="sAdd text-center" title="" href="{{route('notify.index')}}">View All </a></li>
      </ul>
    </li>

     <li class="">
          <a class="dropdown-item" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
              Logout
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
    </li>
  </ul>
</div>
<!--start-top-serch-->
<div id="search">
  <a class="tip-bottom btn" style="" href = "{{route('/')}}"> Vist Site</a>
</div>

<!--close-top-serch--> 

@endsection