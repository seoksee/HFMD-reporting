@extends('layouts.user_home')

@section('content')
  <div class="bg-login-image">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-md-3">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            {{-- <div class="row"> --}}
              {{-- <div class="col-lg-6 d-none d-lg-block "></div> --}}
              <div class="">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="phone" class="col-form-label text-md-right">{{ __('Phone Number') }}</label>
                      <input type="tel" id="phone" class="form-control form-control-user @error('phone') is-invalid @enderror" name="phone" value="{{ old('tel') }}" pattern="[0-9]{10}" required autocomplete="tel" autofocus aria-describedby="emailHelp" placeholder="Enter Phone Number...">

                      @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                      <input type="password" class="form-control form-control-user @error('password') is in-valid @enderror" id="password" required auto-complete="current-password" placeholder="Password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{ __('Login') }}
                    </button>
                    <hr>
                    <div class="text-center">
                    @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                  </div>
                  </form>
                  

                  <div class="text-center">
                  <a class="small" href="{{ route('register') }}">Create an Account!</a>
                  </div>
                </div>
              </div>
            {{-- </div> --}}
          </div>
        </div>

      </div>

    </div>

  </div>

@endsection
