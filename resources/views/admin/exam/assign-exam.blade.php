@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
    @include('admin.messages.return-messages')
    
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Course</h5>
          </div>
          <div class=" nopadding">
            <table id = "data_table" class="table table-bordered table-striped">
              <thead>
              <tr>
                  <th>Remove</th>
                  <th>Users</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($userData as $data) { ?>     
            <tr class="odd">
              <?php   $select =  ''; if(in_array($data['id'], $allSelectedUser )){
                $select = 'Selected';
              }
              ?>
              <td> <input class ="chk_user" type = "checkbox" value = "{{$data['id'] }}" {{$select}} name = "remove[]"></td>
                  <td>{{$data->getFullName()}}</td>
                  <td>{{$data['email']}}</td>      
                </tr>
                
           <?php $i++;} ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
        </div>
</div>
</div>


<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Description</h4>
        </div>
        <div class="modal-body" id = "description_id">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<!-- END THE MODEL -->
 <script>
     $(document).on('click', '.des_details', function(){
         var id = $(this).data('id');
            $.ajax({
             url: 'course-description/'+id,
             type: 'GET',
              success: function(result){
                  $("#description_id").html(result);
                }
            });
          });
    </script>
@endsection


