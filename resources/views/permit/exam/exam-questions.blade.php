
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

var diff = '<?php echo $difference; ?>';
    
 if( diff != 0){

var result = ('<?php echo $difference; ?>').split(':');
// alert(res)
$(".hours").text(result[0]);
$(".minutes").text(result[1]);
$(".seconds").text(result[2]);
  watchfun();
}else{
  watchfun();
}

  $(document).on("click",".opt_data",function(){
    
      $(this).find('input[type="radio"]').prop('checked', true);
    });


    $(document).on("click",".savebtn",function(){
      var btnVal = $(this).val();
      $("#saveu").val(btnVal);
    });

     $(document).on("click",".numberic",function(){
      var btnId = $(this).attr('id');
      questionRedirect(btnId);
    });
    
    function questionRedirect(questionId){
    // alert('rahu;l');
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
        console.log(data);
                if(data === 'view-result'){
                window.location = '/view-result' ;

                }else{
                $("#question_list").html(data);
                }
              },
              error: function (data) {
                  console.log('An error occurred.');
                  // console.log(data);
              },
      })
    }


  var frm = $('#basic_validate');

    $(document).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        frm.submit();
    });

    frm.submit(function (e) {
    console.log( frm.serialize());
        e.preventDefault();

        var valf = $(this).value;
        //alert(valf);
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
             if(data === 'view-result'){
                     window.location = '/view-result' ;
                    }
              $("#question_list").html(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });
  });


</script>

  <div class="maincontent">
    <section class="section">
      <div class="container-fluid">
	 	<div class="col-md-12">

<div class = " col-sm-2  col-sm-offset-10">
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
            <div class = "questions">
                <span> <?php echo htmlspecialchars_decode($questionDetails->question); ?> </span>
             </div> 
              <div class = "options">
                @foreach($questionDetails->Options as $data)
                 <div class = "opt_data">
                    <input type ="radio" class ="rdo_opt" name = "answer" value = "{{$data['id']}}"> 
                    <span class = "options_span"> 
                       {{$data->question_option}}
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

                <button name="save" type="submit" value="continue" class="btn btn-success savebtn">Save</button>

                <button name="save" type="submit" value="preview" class="btn btn-primary savebtn">Preview</button>
                 </div>
                {{ Form::close() }}
              </div>
             </div>

              
     <div class = "col-md-4 hidden-sm report">
      <div class = "question_process_color">
      <div> <a class="answered_count current"> C </a> <span> Current </span> </div>
           <div> <a class="answered_count answered">30</a> <span> Answered </span> </div>
           <div> <a class="answered_count review">30</a> <span> Review </span> </div>
           <div> <a class="answered_count not_visited">30</a> <span>Not Visited </span> </div>

           <div> <a class="answered_count not_answered">30</a> <span>Not Answered </span> </div>
     </div>
     <div class = "question_count_div panel"> <h2>  Question </h2> </div>
       <?php 
          $i = 1;
          foreach($all_questions_class as $question_id => $class) { ?>
           <a href = "JavaScript:void(0);" id = "{{$question_id}}" class = "numberic {{$class}} ">
              <span  >   {{$i}} </span>
            </a> 
          <?php $i++; } ?>
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
