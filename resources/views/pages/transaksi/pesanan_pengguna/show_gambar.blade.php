<style>
  .grid {
    --gap: 1em;
    --columns: 4;
    max-width: 60rem;
    margin: 0 auto;
    display: column;
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
</style>

@if (count($data->bukti_transaksi) > 0)
<div class="grid" id="grid">
  @foreach ($data->bukti_transaksi as $key => $bukti_transaksi)
    <div class="galeri container_image_picker-{{ $key }} shimmer" style="cursor: pointer; width: 100%; height: auto; border: 1px solid #c6c6c6 !important;">
      <img class="img-fluid" src="" alt="" style="width: 100%; height: 100%">
    </div>
  @endforeach
</div>
@else
  <div class="alert alert-info">Belum ada bukti transaksi</div>
@endif

<script>
  var generate_success = 0

  $(() => {
    @if($data->bukti_transaksi != '' && $data->bukti_transaksi != null)
      @foreach ($data->bukti_transaksi as $key => $bukti_transaksi)
        generate_image_handler(`{{ $key }}`, `{{ asset('storage/'.$bukti_transaksi->value) }}`)
        generate_success++;

        if(generate_success == {{ count($data->bukti_transaksi) }}){
          Ryuna.create_image_multiple('grid')
        }
      @endforeach
    @endif
  })

  function generate_image_handler(id, url_link){
    $(`.container_image_picker-${id} img`).attr('src', url_link);
  }

</script>
