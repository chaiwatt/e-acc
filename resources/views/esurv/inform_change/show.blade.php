@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">รายละเอียดการแจ้งเปลี่ยนแปลงที่มีผลต่อคุณภาพ {{ $inform_change->id }}</h3>
                    @can('view-'.str_slug('inform_change'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_change') }}">
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
                                <p class="form-control-static">มอก.{{ $inform_change->tis->tb3_Tisno }} {{ $inform_change->tis->tb3_TisThainame }}</p>
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
                                           @if(array_search($own_license->tbl_licenseNo, $inform_change_licenses))
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
                              {!! Form::label('detail', 'รายละเอียด:', ['class' => 'col-md-4 control-label']) !!}
                              <div class="col-md-6">
                                <p class="form-control-static">{{ $inform_change->detail }}</p>
                              </div>
                          </div>

                          <div class="form-group">
                              {!! Form::label('remark', 'หมายเหตุ:', ['class' => 'col-md-4 control-label']) !!}
                              <div class="col-md-6">
                                <p class="form-control-static">{{ $inform_change->remark }}</p>
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
                                {{ $inform_change->applicant_name }}
                              </p>
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('tel', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">
                                {{ $inform_change->tel }}
                              </p>
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">
                                {{ $inform_change->email }}
                              </p>
                            </div>
                          </div>

                        </div>
                      </form>

                </div>
            </div>

            @if(!is_null($inform_change->consider))
              <div class="col-md-12">
                <div class="white-box">
                  <h3 class="box-title pull-left">บันทึกรับแจ้งการเปลี่ยนแปลงที่มีผลต่อคุณภาพ</h3>

                  <div class="clearfix"></div>
                  <hr>

                  <form class="form-horizontal">

                      <div class="form-group">
                        {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static">
                            <span class="label {{ HP::StateCss()[$inform_change->state] }}">
                              <b>{{ HP::States()[$inform_change->state] }}</b>
                            </span>
                          </p>
                        </div>
                      </div>

                      <div class="form-group">
                        {!! Form::label('consider_comment', 'ความคิดเห็นเพิ่มเติม:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static">
                            {{ $inform_change->consider_comment }}
                          </p>
                        </div>
                      </div>

                      <div class="form-group">
                        {!! Form::label('consider', 'ผู้พิจารณา:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static">
                            {{ App\Models\Basic\Staff::find($inform_change->consider)->FullName }}
                          </p>
                        </div>
                      </div>

                      <div class="form-group">
                        {!! Form::label('reg_phone', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static">
                            {{ App\Models\Basic\Staff::find($inform_change->consider)->reg_phone }}
                          </p>
                        </div>
                      </div>

                      <div class="form-group">
                        {!! Form::label('reg_email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                          <p class="form-control-static">
                            {{ App\Models\Basic\Staff::find($inform_change->consider)->reg_email }}
                          </p>
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
