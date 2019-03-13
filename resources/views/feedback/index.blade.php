@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@push('angular')
  @include('frontend_layouts.partials.fetch_angular')
@endpush
@extends('frontend_layouts.partials.footer')

@section('content')  


<link href="{{ asset('frontend/css/welcome_css.css') }}" rel="stylesheet">
<div class="maincontent">
                <style type="text/css">
.footer_ann_div{position: fixed;
    bottom: 0;
    width: 100%;}
.res_table{margin:20px 0px 10px 10px;font-size:18px;}
/*.report_th, .report_td{ width:43%;text-align:right;  }
.report_th >span ,.report_td >span{margin-right:18%}*/
</style>


<div class="item-container">    
 <div class="container"> 
  <div class="col-md-12" ng-controller ="feedbackController">
  			<div class="mt-20">
            <a class ="btn btn-success pull-right" href="{{ route('feedback.create') }}">Send Feedabck </a>
            </div>
            <div class="pt-20"></div>
            <div class="pt-20"></div>
			<table class = "table res_table mt-20">
				    <tr>
				        <th>Subject</th>
				        <th class = "report_th"><span> Message </span></th>
				        <th class = ""><span> Last Message Date </span></th>
				        <th>View</th>
				    </tr>
				   
				    <tr ng-repeat="meta in feedbackMetaData"> 
				    	<td><@ meta.has_feedback.subject @></td>
				    	<td><@  meta.unread_count @></td>
				    	<td><@  meta.last_message_date @></td>
				    	<td><a ng-href="/feedback/<@ meta.has_feedback.encrypted_id @>" > <i class ="fa fa-eye"> </i></a> </td>
				    	<!-- ng-click="getFeedbackData(meta.feedback_id)" -->
				    </tr>
		    </table>
<@ getId @>
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
	app.controller('feedbackController', function($scope,$window){
		$scope.feedbackMetaData = <?php echo $feedbackMetaJson; ?>;

		// $scope.getFeedbackData = function(id) {
		// 	// $scope.getId = id;
  //       		   $window.location.href = '/feedback/'+id;	
  //   		};
	})
</script>
@endsection