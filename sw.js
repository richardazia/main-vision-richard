const precacheList = [
    "index.html",
    "10yr.htm",
    "12k.shtml",
    "404.htm",
    "about.htm",
    "environm.htm",
    "geo.htm",
    "me.htm",
    "mountain.htm",
    "stats.htm",
    "surfing.htm",
    "st.shtml",
    "surfbot.htm",
    "tanzania-htm",
    "style.css",
    "sw.js",
    "Rome.html",
    "romans.html",
    "whats.htm",
    "which.htm",
    "wifi.shtml",
    "wm.shtml",
    "yeti.shtml"
];

self.addEventListener("install", event => {
    event.waitUntil(
        caches.open("richard")
            .then( cache => {
                cache.addAll(precacheList);
            }
        )
    );
});

self.addEventListener("activate", event => {
    event.waitUntil(
        caches.keys()
            .then( cacheNames => {
                return Promise.all(
                cacheNames.map( cacheName => {
                    if (cacheName !== "richard") {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );  
});

self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then( response => {
                const networkFetch = fetch(event.request)
                    .then( networkResponse => {
                        caches.open("richard")
                            .then( cache => {
                                cache.put(event.request, networkResponse.clone());
                                return networkResponse;
                            })
                    });
                return response || networkFetch;
            })
    );
});