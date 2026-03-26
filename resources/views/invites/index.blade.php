@extends('layouts.app')

@if(Auth::user()->id == 1)
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
                @foreach ($data['invites'] as $invite)
                    <div class="col-sm-6 pb-2 mb-3 mb-sm-0">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-start ">
                                    <div>
                                        {{-- {{dd($invite);}} --}}
                                        <p class="card-text no-margin-padding">{{$invite['email']}}</p>
                                        <p class="card-text no-margin-padding">Enviado: {{ \Carbon\Carbon::parse($invite['inviteSent'])->format('d/m/y') }}</p>
                                        <p class="card-text no-margin-padding">Aceito? {{ $invite['user_id'] }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('programs.balance', ['locale' => app()->getLocale()]) }}">
                                        @csrf
                                        <button type="button" name="data[invites][id]" value="{{ $invite['id'] }}" class="btn btn-outline-secondary btn-sm stretched-link btn-invite">{{ $invite['user_id'] > 0 ?  "CADASTRADO" : "CONVIDAR" }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
    
    @push('scripts')
    <script src="{{ asset('js/invites/index.js') }}"></script>
@endif
