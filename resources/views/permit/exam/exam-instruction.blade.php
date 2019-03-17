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
  width: 60%;
}
tr{
  border-bottom: 1px dashed #ddd;
}
th, td {
  padding: 5px;
  text-align: left;
  /*border-bottom: 1px solid #ddd;*/
}

.top_rank_head{
  padding-top: 9px !important;
color: #17120a;
font-weight: bold;
font-size: 200%;
font-family: initial;
}
  .btndiv{ margin-left: -50px;
      margin-left: -50px;
    background: #eee;
    padding: 20px;
    box-shadow: 0 0 9px -4px;
    border-radius: 20px;}
.buttonDetailsLeft li {
    margin: 10px 0;
    list-style: none;
    font-size: 19px;
}
.buttonDetailsLeft li .btn{
  width: 30%;
}
.let_start_btn{
      margin: 18px 2px;
    font-size: 18px;
    font-weight: 500;

}
.form_absolute{
  /* position: absolute;
    padding: 1px;
    top: 99px;
    /* left: 0px; */
    /* right: 107px; */ */
}
</style>
  <div class="maincontent">
    <section class="section_instruct">
      <div class="container">
	 	<div class="row justify-content-start">
      <div class = "row">
       @if(!empty($topTen->toArray())) 
        <h3 class ="top_rank_head hidden-sm"> Top Rank </h2>
        <div class = "col-sm-4 hidden-sm topper_section">
          @foreach($topTen as $top ) 
            <div class = "topper_div">
              <div class = "user_pic">
                <?php
                  if(!$top->User['profile_image']){
                    $profilePic  = ucwords($top->User['fname'][0].' '.$top->User['lname'][0]);
                    ?>

                   <div class="topper_div_img avatarbox material_avatar showtip tooltipstered" style="background-color: #106eca">{{ $profilePic}}</div>
                   <?php
                    }else{
                        $profilePic = '/images/profile/thumbnail/'.$top->User['profile_image'];
                    ?>
                    <img src="{{ asset( $profilePic )}}"  class="avatarbox material_avatar profile_img"/>

                      <?php } ?>
                
                  <h4> {{$top->User['fname'].' '.$top->User['lname']}} </h4>
              </div>

                <div class = "mark_data">
                    <span class = "obtain_mark">  {{$top->max}} </span>
                    <span class = "total_mark">  {{$examData->total_marks}} </span>
                </div>
            </div> 
            @endforeach  
        </div>
        @endif

      


        <div class = "col-sm-6 col-sm-offset-1 exam_inspect" >
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



<!-- Buuton Know -->
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
            <form action = "{{route('attempt-exam', ['id' => Crypt::encrypt($examData->id)])}}" method = "GET"  class = " form_absolute" >
                <input class = "btn btn-success btn-custom let_start_btn" type = "Submit" value =  "Lets Start">
            </form>
            @endif
  <!-- <div class="btndiv hidden-sm" >    
    <ul class="buttonDetailsLeft">
      <span> You can Hit enter after select answer </span>
      <h2 style="    font-weight: 600;"> Know Your Buttons </h2>
        <li>
             <button type = "button"  class = "btn btn-exam-custom btn-success" > Submit Exam  </button><span>Submit your exam</span>
           </li>
       <li><button name="save" class="btn btn-success savebtn btn-exam-custom" >Save And Next</button> Save Your Answer </li>
        <li> <button name="save"  class="btn btn-danger savebtn btn-exam-custom">Skip ANd Next </button><span> This will Erase/Skip Question</span>
       </li>
         <li> <button name="save"  class="btn btn-primary savebtn btn-exam-custom">Preview  And Next</button> <span>Answered Not Given</span>
      </li>
    </ul>
  </div> -->

  <!-- End Btn Div -->
      <div>
   
      </div>
   <div>
    
  </div>
            <div class = "clear"> </div>
           
            </div>
          </div>

           <!-- <div class = "col-sm-4 col-lg-4">
              <div class="btndiv hidden-sm" >    
                <ul class="buttonDetailsLeft">
                  <span> You can Hit enter after select answer </span>
                  <h2 style="    font-weight: 600;"> Know Your Buttons </h2>
                    <li>
                         <button type = "button"  class = "btn btn-exam-custom btn-success" > Submit Exam  </button><span>Submit your exam</span>
                       </li>
                   <li><button name="save" class="btn btn-success savebtn btn-exam-custom" >Save And Next</button> Save Your Answer </li>
                    <li> <button name="save"  class="btn btn-danger savebtn btn-exam-custom">Skip ANd Next </button><span> This will Erase/Skip Question</span>
                   </li>
                     <li> <button name="save"  class="btn btn-primary savebtn btn-exam-custom">Preview  And Next</button> <span>Answered Not Given</span>
                  </li>
                </ul>
               </div>
            </div> -->


        </div>
      </section>    
</div>
@endsection