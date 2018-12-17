@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content') 

<style type="text/css">

</style>

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
<link href="{{ asset('frontend/css/exam_question.css') }}" rel="stylesheet"> 
<style type="text/css">

</style>
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')    
<div class="row-fluid">
  <div class="span8">
    <div class="quiz">
      <div class="quiz_header">
       
        <h5>{{$title}}
 <a  href="{{ route('add-exam-question', ['exam_id' => $id ]) }}" class = "add_more_question  btn btn-success pull-right"> Add More Question </a>
        </h5>
      </div>
          <?php 
               $totalQuestion = $totalMark = $totalRequiredQuestion = $totalNegativeQuestion =$questionNumber =  0; 
                foreach($examQuestion['question'] as $que) { 
                $questionNumber++;
                $totalQuestion++;
                $totalMark = $totalMark + $que['question']->marks;
                  ?>
         <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q {{$questionNumber}}: </span>
              <span class="inline question">
                <p>
                 <?php echo  htmlspecialchars_decode($que['question']->question); ?>
                </p>
              </span>

 
             <div class = "action_div"> 
              <a  href="{{ route('edit-exam-question', ['id' =>  Crypt::encrypt($que['question']->question_id),'exam_id' => $id ]) }}" class = "edit_question btn  btn-og pull-right"> Edit  </a>

              <a  href="{{ route('remove-exam-question', ['id' =>  Crypt::encrypt($que['question']->id),'exam_id' => $id ]) }}" class = "remove_question  btn btn-danger pull-right"> Remove  </a>
            </div>
              @if($que['question']->is_required == 1)  
              <i class="icon-star text-error required_question" style="display: inline"></i>
               @endif
            </div>
         

            <div class="options_div">
              <?php foreach($que['options'] as $options) { ?>
                    <div class = "options options_rel_div" id = "option_question_id">
                      <?php 
                   
                      if($que['right_anser']->option_id ==  $options->id ) { ?>
                          <i class = "icon icon-ok"> </i> 
                      <?php } ?>

                     <a> <?php echo   $options->question_option; ?> </a>  
                    </div> 
                    <?php } ?> 
            </div>

           <div class = "other_question_information">
                <div class="marks inline">
                   Marks:   <?php echo $que['question']->marks; ?> 
                </div>
                   @if($que['question']->is_negative_marking == 1) 
                    <?php
                    $totalNegativeQuestion++;
                    ?>

               <div class="negative_marks inline">
                      Negative Marks:    <?php echo $que['question']->negative_marks; ?> 
                 </div>  

              @endif 
            </div> 
            </div>
              <?php } ?>
        </div>
      </div>

           <div class="span4" >
              <div class="widget-box collapsible">
          <div class="widget-title"> <a href="#collapseOne" data-toggle="collapse"> <span class="icon"><i class="icon-arrow-right"></i></span>
            <h5>Other Information</h5>
            </a>
          </div>
          <div class="collapse in" id="collapseOne">
            <div class="widget-content">
               {{ Form::open(array('route' => ['save-confirm-exam', $id],'class' => '', 'id'=>'basic_validate'))}}
               <div class="row">
                <div class="" >
                        <div class="other_info" >
                          <h5> Total Question : </h5>
                          <h4> <i>  {{$examQuestion['exam_details']->total_question}} </i> </h4> 
                       
                      </div>
                  
                      <div class="other_info" >
                      <h5>  Total Mark :</h5>
                           <h4> <i>  {{$examQuestion['exam_details']->total_marks}}</i> </h4> 
                      </div>

                      <div class="other_info" >
                        <h5>  Time :</h5>
                        <h4> <i>   {{$examQuestion['exam_details']->time}} </i> </h4> 
                      </div>

                       <div class="other_info" >
                       	@php
                       	$passingType = ($examQuestion['exam_details']->passing_marks_type ==1) ? ' ':' %';
                       	@endphp
                         <h5>  Passing Mark :</h5>
                         <h4> <i>    {{$examQuestion['exam_details']->minimum_passing_marks}}
                            {{ 	$passingType}} </i> </h4> 
                      
                      </div>

                        <!-- <div class="other_info" >
                        <h5>  Required Question :</h5>
                        <h4> <i>   {{--$examQuestion['exam_details']->required_question--}} </i> </h4> 
                      
                      </div> -->

                       <div class="other_info" >
                       <h5>  Total Negative Question :</h5>
                       <h4> <i>  {{$examQuestion['exam_details']->negative_question}} </i> </h4> 
                      
                      </div>
        			  </div>
              </div> 

              </div> 

             </div>
          </div>
         </div>
         </div>
       </div>
         </div>


    </div>

</div>
<script src="{{ asset('js/backend_js/math_ckeditor/ckeditor/ckeditor.js') }}"></script>
<script>
  


      $(document).ready(function(){
         $(".show_question").hover(function(){
          $(this).find(".action_div").css({"display": "inline"});
        }, function(){
          $(this).find(".action_div").css({"display": "none"});
    });

            CKEDITOR.editorConfig = function (config) {
          
      };
      CKEDITOR.replaceClass="editor";

      $(".is_negative").click(function(){
       if ($(this).is(':checked')) {
        var id = $(this).parent().parent().next('div').css("display", "block");
       }else{
        var id = $(this).parent().parent().next('div').css("display", "none");
       }
      });
        
    });
  </script>

  

  <!-- Modal -->
  <div class="modal fade" id="myModal"  role="dialog">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Question</h4>
        </div>
        <div class="modal-body" id = "model_body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection