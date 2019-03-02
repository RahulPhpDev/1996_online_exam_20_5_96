 @extends('frontend_layouts.partials.inner_layout')
@extends('frontend_layouts.partials.header')
@extends('frontend_layouts.partials.sidebar')
@extends('frontend_layouts.partials.footer')
@section('content')
<style type="text/css">
 .wrapper {
    position: relative;
    width: 10px;
    height: 300px;
    /*border: 1px dashed #ccc;*/
    margin: 10px;
}

.line {
    position: absolute;
    left: 49%;
    top: 0;
    bottom: 0;
    width: 1px;
    background: #ccc;
    z-index: 1;
}

.wordwrapper {
    text-align: center;
    height: 12px;
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    margin-top: -12px;
    z-index: 2;
}

.word {
 color: #ccc;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: -1px;
    font: bold 12px arial,sans-serif;
    background: #f5f5f5;
    margin-left: -4px;
    /* font-size: 13px; */
    font-family: cursive;
}
.singin__div, .login__div{
    padding-top:41px;
}
.google__singin{
      width: 83%;
    margin-left: 18px;
}
.facebook__signin{
        padding-top: 30px;
}
</style>
<div class="container" style = "margin-top:30px">
    <div class="row justify-content-center">
        <div class="col-md-7 login__div">
            <div class="card">

                <div class="card-body">
                    <form method="POST"  class="form-horizontal" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right control-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right control-label">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check control-label">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4 control-label">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class = " col-md-1 hidden-sm">
            <div class="wrapper">
                <div class="line"></div>
                <div class="wordwrapper">
                    <div class="word">or</div>                                        
                </div>
            </div>​
        </div>

          <div class = " col-md-4 singin__div hidden-sm ">
            <div class = "google__singin">
              <a href = "login/google"> <img src = "{{asset('images/google_singin.png')}}">  </a>
            </div>

            <div class="facebook__signin">
                <a href = "login/facebook"> <img src = "{{asset('images/facebook_signin.png')}}">  </a>
                
            </div>
        </div>


    </div>
</div>
@endsection


