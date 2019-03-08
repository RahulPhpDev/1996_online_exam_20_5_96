@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@extends('frontend_layouts.partials.fetch_angular')

@section('content')  


<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
                <style type="text/css">

.res_table{margin:20px 0px 10px 10px;font-size:18px;}
/*.report_th, .report_td{ width:43%;text-align:right;  }
.report_th >span ,.report_td >span{margin-right:18%}*/
</style>


<div class="item-container">    
 <div class="container"> 
  <div class="col-md-12" ng-controller ="feedbackController">
			<table class = "table res_table">
				    <tr>
				        <th>Subject</th>
				        <th class = "report_th"><span> Message </span></th>
				        <th class = ""><span> Last Message Date </span></th>
				        <th>View</th>
				    </tr>
				   

				    <tr ng-repeat="meta in feedbackMetaData"> 
				    	<td><@ meta.has_feedback.subject @></td>
				    	<td><@  meta.unread_count @></td>
				    	<td><@  meta.last_message_date | date : "yyyy-mm-dd hh:mm:ss" : 0 @></td>
				    	<td><a href = ""> <i class ="fa fa-eye"> </i></a> </td>
				    </tr>
		    </table>

      </div>
     </div>
    </div>
        </div>
</div>

<script type="text/javascript">
	// var app = angular.module('frontendApp', []);
	// 	app.config(config);
	// 		config.$inject = ['$interpolateProvider'];
	// 		function config($interpolateProvider){

	// 		$interpolateProvider.startSymbol('<@');
	// 		$interpolateProvider.endSymbol('@>');
	// 	}
	app.controller('feedbackController', function($scope){
		$scope.feedbackMetaData = JSON.parse('<?php echo json_encode($feedbackMetaJson->getData()); ?>');
	})
</script>
@endsection