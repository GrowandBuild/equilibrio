<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Equilíbrio') }} - Gestão de Hábitos</title>

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
            // Animação de celebração ao cumprir meta
            window.addEventListener('meta-cumprida', event => {
                // Confetes simples com alert customizado
                alert(`🎉 Meta cumprida! ${event.detail.emoji} ${event.detail.habito}`);
            });
            
            // Escuta eventos do Livewire
            window.livewire.on('meta-cumprida', data => {
                alert(`🎉 Meta cumprida! ${data.emoji} ${data.habito}`);
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
        </script>
    </body>
</html>
