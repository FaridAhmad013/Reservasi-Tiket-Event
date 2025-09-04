@extends('pages.pengguna.parent')

@section('title', $module_name)

@section('styles')
<style>

  .nav-item-custom{
    background-color: var(--dark-navy);
    border-radius: 1rem;
    transition: all 0.3s ease;
    border: 1px solid var(--dark-navy) !important;
    color: white;
  }

  .nav-item-custom.active{
    color: var(--electric-purple) !important;
    border: 1px solid var(--electric-purple) !important;
  }
  .nav-item-custom:hover{
    color: var(--electric-purple) !important;
    border: 1px solid var(--electric-purple) !important;
  }
</style>
@endsection

@section('breadcrum')
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-white d-inline-block mb-0">Pesanan Saya</h6>
  </div>
@endsection

@section('body')
<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card" style="background: #1E1E2F; box-shadow: none; border: none">
      <div class="card-header">
         <div class="row align-items-center ml-1">
          <div class="p-1">
            <a href="{{ route($module . '.index') }}" class="text-white">Status Pesanan</a>
          </div>
          <a  href="javascript:filter_status('semua')" data-status-pesanan="semua" class="nav-item-custom active px-3 py-1 m-1" style="cursor: pointer">Semua</a>
          <a  href="javascript:filter_status('menunggu persetujuan')" data-status-pesanan="menunggu persetujuan" class="nav-item-custom px-3 py-1 m-1" style="cursor: pointer">Menunggu Persetujuan</a>
          <a  href="javascript:filter_status('disetujui')" data-status-pesanan="disetujui" class="nav-item-custom px-3 py-1 m-1" style="cursor: pointer">Disetujui</a>
          <a  href="javascript:filter_status('ditolak')" data-status-pesanan="ditolak" class="nav-item-custom px-3 py-1 m-1" style="cursor: pointer">Ditolak</a>
          <a  href="javascript:filter_status('dibatalkan')" data-status-pesanan="dibatalkan" class="nav-item-custom px-3 py-1 m-1" style="cursor: pointer">Dibatalkan</a>

        </div>
      </div>
      <div class="card-body" id="box-aw">
        @include('admin.alert')

        <div class="overflow-auto p-2" id="wrap-list-pesanan">

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let _url = {
    get_list_pesanan: "{{ route($module.'.get_list_pesanan') }}",
    batalkan: "{{ route($module.'.batalkan', ':id') }}",
    cetak_kartu: "{{ route($module.'.cetak_kartu', ':id') }}"
  }

  let table;

  $(() => {
    get_list_pesanan('semua')
  })

  function filter_status(status){
    $(`.nav-item-custom`).removeClass('active')
    $(`.nav-item-custom[data-status-pesanan="${status}"]`).toggleClass('active')

    get_list_pesanan(status)
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

  function get_list_pesanan(status){
    Ryuna.blockElement('#wrap-list-pesanan')
    $('#wrap-list-pesanan').empty()
    $.get(_url.get_list_pesanan, {
        status: status
    }).done((res) => {
      const data = res?.data ?? []

      data.map(item => {
        $('#wrap-list-pesanan').append(`
          <div class="card card-neon overflow-hidden mb-2" style="background-color: #1E1E2F !important;">
            <div class="card-header" style="background-color: #1E1E2F !important;">
              <span class="text-white">${item?.event?.nama_event}</span> - ${Ryuna.status_transaksi(item?.status_transaksi)} - <span class="text-white">${item.nomor_transaksi}</span>
            </div>
            <div class="card-body" style="background-color: #1E1E2F !important;">
              <div class="row justify-content-between">
                <div class="col-md-9">
                  <h3 class="text-white">${item?.detail_event.area}</h3>
                  <h4 class="text-white">${item?.kuantitas} tiket x ${Ryuna.format_nominal(item?.detail_event.harga)}</h4>
                </div>
                <div class="col col-md-3 col-lg-2">
                  <div class="text-white">Total Harga</div>
                  <b class="text-white">${Ryuna.format_nominal(item.total_harga)}</b>
                </div>
              </div>
            </div>
            <div class="card-footer" style="background-color: #1E1E2F !important;">
              <div class="row justify-content-end">
                ${item?.status_transaksi == 'menunggu persetujuan' ? `<button class="btn btn-danger" onclick="batalkan('${item.id}')" type="button">Batalkan</button>` : ''}
                ${item?.status_transaksi == 'disetujui' ? `<button class="btn btn-primary" onclick="cetak_kartu('${item.id}')" type="button">Cetak Kartu</button>` : ''}
              </div>
            </div>
          </div>
        `)
      })
      Ryuna.unblockElement('#wrap-list-pesanan')
    }).fail((xhr) => {
      Ryuna.unblockElement('#wrap-list-pesanan')
      Ryuna.noty('error', (xhr?.responseJSON?.message ?? 'Terjadi Kesalahan Internal'), '')
    })
  }


  function batalkan(id){
     Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Transaksi yang dipilih akan dibatalkan!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $.get(_url.batalkan.replace(':id', id)).done((res) => {
          Ryuna.noty("success", "", res.message)
          get_list_pesanan()
        }).fail((xhr) => {
          Ryuna.noty('error', (xhr?.responseJSON?.message ?? 'Terjadi Kesalahan Internal'), '')
        })
      }
    })
  }

  function cetak_kartu(id){
    window.location.href = _url.cetak_kartu.replace(':id', id)
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
