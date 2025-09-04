@extends('admin.parent')

@section('title', 'Beranda')

@section('styles')

<style>
  .mini-calendar {
    font-size: 10px; /* Ukuran font kecil */
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

  .fc .selected-circle {
    background: red;
    border-radius: 50% !important;
    opacity: 0.3;
  }
</style>
@endsection

@section('breadcrum')
@endsection

@section('page')

@endsection

@section('scripts')

<script>
  let _url = {

  }

  $(() => {
  })
  $(document).ready(function() {


  })

</script>
@endsection
