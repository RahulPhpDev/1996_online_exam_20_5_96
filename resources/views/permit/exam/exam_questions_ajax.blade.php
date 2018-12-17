

<script src="{{ asset('js/backend_js/jquery.min.js') }}"></script>

<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  

<script type="">
  MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>

<script type="text/javascript">
$(function(){
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


var i = setInterval(function() { compareTime(); }, 1000*62);



$(document).on("click",".opt_data",function(){
    $(this).find('input[type="radio"]').prop('checked', true);
  });

  $(document).on("click","#submitExam",function(){
      window.location = '/view-result' ;
    });

  $(document).on("click",".savebtn",function(){
    var btnVal = $(this).val();
    $("#saveu").val(btnVal);
  });



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
              $.ajax({
                  type: frm.attr('method'),
                  url: frm.attr('action'),
                  data: frm.serialize(),
                  success: function (data) {  
                  var chkToast = '<?php echo $showToast ?>';                  
                      if(chkToast == 1) {
                         myFunction();
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
         

         <div class = "col-md-8" >
        <div class="mycontainer question_section">
       
            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 

            <div class = "question_process_color pull-right question_mark_details">
                  
                  <div class="postitive_mark"> <a > {{$questionDetails->marks}}  </a>  </div>
                 @if($questionDetails->is_negative_marking) <div class="negative_mark"> <a > - {{$questionDetails->negative_marks}}</a>  </div>@endif
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
                    <input type ="radio" class ="rdo_opt" {{$checked}} name = "answer" value = "{{$data['id']}}"> 
                    <span class = "options_span"> 
                    <?php echo htmlspecialchars_decode($data->question_option); ?>
                      </span> 
                </div>
                @endforeach
              </div>
             <div class = "mt-10"> </div>
             <div class="controls">
               
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
           <div> <a class="answered_count current">C </a> <span> Current </span> </div>
           <div> <a class="answered_count answered"> A </a> <span> Answered </span> </div>
           <div> <a class="answered_count review">R </a> <span> Review </span> </div>
           <div> <a class="answered_count not_visited">NV </a> <span>Not Visited </span> </div>

           <div> <a class="answered_count not_answered">NA</a> <span>Not Answered </span> </div>
     </div>
     <div class = "question_count_div panel"> <h2>  Question </h2> </div>
       <?php 
          $i = 1;
          foreach($all_questions_class as $question_id => $class) { 
            if($question_id){
              if(session('current_question') == $question_id){
                $class = 'current';
              }else{
              if(session()->has('questions_answer.'.$question_id)){
                if(session('questions_answer.'.$question_id) > 0){
                  $class = 'answered';
                } else if(session('questions_answer.'.$question_id) == 0){
                  $class = 'not_answered';
                } 
                else if(session('questions_answer.'.$question_id) == -1){
                  $class = 'review';
                }
              }
             }
            ?>

           <a href = "JavaScript:void(0);" id = "{{$question_id}}" class = "numberic {{$class}} ">
              <span  >   {{$i}} </span>
            </a> 
          <?php $i++;}  } ?>
        </div>
