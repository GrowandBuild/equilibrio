<x-guest-layout>
    <!-- Card de Login -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header do Card -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6 text-white text-center">
            <div class="text-5xl mb-3">👋</div>
            <h2 class="text-2xl font-bold">Bem-vindo de Volta!</h2>
            <p class="text-purple-100 text-sm mt-1">Acesse sua conta para continuar</p>
        </div>

        <!-- Formulário -->
        <div class="p-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                           autofocus 
                           autocomplete="username"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                           placeholder="seu@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        🔒 Senha
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                           placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" 
                               type="checkbox" 
                               name="remember"
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">Lembrar de mim</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <!-- Botão de Login -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                    Entrar
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Não tem uma conta?</span>
                </div>
            </div>

            <!-- Link para Registro -->
            <a href="{{ route('register') }}" 
               class="block w-full text-center py-3 px-4 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-all">
                Criar Conta Grátis
            </a>
        </div>
    </div>

    <!-- Dica Rápida -->
    <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-4 shadow-lg">
        <div class="flex items-start space-x-3">
            <span class="text-2xl">💡</span>
            <div>
                <p class="text-sm font-semibold text-gray-700">Usuários de Teste:</p>
                <p class="text-xs text-gray-600 mt-1">
                    <strong>Alexandre:</strong> alexandre@equilibrio.app<br>
                    <strong>Elisa:</strong> elisa@equilibrio.app<br>
                    <strong>Senha:</strong> password
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
