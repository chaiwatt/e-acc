{{-- @extends('layouts.master')

@section('content')
<div class="container-fluid">
  <!-- .row -->
  <div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title pull-left">รายละเอียดการแจ้งข้อมูลอื่นๆ {{ $other->id }}</h3>
        @can('view-'.str_slug('other'))
        <a class="btn btn-success pull-right" href="{{ url('/esurv/other') }}">
          <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
        </a>
        @endcan
        <div class="clearfix"></div>

        <div class="table-responsive">
          <table class="table table">
            <tbody>
              <tr>
                <th>ID</th>
                <td>{{ $other->id }}</td>
              </tr>
              <tr>
                <th> เรื่อง </th>
                <td> {{ $other->title }} </td>
              </tr>
              <tr>
                <th> ประเภทการแจ้ง </th>
                <td> {{ HP::OtherTypes()[$other->inform_type] }} </td>
              </tr>
              <tr>
                <th> รายละเอียด </th>
                <td> {{ $other->detail }} </td>
              </tr>
              <tr>
                <th> ชื่อผู้บันทึก </th>
                <td> {{ $other->applicant_name }} </td>
              </tr>
              <tr>
                <th> เบอร์โทร </th>
                <td> {{ $other->tel }} </td>
              </tr>
              <tr>
                <th> อีเมล </th>
                <td> {{ $other->email }} </td>
              </tr>
              <tr>
                <th> สถานะ </th>
                <td> 
                @php
                   $status_css = ['0'=>'label-warning','1'=>'label-info', '2'=>'label-success', '3'=>'label-danger'];
                   $status_receive  =  ['0' => 'ฉบับร่าง', '1' => 'รอดำเนินการ', '2' => 'อยู่ระหว่างดำเนินการ', '3' => 'ปิดเรื่อง'];
                @endphp
                @if(array_key_exists($other->state,$status_css) && array_key_exists($other->state,$status_receive))
                  <span class="label {{ $status_css[$other->state] }}">
                     <b>{{ $status_receive[$other->state] }}</b>
                 </span>
               @else 
                  <span class="label label-info">
                     <b>รอดำเนินการ</b>
                 </span>
               @endif
                
                </td>
              </tr>
              <tr>
                <th> ผู้สร้าง </th>
                <td> {{ $other->createdName }} </td>
              </tr>
              <tr>
                <th> เบอร์โทร </th>
                <td>  {{ !empty($other->user_created->trader_mobile) ? $other->user_created->trader_mobile : '-' }} </td>
              </tr>
              <tr>
                <th> E-mail </th>
                <td> {{ !empty($other->user_created->agent_email) ? $other->user_created->agent_email : '-' }} </td>
              </tr>
              <tr>
                <th> วันเวลาที่สร้าง </th>
                <td> {{ HP::DateTimeThai($other->created_at) }} </td>
              </tr>
              <tr>
                <th> ผู้แก้ไข </th>
                <td> {{  !empty($other->updatedName) ? $other->updatedName : '-'  }} </td>
              </tr>
              <tr>
                <th> เบอร์โทร </th>
                <td>  {{ !empty($other->user_updated->trader_mobile) ? $other->user_updated->trader_mobile : '-' }} </td>
              </tr>
              <tr>
                <th> E-mail </th>
                <td> {{ !empty($other->user_updated->agent_email) ? $other->user_updated->agent_email : '-' }} </td>
              </tr>
              <tr>
                <th> วันเวลาที่แก้ไข </th>
                <td> {{ HP::DateTimeThai($other->updated_at) }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection --}}
@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขการแจ้งข้อมูลอื่นๆ #{{ $other->id }}</h3>
                    @can('view-'.str_slug('other'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/other') }}">
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

                    {!! Form::model($other, [
                        'method' => 'PATCH',
                        'url' => ['/esurv/other', $other->id],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}
                      <div id="box-readonly">
                          @include ('esurv.other.form')
                      </div>

                      @if(!is_null($other->updated_by) && $other->updated_by !=  auth()->user()->getKey())
                      <hr>
                     <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                       {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
                       <div class="col-md-6">
                         {!! Form::select('state',
                         ['0' => 'ฉบับร่าง', '1' => 'รอดำเนินการ', '2' => 'อยู่ระหว่างดำเนินการ', '3' => 'ปิดเรื่อง'], 
                         !empty($other->state) ? $other->state : '1',
                         ['class' => 'form-control',
                         'disabled' =>true,
                           'placeholder'=>'-เลือกสถานะ-']); !!}
                         {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
                       </div>
                     </div>
                     <div class="form-group {{ $errors->has('remake') ? 'has-error' : ''}}">
                         {!! Form::label('remake', 'ความคิดเห็นเพิ่มเติม:', ['class' => 'col-md-4 control-label']) !!}
                         <div class="col-md-6">
                             {!! Form::textarea('remake', null, ['class' => 'form-control', 'rows'=>'3','disabled' =>true]) !!}
                         </div>
                       </div>
                       <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                         {!! Form::label('', 'พิจารณา:', ['class' => 'col-md-4 control-label']) !!}
                         <div class="col-md-6">
                             {!! Form::text('', !empty($other->Staff_updated->FullName) ?  $other->Staff_updated->FullName : null, ['class' => 'form-control','disabled'=>true]) !!}
                             {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                         </div>
                       </div>
                       <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                        {!! Form::label('', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('', !empty($other->Staff_updated->reg_phone) ?  $other->Staff_updated->reg_phone : null, ['class' => 'form-control','disabled'=>true]) !!}
                            {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div>
                      <div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
                        {!! Form::label('', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('', !empty($other->Staff_updated->reg_email) ?  $other->Staff_updated->reg_email : null, ['class' => 'form-control','disabled'=>true]) !!}
                            {!! $errors->first('', '<p class="help-block">:message</p>') !!}
                        </div>
                      </div>
                       @endif
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
            $('#box-readonly').find('button[type="submit"]').remove();
            $('#box-readonly').find('.icon-close').parent().remove();
            $('#box-readonly').find('.fa-copy').parent().remove();
            $('#box-readonly').find('.data_hide').hide();
            $('#box-readonly').find('input').prop('disabled', true);
            $('#box-readonly').find('textarea').prop('disabled', true);
             $('#box-readonly').find('select').prop('disabled', true);
             $('#box-readonly').find('.bootstrap-tagsinput').prop('disabled', true);
             $('#box-readonly').find('span.tag').children('span[data-role="remove"]').remove();
             $('#box-readonly').find('button').prop('disabled', true);
             $('#box-readonly').find('button').remove();

            $('body').on('click', '.attach-remove', function() {
                $(this).parent().parent().parent().find('input[type=hidden]').val('');
                $(this).parent().remove();
            });


        });
    </script>
     
@endpush
