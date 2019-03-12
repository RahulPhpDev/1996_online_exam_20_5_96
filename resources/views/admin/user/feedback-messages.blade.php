@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = ' Feedback')

@extends('frontend_layouts.partials.fetch_angular')

@section('content')
<style type="text/css">
  .bg-danger {
    background: #eca2a2 !important;
    color: white;
}
</style>

<div id="content">
     <div class="container-fluid"  ng-controller="feedbackController">
      <hr>
      
      @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-user') }}">Add User </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Message</h5>
          </div>
          <div class="nopadding">
            <table id = "data_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Subject</th>
                    <th class = "report_th"><span> Message </span></th>
                    <th class = ""><span> Last Message Date </span></th>
                    <th>Reply</th>
                </tr>
              </thead>
              <tbody>
               <!-- ng-class="apt.name.length >= 15 ? 'col-md-12' : (apt.name.length >= 10 ? 'col-md-6' : 'col-md-4')" -->
                 <tr ng-repeat="meta in feedbackMetaData"> 
                  <td><@ meta.has_feedback.subject @></td>
                  <td class = "center" ng-class="meta.unread_count > 0 ? 'bg-danger' :'nothing' "><a style="color:blue" ng-href = "show-feedback-messages/<@ meta.feedback_id @>"><@  meta.unread_count @> </a></td>
                  <td><@  meta.last_message_date | date : "yyyy-mm-dd hh:mm:ss" : 0 @></td>
                  <td class="center"><a  class = "btn btn-primary" ng-href = "show-feedback-messages/<@ meta.feedback_id @>"> Reply </a> </td>
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
    $scope.feedbackMetaData = <?php echo $feedbackMetaJson; ?>;
// console.log( $scope.feedbackMetaData );
    // $scope.getFeedbackData = function(id) {
    //   // $scope.getId = id;
    //            $window.location.href = 'show-feedback-messages/'+id;  
    //     };
  })
</script>
@endsection

