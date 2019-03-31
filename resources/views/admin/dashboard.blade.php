@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<script src="{{ asset('js/backend_js/matrix.js') }}"></script>
<script src= "{{asset('js/chart_loader.js') }}"></script>
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="javascript::void(0)" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
   
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Site Analytics</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            
            <div class="span12">
              <ul class="site-stats">
                <a  href="{{route('users')}}"> <li class="bg_lh"><i class="icon-user"></i> <strong>{{$data['userCount']}}</strong> <small>Total Users</small></li></a>
                <a  href="{{route('exam')}}"> <li class="bg_lh"><i class="icon-plus"></i> <strong>{{$data['ExamCount']}}</strong> <small>Total Exam </small></li></a>
                <a  href="{{route('subscription')}}"><li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>{{$data['packageCount']}}</strong> <small>Total Package</small></li></a>
              </ul>
            </div>

            <div class="span12">
              <select   >
                <option value="today">Today</option>
                <option value="today">Yesterday</option>
              </select>
              <div id="piechart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr/>
    
  </div>
</div>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
 
function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Language', 'Rating'],
      <?php
      if(count($resultData) > 0){
          foreach($resultData as $u){
            echo "['".$u->exam_name."', ".$u->total."],";
          }
      }
      ?>
    ]);
    
    var options = {
        title: 'Exam taken Today',
        width: 500,
        height: 500,
        pieSliceText: 'value-and-percentage',
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    
    chart.draw(data, options);
}
</script>
<!--end-main-container-part-->
@endsection