@extends('auth.parent')

@section('content')
  <div class="row justify-content-center align-items-center" style="height: 100vh">
    <div class="col-md-4">
      <div class="card card-neon bg-transparent mt-5">
        <div class="card-body">
          <div class="text-center" style="color: var(--cyan-300); font-size: 2rem; font-weight: bold">Ngevent<span style="color: var(--magenta-pink)">Yuk</span></div>
          <div class="text-center text-light text-sm">Masuk ke akunmu</div>
          <div id="response_container" class="my-3"></div>
          <form action="{{ route('auth.login_process') }}" method="post" id="myForm">
            @csrf

            <div class="form-group">
              <label for="username" class="text-white">Username</label>
              <input type="text" name="username" id="username" class="form-control bg-dark border-dark text-light" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="username" class="text-white">Password</label>
              <input type="password" name="password" id="password" class="form-control bg-dark border-dark text-light" autocomplete="off">
            </div>
            <div class="form-group mt-5 mb-3">
              <button type="button" class="btn btn-block btn-gradient-cyan-magenta" id="btn-submit" onclick="save()">Login</button>
            </div>
          </form>
          <div class="form-group">
            <span class="text-light">Belum Punya Akun?</span> <a href="{{ route('auth.register') }}" style="color: var(--cyan-300)" >Daftar Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    function save(){
      $('#response_container').empty();
      $('#btn-submit').prop('disabled', true)
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

          setTimeout(() => {
            $('#btn-submit').prop('disabled', false)
            window.location.href = `{{ route('dashboard.index') }}`
          }, 1000);
        }
      }).fail((xhr) => {
        $('#btn-submit').prop('disabled', false)
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
  </script>
@endsection
