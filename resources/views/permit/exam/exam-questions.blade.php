
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    tex2jax: {
      inlineMath: [['$','$'], ['\\(','\\)']],
      ignoreClass: "math-editor" // put this here
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
                
                <button name="save" type="submit" class="btn btn-success" value="skip">Skip</button>
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
         </div> -->

         @for($i = 1; $i <= $examDetails['total_question']; $i++)

        <div class="col-md-3">
            <a class=""> {{$i}} </a>
         </div>
         @endfor
        
        </div>
          </div>
        </div>
      </section>    
</div>
@endsection