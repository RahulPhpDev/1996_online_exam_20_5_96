
 @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')
<div class="maincontent">
                <section class="section">
    <div class="container mycontainer ">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-heading">
                <div class="widget">
                    <h2 class="title-border"> Registration</h2>
                </div>
            </div><div class="panel-body">
                 <form id="post_req" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('register') }}">
                        @csrf

                                    
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><small>Email <span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                     </div>
                   
                        
                    </div>
                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('First Name') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">

                        <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" required autofocus>                            
                       
                         @if ($errors->has('fname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif

                           </div>
                        </div>

                       <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Last Name') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">

                          <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" required autofocus>                            
                       
                         @if ($errors->has('lname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif

                           </div>
                        </div>

                      <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label">
                            <small>{{ __('Password') }}
                                <span class="text-danger"> *</span></small>
                            </label>

                        <div class="col-sm-4">

                         <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                     @endif
                         </div>
                    </div>


                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Confirm Password') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                             <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>                    
                     </div>
                    </div>

                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Address') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                        <input id="address" type="text" class="form-control" name="address" required>                
                       </div>

                       
                    </div>
                    <!-- <div class="form-group">
                        
                        <label for="group_name" class="col-sm-2 control-label"><small>Enrolment Number</small></label>
                        <div class="col-sm-4">
                             <input id="enrollment" type="text" class="form-control{{ $errors->has('enrollment') ? ' is-invalid' : '' }}" name="enrollment" required>

                               @if ($errors->has('enrollment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('enrollment') }}</strong>
                                </span>
                             @endif
                         </div>
                      </div>-->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>Upload Photo</small></label>
                        <div class="col-sm-4">
                        <input type="file" name="profile"  class="" id="profile"/>       
                        </div>
                       
                    </div>
                    <div class="form-group text-center">
                        <div class="col-sm-offset-2 col-sm-2">
                        <button type="submit" class="btn btn-success"><span class="fa fa-user"></span> Submit</button>
                        </div>
                    </div>
                    </form>        
                </div>
        </div>
    </div>
</section>       
 </div>
@endsection
