<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900">Registro Diário</h2>
            <p class="text-sm text-gray-600 mt-1">
                {{ now()->format('d/m/Y') }} - {{ now()->locale('pt_BR')->dayName }}
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($habitosComRegistro->count() > 0)
                <div class="mb-6">
                    <p class="text-center text-gray-600">
                        Atualize suas conquistas de hoje! 💪
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($habitosComRegistro as $item)
                        @livewire('card-habito', [
                            'habito' => $item['habito'], 
                            'registro' => $item['registro']
                        ], key('registro-'.$item['habito']->id))
                    @endforeach
                </div>

                {{-- Resumo do Dia --}}
                <div class="mt-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl shadow-xl p-6 text-white">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold mb-2">Continue Assim! 🎯</h3>
                        <p class="text-lg opacity-90">
                            Cada registro te aproxima do equilíbrio perfeito
                        </p>
                    </div>
                </div>
            @else
                {{-- Estado Vazio --}}
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-6xl">📝</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Nenhum hábito para registrar</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Você ainda não tem hábitos ativos. Crie seu primeiro hábito para começar!
                    </p>
                    <a href="{{ route('habitos.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold text-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Criar Hábito
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

