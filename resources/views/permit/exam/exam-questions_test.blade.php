
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')


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
 function mobileView(){
  $(".controls").find(".btn").removeClass('btn-exam-custom');
    $(".controls").find(".btn").each(function(){
      var text = $(this).text();
      var newstr=text.replace('And Next', '');
      $(this).text(newstr);
     });
 }
 function laptopView(){
  $(".controls").find(".btn").addClass('btn-exam-custom');
  $(".show__mob").show();
   $(".controls").find(".btn").each(function(){
        var text = $(this).text();
        var findText = 'And Next';
        if(text.indexOf(findText) == -1){
          var text= text + ' And Next';
        }
        
        if(!$(this).hasClass('submitexam'))
            {
              $(this).text(text);
            }
     });
 }
 $(window).resize(function() {
  var width = $(window).width();
   if(width <= 767){

    mobileView();
   } else {

    laptopView();
   }
});

  $(function () {   
    var width = $(window).width();
    if(width <= 767){
        mobileView();
      }
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

     $(document).on("click",".circle",function(){
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
                }else{
                   
                   $("#question_list").html(data);
                }
              },
               error: function (data) {
                  console.log(data);
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
               // window.location = '/view-result' ;
                   
                    }
              $("#question_list").html(data);
            },
            error: function (data) {
              console.log(data);
                console.log('An error occurred.');
            },
        });
    });
  });
   $(document).ready(function() {
    var navDum =$('.navbardum-fixed-top');
    // navDum.hide();
    var open = $('.open-nav'),
        close = $('.close'),
        overlay = $('.overlay');

    open.click(function() {
        overlay.show();
          navDum.show();
        $('#wrapper').addClass('toggled');
    });

    close.click(function() {
        navDum.hide();
        overlay.hide();
        $('#wrapper').removeClass('toggled');
    });
});

</script>

  <div class="maincontent"  id="wrapper">

   <div class="overlay"></div>

    <section class="section_instruct">
      <div class="container-fluid">
	 	<div class="col-md-12 question__data">
    <div class = "col-md-8 hidden-sm">
       <div class ="exam_details">                 
                <div class = "inline_block">  <div class = "detail_heading">  Time : <span> 10 </span></div> </div>
                <div class = "inline_block"><div class = "detail_heading">   Question : <span> 30  </span> </div> </div>
                <div class = "inline_block">  <div class = "detail_heading">   Mark : <span> 30  </span> </div>
          </div>
          <div class = "inline_block"><div class = "detail_heading head_span uppercase ">  Determinant speed test #01  </div>   </div>
            </div>
        </div>


<div class = " col-sm-1 col-md-2 col-sm-offset-2 ">
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
             <form method="POST" action="http://127.0.0.1:8000/save-answer" accept-charset="UTF-8" class="form-horizontal" id="basic_validate"><input name="_token" type="hidden" value="k1cL9Z6JOg2iG9g6uQ5N0HctzsQAE8g7qgBqvOJP"> 
            <div class = "question_process_color pull-right question_mark_details">
                                 <div class="postitive_mark"> <a > 1  </a>  </div>
                                      <button type="button" style="position: relative;top: -5px;" class="btn btn-exam-custom btn-success submitexam" id="submitExam"> Submit Exam </button>
                </div>
            <div class = "questions">
                <span> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </span>
             </div> 
              <div class = "options">
                     
                                 <div class = "opt_data question_count_div panel">
                                       <input type ="radio" class ="rdo_opt"  name = "answer" value = "397"> 
                    <span class = "options_span"> 
                    <p><img alt="" src="http://www.maarulaonlinetest.com/public/images/equation_icon/200a.png" style="height:17px; width:16px" /></p>                      </span> 
                </div>
                                 <div class = "opt_data question_count_div panel">
                                       <input type ="radio" class ="rdo_opt"  name = "answer" value = "398"> 
                    <span class = "options_span"> 
                    <p><img alt="" src="http://www.maarulaonlinetest.com/public/images/equation_icon/200b.png" style="height:19px; width:23px" /></p>                      </span> 
                </div>
                                 <div class = "opt_data question_count_div panel">
                                       <input type ="radio" class ="rdo_opt"  name = "answer" value = "399"> 
                    <span class = "options_span"> 
                    <p><img alt="" src="http://www.maarulaonlinetest.com/public/images/equation_icon/200c.png" style="height:23px; width:31px" /></p>                      </span> 
                </div>
                                 <div class = "opt_data question_count_div panel">
                                       <input type ="radio" class ="rdo_opt"  name = "answer" value = "400"> 
                    <span class = "options_span"> 
                    <p><img alt="" src="http://www.maarulaonlinetest.com/public/images/equation_icon/200dd.png" style="height:23px; width:36px" /></p>                      </span> 
                </div>
                              </div>
             <div class = "mt-10"> </div>
             <div class="controls">
                               <!-- <input type = "submit" name = "save" value = "continue" class = "btn btn-success">
              <input type = "submit" name = "save" value = "preview" class = "btn btn-success"> -->
             
                <input type = "hidden" name = "save" id = "saveu">
                
                <button name="save" type="submit" value="continue" class="btn btn-success savebtn btn-exam-custom"  data-toggle="tooltip" data-placement="top" title="Hooray!" >Save And Next</button>

                <button name="save" type="submit" value="preview" class="btn hidden-sm btn-primary savebtn btn-exam-custom">Preview  And Next</button>

                <button name="save" type="submit" value="skip" class="btn btn-danger savebtn btn-exam-custom">Skip And Next </button>
                <div class = "pull-right">
                </div>
                 </div>
                </form>

              </div>
             </div>

             
     
     <div class = "col-md-4  report navbar navbar-inverse navbardum-fixed-top show__mob" id ="sidebar-wrapper"  role="navigation">
        <div class = "ans_mode">
          <div class ="sec_1">
              <a class=" circle current">C</a> <span>  Current </span>
              <a class=" circle answered"> A</a> <span>  Answered </span> 
              <a class="circle review hidden-sm">R</a> <span>  Review </span> 
             </div>
             <div class="sec_2"> 
              <a class=" circle not_visited">NV</a> <span> Not Visited </span> 
             <a class=" circle not_answered">NA</a> <span>Not Answered </span> 
             </div>
       </div>
     <div class = "question_count_div panel"> <h2>  Question </h2> </div>
           <a href = "JavaScript:void(0);" id = "104" class = "circle current ">
              <span  >   1 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "105" class = "circle pending ">
              <span  >   2 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "106" class = "circle pending ">
              <span  >   3 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "107" class = "circle pending ">
              <span  >   4 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "108" class = "circle pending ">
              <span  >   5 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "109" class = "circle pending ">
              <span  >   6 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "110" class = "circle pending ">
              <span  >   7 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "111" class = "circle pending ">
              <span  >   8 </span>
            </a> 
          
           
            <a href="JavaScript:void(0);" class="close circle hide_in_lap"><i class="fa fa-close" style="color:red  ;  font-size: 25px;" ></i></a>
                  </div>

       </div>
        </div>

      <button type="button" class="hamburger open-nav is-closed animated fadeInLeft hide_in_lap">
        <span class="hamb-top"></span>
        <span class="hamb-bottom"></span>
      </button>
        
      </section>    
