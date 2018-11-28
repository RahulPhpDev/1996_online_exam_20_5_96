@php
$userData = Auth::user();
@endphp
<div style="width:720px; height:480px;margin:auto; padding:10px; text-align:center; border: 10px solid #787878;margin-top:20px;margin-bottom: 20px ">
<div style="width:650px; height:420px; padding:20px; text-align:center; border: 5px solid #787878">
       <span style="font-size:50px; font-weight:bold">Certificate of Completion</span>
       <br><br>
       <span style="font-size:25px"><i>This is to certify that</i></span>
       <br><br>
       <span style="font-size:30px"><b>{{$userData['fname'].' '.$userData['lname']}}</b></span><br/><br/>
       <span style="font-size:25px"><i>has completed the Exam</i></span> <br/><br/>
       <span style="font-size:30px">{{$data->Exam->exam_name}} </span> <br/><br/>
       <span style="font-size:20px">with score of <b>{{$data->obtain_mark}}</b></span> <br/><br/><br/>
       <span style="font-size:25px"><i>dated</i></span><br>
     {{ date("F j, Y")}}  <br>
      <span style="font-size:10px"><i>MaaRula Classess</i></span>
</div>