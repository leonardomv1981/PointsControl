@extends('layouts.app')

@section('content')
    <div class='row'>
        <BR>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap pt-3 pb-2 mb-3 border-bottom">
            <div class="col-12 col-md-7 d-flex align-items-center">
                    <h1 class="h2 text-capitalize">{{ __('programs.title') }}</h1>
            </div>
            <div class="col-12 col-md-5 mt-3 mt-md-0">
                <div class="d-flex justify-content-end gap-3 align-items-center">
                    <div>
                        <a type="button" href="{{ route('programs.index', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">{{ __('programs.title') }}</a>
                    </div>
                    <div>
                        <a type="button" href="{{ route('transactions.add', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">{{ __('transactions.menu') }}</a>
                    </div>
                </div>
            </div>
        </div>

        @php
            if ($data['program']['total_points'] == 0 ) {
                $cpm = 0;
                $totalPoints = 0;
                $totalValue = 0;
                $cpmValue = 0;
                $totalMarketValue = 0;
            } else {
                $totalPoints = str_replace('.', '', $data['program']['total_points']);
                $totalValue = $data['program']['total_value'];
                $cpm = ($totalValue / $totalPoints) * 1000;
                $cpmValue = $data['program']['cpm_value'];
                $totalMarketValue = ($totalPoints / 1000) * $cpmValue;
                if ($data['user']['currency'] == 'brl') {
                    $cpm = number_format($cpm, 2, ',', '.');
                    $totalPoints = number_format($totalPoints, 0, ',', '.');
                    $totalValue = number_format($totalValue, 2, ',', '.');
                    $totalMarketValue = number_format($totalMarketValue, 2, ',', '.');
                    $cpmValue = number_format($cpmValue, 2, ',', '.');
                } else {
                    $cpm = number_format($cpm, 2, '.', ',');
                    $totalPoints = number_format($totalPoints, 0, '.', ',');
                    $totalValue = number_format($totalValue, 2, '.', ',');
                    $totalMarketValue = number_format($totalMarketValue, 2, '.', ',');
                    $cpmValue = number_format($cpmValue, 2, '.', ',');
                }
            }


        @endphp
        <div class="row">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <!-- Texto do programa -->
                            <div class="mb-3 mb-md-0 me-md-3">
                                <h5 class="card-title transaction-line"><strong>{{$data['program']['program_name']}}</strong></h5>
                                <p class="card-text transaction-line">{{__('balance.totalPoints')}}: <strong>{{$totalPoints}}</strong></p>
                                <p class="card-text transaction-line">{{__('balance.totalValue')}}: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ '}} {{ $totalValue }} (CPM: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ '}} {{ $cpm }})</p>
                                @if ($data['program']['cpm_value'] > 0)
                                <p class="card-text transaction-line">{{__('balance.cpmValue')}}: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ '}} {{ $cpmValue }}</p>
                                <p class="card-text transaction-line">{{__('balance.cpmValueTotal')}}: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ '}} {{ $totalMarketValue }}</p>
                                @endif
                                @if ($data['signature_club'])
                                <hr>
                                {{-- {{ dd($data)}} --}}
                                <strong>{{ __('programs.signatureClub')}}:</strong>
                                    @php
                                        if ($data['user']['currency'] == 'brl') {
                                            $cpmClub = 'R$ ' . number_format(($data['signature_club']['club_value'] / $data['signature_club']['points']) * 1000, 2, ',', '.');
                                            $data['signature_club']['points'] = number_format($data['signature_club']['points'], 0, ',', '.');
                                            $data['signature_club']['club_value'] = number_format($data['signature_club']['club_value'], 2, ',', '.');
                                        } else {
                                            $cpmClub = '$ ' . number_format(($data['signature_club']['club_value'] / $data['signature_club']['points']) * 1000, 2, '.', ',');
                                            $data['signature_club']['points'] = number_format($data['signature_club']['points'], 0, '.', ',');
                                            $data['signature_club']['club_value'] = number_format($data['signature_club']['club_value'], 2, '.', ',');
                                        }

                                    @endphp
                                    <p class="card-text transaction-line">{{ __('programs.pointsSignature') }}: 
                                        {{ $data['signature_club']['points'] }}</p>
                                        <p class="card-text transaction-line">{{ __('programs.valueSignature')}}: {{ $data['signature_club']['club_value']}} - <span class="fw-lighter">(CPM: {{ $cpmClub}})</span></p>
                                    </p>
                                @endif
                                
                            </div>
                
                            <!-- Botões -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('programs.add') }}?id={{$data['program']['id']}}"><button name="data[program][id]" value="{{ $data['program']['id'] }}" class="btn btn-outline-secondary btn-sm">{{ __('general.edit') }}</button></a>
                                <button class="btn btn-outline-danger btn-sm btn-delete" data-id="{{ $data['program']['id'] }}">{{ __('general.delete') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title">Transações</h4>
                        <div>
                            <form method="POST" id="formTransactionsPeriod" action="{{ route('programs.balance', ['locale' => app()->getLocale()]) }}">
                                <input type="hidden" name="data[program][id]" value="{{ $data['program']['id'] }}">
                                @csrf
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input check-period-balance" type="radio" name="data[program][period]" id="last30days" value="30" {{ $data['program']['period'] == 30 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="last30days">Últimos 30 dias</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input check-period-balance" type="radio" name="data[program][period]" id="last60days" value="60" {{ $data['program']['period'] == 60 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="last60days">Últimos 60 dias</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input check-period-balance" type="radio" name="data[program][period]" id="all" value="all" {{ $data['program']['period'] == 'all' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all">Todas</label>
                                </div>
                            </form>
                        </div>
                        <hr>

                            @if (count($data['transactions']) == 0)
                                <div class="alert alert-warning mt-4" role="alert">
                                    {{ __('balance.noTransactions') }}
                                </div>
                            @else
                            @foreach ($data['transactions'] as $transaction)
                                @php
                                    if ($data['user']['language'] == 'pt') {
                                        $transaction['date'] = date('d/m/Y', strtotime($transaction['date']));
                                        $totalPoints = number_format($transaction['points'], 0, ',', '.');
                                        if ($transaction['type'] == 'credit') {
                                            $type = 'Acúmulo';
                                        } else if ($transaction['type'] == 'debit') {
                                            $type = 'Resgate';
                                        }
                                        $cpmTransaction = number_format($transaction['value_points'] / ($transaction['points'] / 1000), 2, ',', '.');
                                        $valueTransaction = number_format($transaction['value_points'], 2, ',', '.');
                                        $marketValue = number_format(($transaction['points'] / 1000) * $data['program']['cpm_value'], 2, ',', '.');
                                    } else {
                                        $transaction['date'] = date('m/d/Y', strtotime($transaction['date']));
                                        $totalPoints = number_format($transaction['points'], 0, '.', ',');
                                        $type = $transaction['type'];
                                        $cpmTransaction = number_format($transaction['value_points'] / ($transaction['points'] / 1000), 2, '.', ',');
                                        $valueTransaction = number_format($transaction['value_points'], 2, '.', ',');
                                        $marketValue = number_format(($transaction['points'] / 1000) * $data['program']['cpm_value'], 2, '.', ',');
                                    }
                                @endphp
                                <div class="d-flex justify-content-between align-items-center" id="transaction-{{ $transaction['id'] }}">
                                    <div class="mb-3 transaction-line">
                                        <p class="card-text transaction-line"><span class="text-capitalize">{{__('general.date')}}:</span> <span class="fw-light">{{$transaction['date']}}</span></p>
                                        <p class="card-text transaction-line"><span class="text-capitalize">{{__('general.description')}}:</span> <span class="fw-light">{{$transaction['description']}}</span></p>
                                        <p class="card-text transaction-line"><span class="text-capitalize">{{ $type }}:</span> <span class="fw-light"> {{ $transaction['type'] == 'credit' ? '+' : '-'}}{{ $totalPoints }} </span></p>
                                        <p class="fs-6 transaction-line"> {{ __('balance.value')}}: <span class="fw-light">{{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ ' }} {{$valueTransaction}} </span><span class="fw-lighter">(CPM: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ ' }} {{$cpmTransaction}})</span></p>
                                        @if ($data['program']['cpm_value'] != null && $data['program']['cpm_value'] > 0.00) 
                                            <p class="fs-6 transaction-line"><span class="fw-lighter"> {{ __('balance.repoValue')}}: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ ' }} {{$marketValue}} </span></p>
                                        @endif
                                    </div>
                                    <div class="align-self-start">
                                        <button class="btn btn-outline-danger btn-sm btn-delete-transaction" data-id="{{ $transaction['id'] }}" data-language="{{ $data['user']['language'] }}">Apagar</button>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/programs/index.js') }}"></script>
