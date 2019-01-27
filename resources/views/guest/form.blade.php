
{{ Form::open(array('route' => 'form_check','class' => 'form-horizontal', 'id'=>'basic_validate','enctype'=>'multipart/form-data'))}}
    Name
     {{ Form::text('start_date', ' ',array('class' =>'dsfa', 'id' => ''))}}
    
      <input type = "submit" name = "save">
{{form::close()}}