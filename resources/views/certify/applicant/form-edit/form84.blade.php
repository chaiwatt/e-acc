@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <style>

    </style>
@endpush
<div class="white-box">
    <div class="box-title">
        <h3>คำขอรับใบรับรองห้องปฏิบัติการ</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="app_no" class="control-label">เลขที่คำขอ:</label>
                        {{-- <input type="text" class="form-control text-center" readonly value=" {{ $certi_information->certi_lab->app_no }} " > --}}
                        <input type="text" class="form-control text-center" readonly value=" {{ $certi_lab->app_no }} " >
                    </div>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-3 text-center">
                    <?php $date = \Carbon\Carbon::parse($certi_information->created_at);
                          $month = array(
                              "0"=>"",
                              "1"=>"มกราคม",
                              "2"=>"กุมภาพันธ์",
                              "3"=>"มีนาคม",
                              "4"=>"เมษายน",
                              "5"=>"พฤษภาคม",
                              "6"=>"มิถุนายน",
                              "7"=>"กรกฎาคม",
                              "8"=>"สิงหาคม",
                              "9"=>"กันยายน",
                              "10"=>"ตุลาคม",
                              "11"=>"พฤศจิกายน",
                              "12"=>"ธันวาคม"
                          );
                    ?>
                    <p>
                        วันที่ {{$date->day}} เดือน {{$month[$date->month]}} พ.ศ. {{$date->year + (int)543}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12 m-t-20">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="app_name">ข้าพเจ้า: </label>
                            <input type="text" id="app_name" name="app_name" class="form-control" value="{{ $certi_information->name }}" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="app_old">อายุ: </label>
                            <input type="number" id="app_old" name="app_old" class="form-control" value="{{ $certi_information->ages }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="app_nation">สัญชาติ: </label>
                            <input type="text" id="app_nation" name="app_nation" class="form-control" value="{{ $certi_information->nationality }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_num">อยู่บ้านเลขที่: </label>
                            <input type="text" id="home_num" name="home_num" class="form-control" value="{{ $certi_information->address_no }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_soi">ตรอก/ซอย: </label>
                            <input type="text" id="home_soi" name="home_soi" class="form-control" value="{{ $certi_information->alley }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_street">ถนน: </label>
                            <input type="text" id="home_street" name="home_street" class="form-control" value="{{ $certi_information->road }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_moo">หมู่ที่: </label>
                            <input type="number" id="home_moo" name="home_moo" class="form-control" value="{{ $certi_information->village_no }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_province">จังหวัด: </label>
                            <input type="text" id="home_province" name="home_province" class="form-control" value="{{ $certi_information->province }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_area" >อำเภอ/เขต: </label>
                            <input type="text" id="home_area" name="home_area" class="form-control" value="{{ $certi_information->amphur }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_tumbon" >ตำบล/แขวง: </label>
                            <input type="text" id="home_tumbon" name="home_tumbon" class="form-control" value="{{ $certi_information->district }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_post">ไปรษณีย์: </label>
                            <input type="number" id="home_post" name="home_post" class="form-control" value="{{ $certi_information->postcode }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="home_phone">โทรศัพท์: </label>
                            <input type="text" id="home_phone" name="home_phone" class="form-control" value="{{ $certi_information->tel }}" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_card">เลขประจำตัวประชาชน: </label>
                            <input type="text" id="id_card" name="id_card" class="form-control " value="{{ $certi_information->identify_number }}" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: </label>
                            <input type="text" id="id_tax" name="id_tax" class="form-control " value="{{ $certi_information->tax_indentification_number }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="head_num">มีสำนักงานใหญ่ตั้งอยู่เลขที่: </label>
                            <input type="text" id="head_num" name="head_num" class="form-control" value="{{ $certi_information->address_headquarters }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_soi">ตรอก/ซอย: </label>
                            <input type="text" id="head_soi" name="head_soi" class="form-control" value="{{ $certi_information->headquarters_alley }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_street">ถนน: </label>
                            <input type="text" id="head_street" name="head_street" class="form-control" value="{{ $certi_information->headquarters_road }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_moo">หมู่ที่: </label>
                            <input type="number" id="head_moo" name="head_moo" class="form-control" value="{{ $certi_information->headquarters_village_no }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_tumbon">ตำบล/แขวง: </label>
                            <input type="text" id="head_tumbon" name="head_tumbon" class="form-control" value="{{ $certi_information->headquarters_district }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_area">อำเภอ/เขต: </label>
                            <input type="text" id="head_area" name="head_area" class="form-control" value="{{ $certi_information->headquarters_amphur }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_province">จังหวัด: </label>
                            <input type="text" id="head_province" name="head_province" class="form-control" value="{{ $certi_information->headquarters_province }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_post">รหัสไปรษณีย์: </label>
                            <input type="number" id="head_post" name="head_post" class="form-control" value="{{ $certi_information->headquarters_postcode }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_tel">โทรศัพท์: </label>
                            <input type="text" id="head_tel" name="head_tel" class="form-control" value="{{ $certi_information->headquarters_tel }}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_fax">โทรสาร: </label>
                            <input type="text" id="head_fax" name="head_fax" class="form-control" value="{{ $certi_information->headquarters_tel_fax }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="entity_date">จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: </label>
                            <input type="text" id="entity_date" name="entity_date" class="form-control mydatepicker" value="{{ \Carbon\Carbon::parse($certi_information->date_regis_juristic_person)->format('d/m/Y') }}" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="license_no">ทะเบียนเลขที่: </label>
                            <input type="text" id="license_no" name="license_no" class="form-control" value="{{ $certi_information->registration_number }}" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="commerce_no">ทะเบียนพาณิชย์เลขที่: </label>
                            <input type="text" id="commerce_no" name="commerce_no" class="form-control" value="{{ $certi_information->commercial_registration }}" >
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@push('js')
    <script src="{{asset('js/mask/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('js/mask/mask.init.js')}}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //ปฎิทิน
            $('.mydatepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                orientation: 'bottom'
            });
        });
    </script>
@endpush