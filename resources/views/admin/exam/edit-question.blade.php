@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')   

   <script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    tex2jax: {
      inlineMath: [['$','$'], ['\\(','\\)']],
      ignoreClass: "math-editor" // put this here
    }
  });
</script>

<script type="text/javascript">


  $(document).ready(function(){    
$(".option_style").on( "click", function(){
  var txt =     $(this).parent('.controls').find('textarea').attr('id');
  
  $(this).parent('.controls').css({
      'margin-left': '150px',
      });
    $(this).hide();
  if (CKEDITOR.instances.txt_area) {
        CKEDITOR.instances.txt_area.destroy();
      } else {
        CKEDITOR.replace( txt,
            {
            height: '90px',
            width: '70%',
            } );
      }
      $.browser.chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()); 
      if($.browser.chrome){
        $(this).parent('.controls').find('.checkmark').css({
          'top': '-72px',
          'left': '-34px',
          });
} else if ($.browser.mozilla) {
  $(this).parent('.controls').find('.checkmark').css({
      'top': '39px',
      'left': '-34px',
    });
} else if ($.browser.msie) {
}
   
  });




    $('#edit_1').on('click', function() {
      $(this).hide();
  if (CKEDITOR.instances.txt_area) {
    CKEDITOR.instances.txt_area.destroy();
  } else {

    CKEDITOR.replace( 'textarea' );

  }
  });
  });

</script>
<style type="text/css">

</style>
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
           
          </div>
          <div class="widget-content">
          <div class = "form-horizontal">   
          {{ Form::open(array('route' => ['updateExamQuestion', $id], 'id'=>'basic_validate'))}}
            <div class="control-group"> 
          <input type = "hidden" name = "exam_id" value  = "{{$examID}}">
                <div class="control-group">
                  {{ Form::label('question','Question',array('class' => 'control-label'))}}
               
                <div class="controls">
                <span class = "span_style pull-right" id="edit_1">+STYLE+</span>
                <br>
                  
                </div>
                <div style = "margin-left:40px"  ><textarea name = "question" rows = '3' id = "textarea" class = "question editor question_textarea"> <?php echo htmlspecialchars_decode($questionData->question); ?></textarea>
                </div>
              </div>
            </div>
                <?php $remainingOption = 4; ?>
                @foreach($questionData->Options as $key => $options)
                   <?php
                     $remainingOption--;
                     $incrementKey = ++$key;
                  ?>
                     
                  <div class="controls controls-row option_div">
                  <span class = "span_style option_style pull-right">+STYLE+</span>
                    <?php
                       $check =  ($questionData->rightAnswer['option_id'] == $options->id) ? 'checked' :'';
                    ?> 
                     <label class="option_ra">
                        <input type="radio" name = "answer" {{$check}} value = "{{$options->id}}" />
                            <textarea class="option_txtarea" id="option_{{$options->id}}" cols="80%" name="option[{{$options->id}}]" rows="10">  <?php echo htmlspecialchars_decode($options->question_option); ?></textarea>
                         <span class="checkmark"></span>
                   </label>                 
                </div>
              @endforeach

              @if($remainingOption > 0)
                @for($i = 1; $i <= $remainingOption; $i++)
                    <div class="controls controls-row option_div">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                         <label class="option_ra">
                            <input type="radio" name = "answer" value = "new_{{$i}}" />
                                <textarea class="option_txtarea" id="option_new{{$i}}" cols="80%" name="option_new[{{$i}}]" rows="10"></textarea>
                             <span class="checkmark"></span>
                       </label>                 
                    </div>
                @endfor
              @endif
             
            <div class = "inline_div">
             <div class="">
               <div  class="controls border_top"> 
                <label class="">Marks :</label>
                  <input type="text" class = "mark"  name="total_mark" value="{{$questionData->marks}}" />
               </div>
             <!-- <div  class="controls border_top" > 
                <?php //$checked = $questionData->is_required == 1 ? 'checked' :''; ?>
                  <input type="checkbox"  style = "" name="is_required" value="1" {{--$checked--}} />
                 <label class="" style="font-size: 16px;text-align:center"> Is Required </label>               
              </div> -->
          <div class = "border_top">
                <div  class="controls  inline_div inline" style = "width:30%;display: inline-block;">                  
               <?php $negativeChecked = $questionData->is_negative_marking == 1 ? 'checked' :''; 
               $negativeVal = $questionData->is_negative_marking == 1 ? 1 :0; 
               ?>
                  <input type="checkbox" name="is_negative" value = "1" class = "is_negative" {{$negativeChecked}} />
                  <label class=""  style="font-size: 16px"> Is Negative Marking </label>
            </div>
              
            <div  class="controls negative_mark_div  inline_div inline" style="display: none"> 
              <label class="">Negative Marks :</label>
              <input type="text" class = "mark" name="negative_mark" value = "{{$questionData->negative_marks}}"   />
             </div>
           </div>
    </div>
        </div>
           <div class="controls">
                  <input type="submit" name="save" id = "update" class="btn btn-success btn-custom" value="Update">
                </div>
              </div>
              {{ Form::close() }}
            </div>
                  </div>
              </div> 
            </div>
          </div>
    </div>

<script>
      $(document).ready(function(){
           
      // $(".is_negative").click(function(){
       if ( $(".is_negative").is(':checked')) {
         $('.negative_mark_div').css("display", "inline-block");
        
       }else{
        $('.negative_mark_div').css("visibility",  "hidden");
       }
      // });
        
    // });

    $(".is_negative").click(function(){
       if ( $(".is_negative").is(':checked')) {
         $('.negative_mark_div').css("display", "inline-block");
         $('.negative_mark_div').css("visibility", "visible");
        
       }else{
        
        $('.negative_mark_div').css("visibility",  "hidden");
       }
      });
        
     });
  </script>


@endsection
