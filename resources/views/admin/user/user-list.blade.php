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
<script>
 $(function(){ 

    $(".approve").on("click", function(){
        if(confirm("Are you sure to Approved?")){
          var user_id = $(this).data('id');
          $.ajax({
            url:"/approve-user",
            type: "post",
            data: {
               "_token": "{{ csrf_token() }}",
               "id" : user_id 
           },
           success: function(succ_data) {
                // location.reload();
          $("#user_"+user_id).html(succ_data);
           }
          });
        }
    });
  });

</script>
<div id="content">
     <div class="container-fluid">
      <hr>
      
      @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-user') }}">Add User </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>User</h5>
          </div>
          <div class="">
            <table id = "data_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th> Id </th>
                  <!-- <th>User Name</th> -->
                  <th>Name</th>
                  <th>Email</th>
                  <th>User Type </th>
                  <th>Description </th>
                  <th>Status </th>
                  <th>Exam Taken</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($allData as $data) { 
//$data = get_object_vars($data);
            ?>     


              <?php
         // dd(count($data->Results));
              ?>

                <tr class="odd gradeX" id = "user_{{$data['id']}}">
                  <td>{{$i}}</td>
                  <!-- <td>{{$data['username']}}</td> -->
                  <td>{{$data['fname'] .' '.$data['lname']}}</td>
                  <td>{{$data['email']}}</td>
                  <td>
                   @if($data['user_type'] == 1)
                      {{'Admin'}}
                  @else
                     {{'Student'}}
                   @endif
                 </td>
                  <td>  <button type="button"  class="btn btn-info btn-sm des_details" data-toggle="modal" data-target="#myModal" data-id = "{{Crypt::encrypt($data['id'])}}">Description</button> </td>

                   <td>
                     @if($data['status'] == 1)
                       <span class="text-success"> Approved </span>
                    @else
                    <button data-id = "{{$data['id']}}" type="button" class="btn btn-danger btn-sm text-center approve">
                      Pending
                    </button>
                     @endif
                 </td>
                 <td>
                  <a class = "text-blue" href="{{ route('user-result', ['id' => Crypt::encrypt($data['id']) ]) }}">{{count($data->Results)}} View </a>
                  </td>
                  <td>
                  <a href="{{ route('edit-user', ['id' => Crypt::encrypt($data['id']) ]) }}">Edit <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                  </td>
                  <td>
                  @if($data['status'] == 1)
                  <a class = "btn btn-danger text-center" href="{{ route('delete-user', ['id' => Crypt::encrypt($data['id']) ]) }}"> <i class="fa fa-fw fa-arrow-circle-right text-center">Delete</i></a>&nbsp&nbsp
                  @else
                  <a class = "btn btn-primary text-center" href="javascript::void(0)">Pending</a>&nbsp&nbsp
                     @endif
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

