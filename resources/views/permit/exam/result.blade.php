
@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

<style type="text/css">
    .btn_class{ margin: 12px 4px;}

.top__section_res{
    width:800px; height:570px;margin:auto; padding:20px; text-align:center; border: 10px solid #787878;margin-top:20px;margin-bottom: 20px
}

.header__section__res{
  width:750px; height:520px; padding:20px; text-align:center; border: 5px solid #787878
}

.span__header{
  font-size:50px; font-weight:bold
}
.span__certify{
  font-size:25px
}
.span__username{
font-size:30px
}
.span__complation{
  font-size:25px
}
.span__examname{
  font-size:30px
}
.span__mark{
font-size:20px
}
.span__date{
  font-size:25px
}
.span__footer{
  font-size:10px
}

@media (min-width: 300px) and (max-width: 767px) {
    .top__section_res{
      width: 322px;
        height: 574px;
        margin: auto;
        padding: 20px;
        text-align: center;
        border: 3px solid #787878;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .header__section__res{
      width: 257px;
      height: 520px;
      padding: 5px;
      text-align: center;
      border: 1px solid #787878;
    }
  
.span__header{
  font-size:31px; font-weight:bold
}
.span__certify{
  font-size:17px
}
.span__username{
font-size:20px
}
.span__complation{
  font-size:22px
}
.span__examname{
  font-size:14px
}
.span__mark{
font-size:15px
}
.span__date{
  font-size:10px
}
.span__footer{
  font-size:10px
}
}

</style>
<div class="pull-right btn_class" style = "margin-bottom:10px;overflow: " > 
      <a href = "{{route('answer-sheet',['id'=>Crypt::encrypt($r_id)]) }}" class="btn btn-og btn-exam-custom pull-right">Check AnserSheet</a> </div>
<div class = "top__section_res" style=" ">
<div class = "header__section__res" style="">
       <span style="" class = "span__header">Certificate of Completion</span>
       <br><br>
       <span  class = "span__certify" style=""><i>This is to certify that</i></span>
       <br><br>
       <span style="" class = "span__username"><b>{{$userData['fname'].' '.$userData['lname']}}</b></span><br/><br/>
       <span style="" class = "span__complation"><i>has completed the Exam</i></span> <br/><br/>
       <span style="" class = "span__examname">{{$examDetails['exam_name']}} </span> <br/><br/>
       <span style="" class = "span__mark">with score of <b>{{$totalMark}}</b></span> <br/><br/><br/>
       <span style=""  class = "span__date"><i>dated</i></span><br>
      {{date("F j, Y")}}  <br>
      <span style="" class = "span__footer"><i>MaaRula Classess</i></span>
</div>
</div>
@endsection