<div class="row">
  <div class="form-group col-md-12">
    <label>Anda yakin untuk "{{$label}}" data ini?</label>
    <input type="hidden" name="otp" class="form-control" placeholder="OTP">
  </div>
  <div class="form-group col-md-12">
    <div id="response_container"></div>
  </div>
</div>

<script>
  function action(id, status){
    $('#response_container').empty();
    Ryuna.blockElement('.modal-content');
    let el_form = $('#myForm')
    let target = (status == 1 ? `{{ route($module.'.approve', ':id')."?status=:status" }}` : `{{ route($module.'.reject', ':id')."?status=:status" }}`).replace(':status', status).replace(':id', id)
    let otp = $('[name="otp"]').val()

    $.ajax({
      url: target,
      data: {
        otp: otp
      },
      type: 'GET',
    }).done((res) => {
      if(res?.status == true){
        let html = '<div class="alert alert-success alert-dismissible fade show">'
        html += `${res?.message}`
        html += '</div>'
        Ryuna.noty('success', '', res?.message)
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
        table.draw()
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
        html += `${xhr?.responseJSON?.message ?? 'Terjadi Kesalahan Internal'}`
        html += '</div>'
        Ryuna.noty('error', '', xhr?.responseJSON?.message ?? 'Terjadi Kesalahan Internal')
        $('#response_container').html(html)
        Ryuna.unblockElement('.modal-content')
      }
    })
  }
</script>
