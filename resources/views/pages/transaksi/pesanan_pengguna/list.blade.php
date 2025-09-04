@extends('admin.parent')

@section('title', $module_name)

@section('styles')
<style>
  .avatar{
    object-fit: cover;
  }
</style>
@endsection

@section('breadcrum')
<div class="col-lg-6 col-7">
  <h6 class="h2 text-white d-inline-block mb-0">{{ $group }}</h6>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item"><a href="{{ route($module.'.index') }}"><i class="{{ $icon }}"></i></a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('event.index') }}">Event</a></li>
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
                <th>Nomor Transaksi</th>
                <th>Bukti Transaksi</th>
                <th>Status Transaksi</th>
                <th>Kuantitas</th>
                <th>Total harga</th>
                <th>approved at</th>
                <th>approved by</th>
                <th>rejected at</th>
                <th>rejected by</th>
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
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script>
  let _url = {
    datatable: `{{ route('datatable.'.$module) }}`,
    show_gambar: `{{ route($module.'.show_gambar', ':id') }}`,
    modal: `{{ route($module.'.modal') }}`,
  }

  let table;

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

    table = $(".dt-wow").DataTable({
      language: {
        search: `<i class="fas fa-search"></i>`,
        infoFiltered: ``
      },
      dom: "<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
      order: [[0, 'asc']],
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
          data: 'nomor_transaksi'
        },
        {
          data: 'bukti_transaksi'
        },
        {
          data: 'status_transaksi'
        },
        {
          data: 'kuantitas'
        },
        {
          data: 'total_harga'
        },
        {
          data: 'approved_at'
        },
        {
          data: 'approved_by'
        },
        {
          data: 'rejected_at'
        },
        {
          data: 'rejected_by'
        },
      ],
      scrollY: (Ryuna.heightWindow() <= 660 ? 500 : (Ryuna.heightWindow() - 426)),
      scrollX: true
    });
  })

  function modal(id, status){
    Ryuna.blockUI()
    $.get(_url.modal+'?id='+id+'&status='+status).done((res) => {
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
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Terjadi Kesalahan Internal',
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
</script>
@endsection
