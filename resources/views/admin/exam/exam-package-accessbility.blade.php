
<style type="text/css">
	
	.save_btn_form{
		margin-top:20px;
	}
</style>

            <div class="widget-content nopadding" style="width:85%;margin:auto;">
           
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
                    
          </div>