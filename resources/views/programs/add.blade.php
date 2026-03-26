@extends('layouts.app')

@section('content')
    <div class='row'>
        <BR>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap pt-3 pb-2 mb-3 border-bottom">
            <div class="col-12 col-md-7 d-flex align-items-center">
                    <h1 class="h2 text-capitalize">
                        @if (isset($data['program']['id']))
                            {{ __('programs.editTitle') }}
                        @else
                            {{ __('programs.addTitle') }}
                        @endif
                    </h1>
            </div>
            <div class="col-12 col-md-5 mt-3 mt-md-0">
                <div class="d-flex justify-content-end gap-3 align-items-center">
                    <div>
                        <a type="button" href="{{ route('programs.index', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">{{ __('general.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            @if ($errors->any())
                <div class="mb-3 alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('programs.add', ['locale' => app()->getLocale()]) }}"> 
                @csrf
                <input type="hidden" name="data[program][status]" value="active">
                <input type="hidden" name="data[program][id]" value="{{ isset($data['program']['id']) ? $data['program']['id'] : '' }}">
                <input type="hidden" name="data[currency]" value="{{ $data['user']['currency'] }}">
                <div class="mb-3">
                  <label for="programName" class="form-label"><strong>{{ __('programs.programName')}} <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('programs.nameToolTip') }}">
                     <i class="bi bi-info-circle"></i>
                </button></strong></label>
                  <input type="text" name="data[program][name]" class="form-control" id="programName" value="{{ isset($data['program']['program_name']) ? $data['program']['program_name'] : ''}}" required>
                </div>
                <div class="mb-3">
                    <label for="pointsValue" class="form-label">{{ __('programs.cpmValue') }}</label> 
                    <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('programs.reposicaoToolTip') }}">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <input type="text" name="data[program][cpm_value]" class="form-control currency-input" data-currency="{{ $data['user']['currency'] }}" id="pointsValue" value="{{ isset($data['program']['cpm_value']) ? $data['program']['cpm_value'] : ''}}">
                  </div>
                <div class="mb-3">
                  <label for="pointsValidity" class="form-label">{{ __('programs.validity') }}</label>
                  <input type="number" name="data[program][validity]" class="form-control" id="pointsValidity" value="{{ isset($data['program']['points_validity']) ? $data['program']['points_validity'] : ''}}">
                </div>

                <div class="mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="checkbox-club-signature" name="data[signature_club][status]" value='active' {{ empty($data['signature_club']) ? '' : 'checked' }}><label for="checkbox-club-signature" class="form-label no-margin-checkbox" > {{ __('programs.signatureClub') }}?</label>
                        </div>
                    </div>
                </div>
                <div id="signture-club-div" class="{{ empty($data['signature_club']) ? 'd-none' : '' }}">
                    @php
                        if (!empty($data['signature_club'])) {
                            if ($data['user']['currency'] == 'brl') {
                                $data['signature_club']['club_value'] = number_format($data['signature_club']['club_value'], 2, ',', '.');
                            } else {
                                $data['signature_club']['club_value'] = number_format($data['signature_club']['club_value'], 2, '.', '');
                            }
                            
                        }
                    @endphp
                    <div class="mb-3">
                        <label for="points" class="form-label"><strong>{{ __('programs.pointsSignature') }}*</strong></label>
                        <input type="text" class="form-control" id="signature-points" name="data[signature_club][points]" data-currency="{{ $data['user']['currency'] }}" value="{{ isset($data['signature_club']['points']) ? $data['signature_club']['points'] : ''}}">
                    </div>
        
                    <div class="mb-3">
                        <label for="signature-points-value" class="form-label">{{ __('programs.valueSignature') }}</label>
                        <input type="text" class="form-control" id="signature-points-value" name="data[signature_club][club_value]" step="0.01" data-currency="{{ $data['user']['currency'] }}" value="{{ isset($data['signature_club']['club_value']) ? $data['signature_club']['club_value'] : ''}}">
                    </div>
        
                    <div class="mb-3">
                        <label for="day" class="form-label"><strong>{{ __('programs.daySignature') }}*</strong></label>
                        <input type="number" class="form-control" id="day" name="data[signature_club][day]" value="{{ isset($data['signature_club']['day']) ? $data['signature_club']['day'] : ''}}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
              </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/programs/index.js') }}"></script>
