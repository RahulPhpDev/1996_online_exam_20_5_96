<h2 class="title-border"> Change Password </h2>
<form id="post_req" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('register') }}">

                    <div class="form-group">
                        <label for="group_name" class="col-sm-2 control-label">
                            <small>{{ __('Old Password') }}
                                <span class="text-danger"> *</span></small>
                            </label>
                        <div class="col-sm-4" style = "  display: flex!important">
                            <input id="old_password" type="text" class=" form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="old_password" required  >
                                @if ($errors->has('old_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                        @endif
                            </div>
                           
                    </div>


            <div class="form-group">
                    <label for="group_name" class="col-sm-2 control-label">
                        <small>{{ __('Password') }}
                            <span class="text-danger"> *</span></small>
                        </label>

                    <div class="col-sm-4" style = "  display: flex!important">
                        <input id="password" type="password" class=" form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required  >
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                        </div>
                        <input type="checkbox" class = "" onclick="showPassword()" > Show Password
                </div>
                
                <div class="form-group">
                    <label for="group_name" class="col-sm-2 control-label"><small>{{ __('Confirm Password') }}<span class="text-danger"> *</span></small></label>
                    <div class="col-sm-4">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>                    
                    </div>
                </div>
            </div>
            </form>