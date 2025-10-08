// Service Worker para PWA - Equilíbrio
const CACHE_NAME = 'equilibrio-v1.0.0';
const urlsToCache = [
    '/',
    '/dashboard',
    '/habitos',
    '/css/app.css',
    '/js/app.js',
    '/build/assets/app.css',
    '/build/assets/app.js',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/manifest.json'
];

// Instalação do Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Cache aberto');
                return cache.addAll(urlsToCache);
            })
            .catch(err => {
                console.log('Erro ao cachear:', err);
            })
    );
    self.skipWaiting();
});

// Ativação do Service Worker
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Removendo cache antigo:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Interceptar requisições
self.addEventListener('fetch', event => {
    // Estratégia: Network First, fallback para Cache
    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Clone a resposta
                const responseClone = response.clone();
                
                // Cachear a nova resposta
                caches.open(CACHE_NAME).then(cache => {
                    cache.put(event.request, responseClone);
                });
                
                return response;
            })
            .catch(() => {
                // Se a rede falhar, tenta o cache
                return caches.match(event.request)
                    .then(response => {
                        if (response) {
                            return response;
                        }
                        
                        // Se não tiver no cache, retorna página offline
                        if (event.request.mode === 'navigate') {
                            return caches.match('/');
                        }
                    });
            })
    );
});

// Sincronização em background
self.addEventListener('sync', event => {
    if (event.tag === 'sync-habitos') {
        event.waitUntil(syncHabitos());
    }
});

// Notificações push
self.addEventListener('push', event => {
    const options = {
        body: event.data ? event.data.text() : 'Nova notificação do Equilíbrio',
        icon: '/icons/icon-192x192.png',
        badge: '/icons/icon-72x72.png',
        vibrate: [200, 100, 200],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'explore',
                title: 'Ver agora',
                icon: '/icons/icon-96x96.png'
            },
            {
                action: 'close',
                title: 'Fechar',
                icon: '/icons/icon-96x96.png'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('Equilíbrio', options)
    );
});

// Clique em notificação
self.addEventListener('notificationclick', event => {
    event.notification.close();
    
    if (event.action === 'explore') {
        event.waitUntil(
            clients.openWindow('/dashboard')
        );
    }
});

// Função auxiliar para sincronizar hábitos
async function syncHabitos() {
    try {
        // Implementar lógica de sincronização
        console.log('Sincronizando hábitos...');
    } catch (error) {
        console.error('Erro ao sincronizar:', error);
    }
}
