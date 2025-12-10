/**
 * Safe Route Map JavaScript
 * Handles Leaflet maps with Green/Yellow/Red polylines based on total_score
 * Created by: Zahin (SafeHerBD)
 */

class SafeRouteMap {
    constructor(containerId, options = {}) {
        this.containerId = containerId;
        this.options = {
            center: [23.8103, 90.4125], // Default to Dhaka
            zoom: 12,
            showControls: true,
            ...options
        };
        
        this.map = null;
        this.routes = [];
        this.markers = [];
        this.polylines = [];
        
        this.init();
    }
    
    init() {
        this.initMap();
        if (this.options.showControls) {
            this.addControls();
        }
    }
    
    initMap() {
        // Initialize the map
        this.map = L.map(this.containerId).setView(this.options.center, this.options.zoom);
        
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(this.map);
    }
    
    addControls() {
        // Add map controls
        const controls = L.control({ position: 'topright' });
        
        controls.onAdd = function() {
            const div = L.DomUtil.create('div', 'leaflet-bar');
            div.innerHTML = `
                <div class="bg-white/90 backdrop-blur-sm rounded-lg p-3 shadow-lg">
                    <h4 class="font-bold text-gray-800 mb-2">Safety Levels</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Safe (< 5)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Moderate (5-10)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Dangerous (> 10)</span>
                        </div>
                    </div>
                </div>
            `;
            return div;
        };
        
        controls.addTo(this.map);
    }
    
    getRouteColor(score) {
        if (score < 5) return '#10b981'; // emerald-500
        if (score <= 10) return '#f59e0b'; // yellow-500
        return '#ef4444'; // red-500
    }
    
    getMarkerColor(score) {
        return this.getRouteColor(score);
    }
    
    addRoute(routeData) {
        try {
            const coordinates = JSON.parse(routeData.coordinates_json);
            if (!Array.isArray(coordinates) || coordinates.length === 0) {
                console.warn('Invalid route coordinates:', routeData);
                return;
            }
            
            const color = this.getRouteColor(routeData.total_score);
            
            // Create polyline for the route
            const latlngs = coordinates
                .filter(coord => !coord.crime_type) // Only route points
                .map(coord => [coord.lat, coord.lng]);
            
            if (latlngs.length > 0) {
                const polyline = L.polyline(latlngs, {
                    color: color,
                    weight: 4,
                    opacity: 0.8,
                    smoothFactor: 1
                }).addTo(this.map);
                
                // Add popup to polyline
                polyline.bindPopup(`
                    <div class="p-3 max-w-xs">
                        <h3 class="font-bold text-gray-800 text-lg mb-2">${routeData.route_name}</h3>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Safety Score:</span>
                                <span class="font-semibold ${color.replace('#', 'text-')}">${routeData.total_score}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created by:</span>
                                <span class="text-gray-800">${routeData.creator?.name || 'Unknown'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Route Points:</span>
                                <span class="text-gray-800">${latlngs.length}</span>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <div class="text-xs text-gray-500">
                                ${routeData.total_score < 5 ? '✅ Safe route' : 
                                  routeData.total_score <= 10 ? '⚠️ Moderate risk' : 
                                  '🚨 High risk area'}
                            </div>
                        </div>
                    </div>
                `, {
                    maxWidth: 300,
                    className: 'custom-popup'
                });
                
                this.polylines.push(polyline);
            }
            
            // Add crime point markers
            const crimePoints = coordinates.filter(coord => coord.crime_type);
            crimePoints.forEach(point => {
                const marker = this.addCrimeMarker(point, routeData);
                this.markers.push(marker);
            });
            
            this.routes.push(routeData);
            
        } catch (error) {
            console.error('Error adding route:', error);
        }
    }
    
    addCrimeMarker(point, routeData) {
        const color = this.getMarkerColor(point.score);
        const iconSize = point.score >= 5 ? 12 : point.score >= 3 ? 10 : 8;
        
        const marker = L.circleMarker([point.lat, point.lng], {
            radius: iconSize,
            fillColor: color,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.9
        }).addTo(this.map);
        
        // Enhanced popup for crime points
        marker.bindPopup(`
            <div class="p-3">
                <h4 class="font-bold text-gray-800 mb-2">🚨 Crime Alert</h4>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Crime Type:</span>
                        <span class="font-semibold text-red-600">${this.formatCrimeType(point.crime_type)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Risk Score:</span>
                        <span class="font-bold ${color.replace('#', 'text-')}">${point.score}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Route:</span>
                        <span class="text-gray-800">${routeData.route_name}</span>
                    </div>
                </div>
                <div class="mt-2 pt-2 border-t border-gray-200">
                    <div class="text-xs text-gray-500">
                        📍 ${point.lat.toFixed(6)}, ${point.lng.toFixed(6)}
                    </div>
                </div>
            </div>
        `, {
            maxWidth: 250
        });
        
        // Add hover effect
        marker.on('mouseover', function() {
            this.setStyle({
                weight: 3,
                opacity: 1,
                fillOpacity: 1
            });
        });
        
        marker.on('mouseout', function() {
            this.setStyle({
                weight: 2,
                opacity: 1,
                fillOpacity: 0.9
            });
        });
        
        return marker;
    }
    
