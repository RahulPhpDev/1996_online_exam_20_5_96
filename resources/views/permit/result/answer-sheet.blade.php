
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
    top: 14px;
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
              @foreach($resultData as $key => $question )
               <?php //dd($question);
              ?>
               <div class="show_question">  
                <div class="question_data">
                  <span class="question_number"> Q {{++$key }}: </span>
                  <span class="inline question">
                      <?php echo  htmlspecialchars_decode($question['question']); ?>
                   
                  </span>
                </div>
                @foreach( $question['option'] as $options)
                  <div class="options_div">
                        <?php
                           $checkForOk = true;
                            $wrongIcon = '<i class = "glyphicon glyphicon-remove"> </i>';
                            $rightAnswerIcon = '<i class = "glyphicon glyphicon-ok"> </i>';
                            if((isset($question['user_right_answer'])) && $question['question_right_answer'] == $options->id ){
                                if($question['user_right_answer'] == $options->id){
                                    $wrongIcon = $rightAnswerIcon ;
                                    $checkForOk = false;
                                }
                                echo $wrongIcon;
                              }
                             if($checkForOk === true){ 
                              if($question['user_right_answer'] == $options->id ){
                                echo $rightAnswerIcon;
                               }
                              }
                         ?>
                     <span class="answer">
                      <?php echo  htmlspecialchars_decode($options->question_option); ?> 
                    </span>               
                </div>
              @endforeach

               @if($question['mark_status']  > 0)
                  <div class="option_footer"> 
                   <?php
                    $bgColor = ($question['mark_status']  == 1) ? 'postitive_mark':'negative_mark';
                   ?>
                  
                   <span class="pull-right">  <div class = {{$bgColor}}><a> {{$question['mark'] }} </a> </div></span>
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
