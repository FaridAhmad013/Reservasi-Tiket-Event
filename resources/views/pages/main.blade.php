<!DOCTYPE html>
<html style="scroll-behavior: smooth;">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="NgeventYuk by Farid Ahmad Fadhilah">
  <meta name="author" content="Farid Ahmad Fadhilah">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>NgeventYuk</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Page plugins -->
  <style>
    @keyframes example {
      0%   {background-color: red;}
      25%  {background-color: yellow;}
      50%  {background-color: blue;}
      100% {background-color: green;}
    }

    .text-white{
      color: var(--off-white);
    }

    .shadow-pink{
      box-shadow: 0 0 15px var(--magenta-pink) !important;
    }

    .shadow-yellow{
      box-shadow: 0 0 15px var(--cyber-yellow) !important;
    }


  </style>
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
  {{-- check app debug false --}}
  @if(config('app.debug') == false)
    @laravelPWA
  @endif
  <script>
    var base_url = "{{ url('').'/' }}"
  </script>
</head>

<body style="background-color: var(--dark-navy)">

  <!-- Main content -->
  <div class="main-content" id="panel">

    @include('pengguna.navbar')

    <div class="position-relative">
      @include('pengguna.hero')
      <div style="position: absolute; border-radius: inherit; inset: 0px;">
        <img decoding="async" loading="lazy" width="1200" height="630" sizes="min(100vw, 1200px)" src="{{ asset('assets/img/theme/wallpaper.png') }}" alt="" style="display: block; width: 100%; height: 100%; border-radius: inherit; object-position: center center; object-fit: fill;">
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid">

      <section class="container">
        <div class="pt-5 px-3 position-relative">
          <div class="bg-transparent">

            <div class="card-body">
              <div class="text-center text-white mb-5" data-aos="zoom-in-down" style="font-size: 2rem; font-weight: bold">Why Choose <span style="color: var(--cyan-300);">Ngevent</span><span style="color: var(--magenta-pink)">Yuk</span></div>
              <div class="row">
                <div class="col">
                  <div class="row justify-content-around">
                    <div class="col-12 ">
                      <div class="card card-neon bg-transparent" data-aos="fade-left" data-aos-duration="800">
                        <div class="card-body">
                          <div class="row align-items-center">
                            <div style="font-size: 3rem">🎟️</div>
                            <div class="col">
                              <h3 class="leading-relaxed tracking-wide font-lora my-2 font-weight-bold text-white ">Tiket Resmi & Cepat</h3>
                              <p class="text-light">100% tiket resmi, transaksi cepat, dan terpercaya.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 ">
                      <div class="card card-neon bg-transparent" data-aos="fade-left" data-aos-duration="800">
                        <div class="card-body">
                          <div class="row align-items-center">
                           <div>
                             <div style="font-size: 3rem">🔒</div>
                           </div>
                           <div class="col">
                             <h3 class="leading-relaxed tracking-wide font-lora my-2 font-weight-bold text-white ">Pembayaran Aman</h3>
                             <p class="text-light">Transaksi terenkripsi & mendukung berbagai metode pembayaran.</p>
                           </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 ">
                      <div class="card card-neon bg-transparent" data-aos="fade-left" data-aos-duration="800">
                        <div class="card-body">
                           <div class="row align-items-center">
                            <div style="font-size: 3rem">📲</div>
                            <div class="col">
                              <h3 class="leading-relaxed tracking-wide font-lora my-2 font-weight-bold text-white ">Tiket Digital (QR Code)</h3>
                              <p class="text-light">Langsung dapat e-ticket QR, cukup scan saat masuk venue.</p>
                            </div>
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col d-none d-md-block">
                  <img src="{{ asset('assets/img/theme/why_choose.png') }}" alt="" data-aos="fade-left">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="container" id="events">
        <div class="p-3 position-relative">
          <div class="bg-transparent">
            <div class="card-body position-relative">
              <div class="position-absolute left-0 top-0 d-none d-md-block" data-aos="fade-right">
                <img src="{{ asset('assets/img/theme/hot_events1.png') }}" alt="">
              </div>
              <div class="d-flex justify-content-end mt-5">
                <div class="col-12 col-md-9">
                  <div class="text-center text-white" data-aos="zoom-in-down" style="font-size: 2rem; font-weight: bold">🔥 Hot <span style="color: var(--magenta-pink)">Events</span></div>
                  <div class="row justify-content-center mt-3">
                    <div class="col-md-4 col-12 mt-3" data-aos="fade-right" data-aos-duration="800">
                      <div class="card card-neon bg-transparent overflow-hidden mt-4" style="box-shadow: 0 0 15px var(--magenta-pink)">
                        <img class="card-img-top img-fluid" src="{{ asset('images/gambar_events/concert/74cf50ca-623e-4be5-9ad4-5d4530e4e707.jpg') }}" style="height: calc(0.25rem * 48)">
                        <div class="card-body">
                          <h2 class="d-block text-white">Konser EDM Galaxy 2025</h2>
                          <small class="text-light">Jakarta • 12 Okt 2025</small>

                          <button onclick="window.location.href='{{ route('tickets.show', 1) }}'" 
                          class="btn btn-block btn-gradient-magenta-purple mt-3">Beli Tiket</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-12" data-aos="fade-up" data-aos-duration="800">
                      <div class="card card-neon bg-transparent overflow-hidden mt-4 shadow-yellow " >
                        <img class="card-img-top img-fluid" src="{{ asset('images/gambar_events/concert/74cf50ca-623e-4be5-9ad4-5d4530e4e707.jpg') }}" style="height: calc(0.25rem * 48)">
                        <div class="card-body">
                          <h2 class="d-block text-white">Konser EDM Galaxy 2025</h2>
                          <small class="text-light">Jakarta • 12 Okt 2025</small>

                          <button onclick="window.location.href='{{ route('tickets.show', 1) }}'" 
                          class="btn btn-block btn-gradient-magenta-purple mt-3">Beli Tiket</button>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 col-12 mt-3" data-aos="fade-left" data-aos-duration="800">
                      <div class="card card-neon bg-transparent overflow-hidden mt-4" >
                        <img class="card-img-top img-fluid" src="{{ asset('images/gambar_events/concert/74cf50ca-623e-4be5-9ad4-5d4530e4e707.jpg') }}" style="height: calc(0.25rem * 48)">
                        <div class="card-body">
                          <h2 class="d-block text-white">Konser EDM Galaxy 2025</h2>
                          <small class="text-light">Jakarta • 12 Okt 2025</small>

                          <button onclick="window.location.href='{{ route('tickets.show', 1) }}'" 
                          class="btn btn-block btn-gradient-magenta-purple mt-3">Beli Tiket</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>


  <!-- Fab Button -->
  {{-- <button class="btn btn-fab btn-info" title="Panduan" onclick="Ryuna.helpModal(`{{ isset($help_key) ? $help_key: '' }}`)">
    <i class="fas fa-question"></i>
  </button> --}}

  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>

  <!-- Optional JS -->
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
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script>
    AOS.init();
    // var typed = new Typed('.hero-title', {
    //   strings: ['<span style="color:#00FFFF;">Temukan</span> & <span style="color:#FF00FF;">Beli Tiket</span> <span style="color:#FFD700;">Konser Favoritmu</span>'],
    //   typeSpeed: 50,
    //   onComplete: function(self) {
    //     $('.typed-cursor.typed-cursor--blink').hide()
    //     new Typed('.hero-subtitle', {
    //       strings: ['Dari konser lokal hingga internasional. Semua tiket resmi, cepat, dan praktis di NgeventYuk.'],
    //       typeSpeed: 1,
    //       onComplete: function(){
    //         $('.typed-cursor.typed-cursor--blink').hide()
    //       }
    //     });
    //   }
    // });

  </script>
</body>

</html>
