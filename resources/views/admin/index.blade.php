@extends('layouts.master')

@push('css')
<style>
    .announce-box {
        margin-left: 1rem;
        margin-bottom: 1rem;
    }
    .announce-content {
        margin-bottom: 2rem;
    }
    .text-gray {
        color: #777777;
    }
    .text-indent-5r {
        text-indent: 5rem;
    }
</style>
@endpush

@section('content')

@php
         $data_session     =    HP::CheckSession();
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {{-- <h3 class="box-title">หน้าหลัก</h3> 
                <hr> --}}
                <div class="announce-box">
                    <div class="announce-content">
                        <b class="announce-title text-warning">แจ้งปรับปรุงหน้าแบบฟอร์มคำขอรับใบรับรองระบบงาน</b>
                        <div class="text-indent-5r">เนื่องจาก แบบฟอร์มเดิมยังไม่มีการเก็บ <b>"หมายเลขการรับรอง"</b></div>
                        <div class="text-indent-5r">ดังนั้นทาง สมอ. จะขอเก็บข้อมูลส่วนนี้เพิ่ม เพื่อความสะดวกและถูกต้องในการจัดทำใบรับรองต่อไป </div>
                    </div>
                    <div class="announce-footer">
                        <i class="text-gray">*** ต้องขออภัยในความไม่สะดวก ***</i>
                    </div>
                </div>
            @if ($data_session->applicanttype_id == 2  && is_null($data_session->agent_id))

                <h3 class="box-title">หน้าหลัก ระบบการรับรองระบบงาน</h3>

                <div class="row colorbox-group-widget">

                    @if(HP::CheckPermission('view-'.str_slug('experts')))
                        <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('experts') }}">
                            <div class="white-box">
                                <div class="media bg-warning">
                                    <div class="media-body">
                                        <h3 class="info-count" style="font-size:140%;">ทะเบียนผู้เชี่ยวชาญ<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-nut"></i></span>
                                        </h3>
                                        <p class="info-text font-12">ผู้เชี่ยวชาญ</p>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    @endif

                    @if(HP::CheckPermission('view-'.str_slug('acc-auditors')))
                        <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('gta-auditors') }}">
                            <div class="white-box">
                                <div class="media bg-warning">
                                    <div class="media-body">
                                        <h3 class="info-count" style="font-size:140%;">ทะเบียนผู้ตรวจประเมิน<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-human-child"></i></span>
                                        </h3>
                                        <p class="info-text font-12">ผู้ตรวจประเมิน</p>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    @endif
                    
                </div>
           @endif
                <div class="row colorbox-group-widget">

                    @if(HP::CheckPermission('view-'.str_slug('applicantcbs')))
                        <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/applicant-cb') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:140%;">ใบรับรองระบบงาน (CB)<br/>
                                              <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-odnoklassniki"></i></span>
                                            </h3>
                                            <p class="info-text font-12">หน่วยรับรอง</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(HP::CheckPermission('view-'.str_slug('applicantibs')))
                        <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/applicant-ib') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:140%;">ใบรับรองระบบงาน (IB)<br/>
                                                <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-palette-advanced"></i></span>
                                            </h3>
                                            <p class="info-text font-12">หน่วยตรวจ</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(HP::CheckPermission('view-'.str_slug('applicant')))
                        <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/applicant') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:140%;">ใบรับรองระบบงาน (Lab)<br/>
                                                <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-test-tube"></i></span>
                                            </h3>
                                            <p class="info-text font-12">ห้องปฎิบัติการ</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(HP::CheckPermission('view-'.str_slug('tracking-cb')))
                    <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                        <a href="{{ url('certify/tracking-cb') }}">
                            <div class="white-box">
                                <div class="media bg-dashboard2">
                                    <div class="media-body">
                                        <h3 class="info-count" style="font-size:140%;">ตรวจติดตามใบรับรอง (CB)<br/>
                                            <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-bookmark"></i></span>
                                        </h3>
                                        <p class="info-text font-12">หน่วยรับรอง</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                  @endif

                  @if(HP::CheckPermission('view-'.str_slug('tracking-ib')))
                  <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                      <a href="{{ url('certify/tracking-ib') }}">
                          <div class="white-box">
                              <div class="media bg-dashboard2">
                                  <div class="media-body">
                                      <h3 class="info-count" style="font-size:140%;">ตรวจติดตามใบรับรอง (IB)<br/>
                                          <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-bookmark"></i></span>
                                      </h3>
                                      <p class="info-text font-12">หน่วยตรวจ</p>
                                  </div>
                              </div>
                          </div>
                      </a>
                  </div>
                @endif

                    @if(HP::CheckPermission('view-'.str_slug('tracking-lab')))
                        <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/tracking-labs') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:140%;">ตรวจติดตามใบรับรอง (LAB)<br/>
                                                <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-bookmark"></i></span>
                                            </h3>
                                            <p class="info-text font-12">ห้องปฎิบัติการ</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    
                    <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                        <a href="{{url('tisi/standard-offers')}}">
                            <div class="white-box">
                                <div class="media bg-dashboard2">
                                    <div class="media-body">
                                        <h3 class="info-count" style="font-size:140%;">เสนอกำหนดมาตรฐาน<br/>
                                            <span class="pull-right m-t-10" style="font-size:45px;"><i class="mdi mdi-odnoklassniki"></i></span>
                                        </h3>
                                        <p class="info-text font-12">มตช</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <script>
        $(document).ready(function () {

            @if(\Session::has('flash_message'))
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('flash_message')}}',
                loaderBg: '#70b7d6',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
            @endif

        });
    </script>

@endpush
