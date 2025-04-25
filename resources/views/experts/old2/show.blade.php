@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <!-- .row -->
  <div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title pull-left"><i class="mdi mdi-book"></i>รายละเอียดผู้เชี่ยวชาญ</h3>
        @can('view-'.str_slug('experts'))
        <a class="btn btn-success pull-right" href="{{ url('/experts') }}">
          <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
        </a>
        @endcan
        <div class="clearfix"></div>
        <hr>

        {!! Form::model($expert, [
        'method' => 'POST',
        'url' => ['/experts/detail'],
        'class' => 'form-horizontal',
        'files' => true
        ]) !!}

        <div id="box-readonly">

          @include ('experts.form')

        </div>

        {!! Form::close() !!}

      </div>
    </div>
  </div>
</div>

@endsection

@push('js')

<script>
  $(document).ready(function() {
    // จัดการข้อมูลในกล่องคำขอ false
    $('#box-readonly').find('button[type="submit"]').remove();
    $('#box-readonly').find('.icon-close').parent().remove();
    $('#box-readonly').find('.fa-copy').parent().remove();
    $('#box-readonly').find('.hide_attach').hide();
    $('#box-readonly').find('input').prop('disabled', true);
    $('#box-readonly').find('input').prop('disabled', true);
    $('#box-readonly').find('textarea').prop('disabled', true);
    $('#box-readonly').find('select').prop('disabled', true);
    $('#box-readonly').find('.bootstrap-tagsinput').prop('disabled', true);
    $('#box-readonly').find('span.tag').children('span[data-role="remove"]').remove();
    $('#box-readonly').find('button').prop('disabled', true);
    $('#box-readonly').find('button').remove();
    $('#box-readonly').find('button').remove();
    $('body').on('click', '.attach-remove', function() {
      $(this).parent().parent().parent().find('input[type=hidden]').val('');
      $(this).parent().remove();
    });
  });
</script>

@endpush