@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<style>
.select2-container{
  width: 30%;
}
</style>  
<div id="content">
     <div class="container-fluid">
      <hr>
      
      @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-course') }}">Add Course </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Course</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th> Id </th>
                  <th>User Name</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>User Type </th>
                  <th>Description </th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($allData as $data) { 
$data = get_object_vars($data);
            ?>     
                <tr class="odd gradeX">
                  <td>{{$i}}</td>
                  <td>{{$data['username']}}</td>
                  <td>{{$data['fname'] .' '.$data['lname']}}</td>
                  <td>{{$data['email']}}</td>
                  <td>
                   @if($data['user_type'] == 1)
                      {{'Admin'}}
                  @else
                     {{'Student'}}
                   @endif
                 </td>
                  <td>  <button type="button"  class="btn btn-info btn-lg des_details" data-toggle="modal" data-target="#myModal" data-id = "{{Crypt::encrypt($data['id'])}}">Description</button> </td>
                  <td>
                  <a href="{{ route('edit-user', ['id' => Crypt::encrypt($data['id']) ]) }}">Edit <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                  </td>
                  <td>
                  <a class = "text-center" href="{{ route('delete-user', ['id' => Crypt::encrypt($data['id']) ]) }}"> <i class="fa fa-fw fa-arrow-circle-right text-center">Delete</i></a>&nbsp&nbsp
                  </td>
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
             url: 'user-other-details/'+id,
             type: 'GET',
              success: function(result){
                  $("#description_id").html(result);
                }
            });
          });
    </script>
@endsection

