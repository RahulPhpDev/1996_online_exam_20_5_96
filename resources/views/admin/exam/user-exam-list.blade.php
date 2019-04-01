@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title ='Extra Attempt')


@section('content')

<script type="text/javascript">

  app.controller('maarulaController', function($scope, $http){
    $scope.userExamData = <?php echo $userExamData; ?> ;

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
              <table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
   
              <thead>
              <tr>
                    <th> ID</th>
                    <th class = "center"> Exam </th>
                    <th >  User </th>
                    <th > Email  </th>
                    <th > Attempt</th>
                    <th > Give Extra Attempt </th>
                  </tr>
              </thead>
                <tr ng-repeat = "userExam in userExamData">
                  <td> <@ $index+1 @></td>
                  <td> <@  userExam.exam_name @></td>
                  <td> <@  userExam.fname+'  '+userExam.lname @></td>
                  <td> <@  userExam.email @></td>
                  <td> <@  userExam.count_attempt @></td>
                    
                  <td class="center">
                   <a 
                      ng-href = "/result/extra-attempt/<@ userExam.exam_id+'/'+userExam.user_id  @>" class ="btn btn-xs"
                      ng-class = "(userExam.eaId > 0) ? 'btn-danger' : 'btn-primary'"> CLick
                        <span class = "round_num" ng-if = "userExam.eaId > 0">
                           <@ userExam.eaId @>
                        </span>
                         </a>
                      </td>
                      
                </tr>  
            </table>
          </div>             
        </div>
      </div>
     </div>
  </div>
</div>

@endsection