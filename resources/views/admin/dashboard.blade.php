@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<script src="{{ asset('js/backend_js/matrix.js') }}"></script>
<!-- <script src= "{{asset('js/chart_loader.js') }}"></script> -->
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

            <div class="span12">
              <select ng-change=""  >
                <option value="today">Today</option>
                <option value="today">Yesterday</option>
              </select>
               <label class="label">Chart Type: </label>
                   <select ng-model="chartType" ng-options="chartType.name for chartType in chartTypes" ng-init="chartType=chartTypes[0]" ng-change="myChart.type=chartType.type">
               </select>
               <div style="border:1px solid lightblue;width:100%;height:100%;" google-chart chart="myChart"></div>
        
        <!-- Chart items -->
        <div style="text-align:center;font-size:25px">
     
        </div>
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
  app.controller("dashboardController", ['$scope','chartService',
    function ($scope,chartService) {
        $scope.myChart = chartService;
        $scope.chartTypes=chartService.chartTypes;
   
    $scope.init = function(){
        $scope.employees =<?php echo $resultData; ?>;
        angular.forEach($scope.employees, function(value, key) {
           $scope.myChart.addColumn(value.exam_name,parseInt(value.total));
        });
      }
      $scope.init();
    }
  ]);
</script>
<!--end-main-container-part-->
@endsection