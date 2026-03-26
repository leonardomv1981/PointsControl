@extends('layouts.app')

@section('content')

    <div class='row'>
        <BR>
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 text-capitalize m-0 pe-2">{{__('trips.title')}}</h1>
            <div class="flex-shrink-0">
                <div>
                    <!-- Seu conteúdo existente do CRUD -->
                    
                    
                    <livewire:trips.create-trip-modal />
                    
                    <!-- Adicione isso para atualizar a lista após criar uma viagem -->
                    @push('scripts')
                        <script>
                            Livewire.on('trip-created', () => {
                                // Atualiza a lista de viagens
                                Livewire.emit('refreshTrips');
                            });
                        </script>
                    @endpush
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container mt-5">
                
                @if (count($trips) == 0)
                <div class="alert alert-warning mt-4" role="alert">
                    {!! __('trips.noTrips') !!}
                </div>
                @else
                    @foreach ($trips as $trip)
                        <div class="card mb-4 mx-2" style="max-width: 55rem;">
                            <div class="card-body">
                                {{-- {{ dd($trip) }} --}}
                                <h4 class="card-title">{{ $trip['trip_name'] }}</h4>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script src="{{ asset('js/mytrips/index.js') }}"></script>
