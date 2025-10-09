<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Meus Hábitos</h2>
                <p class="text-sm text-gray-600 mt-1">Gerencie seus hábitos bons e ruins</p>
            </div>
            <a href="{{ route('habitos.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Hábito
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($habitos->count() > 0)
                {{-- Hábitos Ativos --}}
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Hábitos Ativos ({{ $habitos->count() }})</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($habitos as $habito)
                            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                                {{-- Cabeçalho --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-3xl"
                                             style="background-color: {{ $habito->cor }}20;">
                                            {{ $habito->emoji }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $habito->nome }}</h4>
                                            <p class="text-sm text-gray-500">{{ $habito->meta_formatada }} {{ $habito->unidade }}</p>
                                        </div>
                                    </div>
                                    
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold"
                                          style="background-color: {{ $habito->cor }}20; color: {{ $habito->cor }};">
                                        {{ ucfirst($habito->tipo) }}
                                    </span>
                                </div>

                                {{-- Descrição --}}
                                @if($habito->descricao)
                                    <p class="text-sm text-gray-600 mb-4">{{ $habito->descricao }}</p>
                                @endif

                                {{-- Frequência --}}
                                <div class="mb-4">
                                    <span class="text-xs text-gray-500">Frequência: </span>
                                    <span class="text-xs font-semibold text-gray-700">{{ ucfirst($habito->frequencia_tipo) }}</span>
                                </div>

                                {{-- Ações --}}
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('habitos.edit', $habito) }}" 
                                           class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            ✏️ Editar
                                        </a>
                                        @if($habito->temRegistros())
                                            <a href="{{ route('insights.index') }}?habito={{ $habito->id }}" 
                                               class="text-sm text-green-600 hover:text-green-700 font-medium">
                                                📊 Histórico
                                            </a>
                                            <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                                                ⚠️ Tem registros
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        @if(!$habito->temRegistros())
                                            <form action="{{ route('habitos.destroy', $habito) }}" method="POST" 
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este hábito?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                                    🗑️ Excluir
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('habitos.arquivar', $habito) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                                                    📦 Arquivar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Estado Vazio --}}
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-6xl">🎯</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Nenhum hábito ainda</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Comece sua jornada criando seu primeiro hábito! Defina metas e acompanhe seu progresso diariamente.
                    </p>
                    <a href="{{ route('habitos.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold text-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Criar Primeiro Hábito
                    </a>
                </div>
            @endif

            {{-- Hábitos Arquivados --}}
            @if($habitosArquivados->count() > 0)
                <div class="mt-12">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Hábitos Arquivados ({{ $habitosArquivados->count() }})</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($habitosArquivados as $habito)
                            <div class="bg-gray-50 rounded-2xl shadow p-6 opacity-75">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-3xl">
                                            {{ $habito->emoji }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-700">{{ $habito->nome }}</h4>
                                            <p class="text-sm text-gray-500">{{ $habito->meta_formatada }} {{ $habito->unidade }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <form action="{{ route('habitos.reativar', $habito) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                            ♻️ Reativar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

