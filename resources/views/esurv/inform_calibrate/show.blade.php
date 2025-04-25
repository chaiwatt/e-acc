@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ผลการสอบเทียบ {{ $inform_calibrate->id }}</h3>
                    @can('view-'.str_slug('inform_calibrate'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_calibrate') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
                        </a>
                    @endcan
                    <div class="clearfix"></div>
                    <hr>

                    <form class="form-horizontal" role="form">
                      <div class="form-body">

                        <div class="form-group">
                            {!! Form::label('tb3_Tisno', 'มาตรฐาน:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">มอก.{{ $inform_calibrate->tis->tb3_Tisno }} {{ $inform_calibrate->tis->tb3_TisThainame }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('license', 'ใบอนุญาต:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-8">

                            <div class="row license-list">
                              <!-- แสดงเลขที่ใบอนุญาต -->
                              @foreach ($own_licenses as $key => $own_license)

                              <div class="col-md-4">
                                <div class="checkbox checkbox-success checkbox-active">
                                  <input name="tbl_licenseNo[]"
                                         id="license{{ $own_license->Autono }}"
                                         data-license="{{ $own_license->Autono }}"
                                         class="license-item" type="checkbox"
                                         value="{{ $own_license->tbl_licenseNo }}"
                                         disabled="disabled"
                                         @if(array_search(trim($own_license->tbl_licenseNo), $inform_change_licenses))
                                           checked="checked"
                                         @endif>
                                  <label for="license{{ $own_license->Autono }}"> {{ $own_license->tbl_licenseNo }} </label>
                                </div>
                              </div>

                              @endforeach

                            </div>

                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 control-label">โรงงาน:</label>
                          <div class="col-md-6" id="factory-box">

                            <!-- แสดงชื่อโรงงานและที่อยู่ -->
                            @php $factorys = []; @endphp
                            @foreach ($own_licenses as $key => $own_license)

                                @if(array_search(trim($own_license->tbl_licenseNo), $inform_change_licenses))
                                  @php
                                    $factory = $own_license->tbl_factoryName.' '.$own_license->tbl_factoryAddress;
                                  @endphp
                                  @if(!in_array($factory, $factorys))
                                    @php
                                      $factorys[] = $factory;
                                    @endphp
                                    <p class="form-control-static">{{ $factory }}</p>
                                  @endif
                                @endif

                            @endforeach

                          </div>
                        </div>

                        <div class="table-responsive">

                          <table class="table color-bordered-table info-bordered-table" id="table-detail">
                            <thead>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="col-md-2 text-center">ชื่อเครื่องมือ</th>
                                <th class="col-md-4 text-center">รายการที่ใช้วัด</th>
                                <th class="col-md-2 text-center">วันที่สอบเทียบ</th>
                                <th class="col-md-3 text-center">
                                  ผลการสอบเทียบ
                                  <div class="text-warning">รองรับไฟล์ .pdf และ .jpg ขนาดไม่เกิน 10 MB</div>
                                </th>
                              </tr>
                            </thead>
                            <tbody>

                              @foreach ($inform_details as $key => $inform_detail)
                                <tr>
                                  <td>{{ $key+1 }}.</td>
                                  <td>
                                    {{ $inform_detail->tool }}
                                  </td>
                                  <td class="td-detail">
                                    @foreach (json_decode($inform_detail->detail) as $key_detail => $detail)

                                      <div class="col-md-12">
                                        {{ $key_detail+1 }}.&nbsp;{{ $detail }}
                                      </div>

                                    @endforeach

                                  </td>
                                  <td class="text-center">
                                    {{ HP::DateThai($inform_detail->exam_date) }}
                                  </td>
                                  <td class="text-center">

                                    {{-- ดูไฟล์ --}}
                                      @foreach (json_decode($inform_detail->attach_result) as $attach_result)
                                        @if(HP::checkFileStorage($attach_path.$attach_result->file_name))
                                            <a href="{{ HP::getFileStorage($attach_path.$attach_result->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                                            <input type="hidden" name="attach_file[{{ $key }}][]" value="{{ $attach_result->file_name }}" />
                                        @endif
                                      @endforeach

                                  </td>
                                </tr>
                              @endforeach

                            </tbody>
                          </table>

                        </div>

                        <div class="form-group">
                          {!! Form::label('applicant_name', 'ชื่อผู้บันทึก:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">
                              {{ $inform_calibrate->applicant_name }}
                            </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('tel', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">
                              {{ $inform_calibrate->tel }}
                            </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">
                              {{ $inform_calibrate->email }}
                            </p>
                          </div>
                        </div>

                      </div>
                    </form>

                </div>
            </div>

            @if(!is_null($inform_calibrate->consider))
              <div class="col-md-12">
                  <div class="white-box">
                    <h3 class="box-title pull-left">บันทึกรับแจ้งผลการสอบเทียบเครื่องมือวัด</h3>

                    <div class="clearfix"></div>
                    <hr>

                    <form action="#" accept-charset="UTF-8" class="form-horizontal">

                      <div class="form-group">
                        {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">

                          <p class="form-control-static">
                            <span class="label {{ HP::StateCss()[$inform_calibrate->state] }}">
                              <b>{{ HP::States()[$inform_calibrate->state] }}</b>
                            </span>
                          </p>

                        </div>
                      </div>

                      <div class="form-group">
                        {!! Form::label('consider_comment', 'ความคิดเห็นเพิ่มเติม:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static"> {{ $inform_calibrate->consider_comment }} </p>
                        </div>
                      </div>

                      <div class="form-group">
                        {!! Form::label('consider', 'ผู้พิจารณา:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static"> {{ App\Models\Basic\Staff::find($inform_calibrate->consider)->FullName }} </p>
                        </div>
                      </div>
                      <div class="form-group">
                        {!! Form::label('reg_phone', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static"> {{ App\Models\Basic\Staff::find($inform_calibrate->consider)->reg_phone }} </p>
                        </div>
                      </div>
                      <div class="form-group">
                        {!! Form::label('reg_email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static"> {{ App\Models\Basic\Staff::find($inform_calibrate->consider)->reg_email }} </p>
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
