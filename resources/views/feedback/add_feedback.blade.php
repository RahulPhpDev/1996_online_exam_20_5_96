@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<link href="{{ asset('css/validation.css') }}" rel="stylesheet">


<script type="text/javascript">
	
$(function(){
	  $('#save_form').validate({ // initialize the plugin
        rules: {
            name: { required: true,minlength: 3 },
            subject: { required: true,minlength: 3 },
            message: { required: true,minlength: 3 },
           email: { required: true, email: true,minlength: 3  },
        },
        messages: { 
              name: {
                  required: "Name Should Not be blank",
                  minlength: "Name must be at least 3 characters long"
              },
              subject: {
                  required: "Subject Should Not be blank",
                  minlength: "Subject must be at least 3 characters long"
              },
              message: {
                  required: "Message Should Not be blank",
                  minlength: "Message must be at least 3 characters long"
              },
              email: {required :"Email is required",email :"Not a valid email", minlength : "Email should have 3 character"},
            },
      });
    
      // $('.textarea_editor').wysihtml5();

  });
</script>
<div class="maincontent">
  <section class="section">
    <div class="container">

        @if (session('status'))
			<div class="alert alert-success" role="alert">
			   {{ session('status') }}
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>                      
        </div>
        @endif
      <div class="row">
       <div class = "col-md-7 col">

        <div class="mycontainer">                  
            <?php
             $readOnly = '';
             $nameValue = old('name');
             $emailValue = old('email');
             if(Auth::User()){
             	$nameValue =  Auth::User()->fname.' '.Auth::User()->lname;
             	$emailValue = Auth::User()->email;
             	$readOnly = 'readonly';
             }
            ?>
         
{!! Form::open(['action' => 'FeedbackController@store',    'id' => 'save_form'])    !!}

        	
	        	  <div class="form-group">
	     				 <label for="name">Name:</label>
	      					<input type="text" class=" name_input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id = "name" name="name" value="{{ $nameValue }}" {{$readOnly}}  required autofocus  >
	      					 @if ($errors->has('name'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif
				 </div>

				 <div class="form-group">
	     				 <label for="email">Email:</label>
	      					<input type="email" class=" name_input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id = "email"  name="email" value="{{ $emailValue }}" {{$readOnly}} required autofocus >
	      					 @if ($errors->has('email'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('email') }}</strong>
		                        </span>
		                    @endif
				 </div>


				 <div class="form-group">
	     				 <label for="subject">Subject:</label>
	      					<input type="text" id = "subject" class=" name_input form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}"  name="subject" value="{{ old('subject') }}" required autofocus >
	      					 @if ($errors->has('subject'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('subject') }}</strong>
		                        </span>
		                    @endif
				 </div>


				 <div class="form-group">
     				 <label for="subject">Message:</label>

      					<textarea name = "message" id = "message" class="textarea_editor msg_textarea form-control" rows = "6" cols="6">{{Request::old('message')}}</textarea>
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