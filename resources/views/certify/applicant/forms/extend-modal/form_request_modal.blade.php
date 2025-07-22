{{-- work on Certify\ApplicantController --}}
{{-- modal add address --}}
<style>
    .symbol-btn {
        width: 60px; /* ปรับความกว้างตามที่ต้องการ */
        margin: 5px; /* ช่องว่างระหว่างปุ่ม */
    }
/* เส้นขอบรอบตาราง */
.custom-bordered-table {
    border-collapse: separate;
    border: 0.5px solid #dee2e6; /* เส้นขอบรอบตาราง */
    border-spacing: 0; /* ไม่มีช่องว่างระหว่างเซลล์ */
}

/* เส้นขอบเฉพาะด้านซ้ายและขวาสำหรับ td และ th */
.custom-bordered-table td,
.custom-bordered-table th {
    border-left: 0.5px solid #dee2e6 !important; /* ขอบซ้าย */
    border-right: 0.5px solid #dee2e6 !important; /* ขอบขวา */
    border-top: none !important; /* ไม่มีขอบบน */
    border-bottom: none !important; /* ไม่มีขอบล่าง */
}

/* ยกเลิกเส้นขอบที่อาจซ้อนมาจาก Bootstrap */
.custom-bordered-table th,
.custom-bordered-table td {
    border-top: 0 !important;
    border-bottom: 0 !important;
}

/* เส้นขอบด้านล่างสุดของตาราง */
.custom-bordered-table tr:last-child td {
    border-bottom: none !important; /* ยกเลิกขอบล่างของแถวสุดท้าย */
}

    /* ปิดเอฟเฟกต์ hover */
    .table-no-hover tbody tr:hover {
        background-color: transparent !important;
    }

    .editable-div {
    width: 200px;
    min-height: 100px;
    white-space: pre-wrap;
    font-family: Arial, sans-serif;
    overflow-wrap: break-word;
    border: 1px solid #ccc;
    padding: 4px;
    outline: none;
}

.editable-div:focus {
    border-color: #666;
}

#scope_table_wrapper table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
        border: 1px solid black;
    }

    #scope_table_wrapper td {
        border: 1px solid black;
        padding: 8px;
        vertical-align: top;
        background-color: #ffffff;
    }

    #scope_table_wrapper td:nth-child(1),
    #scope_table_wrapper td:nth-child(2),
    #scope_table_wrapper td:nth-child(3),
    #scope_table_wrapper td:nth-child(4),
    #scope_table_wrapper td:nth-child(5) {
        border-top: none;
        border-bottom: none;
    }

    #scope_table_wrapper tr:first-child td:nth-child(1),
    #scope_table_wrapper tr:first-child td:nth-child(2),
    #scope_table_wrapper tr:first-child td:nth-child(3),
    #scope_table_wrapper tr:first-child td:nth-child(4),
    #scope_table_wrapper tr:first-child td:nth-child(5) {
        border-top: 1px solid black;
    }

    #scope_table_wrapper tr:last-child td:nth-child(1),
    #scope_table_wrapper tr:last-child td:nth-child(2),
    #scope_table_wrapper tr:last-child td:nth-child(3),
    #scope_table_wrapper tr:last-child td:nth-child(4),
    #scope_table_wrapper tr:last-child td:nth-child(5) {
        border-bottom: 1px solid black;
    }

    #scope_table_wrapper td:nth-child(1) {
        width: 15%;
    }

    #scope_table_wrapper td:nth-child(2) {
        width: 35%;
    }

    #scope_table_wrapper td:nth-child(3) {
        width: 25%;
    }

    #scope_table_wrapper td:nth-child(4) {
        width: 15%;
    }

    #scope_table_wrapper td:nth-child(5) {
        width: 10%;
    }

    #scope_table_wrapper table.table-striped tbody tr,
    #scope_table_wrapper table.table-striped tbody tr:nth-child(odd),
    #scope_table_wrapper table.table-striped tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    #scope_table_wrapper tr.parameter-one {
        background-color: #e6f3ff !important;
    }

    #scope_table_wrapper table.table tbody tr:hover {
        background-color: transparent !important;
    }

    #scope_table_wrapper .btn-danger {
        padding: 2px 6px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 2px;
        background-color: #d9534f;
        border-color: #d43f3a;
    }

    #scope_table_wrapper table[id^="cal_scope_table_branch_"] {
        background-color: #f0f8ff; /* สีพื้นหลังสำหรับสาขา */
    }


