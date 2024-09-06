@extends('layouts.app')

@section('content')
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="col-md-5">
        <div class="text-center mb-4">
            <img src="{{ asset('dist/img/logo-big-without-bg.png') }}" alt="logo" style="width: 128px; height: 128px;" class="img-circle elevation-3">
        </div>
        <div class="card bg-warning">
            <div class="card-header text-center">{{ __('Login') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-8 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0 row">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-danger">
                                {{ __('Login') }}
                            </button>
                             @if (Route::has('password.request'))
                                <!-- <a class="text-weight" href="{{ route('password.request') }}">
                                    {{-- __('Forgot Your Password?') --}}
                                </a> -->
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #382B22 !important;
    }

    .container {
        height: 100vh;
    }

    .img-circle {
        border-radius: 50%;
    }

    .elevation-3 {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>
