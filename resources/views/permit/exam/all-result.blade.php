@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  


<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
                <style type="text/css">

.res_table{margin:20px 0px 10px 10px;font-size:18px;}
.report_th, .report_td{ width:43%;text-align:right;  }
.report_th >span ,.report_td >span{margin-right:18%}
</style>



<section class="section mycontainer" style="position: relative;background-image: url('{{ asset('frontend/img/tab/ee8fc908ad2c41c023a0755b4c6486b3.jpg') }}') ;background-size: cover;min-height: 500px;text-align: center;">

	<div class="mb50"></div>
		<div class="container home">
			<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
				<h1 class="text-center font_bold m0" style="color: #fff"> Maarula Online Exam</h1>
				<p class="text-center" style="color: #fff"><p>The most Powerful Examination</p></p>
			
			</div>
		</div>	
		<div class="mb50"></div>
	
</section>

    <div class="item-container">    
     <div class="container"> 
      <div class="col-md-12">
    

<table class = "table res_table">
    <tr>
        <th>Exam</th>
        <th class = "report_th"><span> Reports </span></th>
        <th>Last Date</th>
    </tr>

    @foreach($resultData as $res)
    <tr>
       <?php
    // dd($res->Exam);
    ?>
        <td>{{$res->Exam['exam_name']}}</td>
        <td class = "report_td" > <span> <a href = "{{ route('exam-result', ['id' => Crypt::encrypt($res->Exam['id']) ]) }}">{{$res->total}} View</a> </span></td>
        <td>{{ DateManipulation($res->add_date)}}</td>
     </tr>
     @endforeach
    </table>
      </div>
     </div>
    </div>


        </div>
</div>
@endsection