<div class="widget-content nopadding" >
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th> Id </th>
                  <th>Select</th>
                  <th>Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
           <?php $i = 1; foreach($userData as $data) { 

            ?>     
                <tr class="odd gradeX" id = "user_{{$data['id']}}">
                  <td>{{$i}}</td>
                  <td><input type = "checkbox" name = "student_id[]" value = "{{$data['id']}}"></td>
                  <td>{{$data['fname'] .' '.$data['lname']}}</td>
                  <td>{{$data['email']}}</td>
                
                
                </tr>
                
           <?php $i++;} ?>
              </tbody>
            </table>
          </div>