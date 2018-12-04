@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  

  <style type="text/css">

.action_div{
  display:none;
}
.action_div {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
}
.action_div a {
  width:60px;
  padding:5px;
  margin:0px 2px 0px 2px;
}
.add_more_question{
  padding:4px;
  margin-right:10px;
}

.quiz{overflow-y:scroll; max-height:730px;}
.other_info > h5 {
  display: inline-block;
  width: 190px;
grid-template-columns: max-content max-content;
grid-gap:5px;
text-align:right;
margin-right:10px;
}

.other_info > h3:after { content: ":"; }
.other_info > h4{ display:inline-block;}

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
<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">

  <div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')    
<div class="row-fluid">
  <div class="col-sm-8 col-sm-offset-4">
    <div class="quiz">
      <div class="quiz_header">
       
        <h5>ghfghf </h5>
      </div>

  @php $questionNumber = 1; @endphp
    @foreach($resultData as $examQuestion) 
       <div class="show_question">  
        <div class="question_data">
          <span class="question_number"> Q {{$questionNumber}}: </span>
          <span class="inline question">
            <p>
            <?php echo  htmlspecialchars_decode($examQuestion->question); ?>
              </p>
             </span> 
             </div>
            </div>  
              {{$examQuestion->question_option}}
  @php $questionNumber++; @endphp
            @endforeach
          </div>
       </div>
    </div>
   </div>

@endsection