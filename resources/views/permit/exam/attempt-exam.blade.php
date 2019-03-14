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
  .numberCircle {
    border-radius: 50%;
    width: 34px;
    height: 33px;
    padding: 6px !important;
    background: #337ab7; 
    border: 2px solid #626ce4;
    color: #fff;
    text-align: center;
    font: 16px Arial, sans-serif;
    display: inline;
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
           
             {{ Form::open(array('route' =>['submit-exam', $en_eId],"class" => "form-horizontal", "onSubmit"=>"if(!confirm('Are you sure to submit Exam?')){return false;}"))  }}

           	  <div class = "question_process_color pull-right question_mark_details">
                <div class="numberCircle bg-primary"> 15 </div>
               	  <div class="postitive_mark"> <a > <@ quizWithClass.question.marks @>  </a>  </div>
                  <div class="negative_mark" ng-show="quizWithClass.question.negative_marks > 0">
                  		 <a > <@ quizWithClass.question.negative_marks @>  </a> 
                  </div>
                   
                   
                   <button type="submit" style="position: relative;top: -5px;" class="btn btn-exam-custom btn-success submitexam" id="submitExam"> Submit Exam </button>
               	</div>
             {{ Form::close() }}


            <form method="post" ng-submit="submitForm()", class = "form-horizontal">
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
	   				 <a ng-click="directQuestion(key)" href = "JavaScript:void(0);" id = "<@ key @>"  class = "circle numberic-custom <@ value @>" >
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

          
function submitExam(){
  return confirm('Do you really want to submit the form?');
}


	app.controller('appController', function($scope,$sce, $http){
       $scope.model = {};
        $scope.savemodel = {};
        $scope.model.answer = '';
        $scope.savemodel.saveBtnc = '';
		    $scope.examDetails =  <?php echo $examDetails->getContent(); ?>;
		    $scope.examId = '<?php echo $en_eId; ?>';


		// $scope.submitExam = function(){
  //     return confirm('Do you really want to submit the form?');
  //   }


		$scope.fetchExamQuestions = function(){
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
    }; 

    $scope.directQuestion = function(questionID){
        $http({
            method : 'POST',
            url : '/get_direct_question/',
            data:{
              '_token' : '{{csrf_token() }}',
              'questionId' :questionID,
            }
        }).then(function(data){
          if(data.error != '')
          {
            console.log('139');
            $scope.errorMessage = data.error;
            $scope.fetchExamQuestions();

          }
          else{
            console.log('138');
            $scope.form_data = {};
            $scope.fetchExamQuestions();
          }
        });
    };


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
        $scope.form_data = {};
        $scope.fetchExamQuestions();
      }
    });
  };     
    
       
	});

  
</script>


@endsection