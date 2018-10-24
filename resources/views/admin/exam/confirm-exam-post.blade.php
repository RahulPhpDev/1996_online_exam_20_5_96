@extends('layouts.partials.inner_layout')
@extends('layouts.partials.header')
@extends('layouts.partials.sidebar')
@extends('layouts.partials.footer')
@section('title', $title)
@section('content')  
<style type="text/css">
  .editor{
    width: 30x;
    height:40px;
  }
  .article-post{
    padding:10px;  
  }

  .span4{
    /*border:1px solid red;*/
  }
/*.required_question{
  font-size: 7px;
    color: red;
    position: relative;
    top: 9px;float: inherit;margin: 5px;
}*/
</style>
<div id="content">
     <div class="container-fluid">
    <hr>
      @include('admin.messages.return-messages')
    
    <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Notifications</h5>
          </div>
          <div class="widget-content">
            <div class="alert alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
              <h4 class="alert-heading">Congratulation!</h4>
              you have posted this. </div>
            <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
              <h4 class="alert-heading">Success!</h4>
             you have posted this. </div>
      
          </div>
        </div>

    </div>
  </div>
@endsection