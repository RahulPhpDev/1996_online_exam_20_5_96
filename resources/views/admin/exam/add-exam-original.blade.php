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
            
                {{ Form::open(array('route' => ['save-exam-question', $id],'class' => 'form-horizontal', 'id'=>'basic_validate'))}}

                <div class="control-group">
                  {{ Form::label('question','Question 1',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::textarea('question[1][]',' ', array('class' => 'question editor')) }}
                </div>
              </div>

              
              <div class="controls controls-row">
              <span  class="span1"> <input type="radio" name="answer[1]" value = "0"/></span>
               <input type="text" placeholder="option 1" name = "option[1][]" class="span5 m-wrap">

                 <span  class="span1"> <input type="radio" name="answer[1]" value = "1" /></span>
               <input type="text" placeholder="Option 2"  name = "option[1][]" class="span5 m-wrap">
             </div>

             <div class="controls controls-row">
                <span  class="span1"> <input type="radio" name="answer[1]" value = "2" /></span>
               <input type="text" placeholder="Option 3" class="span5 m-wrap"  name = "option[1][]">
                <span  class="span1"> <input type="radio" name="answer[1]" value = "3"/></span>
              <input type="text" placeholder="Option 4" class="span5 m-wrap"  name = "option[1][]">
             </div>

            
              <div class="control-group controls controls-row">
                <div  class="span6"> 
                 <label class="control-label"  style="font-size: 16px"> Is Required </label>
               <div class="controls">
                  <input type="checkbox" name="is_required[1]" value="1" />
               </div>
            </div>

            <div  class="span6"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" name="total_mark[1]" />
              </div>
             </div>
           </div>


            <div class="control-group controls controls-row">
                <div  class="span6"> 
                 <label class="control-label"  style="font-size: 16px"> Is Negative Marking </label>
               <div class="controls">
                  <input type="checkbox" name="is_negative[1]" class = "is_negative" />
               </div>
            </div>

            <div  class="span6" style="display: none"> 
              <label class="control-label">Negative Marks :</label>
               <div class="controls">
                <input type="text"  name="negative_mark[1]" class="span11" placeholder="Company name" />
              </div>
             </div>
           </div>



           <div class="control-group">
                  {{ Form::label('question','Question 1',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::textarea('question[2][]',' ', array('class' => 'question editor')) }}
                </div>
              </div>

              
              <div class="controls controls-row">
              <span  class="span1"> <input type="radio" name="answer[2]" value = "0"/></span>
               <input type="text" placeholder="option 1" name = "option[2][]" class="span5 m-wrap">

                 <span  class="span1"> <input type="radio" name="answer[2]" value = "1" /></span>
               <input type="text" placeholder="Option 2"  name = "option[2][]" class="span5 m-wrap">
             </div>

             <div class="controls controls-row">
                <span  class="span1"> <input type="radio" name="answer[2]" value = "2" /></span>
               <input type="text" placeholder="Option 3" class="span5 m-wrap"  name = "option[2][]">
                <span  class="span1"> <input type="radio" name="answer[2]" value = "3"/></span>
              <input type="text" placeholder="Option 4" class="span5 m-wrap"  name = "option[2][]">
             </div>

            
              <div class="control-group controls controls-row">
                <div  class="span6"> 
                 <label class="control-label"  style="font-size: 16px"> Is Required </label>
               <div class="controls">
                  <input type="checkbox" name="is_required[2]" value="1" />
               </div>
            </div>

            <div  class="span6"> 
              <label class="control-label">Marks :</label>
               <div class="controls">
                <input type="text" name="total_mark[2]" />
              </div>
             </div>
           </div>


            <div class="control-group controls controls-row">
                <div  class="span6"> 
                 <label class="control-label"  style="font-size: 16px"> Is Negative Marking </label>
               <div class="controls">
                  <input type="checkbox" name="is_negative[2]" class = "is_negative" />
               </div>
            </div>

            <div  class="span6" style="display: none"> 
              <label class="control-label">Negative Marks :</label>
               <div class="controls">
                <input type="text"  name="negative_mark[2]" class="span11" placeholder="Company name" />
              </div>
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