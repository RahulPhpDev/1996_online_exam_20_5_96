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
  
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
    box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
</style>


<script type="text/javascript">

$(function(){
   var navDum =$('.navbardum-fixed-top');
    // navDum.hide();
    var open = $('.open-nav'),
        close = $('.close'),
        overlay = $('.overlay');

    open.click(function() {
      console.log(' hii');
          overlay.toggle();
          navDum.toggle();
         $('#wrapper').toggleClass('toggled');
    });

    close.click(function() {
        navDum.hide();
        overlay.hide();
        $('#wrapper').removeClass('toggled');
    });



});
var th = this;
  app.controller('appController', function($scope,$timeout,$sce, $http){

        $scope.model = {};
        $scope.savemodel = {};
        $scope.model.answer = '';
        $scope.savemodel.saveBtnc = '';
        $scope.examDetails =  <?php echo $examDetails->getContent(); ?>;
        $scope.examId = '<?php echo $en_eId; ?>';         


    $scope.fetchExamQuestions = function(){
      $http({
            method: 'GET',
            url: '/fetch_exam_question/'+$scope.examId
         }).then(function (response){
           $scope.quizWithClass = response.data;
           $scope.quizOptions =  response.data.optionsdata;
           $scope.oldAnswer = response.data.old_answer;
           $scope.difference = response.data.difference;
         },function (error){
       });
    };

      var setTimer = function(){
           th.watchfun($scope.difference);  
      }
        $timeout(setTimer, 1000);
  
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
              'examId' :$scope.examId
            }
        }).then(function(data){
          if(data.error != '')
          {
            $scope.errorMessage = data.error;
            $scope.fetchExamQuestions();
            if( $('#wrapper').hasClass('toggled')){
              $('.navbardum-fixed-top').hide();
              $('.overlay').hide();
              $('#wrapper').removeClass('toggled');
            }

          }
          else{
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
            'save':$scope.btnVal,
            'examId' :$scope.examId
         }
    }).then(function(data){
      if(data.error != '')
      {
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

  $scope.submitExam = function() {
   $("#exam-form").submit();
  } 
    $scope.yes = function() {
      alert('Confirmed!')
    }
  });

  app.directive('ngConfirmClick', [
        function(){
            return {
                link: function (scope, element, attr) {
                    var msg = attr.ngConfirmClick || "Are you sure?";
                    var clickAction = attr.confirmedClick;
                    element.bind('click',function (event) {
                        if ( window.confirm(msg) ) {
                            scope.$eval(clickAction)
                        }
                    });
                }
            };
    }])

setTimeout(compareTime, 3000);

   // ();
  setInterval(function() { compareTime(); }, 1000*60);

  function compareTime() {
        var givenTime =  <?php echo $total_time; ?>;
        // console.log(givenTime);
        var hour  =  $(".hours").text();
        var minute = $(".minutes").text();
        var totalMintue = parseInt(hour*60) + parseInt(minute);
        console.log(totalMintue);
        if(givenTime != 0){
        if(totalMintue >= givenTime){
           $("#exam-form").submit();
        }
      }
    }

</script>



<div class="maincontent" id="wrapper">
  <div class="overlay"></div>
    <section class="section_instruct">
      <div class="container-fluid">
	 	<div class="col-md-12" ng-controller="appController">
	 	
	 <!-- ************ Exam Details ******* !-->		
   		  
 <!-- ************ENd Exam Details ******* !-->		

 		<div class = "col-md-8 header_question_exam" >


          <div class ="exam_details hidden-sm" ng-init="examDetails;fetchExamQuestions()" style="margin-top:20px">  

               <div class = "detail_heading head_span uppercase ">  <@ examDetails.exam_name  @>  </div> 
           </div>

           

           <div class = "exam_submit_header_div">
            {{ Form::open(array('route' =>['submit-exam', $en_eId],"class" => "form-horizontal","id" => "exam-form"))  }}
              <div class = "question_process_color pull-right question_mark_details">
                <div class = "">
                    <div class="timer_data alert alert-danger alert-dismissible " id="myAlert">
                        <div class="stopwatch" data-autostart="false">
                            <div class="time">
                               <span class="hours" ></span> :
                                <span class="minutes" ></span>  :
                                <span class="seconds"></span> 
                            </div>
                          </div>
                    </div>
                </div> 
                <div class="numberCircle bg-primary"> 15 </div>
                  <div class="postitive_mark"> <a > <@ quizWithClass.question.marks @>  </a>  </div>
                  <div class="negative_mark" ng-show="quizWithClass.question.negative_marks > 0">
                       <a > <@ quizWithClass.question.negative_marks @>  </a> 
                  </div>
                   <button type = "button" confirmed-click="submitExam()" ng-confirm-click="Are you really sure?"  style="position: relative;top: -5px;" style="position: relative;top: -5px;" class="btn btn-exam-custom btn-success submitexam" id="submitExam"   >Submit Exam</button>
                   
                 
                </div>
             {{ Form::close() }}
            </div> 


          <div class="mycontainer question_section">
            <form method="post" ng-submit="submitForm()", class = "form-horizontal">
            	 <div class = "questions"  >
            	  <span ng-bind-html = "quizWithClass.question.encoded_question"> </span>            	 	  
            	 </div>
          
                 <div class = "options">
                  <div class = "opt_data question_count_div panel" ng-repeat = "(key, value) in quizOptions">
                     <input type ="radio" ng-model = "model.answer" value = "<@ value.id @>" class ="rdo_opt" id = "<@ value.id @>" name = "answer" 
                      ng-checked="(oldAnswer == value.id)"
                     > 
                       <span class = "options_span" ng-bind-html = "value.question_option "> </span> 
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

          
      
             <div class = "col-md-4  report navbar navbar-inverse navbardum-fixed-top show__mob" id ="sidebar-wrapper"  role="navigation" >
             <fieldset class="scheduler-border">
                 <legend class="scheduler-border">Exam Details</legend>
           		   <table id="customers" class="table table-hover" style="width:80%;margin:auto"  ng-init="examDetails;">
                    <tr>
                      <th> Time </th>
                      <td> <@ examDetails.time @>   </td>
                    </tr>
                     <tr>
                      <th>Total Question </th>
                      <td>  <@ examDetails.total_question @>  </td>
                    </tr>
                     <tr>
                      <th> Total Mark </th>
                      <td>  <@ examDetails.total_marks @>  </td>
                    </tr>
                     <tr>
                      <th> Total Time </th>
                      <td>  <@ examDetails.time @>  </td>
                    </tr>
                  </table> 

             </fieldset>
                        <legend class="scheduler-border">Test Monitor</legend>
          			   <div >
              			<span ng-repeat="(key, value) in quizWithClass.question_class">
              	   				 <a ng-click="directQuestion(key)" href = "JavaScript:void(0);" id = "<@ key @>"  class = "circle numberic-custom <@ value @>" >
              	      	    		<span>  <@ $index+1 @> </span>
              			        </a>
          		        </span> 
          			</div>
           

          	</div>
          <!-- ************ End Question Iritation  ******* !-->
          <button  type="button" class="hamburger open-nav  is-closed animated fadeInLeft hide_in_lap">
            <span class="hamb-top"></span>
            <span class="hamb-bottom"></span>
          </button>
       </div>
     </div>
  </section>
</div>



@endsection