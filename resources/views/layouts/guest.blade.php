<!DOCTYPE html>
<meta name="keywords" content="Points Control, gerenciamento de pontos, gerenciamento de milhas, programa de fidelidade, pontos de cartão, milhas aéreas, controle de pontos, acumular milhas, resgatar pontos, melhor uso de milhas, otimizar pontos, cartão de crédito, viagens com milhas, programa de recompensas, pontos acumulados, calculadora de milhas, gestão de fidelidade">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="alternate" hreflang="{{__('general.otherLanguage')}}" href="https://www.pointscontrol.com/{{__('general.otherLanguage')}}" />
        <script src="{{ asset('js/color-modes.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
        integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous">
        </script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>
        <script src="{{ asset('js/functions.js') }}"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Points Control">
        <meta name="color-scheme" content="light">
        <title>{{ __('general.titlePage')}}</title>

        @yield('styles')

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <meta name="theme-color" content="#712cf9">
        <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="{{ asset('css/general.css') }}" rel="stylesheet">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
