
			<div class="">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td class="width30">Name:</td>
                      <td class="width70"><strong>
                      {{$allData->fname.' '.$allData->lname}}</strong></td>
                    </tr>
                    <tr>
                      <td>Phone Number:</td>
                      <td><strong>{{$allData->phone_no}}</strong></td>
                    </tr>
                    <tr>
                      <td>User Type:</td>
                      <td><strong>
                      	 @if($allData->user_type == 1)
                      {{'Admin'}}
                  @else
                     {{'Student'}}
                   @endif
                      </strong></td>
                    </tr>

                    @if($allData->user_type == 2)
                    <tr>
                  <td class="width30">Course</td>
                    <td class="width70"><strong>
                    <?php
                   $courseName = App\Model\Course::find($allData->course_id);
                    echo $courseName->name;
                    ?>
                    </strong> </td>
                </tr>
                <tr>
                    <td class="width30">Enrollment Number</td>
                    <td class="width70"><strong>
                    {{$allData->enroll_number}}
                    </strong> 
                   </td>
				</tr>

				<tr>
                    <td class="width30">Join Date</td>
                    <td class="width70"><strong>
                    {{$allData->join_date}}
                    </strong> </td>
				</tr>

				<tr>
                    <td class="width30">End Date</td>
                    <td class="width70"><strong>
                    {{$allData->end_date}}
                    </strong> </td>

                  </tr>
                  @endif
                    </tbody>
                  
                </table>
              </div>