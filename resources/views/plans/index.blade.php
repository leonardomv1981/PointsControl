@extends('layouts.app')

@section('content')
    <div class='row'>
        <BR>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap pt-3 pb-2 mb-3 border-bottom">
            <div class="col-7">
                    <h1 class="h2">{{ __('title.subscription') }}</h1>
            </div>
            <div class="col-5">
                <div class="d-flex justify-content-end grid gap-3">
                </div>
            </div>
        </div>

        <div class="row">
            {{-- {{ dd($data) }} --}}
            @foreach ($data['plans'] as $plan)
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card border-dark">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('plans.name') }} {{ $plan['description'] }}</h5>
                            <p class="card-text">Acesso ilimitado ao controle de pontos e lounges</p>
                            <form method="post" action="{{ route('plans.subscribe', ['locale' => app()->getLocale()]) }}">
                                @csrf
                                <input type="hidden" name="id_plan" value="{{ $plan['id'] }}">
                                @if (isset($data['myPlan']['id_plan']) && $plan['id'] == $data['myPlan']['id_plan'])
                                    Assinado
                                @else
                                    <button type="submit" class="btn btn-primary">{{ $plan['price'] }}</button>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/plans/index.js') }}"></script>