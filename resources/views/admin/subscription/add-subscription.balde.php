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
            
                {{ Form::open(array('route' => 'save-user','class' => 'form-horizontal', 'id'=>'basic_validate'))}}

               

                <div class="control-group">
                  {{ Form::label('name','Exam Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('exam_name') }}
                </div>
              </div>

            <div class="control-group">
              <label class="control-label">Exam Visible TO: </label>
              <div class="controls">
                <label>
                  <input type="checkbox" name="exam_type[]" id = "exam_type_1" value = "1"/>
                  All</label>
               
                <label>
                  <input type="checkbox" name="exam_type[]" id = "exam_type_2" value = "2"/>
                  Register Student</label>

                   <label>
                  <input type="checkbox" name="exam_type[]" id = "exam_type_3" value = "3" />
                   Selected Course </label>
              </div>
            </div>

                <div class="controls">
                    {{ Form::submit('save',array('class' => 'btn btn-success')) }}
                </div>
              </div>
              {{ Form::close() }}
          </div>
        </div>
        </div>
        </div>
</div>
</div>

@endsection