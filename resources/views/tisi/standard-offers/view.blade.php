@extends('layouts.master')

@push('css')
    <style type="text/css">
        .form-group {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .control-label {
            font-weight: bold;
            color: #555;
        }
        .form-group p {
            margin-top: 5px;
            margin-left: 10px;
            color: #333;
        }
        .white-box {
            padding: 25px;
        }
        .mb-4 {
            margin-bottom: 2rem;
            border-bottom: 2px solid #337ab7;
            padding-bottom: 10px;
            color: #337ab7;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eee;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title pull-left">การเสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง #{{ $offer->id }}</h3>

                <div class="pull-right">
                    {{-- @if(HP::CheckPermission('edit-'.str_slug('applicantcbs')))
                        <a href="{{ route('tisi.standard-offers.edit', $offer->id) }}" class="btn btn-warning btn-sm waves-effect waves-light">
                            <i class="fa fa-edit"></i> แก้ไข
                        </a>
                    @endif --}}
                    <a class="btn btn-info btn-sm waves-effect waves-light" href="{{ url('tisi/standard-offers') }}">
                        <span class="btn-label"><i class="icon-arrow-left-circle"></i></span><b>กลับ</b>
                    </a>
                </div>

                <div class="clearfix"></div>
                <hr>

                <div class="container-fluid">
                    <h3 class="mb-4">ผู้ยื่นข้อเสนอ (Proposer)</h3>
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                           
                            {{-- {{$offer->requetOwner()}} --}}
                            @if ($offer->requetOwner() != null)
                                    <div class="form-group"><label class="control-label">ชื่อหน่วยงาน</label><p>{{ $offer->requetOwner()->name }}</p></div>
                                @else
                                    <div class="form-group"><label class="control-label">ชื่อหน่วยงาน</label><p>-</p></div>
                            @endif
                           
                            <div class="form-group"><label class="control-label">ที่อยู่</label><p>{{ $addressInfo ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">เบอร์โทร</label><p>{{ $offer->tel ?? $department->tel ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">แฟกซ์</label><p>{{ $department->fax ?? 'ไม่พบข้อมูล' }}</p></div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group"><label class="control-label">ผู้ประสานงาน</label><p>{{ $offer->name ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">มือถือ</label><p>{{ $department->mobile ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">E-mail</label><p>{{ $offer->email ?? 'ไม่พบข้อมูล' }}</p></div>
                        </div>
                    </div>

                    <hr>

                    <h3 class="mb-4">รายละเอียดมาตรฐาน</h3>
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            {{-- <div class="form-group"><label class="control-label">ชื่อเรื่อง</label><p>{{ $offer->title ?? 'ไม่พบข้อมูล' }}</p></div> --}}
                            <div class="form-group"><label class="control-label">ชื่อมาตรฐาน</label><p>{{ $offer->standard_name ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">ประเภทมาตรฐาน</label><p>{{ App\Models\Bcertify\Standardtype::find($offer->std_type)->offertype ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">ประเภทข้อเสนอ (Proposer)</label><p>{{ $offer->proposer_type ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">จุดประสงค์และเหตุผลในการจัดทำ</label><p>{{ $offer->objectve ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">ขอบข่าย</label><p>{{ $offer->scope ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">เลขมาตรฐาน ISO</label><p>{{ $offer->iso_number ?? 'ไม่พบข้อมูล' }}</p></div>
                            
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            {{-- <div class="form-group"><label class="control-label">ชื่อเรื่อง (Eng)</label><p>{{ $offer->title_eng ?? 'ไม่พบข้อมูล' }}</p></div> --}}
                            <div class="form-group"><label class="control-label">ชื่อมาตรฐาน (Eng)</label><p>{{ $offer->standard_name_en ?? 'ไม่พบข้อมูล' }}</p></div>
                            <div class="form-group"><label class="control-label">ผู้มีส่วนได้เสียที่เกี่ยวข้อง</label><p>{!! $offer->stakeholders ?? 'ไม่พบข้อมูล' !!}</p></div>
                            <div class="form-group"><label class="control-label">จำนวนการประชุมเชิงปฏิบัติการฯ</label><p>{{ $offer->meeting_count ?? 'ไม่พบข้อมูล' }}</p></div>
                            
                            <div class="form-group"><label class="control-label">แผนยุทธศาสตร์ชาติฯ</label><p>{{ $offer->national_strategy ?? 'ไม่พบข้อมูล' }}</p></div>
                        </div>

                        <!-- Full Width -->
                        <div class="col-md-12">
                            <div class="form-group"><label class="control-label">เหตุผล</label><p>{{ $offer->reason ?? 'ไม่พบข้อมูล' }}</p></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">เอกสาร (.zip) ประกอบด้วย แผนการดำเนินงาน, ร่างมาตรฐาน หรืออื่น ๆ :</label>
                                <p>
                                    {{-- @if($offer->attach_file)
                                        <a href="{{ asset('storage/' . $offer->attach_file) }}" target="_blank">
                                            <i class="fa fa-download"></i> {{ basename($offer->attach_file) }}
                                        </a>
                                    @else
                                        ไม่พบเอกสาร
                                    @endif --}}

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
