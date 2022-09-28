@extends('layouts.auth')
@section('page-title')
    {{__('Register')}}
@endsection
@php
    $logo=asset(Storage::url('uploads/logo/'));
@endphp

@push('custom-scripts')
@if(env('RECAPTCHA_MODULE') == 'yes')
        {!! NoCaptcha::renderJs() !!}
@endif
@endpush
@section('language-bar')
<li class="nav-item">
    <select name="language" id="language" class="lang-dropdown btn btn-primary my-1 me-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        @foreach(App\Models\Utility::languages() as $language)
            <option @if($lang == $language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}</option>
        @endforeach
    </select>
</li>

@endsection

@section('content')
    {{-- <div class="login-contain">
        <div class="login-inner-contain">
            <a class="navbar-brand" href="#">
                <img src="{{$logo.'/logo.png'}}" class="navbar-brand-img" alt="logo">
            </a>
            <div class="login-form">
                <div class="page-title"><h5>{{__('Register')}}</h5></div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-control-label">{{__('Name')}}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-control-label">{{__('Email')}}</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="invalid-feedback">
                            {{__('Please fill in your email')}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-control-label">{{__('Password')}}</label>
                        <input id="password" type="password" data-indicator="pwindicator" class="form-control pwstrength @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-control-label">{{__('Password Confirmation')}}</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                        @if(env('RECAPTCHA_MODULE') == 'yes')
                        <div class="form-group">
                            {!! NoCaptcha::display() !!}
                            @error('g-recaptcha-response')
                            <span class="small text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endif

                    <div class="custom-control custom-checkbox remember-me-text">
                        <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                        <label class="custom-control-label" for="agree">{{__('I agree with the terms and conditions')}}</label>
                    </div>
                    <button type="submit" class="btn-login">{{__('Register')}}</button>
                    <div class="or-text">{{__('OR')}}</div>
                    <small class="text-muted">{{__("Already have an account?")}}</small>
                    <a href="{{ route('login') }}" class="text-xs text-primary">{{__('Login')}}</a>
                </form>
            </div>

            <h5 class="copyright-text">
                {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright HRMGo') }} {{ date('Y') }}
            </h5>
            <div class="all-select">
                <a href="#" class="monthly-btn">
                    <span class="monthly-text py-0">{{__('Change Language')}}</span>
                    <select class="select-box select2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
                        @foreach(Utility::languages() as $language)
                            <option @if($lang == $language) selected @endif value="{{ route('register',$language) }}">{{Str::upper($language)}}</option>
                        @endforeach
                    </select>
                </a>
            </div>
        </div>
    </div> --}}
    <div class="card">
        <div class="row align-items-center text-start">
            <div class="col-xl-6">
                {{Form::open(array('route'=>'register','method'=>'post','id'=>'loginForm'))}}
                    <div class="card-body">
                        <div class="">
                            <h2 class="mb-3 f-w-600">{{ __('Register') }}</h2>

                        </div>
                        <div class="">
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Full Name') }}</label>
                                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Username')))}}
                            </div>
                            @error('name')
                            <span class="error invalid-name text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Email') }}</label>
                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Email address')))}}
                            </div>
                            @error('email')
                            <span class="error invalid-email text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Password') }}</label>
                                {{Form::password('password',array('class'=>'form-control','id'=>'input-password','placeholder'=>__('Password')))}}
                            </div>
                            @error('password')
                            <span class="error invalid-password text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-group">
                                <label class="form-label">{{__('Confirm password')}}</label>
                                    {{Form::password('password_confirmation',array('class'=>'form-control','id'=>'confirm-input-password','placeholder'=>__('Confirm Password')))}}
                                    {{-- <div class="input-group-append">
                                        <span class="input-group-text">
                                          <a href="#" data-toggle="password-text" data-target="#confirm-input-password">
                                            <i class="fas fa-eye"></i>
                                          </a>
                                        </span>
                                    </div> --}}
                                @error('password_confirmation')
                                <span class="error invalid-password_confirmation text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @if(env('RECAPTCHA_MODULE') == 'yes')
                            <div class="form-group col-lg-12 col-md-12 mt-3">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                <span class="error small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif
                            <div class="d-grid">
                                <button class="btn btn-primary btn-block mt-2">{{ __('Register') }}</button>
                            </div>

                        </div>
                        <p class="mb-2 my-4 text-center">{{ __('Already have an account?') }} <a href="{{ route('login') }}" class="f-w-400 text-primary">{{ __('Login') }}</a></p>
                    </div>
            </div>
            <div class="col-xl-6 img-card-side">
                <div class="auth-img-content">
                    <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt="" class="img-fluid">
                    <h3 class="text-white mb-4 mt-5">{{ __('“Attention is the new currency”') }}</h3>
                    <p class="text-white">{{ __('The more effortless the writing looks, the more effort the writer
                        actually put into the process.')}}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
