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
                                    <ul  id="frontMenu" class="menu"><li class="toggle-menu"><i class="fa icon_menu"></i></li><li class="mobilshopping"><a class="shop" href="Carts/View.html"><i class="fa fa-shopping-bag">0</i></a></li>
	<li class="active"><a href="{{route('/welcome')}}"><i class="fa fa-home"></i>&nbsp;Home</a></li>
	<li>
    <a href="{{route('about-us')}}"><i class="fa fa-globe"></i>&nbsp;About Us</a>
		
	</li>
	<li><a href="javascript::void(0)"><i class="fa fa-shopping-cart"></i>&nbsp;Packages</a></li>
    @if( !(Auth::user()))
	<li><a href="{{route('register')}}"><i class="fa fa-user"></i>&nbsp;Register</a></li>
	<li><a href="{{route('login')}}"><i class="fa fa-lock"></i>&nbsp;Login</a></li>
        
        @else
   <li> 
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> 
        Logout 
                </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
       @endif
</ul>
                                </nav>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
    </div>

@endsection