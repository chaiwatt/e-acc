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
                        <label for="app_no" class="control-label">เลขที่คำขอ: </label>
                        <input type="text" class="form-control text-center" readonly value=" {{ $certi_information->certi_lab->app_no }} " >
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
                            ข้าพเจ้า: <label for="app_name">{{ $certi_information->name }}</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            อายุ: <label for="app_old">{{ $certi_information->ages }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            สัญชาติ: <label for="app_nation">{{ $certi_information->nationality }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            อยู่บ้านเลขที่: <label for="home_num">{{ $certi_information->address_no }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            ตรอก/ซอย: <label for="home_soi">{{ $certi_information->alley }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            ถนน: <label for="home_street">{{ $certi_information->road }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            หมู่ที่: <label for="home_moo">{{ $certi_information->village_no }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            จังหวัด: <label for="home_province">{{ $certi_information->province }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            อำเภอ/เขต: <label for="home_area" >{{ $certi_information->amphur }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            ตำบล/แขวง: <label for="home_tumbon" >{{ $certi_information->district }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            ไปรษณีย์: <label for="home_post">{{ $certi_information->postcode }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            โทรศัพท์: <label for="home_phone">{{ $certi_information->tel }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            เลขประจำตัวประชาชน: <label for="id_card">{{ $certi_information->identify_number }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            เลขประจำตัวผู้เสียภาษีอากร: <label for="id_tax">{{ $certi_information->tax_indentification_number }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            มีสำนักงานใหญ่ตั้งอยู่เลขที่: <label for="head_num">{{ $certi_information->address_headquarters }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            ตรอก/ซอย: <label for="head_soi">{{ $certi_information->headquarters_alley }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            ถนน: <label for="head_street">{{ $certi_information->headquarters_road }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            หมู่ที่: <label for="head_moo">{{ $certi_information->headquarters_village_no }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            ตำบล/แขวง: <label for="head_tumbon">{{ $certi_information->headquarters_district }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            อำเภอ/เขต: <label for="head_area">{{ $certi_information->headquarters_amphur }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            จังหวัด: <label for="head_province">{{ $certi_information->headquarters_province }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            รหัสไปรษณีย์: <label for="head_post">{{ $certi_information->headquarters_postcode }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            โทรศัพท์: <label for="head_tel">{{ $certi_information->headquarters_tel }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            โทรสาร: <label for="head_fax">{{ $certi_information->headquarters_tel_fax }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <label for="entity_date">{{ \Carbon\Carbon::parse($certi_information->date_regis_juristic_person)->format('d M Y') }}</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            ทะเบียนเลขที่: <label for="license_no">{{ $certi_information->registration_number }}</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            ทะเบียนพาณิชย์เลขที่: <label for="commerce_no">{{ $certi_information->commercial_registration }}</label>
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