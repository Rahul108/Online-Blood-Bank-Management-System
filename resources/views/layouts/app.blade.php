<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Medical Service Online</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Medical Service Online
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}"></a></li>
                            <li><a class="nav-link" href="{{ route('register') }}"></a></li>
                        @else

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position:relative;padding-left:20px;" v-pre >
                                 <i class="fa fa-globe fa-2x" aria-hidden="true"></i>
                                 <?php $pos=0 ?>
                                @foreach($notification as $nn)
                                   @if(Auth::user()->id == $nn->user_whom && Auth::user()->location == $nn->for_location)
                                     @if($nn->seen=='0')
                                       <?php $pos++ ?>
                                     @endif
                                   @endif
                                @endforeach
                                @if($pos!=0)
                                 <span class="badge badge-pill badge-danger" style="position:relative; top:-10px; left:-10px">
                                   <?php print $pos ?>
                                 </span>
                                 @endif
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <?php $temp=0 ?>
                              @foreach($notification as $nn)
                                @if($temp == 6)
                                  <a class="dropdown-item" href="#" style="border:1px solid gray;text-align:center;background:#ffe6cc">See All</a>
                                  @break
                                @endif
                                @if(Auth::user()->id == $nn->user_whom && Auth::user()->location == $nn->for_location)
                                  <?php $temp++ ?>
                                  <a class="dropdown-item" href="{{ route('notification_show',["id" => $nn->id, "action_id" => $nn->action_id, "auth_user" => $nn->auth_user]) }}" style="border:1px solid gray; background:@if($nn->seen=='0') #d9f2e6 @endif">
                                  @foreach($users as $user)
                                    @if($nn->auth_user == $user->id)
                                      {{ $user->name }} Has<br>
                                      @if($nn->action == 'Requested')
                                        ReQuested For Blood In Your Area !
                                      @elseif($nn->action == 'Accepted')
                                        Accepted Your Blood Request !
                                      @else
                                        Suggested Your Blood Request !
                                      @endif
                                    @endif
                                  @endforeach
                                  </a>
                                @endif
                              @endforeach
                              @if($temp < 6 && $temp != 0)
                                <a class="dropdown-item" href="#" style="border:1px solid gray;text-align:center;background:#ffe6cc">See All</a>
                              @endif
                              @if($temp == 0)
                                <a class="dropdown-item" href="#" style="border:1px solid gray;text-align:center;background:#ffe6cc">No Notification Yet !</a>
                              @endif
                            </div>
                        </li>

                            <li><a class="nav-link" href="{{ route('home') }}">Home</a></li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position:relative;padding-left:50px;" v-pre >
                                    <img src="/uploads/avatars/{{ Auth::user()->avatar }}" style="width:32px;height:32px;position:absolute;top:10px;left:10px;border-radius:50%" >
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                  <a class="dropdown-item" href="{{ route('profile_show',Auth::user()->username)}}">  <i class ="fa fa-btn fa-user"></i>{{ __(' Profile') }}</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class ="fa fa-btn fa-sign-out"></i>{{ __(' Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
