<!-- Desktop Version -->
<div class="hidden lg:flex items-center space-x-3 py-2">
    <!-- XP Total -->
    <div class="flex items-center space-x-2 {{ $xpTotal < 0 ? 'bg-gradient-to-r from-red-50 to-red-100 border-red-200' : 'bg-gradient-to-r from-purple-50 to-blue-50 border-purple-200' }} px-3 py-3 border">
        <div class="w-8 h-8 {{ $xpTotal < 0 ? 'bg-gradient-to-br from-red-500 to-red-600' : 'bg-gradient-to-br from-purple-500 to-blue-500' }} rounded-full flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">XP Total</div>
            <div class="text-sm font-bold {{ $xpTotal < 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($xpTotal) }}</div>
        </div>
    </div>

    <!-- Nível e Progresso -->
    <div class="flex items-center space-x-2 bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-3 border border-yellow-200">
        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="min-w-0 flex-1">
            <div class="flex items-center justify-between">
                <div class="text-xs text-gray-500">Nível</div>
                @if($xpProximoNivel > 0)
                    <div class="text-xs text-gray-500">{{ number_format($xpProximoNivel) }} XP</div>
                @endif
            </div>
            <div class="text-sm font-bold text-gray-900">{{ $nivelAtual }}</div>
            @if($xpProximoNivel > 0)
                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                    @if($xpTotal < 0)
                        {{-- XP Negativo: Barra vermelha --}}
                        <div class="bg-gradient-to-r from-red-500 to-red-600 h-1.5 rounded-full transition-all duration-500" 
                             style="width: 100%"></div>
                    @else
                        {{-- XP Positivo: Barra normal --}}
                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-1.5 rounded-full transition-all duration-500" 
                             style="width: {{ $progressoNivel }}%"></div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Version -->
<div class="lg:hidden flex items-center justify-between w-full py-2">
    <!-- XP Compacto -->
    <div class="flex items-center space-x-1.5 {{ $xpTotal < 0 ? 'bg-gradient-to-r from-red-50 to-red-100 border-red-200' : 'bg-gradient-to-r from-purple-50 to-blue-50 border-purple-200' }} px-2 py-2 border">
        <div class="w-5 h-5 {{ $xpTotal < 0 ? 'bg-gradient-to-br from-red-500 to-red-600' : 'bg-gradient-to-br from-purple-500 to-blue-500' }} rounded-full flex items-center justify-center">
            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
        <div class="text-xs font-bold {{ $xpTotal < 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($xpTotal) }}</div>
    </div>

    <!-- Nível Compacto -->
    <div class="flex items-center space-x-1.5 bg-gradient-to-r from-yellow-50 to-orange-50 px-2 py-2 border border-yellow-200">
        <div class="w-5 h-5 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="text-xs font-bold text-gray-900">{{ $nivelAtual }}</div>
    </div>
</div>