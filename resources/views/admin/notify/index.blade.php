@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title ='Notification')
@push('angular')
  @include('layouts.partials.fetch_layout_angular')
@endpush

@section('content')
<style type="text/css">
  .controls-span{
    padding:5px 0px;
    font-size: 16px;
    font-weight: 500;

  }

</style>



<script type="text/javascript">

  app.controller('maarulaController', function($scope, $http){

    $scope.notification = <?php echo Auth::user()->unreadNotifications; ?>;
    
  });

</script>

<div id="content" ng-controller="maarulaController">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class="widget-content nopadding">
            <table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped mb-20">
              <thead>
                <tr>
                    <th> ID</th>
                    <th class = "center"> Date </th>
                    <th > Subject  </th>
                    <th > Message </th>
                    <th > Delete </th>
                </tr>
              </thead>
               <tr ng-repeat="notify in notification">
               <td>  <@ $index+1 @> </td>
               <td>   <@ notify.created_at @></td>
               <td>  <@ notify.data.subject @> </td>
               <td> <a href = "" class= "btn btn-primary">  View </a></td>
               <td>  <a href = "" class= "btn btn-danger"> Delete </a></td>
              </tr>
            </table>
          </div>  

        </div>
      </div>
    </div>
  </div>
</div>

@endsection