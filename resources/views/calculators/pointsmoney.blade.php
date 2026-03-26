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
            <div class="col-12 col-md-8 d-flex align-items-center">
                <h1 class="h2 text-break">{{ __('calculators.calculatorPointsAndMoney') }}</h1>

            </div>
            
        </div>
        <div class="row">

            <div class="container py-4 choice-container" id="container-pointAndMoney">
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="points" class="form-label">Quantidade de pontos</label>
                        <input type="number" class="form-control" id="points" placeholder="Ex: 10000">
                    </div>

                    <div class="col-md-4">
                        <label for="conversionRate" class="form-label">Fator de conversão</label>
                        <input type="number" step="0.01" class="form-control" id="conversionRate" placeholder="Ex: 1.0">
                    </div>
                
                    <div class="col-md-4">
                        <label for="bonus" class="form-label">Bônus (%)</label>
                        <input type="number" step="0.01" class="form-control" id="bonus" placeholder="Ex: 30">
                    </div>
                
                    <div class="col-md-4">
                        <label for="moneyValue" class="form-label">Valor pago (R$)</label>
                        <input type="number" step="0.01" class="form-control" id="moneyValue" placeholder="se for pontos + dinheiro">
                    </div>
                
                </div>
                
                <hr class="my-4">
                
                <h5>Resultados <span  class="small-text" style="color: #6c757d;">- pointscontrol.com</span></h5>
                <ul class="list-group">
                    <li class="list-group-item">{{__('calculators.totalPoints')}}: <strong id="totalPoints">-</strong></li>
                    <li class="list-group-item">{{__('calculators.finalRatio')}}: <strong id="finalRatio">-</strong></li>
                    <li class="list-group-item">CPM (R$): <strong id="cpm">-</strong></li>
                </ul>
            </div>

            
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/calculators/index.js') }}"></script>
