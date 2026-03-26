<div>
    <!-- Botão para abrir -->
    <button wire:click="openModal" class="btn btn-primary btn-sm">
        {{ __('trips.addTrip') }}
    </button>

    <!-- Modal e Overlay -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <!-- Overlay Escuro -->
            <div class="fixed inset-0 bg-black opacity-75"></div>
            
            <!-- Conteúdo do Modal -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto relative z-50 p-6" style="max-width: 400px">
                    <h3 class="text-lg font-bold mb-4">Nova Viagem</h3>
                    
                    <input wire:model="name" 
                           type="text"
                           class="w-full p-2 border rounded mb-4"
                           placeholder="Nome da viagem">
                    
                    <div class="flex justify-end gap-2">
                        <button wire:click="closeModal" 
                                class="px-4 py-2 text-gray-600">
                            {{ __('general.cancel') }}
                        </button>
                        <button wire:click="save" 
                                class="px-4 py-2 bg-blue-500 rounded">
                            {{ __('general.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>