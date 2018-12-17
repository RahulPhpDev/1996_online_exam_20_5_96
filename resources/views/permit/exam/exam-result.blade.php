@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  
<script type="text/javascript">
  $(function(){
  })
</script>

<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
  <style type="text/css">

.res_table{margin:20px 0px 10px 10px;font-size:18px;}
.report_th, .report_td{ width:70%;text-align:right;  }
.report_th >span ,.report_td >span{margin-right:18%}

tr:nth-child(even) {background-color: #f2f2f2;}

</style>

@component('homepage.page_top')@endcomponent  


    <div class="item-container">    
     <div class="container"> 
      <div class="col-md-12">
    

<table class = "table res_table">
    <tr>
         <th> Date</th>
        <th ><span class = "center"> Total Mark </span></th>
        <th ><span class = "center"> Obtain Mark </span></th>
        <th ><span class = "center">Status </span></th>
        <th ><span class = "center">Answer Sheet </span></th>
        <th ><span class = "center">Download Pdf </span></th>
       
    </tr>
    <tbody>
    @foreach($resultData as $res)
    <tr>
        <td>{{ DateManipulation($res->add_date)}}</td>
        <td > <span class = "center"> {{$res->Exam->total_marks}} </span></td>
        <td > <span class = "center"> {{ $res->obtain_mark}} </span></td>
        @php
          $passingStatus = ($res->result_status == 2) ? 'Fail' : 'Pass'; 
        @endphp
        <td > <span class = "center"> {{$passingStatus}}</span></td>
        <td class = "center"> <a href = "{{route('answer-sheet',['id'=>Crypt::encrypt($res->id)])}}" > Details</a></td>
        <td ><span class = "center"><a href = "{{ route('download-exam-pdf', ['id' => Crypt::encrypt($res->id) ]) }}" class ="button btn btn-success"> Download </a> </span></td>
     </tr>
     @endforeach
</tbody>
    </table>  <?php echo $resultData->render(); ?>

      </div>
    
     </div>
    </div>


        </div>
</div>
@endsection