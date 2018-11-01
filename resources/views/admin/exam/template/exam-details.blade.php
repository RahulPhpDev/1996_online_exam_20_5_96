

         <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse"> <span class="icon"><i class="icon-ok"></i></span>
                <h5>Exam Details</h5>
                </a> </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                
                <div class="widget-content nopadding updates">
            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
             <div class="update-done"><span class="update-day">Exam :</span></div>
              <div class="update-date"><strong>{{$title}}</strong></div>
              </div>
            </div>
            @if($getExamData->Subscriptions())
            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
                Exam Package
              </strong>
              </div>
              <div class="update-date"><span class="update-day"><strong>
          <?php foreach($getExamData->Subscriptions as $name){
                echo $name->name;
              }
            ?>
        </strong></span></div>
            </div>
          @endif
            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
                Total Questions
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$getExamData['total_question']}}</span></div>
            </div>

             <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
                 Negative Question
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$getExamData['negative_question']}}</span></div>
            </div>

            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
                Negative Marks
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$getExamData['negative_marks']}}</span></div>
            </div>


            

            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
                Required Question
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$getExamData['required_question']}}</span></div>
            </div>
            
          <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><strong>
                Total Marks
              </strong>
              </div>
              <div class="update-date"><span class="update-day">{{$getExamData['total_marks']}}</span></div>
            </div>

          </div>



              </div>
            </div>
          </div>

