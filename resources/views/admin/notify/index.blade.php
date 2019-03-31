@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title ='Notification')


@section('content')
<style type="text/css">
  .controls-span{
    padding:5px 0px;
    font-size: 16px;
    font-weight: 500;

  }

</style>

<script type="text/javascript">
  app.controller('maarulaController', ['$rootScope', '$scope','$http', 'myservice',function($scope, $rootScope,$http,myservice){
    $scope.notification = <?php echo Auth::user()->unreadNotifications; ?>;
    $scope.deleteNotification = function (id){
          $http({
                url: 'notify/'+id,
                method: 'DELETE', 
              }).then(function(response){
                 $scope.notification = response.data;
                console.log($scope.notification);
              },function(error){
          });
        };

      $scope.getMessage = function(id){
        $http({
          method:'get',
          url: 'notify/'+id,
        }).then(function (response){
          $scope.countUnreadNotification();

          $.confirm({
             columnClass: 'col-sm-1 col-md-1',
             title: 'Notification',
             content: response,
             buttons: {
                  delete: {
                    text: 'Remove',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){
                        $scope.deleteNotification(id);
                        $scope.countUnreadNotification();
                    }
                  },
                  close: function () {

                  }
                }
            });
          
        },function(error){

        });
      };
    

    $scope.countUnreadNotification = function(){
      $http({
        url: 'notify/unreadNotification',
        method :'Get'
      }).then(function (response){
        myservice.unreadNotification = response.data;
      },function(error){      
      });
    }

  }]);
 
</script>

<div id="content" ng-controller="maarulaController">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Notification</h5>
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
               <td> 
               <a ng-click = "getMessage(notify.id)" class= "btn btn-primary">  View </a></td>
               <td>  <a ng-click = "deleteNotification(notify.id)"   class= "btn btn-danger"> Delete </a></td>
              </tr>
            </table>
          </div>  

        </div>
      </div>
    </div>
  </div>
</div>

@endsection