    formatCrimeType(type) {
        const types = {
            'theft': ' Theft',
            'robbery': ' Robbery',
            'kidnapping': ' Kidnapping'
        };
        return types[type] || type;
    }
    
    addMultipleRoutes(routesData) {
        routesData.forEach(route => this.addRoute(route));
        this.fitToRoutes();
    }
    
    fitToRoutes() {
        if (this.routes.length === 0) return;
        
        const group = new L.featureGroup([...this.polylines, ...this.markers]);
        if (Object.keys(group._layers).length > 0) {
            this.map.fitBounds(group.getBounds().pad(0.1));
        }
    }
    
    clearAll() {
        // Remove all routes and markers
        this.polylines.forEach(polyline => this.map.removeLayer(polyline));
        this.markers.forEach(marker => this.map.removeLayer(marker));
        
        this.routes = [];
        this.markers = [];
        this.polylines = [];
    }
    
    addRoutePoint(lat, lng, options = {}) {
        if (!this.currentRoute) {
            this.currentRoute = {
                points: [],
                polyline: null
            };
        }
        
        this.currentRoute.points.push({ lat, lng });
        
        // Update polyline
        if (this.currentRoute.polyline) {
            this.map.removeLayer(this.currentRoute.polyline);
        }
        
        const latlngs = this.currentRoute.points.map(point => [point.lat, point.lng]);
        this.currentRoute.polyline = L.polyline(latlngs, {
            color: options.color || '#3b82f6',
            weight: 4,
            opacity: 0.8
        }).addTo(this.map);
        
        return this.currentRoute.polyline;
    }
    
    addCrimePoint(lat, lng, crimeData, options = {}) {
        const score = crimeData.score || 1;
        const color = this.getMarkerColor(score);
        const iconSize = score >= 5 ? 12 : score >= 3 ? 10 : 8;
        
        const marker = L.circleMarker([lat, lng], {
            radius: iconSize,
            fillColor: color,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.9
        }).addTo(this.map);
        
        marker.bindPopup(`
            <div class="p-2">
                <p class="font-semibold text-gray-800">Crime: ${this.formatCrimeType(crimeData.crime_type)}</p>
                <p class="text-sm text-gray-600">Score: ${score}</p>
            </div>
        `);
        
        return marker;
    }
    
    calculateRouteScore(points) {
        const crimePoints = points.filter(point => point.crime_type);
        return crimePoints.reduce((total, point) => total + (point.score || 0), 0);
    }
    
    // Utility method to get current map state
    getMapState() {
        const center = this.map.getCenter();
        const zoom = this.map.getZoom();
        return {
            center: [center.lat, center.lng],
            zoom: zoom
        };
    }
    
    // Utility method to set map state
    setMapState(state) {
        if (state.center && state.zoom) {
            this.map.setView(state.center, state.zoom);
        }
    }
}

// Utility functions for global use
window.SafeRouteMap = {
    create: function(containerId, options = {}) {
        return new SafeRouteMap(containerId, options);
    },
    
    getRouteColor: function(score) {
        if (score < 5) return '#10b981';
        if (score <= 10) return '#f59e0b';
        return '#ef4444';
    },
    
    formatCrimeType: function(type) {
        const types = {
            'theft': ' Theft',
            'robbery': ' Robbery', 
            'kidnapping': ' Kidnapping'
        };
        return types[type] || type;
    }
};

// CSS styles for enhanced UI
const style = document.createElement('style');
style.textContent = `
    .custom-popup .leaflet-popup-content-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .custom-popup .leaflet-popup-tip {
        background: rgba(255, 255, 255, 0.95);
    }
    
    .leaflet-control-container .leaflet-control {
        border-radius: 8px;
        overflow: hidden;
    }
`;
document.head.appendChild(style);

// Auto-initialize for pages with safe-route-map class
document.addEventListener('DOMContentLoaded', function() {
    const mapContainer = document.getElementById('map');
    if (mapContainer && window.SafeRouteMap) {
        // This will be initialized by the page-specific scripts
        console.log('Safe Route Map ready for initialization');
    }
});
