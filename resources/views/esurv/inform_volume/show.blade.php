@extends('layouts.master')

@push('css')
<style type="text/css">
  .panel-body-info {
    border: #00bbd9 1px solid;
  }
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">รายละเอียดการแจ้งปริมาณการผลิตตามเงื่อนไข {{ $inform_volume->id }}</h3>
                    @can('view-'.str_slug('inform_volume'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_volume') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
                        </a>
                    @endcan

                    <div class="clearfix"></div>
                    <hr>

                    <form class="form-horizontal" role="form">
                        <div class="form-body">

                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">เดือน:</label>
                                      <div class="col-md-9">
                                          <p class="form-control-static"> {{ HP::MonthList()[$inform_volume->inform_month] }} </p>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="control-label col-md-3">ปี:</label>
                                      <div class="col-md-9">
                                        <p class="form-control-static"> {{ $inform_volume->inform_year+543 }} </p>
                                      </div>
                                  </div>
                              </div>

                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="panel panel-primary">
                                <div class="panel-heading">ข้อมูลปริมาณการผลิต</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                  <div class="panel-body panel-body-info">

                                    <div class="form-group">
                                      {!! Form::label('tb3_Tisno', 'มาตรฐาน:', ['class' => 'col-md-2 control-label']) !!}
                                      <div class="col-md-8">
                                        <p class="form-control-static">มอก.{{ @$inform_volume->tis->tb3_Tisno }} {{ @$inform_volume->tis->tb3_TisThainame }}</p>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      {!! Form::label('license', 'ใบอนุญาต:', ['class' => 'col-md-2 control-label']) !!}
                                      <div class="col-md-8">

                                        <div class="row license-list">
                                          <!-- แสดงเลขที่ใบอนุญาต -->
                                          @foreach ($own_licenses as $key => $own_license)
                                            @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses))

                                          <div class="col-md-4">
                                            <div class="checkbox checkbox-success checkbox-active">
                                              <input name="tbl_licenseNo[]"
                                                     id="license{{ $own_license->Autono }}"
                                                     data-license="{{ $own_license->Autono }}"
                                                     class="license-item"
                                                     type="checkbox"
                                                     value="{{ $own_license->tbl_licenseNo }}"
                                                     disabled="disabled"
                                                     @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses))
                                                       checked="checked"
                                                     @endif>
                                                <label for="license{{ $own_license->Autono }}"> {{ $own_license->tbl_licenseNo }} </label>
                                            </div>
                                          </div>

                                            @endif
                                          @endforeach

                                        </div>

                                      </div>
                                    </div>

                                    <div class="form-group">

                                      <div class="row license-detail col-md-12">
                                        <!-- แสดงรายละเอียดรายการในใบอนุญาต -->

                                        @if(!empty($inform_volume->starndard->tb3_Tisforce) &&  $inform_volume->starndard->tb3_Tisforce!='บ')

                                        {{-- {{ 1 }} --}}

                                          @foreach ($own_licenses as $key => $own_license)

                                          @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses)===false)
                                            @continue
                                          @endif

                                            <div class="col-md-12 detail-item" id="detail{{ $own_license->Autono }}">
                                              <h5>
                                                <span class="order">{{ $key+1 }}</span>. ใบอนุญาตเลขที่ <span class="text-info">{{ $own_license->tbl_licenseNo }}</span> <span class="text-success">(มาตรฐานทั่วไป)</span>
                                              </h5>
                                              <div class="table-responsive">
                                                <table class="table color-bordered-table info-bordered-table" id="table-detail{{ $own_license->Autono }}">
                                                  <thead>
                                                    <tr>
                                                      <th class="col-md-1 text-center" rowspan="2">รายการที่</th>
                                                      <th class="col-md-5 text-center" rowspan="2">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>
                                                      <th class="col-md-4 text-center" colspan="2">ปริมาณการผลิต</th>
                                                      <th class="col-md-2 text-center" rowspan="2">หน่วย</th>
                                                    </tr>
                                                    <tr>
                                                      <th class="text-center">แสดง</th>
                                                      <th class="text-center">ไม่แสดง</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach ($details[$own_license->tbl_licenseNo] as $key => $detail)

                                                    <tr>
                                                      <td class="text-center">{{ $key+1 }}.</td>
                                                      <td>{{ $detail->standard_detail }}</td>
                                                      <td>
                                                        <div class="col-md-12">
                                                          <div class="checkbox checkbox-success checkbox-active">
                                                            <input id="license-detail1-{{ $detail->id }}"
                                                                   name="license_detail_checked[{{ $detail->id }}][2]"
                                                                   class="license-detail-item"
                                                                   type="checkbox"
                                                                   disabled="disabled"
                                                                   value="{{ $detail->id }}"
                                                                   @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume2))
                                                                     checked="checked"
                                                                   @endif
                                                            />
                                                            <label for="license-detail1-{{ $detail->id }}">
                                                              ผลิต
                                                              @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume2))
                                                                {{ $inform_details[$detail->id]->volume2 }}
                                                              @endif
                                                            </label>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td>
                                                        <div class="col-md-5">
                                                          <div class="checkbox checkbox-success">
                                                            <input id="license-detail2-{{ $detail->id }}"
                                                                   name="license_detail_checked[{{ $detail->id }}][3]"
                                                                   class="license-detail-item"
                                                                   type="checkbox"
                                                                   value="{{ $detail->id }}"
                                                                   disabled="disabled"
                                                                   @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume3))
                                                                      checked="checked"
                                                                   @endif
                                                            />
                                                            <label for="license-detail2-{{ $detail->id }}">
                                                              ผลิต
                                                              @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume3))
                                                                {{ $inform_details[$detail->id]->volume3 }}
                                                              @endif
                                                            </label>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class="text-center">
                                                        @if(array_key_exists($detail->id, $inform_details) && (!is_null($inform_details[$detail->id]->volume2) || !is_null($inform_details[$detail->id]->volume3)))
                                                          <p class="form-control-static">{{ App\Models\Basic\UnitCode::find($inform_details[$detail->id]->unit)->name_unit ?? 'n/a' }}</p>
                                                        @endif
                                                      </td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>

                                            @endforeach

                                            @else

                                            {{-- {{ 2 }} --}}

                                            {{-- {{ dd($inform_volume_licenses) }} --}}

                                            {{-- {{ dd($own_licenses) }} --}}

                                                @foreach ($own_licenses as $key => $own_license)

                                                  @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses)===false)
                                                    @continue
                                                  @endif

                                                  <div class="col-md-12 detail-item" id="detail{{ $own_license->Autono }}">
                                                    <h5>
                                                      <span class="order">{{ $key+1 }}</span>. ใบอนุญาตเลขที่ <span class="text-info">{{ $own_license->tbl_licenseNo }}</span> <span class="text-danger">(มาตรฐานบังคับ)</span>
                                                    </h5>

                                                    <div class="table-responsive">

                                                      <table class="table color-bordered-table info-bordered-table" id="table-detail{{ $own_license->Autono }}">
                                                        <thead>
                                                          <tr>
                                                            <th class="col-md-1 text-center">รายการที่</th>
                                                            <th class="col-md-6 text-center">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>
                                                            <th class="col-md-3 text-center">ปริมาณการผลิต</th>
                                                            <th class="col-md-2 text-center">หน่วย</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          @foreach ($details[$own_license->tbl_licenseNo] as $key => $detail)

                                                            <tr>
                                                              <td class="text-center">{{ $key+1 }}.</td>
                                                              <td>{{ $detail->standard_detail }}</td>
                                                              <td>
                                                                <div class="col-md-5">
                                                                  <div class="checkbox checkbox-success checkbox-active">
                                                                    <input id="license-detail{{ $detail->id }}"
                                                                           name="license_detail_checked[{{ $detail->id }}][1]"
                                                                           class="license-detail-item"
                                                                           type="checkbox"
                                                                           disabled="disabled"
                                                                           value="{{ $detail->id }}"
                                                                           @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume1))
                                                                             checked="checked"
                                                                           @endif
                                                                    />
                                                                    <label for="license-detail{{ $detail->id }}"> ผลิต </label>
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume1))
                                                                      <p class="form-control-static">{{ $inform_details[$detail->id]->volume1 }}</p>
                                                                    @endif
                                                                </div>
                                                              </td>
                                                              <td class="text-center">
                                                                @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume1))
                                                                  <p class="form-control-static">{{ App\Models\Basic\UnitCode::find($inform_details[$detail->id]->unit)->name_unit ?? 'n/a' }}</p>
                                                                @endif
                                                              </td>
                                                            </tr>
                                                          @endforeach
                                                        </tbody>
                                                      </table>

                                                    </div>

                                                  </div>

                                                  @endforeach

                                              @endif
                                      </div>

                                    </div>

                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>

                          <div class="form-group">
                            {!! Form::label('remark', 'หมายเหตุ:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">{{ $inform_volume->remark }}</p>
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Html::decode(Form::label('attach', 'ไฟล์แนบเอกสารที่เกี่ยวข้อง:<br><span class="text-muted">รองรับไฟล์ .pdf และ .jpg ขนาดไม่เกิน 10 MB</span>', ['class' => 'col-md-4 control-label'])) !!}
                            <div class="col-md-8">

                                @foreach ($attachs as $key => $attach)

                                <div class="form-group">
                                  <div class="col-md-12">
                                    <p class="form-control-static">
                                      {{ !is_null($attach->file_note)?$attach->file_note:$attach->file_client_name }}
                                      @if($attach->file_name!='' && HP::checkFileStorage($attach_path.$attach->file_name))
                                        <a href="{{ HP::getFileStorage($attach_path.$attach->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                                      @endif
                                    </p>
                                  </div>
                                </div>

                                @endforeach

                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('applicant_name', 'ชื่อผู้บันทึก:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">
                                {{ $inform_volume->applicant_name }}
                              </p>
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('tel', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">
                                {{ $inform_volume->tel }}
                              </p>
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">
                                {{ $inform_volume->email }}
                              </p>
                            </div>
                          </div>

                        </div>
                      </form>

                </div>
            </div>
            <!-- End Show Form Detail -->

            @if(!is_null($inform_volume->consider))
              <div class="col-md-12">
                  <div class="white-box">
                    <h3 class="box-title pull-left">บันทึกรับแจ้งปริมาณการผลิตตามเงื่อนไข</h3>

                    <div class="clearfix"></div>
                    <hr>

                    <form action="#" accept-charset="UTF-8" class="form-horizontal">

                        <div class="form-group">
                          {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">
                              <span class="label {{ HP::StateCss()[$inform_volume->state] }}">
                                <b>{{ HP::States()[$inform_volume->state] }}</b>
                              </span>
                            </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('consider_comment', 'ความคิดเห็นเพิ่มเติม:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static"> {{ $inform_volume->consider_comment }} </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('consider', 'ผู้พิจารณา:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static"> {{ App\Models\Basic\Staff::find($inform_volume->consider)->FullName }} </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('reg_phone', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static"> {{  App\Models\Basic\Staff::find($inform_volume->consider)->reg_phone }} </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('reg_email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static"> {{ App\Models\Basic\Staff::find($inform_volume->consider)->reg_email }} </p>
                          </div>
                        </div>

                    </form>

                    <div class="clearfix"></div>

                  </div>
                </div>
              @endif


        </div>
    </div>

@endsection
