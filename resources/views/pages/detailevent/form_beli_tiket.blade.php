<style>
  .galeri{
    position: relative;
  }

  @media (min-width: 992px) {
    .modal-lg, .modal-xl {
      max-width: 500px;
    }
  }

</style>

<form action="{{ route('ticket.beli_tiket.create', ['detail_event_id' => $data->id]) }}" method="POST" id="myForm">
  @csrf
  <div class="swal-header mb-3">
    <div class="swal2-icon swal2-question swal2-animate-question-icon" style="display: flex;"><span class="swal2-icon-text">?</span></div>
    <h2 class="swal2-title text-center" id="swal2-title" >Apakah anda yakin ingin membeli tiket <b>{{ $event->nama_event }}</b> ({{ $data->area }})?</h2>
  </div>
  <div class="card mb-3 bg-dark">
    <div class="card-body">
      <h3 class="text-white text-left"><i class="fa fa-university"></i> Transfer ke Rekening Berikut:</h3>
      <table class="table table-borderless" style="width: 100%">
        <tr>
          <td class="text-white text-left" style="width: 25%">Bank</td>
          <td class="text-white text-left" style="width: 1%">:</td>
          <td class="text-white text-left font-weight-bold">BCA</td>
        </tr>
        <tr>
          <td class="text-white text-left">No. Rekening</td>
          <td class="text-white text-left">:</td>
          <td class="text-white text-left font-weight-bold"><span id="no-rek">1234567890</span> </td>
        </tr>
        <tr>
          <td class="text-white text-left">Atas Nama</td>
          <td class="text-white text-left">:</td>
          <td class="text-white font-weight:bold text-left">Farid Ahmad Fadhilah</td>
        </tr>
        <tr>
          <td class="text-white text-left">Nominal</td>
          <td class="text-white text-left">:</td>
          <td class="font-weight-bold text-white text-left" id="total-harga">Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
        </tr>
      </table>
    </div>
  </div
  <></>
  <div class="card mb-3 bg-dark">
    <div class="card-body">
      <h3 class="text-white text-left"><i class="fa fa-ticket"></i> Pilih Jumlah Tiket:</h3>
      <div class="input-group" style="max-width: 200px;">
        <button type="button" class="btn btn-danger btn-sm" id="qty-minus">-</button>
        <input type="number" class="form-control text-center" id="kuantitas" name="kuantitas" value="1" min="1">
        <button type="button" class="btn btn-success btn-sm" id="qty-plus">+</button>
      </div>
      <small class="text-white">Sisa tiket: <span id="sisa-tiket">{{ $data->sisa_tiket }}</span></small>
    </div>
  </div>
  <div class="alert alert-default text-left">
    Silakan Upload Bukti Pembayaran
  </div>
  <div class="flex justify-content-center align-items-center">
    <div class="galeri container_image_picker-0" style="cursor: pointer; width: 100%; height: auto; aspect-ratio: 1/1; overflow: hidden; border: 1px #172b4d solid;">
      <img class="img-fluid" src="{{ asset('img/default_add_photo_dark.png') }}" alt="" style="width: 100%; height: 100%; display: block; object-fit: cover">
      <div class="position-absolute top-0 right-0 p-2">
        <div id="wrap-remove_image_picker_0" style="display: none">
          <button type="button" class="btn btn-danger btn-sm" onclick="remove_image_picker(0)"><i class="fa fa-trash"></i></button>
        </div>
      </div>
      <div class="position-absolute bottom-0 right-0 left-0">
        <div class="bg-default p-2 position-relative text-white" title="Bukti Pembayaran">
          <center>
            <b>
              Bukti Pembayaran
            </b>
          </center>
        </div>
      </div>
    </div>
    <input type="hidden" name="bukti_transaksi[0][label]" value="Bukti Pembayaran" />
    <input type="file"  id="input-foto-0" autocomplete="off" accept="image/*" style="display: none">
    <input type="hidden" name="bukti_transaksi[0][value]" id="filename_0">

  </div>
</form>
<div id="response_container" class="my-3"></div>
<script>
  var hargaSatuan = {{ $data->harga }};
  function copyRekening() {
    let text = $("no-rek").text();
    navigator.clipboard.writeText(text).then(() => {
      Swal.fire('Berhasil!', 'Nomor rekening disalin.', 'success');
    });
  }
  function updateTotal() {
    let qty = parseInt($("#kuantitas").val()) || 0;
    let total = qty * hargaSatuan;
    $("#total-harga").html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total));
  }

  setTimeout(() => {
    $(`.container_image_picker-0 img`).on('click drag', function(e){
      $(`#input-foto-0`).click()
    })

    
    let maxQty = {{ $data->sisa_tiket ?? 0 }}; 
    let $qtyInput = $("#kuantitas");

    // pastikan value awal tidak lebih besar dari max
    if ($qtyInput.val() > maxQty) {
      $qtyInput.val(maxQty);
    }

    $("#qty-plus").click(function() {
      let current = parseInt($qtyInput.val());
      if (current < maxQty) {
        $qtyInput.val(current + 1);
        updateTotal()
      } else {
        Swal.fire('Info', 'Jumlah tiket maksimal ' + maxQty, 'info');
      }
    });

    $("#qty-minus").click(function() {
      let current = parseInt($qtyInput.val());
      if (current > 1) {
        $qtyInput.val(current - 1);
        updateTotal()
      }
    });

    // validasi manual input
    $qtyInput.on("input", function() {
      let val = parseInt($(this).val());
      if (isNaN(val) || val < 1) {
        $(this).val(1);
      } else if (val > maxQty) {
        $(this).val(maxQty);
        Swal.fire('Info', 'Jumlah tiket maksimal ' + maxQty, 'info');
      }
      updateTotal()
    });

    updateTotal();

     $("#kuantitas").on("input change", function(){
        let maxQty = parseInt($(this).attr("max"));
        if ($(this).val() > maxQty) {
            $(this).val(maxQty);
        }
        updateTotal();
    });
  }, 1000)

  $(`#input-foto-0`).change(function(e){
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
                $(`#filename_0`).val('')
              });

              $('#swal-continue').on('click', function() {

                if (document.querySelector(`#input-foto-0`).files[0].size > 2 * 1024 * 1024) { // 2MB
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
                  var file = new File([blob], document.querySelector(`#input-foto-0`).files[0].name, {
                    type: 'image/png'
                  });

                  let el_form = $('#formImage')
                  let target = el_form.attr('action')
                  let formData = new FormData(el_form[0])
                  formData.append('file', file)
                  formData.append('path', 'bukti_pembayaran')
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
                      $(`#filename_0`).val(res.data.filename)

                      $(`#wrap-remove_image_picker_0`).show()

                      generate_image_handler(`0`, URL.createObjectURL(file))
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
            $(`#filename_0`).val('');
            Ryuna.unblockUI();
        });

      }
      reader.readAsDataURL(file);
    } else {
      Ryuna.noty('error', 'File yang Anda unggah bukan berupa gambar. Harap unggah file gambar (jpg, png, gif, dll).', '')
      $(`#filename_0`).val('');
    }
  });

  function generate_image_handler(id, url_link){
    $(`.container_image_picker-${id} img`).attr('src', url_link);
  }

</script>
