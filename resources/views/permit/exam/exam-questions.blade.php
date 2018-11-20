
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 
<!-- tex2jax: {
      inlineMath: [['$','$'], ['\\(','\\)']],
      ignoreClass: "math-editor", // put this here
      ShowMathMenu: false,
    } -->
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
           <div class="mycontainer question_section">
             <div class = "questions">
                <span> <?php echo htmlspecialchars_decode($questionDetails->question); ?> </span>
             </div> 
           
          {{-- Form::open(array('route' => ['save-answer',$examId],'class' => 'form-horizontal', 'id'=>'basic_validate'))--}} 

            {{ Form::open(array('route' => 'save-answer','class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
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
             <div class = "mt-10"> </div>
             <div class="controls">
                @if($questionDetails->is_required == 0)
                 <button name="save" type="submit" class="btn btn-success" value="skip">Skip</button>
		           @endif
                <button name="save" type="submit" value="continue" class="btn btn-success">Save And Next Question</button>
            </div>

             </div>

             {{ Form::close() }}
           </div>

           <div class = "col-md-5 report">
        
        <div class="report_section">

         <span class=""> <h2> Total Question </h2> </span>

           <!-- <div class="col-md-3">
              <a class="answered"> 1 </a>
          </div>
         <div class="col-md-3">
            <a class="answered_escape"> 2 </a>
         </div>

         <div class="col-md-3">
            <a class="pending"> 3 </a>
         </div>  -->

        


       <?php 
       $i = 1;
      //  dd($all_questions_class);
       foreach($all_questions_class as $question_id => $class) { ?>
         
         <div class="col-md-3">
            <a class="{{$class}}"> {{$i}} </a>
         </div>
         <?php $i++; } ?>
        </div>
          </div>
        </div>
      </section>    
</div>
@endsection
