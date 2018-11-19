<style type="text/css">
	
	.save_btn_form{
		margin-top:20px;
	}
</style>
@if($examDetails->exam_visible_status == 3)

<div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <!-- <th>Remove</th> -->
                  <th>ID</th>
                  <th>Package</th>
                  <th>Price</th>
                  
                </tr>
              </thead>
              <tbody>
           <?php $i = 1;
           // dd($examDetails->UsersExam );
            foreach($examDetails->Subscriptions as $data) { 
            ?>     
               <tr class="odd">
               
                  <td>{{$i}}</td>
                  <td>{{$data->name}}</td>
                  <td>{{$data->price}}</td>      
                </tr>
           <?php $i++; } ?>
              </tbody>
            </table>
            <div class = "save_btn_form">
<input class = "save btn btn-success" type = "submit" value = "Remove" name = "save">
</div>
          </div>

          @endif

          @if($examDetails->exam_visible_status == 2)

<div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Remove</th>
                  <th>Exam</th>
                  <th>Users</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1;
           // dd($examDetails->UsersExam );
            foreach($examDetails->UserExamData as $data) { 
            ?>     
               <tr class="odd">
                <td> <input class ="chk_user" type = "checkbox" value = "{{$data->id}}" name = "remove[]"></td>
                  <td>{{$examDetails->exam_name}}</td>
                  <td>{{$data->fname. ' '.$data->lname}}</td>
                  <td>{{$data->email}}</td>      
                </tr>
           <?php $i++; } ?>
              </tbody>
            </table>
				<div class = "save_btn_form">
			    	<input class = "save btn btn-success" type = "submit" value = "Remove" name = "save">
				</div>
          </div>

 @endif
<script>
$(function(){
   
  $(".save").on("click",function(){
    var arr = [];
        $('input.chk_user:checkbox:checked').each(function () {
            arr.push($(this).val());
        });
        // alert(arr);
       var Id =  '<?php echo $id; ?>';
   $.ajax({
     url:"/remove-exam-user/"+Id,
     type:"POST",
     data:{all_ids: arr, "_token":"{{ csrf_token() }}"},
     success:function(adata){
       $("#myModal").modal('hide');
     }
   });
  });
});
</script>