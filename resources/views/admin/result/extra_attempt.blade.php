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
            <table class="table table-bordered table-striped ">
              <thead>
              <tr>
                    <th> ID</th>
                    <th class = "center"> Attempt </th>
                    <th > Created On  </th>
                    <th > Remove This </th>
                    </tr>
                    <tr ng-repeat="(key, value) in checkUserExtraAttemptOnExam">
                      <td> <@ key+1 @> </td>
                      <td> <@ value.attempt @> </td>
                      <td> <@ value.create_at @> </td>
                      <td><button type="button" ng-click="deleteData(value.id)" class="btn btn-danger btn-xs">Delete</button> </td>
                    </tr>
              </thead>
            </table>

          <div class ="form mb-20" ng-show="userExamData.fname">
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
                    <label class="control-label">Extra Attempt</label>
                    <div class="controls">
                     <select ng-model="selectedOption" name = "attempt" required>
                      <option ng-repeat="(key, value) in maxAttempt" value="<@ key @>"><@ value @></option>
                    </select>
                    <span ng-show="inputform.selectedOption.$error.required">Select Extra Attempt.</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Message</label>
                    <div class="controls">
                      {{Form::textarea('message', ' ',array('class' =>'description textarea_editor  span8' ,'rows'=>'6', 'id' => 'editor1',
                       'ng-model' => 'txt_textarea',
                       ))}}
                    </div>
                    <span ng-show="inputform.txt_textarea.$error.required">Send a Message</span> 
                </div> 

                <div class="control-group">
                <div class="controls">
                    {{ Form::submit('Save',array('class' => 'btn btn-success')) }}
                </div>
              </div>
              {{ Form::close() }}
            </div>

          </div>             
        </div>
        
        </div>
      </div>
</div>
</div>

<script type="text/javascript">


  app.controller('maarulaController', function($scope, $http){
    $scope.userExamData = <?php echo $userExamData->getContent(); ?>;
    $scope.checkUserExtraAttemptOnExam = <?php echo $checkUserExtraAttemptOnExam->getContent(); ?>;
    $scope.maxAttempt = <?php echo json_encode(maxAttempt()) ?>;

      $scope.deleteData = function(id){
      if(confirm("Are you sure you want to remove it?"))
      {
        $http({
          method:"POST",
          url: "{{route('delete-extra-attempt')}}" ,
          data:{'id':id,   "_token": "{{ csrf_token() }}", }
        }).then(function(data){
          console.log(data);
           $scope.checkUserExtraAttemptOnExam = data;
          // $scope.success = true;
          // $scope.error = false;
          // $scope.successMessage = data.message;
          // $scope.fetchData();
        }); 
      }
    };

  });

</script>
@endsection