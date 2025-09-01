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

@if (count($data->foto) > 0)
<div class="grid" id="grid">
  @foreach ($data->foto as $key => $foto)
    <div class="galeri container_image_picker-{{ $key }} shimmer" style="cursor: pointer; width: 100%; height: auto; border: 1px solid #c6c6c6 !important;">
      <img class="img-fluid" src="" alt="" style="width: 100%; height: 100%">
    </div>
  @endforeach
</div>
@else
  <div class="alert alert-info">Belum ada foto event</div>
@endif

<script>
  var generate_success = 0

  $(() => {
    @if($data->foto != '' && $data->foto != null)
      @foreach ($data->foto as $key => $foto)
        generate_image_handler(`{{ $key }}`, `{{ asset('storage/'.$foto->value) }}`)
        generate_success++;

        console.log(generate_success, "{{ count($data->foto) }}")
        if(generate_success == {{ count($data->foto) }}){
          Ryuna.create_image_multiple('grid')
        }
      @endforeach
    @endif
  })
</script>
