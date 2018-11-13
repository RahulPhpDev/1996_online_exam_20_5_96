@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')  
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
/*.required_question{
  font-size: 7px;
    color: red;
    position: relative;
    top: 9px;float: inherit;margin: 5px;
}*/
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
      <style type="text/css">
      .quiz{
        background: #fff;
      }
      .quiz_header{
        padding:10px 0px 2px 10px;
        font-size:32px;
      }
        .show_question{
          /*border:1px solid red;*/
          margin:10px;
          padding:10px;
          font-size: 15px;
           border: 1px dotted transparent;
          display: block;
          box-shadow: 0px 0px 0px 1px rgba(0, 0, 1, 0.1);
        }
        .question_data{
          /*display: inline;*/
        
         margin-top:20px;
        }
        .inline{
          display: inline-block;
        }
        .question_serial{
          padding:10px;
        }
        .question{

          font-size:17px;
           letter-spacing: 0.5px;
        }
        .options_div{
         
          padding:2px 0px 2px 40px;
        }
          .options i{
              color: green;
              position: absolute;
          }
        .options a{
          padding-left:25px;
         line-height:32px;
        }
        i .required_question{
          /*position: absolute;*/
          margin-top:-30px;
        }
        .other_question_information a{
          /*display: inline;*/

          padding-left:50px;
        }
        .other_question_information span{
          padding-left:8px;
        }
        .show_question:hover {
        /*box-shadow: 0 0 11px rgba(33,33,33,.2); */
        border:1px dotted rgba(0, 0, 1, 0.1);
         background: #ededed;
        /*box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0);*/
      }
      .marks, .negative_marks {
        background: none repeat scroll 0 0 #E1E1E1;
        border-radius: 3px 3px 3px 3px;
        border: 1px solid #E1E1E1;
        /*float: ;*/
        font-size: 12px;
        margin-bottom: 10px;
        padding: 3px 10px;
        text-shadow: none;
        margin-right: 7px;
    }
     .negative_marks{
       background: none repeat scroll 0 0 orange;
       /*padding:0px 10px ;*/
       margin-left:5px;
    }
      </style>
      

      
          <?php 
               $totalQuestion = $totalMark = $totalRequiredQuestion = $totalNegativeQuestion = 0; 
                foreach($examQuestion['question'] as $que) { 
                $totalQuestion++;
                $totalMark = $totalMark + $que['question']->marks;
                  ?>
         <div class="show_question">  
            <div class="question_data">
              <span class="question_number"> Q 1 : </span>
              <span class="inline question">
                <p>
                 <?php echo  htmlspecialchars_decode($que['question']->question); ?>
                </p>
              </span>
              <i class="icon-star text-error required_question" style="display: inline"></i>
            </div>
         

            <div class="options_div">
              <?php foreach($que['options'] as $options) { ?>
                    <div class = "options" id = "option_question_id">
                      <?php if($que['right_anser']->option_id ==  $options->id ) {  ?>
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

           <div class="span4" >
              <div class="widget-box collapsible">
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