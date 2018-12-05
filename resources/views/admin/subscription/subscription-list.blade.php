@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')

<div id="content">
  <div id="content-header">
   
  </div>
  <div class="container-fluid">
    <hr>
     @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-subscription') }}">Add Subscription Package </a>
    <div class="row-fluid">
      <div class="span12">
       
       
        <div class="">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Subscription Package</h5>
          </div>
          <div class="">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                <th> SN </th>
                  <th>Name</th>
                  <th>Duration</th>
                  <th>Price</th>
                  <th>Image</th>
                  <th>Edit</th>
                  <th>Update Image</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
              @php  $i = 1; @endphp
                @foreach($allData as $data)
              
                <tr class="gradeX">
                  <td>{{$i}}</td>
                  <td>{{$data['name']}}</td>
                  <td>
                    @if($data['isDatePermit'] == 0)
                     {{$data['duration']}}
                    @else

              {{ $data['start_date'].' To '.$data['end_date']}}
                    @endif
                 </td>
                  <td>{{$data['price']}}</td>
                  <?php
                   $pic = '';
                  if(!is_null($data['image'])){
                    $pic = '/images/package/thumbnail/'.$data['image'];
                  }
                    ?>
                   
                  
                  <td class = "center">  <img style = "max-width:120px" src="{{ asset( $pic )}}"  class="avatarbox material_avatar package_img"/> </td>
                  <td class="center">
                    <a class = "btn btn-danger update_img" data-subid = "{{$data['id']}}" >Update</a></td>
                  <td class="center">
                    <a class = "btn btn-danger" href = "{{route('edit-subscription', ['id' => Crypt::encrypt($data['id']) ]) }}">Edit</a></td>
                  <td class="center" ><a class = "btn btn-og delete_btn">Delete </a>
                  <div class = "delete_div" style = "display:none">
                  {{Form::open(array('route' => array('delete-subscription','id' => Crypt::encrypt($data['id']) ), 'method' => 'post','class' => 'form-horizontal'))}}
                  <div class="control-group">
                    {{Form::label('option' , 'Delete Exam Also', array('class' => 'control-label')) }}
                    <div class="mt-10">
                      <input type="submit" name="save" value="Yes" class = 'btn btn-lg btn-primary'>
                      <input type="submit" name="save" value="No" class = 'btn btn-lg btn-success'>
                     <span class="tip" data-original-title="Exam will not be delete."><i class="icon-pencil"></i></span>
                  </div>
                  {{Form::Close()}}
                  </div>
                  </td>
                </tr>
                @php  $i++; @endphp
                @endforeach
              </tbody>
            </table>
            {{$allData->render()}}
          </div>
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
        {{Form::open(array('route' => array('update-subscription-img'), 'method' => 'post','class' => 'form-horizontal', 'id'=>'basic_validate','enctype'=>'multipart/form-data'))}}

        <input type = "hidden" value = "" id = "subs_id" name = 'sub_id'>
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




<style>

</style>

<script>


$(function(){
  	$('.package_img').on('click', function() {
      var source =  $(this).attr('src');
      console.log(source);
			$('.imagepreview').attr('src',source);
			$('#imagemodal').modal('show');   
		});		

    	$('.update_img').on('click', function() {
        $('#imagemodal').modal('show'); 
       var subId =  $(this).data("subid");
       $("#subs_id").val(subId);
       $(".imagepreview").hide();  
		});		


  $(".delete_btn").on("click", function(){
    // console.log(this);
    $(this).next(".delete_div").css({"display": "inline"});
    $(this).removeClass('delete_btn');
    $(this).text('Hide');
    $(this).addClass('show_delete_btn');
  });

  
});  
// $('.table').on('click', 'a.show_delete_btn', function(event) {
//   console.log('92'+this);
//     $(this).next(".delete_div").css({"display": "none"});
//     $(this).removeClass('show_delete_btn');
//     $(this).addClass('delete_btn');
//     $(this).text('Deletesfsf');  
// });

// $(document).on('click', "a.show_delete_btn", function() {
//   console.log('92'+this);
//     $(this).next(".delete_div").css({"display": "none"});
//     $(this).removeClass('show_delete_btn');
//     $(this).addClass('delete_btn');
//     $(this).text('Delete');      
// });

//  $(".show_delete_btn").on("click", function(){
//     console.log('92'+this);
//     $(this).next(".delete_div").css({"display": "none"});
//     $(this).removeClass('show_delete_btn');
//     $(this).addClass('delete_btn');
//     $(this).text('Delete');
//   });

</script>
@endsection