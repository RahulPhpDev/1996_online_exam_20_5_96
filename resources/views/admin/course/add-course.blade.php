@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
    @if(\Session::has('error'))
    <div class="alert alert-error"> 
      <a class="close" data-dismiss="alert" >×</a>
      {{\Session::get('error')}}
    </div>
@endif
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Add Course</h5>
          </div>
          <div class="widget-content nopadding">
            
                {{ Form::open(array('route' => 'save-course','class' => 'form-horizontal', 'id'=>'basic_validate'))}}
                
              <div class="control-group">
                  {{ Form::label('name','Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('course') }}
                </div>
              </div>
            
                
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea cols="80" id="editor1" name="description" rows="10" > </textarea>
                    </div>
                </div>
                
                <div class="control-group">
                  
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
<script>
	
		CKEDITOR.replace( 'editor1');
	</script>
@endsection