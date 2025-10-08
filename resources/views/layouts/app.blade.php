<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Equilíbrio') }} - Gestão de Hábitos</title>

        <!-- PWA Meta Tags -->
        <meta name="application-name" content="Equilíbrio">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Equilíbrio">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#8b5cf6">
        
        <!-- PWA Manifest -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        
        <!-- PWA Icons -->
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('icons/icon-512x512.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/icon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('icons/icon-192x192.png') }}">
        
        <!-- iOS Splash Screens -->
        <link rel="apple-touch-startup-image" href="{{ asset('icons/icon-512x512.png') }}">
        
        <!-- Microsoft Tiles -->
        <meta name="msapplication-TileColor" content="#8b5cf6">
        <meta name="msapplication-TileImage" content="{{ asset('icons/icon-144x144.png') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        
        <!-- CSS para PWA e Mobile Responsivo -->
        <style>
            /* Reset para PWA e prevenção de scroll lateral */
            * {
                -webkit-tap-highlight-color: transparent;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                box-sizing: border-box;
            }
            
            /* Prevenir scroll horizontal */
            html, body {
                overflow-x: hidden !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            
            /* Container principal sem overflow */
            .min-h-screen {
                overflow-x: hidden !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            
            /* Garantir que a nav bar mobile fique sempre visível */
            @media (max-width: 768px) {
                /* Prevenir scroll horizontal em mobile */
                html, body {
                    overflow-x: hidden !important;
                    max-width: 100vw !important;
                    width: 100vw !important;
                }
                
                /* Todos os containers sem overflow */
                .min-h-screen, main, .max-w-7xl, .mx-auto {
                    overflow-x: hidden !important;
                    max-width: 100% !important;
                    width: 100% !important;
                }
                
                /* Padding e margin responsivos */
                .px-4, .px-6, .px-8 {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
                
                .mx-auto {
                    margin-left: auto !important;
                    margin-right: auto !important;
                }
                
                .mobile-nav {
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    width: 100% !important;
                    z-index: 9999 !important;
                    transform: translate3d(0, 0, 0) !important;
                    -webkit-transform: translate3d(0, 0, 0) !important;
                    will-change: transform !important;
                    backface-visibility: hidden !important;
                    -webkit-backface-visibility: hidden !important;
                    display: block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                }
                
                /* Garante que o conteúdo não fique atrás da nav bar */
                .mobile-content {
                    padding-bottom: 5rem !important;
                    margin-bottom: 0 !important;
                }
                
                /* Força o body a ter altura total */
                body {
                    min-height: 100vh !important;
                    min-height: -webkit-fill-available !important;
                }
                
                /* Container principal */
                .min-h-screen {
                    min-height: 100vh !important;
                    min-height: -webkit-fill-available !important;
                }
                
                /* Garantir que a nav bar não seja afetada por scroll */
                .mobile-nav {
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    transform: none !important;
                    -webkit-transform: none !important;
                }
            }
            
            /* PWA específico */
            @media (display-mode: standalone) {
                .mobile-nav {
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    z-index: 9999 !important;
                    display: block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                }
                
                .mobile-content {
                    padding-bottom: 5rem !important;
                }
            }
            
            /* Força a nav bar a ser sempre visível */
            .mobile-nav {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                z-index: 9999 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                transform: none !important;
                -webkit-transform: none !important;
            }
            
            /* Garantir que não seja afetada por scroll */
            @media (max-width: 768px) {
                .mobile-nav {
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    width: 100% !important;
                    z-index: 9999 !important;
                    display: block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    transform: none !important;
                    -webkit-transform: none !important;
                    will-change: auto !important;
                }
                
                /* Cards e elementos responsivos */
                .bg-white, .rounded-2xl, .shadow-lg {
                    max-width: 100% !important;
                    width: 100% !important;
                    box-sizing: border-box !important;
                }
                
                /* Grid e flex responsivos */
                .grid, .flex {
                    max-width: 100% !important;
                    width: 100% !important;
                }
                
                /* Texto responsivo */
                .text-sm, .text-xs, .text-lg, .text-xl, .text-2xl, .text-3xl {
                    word-wrap: break-word !important;
                    overflow-wrap: break-word !important;
                }
                
                /* Imagens responsivas */
                img, svg {
                    max-width: 100% !important;
                    height: auto !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pb-20 md:pb-8 mobile-content">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <!-- Bottom Navigation (Mobile) -->
            <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg mobile-nav" style="bottom: 0; padding-bottom: env(safe-area-inset-bottom); z-index: 9999; width: 100%;">
                <div class="flex justify-around items-center h-16">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('dashboard') ? 'text-purple-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-xs mt-1">Início</span>
                    </a>
                    <a href="{{ route('registros.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('registros.*') ? 'text-purple-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span class="text-xs mt-1">Registro</span>
                    </a>
                    <a href="{{ route('habitos.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('habitos.*') ? 'text-purple-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-xs mt-1">Hábitos</span>
                    </a>
                    <a href="{{ route('insights.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('insights.*') ? 'text-purple-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-xs mt-1">Insights</span>
                    </a>
                    <a href="{{ route('perfil.index') }}" class="flex flex-col items-center justify-center flex-1 {{ request()->routeIs('perfil.*') ? 'text-purple-600' : 'text-gray-600' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-xs mt-1">Perfil</span>
                    </a>
                </div>
            </nav>
        </div>

        @livewireScripts
        
        <script>
            // Modal moderno para celebração de meta cumprida
            function showMetaCumpridaModal(habito, emoji) {
                // Criar modal
                const modal = document.createElement('div');
                modal.id = 'meta-cumprida-modal';
                modal.innerHTML = `
                    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm">
                        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
                            <!-- Header com gradiente -->
                            <div class="relative bg-gradient-to-r from-green-400 to-blue-500 rounded-t-3xl p-6 text-center">
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-2xl">${emoji}</span>
                                    </div>
                                </div>
                                <h3 class="text-white text-xl font-bold mt-4">Parabéns!</h3>
                            </div>
                            
                            <!-- Conteúdo -->
                            <div class="p-6 text-center">
                                <div class="mb-4">
                                    <div class="text-6xl mb-2">🎉</div>
                                    <h4 class="text-2xl font-bold text-gray-800 mb-2">Meta Cumprida!</h4>
                                    <p class="text-lg text-gray-600">${habito}</p>
                                </div>
                                
                                <!-- XP ganho -->
                                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-4 mb-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-lg font-bold text-gray-800">+100 XP</span>
                                    </div>
                                </div>
                                
                                <!-- Botão -->
                                <button onclick="closeMetaModal()" 
                                        class="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold py-3 px-6 rounded-2xl hover:from-green-600 hover:to-blue-600 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    Continuar
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                // Adicionar ao body
                document.body.appendChild(modal);
                
                // Animar entrada
                setTimeout(() => {
                    const content = document.getElementById('modal-content');
                    content.style.transform = 'scale(1)';
                    content.style.opacity = '1';
                }, 10);
                
                // Confetes animados
                createConfetti();
            }
            
            function closeMetaModal() {
                const modal = document.getElementById('meta-cumprida-modal');
                if (modal) {
                    const content = document.getElementById('modal-content');
                    content.style.transform = 'scale(0.95)';
                    content.style.opacity = '0';
                    setTimeout(() => {
                        modal.remove();
                    }, 300);
                }
            }
            
            function createConfetti() {
                const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3'];
                const confettiCount = 50;
                
                for (let i = 0; i < confettiCount; i++) {
                    setTimeout(() => {
                        const confetti = document.createElement('div');
                        confetti.style.position = 'fixed';
                        confetti.style.left = Math.random() * 100 + 'vw';
                        confetti.style.top = '-10px';
                        confetti.style.width = '10px';
                        confetti.style.height = '10px';
                        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                        confetti.style.borderRadius = '50%';
                        confetti.style.pointerEvents = 'none';
                        confetti.style.zIndex = '9999';
                        confetti.style.animation = `confetti-fall ${2 + Math.random() * 3}s linear forwards`;
                        
                        document.body.appendChild(confetti);
                        
                        setTimeout(() => {
                            confetti.remove();
                        }, 5000);
                    }, i * 50);
                }
            }
            
            // Adicionar CSS para animação dos confetes
            const style = document.createElement('style');
            style.textContent = `
                @keyframes confetti-fall {
                    0% {
                        transform: translateY(-100vh) rotate(0deg);
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(100vh) rotate(720deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            // Event listeners
            window.addEventListener('meta-cumprida', event => {
                showMetaCumpridaModal(event.detail.habito, event.detail.emoji);
            });
            
            window.livewire.on('meta-cumprida', data => {
                showMetaCumpridaModal(data.habito, data.emoji);
            });

            // Função para minimizar/maximizar cards informativos
            function toggleCard(cardId) {
                const card = document.getElementById(cardId);
                const content = card.querySelector('.card-content');
                const button = card.querySelector('button[onclick*="toggleCard"]');
                const icon = button.querySelector('svg');
                
                if (content.style.display === 'none') {
                    // Mostrar card
                    content.style.display = 'block';
                    card.style.height = 'auto';
                    card.style.overflow = 'visible';
                    icon.style.transform = 'rotate(0deg)';
                    button.title = 'Minimizar';
                    localStorage.setItem(cardId + '_minimized', 'false');
                } else {
                    // Minimizar card
                    content.style.display = 'none';
                    card.style.height = '80px';
                    card.style.overflow = 'hidden';
                    icon.style.transform = 'rotate(180deg)';
                    button.title = 'Expandir';
                    localStorage.setItem(cardId + '_minimized', 'true');
                }
            }

            // Restaurar estado dos cards ao carregar a página
            document.addEventListener('DOMContentLoaded', function() {
                const cards = ['xp-info-card', 'welcome-card'];
                
                cards.forEach(cardId => {
                    const card = document.getElementById(cardId);
                    if (card) {
                        const isMinimized = localStorage.getItem(cardId + '_minimized') === 'true';
                        if (isMinimized) {
                            const content = card.querySelector('.card-content');
                            const button = card.querySelector('button[onclick*="toggleCard"]');
                            const icon = button.querySelector('svg');
                            
                            content.style.display = 'none';
                            card.style.height = '80px';
                            card.style.overflow = 'hidden';
                            icon.style.transform = 'rotate(180deg)';
                            button.title = 'Expandir';
                        }
                    }
                });
                
                // Garantir que a nav bar mobile fique sempre visível
                function fixMobileNav() {
                    const mobileNav = document.querySelector('.mobile-nav');
                    if (mobileNav) {
                        // Força o posicionamento correto
                        mobileNav.style.position = 'fixed';
                        mobileNav.style.bottom = '0';
                        mobileNav.style.left = '0';
                        mobileNav.style.right = '0';
                        mobileNav.style.width = '100%';
                        mobileNav.style.zIndex = '9999';
                        mobileNav.style.display = 'block';
                        mobileNav.style.visibility = 'visible';
                        mobileNav.style.opacity = '1';
                        mobileNav.style.transform = 'none';
                        mobileNav.style.webkitTransform = 'none';
                        
                        // Adiciona padding bottom para safe area
                        const safeAreaBottom = getComputedStyle(document.documentElement).getPropertyValue('--safe-area-inset-bottom') || '0px';
                        mobileNav.style.paddingBottom = safeAreaBottom;
                        
                        // Força a renderização
                        mobileNav.offsetHeight;
                    }
                }
                
                // Executa imediatamente
                fixMobileNav();
                
                // Executa após um pequeno delay para garantir
                setTimeout(fixMobileNav, 100);
                
                // Executa quando a janela é redimensionada
                window.addEventListener('resize', fixMobileNav);
                
                // Executa quando a orientação muda
                window.addEventListener('orientationchange', function() {
                    setTimeout(fixMobileNav, 500);
                });
                
                // Executa quando a página ganha foco (PWA)
                window.addEventListener('focus', fixMobileNav);
                
                // Função para prevenir scroll lateral
                function preventHorizontalScroll() {
                    // Força overflow-x hidden
                    document.documentElement.style.overflowX = 'hidden';
                    document.body.style.overflowX = 'hidden';
                    
                    // Garante que todos os containers tenham largura máxima
                    const containers = document.querySelectorAll('.min-h-screen, main, .max-w-7xl, .mx-auto');
                    containers.forEach(container => {
                        container.style.overflowX = 'hidden';
                        container.style.maxWidth = '100%';
                        container.style.width = '100%';
                    });
                    
                    // Garante que cards não ultrapassem a largura
                    const cards = document.querySelectorAll('.bg-white, .rounded-2xl, .shadow-lg');
                    cards.forEach(card => {
                        card.style.maxWidth = '100%';
                        card.style.width = '100%';
                        card.style.boxSizing = 'border-box';
                    });
                }
                
                // Executa a prevenção de scroll lateral
                preventHorizontalScroll();
                
                // Executa quando a janela é redimensionada
                window.addEventListener('resize', preventHorizontalScroll);
                
                // Executa quando a orientação muda
                window.addEventListener('orientationchange', function() {
                    setTimeout(preventHorizontalScroll, 500);
                });
            });
            
            // ========================================
            // PWA SERVICE WORKER
            // ========================================
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js')
                        .then(function(registration) {
                            console.log('✅ Service Worker registrado com sucesso:', registration.scope);
                            
                            // Verifica atualizações a cada 1 hora
                            setInterval(() => {
                                registration.update();
                            }, 3600000);
                        })
                        .catch(function(error) {
                            console.log('❌ Erro ao registrar Service Worker:', error);
                        });
                });
                
                // Detecta quando uma nova versão está disponível
                let refreshing;
                navigator.serviceWorker.addEventListener('controllerchange', function() {
                    if (refreshing) return;
                    refreshing = true;
                    window.location.reload();
                });
            }
            
            // ========================================
            // PWA INSTALL PROMPT
            // ========================================
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                // Previne o prompt automático
                e.preventDefault();
                deferredPrompt = e;
                
                // Você pode mostrar um botão customizado aqui
                console.log('💡 PWA pode ser instalado');
                
                // Opcional: Criar um banner de instalação
                const installBanner = document.createElement('div');
                installBanner.id = 'pwa-install-banner';
                installBanner.innerHTML = `
                    <div style="position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%); 
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                color: white; padding: 15px 25px; border-radius: 50px; 
                                box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 10000;
                                display: flex; align-items: center; gap: 15px; max-width: 90vw;">
                        <span style="font-size: 14px; font-weight: 600;">
                            📱 Instale o Equilíbrio no seu celular!
                        </span>
                        <button onclick="installPWA()" 
                                style="background: white; color: #667eea; border: none; 
                                       padding: 8px 20px; border-radius: 25px; font-weight: 600;
                                       cursor: pointer; font-size: 14px;">
                            Instalar
                        </button>
                        <button onclick="closePWABanner()" 
                                style="background: transparent; color: white; border: 1px solid white; 
                                       padding: 8px 15px; border-radius: 25px; font-weight: 600;
                                       cursor: pointer; font-size: 14px;">
                            Agora não
                        </button>
                    </div>
                `;
                
                // Só mostra após 10 segundos
                setTimeout(() => {
                    if (!localStorage.getItem('pwa-install-dismissed')) {
                        document.body.appendChild(installBanner);
                    }
                }, 10000);
            });
            
            // Função para instalar PWA
            window.installPWA = async function() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`PWA install: ${outcome}`);
                    deferredPrompt = null;
                    closePWABanner();
                }
            };
            
            // Função para fechar banner
            window.closePWABanner = function() {
                const banner = document.getElementById('pwa-install-banner');
                if (banner) {
                    banner.remove();
                    localStorage.setItem('pwa-install-dismissed', 'true');
                }
            };
            
            // Detecta quando o PWA foi instalado
            window.addEventListener('appinstalled', () => {
                console.log('✅ PWA instalado com sucesso!');
                closePWABanner();
            });
            
            // ========================================
            // PWA NETWORK STATUS
            // ========================================
            window.addEventListener('online', () => {
                console.log('✅ Conectado à internet');
                // Opcional: Mostrar notificação
            });
            
            window.addEventListener('offline', () => {
                console.log('❌ Sem conexão com a internet');
                // Opcional: Mostrar notificação
            });
        </script>
    </body>
</html>
