
 @include('layouts.partials.fetch_js')
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
    $('#edit_1').on('click', function() {
  // alert('hello');
  if (CKEDITOR.instances.txt_area) {
    CKEDITOR.instances.txt_area.destroy();
  } else {
    CKEDITOR.replace('textarea');
  }
  });


$('#update').on('click', function() {
 var editorVal =  CKEDITOR.instances['textarea'].getData();

 // alert(dd);
 $.ajax({
     type: 'post',
     url: '/updateExamQuestion',
     data: {
         '_token': $('input[name=_token]').val(),
         'id': <?php echo $e_id;?>,
         'option1': $('input[name=option1]').val(),
         'question': editorVal,
         'option2': $('input[name=option2]').val(),
         'option3': $('input[name=option3]').val(),
         'option4': $('input[name=option4]').val(),
         'is_required': $('input[name=is_required]').val(),
         'total_mark': $('input[name=total_mark]').val(),
         'is_negative': $('input[name=is_negative]').val(),
         'negative_mark': $('input[name=negative_mark]').val(),
     },
     success: function(succ_data) {
          location.reload();

     }
 });
});

  });

</script>
<!-- <div id="content">
     <div class="container-fluid">
    <hr>
     <h5> {{$title}}</h5>
      -->

                {{ Form::open(array('','class' => '', 'id'=>'basic_validate'))}}

                <div class="control-group">
                  {{ Form::label('question','Question 1',array('class' => 'control-label'))}}
                <div class="controls">
                <button type = "button" id="edit_1">Editor</button>
                    <br/>
                    {{-- Form::textarea('question',($test), array('id' => 'textarea','class' => 'question editor')) --}}
                    <textarea name = "qustion" id = "textarea" class = "question editor"> <?php echo htmlspecialchars_decode($test); ?></textarea>
                </div>
              </div>
                @foreach($questionData->Options as $key => $options)  
                  <div class="controls controls-row">
                  <input type="text" name = "option{{++$key}}" id = "option{{++$key}}" value = "{{$options->question_option}}" class="span5 m-wrap" >
                </div>
              @endforeach

             <div class="control-group controls controls-row">
                <div  class="span5"> 
                 <label class="control-label"  style="font-size: 16px"> Is Required </label>
               <div class="controls">
               <?php $checked = $questionData->is_required == 1 ? 'checked' :''; ?>
                  <input type="checkbox" name="is_required" value="1" {{$checked}} />
               </div>
            </div>

            <div  class="span4"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" name="total_mark" value="{{$questionData->marks}}" />
              </div>
             </div>
           </div>
           
            <div class="control-group controls controls-row">
                <div  class="span5"> 
                 <label class="control-label"  style="font-size: 16px"> Is Negative Marking </label>
               <div class="controls">
               <?php $negativeChecked = $questionData->is_negative_marking == 1 ? 'checked' :''; ?>
                  <input type="checkbox" name="is_negative" class = "is_negative" {{$negativeChecked}}/>
               </div>
            </div>

            <div  class="span4 negative_mark_div" style="display: none"> 
              <label class="control-label">Negative Marks :</label>
               <div class="controls">
                <input type="text"  name="negative_mark" class="span11" value = "{{$questionData->negative_marks}}"   />
              </div>
             </div>
           </div>

           <div class="controls">
                  <button name="save" type="button" id = "update" class="btn btn-success" value="save">Update</button>

                </div>

              {{ Form::close() }}
            
    <!-- </div>
</div>
 -->
<script>
      $(document).ready(function(){
           
      // $(".is_negative").click(function(){
       if ( $(".is_negative").is(':checked')) {
         $('.negative_mark_div').css("display", "block");
        
       }else{
        $('.negative_mark_div').css("display",  "none");
       }
      });
        
    // });
  </script>