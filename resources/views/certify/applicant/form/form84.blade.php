@push('css')
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
<style type="text/css">
        .input_background_color{
            background-color: rgb(232, 253, 246);
        }
        .input-show[disabled]{
            background-color: #FFFFFF;
        }

        .label-height{
            line-height: 16px;
        }

        .font_size{
            font-size: 10px;
        }
</style>
@endpush
<div class="white-box">
    <div class="box-title">
        <legend><h4>คำขอรับบริการห้องปฏิบัติการ (LAB)</h4></legend>
    </div>
    <div class="row">

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
                            <label for="app_name">ชื่อผู้ยื่นขอรับรองการรับรอง: <span>(Applicant)</span> </label>
                            <input type="text" id="app_name" name="app_name" class="form-control input_background_color " readonly value="{{$tis_data->name ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: <span>(Tax ID)</span>  </label>
                            <input type="text" id="id_tax" name="id_tax" class="form-control input_background_color id-inputmask" readonly  value="{{ !empty($tis_data->tax_number) ? $tis_data->tax_number : null }}">
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        @if($tis_data->trader_type!='นิติบุคคล')
                            <div class="form-group">
                                <label for="app_old">อายุ: </label>
                                <input type="number" id="app_old" name="app_old" class="form-control input_background_color" >
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($tis_data->trader_type!='นิติบุคคล')
                            <div class="form-group">
                                <label for="app_nation">สัญชาติ: </label>
                                <input type="text" id="app_nation" name="app_nation" class="form-control input_background_color">
                            </div>
                        @endif
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_num">อยู่บ้านเลขที่: </label>
                            <input type="text" id="home_num" name="home_num" class="form-control input_background_color" readonly  value="{{$tis_data->trader_address ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_soi">ตรอก/ซอย: </label>
                            <input type="text" id="home_soi" name="home_soi" class="form-control input_background_color" readonly  value="{{$tis_data->trader_address_soi ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_street">ถนน: </label>
                            <input type="text" id="home_street" name="home_street" class="form-control input_background_color" readonly value="{{ $tis_data->trader_address_road ?? '-'}}">
                        </div>
                    </div>
                </div>
            </div> --}}
{{--
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_moo">หมู่ที่: </label>
                            <input type="text" id="home_moo" name="home_moo" class="form-control input_background_color" readonly value="{{$tis_data->trader_address_moo ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_province">จังหวัด: </label>
                            <input type="text" id="home_province" name="home_province" class="form-control input_background_color" readonly  value="{{$tis_data->trader_provinceID ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_area" >อำเภอ/เขต: </label>
                            <input type="text" id="home_area" name="home_area" class="form-control input_background_color" readonly value="{{$tis_data->trader_address_amphur ?? '-'}}">
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_tumbon" >ตำบล/แขวง: </label>
                            <input type="text" id="home_tumbon" name="home_tumbon" class="form-control input_background_color" readonly  value="{{$tis_data->trader_address_tumbol ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_post">ไปรษณีย์: </label>
                            <input type="number" id="home_post" name="home_post" class="form-control input_background_color" readonly  value="{{$tis_data->trader_address_poscode ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_phone">โทรศัพท์: </label>
                            <input type="text" id="home_phone" name="home_phone" class="form-control input_background_color" readonly value="{{$tis_data->trader_phone ?? '-'}}">
                        </div>
                    </div>
                </div>
            </div> --}}
           {{--   <div class="col-md-12">
                <div class="row">
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_card">เลขประจำตัวประชาชน: </label>
                            <input type="text" id="id_card" name="id_card" class="form-control input_background_color id-inputmask" value="{{ $tis_data->trader_id }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: </label>
                        <input type="text" id="id_tax" name="id_tax" class="form-control input_background_color id-inputmask" readonly  value="{{ $tis_data->trader_id }}">
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="head_num">มีสำนักงานใหญ่ตั้งอยู่เลขที่: <span>(Head office address)</span> </label>
                            <input type="text" id="head_num" name="head_num" class="form-control" readonly  value="{{ !empty($tis_data->address_no)? $tis_data->address_no : null }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_soi">ตรอก/ซอย: <span>(Trok/Soi)</span> </label>
                            <input type="text" id="head_soi" name="head_soi" class="form-control" readonly  value="{{ !empty($tis_data->soi)? $tis_data->soi : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_street">ถนน: <span>(Steet/Road)</span> </label>
                            <input type="text" id="head_street" name="head_street" class="form-control"  readonly  value="{{ !empty($tis_data->street)? $tis_data->street : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_moo">หมู่ที่: <span>(Moo)</span> </label>
                            <input type="text" id="head_moo" name="head_moo" class="form-control" readonly  value="{{ !empty($tis_data->moo)? $tis_data->moo : null }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_tumbon">ตำบล/แขวง: <span>(Tambon/Khwarng)</span> </label>
                            <input type="text" id="head_tumbon" name="head_tumbon" class="form-control" readonly  value="{{ !empty($tis_data->subdistrict)? $tis_data->subdistrict : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_area">อำเภอ/เขต: <span>(Amphoe/Khet)</span> </label>
                            <input type="text" id="head_area" name="head_area" class="form-control"  readonly value="{{ !empty($tis_data->district)? $tis_data->district : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_province">จังหวัด: <span>(Province)</span> </label>
                            <input type="text" id="head_province" name="head_province" class="form-control"  readonly  value="{{ !empty($tis_data->province)? $tis_data->province : null }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_post">รหัสไปรษณีย์: <span>(Zip code)</span> </label>
                            <input type="text" id="head_post" name="head_post" class="form-control" readonly value="{{ !empty($tis_data->zipcode)? $tis_data->zipcode : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_tel">โทรศัพท์: <span>(Telephone)</span> </label>
                            <input type="text" id="head_tel" name="head_tel" class="form-control" readonly  value="{{ !empty($tis_data->tel)? $tis_data->tel : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_fax">โทรสาร: </label>
                            <input type="text" id="head_fax" name="head_fax" class="form-control" readonly value="{{ !empty($tis_data->fax)? $tis_data->fax : null }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="entity_date"  class="col-md-12">จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <span>(Juristic person registered date/month/year)</span> </label>
                            {{-- mydatepicker_th --}}
                        <div  class="col-md-4">
                            <input type="text" id="entity_date" name="entity_date" class="form-control " readonly  value="{{  !empty($tis_data->registerDate)? HP::revertDate( date('Y-m-d', strtotime($tis_data->registerDate)),true)  : null }}">
                        </div>

                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="license_no">ทะเบียนเลขที่: </label>
                            <input type="text" id="license_no" name="license_no" class="form-control" readonly  value="{{$tis_data->trader_id ?? '-'}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="commerce_no">ทะเบียนพาณิชย์เลขที่: </label>
                            <input type="text" id="commerce_no" name="commerce_no" readonly class="form-control">
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
