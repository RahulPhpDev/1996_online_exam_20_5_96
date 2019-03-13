@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@push('angular')
  @include('frontend_layouts.partials.fetch_angular')
@endpush

@section('content') 

<link href="{{ asset('css/backend_css/exam_question.css') }}" rel="stylesheet">


<style type="text/css">
	.inline_block div{
		display: inline-block;
	}
</style>
<div class="maincontent" id="wrapper">
  <div class="overlay"></div>
    <section class="section_instruct">
      <div class="container-fluid">
	 	<div class="col-md-12" ng-controller="appController">
	 	
	 <!-- ************ Exam Details ******* !-->		
   		  <div class = "col-md-8 hidden-sm">
      			 <div class ="exam_details" ng-init="examDetails;fetchExamQuestions()">                 
             	 	<div class = "inline_block">
             	 			 <div class = "detail_heading">  Time : <span>  <@ examDetails.time @> </span></div>
             	 			 <div class = "detail_heading">   Question : <span> <@ examDetails.total_question @>  </span> </div>
             	 		     <div class = "detail_heading">   Mark : <span> <@ examDetails.total_marks @>  </span> </div>
             	 		     <div class = "detail_heading head_span uppercase ">  <@ examDetails.exam_name  @>  </div> 
             	 	 </div>
            	 </div>
         </div>
 <!-- ************ENd Exam Details ******* !-->		

 		<div class = "col-md-8" >
          <div class="mycontainer question_section">
            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
           	  <div class = "question_process_color pull-right question_mark_details">
               	 <div class="postitive_mark"> <a > <@ quizWithClass.question.marks @>  </a>  </div>
                  <div class="negative_mark" ng-show="quizWithClass.question.negative_marks > 0">
                  		 <a > <@ quizWithClass.question.negative_marks @>  </a> 
                  </div>
            	</div>

            	 <div class = "questions"  >
            	  <!-- ng-bind-html="snippet" -->
            	  <!-- quizWithClass.question.question -->
            	  <span ng-bind-html = "deliberatelyTrustDangerousSnippet(quizWithClass.question.question)"> </span>

            	 	  
            	 </div>
              {{ Form::close() }}
           </div>
         </div>


<!-- ************Question Iritation  ******* !-->		
   <div class = "col-md-4  report navbar navbar-inverse navbardum-fixed-top show__mob" id ="sidebar-wrapper"  role="navigation">
   		 <div class = "question_count_div panel"> <h2>  Question </h2> </div>
			<div >
			<span ng-repeat="(key, value) in quizWithClass.class">
	   				 <a href = "JavaScript:void(0);" id = "<@ key @>"  class = "circle numberic-custom <@ value @>" >
	      	    		<span>  <@ $index+1 @> </span>
			        </a>
		        </span> 
			</div>
	</div>
<!-- ************ End Question Iritation  ******* !-->
       </div>
     </div>
  </section>
</div>


<script type="text/javascript">
	app.controller('appController', function($scope,$sce, $http){
		$scope.examDetails =  <?php echo $examDetails->getContent(); ?>;
		$scope.examId = '<?php echo $en_eId; ?>';
		
		$scope.fetchExamQuestions = function(){
			$http({
		        method: 'GET',
		        url: '/fetch_exam_question/'+$scope.examId
			   }).then(function (response){
					$scope.quizWithClass = response.data;
			   },function (error){
		   });
		};
		$scope.deliberatelyTrustDangerousSnippet = function(snippet) {
			console.log(snippet);
               return $sce.trustAsHtml(snippet);
             };
	});
	
</script>


@endsection