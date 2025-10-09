<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    Olá, {{ $usuario->name }}! 👋
        </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ now()->format('d/m/Y') }} - {{ now()->locale('pt_BR')->dayName }}
                </p>
            </div>
            
            @if($conquistasNovas->count() > 0)
                <div class="hidden md:block">
                    <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                        🏆 {{ $conquistasNovas->count() }} {{ $conquistasNovas->count() == 1 ? 'novo emblema' : 'novos emblemas' }}!
                    </span>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Estatísticas do Dia --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Total Hábitos --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total de Hábitos</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $habitos->count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Metas Cumpridas --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Metas Cumpridas Hoje</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $metasCumpridasHoje }}/{{ $habitos->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- XP Ganho --}}
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">XP Ganho Hoje</p>
                            <p class="text-3xl font-bold {{ $xpGanhoHoje >= 0 ? 'text-gray-900' : 'text-red-600' }}">{{ $xpGanhoHoje >= 0 ? '+' : '' }}{{ $xpGanhoHoje }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Barra de XP --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Progresso do Nível</h3>
                        <p class="text-sm text-gray-600">Nível {{ $usuarioXp->nivel_atual ?? 'Iniciante' }} - {{ $usuarioXp->xp_total ?? 0 }} XP</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold {{ ($usuarioXp->xp_total ?? 0) < 0 ? 'text-red-600' : 'text-purple-600' }}">{{ $usuarioXp->xp_total ?? 0 }}</div>
                        <div class="text-sm text-gray-500">XP Total</div>
                    </div>
                </div>
                
                <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                    @php
                        $progresso = $usuarioXp ? $usuarioXp->progresso_nivel : 0;
                        $niveis = \App\Models\UsuarioXp::niveis();
                        $nivelAtual = null;
                        foreach ($niveis as $nivel) {
                            if ($nivel['nome'] === ($usuarioXp->nivel_atual ?? 'Iniciante')) {
                                $nivelAtual = $nivel;
                                break;
                            }
                        }
                        $xpMin = $nivelAtual['xp_min'] ?? 0;
                        $xpMax = $nivelAtual['xp_max'] ?? 1000;
                    @endphp
                    @if(($usuarioXp->xp_total ?? 0) < 0)
                        {{-- XP Negativo: Barra vermelha --}}
                        <div class="bg-gradient-to-r from-red-500 to-red-600 h-3 rounded-full transition-all duration-300" 
                             style="width: 100%"></div>
                    @else
                        {{-- XP Positivo: Barra normal --}}
                        <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-3 rounded-full transition-all duration-300" 
                             style="width: {{ $progresso }}%"></div>
                    @endif
                </div>
                
                <div class="flex justify-between text-xs text-gray-500">
                    <span>{{ $xpMin }} XP</span>
                    <span>{{ $xpMax }} XP</span>
                </div>
            </div>

            {{-- Card Informativo sobre XP --}}
            <div id="xp-info-card" class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl shadow-lg p-6 mb-8 border border-blue-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">💡 Como ganhar XP?</h3>
                            <button onclick="toggleCard('xp-info-card')" 
                                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    title="Minimizar">
                                <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="card-content space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 text-sm font-bold">✓</span>
                                </div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Cumprir metas diárias:</span> +100 XP por hábito concluído
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <span class="text-yellow-600 text-sm font-bold">+</span>
                                </div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Exceder metas:</span> +50 XP bônus por exceder o objetivo
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-purple-600 text-sm font-bold">🔥</span>
                                </div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-semibold">Manter sequência:</span> Bônus de XP por dias consecutivos
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-white rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Próximo nível em:</p>
                                    <p class="text-lg font-bold text-blue-600">{{ $xpMax - ($usuarioXp->xp_total ?? 0) }} XP</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Nível atual</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $usuarioXp->nivel_atual ?? 'Iniciante' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sequência Atual --}}
            <div class="bg-gradient-to-r from-orange-400 to-pink-500 rounded-2xl shadow-lg p-6 text-white mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">🔥 Sequência Atual</h3>
                        <p class="text-3xl font-bold">{{ $usuarioXp->sequencia_dias_atual ?? 0 }} dias</p>
                        <p class="text-orange-100 text-sm">Melhor sequência: {{ $usuarioXp->melhor_sequencia_dias ?? 0 }} dias</p>
                    </div>
                    <div class="text-6xl opacity-80">🔥</div>
                </div>
            </div>

            {{-- Dicas para Novos Usuários --}}
            @if($habitos->count() <= 2)
                <div id="welcome-card" class="bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl shadow-lg p-6 mb-8 text-white">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <span class="text-2xl">🚀</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold">Bem-vindo ao seu novo hábito!</h3>
                                <button onclick="toggleCard('welcome-card')" 
                                        class="text-white text-opacity-70 hover:text-opacity-100 transition-colors duration-200"
                                        title="Minimizar">
                                    <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="card-content">
                                <p class="text-green-100 mb-4">
                                Para começar a ganhar XP, clique no botão <strong>+</strong> nos seus hábitos sempre que completar uma atividade. 
                                Cada meta cumprida te dá <strong>100 XP</strong>!
                            </p>
                            <div class="flex items-center space-x-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="w-2 h-2 bg-white rounded-full"></span>
                                    <span>Clique no + para registrar</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="w-2 h-2 bg-white rounded-full"></span>
                                    <span>Ganhe XP automaticamente</span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Hábitos de Hoje --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Hábitos de Hoje</h2>
                    <a href="{{ route('habitos.create') }}" 
                       class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                        + Novo Hábito
                    </a>
                </div>

                @if($habitos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($habitos as $habito)
                            @php
                                $registroHoje = $habito->registroHoje;
                            @endphp
                            
                            @livewire('card-habito', [
                                'habito' => $habito, 
                                'registro' => $registroHoje
                            ], key('dashboard-'.$habito->id))
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                        <div class="text-8xl mb-6">🎯</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum hábito ainda</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Comece criando seu primeiro hábito para começar sua jornada de transformação!
                        </p>
                        <a href="{{ route('habitos.create') }}" 
                           class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            Criar Primeiro Hábito
                        </a>
                    </div>
                @endif
            </div>

            {{-- Conquistas Recentes --}}
            @if($conquistasRecentes->count() > 0)
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-semibold mb-6">🏆 Conquistas Recentes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($conquistasRecentes as $conquista)
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm p-4 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="text-3xl">{{ $conquista->emblema->icone }}</div>
                                    <div>
                                        <p class="font-semibold">{{ $conquista->emblema->nome }}</p>
                                        <p class="text-sm opacity-90">{{ $conquista->desbloqueado_em->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>