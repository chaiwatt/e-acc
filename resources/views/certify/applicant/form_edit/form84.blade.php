@push('css')
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
<style type="text/css">
    .label-height{
        line-height: 16px;
    }

    .font_size{
        font-size: 10px;
    }
</style>
@endpush
<div class="white-box" style="border: 2px solid #e5ebec;">
    <legend><h4>คำขอรับบริการห้องปฏิบัติการ (LAB)</h4></legend>

    <div class="row">
  @if($certi_lab->status >= 9)
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('head_num') ? 'has-error' : ''}}">
                        <label for="app_no" class="control-label">เลขที่คำขอ: </label>
                        {!! Form::text('app_no',null, ['class' => 'form-control text-center','disabled'=>true]) !!}
                    </div>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-3 text-center">
                    <p>
                        {{ !empty($certi_lab->check->ResultReportDate) ?   $certi_lab->check->ResultReportDate : '-' }}
                    </p>
                </div>
            </div>
        </div>
  @endif
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12 m-t-20">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="app_name">ประเภทผู้ยื่นคำขอ </label>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('trader_type') ? 'has-error' : ''}}">    
                        <div class="col-md-9" >
                            {!! Form::radio('applicanttype_id', '1', !empty($certi_lab->applicanttype_id=='1')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id1' ]) !!}
                            &nbsp;นิติบุคคล&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '2', !empty($certi_lab->applicanttype_id=='2')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id2']) !!}
                            &nbsp;บุคคลธรรมดา&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '3', !empty($certi_lab->applicanttype_id=='3')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id3']) !!}
                            &nbsp;คณะบุคคล&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '4', !empty($certi_lab->applicanttype_id=='4')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id4']) !!}
                            &nbsp;ส่วนราชการ&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '5', !empty($certi_lab->applicanttype_id=='5')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id5']) !!}
                            &nbsp;อื่นๆ&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="app_name">ชื่อผู้ยื่นขอรับรองการรับรอง: <span class="">(Applicant)</span>  </label>
                            {!! Form::text('app_name', null, ['class' => 'form-control','disabled'=>true]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: <span class="">(Tax ID)</span>  </label>
                            {!! Form::text('certi_information[tax_indentification_number]',!empty($certi_information->tax_indentification_number)? $certi_information->tax_indentification_number : null, ['class' => 'form-control id-inputmask','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[tax_indentification_number]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        @if(!is_null($certi_lab->trader) && $certi_lab->trader->trader_type!='นิติบุคคล')
                            <div class="form-group">
                                <label for="app_old">อายุ: </label>
                                {!! Form::text('app_old',null, ['class' => 'form-control','disabled'=>true]) !!}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if(!is_null($certi_lab->trader) && $certi_lab->trader->trader_type!='นิติบุคคล')
                            <div class="form-group">
                                <label for="app_nation">สัญชาติ: </label>
                                {!! Form::text('app_nation',null, ['class' => 'form-control','disabled'=>true]) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            {{-- <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_num') ? 'has-error' : ''}}">
                            <label for="home_num">อยู่บ้านเลขที่: </label>
                            {!! Form::text('home_num',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_num"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_soi') ? 'has-error' : ''}}">
                            <label for="home_soi">ตรอก/ซอย: </label>
                            {!! Form::text('home_soi',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_soi"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_street') ? 'has-error' : ''}}">
                            <label for="home_street">ถนน: </label>
                            {!! Form::text('home_street',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_street"]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_moo') ? 'has-error' : ''}}">
                            <label for="home_moo">หมู่ที่: </label>
                            {!! Form::text('home_moo',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_moo"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_province') ? 'has-error' : ''}}">
                            <label for="home_province">จังหวัด: </label>
                            {!! Form::text('home_province',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_province"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_area') ? 'has-error' : ''}}">
                            <label for="home_area" >อำเภอ/เขต: </label>
                            {!! Form::text('home_area',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_area"]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_tumbon') ? 'has-error' : ''}}">
                            <label for="home_tumbon" >ตำบล/แขวง: </label>
                            {!! Form::text('home_tumbon',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_tumbon"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_post') ? 'has-error' : ''}}">
                            <label for="home_post">ไปรษณีย์: </label>
                            {!! Form::text('home_post',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_post"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('home_phone') ? 'has-error' : ''}}">
                            <label for="home_phone">โทรศัพท์: </label>
                            {!! Form::text('home_phone',null, ['class' => 'form-control','disabled'=>true,'id'=>"home_phone"]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('certi_information[tax_indentification_number]') ? 'has-error' : ''}}">
                            <label for="certi_information[tax_indentification_number]">เลขประจำตัวผู้เสียภาษีอากร: </label>
                            {!! Form::text('certi_information[tax_indentification_number]',!empty($certi_information->tax_indentification_number)? $certi_information->tax_indentification_number : null, ['class' => 'form-control','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[tax_indentification_number]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('certi_information[address_headquarters]') ? 'has-error' : ''}}">
                            <label for="certi_information[address_headquarters]">มีสำนักงานใหญ่ตั้งอยู่เลขที่: <span class="">(Head office address)</span> </label>
                            {!! Form::text('certi_information[address_headquarters]',!empty($certi_information->address_headquarters)? $certi_information->address_headquarters : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_num"]) !!}
                            {!! $errors->first('certi_information[address_headquarters]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_alley]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_alley]">ตรอก/ซอย: <span class="">(Trok/Soi)</span> </label>
                            {!! Form::text('certi_information[headquarters_alley]',!empty($certi_information->headquarters_alley)? $certi_information->headquarters_alley : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_soi"]) !!}
                            {!! $errors->first('certi_information[headquarters_alley]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_road]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_road]">ถนน: <span class="">(Steet/Road)</span>  </label>
                            {!! Form::text('certi_information[headquarters_road]',!empty($certi_information->headquarters_road)? $certi_information->headquarters_road : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_street"]) !!}
                            {!! $errors->first('certi_information[headquarters_road]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_village_no]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_village_no]">หมู่ที่: <span class="">(Moo)</span> </label>
                            {!! Form::text('certi_information[headquarters_village_no]',!empty($certi_information->headquarters_village_no)? $certi_information->headquarters_village_no : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_moo"]) !!}
                            {!! $errors->first('certi_information[headquarters_village_no]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_district]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_district]">ตำบล/แขวง: <span class="">(Tambon/Khwarng)</span> </label>
                            {!! Form::text('certi_information[headquarters_district]',!empty($certi_information->headquarters_district)? $certi_information->headquarters_district : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_tumbon"]) !!}
                            {!! $errors->first('certi_information[headquarters_district]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_amphur]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_amphur]">อำเภอ/เขต: <span class="">(Amphoe/Khet)</span> </label>
                            {!! Form::text('certi_information[headquarters_amphur]',!empty($certi_information->headquarters_district)? $certi_information->headquarters_district : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_area"]) !!}
                            {!! $errors->first('certi_information[headquarters_amphur]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_province]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_province]">จังหวัด: <span class="">(Province)</span> </label>
                            {!! Form::text('certi_information[headquarters_province]',!empty($certi_information->headquarters_province)? $certi_information->headquarters_province : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_province"]) !!}
                            {!! $errors->first('certi_information[headquarters_province]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_postcode]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_postcode]">รหัสไปรษณีย์: <span class="">(Zip code)</span> </label>
                            {!! Form::text('certi_information[headquarters_postcode]',!empty($certi_information->headquarters_postcode)? $certi_information->headquarters_postcode : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_post"]) !!}
                            {!! $errors->first('certi_information[headquarters_postcode]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_tel]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_tel]">โทรศัพท์: <span class="">(Telephone)</span> </label>
                            {!! Form::text('certi_information[headquarters_tel]',!empty($certi_information->headquarters_tel)? $certi_information->headquarters_tel : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_tel"]) !!}
                            {!! $errors->first('certi_information[headquarters_tel]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[headquarters_tel_fax]') ? 'has-error' : ''}}">
                            <label for="certi_information[headquarters_tel_fax]">โทรสาร: </label>
                            {!! Form::text('certi_information[headquarters_tel_fax]',!empty($certi_information->headquarters_tel_fax)? $certi_information->headquarters_tel_fax : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_fax"]) !!}
                            {!! $errors->first('certi_information[headquarters_tel_fax]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="certi_information[date_regis_juristic_person]"  class="col-md-12">จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <span>(Juristic person registered date/month/year)</span> </label>
                            {{-- mydatepicker_th --}}
                        <div  class="col-md-4">
                            {!! Form::text('certi_information[date_regis_juristic_person]',!empty($certi_information->date_regis_juristic_person)? HP::revertDate(\Carbon\Carbon::parse($certi_information->date_regis_juristic_person)->format('Y-m-d') ,true) ?? ''  : null, ['class' => 'form-control ','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[date_regis_juristic_person]', '<p class="help-block">:message</p>') !!}
                        </div>

                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group {{ $errors->has('certi_information[registration_number]') ? 'has-error' : ''}}">
                            <label for="certi_information[registration_number]">ทะเบียนเลขที่: </label>
                            {!! Form::text('certi_information[registration_number]',!empty($certi_information->registration_number)? $certi_information->registration_number : null, ['class' => 'form-control','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[registration_number]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->has('certi_information[commercial_registration]') ? 'has-error' : ''}}">
                            <label for="certi_information[commercial_registration]">ทะเบียนพาณิชย์เลขที่: </label>
                            {!! Form::text('certi_information[commercial_registration]',!empty($certi_information->commercial_registration)? $certi_information->commercial_registration : null, ['class' => 'form-control','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[commercial_registration]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

    </div>
</div>
@push('js')
<script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
<script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('js/mask/mask.init.js')}}"></script>
  <!-- input calendar thai -->
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
  <!-- thai extension -->
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script>
        $(document).ready(function () {
            //ปฎิทิน
            $('.mydatepicker_th').datepicker({
                toggleActive: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });


        });
    </script>
@endpush
