<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HomeEssence') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @if(Auth::check() && !Auth::user()->hasVerifiedEmail() && request()->path() !== 'email/verify')
        <script>
            // Redirect unverified users to the email verification notice page
            window.location.href = "{{ url('/email/verify') }}";
        </script>
    @endif

    <div id="app">
        <header class="bg-beige py-2">
            <div class="container">
                <a class="logo text-decoration-none" href="{{ url('/') }}">
                    <h1 class="m-0">Home<span>Essence</span></h1>
                </a>
            </div>
        </header>
        
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand d-md-none" href="{{ url('/') }}">
                    {{ config('app.name', 'HomeEssence') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <!-- Additional left-side links if needed -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown position-relative">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->customer && Auth::user()->customer->profile_picture)
                                        <img src="{{ Storage::url('profile_pictures/' . Auth::user()->customer->profile_picture) }}" 
                                            alt="Profile Picture" class="rounded-circle" 
                                            style="width:40px; height:40px; margin-right:10px; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-circle" style="font-size:40px; margin-right:10px;"></i>
                                    @endif
                                    {{ Auth::user()->name }}
                                </a>
                                
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="position:absolute; left:0; right:auto; top:100%;">
                                    <a class="dropdown-item" href="{{ route('customerprofile.edit') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            @include('layouts.flash-messages')
            @yield('content')
        </main>
        
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h4 class="footer-heading">About HomeEssence</h4>
                        <p>Discover elegant home furnishings and décor that transform your living spaces. Our curated collection brings style and comfort to every home.</p>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <h4 class="footer-heading">Customer Service</h4>
                        <ul class="footer-links">
                            <li><a href="#">Shipping Policy</a></li>
                            <li><a href="#">Return Policy</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-md-2 mb-4">
                        <h4 class="footer-heading">Connect</h4>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-dark fs-4"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-dark fs-4"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-dark fs-4"><i class="fab fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="copyright">
                    <p class="mb-0">&copy; {{ date('Y') }} HomeEssence. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>