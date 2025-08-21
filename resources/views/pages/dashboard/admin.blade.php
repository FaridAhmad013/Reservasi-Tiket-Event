@extends('admin.parent')

@section('title', 'Beranda')

@section('styles')

<style>
  .mini-calendar {
    font-size: 4px; /* Ukuran font kecil */
  }

  .mini-calendar .fc {
    font-size: 0.65rem;
  }

  .fc th{
    font-size: 0.6rem !important;
    padding: 2px !important;
  }
  .mini-calendar .fc-toolbar-title {
    font-size: 0.85rem;
  }

  .mini-calendar .fc-button {
    padding: 2px 6px;
    font-size: 0.65rem;
  }

  .mini-calendar .fc-daygrid-day-number {
    font-size: 0.6rem;
    padding: 2px;
  }

  .mini-calendar .fc-daygrid-day-frame {
    padding: 2px;
  }
</style>
@endsection

@section('breadcrum')
<div>
  <h1 class="font-lora font-weight-bold tracking-wide" style="font-size: 3rem">{{ @$ucapan }}</h1>
</div>
@endsection

@section('page')

<div class="row">
  <div class="col-12">
    <div class="card overflow-hidden" style="background: #1E1E2F; box-shadow: none; border: none">
      <div class="card-header" style="background: #1E1E2F">
        <h2 class="text-white neon-underline"><i class="fas fa-book-open"></i> Ringkasan</h2>
      </div>
      <div class="card-body" style="background: #1E1E2F">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-neon bg-transparent wrap-total_pengguna" style="box-shadow: 0 0 4px #00E5FF;">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3 class="text-white">Total Pengguna</h3>
                    <h1 class="text-white" id="total_pengguna">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-default shadow-default text-center rounded-circle">
                      <i class="fas fa-users text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-neon bg-transparent wrap-total_pertanyaan" style="box-shadow: 0 0 4px #FF00FF;">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3 class="text-white">Total Pertanyaan</h3>
                    <h1 class="text-white" id="total_pertanyaan">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-warning shadow-warning text-center rounded-circle">
                      <i class="fas fa-question text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-neon bg-transparent wrap-entry_jurnal_hari_ini" style="box-shadow: 0 0 4px #00FFFF;">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3 class="text-white">Entri Jurnal Hari Ini</h3>
                    <h1 class="text-white" id="total_entry_jurnal_hari_ini">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-info shadow-info text-center rounded-circle">
                      <i class="fas fa-calendar-check text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-neon bg-transparent wrap-pengguna_aktif" style="box-shadow: 0 0 4px #39FF14;">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3 class="text-white">Pengguna Aktif (Bulan Ini)</h3>
                    <h1 class="text-white" id="total_pengguna_aktif">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-success shadow-success text-center rounded-circle">
                      <i class="fas fa-chart-bar text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>
  let _url = {

  }
  $(document).ready(function() {
    get_total_pengguna()
    get_total_pertanyaan()
    get_total_entry_jurnal_hari_ini()
    get_total_pengguna_aktif()
  })

  function get_total_pengguna(){
    Ryuna.blockElement('.wrap-total_pengguna')
    $.get(_url.total_pengguna).done((res) => {
      $('#total_pengguna').text(res?.data?.total ?? 0)
      Ryuna.unblockElement('.wrap-total_pengguna')
    }).fail((xhr) => {
      Ryuna.unblockElement('.wrap-total_pengguna')
    })
  }

  function get_total_pertanyaan(){
    Ryuna.blockElement('.wrap-total_pertanyaan')
    $.get(_url.total_pertanyaan).done((res) => {
      $('#total_pertanyaan').text(res?.data?.total ?? 0)
      Ryuna.unblockElement('.wrap-total_pertanyaan')
    }).fail((xhr) => {
      Ryuna.unblockElement('.wrap-total_pertanyaan')
    })
  }

  function get_total_entry_jurnal_hari_ini(){
    Ryuna.blockElement('.wrap-entry_jurnal_hari_ini')
    $.get(_url.total_entry_jurnal_hari_ini).done((res) => {
      $('#total_entry_jurnal_hari_ini').text(res?.data?.total ?? 0)
      Ryuna.unblockElement('.wrap-entry_jurnal_hari_ini')
    }).fail((xhr) => {
      Ryuna.unblockElement('.wrap-entry_jurnal_hari_ini')
    })
  }

  function get_total_pengguna_aktif(){
    Ryuna.blockElement('.wrap-pengguna_aktif')
    $.get(_url.total_pengguna_aktif).done((res) => {
      $('#total_pengguna_aktif').text(res?.data?.total ?? 0)
      Ryuna.unblockElement('.wrap-pengguna_aktif')
    }).fail((xhr) => {
      Ryuna.unblockElement('.wrap-pengguna_aktif')
    })
  }
</script>
@endsection
