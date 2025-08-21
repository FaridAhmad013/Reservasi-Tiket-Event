@extends('auth.parent')

@section('content')
  <div class="row justify-content-center align-items-center mt-5" style="min-height: 100vh">
    <div class="col-md-5">
      <div class="card card-neon bg-transparent">
        <div class="card-body">

          <div class="text-center" style="color: var(--cyan-300); font-size: 2rem; font-weight: bold">Ngevent<span style="color: var(--magenta-pink)">Yuk</span></div>
          <div class="text-light text-center">Buat Akun Baru</div>
          <div id="response_container" class="mt-5 mb-3"></div>
          <form action="{{ route('auth.register_process') }}" method="post" id="myForm">
            @csrf

            <div class="row flex-wrap">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="text-light" for="nama_depan">Nama Depan</label>
                  <input type="text" name="nama_depan" id="nama_depan" class="form-control bg-dark border-dark text-light" autocomplete="off">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="text-light" for="nama_belakang">Nama Belakang</label>
                  <input type="text" name="nama_belakang" id="nama_belakang" class="form-control bg-dark border-dark text-light" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="text-light" for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control bg-dark border-dark text-light" autocomplete="off">
            </div>

            <div class="form-group">
              <label class="text-light" for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control bg-dark border-dark text-light" autocomplete="off">
            </div>


            <div class="form-group">
              <label class="text-light" for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control bg-dark border-dark text-light" autocomplete="off">
            </div>

            <div class="form-group">
              <label class="text-light" for="password_confirmation">Ulangi Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-dark border-dark text-light" autocomplete="off">
            </div>
            <div class="form-group mt-5 mb-3">
              <button type="button" class="btn btn-gradient-cyan-magenta btn-block" onclick="save()">Register</button>
            </div>
          </form>
          <div class="form-group mt-3">
            <span class="text-light">Sudah Punya Akun?</span> <a href="{{ route('auth.login') }}" style="color: var(--cyan-300)">Login</a>
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
            window.location.href = `{{ route('auth.login') }}`
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
