@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">คำขอรับบริการหน่วยรับรอง (CB)</h3>
                    @if( HP::CheckPermission('view-'.str_slug('applicantcbs')))
                        <a class="btn btn-success pull-right" href="{{ url("certify/applicant-cb") }}" >
                            <i class="icon-arrow-left-circle"></i> กลับ
                        </a>
                    @endif
                    <div class="clearfix"></div>
                    <hr>

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($certi_cb, [
                        'method' => 'PATCH',
                        'url' => ['/certify/applicant-cb', $certi_cb->token],
                        'class' => 'form-horizontal',
                        'files' => true,
                        'id'=>'app_certi_form'
                    ]) !!}
                      <div id="box-readonly">
                        {{-- @include ('certify.applicant_cb/from.form01')
                        @include ('certify.applicant_cb/from.form02') --}}
                        {{-- @include ('certify.applicant_cb/from.form03') --}}
                        {{-- @include ('certify.applicant_cb/from.form04')
                        @include ('certify.applicant_cb/from.form05')
                        @include ('certify.applicant_cb/from.form06')
                        @include ('certify.applicant_cb/from.form07') --}}
                        @include ('certify.applicant_cb.form')
                      </div>

                     <div class="row">
                      <div class="col-md-12">
                          <a  href="{{url('certify/applicant-cb')}}">
                              <div class="alert alert-dark text-center" role="alert">
                                  <b>กลับ</b>
                              </div>
                          </a>
                       </div>
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
            $('#box-readonly').find('input, select, textarea').prop('disabled', true);
            $('#box-readonly').find('button').remove();
            $('#box-readonly').find('.box_remove_file').remove();
        });
    </script>

@endpush
