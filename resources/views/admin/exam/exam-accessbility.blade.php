
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


<div class="widget-content nopadding"  style="width:85%;margin:auto;">
            <table id = "data_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Add</th>
                  <th>Exam</th>
                  <th>Users</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                 <?php 
                           // for($i = 0;$i <20; $i++){
                              foreach($examDetails->UserExamData as $data) { ?>     
                                 <tr class="odd">
                                  <td class="center"> <input class ="chk_user" type = "checkbox" checked value = "{{$data->id}}" name = "add[]"></td>
                                    <td>{{$examDetails->exam_name}}</td>
                                    <td>{{$data->fname. ' '.$data->lname}}</td>
                                    <td>{{$data->email}}</td>      
                                  </tr>
                               <?php } 
                                foreach($allUser as $user) { ?>     
                                 <tr class="odd">
                                  <td  class="center"> <input class ="chk_user" type = "checkbox" value = "{{$user->id}}" name = "add[]"></td>
                                    <td>{{$examDetails->exam_name}}</td>
                                    <td>{{$user->getFullName()}}</td>
                                    <td>{{$user->email}}</td>      
                                  </tr>
                               <?php } ?>
              </tbody>
            </table>
             
          </div>