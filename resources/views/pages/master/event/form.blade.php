<style>
  .grid {
    --gap: 1em;
    --columns: 4;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(var(--columns), minmax(0, 1fr));
    columns: var(--columns);
    gap: var(--gap);
  }

  .grid>* {
    break-inside: avoid;
    margin-bottom: var(--gap);
  }

  .galeri{
    position: relative;
  }

  #map-0 .blockUI.blockMsg.blockElement{
    left: 40% !important;
    top: 40% !important;
  }

  .leaflet-control-geocoder-alternatives li{
    color: var(--charcoal-gray) !important
  }
</style>

<div class="form-group">
  <label for="nama_event">Nama Event</label>
  <input type="text" name="nama_event" id="nama_event" value="" class="form-control bg-dark border-dark text-white" autocomplete="off">
</div>
<div class="form-group">
  <label for="deskripsi">Deskripsi</label>
  <textarea name="deskripsi" id="deskripsi" class="form-control bg-dark border-dark text-white" autocomplete="off"></textarea>
</div>
<div class="form-group">
  <label for="waktu_event">Waktu Event</label>
  <input type="text" name="waktu_event" id="waktu_event" class="form-control bg-dark border-dark text-white" autocomplete="off">
</div>
<div class="form-group">
  <div class="d-flex justify-content-between">
    <div class="mb-2">Gambar</div>
    <button type="button" class="btn btn-success btn-sm" onclick="append_container_image_picker($(this).parent().parent().find('.grid').children().length)"> <i class="fas fa-plus"></i> </button>
  </div>

  <div class="grid" id="wrap-gambar_event">

  </div>
</div>

<div class="form-group">
  <label for="lokasi">Lokasi</label>
  <input type="text" name="lokasi" id="lokasi" class="form-control bg-dark border-dark text-white" placeholder="Contoh: Sumatera Utara Main Stadium" autocomplete="off">
</div>

<div class="form-group">
  <label for="kordinat">Kordinat</label>
  <input type="text" name="kordinat" id="kordinat" class="form-control bg-dark border-dark text-white" placeholder="-6.917464, 107.619125" autocomplete="off">
</div>


<div class="position-relative overflow-hidden" id="wrap-map-0" style="width: 100%; height: auto">
  <div id="map-0" style="width: 100%; height: 400px; display: flex; justify-content: center; align-items: center"></div>
</div>

<a href="https://www.google.com/maps?q=-6.917464,107.619125" target="_blank" class="btn btn-success mt-3">
  <i class="fas fa-map-marker-alt"></i> Lihat dengan Google Maps
</a>
<script>
  $(() => {
    Ryuna.summernote('[name="deskripsi"]')

    append_container_image_picker(0)

    flatpickr('#waktu_event', {
      enableTime: true,
      closeOnSelect: false,
      dateFormat: "d-m-Y H:i:S",
      defaultDate: new Date(),
      altInput: true,
      altFormat: "d-m-Y H:i:S",
      minDate: new Date()
    });
  })

  Ryuna.blockElement('#map-0')

  $(() => {
    if (window.maps && window.maps[0]) {
      window.maps[0].remove();
    }

    setTimeout(() => {
      // Buat peta
      var map = L.map(`map-0`).setView([-6.917464, 107.619125], 15);
      window.maps = window.maps || {};
      window.maps[0] = map;

      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: 'Leaflet &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>',
        maxZoom: 20
      }).addTo(map);

      // Tambah marker draggable
      var marker = L.marker([-6.917464, 107.619125], {
        icon: createNumberIcon(1, 'Lokasi Event'),
        draggable: true
      }).addTo(map);

      // Event ketika marker digeser
      marker.on('dragend', function(e) {
        var latlng = marker.getLatLng();
        console.log("Marker dipindahkan ke:", latlng.lat, latlng.lng);

        // Update input kordinat
        $("#kordinat").val(latlng.lat + "," + latlng.lng);
      });

      // Tambah search box
      var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
      })
      .on('markgeocode', function(e) {
        var bbox = e.geocode.bbox;
        var latlng = e.geocode.center;

        // Pindahkan marker ke lokasi hasil pencarian
        marker.setLatLng(latlng);
        map.fitBounds(bbox);

        // Update input kordinat
        $("#kordinat").val(latlng.lat + "," + latlng.lng);

        console.log("Hasil pencarian:", latlng.lat, latlng.lng);
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
</script>
