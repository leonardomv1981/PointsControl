<!DOCTYPE html>
<meta name="keywords" content="Points Control, gerenciamento de pontos, gerenciamento de milhas, programa de fidelidade, pontos de cartão, milhas aéreas, controle de pontos, acumular milhas, resgatar pontos, melhor uso de milhas, otimizar pontos, cartão de crédito, viagens com milhas, programa de recompensas, pontos acumulados, calculadora de milhas, gestão de fidelidade">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="alternate" hreflang="{{__('general.otherLanguage')}}" href="https://www.pointscontrol.com/{{__('general.otherLanguage')}}" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('general.titlePage')}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="{{ asset('js/color-modes.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/product.css') }}">

        <style>
            .bd-placeholder-img {
              font-size: 1.125rem;
              text-anchor: middle;
              -webkit-user-select: none;
              -moz-user-select: none;
              user-select: none;
            }
      
            @media (min-width: 768px) {
              .bd-placeholder-img-lg {
                font-size: 3.5rem;
              }
            }
      
            .b-example-divider {
              width: 100%;
              height: 3rem;
              background-color: rgba(0, 0, 0, .1);
              border: solid rgba(0, 0, 0, .15);
              border-width: 1px 0;
              box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }
      
            .b-example-vr {
              flex-shrink: 0;
              width: 1.5rem;
              height: 100vh;
            }
      
            .bi {
              vertical-align: -.125em;
              fill: currentColor;
            }
      
            .nav-scroller {
              position: relative;
              z-index: 2;
              height: 2.75rem;
              overflow-y: hidden;
            }
      
            .nav-scroller .nav {
              display: flex;
              flex-wrap: nowrap;
              padding-bottom: 1rem;
              margin-top: -1px;
              overflow-x: auto;
              text-align: center;
              white-space: nowrap;
              -webkit-overflow-scrolling: touch;
            }
      
            .btn-bd-primary {
              --bd-violet-bg: #712cf9;
              --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
      
              --bs-btn-font-weight: 600;
              --bs-btn-color: var(--bs-white);
              --bs-btn-bg: var(--bd-violet-bg);
              --bs-btn-border-color: var(--bd-violet-bg);
              --bs-btn-hover-color: var(--bs-white);
              --bs-btn-hover-bg: #6528e0;
              --bs-btn-hover-border-color: #6528e0;
              --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
              --bs-btn-active-color: var(--bs-btn-hover-color);
              --bs-btn-active-bg: #5a23c8;
              --bs-btn-active-border-color: #5a23c8;
            }
      
            .bd-mode-toggle {
              z-index: 1500;
            }
      
            .bd-mode-toggle .dropdown-menu .active .bi {
              display: block !important;
            }
          </style>
          
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else

        @endif
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col" data-bs-theme="light">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal"
                        >
                            {{ __('general.yourArea') }}
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal"
                        >
                            {{ __('general.login') }}
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal">
                                {{ __('general.register') }}
                            </a>
                        @endif
                    @endauth
                    <div class="text-[#1b1b18] text-sm">
                        <a href="pt" class="hover:underline">PT</a> |
                        <a href="en" class="hover:underline">EN</a>
                      </div>
                </nav>
            @endif
        </header>
        
        <main>
            <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
              <div class="col-md-6 p-lg-5 mx-auto my-5">
                <center><img src="{{ asset('img/logo.png')}}" alt="logo"></center>
                <h1 class="display-3 fw-bold">{{ __('general.titleWelcome')}}</h1>
                <h3 class="fw-normal text-muted mb-3">{{ __('general.subTitleWelcome') }}</h3>
                <div class="d-flex gap-3 justify-content-center lead fw-normal">
                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal"
                            >
                                {{ __('general.yourArea') }}

                            </a>
                            
                        @else
                            <a class="icon-link" href="{{ route('login') }}">
                                {{ __('general.login') }}
                                <svg class="bi"><use xlink:href="#chevron-right"/></svg>
                            </a>
                            <a class="icon-link" href="{{ route('register') }}">
                                {{ __('general.register') }}
                                <svg class="bi"><use xlink:href="#chevron-right"/></svg>
                            </a>
                        @endauth

                    @endif
                </div>
                </div>
            </div>
            <hr>
            
            
            <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
                <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                    <div class="my-3 py-3">
                        <h2 class="display-5">{{__('general.headline1')}}</h2>
                        <p class="lead">{{__('general.healineLead1')}}</p>
                    </div>
                    <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                        <div class="col-12">
                            <div class="card cardPrograms">
                                <div class="card-body ">
                                    <div class="d-flex justify-content-between align-items-start ">
                                        <div>
                                            <h5 class="card-title no-margin-padding text-start"><strong>AA</strong><span class="card-text fw-lighter"> </span></h5>
                                            <p class="card-text no-margin-padding text-start">saldo: 158.648 (CPM: R$ 36,03)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card cardPrograms">
                                <div class="card-body ">
                                    <div class="d-flex justify-content-between align-items-start ">
                                        <div>
                                            <h5 class="card-title no-margin-padding text-start"><strong>Azul</strong><span class="card-text fw-lighter"> </span></h5>
                                            <p class="card-text no-margin-padding text-start">saldo: 455.980 (CPM: R$ 8,17)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card cardPrograms">
                                <div class="card-body ">
                                    <div class="d-flex justify-content-between align-items-start ">
                                        <div>
                                            <h5 class="card-title no-margin-padding text-start"><strong>Esfera</strong><span class="card-text fw-lighter"> </span></h5>
                                            <p class="card-text no-margin-padding text-start">saldo: 58.015 (CPM: R$ 18,30)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card cardPrograms">
                                <div class="card-body ">
                                    <div class="d-flex justify-content-between align-items-start ">
                                        <div>
                                            <h5 class="card-title no-margin-padding text-start"><strong>Ibéria</strong><span class="card-text fw-lighter"> </span></h5>
                                            <p class="card-text no-margin-padding text-start">saldo: 115.300 (CPM: R$ 42,55)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 p-3">
                  <h2 class="display-5">{{__('general.headline2')}}</h2>
                  <p class="lead">{{__('general.healineLead2')}}</p>
                </div>
                <div class=" shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                  
            


                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-start"><strong>Transações</strong></h4>
                                
                                <hr>
                                <div class="d-flex justify-content-between align-items-center" id="transaction-9">
                                    <div class="mb-3 transaction-line">
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">data:</span> <span class="fw-light">07/02/2025</span></p>
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">descrição:</span> <span class="fw-light">clube</span></p>
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">Acúmulo:</span> <span class="fw-light"> +4.000 </span></p>
                                        <p class="fs-6 transaction-line text-start"> Custo: <span class="fw-light">R$  74,00 </span><span class="fw-lighter">(CPM: R$  18,50)</span></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center" id="transaction-8">
                                    <div class="mb-3 transaction-line">
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">data:</span> <span class="fw-light">25/01/2025</span></p>
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">descrição:</span> <span class="fw-light">emissão voo XXX2X</span></p>
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">Resgate:</span> <span class="fw-light"> -32.000 </span></p>
                                        <p class="fs-6 transaction-line text-start"> Custo: <span class="fw-light">R$  365,23 </span><span class="fw-lighter">(CPM: R$  11,41)</span></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center" id="transaction-7">
                                    <div class="mb-3 transaction-line">
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">data:</span> <span class="fw-light">06/01/2025</span></p>
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">descrição:</span> <span class="fw-light">clube</span></p>
                                        <p class="card-text transaction-line text-start"><span class="text-capitalize">Acúmulo:</span> <span class="fw-light"> +4.000 </span></p>
                                        <p class="fs-6 transaction-line text-start"> Custo: <span class="fw-light">R$  74,00 </span><span class="fw-lighter">(CPM: R$  18,50)</span></p>
                                    </div>
                                </div>                                                                                                        
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          <hr>
          <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
            <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5">{{__('general.headline3')}}</h2>
                    <p class="lead">{{__('general.healineLead3')}}</p>
                </div>
                <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                    



                    <div class="col-12">
                        <div class="card cardPrograms">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-start ">
                                    <div>
                                        <h5 class="card-title no-margin-padding text-start"><strong>Azul</strong><span class="card-text fw-lighter"> </span></h5>
                                        <p class="card-text no-margin-padding text-start">saldo: 455.980 (CPM: R$ 8,17)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card cardPrograms">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-start ">
                                    <div>
                                        <h5 class="card-title no-margin-padding text-start"><strong>Azul (esposa)</strong><span class="card-text fw-lighter"> </span></h5>
                                        <p class="card-text no-margin-padding text-start">saldo: 135.412 (CPM: R$ 6,44)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card cardPrograms">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-start ">
                                    <div>
                                        <h5 class="card-title no-margin-padding text-start"><strong>Azul (filho)</strong><span class="card-text fw-lighter"> </span></h5>
                                        <p class="card-text no-margin-padding text-start">saldo: 33.615 (CPM: R$ 11,67)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card cardPrograms">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-start ">
                                    <div>
                                        <h5 class="card-title no-margin-padding text-start"><strong>Azul (pai)</strong><span class="card-text fw-lighter"> </span></h5>
                                        <p class="card-text no-margin-padding text-start">saldo: 89.410 (CPM: R$ 10,55)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
            <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 p-3">
                    <h2 class="display-5">{{__('general.headline4')}}</h2>
                    <p class="lead">{{__('general.healineLead4')}}</p>
                </div>
                <div class=" shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
              
                    <img src="{{ asset('img/headline3.png')}}" alt="{{__('general.healineLead3')}}">
                
                </div>
            </div>
        </div>


          <hr>
          </main>
          
        <footer class="container py-5">
            <div class="row">
                <div class="col-12 col-md">
                    <a href="{{ route('contact')}}">{{__('general.contact')}}</a>
                    <p class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('general.allRightsReserved') }}</p>
                </div>
            </div>
        </footer>
          <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
