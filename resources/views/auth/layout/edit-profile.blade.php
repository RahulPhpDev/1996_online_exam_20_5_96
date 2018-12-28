
   <script type="text/javascript">
  $(document).ready(function () {
  $("#profile_post_req").validate({
            ignore: [], 
            rules: {
               fname: {required: true,minlength: 3,maxlength: 60},
               lname: {required: true,minlength: 3,maxlength: 60},
               address:{required:true,maxlength: 60},
               phone_no:{ digits: true,minlength: 10,maxlength: 11}
            },
            messages: {
               fname:{required:" First Name is required!",minlength:" First Name require minimum 3 characters!",maxlength:" First Name require max 60 characters!"},
               lname:{required:" Sur Name is required!",minlength:" Sur Name require minimum 3 characters!",maxlength:" Sur Name require max 60 characters!"},
               address: {required:" Address is required!" ,maxlength:"  max 60 characters!"},
               phone_no:{minlength:" Not valid",maxlength:" Not valid"},
            },
            submitHandler: function(form) {
                $('#disable-button').show();
                $('#enable-button').hide();
               document.profile_post_req.submit();
            },
        });
    });
</script>

   <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-heading">
                <div class="widget">
                    <h2 class="title-border"> Update Profile </h2>
                </div>
            </div>
            <div class="panel-body">
                 <form id="profile_post_req"  class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('update-user-profile') }}">
                        @csrf    
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email </label>
                        <div class="col-sm-4">
                          {{Auth::User()->email}} 
                       </div>
                    </div>
                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label">{{ __('First Name') }}</label>
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
                        <label for="group_name" class="col-sm-2 control-label">{{ __('Last Name') }}</label>
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
                        <label for="group_name" class="col-sm-2 control-label">{{ __('Mobile') }}</label>
                        <div class="col-sm-4">
                        <input id="phone_no" type="text" class="form-control" value ="{{Auth::User()->phone_no}}" name="phone_no" required> 

                        @if ($errors->has('phone_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                @endif
                       </div>
                    </div>

                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label">{{ __('Address') }}</label>
                        <div class="col-sm-4">
                            <input id="address" type="text" class="form-control" value ="{{Auth::User()->Student->address}}" name="address" required> 
                       </div>
                    </div>
                  
                        <div class="form-group text-center">
                            <div class="col-sm-offset-2 col-sm-2">
                                <div id = "enable-button">
                                    <button type="submit" class="btn btn-success btn-custom"> Update </button>
                                </div>
                                <div id = "disable-button" style="display:none">
                                    <button type="submit" class="btn btn-success btn-custom" disabled="disabled">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>        
                </div>
        </div>
    