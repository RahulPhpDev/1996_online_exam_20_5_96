@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Exam</th>
                  <th>Obtain Mark</th>
                </tr>
              </thead>
              <tbody>
                <!-- ALTER TABLE `results` CHANGE `student_id` `user_id` INT(11) NOT NULL; -->

           <?php foreach($allData as $data) { ?>     
                <tr class="odd">
                  <td>{{$data->User['fname']}}</td>
                
                  <td> {{$data->Exam['exam_name']}} </td>
                  <td> {{$data['obtain_mark']}}</td>
                </tr>
                
           <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
        </div>
</div>
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Exam Visible</h4>
      </div>
      <div class="modal-body">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
  // $(document).ready(function(){
  //   $(".show_visible_to").on("click", function(){
  //     var exam_id = $(this).data("id"); 
  //      $.ajax({
  //       url:"exam-accessbility/"+exam_id,
  //       method:"GET",
  //     success:function(data){
  //         $(".modal-body").html(data);
  //         }
  //      });
  //   });
  // });

</script>
@endsection