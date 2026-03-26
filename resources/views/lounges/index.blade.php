@extends('layouts.app')

@section('content')
    <style>
            .counter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .counter-value {
            font-size: 24px;
            font-weight: bold;
            margin: 0 15px;
        }
        .btn-action {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        /* Removemos o flex do container dos botões */
        .action-buttons {
            margin-top: 10px;
        }
        /* Estilo para cada botão ocupar 100% da largura */
        .action-button {
            width: 100%;
            margin-bottom: 8px; /* Espaço entre os botões */
        }
        .fixed-width-card {
            width: 18rem;
            min-width: 18rem;
        }
        .small-text {
        font-size: 80%; /* Reduz em 20% */
        /* Alternativa usando tamanho fixo: */
        /* font-size: 0.875rem; */
    }
</style>
    <div class='row'>
        <BR>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap pt-3 pb-2 mb-3 border-bottom">
            <div class="col-12 col-md-2 d-flex align-items-center">
                    <h1 class="h2 text-capitalize">Lounges</h1>
            </div>
            <div class="col-12 col-md-5 mt-3 mt-md-0">
                <div class="d-flex justify-content-end gap-3 align-items-center">

                    <div>
                        <a type="button" href="{{ route('lounges.add', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">{{ __('lounges.addCard') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container mt-5">
                @if (count($data['loungecards']) == 0)
                <div class="alert alert-warning mt-4" role="alert">
                    {{ __('lounges.noCards') }}
                </div>
                @else
                    @foreach ($data['loungecards'] as $loungecards)
                        <div class="card mb-4 mx-2" style="max-width: 55rem;"> <!-- Adicionei mb-4 para espaçamento -->
                            <div class="card-body">
                                <h4 class="card-title">{{ $loungecards['name'] }}</h4>
                                <h6 class="card-text no-margin-padding small-text">{{ __('lounges.accessRemaining') }}: <span class="access-remaining" id="access-{{ $loungecards['id'] }}">{{ $loungecards['access_own'] - $loungecards['access_own_used']}}</span></h6>
                                <h6 class="card-text small-text">Login ({{ $loungecards['flag']}}): {{ $loungecards['login']}}</h6>
                                <hr>
                                <h6 class="card-text small-text">{{ __('lounges.saveAccess') }}:</h6>
                                <div class="counter-container">
                                    <button id="decrement" data-id="{{ $loungecards['id']}}" class="btn btn-outline-primary btn-action btn-decrement">-</button>
                                    <span id="counter-{{$loungecards['id']}}" class="counter-value" data-id="{{ $loungecards['id']}}" class="counter-value">0</span>
                                    <button id="increment" data-id="{{ $loungecards['id']}}" class="btn btn-outline-primary btn-action btn-increment">+</button>
                                </div>
                                <div class="action-buttons">
                                    <button id="confirm" class="btn btn-success w-100 mb-2 btn-add-access" data-id="{{ $loungecards['id']}}">Confirmar</button>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 pe-1">
                                            <a href="{{ route('lounges.add') }}?id={{$loungecards['id']}}" class="d-block">
                                                <button id="edit" name="data['loungecards']['id']" value="{{$loungecards['id']}}" class="btn btn-outline-secondary w-100 py-2">{{ __('general.edit') }}</button>
                                            </a>
                                        </div>
                                        <div class="col-6 ps-1">
                                            <button type="button" data-id="{{ $loungecards['id'] }}" class="btn btn-outline-danger w-100 py-2 btn-delete">{{ __('general.delete') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/lounges/index.js') }}"></script>
