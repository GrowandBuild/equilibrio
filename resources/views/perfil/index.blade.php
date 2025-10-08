<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900">Meu Perfil</h2>
            <p class="text-sm text-gray-600 mt-1">Gerencie suas informações pessoais</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Card do Perfil --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6 mb-8">
                    {{-- Foto --}}
                    <div class="flex-shrink-0">
                        <img src="{{ $usuario->foto_url }}" 
                             alt="{{ $usuario->name }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-purple-200">
                    </div>
                    
                    {{-- Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $usuario->name }}</h3>
                        <p class="text-gray-600 mt-1">{{ $usuario->email }}</p>
                        
                        @if($usuario->biografia)
                            <p class="text-gray-700 mt-3 italic">"{{ $usuario->biografia }}"</p>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-3 justify-center md:justify-start">
                            <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                {{ $usuarioXp->nivel_atual }}
                            </span>
                            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                {{ number_format($usuarioXp->xp_total) }} XP
                            </span>
                            @if($usuarioXp->sequencia_dias_atual > 0)
                                <span class="px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">
                                    🔥 {{ $usuarioXp->sequencia_dias_atual }} dias
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Formulário de Atualização --}}
                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Nome --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nome
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $usuario->name) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $usuario->email) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Biografia --}}
                    <div class="mb-6">
                        <label for="biografia" class="block text-sm font-semibold text-gray-700 mb-2">
                            Biografia
                        </label>
                        <textarea name="biografia" 
                                  id="biografia" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Conte um pouco sobre você...">{{ old('biografia', $usuario->biografia) }}</textarea>
                        @error('biografia')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-6">
                        <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto de Perfil
                        </label>
                        <input type="file" 
                               name="foto" 
                               id="foto" 
                               accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG ou JPEG. Máximo 2MB.</p>
                        @error('foto')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botão Salvar --}}
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>

            {{-- Alterar Senha --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Alterar Senha</h3>
                
                <form action="{{ route('perfil.senha') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4 mb-6">
                        <div>
                            <label for="senha_atual" class="block text-sm font-semibold text-gray-700 mb-2">
                                Senha Atual
                            </label>
                            <input type="password" 
                                   name="senha_atual" 
                                   id="senha_atual" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('senha_atual')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="senha_nova" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nova Senha
                            </label>
                            <input type="password" 
                                   name="senha_nova" 
                                   id="senha_nova" 
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @error('senha_nova')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="senha_nova_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirmar Nova Senha
                            </label>
                            <input type="password" 
                                   name="senha_nova_confirmation" 
                                   id="senha_nova_confirmation" 
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-semibold">
                            Alterar Senha
                        </button>
                    </div>
                </form>
            </div>

            {{-- Conquistas --}}
            @if($emblemas->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">🏆 Minhas Conquistas ({{ $emblemas->count() }})</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($emblemas as $conquista)
                            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-4 border-2 border-yellow-200 text-center">
                                <div class="text-4xl mb-2">{{ $conquista->emblema->icone }}</div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $conquista->emblema->nome }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $conquista->desbloqueado_em->format('d/m/Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

