<div>
    <div class="container mx-auto max-w-sm">
        <div class="bg-white p-6 ronded-lg mt-3 shadow-lg">
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2"> Informasi Pegawai</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="mb2"><strong>Nama Pegawai : </strong>{{ Auth::user()->name }}</p>
                        <p><strong>Kantor : </strong>{{ $schedule->office->name }}</p>
                        <p><strong>Shift: </strong>{{ $schedule->shift->name }} ({{ $schedule->shift->start_time }} -
                            {{ $schedule->shift->end_time }})</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-l font-bold mb-2 ">Jam Masuk</h4>
                            <p><strong>09.02</strong></p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-l font-bold mb-2 ">Jam Pulang</h4>
                            <p><strong>19.02</strong></p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold mb-2">Presensi</h2>
                    <div id="map" class="mb-4 rounded-lg border border-gray-300" wire:ignore>
                    </div>
                    <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded" onclick="tagLocation()">Tag
                        Location</button>
                    @if ($insideRadius)
                        <button type="button" class="px-4 py-2 bg-green-500 rounded text-white">Submit
                            Presensi</button>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map;
        let lat;
        let lng;
        let component;
        let office = [{{ $schedule->office->latitude }}, {{ $schedule->office->longitude }}];
        const radius = {{ $schedule->office->radius }};
        let marker;
        document.addEventListener('livewire:initialized', function() {
            component = @this;
            map = L.map('map').setView([{{ $schedule->office->latitude }},
                {{ $schedule->office->longitude }}
            ], 18);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const circle = L.circle(office, {
                color: 'green',
                fillColor: 'green',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        });

        function tagLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    lat = position.coords.latitude;
                    lng = position.coords.longitude;

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker([lat, lng]).addTo(map);
                    map.setView([lat, lng], 13);

                    if (isWithinRadius(lat, lng, office, radius)) {
                        component.set('insideRadius', true);
                    } else {
                        alert('Anda berada diluar radius');
                    }
                })
            } else {
                alert('Tidak bisa get Location.');
            }
        }

        function isWithinRadius(lat, lng, center, radius) {
            let distance = map.distance([lat, lng], center);
            return distance <= radius;
        }
    </script>
</div>
