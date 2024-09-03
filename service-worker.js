self.addEventListener('install', e => {
    e.waitUntil(
        caches.open('pwa-cache-v1').then(cache => {
            return cache.addAll([
                '/',
                '/index.php',
                '/style/index.css',
                '/index.js',
                '/resources/img/happy-woman-smiling.jpg',
                '/resources/img/woman-lookingphone.jpg'
            ]);
        })
    )
})

self.addEventListener('fetch', e => {
    e.respondWith(
        caches.match(e.request).then(response => {
            return response || fetch(e.request);
        })
    );
});