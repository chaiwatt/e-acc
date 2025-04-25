@extends('layouts.master')

@push('css')
  <style type="text/css">
  fieldset.white-box {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
  legend.legend {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
  }
  </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">
                  ยินดีต้อนรับเข้าสู่ "ระบบการรับรองระบบงาน"
                </h3>

                {{-- <p>
                  <h3 style="color: blue;">เรียน ผู้ประกอบการทุกท่าน</h3>
                    <span style="color: red;">ตอนนี้ระบบขอใบรับรองระบบ CB, IB, LAB อยู่ระหว่างดำเนินการ</span><br>
                    <span style="color: red;">กรุณารอการประกาศใช้งานอย่างเป็นทางการอีกครั้ง</span><br>
                    <span style="color: red;">ขออภัยมาในความไม่สะดวกมา ณ ที่นี้ด้วย</span><br>
                </p> --}}

                    <div class="row colorbox-group-widget">

                        {{-- @can('view-'.str_slug('applicantcbs')) --}}
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/applicant-cb') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:170%;">ใบรับรองระบบงาน (CB)<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-odnoklassniki"></i></span>
                                          </h3>
                                          <p class="info-text font-12">หน่วยรับรอง</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        {{-- @endcan --}}

                        {{-- @can('view-'.str_slug('applicantibs')) --}}
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/applicant-ib') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:180%;">ใบรับรองระบบงาน (IB)<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-palette-advanced"></i></span>
                                          </h3>
                                          <p class="info-text font-12">หน่วยตรวจ</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        {{-- @endcan --}}

                        {{-- @can('view-'.str_slug('applicant')) --}}
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('certify/applicant') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:180%;">ใบรับรองระบบงาน (Lab)<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-test-tube"></i></span>
                                          </h3>
                                          <p class="info-text font-12">ห้องปฎิบัติการ</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        {{-- @endcan --}}

                    </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
@endpush
