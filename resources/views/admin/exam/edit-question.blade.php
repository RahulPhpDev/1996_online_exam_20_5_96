@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')   
<!-- <script src="{{ asset('js/mathJx.js') }}"> -->

   <script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({
    tex2jax: {
      inlineMath: [['$','$'], ['\\(','\\)']],
      ignoreClass: "math-editor" // put this here
    }
  });
</script>

<style type="text/css">
  

</style>
   
<script type="text/javascript">


  $(document).ready(function(){    
$(".option_style").on( "click", function(){
  var txt =     $(this).parent('.controls').find('textarea').attr('id');
  
  $(this).parent('.controls').css({
      'margin-left': '230px',
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
    CKEDITOR.replace('textarea',
            {
            height: '110px',
            width: '80%',
            } );
  }
  });
  });

</script>
<style type="text/css">
 .option_div input[type="radio"]{float: left;margin:9px 19px 2px 8px}
 .inline_div label{display: inline-block;width: 152px;text-align:right}
 .inline_div input{display:inline !important;margin-right:20px;padding-bottom:-2px}
 .border_top{border-top:1px dotted #dfdfdf}
 input.mark{padding: 6px;width: 42px;text-align: center}
 .inline{display:inline !important}
</style>
<div id="content">
     <div class="container-fluid">
    <hr>
     <!-- <h5> {{$title}}</h5> -->
     <div class="row-fluid">
      <div class="span8">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
           
          </div>
          <div class="widget-content nopadding">
          {{ Form::open(array('route' => ['updateExamQuestion', $id],'class' => 'form-horizontal', 'id'=>'basic_validate'))}} 
          <input type = "hidden" name = "exam_id" value  = "{{$examID}}">
                <div class="control-group">
                  {{ Form::label('question','Question 1',array('class' => 'control-label'))}}
               
                <div class="controls">
                <span class = "span_style pull-right" id="edit_1">+STYLE+</span>
                <br>
                  
                </div>
                <div style = "margin-left:40px"  ><textarea name = "question" rows = '3' id = "textarea" class = "question editor question_textarea"> <?php echo htmlspecialchars_decode($questionData->question); ?></textarea>
                </div>
              </div>
                @foreach($questionData->Options as $key => $options)
                   <?php
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
                <div  class="controls  inline_div inline" style = "width:30%">                  
               <?php $negativeChecked = $questionData->is_negative_marking == 1 ? 'checked' :''; 
               $negativeVal = $questionData->is_negative_marking == 1 ? 1 :0; 
               ?>
                  <input type="checkbox" name="is_negative" value = "{{$negativeVal}}" class = "is_negative" {{$negativeChecked}} />
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
         $('.negative_mark_div').css("display", "inline");
        
       }else{
        $('.negative_mark_div').css("visibility",  "hidden");
       }
      // });
        
    // });

    $(".is_negative").click(function(){
       if ( $(".is_negative").is(':checked')) {
         $('.negative_mark_div').css("display", "inline");
         $('.negative_mark_div').css("visibility", "visible");
        
       }else{
        
        $('.negative_mark_div').css("visibility",  "hidden");
       }
      });
        
     });
  </script>


@endsection
