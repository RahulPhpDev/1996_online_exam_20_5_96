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
          <a href = "{{route('add-exam')}}" class = "pull-right btn btn-og">
         Add Exam </a>
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Exam</h5>
          </div>
          <div class=" nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Visible</th>
                 
                  <th> Other Details </th>
                  <th>Image </th>
                  <th>Update Image </th>
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
                  <td class = "center"> <button data-toggle="modal" data-target="#myModal" type = "button"  class ="show_visible_to btn btn-primary" data-id = "{{ Crypt::encrypt($data['id'])  }}"> {{$examVisible}} </button> </td>
                 
                  <td class = "center">
                  <button data-toggle="modal" data-target="#myModal" type = "button"  class ="exam_detail btn btn-primary" data-id = "{{ Crypt::encrypt($data['id'])  }}"> Details </button> 
                   </td>

                 @php  $pic = (!is_null($data['image'])) ? '/images/exam/thumbnail/'.$data['image'] : '';  @endphp
                 <td class = "center">  <img style = "max-width:120px" src="{{ asset( $pic )}}"  class="avatarbox material_avatar package_img"/> </td>
                 <td class="center"> <a class = "btn btn-danger update_img" data-exid = "{{$data['id']}}" >Update</a></td>
                  <td class = "center"> <a class ="btn btn-success" href="{{ route('exam-question', ['id' => Crypt::encrypt($data['id']) ]) }}">Questions <i class="fa fa-fw fa-arrow-circle-right"></i></a>&nbsp&nbsp
                   </td> 
                  <td class = "center"> <a type = "button" class ="btn btn-sm btn-success" href="{{ route('edit-exam', ['id' => Crypt::encrypt($data['id']) ]) }}"> Edit </a> </td>
                 <form method = "post" action = "{{ route('delete-exam',['id'=> Crypt::encrypt($data['id'])]) }}"> 
                 {{ Form::open(array('route' => ['delete-exam', Crypt::encrypt($data['id']) ] ) )}}
                  <td  class = "center">  <button type = "submit" class ="btn btn-danger" >Disable  </button> </td>
                  {{ Form::close() }}
                </tr>
                
           <?php } ?>
              </tbody>
            </table>
            {{$examDetails->render()}}
          </div>
        </div>
       </div>
    </div>
 </div>



<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
        {{Form::open(array('route' => array('update-exam-img'), 'method' => 'post','class' => 'form-horizontal', 'id'=>'popup_form','enctype'=>'multipart/form-data'))}}

        <input type = "hidden" value = "" id = "ex_id" name = 'exam_id'>
            <div class="control-group">
                    {{Form::label('image' , 'Upload Photo', array('class' => 'control-label')) }}
                    <div class="controls"> 
                        {{Form::file('image')}}
                      </div>
                 </div>
        <div class="form-actions">
                 {{Form::submit('Update',array('class' => 'btn btn-success btn-lg'))}}
                </div>
                 {{ Form::close()}}
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

    	$('.package_img').on('click', function() {
      var source =  $(this).attr('src');
      console.log(source);
			$('.imagepreview').attr('src',source);
			$('#popup_form').hide();   
			$('#imagemodal').modal('show');   
		});		

    	$('.update_img').on('click', function() {
        $('#imagemodal').modal('show'); 
       var subId =  $(this).data("exid");
       $('#popup_form').show();
       $("#ex_id").val(subId);
       $(".imagepreview").hide();  
		});		




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


    $(".exam_detail").on("click", function(){
      var exam_id = $(this).data("id"); 
       $.ajax({
        url:"exam-details/"+exam_id,
        method:"GET",
      success:function(data){
          $(".modal-body").html(data);
          }
       });
    });
  });

</script>
@endsection