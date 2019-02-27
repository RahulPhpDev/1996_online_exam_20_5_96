@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  


<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
                <style type="text/css">

.res_table{margin:20px 0px 10px 10px;font-size:18px;}
.report_th, .report_td{ width:43%;text-align:right;  }
.report_th >span ,.report_td >span{margin-right:18%}
.sorry__text{
    text-align: justify;
    font-size: 26px;
    line-height: 42px;
    font-weight: 500;
    font-family: cursive
}
.sub_heading{
    font-size: 16px;
    text-align: right;
    font-family: monospace;
}
.exam_anchor{
    color: #3838e0;
    font-weight: 800;
    font-style: oblique;
    font-size: 115%;
    }
</style>



<section class="section mycontainer" style="position: relative;background-image: url('{{ asset('frontend/img/tab/ee8fc908ad2c41c023a0755b4c6486b3.jpg') }}') ;background-size: cover;min-height: 500px;text-align: center;">

	<div class="mb50"></div>
		<div class="container home">
			<div class="top-bg-overlay-fill"></div>
			  <div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff"> Maarula Online Exam</h1>
				<p class="text-center" style="color: #fff"><p>The most Powerful Examination</p></p>
			   </div>
		    </div>	
		<div class="mb50"></div>
</section>

        <div class="item-container" style="padding:20px 0">    
         <div class="container"> 
          <div class="col-md-12">
          <div class="col-sm-6">
               <div class="text__section" style="padding-top:40px">
                   <h3 class = "sorry__text">  Sorry.. You have Extend Maximum Attempt On <a href = "{{route('exam-result', Crypt::encrypt($exam_data['id']))}}" title = "check Your Record " class="exam_anchor">{{ucwords($exam_data['exam_name'])}} </a> Exam </h3>
                    <span class = "sub_heading"> You can <a href="#"> Contact Us </a> for raise more attempts </span>
               </div> 
          </div>

          <div class="col-sm-6"></div>
           <img src="{{ asset('frontend/img/no_access.png') }}" style="float: right">
          </div>
         </div>
        </div>
      </div>
</div>
@endsection