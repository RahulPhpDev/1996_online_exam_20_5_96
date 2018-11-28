
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 


<script>
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}
</script>

<div style="width:800px; height:570px;margin:auto; padding:20px; text-align:center; border: 10px solid #787878;margin-top:20px;margin-bottom: 20px ">
<div style="width:750px; height:520px; padding:20px; text-align:center; border: 5px solid #787878">
       <span style="font-size:50px; font-weight:bold">Certificate of Completion</span>
       <br><br>
       <span style="font-size:25px"><i>This is to certify that</i></span>
       <br><br>
       <span style="font-size:30px"><b>{{$userData['fname'].' '.$userData['lname']}}</b></span><br/><br/>
       <span style="font-size:25px"><i>has completed the Exam</i></span> <br/><br/>
       <span style="font-size:30px">{{$examDetails['exam_name']}} </span> <br/><br/>
       <span style="font-size:20px">with score of <b>{{$totalMark}}</b></span> <br/><br/><br/>
       <span style="font-size:25px"><i>dated</i></span><br>
     {{ date("F j, Y")}}  <br>
      <span style="font-size:10px"><i>MaaRula Classess</i></span>
</div>
</div>
@endsection