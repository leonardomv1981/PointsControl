@extends('layouts.app')

@section('content')
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
                        <a type="button" href="{{ route('lounges.index', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">Lounges</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container mt-5">
                <form method="POST" action="{{ route('lounges.add', ['locale' => app()->getLocale()]) }}"> 
                    @csrf
                    <input type="hidden" name="data[loungecards][status]" value="active">
                    <input type="hidden" name="data[loungecards][id]" value="{{ isset($data['loungecards']['id']) ? $data['loungecards']['id'] : '' }}">
                    <div class="mb-3">
                        <label for="cardName" class="form-label"><strong>{{ __('lounges.cardName')}}*</strong></label>
                        <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('lounges.cardNameToolTip') }}">
                            <i class="bi bi-info-circle"></i>
                        </button>
                        <input type="text" name="data[loungecards][name]" class="form-control" id="cardName" value="{{ isset($data['loungecards']['name']) ? $data['loungecards']['name'] : ''}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardLogin" class="form-label">{{ __('lounges.cardLogin') }}</label>
                        <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('lounges.loginToolTip') }}">
                            <i class="bi bi-info-circle"></i>
                        </button>
                        <input type="text" name="data[loungecards][login]" class="form-control" id="cardLogin" value="{{ isset($data['loungecards']['login']) ? $data['loungecards']['login'] : ''}}">
                    </div>
    
                    <div class="mb-3">
                        <label for="cardBrand" class="form-label"><strong>{{ __('lounges.cardBrand') }}*</strong></label>
                        <select class="form-select" id="cardBrand" name="data[loungecards][cardBrand]" required>
                            <option value="" disabled selected>{{ __('general.choose') }}</option>
                            @foreach ($data['cardBrands'] as $cardBrand)
                                <option value="{{ $cardBrand->id }}" {{ isset($data['loungecards']['id_cardflag']) && $data['loungecards']['id_cardflag'] == $cardBrand->id ? 'selected' : '' }}>{{ $cardBrand->flag }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="loungesAccess" class="form-label">{{ __('lounges.qtdAccess') }}</label>
                        <button type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{__('lounges.qtdAccessTooltip') }}">
                            <i class="bi bi-info-circle"></i>
                        </button>
                        <input type="number" name="data[loungecards][access_own]" class="form-control" id="loungesAccess" value="{{ isset($data['loungecards']['access_own']) ? $data['loungecards']['access_own'] : ''}}">
                      </div>
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                  </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/lounges/index.js') }}"></script>
