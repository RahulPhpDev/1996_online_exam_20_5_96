@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')  
<style type="text/css">
  .editor{
    width: 30x;
    height:40px;
  }
  .article-post{
    padding:10px;  
  }

  .span4{
    /*border:1px solid red;*/
  }
/*.required_question{
  font-size: 7px;
    color: red;
    position: relative;
    top: 9px;float: inherit;margin: 5px;
}*/
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
<link href="{{ asset('frontend/css/exam_question.css') }}" rel="stylesheet"> 

<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Exam Detail</h5>
         
              <div class = "pull-right">
              <a href="{{route('exam')}}" type = "button" class = "btn btn-og"> Exam </a>
              </div>
               </div>
          <div class="widget-content">

            <div class="row">
                <div class="" >
                        <div class="other_info" >
                          <h5> Total Question : </h5>
                          <h4> <i>  {{$examDetails->total_question}} </i> </h4> 
                       
                      </div>

                    
                   @if(count($examDetails->Subscriptions))     
                     <div class="other_info" >
                      <h5>  Package :</h5>                           
                       @foreach($examDetails->Subscriptions as $name)
                        <h4> <i> {{$name->name}}</i> </h4> 
                      @endforeach
                      </div>
                    @endif  

                   @if(count($examDetails->Courses))   
                      <div class="other_info" >
                      <h5>  Course :</h5>
                       @foreach($examDetails->Courses as $course)
                        <h4> <i> {{$course->name}} | </i> </h4> 
                      @endforeach
                      </div>
                      @endif
                  
                      <div class="other_info" >
                      <h5>  Total Mark :</h5>
                           <h4> <i>  {{$examDetails->total_marks}}</i> </h4> 
                      
                      </div>

                       <div class="other_info" >
                        @php
                        $passingType = ($examDetails->passing_marks_type ==1) ? ' ':' %';
                        @endphp
                         <h5>  Passing Mark :</h5>
                         <h4> <i>    {{$examDetails->minimum_passing_marks}}
                            {{  $passingType}} </i> </h4> 
                      
                      </div>

                        <div class="other_info" >
                        <h5>  Required Question :</h5>
                        <h4> <i>   {{$examDetails->required_question}} </i> </h4> 
                      
                      </div>

                       <div class="other_info" >
                       <h5>  Total Negative Question :</h5>
                       <h4> <i>  {{$examDetails->negative_question}} </i> </h4> 
                      
                      </div>
                </div>
              </div> 
      
          </div>
        </div>

    </div>
  </div>
@endsection