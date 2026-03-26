@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form method="POST" wire:submit="send">
    @csrf
    <div>
        <x-label for="name" value="{{ __('general.name') }}" />
        <x-input id="name" wire:model="name" class="block mt-1 w-full" type="text" name="name"/>
        @error('name') 
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mt-4">
        <x-label for="email" value="e-mail" />
        <x-input id="email" wire:model="email" class="block mt-1 w-full" type="email" name="email" />
        @error('email') <span class="text-danger">{{ $message }}</span>@enderror
    </div>

    <div class="mt-4">
        <x-label for="message" value="{{ __('general.message') }}" />
        <textarea id="message" wire:model="message" class="block mt-1 w-full" name="message"></textarea>
        @error('message') <span class="text-danger">{{ $message }}</span>@enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-button class="ms-4">
            {{ __('general.register') }}
        </x-button>
    </div>
</form>