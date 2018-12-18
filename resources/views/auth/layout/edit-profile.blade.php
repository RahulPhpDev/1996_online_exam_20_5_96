
    <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-heading">
                <div class="widget">
                    <h2 class="title-border"> Update Profile </h2>
                </div>
            </div><div class="panel-body">
                 <form id="post_req" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('register') }}">
                        @csrf    
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><small>Email <span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                          {{Auth::User()->email}} 
                     </div>
                   
                        
                    </div>
                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('First Name') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">

                        <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{Auth::User()->fname}} " required autofocus>                            
                       
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

                          <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{Auth::User()->lname}}" required autofocus>                            
                       
                         @if ($errors->has('lname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif

                           </div>
                        </div>

                     

                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Address') }}<span class="text-danger"> *</span></small></label>
                        <div class="col-sm-4">
                        <input id="address" type="text" class="form-control" value ="{{Auth::User()->address}}" name="address" required>                
                       </div>

                       
                    </div>
                  
                  
                    
                    <div class="form-group text-center">
                        <div class="col-sm-offset-2 col-sm-2">
                          <div id = "enable-button">
                        <button type="submit" class="btn btn-success"><span class="fa fa-user"></span> Save</button>
                      </div>
                      <div id = "disable-button" style="display:none">
                         <button type="submit" class="btn btn-success" disabled="disabled"><span class="fa fa-user"></span> Save</button>
                      </div>
                        </div>
                    </div>
                    </form>        
                </div>
        </div>
    