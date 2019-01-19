
<script src="{{ asset('js/common/datatables.min.js') }}"></script>
<link href="{{ asset('css/common/jquery.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/backend_js/custom.js') }}"></script>
<script>
     $('.page-link').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, $('#form-horizontal').serialize(), function(data){
            $('#register_student').html(data);
          });
  });
  </script>


<div class="widget-content nopadding"  style = "width:80%;margin:auto">
            <table id = "data_table" class="table table-bordered table-striped">
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
                  <td>
                  <input type = "checkbox" name = "student_id[]" value = "{{$data['id']}}"></td>
                  <td>{{$data['fname'] .' '.$data['lname']}}</td>
                  <td>{{$data['email']}}</td>
                </tr>
                
           <?php $i++;} ?>
              </tbody>
            </table>
              <?php //echo $userData->render();?>
          </div>