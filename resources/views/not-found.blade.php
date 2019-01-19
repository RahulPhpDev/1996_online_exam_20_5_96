@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content')  
<style type="text/css">
	.error_text{
		    font-weight: 800;
    font-family: cursive;
    letter-spacing: 3px;
    color: #dc2c2c;
	}

</style>
		<div class="mb50"></div>
	

		<div class="container home">
			<div class="top-bg-overlay-fill"></div>
			<div class="lb-content text-center">
	
				<img src = "{{ asset('images/not_found.jpg') }}">
			</div>
		</div>	
			<h1 class="text-center error_text">URL Not Found</h1>
<div class="mb50"></div>
<div class="mb50"></div>
<div class="mb50"></div>
<div class="mb50"></div>

@endsection