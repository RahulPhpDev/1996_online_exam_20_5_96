
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
    var open = $('.open-nav'),
        close = $('.close'),
        overlay = $('.overlay');

    open.click(function() {
        overlay.show();
        $('#wrapper').addClass('toggled');
    });

    close.click(function() {
        overlay.hide();
        $('#wrapper').removeClass('toggled');
    });
});

</script>

  <div class="maincontent"  id="wrapper">

   <div class="overlay"></div>
          <div  class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation"> dfasdfas</div>

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
                <span> <p><img alt="" src="http://www.maarulaonlinetest.com/public/images/equation_icon/200.png" style="height:39px; width:387px" /></p> </span>
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

             
     
             <div class = "col-md-4 hidden-sm report">
      <div class = "question_process_color">
           <div> <a class="answered_count current">C</a> <span>  Current </span> </div>
           <div> <a class="answered_count answered"> A</a> <span>  Answered </span> </div>
           <div> <a class="answered_count review">R</a> <span>  Review </span> </div>
           <div> <a class="answered_count not_visited">NV</a> <span> Not Visited </span> </div>

           <div> <a class="answered_count not_answered">NA</a> <span>Not Answered </span> </div>
     </div>
     <div class = "question_count_div panel"> <h2>  Question </h2> </div>
     
           <a href = "JavaScript:void(0);" id = "104" class = "numberic current ">
              <span  >   1 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "105" class = "numberic pending ">
              <span  >   2 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "106" class = "numberic pending ">
              <span  >   3 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "107" class = "numberic pending ">
              <span  >   4 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "108" class = "numberic pending ">
              <span  >   5 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "109" class = "numberic pending ">
              <span  >   6 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "110" class = "numberic pending ">
              <span  >   7 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "111" class = "numberic pending ">
              <span  >   8 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "112" class = "numberic pending ">
              <span  >   9 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "113" class = "numberic pending ">
              <span  >   10 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "114" class = "numberic pending ">
              <span  >   11 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "115" class = "numberic pending ">
              <span  >   12 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "116" class = "numberic pending ">
              <span  >   13 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "117" class = "numberic pending ">
              <span  >   14 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "118" class = "numberic pending ">
              <span  >   15 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "119" class = "numberic pending ">
              <span  >   16 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "120" class = "numberic pending ">
              <span  >   17 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "121" class = "numberic pending ">
              <span  >   18 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "122" class = "numberic pending ">
              <span  >   19 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "123" class = "numberic pending ">
              <span  >   20 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "124" class = "numberic pending ">
              <span  >   21 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "125" class = "numberic pending ">
              <span  >   22 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "126" class = "numberic pending ">
              <span  >   23 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "127" class = "numberic pending ">
              <span  >   24 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "128" class = "numberic pending ">
              <span  >   25 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "129" class = "numberic pending ">
              <span  >   26 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "130" class = "numberic pending ">
              <span  >   27 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "131" class = "numberic pending ">
              <span  >   28 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "132" class = "numberic pending ">
              <span  >   29 </span>
            </a> 
          
           <a href = "JavaScript:void(0);" id = "133" class = "numberic pending ">
              <span  >   30 </span>
            </a> 
                  </div>
   


       </div>

        </div>

<button type="button" class="hamburger open-nav is-closed animated fadeInLeft">
        <span class="hamb-top"></span>
        <span class="hamb-middle"></span>
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

  @media (min-width: 320px) and (max-width: 480px) {
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
   
     padding-right:1px !important;
      padding-left:1px !important;
      }

      }



#wrapper {
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    -webkit-transition: all 0.5s ease;
    padding-right: 0;
    transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
    width: 300px;                       /* SZEROKOŚĆ SIDEBARA */
}

#sidebar-wrapper {
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    -webkit-transition: all 0.5s ease;
    background: #1a1a1a;                /* KOLOR SIDEBARA */
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    transition: all 0.5s ease;
    width: 0;
    z-index: 1000;
}

#sidebar-wrapper::-webkit-scrollbar {
    display: none;
}

.sidebar-nav {
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 0;
    width: 300px;     
  right: 0;/* SZEROKOŚĆ ZAWARTOŚCI SIDEBARA */
}

.sidebar-nav li {
    display: inline-block;
    line-height: 20px;
    position: relative;
    width: 100%;
}

.sidebar-nav li a {
    color: #dddddd;
    display: block;
    padding: 10px 15px 10px 30px;
    text-decoration: none;
}

.sidebar-nav .dropdown-menu {
    background-color: grey;             /* KOLOR BG DROPDOWNA */
    border-radius: 0;
    border: none;
    box-shadow: none;
    margin: 0;
    padding: 0;
    position: relative;
    width: 100%;
}

.sidebar-nav li a:hover,
.sidebar-nav li a:active,
.sidebar-nav li a:focus,
.sidebar-nav li.active a,
.sidebar-nav li.active a:hover,
.sidebar-nav li.active a:active,
.sidebar-nav li.active a:focus {
    background-color: transparent;
    color: red;
    text-decoration: none;
}

.sidebar-nav > .sidebar-brand {
    font-size: 20px;
    height: 65px;
    line-height: 44px;
}


.hamburger {
   background: red;
    border: none;
    display: block;
    height: 32px;
    margin-right: 15px;
    position: fixed;
    /*top: 20px;
    width: 32px;*/
    right: 0;
    z-index: 999;
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

.overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

/* FOR left side */
.navbar-fixed-top {
    left: auto;
}
</style>
@endsection
