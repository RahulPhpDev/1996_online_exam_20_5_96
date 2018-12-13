<style>

.coupon {
  border: 1px dotted #bbb;
  width: 80%;
  border-radius: 1px;
  /* margin: 0 auto; */
  max-width: 600px;
}

.upcoming_container {
  padding: 2px 16px;
  background-color: #f1f1f1;
}

.promo {
  background: #ccc;
  padding: 3px;
}
.begin {
  color: green;
  font-size:140%;
}
.expire {
  color: red;
  font-size:140%;
  padding:3px 3px 0px 3px ;
  margin:0px 0px 8px 0;
}

#marquee_exam {
	overflow-x: marquee-line;
	marquee-style: scroll;
	marquee-speed: fast;
}
.going_on{
    color:green;
    font-size:150%;

}
</style>
<section class="section mycontainer">
	
<div class="container"> 
<h2 class="text-center font_bold m0">Upcoming Exam		</h2>
<div class="mb50"></div>
		<div class="row col-p30">
@foreach($upcomingExams as $exam)
    <div class = "col-sm-5">
        <div class="coupon">
            <div class="upcoming_container">
            <h3>{{ $exam['exam_name']}}</h3>
            </div>
            @php  $pic = (!is_null($exam['image'])) ? '/images/exam/thumbnail/'.$exam['image'] : '/images/exam/exam_icon_2.png';  @endphp
        <div class = "text-center"> <img style = "max-width:120px;  height: 95px;" src="{{ asset( $pic )}}" >  </div>
            <div class="upcoming_container" style="background-color:white">
            <h2><b></b></h2> 
            <p><?php echo htmlspecialchars_decode(substr($exam['description'] , 0 , 130)) ?></p>
            </div>
        <div class="upcoming_container text-center">
       @php
            $sdate = extractDateTime('Y-m-d',$exam['start_date']) ; 
               $startDate =  ( $sdate == date('Y-m-d')) ? '' : $sdate ;
             $isBetween =   isDateInBetween($exam['start_date'],$exam['end_date'] );
             if($isBetween){
                $text= "Take Exam";
                $btnClass = "btn-success";
             }else{
                $text= "View More Details";
                $btnClass = "btn-primary";
             }
            
           @endphp
        @if($isBetween == false)
         <p class="begin">Start At: <?php echo $startDate; ?>
           <?php echo extractDateTime('H:i a',$exam['start_date']) ?>
        </p>
        @else
        <p id = "marquee_exam"  class="going_on"> Going On</p> 
        @endif

             @php
            $edate = extractDateTime('Y-m-d',$exam['end_date']) ; 
               $endDate =  ( $sdate == date('Y-m-d')) ? '' : $sdate ;
           @endphp
            <p class="expire">Expire At: <?php echo $endDate;  ?>
              <?php echo extractDateTime('H:i a',$exam['end_date']) ?>
           </p>

            <a href="{{ route('exam-instruction', ['id' => Crypt::encrypt($exam['id']) ]) }}"><button type = "button" class = "button {{$btnClass}} btn-custom"> {{$text}} </button></a> 
        </div>
       
     </div>
    </div>
   @endforeach 

   </div>
</div>
</section>