@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<style>
.new-update .update-date {

    width: auto;
}
</style>
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">






      <div class = "information" style = "padding:6px; margin-bottom: 140px !important;">
          <div class="widget-box">
              <div class="widget-content nopadding  span4 offset1">
              <div class="new-update clearfix">
              <div class="update-done"><a href="#" title=""><strong>Exam</strong></a>  </div>
              <div class="update-date"><span class="update-day">{{$examDetails['exam_name']}}</span></div>
            </div>
            <div class="new-update clearfix">
                 <div class="update-done"><a href="#" title=""><strong>Total Mark</strong></a> </div>
                 <div class="update-date"><span class="update-day">{{$examDetails['total_marks']}}</span> </div>
            </div>
            <div class="new-update clearfix">
                 <div class="update-done"><a href="#" title=""><strong>Total Question</strong></a> </div>
                 <div class="update-date"><span class="update-day">{{$examDetails['total_question']}}</span> </div>
            </div>
            <div class="new-update clearfix">
                 <div class="update-done"><a href="#" title=""><strong>Time</strong></a> </div>
                 <div class="update-date"><span class="update-day">{{$examDetails['time']}}</span> </div>
            </div>
          </div>
        </div>
       </div>

        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>

          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped ">
              <thead>
              <tr>
                        <th> Date</th>
                        <th ><span class = "center"> User  </span></th>
                        <th ><span class = "center"> Time Taken </span></th>
                        <th ><span class = "center"> Obtain Mark </span></th>
                        <th ><span class = "center">Status </span></th>
                        <th ><span class = "center">Answer Sheet </span></th>
                    </tr>
              </thead>
              <tbody>
              @foreach($resultData as $res)
                <tr>
                    <td>{{ DateManipulation($res->add_date)}}</td>
                    <td > <span class = "center"> {{$res->User->getFullName()}} </span></td>
                    <td > <span class = "center"> {{$res->time_taken}} </span></td>
                    <td > <span class = "center"> {{ $res->obtain_mark}} </span></td>
                    @php
                    $passingStatus = ($res->result_status == 2) ? 'Fail' : 'Pass'; 
                    @endphp
                    <td > <span class = "center"> {{$passingStatus}}</span></td>
                    <td class = "center"> <a class = " text-blue" href = "{{route('inspection-sheet',['id'=>Crypt::encrypt($res->id)])}}" > Details</a></td>
                   
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
            {{$resultData->render()}}
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


</script>
@endsection