@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@push('angular')
  @include('frontend_layouts.partials.fetch_angular')
  <link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet">
  <script src="{{ asset('js/jquery-confirm.min.js') }}"></script>
@endpush


@section('content') 

<link href="{{ asset('css/backend_css/exam_question.css') }}" rel="stylesheet">
<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
   
     showMathMenu: false,
  extensions: ["tex2jax.js"],
  jax: ["input/TeX", "output/HTML-CSS"],
  tex2jax: {
      skipTags: ["body"],
      processClass: "equation"
  }
  });
</script>

<style type="text/css">
	.inline_block div{
		display: inline-block;
	}

</style>


<script type="text/javascript">

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
           $scope.currentQuestionNumber = response.data.currentQuestionNumber + 1;
           <?php
           $cur = session($session_array_key.'current_question'); 
           // echo $cur;
           if(!session($session_array_key.'questions_answer'.$cur) > 0) {?>
           $scope.model.answer = '';
           console.log('cs');
           var fd = <?php echo session($session_array_key.'questions_answer'.session($session_array_key.'current_question')); ?>;
           console.log(f);
         <?php }else {
          ?>
console.log('hii');
          $scope.model.answer = <?php echo session($session_array_key.'questions_answer'.$cur);
         } ?>
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

$(function(){
  var autoSubmit = true;
setTimeout(compareTime, 3000);

   // ();
  setInterval(function() { compareTime(); }, 1000*30);

  function compareTime() {
        var givenTime =  <?php echo $total_time; ?>;
        // console.log(givenTime);
        var hour  =  $(".hours").text();
        var minute = $(".minutes").text();
        var totalMintue = parseInt(hour*60) + parseInt(minute);
        console.log(totalMintue);
        if(givenTime != 0){
        if(totalMintue >= givenTime){
           if(autoSubmit == true){
               submitFormWithComment('true');
             }
        }
      }
    }
  

$('#submitExam').on('click', function(){
  submitFormWithComment();  
});

function submitFormWithComment(disable = false){
  autoSubmit = false;
  $.confirm({
    title: 'Confirmation!',
    content: '' +
    '{{ Form::open(array("route" =>["submit-exam", $en_eId],"id" => "exam-form-pop"))  }}' +
    '<div class="form-group">' +
    '<label>Enter something here</label>' +
    '<textarea type="text" name = "comment" placeholder="any Comment" class="comment form-control" required />' +
    '</div>' +
    '{{ Form::close() }}',
    buttons: {
        formSubmit: {
            text: 'Submit Exam',
            btnClass: 'btn-blue',
            action: function () {
                var name = this.$content.find('.comment').val();
                if(!name){
                    $.alert('provide a valid Comment');
                    return false;
                }
              $('#load').show();
              $("#exam-form-pop").submit();
            }
        },
        formCancel: {
            text: 'Cancel',
            btnClass :'cancel_btn btn-danger',
            isDisabled: disable,
        },
        // cancel: function () {

        // },
    },
  
});
}

//============ END +++++++++++++++==========
   var navDum =$('.navbardum-fixed-top');
    // navDum.hide();
    var open = $('.open-nav'),
        close = $('.close'),
        overlay = $('.overlay');

    open.click(function() {
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

</script>



<div class="maincontent" id="wrapper">
  <div class="overlay"></div>
    <section class="section_instruct">
      <div class="container-fluid">
	 	<div class="row" ng-controller="appController">
	 	
	 <!-- ************ Exam Details ******* !-->		
   		  
 <!-- ************ENd Exam Details ******* !-->		

 		<div class = "col-md-8 header_question_exam" >


          <div class ="exam_details hidden-sm" ng-init="examDetails;fetchExamQuestions()" style="margin-top:20px">  

               <div class = "detail_heading head_span uppercase hidden-sm">  <@ examDetails.exam_name  @>  </div> 
           </div>

           

           <div class = "exam_submit_header_div">
           
              <div class = "question_process_color pull-right question_mark_details">
                <img src = "{{asset('frontend/timer.gif')}}" style="margin-right: 4px">
                <span class = "timer_data" id="myAlert">
                        <div class="stopwatch" data-autostart="false">
                            <div class="time">
                               <span class="hours" ></span> :
                                <span class="minutes" ></span>  :
                                <span class="seconds"></span> 
                            </div>
                    </div>
                </span> 
                  <div class="postitive_mark"> <a > <@ quizWithClass.question.marks @>  </a>  </div>
                  <div class="negative_mark" ng-show="quizWithClass.question.negative_marks > 0">
                       <a > <@ quizWithClass.question.negative_marks @>  </a> 
                  </div>
                   <button type = "button"   class="btn  btn-success submitexam" id="submitExam"   >Submit Exam</button>
                   
                 
                </div>
           
            </div> 

               
<div id = "load" style="display: none"></div> 

          <div class="mycontainer question_section">
            <form method="post" ng-submit="submitForm()", class = "form-horizontal">
            	 <div class = "questions">
               <div class="numberCircle bg-primary" >  <@ currentQuestionNumber @></div> 	  <span ng-bind-html = "quizWithClass.question.encoded_question"> </span>            	 	  
            	 </div>
          
                 <div class = "options"  >

               
                  <div class = "opt_data question_count_div panel" ng-repeat = "(key, value) in quizOptions">
                     <input type ="radio" ng-model = "model.answer" value = "<@ value.id @>" class ="rdo_opt" id = "<@ value.id @>" name = "answer" 
                      ng-checked="(oldAnswer == value.id)"
                     > 
                       <span class = "options_span" ng-bind-html = "value.question_option "> </span> 
                    </div>
                     
                 </div>
          
                <div class = "mt-10"> </div>
                <div class="controls quiz_action"> 
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
<a href="JavaScript:void(0);" class="close circle close_circle hide_in_lap"><i class="fa fa-close" style="color:red  ;  font-size: 25px;" ></i></a>
              <div class = "ans_mode">
                <div class ="sec_1">
                  <a class="circle current">C</a> <span>  Current </span>
                    <a class="circle answered"> A</a> <span>  Answered </span> 
                   <a class="circle review hidden-sm">R</a> <span>  Review </span> 
               </div>
              <div class ="sec_2">  
                   <a class="circle not_visited">NV</a> <span> Not Visited </span> 
                   <a class="circle not_answered">NA</a> <span>Not Answered </span> 
            </div>

     </div>

           
                <fieldset class="scheduler-border">         
                 <legend class="scheduler-border">Test Monitor</legend>

          			   <div >
                      
              			<span ng-repeat="(key, value) in quizWithClass.question_class">
              	   				 <a ng-click="directQuestion(key)" href = "JavaScript:void(0);" id = "<@ key @>"  class = "circle numberic-custom <@ value @>" >
              	      	    		<span>  <@ $index+1 @> </span>
              			        </a>
          		        </span> 
          			</div>
           </fieldset>

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

<div id="snackbar">You Have Taken all The Questions. Now You Can Review Your Answer Or Submit Exam By Clicking Button....</div>

@endsection