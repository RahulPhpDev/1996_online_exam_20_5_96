@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
<div id="content">
     <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>Add Course</h5>
          </div>
          <div class="widget-content nopadding">
            
                  <form class="form-horizontal" action="{{ route('update-course',Crypt::encrypt($editData->id))}}" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
             @csrf
              <div class="control-group">
                  {{ Form::label('name','Name',array('class' => 'control-label'))}}
                <div class="controls">
                    {{ Form::text('course',$editData->name) }}
                </div>
              </div>
            
                
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea cols="80" id="editor1" name="description" rows="10" >{{$editData->description}} </textarea>
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
		// CKEDITOR.config.devtools_styles =
		// 	'#cke_tooltip { line-height: 20px; font-size: 12px; padding: 5px; border: 2px solid #333; background: #ffffff }' +
		// 	'#cke_tooltip h2 { font-size: 14px; border-bottom: 1px solid; margin: 0; padding: 1px; }' +
		// 	'#cke_tooltip ul { padding: 0pt; list-style-type: none; }';
  // CKEDITOR.replace( 'editor1');
		CKEDITOR.replace( 'editor1', {
			height: 150,
      width:600,
			// extraPlugins: 'devtools'
		} );
	</script>
@endsection