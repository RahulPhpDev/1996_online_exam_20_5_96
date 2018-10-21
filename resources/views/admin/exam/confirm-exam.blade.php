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
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>{{$title}}</h5>
          </div>
          
          <div class="widget-content nopadding">
            
               {{ Form::open(array('route' => ['save-confirm-exam', $id],'class' => 'form-horizontal', 'id'=>'basic_validate'))}}
               <?php 
               $totalQuestion = $totalMark = $totalRequiredQuestion = $totalNegativeQuestion = 0; 

               foreach($examQuestion['question'] as $que) { 
                $totalQuestion++;
                $totalMark = $totalMark + $que['question']->marks;

                 ?>
                
                <div class="control-group ">
                  <span class=" control-label span2"> Q 1 : </span>

                    <span class=" control-label span6">
                   <?php echo  htmlspecialchars_decode($que['question']->question); ?>
                  </span>
                  @if($que['is_required'] = 1)
                  <?php
                  $totalRequiredQuestion++;
                  ?>
                      <i class="icon-star text-error required_question" style="display: inline;bottom:20px"></i>
                  @endif

              </div>
               <!-- style="column-count: 2;" -->

                <div class="control-group ">
                  <?php foreach($que['options'] as $options) { ?> 
                   <div class="">
                     <div class="control-label">
                        <?php if($que['right_anser']->option_id ==  $options->id ) {  ?> 
                           <span class=""> <i class="icon-ok text-success"></i></span>
                        <?php } ?>
                      <?php echo   $options->question_option; ?>
                    </div>
                  </div>
                  <?php } ?>
                </div>

                <div class="control-group ">
                    <label class=" control-label"> Marks: </label> 
                      <div class=" controls" style="margin-top:8px ">
                     <?php echo $que['question']->marks; ?>
                    </div>
               </div>

              @if($que['question']->is_negative_marking == 1) 
              <?php
              $totalNegativeQuestion++;
              ?>
               <div class="control-group ">
                    <label class=" control-label"> Negative Marks: </label> 
                      <div class=" controls" style="margin-top:8px ">
                     <?php echo $que['question']->marks; ?>
                    </div>
               </div>
              @endif 

              <?php } ?>

       <div class="widget-box collapsible">
          <div class="widget-title"> <a href="#collapseOne" data-toggle="collapse"> <span class="icon"><i class="icon-arrow-right"></i></span>
            <h5>Other Information</h5>
            </a>
          </div>
          <div class="collapse in" id="collapseOne">
            <div class="widget-content">
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
                  {{ Form::label('passing_mark','Passing Mark Type',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::radio('passing_mark_type', '1',true) }} Number
                    {{ Form::radio('passing_mark_type', '2' , false) }} Percentage
                </div>
              </div>

               <div class="control-group">
                  {{ Form::label('passing_mark','Passing Mark',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('passing_mark') }}
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