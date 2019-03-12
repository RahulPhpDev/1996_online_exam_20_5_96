@extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')

@section('content') 
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<link href="{{ asset('css/validation.css') }}" rel="stylesheet">

<style type="text/css">
    .send_by_admin{
      background: #f7f6dd;
      width: 82%;
     border: 1px dashed #ddd;
    float: right;
  }
 .send_by_you > .panel-heading{
  background: #fdf6f6;
  
  }
.panel-default > .panel-heading span{
  padding-left:10px;
} 
.panel-default > .panel-heading a{
  padding-right:10px;
} 
     .send_by_you{
         background: #fff;
        width: 82%;
        border: 1px dashed #ddd;
        border-radius: 13px;
      }
      .panel-body{
        font-size: 16px;
        text-align: justify;
        line-height: 1.8;
        padding: 14px;
      }
</style>
<script type="text/javascript">
	
$(function(){
	  $('#save_form').validate({ // initialize the plugin
        rules: {
            name: { required: true,minlength: 3 },
            subject: { required: true,minlength: 3 },
            reply: { required: true,minlength: 3 },
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
              reply: {
                  required: "Message Should Not be blank",
                  minlength: "Message must be at least 3 characters long"
              },
              email: {required :"Email is required",email :"Not a valid email", minlength : "Email should have 3 character"},
            },
      });
  });
</script>
<div class="maincontent">
  <section class="section">
    <div class="container">
      <a style = "margin-bottom: 10px;" class ="btn btn-success pull-right" href="{{ route('feedback.create') }}">Add New Feedback </a>
      <div class="row">
       <div class = "col-md-12 col">

        <div class="mycontainer">      
            <div class = "subject__div" >
              <h4>Subject :<span> {{$feedbackData->subject}}</span> </h4> 
            </div>

            <div class="collapse-group">
            @foreach($feedbackData->MutipleFeedbackMetaData as $feed)

            @php
            $panelClass = 'send_by_admin';
            $sendByText = 'MaaRula';
            if($userId ==  $feed->sender){
              $panelClass = 'send_by_you';
              $sendByText = 'You';
            }
             $in = '';
            if(($feed->isRead == 0) && ($feed->receiver != 1)){
              $in = 'in';
            }
            @endphp

          <div class="panel panel-default {{ $panelClass }}">
            <div class="panel-heading" role="tab" id="heading_{{$feed->id}}">
              <h5 class="panel-title">
              <span> {{$sendByText}} </span>
                <a role="button" data-toggle="collapse" href="#collapse_{{$feed->id}}" aria-expanded="true" aria-controls="collapse_{{$feed->id}}" class="trigger collapsed pull-right">
                 <i class="glyphicon-glyphicon-chevron-up"> </i><i class="glyphicon-glyphicon-chevron-down"></i> {{DateTimeConvert($feed->create_date, 'd-M-Y H:i')}}
                </a>
                <span class="clearfix"></span>  
              </h5>
            </div>
            <div id="collapse_{{$feed->id}}" class="panel-collapse collapse {{$in}}" role="tabpanel" aria-labelledby="heading_{{$feed->id}}">
              <div class="panel-body">
                {{$feed->message}}
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
            @endforeach
         
        </div>
        	  <form method="POST" id = "save_form"  class="" style="padding-top:15px">
        	  	@csrf
      				 <div class="form-group">
           				 <label for="subject">Reply:</label>
            					<textarea name = "reply" id = "message" class="textarea_editor msg_textarea form-control" rows = "6" cols="6"></textarea>
      				 </div>
      				 <div class="form-group">
      					 <input type ="submit" value = "SEND" class = "btn btn-success" name = "send" style = "font-size: 17px;font-family: cursive;">
      				 </div>
        	  </form>	
        </div>
       </div>
      </div>
     
    </div>
    <?php

      use App\Http\Controllers\FeedbackController; 
      $obj = new FeedbackController();
      echo $obj->updateReadFeedbackByUser($feedbackData['id']);

    ?>

    
  </section>
</div>



@endsection