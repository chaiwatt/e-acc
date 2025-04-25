@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">คำขอรับบริการหน่วยรับรอง (CB) </h3>
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

                    {!! Form::open(['url' => '/certify/applicant-cb', 'class' => 'form-horizontal', 'files' => true,'id'=>'app_certi_form']) !!}

                        @include ('certify.applicant_cb.form')
                        {{-- @include ('certify.applicant_cb/from.form02') --}}
                        {{-- @include ('certify.applicant_cb/from.form03') --}}
                        {{-- @include ('certify.applicant_cb/from.form04')
                        @include ('certify.applicant_cb/from.form05')
                        @include ('certify.applicant_cb/from.form06')
                        @include ('certify.applicant_cb/from.form07') --}}

                        <div class="row form-group">
                            <div class="col-md-12 text-center">
                                <div id="status_btn"></div>
                                <button type="button"class="btn btn-default m-l-5" onclick="submit_form('1');return false" id="send_data" disabled>ส่งข้อมูล</button>
                                <button type="button" class="btn btn-warning text-white m-l-5 " onclick="submit_form_draft('0');return false">ฉบับร่าง</button>
                                <a href="{{ url("certify/applicant-cb") }}"  class="btn btn-danger text-white m-l-5" id="cancel_edit_calibrate">ยกเลิก</a>
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



        $(document).ready(function () {
           
            if($('input[name="branch_type"]').val() == 1){
                $('#use_address_office-1').iCheck('check');
            }else{
                $('#use_address_office-2').iCheck('check');
            }

        });
        
    </script>
@endpush
