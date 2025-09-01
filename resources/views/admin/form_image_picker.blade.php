<form action="{{ route('upload.store_image_picker') }}" method="post" id="formImage" class="position-relative rounded overflow-hidden" style="aspect-ratio: 1/1; height: 500px; width: 100%">
  @csrf

  <img src="" alt="" id="preview_img" style=" width: 100%; height: 100%; object-fit: cover;">
  <div class="position-absolute top-0 left-0 right-0 py-2" id="ratio_container" style="background-color: rgba(0, 0, 0, 0.5); z-index: 10; display: none">
    <div class="d-flex justify-content-center">
      <div class="btn-group ratio-toggle" role="group">
        <button type="button" class="btn btn-sm btn-outline-light aspect-ratio-btn active" data-ratio="1/1">1:1</button>
        <button type="button" class="btn btn-sm btn-outline-light aspect-ratio-btn" data-ratio="3/4">3:4</button>
        <button type="button" class="btn btn-sm btn-outline-light aspect-ratio-btn" data-ratio="9/14">9:14</button>
        <button type="button" class="btn btn-sm btn-outline-light aspect-ratio-btn" data-ratio="free">Full</button>
      </div>
    </div>
  </div>
  <div class="position-absolute bottom-0 left-0 right-0">
    <div class="row justify-content-center my-3">
      <button class="btn btn-sm btn-secondary zoomInHandler" type="button"><i class="fas fa-plus"></i></button>
      <button class="btn btn-sm btn-secondary zoomOutHandler" type="button"><i class="fas fa-minus"></i></button>
    </div>
  </div>
</form>

<div id="response_container_logo" class="my-3" style="text-align: left">
</div>
