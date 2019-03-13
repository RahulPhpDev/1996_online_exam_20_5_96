@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title ='Extra Attempt')
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
// datepicker
  app.controller('maarulaController', function($scope, $http){
     $scope.required = true;
     var today=new Date();
     $scope.today = today.toISOString();

    $scope.userExamData = <?php echo $userExamData->getContent(); ?>;
    $scope.checkUserExtraAttemptOnExam = <?php echo $checkUserExtraAttemptOnExam->getContent(); ?>;
    $scope.maxAttempt = <?php echo json_encode(maxAttempt()) ?>;
console.log($scope.checkUserExtraAttemptOnExam);
      $scope.deleteData = function(id){
        // console.log(id);
      if(confirm("Are you sure you want to remove it?"))
      {
        $http({
          method:"POST",
          url: "{{route('delete-extra-attempt')}}" ,
          data:{'id':id,"_token": "{{ csrf_token() }}", }
        }).then(function(data){
          console.log(data.data);
           $scope.checkUserExtraAttemptOnExam = data.data;
        }); 
      }
    };

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
                    <th class = "center"> Attempt </th>
                    <th > Created On  </th>
                    <th > Remove This </th>
                    </tr>
              </thead>
                    <tr ng-repeat="(key, value) in checkUserExtraAttemptOnExam">
                      <td> <@ key+1 @> </td>
                      <td> <@ value.attempt @> </td>
                      <td> <@ value.create_at @> </td>
                      <td><button type="button" ng-click="deleteData(value.id)" class="btn btn-danger btn-xs">Delete</button> </td>
                    </tr>
            </table>
        </div>
          <div class ="form mb-20">
           {{ Form::open(array('class' => 'form-horizontal', 'id'=>'basic_validate','name' =>"inputform"))}}
                <div class="control-group">
                    <label class="control-label">User</label>
                    <div class="controls">
                      <span class = "controls-span"> <@ userExamData.fname +' '+ userExamData.lname @>  </span>
                    </div>
                </div>

                 <div class="control-group">
                    <label class="control-label">Exam</label>
                    <div class="controls">
                       <span class = "controls-span"> <@ userExamData.exam_name @>  </span>
                    </div>
                </div>
      
               <div class="control-group">
                    <label class="control-label">Extra Attempt: <span class="text-danger">* </span></label>
                    <div class="controls">
                     <select ng-model="attempt" name = "attempt"   ng-required="required">
                      <option ng-repeat="(key, value) in maxAttempt" value="<@ key @>"><@ value @></option>
                    </select>
                    <span class = "text-danger " ng-show="inputform.attempt.$error.required">Select Extra Attempt.</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Message:<span class="text-danger">* </span></label>
                    <div class="controls">
                      {{Form::textarea('message', ' ',array('class' =>'description textarea_editor  span8' ,'rows'=>'6', 'id' => 'editor1',
                       'ng-model' => 'message',
                        'ng-required'=>"true"
                       ))}}
                    </div>
                </div> 

                <div class="control-group">
                  {{ Form::label('end_date','End Date',array('class' => 'control-label'))}}
                <div class="controls">
                      <input type="date" ng-model="validdate" name="validdate" class = ""  min="<@ today @>" />

                      <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                          <span class = "text-danger "  ng-show="inputform.validdate.$error.min">Start Date should not be less than current date</span>
                   </div>
                </div>  


                <div class="control-group">
                <div class="controls">
                    <input type="submit" name="save" value="Save" class="btn btn-success" ng-disabled="inputform.validdate.$error.min || inputform.attempt.$error.required">
                </div>
              </div>
              {{ Form::close() }}
            </div>
           
        </div>
        
        </div>
      </div>
</div>
</div>

@endsection