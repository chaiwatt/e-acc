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
                    <h3 class="box-title pull-left">ดูการเสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง #{{ $offer->id }}</h3>

                    <div class="pull-right">
                        @if(HP::CheckPermission('edit-'.str_slug('applicantcbs')))
                            <a href="{{ route('tisi.standard-offers.edit', $offer->id) }}" class="btn btn-warning btn-sm waves-effect waves-light">
                                <i class="fa fa-edit"></i> แก้ไข
                            </a>
                        @endif
                        <a class="btn btn-info btn-sm waves-effect waves-light" href="{{ url('tisi/standard-offers') }}">
                            <span class="btn-label"><i class="icon-arrow-left-circle"></i></span><b>กลับ</b>
                        </a>
                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    <div class="container">
                        <h3 class="mb-4">ผู้ยื่นข้อเสนอ (Proposer)</h3>
                        <div class="row">
                            <!-- คอลัมน์ที่ 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">ชื่อหน่วยงาน</label>
                                    <p>{{ $department->title ?? $offer->department ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">เบอร์โทร</label>
                                    <p>{{ $offer->telephone ?? $department->tel ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">E-mail</label>
                                    <p>{{ $offer->email ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">โทรศัพท์</label>
                                    <p>{{ $department->tel ?? 'ไม่พบข้อมูล' }}</p>
                                </div>
                            </div>

                            <!-- คอลัมน์ที่ 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">ที่อยู่</label>
                                    <p>{{ $addressInfo ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">แฟกซ์</label>
                                    <p>{{ $department->fax ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">มือถือ</label>
                                    <p>{{ $department->mobile ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">ผู้ประสานงาน</label>
                                    <p>{{ $offer->name ?? 'ไม่พบข้อมูล' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <h3 class="mb-4">รายละเอียดมาตรฐาน</h3>
                        <div class="row">
                            <!-- คอลัมน์ที่ 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">ชื่อเรื่อง</label>
                                    <p>{{ $offer->title ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">ประเภทมาตรฐาน</label>
                                    <p>{{ App\Models\Bcertify\Standardtype::find($offer->std_type)->offertype ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">จุดประสงค์และเหตุผล</label>
                                    <p>{{ $offer->objectve ?? 'ไม่พบข้อมูล' }}</p>
                                </div>
                            </div>

                            <!-- คอลัมน์ที่ 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">ชื่อเรื่อง (Eng)</label>
                                    <p>{{ $offer->title_eng ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">ขอบข่าย</label>
                                    <p>{{ $offer->scope ?? 'ไม่พบข้อมูล' }}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">ผู้มีส่วนได้เสียที่เกี่ยวข้อง</label>
                                    <p>{{ $offer->stakeholders ?? 'ไม่พบข้อมูล' }}</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">เอกสารเพิ่มเติม</label>
                                    <p>
                                        @if($offer->attach_file)
                                            <a href="{{ asset('storage/' . $offer->attach_file) }}" target="_blank">{{ basename($offer->attach_file) }}</a>
                                        @else
                                            ไม่พบเอกสาร
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection