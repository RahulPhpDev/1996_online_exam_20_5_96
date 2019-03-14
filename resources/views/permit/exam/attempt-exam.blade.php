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
            
            <form method="post" ng-submit="submitForm()", class = "form-horizontal">
           	  <div class = "question_process_color pull-right question_mark_details">
               	 <div class="postitive_mark"> <a > <@ quizWithClass.question.marks @>  </a>  </div>
                  <div class="negative_mark" ng-show="quizWithClass.question.negative_marks > 0">
                  		 <a > <@ quizWithClass.question.negative_marks @>  </a> 
                  </div>
            	</div>

            	 <div class = "questions"  >
            	  <span ng-bind-html = "quizWithClass.question.encoded_question"> </span>            	 	  
            	 </div>
          
                 <div class = "options">
                  <div class = "opt_data question_count_div panel" ng-repeat = "(key, value) in quizOptions">
                     <input type ="radio" ng-model = "model.answer" value = "<@ value.id @>" class ="rdo_opt" id = "<@ value.id @>" name = "answer" > 
                     <span class = "options_span" ng-bind-html = "value.question_option ">
                      </span> 
                    </div>
                     
                 </div>
          
                <div class = "mt-10"> </div>
                <div class="controls"> 
                  <input type = "hidden" name = "save" id = "saveu">
                  <button ng-click="ButtonClick('continue')" name="save" type="submit" value="continue" class="btn btn-success savebtn btn-exam-custom">Save</button>

                  <button ng-click="ButtonClick('preview')" name="save" type="submit" value="preview" class="btn hidden-sm btn-primary savebtn btn-exam-custom hidden-sm">Preview</button>

                  <button ng-click="ButtonClick('skip')" name="save" type="submit" value="skip" class="btn btn-danger savebtn btn-exam-custom">Skip </button>
                 </div>
              {{ Form::close() }}
           </div>
         </div>


<!-- ************Question Iritation  ******* !-->		
   <div class = "col-md-4  report navbar navbar-inverse navbardum-fixed-top show__mob" id ="sidebar-wrapper"  role="navigation">
   		 <div class = "question_count_div panel"> <h2>  Question </h2> </div>
			<div >
			<span ng-repeat="(key, value) in quizWithClass.question_class">
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
       $scope.model = {};
        $scope.savemodel = {};
       $scope.model.answer = '';
       $scope.savemodel.saveBtnc = '';
		$scope.examDetails =  <?php echo $examDetails->getContent(); ?>;
		$scope.examId = '<?php echo $en_eId; ?>';
		
		$scope.fetchExamQuestions = function(){
      console.log('ckj');
			$http({
		        method: 'GET',
		        url: '/fetch_exam_question/'+$scope.examId
			   }).then(function (response){
          console.log(response);
           $scope.quizWithClass = response.data;
           $scope.quizOptions =  response.data.optionsdata;
			   },function (error){
		   });
		};


		$scope.deliberatelyTrustDangerousSnippet = function(snippet) {
          return $sce.trustAsHtml(snippet);
     };

    $scope.ButtonClick = function(btnValue){
      $scope.btnVal = btnValue;
    } 

  $scope.submitForm = function(){
    $http({
      method:"POST",
      url:"/save-answer",
      data:{
            "_token": "{{ csrf_token() }}",
            'answer':$scope.model.answer ,
            'save':$scope.btnVal
         }
    }).then(function(data){
      console.log(data);
      if(data.error != '')
      {
        console.log('138');
        $scope.success = false;
        $scope.error = true;
        $scope.errorMessage = data.error;
        $scope.fetchExamQuestions();
      }
      else
      {
        console.log('145');
        // $scope.success = true;
        // $scope.error = false;
        // $scope.successMessage = data.message;
        $scope.form_data = {};
        $scope.fetchExamQuestions();
        // $scope.fetchData();
      }
    });
  };     
           
	});

  
</script>


@endsection