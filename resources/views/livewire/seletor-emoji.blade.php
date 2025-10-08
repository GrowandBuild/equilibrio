<div>
    {{-- Botão para abrir modal --}}
    <div class="flex items-center space-x-3">
        <button type="button" 
                wire:click="abrirModal"
                class="w-20 h-20 rounded-2xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-5xl transition-all duration-200 hover:scale-105">
            {{ $emojiSelecionado }}
        </button>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Emoji do Hábito</label>
            <p class="text-xs text-gray-500">Clique para escolher</p>
        </div>
    </div>

    <input type="hidden" name="emoji" value="{{ $emojiSelecionado }}">

    {{-- Modal de seleção --}}
    @if($mostrarModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Overlay --}}
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     wire:click="fecharModal"></div>

                {{-- Modal --}}
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-purple-500 to-blue-500 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-white">
                                Escolha um Emoji
                            </h3>
                            <button wire:click="fecharModal" class="text-white hover:text-gray-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Conteúdo --}}
                    <div class="px-6 py-4 max-h-96 overflow-y-auto">
                        @foreach($emojis as $categoria => $lista)
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">{{ $categoria }}</h4>
                                <div class="grid grid-cols-8 gap-2">
                                    @foreach($lista as $emoji)
                                        <button type="button"
                                                wire:click="selecionarEmoji('{{ $emoji }}')"
                                                class="w-12 h-12 rounded-lg bg-gray-100 hover:bg-purple-100 flex items-center justify-center text-3xl transition-all duration-200 hover:scale-110">
                                            {{ $emoji }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-6 py-4">
                        <button wire:click="fecharModal"
                                class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

