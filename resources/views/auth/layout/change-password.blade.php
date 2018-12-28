<script type="text/javascript">
  $(document).ready(function () {
  $("#post_password").validate({
            ignore: [], 
            rules: {
              
                password: { required: true,minlength: 5  },
                password_confirmation:{ required: true,equalTo:"#password" },
            },
            messages: {
                password: {required :"Password is required",minlength : "password Should have 5 character"},
                password_confirmation: {required :"Confirm Password is required",equalTo: "Password is not matching "}
            },
            submitHandler: function(form) {
                $('#disable-button').show();
                $('#enable-button').hide();
               document.post_password.submit();
            },
        });
    });
</script>
<h2 class="title-border"> Change Password </h2>
<form id="post_password" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="{{ route('update-user-password') }}">
                    @csrf    
                    
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