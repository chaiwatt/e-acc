{{-- work on Certify\ApplicantController --}}
<fieldset class="white-box">
    <legend><h4>ข้อมูลผู้ยื่นคำ</h4></legend>
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

                            <div class="iradio_square-green {!! !empty($certi_lab->applicanttype_id=='1')?'checked':'' !!}"></div>
                            &nbsp;นิติบุคคล&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_lab->applicanttype_id=='2')?'checked':'' !!}"></div>
                            &nbsp;บุคคลธรรมดา&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_lab->applicanttype_id=='3')?'checked':'' !!}"></div>
                            &nbsp;คณะบุคคล&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_lab->applicanttype_id=='4')?'checked':'' !!}"></div>
                            &nbsp;ส่วนราชการ&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_lab->applicanttype_id=='5')?'checked':'' !!}"></div>
                            &nbsp;อื่นๆ&nbsp;&nbsp;

                            <input type="hidden" name="applicanttype_id" value="{!! !empty($certi_lab->applicanttype_id)?$certi_lab->applicanttype_id:null !!}"/>

                        </div>
                    </div>
        
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="app_name">ชื่อผู้ยื่นขอรับรองการรับรอง: <span>(Applicant)</span> </label>
                            <input type="text" id="app_name" name="app_name" class="form-control input_background_color " readonly value="{!! $certi_lab->app_name ?? '-' !!}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: <span>(Tax ID)</span>  </label>
                            <input type="text" id="id_tax" name="id_tax" class="form-control input_background_color id-inputmask" readonly  value="{{ !empty($certi_lab->tax_number) ? $certi_lab->tax_number : null }}">
                        </div>
                    </div>

                </div>
                
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="head_num">มีสำนักงานใหญ่ตั้งอยู่เลขที่: <span>(Head office address)</span> </label>
                            <input type="text" id="head_num" name="head_num" class="form-control" readonly  value="{{ !empty($certi_lab->address_headquarters)? $certi_lab->address_headquarters : null }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_soi">ตรอก/ซอย: <span>(Trok/Soi)</span> </label>
                            <input type="text" id="head_soi" name="head_soi" class="form-control" readonly  value="{{ !empty($certi_lab->headquarters_alley)? $certi_lab->headquarters_alley : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_street">ถนน: <span>(Steet/Road)</span> </label>
                            <input type="text" id="head_street" name="head_street" class="form-control"  readonly  value="{{ !empty($certi_lab->headquarters_road)? $certi_lab->headquarters_road : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_moo">หมู่ที่: <span>(Moo)</span> </label>
                            <input type="text" id="head_moo" name="head_moo" class="form-control" readonly  value="{{ !empty($certi_lab->headquarters_village_no)? $certi_lab->headquarters_village_no : null }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_tumbon">ตำบล/แขวง: <span>(Tambon/Khwarng)</span> </label>
                            <input type="text" id="head_tumbon" name="head_tumbon" class="form-control" readonly  value="{{ !empty($certi_lab->headquarters_district)? $certi_lab->headquarters_district : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_area">อำเภอ/เขต: <span>(Amphoe/Khet)</span> </label>
                            <input type="text" id="head_area" name="head_area" class="form-control"  readonly value="{{ !empty($certi_lab->headquarters_amphur)? $certi_lab->headquarters_amphur : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_province">จังหวัด: <span>(Province)</span> </label>
                            <input type="text" id="head_province" name="head_province" class="form-control"  readonly  value="{{ !empty($certi_lab->headquarters_province)? $certi_lab->headquarters_province : null }}">
                        </div>
                    </div>
                    
                    <input type="hidden" name="hq_subdistrict_id"  value="{{ !empty($certi_lab->hq_subdistrict_id)? $certi_lab->hq_subdistrict_id : null }}">
                    <input type="hidden" name="hq_district_id"  value="{{ !empty($certi_lab->hq_district_id)? $certi_lab->hq_district_id : null }}">
                    <input type="hidden" name="hq_province_id"  value="{{ !empty($certi_lab->hq_province_id)? $certi_lab->hq_province_id : null }}">
                    
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_post">รหัสไปรษณีย์: <span>(Zip code)</span> </label>
                            <input type="text" id="head_post" name="head_post" class="form-control" readonly value="{{ !empty($certi_lab->headquarters_postcode)? $certi_lab->headquarters_postcode : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_tel">โทรศัพท์: <span>(Telephone)</span> </label>
                            <input type="text" id="head_tel" name="head_tel" class="form-control" readonly  value="{{ !empty($certi_lab->headquarters_tel)? $certi_lab->headquarters_tel : null }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="head_fax">โทรสาร: </label>
                            <input type="text" id="head_fax" name="head_fax" class="form-control" readonly value="{{ !empty($certi_lab->headquarters_tel_fax)? $certi_lab->headquarters_tel_fax : null }}">
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="entity_date"  class="col-md-12">จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <span>(Juristic person registered date/month/year)</span> </label>
                            <div  class="col-md-4">
                                <input type="text" id="entity_date" name="entity_date" class="form-control " readonly  value="{{  !empty($certi_lab->registerDate)? HP::revertDate( date('Y-m-d', strtotime($certi_lab->registerDate)),true)  : null }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</fieldset>