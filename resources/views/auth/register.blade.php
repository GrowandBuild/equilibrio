<x-guest-layout>
    <!-- Card de Registro -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header do Card -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6 text-white text-center">
            <div class="text-5xl mb-3">🎯</div>
            <h2 class="text-2xl font-bold">Comece sua Jornada!</h2>
            <p class="text-purple-100 text-sm mt-1">Crie sua conta e alcance o equilíbrio</p>
        </div>

        <!-- Formulário -->
        <div class="p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nome -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        👤 Nome Completo
                    </label>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                           placeholder="Seu nome">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        📧 Email
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="username"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                           placeholder="seu@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Senha -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        🔒 Senha
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                           placeholder="Mínimo 8 caracteres">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar Senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        🔐 Confirmar Senha
                    </label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                           placeholder="Digite a senha novamente">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Benefícios -->
                <div class="bg-purple-50 rounded-lg p-4 space-y-2">
                    <p class="text-sm font-semibold text-purple-900">✨ Ao criar sua conta você terá:</p>
                    <ul class="space-y-1 text-xs text-purple-700">
                        <li>✅ Sistema de hábitos bons e ruins</li>
                        <li>🎮 Gamificação com XP e níveis</li>
                        <li>🔥 Sequências e conquistas</li>
                        <li>📊 Estatísticas e insights</li>
                        <li>💯 100% Gratuito</li>
                    </ul>
                </div>

                <!-- Botão de Registro -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                    Criar Conta Grátis
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Já tem uma conta?</span>
                </div>
            </div>

            <!-- Link para Login -->
            <a href="{{ route('login') }}" 
               class="block w-full text-center py-3 px-4 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-all">
                Fazer Login
            </a>
        </div>
    </div>
</x-guest-layout>
