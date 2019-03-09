@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = ' Feedback')

@extends('frontend_layouts.partials.fetch_angular')

@section('content')

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
<div id="content">
     <div class="container-fluid"  ng-controller="feedbackController">
      <hr>
      
      @include('admin.messages.return-messages')
     <a class ="btn btn-success pull-right" href="{{ route('add-user') }}">Add User </a>
    <div class="row-fluid">
        <div class="span12">
          
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
            <div id="collapse_{{$feed->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{$feed->id}}">
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
                      <textarea name = "reply" id = "message" class="textarea_editor msg_textarea span7 form-control" rows = "6" cols="6"></textarea>
               </div>
               <div class="form-group">
                 <input type ="submit" value = "SEND" class = "btn btn-success" name = "send" style = "font-size: 17px;font-family: cursive;">
               </div>
            </form> 
        </div>

        </div>
       </div> 
    </div>
</div>

<script type="text/javascript">
    $(".open-button").on("click", function() {
  $(this).closest('.collapse-group').find('.collapse').collapse('show');
  $(this).closest('.panel-collapse').css({'padding':' 6px 0px 27px 5px','top': '11px','width': '86%','left': '-2px','border-top': '1px solid white'});
});

$(".close-button").on("click", function() {
  $(this).closest('.collapse-group').find('.collapse').collapse('hide');
});

</script>
@endsection
