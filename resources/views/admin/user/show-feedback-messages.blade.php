@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title = ' Feedback')

@push('angular')
  @include('layouts.partials.fetch_layout_angular')
@endpush

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
     
    <div class="row-fluid">
        <div class="span12">
          
            <div class="mycontainer">      
            <div class = "subject__div" >
              <fieldset class="scheduler-border" style="width:50%">
                 <legend class="scheduler-border">User Details</legend>
                 <table id="customers" class="table table-hover" style="width:80%;margin:auto"  ng-init="examDetails;">
                    <tr>
                      <th> Name: </th>
                      <td>{{$feedbackData->name}}  </td>
                    </tr>
                     <tr>
                      <th>Email </th>
                      <td> {{$feedbackData->email}} </td>
                    </tr>
                     
                  </table> 

             </fieldset>

              <h4>Subject :<span> {{$feedbackData->subject}}</span> </h4> 
            </div>

            <div class="collapse-group">
            @foreach($feedbackData->MutipleFeedbackMetaData as $feed)

            @php
            $panelClass = 'send_by_admin';
            $sendByText = 'User';
            if($userId ==  $feed->sender){
              $panelClass = 'send_by_you';
              $sendByText = 'You';
            }
            $in = '';
            if(($feed->isRead == 0 ) && ( $feed->receiver == 1)){
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
<?php


    use App\Http\Controllers\Admin\UserController; 
    $obj = new UserController();
    echo $obj->updateReadByAdmin($id);

?>
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

