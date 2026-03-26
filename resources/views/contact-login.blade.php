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
                    <h1 class="h2 text-capitalize">{{__('general.contact')}}</h1>
            </div>
            <div class="col-12 col-md-5 mt-3 mt-md-0">
                <div class="d-flex justify-content-end gap-3 align-items-center">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="container mt-5">
                @livewire('contact-form')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/lounges/index.js') }}"></script>
