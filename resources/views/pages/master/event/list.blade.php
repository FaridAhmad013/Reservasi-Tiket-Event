@extends('admin.parent')

@section('title', $module_name)

@section('styles')
<style>
  .avatar{
    object-fit: cover;
  }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endsection

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">{{ $group }}</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="{{ route($module.'.index') }}"><i class="{{ $icon }}"></i></a></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route($module.'.index') }}">{{ $module_name }}</a></li>
    </ol>
  </nav>
</div>
@endsection

@section('page')
<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card" style="background: #1E1E2F; box-shadow: none; border: none">
      <div class="card-body" id="box-aw">
        @include('admin.alert')
        <div class="table-responsive py-2">
          <table class="table align-items-center table-flush dt-wow" style="width: 100% !important;">
            <thead class="thead-dark">
              <tr>
                <th>Aksi</th>
                <th>Foto</th>
                <th>Nama Event</th>
                <th>Waktu Event</th>
                <th>Lokasi Event</th>
                <th>Created At</th>
                <th>Updated At</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
  let _url = {
    datatable: `{{ route('datatable.'.$module) }}`,
    create: `{{ route($module.'.create') }}`,
    edit: `{{ route($module.'.edit', ':id') }}`,
    show: `{{ route($module.'.show', ':id') }}`,
    show_gambar: `{{ route($module.'.show_gambar', ':id') }}`,
    show_lokasi: `{{ route($module.'.show_lokasi', ':id') }}`,
    delete: `{{ route($module.'.destroy', ':id') }}`,
    form_gambar: `{{ route('upload.form_image_picker') }}`,
    hapus_gambar: `{{ route('upload.hapus_gambar') }}`,
    detail_event: `{{ route('detail_event.index') }}?id=:id`
  }

  let table, cropper;

  $(() => {
    let dt_buttons = [
      {
        extend: 'colvis',
        text: 'Column',
        titleAttr: 'Column',
        tag: "button",
        className: "btn-default"
      }
    ];

    dt_buttons.unshift({
      extend: 'print',
      text: '<i class="fas fa-file-pdf"></i>',
      titleAttr: 'pdf',
      tag: "button",
      className: "btn-default"
    },
    {
      extend: 'csv',
      text: '<i class="fas fa-file-csv"></i>',
      titleAttr: 'csv',
      tag: "button",
      className: "btn-default"
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fas fa-file-excel"></i>',
      titleAttr: 'excel',
      tag: "button",
      className: "btn-default"
    })


    dt_buttons.unshift( {
      text: '<i class="fas fa-plus"></i> Tambah',
      attr: { id: 'create' },
      className: "btn-default",
      action: function(e, dt, node, config ) {
        create()
      }
    })

    table = $(".dt-wow").DataTable({
      language: {
        search: `<i class="fas fa-search"></i>`,
        infoFiltered: ``
      },
      dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
      order: [[5, 'asc']],
      buttons: dt_buttons,
      processing: true,
      serverSide: true,
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All'],
      ],
      ajax: {
        url: _url.datatable,
        type: 'POST',
        beforeSend: function (request) {
          request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        }
      },
      columns: [
        {
          data: 'aksi'
        },
        {
          data: 'foto'
        },
        {
          data: 'nama_event'
        },
        {
          data: 'waktu_event'
        },
        {
          data: 'lokasi'
        },
        {
          data: 'created_at'
        },
        {
          data: 'updated_at'
        },
      ],
      scrollY: (Ryuna.heightWindow() <= 660 ? 500 : (Ryuna.heightWindow() - 426)),
      scrollX: true
    });
  })

  function append_container_image_picker(i) {
    $('#wrap-gambar_event').append(`
      <div>
        <div class="galeri container_image_picker-${i}" style="cursor: pointer; width: 100%; height: auto; aspect-ratio: 1/1; overflow: hidden; border: 1px #172b4d solid;">
          <img class="img-fluid" src="{{ asset('img/default_add_photo_dark.png') }}" alt="" style="width: 100%; height: 100%; display: block; object-fit: cover">
          <div class="position-absolute top-0 right-0 p-2">
            <div id="wrap-remove_image_picker_${i}" style="display: none">
              <button type="button" class="btn btn-danger btn-sm" onclick="remove_image_picker(${i})"><i class="fa fa-trash"></i></button>
            </div>
          </div>
          <div class="position-absolute bottom-0 right-0 left-0">
            <div class="bg-dark p-2 position-relative text-white" title="Foto ${(i+1)}">
              <center>
                <b>
                  Foto ${(i+1)}
                </b>
              </center>
            </div>
          </div>
        </div>
        <input type="hidden" name="foto[${i}][label]" value="Foto ${(i+1)}" />
        <input type="file"  id="input-foto-${i}" autocomplete="off" accept="image/*" style="display: none">
        <input type="hidden" name="foto[${i}][value]" id="filename_${i}">
      </div>
    `)

    setTimeout(() => {
      $(`.container_image_picker-${i} img`).on('click drag', function(e){
        $(`#input-foto-${i}`).click()
      })

      $(`#input-foto-${i}`).change(function(e){
        var file = e.target.files[0];

        // Validasi apakah file adalah gambar
        if (file && file.type.match('image.*')) {
          var reader = new FileReader();

          reader.onload = function() {
            Ryuna.blockUI()

            $.get((_url.form_gambar)).done(function(res) {
              Swal.fire({
                title: res?.title ?? '',
                html: res?.body ?? '',
                footer: res?.footer ?? '',
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                onOpen: () => {
                  $('#swal-back').on('click', function() {
                    Swal.close();
                    $(`#filename_${i}`).val('')
                  });

                  $('#swal-continue').on('click', function() {

                    if (document.querySelector(`#input-foto-${i}`).files[0].size > 2 * 1024 * 1024) { // 2MB
                      let html = '<div class="alert alert-danger alert-dismissible fade show">';
                      html += 'Ukuran file maksimal 2MB';
                      html += '</div>';
                      $('#response_container_logo').html(html);
                      Ryuna.noty('error', 'Ukuran file maksimal 2MB', '')
                      return;
                    }
                    var canvas = cropper?.getCroppedCanvas();

                    function compressImage(canvas, quality, callback) {
                      canvas.toBlob((blob) => {
                        if (blob.size <= 2 * 1024 * 1024 || quality <= 0.1) { // 2MB or minimum quality
                          callback(blob);
                        } else {
                          compressImage(canvas, quality - 0.1, callback);
                        }
                      }, 'image/jpeg', quality);
                    }

                    compressImage(canvas, 1.0, (blob) => {
                      var file = new File([blob], document.querySelector(`#input-foto-${i}`).files[0].name, {
                        type: 'image/png'
                      });

                      let el_form = $('#formImage')
                      let target = el_form.attr('action')
                      let formData = new FormData(el_form[0])
                      formData.append('file', file)
                      formData.append('path', 'event')
                      Ryuna.blockUI()
                      $('#response_container_logo').empty()


                      $.ajax({
                        url: target,
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                      }).done((res) => {
                        if(res?.status == true){
                          let html = '<div class="alert alert-success alert-dismissible fade show">'
                          html += `${res?.message}`
                          html += '</div>'
                          Ryuna.noty('success', '', res?.message)
                          $('#response_container_logo').html(html)
                          Ryuna.unblockUI()
                          $(`#filename_${i}`).val(res.data.filename)

                          $(`#wrap-remove_image_picker_${i}`).show()

                          generate_image_handler(`${i}`, URL.createObjectURL(file))
                          setTimeout(() => {
                            Swal.close()
                          }, 1000);
                        }
                      }).fail((xhr) => {

                        if(xhr?.status == 422){
                          let errors = xhr.responseJSON.errors
                          let html = '<div class="alert alert-danger alert-dismissible fade show">'
                          html += '<ul>';
                          for(let key in errors){
                            html += `<li>${errors[key]}</li>`;
                          }
                          html += '</ul>'
                          html += '</div>'
                          $('#response_container_logo').html(html)
                          Ryuna.unblockUI()
                        }else{
                          let html = '<div class="alert alert-danger alert-dismissible fade show">'
                          html += `${xhr?.responseJSON?.message ?? 'Terjadi Kesalahan Internal'}`
                          html += '</div>'
                          Ryuna.noty('error', '', xhr?.responseJSON?.message ?? 'Terjadi Kesalahan Internal')
                          $('#response_container_logo').html(html)
                          Ryuna.unblockUI()
                        }
                      })
                    });
                  });
                }
              });

              setTimeout(() => {
                if (reader.result) {
                  $('#preview_img').attr('src', reader.result);
                  $('#formImage').css('aspect-ratio', 'auto')
                  $('#ratio_container').show()
                  initCropper('1/1')


                  $('.aspect-ratio-btn').click(function() {
                    $('.aspect-ratio-btn').removeClass('active');
                    $(this).addClass('active');

                    const aspectRatio = $(this).data('ratio');

                    initCropper(aspectRatio);
                  });

                  $('.zoomInHandler').click(function(e){
                    e.preventDefault()
                    zoomIn()
                  })

                  $('.zoomOutHandler').click(function(e){
                    e.preventDefault()
                    zoomOut()
                  })
                }
                Ryuna.unblockUI();
              }, 500);
            }).fail(function(xhr) {
                Ryuna.noty('error', 'Gagal mengunggah gambar.', '');
                $(`#filename_${i}`).val('');
                Ryuna.unblockUI();
            });

          }
          reader.readAsDataURL(file);
        } else {
          Ryuna.noty('error', 'File yang Anda unggah bukan berupa gambar. Harap unggah file gambar (jpg, png, gif, dll).', '')
          $(`#filename_${i}`).val('');
        }
      });
    }, 500);

  }

  function remove_image_picker(index){
    Swal.fire({
      title: 'Apakah Anda Yakin?',
      text: 'Apakah Anda yakin ingin menghapus gambar ini? Perubahan akan langsung diterapkan',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      swal: '400px',
    }).then((result) => {
      if (result.value) {
        const formData = new FormData();
        $(`.container_image_picker-${index} img`).css('display', 'none')
        $(`.container_image_picker-${index}`).addClass('shimmer')
        formData.append('file', $(`#filename_${index}`).val())
        $.ajax({
          url: _url.hapus_gambar,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (res) {
            $(`.container_image_picker-${index} img`).css('display', 'block')
            $(`.container_image_picker-${index}`).removeClass('shimmer')

            $(`.container_image_picker-${index} img`).attr('src', `{{ asset('img/default_add_photo_dark.png') }}`)
            $(`#foto_bukti_penerimaan-${index}`).val('')
            $(`[name="foto[${index}][value]"]`).val('')
            $(`#wrap-remove_image_picker_${index}`).hide()

            Ryuna.noty('success', `Gambar berhasil dihapus`, '')
          },
          error: function (xhr) {
            $(`.container_image_picker-${index} img`).css('display', 'block')
            $(`.container_image_picker-${index}`).removeClass('shimmer')
            Ryuna.noty('error', `Gambar gagal dihapus`, '')
          }
        });
      }
    })
  }

  function generate_image_handler(id, url_link){
    $(`.container_image_picker-${id} img`).attr('src', url_link);
  }

  function initCropper(aspectRatio, isLandscape) {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }

    const cropperOptions = {
      viewMode: 0,
      guides: true,
      autoCropArea: 1,
      dragMode: 'move',
      zoomable: true,
      responsive: true,
      background: false,
      modal: true,
      cropBoxResizable: true,
      cropBoxMovable: true,
      scalable: true,
      minContainerWidth: 100,
      minContainerHeight: 100,
      minCanvasWidth: 0,
      minCanvasHeight: 0
    };

    if (aspectRatio !== 'free') {
      const [numerator, denominator] = aspectRatio.split('/').map(Number);
      cropperOptions.aspectRatio = numerator / denominator;
    } else {
      cropperOptions.aspectRatio = NaN;
    }

    cropper = new Cropper(document.querySelector('#preview_img'), cropperOptions);
  }

  function zoomIn() {
    cropper.zoom(0.1);
  }

  function zoomOut() {
    cropper.zoom(-0.1);
  }

  function create(){
    Ryuna.blockUI()
    $.get(_url.create).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function detail_event(id){
    window.location.href = _url.detail_event.replace(':id', id)
  }

  function show(id){
    Ryuna.blockUI()
    $.get(_url.show.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.large_modal()
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function show_gambar(id){
    Ryuna.blockUI()
    $.get(_url.show_gambar.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.large_modal()
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function show_lokasi(id){
    Ryuna.blockUI()
    $.get(_url.show_lokasi.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.large_modal()
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function edit(id){
    Ryuna.blockUI()
    $.get(_url.edit.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function save(){
    $('#response_container').empty();
    Ryuna.blockElement('.modal-content');
    let el_form = $('#myForm')
    let target = el_form.attr('action')
    let formData = new FormData(el_form[0])

    $.ajax({
      url: target,
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
    }).done((res) => {
      if(res?.status == true){
        let html = '<div class="alert alert-success alert-dismissible fade show">'
        html += `${res?.message}`
        html += '</div>'
        Ryuna.noty('success', '', res?.message)
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')

        if($('[name="_method"]').val() == undefined) el_form[0].reset()
        table.draw()

        setTimeout(() => {
          Ryuna.close_modal()
        }, 3000);
      }
    }).fail((xhr) => {
      if(xhr?.status == 422){
        let errors = xhr.responseJSON.errors
        let html = '<div class="alert alert-danger alert-dismissible fade show">'
        html += '<ul>';
        for(let key in errors){
          html += `<li>${errors[key]}</li>`;
        }
        html += '</ul>'
        html += '</div>'
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
      }else{
        let html = '<div class="alert alert-danger alert-dismissible fade show">'
        html += `${xhr?.responseJSON?.message}`
        html += '</div>'
        Ryuna.noty('error', '', xhr?.responseJSON?.message)
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
      }
    })
  }

  function destroy(id){
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data yang di hapus secara permanen!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $.ajax({
          url: _url.delete.replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'DELETE',
        }).done((res) => {
          Swal.fire({
            title: res.message,
            text: '',
            type: 'success',
            confirmButtonColor: '#007bff'
          })
          table.draw()
        }).fail((xhr) => {
          Swal.fire({
            title: xhr.responseJSON.message,
            text: '',
            type: 'error',
            confirmButtonColor: '#007bff'
          })
        })
      }
    })
  }
</script>
@endsection
