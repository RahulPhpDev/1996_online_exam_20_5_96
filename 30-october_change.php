<?php
public function examQuestion($id = 0){
    	 $id = 1;
    	 $examDetails = Exam::find($id);
    	 $questionData = $examDetails->ExamQuestion[0];
         $questionDetails	= Question::find($questionData['id']);
        //  dd($questionDetails->question);
        //  dd($questionDetails->Options);
        // foreach($questionDetails->Options as $data){
            // echo($data->question_option).'<br><br>';
        // }

    	$nextQuestionId = $examDetails->ExamQuestion[1]['id'];
       
        $passArray = array('examDetails' => $examDetails,
         'questionDetails' => $questionDetails,
         'nextQuestionId' => $nextQuestionId ,
            'id' =>  $id,
        );
        return view('guest.exam-questions',$passArray);
    }

    public function saveAnswer($examId, Request $request){      
        $nextQuestionId = $request['nxt'];
        $questionID = $request['questionId'];
        echo  $questionID;
        $answerID = $request['answer'];
        
       $questionDetails =  Question::find($questionID);
    //    dd( $questionDetails);
    //    dd($questionDetails->rightAnswer->option_id);

       
       $id = $nextQuestionId;
       $examDetails = Exam::find($id);
       $questionData = $examDetails->ExamQuestion[0];
       $questionDetails	= Question::find($questionData['id']);
      //  dd($questionDetails->question);
      //  dd($questionDetails->Options);
      // foreach($questionDetails->Options as $data){
          // echo($data->question_option).'<br><br>';
      // }

      $nextQuestionId = $examDetails->ExamQuestion[1]['id'];
     
      $passArray = array('examDetails' => $examDetails,
       'questionDetails' => $questionDetails,
       'nextQuestionId' => $nextQuestionId ,
          'id' =>  $id,
      );
      return view('guest.exam-questions',$passArray);
    }

    Route::match(array('GET','POST'),'save-answer/{id}', 'Auth\UserController@saveAnswer')->name('save-answer');


    @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  
<style>
.questions{
    display:inline;
}
.questions span{
    font-size:22px;
    padding:10px 0px 8px 27px; 
}

.options{
    padding:10px 0px 8px 30px;
    line-height:35px; 
}
.options_span{
    padding-left:10px ; 
   font-size:20px;
}
.question_section{
    box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -moz-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -o-box-shadow: 0 0 10px rgba(0,0,0,0.6);
}
  .report{
            background-color: #cce0ff;
            /*border:1px solid black;*/
            padding:30px 20px 25px 20px;
              box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -moz-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.6);
    -o-box-shadow: 0 0 10px rgba(0,0,0,0.6);
/*none|h-offset v-offset blur spread color |inset|initial|inherit;*/
        }
            .report_section a {
                    border: 1px solid #404040;
                    padding: 8px 12px 7px 12px;
                    line-height: 15px;
                    border-radius: 30%;
                    margin-top: 10px;
                    display: block;
                    text-align: center;
                    font-size: 18px;
                    color: #6666ff;
                    font-weight: 620;
                     /*background: #fff;*/
                }
                .answered{
                    /*border: 2px solid #993300 !important;*/
                    background: #00cc00;
                    color:#ffffff !important;
                    border:none !important;
                 /* border-bottom:5px solid #666 !important;
                  border-left: 2px solid transparent !important; 
                 border-right: 5px solid transparent!important;
                   */
                  border-radius:30% !important;
                }
                .answered_escape{
                       background: #ff7733;
                    color:#ffffff !important;
                     border:none !important;
                }
                .mt-10{
                    margin-top:10px;
                }
        </style>
  <div class="maincontent">
    <section class="section">
      <div class="container">
	 	<div class="col-md-12">
           <div class = "col-md-7">
           <div class="mycontainer question_section">
             <div class = "questions">
                <span>  {{ $questionDetails->question}}  </span>
             </div> 
           
             {{ Form::open(array('route' => ['save-answer', $id],'class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
                
             <input type = "hidden" value = "{{$nextQuestionId}}" name = "nxt">
                <input type = "hidden" value = "{{$questionDetails->id}}" name = "questionId">

              <div class = "options">
                @foreach($questionDetails->Options as $data)
                 <div class = "opt_data">
                    <input type ="radio" class ="rdo_opt" name = "answer" value = "{{$data['id']}}"> 
                    <span class = "options_span">  {{$data->question_option}} </span> 
                </div>
                @endforeach
              </div>

              
             <div class = "mt-10"> </div>
             <div class = "mt-10"> </div>
             <div class="controls">
                {{ Form::submit('Save and Continue',array('class' => 'btn btn-success')) }}
            </div>
            


             </div>

             {{ Form::close() }}
           </div>

           <div class = "col-md-5 report">
        
        <div class="report_section">

         <span class=""> <h2> Name: Rahull </h2> </span>

         

         <div class="col-md-3">
          <a class="answered"> 1 </a>
         </div>
         <div class="col-md-3">
        <a class="answered_escape"> 2 </a>
         </div>
        
        </div>


          </div>
        </div>
      </section>    
</div>
@endsection

// MODEL?
public function rightAnswer(){
    return  $this->hasOne(QuestionRightAnswer::class,'question_id');
 }