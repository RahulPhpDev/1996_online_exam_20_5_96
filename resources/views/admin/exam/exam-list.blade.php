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
          <a href = "{{route('add-exam')}}" class = "float-right btn btn-primary" style="text-align: right">
         Add Exam </a>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Visible</th>
                  <th>Total Question</th>
                  <th>Total Mark</th>
                  <th>Passing Mark</th>
                  <th> Other Details </th>
                  <th> View/Edit Question </th>
                  <th> Edit </th>
                  <th> Disable </th>
                </tr>
              </thead>
              <tbody>
           <?php foreach($examDetails as $data) { ?>     
                <tr class="odd">
                  <td>{{$data['exam_name']}}</td>
                  @php
                   $examVisible  = '';
                  if($data['exam_visible_status']== 1){
                  $examVisible = 'All';
                }else if($data['exam_visible_status']== 2){
                   $examVisible = 'Register Student';
                }else if($data['exam_visible_status']== 3){
                  $examVisible = 'Package';
                }

                  @endphp
                  <td> <button data-toggle="modal" data-target="#myModal" type = "button"  class ="show_visible_to btn btn-primary" data-id = "{{ Crypt::encrypt($data['id'])  }}"> {{$examVisible}} </button> </td>
                  <td> {{$data['total_question']}} </td>
                  <td> {{$data['total_marks']}}</td>
                  <td> {{$data['minimum_passing_marks']}} </td>
                  <td> <button type = "button" class ="btn btn-primary"> Other </button></td>
                  <td> <a class ="btn btn-success" href="{{ route('exam-question', ['id' => Crypt::encrypt($data['id']) ]) }}">Questions <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                   </td> 
                  <td> <a type = "button" class ="btn btn-sm btn-success" href="{{ route('edit-exam', ['id' => Crypt::encrypt($data['id']) ]) }}"> Edit </a> </td>
                 <form method = "post" action = "{{ route('delete-exam',['id'=> Crypt::encrypt($data['id'])]) }}"> 
                 {{ Form::open(array('route' => ['delete-exam', Crypt::encrypt($data['id']) ] ) )}}
                  <td> <button type = "submit" class ="btn btn-danger" >Disable  </button> </td>
                  {{ Form::close() }}
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
  $(document).ready(function(){
    $(".show_visible_to").on("click", function(){
      var exam_id = $(this).data("id"); 
       $.ajax({
        url:"exam-accessbility/"+exam_id,
        method:"GET",
      success:function(data){
          $(".modal-body").html(data);
          }
       });
    });
  });

</script>
@endsection