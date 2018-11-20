@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')  

<script type="text/javascript">
  
$(document).ready(function () {

    $('#basic_validate').validate({ // initialize the plugin
        rules: {
            exam_name: { required: true,minlength: 3 },
            description:{required:true},
        },
        messages: {
                  
                    exam_name: {
                        required: "Exam Name Should Not be blank",
                        minlength: "Exam Name must be at least 3 characters long"
                    },
                  
                  }
    });

});


</script>
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Update Exam</h5>
          </div>
          
          <div class="widget-content nopadding">
            
                {{ Form::open(array('route' => ['update-exam', 'id' => $id],'class' => 'form-horizontal', 'id'=>'basic_validate'))}}

                <div class="control-group">
                  {{ Form::label('name','Exam Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('exam_name', $examDetails['exam_name']) }}
                </div>
              </div>

                <div class="control-group">
                    {{Form::label('total_question' , 'Total Question', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::text('total_question',  $examDetails['total_question'],array('class' =>'mark', 'id' => '', 'readonly'))}}
                    </div>
                 </div>

                <div class="control-group">
                    {{Form::label('total_marks' , 'Total Mark', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::text('total_marks',  $examDetails['total_marks'],array('class' =>'mark', 'readonly'))}}
                    </div>
                 </div>

                    <div class="control-group">
                    {{Form::label('passing_marks_type' , 'Passing Mark Type', array('class' => 'control-label')) }}
                    <div class="controls">
                    <input type = "radio" name = "passing_marks_type" value = "1" <?php $r = ( $examDetails['passing_marks_type'] == 1) ? 'checked' : ''; echo $r; ?>> Number
                    <input type = "radio" name = "passing_marks_type" value = "2" <?php $r = ( $examDetails['passing_marks_type'] == 2) ? 'checked' : ''; echo $r; ?>> Percentage
                 
                    </div>
                 </div>


                   <div class="control-group">
                    {{Form::label('minimum_passing_marks' , 'Passing Mark', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::text('minimum_passing_marks',  $examDetails['minimum_passing_marks'] ,array('class' =>'mark') )}}
                    </div>
                 </div>


            <div class="control-group">
                    {{Form::label('Description' , 'Description', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::textarea('description',  $examDetails['description'],array('class' =>'description_div', 'id' => 'description'))}}
                    </div>
                 </div>



                <div class="control-group">
                    {{Form::label('notes' , 'Notes Before Exam', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::textarea('notes', $examDetails['notes'],array('class' =>'description_div', 'id' => 'notes'))}}
                    </div>
                 </div>

                <div class="controls">
                    {{ Form::submit('Update',array('class' => 'btn btn-success')) }}
                </div>
              {{ Form::close() }}
              </div>
          </div>
        </div>
        </div>
        </div>
</div>
</div>

<script>
    $(function(){
      $(document).ready(function(){
            CKEDITOR.editorConfig = function (config) {
           config.toolbar_Full.push({ name: 'wiris', items : [ 'ckeditor_wiris_formulaEditor','ckeditor_wiris_formulaEditorChemistry']});
      
      };
      CKEDITOR.replace('description');
      CKEDITOR.replace('notes');

       
        });

   var arr = [];
 
// $('#payable').click(function(){
//      if($(this).prop('checked')){
//        $("#amout_div").show(); 
//     $(".exam_visibility").hide();
//     $("#subscription_div").hide();
//      }else{
//       $("#amout_div").hide(); 
//     $(".exam_visibility").show();
//      }
//    });     

    });
  </script>
@endsection