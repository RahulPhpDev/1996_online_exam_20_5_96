@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = ' Feedback')

@extends('frontend_layouts.partials.fetch_angular')

@section('content')


<div id="content">
     <div class="container-fluid"  ng-controller="feedbackController">
      <hr>
      
      @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-user') }}">Add User </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>User</h5>
          </div>
          <div class="nopadding">
            <table id = "data_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Subject</th>
                    <th class = "report_th"><span> Message </span></th>
                    <th class = ""><span> Last Message Date </span></th>
                    <th>View</th>
                </tr>
              </thead>
              <tbody>
                 <tr ng-repeat="meta in feedbackMetaData"> 
                  <td><@ meta.has_feedback.subject @></td>
                  <td><@  meta.unread_count @></td>
                  <td><@  meta.last_message_date | date : "yyyy-mm-dd hh:mm:ss" : 0 @></td>
                  <td><a ng-click="getFeedbackData(meta.feedback_id)"> View </a> </td>
                </tr>
              </tbody>
            </table>
        
          </div>
         
        </div>
    
          </div>
        </div>
    </div>
</div>

<script type="text/javascript">

  backEnddApp.controller('feedbackController', function($scope,$window){
    $scope.feedbackMetaData = JSON.parse('<?php echo json_encode($feedbackMetaJson->getData()); ?>');

    $scope.getFeedbackData = function(id) {
      // $scope.getId = id;
               $window.location.href = 'show-feedback-messages/'+id;  
        };
  })
</script>
@endsection

