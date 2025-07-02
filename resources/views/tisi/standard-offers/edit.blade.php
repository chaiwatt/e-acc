@extends('layouts.master')

@push('css')
    <link href="{{ asset('plugins/components/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css') }}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .label-filter {
            margin-top: 7px;
        }

        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin: 0 0 1rem 0;
            }

            tr:nth-child(odd) {
                background: #eee;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }

            td:nth-of-type(1):before { content: "No.:"; }
            td:nth-of-type(2):before { content: "เลือก:"; }
            td:nth-of-type(3):before { content: "ชื่อ-สกุล:"; }
            td:nth-of-type(4):before { content: "เลขประจำตัวประชาชน:"; }
            td:nth-of-type(5):before { content: "หน่วยงาน:"; }
            td:nth-of-type(6):before { content: "สาขา:"; }
            td:nth-of-type(7):before { content: "ประเภทของคณะกรรมการ:"; }
            td:nth-of-type(8):before { content: "ผู้สร้าง:"; }
            td:nth-of-type(9):before { content: "วันที่สร้าง:"; }
            td:nth-of-type(10):before { content: "สถานะ:"; }
            td:nth-of-type(11):before { content: "จัดการ:"; }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <h3 class="box-title pull-left">แก้ไขการเสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง #{{ $offer->id }}</h3>

                    <div class="pull-right">
                        @if( HP::CheckPermission('add-'.str_slug('applicantcbs')))
                            <a class="btn btn-info btn-sm waves-effect waves-light" href="{{ url('tisi/standard-offers') }}">
                                <span class="btn-label"><i class="icon-arrow-left-circle"></i></span><b>กลับ</b>
                            </a>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    {!! Form::model($offer, ['url' => '/tisi/standard-offers/' . $offer->id . '/update', 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="container">
                            <h3 class="mb-4">ผู้ยื่นข้อเสนอ (Proposer)</h3>
                            <div class="row">
                                <!-- คอลัมน์ที่ 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ชื่อหน่วยงาน</label>
                                        <p>{{ $department->title ?? $offer->department ?? 'ไม่พบข้อมูล' }}</p>
                                    </div>

                                    <div class="form-group required {{ $errors->has('tel') ? 'has-error' : '' }}">
                                        {!! Form::label('tel', 'เบอร์โทร', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('tel', old('tel', $offer->telephone), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                             
                                    <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                                        {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('email', old('email'), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group required {{ $errors->has('tel') ? 'has-error' : '' }}">
                                        {!! Form::label('tel', 'โทรศัพท์', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('tel', old('tel', $department->tel), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- คอลัมน์ที่ 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ที่อยู่</label>
                                        <p>{{ $addressInfo ?? 'ไม่พบข้อมูล' }}</p>
                                    </div>

                                    <div class="form-group {{ $errors->has('fax') ? 'has-error' : '' }}">
                                        {!! Form::label('fax', 'แฟกซ์', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('fax', old('fax', $department->fax), ['class' => 'form-control']) !!}
                                            {!! $errors->first('fax', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                                        {!! Form::label('mobile', 'มือถือ', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('mobile', old('mobile', $department->mobile), ['class' => 'form-control']) !!}
                                            {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                                        {!! Form::label('name', 'ผู้ประสานงาน', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <h3 class="mb-4">รายละเอียดมาตรฐาน</h3>
                            <div class="row">
                                <!-- คอลัมน์ที่ 1 -->
                                <div class="col-md-6">
                                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                                        {!! Form::label('title', 'ชื่อเรื่อง : ', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('title', old('title', $offer->title), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group required {{ $errors->has('std_type') ? 'has-error' : '' }}">
                                        {!! Form::label('std_type', 'ประเภทมาตรฐาน : ', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::select('std_type', App\Models\Bcertify\Standardtype::orderByRaw('CONVERT(offertype USING tis620)')->pluck('offertype', 'id'), old('std_type', $offer->std_type), ['class' => 'form-control', 'placeholder' => '- เลือกประเภทมาตรฐาน -', 'required' => 'required']) !!}
                                            {!! $errors->first('std_type', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group required {{ $errors->has('objectve') ? 'has-error' : '' }}">
                                        {!! Html::decode(Form::label('objectve', 'จุดประสงค์และเหตุผล : ', ['class' => 'control-label'])) !!}
                                        <div>
                                            {!! Form::text('objectve', old('objectve', $offer->objectve), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('objectve', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- คอลัมน์ที่ 2 -->
                                <div class="col-md-6">
                                    <div class="form-group required {{ $errors->has('title_eng') ? 'has-error' : '' }}">
                                        {!! Form::label('title_eng', 'ชื่อเรื่อง (Eng) : ', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('title_eng', old('title_eng', $offer->title_eng), ['class' => 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('title_eng', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('scope') ? 'has-error' : '' }}">
                                        {!! Form::label('scope', 'ขอบข่าย : ', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('scope', old('scope', $offer->scope), ['class' => 'form-control']) !!}
                                            {!! $errors->first('scope', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('stakeholders') ? 'has-error' : '' }}">
                                        {!! Form::label('stakeholders', 'ผู้มีส่วนได้เสียที่เกี่ยวข้อง : ', ['class' => 'control-label']) !!}
                                        <div>
                                            {!! Form::text('stakeholders', old('stakeholders', $offer->stakeholders), ['class' => 'form-control']) !!}
                                            {!! $errors->first('stakeholders', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group {{ $errors->has('attach_file') ? 'has-error' : '' }}">
                                        {!! Form::label('additional_documents', 'เอกสารเพิ่มเติม : ', ['class' => 'control-label']) !!}
                                        <div>
                                            <div class="form-group other_attach_item">
                                                <div class="col-md-6">
                                                    {!! Form::text('caption', old('caption', $offer->caption), ['class' => 'form-control', 'placeholder' => 'รายละเอียดเอกสาร']) !!}
                                                    {!! $errors->first('caption', '<p class="help-block">:message</p>') !!}
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename">{{ $offer->attach_file ? basename($offer->attach_file) : '' }}</span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">เลือกไฟล์</span>
                                                            <span class="fileinput-exists">เปลี่ยน</span>
                                                            <input type="file" name="attach_file" class="attach check_max_size_file">
                                                        </span>
                                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                    </div>
                                                    {!! $errors->first('attach_file', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="previousUrl" id="previousUrl" value="{{ app('url')->previous() }}">

                        <div class="form-group">
                            <div class="col-md-offset-5 col-md-6">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-paper-plane"></i> บันทึก
                                </button>
                                <a class="btn btn-default" href="{{ app('url')->previous() }}">
                                    <i class="fa fa-rotate-left"></i> ยกเลิก
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    @include('tisi.standard-offers.modal_department')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/components/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Form validation with Parsley
            if ($('form').length > 0 && $('form:first:not(.not_validated)').length > 0) {
                $('form:first:not(.not_validated)').parsley({
                    excluded: "input[type=button], input[type=submit], input[type=reset], [disabled], input[type=hidden]"
                }).on('field:validated', function() {
                    var ok = $('.parsley-error').length === 0;
                    $('.bs-callout-info').toggleClass('hidden', !ok);
                    $('.bs-callout-warning').toggleClass('hidden', ok);
                }).on('form:submit', function() {
                    $('form').find('button, input[type=button], input[type=submit], input[type=reset]').prop('disabled', true);
                    $('form').find('a').removeAttr('href');
                    return true;
                });
            }

            // File size validation
            check_max_size_file();

            // Department form submission
            $('#form_department').on('submit', function(event) {
                event.preventDefault();
                $('button[type="submit"]').attr('disabled', true);
                var form_data = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "{{ url('tisi/standard-offers/save_department') }}",
                    datatype: "script",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == "success") {
                            var opt = "<option value='" + data.id + "'>" + data.title + "</option>";
                            $('#exampleModalAppointDepartment').modal('hide');
                            $('button[type="submit"]').attr('disabled', false);
                            $('select#department_id').append(opt).trigger('change');
                        } else if (data.status == "error") {
                            $('button[type="submit"]').attr('disabled', false);
                            alert('บันทึกไม่สำเร็จ โปรดบันทึกใหม่อีกครั้ง');
                        } else {
                            alert('ระบบขัดข้อง โปรดตรวจสอบ !');
                        }
                    }
                });
            });

            function check_max_size_file() {
                var max_size = "{{ ini_get('upload_max_filesize') }}";
                var res = max_size.replace("M", "");
                $('.check_max_size_file').bind('change', function() {
                    if ($(this).val() != '') {
                        var size = (this.files[0].size) / 1024 / 1024; // MB
                        var file = this.files[0];
                        var filename = file.name;
                        $(this).closest('.fileinput').find('.fileinput-filename').text(filename);
                        if (size > res) {
                            Swal.fire(
                                'ขนาดไฟล์เกินกว่า ' + res + ' MB',
                                '',
                                'info'
                            );
                            $(this).parent().parent().find('.fileinput-exists').click();
                            return false;
                        }
                    }
                });
            }

            @if(Session::has('message'))
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '{{ session()->get('message') }}',
                    loaderBg: '#70b7d6',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            @if(Session::has('message_error'))
                $.toast({
                    heading: 'Error!',
                    position: 'top-center',
                    text: '{{ session()->get('message_error') }}',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            // Datepicker initialization
            jQuery('#date-range').datepicker({
                toggleActive: true,
                language: 'th-th',
                format: 'dd/mm/yyyy'
            });
        });
    </script>
@endpush