@extends('layouts.master')

@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css"/>
    <style>

        th {
            text-align: center;
        }

        td {
            text-align: center;
        }

        .label-filter {
            margin-top: 7px;
        }

        .txt-center {
            text-align: center;
        }

        /*
          Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
          */
        @media only screen
        and (max-width: 760px), (min-device-width: 768px)
        and (max-device-width: 1024px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
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
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                /* Now like a table header */
                /*position: absolute;*/
                /* Top/left values mimic padding */
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }

            /*
            Label the data
        You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
            */
            /*td:nth-of-type(1):before { content: "Column Name"; }*/

        }


        .wrapper-detail {
            border: solid 1px silver;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        fieldset {
            padding: 20px;
        }


    .center {
        margin: auto;  //ระยะขอบ ผลักอัตโนมัติ
        width: 50%;   //ความกว้าง 50%
        border: 3px solid blue;   //ความหนา รูปแบบ สีของขอบ
        padding: 3%;  //ขยายขอบด้านใน
    }


    </style>
@endpush


@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div id="alert">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="box-title">ระบบรับ - แจ้งผลการทดสอบ (สำหรับ LAB)</h1>
                            <hr class="hr-line bg-primary">
                        </div>
                    </div>

                    <form id="form_data" method="post" enctype="multipart/form-data">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <fieldset class="row">
                            <div class="white-box" style="display: flex; flex-direction: column;">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="col-sm-2 text-right"> เลขที่อ้างอิง :</div>
                                        <div class="col-sm-9">
                                            <input name="example_id" value="<?=$data->id?>" hidden>
                                            <input type="text" class="form-control" value="{{$data_map->no_example_id}}"
                                                   disabled="true">
                                            <input type="text" value="{{$data_map->no_example_id}}" name="no_example_id"
                                                   hidden>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="col-sm-2 text-right"> มาตรฐาน :</div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   value="{{'มอก. '. $data->tis_standard. ' ' .$data->tis->tb3_TisThainame}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="col-sm-2 text-right"> ผู้ได้รับใบอนุญาต :</div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                   value="{{$data->licensee}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table color-bordered-table primary-bordered-table" id="myTable">
                                        <thead>
                                        <tr>
                                            <th style="width: 3%; color: white">รายการ<br>ที่</th>
                                            <th style="width: 25%; color: white">รายละเอียดผลิตภัณฑ์อุตสาหกรรม</th>
                                            <th style="width: 19%; color: white">รายการทดสอบ</th>
                                            <th style="width: 7%; color: white">จำนวน<br>ที่ส่ง</th>
                                            <th style="width: 7%; color: white">จำนวน<br>ที่<br>ได้รับ</th>
                                            <th style="width: 10%; color: white">หมายเลข<br>ตัวอย่าง</th>
                                            <th style="width: 19%; color: white">ผลทดสอบ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        $temp = 1;
                                        ?>
                                        @foreach($data_map_table as $list)
                                            <tr>
                                                <td style="vertical-align: top;">{{$loop->iteration}}</td>
                                                <td style="font-size: 15px; text-align: left; vertical-align: top;">{{HP::map_lap_sizedetail($list->detail_product_maplap)}}
                                                    <input name="example_id_no[]" value="{{$list->id}}" hidden>
                                                </td>
                                                <td style="font-size: 14px;">
                                                {!! HP::map_lap_test_detail_disable2($list->id,$i,$list->example_id) !!}
                                                </td>
                                                <td style="font-size: 14px; vertical-align: text-top;">
                                                    <input class="form-control input-sm txt-center" disabled
                                                           value="{{HP::map_lap_number3($list->detail_product_maplap,$list->example_id)}}">
                                                </td>
                                                <td style="font-size: 14px; vertical-align: text-top;">
                                                    <input class="form-control input-sm txt-center" name="number_labget[]" disabled
                                                           value="{{$list->number_labget}}">
                                                </td>
                                                <td style="font-size: 14px; vertical-align: text-top;">
                                                    <input class="form-control input-sm txt-center" disabled
                                                           value="{{HP::map_lap_num_ex3($list->detail_product_maplap,$list->example_id)}}">
                                                </td>
                                                <td style="font-size: 14px; vertical-align: text-top;">
                                                    <input class="form-control input-sm txt-center" disabled
                                                           value="{{HP::map_lap_file($list->id,$list->no_example_id)}}">
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                            <input value="{{$temp++}}" hidden>
                                            <input name="get_example_id" value="{{$list->example_id}}" hidden>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </fieldset>

                        <fieldset class="row">
                            <div class="white-box" style="display: flex; flex-direction: column;">
                            <div class="form-group m-b-10">
                                    <div class="col-sm-8">
                                        <label class="col-sm-3 text-right"> การตรวจสอบ : </label>
                                        <div class="col-md-7">
                                            <input type="radio"
                                                   class="col-sm-1 checked_radio"
                                                   name="verification"
                                                   value="ตรวจสอบที่หน่วยตรวจสอบ"
                                                   disabled
                                            <?php echo ($data->verification == 'ตรวจสอบที่หน่วยตรวจสอบ') ? 'checked' : '' ?>>
                                            <label> ตรวจสอบที่หน่วยตรวจสอบ </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <label class="col-sm-3 text-right"></label>
                                        <div class="col-md-7">
                                            <input type="radio"
                                                   class="col-sm-1 checked_radio"
                                                   name="verification"
                                                   value="ตรวจสอบที่โรงงาน"
                                                   disabled
                                            <?php echo ($data->verification == 'ตรวจสอบที่โรงงาน') ? 'checked' : '' ?>>
                                            <label> ตรวจสอบที่โรงงาน </label>
                                        </div>
                                    </div>
                                </div>
                                @if($data->verification == 'ตรวจสอบที่หน่วยตรวจสอบ')
                                <div id="sample_delivery" class="form-group">
                                    <div class="form-group">
                                        <div class="col-sm-8 m-b-10">
                                            <label class="col-sm-3 text-right"> การนำส่งตัวอย่าง : </label>
                                            <div class="col-md-7">
                                                <input type="radio" class="col-sm-1" name="sample_submission"
                                                       <?php echo ($data->sample_submission == 'ผู้ยื่นคำขอ/ผู้รับใบอนุญาต นำส่งตัวอย่าง') ? 'checked' : '' ?>
                                                       value="ผู้ยื่นคำขอ/ผู้รับใบอนุญาต นำส่งตัวอย่าง" disabled>
                                                <label> ผู้ยื่นคำขอ/ผู้รับใบอนุญาต นำส่งตัวอย่าง </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-8 m-b-10">
                                            <label class="col-sm-3 text-right"></label>
                                            <div class="col-md-7">
                                                <input type="radio" class="col-sm-1" name="sample_submission"
                                                       <?php echo ($data->sample_submission == 'กลุ่มหน่วยตรวจสอบ กอ. นำส่งตัวอย่าง') ? 'checked' : '' ?>
                                                       value="กลุ่มหน่วยตรวจสอบ กอ. นำส่งตัวอย่าง" disabled>
                                                <label> กลุ่มหน่วยตรวจสอบ กอ. นำส่งตัวอย่าง </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <p class="col-sm-2"></p>
                                            <label class="col-sm-3 text-right"> โดยเก็บตัวอย่างไว้ที่ </label>
                                            <label class="col-sm-2"><input type="radio" name="stored_add" disabled
                                                   value="โรงงาน" <?php echo ($data->stored_add == 'โรงงาน') ? 'checked' : '' ?>> โรงงาน </label>
                                            <label class="col-sm-2"><input type="radio" name="stored_add" disabled
                                                   value="สมอ. ห้อง" <?php echo ($data->stored_add == 'สมอ. ห้อง') ? 'checked' : '' ?>> สมอ. ห้อง </label>
                                            <div class="input-group col-sm-2">
                                                <input type="text" class="form-control pull-right" name="room_anchor" disabled
                                                       value="{{$data->room_anchor}}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endif

                                <div class="form-group">
                                    <p class="center" style="text-align: justify; padding: 10px; border: 2px solid black; line-height: 40px; width: 980px">
                                        ตามเงื่อนไขที่ผู้รับใบอนุญาตต้องปฏิบัติ ตามมาตรา 25 ทวิ สำนักงานขอแจ้งให้ท่านนำส่งตัวอย่างพร้อมชำระค่าใช้จ่ายในการตรวจสอบ<br>
                                        ที่หน่วยตรวจสอบตามที่ระบุไว้ ในใบรับ-นำส่งตัวอย่างนี้ ภายใน 15 วัน นับจากวันที่เก็บตัวอย่าง
                                    </p>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> วันที่เก็บตัวอย่าง : </label>
                                        <div class="col-md-8">
                                        <!-- date('d/m/Y', strtotime($data->sample_submission_date)) -->
                                            <input type="text" class="form-control" name="sample_submission_date"
                                                   value="{{$data->sample_submission_date}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> ผู้จ่ายตัวอย่าง : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="sample_pay"
                                                   value="{{$data->sample_pay}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                     <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> ผู้รับตัวอย่าง : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="sample_recipient"
                                                   value="{{$data->sample_recipient}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> ตำแหน่ง : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="permission_submiss"
                                                   value="{{$data->permission_submiss}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> ตำแหน่ง : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="permission_receive"
                                                   value="{{$data->permission_receive}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> เบอร์โทรศัพท์ : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="permission_submiss"
                                                   value="{{$data->tel_submiss}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> เบอร์โทรศัพท์ : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="permission_receive"
                                                   value="{{$data->tel_receive}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> E-mail : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="permission_submiss"
                                                   value="{{$data->email_submiss}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> E-mail : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="permission_receive"
                                                   value="{{$data->email_receive}}"
                                                   disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> การรับคืนตัวอย่าง : </label>
                                        <label class="col-md-8">{{$data->sample_return}}</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="row">
                            <div class="white-box" style="display: flex; flex-direction: column;">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> สถานะ : </label>
                                        <div class="col-md-8">
                                            <select name="status" class="form-control" id="status"
                                                    onchange="add_req(this);" disabled="true">
                                                <option value="{{$data_map->status}}">{{HP::map_lap_status($data_map->status)}}</option>
                                                <option value="อยู่ระหว่างดำเนินการ">อยู่ระหว่างดำเนินการ</option>
                                                <option value="ส่งผลการทดสอบ">ส่งผลการทดสอบ</option>
                                                <option value="ไม่รับเรื่อง">ไม่รับเรื่อง</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> หมายเหตุ : </label>
                                        <div class="col-md-8">
                                        <textarea class="form-control" name="remark_map" id="remark"
                                                  rows="4" disabled="true">{{$data_map->remark}} </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> ผู้บันทึก : </label>
                                        <div class="col-md-8">
                                            <input class="form-control" name="user_create" value="{{$data_map->user_lab}}" disabled="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> เบอร์โทรศัพท์ : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="tel_lab"
                                                    value="{{$data_map_table[0]->tel_lab}}"
                                                    disabled="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 text-right"> E-mail : </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="email_lab"
                                                    value="{{$data_map_table[0]->email_lab}}"
                                                    disabled="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div align="right">
                            <a class="btn btn-default btn-sm waves-effect waves-light"
                               href="{{ url('/resurv/report_product') }}">
                                <i class="fa fa-undo"></i><b> กลับ</b>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <input id="tis_no" value="{{$data->tis_standard}}" hidden>
        <input id="verification" value="{{$data->verification}}" hidden>
        @endsection

        @push('js')
            <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
            <script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>

            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                function add_req(test) {
                    if (test.value == 'อยู่ระหว่างดำเนินการ') {
                        $(function () {
                            $("#sample_collect_date").prop('required', true);
                            $("#sample_recipient").prop('required', true);
                            $("#permission_receive").prop('required', true);
                            $("#tel_receive").prop('required', true);
                            $("#email_receive").prop('required', true);
                            $("#remark").prop('required', true);
                            // $("input").prop('required',true);
                        });
                        $('#send').prop('disabled', true)
                    } else {
                        $("#sample_collect_date").prop('required', false);
                        $("#sample_recipient").prop('required', false);
                        $("#permission_receive").prop('required', false);
                        $("#tel_receive").prop('required', false);
                        $("#email_receive").prop('required', false);
                        $("#remark").prop('required', false);
                        $('#send').prop('disabled', false)
                    }
                    if (test.value == 'ไม่รับเรื่อง' || test.value == 'ส่งผลการทดสอบ') {
                        $('#save').prop('disabled', true)
                    } else {
                        $('#save').prop('disabled', false)
                    }
                }

                $('#form_data').submit(function (event) {
                    event.preventDefault();
                    var form_data = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "{{url('/resurv/report_product/update')}}",
                        datatype: "script",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            if (data.status == "success") {
                                alert('แก้ไขข้อมูลสำเร็จ');
                                window.location.href = "{{url('/resurv/report_product')}}"
                            } else if (data.status == "error") {
                                $("#alert").html('<div class="alert alert-danger"><strong>แจ้งเตือน !</strong> ' + response.message + ' <br></div>');
                            } else {
                                alert('ระบบขัดข้อง โปรดตรวจสอบ !');
                            }
                        }
                    });
                });

                function add_file_upload() {
                    var next_num = $('.sub_file').length;

                    var html_add_item = '<div class="form-group sub_file">\n' +
                        '<span class="running-no"></span>\n' +
                        '<input type="text" name="num_row_file[]" hidden>\n' +
                        '<div class="col-md-2"></div>\n' +
                        '<div class="col-md-4">\n' +
                        '<input type="file" accept="application/pdf" id="file' + next_num + '" name="file' + next_num + '" class="form-control" disabled>\n' +
                        '</div>\n' +
                        '<button class="btn btn-small btn-danger remove" onclick="return false;" disabled><span class="fa fa-trash"></span></button>\n' +
                        '</div>';

                    $('#file_upload').append(html_add_item);

                    var uploadField1 = document.getElementById("file" + next_num);
                    uploadField1.onchange = function () {
                        if (this.files[0].size > 10485760) {
                            alert("ไฟล์มีขนาดใหญ่เกินไป");
                            this.value = "";
                        }
                        ;
                    };
                }

                $("#add").click(function () {
                    add_file_upload();
                });

                var uploadField = document.getElementById("file");

                uploadField.onchange = function () {
                    if (this.files[0].size > 10485760) {
                        alert("ไฟล์มีขนาดใหญ่เกินไป");
                        this.value = "";
                    }
                    ;
                };


                $(document).on('click', '.remove', function () {
                    var row_remove = $(this).parent();
                    setTimeout(function () {
                        row_remove.remove();
                    }, 100);
                });

                $(document).on('click', '.remove_old', function () {
                    var next_num = $('.sub_file').length;
                    $('.file_old').remove();
                    $('#file_old0').remove();
                    $('#new_file').html('<input type="file" class="form-control sub_file" id="file" name="file'+next_num+'" disabled>')
                });

                $(".custom-file-input").on("change", function () {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });


                $('#datepicker-time').datepicker({
                    autoclose: true
                });

                $('#datepicker-time2').datepicker({
                    autoclose: true
                });

            </script>
    @endpush


