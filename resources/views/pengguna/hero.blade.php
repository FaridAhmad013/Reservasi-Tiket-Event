<style>
  .btn-lihat-event{
    background: linear-gradient(360deg, var(--neon-cyan), var(--magenta-pink));
    background-size: 400% 400%;
    animation: gradientShift 2s ease infinite;
    box-shadow: 0 0 15px #00FFFF;
    color: var(--off-white);
  }
  @keyframes gradientShift {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
</style>
<!-- Hero -->
<div class="p-5 text-center bg-image rounded-3" style="
    background-image: url('{{ asset('assets/img/theme/wallpaper-1.jpg') }}');
    background-size: cover;
    background-position: inherit;
    background-repeat: no-repeat;
    height: 650px;
  ">
  {{-- <div class="mask"> --}}
  <div class="mask" style="background-color: rgba(0, 0, 0, 0.1);">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="text-white">
        <h1 class="mb-3 font-lora hero-title" style="color: var(--off-white)"><span style="color:#00FFFF;">Temukan</span> & <span style="color:#FF00FF;">Beli Tiket</span> <span style="color:#FFD700;">Konser Favoritmu</span></h1>
        <h2 class="mb-3 font-lora hero-subtitle" style="color: var(--off-white)">Dari konser lokal hingga internasional. Semua tiket resmi, cepat, dan praktis di NgeventYuk.</h2>
        <a data-mdb-ripple-init class="btn btn-lg btn-lihat-event" href="{{ route('dashboard.index')}}" role="button">Lihat Event</a>
      </div>
    </div>
  </div>
</div>
<!-- Hero -->
