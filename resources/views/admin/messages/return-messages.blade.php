@if(\Session::has('success'))
    <div class="alert alert-success"> 
      <a class="close" data-dismiss="alert" >×</a>
      {{\Session::get('success')}}
    </div>
@endif

 @if(\Session::has('error'))
    <div class="alert alert-error"> 
      <a class="close" data-dismiss="alert" >×</a>
      {{\Session::get('error')}}
    </div>
@endif

 @if(\Session::has('err_success'))
    <div class="alert alert-error"> 
      <a class="close" data-dismiss="alert" >×</a>
      {{\Session::get('err_success')}}
    </div>
@endif


@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissable flat">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif