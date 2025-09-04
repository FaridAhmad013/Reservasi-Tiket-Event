<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event - Reservasi Tiket</title>

    <!-- Tailwind CSS dari CDN (sementara) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purple: {
                            900: '#1a103d',
                            800: '#2d1b69',
                            700: '#3d2a7a',
                            600: '#5a3d9a',
                            500: '#7c5ac2',
                            400: '#9f7aea',
                            300: '#b794f4',
                        }
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/datatable-extensions/fixedColumns.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/wizard/bd-wizard.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/wizard/materialdesignicons.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.min.css') }}">
    <!-- Custom wizard css -->
    <link rel="stylesheet" href="{{ asset('assets/wizard/css/bd-wizard.css') }}">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.1.0') }}" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?'.date('Ym')) }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/datatables-searchbuilder.min.css') }}" type="text/css">
    {{-- Date CSS --}}
    <link href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/flatpickr/material_blue.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/flatpickr/monthSelect.css') }}" rel="stylesheet">

    {{-- Noty --}}
    <link href="{{ asset('assets/vendor/noty/noty.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/lexend_deca.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(to bottom, #1f2937, #6b21a8, #000000);
        }

        .backdrop-custom {
            background: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(20px);
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
        }
        .deskripsi-wrapper {
          position: relative;
          max-height: 150px; 
          overflow: hidden;
        }

        .deskripsi-wrapper.expanded {
          max-height: none; 
        }

        .deskripsi-content {
        }

        .load-more {
          cursor: pointer;
          text-align: center;
        }
    </style>
  <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">

  <script>
    var base_url = "{{ url('').'/' }}"
  </script>
</head>
<body class="min-h-screen gradient-bg text-white">

  <!-- Container Utama -->
  <div class="max-w-6xl mx-auto p-4 sm:p-6 backdrop-custom rounded-2xl shadow-xl border border-purple-500/40 mt-10 mb-10">

    <div class="flex flex-wrap mb-3">
      <div class="w-3/4 relative h-96 overflow-y-auto pr-3">
        <div class="relative overflow-hidden rounded-xl shadow-lg h-full border border-purple-400/30">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              @foreach ($event->foto as $foto)
                <div class="swiper-slide relative">
                  <!-- Gambar -->
                  <img src="{{ $foto }}" alt="Concert Banner" class="w-full h-96 object-cover">

                  <!-- Overlay gradasi -->
                  <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20"></div>

                  <!-- Overlay teks -->
                  <div class="absolute bottom-6 left-6 z-10">
                    <h1 class="text-2xl sm:text-4xl font-bold text-purple-300 drop-shadow-lg">
                      {{ $event->nama_event ?? 'Konser Musik Spektakuler' }}
                    </h1>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Tombol navigasi -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Pagination bulatan -->
            <div class="swiper-pagination"></div>
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20"></div>
          <div class="absolute bottom-6 left-6">
            <h1 class="text-3xl sm:text-4xl font-bold text-purple-300 drop-shadow-lg">
              {{ $event->nama_event ?? 'Konser Musik Spektakuler' }}
            </h1>
            <p class="text-lg text-gray-200 mt-2">
              {!! $event->deskripsi ?? 'Pengalaman musik yang tak terlupakan dengan artis ternama' !!}
            </p>
          </div>
        </div>
      </div>
      <div class="w-1/4 relative h-96 overflow-y-auto">
        {{-- Deskripsi Detail --}}
        <div class="bg-black/40 border border-purple-400/30 p-2 rounded-xl shadow-md h-full">
          <h2 class="text-lg font-semibold text-purple-300 mb-4 flex items-center mt-2">
            <span class="mr-2">ℹ️</span> Informasi Tambahan
          </h2>
          <ul class="space-y-3 text-gray-300">
            <li class="flex items-start">
              <span class="text-green-400 mr-2">✓</span>
              <span>Anak-anak di bawah 3 tahun masuk gratis (tanpa kursi)</span>
            </li>
            <li class="flex items-start">
              <span class="text-red-400 mr-2">✗</span>
              <span>Tiket tidak dapat dikembalikan atau refund</span>
            </li>
            <li class="flex items-start">
              <span class="text-yellow-400 mr-2">⚠️</span>
              <span>Setiap ID hanya bisa membeli maksimal 4 tiket</span>
            </li>
            <li class="flex items-start">
              <span class="text-blue-400 mr-2">⏰</span>
              <span>Pintu dibuka 2 jam sebelum acara dimulai</span>
            </li>
            <li class="flex items-start">
              <span class="text-purple-400 mr-2">🎵</span>
              <span>Dilarang membawa makanan dan minuman dari luar</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- Informasi Event --}}
    <div class="flex flex-wrap border border-purple-400/30 rounded-xl">
      {{-- Deskripsi  --}}
      <div class="bg-black/40 px-3 py-4 rounded-xl shadow-md w-8/12 mb-3">
        <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center">
          <span class="mr-2">📝</span> Deskripsi Event
        </h2>
        <div class="deskripsi-wrapper relative">
          <div class="deskripsi-content">
            <p class="deskripsi text-gray-300">
              {!! $event->deskripsi ?? 'Pengalaman musik yang tak terlupakan dengan artis ternama' !!}
            </p>
          </div>
          <button class="load-more absolute bottom-0 left-0 right-0  w-full btn btn-default hidden">
            Lihat Lebih Banyak
          </button>
        </div>
      </div>
      {{-- Jadwal --}}
      <div class="bg-black/40 px-3 py-4 border-left border-purple-400/30  shadow-md w-4/12 mb-3">
        <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center">
          <span class="mr-2">📅</span> Jadwal Event
        </h2>
        <div class="space-y-1">
          <p class="flex items-center">
            <span class="w-6 ml-2">🗓</span>
            <span class="mx-2">{{ App\Helpers\Util::tanggal_bahasa($event->waktu_event) }}</span>
          </p>
          <p class="flex items-center">
            <span class="w-6 ml-1"><a href="https://www.google.com/maps?q={{ @$event->kordinat[0] }},{{ @$event->kordinat[1] }}" target="_blank">📍</a></span>
            <span class="mx-2 text-gray-300">{{ $event->lokasi }}</span>
          </p>
        </div>
      </div>

    </div>
    {{-- Tiket --}}
    @foreach ($detail_events as  $detail_event)
      <div class="bg-black/40 border border-purple-400/30 my-3 rounded-xl shadow-md w-full overflow-hidden">
        <div class="flex justify-content-between align-items-center px-3 py-4">
          <div class="w-9/12">
            <div class="font-bold">{{ $detail_event->area }}</div>
            <div>{!! $detail_event->deskripsi !!}</div>
          </div>
          <div class="w-3/12">
            <div class="flex flex-wrap justify-content-between">
              <div>
                {!! \App\Helpers\Util::status_detail_event($detail_event->status) !!}
              </div>
              <div>
                {{ \App\Helpers\Util::rupiah($detail_event->harga) }}
              </div>
            </div>
          </div>
        </div>
        @if (@$user->role->role == 'Admin' || @$user->role->role == 'Pengguna')
          <button class="btn btn-primary btn-block" onclick="beliTicket('{{ $detail_event->id }}')">
            Pesan Tiket
          </button>
        @endif
      </div>
    @endforeach

    {{-- Tombol Kembali --}}
    <div class="mt-8 text-center">
      <a href="{{ route('main.index') }}" class="inline-flex items-center px-6 py-3 border border-purple-400/30 text-purple-300 rounded-xl hover:bg-purple-400/10 transition-all duration-300">
        ← Kembali ke Halaman Utama
      </a>
    </div>
  </div>
</body>


  <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content text-white" style="border: 2px solid rgba(58, 64, 96, 0.6); background: oklch(27.8% 0.033 256.848)">
        <div class="modal-header">
          <h5 class="modal-title text-white" id="modal_title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body"></div>
        <div class="modal-footer" id="modal_footer"></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>

  <script src="{{ asset('js/jszip.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-block-ui/jquery-block-ui.js') }}"></script>
  <script src="{{ asset('js/autoNumeric.js') }}"></script>
  <script src="{{ asset('js/numeral.js') }}"></script>
  <script src="{{ asset('assets/vendor/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('vendor/flatpickr/monthSelect.js') }}"></script>

  <!-- Custom js -->
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/wizard/jquery.steps.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/wizard/bd-wizard.js') }}"></script>
  <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
  {{-- Noty JS --}}
  <script src="{{ asset('assets/vendor/noty/noty.js') }}" type="text/javascript"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets/js/argon.js?v=1.1.0') }}"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="{{ asset('assets/js/demo.min.js') }}"></script>
  {{-- Global js --}}
  <script src="{{ asset('js/global.js') }}"></script>
  <script src="{{ asset('js/cropper.min.js') }}"></script>
  <script>
    let _url = {
      form_beli_tiket: `{{ route('ticket.beli_tiket.create', ':id') }}`,
      form_gambar: `{{ route('upload.form_image_picker') }}`,
      hapus_gambar: `{{ route('upload.hapus_gambar') }}`,
    }

    let cropper
    function beliTicket(id) {
      Ryuna.blockUI()

      $.get(_url.form_beli_tiket.replace(':id', id)).done((res) => {
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

    // Animasi hover untuk tombol
    document.addEventListener('DOMContentLoaded', function() {
      const buttons = document.querySelectorAll('button');
      buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-2px)';
        });
        button.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });

      var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    });

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

          if(xhr?.responseJSON?.errors && xhr?.responseJSON?.errors?.length > 0){
            html += '<ul style="list-style: disc">';
            xhr?.responseJSON?.errors.map((error) => {
              html += `<li>${error}</li>`
            })
            html += '</ul>';
          }

          html += '</div>'
          Ryuna.noty('error', '', xhr?.responseJSON?.message)
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')
        }
      })
    }

    $(window).on('load', function () {
      $('.deskripsi-wrapper').each(function () {
        let $wrapper = $(this);
        let $content = $wrapper.find('.deskripsi-content'); // ambil kontainer asli
        let $btn = $wrapper.find('.load-more');

        console.log("scrollHeight:", $content[0].scrollHeight, "wrapper:", $wrapper.height());

        // cek apakah tinggi konten melebihi batas
        if ($content[0].scrollHeight > $wrapper.height()) {
          $btn.removeClass('hidden');
        }

        $btn.on('click', function () {
          $wrapper.toggleClass('expanded');

          if ($wrapper.hasClass('expanded')) {
            $btn.text('Lihat Lebih Sedikit');
          } else {
            $btn.text('Lihat Lebih Banyak');
          }
        });
      });
    });




  </script>

</html>
