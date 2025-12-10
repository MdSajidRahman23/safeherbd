// Initialize Leaflet map and plot SOS alerts from window.INITIAL_SOS
(function () {
    function initMap() {
        const mapDiv = document.getElementById('admin-sos-map');
        if (!mapDiv || typeof L === 'undefined') return;

        const map = L.map(mapDiv).setView([23.8103, 90.4125], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const sos = window.INITIAL_SOS || [];
        sos.forEach(function (item) {
            if (!item.latitude || !item.longitude) return;

            const marker = L.circleMarker([item.latitude, item.longitude], {
                radius: 8,
                fillColor: '#ff3b3b',
                color: '#b91c1c',
                weight: 1,
                opacity: 1,
                fillOpacity: 0.9
            }).addTo(map);

            const createdAt = item.created_at || '';
            const user = (item.user && (item.user.name || item.user.id)) || 'Unknown';

            marker.bindPopup(`<strong>Alert #${item.id}</strong><br>User: ${user}<br>${item.message || ''}<br>${createdAt}`);
        });

        if (sos.length) {
            const first = sos[0];
            if (first.latitude && first.longitude) {
                map.setView([first.latitude, first.longitude], 13);
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap);
    } else {
        initMap();
    }
})();
