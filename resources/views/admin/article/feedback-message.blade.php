<div class="">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Feedback Message</h5>
          </div>
          <div class=" ">
            <table id = "data_table"  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> Id </th>
                  <th>Subject</th>
                  <th>Date</th>
                  <th>Reply</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($userFeedback as $data) { ?>     
                <tr class="odd gradeX">
                  <td>{{$i}}</td>
                  <td>{{$data['subject']}}</td>
                  
                  <td>{{$data['add_date']}}</td>
                  	
                  <td>
                  <a class = "text-center btn btn-og view_details" href = "{{route('feedback-reply', ['id' => $data['id'] ]) }}">Reply
					</a>
                  </td>
                </tr>
              <?php $i++;} ?>
              </tbody>
            </table>
          </div>
        </div>