<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        {{__('general.welcome')}}
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
        {{__('general.textWelcome')}}
    </p>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div>
        <div class="flex items-baseline"> <!-- Alinha pela base do texto -->
            <i class="bi bi-wallet2"></i>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                <a class="link-underline-light" href="{{ route('programs.index', ['locale' => app()->getLocale()]) }}">{{__('programs.title')}}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            <p class="no-margin-padding"><strong>{{__('general.totalPrograms')}}:</strong> {{$data['program_count']}}</p>
            <p class="no-margin-padding"><strong>{{__('general.totalPoints')}}:</strong> {{ number_format($data['balance']['total_points'], 0, '', '.') }}</p>
            <p class="no-margin-padding"><strong>{{__('general.totalValue')}}: </strong>
                @if($data['user']['currency'] === 'brl')
                    R$ {{ number_format($data['balance']['total_value'], 2, ',', '.') }}
                @else
                    $ {{ number_format($data['balance']['total_value'], 2, '.', ',') }}
                @endif
            </p>
        </p>
    </div>

    <div>
        <div class="flex items-baseline"> <!-- Alinha pela base do texto -->
            <i class="bi-stars"></i>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                <a class="link-underline-light" href="{{ route('lounges.index', ['locale' => app()->getLocale()]) }}">Lounges</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            <p class="no-margin-padding"><strong>{{__('general.totalCards')}}:</strong> {{$data['lounges']['total_count']}}</p>
            <p class="no-margin-padding"><strong>{{__('general.totalAccess')}}:</strong> {{$data['lounges']['total_remaining_access']}}</p>
        </p>
    </div>

</div>
