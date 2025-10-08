<div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
            {{-- Emoji grande com fundo colorido --}}
            <div class="w-14 h-14 rounded-full flex items-center justify-center text-3xl shadow-md"
                 style="background-color: {{ $habito->cor }}20;">
                {{ $habito->emoji }}
            </div>
            
            <div>
                <h3 class="font-semibold text-gray-900 text-lg">{{ $habito->nome }}</h3>
                <p class="text-sm text-gray-500">
                    Meta: {{ $habito->meta_formatada }} {{ $habito->unidade }}
                </p>
            </div>
        </div>
        
        {{-- Badge do tipo --}}
        <span class="px-3 py-1 rounded-full text-xs font-semibold"
              style="background-color: {{ $habito->cor }}20; color: {{ $habito->cor }};">
            {{ ucfirst($habito->tipo) }}
        </span>
    </div>

    {{-- Controles de quantidade --}}
    <div class="flex items-center justify-center space-x-4 mb-4">
        <button wire:click="decrementar" 
                class="w-12 h-12 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors duration-200 group relative"
                title="Diminuir quantidade">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                Diminuir
            </div>
        </button>

        <div class="text-center min-w-[120px]">
            <input type="number" 
                   wire:model.lazy="quantidade" 
                   wire:change="atualizar"
                   step="{{ $habito->step }}"
                   class="text-3xl font-bold text-center border-none focus:ring-0 w-full"
                   style="color: {{ $habito->cor }};"
                   value="{{ $quantidade }}">
            <p class="text-sm text-gray-500 mt-1">{{ $habito->unidade }}</p>
        </div>

        <button wire:click="incrementar"
                class="w-12 h-12 rounded-full flex items-center justify-center transition-colors duration-200 group relative"
                style="background-color: {{ $habito->cor }}20; color: {{ $habito->cor }};"
                title="Aumentar quantidade - Ganhe XP!">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                +100 XP ao cumprir meta!
            </div>
        </button>
    </div>

    {{-- Barra de progresso --}}
    <div class="mb-3">
        <div class="flex justify-between text-sm mb-2">
            <span class="text-gray-600">Progresso</span>
            <span class="font-semibold" style="color: {{ $habito->cor }};">
                {{ number_format($progresso, 0) }}%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-500 ease-out"
                 style="width: {{ min($progresso, 100) }}%; background-color: {{ $habito->cor }};">
            </div>
        </div>
    </div>

    {{-- Status visual --}}
    <div class="flex items-center justify-between">
        @if($habito->tipo === 'bom')
            {{-- Hábito bom --}}
            @if($metaCumprida)
                <div class="flex items-center space-x-2 text-green-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">Meta cumprida!</span>
                </div>
            @elseif($progresso >= 70)
                <div class="flex items-center space-x-2 text-yellow-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">Quase lá!</span>
                </div>
            @else
                <div class="flex items-center space-x-2 text-gray-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm">Continue assim!</span>
                </div>
            @endif
        @else
            {{-- Hábito ruim --}}
            @if($quantidade > $habito->meta)
                <div class="flex items-center space-x-2 text-red-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">Limite excedido!</span>
                </div>
            @elseif($quantidade == $habito->meta)
                <div class="flex items-center space-x-2 text-yellow-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">No limite!</span>
                </div>
            @else
                <div class="flex items-center space-x-2 text-green-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">Dentro do limite!</span>
                </div>
            @endif
        @endif

        @if($registro)
            <span class="text-xs {{ $registro->xp_ganho >= 0 ? 'text-gray-400' : 'text-red-500' }}">
                {{ $registro->xp_ganho >= 0 ? '+' : '' }}{{ $registro->xp_ganho }} XP
            </span>
        @endif
    </div>
</div>

