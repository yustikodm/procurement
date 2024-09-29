<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Procurement App') }}</title>

    <!-- Bootstrap and Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Vite Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
<div id="app">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            @if(Auth::check() && Auth::user()->isVendor())
                <a class="navbar-brand font-weight-bold text-primary" href="{{ route('products.index') }}">
                    {{ config('app.name', 'E-Procurement App') }}
                </a>
            @else
                <a class="navbar-brand font-weight-bold text-primary" href="{{ url('/') }}">
                    {{ config('app.name', 'E-Procurement App') }}
                </a>
            @endif
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('vendors.approve')}}">Vendor Approval</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.products') }}">Product Catalog</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('products.index') }}">Product Catalog</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary btn-sm mx-1" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif

                        @if (Route::has('admin.register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-success btn-sm mx-1" href="{{ route('admin.register') }}">Register</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item me-2">
                        <span class="nav-link" v-pre>
                            {{ Auth::user()->name }} <!-- Ensure this points to the correct attribute -->
                        </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-danger btn-sm" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
