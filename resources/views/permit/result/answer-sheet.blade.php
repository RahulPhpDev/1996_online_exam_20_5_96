
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

<link href="{{ asset('frontend/css/exam_question.css') }}" rel="stylesheet"> 
<style type="text/css">
  


</style>
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

  <div class="maincontent">
    <section class="section">
      <div class="container">
    <div class="row">
           <div class = "col-md-10">
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
        </div>
      </section>    
</div>
@endsection
