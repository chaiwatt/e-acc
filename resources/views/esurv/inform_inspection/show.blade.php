@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">รายละเอียดการแจ้งผลการทดสอบผลิตภัณฑ์ {{ $inform_inspection->id }}</h3>
                    @can('view-'.str_slug('inform_inspection'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_inspection') }}">
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
                              <p class="form-control-static">มอก.{{ $inform_inspection->tis->tb3_Tisno }} {{ $inform_inspection->tis->tb3_TisThainame }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('tbl_licenseNo', 'ใบอนุญาต:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">{{ $inform_inspection->tbl_licenseNo }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('check_date', 'วันที่ตรวจ:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">{{ HP::DateThai($inform_inspection->check_date) }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('inspector', 'หน่วยงานที่ตรวจ:', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                              <p class="form-control-static">{{ !is_null($inform_inspection->inspector)?$inform_inspection->inspector_u->title:$inform_inspection->inspector_other }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('product_detail', 'รายละเอียดผลิตภัณฑ์:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">{{ $inform_inspection->product_detail }}</p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('remark', 'หมายเหตุ:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">{{ $inform_inspection->remark }}</p>
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
                              {{ $inform_inspection->applicant_name }}
                            </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('tel', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">
                              {{ $inform_inspection->tel }}
                            </p>
                          </div>
                        </div>

                        <div class="form-group">
                          {!! Form::label('email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                          <div class="col-md-6">
                            <p class="form-control-static">
                              {{ $inform_inspection->email }}
                            </p>
                          </div>
                        </div>

                      </div>
                    </form>

                </div>
            </div>

            @if(!is_null($inform_inspection->consider))
            <div class="col-md-12">
              <div class="white-box">
                <h3 class="box-title pull-left">บันทึกรับแจ้งผลการทดสอบผลิตภัณฑ์</h3>

                <div class="clearfix"></div>
                <hr>

                <form class="form-horizontal">

                    <div class="form-group">
                      {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
                      <div class="col-md-6">
                        
                        <p class="form-control-static">
                          <span class="label {{ HP::StateCss()[$inform_inspection->state] }}">
                            <b>{{ HP::States()[$inform_inspection->state] }}</b>
                          </span>
                        </p>

                      </div>
                    </div>

                    <div class="form-group">
                      {!! Form::label('consider_comment', 'ความคิดเห็นเพิ่มเติม:', ['class' => 'col-md-4 control-label']) !!}
                      <div class="col-md-6">
                        <p class="form-control-static">
                          {{ $inform_inspection->consider_comment }}
                        </p>
                      </div>
                    </div>

                    <div class="form-group">
                      {!! Form::label('consider', 'ผู้พิจารณา:', ['class' => 'col-md-4 control-label']) !!}
                      <div class="col-md-6">
                        <p class="form-control-static">
                          {{ App\Models\Basic\Staff::find($inform_inspection->consider)->FullName }}
                        </p>
                      </div>
                    </div>
                    <div class="form-group">
                      {!! Form::label('reg_phone', 'เบอร์โทร:', ['class' => 'col-md-4 control-label']) !!}
                      <div class="col-md-6">
                        <p class="form-control-static">
                          {{ App\Models\Basic\Staff::find($inform_inspection->consider)->reg_phone }}
                        </p>
                      </div>
                    </div>
                    <div class="form-group">
                      {!! Form::label('reg_email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
                      <div class="col-md-6">
                        <p class="form-control-static">
                          {{ App\Models\Basic\Staff::find($inform_inspection->consider)->reg_email }}
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