</div>

<div id="snackbar">You Have Taken all The Questions. Now You Can Review Your Answer Or Submit Exam By Clicking Button....</div>

<script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 7000);
}
</script>

<style type="text/css">
  #snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 1s, fadeout 4s 6s;
  animation: fadein 1s, fadeout 4s 6s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

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
.hamburger {
    background: #2d2626;
    border: none;
    display: block;
    height: 24px;
    margin-right: 15px;
    position: relative;
    /* top: 20px; */
    width: 32px;
    margin-top: 10px;
    right: 0;
    z-index: 999;
    /* bottom: 8px; */
    float: right;
}

.hamburger:hover,
.hamburger:focus,
.hamburger:active {
    outline: none;
}

.hamburger.open-nav:before {
    -webkit-transform: translate3d(0, 0, 0);
    -webkit-transition: all 0.35s ease-in-out;
    color: #ffffff;
    content: '';
    display: block;
    font-size: 14px;
    line-height: 32px;
    opacity: 0;
    text-align: center;
    width: 100px;
}

.hamburger.open-nav:hover before {
    -webkit-transform: translate3d(-100px, 0, 0);
    -webkit-transition: all 0.35s ease-in-out;
    display: block;
    opacity: 1;
}

.hamburger.open-nav:hover .hamb-top {
    -webkit-transition: all 0.35s ease-in-out;
    top: 0;
}

.hamburger.open-nav:hover .hamb-bottom {
    -webkit-transition: all 0.35s ease-in-out;
    bottom: 0;
}

.hamburger.open-nav .hamb-top {
    -webkit-transition: all 0.35s ease-in-out;
    background-color: rgba(255, 255, 255, 0.7);
    top: 5px;
}

.hamburger.open-nav .hamb-middle {
    background-color: rgba(255, 255, 255, 0.7);
    margin-top: -2px;
    top: 50%;
}

.hamburger.open-nav .hamb-bottom {
    -webkit-transition: all 0.35s ease-in-out;
    background-color: rgba(255, 255, 255, 0.7);
    bottom: 5px;
}

.hamburger.open-nav .hamb-top,
.hamburger.open-nav .hamb-middle,
.hamburger.open-nav .hamb-bottom {
    height: 4px;
    left: 0;
    position: absolute;
    width: 100%;
}


.report a {
    display: inline-block;
}

.circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 16px;
    color: #fff;
    line-height: 30px;
    text-align: center;
    background: #000;
    /* padding: 2px; */
    margin: 13px;
}

.navbardum-fixed-top {
    height: 700px;
    overflow: scroll;
}
</style>
@endsection
