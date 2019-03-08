@extends('layouts.partials.inner_layout')

@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = 'D')
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


.controls {
  margin-bottom: 10px;
}

.collapse-group {
  padding: 10px;
  border: 1px solid darkgrey;
  margin-bottom: 10px;
}

.panel-title .trigger:before {
  content: '\e082';
  font-family: 'Glyphicons Halflings';
  vertical-align: text-bottom;
}

.panel-title .trigger.collapsed:before {
  content: '\e081';
}

.collapse-group {
    padding: 15px;
    margin-bottom: 10px;
    border:none;
    width: 90%;
    /*margin-top:20px;*/
}
.panel-default{
	    border-bottom: 1px solid #666;
}
.panel{padding: 25px;}
.panel-collapse
{   
 /*height: auto;*/
    /*border-top: 1px solid white;
    padding: 6px 0px 27px 5px;
    top: 11px;
    left: -2px;
    width: 86%;*/
}

	</style>
<script type="text/javascript">
	$(".open-button").on("click", function() {
  $(this).closest('.collapse-group').find('.collapse').collapse('show');
  $(this).closest('.panel-collapse').css({'padding':' 6px 0px 27px 5px','top': '11px','width': '86%','left': '-2px','border-top': '1px solid white'});
});

$(".close-button").on("click", function() {
  $(this).closest('.collapse-group').find('.collapse').collapse('hide');
});

</script>
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
	      			<h4>Subject :<span> {{$feedbackData->subject}}</span> </h4> 
	      		</div>

	      		<div class="collapse-group">
	      		@foreach($feedbackData->MutipleFeedbackMetaData as $feed)
	      		
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="heading_{{$feed->id}}">
				      <h5 class="panel-title">
				        <a role="button" data-toggle="collapse" href="#collapse_{{$feed->id}}" aria-expanded="true" aria-controls="collapse_{{$feed->id}}" class="trigger collapsed pull-right">
				         Message On {{DateTimeConvert($feed->create_date, 'Y-M-d H:i:s')}}
				        </a>
				        <span class="clearfix"></span>	
				      </h5>
				    </div>
				    <div id="collapse_{{$feed->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{$feed->id}}">
				      <div class="panel-body">
				      	{{$feed->message}}
				      </div>
				    </div>
				  </div>
	      		@endforeach
				 
				</div>
				Send Message Reply
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