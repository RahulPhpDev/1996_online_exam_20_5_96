
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



  var frm = $('#basic_validate');

$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
     frm.submit();
});

    frm.submit(function (e) {
    console.log('submit');
        e.preventDefault();
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


<style type="text/css">
  
  .time {
    position: relative;
    /*top: 36px;*/
}
.timer_data{
       background: rgba(226, 226, 226, 0.21);
   /* border-radius: 50%;
    height: 120px;
    width: 120px;
   */ text-align: center;
    /*border: 3px solid #f4a909c4;*/
    font-weight: bold;
    font-size: 16px;
    color: #000;
    }

    .numberic {
        display: inline-block;
    width: 11%;
    /* padding: 25px; */
    /* width: 50px; */
    height: 35px;
    border-radius: 50%;
    background: #ccc;
    margin: 20px;
}
  .numberic a {
       text-align: center;
    position: relative;
    top: 7px;
    left: 15px;
    font-size: 15px;
    font-weight: bold;
    font-family: sans-serif;
    color: #fff !important;
}
.skip{
  background: #ff3333 !important;
  color: #fff !important;
}
.answered{
  background: #39ac39!important;
  color: #fff !important;
}
.pending{

}
.review{
  background: #3377ff !important;
  color: #fff !important;
}
</style>
  <div class="maincontent">
    <section class="section">
      <div class="container">
	 	<div class="col-md-12">

<div class = " col-sm-2  col-sm-offset-10">
      <div class="timer_data alert alert-danger alert-dismissible " id="myAlert">

  <div class="stopwatch" data-autostart="false">
      <div class="time">
          <span class="hours"></span> : 
          <span class="minutes"></span> : 
          <span class="seconds"></span> 
          
      </div>
      <div class="controls">
          
       </div>
     </div>
   </div>
    
  </div>


           <div class = "col-md-7">
        <div class="mycontainer question_section">
          <div id = "question_list">   
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
                <!-- <input type = "submit" name = "save" value = "Save" class = "btn btn-success"> -->
                <button name="save" type="submit" value="continue" class="btn btn-success">Save</button>
                 </div>
                {{ Form::close() }}
              </div>
             </div>
           </div>

              
     <div class = "col-md-4 col-sm-offset-1 hidden-sm report">
       <?php 
          $i = 1;
          foreach($all_questions_class as $question_id => $class) { ?>
           <div class = "numberic">
              <a>   {{$i}} </a>
            </div>
          <?php $i++; } ?>
        </div>



        </div>
      </section>    
</div>
@endsection
