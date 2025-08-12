@extends('layouts.master')

@push('css')
    {{-- Add your CSS links here --}}
    <style>
        .form-group { margin-bottom: 25px; }
        .control-label { font-weight: bold; margin-bottom: 5px; display: block; }
        .white-box { padding: 25px; }
        .mb-4 { margin-bottom: 2rem; }
        hr { margin-top: 20px; margin-bottom: 20px; border-top: 1px solid #eee; }
        .help-block { color: #a94442; }
        .form-control[readonly], .form-control[disabled] {
             background-color: #eee;
             opacity: 1;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title pull-left">แก้ไขการเสนอความเห็นฯ #{{ $offer->id }}</h3>
                <div class="pull-right">
                    <a class="btn btn-info btn-sm waves-effect waves-light" href="{{ url('tisi/standard-offers') }}">
                        <span class="btn-label"><i class="icon-arrow-left-circle"></i></span><b>กลับ</b>
                    </a>
                </div>
                <div class="clearfix"></div>
                <hr>

                <form method="POST" action="{{ url('/tisi/standard-offers/' . $offer->id . '/update') }}" class="form-horizontal" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    {{-- Section: Proposer Info (Readonly) --}}
                    <h3 class="mb-4">ผู้ยื่นข้อเสนอ (Proposer)</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label class="control-label" style="text-align:left">ชื่อหน่วยงาน</label><input type="text" class="form-control" value="{{ $department->title ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">จังหวัด</label><input type="text" class="form-control" value="{{ $addressInfo['province'] ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">ตำบล/แขวง</label><input type="text" class="form-control" value="{{ $addressInfo['district'] ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">เบอร์โทร</label><input type="text" class="form-control" value="{{ $offer->tel ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">แฟกซ์</label><input type="text" class="form-control" value="{{ $department->fax ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">ผู้ประสานงาน</label><input type="text" class="form-control" value="{{ $offer->name ?? '' }}" readonly></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="control-label" style="text-align:left">ที่อยู่</label><input type="text" class="form-control" value="{{ $department->address ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">อำเภอ/เขต</label><input type="text" class="form-control" value="{{ $addressInfo['amphur'] ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">รหัสไปรษณีย์</label><input type="text" class="form-control" value="{{ $department->poscode ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">มือถือ</label><input type="text" class="form-control" value="{{ $department->mobile ?? '' }}" readonly></div>
                            <div class="form-group"><label class="control-label" style="text-align:left">E-mail</label><input type="text" class="form-control" value="{{ $offer->email ?? '' }}" readonly></div>
                        </div>
                    </div>
                    <hr>

                    {{-- Section: Standard Details (Editable) --}}
                    <h3 class="mb-4">รายละเอียดมาตรฐาน</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('title') ? 'has-error' : ''}}"><label for="title" class="control-label" style="text-align:left">ชื่อเรื่อง</label><input type="text" name="title" id="title" value="{{ old('title', $offer->title) }}" class="form-control" required>@if ($errors->has('title'))<p class="help-block">{{ $errors->first('title') }}</p>@endif</div>
                            <div class="form-group required {{ $errors->has('std_type') ? 'has-error' : '' }}"><label for="std_type" class="control-label" style="text-align:left">ประเภทมาตรฐาน</label><select name="std_type" id="std_type" class="form-control" required><option value="">- เลือกประเภทมาตรฐาน -</option>@foreach(App\Models\Bcertify\Standardtype::orderbyRaw('CONVERT(offertype USING tis620)')->pluck('offertype', 'id') as $id => $offertype)<option value="{{ $id }}" {{ (old('std_type', $offer->std_type) == $id) ? 'selected' : '' }}>{{ $offertype }}</option>@endforeach</select>@if ($errors->has('std_type'))<p class="help-block">{{ $errors->first('std_type') }}</p>@endif</div>
                            <div class="form-group required {{ $errors->has('proposer_type') ? 'has-error' : '' }}"><label for="proposer_type" class="control-label" style="text-align:left">ประเภทข้อเสนอ (Proposer)</label><select name="proposer_type" id="proposer_type" class="form-control" required><option value="">-- กรุณาเลือก --</option><option value="sdo_advanced" {{ (old('proposer_type', $offer->proposer_type) == 'sdo_advanced') ? 'selected' : '' }}>SDO ขั้นสูง</option><option value="sdo_basic_or_non_sdo" {{ (old('proposer_type', $offer->proposer_type) == 'sdo_basic_or_non_sdo') ? 'selected' : '' }}>SDO ขั้นต้น หรือหน่วยงานที่ไม่ใช่ SDO</option></select>@if ($errors->has('proposer_type'))<p class="help-block">{{ $errors->first('proposer_type') }}</p>@endif</div>
                            <div class="form-group required {{ $errors->has('stakeholders') ? 'has-error' : ''}}"><label for="stakeholders" class="control-label" style="text-align:left">ผู้มีส่วนได้เสียที่เกี่ยวข้อง</label><textarea name="stakeholders" id="stakeholders" class="form-control" required>{{ old('stakeholders', $offer->stakeholders) }}</textarea>@if ($errors->has('stakeholders'))<p class="help-block">{{ $errors->first('stakeholders') }}</p>@endif</div>
                            <div class="form-group {{ $errors->has('iso_number') ? 'has-error' : ''}}"><label for="iso_number" class="control-label" style="text-align:left">เลขมาตรฐาน ISO</label><input class="form-control" name="iso_number" type="text" id="iso_number" value="{{ old('iso_number', $offer->iso_number) }}">@if ($errors->has('iso_number'))<p class="help-block">{{ $errors->first('iso_number') }}</p>@endif</div>
                            <div class="form-group {{ $errors->has('standard_name_en') ? 'has-error' : ''}}"><label for="standard_name_en" class="control-label" style="text-align:left">ชื่อมาตรฐาน (Eng)</label><input class="form-control" name="standard_name_en" type="text" id="standard_name_en" value="{{ old('standard_name_en', $offer->standard_name_en) }}">@if ($errors->has('standard_name_en'))<p class="help-block">{{ $errors->first('standard_name_en') }}</p>@endif</div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('title_eng') ? 'has-error' : ''}}"><label for="title_eng" class="control-label" style="text-align:left">ชื่อเรื่อง (Eng)</label><input type="text" name="title_eng" id="title_eng" value="{{ old('title_eng', $offer->title_eng) }}" class="form-control" required>@if ($errors->has('title_eng'))<p class="help-block">{{ $errors->first('title_eng') }}</p>@endif</div>
                            <div class="form-group required {{ $errors->has('objectve') ? 'has-error' : '' }}"><label for="objectve" class="control-label" style="text-align:left">จุดประสงค์และเหตุผลในการจัดทำ</label><select name="objectve" id="objectve" class="form-control" required><option value="">- เลือกจุดประสงค์ -</option><option value="จัดทำครั้งแรก" {{ (old('objectve', $offer->objectve) == 'จัดทำครั้งแรก') ? 'selected' : '' }}>จัดทำครั้งแรก</option><option value="ปรับปรุงมาตรฐาน" {{ (old('objectve', $offer->objectve) == 'ปรับปรุงมาตรฐาน') ? 'selected' : '' }}>ปรับปรุงมาตรฐาน</option></select>@if ($errors->has('objectve'))<p class="help-block">{{ $errors->first('objectve') }}</p>@endif</div>
                            <div class="form-group {{ $errors->has('scope') ? 'has-error' : '' }}"><label for="scope" class="control-label" style="text-align:left">ขอบข่าย</label><input class="form-control" name="scope" type="text" id="scope" value="{{ old('scope', $offer->scope) }}">@if ($errors->has('scope'))<p class="help-block">{{ $errors->first('scope') }}</p>@endif</div>
                            <div class="form-group {{ $errors->has('meeting_count') ? 'has-error' : '' }}"><label for="meeting_count" class="control-label" style="text-align:left">จำนวนการประชุมเชิงปฏิบัติการที่คาดว่าจะจัดและช่วงเวลาที่คาดว่าจะจัดการประชุมเชิงปฏิบัติการ (เฉพาะกรณีจัดทำข้อตกลงร่วม) :</label><input class="form-control" name="meeting_count" type="text" id="meeting_count" value="{{ old('meeting_count', $offer->meeting_count) }}">@if ($errors->has('meeting_count'))<p class="help-block">{{ $errors->first('meeting_count') }}</p>@endif</div>
                            <div class="form-group {{ $errors->has('standard_name') ? 'has-error' : ''}}"><label for="standard_name" class="control-label" style="text-align:left">ชื่อมาตรฐาน</label><input class="form-control" name="standard_name" type="text" id="standard_name" value="{{ old('standard_name', $offer->standard_name) }}">@if ($errors->has('standard_name'))<p class="help-block">{{ $errors->first('standard_name') }}</p>@endif</div>
                            
                            <div class="form-group {{ $errors->has('national_strategy') ? 'has-error' : ''}}"><label for="national_strategy" class="control-label" style="text-align:left">แผนยุทธศาสตร์ชาติ 20 ปี/แผนพัฒนาเศรษฐกิจและสังคมแห่งชาติ ฉบับที่ 13 (ถ้ามี) :</label><input class="form-control" name="national_strategy" type="text" id="national_strategy" value="{{ old('national_strategy', $offer->national_strategy) }}">@if ($errors->has('national_strategy'))<p class="help-block">{{ $errors->first('national_strategy') }}</p>@endif</div>
                        </div>
                        <div class="col-md-12"><div class="form-group {{ $errors->has('reason') ? 'has-error' : ''}}"><label for="reason" class="control-label" style="text-align:left">เหตุผล</label><textarea name="reason" id="reason" class="form-control">{{ old('reason', $offer->reason) }}</textarea>@if ($errors->has('reason'))<p class="help-block">{{ $errors->first('reason') }}</p>@endif</div></div>
                        <div class="col-md-12"><div class="form-group {{ $errors->has('attach_file') ? 'has-error' : ''}}">

                            <label for="attach_file" class="control-label" style="text-align:left">เอกสาร (.zip) ประกอบด้วย แผนการดำเนินงาน, ร่างมาตรฐาน หรืออื่น ๆ กรณีเป็นลิงก์ดาวน์โหลดให้ใส่ใน Text file แล้ว zip 
                                <br>
                                {{-- @php
                                    $attach = $offer->AttachFileAttachFileTo;
                                @endphp
                                @if (!empty($attach))
                                    {!! !empty($attach->caption) ? $attach->caption : '' !!}
                                    <a href="{{url('funtions/get-view/'.$attach->url.'/'.( !empty($attach->filename) ? $attach->filename :  basename($attach->url)  ))}}" target="_blank" 
                                        title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}" >
                                        {!! !empty($attach->filename) ? $attach->filename : '' !!}
                                    </a>
                                @else 
                                    {!! Form::label('stakeholders', '(ไม่มี)', ['class' => 'control-label', 'style' => 'text-align: left; color: black !important;']) !!}
                                @endif  --}}


                                 @forelse ($offer->getAttachments() as $attach)
                                    {{-- วนลูปแสดงผลทีละไฟล์ --}}
                                    <div>
                                        {!! !empty($attach->caption) ? $attach->caption . ':' : '' !!}
                                        <a href="{{ url('funtions/get-view/' . $attach->url . '/' . (!empty($attach->filename) ? $attach->filename : basename($attach->url))) }}"
                                        target="_blank"
                                        title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}">
                                        
                                        <i class="fa fa-paperclip"></i> {{-- Add an icon for better UI --}}
                                        {!! !empty($attach->filename) ? $attach->filename : 'เปิดไฟล์' !!}
                                        </a>
                                    </div>
                                @empty
                                    {{-- ส่วนที่จะแสดงผลถ้าไม่มีไฟล์แนบเลย --}}
                                    {!! Form::label('stakeholders', '(ไม่มี)', ['class' => 'control-label', 'style' => 'text-align: left; color: black !important;']) !!}
                                @endforelse

                            </label>
                            <br>
                            
                            <div>@if($offer->attach_file)<p><a href="{{ asset('storage/' . $offer->attach_file) }}" target="_blank"><i class="fa fa-download"></i> {{ basename($offer->attach_file) }}</a></p>@endif<div class="fileinput fileinput-new input-group" data-provides="fileinput"><div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span></div><span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">เลือกไฟล์ใหม่</span><span class="fileinput-exists">เปลี่ยน</span><input type="file" name="attach_file" class="attach check_max_size_file" accept=".zip,.rar" ></span><a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a></div>@if ($errors->has('attach_file'))<p class="help-block">{{ $errors->first('attach_file') }}</p>@endif</div></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-6">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> บันทึก</button>
                            <a class="btn btn-default" href="{{ url()->previous() }}"><i class="fa fa-rotate-left"></i> ยกเลิก</a>
                        </div>
                    </div>
                </form>
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