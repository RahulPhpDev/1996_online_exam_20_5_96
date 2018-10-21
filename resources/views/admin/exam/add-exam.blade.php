@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')  
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Step 1</h5>
          </div>
          
          <div class="widget-content nopadding">
            
                {{ Form::open(array('route' => 'save-add-exam','class' => 'form-horizontal', 'id'=>'basic_validate'))}}

               

                <div class="control-group">
                  {{ Form::label('name','Exam Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('exam_name') }}
                </div>
              </div>

            <div class="control-group">
              <label class="control-label">Exam Visible TO: </label>
              <div class="controls" style="display: inline-block;">
                <label>
                  <input type="radio" name="exam_type" id = "exam_type_1" value = "1"/>
                  All</label>
               
                <label>
                  <input type="radio" name="exam_type" id = "exam_type_2" value = "2"/>
                  Register Student</label>

                   <label>
                  <input type="radio" name="exam_type" id = "exam_type_3" value = "3" />
                   Subscription Package </label>
              </div>
            </div>

              


            <div class="control-group" id = "subscription_div" style="display: none">
              <label class="control-label">Select Subscription Package:</label>
              <div class="controls">
                <select class="multiselect" name = "subscription[]" multiple >
                 @foreach($allSubscription as $k => $v) 
                  <option value="{{$k}}">{{$v}}</option>
                 @endforeach 
                </select>
              </div>
            </div>

          

          <div class="control-group">
              <label class="control-label">Do you want to Mark this is Payable: </label>
              <div class="controls">
                <label>
                  <input type="checkbox" name="payable" id = "payable" value = "1"/>
                  Yes</label>
            </div>
          </div>


           <div class="control-group" id = "amout_div" style = "display:none;">
                  {{ Form::label('amount','Payable Amount',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('amount') }}
                </div>
              </div>      


            <div class="control-group">
                    {{Form::label('Description' , 'Description', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::textarea('description', ' ',array('class' =>'description_div', 'id' => 'description'))}}
                    </div>
                 </div>



                <div class="control-group">
                    {{Form::label('notes' , 'Notes Before Exam', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::textarea('notes', ' ',array('class' =>'description_div', 'id' => 'notes'))}}
                    </div>
                 </div>

                <div class="controls">
                    {{ Form::submit('save',array('class' => 'btn btn-success')) }}
                </div>
              {{ Form::close() }}
              </div>
          </div>
        </div>
        </div>
        </div>
</div>
</div>
<script src="{{ asset('js/backend_js/math_ckeditor/ckeditor/ckeditor.js') }}"></script>

<script>
    $(function(){
      $(document).ready(function(){
            CKEDITOR.editorConfig = function (config) {
           config.toolbar_Full.push({ name: 'wiris', items : [ 'ckeditor_wiris_formulaEditor','ckeditor_wiris_formulaEditorChemistry']});
      };
      CKEDITOR.replace('description');
      CKEDITOR.replace('notes');

         $('.multiselect').multiselect({
                nonSelectedText: 'Select Option!',
                buttonWidth: 250,
                enableFiltering: true
            });
        });

   var arr = [];
   $("input[type=radio]").click(function () { 
   if($('#exam_type_3').is(':checked')){ 
    $("#subscription_div").show();
   }else{
    $("#subscription_div").hide();
   }
});
// $('input[name="exam_type[]"]').click(function(){
//   var atLeastOneIsChecked = $('#exam_type_3:checkbox:checked').length > 0;

//     var id = $(this).attr('id');
//    var check =  $(this).prop('checked');
//    if(id == 'exam_type_3' && check === true){
//     $("#subscription_div").show();
//    }else{
//     $("#subscription_div").hide();
//    }

   
// });
$('#payable').click(function(){
     console.log('this');
     if($(this).prop('checked')){
       $("#amout_div").show(); 
     }else{
      $("#amout_div").hide(); 
     }
   });     

    });
  </script>
@endsection