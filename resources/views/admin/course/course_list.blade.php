@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
   @if(\Session::has('success'))
    <div class="alert alert-success"> 
      <a class="close" data-dismiss="alert" >×</a>
      {{\Session::get('success')}}
    </div>
@endif
     <a class ="btn btn-success pull-right" href="{{ route('add-course') }}">Add Course </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Course</h5>
          </div>
          <div class=" nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th> Id </th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($allData as $data) { ?>     
                <tr class="odd gradeX">
                  <td>{{$i}}</td>
                  <td>{{$data['name']}}</td>
                  <td>  <button type="button"  class="btn btn-info btn-lg des_details" data-toggle="modal" data-target="#myModal" data-id = "{{Crypt::encrypt($data['id'])}}">Description</button> </td>
                  <td>
                  <a href="{{ route('edit-course', ['id' => Crypt::encrypt($data['id']) ]) }}" class="btn btn-og">Edit</a>
                  </td>
                  <td>
                  <a class = "text-center btn btn-og" href="{{ route('delete-course', ['id' => Crypt::encrypt($data['id']) ]) }}" > Delete</a>&nbsp&nbsp
                  </td>
                </tr>
                
           <?php $i++;} ?>
              </tbody>
            </table>
            {{$allData->render()}}
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


