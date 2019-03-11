
@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title ='Announcment')
@section('content')


  <script src="{{ asset('js/angular/angular.min.js') }}"></script>
  <script src="{{ asset('js/angular/angular-sanitize.js') }}"></script>

<div id="content" ng-controller="maarulacontroller">
     <div class="container-fluid">
    <hr>
    @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-announcement') }}">Add Announcement </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Course</h5>
          </div>
          <div class=" nopadding">
            <table id = ""  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Message</th>
                  <th>Date</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                 <tr ng-repeat="post in allData">
              
                         <td> <@  $index + 1 @> </td>
                          <td ng-bind-html="post.content" ></td>
                          <td><@ post.add_date  @></td>
                          <td><a href = "" class="btn btn-success" ng-click="editAnnouncement( post.id )"> Edit</a></td>
                          <td><a ng-href="delete-announcement/<@ post.id @>" class="btn btn-danger"> Delete</a></td>
                      </tr>
              </tbody>
            </table>
          </div>
          <div ng-bind-html="deliberatelyTrustDangerousSnippet()"></div>
        
        </div>
       </div>
       <div class = "mb-50" style="margin-bottom:10px"></div>  
      
    </div>
 </div>
</div>

<!-- END THE MODEL -->
 <script>

     var app = angular.module('maarulaapp', ['ngSanitize']);
      app.config(config);
      config.$inject = ['$interpolateProvider'];
      function config($interpolateProvider){

      $interpolateProvider.startSymbol('<@');
      $interpolateProvider.endSymbol('@>');
    }
     app.controller('maarulacontroller', ['$scope', '$sce','$http', function($scope, $sce,$http) {
              $scope.editAnnouncement = function( id ) {
               $http({
                    method: 'GET',
                    url: "edit-announcement/"+id,
                    responseType:'html'

                }).then(function(response) {
                  $scope.myWelcome = response.data;
              });

             $scope.deliberatelyTrustDangerousSnippet = function() {
                   return $sce.trustAsHtml($scope.myWelcome);
                 };
            }

               $scope.allData = <?php echo $allData->getContent(); ?>;
           }]);



</script>
@endsection


