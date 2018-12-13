@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')  
<style>
.exam_notes{
    font-size:17px;
}

.best_wish{
    margin-top:10px;
    color: #1ba73c;
    text-transform: capitalize;
    text-decoration: dashed;
    text-indent: inherit;
}
.clear{
    clear: both;
}
.desciption{
  width: 60%;
  /*//margin: auto;*/
  text-align: justify;
letter-spacing: .8px;
padding:2px 8px;
margin:25px 2px ;
/* box-shadow:2px 3px 4px #ddd; */
}

table {
  border-collapse: collapse;
  width: 50%;
}
tr{
  border-bottom: 1px dashed #ddd;
}
th, td {
  padding: 3px;
  text-align: left;
  /*border-bottom: 1px solid #ddd;*/
}
</style>
  <div class="maincontent">
    <section class="section">
      <div class="container">
	 	<div class="row justify-content-start">
           <div class = "col align-self-center ">
              <div class = "exam_notes">
              <div class = "info">
               <table>
                 <tr>
                    <th> Exam </th>
                    <td> {{$examData->exam_name}} </td>
                  </tr>
                   
                   <tr>
                    <th> Question </th>
                    <td> {{$examData->total_question}}</td>
                  </tr>
                   <tr>
                    <th> Total Mark </th>
                    <td> {{$examData->total_marks}}</td>
                  </tr> 
                  <tr>
                    <th> Required Passing Mark </th>
                    <td> {{$examData->minimum_passing_marks}} </td>
                  </tr>
                   <tr>
                    <th>Time </th>
                    <td> {{$examData->time}} Minute</td>
                  </tr> 

               </table>
              </div> 
              <div class = "desciption">
               <?php echo htmlspecialchars_decode($examData->notes); ?> 
              </div>
               <div  class=""> 
                    <h3 class = "best_wish"> ALL THE BEST <?php $userData = Auth::User(); echo $userData['fname'].' '.$userData['lname']; ?></h3>
                </div>
            </div>
            <div class = "clear"> </div>
            @php
             $hide = 0; 
              if($examData->particular_date){
                  $isBetween =   isDateInBetween($examData->start_date,$examData->end_date );
                  if($isBetween == false){
                    $hide = 1;
                  }
              }
           @endphp
           @if($hide == 0)   
            <form action = "{{route('get-exam', ['id' => Crypt::encrypt($examData->id)])}}" method = "GET" style="padding: 1px;">
                <input class = "btn btn-success" type = "Submit" value =  "Lets Start">
            </form>
            @endif
          
        </div>
      </section>    
</div>
@endsection