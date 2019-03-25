
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
           <div class = "col-md-8">
           <div class="mycontainer" style="overflow-y: scroll; height:800px;">
            @if(!empty($resultDataWithDetails))
              @foreach($resultDataWithDetails as $key => $question )
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

                <?php
                  $bgClass = '';
                 $checkForOk = true;
                  $wrongIcon = '<i class = "glyphicon glyphicon-ok"> </i>';
                  $rightAnswerIcon = '<i class = "glyphicon glyphicon-user"> </i>';
                  
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
                       $bgClass = 'user_answer';
                     }
                    }
                     if($question['question_right_answer'] == $options->id ){
                      // echo $rightAnswerIcon;
                       $bgClass = 'question_answer';
                     }
                     if($question['user_right_answer'] == $options->id ){
                      // echo $rightAnswerIcon;
                       $bgClass = 'user_answer';
                     }

                  if(($question['user_right_answer'] == $options->id) && ($question['question_right_answer'] == $options->id)){
                       $bgClass = 'right_user_answer';
                  }
               ?>

                  <div class="options_div {{ $bgClass }}">
                        
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

          <div  class = "col-md-4 col-sm-4">
              <fieldset class="scheduler-border">
                 <legend class="scheduler-border">Result Details</legend>
                 <table id="customers" class="table table-hover" style="width:80%;margin:auto" >
                    <tr>
                      <th> Exam </th>
                      <td> {{ $resultData->Exam->exam_name }}   </td>
                    </tr> <tr>
                      <th> Time Taken </th>
                      <td> {{  $resultData['time_taken'] }}   </td>
                    </tr>
                     <tr>
                      <th>Total Question </th>
                      <td>  {{ $resultData->Exam->total_question}}  </td>
                    </tr>
                     <tr>
                      <th> Attempt Question </th>
                      <td>  {{ $resultData->Exam->total_question + $resultData['not_attempt'] }}  </td>
                    </tr>
                     <tr>
                      <th> Mark </th>
                      <td>  {!! $resultData['obtain_mark']  .'/'.$resultData->Exam->total_marks !!}  </td>
                    </tr>
                    <tr>
                      <th> Attempt On </th>
                      <td>  {!! extractDateTime('d-M-Y',$resultData['add_date']) !!}  </td>
                    </tr>

                    <tr>
                      <th> Result Status </th>
                      <td>  
                      @php
                        $status = ($resultData['result_status'] == 1) ? 'Pass':'Better Luck For Next';
                        echo $status;
                       @endphp 
                      </td>
                    </tr>

                  </table> 

             </fieldset>
          </div>
      </div>
  </section>    
</div>
@endsection
