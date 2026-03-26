<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="{{ asset('js/color-modes.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Points Control">
    <title>{{ __('general.titlePage')}}</title>

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/general.css') }}" rel="stylesheet">
    <link rel="alternate" hreflang="{{__('general.otherLanguage')}}" href="https://www.pointscontrol.com/{{__('general.otherLanguage')}}" />
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Livewire Styles -->
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased" data-bs-theme="light">
    <x-banner />

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow menuSuperior" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">POINTS Control</a> 
        <ul class="navbar-nav flex-row d-md-none"> 
            <li class="nav-item text-nowrap"> 
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search"> 
                    <svg class="bi" aria-hidden="true"><use xlink:href="#search"></use></svg> 
                </button> 
            </li> 
            <li class="nav-item text-nowrap"> 
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"> 
                    <svg class="bi" aria-hidden="true"><use xlink:href="#list"></use></svg> 
                </button> 
            </li> 
        </ul> 
        <div id="navbarSearch" class="navbar-search w-100 collapse"> <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search"> </div> 
    </header>

    <div class="container-fluid">
        <div class="row">
            @include('components.sidemenu')
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset
            </main>
        </div>
    </div>

    <!-- Modal genérico (opcional) -->
    <div class="modal" tabindex="-1" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @stack('modals')
    @livewireScripts
    <!-- Alpine.js -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    @stack('scripts')
</body>
</html>