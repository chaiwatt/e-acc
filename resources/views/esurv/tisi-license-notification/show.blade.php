@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แจ้งข้อมูลใบอนุญาต #{{ $license->id }}</h3>
                    @can('view-'.str_slug('tisi-license-notification'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/tisi_license_notification') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
                        </a>
                    @endcan
                    <div class="clearfix"></div>
                    <hr>

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($license, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/tisi_license_notification', $license->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}
                        <div id="box_readonly">
                       @include ('esurv.tisi-license-notification.form')
                      @if(!is_null($license->updated_by) && $license->updated_by !=  auth()->user()->getKey())
                       <hr>
                      <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                        {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          {!! Form::select('state',
                            ['0' => 'ฉบับร่าง', '1' => 'รอดำเนินการ', '2' => 'อยู่ระหว่างดำเนินการ', '3' => 'ปิดเรื่อง'],
                          !empty($license->state) ? $license->state : '1',
                          ['class' => 'form-control list_disabled',
                            'placeholder'=>'-เลือกสถานะ-']); !!}
                          {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('remake') ? 'has-error' : ''}}">
                          {!! Form::label('remake', 'ความคิดเห็นเพิ่มเติม:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                              {!! Form::textarea('remake', null, ['class' => 'form-control list_disabled', 'rows'=>'3']) !!}
                          </div>
                        </div>
                        <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                          {!! Form::label('', 'พิจารณา:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                              {!! Form::text('', !empty($license->Staff_updated->FullName) ?  $license->Staff_updated->FullName : null, ['class' => 'form-control','disabled'=>true]) !!}
                              {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                            {!! Form::label('', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('', !empty($license->Staff_updated->reg_phone) ?  $license->Staff_updated->reg_phone : null, ['class' => 'form-control','disabled'=>true]) !!}
                                {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                          <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                            {!! Form::label('', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('', !empty($license->Staff_updated->reg_email) ?  $license->Staff_updated->reg_email : null, ['class' => 'form-control','disabled'=>true]) !!}
                                {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>
                        @endif
                      </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        jQuery(document).ready(function() {
           // จัดการข้อมูลในกล่องคำขอ false
            $('#box_readonly').find('button[type="submit"]').remove();
            $('#box_readonly').find('.icon-close').parent().remove();
            $('#box_readonly').find('.fa-copy').parent().remove();
            $('#box_readonly').find('.list_attach').hide();
            $('#box_readonly').find('input').prop('disabled', true);
            $('#box_readonly').find('input').prop('disabled', true);
            $('#box_readonly').find('textarea').prop('disabled', true);
             $('#box_readonly').find('select').prop('disabled', true);
             $('#box_readonly').find('.bootstrap-tagsinput').prop('disabled', true);
             $('#box_readonly').find('span.tag').children('span[data-role="remove"]').remove();
             $('#box_readonly').find('button').prop('disabled', true);
             $('#box_readonly').find('button').remove();
             $('#box_readonly').find('button').remove();
            $('body').on('click', '.attach-remove', function() {
                $(this).parent().parent().parent().find('input[type=hidden]').val('');
                $(this).parent().remove();
            });
        });
    </script>

@endpush
