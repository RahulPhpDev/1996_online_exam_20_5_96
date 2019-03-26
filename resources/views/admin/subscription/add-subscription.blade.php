@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<style>
.select2-container{
  width: 30%;
}
input[type="checkbox" i] {
    -webkit-appearance: checkbox;
    box-sizing: border-box;
}
div.checker input {
    opacity: 10 !important;
    filter: alpha(opacity:10);
    display: inline;
    background: none;
}

div.radio input{ opacity: 10 !important;
    filter: alpha(opacity:10);
    display: inline-block;
    background: none;
}
</style>  
<div id="content">  
  <div class="container-fluid"><hr>
    @include('admin.messages.return-messages')
    
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Package</h5>
            </div>
            <div class="widget-content nopadding">
          
                 {{Form::open(array('route' => array('save-subscription'), 'method' => 'post','class' => 'form-horizontal', 'id'=>'basic_validate','enctype'=>'multipart/form-data'))}}

                <div class="control-group">
                    {{Form::label('name', 'Name', array('class' => 'control-label'))}}
                  <div class="controls">
                      {{Form::text('name',' ', array('class' =>'name_div', 'id' => 'name'))}}
                  </div>
                </div>
                 
                 <div class="control-group">
                     {{Form::label('exam','Select Exam' , array('class' => 'control-label')) }}
                     <div class="controls">
                         <select name= "exam_id[]" multiple class="multiselect">
                            @foreach($examList as $k => $v)
                             <option value="{{$k}}"> {{$v}}</option>
                            @endforeach
                       </select>
                     </div>
                  </div>

                 <div class="control-group">
                    {{Form::label('price' , 'Price', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::text('price', ' ',array('class' =>'price_div', 'id' => 'price'))}}
                    </div>
                 </div>
                 
                  <div class="control-group">
                    {{Form::label('valid_date' , 'Valid Date', array('class' => 'control-label')) }}
                    <div class="" style="display: inline;margin-left:30px;margin-top:20px "> 
                        {{Form::checkbox('valid_date', '1',false, array('class' => 'valid_date'))}}
                      </div>
                 </div>
                 
                 <div class="control-group" id = "duration_div">
                    {{Form::label('Duration' , 'Duration', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::text('duration', ' ',array('class' =>'duration_div', 'id' => 'duration'))}}
                        <span class ="alert">In Months </span>
                    </div>
                 </div>
                 
                 <div id ="date_div" style="display: none;">
                     <div class="control-group">
                    {{Form::label('start_date','Start Date', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::text('start_date', ' ',array('class' =>'start_date datepicker', 'id' => 'start_date'))}}
                    </div>
                  </div>
                    

                    <div class="control-group">
                     {{Form::label('end_date','End Date' , array('class' => 'control-label')) }}
                     <div class="controls">
                         {{Form::text('end_date', ' ',array('class' =>'end_date datepicker', 'id' => 'end_date'))}}
                     </div>
                    </div>
                   </div>
                   <div class="control-group">
                    {{Form::label('Description' , 'Description', array('class' => 'control-label')) }}
                    <div class="controls">
                        {{Form::textarea('description', ' ',array('class' =>'description_div span8', 'id' => 'description'))}}
                    </div>
                 </div>

                 <div class="control-group">
                    {{Form::label('image' , 'Upload Photo', array('class' => 'control-label')) }}
                    <div class="controls"> 
                        {{Form::file('image')}}
                      </div>
                 </div>
                 <!-- <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>Upload Photo</small></label>
                        <div class="col-sm-4">
                        <input type="file" name="profile"  class="" id="profile"/>       
                        </div>
                    </div> -->


                  <div class="form-actions">
                 {{Form::submit('Save',array('class' => 'btn btn-success btn-lg'))}}
                </div>
                 {{ Form::close()}}
                 </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <script>
       $(document).ready(function(){
        $('.multiselect').multiselect({
                nonSelectedText: 'Select Option!',
                buttonWidth: 250,
                enableFiltering: true
            });
        $('.description_div').wysihtml5();
          $(".valid_date").on("click",function(){
              
                if($(this).prop("checked") == true){
                    $("#date_div").show();
                    $("#duration_div").hide();
                }else{
                    $("#duration_div").show();
                    $("#date_div").hide();
                }
          });

          $(".datepicker").datepicker({
            format:'yyyy-mm-dd',
          });
       });
        </script>
@endsection