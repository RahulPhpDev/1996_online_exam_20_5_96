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
     <a class ="btn btn-success pull-right" href="{{ route('add-course') }}">Add Course </a>
    <div class="row-fluid">
      <div class="span12">
        <div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Course</h5>
          </div>
          <div class=" nopadding">
            <table id = "data_table"  class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th> Id </th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Total</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($allFeedback as $data) { ?>     
                <tr class="odd gradeX">
                  <td>{{$i}}</td>
                  <td>{{$data['name']}}</td>
                  
                  <td>{{$data['email']}}</td>
                  
                  <td>{{$data['total']}} </td>

                  <td>
                  <a class = "text-center btn btn-og view_details" id ="feedback" data-id = "{{$data->id}}"> View</a>&nbsp&nbsp
                  </td>
                </tr>
              <?php $i++;} ?>
              </tbody>
            </table>
          </div>
        </div>
       </div>
       <div class = "mb-50" style="margin-bottom:10px"></div>  
       <div id = "feedback_id"></div>
    </div>
 </div>
</div>


<!-- END THE MODEL -->
 <script>
     $(document).on('click', '.view_details', function(){
         var id = $(this).data('id');
            $.ajax({
             url: 'feedback-message/'+id,
             type: 'GET',
              success: function(result){
                  $("#feedback_id").html(result);
                    $('html, body').animate({
                    scrollTop: $("#feedback_id").offset().top+50
                }, 2000);

                }
            });
          });
    </script>
@endsection


