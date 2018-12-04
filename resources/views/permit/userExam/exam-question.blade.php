@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  


<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
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

    <div class="item-container">    
     <div class="container"> 
      <div class="col-md-12">
      <div class="quiz">
      <div class="quiz_header">
       
        <h5> <?php echo $resultData->Exam->exam_name; ?> </h5>

      </div>
         
         <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q : </span>
              <span class="inline question">
                <p>
                 <?php echo $resultData->Exam->exam_name?>
                </p>
              </span>

              <?php
              foreach($resultData->Exam->ExamQuestion as $examQuestion){

echo $examQuestion->question;
               ?>


              <?php } ?>
             
             
            </div>
         

            </div>
          
        </div

      </div>
     </div>
    </div>


        </div>
</div>
@endsection