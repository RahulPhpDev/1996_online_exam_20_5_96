@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')  

<link href="{{ asset('frontend/css/exam_question.css') }}" rel="stylesheet">
<style type="text/css">
  .editor{
    width: 30x;
    height:40px;
  }
  .article-post{
    padding:10px;  
  }

  .span4{
    /*border:1px solid red;*/
  }
</style>
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    
<div class="row-fluid">
  <div class="span8">
    <div class="quiz">
      <div class="quiz_header">
       
        <h5>{{$title}}</h5>
      </div>
       
          <?php 
               $totalQuestion = $totalMark = $totalRequiredQuestion = $totalNegativeQuestion =$questionNumber =  0; 
                foreach($examQuestion['question'] as $que) { 
                $questionNumber++;
                $totalQuestion++;
                $totalMark = $totalMark + $que['question']->marks;
                  ?>
         <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q {{$questionNumber}}: </span>
              <span class="inline question">
                <p>
                 <?php echo  htmlspecialchars_decode($que['question']->question); ?>
                </p>
              </span>

              <a  href="{{ route('edit-exam-question', ['id' =>  Crypt::encrypt($que['question']->id),'exam_id' => $id ]) }}" class = "edit_question btn btn-error pull-right"> Edit  </a>

              @if($que['question']->is_required == 1)  
              <i class="icon-star text-error required_question" style="display: inline"></i>
               @endif
            </div>
         

            <div class="options_div">
              <?php foreach($que['options'] as $options) { ?>
                    <div class = "options options_rel_div" id = "option_question_id">
                      <?php 
                   
                      if($que['right_anser']->option_id ==  $options->id ) { ?>
                          <i class = "icon icon-ok"> </i> 
                      <?php } ?>

                     <a> <?php echo   $options->question_option; ?> </a>  
                    </div> 
                    <?php } ?> 
            </div>

           <div class = "other_question_information">
                <div class="marks inline">
                   Marks:   <?php echo $que['question']->marks; ?> 
                </div>
                   @if($que['question']->is_negative_marking == 1) 
                    <?php
                    $totalNegativeQuestion++;
                    ?>

               <div class="negative_marks inline">
                      Negative Marks:    <?php echo $que['question']->marks; ?> 
                 </div>  

              @endif 
            </div> 
            </div>
              <?php } ?>



      
        </div>
      </div>

           <div class="span4 " >
              <div class="widget-box collapsible other_form_info">
          <div class="widget-title"> <a href="#collapseOne" data-toggle="collapse"> <span class="icon"><i class="icon-arrow-right"></i></span>
            <h5>Other Information</h5>
            </a>
          </div>
          <div class="collapse in" id="collapseOne">
            <div class="widget-content">
               {{ Form::open(array('route' => ['save-confirm-exam', $id],'class' => '', 'id'=>'basic_validate'))}}
               <div class="row">


                <div class="span4">
                   <ul class="recent-posts">
                    <li>
                      <div class="article-post" style="padding:10px">
                        Total Question
                      <div class="fr">
                          {{$totalQuestion}}
                        </div>
                      </div>
                    </li>              
                  </ul>
               </div>

                <div class="span4">
                   <ul class="recent-posts">
                    <li>
                      <div class="article-post" style="padding:10px">
                        Total Mark
                      <div class="fr">
                         {{$totalMark}}
                        </div>
                      </div>
                    </li>              
                  </ul>
               </div>

                <div class="span4">
                   <ul class="recent-posts">
                    <li>
                      <div class="article-post" style="padding:10px">
                        Required Question
                      <div class="fr">
                         {{$totalRequiredQuestion}}
                        </div>
                      </div>
                    </li>              
                  </ul>
               </div>

               <div class="span4">
                   <ul class="recent-posts">
                    <li>
                      <div class="article-post" style="padding:10px">
                        Total Negative Question
                      <div class="fr">
                          {{$totalNegativeQuestion}}
                        </div>
                      </div>
                    </li>              
                  </ul>
               </div>

              </div> 

              <!-- FORM -->
               <div class="control-group">
               <label class="control-label"> Passing Mark Type</label>
                
                <div class="controls">
                <input type = "radio" name = "passing_mark_type" id = "passing_mark_type" value="1" checked=""> Number
                <input type = "radio" name = "passing_mark_type" id = "passing_mark_type" value="2"> Number
                  
                </div>
              </div>

               <div class="control-group">
                  <label class="control-label"> Passing Mark</label>
                <div class="controls">
                    <input type = "text" name = "passing_mark" id = "passing_mark">
                </div>
              </div>


                <div class="controls">
                    {{ Form::submit('Save and Continue',array('class' => 'btn btn-success')) }}
                </div>

              {{Form::close()}}
              </div> 

             </div>
          </div>
         </div>
         </div>
       </div>
         </div>


    </div>

</div>
<script src="{{ asset('js/backend_js/math_ckeditor/ckeditor/ckeditor.js') }}"></script>

<script>
      $(document).ready(function(){

        // $(".edit_question").on('click', function(){
        //   var qId =   $(this).data('id');
        //   $.ajax({
        //     type : "get",
        //     url: "/edit-exam-question/"+qId,
        //     success:function(data){
        //       // console.log(data);

        //       $("#model_body").html(data);
        //     }
        //   });
        // });
            CKEDITOR.editorConfig = function (config) {
          
      };
      CKEDITOR.replaceClass="editor";

      $(".is_negative").click(function(){
       if ($(this).is(':checked')) {
        var id = $(this).parent().parent().next('div').css("display", "block");
       }else{
        var id = $(this).parent().parent().next('div').css("display", "none");
       }
      });
    });
  </script>


@endsection
