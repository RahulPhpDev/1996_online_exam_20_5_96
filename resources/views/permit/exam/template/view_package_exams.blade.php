<style type="text/css">
   .text_item {
    padding:0px 0px 0px 20px;
    font-size:18px;
  }
  .text_heading{
    text-align: center;
    padding-right:30px;
    padding-top:10px;
  }
  .text_heading strong{
    display: inline-block;
  width: 130px;
  text-align: right;
  }
</style>
 
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
              @if($package->Exam->toArray())
                @foreach($package->Exam as $k => $exam)
                @php
                $active = '';
                if($k == 0){
                  $active = 'active';
                }
                @endphp
                <a  href="#tab2" class="list-group-item text-center {{$active}}">
                  <h4 class="glyphicon glyphicon-book"></h4><br/>
                  {{$exam->exam_name}}
                </a>
               @endforeach

             
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                @foreach($package->Exam as $k => $exam)
                @php
                $active = '';
                if($k == 0){
                  $active = 'active';
                }
                @endphp
                <div class="bhoechie-tab-content {{$active}}">
                    <center>
                    <h1 class="glyphicon glyphicon-book" style="font-size:10em;color:#55518a"></h1>
                     <div class="text_heading">
                      <strong>
                           Total Questions :
                        </strong>
                        <span class="text_item">{{$exam->total_question}}
                        </span>
                     </div>

                     <div class="text_heading"><strong>
                            Required Question :
                        </strong>
                        <span class="text_item">{{$exam->required_question}}
                        </span>
                     </div>


                     <div class="text_heading"><strong>
                          Negative Question :
                        </strong>
                        <span class="text_item">{{$exam->negative_question}}
                        </span>
                     </div>

                     <div class="text_heading"><strong>
                           Negative Marks :
                        </strong>
                        <span class="text_item">{{$exam->negative_marks}}
                        </span>
                     </div>

                      <div class="text_heading"><strong>
                            Total Marks :
                        </strong>
                        <span class="text_item">{{$exam->total_marks}}
                        </span>
                     </div>
              
                    </center>

                    <div class="addtocart" style="margin-top:15px;">
                        <a href="{{route('exam-instruction', Crypt::encrypt($exam->id))}}"  class="btn btn-success shopCart" id="addtocart" style="background: #68c6ec;border: #68c6ec;border-radius: 10px: ">&nbsp; Explore Exam</a>       
                  </div>
                </div>
               @endforeach
              @else
             Sorry !!! No Exams In This Package
              @endif

            </div>
        </div>