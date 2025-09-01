<style>
  #map-0 .blockUI.blockMsg.blockElement{
    left: 40% !important;
    top: 40% !important;
  }

  .leaflet-control-geocoder-alternatives li{
    color: var(--charcoal-gray) !important
  }
</style>

<div class="position-relative overflow-hidden" id="wrap-map-0" style="width: 100%; height: auto">
  <div id="map-0" style="width: 100%; height: 400px; display: flex; justify-content: center; align-items: center"></div>
</div>

@if (count($data->kordinat) > 0)
  <a href="https://www.google.com/maps?q={{ $data->kordinat[0] }},{{ $data->kordinat[1] }}" target="_blank" class="btn btn-success mt-3">
    <i class="fas fa-map-marker-alt"></i> Lihat dengan Google Maps
  </a>
@endif
<script>

  @if (count($data->kordinat) > 0)
    Ryuna.blockElement('#map-0')

    $(() => {
      if (window.maps && window.maps[0]) {
        window.maps[0].remove();
      }

      setTimeout(() => {
        // Buat peta
        var map = L.map(`map-0`, {
          dragging: false,
          keyboard: false,
        }).setView(['{{ $data->kordinat[0] }}', '{{ $data->kordinat[1] }}'], 15);
        window.maps = window.maps || {};
        window.maps[0] = map;

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
          attribution: 'Leaflet &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>',
          maxZoom: 20
        }).addTo(map);

        // Tambah marker draggable
        var marker = L.marker(['{{ $data->kordinat[0] }}', '{{ $data->kordinat[1] }}'], {
          icon: createNumberIcon(1, 'Lokasi Event'),
          draggable: false,
          keyboard: false,
        }).addTo(map);


        // Tambah search box
        var geocoder = L.Control.geocoder({
          defaultMarkGeocode: false
        })
        .addTo(map);

        Ryuna.unblockElement('#map-0')
      }, 1000);
    });

    function createNumberIcon(number, nama_pelanggan) {
      return L.divIcon({
        className: 'custom-marker',
        html: `
          <div style="position: relative; text-align: center;" title="${nama_pelanggan}">
            <div style="position: relative; width: 25px; height: 41px; background-image: url('https://unpkg.com/leaflet@1.8.0/dist/images/marker-icon.png'); background-size: cover;">
              <span style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 12px; font-weight: bold; color: black; background-color: white; border-radius: 50%; width: 16px; height: 16px; line-height: 16px; text-align: center;">
                ${number}
              </span>
            </div>
          </div>`,
        iconSize: [25, 41],
        iconAnchor: [12, 41]
      });
    }
  @endif
</script>
