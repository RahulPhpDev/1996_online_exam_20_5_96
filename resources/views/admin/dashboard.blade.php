@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<script src="{{ asset('js/backend_js/matrix.js') }}"></script>

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
          <div class="row-fluid" ng-controller="dashboardController">
            
            <div class="span12">
              <ul class="site-stats">
                <a  href="{{route('users')}}"> <li class="bg_lh"><i class="icon-user"></i> <strong>{{$data['userCount']}}</strong> <small>Total Users</small></li></a>
                <a  href="{{route('exam')}}"> <li class="bg_lh"><i class="icon-plus"></i> <strong>{{$data['ExamCount']}}</strong> <small>Total Exam </small></li></a>
                <a  href="{{route('subscription')}}"><li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>{{$data['packageCount']}}</strong> <small>Total Package</small></li></a>
              </ul>
            </div>

            

          <div class="span12" style="margin: 50px">
             <label class="label">Select Date: </label>
                    {{ Form::text('start_date', ' ',array('class' =>'dd', 'id' => 'datepicker',"autocomplete"=>"off"))}}
  

   
             <label class="label">Select Date: </label>
                    {{ Form::text('start_date', ' ',array('class' =>'datepicker', 'id' => '',"autocomplete"=>"off",'ng-change'=>"dataByDate()",'ng-model'=>"date" ))}}

               <label class="label">Chart Type: </label>
                   <select ng-model="chartType" ng-options="chartType.name for chartType in chartTypes" ng-init="chartType=chartTypes[0]" ng-change="myChart.type=chartType.type">
               </select>
               <div style="border:1px solid lightblue;width:50%;height:400px" google-chart chart="myChart"></div>
        
        <!-- Chart items -->
                 <div style="text-align:center;font-size:25px"> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr/>
    
  </div>
</div>
<style type="text/css">
  svg > g:last-child > g:last-child { pointer-events: none }
div.google-visualization-tooltip { pointer-events: none }
</style>
<script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker( {
                format: "mm-yyyy",
                startView: "months", 
                minViewMode: "months"
            });
        });

  app.controller("dashboardController", ['$scope','chartService','$http',
    function ($scope,chartService,$http) {
        $scope.myChart = chartService;
        $scope.chartTypes=chartService.chartTypes;
   
  $scope.chartData =<?php echo $resultData; ?>;
    $scope.init = function(){
      console.log('akd'+$scope.chartData);
        angular.forEach($scope.chartData, function(value, key) {
          // console.log(value.exam_name);
           $scope.myChart.addColumn(value.exam_name,parseInt(value.total));
        });
      }
      $scope.init();

      $scope.dataByDate = function(){
       $http.get("result_by_date/"+$scope.date)
                .then(function(response) {
                    $scope.myChart.clearChart();
                  console.log(response.data);
                  $scope.chartData = response.data;
                    $scope.init();
                });
      }

    }

    
  ]);
</script>
<!--end-main-container-part-->
@endsection