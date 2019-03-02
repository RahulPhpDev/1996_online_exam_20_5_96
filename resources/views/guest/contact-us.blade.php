@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 

<div class="maincontent">
  <section class="section">
    <div class="container container_custom">

      <div class="row">
       <div class = "col-md-7 col">

        <div class="mycontainer">
		
        	  <form method="POST"  action = "{{route('saveContactUs')}}" class="" style="padding-top:15px">
        	  	@csrf
	        	  <div class="form-group">
	     				 <label for="name">Name:</label>
	      					<input type="text" class=" name_input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"  name="name" value="{{ old('name') }}" required autofocus >
	      					 @if ($errors->has('name'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif
				 </div>

				 <div class="form-group">
	     				 <label for="email">Email:</label>
	      					<input type="email" class=" name_input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" value="{{ old('email') }}" required autofocus >
	      					 @if ($errors->has('email'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('email') }}</strong>
		                        </span>
		                    @endif
				 </div>


				 <div class="form-group">
	     				 <label for="subject">Subject:</label>
	      					<input type="text" class=" name_input form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}"  name="subject" value="{{ old('email') }}" required autofocus >
	      					 @if ($errors->has('subject'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('subject') }}</strong>
		                        </span>
		                    @endif
				 </div>


				 <div class="form-group">
     				 <label for="subject">Message:</label>
      					<textarea name = "message" id = "message" class="msg_textarea form-control" rows = "6" cols="5"></textarea>
				 </div>

				 <div class="form-group">
					 <input type ="submit" value = "SEND" class = "btn btn-success" name = "send" style = "font-size: 17px;font-family: cursive;">
				 </div>
        	  </form>	


        </div>
       </div>

       <div class="col-sm-5 col img_div hidden-sm">
        <img class = "cont_img" src = "{{asset('images/contact_us.jpg')}}">
	        <div class = "messages">  
	        	<h4 > Send us your  Message, to us  form here . </h4>
	        	<p class = "welcome_span"> We Welcome your feedback </p>	
	        </div>

       </div>


      </div>
     
    </div>

    
  </section>
</div>



@endsection