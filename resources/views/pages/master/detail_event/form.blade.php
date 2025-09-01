<input type="hidden" name="event_id" value="{{ @$event->id }}" autocomplete="off">
<div class="form-group">
  <label for="nama_event">Area</label>
  <input type="text" name="area" id="area" value="{{ @$data->area }}" class="form-control bg-dark border-dark text-white" autocomplete="off">
</div>
<div class="form-group">
  <label for="deskripsi">Deskripsi</label>
  <textarea name="deskripsi" id="deskripsi" class="form-control bg-dark border-dark text-white" autocomplete="off">{{ @$data->deskripsi }}</textarea>
</div>
<div class="form-group">
  <label for="jumlah_tiket">Jumlah Tiket</label>
  <input type="text" name="jumlah_tiket" id="jumlah_tiket" class="form-control bg-dark border-dark text-white" autocomplete="off" value="{{ @$data->jumlah_tiket }}">
</div>

<div class="form-group">
  <label for="harga">Harga</label>
  <input type="text" name="harga" id="harga" class="form-control bg-dark border-dark text-white" autocomplete="off">
</div>

<div class="form-group">
  <label for="dibuka_pada">Dibuka Pada</label>
  <input type="text" name="dibuka_pada" id="dibuka_pada" class="form-control bg-dark border-dark text-white" autocomplete="off">
</div>
<div class="form-group">
  <label for="ditutup_pada">Ditutup Pada</label>
  <input type="text" name="ditutup_pada" id="ditutup_pada" class="form-control bg-dark border-dark text-white" autocomplete="off">
</div>

<script>
  $(() => {
    Ryuna.summernote('[name="deskripsi"]')
    $('#jumlah_tiket').mask('999999999999');

    init_format_rupiah('#harga', '{{ @$data->harga ?? 0 }}')

    var dibuka_pada = init_format_flatpickr('#dibuka_pada', '{{ @$data->dibuka_pada ? \Carbon\Carbon::parse($data->dibuka_pada)->format("d-m-Y H:i:S") : null }}', '{{ @$event->waktu_event ? \Carbon\Carbon::parse($event->waktu_event)->format("d-m-Y H:i:S") : null }}' , null)
    var ditutup_pada = init_format_flatpickr('#ditutup_pada', '{{ @$data->ditutup_pada ? \Carbon\Carbon::parse($data->ditutup_pada)->format("d-m-Y H:i:S") : null }}', '{{ @$event->waktu_event ? \Carbon\Carbon::parse($event->waktu_event)->format("d-m-Y H:i:S") : null }}' , null)

    dibuka_pada.config.onChange.push(function(selectedDates) {
      if (selectedDates.length > 0) {
        ditutup_pada.set("minDate", selectedDates[0]);
      }
    });
  })
</script>
