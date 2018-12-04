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

<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
                <style type="text/css">

</style>

    <div class="item-container">    
     <div class="container"> 
<h5>{{$resultData->Exam->exam_name}} </h5>

@foreach($resultData->Exam->ExamQuestion as $res)

  <div class = "col-sm-12">
      <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q </span>
              <span class="inline question">
                  <p>
                    <?php echo  htmlspecialchars_decode($res->question); ?>
                  </p>
                </div>

                <div class="options_div">
              <?php dd( $res->); ?>

                     <a> <?php// echo   $options->question_option; ?> </a>  
                    </div> 
                             </div>

              </div>  
            </div>
    
          
        @endforeach
      </div>
    
     </div>
    </div>
@endsection