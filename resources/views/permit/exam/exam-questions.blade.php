
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 




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
<script type="text/javascript">
 

  $(function () {
    console.log(' check');
    // $('#myModal').modal('show');
    var diff = '<?php echo $difference; ?>';
    if( diff != 0){
      watchfun(diff);
    }else{
      watchfun(diff);
    }

compareTime();
var i = setInterval(function() { compareTime(); }, 1000*62);
    function compareTime() {
        var givenTime =  '<?php echo session('total_time'); ?>';
        // console.log(givenTime);
        var hour  =  $(".hours").text();
        var minute = $(".minutes").text();
        var totalMintue = parseInt(hour*60) + parseInt(minute);
        if(givenTime != 0){
        if(totalMintue >= givenTime){
          window.location = '/view-result' ;
        }
      }
    }



  $(document).on("click",".opt_data",function(){
      $(this).find('input[type="radio"]').prop('checked', true);
    });


    $(document).on("click",".savebtn",function(){
      var btnVal = $(this).val();
      $("#saveu").val(btnVal);
    });

    $(document).on("click","#submitExam",function(){
      window.location = '/view-result' ;
    });

     $(document).on("click",".numberic",function(){
      var btnId = $(this).attr('id');
      questionRedirect(btnId);
    });
    
    function questionRedirect(questionId){
    $.ajax({
      url: "/get-question",
      type: 'POST',
      // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
      data: {
        _method: 'POST',
        que_id : questionId,
        _token:     '{{ csrf_token() }}'
      },
      success: function (data) {
                if(data === 'view-result'){
                  alert(' You Have Taken All The Test Please Now Click and Review Your Answer Or You Can Submit Exam.. ');
                }else{
                $("#question_list").html(data);
                }
              },
              error: function (data) {
                  console.log('An error occurred.');
              },
      })
    }


  var frm = $('#basic_validate');

    $(document).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (!$("input[name='answer']:checked").val()) {
               $("#saveu").val('skip');
            }
            else {
              $("#saveu").val('continue');
             }
        frm.submit();
    });

    frm.submit(function (e) {
        e.preventDefault();

        var valf = $(this).value;
        //alert(valf);
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
             if(data === 'view-result'){
              //  var ch = alert(' Are YOur Sure to Submit Test');
              //  if(ch){
                window.location = '/view-result' ;
              //  }
                   
                    }
              $("#question_list").html(data);
            },
            error: function (data) {
                console.log('An error occurred.');
            },
        });
    });
  });


</script>


  <div class="maincontent">
    <section class="section">
      <div class="container-fluid">
	 	<div class="col-md-12">
     <div class = "col-md-8">
       <div class ="exam_details">                 
                      <div class = "inline_block">  <div class = "detail_heading">  Time : <span> {{$examDetails->time}} </span></div> </div>
                      <div class = "inline_block"><div class = "detail_heading">   Question : <span> {{$examDetails->total_question}}  </span> </div> </div>
                      <div class = "inline_block">  <div class = "detail_heading">   Mark : <span> {{$examDetails->total_marks}}  </span> </div></div>
          <div class = "inline_block"><div class = "detail_heading head_span uppercase ">  {{$examDetails->exam_name}}  </div>   </div>
            </div>
        </div>

<div class = " col-sm-2  col-sm-offset-2">
      <div class="timer_data alert alert-danger alert-dismissible " id="myAlert">
          <div class="stopwatch" data-autostart="false">
              <div class="time">
                  <span class="hours"></span> : 
                  <span class="minutes"></span> : 
                  <span class="seconds"></span> 
              </div>
            </div>
      </div>
  </div>

<div class = "clear"></div>
   <div id = "question_list">   
      <div class = "col-md-8" >
        <div class="mycontainer question_section">
            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
            <div class = "question_process_color pull-right question_mark_details">
               <?php 
               
               session($questionDetails['id']);?>
                  <div class="postitive_mark"> <a > {{$questionDetails->marks}}  </a>  </div>
                 @if($questionDetails->is_negative_marking)
                  <div class="negative_mark"> <a > 
                   - {{$questionDetails->negative_marks}}</a>  </div>
                    @endif
                </div>
            <div class = "questions">
                <span> <?php echo htmlspecialchars_decode($questionDetails->question); ?> </span>
             </div> 
              <div class = "options">
                @php
                   $give_anser_id = false;
                   $anserId = 0;
                   if(session()->has('questions_answer')) {
                        if(session('questions_answer.'.$questionDetails['id'])){
                          $anserId = session('questions_answer.'.$questionDetails['id']);
                          $give_anser_id = true;
                        }
                      }
                  @endphp     
                @foreach($questionDetails->Options as $data)
                 <div class = "opt_data question_count_div panel">
                   @php
                   $checked = '';
                   if($give_anser_id === true) {
                        if($anserId == $data['id']){
                          $checked = 'checked';
                        }
                      }
                   @endphp
                    <input type ="radio" class ="rdo_opt" {{ $checked}} name = "answer" value = "{{$data['id']}}"> 
                    <span class = "options_span"> 
                    <?php echo htmlspecialchars_decode($data->question_option); ?>
                      </span> 
                </div>
                @endforeach
              </div>
             <div class = "mt-10"> </div>
             <div class="controls">
               <?php
               /*if($questionDetails->is_required == 0)
                 <button name="save" type="submit" class="btn btn-success" value="skip">Skip</button>
		           endif
               */?>
                <!-- <input type = "submit" name = "save" value = "continue" class = "btn btn-success">
              <input type = "submit" name = "save" value = "preview" class = "btn btn-success"> -->
             
                <input type = "hidden" name = "save" id = "saveu">

                <button name="save" type="submit" value="continue" class="btn btn-success savebtn btn-exam-custom">Save And Next</button>

                <button name="save" type="submit" value="preview" class="btn btn-primary savebtn btn-exam-custom">Preview  And Next</button>

                <button name="save" type="submit" value="skip" class="btn btn-danger savebtn btn-exam-custom">Skip ANd Next </button>
                <div class = "pull-right">
                  <button type = "button"  class = "btn btn-exam-custom btn-success" id = "submitExam"> Submit Exam </button>
                </div>
                 </div>
                {{ Form::close() }}
              </div>
             </div>

             
     <div class = "col-md-4 hidden-sm report">
      <div class = "question_process_color">
           <div> <a class="answered_count current">C</a> <span>  Current </span> </div>
           <div> <a class="answered_count answered"> A</a> <span>  Answered </span> </div>
           <div> <a class="answered_count review">R</a> <span>  Review </span> </div>
           <div> <a class="answered_count not_visited">NV</a> <span> Not Visited </span> </div>

           <div> <a class="answered_count not_answered">NA</a> <span>Not Answered </span> </div>
     </div>
     <div class = "question_count_div panel"> <h2>  Question </h2> </div>
       <?php 
          $i = 1;
          foreach($all_questions_class as $question_id => $class) { 
            if($question_id){
              ?>
           <a href = "JavaScript:void(0);" id = "{{$question_id}}" class = "numberic {{$class}} ">
              <span  >   {{$i}} </span>
            </a> 
          <?php $i++; } } ?>
        </div>
       </div>

        </div>

        
      </section>    
</div>



<style type="text/css">
  
  .question_count_div {
    
    margin-top: 10px;
    box-shadow: 0px 0px 2px 0px #DDC;
    padding: -10px 0px;
}
.question_count_div h2 {
    padding: 6px 5px;
    font-size: 25px;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 600;
}
</style>
@endsection
