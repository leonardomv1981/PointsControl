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
                <h1 class="h2 text-break">{{ __('general.calculatorALL') }}</h1>

            </div>
            
        </div>
        <div class="row">

            <div class="row row-cols-1 row-cols-md-3 g-2 w-100" role="group" aria-label="Tipo de operação">
                <div class="col">
                    <input type="radio" class="btn-check choiceAllTransfer stretched-link" name="type" id="directTransferALL" value="credit" data-type="directTransferALL" autocomplete="off">
                    <label class="btn btn-outline-secondary w-100" for="directTransferALL">
                        Transferência direta ALL
                    </label>
                </div>
                <div class="col">
                    <input type="radio" class="btn-check choiceAllTransfer stretched-link" name="type" id="indirectTransferALL" data-type="indirectTransferALL" value="debit" autocomplete="off">
                    <label class="btn btn-outline-secondary w-100" for="indirectTransferALL">
                        Transferência passando por outro programa
                    </label>
                </div>
                <div class="col">
                    <input type="radio" class="btn-check choiceAllTransfer stretched-link" name="type" id="myProgramsTransferALL" data-type="myProgramsTransferALL" value="debit" autocomplete="off">
                    <label class="btn btn-outline-secondary w-100" for="myProgramsTransferALL">
                        Transferência usando meus programas
                    </label>
                </div>
            </div>

            <div class="container py-4 choice-container" id="container-directTransferALL" style="display: none">
                
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
                    <li class="list-group-item">{{__('calculators.finalRatioAll')}}: <strong id="realConversion">-</strong></li>
                    <li class="list-group-item">Valor do Euro: <strong id="euroValue">-</strong></li>
                    <li class="list-group-item">CPM ALL (R$): <strong id="cpmAll">-</strong></li>
                </ul>
            </div>

            <div class="container py-4 choice-container" id="container-indirectTransferALL" style="display: none">
                <div class="row g-3">
                    Transferência para ALL passando por um programa intermediário (programa A para programa B para ALL)
                    <hr>
                    <strong>Programa A (origem) para Programa B:</strong>
                    <div class="col-md-4">
                        <label for="points" class="form-label">Quantidade de pontos (programa de origem)</label>
                        <input type="number" class="form-control" id="pointsProgramA" placeholder="Ex: 10000">
                    </div>

                    <div class="col-md-4">
                        <label for="conversionRate" class="form-label">Fator de conversão para o programa B</label>
                        <input type="number" step="0.01" class="form-control" id="conversionRateProgramA" placeholder="Ex: 1.0">
                    </div>
                
                    <div class="col-md-4">
                        <label for="bonus" class="form-label">Bônus (%)</label>
                        <input type="number" step="0.01" class="form-control" id="bonusProgramA" placeholder="Ex: 30">
                    </div>
                
                    <div class="col-md-4">
                        <label for="moneyValue" class="form-label">Valor pago (R$)</label>
                        <input type="number" step="0.01" class="form-control" id="moneyValue" placeholder="se for pontos + dinheiro">
                    </div>
                    <hr>
                    <strong>Programa B para ALL:</strong>
                    
                    <div class="col-md-4">
                        <label for="points" class="form-label">Quantidade de pontos</label>
                        <input type="number" class="form-control" id="points" placeholder="Ex: 10000" readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="conversionRate" class="form-label">Fator de conversão</label>
                        <input type="number" step="0.01" class="form-control" id="conversionRate" placeholder="Ex: 1.0">
                    </div>
                
                    <div class="col-md-4">
                        <label for="bonus" class="form-label">Bônus (%)</label>
                        <input type="number" step="0.01" class="form-control" id="bonus" placeholder="Ex: 30">
                    </div>
                
                </div>
                
                <hr class="my-4">
                
                <h5>Resultados <span  class="small-text" style="color: #6c757d;">- pointscontrol.com</span></h5>
                <ul class="list-group">
                    <li class="list-group-item">{{__('calculators.finalRatioAll')}}: <strong id="realConversion">-</strong></li>
                    <li class="list-group-item">Valor do Euro: <strong id="euroValue">-</strong></li>
                    <li class="list-group-item">CPM ALL (R$): <strong id="cpmAll">-</strong></li>
                </ul>
            </div>

            <div class="container py-4 choice-container" id="container-myProgramsTransferALL" style="display: none">
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="points" class="form-label">Origem</label>
                        <select class="form-select" id="originProgram">
                            <option value='' disabled selected>{{ __('general.choose') }}</option>
                            @foreach ($data['programs'] as $program)
                                @php
                                    if ($program->total_value != 0) {
                                        $cpm = number_format($program->total_value / ($program->total_points / 1000), 2, '.', '');
                                    } else {
                                        $cpm = 0;
                                    }
                                @endphp
                                <option value="{{ $cpm}} ">{{ $program->program_name }} (CPM: {{ number_format($cpm, 2, ',', '.')}})</option>
                            @endforeach
                        </select>
                    </div>

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
                
                </div>
                
                <hr class="my-4">
                
                <h5>Resultados <span  class="small-text" style="color: #6c757d;">- pointscontrol.com</span></h5>
                <ul class="list-group">
                    <li class="list-group-item">{{__('calculators.finalRatioAll')}}: <strong id="realConversion">-</strong></li>
                    <li class="list-group-item">Valor do Euro: <strong id="euroValue">-</strong></li>
                    <li class="list-group-item">CPM ALL (R$): <strong id="cpmAll">-</strong></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/calculators/index.js') }}"></script>
