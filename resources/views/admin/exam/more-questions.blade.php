          

 @include('layouts.partials.fetch_js')
<script type="text/javascript">
 $(function(){ 
  $('#edit_<?php echo $id; ?>').on('click', function() {
  if (CKEDITOR.instances.txt_area) {
    CKEDITOR.instances.txt_area.destroy();
  } else {
    CKEDITOR.replace('textarea_<?php echo $id; ?>');
  }
  });
});

</script>
<div class = "mt-15"></div>
<div class = "mt-15"></div>
            <div class="control-group">
                   <label class="control-label" for = "question_<?php echo $id; ?> ">Question <?php echo $id; ?></label>
               
                <div class="controls">                    
                     <button type = "button" id="edit_<?php echo $id; ?>">Editor</button>
<br/>
<!-- <textarea id="txt_area" rows="10" style="width:100%;">
  Click edit to editor this textarea using ckeditor
</textarea> -->

<textarea name = "question[<?php echo $id; ?>][]" id = "textarea_<?php echo $id; ?>" class = "question editor"></textarea>


                </div>
              </div>

              <div class="option_div mt-10" style="text-align: center;">
               <input checked type="radio" name="answer[<?php echo $id; ?>]" value = "0"/>
               <input type="text" placeholder="option 1" name = "option[<?php echo $id; ?>][]" class="span5">
              <div class = "mt-15"> 
                <input type="radio" name="answer[<?php echo $id; ?>]" value = "1" />
               <input type="text" placeholder="Option 2"  name = "option[<?php echo $id; ?>][]" class="span5">
             </div>

             <div class = "mt-15">
                <input type="radio" name="answer[<?php echo $id; ?>]" value = "2" />
               <input type="text" placeholder="Option 3" class="span5"  name = "option[<?php echo $id; ?>][]">
              </div> 
               <div class = "mt-15">
                <input type="radio" name="answer[<?php echo $id; ?>]" value = "3"/>
              <input type="text" placeholder="Option 4" class="span5"  name = "option[<?php echo $id; ?>][]">
             </div>
           </div>
            
             <div  class="" style="display: inline-block;margin-left:20px"> 
                 <label class="control-label"  style="font-size: 16px"> Required </label>
               <div class="controls">
                    <input type="checkbox" name="is_required[<?php echo $id; ?>]" value="1" />
               </div>
             </div>

             <div  class="" style="display: inline-block"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" name="total_mark[<?php echo $id; ?>]" style = "width: 20%"/>
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