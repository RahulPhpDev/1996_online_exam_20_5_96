@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')
	<style type="text/css">

		.message{
			    width: 73%;
    text-align: justify;
    font-size: 17px;
    font-family: initial;
    line-height: 1.5;
    padding: 15px 0px
		}

	.reply_textarea{
   			 width: 73%;
  
		}
.mail_div{
	    font-size: 16px;
       padding: 12px 0px;
}



	</style>

<div id="content">
  <div id="content-header">
   
  </div>
  <div class="container-fluid">
    <hr>
     @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-subscription') }}">Add Subscription Package </a>
	    <div class="row-fluid">
	      <div class="span12">
	      	<div class = "subject__div" >
	      		<h2>Subject :<span> This is Subject</span> </h2> 
	      	</div>	
	      	<div class="message__div">
		      <p class="message">
		        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		      	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		      	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		      	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		      	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		      	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		      </p>
	      	</div>

	      	<div class = "mail_div"> {{$feedback['email']}} </div>
	      	<form method="post">
	      		@csrf	
		      	<div class="reply_message">
		      		<textarea name ="reply" rows="16" class = "description_div textarea_editor span8 reply_textarea" id="description"></textarea>
		      	</div>	
		      	<input type = "submit" class="btn btn-primary btn-custom" value="Send">
	      	</form>
	      </div>
	     </div> 
	</div>
</div>



@endsection