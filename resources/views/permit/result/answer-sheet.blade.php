
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

<link href="{{ asset('frontend/css/exam_question.css') }}" rel="stylesheet"> 

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
  .glyphicon{
    display: block;
    top: 11px;
    height: 0px;
    left: 11px;
    font-weight: 700;
  }
  .glyphicon-ok{
    color:green;
  }
  .glyphicon-remove{
    color:red;
  }
  .options_div > .answer {
    line-height: 2.3;
}
</style>

  <div class="maincontent">
    <section class="section">
      <div class="container">
    <div class="row">
           <div class = "col-md-10">
           <div class="mycontainer">
            @if(!empty($resultData))
            <h2> {{--$resultData[0]->exam_name--}} </h2>

          @foreach($resultData->Exam->userAnswer[0]->ExamQuestion as $key => $question )

           <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q {{++$key }}: </span>
              <span class="inline question">
                  <?php echo  htmlspecialchars_decode($question['question']); ?>
               
              </span>
            </div>
         <?php
         $userAnswerStatus = $resultData->rightAnswerByResultId($userId, $question->id);
          foreach($question->Options as $options){
            ?>

            <div class="options_div">
          <?php
           $checkForOk = true;
            
            $wrongIcon = '<i class = "glyphicon glyphicon-remove"> </i>';
            $rightAnswerIcon = '<i class = "glyphicon glyphicon-ok"> </i>';
            if((isset($userAnswerStatus->answer_id)) && $userAnswerStatus->answer_id == $options['id'] ){
                if($question->rightAnswer['option_id'] == $options['id']){
                    $wrongIcon = $rightAnswerIcon ;
                    $checkForOk = false;
                }
                echo $wrongIcon;
              }
             if($checkForOk === true){ 
              if($question->rightAnswer['option_id'] ==$options['id'] ){
                echo $rightAnswerIcon;
               }
              }
          ?>

            <span class="answer">
                <?php echo  htmlspecialchars_decode($options['question_option']); ?> 
              </span>               
            </div>
            <?php
               }
            ?>
            @if($userAnswerStatus->status  > 0)
            <div class="option_footer"> 
             <?php
              $bgColor = ($userAnswerStatus->status == 1) ? 'postitive_mark':'negative_mark';
             ?>
            
             <span class="pull-right">  <div class = {{$bgColor}}><a> {{$userAnswerStatus->mark}} </a> </div></span>
           </div>
           <div class="clearfix"></div>
           @endif

            </div>
            @endforeach
            @else
              <h3 class="text-danger"> No Data to Show </h3>
            @endif
             </div>


           </div>
        </div>
      </section>    
</div>
@endsection
