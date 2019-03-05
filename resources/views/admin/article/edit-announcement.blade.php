    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Add Announcement</h5>
          </div>
          <div class="widget-content nopadding">
            
               {{ Form::open(array('class' => 'form-horizontal', 'id'=>'basic_validate'))}}
                
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                         {!!Form::textarea('content', $announcementData->content,array('class' =>'description textarea_editor span8' ,'rows'=>'6', 'id' => 'editor1',
                       'ng-model' => 'txt_textarea',
                       ))!!}
                    </div>
                </div>
                <div class="control-group">
                <div class="controls">
                    {{ Form::submit('Save',array('class' => 'btn btn-success')) }}
                </div>
              </div>
             </form>
          </div>
        </div>
       </div>
   </div>
</div>
<script type="text/javascript">
  $(function(){
      $('.textarea_editor').wysihtml5();
    });
</script>