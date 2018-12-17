          

 @include('layouts.partials.fetch_js')
 <style>
 
 </style>
<script type="text/javascript">
 $(function(){ 
  $('#edit_<?php echo $id; ?>').on('click', function() {
  if (CKEDITOR.instances.txt_area) {
    CKEDITOR.instances.txt_area.destroy();
  } else {
    CKEDITOR.replace( 'textarea_<?php echo $id; ?>',
            {
            height: '80px',
            width: '90%',
            } );
          }
  });

   $(".option_style").on( "click", function(){
  var txt =     $(this).parent('.controls').find('textarea').attr('id');
  
  $(this).parent('.controls').css({
      'margin-left': '230px',
      });
  console.log(txt);
    $(this).hide();


  if (CKEDITOR.instances.txt_area) {
        CKEDITOR.instances.txt_area.destroy();
      } else {
        CKEDITOR.replace( txt,
            {
            height: '50px',
            width: '70%',
            } );
      }
    $(this).parent('.controls').find('.checkmark').css({
      'top': '-72px',
      'left': '-34px',
    });
  });

});

</script>

<div class = "mt-15"></div>
<div class = "mt-15"></div>
            <div class="control-group" sytle = "border-top: 2px dashed #dedede;">
                   <label class="control-label" for = "question_<?php echo $id; ?> ">Question <?php echo $id; ?></label>
               
                <div class="controls">                    
                    <span class = "span_style pull-right" id="edit_<?php echo $id; ?>">+STYLE+</span><br>
                       <textarea name = "question[<?php echo $id; ?>][]" id = "textarea_<?php echo $id; ?>" class = "question editor" ,rows = 3>
                      </textarea>
                    </div>
               </div>

               <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio" checked name="answer[<?php echo $id; ?>]" value = "0" />
                    <textarea class="option_txtarea" id="option_{{$id}}_0" cols="80%" name="option[{{$id}}][]" rows="10"> </textarea>
                  <span class="checkmark"></span>
                </label>
              </div>

              <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio"  name="answer[<?php echo $id; ?>]" value = "1" />
                    <textarea class="option_txtarea" id="option_{{$id}}_1" cols="80%" name="option[{{$id}}][]" rows="10"> </textarea>
                  <span class="checkmark"></span>
                </label>
              </div>

               <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio"  name="answer[<?php echo $id; ?>]" value = "2" />
                    <textarea class="option_txtarea" id="option_{{$id}}_2" cols="80%" name="option[{{$id}}][]" rows="10"> </textarea>
                  <span class="checkmark"></span>
                </label>
              </div>

               <div class="controls">
                      <span class = "span_style option_style pull-right">+STYLE+</span>
                    <label class="option_ra">
                    <input type="radio"  name="answer[<?php echo $id; ?>]" value = "3" />
                    <textarea class="option_txtarea" id="option_{{$id}}_3" cols="80%" name="option[{{$id}}][]" rows="10"> </textarea>
                  <span class="checkmark"></span>
                </label>
              </div>

            
            
             <!-- <div  class="" style="display: inline-block;margin-left:20px"> 
                 <label class="control-label"  style="font-size: 16px"> Required </label>
               <div class="controls">
                    <input type="checkbox" name="is_required[<?php echo $id; ?>]" value="1" />
               </div>
             </div> -->

             <div  class="" style="display: inline-block"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" class="total_mark_input" name="total_mark[<?php echo $id; ?>]" style = "width: 20%"/>
              </div>
             </div>


             <div  class="">
              <div  class=""  style="display: inline-block;margin-left:20px"> 
                 <label class="control-label"  style="font-size: 16px"> Is Negative Marking </label>
               <div class="controls">
                 <input type="checkbox" name="is_negative[<?php echo $id; ?>]" class = "is_negative" />
               </div>
            </div>

            <div  class="" style="display: none"> 
              <label class="control-label">Negative Marks :</label>
               <div class="controls">
                <input type="text"  name="negative_mark[<?php echo $id; ?>]" style = "width: 20%" class=""  />
              </div>
             </div>
           </div>


           
<script>
      $(document).ready(function(){

      $(".is_negative").click(function(){
       if ($(this).is(':checked')) {
        var id = $(this).parent().parent().next('div').css("display", "inline-block");
       }else{
        var id = $(this).parent().parent().next('div').css("display", "none");
       }
      });
        
    });
  </script>