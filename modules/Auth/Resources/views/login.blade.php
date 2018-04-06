@include('admin.layouts.head')
<body>
<div id="app">
    <div class="login-bg"></div>
    <div class="container">
        <div class="login-app-text">MTNESS</div>
            <form class="login-box" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="login-title mb-4">Login</div>
                @if ($errors->has('email'))
                <div class="login-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>{{ $errors->first('email') }}</strong>
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
                @endif
                
                <div class="login-input mb-3">
                    <input type="text" class="form-control" placeholder="Email o usuario" value="{{ old('email') }}"name="email" required autofocus>
                    <i class="fas fa-user"></i>
                </div>

                <div class="login-input mb-3">
                        <input id="password" type="password" class="form-control"placeholder="password" name="password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Remember Me</label>
                    </div>


                <button type="submit" class="btn btn-primary btn-block mb-2">
                    Login
                </button>
                <a class="login-forgot mb-4" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
                

            </form>
                    
        </div>
    </div>
</div> 
</body>
@include('admin.layouts.scripts')

</html>