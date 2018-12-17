@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)

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

<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class = "span8">
           <div class="mycontainer">
            <h2> {{$resultData[0]->exam_name}} </h2>
            @foreach($resultData as $key => $result )

      <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q {{++$key }}: </span>
              <span class="inline question">
                  <?php echo  htmlspecialchars_decode($result->question); ?>
               
              </span>
            </div>
         

            <div class="options_div">
                <span class="answer">
                 @if($result->question_option === NULL) 
                    <span class="text-danger">  Not Ansered </span>
                 @else
                    <?php echo  htmlspecialchars_decode($result->question_option); ?> </span>
                 @endif
            </div>
            </div>
            @endforeach
             </div>
           </div>

    <div class="span3">
    <div class="accordion-group widget-box" style = "margin-top:60px">
            <div class="accordion-heading">
              <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse"> <span class="icon"><i class="icon-ok"></i></span>
                <h5>Details</h5>
                </a> </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                
                <div class="widget-content nopadding updates">
            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
             <div class="update-done"><span class="update-day"><strong>Exam : </strong></span></div>
              <div class="update-date"><strong>{{$resultData[0]->exam_name}}</strong></div>
              </div>
            </div>


            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
               User
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$resultData[0]->fname.' '.$resultData[0]->lname }}</span></div>
            </div>
             
            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
            Time Taken
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$resultData[0]->time_taken}}</span></div>
            </div>

             <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
             Obtain Mark
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$resultData[0]->obtain_mark}}</span></div>
            </div>

          
          </div>
              </div>
            </div>
          </div>
</div>

    </div>
</div>
@endsection
