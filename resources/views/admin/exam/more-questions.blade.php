          

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

              <div class="controls controls-row">
              <span  class="span1"> <input checked type="radio" name="answer[<?php echo $id; ?>]" value = "0"/></span>
               <input type="text" placeholder="option 1" name = "option[<?php echo $id; ?>][]" class="span5 m-wrap">

                 <span  class="span1"> <input type="radio" name="answer[<?php echo $id; ?>]" value = "1" /></span>
               <input type="text" placeholder="Option 2"  name = "option[<?php echo $id; ?>][]" class="span5 m-wrap">
             </div>

             <div class="controls controls-row">
                <span  class="span1"> <input type="radio" name="answer[<?php echo $id; ?>]" value = "2" /></span>
               <input type="text" placeholder="Option 3" class="span5 m-wrap"  name = "option[<?php echo $id; ?>][]">
               
                <span  class="span1"> <input type="radio" name="answer[<?php echo $id; ?>]" value = "3"/></span>
              <input type="text" placeholder="Option 4" class="span5 m-wrap"  name = "option[<?php echo $id; ?>][]">
             </div>

            
              <div class="control-group controls controls-row">
                <div  class="span5"> 
                 <label class="control-label"  style="font-size: 16px"> Is Required </label>
               <div class="controls">
                  <input type="checkbox" name="is_required[<?php echo $id; ?>]" value="1" />
               </div>
            </div>

            <div  class="span4"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" name="total_mark[<?php echo $id; ?>]" />
              </div>
             </div>
           </div>


            <div class="control-group controls controls-row">
                <div  class="span5"> 
                 <label class="control-label"  style="font-size: 16px"> Is Negative Marking </label>
               <div class="controls">
                  <input type="checkbox" name="is_negative[<?php echo $id; ?>]" class = "is_negative" />
               </div>
            </div>

            <div  class="span4" style="display: none"> 
              <label class="control-label">Negative Marks :</label>
               <div class="controls">
                <input type="text"  name="negative_mark[<?php echo $id; ?>]" class="span11"  />
              </div>
             </div>
           </div>

          