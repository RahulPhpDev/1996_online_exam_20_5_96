
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

<style type="text/css">
  .question_section {
    box-shadow: 0 0 2px rgba(0,0,0,0.6);
    -moz-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    /* -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.6); */
    -o-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    margin: 10px 6px 3px 10px;
    min-height: 163px !important;
}
.love p{
  margin: 0 0 0px 19px;
}
.love{
      display: block;
    padding-top: 19px;
}
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
    <div class="col-md-12">
           <div class = "col-md-7">
           <div class="mycontainer">

  @php $questionNumber = 1; @endphp
    @foreach($resultData as $examQuestion)   
           <div class="question_section">
           <div class = "hate"> 
             <div class = "questions">
                <span class = "love"> <?php echo  htmlspecialchars_decode($examQuestion->question); ?> </span>
             </div> 
              <div class = "options">
                 <div class = "opt_data">
                    <span class = "options_span"> 
                       {{$examQuestion->question_option}}
                      </span> 
                </div>
                  @php $questionNumber++; @endphp
                   </div>
                 </div>
              </div>
                @endforeach
              
             </div>
           </div>
        </div>
      </section>    
</div>
@endsection
