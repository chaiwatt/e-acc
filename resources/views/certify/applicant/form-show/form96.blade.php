<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    <h4 class="m-l-5">10. เอกสารแนบ</h4>
    <div class="container">
        @if ($attaches->count() > 0)
            <div class="col-md-12" style="margin-bottom: 10px">
                <table class="table table-bordered" id="myTable_labTest">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white col-xs-4">ประเภทไฟล์</th>
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
        @endif
    </div>

    <h5>เอกสารแนบอื่นๆ</h5>
    <div class="container-fluid">
        @if ($certi_lab_attach_more->count() > 0)
            <div class="col-md-12" style="padding-left: 4rem;padding-right: 4rem">
                <table class="table table-bordered" id="myTable_labTest">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white col-xs-4">ชื่อไฟล์</th>
                        <th class="text-center text-white col-xs-3">ดาวน์โหลด</th>
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
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
