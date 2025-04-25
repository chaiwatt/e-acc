<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 1rem">
    <h4 class="m-l-5">10. เอกสารแนบ</h4>
</div>
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px">
        <table class="table table-bordered" id="myTable_labTest">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white col-xs-4">ประเภทไฟล์</th>
                <th class="text-center text-white col-xs-5">อัพโหลด</th>
                <th class="text-center text-white col-xs-3">ดาวน์โหลด</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attaches as $attach)
                @php $find_name = \Illuminate\Support\Facades\DB::table('bcertify_config_attaches')->select('*')->where('id',$attach->config_attach_id)->where('state',1)->first() @endphp
                <tr>
                    @if ($find_name)

                        @php
                            $certi_files = $certi_lab->get_this_attach_config($attach->config_attach_id) ?? null;
                        @endphp
                        <td class="text-center">
                            @if ($find_name->essential == 1)
                                <label for="id_certificate_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">{{ $find_name->title }} <span class="text-danger">*</span></label>
                            @else
                                <label for="id_certificate_file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">{{ $find_name->title }}</label>
                            @endif
                        </td>
                        <td style="padding-left: 3rem;padding-right: 4rem">
                            <input type="hidden" value="{{ $find_name->id }}" name="findNameTen[]">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput" style="margin-left: 8px">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                    @if ($certi_files && $certi_files->path)
                                        <input type="file" id="id_certificate_file[]" name="id_certificate_file[]" onchange="alert('คุณกำลังเปลี่ยนไฟล์')">
                                    @else
                                        {!! Form::file('id_certificate_file[]', null,['required' => 'required']) !!}
                                    @endif
                                    </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                            @if ($certi_files)
                                @if ($certi_files->path)
                                    <small class="text-danger">* อัพโหลดไฟล์ใหม่ หากต้องการเปลี่ยนไฟล์</small>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($certi_files && $certi_files->path)
                                <a href="{{url('check/files/'.basename($certi_files->path))}}" class="text-white" target="_blank">
                                        <span class="badge badge-success" style="padding: 8px;white-space: initial;text-transform: initial;">
                                            <i class="mdi mdi-file"></i> {{basename($certi_files->path)}}
                                        </span>
                                    {{--                                        <i class="fa fa-file-pdf-o" style="font-size:25px; color:red" aria-hidden="true"></i>--}}
                                    {{--                                        <p>{{basename($certi_files->path)}}</p>--}}
                                </a>
                            @else
                                <span class="badge badge-danger" style="padding: 8px">ยังไม่มีไฟล์</span>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-md-12 m-l-30 form-group" style="margin-bottom: 10px">
        {!! Form::label('another_attach_files', 'เอกสารเพิ่มเติมอื่นๆ:', ['class' => 'm-t-5']) !!}
        <button type="button" class="btn btn-sm btn-success m-l-10" id="another_attach-add">
            <i class="icon-plus"></i>&nbsp;เพิ่ม
        </button>
        <div id="another_attach_files-box">
            <div class="form-group another_attach_files">
                <div class="col-md-3">
                    {!! Form::text('another_attach_name[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
                </div>
                <div class="col-md-3">
                    <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span>
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                            {!! Form::file('another_attach_files[]', null) !!}
                                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('another_attach_files', '<p class="help-block">:message</p>') !!}

                </div>
                <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                    <button class="btn btn-danger btn-sm another_attach_remove" type="button">
                        <i class="icon-close"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($certi_lab_attach_more->count() > 0)
        <div class="col-md-12" style="padding-left: 4rem;padding-right: 4rem">
            <div class="container-fluid">
                <table class="table table-bordered" id="myTable_labTest">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white col-xs-4">ชื่อไฟล์</th>
                        <th class="text-center text-white col-xs-3">ดาวน์โหลด</th>
                        <th class="text-center text-white col-xs-3">ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certi_lab_attach_more as $data)
                        <tr>
                            @if ($data->file)
                                <td class="text-center">
                                    {{$data->file_desc}}
                                </td>
                                <td class="text-center">
                                    <a href="{{url('check/files/'.basename($data->file))}}" target="_blank">
                                        <i class="fa fa-file-pdf-o" style="font-size:25px; color:red" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{url('certify/applicant/delete/file').'/'.basename($data->file).'/'.$data->token}}" class="btn btn-danger btn-xs" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
{{--    <div class="col-md-4 m-l-35">--}}
{{--        <button type="button" class="btn btn-primary m-l-5">ส่งข้อมูล</button>--}}
{{--        <button type="button" class="btn btn-warning text-white m-l-5">ฉบับร่าง</button>--}}
{{--        <button type="button" class="btn btn-danger m-l-5" id="cancel_edit_calibrate">ยกเลิก</button>--}}
{{--    </div>--}}
</div>
@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#another_attach-add').click(function(event) {
                $('.another_attach_files:first').clone().appendTo('#another_attach_files-box');

                $('.another_attach_files:last').find('input').val('');
                $('.another_attach_files:last').find('a.fileinput-exists').click();
                $('.another_attach_files:last').find('a.view-attach').remove();

                ShowHideRemoveBtn();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.another_attach_remove', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn();
            });

            ShowHideRemoveBtn();
        });

        function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

            if ($('.another_attach_files').length > 1) {
                $('.another_attach_remove').show();
            } else {
                $('.another_attach_remove').hide();
            }

        }
    </script>
@endpush
