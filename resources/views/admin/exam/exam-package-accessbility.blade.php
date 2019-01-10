@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = 'Package')
@section('content') 
<style type="text/css">
	
	.save_btn_form{
		margin-top:20px;
	}
</style>
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span> <h3>Package</h3>
           </div>
           {{ Form::open(array('route' => ['assignPackageExam', $id], 'id'=>'basic_validate'))}}
              <div class="widget-content nopadding">
                          <table id="data_table" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                               <th>Add</th>
                               <th>Exam</th>
                                <th>Package</th>
                                <th>Price</th>
                              </tr>
                            </thead>
                            <tbody>
                           <?php 
                           // for($i = 0;$i <20; $i++){
                              foreach($subscriptionsData as $data) { ?>     
                                 <tr class="odd">
                                  <td class="center"> <input class ="chk_user" type = "checkbox" checked value = "{{$data->id}}" name = "add[]"></td>
                                    <td>{{$examDetails->exam_name}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->price}}</td>      
                                  </tr>
                               <?php } 
                                foreach($allSubscription as $data) { ?>     
                                 <tr class="odd">
                                  <td  class="center"> <input class ="chk_user" type = "checkbox" value = "{{$data->id}}" name = "add[]"></td>
                                    <td>{{$examDetails->exam_name}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->price}}</td>      
                                  </tr>
                               <?php } ?>
                            </tbody>
                          </table>
                      <div class = "save_btn_form sm-offset-2">
                        <input class = "save btn btn-success btn-custom" type = "submit" value = "Add" name = "save">
                    </div>
                  </div>
               {{ Form::close() }}
          </div>
        </div> 
      </div>
    </div>
</div>
<script>
$(function(){
   
//   $(".save").on("click",function(){
//     // var arr = [];
//     //     $('input.chk_user:checkbox:checked').each(function () {
//     //         // arr.push($(this).val());
//     //     });
//         // alert(arr);
//   //      var Id =  '<?php // echo $id; ?>';
//   //  $.ajax({
//   //    url:"/remove-exam-user/"+Id,
//   //    type:"POST",
//   //    data:{all_ids: arr, "_token":"{{ csrf_token() }}"},
//   //    success:function(adata){
//   //      $("#myModal").modal('hide');
//   //    }
//   //  });
//   // });
// });
</script>

@endsection