@extends('layouts.auth')
@section('style')
    <style>
        li {
            display: inline-block;
            font-size: 1.2em;
            list-style-type: none;
            text-transform: uppercase;
        }

        li span {
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">

            <div class="signin-logo tx-center tx-bold">
                <div class="wd-100 ht-100 bd bd-5 bd-warning rounded-circle mx-auto" style="font-size: 63px;">
                    <i class="fa fa-mobile"></i>
                </div>
            </div>
            
            <form action="{{ route('verify') }}" method="post">
                @csrf
                <div class="form-group mt-4">
                        <input id="code" type="number" class="form-control" name="code" value="{{ old('code') }}" placeholder="{{__('page.verification_code')}}" required autofocus>
                    @error('code')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> <div class="form-group">
                    <ul class="p-2 text-center">
                        <li class="px-2"><span id="minutes"></span>Min</li>
                        <li><span id="seconds"></span>Sec</li>
                    </ul>
                </div>
                
                <button type="submit" class="btn btn-info btn-block"><i class="fa fa-check-circle-o"></i> {{__('page.verify')}}</button>
                
            </form>
        </div>

    </div>
@endsection

@section('script')
    <script>

        let countDown = 300,

        x = setInterval(function() {

            countDown -= 1;            
            document.getElementById('minutes').innerText = pad2(Math.floor(countDown / 60)),
            document.getElementById('seconds').innerText = pad2(Math.floor(countDown % 60));
        
            if (countDown == 0) {
                clearInterval(x);
                window.location.href = "{{route('login')}}";
            }

        }, 1000);

        function pad2(number) {   
            return (number < 10 ? '0' : '') + number        
        }

    </script>
@endsection
