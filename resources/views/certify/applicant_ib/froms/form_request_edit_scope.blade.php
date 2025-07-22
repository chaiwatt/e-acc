<fieldset class="white-box" hidden>
    <legend><h4>ข้อมูลขอรับบริการ</h4></legend>


    @php
        $Formula_Arr = App\Models\Bcertify\Formula::where('applicant_type',2)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');
        $Province_arr = App\Models\Basic\Province::orderbyRaw('CONVERT(PROVINCE_NAME USING tis620)');
    @endphp

    <div class="row">
        @if (count($formulas)==1)
            <div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('type_standard', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <div class="col-md-4" >
                    {!! Form::select('type_standard',$Formula_Arr, !empty( $certi_ib->type_standard )?$certi_ib->type_standard:$formulas[0]->id, ['class' => 'form-control', 'id'=>'type_standard', 'required' => true]) !!}
                    {!! $errors->first('type_standard', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        @else
            <div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('type_standard', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <div class="col-md-4" >
                    {!! Form::select('type_standard',  $Formula_Arr,  !empty( $certi_ib->type_standard )?$certi_ib->type_standard:null, ['class' => 'form-control', 'id'=>'type_standard', 'required' => true, 'placeholder' =>'- เลือกตามมาตรฐานเลข -']) !!}
                    {!! $errors->first('type_standard', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        @endif

        <div class="form-group {{ $errors->has('type_unit') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('type_unit', 'หน่วยตรวจประเภท'.':'.'<br/><span class="  font_size">(Type examination unit)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <label class="col-md-1  label-height" >
                {!! Form::radio('type_unit', '1', !empty( $certi_ib->type_unit ) && $certi_ib->type_unit == '1' ?true:( !isset($certi_ib->id)?true:false ), ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
                &nbsp;A
            </label>
            <label class="col-md-1  label-height" >
                {!! Form::radio('type_unit', '2', !empty( $certi_ib->type_unit ) && $certi_ib->type_unit == '1' ?true:false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
                 &nbsp;B
            </label>
            <label class="col-md-1  label-height" >
                {!! Form::radio('type_unit', '3', !empty( $certi_ib->type_unit ) && $certi_ib->type_unit == '1' ?true:false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
                 &nbsp;C
            </label>
            <label class="col-md-1  label-height" >
                {!! Form::radio('type_unit', '4', !empty( $certi_ib->type_unit ) && $certi_ib->type_unit == '1' ?true:false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
                 &nbsp;Other
            </label>
           {!! $errors->first('type_unit', '<p class="help-block">:message</p>') !!}
        </div>
        {{-- {{$certifieds->count()}} --}}
        @if( isset($certi_ib->id) && !empty($certi_ib->standard_change) )
        
            <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <label  class="col-md-2 label-height">
                    {!! Form::radio('standard_change', '1', $certi_ib->standard_change == 1 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change1']) !!}
                    &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(initial assessment)</span>
                </label>
                <label  class="col-md-2 label-height">
                    {!! Form::radio('standard_change', '2', $certi_ib->standard_change == 2 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change2']) !!}
                    &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(renewal)</span>
                </label>
                <label  class="col-md-2 label-height">
                    {!! Form::radio('standard_change', '3', $certi_ib->standard_change == 3 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change3']) !!}
                    &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(extending accreditation)</span>
                </label>
                <label  class="col-md-3 label-height">
                    {!! Form::radio('standard_change', '4', $certi_ib->standard_change == 4 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change4']) !!}
                    &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(standard change)</span>
                </label>
                {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
            </div>
            
        @else
            <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}

                @if ($certifieds->count() == 0)
                    <label  class="col-md-2 label-height" >
                        {!! Form::radio('standard_change', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change1']) !!}
                        &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(initial assessment)</span>
                    </label>
                    <label  class="col-md-2 label-height" >
                        {!! Form::radio('standard_change', '6', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change6']) !!}
                        &nbsp;โอนใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(transfer accreditation)</span>
                    </label>

                @endif

                @if ($certifieds->count() > 0)
                    <label  class="col-md-2 label-height" >
                        {!! Form::radio('standard_change', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change1']) !!}
                        &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(initial assessment)</span>
                    </label>
                    <label  class="col-md-2 label-height">
                        {!! Form::radio('standard_change', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change2']) !!}
                        &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(renewal)</span>
                    </label>
                    <label  class="col-md-2 label-height">
                        {!! Form::radio('standard_change', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change3']) !!}
                        &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(extending accreditation)</span>
                    </label>
                    <label  class="col-md-3 label-height">
                        {!! Form::radio('standard_change', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change4']) !!}
                        &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(standard change)</span>
                    </label>
                @endif

                {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
            </div>
            

            @if ($certifieds->count() > 0)
                <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
                    <label for="" class="col-md-3 control-label label-height"></label>
                
                    <label  class="col-md-2 label-height" >
                        {!! Form::radio('standard_change', '5', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change5']) !!}
                        &nbsp;ย้ายสถานที่ <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(Relocation)</span>
                    </label>
                    <label  class="col-md-2 label-height">
                        {!! Form::radio('standard_change', '6', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change6']) !!}
                        &nbsp;โอนใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="font_size">(transfer accreditation)</span>
                    </label>
                

                    {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
                </div>
            @endif
        
        @endif


        <div id="box_ref_application_no">
            <div class="form-group">
                <label for="ref_application_no" class="col-md-3 control-label label-height">
                    ใบรับรองเลขที่:<br/>
                    <span class="font_size">(Certificate No.)</span>
                </label>
                <div class="col-md-4">
                    <select name="select_certified" id="select_certified" class="form-control" readonly>
                    </select>
                    @if ($errors->has('select_certified'))
                        <p class="help-block">{{ $errors->first('select_certified') }}</p>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('ref_application_no') ? 'has-error' : '' }}">
                <label for="ref_application_no" class="col-md-3 control-label label-height">
                    อ้างอิงเลขที่คำขอ:<br/>
                    <span class="font_size">(Application No.)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" name="ref_application_no" id="ref_application_no" class="form-control" value="{{ old('ref_application_no') }}">
                    @if ($errors->has('ref_application_no'))
                        <p class="help-block">{{ $errors->first('ref_application_no') }}</p>
                    @endif
                </div>
            </div>
            {{-- <div class="form-group {{ $errors->has('certificate_exports_id') ? 'has-error' : '' }}">
                <label for="certificate_exports_id" class="col-md-3 control-label label-height">
                    ใบรับรองเลขที่:<br/>
                    <span class="font_size">(Certificate No)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" name="certificate_exports_id" id="certificate_exports_id" class="form-control" value="{{ old('certificate_exports_id') }}">
                    @if ($errors->has('certificate_exports_id'))
                        <p class="help-block">{{ $errors->first('certificate_exports_id') }}</p>
                    @endif
                </div>
            </div> --}}
            <div class="form-group {{ $errors->has('accereditation_no') ? 'has-error' : '' }}">
                <label for="accereditation_no" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> หมายเลขการรับรองที่:<br/>
                    <span class="font_size">(Accreditation No. Calibration)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" name="accereditation_no" id="accereditation_no" class="form-control" value="{{ old('accereditation_no') }}">
                    @if ($errors->has('accereditation_no'))
                        <p class="help-block">{{ $errors->first('accereditation_no') }}</p>
                    @endif
                </div>
            </div>
        </div>


        <div class="form-group {{ $errors->has('branch_type') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('branch_type', '<span class="text-danger">*</span> ประเภทสาขา'.':'.'<br/><span class=" font_size">(Branch Type)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-4" >
                <div class="iradio_square-blue {!! (@$certi_ib->branch_type == 1)?'checked':'' !!}"></div>
                <label for="branch_type1">&nbsp;สำนักงานใหญ่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="iradio_square-blue {!! (@$certi_ib->branch_type != 1)?'checked':'' !!}"></div>
                <label for="branch_type2">&nbsp;สาขา</label>
                <input type="hidden" name="branch_type" value="{!! (@$certi_ib->branch_type == 1)?1:2 !!}" />
            </div>
        </div>



        <div class="form-group {{ $errors->has('name_unit') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name_unit', '<span class="text-danger">*</span> หน่วยตรวจสอบ (TH)'.':'.'<br/><span class=" font_size">(Examination room name)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-6">
                {!! Form::text('name_unit', !empty($certi_ib->name_unit)?$certi_ib->name_unit:null, ['class' => 'form-control', 'required' => true]) !!}
                {!! $errors->first('name_unit', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('name_en_unit') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name_en_unit', '<span class="text-danger">*</span> หน่วยตรวจสอบ (EN)'.':'.'<br/><span class=" font_size">(Examination room name)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-6">
                {!! Form::text('name_en_unit', !empty($certi_ib->name_en_unit)?$certi_ib->name_en_unit:null, ['class' => 'form-control input_address_eng', 'required' => true]) !!}
                {!! $errors->first('name_en_unit', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('name_short_unit') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name_short_unit', 'ชื่อย่อหน่วยตรวจสอบ'.':'.'<br/><span class=" font_size">(Examination room Short name)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-6">
                {!! Form::text('name_short_unit', !empty($certi_ib->name_short_unit)?$certi_ib->name_short_unit:null, ['class' => 'form-control', 'required' => false]) !!}
                {!! $errors->first('name_short_unit', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    
    <div id="transfer-wrapper" style="display: none;">
        <div class="form-group">
            <div class="col-md-3 control-label label-height">
                <h3>ข้อมูลผู้โอน </h3>
            </div>
            <div class="col-md-7 label-height" style="margin-top:10px">
                <button id="check_transferee" type="button" class="btn btn-sm btn-info">ตรวจสอบ</button>
            </div>
        </div>
        <div class="form-group">
            <label for="id_number" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> ใบรับรองเลขที่:<br/>
                <span class="font_size">(Transferer Certificate Number)</span>
            </label>
            <div class="col-md-7">
                <input type="text" name="transferee_certificate_number" id="transferee_certificate_number" class="form-control" maxlength="13">
            </div>
        </div>
        <div class="form-group">
            <label for="id_number" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> เลข 13 หลักผู้โอน:<br/>
                <span class="font_size">(Transferer 13-digit ID)</span>
            </label>
            <div class="col-md-7">
                <input type="text" name="transferer_id_number" id="transferer_id_number" class="form-control" maxlength="13">
            </div>
        </div>
        
        <div class="form-group">
            <label for="transferee_name" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> ชื่อผู้โอน:<br/>
                <span class="font_size">(Transferer Name)</span>
            </label>
            <div class="col-md-7">
                <input type="text" name="transferee_name" id="transferee_name" class="form-control" readonly>
            </div>
        </div>
 
        
    </div>

    <hr>

    <div class="row">
        <div class="form-group {{ $errors->has('use_address_office') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('use_address_office', 'ที่ตั้งหน่วยตรวจสอบ'.':'.'<br/><span class=" font_size">(Address laboratory)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-8">
                <div class="col-md-4">
                    {!! Form::radio('use_address_office', '1',null, ['class' => 'form-control check', 'data-radio' => 'iradio_square-blue', 'id'=>'use_address_office-1']) !!}
                    {!! Form::label('use_address_office-1', 'ที่อยู่เดียวกับที่อยู่สำนักงานใหญ่', ['class' => 'control-label font-medium-1 text-capitalize']) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::radio('use_address_office', '2',null, ['class' => 'form-control check', 'data-radio' => 'iradio_square-blue', 'id'=>'use_address_office-2']) !!}
                    {!! Form::label('use_address_office-2', 'ที่อยู่เดียวกับที่อยู่ติดต่อได้', ['class' => 'control-label font-medium-1 text-capitalize']) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::radio('use_address_office', '3',null, ['class' => 'form-control check', 'data-radio' => 'iradio_square-blue', 'id'=>'use_address_office-3']) !!}
                    {!! Form::label('use_address_office-3', 'ระบุที่ตั้งใหม่', ['class' => 'control-label font-medium-1 text-capitalize']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('address_number', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('address', null, ['class' => 'form-control input_address', 'required' => 'required','id'=>'address']) !!}
                    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('allay') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('allay', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('allay', null, ['class' => 'form-control input_address','id'=>'allay']) !!}
                    {!! $errors->first('allay', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('village_no') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('address_soi', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('village_no', null, ['class' => 'form-control input_address','id'=>'village_no']) !!}
                    {!! $errors->first('village_no', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('road') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('address_street', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('road', null, ['class' => 'form-control input_address','id'=>'road']) !!}
                    {!! $errors->first('road', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group ">
                {!! Form::label('authorized_address_seach', 'ค้นหาที่อยู่'.' :', ['class' => 'col-md-5 control-label']) !!}
                <div class="col-md-7">
                    {!! Form::text('authorized_address_seach', null,  ['class' => 'form-control authorized_address_seach', 'autocomplete' => 'off', 'data-provide' => 'typeahead', 'placeholder' => 'ค้นหาที่อยู่' ]) !!}
                    {!! $errors->first('authorized_address_seach', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('province') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('address_city', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::select('province_id',$Province_arr->pluck('PROVINCE_NAME', 'PROVINCE_ID' ),  null,['class' => 'form-control input_address', 'id'=>'province_id',  'placeholder' =>'- เลือกจังหวัด -']) !!}
                   {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('amphur_id') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('amphur_id', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('amphur_id', null, ['class' => 'form-control input_address','id'=>'amphur_id']) !!}
                    {!! $errors->first('amphur_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('district_id ') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('district_id ', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                   {!! Form::text('district_id', null, ['class' => 'form-control input_address','id'=>'district_id']) !!}
                   {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('postcode', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('postcode', null, ['class' => 'form-control input_address', 'required' => 'required','id'=>'postcode']) !!}
                    {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! HTML::decode(Form::label('', '',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <a class="btn btn-default pull-left" id="show_map" onclick="return false">
                        ค้นหาจากแผนที่
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_latitude') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_latitude', 'พิกัดที่ตั้ง (ละติจูด)'.':'.'<br/><span class=" font_size">(latitude)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="ib_latitude" id="ib_latitude" class="form-control input_address" value="{!! !empty($certi_ib->ib_latitude)?$certi_ib->ib_latitude: null !!}" >
                    {!! $errors->first('ib_latitude', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_longitude') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_longitude', 'พิกัดที่ตั้ง (ลองจิจูด)'.':'.'<br/><span class=" font_size">(longitude)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="ib_longitude" id="ib_longitude" class="form-control input_address" value="{!! !empty($certi_ib->ib_longitude)?$certi_ib->ib_longitude: null !!}" >
                    {!! $errors->first('ib_longitude', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! HTML::decode(Form::label('', 'ที่ตั้งหน่วยตรวจสอบ (EN)',['class' => 'col-md-6 control-label label-height'])) !!}
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_address_no_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_address_no_eng', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('ib_address_no_eng', !empty($certi_ib->ib_address_no_eng)?$certi_ib->ib_address_no_eng: null , ['class' => 'form-control input_address_eng', 'required' => 'required']) !!}
                    {!! $errors->first('ib_address_no_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_moo_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_moo_eng', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Moo)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('ib_moo_eng', !empty($certi_ib->ib_moo_eng)?$certi_ib->ib_moo_eng: null , ['class' => 'form-control input_address_eng']) !!}
                    {!! $errors->first('ib_moo_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_soi_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_soi_eng', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('ib_soi_eng', !empty($certi_ib->ib_soi_eng)?$certi_ib->ib_soi_eng: null , ['class' => 'form-control input_address_eng']) !!}
                    {!! $errors->first('ib_soi_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_street_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_street_eng', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('ib_street_eng', !empty($certi_ib->ib_street_eng)?$certi_ib->ib_street_eng: null , ['class' => 'form-control input_address_eng']) !!}
                    {!! $errors->first('ib_street_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('address_city') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_province_eng', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::select('ib_province_eng', $Province_arr->where('PROVINCE_NAME_EN', '!=', null)->pluck('PROVINCE_NAME_EN', 'PROVINCE_ID' ), !empty($certi_ib->ib_province_eng)?$certi_ib->ib_province_eng: null , ['class' => 'form-control', 'id'=>'ib_province_eng', 'required' => true,  'placeholder' =>'- PROVINCE -']) !!}
                    {!! $errors->first('ib_province_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_amphur_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_amphur_eng', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="ib_amphur_eng" id="ib_amphur_eng" class="form-control input_address_eng" value="{!! !empty($certi_ib->ib_amphur_eng)?$certi_ib->ib_amphur_eng: null !!}">
                    {!! $errors->first('ib_amphur_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_district_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_district_eng', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="ib_district_eng" id="ib_district_eng" class="form-control input_address_eng" value="{!! !empty($certi_ib->ib_district_eng)?$certi_ib->ib_district_eng: null !!}">
                    {!! $errors->first('ib_district_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group {{ $errors->has('ib_postcode_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ib_postcode_eng', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="ib_postcode_eng" id="ib_postcode_eng" class="form-control input_address_eng" required value="{!! !empty($certi_ib->ib_postcode_eng)?$certi_ib->ib_postcode_eng: null !!}">
                    {!! $errors->first('ib_postcode_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! HTML::decode(Form::label('', 'ข้อมูลสำหรับการติดต่อ (Contact information)',['class' => 'col-md-6 control-label label-height'])) !!}
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('contactor_name') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('contact', '<span class="text-danger">*</span> ชื่อบุคคลที่ติดต่อ'.':'.'<br/><span class=" font_size">(Contact Person)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('contactor_name', !empty($certi_ib->contactor_name)?$certi_ib->contactor_name: null  , ['class' => 'form-control' ,'id'=>'contactor_name','readonly'=>true]) !!}
                    {!! $errors->first('contactor_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('email', !empty($certi_ib->email)?$certi_ib->email: null, ['class' => 'form-control','required'=>"required","placeholder"=>"Email@gmail.com",'id'=>"address_email",'readonly'=>true]) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('contact_tel') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('contact_mobile', 'โทรศัพท์ผู้ติดต่อ'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('contact_tel', !empty($certi_ib->contact_tel)?$certi_ib->contact_tel: null  , ['class' => 'form-control' ,'id'=>'contact_tel','readonly'=>true]) !!}
                    {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('telephone', '<span class="text-danger">*</span> โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('telephone', !empty($certi_ib->telephone)?$certi_ib->telephone: null , ['class' => 'form-control','id'=>"telephone",'readonly'=>true]) !!}
                    {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    
</fieldset>

<fieldset class="white-box" hidden>
    <legend><h4>1. ข้อมูลทั่วไป (General information)</h4></legend>
    <div class="m-l-10 form-group {{ $errors->has('petitioner') ? 'has-error' : ''}}">
        <div class="col-md-6 ">
            {!! Form::text('petitioner' ,'ใบรับรองหน่วยตรวจ', ['class' => 'form-control','disabled'=>true]) !!}
            {!! $errors->first('petitioner', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</fieldset>
{{-- {{$tis_data}} --}}

@push('js')
    <script>
        const app_ib_id = '{{ @$app_certi_ib->id }}';
        var certifieds;
        var certi_ib;

        certifieds = @json($certifieds->mapWithKeys(function($certified) {
                return [$certified->id => $certified->certificate];
            }) ?? []);
            certi_ib = @json($certi_ib ?? []);
            
            console.log(certifieds);

        $(document).ready(function () {

        $('#scope-editor').on('click', function(e) {
            e.preventDefault();
            
            // Get the values from the form inputs
            var typeStandard = $('#type_standard').val();
            var typeUnit = $('input[name="type_unit"]:checked').val();
            var standardChange = $('input[name="standard_change"]:checked').val();
            var nameUnit = $('#name_unit').val();
            var nameEnUnit = $('#name_en_unit').val();
            var address = $('#address').val();
            var allay = $('#allay').val();
            var villageNo = $('#village_no').val();
            var road = $('#road').val();
            var provinceId = $('#province_id').val();
            var provinceText = $('#province_id option:selected').text();
            var amphurId = $('#amphur_id').val();
            var districtId = $('#district_id').val();
            var postcode = $('#postcode').val();
            
            // Check if required values are undefined or empty
            if (!typeStandard || !typeUnit || !standardChange || !nameUnit || !nameEnUnit || 
                !address || !provinceId || !amphurId || !districtId || !postcode) {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน: ตามมาตรฐานเลข, หน่วยตรวจประเภท, วัตถุประสงค์, หน่วยตรวจสอบ (TH), หน่วยตรวจสอบ (EN), เลขที่, จังหวัด, เขต/อำเภอ, แขวง/ตำบล, และรหัสไปรษณีย์');
                return;
            }
            
            // Build the URL with query parameters
            var url = $(this).attr('href') + '?type_standard=' + encodeURIComponent(typeStandard) +
                    '&type_unit=' + encodeURIComponent(typeUnit) +
                    '&standard_change=' + encodeURIComponent(standardChange) +
                    '&name_unit=' + encodeURIComponent(nameUnit) +
                    '&name_en_unit=' + encodeURIComponent(nameEnUnit) +
                    '&address=' + encodeURIComponent(address) +
                    (allay ? '&allay=' + encodeURIComponent(allay) : '') +
                    (villageNo ? '&village_no=' + encodeURIComponent(villageNo) : '') +
                    (road ? '&road=' + encodeURIComponent(road) : '') +
                    '&province=' + encodeURIComponent(provinceText) +
                    '&amphur_id=' + encodeURIComponent(amphurId) +
                    '&district_id=' + encodeURIComponent(districtId) +
                    '&postcode=' + encodeURIComponent(postcode);
            
            // Open the URL in a new tab
            window.open(url, '_blank');
        });

            //เมื่อกรอกภาษาอังกฤษ
            $('.input_address_eng').keyup(function(event) {
                filterEngAndNumberOnlyCustomForPage(this);//เอาเฉพาะภาษาอังกฤษ ฟังก์ชั่นในไฟล์ function.js
            });

            $('.input_address_eng').change(function(event) {
                filterEngAndNumberOnlyCustomForPage(this);//เอาเฉพาะภาษาอังกฤษ ฟังก์ชั่นในไฟล์ function.js
            });

            $('#show_map').click(function(){
                $('#modal-default').modal('show');
            });

            $('#button-modal-default').click(function(){

                if( $('#lat1').val() != ""){
                    $('#ib_latitude').val( $('#lat1').val());
                }else{
                    $('#ib_latitude').val('');
                }

                if( $('#lng1').val() != ""){
                    $('#ib_longitude').val( $('#lng1').val());
                }else{
                    $('#ib_longitude').val('');
                }

                $('#modal-default').modal('hide');
            });

            $('#use_address_office-1').on('ifChecked', function(event){
                use_address_offices();
            });

            $('#use_address_office-2').on('ifChecked', function(event){
                use_address_offices();
            });

            $('#use_address_office-3').on('ifChecked', function(event){
                use_address_offices();
            });

            $("#authorized_address_seach").select2({
                dropdownAutoWidth: true,
                width: '100%',
                ajax: {
                    url: "{{ url('/funtions/search-addreess') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params // search term
                        };
                    },
                    results: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true,
                },
                placeholder: 'คำค้นหา',
                minimumInputLength: 1,
            });

            $("#authorized_address_seach").on('change', function () {
                $.ajax({
                    url: "{!! url('/funtions/get-addreess/') !!}" + "/" + $(this).val()
                }).done(function( jsondata ) {
                    if(jsondata != ''){

                        $('#province_id').val(jsondata.pro_id).select2();
                        $('#amphur_id').val(jsondata.dis_title);
                        $('#district_id').val(jsondata.sub_title);
                        $('#postcode').val(jsondata.zip_code);

                        $('#ib_province_eng').val(jsondata.pro_id).select2();
                        $('#ib_amphur_eng').val(jsondata.dis_title_en);
                        $('#ib_district_eng').val(jsondata.sub_title_en);
                        $('#ib_postcode_eng').val(jsondata.zip_code);

                    }
                });
            });
            
                  
            // change   สาขาที่ขอรับการรับรอง
            $("input[name=standard_change]").on("ifChanged",function(){
                box_ref_application_no();
                get_app_no_and_certificate_exports_no();
            });   

            // change   สาขาที่ขอรับการรับรอง
            $("#type_standard").change(function(){
                box_ref_application_no();
                get_app_no_and_certificate_exports_no();
            });
            box_ref_application_no();

        });

        function use_address_offices(){

            $('.input_address').val('');
            $('body').find('select.input_address').val('').select2();

            if( $('#use_address_office-1').is(':checked',true) ){

                var address =  '{!! isset($tis_data) && !empty($tis_data->address_no) ?$tis_data->address_no:'' !!}';
                var moo =  '{!! isset($tis_data) && !empty($tis_data->moo) ?$tis_data->moo:'' !!}';
                var soi =  '{!! isset($tis_data) && !empty($tis_data->soi) ?$tis_data->soi:'' !!}';
                var road =  '{!! isset($tis_data) && !empty($tis_data->street) ?$tis_data->street:'' !!}';
                var building =  '{!! isset($tis_data) && !empty($tis_data->building) ?$tis_data->building:'' !!}';

                var subdistrict_txt =  '{!! isset($tis_data) && !empty($tis_data->subdistrict) ?$tis_data->subdistrict:'' !!}';
                var district_txt = '{!! isset($tis_data) && !empty($tis_data->district) ?$tis_data->district:'' !!}';
                var province_txt = '{!! isset($tis_data) && !empty($tis_data->province_id) ?$tis_data->province_id:'' !!}';
                var postcode_txt = '{!! isset($tis_data) && !empty($tis_data->zipcode) ?$tis_data->zipcode:'' !!}';

                var longitude =  '{!! isset($tis_data) && !empty($tis_data->longitude) ?$tis_data->longitude:'' !!}';
                var latitude =  '{!! isset($tis_data) && !empty($tis_data->latitude) ?$tis_data->latitude:'' !!}';

                // console.log(postcode_txt)

                $('#address').val(address);
                $('#allay').val(moo);
                $('#village_no').val(soi);
                $('#road').val(road);

                $('#province_id').val(province_txt).select2();
                $('#amphur_id').val(district_txt);
                $('#district_id').val(subdistrict_txt);
                $('#postcode').val(postcode_txt);

                $('#ib_latitude').val(latitude);
                $('#ib_longitude').val(longitude);

            }else if( $('#use_address_office-2').is(':checked',true) ){

                var address =  '{!! isset($tis_data) && !empty($tis_data->contact_address_no) ?$tis_data->contact_address_no:'' !!}';
                var moo =  '{!! isset($tis_data) && !empty($tis_data->contact_moo) ?$tis_data->contact_moo:'' !!}';
                var soi =  '{!! isset($tis_data) && !empty($tis_data->contact_soi) ?$tis_data->contact_soi:'' !!}';
                var road =  '{!! isset($tis_data) && !empty($tis_data->contact_street) ?$tis_data->contact_street:'' !!}';
                var building =  '{!! isset($tis_data) && !empty($tis_data->contact_building) ?$tis_data->contact_building:'' !!}';

                var subdistrict_txt =  '{!! isset($tis_data) && !empty($tis_data->contact_subdistrict) ?$tis_data->contact_subdistrict:'' !!}';
                var district_txt = '{!! isset($tis_data) && !empty($tis_data->contact_district) ?$tis_data->contact_district:'' !!}';
                var province_txt = '{!! isset($tis_data) && !empty($tis_data->contact_province_id) ?$tis_data->contact_province_id:'' !!}';
                var postcode_txt = '{!! isset($tis_data) && !empty($tis_data->contact_zipcode) ?$tis_data->contact_zipcode:'' !!}';

                $('#address').val(address);
                $('#allay').val(moo);
                $('#village_no').val(soi);
                $('#road').val(road);

                $('#province_id').val(province_txt).select2();
                $('#amphur_id').val(district_txt);
                $('#district_id').val(subdistrict_txt);
                $('#postcode').val(postcode_txt);
            }
    
        }

        function box_ref_application_no(){
            let standard_change = $('input[name="standard_change"]:checked').val();
            let typeStandard = $('#type_standard').val();
            let typeUnit = $('input[name="type_unit"]:checked').val();
            // if(standard_change >= 2){
            if(standard_change >= 2 && standard_change < 6){

                $.get("{{ url('/certify/certi_ib/get-certificate-belong') }}", { 
                    typeStandard: typeStandard,
                    typeUnit: typeUnit
                    }).done(function( data ) {
                       
                        if (data.certificateExports.length > 0) {
                            // ล้างเนื้อหาใน select เดิมก่อน (ถ้ามี)
                            $('#select_certified').empty();
                            // Loop ข้อมูลจาก data.certificateExports เพื่อสร้าง option
                            data.certificateExports.forEach(function(cert) {
                                $('#select_certified').append(
                                    $('<option>', {
                                        value: cert.id,
                                        text: cert.certificate
                                    })
                                );
                            });

                            // เพิ่ม readonly attribute ให้กับ select
                            $('#select_certified').attr('readonly', 'readonly');
                            $('#select_certified option:first').val();
                            $('#select_certified').trigger('change');
                            } else {
                                // กรณีไม่มีข้อมูล
                                console.log("No certificate exports found.");
                            } 
                    });


                $('#box_ref_application_no').show();
                $('#box_ref_application_no').find('input').prop('disabled', false);
                $('#accereditation_no').prop('required', true);
                $('#transfer-wrapper').hide(); 
            }else if(standard_change == 1){
                $('#box_ref_application_no').hide();
                $('#box_ref_application_no').find('input').prop('disabled', true);
                $('#accereditation_no').prop('required', false);
                console.log("ขอครั้งแรก")
                isIbTypeAndStandardBelong();
                $('#transfer-wrapper').hide(); 
            }else if(standard_change == 6){

                $('#box_ref_application_no').hide();
                $('#box_ref_application_no').find('input').prop('disabled', true);
                $('#accereditation_no').prop('required', false);
                $('#transfer-wrapper').show(); 

            }else{
                $('#transfer-wrapper').hide(); 
            }
        }


// ตรวจสอบเมื่อ type_unit เปลี่ยนแปลง
    $("input[name=type_unit]").on("ifChanged", function() {
        // ตรวจสอบว่า input[name=standard_change] มีการ checked หรือไม่
        if ($('input[name=standard_change]:checked').length > 0) {
            let typeStandard = $('#type_standard').val();
            let typeUnit = $('input[name="type_unit"]:checked').val();
            console.log(typeStandard,typeUnit)

            $.get("{{ url('/certify/certi_ib/is-ib-type-and-standard-belong') }}", { 
                typeStandard: typeStandard,
                typeUnit: typeUnit
                }).done(function( data ) {
                    console.log(data);
                    if (data.certiIbs.length != 0)
                    {
                        // let typeUnitLabel = $('input[name="type_unit"]:checked').closest('label').text().trim();
                        alert('ไม่สามารถ "ยื่นขอครั้งแรก" สำหรับเลขมาตรฐาน "'+$('#type_standard option:selected').text().trim()+'" และหน่วยตรวจ  "'+$('input[name="type_unit"]:checked').closest('label').text().trim()+'" เนื่องจากมีใบรับรองแล้วในระบบแล้ว');
                        $("input[name=standard_change]").iCheck('uncheck');
                        $("input[name=type_unit]").iCheck('uncheck');
                    }
                    
                });
        } 
    }); 

        function isIbTypeAndStandardBelong(){

            let typeStandard = $('#type_standard').val();
            let typeUnit = $('input[name="type_unit"]:checked').val();
            console.log(typeStandard,typeUnit)

            $.get("{{ url('/certify/certi_ib/is-ib-type-and-standard-belong') }}", { 
                typeStandard: typeStandard,
                typeUnit: typeUnit
                }).done(function( data ) {
                    console.log(data);
                    if (data.certiIbs.length != 0)
                    {
                        // let typeUnitLabel = $('input[name="type_unit"]:checked').closest('label').text().trim();
                        alert('ไม่สามารถ "ยื่นขอครั้งแรก" สำหรับเลขมาตรฐาน "'+$('#type_standard option:selected').text().trim()+'" และหน่วยตรวจ  "'+$('input[name="type_unit"]:checked').closest('label').text().trim()+'" เนื่องจากมีใบรับรองแล้วในระบบแล้ว');
                        $("input[name=standard_change]").iCheck('uncheck');
                        $("input[name=type_unit]").iCheck('uncheck');
                    }
                    
                });
        }


        function get_app_no_and_certificate_exports_no(){
            let std_id = $('#type_standard').val();
            let standard_change = $('input[name="standard_change"]:checked').val();
            $('#ref_application_no').val(null);
            $('#certificate_exports_id').val(null);
            if(app_ib_id == '' && !!std_id && standard_change >= 2){
                $.get("{{ url('/certify/applicant-ib/get_app_no_and_certificate_exports_no') }}", { 
                    std_id: std_id
                }).done(function( data ) {
                    if(data.status){
                        $('#ref_application_no').val(data.app_no);
                        $('#certificate_exports_id').val(data.certificate_exports_no);
                    }
                });
            }
        }

        function getLastElementAsArray(fileSection) {
            try {
                // ตรวจสอบว่า fileSection เป็น Array และไม่ว่าง
                if (!Array.isArray(fileSection)) {
                    throw new Error("file_sectionn4s ต้องเป็น Array");
                }
                if (fileSection.length === 0) {
                    return [];
                }

                // ดึง element สุดท้ายและส่งคืนเป็น Array
                const lastElement = fileSection[fileSection.length - 1];
                return [lastElement];
            } catch (error) {
                console.error(`Error: ${error.message}`);
                return [];
            }
        }

        // ตัวอย่างการใช้งาน
        const result = {
            file_sectionn4s: [
                { name: "file1.txt", lastModified: 1697059200000 }, // 2023-10-12
                { name: "file2.txt", lastModified: 1697145600000 }, // 2023-10-13
                { name: "file3.txt", lastModified: 1697232000000 }  // 2023-10-14
            ]
        }; 

        $(document).on('change', '#select_certified', function() {
            var certified_id = $(this).val();
            const _token = $('input[name="_token"]').val();
            console.log(certified_id)
            if (certified_id === '' || certified_id === undefined) {
                return;
            }

            $.ajax({
                url: "/certify/certi_ib/api/get_certificated",
                method: "POST",
                data: {
                    certified_id: certified_id,
                    _token: _token
                },
                success: function(result) {
                    // attach_path = result.attach_path;
                    // console.log(result);

                    attach_path = result.attach_path;

                    ibScopeTransactions = result.ibScopeTransactions
                    renderInitialTable()

                    certi_ib = result.certiIb
                    
                    var dis_title = result.address.original.dis_title;
                    var dis_title_en = result.address.original.dis_title_en;
                    var pro_id = result.address.original.pro_id;
                    var sub_title = result.address.original.sub_title;
                    var sub_title_en = result.address.original.sub_title_en;
                    var zip_code = result.address.original.zip_code;
                    var labTestRequest = result.labTestRequest;
                    var certificateExport = result.certificateExport;

                    console.log('result',result);

                    $('#province_id').val(pro_id).trigger('change');
                    $('#address_district').val(dis_title);
                    $('#sub_district').val(sub_title);
                    $('#postcode').val(zip_code);
                    
                    $('#ib_province_eng').val(pro_id).trigger('change');
                    $('#ib_address_no_eng').val(result.certiIb.address);
                    $('#ib_moo_eng').val(result.certiIb.allay);
                    $('#ib_amphur_eng').val(dis_title_en);
                    $('#ib_district_eng').val(sub_title_en);
                    $('#ib_postcode_eng').val(zip_code);

                    
                    $('#name_unit').val(certi_ib.name_unit);
                    $('#name_en_unit').val(certi_ib.name_en_unit);
                    $('#name_short_unit').val(certi_ib.name_short_unit);
                    
                    

                    $('#accereditation_no').val(certificateExport.accereditatio_no);
                    

                    renderFiles(result.file_sectionn1s, '#repeater_section1_wrapper', '1');
                    $('.attachs_sec1').removeAttr('required');

                    renderFiles(result.file_sectionn2s, '#repeater_section2_wrapper', '2');
                    $('.attachs_sec2').removeAttr('required');

                    const lastElementArray = getLastElementAsArray(result.file_sectionn3s);

                    renderFiles(lastElementArray, '#repeater_section3_wrapper', '3');
                    $('.attachs_sec3').removeAttr('required');

                    
                    renderFiles(result.file_sectionn4s, '#repeater_section4_wrapper', '4');
                    $('.attachs_sec4').removeAttr('required');

                    renderFiles(result.file_sectionn5s, '#repeater_section5_wrapper', '5');
                    $('.attachs_sec5').removeAttr('required');
        

                    renderFiles(result.file_sectionn6s, '#repeater_section6_wrapper', '6');
                    $('.attachs_sec6').removeAttr('required');

                    
                    renderFiles(result.file_sectionn7s, '#repeater_section7_wrapper', '7');
                    $('.attachs_sec7').removeAttr('required');
        
                }
            });
        });

        function getLastElementAsArray(fileSection) {
    try {
        // ตรวจสอบว่า fileSection เป็น Array และไม่ว่าง
        if (!Array.isArray(fileSection)) {
            throw new Error("file_sectionn4s ต้องเป็น Array");
        }
        if (fileSection.length === 0) {
            return [];
        }

        // ดึง element สุดท้ายและส่งคืนเป็น Array
        const lastElement = fileSection[fileSection.length - 1];
        return [lastElement];
    } catch (error) {
        console.error(`Error: ${error.message}`);
        return [];
    }
}
        

        function renderFiles(files, wrapperSelector, section) {
            var wrapper = $(wrapperSelector);
            wrapper.empty(); // ล้างข้อมูลเก่าออก
            if (files.length > 0) {
                files.forEach(function(file) {
                    var fileItem = `
                        <div class="form-group">
                            <div class="col-md-4 text-light"></div>
                            <div class="col-md-6">
                                <a href="${baseUrl}certify/check/file_ib_client/${file.file}/${file.file_client_name}" target="_blank" class="view-attach btn btn-info btn-sm">
                                    <i class="fa fa-eye mr-2"></i> ${file.file_client_name}
                                </a>
                            </div>
                        </div>
                    `;
                    wrapper.append(fileItem);
                });
            }

            // Add default file input for uploading new files
            var newFileInput = `
                <div class="form-group box_remove_file" data-repeater-item>
                    <div class="col-md-4 text-light"></div>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">เลือกไฟล์</span>
                                <span class="fileinput-exists">เปลี่ยน</span>
                                <input type="file" name="repeater-section${section}[0][attachs_sec${section}]" class="attachs_sec${section} check_max_size_file" required>
                            </span> 
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                        <p class="help-block"></p>
                    </div>
            
                </div>
            `;
            wrapper.append(newFileInput);
        }
    
        
    $(document).on('click', '#check_transferee', function(e) {
        e.preventDefault();
        let transferee_certificate_number = $('#transferee_certificate_number').val();
        let transferer_id_number = $('#transferer_id_number').val();

        const _token            = $('input[name="_token"]').val();

        let pattern = /^\d{2}-IB\d{4}$/;

        if (!pattern.test(transferee_certificate_number)) {
            alert("รูปแบบใบรับรอง IB ไม่ถูกต้อง");
            return;
        } 

        // ลบอักขระพิเศษทั้งหมดให้เหลือแต่ตัวเลข
        transferer_id_number = transferer_id_number.replace(/\D/g, ''); // \D หมายถึงตัวอักษรที่ไม่ใช่ตัวเลข

        // ตรวจสอบให้เป็นเลข 13 หลัก
        if (transferer_id_number.length !== 13) {
            alert("กรุณากรอกเลข 13 หลัก");
            return;
        }

        $.ajax({
                url:"{{route('certi_ib.check_ib_transferee')}}",
                method:"POST",
                data:{
                    transferer_id_number:transferer_id_number,
                    transferee_certificate_number:transferee_certificate_number,
                    _token:_token
                },
                success:function (result){
                    console.log(result);
                    if(result.user == null)
                    {
                        alert('ไม่พบข้อมูลผู้รับโอน โปรดตรวจสอบว่าได้เลือก "ตามมาตรฐานเลข" และ "วัตถุประสงค์ในการยื่นคำขอ" และ "เลขที่ใบรับรอง" และ "เลข 13 หลักของผู้โอน" ตรงกับใบรับรองที่ต้องการรับโอน');
                    }else
                    {
                        alert('ต้องการโอนใบรับรองจาก' + result.user.name );
                        $('#transferee_name').val( result.user.name);
                        // $('#lab_name').val( result.certiLab.lab_name);
                        // $('#lab_name_en').val( result.certiLab.lab_name_en);
                        // $('#lab_name_short').val( result.certiLab.lab_name_short);
                    }
                    
                }
            });
    });

    </script>
@endpush