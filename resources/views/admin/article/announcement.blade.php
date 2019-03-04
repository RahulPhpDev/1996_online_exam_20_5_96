
@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title ='Announcment')
@section('content')
  <script src="{{ asset('angular.min.js') }}"></script>
  <script src="{{ asset('angular-sanitize.js') }}"></script>

<div id="content" ng-controller="maarulacontroller">
     <div class="container-fluid">
    <hr>
    @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-course') }}">Add Course </a>
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
                 <tr ng-repeat="post in allData.original">
                         <td> <@  $index+1 @> </td>
                          <td ng-bind-html="post.content" ></td>
                          <td><@ post.add_date  | date   @></td>
                          <td><a href = "" class="btn btn-success" ng-click="deletePerson( post.id )"> Edit</a></td>
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
// https://plnkr.co/edit/?p=preview

      angular.module('maarulaapp', ['ngSanitize'])
           .controller('maarulacontroller', ['$scope', '$sce', function($scope, $sce) {
              $scope.deletePerson = function( id ) {
               $http({
                    method: 'GET',
                    url: "edit-announcement/"+id,
                    responseType:'html'

                }).then(function(response) {
                // console.log(response.data);
                  $scope.myWelcome = response.data;
              });
$scope.deliberatelyTrustDangerousSnippet = function() {
               return $sce.trustAsHtml($scope.myWelcome);
             };
        
        }
   $scope.allData = JSON.parse('<?php echo json_encode($allData); ?>');
             
           }]);



//     app.controller('maarulacontroller', function( $scope,$http,$sce) {

      
//     $scope.deletePerson = function( id ) {
//        $http({
//             method: 'GET',
//             url: "edit-announcement/"+id,
//             responseType:'html'

//         })
//       // $http.get("edit-announcement/"+id)
//       .then(function(response) {
//         // console.log(response.data);
//           $scope.myWelcome = response.data;
//       });
// $scope.trustAsHtml = function() {
//             return $sce.trustAsHtml($scope.myWelcome);
//          }
        
//         }

      

  
           // console.log($scope.allData);

    // });



</script>
@endsection


