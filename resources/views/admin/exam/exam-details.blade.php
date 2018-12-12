
            <table class="table table-bordered table-striped ">
              <thead>
                <tr>
                  <th>Name</th>
                 
                  <th>Total Question</th>
                  <th>Total Mark</th>
                  <th>Passing Mark</th>
                </tr>
              </thead>
              <tbody>
            
                <tr class="odd">
                   <td> {{$examDetails['exam_name']}}</td>
                    <td> {{$examDetails['total_question']}} </td>
                    <td> {{$examDetails['total_marks']}}</td>
                    <td> {{$examDetails['minimum_passing_marks']}} </td>
              
              </tbody>
            </table>