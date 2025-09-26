const CACHE_NAME = "detani-cache-v2";
const urlsToCache = [
  "/",
  "/icons/icon-192x192.png",
  "/icons/icon-512x512.png",
  "/manifest.json"
];

// Install Service Worker
self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      console.log('Caching files:', urlsToCache);
      return cache.addAll(urlsToCache);
    })
  );
});

// Activate Service Worker
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.filter(name => name !== CACHE_NAME)
                  .map(name => caches.delete(name))
      )
    )
  );
  self.clients.claim();
});

// Fetch (Offline Support)
self.addEventListener("fetch", event => {
  event.respondWith(
    fetch(event.request)
      .then(networkResponse => {
        // ❌ Jangan cache response redirect
        if (!networkResponse || networkResponse.type === "opaqueredirect") {
          return networkResponse;
        }

        // ✅ Simpan ke cache versi baru
        const responseClone = networkResponse.clone();
        caches.open(CACHE_NAME).then(cache => cache.put(event.request, responseClone));

        return networkResponse;
      })
      .catch(() => {
        // Offline fallback ke cache
        return caches.match(event.request).then(cachedResponse => {
          if (cachedResponse) {
            console.log('Cache hit (offline):', event.request.url);
            return cachedResponse;
          }
          // Optional: fallback halaman offline custom
          return new Response("You are offline and this resource is not cached.", {
            status: 503,
            headers: { "Content-Type": "text/plain" }
          });
        });
      })
  );
});
