@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  


<div class="maincontent">
                <style type="text/css">

	.box-services-c {
		margin: 0 auto;
	    border-radius: 50%;
	    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
	    text-align: center;
	    width: 245px;
	    padding: 20px;
	}
	.font_bold{
		font-weight: 400;
	}
	.homehedp{font-size: 18px;color: #5A6779;font-weight: 400; width: 70%;margin: 0 auto;}
	.btn {
		display: inline-block;
		padding: 8px 2rem;
		overflow: hidden;
		position: relative;
		text-decoration: none;
		text-transform: uppercase;
		border-radius: 3px;
		-webkit-transition: 0.3s;
		-moz-transition: 0.3s;
		-ms-transition: 0.3s;
		-o-transition: 0.3s;
		transition: 0.3s;
		box-shadow: 0 2px 10px rgba(0,0,0,0.5);
		border: none; 
		font-size: 15px;
		text-align: center;
		background-color: #00bcd4;
	}
	.home .header {
		margin: 32px 0;
	}
	.homepackage{
		margin: 32px 0;
	}
	h2.title {
		margin: 8px 0 24px;
		text-transform: uppercase;
		font-weight: 300;
	}
	p.text{position: relative!important;background-color: transparent !important;color: #5A6779!important;}
	.flexslider{box-shadow: none!important;}
	.slideimg{
		box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
	}
	.input-state {
		position: relative;
		margin-top: 24px;
	}
	.sr-only {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0,0,0,0);
		border: 0;
	}
	.get-apps-link input[type=text] {
		border-width: 2px;
		height: auto;
		font-weight: 500;
		border-color: transparent transparent #F0F0F0;
		padding: 12px 96px 12px 0;
	}
	.top-bg-overlay-fill {
		position: absolute;
		background: rgba(0,0,0,.5);
		height: 100%;
		width: 100%;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
	}
	.lb-content {
		/*display: inline-block;*/
		vertical-align: middle;
		white-space: normal;
		
		position: relative;
		padding: 35px 0;
		margin-left: -4px;
		color: #fff;
	}
	
</style>

	<?php if(Session::has('login_status_message')) { ?>
	

<link href="{{ asset('/css/jquery.gritter.css') }}" rel="stylesheet">


<script src="{{ asset('/js/jquery.gritter.min.js') }}"></script>


<script src="{{ asset('js/backend_js/jquery.peity.min.js') }}"></script>

<script src="{{ asset('/js/matrix.interface.js') }}"></script>

	<?php } ?>

<section class="section mycontainer" style="position: relative;background-image: url('{{ asset('frontend/img/tab/ee8fc908ad2c41c023a0755b4c6486b3.jpg') }}') ;background-size: cover;min-height: 500px;text-align: center;">


<!-- <section class="section mycontainer" style="position: relative;background-image: url('img/tab/ee8fc908ad2c41c023a0755b4c6486b3.jpg');background-size: cover;min-height: 500px;text-align: center;"> -->
	<div class="mb50"></div>
	

		<div class="container home">
			<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff"> Maarula Online Exam</h1>
				<p class="text-center" style="color: #fff"><p>The most Powerful Examination Engine on Envato. Try Edu Expression today. Visit EduExpression.com for more information or details.</p></p>
				<!-- <a href="Registers.html" data-redirect-url="/tests" class="btn btn-success h-btn mar-b8 mar-h4 js-tb-signup-anchor">Get Started For Free</a> -->
			</div>
		</div>	
		<div class="mb50"></div>
	
</section>
 		<section class="section mycontainer">
			<div class="container home">
				<div class="mb50"></div>
									<div class="col-xs-12 header">
						<h2 class="text-center font_bold m0">
							Try This Online examination System 						</h2>
						<p class="homehedp text-center">Maarula Online Exam Portal  Enables you to conduct flexible online examination system with ease.where you can explore your knowledge, </p>
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
	<!-- <section class="section mycontainer" style="background-color: #f6f8fa;">
	<div class=" home">
		<div class="mb50"></div>
			<div class="flexslider ss" style="background: #f6f8fa;">
				<ul class="slides">
										<li>
						<div class="feat-text-slide col-md-5">
							<div class="each js-each-feature active" data-feature-id="content-control-1" style="display: block;">
								<h2 class="title">Flawless Exam Experience </h2>
								<p class="text">Clear Exam interface with Categories , Subject and Question Panel. Ability to switch from one Subject to another and one question to another. Color legends to track your progress. Essential features such as Browser switching features, language change option are also available..</p>
							<br>
							 
								<a href="Registers.html" data-redirect-url="/tests" class="btn h-btn mar-v16 btn-success js-tb-signup-anchor">Get started</a>
							</div>
						</div>
						<div class="col-md-7">
							<img src="{{asset('frontend/img/slides_thumb/9a7906ffc41e8beaafb1bf2a2b982d9a.png')}}" alt="Slide1" />						</div>
					
					</li>
								</ul>
			</div>
		<div class="mb50"></div>
	</div>
</section> -->


 <section class="section mycontainer" style="background-color: #f6f8fa;">
	<div class="mb50"></div>
	<div class="mb50"></div>
		<div class="container home">
			
							<div class="col-sm-12">
	            <div class="section-testimonials  el_max_height"">
	            	<div class="">
	                <h3 class="title-small mrg-left text-center ">Our Topper</h3>
	                <div class="owl-carousel owl-portfolio">
						                    <div class="owl-el">

	                        <div class="jag-tst-avatar text-center">
							<img src="{{asset('frontend/img/blankuser.jpg')}}" alt="CakePHP" border="0" class="img-responsive" />	                        </div>

	                        <div class="ss-tst-details text-center">
	                            <div class="ss-name marginbottom_10">Joseph</div>
	                            	                             <div class="ss-rating text-center">
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                            </div>
	                           
	                        </div>
	                        <blockquote>
	                            <p class="p0">This website helped me prepare extremely well for my exams. Highly recommended !</p>
	                            <footer>
	                            </footer>
	                        </blockquote>
	                    </div>
				                    <div class="owl-el">

	                        <div class="jag-tst-avatar text-center">
							<img src="{{asset('frontend/img/blankuser.jpg')}}" alt="CakePHP" border="0" class="img-responsive" />	                        </div>

	                        <div class="ss-tst-details text-center">
	                            <div class="ss-name marginbottom_10">Manish Paul</div>
	                               <div class="ss-rating text-center">
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                            </div>
	                             
	                           
	                        </div>
	                        <blockquote>
	                            <p class="p0">The question bank of this website is extensive and prepared me completely for my exam.</p>
	                            <footer>
	                            </footer>
	                        </blockquote>
	                    </div>
				                    <div class="owl-el">

	                        <div class="jag-tst-avatar text-center">
							<img src="{{asset('frontend/img/blankuser.jpg')}}" alt="CakePHP" border="0" class="img-responsive" />	                        </div>

	                        <div class="ss-tst-details text-center">
	                            <div class="ss-name marginbottom_10">Ajit</div>
	                               
	                              
	                               	                             <div class="ss-rating text-center">
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star-half-empty"></i>
	                            </div>
	                             
	                             
	                            	                              
	                           
	                           
	                        </div>
	                        <blockquote>
	                            <p class="p0">Site has useful hints and explanation for questions which is not available on other sites. </p>
	                            <footer>
	                            </footer>
	                        </blockquote>
	                    </div>
				                    <div class="owl-el">

	                        <div class="jag-tst-avatar text-center">
							<img src="{{asset('frontend/img/blankuser.jpg')}}" alt="CakePHP" border="0" class="img-responsive" />	                        </div>

	                        <div class="ss-tst-details text-center">
	                            <div class="ss-name marginbottom_10">Rahul</div>
	                               
	                              
	                                
	                            	                             <div class="ss-rating text-center">
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star-half-empty"></i>
	                            </div>
	                             
	                            	                              
	                           
	                           
	                        </div>
	                        <blockquote>
	                            <p class="p0">The packages of the site offer more for less money. VALUE FOR MONEY AND TIME. </p>
	                            <footer>
	                            </footer>
	                        </blockquote>
	                    </div>
				                    <div class="owl-el">

	                        <div class="jag-tst-avatar text-center">
							<img src="{{asset('frontend/img/blankuser.jpg')}}" alt="CakePHP" border="0" class="img-responsive" />	                        </div>

	                        <div class="ss-tst-details text-center">
	                            <div class="ss-name marginbottom_10">Pritam</div>
	                               
	                              
	                                
	                             
	                            	                             <div class="ss-rating text-center">
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                                <i class="fa fa-star"></i>
	                            </div>
	                            	                              
	                           
	                           
	                        </div>
	                        <blockquote>
	                            <p class="p0">Thank you. You were like messiah. Saved time and effort. I could prepare on move and with just my mobile. GREAT. </p>
	                            <footer>
	                            </footer>
	                        </blockquote>
	                    </div>
				                </div>
	            </div>
	        </div>
	        </div>
	        				
		

		</div>	
	<div class="mb50"></div>
</section> 

<!-- <section class="section mycontainer">
	<div class="container ">
		<div class="mb50"></div>
		<div class="row col-p30">
						<div class="col-sm-4 xs-box2">
				<div class="box-services-c">
					<i class="fa fa-user fa-5x"></i>
					<h3 class="title-small br-bottom-center">No of Visitors</h3>
					<p class="mb0"><h3 class="text-danger">1369</h3></strong></p>
				</div>
			</div>
										<div class="col-sm-4 xs-box2">
					<div class="box-services-c">
						<i class="fa fa-graduation-cap fa-5x"></i>
						<h3 class="title-small br-bottom-center">No of Students</h3>
						<p class="mb0"><h3 class="text-danger">6</h3></p>
					</div>
				</div>
										<div class="col-sm-4">
					<div class="box-services-c">
						<i class="fa fa-book fa-5x"></i>
						<h3 class="title-small br-bottom-center">No of Exams</h3>
						<p class="mb0"><h3 class="text-danger">6</h3></p>
					</div>
				</div>
			
		</div>
		<div class="mb50"></div>
	</div>
</section> -->

<style type="text/css">
	.top-bg-overlay-fill {
    position: absolute;
    background: rgba(0,0,0,.5);
    height: 100%;
    width: 100%;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>
<section class="section mycontainer" style="position: relative;background-image: url('img/tab/05aebf5cfc01f0cac8f9fdc1b65b4452.jpg');background-size: cover;min-height: 350px;text-align: center;">
	<div class="mb50"></div>
	 	<div class="container home">
	 		<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff;">Start Your Exam Preparation Now!</h1>
				<p class="text-center" style="color: #fff">PRACTICE, ANALYZE AND IMPROVE!</p>
				<!-- <a href="Registers.html" data-redirect-url="/tests" class="btn btn-success h-btn mar-b8 mar-h4 js-tb-signup-anchor">Get Started For Free</a> -->
			</div>
		</div>	
		<div class="mb50"></div>
	
</section>


<!-- <section class="section mycontainer">
	<div class="mb50"></div>
		<div class="container home">
			<div class="col-sm-12">
	             <h3 class="title-small text-center">Latest News & Events</h3>
	             <div class="col-md-8 col-md-offset-2">
	             	 <marquee align="top" direction="up" onmouseover="this.stop();" onmouseout="this.start();" scrollamount="2" height="218">
				    <ul>				
				<li><a href="News/show/Sed-in-leo-vel-justo-commodo-facilisis-ac-gravida.html">Sed in leo vel justo commodo facilisis ac gravida</a></li>
				<li><a href="News/show/Lorem-ipsum-dolor-sit-amet.html">Lorem ipsum dolor sit amet</a></li>
									  
				  </ul>
				  </marquee>
	             </div>
				   
	    	</div>
	    </div>
		
	<div class="mb50"></div>
</section> -->



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