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
            course: { required: true,minlength: 3 },
        },
        messages: { 
              course: {
                  required: "Course Name Should Not be blank",
                  minlength: "Course Name must be at least 3 characters long"
              },
            },
      });
 });
</script>
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
                         {{Form::textarea('description', $editData->description,array('class' =>'description span8' ,'rows'=>'6', 'id' => 'editor1'))}}
                     
                    </div>
                </div>
                
                <div class="control-group">
                  
                <div class="controls">
                    {{ Form::submit('Update',array('class' => 'btn btn-success btn-custom')) }}
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
   $('.description').wysihtml5();
	</script>
@endsection