[id^="result"] {
    margin-top: 10px;
}
</style>
<div class="modal fade" id="modal-add-address">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title"><span id="address-modal-title">เพิ่มที่อยู่สาขา</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
              </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <legend><h4>1. เพิ่มที่อยู่สาขาห้องปฏิบัติการที่ต้องการรับรอง</h4></legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! HTML::decode(Form::label('', 'ที่อยู่ห้องปฏิบัติการ (ไทย)',['class' => 'col-md-5 control-label label-height'])) !!}
                                <div class="col-md-7"></div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    
                    {{-- <span class="text-danger">สำหรับการจำลองเท่านั้น</span> --}}
                        <div class="col-md-12">
                            <div class="form-group ">
                                {!! Form::label('authorized_address_seach', 'สำหรับการจำลองเท่านั้น'.' :', ['class' => 'text-danger col-md-5 control-label']) !!}
                                <div class="col-md-7">
                                    {!! Form::text('authorized_address_seach', null,  ['id' => 'authorized_address_seach_add_modal', 'class' => 'form-control ', 'autocomplete' => 'off', 'data-provide' => 'typeahead', 'placeholder' => 'ค้นหาที่อยู่' ]) !!}
                                    {!! $errors->first('authorized_address_seach', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        
                </div>
                <hr>
                <div class="row">
                 
                    <div class="col-md-6">
                        {{-- <div class="form-group ">
                            {!! Form::label('existing_branch', 'สาขา'.' :', ['class' => 'col-md-5 control-label']) !!}
                            <div class="col-md-7">
                                {!! Form::text('existing_branch', null,  ['id' => 'existing_branch', 'class' => 'form-control ', 'autocomplete' => 'off', 'data-provide' => 'typeahead', 'placeholder' => 'สาขา' ]) !!}
                                {!! $errors->first('existing_branch', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label for="existing_branch" class="col-md-5 control-label"><span class="text-danger">*</span> สาขา</label>
                            <div class="col-md-7 ">
                                <select name="existing_branch" id="existing_branch" class="form-control pull-left">
                                    {{-- <option value="" selected>- สาขา -</option> --}}
        
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
                
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('address_number_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('address_number_add_modal', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('address_number_add_modal', null, ['id' => 'address_number_add_modal', 'class' => 'form-control input_address']) !!}
                                {!! $errors->first('address_number_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('village_no_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('village_no_add_modal', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('village_no_add_modal', null, ['id' => 'village_no_add_modal', 'class' => 'form-control input_address']) !!}
                                {!! $errors->first('village_no_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                  
                 
                </div>

                
         
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('address_soi_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('address_soi_add_modal', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('address_soi_add_modal',null, ['id' => 'address_soi_add_modal', 'class' => 'form-control input_address']) !!}
                                {!! $errors->first('address_soi_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('address_street_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('address_street_add_modal', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('address_street_add_modal', null, ['id' => 'address_street_add_modal','class' => 'form-control input_address']) !!}
                                {!! $errors->first('address_street_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                   
                  
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('address_city_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('address_city_add_modal', '<span class="text-danger">*</span> จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::select('address_city_add_modal', $province->pluck('PROVINCE_NAME', 'PROVINCE_ID' ),  null , ['id' => 'address_city_add_modal','class' => 'form-control select_address', 'id'=>'address_city_add_modal', 'placeholder' =>'- จังหวัด -']) !!}
                                {!! $errors->first('address_city_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('address_district_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('address_district_add_modal', '<span class="text-danger">*</span> เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                <input type="text" name="address_district_add_modal" id="address_district_add_modal" readonly class="form-control input_address" value="null">
                                {!! $errors->first('according_district_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('sub_district_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('sub_district_add_modal', '<span class="text-danger">*</span> แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                <input type="text" name="sub_district_add_modal" id="sub_district_add_modal" readonly class="form-control input_address" value="null">
                                {!! $errors->first('sub_district_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('postcode_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('postcode_add_modal', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                <input type="text" name="postcode_add_modal" id="postcode_add_modal" readonly class="form-control input_address"  value="null">
                                {!! $errors->first('postcode_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! HTML::decode(Form::label('', 'ที่อยู่ห้องปฏิบัติการ (EN)',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7"></div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('lab_address_no_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_address_no_eng_add_modal', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('lab_address_no_eng_add_modal',null , ['id' => 'lab_address_no_eng_add_modal','class' => 'form-control input_address_eng']) !!}
                                {!! $errors->first('lab_address_no_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('lab_moo_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_moo_eng_add_modal', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Moo)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('lab_moo_eng_add_modal', null , ['id' => 'lab_moo_eng_add_modal','class' => 'form-control']) !!}
                                {!! $errors->first('lab_moo_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('lab_soi_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_soi_eng_add_modal', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('lab_soi_eng_add_modal', null , ['id' => 'lab_soi_eng_add_modal','class' => 'form-control input_address_eng']) !!}
                                {!! $errors->first('lab_soi_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('lab_street_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_street_eng_add_modal', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::text('lab_street_eng_add_modal', null , ['id' => 'lab_street_eng_add_modal','class' => 'form-control input_address_eng']) !!}
                                {!! $errors->first('lab_street_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group  {{ $errors->has('lab_province_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_province_eng_add_modal', '<span class="text-danger">*</span> จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                {!! Form::select('lab_province_eng_add_modal', $province->where('PROVINCE_NAME_EN', '!=', null)->pluck('PROVINCE_NAME_EN', 'PROVINCE_ID' ), null , ['id' => 'lab_province_eng_add_modal','class' => 'form-control', 'id'=>'lab_province_eng_add_modal', 'placeholder' =>'- PROVINCE -']) !!}
                                {!! $errors->first('lab_province_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('lab_amphur_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_amphur_eng_add_modal', '<span class="text-danger">*</span> เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                <input type="text" name="lab_amphur_eng_add_modal" id="lab_amphur_eng_add_modal" readonly class="form-control input_address_eng" value="null">
                                {!! $errors->first('lab_amphur_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('lab_district_eng_add_modal') ? 'has-error' : ''}}">
                            {!! HTML::decode(Form::label('lab_district_eng_add_modal', '<span class="text-danger">*</span> แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                            <div class="col-md-7">
                                <input type="text" name="lab_district_eng_add_modal" id="lab_district_eng_add_modal" readonly class="form-control input_address_eng" value="null">
                                {!! $errors->first('lab_district_eng_add_modal', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div> 
            </fieldset>


            <fieldset class="white-box">
                <legend><h4>2. <span class="text-danger">*</span> ประเภทสถานปฏิบัติการของห้องปฏิบัติการ</h4></legend>
                
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                        <div class="form-group">
                            <div class="row">
                                <div class="m-l-15 form-group {{ $errors->has('pl_2_1_branch') ? 'has-error' : ''}}">
                                    <div class="col-md-12 m-l-15">
                                        {!! Form::checkbox('pl_2_1_branch', '0', false, ['id' => 'pl_2_1_branch','class'=>'check pl_2_1 checked','data-checkbox'=>"icheckbox_flat-red"]) !!}
                                        <label for="pl_2_1_branch"> &nbsp;ประเภท1 สถานปฏิบัติการถาวร (Permanent facilities) &nbsp; </label>
                                        {!! $errors->first('pl_2_1_branch', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="m-l-15 form-group {{ $errors->has('pl_2_2_branch') ? 'has-error' : ''}}">
                                    <div class="col-md-12 m-l-15">
                                        {!! Form::checkbox('pl_2_2_branch', '0', false, ['id' => 'pl_2_2_branch','class'=>'check pl_2_2','data-checkbox'=>"icheckbox_flat-red"]) !!}
                                        <label for="pl_2_2_branch"> &nbsp;ประเภท2 สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities) &nbsp; </label>
                                        {!! $errors->first('pl_2_2_branch', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            
                                <div class="m-l-15 form-group {{ $errors->has('pl_2_3_branch') ? 'has-error' : ''}}">
                                    <div class="col-md-12 m-l-15">
                                        {!! Form::checkbox('pl_2_3_branch', '0', false, ['id' => 'pl_2_3_branch','class'=>'check pl_2_3','data-checkbox'=>"icheckbox_flat-red"]) !!}
                                        <label for="pl_2_3_branch"> &nbsp;ประเภท3 สถานปฏิบัติการเคลื่อนที่ (Mobile facilities) &nbsp; </label>
                                        {!! $errors->first('pl_2_3_branch', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="m-l-15 form-group {{ $errors->has('pl_2_4_branch') ? 'has-error' : ''}}">
                                    <div class="col-md-12 m-l-15">
                                        {!! Form::checkbox('pl_2_4_branch', '0', false, ['id' => 'pl_2_4_branch','class'=>'check pl_2_4','data-checkbox'=>"icheckbox_flat-red"]) !!}
                                        <label for="pl_2_4_branch"> &nbsp;ประเภท4 สถานปฏิบัติการชั่วคราว (Temporary facilities) &nbsp; </label>
                                        {!! $errors->first('pl_2_4_branch', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                {{-- <div class="m-l-15 form-group {{ $errors->has('pl_2_5_branch') ? 'has-error' : ''}}">
                                    <div class="col-md-12 m-l-15">
                                        {!! Form::checkbox('pl_2_5_branch', '0', false, ['id' => 'pl_2_5_branch','class'=>'check pl_2_5','data-checkbox'=>"icheckbox_flat-red"]) !!}
                                        <label for="pl_2_5_branch"> &nbsp;ประเภท5 สถานปฏิบัติการหลายสถานะที่ (Multi-site facilities) &nbsp; </label>
                                        {!! $errors->first('pl_2_5_branch', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
                   
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="create_address" >
                    <span aria-hidden="true">บันทึก</span>
                </button>
            </div>
        </div>
    </div>
</div>




{{-- modal add address --}}

{{-- modal test scope --}}

<div class="modal fade" id="modal-add-cal-scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่ายห้องปฏิบัติการสอบเทียบ</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
                <h5>
                  <span class="text-danger">*โปรดทราบ!! ถ้าไม่พบขอบข่ายที่ต้องการ โปรดติดต่อเจ้าหน้าที่เพื่อเพิ่มเติมขอบข่าย ==></span> <span><a href="{{url('certify/scope-request/lab-scope-request')}}" target="_blank">ขอเพิ่มขอบข่าย</a></span>
                </h5>
            </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <div class="row" id="select_wrapper">
                        <div class="col-md-4 form-group">
                            <label for="">สาขาการสอบเทียบ</label>
                            <select class="form-control" name="" id="cal_main_branch">
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">เครื่องมือ1</label>
                            <select class="form-control" name="" id="cal_instrumentgroup">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="cal_instrument_wrapper">
                            <label for="">เครื่องมือ2</label>
                            <select class="form-control" name="" id="cal_instrument">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="cal_parameters_wrapper">
                            <label for="">เลือกพารามิเตอร์</label>
                            <select class="form-control" name="" id="cal_parameters">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="cal_parameter_one_wrapper">
                            <label for="">พารามิเตอร์1</label>
                            <select class="form-control" name="" id="cal_parameter_one">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="cal_parameter_two_wrapper">
                            <label for="">พารามิเตอร์2</label>
                            <select class="form-control" name="" id="cal_parameter_two">
                            </select>
                        </div>
                    </div>
                    
                    <div class="row" id="cal_infomation_scope" >
                     
                      
                  
                        <div id="cal_parameter_cmc_table" style="margin-top: 15px">
                            <div class="col-md-12 form-group">
                                <button type="button" class="btn btn-info pull-right ml-2" id="button_add_cal_param_cmc">
                                    <span aria-hidden="true">เพิ่มรายละเอียด/CMC</span>
                                </button>
                               
                            </div>
                            <table class="table table-bordered" id="cal_parameter_cmc_table_notuse">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center text-white "  width="30%">คำอธิบาย/เงื่อนไข</th>
                                        <th class="text-center text-white "  width="30%">รายละเอียด</th>
                                        <th class="text-center text-white "  width="30%">ขีดความสามารถการสอบเทียบและการวัด (CMC)</th>
                                        {{-- <th class="text-center text-white "  width="10%">ลบ</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="cal_parameter_cmc_body">
                            
                               
                                </tbody>
                            </table>
    
                         
                        </div>

                        <div class="col-md-12 form-group" id="cal_lab_std_wrapper" style="margin-left: -20px">
                            <hr>
                            <div class="col-md-12 form-group" style="display: flex; gap: 20px; align-items: flex-start; padding-left: 0;">
                                {{-- <div id="parameter_desc_wrapper" hidden>
                                    <label for="parameter_desc" style="display: block;">คำอธิบายพารามิเตอร์(ถ้ามี)</label>
                                    <div id="parameter_desc" class="editable-div" contenteditable="true" style="width: 220px; font-family: kanit;"></div>
                                </div> --}}
                                <div>
                                    <label for="cal_standard_txtarea" style="display: block;">วิธีสอบเทียบ / มาตรฐานที่ใช้</label>
                                    <div id="cal_standard_txtarea" class="editable-div" contenteditable="true" style="width: 220px; font-family: kanit;"></div>
                                </div>
                            </div>
                        </div>
                      

                    
                        
                    {{-- <div class="row mt-2"> --}}
                       
                        {{-- <div class="col-md-12 form-group">
                        
                        </div> --}}
                        {{-- <table class="table table-bordered" id="myTable_lab_cal_scope">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center text-white "  width="15%">สาขาทดสอบ</th>
                                    <th class="text-center text-white "  width="15%">เครื่องมือ1</th>
                                    <th class="text-center text-white "  width="15%">เครื่องมือ2</th>
                                    <th class="text-center text-white "  width="15%">พารามิเตอร์1</th>
                                    <th class="text-center text-white "  width="15%">พารามิเตอร์2</th>
                                    <th class="text-center text-white "  width="20%">วิธีสอบเทียบ</th>
                                    <th class="text-center text-white "  width="5%">ลบ</th>
                                </tr>
                            </thead>
                            <tbody id="lab_cal_scope_body">
                        
                           
                            </tbody>
                        </table> --}}
                    {{-- </div> --}}
                
             
                </fieldset>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-right ml-2" id="button_add_cal_scope">
                    <span aria-hidden="true">เพิ่ม</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-cal-param-cmc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่ายห้องปฏิบัติการสอบเทียบ</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <div class="row" >
                        <div class="col-md-12 form-group" >
                            <label for="description">คำอธิบาย / เงื่อนไขการวัด (ถ้ามี)</label>
                            {{-- <input type="text" class="form-control" id="description"> --}}
                            <textarea class="form-control" rows="3" id="description"></textarea>
                        </div> 

                        <div class="col-md-6 form-group" >
                            <label for="exampleInputPassword1">
                                รายละเอียดพารามิเตอร์
                                {{-- <label class="label-height" style="margin-left: 15px;">
                                    <input type="radio" name="cal_param_option" value="text" 
                                           class="check checkLab" 
                                           data-radio="iradio_square-green" 
                                           id="cal_param_use_text" 
                                           checked>
                                    ข้อความ
                                </label> --}}
                                {{-- <label class="label-height" style="margin-left: 15px;">
                                    <input type="radio" name="cal_param_option" value="picture" 
                                           class="check checkLab" 
                                           data-radio="iradio_square-green" 
                                           id="cal_param_use_picture">
                                    รูปภาพ (750x200px HQ)
                                </label> --}}
                                <label for="">
                                    <button type="button" class="btn btn-primary btn-xs" id="show_modal_add_parameter_symbol">
                                        <i class="fa fa-plus"></i> สัญลักษณ์
                                    </button>
                                </label>
                            </label>
                            <textarea class="form-control" rows="5" id="cal_param_range_textarea"></textarea>
                            {{-- <input type="file" class="form-control" id="cal_param_file" style="display:none;"> --}}
                            {{-- <input type="file" class="form-control" id="cal_param_file" accept=".png" style="display:none;"> --}}

                        </div>
                        
                        <div class="col-md-6 form-group" id="cmc_wrapper">
                            <label for="exampleInputPassword1">
                                <label for="">ขีดความสามารถฯ (CMC)  
                                    <button type="button" class="btn btn-primary btn-xs" id="show_modal_add_cmc_symbol">
                                    <i class="fa fa-plus"></i> สัญลักษณ์
                                    </button>
                            </label>
                      
                                
                            </label>
                            <textarea class="form-control" rows="5" id="cal_cmc_uncertainty_textarea"></textarea>
                            <div style="display: flex; gap: 20px; align-items: flex-start;margin-top:5px">
                                    <label class="label-height" >
                                        <input type="radio" name="cal_cmc_option" value="text" 
                                            class="check checkLab" 
                                            data-radio="iradio_square-green" 
                                            id="cal_use_text" 
                                            checked>
                                        ข้อความ
                                    </label></p>
                                
                                    <label class="label-height" >
                                        <input type="radio" name="cal_cmc_option" value="picture" 
                                            class="check checkLab" 
                                            data-radio="iradio_square-green" 
                                            id="cal_use_picture">
                                        รูป(750x200px HQ)
                                    </label>
                                </div>
                             
                         
                     
                            <input type="file" class="form-control" id="cal_cmc_file" accept=".png" style="display:none;">
                        </div>
                    </div>
                    <div class="row mt-2">
                       
                        <div class="col-md-12 form-group">
                            <span class="text-danger">ต้องกรอกให้ รายละเอียดพารามิเตอร์ ตรงกับ ขีดความสามารถการสอบเทียบและการวัด (CMC)</span>
                            <button type="button" class="btn btn-success pull-right ml-2" id="btn_add_cal_param_cmc">
                                <span aria-hidden="true">เพิ่ม</span>
                            </button>
                           
                        </div>
                    </div>  
                </fieldset>
            </div>
        </div>
    </div>
</div>
{{-- modal scope --}}

{{-- modal parameter one --}}
{{-- <div class="modal fade" id="modal-add-parameter-one">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="scope-modal-title">ช่วงการสอบเทียบของพารามิเตอร์1:</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        
                        <textarea id="parameter_one_textarea" class="form-control"></textarea>
                    </div>         
                </div>
                <div class="row">
                    <div class="col-md-9 ">
                        <small class="text-danger">* กรอกบรรทัดละ 1 รายการ เช่น 
                            <ul>
                                <li>20V to 50V</li>
                                <li>10A to 30A</li>
                            </ul>
                           </small>
                    </div>
                    <div class="col-md-3 ">
                        <button type="button" class="btn btn-success pull-right " id="button_add_parameter_one">
                            <span aria-hidden="true">เพิ่ม</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="modal-add-parameter-one">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">ช่วงการสอบเทียบของพารามิเตอร์1:</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="parameter_one_textarea" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <small class="text-danger">* กรอกบรรทัดละ 1 รายการ เช่น
                            <ul>
                                <li>20V to 50V</li>
                                <li>10A to 30A</li>
                            </ul>
                        </small>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success pull-right" id="button_add_parameter_one">
                            เพิ่ม
                        </button>
                        <!-- ปุ่มเปิดโมดัลสัญลักษณ์ -->
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-add-parameter-one-symbol">
                            สัญลักษณ์พิเศษ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create-parameter-one">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มพารามิเตอร์1:</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="parameter_one_textarea_standard" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-cal-parameter-symbol">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เลือกสัญลักษณ์พิเศษ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <div class="d-flex flex-wrap justify-content-start align-items-center" style="gap: 10px; padding: 10px;">
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Ω">Ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="π">π</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Σ">Σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="β">β</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="α">α</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="γ">γ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="µ">µ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="±">±</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∞">∞</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="θ">θ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="δ">δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ξ">ξ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="φ">φ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="χ">χ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ψ">ψ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ε">ε</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Δ">Δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="√">√</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∮">∮</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∫">∫</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∂">∂</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∇">∇</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∑">∑</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∏">∏</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∆">∆</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="λ">λ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="σ">σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ρ">ρ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="℃">℃</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="℉">℉</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Ξ">Ξ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-cal-cmc-symbol">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เลือกสัญลักษณ์พิเศษ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <div class="d-flex flex-wrap justify-content-start align-items-center" style="gap: 10px; padding: 10px;">
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="Ω">Ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="π">π</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="Σ">Σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="β">β</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="α">α</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="γ">γ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="µ">µ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="±">±</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∞">∞</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="θ">θ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="δ">δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="ξ">ξ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="φ">φ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="χ">χ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="ψ">ψ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="ε">ε</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="Δ">Δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="√">√</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∮">∮</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∫">∫</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∂">∂</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∇">∇</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∑">∑</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∏">∏</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="∆">∆</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="λ">λ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="σ">σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="ρ">ρ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="℃">℃</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="℉">℉</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-cmc" data-symbol="Ξ">Ξ</button>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- modal parameter one --}}

{{-- modal parameter two --}}
<div class="modal fade" id="modal-add-parameter-two">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="scope-modal-title">ช่วงการสอบเทียบของพารามิเตอร์2:</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{-- <label for="how_test_detail">ช่วงการสอบเทียบของพารามิเตอร์2: </label> --}}
                        <textarea id="parameter_two_textarea" class="form-control"></textarea>
                    </div>         
                </div>
                <div class="row">
                    <div class="col-md-9 ">
                        <small class="text-danger">* กรอกบรรทัดละ 1 รายการ เช่น 
                            <ul>
                                <li>20V to 50V</li>
                                <li>10A to 30A</li>
                            </ul>
                           </small>
                    </div>
                    <div class="col-md-3 ">
                        <button type="button" class="btn btn-success pull-right " id="button_add_parameter_two">
                            <span aria-hidden="true">เพิ่ม</span>
                        </button>
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-add-parameter-two-symbol">
                            สัญลักษณ์พิเศษ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-parameter-two-symbol">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เลือกสัญลักษณ์พิเศษ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <div class="d-flex flex-wrap justify-content-start align-items-center" style="gap: 10px; padding: 10px;">
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Ω">Ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="π">π</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Σ">Σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="β">β</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="α">α</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="γ">γ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="µ">µ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="±">±</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∞">∞</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="θ">θ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="δ">δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ξ">ξ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="φ">φ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="χ">χ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ψ">ψ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ε">ε</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Δ">Δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="√">√</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∮">∮</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∫">∫</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∂">∂</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∇">∇</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∑">∑</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∏">∏</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∆">∆</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="λ">λ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="σ">σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ρ">ρ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="℃">℃</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="℉">℉</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Ξ">Ξ</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal parameter two --}}

{{-- modal select ref branch --}}
<div class="modal fade" id="modal-select-ref-branch">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="scope-modal-title">เลือกประเภทหลัก</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group" id="select_ref_branch_wrapper">
                        <label for="" class="text-danger">ตรวจพบ Scope ของแต่ละประเภทแตกต่างกัน โปรดเลือกประเภทหลัก ประเภทอื่น ๆ ถูกปรับ scope ร่วมกับประเภทที่เลือก</label>
                        <select  class="form-control" name="" id="select_ref_branch">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <button type="button" class="btn btn-success pull-right " id="button_select_ref_branch">
                            <span aria-hidden="true">เลือกรายการ</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal select ref branch --}}

{{-- modal select ref main --}}
<div class="modal fade" id="modal-select-ref-main">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="scope-modal-title">เลือกประเภทหลัก</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group" id="select_ref_main_wrapper">
                        <label for="" class="text-danger">ตรวจพบ Scope ของแต่ละประเภทแตกต่างกัน โปรดเลือกประเภทหลัก ประเภทอื่น ๆ ถูกปรับ scope ร่วมกับประเภทที่เลือก</label>
                        <select  class="form-control" name="" id="select_ref_main">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <button type="button" class="btn btn-success pull-right " id="button_select_ref_main">
                            <span aria-hidden="true">เลือกรายการ</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal select ref main --}}

{{-- modal cal method --}}
<div class="modal fade" id="modal-add-cal-method">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="scope-modal-title">เพิ่มวิธีการสอบเทียบ:</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="cal_method_textarea" class="form-control"></textarea>
                    </div>         
                </div>
                <div class="row">
                    <div class="col-md-9 ">
                        <small class="text-danger">* กรุณาอธิบายวิธีสอบเทียบ
                           </small>
                    </div>
                    <div class="col-md-3 ">
                        <button type="button" class="btn btn-success pull-right " id="button_add_cal_method">
                            <span aria-hidden="true">เพิ่ม</span>
                        </button>
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-add-cal-method-symbol">
                            สัญลักษณ์พิเศษ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-cal-method-symbol">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เลือกสัญลักษณ์พิเศษ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <div class="d-flex flex-wrap justify-content-start align-items-center" style="gap: 10px; padding: 10px;">
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Ω">Ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="π">π</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Σ">Σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="β">β</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="α">α</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="γ">γ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="µ">µ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="±">±</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∞">∞</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="θ">θ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="δ">δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ξ">ξ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="φ">φ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="χ">χ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ψ">ψ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ε">ε</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Δ">Δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="√">√</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∮">∮</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∫">∫</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∂">∂</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∇">∇</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∑">∑</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∏">∏</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="∆">∆</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="λ">λ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="σ">σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="ρ">ρ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="℃">℃</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="℉">℉</button>
                    <button type="button" class="btn btn-default symbol-btn-add-cal-parameter" data-symbol="Ξ">Ξ</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal cal method --}}


{{-- modal show cal scope --}}

<div class="modal fade" id="modal-show-cal-scope">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">รายการขอบข่ายปรับปรุง <span id="created_at"></span>  </span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-left" id="show_cal_scope_wrapper">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal show cal scope --}}

<div class="modal fade" id="modal-add-test-scope">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่ายห้องปฏิบัติการทดสอบ</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
                <h5>
                  <span class="text-danger">*โปรดทราบ!! ถ้าไม่พบขอบข่ายที่ต้องการ โปรดติดต่อเจ้าหน้าที่เพื่อเพิ่มเติมขอบข่าย ==></span> <span><a href="{{url('certify/scope-request/lab-scope-request')}}" target="_blank">ขอเพิ่มขอบข่าย</a></span>
                </h5>
            </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <div class="row" id="select_wrapper">
                        <div class="col-md-4 form-group">
                            <label for="">สาขาการทดสอบ</label>
                            <select class="form-control" name="" id="test_main_branch">
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">หมวดหมู่การทดสอบ</label>
                            <select class="form-control" name="" id="test_category">
                            </select>
                        </div>
                        <div class="col-md-4 form-group" id="test_parameter_wrapper">
                            <label for="">พารามิเตอร์</label>
                            <select class="form-control" name="" id="test_parameter">
                            </select>
                        </div>
                    </div>
                    
                    <div class="row" id="test_infomation_scope">
                        <hr>
                            <div class="col-md-12 form-group" >
                                <label for="description">คำอธิบาย / เงื่อนไขการวัด (ถ้ามี)</label>
                                <textarea class="form-control" rows="3" id="test_condition_description"></textarea>
                            </div> 
    
                            <div class="col-md-12 form-group" >
                                <label for="exampleInputPassword1">
                                    รายละเอียดพารามิเตอร์
                                </label>
                                <textarea class="form-control" rows="5" id="test_param_detail_textarea"></textarea>
                            </div>
                        <div class="col-md-12 form-group" >
                            <label for="test_standard_txtarea">วิธีทดสอบ / มาตรฐานที่ใช้</label>
                            <textarea class="form-control" rows="5" id="test_standard_txtarea"></textarea>
                        </div>
                    </div>          
                </fieldset>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-right ml-2" id="button_add_test_scope">
                    <span aria-hidden="true">เพิ่ม</span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-add-test-param">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">
                    <span id="scope-modal-title">เพิ่มขอบข่ายห้องปฏิบัติการทดสอบ</span>  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <fieldset class="white-box">
                    <div class="row" >
                        <div class="col-md-12 form-group" >
                            <label for="description">คำอธิบาย / เงื่อนไขการวัด (ถ้ามี)</label>
                            <textarea class="form-control" rows="3" id="description"></textarea>
                        </div> 

                        <div class="col-md-12 form-group" >
                            <label for="exampleInputPassword1">
                                รายละเอียดพารามิเตอร์
                                <label for="">
                                    <button type="button" class="btn btn-primary btn-xs" id="show_modal_add_parameter_symbol">
                                        <i class="fa fa-plus"></i> สัญลักษณ์
                                    </button>
                                </label>
                            </label>
                            <textarea class="form-control" rows="5" id="test_param_detail_textarea"></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                       
                        <div class="col-md-12 form-group">
                            <button type="button" class="btn btn-success pull-right ml-2" id="btn_add_test_param">
                                <span aria-hidden="true">เพิ่ม</span>
                            </button>
                           
                        </div>
                    </div>  
                </fieldset>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-test-standard-symbol">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เลือกสัญลักษณ์พิเศษ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-left">
                <div class="d-flex flex-wrap justify-content-start align-items-center" style="gap: 10px; padding: 10px;">
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="Ω">Ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="π">π</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="Σ">Σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="β">β</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="α">α</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="γ">γ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="µ">µ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="±">±</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∞">∞</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="θ">θ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="δ">δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="ξ">ξ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="φ">φ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="χ">χ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="ψ">ψ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="ε">ε</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="Δ">Δ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="√">√</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∮">∮</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∫">∫</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∂">∂</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∇">∇</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∑">∑</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∏">∏</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="∆">∆</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="λ">λ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="ω">ω</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="σ">σ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="ρ">ρ</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="℃">℃</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="℉">℉</button>
                    <button type="button" class="btn btn-default symbol-btn-add-test-standard" data-symbol="Ξ">Ξ</button>
                    <!-- ปุ่มสำหรับตัวยก (superscript) -->
                    <button type="button" class="btn btn-default" id="add-superscript-btn">xʸ</button>
                    <!-- ปุ่มสำหรับตัวห้อย (subscript) -->
                    <button type="button" class="btn btn-default" id="add-subscript-btn">xₙ</button>
                </div>
            </div>
        </div>
    </div>
</div>


