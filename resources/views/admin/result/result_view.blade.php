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
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped ">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Exam</th>
                  <th>Result</th>
                  <th>Mark</th>
                  <th>Other Details</th>
                  <th>Report</th>
                  <th>Date</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <!-- ALTER TABLE `results` CHANGE `student_id` `user_id` INT(11) NOT NULL; -->

           <?php foreach($allData as $data) { ?>     
                <tr class="odd">
                  <td>{{$data->User['fname'].' '.$data->User['lname']}}</td>                
                  <td class = "center"> {{$data->Exam['exam_name']}} </td> 
                  @php
                  $passingStatus = ($data->result_status == 2) ? 'Fail' : 'Pass'; 
                @endphp
                  <td>{{ $passingStatus}}</td>
                  <td>{{ $data->obtain_mark }} </td>
                  <td class = "center">  <a class = "text-center btn btn-primary" href="" > Detail</a></td>
                  <td class = "report_td center" > <span> <a class = "btn btn-primary" href = "{{ route('result-answersheet', ['id' => Crypt::encrypt($data['id']) ]) }}">{{$data['total']}} View</a> </span></td>
                  <td> {{ DateManipulation($data['add_date'])}}</td>

                  <td class = "center">  <a  href="{{ route('delete-result', ['id' => Crypt::encrypt($data->id) ]) }}" class = "text-center btn btn-og" href="" > Delete</a></td>
                </tr>
                
           <?php } ?>
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