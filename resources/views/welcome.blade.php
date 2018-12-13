@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  

<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">

<div class="maincontent">
     
	<?php if(Session::has('login_status_message')) { ?>
	

<link href="{{ asset('/css/jquery.gritter.css') }}" rel="stylesheet">


<script src="{{ asset('/js/jquery.gritter.min.js') }}"></script>


<script src="{{ asset('js/backend_js/jquery.peity.min.js') }}"></script>

<script src="{{ asset('/js/matrix.interface.js') }}"></script>

	<?php } ?>

<section class="section mycontainer" style="position: relative;background-image: url('{{ asset('frontend/img/tab/ee8fc908ad2c41c023a0755b4c6486b3.jpg') }}') ;background-size: cover;min-height: 500px;text-align: center;">

	<div class="mb50"></div>
	

		<div class="container home">
			<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff"> Maarula Online Exam</h1>
				<p class="text-center" style="color: #fff"><p>The most Powerful Examination .</p></p>
				<!-- <a href="Registers.html" data-redirect-url="/tests" class="btn btn-success h-btn mar-b8 mar-h4 js-tb-signup-anchor">Get Started For Free</a> -->
			</div>
		</div>	
	
</section>
 	
@if(!empty($upcomingExams->toArray()))
   @component('homepage.upcoming_exam', compact('upcomingExams'))@endcomponent  
@endif
@component('homepage.exam', compact('nonSubscriptionExams','allExam'))@endcomponent  
@if(!empty($courseData))
 @component('homepage.course',compact('courseData'))@endcomponent  
@endif

@component('homepage.testimonial')@endcomponent  
 

	<section class="section mycontainer">
			<div class="container home">
									<div class="col-xs-12 header">
						<h2 class="text-center font_bold m0">
							Try This Online examination System 						</h2>
						<p class="homehedp text-center">MaaRula Online Exam Portal  Enables you to conduct flexible online examination system with ease.where you can explore your knowledge, </p>
					</div>
										<!-- filter -->
										<div class="col-xs-12 text-center">
						<div class="filter">
							<div class="btn-group">			
								<!-- <a href="#" class="btn btn-success">Latest Packages</a> -->	
							</div>
						</div>
					</div>
					<div class="col-xs-12 text-center homepackage">

					  @php $componentData = array(
						'SubscriptionData' => $SubscriptionData,
						); @endphp
						@component('homepage.subscription_package', $componentData)
						@endcomponent      

					</div>
					<div class="col-xs-12 text-center">
						<div class="filter">
							<div class="btn-group">	
									
							<!-- 	<a href="Packages.html" class="btn btn-success">Show All</a> -->
							</div>
						</div>
					</div>
				</div>
		</section>
		

<script>
	$(document).ready(function () {
	    $('.flexslider.ss').flexslider({
	        animation: 'slide',
	        directionNav: false, 
	        slideshowSpeed:'5000',
	        controlsContainer: '.flexslider.ss'
	    });	
    });
</script>
<script type="text/javascript">
        $(document).ready(function () {

        	$(document).bind("contextmenu",function(e){
				    return true;
				});


            $('.flexslider.carousel').flexslider({
               animation: "slide",
               slideshowSpeed:'4000',
               mousewheel: true,
               directionNav: true, 
                animationLoop: true,
                controlNav:	false,
                itemWidth: 288,
                itemMargin: 30,
                touch:true,
                minItems: 3,
                maxItems: 6,
                controlsContainer: '.flexslider.carousel'
            });
        });
</script>

        </div>
</div>
@endsection