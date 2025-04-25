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

  @php
    $user = auth()->user();
  @endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h6 class="box-title">
                  ยินดีต้อนรับเข้าสู่ "ระบบตรวจติดตามออนไลน์" (e-Surveillance)
                  <div class="pull-right">

                    @can('view-'.str_slug('licenses'))
      								<a href="{{ url('esurv/tisi_license') }}" class="btn btn-rounded waves-effect waves-light btn-success" style="font-size:45%">
      									<span class="btn-label"><i class="fa fa-search"></i></span>ดูข้อมูลใบอนุญาต
      								</a>
                    @endcan

                    @can('edit-'.str_slug('license-details'))
                      <a href="{{ url('esurv/license_detail_edit') }}" class="btn btn-rounded waves-effect waves-light btn-primary" style="font-size:45%">
      									<span class="btn-label"><i class="fa fa-edit"></i></span>แก้ไขลำดับรายละเอียดผลิตภัณฑ์
      								</a>
                    @endcan

    							</div>
                </h6>
                <div class="clearfix"></div>

                <fieldset class="white-box">

                  <legend class="legend">งานตรวจติดตาม</legend>

                  @if($user->can('view-'.str_slug('inform_volume')) ||
                      $user->can('view-'.str_slug('inform_change')) ||
                      $user->can('view-'.str_slug('inform_quality_control')) ||
                      $user->can('view-'.str_slug('inform_inspection')) ||
                      $user->can('view-'.str_slug('inform_calibrate')) ||
                      $user->can('view-'.str_slug('other'))
                     )

                    @if($user->can('view-'.str_slug('inform_volume')) || $user->can('view-'.str_slug('inform_change')))
                      <div class="row colorbox-group-widget">
                          <div class="col-md-12 col-sm-12"><h4>1.แจ้งตามเงื่อนไข</h4></div>

                          @can('view-'.str_slug('inform_volume'))
                            <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                              <a href="{{ url('esurv/inform_volume') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:170%;">แจ้งปริมาณการผลิต<br/>
                                              <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-cart-plus"></i></span>
                                            </h3>
                                            <p class="info-text font-12">(ตามเงื่อนไข)</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            </div>
                          @endcan

                          @can('view-'.str_slug('inform_change'))
                            <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                              <a href="{{ url('esurv/inform_change') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:180%;">แจ้งการเปลี่ยนแปลง<br/>
                                              <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-wrap"></i></span>
                                            </h3>
                                            <p class="info-text font-12">(ที่มีผลกระทบต่อคุณภาพ)</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            </div>
                          @endcan

                      </div>
                    @endif

                    @if($user->can('view-'.str_slug('inform_quality_control')) ||
                        $user->can('view-'.str_slug('inform_inspection')) ||
                        $user->can('view-'.str_slug('inform_calibrate'))
                       )
                      <div class="row colorbox-group-widget">
                        <div class="col-md-12 col-sm-12"><h4>2.Self Declaration</h4></div>

                        @can('view-'.str_slug('inform_quality_control'))
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('esurv/inform_quality_control') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:170%;">แจ้งผลการประเมิน QC<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span>
                                          </h3>
                                          <p class="info-text font-12">&nbsp;</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        @endcan

                        @can('view-'.str_slug('inform_inspection'))
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('esurv/inform_inspection') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:180%;">แจ้งผลการทดสอบ<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-playlist-check"></i></span>
                                          </h3>
                                          <p class="info-text font-12">ผลิตภัณฑ์</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        @endcan

                        @can('view-'.str_slug('inform_calibrate'))
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('esurv/inform_calibrate') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:180%;">แจ้งผลการสอบเทียบ<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-speedometer"></i></span>
                                          </h3>
                                          <p class="info-text font-12">เครื่องมือวัด</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        @endcan
                      </div>
                    @endif

                    @if($user->can('view-'.str_slug('other')))
                      <div class="row colorbox-group-widget">
                        <div class="col-md-12 col-sm-12"><h4>3.แจ้งข้อมูลอื่นๆ</h4></div>

                        @can('view-'.str_slug('other'))
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('esurv/other') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:190%;">แจ้งข้อมูลอื่นๆ<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-comment-question-outline"></i></span>
                                          </h3>
                                          <p class="info-text font-12">&nbsp;</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        @endcan
                       @can('view-'.str_slug('tisi_license_notification'))
                          <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                            <a href="{{ url('esurv/tisi_license_notification') }}">
                              <div class="white-box">
                                  <div class="media bg-dashboard2">
                                      <div class="media-body">
                                          <h3 class="info-count" style="font-size:190%;">แจ้งข้อมูลใบอนุญาต<br/>
                                            <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-alert-circle"></i></span>
                                          </h3>
                                          <p class="info-text font-12">&nbsp;</p>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        @endcan
                      </div>
                    @endif

                  @else
                    <div class="alert alert-info"> <i class="fa fa-info-circle"></i> คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ </div>
                  @endif

                </fieldset>

                <fieldset class="white-box">


                  @if($user->can('view-'.str_slug('applicant_20ter')) ||
                          $user->can('view-'.str_slug('applicant_20bis')) ||
                          $user->can('view-'.str_slug('applicant_21bis'))
                         )
                        <div class="row colorbox-group-widget">
                            <div class="col-md-12 col-sm-12"><h4>4.ระบบยื่นคำขอ</h4></div>

                            @can('view-'.str_slug('applicant_20ter'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                  <a href="{{ url('esurv/applicant_20ter') }}">
                                  <div class="white-box">
                                          <div class="media bg-dashboard2">
                                              <div class="media-body">
                                                  <h3 class="info-count" style="font-size:116%;">คำขอการทำผลิตภัณฑ์เพื่อส่งออก<br/>
                                                      <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-ray-start-arrow"></i></span>
                                                  </h3>
                                                  <p class="info-text font-12">(ตามมาตรา 20 ตรี)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                            @endcan

                            @can('view-'.str_slug('applicant_20bis'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                  <a href="{{ url('esurv/applicant_20bis') }}">
                                      <div class="white-box">
                                          <div class="media bg-dashboard2">
                                              <div class="media-body">
                                                  <h3 class="info-count" style="font-size:70%;">คำขอทำผลิตภัณฑ์เพื่อใช้ในประเทศเป็นการเฉพาะคราว<br/>
                                                      <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-ray-start-end"></i></span>
                                                  </h3>
                                                  <p class="info-text font-12">(ตามมาตรา 20 ทวิ)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                            @endcan

                            {{-- @can('view-'.str_slug('applicant_21bis'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                  <a href="{{ url('esurv/applicant_21bis') }}">
                                      <div class="white-box">
                                          <div class="media bg-dashboard2">
                                              <div class="media-body">
                                                  <h3 class="info-count" style="font-size:96%;">คำขอการนำเข้าผลิตภัณฑ์ใช้ในประเทศ<br/>
                                                      <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-ray-end-arrow"></i></span>
                                                  </h3>
                                                  <p class="info-text font-12">(ตามมาตรา 21 ทวิ)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                            @endcan --}}
                        </div>
                    @endif


                  <legend class="legend">20 ตรี, 20 ทวิ</legend>

                  @if($user->can('view-'.str_slug('volume_20ter')) ||
                      $user->can('view-'.str_slug('volume_20bis')) ||
                      $user->can('view-'.str_slug('applicant_20ter')) ||
                      $user->can('view-'.str_slug('applicant_20bis')) ||
                      $user->can('view-'.str_slug('applicant_21bis'))
                     )

                      @if($user->can('view-'.str_slug('volume_20ter')) || $user->can('view-'.str_slug('volume_20bis')))
                        <div class="row colorbox-group-widget">
                            <div class="col-md-12 col-sm-12"><h4>5. แจ้ง 20 ตรี, 20 ทวิ</h4></div>

                            @can('view-'.str_slug('volume_20ter'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                <a href="{{ url('esurv/volume_20ter') }}">
                                  <div class="white-box">
                                      <div class="media bg-dashboard2">
                                          <div class="media-body">
                                              <h3 class="info-count" style="font-size:130%;">แจ้งผลการทำเพื่อการส่งออก<br/>
                                                <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-keyboard-tab"></i></span>
                                              </h3>
                                              <p class="info-text font-12">(ตามมาตรา 20 ตรี)</p>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                              </div>
                            @endcan

                            @can('view-'.str_slug('volume_20bis'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                <a href="{{ url('esurv/volume_20bis') }}">
                                  <div class="white-box">
                                      <div class="media bg-dashboard2">
                                          <div class="media-body">
                                              <h3 class="info-count" style="font-size:115%;">แจ้งการทำเพื่อใช้ในราชอาณาจักร<br/>
                                                <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-dots-horizontal"></i></span>
                                              </h3>
                                              <p class="info-text font-12">(ตามมาตรา 20 ทวิ)</p>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                              </div>
                            @endcan


                            {{-- <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                              <a href="{{ url('') }}">
                                <div class="white-box">
                                    <div class="media bg-dashboard2">
                                        <div class="media-body">
                                            <h3 class="info-count" style="font-size:107%;">แจ้งการนำเข้าเพื่อใช้ในราชอาณาจักร<br/>
                                              <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-keyboard-return"></i></span>
                                            </h3>
                                            <p class="info-text font-12">(ตามมาตรา 21 ทวิ)</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            </div> --}}
                        </div>
                      @endif


                  @else
                    <div class="alert alert-info"> <i class="fa fa-info-circle"></i> คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ </div>
                  @endif

                </fieldset>


                <fieldset class="white-box">

                  @if($user->can('view-'.str_slug('applicant_21ter')) ||
                          $user->can('view-'.str_slug('applicant_21bis'))
                         )
                        <div class="row colorbox-group-widget">
                            <div class="col-md-12 col-sm-12"><h4>6.ระบบยื่นคำขอ</h4></div>

                            @can('view-'.str_slug('applicant_21ter'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                  <a href="{{ url('esurv/applicant_21ter') }}">
                                  <div class="white-box">
                                          <div class="media bg-dashboard2">
                                              <div class="media-body">
                                                  <h3 class="info-count" style="font-size:116%;">คำขอการนำเข้าผลิตภัณฑ์เพื่อส่งออก<br/>
                                                      <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-ray-start-arrow"></i></span>
                                                  </h3>
                                                  <p class="info-text font-12">(ตามมาตรา 21 ตรี)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                            @endcan

                            @can('view-'.str_slug('applicant_21bis'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                  <a href="{{ url('esurv/applicant_21bis') }}">
                                      <div class="white-box">
                                          <div class="media bg-dashboard2">
                                              <div class="media-body">
                                                  <h3 class="info-count" style="font-size:70%;">คำขอการนำเข้าผลิตภัณฑ์เพื่อใช้ในประเทศเป็นการเฉพาะคราว<br/>
                                                      <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-ray-start-end"></i></span>
                                                  </h3>
                                                  <p class="info-text font-12">(ตามมาตรา 21 ทวิ)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                            @endcan

                            @can('view-'.str_slug('applicant_21own'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                  <a href="{{ url('esurv/applicant_21own') }}">
                                      <div class="white-box">
                                          <div class="media bg-dashboard2">
                                              <div class="media-body">
                                                  <h3 class="info-count" style="font-size:70%;">คำขอการนำเข้ามาโดยมิได้มีวัตถุประสงค์เพื่อจำหน่ายในราชอาณาจักร<br/>
                                                      <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-ray-start-end"></i></span>
                                                  </h3>
                                                  <p class="info-text font-12">(ตามมาตรา 21)</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                            @endcan

                        </div>
                    @endif


                  <legend class="legend">21 ตรี, 21 ทวิ</legend>

                  @if($user->can('view-'.str_slug('volume_21ter')) ||
                      $user->can('view-'.str_slug('volume_21bis')) ||
                      $user->can('view-'.str_slug('applicant_21ter')) ||
                      $user->can('view-'.str_slug('applicant_21bis'))
                     )

                      @if($user->can('view-'.str_slug('volume_21ter')) || $user->can('view-'.str_slug('volume_21bis')))
                        <div class="row colorbox-group-widget">
                            <div class="col-md-12 col-sm-12"><h4>7.แจ้ง 21 ตรี, 21 ทวิ</h4></div>

                            @can('view-'.str_slug('volume_21ter'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                <a href="{{ url('esurv/volume_21ter') }}">
                                  <div class="white-box">
                                      <div class="media bg-dashboard2">
                                          <div class="media-body">
                                              <h3 class="info-count" style="font-size:130%;">แจ้งผลการนำเข้าเพื่อการส่งออก<br/>
                                                <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-keyboard-tab"></i></span>
                                              </h3>
                                              <p class="info-text font-12">(ตามมาตรา 21 ตรี)</p>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                              </div>
                            @endcan

                            @can('view-'.str_slug('volume_21bis'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                <a href="{{ url('esurv/volume_21bis') }}">
                                  <div class="white-box">
                                      <div class="media bg-dashboard2">
                                          <div class="media-body">
                                              <h3 class="info-count" style="font-size:115%;">แจ้งผลการนำเข้าเพื่อใช้ในราชอาณาจักร<br/>
                                                <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-dots-horizontal"></i></span>
                                              </h3>
                                              <p class="info-text font-12">(ตามมาตรา 21 ทวิ)</p>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                              </div>
                            @endcan

                            @can('view-'.str_slug('volume_21own'))
                              <div class="col-md-4 col-sm-6 info-color-box waves-effect waves-light">
                                <a href="{{ url('esurv/volume_21own') }}">
                                  <div class="white-box">
                                      <div class="media bg-dashboard2">
                                          <div class="media-body">
                                              <h3 class="info-count" style="font-size:115%;">แจ้งผลการนำเข้าเพื่อนำมาใช้เอง<br/>
                                                <span class="pull-right" style="font-size:45px;"><i class="mdi mdi-dots-horizontal"></i></span>
                                              </h3>
                                              <p class="info-text font-12">(ตามมาตรา 21)</p>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                              </div>
                            @endcan

                        </div>
                      @endif


                  @else
                    <div class="alert alert-info"> <i class="fa fa-info-circle"></i> คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ </div>
                  @endif

                </fieldset>



            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
@endpush
