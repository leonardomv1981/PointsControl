@extends('layouts.app')

@section('content')
    <div class='row'>
        <BR>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap pt-3 pb-2 mb-3 border-bottom">
            <div class="col-12 col-md-7 d-flex align-items-center">
                <h1 class="h2 text-capitalize">{{ __('transactions.title') }}</h1>
            </div>
            <div class="col-12 col-md-5 mt-3 mt-md-0">
                <div class="d-flex justify-content-end gap-3 align-items-center">
                    <div>
                        <a type="button" href="{{ route('programs.index', ['locale' => app()->getLocale()]) }}"
                            class="btn btn-primary btn-sm text-capitalize">{{ __('programs.title') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- {{dd($data)}}; --}}
            @if (isset($data['error']))
                <div class="">
                    <div class="alert alert-danger">
                        <ul>
                        <li>{{ $data['error'] }}</li>
                        </ul>
                    </div>
                </div>
            @endif
            @if ($errors->any())
            <div class="">
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="row g3">
                <div class="">
                    <label for="selectType" class="form-label">{{ __('transactions.typeOfTransaction') }}</label>
                    @php
                        $selectedType = isset($data['error']) ? $data['type'] : null;
                    @endphp

                    <div class="btn-group w-100" role="group" aria-label="Tipo de operação">
                        <input type="radio" class="btn-check" name="type" id="typeCredit" value="credit"
                            autocomplete="off" {{ $selectedType === 'credit' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="typeCredit">
                            {{ __('transactions.credit') }}
                        </label>

                        <input type="radio" class="btn-check" name="type" id="typeDebit" value="debit"
                            autocomplete="off" {{ $selectedType === 'debit' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="typeDebit">
                            {{ __('transactions.debit') }}
                        </label>

                        <input type="radio" class="btn-check" name="type" id="typeTransfer" value="transfer"
                            autocomplete="off" {{ $selectedType === 'transfer' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="typeTransfer">
                            {{ __('transactions.transfer') }}
                        </label>
                    </div>

                </div>
            </div>
            <form class="row g-3" method="post" action="{{ route('transactions.save', ['locale' => app()->getLocale()]) }}" id="transaction-credit-form" style="{{ isset($data['error']) && ($data['type'] == 'credit') ? '' : 'display: none;'}}">
                @csrf
                <input type="hidden" name='data[transactions][type]' value="credit">
                <div class="col-md-6">
                    <label for="selectProgram" class="form-label"><strong>{{ __('general.program') }}</strong></label>
                    <select id="selectProgram" name="data[transactions][credit][id_program]" class="form-select">
                        <option disabled selected>{{ __('general.choose') }}...</option>
                        @foreach ($data['programs'] as $program)
                            <option value="{{ $program->id }}" {{ isset($data['error']) && (isset($data['credit']['id_program']) && $data['credit']['id_program'] == $program->id) ? 'selected' : ''}}>{{ $program->program_name }} ({{ number_format($program->total_points, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="input-data" class="form-label"><strong>{{ __('general.date') }}</strong></label>
                    <input type="date" name="data[transactions][credit][date]" class="form-control input-date" value="{{ isset($data['error']) && (isset($data['credit']['date'])) ? $data['credit']['date'] : ''}}" required>
                </div>
                <div class="col-12">
                    <label for="input-points" class="form-label"><strong>{{ __('general.points') }}</strong></label>
                    <input type="text" name="data[transactions][credit][points]" class="form-control input-points" id="input-points" value="{{ isset($data['error']) && (isset($data['credit']['points'])) ? $data['credit']['points'] : ''}}" required>
                </div>
                <div class="col-12">
                    <label for="value-points" class="form-label">{{ __('transactions.value') }}</label>
                    <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('transactions.valueToolTip') }}">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <input type="text" name="data[transactions][credit][value_points]" class="form-control input-value-points" id="value-points" data-currency="{{ $data['user']['currency'] }}" value="{{ isset($data['error']) && (isset($data['credit']['value_points'])) ? $data['credit']['value_points'] : ''}}">
                    <input type="hidden" name="data[transactions][currency]" value="{{ $data['user']['currency'] }}">
                </div>
                <div class="col-12">
                    <label for="input-description" class="form-label">{{ __('general.description') }}</label> 
                    <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('transactions.descriptionToolTip') }}">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <input type="text" name="data[transactions][credit][description]" class="form-control input-description" value="{{ isset($data['error']) && (isset($data['credit']['description'])) ? $data['credit']['description'] : ''}}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                </div>
            </form>
            
            {{-- {{dd($data)}} --}}
            <form class="row g-3" method="post" action="{{ route('transactions.save', ['locale' => app()->getLocale()]) }}" id="transaction-debit-form" style="{{ isset($data['error']) && ($data['type'] == 'debit') ? '' : 'display: none;'}}">
                <meta name="locale" content="{{ app()->getLocale() }}">
                @csrf
                <input type="hidden" name='data[transactions][type]' value="debit">
                <div class="col-md-6">
                    <label for="selectProgram" class="form-label"><strong>{{ __('general.program') }}</strong></label>
                    <select id="selectProgram" name="data[transactions][debit][id_program]" class="form-select">
                        <option selected>{{ __('general.choose') }}...</option>
                        @foreach ($data['programs'] as $program)
                            <option value="{{ $program->id }}" {{ isset($data['error']) && (isset($data['debit']['id_program']) && $data['debit']['id_program'] == $program->id) ? 'selected' : ''}} >{{ $program->program_name }} ({{ number_format($program->total_points, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="input-data" class="form-label"><strong>{{ __('general.date') }}</strong></label>
                    <input type="date" name="data[transactions][debit][date]" class="form-control input-date" value="{{ isset($data['error']) && (isset($data['debit']['date'])) ? $data['debit']['date'] : ''}}" required>
                </div>
                <div class="col-12">
                    <label for="input-points" class="form-label"><strong>{{ __('general.points') }}</strong></label>
                    <input type="text" name="data[transactions][debit][points]" class="form-control input-points" id="input-points" value="{{ isset($data['error']) && (isset($data['debit']['points'])) ? $data['debit']['points'] : ''}}" required>
                </div>
                <div class="col-12">
                    <label for="input-description" class="form-label">{{ __('general.description') }}</label>
                    <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('transactions.descriptionToolTip') }}">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <input type="text" name="data[transactions][debit][description]" class="form-control input-description" value="{{ isset($data['error']) && (isset($data['debit']['description'])) ? $data['debit']['description'] : ''}}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                </div>
            </form>
        
            <form class="row g-3" method="post" action="{{ route('transactions.save', ['locale' => app()->getLocale()]) }}" id="transaction-transfer-form" style="{{ isset($data['error']) && ($data['type'] == 'transfer') ? '' : 'display: none;'}}">
                @csrf
                <input type="hidden" name='data[transactions][type]' value="transfer">
                <div class="col-md-6">
                    <label for="selectProgram" class="form-label"><strong>{{ __('transactions.originProgram') }}</strong></label>
                    <select id="selectProgram" name="data[transactions][debit][id_program]" class="form-select">
                        <option selected>{{ __('general.choose') }}...</option>
                        @foreach ($data['programs'] as $program)
                        <option value="{{ $program->id }}" {{ isset($data['error']) && (isset($data['debit']['id_program']) && $data['debit']['id_program'] == $program->id) ? 'selected' : ''}}>{{ $program->program_name }} ({{ number_format($program->total_points, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="input-points" class="form-label"><strong>{{ __('general.points') }}</strong></label>
                    <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('transactions.originProgramToolTip') }}">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <input type="text" name="data[transactions][debit][points]" class="form-control input-points" id="origin-points" required value="{{ isset($data['error']) && (isset($data['debit']['points'])) ? $data['debit']['points'] : ''}}">
                </div>
                <div class="col-12">
                    <label for="input-data" class="form-label"><strong>{{ __('general.date') }}</strong></label>
                    <input type="date" name="data[transactions][transfer][date]" class="form-control input-date" required value="{{ isset($data['error']) && (isset($data['transfer']['date'])) ? $data['transfer']['date'] : ''}}">
                </div>
                <div class="col-md-12">
                    <label for="selectProgram" class="form-label"><strong>{{ __('transactions.destinationProgram') }}</strong></label>
                    <select id="selectProgram" name="data[transactions][credit][id_program]" class="form-select">
                        <option selected>{{ __('general.choose') }}...</option>
                        @foreach ($data['programs'] as $program)
                            <option value="{{ $program->id }}" {{ isset($data['error']) && (isset($data['credit']['id_program']) && $data['credit']['id_program'] == $program->id) ? 'selected' : ''}}>{{ $program->program_name }} ({{ number_format($program->total_points, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="input-bonus" class="form-label">bonus</label>
                    <input type="text" name="" class="form-control" id="input-bonus" disabled>
                </div>
                <div class="col-6">
                    <label for="input-points" class="form-label"><strong>{{ __('general.points') }}</strong></label>
                    <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('transactions.pointsFinalToolTip') }}">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <input type="text" name="data[transactions][credit][points]" class="form-control" id="destination-points" required value="{{ isset($data['error']) && (isset($data['credit']['points'])) ? $data['credit']['points'] : ''}}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                </div>
            </form>


        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/transactions/index.js') }}"></script>
