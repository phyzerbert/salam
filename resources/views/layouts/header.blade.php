@php
    $user = Auth::user();
    $role = $user->role->slug;
@endphp
<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="{{route('home')}}"><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="{{route('home')}}"><i class="icon ion-navicon-round"></i></a></div>        
    </div>
    <div class="br-header-right">
        <nav class="nav">
            <div class="user-company mx-5 tx-25">
                @if (Auth::user()->hasRole('user'))
                    {{ Auth::user()->company->name }}
                @endif
            </div>
            <div class="dropdown dropdown-lang">
                @php $locale = session()->get('locale'); @endphp
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle mg-t-15" data-toggle="dropdown">                    
                    @switch($locale)
                        @case('en')
                            <img src="{{asset('images/lang/en.png')}}" width="30px">&nbsp;&nbsp;English
                            @break
                        @case('es')
                            <img src="{{asset('images/lang/es.png')}}" width="30px">&nbsp;&nbsp;Spanish
                            @break
                        @default
                            <img src="{{asset('images/lang/es.png')}}" width="30px">&nbsp;&nbsp;Spanish
                    @endswitch
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('lang', 'en')}}"><img src="{{asset('images/lang/en.png')}}" class="rounded-circle wd-30 ht-30"> English</a>
                    <a class="dropdown-item" href="{{route('lang', 'es')}}"><img src="{{asset('images/lang/es.png')}}" class="rounded-circle wd-30 ht-30"> Spanish</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="{{route('home')}}" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down">{{$user->first_name}} {{$user->last_name}}</span>
                    <img src="@if (Auth::user()->picture != ''){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" class="wd-32 rounded-circle" alt="">
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{route('profile')}}"><i class="icon ion-ios-person"></i> {{__('page.my_profile')}}</a></li>
                        {{-- <li><a href="index.html"><i class="icon ion-ios-gear"></i> Settings</a></li> --}}
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" 
                            ><i class="icon ion-power"></i> {{__('page.sign_out')}}</a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>
        {{-- <div class="navicon-right">
            <a id="btnRightMenu" href="index.html" class="pos-relative">
                <i class="icon ion-ios-chatboxes-outline"></i>
                <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span>
            </a>
        </div> --}}
    </div>
</div>