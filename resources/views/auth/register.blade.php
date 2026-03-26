<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @php
            $type = 'invite';
        @endphp
            <form method="POST" action="{{ route('register', ['locale' => app()->getLocale()]) }}">
                @csrf
                
                <div>
                    <x-label for="first_name" value="{{ __('general.firstName') }}" />
                    <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"  autofocus autocomplete="first_name" />
                </div>

                <div class="mt-4">
                    <x-label for="last_name" value="{{ __('general.lastName') }}" />
                    <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"  autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="e-mail" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autocomplete="username" value=""/>
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('general.password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password"  autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('general.confirmPassword') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"  autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms"  />

                                <div class="ms-2">
                                    {!! __('Concordo com os :privacy_policy', [
                                            // 'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show', ['locale' => app()->getLocale()]).'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login', ['locale' => app()->getLocale()]) }}">
                        {{ __('general.alreadyRegistered') }}
                    </a>

                    <x-button class="ms-4">
                        {{ __('general.register') }}
                    </x-button>
                </div>
            </form>
        @php
            /*
        <form method="POST" action="{{ route('register.invite', ['locale' => app()->getLocale()]) }}">
            @csrf

            {{-- {{dd($data)}} --}}
            @if (isset($data['message']))
                <div class="p-3 mb-3 text-bg-{{$data['response']}} rounded-3">{!! $data['message'] !!}</div>
            @endif
            <div class="mt-4">
                No momento o POINTS Control está em fase de testes, para se inscrever na lista de espera preencha seu e-mail.
            </div>
            <div class="mt-4">
                <x-label for="email" value="e-mail" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autocomplete="username" />
            </div>
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms"  />

                            <div class="ms-2">
                                {!! __('Concordo com os :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">

                <x-button class="ms-4">
                    {{ __('general.register') }}
                </x-button>
            </div>
        </form>
    */
    @endphp
    </x-authentication-card>
</x-guest-layout>
