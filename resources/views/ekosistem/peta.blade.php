@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>
    #map {
        height: 500px;
        width: 100%;
        z-index: 10;
        border-radius: 1.5rem;
    }
    @media (max-width: 640px) {
        #map { height: 380px; }
    }
    .leaflet-popup-content-wrapper {
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        padding: 0;
        overflow: hidden;
    }
    .leaflet-popup-content {
        margin: 0;
        line-height: 1.4;
    }
    .custom-marker {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .marker-pin {
        width: 34px;
        height: 34px;
        border-radius: 9999px;
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        border: 2.5px solid #ffffff;
        box-shadow: 0 4px 10px rgba(6, 78, 59, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 800;
        font-size: 11px;
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .marker-pin:hover {
        transform: scale(1.18);
        background: #022c22;
        border-color: #facc15;
    }
    .marker-pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 9999px;
        background: #10b981;
        opacity: 0.4;
        animation: pin-pulse 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        pointer-events: none;
    }
    @keyframes pin-pulse {
        0% { transform: scale(0.95); opacity: 0.6; }
        70% { transform: scale(1.8); opacity: 0; }
        100% { transform: scale(1.8); opacity: 0; }
    }
</style>
@endpush

@section('content')
<div class="space-y-5">
    <!-- Header with Back Button & Centering Control -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b pb-3 border-slate-200">
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition" title="Kembali ke Beranda">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-base sm:text-lg font-extrabold text-slate-800">Peta Sebaran Alumni PPIB</h1>
                <p class="text-xs text-slate-500">Persebaran domisili dan kiprah alumni di seluruh wilayah Nusantara.</p>
            </div>
        </div>

        <!-- Quick Focus Button -->
        <button type="button" id="btn-focus-indonesia" class="self-start sm:self-auto px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200 flex items-center space-x-1.5 shadow-sm transition">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Fokus ke Indonesia</span>
        </button>
    </div>

    <!-- Map Container -->
    <div class="bg-white p-3 rounded-3xl border border-slate-200 shadow-sm space-y-2">
        <div id="map" class="shadow-inner"></div>
        <div class="flex items-center justify-between text-[11px] text-slate-400 px-2 pt-1">
            <span>Peta OpenStreetMap Nusantara</span>
            <span class="flex items-center space-x-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                <span>Klik pin hijau untuk melihat detail alumni tiap kota</span>
            </span>
        </div>
    </div>

    <!-- City Breakdown -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <div class="flex items-center justify-between border-b pb-2">
            <h2 class="font-bold text-slate-800 uppercase tracking-wider text-xs flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Sebaran Berdasarkan Kota & Wilayah</span>
            </h2>
            <span class="text-[11px] text-slate-400">Klik kota untuk zoom di peta</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 text-xs">
            @foreach($alumniLocations as $kota => $group)
                <button type="button" onclick="focusToCity('{{ $kota }}')" class="p-2.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200/80 hover:border-emerald-300 flex items-center justify-between text-left transition group">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-100 group-hover:bg-emerald-600 group-hover:text-white text-emerald-800 flex items-center justify-center transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <span class="font-semibold text-slate-700 group-hover:text-emerald-900">{{ $kota }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                        {{ count($group) }} Alumni
                    </span>
                </button>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
    let mapInstance = null;
    let cityMarkers = {};

    document.addEventListener('DOMContentLoaded', function () {
        // Strict boundary for Indonesia region so user cannot pan into outer oceans
        const indonesiaBounds = [
            [-11.5, 94.0], // South-West (Indian Ocean south of Java/Sumatra)
            [6.5, 142.0]   // North-East (Papua border)
        ];

        // Initialize Map centered strictly on Indonesia
        mapInstance = L.map('map', {
            center: [-2.5489, 118.0149],
            zoom: 5,
            minZoom: 4,
            maxZoom: 18,
            maxBounds: indonesiaBounds,
            maxBoundsViscosity: 0.8
        });

        // OpenStreetMap Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(mapInstance);

        // Predefined city coordinates for PPIB alumni hubs
        const cities = [
            { name: "Jakarta", lat: -6.2088, lng: 106.8456, count: 18, region: "DKI Jakarta & Sekitarnya" },
            { name: "Bandung", lat: -6.9175, lng: 107.6191, count: 12, region: "Jawa Barat" },
            { name: "Surabaya", lat: -7.2575, lng: 112.7521, count: 15, region: "Jawa Timur" },
            { name: "Yogyakarta", lat: -7.7956, lng: 110.3695, count: 9, region: "DI Yogyakarta" },
            { name: "Semarang", lat: -6.9667, lng: 110.4167, count: 7, region: "Jawa Tengah" },
            { name: "Malang", lat: -7.9666, lng: 112.6326, count: 8, region: "Jawa Timur" },
            { name: "Medan", lat: 3.5952, lng: 98.6722, count: 5, region: "Sumatera Utara" },
            { name: "Makassar", lat: -5.1477, lng: 119.4327, count: 6, region: "Sulawesi Selatan" },
            { name: "Banjarmasin", lat: -3.3194, lng: 114.5908, count: 4, region: "Kalimantan Selatan" },
        ];

        const markerGroup = L.featureGroup();

        cities.forEach(city => {
            // Elegant custom HTML pulse pin
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `
                    <div class="marker-pin">
                        <div class="marker-pulse"></div>
                        <span>${city.count}</span>
                    </div>
                `,
                iconSize: [34, 34],
                iconAnchor: [17, 17],
                popupAnchor: [0, -18]
            });

            const marker = L.marker([city.lat, city.lng], { icon: customIcon });

            // Modern popup card
            const popupContent = `
                <div class="p-3.5 bg-white space-y-1.5 text-xs text-slate-800 min-w-[180px]">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-1.5">
                        <span class="font-extrabold text-sm text-emerald-900">${city.name}</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">${city.count} Alumni</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium">${city.region}</p>
                    <div class="pt-1">
                        <span class="text-[10px] text-emerald-700 font-semibold flex items-center space-x-1">
                            <span>Korwil Alumni PPIB</span>
                        </span>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
            markerGroup.addLayer(marker);
            cityMarkers[city.name.toLowerCase()] = marker;
        });

        markerGroup.addTo(mapInstance);

        // Fit map bounds strictly around the alumni pins
        setTimeout(function () {
            mapInstance.invalidateSize();
            mapInstance.fitBounds(markerGroup.getBounds(), {
                padding: [40, 40],
                maxZoom: 6
            });
        }, 300);

        // Reset to Indonesia Button
        document.getElementById('btn-focus-indonesia')?.addEventListener('click', function () {
            mapInstance.invalidateSize();
            mapInstance.fitBounds(markerGroup.getBounds(), {
                padding: [40, 40],
                maxZoom: 6
            });
        });

        // Window resize handler to maintain map integrity
        window.addEventListener('resize', function () {
            if (mapInstance) {
                mapInstance.invalidateSize();
            }
        });
    });

    // Function to pan to city when clicked from list
    window.focusToCity = function (cityName) {
        if (!mapInstance) return;
        const key = cityName.toLowerCase().trim();
        const marker = cityMarkers[key];
        if (marker) {
            mapInstance.flyTo(marker.getLatLng(), 8, { duration: 1.2 });
            marker.openPopup();
        } else {
            // If dynamic city, find coordinates or alert
            mapInstance.setView([-2.5489, 118.0149], 5);
        }
    };
</script>
@endpush
