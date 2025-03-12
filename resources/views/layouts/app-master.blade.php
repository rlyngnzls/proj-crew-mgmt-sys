<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <!-- Fontawesome 6 Pro v6.7.2 Core CSS-->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
    <!-- Fontawesome 6 Pro v6.7.2 Extra CSS -->
    <link href="{{ asset('css/duotone-regular.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/duotone-light.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/duotone-thin.css') }}" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors-pallete-ver2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style> 
        .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
            max-width: 90% !important;
        }
    </style>
</head>
<body style="background-color: #E8F2F5 !important; font-family: 'DM Sans', sans-serif;">
    <div id="app">
        <nav class="navbar navbar-expand-md bg-dark-gunmetal shadow-sm border-bottom border-body" data-bs-theme="dark">
            <div class="container w-100">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                    
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row mb-5 mt-3">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a href="/home" style="text-decoration: none;">
                            <div class="card border-5 rounded-3 bg-dark-gray" >
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="text-uppercase fw-bold">List</span>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square fa-lg"></i>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </a>
                    </div>
                    @if (Auth::user()->user_type == 'System Admin')
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a href="/data/setup" style="text-decoration: none;">
                            <div class="card border-5 rounded-3 bg-dark-gray">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="text-uppercase fw-bold">Maintenance</span>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <i class="fa-duotone fa-solid fa-gears fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    
                </div>
            </div>
            
            @yield('content')
        </main>
    </div>
</body>
</html>
