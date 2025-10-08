<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Insights & Estatísticas</h2>
                <p class="text-sm text-gray-600 mt-1">Acompanhe sua evolução</p>
            </div>
            
            <form method="GET" class="flex items-center space-x-2">
                <select name="periodo" 
                        onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                    <option value="7" {{ $periodo == 7 ? 'selected' : '' }}>Últimos 7 dias</option>
                    <option value="30" {{ $periodo == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
                    <option value="90" {{ $periodo == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Frase Motivacional --}}
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-xl p-8 mb-8 text-white text-center">
                <div class="text-5xl mb-4">✨</div>
                <p class="text-2xl font-bold mb-2">{{ $frase }}</p>
                @if($melhoria != 0)
                    <p class="text-lg opacity-90">
                        {{ $melhoria > 0 ? '📈' : '📉' }} 
                        {{ abs(number_format($melhoria, 1)) }}% 
                        {{ $melhoria > 0 ? 'melhor' : 'abaixo' }} 
                        que o período anterior
                    </p>
                @endif
            </div>

            {{-- Cards Resumo --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- XP Total do Período --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">XP no Período</h3>
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">⚡</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($xpPeriodoAtual, 0, ',', '.') }}</p>
                    @if($melhoria != 0)
                        <p class="text-sm mt-2 {{ $melhoria > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $melhoria > 0 ? '↗' : '↘' }} {{ abs(number_format($melhoria, 1)) }}%
                        </p>
                    @endif
                </div>

                {{-- Taxa de Cumprimento --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Taxa de Cumprimento</h3>
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">🎯</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($taxaCumprimento, 1) }}%</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $taxaCumprimento }}%"></div>
                    </div>
                </div>

                {{-- Período --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Período Analisado</h3>
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">📅</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">{{ $periodo }} dias</p>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ now()->subDays($periodo - 1)->format('d/m') }} - {{ now()->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            {{-- Gráfico de XP (Simplificado) --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">XP ao Longo do Tempo</h3>
                
                @if($xpPorDia->count() > 0)
                    <div class="flex items-end justify-between h-48 space-x-2">
                        @php
                            $maxXp = $xpPorDia->max('total_xp') ?: 1;
                        @endphp
                        @foreach($xpPorDia as $dia)
                            @php
                                $altura = $dia->total_xp > 0 ? ($dia->total_xp / $maxXp) * 100 : 5;
                                $cor = $dia->total_xp > 0 ? 'bg-purple-500' : 'bg-gray-200';
                            @endphp
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full rounded-t-lg {{ $cor }} transition-all hover:opacity-75"
                                     style="height: {{ $altura }}%"
                                     title="{{ $dia->total_xp }} XP">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($dia->dia)->format('d/m') }}</p>
                                <p class="text-xs font-semibold text-gray-700">{{ $dia->total_xp }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-12">Nenhum registro no período selecionado</p>
                @endif
            </div>

            {{-- Melhores e Piores Hábitos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Melhores --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="text-3xl mr-3">🏆</span>
                        Melhores Hábitos
                    </h3>
                    
                    @if($melhoresHabitos->count() > 0)
                        <div class="space-y-4">
                            @foreach($melhoresHabitos as $index => $registro)
                                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">{{ $registro->habito->emoji }}</span>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $registro->habito->nome }}</p>
                                            <p class="text-xs text-gray-500">{{ $registro->dias_registrados }} dias registrados</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-green-600">+{{ $registro->total_xp }}</p>
                                        <p class="text-xs text-gray-500">XP</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Nenhum dado disponível</p>
                    @endif
                </div>

                {{-- Piores --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="text-3xl mr-3">📉</span>
                        Pontos de Atenção
                    </h3>
                    
                    @if($pioresHabitos->count() > 0)
                        <div class="space-y-4">
                            @foreach($pioresHabitos as $registro)
                                <div class="flex items-center justify-between p-4 {{ $registro->total_xp < 0 ? 'bg-red-50' : 'bg-yellow-50' }} rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">{{ $registro->habito->emoji }}</span>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $registro->habito->nome }}</p>
                                            <p class="text-xs text-gray-500">{{ $registro->dias_registrados }} dias registrados</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold {{ $registro->total_xp < 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                            {{ $registro->total_xp > 0 ? '+' : '' }}{{ $registro->total_xp }}
                                        </p>
                                        <p class="text-xs text-gray-500">XP</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Nenhum dado disponível</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

