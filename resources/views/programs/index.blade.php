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
                        <a type="button" href="{{ route('programs.add', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">{{ __('programs.addProgram') }}</a>
                    </div>
                    <div class="">
                        <a type="button" href="{{ route('transactions.add', ['locale' => app()->getLocale()]) }}" class="btn btn-primary btn-sm">{{ __('transactions.menu') }}</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            @if (count($data['programs']) == 0)
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="alert alert-warning" role="alert">
                        {{ __('programs.noProgram') }}
                    </div>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                @foreach ($data['programs'] as $program)
                    <div class="col-sm-6 pb-2 mb-3 mb-sm-0">
                        <div class="card cardPrograms">
                            {{-- {{dd($program);}} --}}
                            @php
                                if ($program['total_points'] == 0) {
                                    $cpm = 0;
                                } else {
                                    $total_points = str_replace('.', '', $program['total_points']);
                                    $total_value = $program['total_value'];
                                    $cpm = ($total_value / $total_points) * 1000;
                                }
                            @endphp
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-start ">
                                    <div>
                                        <h5 class="card-title no-margin-padding"><strong>{{ $program['program_name'] }}</strong><span class="card-text fw-lighter"> {{ $program['signature_clu|b'] == 1 ? '(' . __('programs.clubActive') . ')' : '' }}</span></h5>
                                        <p class="card-text no-margin-padding">{{ __('programs.balance') }}: {{ number_format($program['total_points'], 0, ',', '.') }} (CPM: {{ $data['user']['currency'] == 'brl' ? 'R$ ' : '$ '}}{{ number_format($cpm, 2, ',', '.') }})</p>
                                        
                                    </div>
                                    <form method="POST" action="{{ route('programs.balance', ['locale' => app()->getLocale()]) }}">
                                        @csrf
                                        <button name="data[program][id]" value="{{ $program['id'] }}" class="btn btn-outline-secondary btn-sm stretched-link">{{ __('programs.details') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
    @endsection
    
    @push('scripts')
    <script src="{{ asset('js/programs/index.js') }}"></script>
