<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Kopiqu </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/business-casual.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <style>
        body { padding-top: 70px; }
    </style>
    @yield('header')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="{{ route('home') }}">Kopiqu</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ route('home', ['#products']) }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}">My Cart</a>
                    </li>
                    @guest
                    <li>
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                    </li>
                    @else
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi, {{ Auth::user()->name }}! <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="{{ route('orders.index')}}">My Order</a></li>
                        @if(Auth::user()->role))
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Admin menu 1</a></li>
                        @endif
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Sign Out') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form></li>
                      </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Kopiqu 2018</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    @yield('footer')
</body>
</html>
