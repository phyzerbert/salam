@extends('layouts.auth')

@section('content')
    @php
        $verify_messages = [
            '10' => __('page.concurrent_verifications_to_the_same_number_are_not_allowed'),
            '4' => __('page.invalid_credentials_were_provided'),
            '5' => __('page.internal_error'),
        ];
    @endphp
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">{{ config("app.name") }}</span></div>
            <div class="tx-center my-4">{{__('page.enter_your_credentials_below')}}</div>
            
            @error('phone')
                <span class="text-danger mt-2" role="alert">
                    <strong>
                        @if (isset($verify_messages[$message]))
                            {{ $verify_messages[$message] }}
                        @else
                            {{__('page.invalid_verification_request')}}
                        @endif
                    </strong>
                </span>
            @enderror
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="form-group">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{__('page.username')}}">
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="{{__('page.password')}}">

                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="ckbox">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('page.remember_me') }}</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-info btn-block">{{__('page.sign_in')}}</button>

                <div class="form-group text-center mt-3">
                    <a href="{{route('lang', 'en')}}" class="btn btn-outline p-0 @if(config('app.locale') == 'en') border-primary border-2 @endif" title="English"><img src="{{asset('images/lang/en.png')}}" width="45px"></a>
                    <a href="{{route('lang', 'es')}}" class="btn btn-outline ml-2 p-0 @if(config('app.locale') == 'es') border-primary border-2 @endif" title="Spanish"><img src="{{asset('images/lang/es.png')}}" width="45px"></a>
                </div>
            </form>
        </div>

    </div>
@endsection
