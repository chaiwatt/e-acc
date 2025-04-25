<fieldset class="white-box">
    <legend><h4>ข้อมูลผู้ยื่นคำขอ</h4></legend>

    <div class="row">

        @if(isset($certi_ib->id) && $certi_ib->status >= 6)
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
                            <div class="iradio_square-green {!! !empty($certi_ib->applicanttype_id=='1')?'checked':'' !!}"></div>
                            &nbsp;นิติบุคคล&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_ib->applicanttype_id=='2')?'checked':'' !!}"></div>
                            &nbsp;บุคคลธรรมดา&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_ib->applicanttype_id=='3')?'checked':'' !!}"></div>
                            &nbsp;คณะบุคคล&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_ib->applicanttype_id=='4')?'checked':'' !!}"></div>
                            &nbsp;ส่วนราชการ&nbsp;&nbsp;
                            <div class="iradio_square-green {!! !empty($certi_ib->applicanttype_id=='5')?'checked':'' !!}"></div>
                            &nbsp;อื่นๆ&nbsp;&nbsp;

                            <input type="hidden" name="applicanttype_id" value="{!! !empty($certi_ib->applicanttype_id)?$certi_ib->applicanttype_id:null !!}"/>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="app_name">ชื่อผู้ยื่นขอรับรองการรับรอง: <span class="">(Applicant)</span>  </label>
                            {!! Form::text('app_name', $certi_ib->name ?? null, ['class' => 'form-control','readonly'=>true]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_tax">เลขประจำตัวผู้เสียภาษีอากร: <span class="">(Tax ID)</span>  </label>
                            {!! Form::text('tax_number' ,!empty($certi_ib->tax_number) ? $certi_ib->tax_number : null, ['class' => 'form-control id-inputmask','readonly'=>true]) !!}
                            {!! $errors->first('tax_number', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('hq_address') ? 'has-error' : ''}}">
                            <label for="hq_address">มีสำนักงานใหญ่ตั้งอยู่เลขที่: <span class="">(Head office address)</span> </label>
                            {!! Form::text('hq_address',!empty($certi_ib->hq_address)? $certi_ib->hq_address : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_num"]) !!}
                            {!! $errors->first('hq_address', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_soi') ? 'has-error' : ''}}">
                            <label for="hq_soi">ตรอก/ซอย: <span class="">(Trok/Soi)</span> </label>
                            {!! Form::text('hq_soi',!empty($certi_ib->hq_soi)? $certi_ib->hq_soi : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_soi"]) !!}
                            {!! $errors->first('hq_soi', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_road') ? 'has-error' : ''}}">
                            <label for="hq_road">ถนน: <span class="">(Steet/Road)</span>  </label>
                            {!! Form::text('hq_road',!empty($certi_ib->hq_road)? $certi_ib->hq_road : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_street"]) !!}
                            {!! $errors->first('hq_road', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_moo') ? 'has-error' : ''}}">
                            <label for="hq_moo">หมู่ที่: <span class="">(Moo)</span> </label>
                            {!! Form::text('hq_moo',!empty($certi_ib->hq_moo)? $certi_ib->hq_moo : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_moo"]) !!}
                            {!! $errors->first('hq_moo', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_subdistrict_txt') ? 'has-error' : ''}}">
                            <label for="hq_subdistrict_txt">ตำบล/แขวง: <span class="">(Tambon/Khwarng)</span> </label>
                            {!! Form::text('hq_subdistrict_txt',!empty($certi_ib->hq_subdistrict_txt)? $certi_ib->hq_subdistrict_txt : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_tumbon"]) !!}
                            {!! $errors->first('hq_subdistrict_txt', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_district_txt') ? 'has-error' : ''}}">
                            <label for="hq_district_txt">อำเภอ/เขต: <span class="">(Amphoe/Khet)</span> </label>
                            {!! Form::text('hq_district_txt',!empty($certi_ib->hq_district_txt)? $certi_ib->hq_district_txt : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_area"]) !!}
                            {!! $errors->first('hq_district_txt', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_province_txt') ? 'has-error' : ''}}">
                            <label for="hq_province_txt">จังหวัด: <span class="">(Province)</span> </label>
                            {!! Form::text('hq_province_txt',!empty($certi_ib->hq_province_txt)? $certi_ib->hq_province_txt : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_province"]) !!}
                            {!! $errors->first('hq_province_txt', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <input type="hidden" name="hq_subdistrict_id" value="{!! !empty($certi_ib->hq_subdistrict_id)?$certi_ib->hq_subdistrict_id:null !!}"/>
                    <input type="hidden" name="hq_district_id" value="{!! !empty($certi_ib->hq_district_id)?$certi_ib->hq_district_id:null !!}"/>
                    <input type="hidden" name="hq_province_id" value="{!! !empty($certi_ib->hq_province_id)?$certi_ib->hq_province_id:null !!}"/>

                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_zipcode') ? 'has-error' : ''}}">
                            <label for="hq_zipcode">รหัสไปรษณีย์: <span class="">(Zip code)</span> </label>
                            {!! Form::text('hq_zipcode',!empty($certi_ib->hq_zipcode)? $certi_ib->hq_zipcode : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_post"]) !!}
                            {!! $errors->first('hq_zipcode', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_telephone') ? 'has-error' : ''}}">
                            <label for="hq_telephone">โทรศัพท์: <span class="">(Telephone)</span> </label>
                            {!! Form::text('hq_telephone',!empty($certi_ib->hq_telephone)? $certi_ib->hq_telephone : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_tel"]) !!}
                            {!! $errors->first('hq_telephone', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('hq_fax') ? 'has-error' : ''}}">
                            <label for="hq_fax">โทรสาร: </label>
                            {!! Form::text('hq_fax',!empty($certi_ib->hq_fax)? $certi_ib->hq_fax : null, ['class' => 'form-control','readonly'=>true,'id'=>"head_fax"]) !!}
                            {!! $errors->first('hq_fax', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="hq_date_registered"  class="col-md-12">จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <span>(Juristic person registered date/month/year)</span> </label>
                        <div  class="col-md-4">
                            {!! Form::text('hq_date_registered',!empty($certi_ib->hq_date_registered)? HP::revertDate( date('Y-m-d', strtotime($certi_ib->hq_date_registered)),true)  : null, ['class' => 'form-control ','readonly'=>true]) !!}
                            {!! $errors->first('hq_date_registered', '<p class="help-block">:message</p>') !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</fieldset>