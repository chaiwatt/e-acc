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
    <legend><h4>คำขอรับบริการหน่วยตรวจ (IB)</h4></legend>

    <div class="row">

        @if(isset($certi_ib) && $certi_ib->status >= 6)
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
                        {{ !empty($certi_ib->save_date) ?   HP::formatDateThai($certi_ib->save_date) : '-' }}
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
                            {!! Form::radio('applicanttype_id', '1', !empty($tis_data->applicanttype_id=='1')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id1' ]) !!}
                            &nbsp;นิติบุคคล&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '2', !empty($tis_data->applicanttype_id=='2')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id2']) !!}
                            &nbsp;บุคคลธรรมดา&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '3', !empty($tis_data->applicanttype_id=='3')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id3']) !!}
                            &nbsp;คณะบุคคล&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '4', !empty($tis_data->applicanttype_id=='4')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id4']) !!}
                            &nbsp;ส่วนราชการ&nbsp;&nbsp;
                            {!! Form::radio('applicanttype_id', '5', !empty($tis_data->applicanttype_id=='5')?true:false, ['class'=>'check applicanttype_id', 'data-radio'=>'iradio_square-green','id'=>'applicanttype_id5']) !!}
                            &nbsp;อื่นๆ&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="app_name">ชื่อผู้ยื่นขอรับรองการรับรอง: <span class="">(Applicant)</span>  </label>
                            {!! Form::text('app_name', $tis_data->name ?? null, ['class' => 'form-control','disabled'=>true]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: <span class="">(Tax ID)</span>  </label>
                            {!! Form::text('certi_information[tax_indentification_number]' ,!empty($tis_data->tax_number) ? $tis_data->tax_number : null, ['class' => 'form-control id-inputmask','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[tax_indentification_number]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('certi_information[trader_address]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address]">มีสำนักงานใหญ่ตั้งอยู่เลขที่: <span class="">(Head office address)</span> </label>
                            {!! Form::text('certi_information[trader_address]',!empty($tis_data->address_no)? $tis_data->address_no : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_num"]) !!}
                            {!! $errors->first('certi_information[trader_address]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_address_soi]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address_soi]">ตรอก/ซอย: <span class="">(Trok/Soi)</span> </label>
                            {!! Form::text('certi_information[trader_address_soi]',!empty($tis_data->soi)? $tis_data->soi : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_soi"]) !!}
                            {!! $errors->first('certi_information[trader_address_soi]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_address_road]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address_road]">ถนน: <span class="">(Steet/Road)</span>  </label>
                            {!! Form::text('certi_information[trader_address_road]',!empty($tis_data->street)? $tis_data->street : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_street"]) !!}
                            {!! $errors->first('certi_information[trader_address_road]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_address_moo]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address_moo]">หมู่ที่: <span class="">(Moo)</span> </label>
                            {!! Form::text('certi_information[trader_address_moo]',!empty($tis_data->moo)? $tis_data->moo : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_moo"]) !!}
                            {!! $errors->first('certi_information[trader_address_moo]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_address_tumbol]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address_tumbol]">ตำบล/แขวง: <span class="">(Tambon/Khwarng)</span> </label>
                            {!! Form::text('certi_information[trader_address_tumbol]',!empty($tis_data->subdistrict)? $tis_data->subdistrict : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_tumbon"]) !!}
                            {!! $errors->first('certi_information[trader_address_tumbol]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_address_amphur]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address_amphur]">อำเภอ/เขต: <span class="">(Amphoe/Khet)</span> </label>
                            {!! Form::text('certi_information[trader_address_amphur]',!empty($tis_data->district)? $tis_data->district : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_area"]) !!}
                            {!! $errors->first('certi_information[trader_address_amphur]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_provinceID]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_provinceID]">จังหวัด: <span class="">(Province)</span> </label>
                            {!! Form::text('certi_information[trader_provinceID]',!empty($tis_data->province)? $tis_data->province : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_province"]) !!}
                            {!! $errors->first('certi_information[trader_provinceID]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_address_poscode]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_address_poscode]">รหัสไปรษณีย์: <span class="">(Zip code)</span> </label>
                            {!! Form::text('certi_information[trader_address_poscode]',!empty($tis_data->zipcode)? $tis_data->zipcode : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_post"]) !!}
                            {!! $errors->first('certi_information[trader_address_poscode]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_phone]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_phone]">โทรศัพท์: <span class="">(Telephone)</span> </label>
                            {!! Form::text('certi_information[trader_phone]',!empty($tis_data->tel)? $tis_data->tel : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_tel"]) !!}
                            {!! $errors->first('certi_information[trader_phone]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('certi_information[trader_fax]') ? 'has-error' : ''}}">
                            <label for="certi_information[trader_fax]">โทรสาร: </label>
                            {!! Form::text('certi_information[trader_fax]',!empty($tis_data->fax)? $tis_data->fax : null, ['class' => 'form-control','disabled'=>true,'id'=>"head_fax"]) !!}
                            {!! $errors->first('certi_information[trader_fax]', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="certi_information[trader_id_register]"  class="col-md-12">จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <span>(Juristic person registered date/month/year)</span> </label>
                        <div  class="col-md-4">
                            {!! Form::text('certi_information[trader_id_register]',!empty($tis_data->registerDate)? HP::revertDate( date('Y-m-d',strtotime($tis_data->registerDate)),true)  : null, ['class' => 'form-control ','disabled'=>true]) !!}
                            {!! $errors->first('certi_information[trader_id_register]', '<p class="help-block">:message</p>') !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
<script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
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
