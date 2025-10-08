<div class="bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl shadow-xl p-6 text-white">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold opacity-90">Nível Atual</h3>
            <p class="text-3xl font-bold">{{ $nivel_atual }}</p>
        </div>
        
        <div class="text-right">
            <p class="text-sm opacity-90">XP Total</p>
            <p class="text-2xl font-bold">{{ number_format($xp_total, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Barra de progresso para próximo nível --}}
    @if($xp_proximo_nivel > 0)
        <div class="space-y-2">
            <div class="flex justify-between text-sm">
                <span>Próximo nível</span>
                <span>{{ number_format($xp_proximo_nivel, 0, ',', '.') }} XP restantes</span>
            </div>
            
            <div class="w-full bg-white bg-opacity-30 rounded-full h-3 overflow-hidden">
                <div class="h-full bg-white rounded-full transition-all duration-500 ease-out"
                     style="width: {{ $progresso_nivel }}%;">
                </div>
            </div>
            
            <p class="text-xs text-center opacity-75">
                {{ number_format($progresso_nivel, 1) }}% completo
            </p>
        </div>
    @else
        <div class="text-center py-2">
            <p class="text-lg font-semibold">🏆 Nível Máximo Atingido!</p>
            <p class="text-sm opacity-75">Parabéns, Mestre do Equilíbrio!</p>
        </div>
    @endif
</div>

