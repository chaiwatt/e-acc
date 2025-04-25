


<fieldset class="white-box">
    <legend><h4>ข้อมูลขอรับบริการ</h4></legend>

    <div class="row">

        @php
            $province = App\Models\Basic\Province::orderbyRaw('CONVERT(PROVINCE_NAME USING tis620)');
            $CertificationBranch = App\Models\Bcertify\CertificationBranch::select(DB::raw("CONCAT(title,' (',initial,')') AS titles"),'id')
                                                                            ->where('formula_id',@$certi_cb->type_standard)
                                                                            ->where('state',1)
                                                                            ->orderbyRaw('CONVERT(titles USING tis620)')
                                                                            ->pluck('titles','id');

            if( !isset($certi_cb->id) ){
                $app_check = App\Models\Certify\ApplicantCB\CertiCb::where( function($Query) use($tis_data){
                                                                    if(!is_null($tis_data->agent_id)){  // ตัวแทน
                                                                        $Query->where('agent_id',  $tis_data->agent_id ) ;
                                                                    }else{
                                                                        if($tis_data->branch_type == 1){  // สำนักงานใหญ่
                                                                            $Query->where('tax_id',  $tis_data->tax_number ) ;
                                                                        }else{   // ผู้บันทึก
                                                                            $Query->where('created_by',   auth()->user()->getKey()) ;
                                                                        }
                                                                    }
                                                                })
                                                                ->get();

                $certificate_no = DB::table('app_certi_cb_export AS export')
                                    ->leftJoin('app_certi_cb AS cb', 'cb.id', '=', 'export.app_certi_cb_id')
                                    ->select('export.id')
                                    ->where('cb.tax_id',$tis_data->tax_number)
                                    ->where('export.status',3)
                                    ->get();
            }

            // dd(count($certificate_no)==0);

            $Formula_Arr = App\Models\Bcertify\Formula::where('applicant_type',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');

        @endphp

        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        @if ( count($formulas) == 1 )
            <div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('type_standard', '<span class="text-danger">*</span> ข้อกำหนดที่ใช้ในการรับรอง'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <div class="col-md-4" >
                    {!! Form::select('type_standard', $Formula_Arr,  !empty( $certi_cb->type_standard )?$certi_cb->type_standard:$formulas[0]->id, ['class' => 'form-control', 'id'=>'type_standard','required' => true]) !!}
                    {!! $errors->first('type_standard', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        @else
            <div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('type_standard', '<span class="text-danger">*</span> ข้อกำหนดที่ใช้ในการรับรอง'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <div class="col-md-4" >
                    {!! Form::select('type_standard', $Formula_Arr,  !empty( $certi_cb->type_standard )?$certi_cb->type_standard:null, ['class' => 'form-control', 'id'=>'type_standard','required' => true, 'placeholder' =>'- เลือกข้อกำหนดที่ใช้ในการรับรอง -']) !!}
                    {!! $errors->first('type_standard', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        @endif

        @if( isset($certi_cb->id) && !empty($certi_cb->standard_change) )

            <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <label  class="col-md-2 label-height">
                    {!! Form::radio('standard_change', '1', $certi_cb->standard_change == 1 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change1']) !!}
                    &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(initial assessment)</span>
                </label>
                <label  class="col-md-2 label-height">
                    {!! Form::radio('standard_change', '2', $certi_cb->standard_change == 2 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change2']) !!}
                    &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(renewal)</span>
                </label>
                <label  class="col-md-2 label-height">
                    {!! Form::radio('standard_change', '3', $certi_cb->standard_change == 3 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change3']) !!}
                    &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(extending accreditation)</span>
                </label>
                <label  class="col-md-3 label-height">
                    {!! Form::radio('standard_change', '4', $certi_cb->standard_change == 4 ?true:false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'standard_change4']) !!}
                    &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(standard change)</span>
                </label>
                {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
            </div>

        @else
            <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
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
                {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
            </div>

        @endif

        <div id="box_ref_application_no" >
            <div class="form-group {{ $errors->has('ref_application_no') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('ref_application_no', 'อ้างอิงเลขที่คำขอ'.':'.'<br/><span class=" font_size">(Application No.)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
                <div class="col-md-4">
                    {!! Form::text('ref_application_no', null, ['class' => 'form-control', 'id' => 'ref_application_no']) !!}
                    {!! $errors->first('ref_application_no', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('certificate_exports_id') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('certificate_exports_id', 'ใบรับรองเลขที่'.':'.'<br/><span class="  font_size">(Certificate No)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <div class="col-md-4">
                    {!! Form::text('certificate_exports_id', null, ['class' => 'form-control', 'id' => 'certificate_exports_id']) !!}
                    {!! $errors->first('certificate_exports_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('accereditation_no') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('accereditation_no', '<span class="text-danger">*</span> หมายเลขการรับรองที่'.':'.'<br/><span class="  font_size">(Accreditation No. Calibration)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                <div class="col-md-4">
                    {!! Form::text('accereditation_no', null, ['class' => 'form-control', 'id' => 'accereditation_no']) !!}
                    {!! $errors->first('accereditation_no', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        {{-- @if (!is_null($certificate_exports))

            @if (count($certificate_no)==1)
                <div class="form-group div_certificate_exports_id{{ $errors->has('certificate_exports_id') ? 'has-error' : ''}}">
                    {!! HTML::decode(Form::label('certificate_exports_id', '<span class="text-danger">*</span> ใบรับรองเลขที่'.':'.'<br/><span class="  font_size">(Certificate No)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                    <div class="col-md-4" >
                        {!! Form::select('certificate_exports_id', $certificate_exports, !empty($certi_cb->certificate_exports_id)?$certi_cb->certificate_exports_id:$certificate_no[0]->id, ['class' => 'form-control','id'=>'certificate_exports_id','required' => true,'placeholder' =>'- ใบรับรองเลขที่ -', 'readonly' =>true ] ) !!}
                        {!! $errors->first('certificate_exports_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            @elseif (count($certificate_no) > 1)
                <div class="form-group div_certificate_exports_id{{ $errors->has('certificate_exports_id') ? 'has-error' : ''}}">
                    {!! HTML::decode(Form::label('certificate_exports_id', '<span class="text-danger">*</span> ใบรับรองเลขที่'.':'.'<br/><span class="  font_size">(Certificate No)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
                    <div class="col-md-4" >
                        {!! Form::select('certificate_exports_id', $certificate_exports, !empty($certi_cb->certificate_exports_id)?$certi_cb->certificate_exports_id:null, ['class' => 'form-control','id'=>'certificate_exports_id','required' => true,'placeholder' =>'- ใบรับรองเลขที่ -' ] ) !!}
                        {!! $errors->first('certificate_exports_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            @endif

        @endif --}}

        <div class="form-group {{ $errors->has('branch_type') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('branch_type', '<span class="text-danger">*</span> ประเภทสาขา'.':'.'<br/><span class=" font_size">(Branch Type)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-4" >
                <div class="iradio_square-blue {!! (@$certi_cb->branch_type == 1)?'checked':'' !!}"></div>
                <label for="branch_type1">&nbsp;สำนักงานใหญ่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="iradio_square-blue {!! (@$certi_cb->branch_type != 1)?'checked':'' !!}"></div>
                <label for="branch_type2">&nbsp;สาขา</label>
                <input type="hidden" name="branch_type" value="{!! (@$certi_cb->branch_type == 1)?1:2 !!}" />
            </div>
        </div>

        <div class="form-group {{ $errors->has('petitioner') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('petitioner', '<span class="text-danger">*</span> สาขา'.':'.'<br/><span class="  font_size">(ฺBranch)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-6" >
                {!! Form::select('petitioner', $CertificationBranch, !empty($certi_cb->petitioner)?$certi_cb->petitioner:null,['class' => 'form-control',  'id'=>'petitioner','required' => true,'placeholder' =>'- เลือกสาขาเข้าขอรับการรับรอง -']) !!}
                {!! $errors->first('petitioner', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('name_standard') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name_standard', '<span class="text-danger">*</span> หน่วยรับรอง'.':'.'<br/><span class=" font_size">(Name of Certification body)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-6">
                {!! Form::text('name_standard',  !empty($certi_cb->name_standard)?$certi_cb->name_standard:null, ['class' => 'form-control', 'required' => true]) !!}
                {!! $errors->first('name_standard', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('name_en_standard') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name_en_standard', '<span class="text-danger">*</span> หน่วยรับรอง (EN)'.':'.'<br/><span class=" font_size">(Name of Certification body)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-6">
                {!! Form::text('name_en_standard', !empty($certi_cb->name_en_standard)?$certi_cb->name_en_standard:null, ['class' => 'form-control input_address_eng', 'required' => true]) !!}
                {!! $errors->first('name_en_standard', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('name_short_standard') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('name_short_standard', 'ชื่อย่อหน่วยรับรอง'.':'.'<br/><span class=" font_size">(Short Name of Certification body)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
            <div class="col-md-6">
                {!! Form::text('name_short_standard', !empty($certi_cb->name_short_standard)?$certi_cb->name_short_standard:null, ['class' => 'form-control']) !!}
                {!! $errors->first('name_short_standard', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>

    <hr>

    <div class="row">
        <div class="form-group {{ $errors->has('use_address_office') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('use_address_office', 'ที่ตั้งหน่วยงาน'.':'.'<br/><span class=" font_size">(Address laboratory)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
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
                {!! HTML::decode(Form::label('address', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
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
                {!! HTML::decode(Form::label('village_no', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('village_no', null, ['class' => 'form-control input_address','id'=>'village_no']) !!}
                    {!! $errors->first('village_no', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('road') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('road', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
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
                {!! HTML::decode(Form::label('province_id', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::select('province_id',$province->pluck('PROVINCE_NAME','PROVINCE_ID'), null, ['class' => 'form-control input_address', 'id'=>'province_id', 'placeholder' =>'- เลือกจังหวัด -']) !!}
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
                {!! HTML::decode(Form::label('district_id ', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                   {!! Form::text('district_id', null, ['class' => 'form-control input_address','id'=>'district_id']) !!}
                   {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('postcode', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
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
            <div class="form-group {{ $errors->has('cb_latitude') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_latitude', 'พิกัดที่ตั้ง (ละติจูด)'.':'.'<br/><span class=" font_size">(latitude)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="cb_latitude" id="cb_latitude" class="form-control input_address" value="{!! !empty($certi_cb->cb_latitude)?$certi_cb->cb_latitude: null !!}">
                    {!! $errors->first('cb_latitude', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_longitude') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_longitude', 'พิกัดที่ตั้ง (ลองจิจูด)'.':'.'<br/><span class=" font_size">(longitude)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="cb_longitude" id="cb_longitude" class="form-control input_address" value="{!! !empty($certi_cb->cb_longitude)?$certi_cb->cb_longitude: null !!}">
                    {!! $errors->first('cb_longitude', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! HTML::decode(Form::label('', 'ที่ตั้งหน่วยงาน (EN)',['class' => 'col-md-6 control-label label-height'])) !!}
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_address_no_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_address_no_eng', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('cb_address_no_eng', !empty($certi_cb->cb_address_no_eng)?$certi_cb->cb_address_no_eng: null , ['class' => 'form-control input_address_eng', 'required' => 'required']) !!}
                    {!! $errors->first('cb_address_no_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_moo_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_moo_eng', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Moo)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('cb_moo_eng', !empty($certi_cb->cb_moo_eng)?$certi_cb->cb_moo_eng: null , ['class' => 'form-control input_address_eng']) !!}
                    {!! $errors->first('cb_moo_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_soi_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_soi_eng', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('cb_soi_eng', !empty($certi_cb->cb_soi_eng)?$certi_cb->cb_soi_eng: null , ['class' => 'form-control input_address_eng']) !!}
                    {!! $errors->first('cb_soi_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_street_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_street_eng', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('cb_street_eng', !empty($certi_cb->cb_street_eng)?$certi_cb->cb_street_eng: null , ['class' => 'form-control input_address_eng']) !!}
                    {!! $errors->first('cb_street_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('address_city') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_province_eng', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::select('cb_province_eng', $province->where('PROVINCE_NAME_EN', '!=', null)->pluck('PROVINCE_NAME_EN', 'PROVINCE_ID' ), !empty($certi_cb->cb_province_eng)?$certi_cb->cb_province_eng: null , ['class' => 'form-control', 'id'=>'cb_province_eng', 'required' => true,'placeholder' =>'- PROVINCE -']) !!}
                    {!! $errors->first('cb_province_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_amphur_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_amphur_eng', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="cb_amphur_eng" id="cb_amphur_eng" class="form-control input_address_eng" value="{!! !empty($certi_cb->cb_amphur_eng)?$certi_cb->cb_amphur_eng: null !!}">
                    {!! $errors->first('cb_amphur_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_district_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_district_eng', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="cb_district_eng" id="cb_district_eng" class="form-control input_address_eng" value="{!! !empty($certi_cb->cb_district_eng)?$certi_cb->cb_district_eng: null !!}">
                    {!! $errors->first('cb_district_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('cb_postcode_eng') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('cb_postcode_eng', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    <input type="text" name="cb_postcode_eng" id="cb_postcode_eng" class="form-control input_address_eng" required value="{!! !empty($certi_cb->cb_postcode_eng)?$certi_cb->cb_postcode_eng: null !!}">
                    {!! $errors->first('cb_postcode_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
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
                    {!! Form::text('contactor_name', !empty($certi_cb->contactor_name)?$certi_cb->contactor_name: null  , ['class' => 'form-control' ,'id'=>'contactor_name','readonly'=>true]) !!}
                    {!! $errors->first('contactor_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('email', !empty($certi_cb->email)?$certi_cb->email: null, ['class' => 'form-control','required'=>"required","placeholder"=>"Email@gmail.com",'id'=>"address_email",'readonly'=>true]) !!}
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
                    {!! Form::text('contact_tel', !empty($certi_cb->contact_tel)?$certi_cb->contact_tel: null  , ['class' => 'form-control' ,'id'=>'contact_tel','readonly'=>true]) !!}
                    {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('telephone', '<span class="text-danger">*</span> โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
                <div class="col-md-7">
                    {!! Form::text('telephone', !empty($certi_cb->telephone)?$certi_cb->telephone: null , ['class' => 'form-control','id'=>"telephone",'readonly'=>true]) !!}
                    {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

</fieldset>

@push('js')
    <script>
        const app_cb_id = '{{ @$certi_cb->id }}';

        $(document).ready(function () {

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
                    $('#cb_latitude').val( $('#lat1').val());
                }else{
                    $('#cb_latitude').val('');
                }

                if( $('#lng1').val() != ""){
                    $('#cb_longitude').val( $('#lng1').val());
                }else{
                    $('#cb_longitude').val('');
                }

                $('#modal-default').modal('hide');
            });

            $('#type_standard').change(function(){
                $('#petitioner').html('<option value="">- เลือกสาขาเข้าขอรับการรับรอง  -</option>').select2();
                if($(this).val()!=""){
                    let type = $('#type_standard').find('option[value="'+$(this).val()+'"]').text();
                    let row = type.replace("มอก.", "");
                    $('.span_tis').html(row);

                    $.ajax({
                    url: "{!! url('/certify/applicant-cb/formulas2') !!}"  + "/" + $(this).val()
                    }).done(function( object ) {
                        let row = object.data;
                        if(row != '-'){
                            $.each(row,function (index,value) {
                                $('#petitioner').append('<option value='+value.id+'  >'+value.titles+'</option>');
                            });
                        }
                    });

                }else{
                    $('.span_tis').html('');
                }
            });

            //  $('#type_standard').change();
            $('#petitioner').change(function(){
                if($(this).val()!=""){
                    let row = $('#petitioner').find('option[value="'+$(this).val()+'"]').text();
                    $('#span_certification').html(row);
                }else{
                    $('#span_certification').html('');
                }
            });


            $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});

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


                        $('#cb_province_eng').val(jsondata.pro_id).select2();
                        $('#cb_amphur_eng').val(jsondata.dis_title_en);
                        $('#cb_district_eng').val(jsondata.sub_title_en);
                        $('#cb_postcode_eng').val(jsondata.zip_code);

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
            $('#province_id').val('').select2();

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

                $('#address').val(address);
                $('#allay').val(moo);
                $('#village_no').val(soi);
                $('#road').val(road);

                $('#province_id').val(province_txt).select2();
                $('#amphur_id').val(district_txt);
                $('#district_id').val(subdistrict_txt);
                $('#postcode').val(postcode_txt);

                $('#cb_latitude').val(latitude);
                $('#cb_longitude').val(longitude);

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
            if(standard_change >= 2){
                $('#box_ref_application_no').show();
                $('#box_ref_application_no').find('input').prop('disabled', false);
                $('#accereditation_no').prop('required', true);
            }else{
                $('#box_ref_application_no').hide();
                $('#box_ref_application_no').find('input').prop('disabled', true);
                $('#accereditation_no').prop('required', false);
            }
        }

        function get_app_no_and_certificate_exports_no(){
            let std_id = $('#type_standard').val();
            let standard_change = $('input[name="standard_change"]:checked').val();
            $('#ref_application_no').val(null);
            $('#certificate_exports_id').val(null);
            if(app_cb_id == '' && !!std_id && standard_change >= 2){
                $.get("{{ url('/certify/applicant-cb/get_app_no_and_certificate_exports_no') }}", {
                    std_id: std_id
                }).done(function( data ) {
                    if(data.status){
                        $('#ref_application_no').val(data.app_no);
                        $('#certificate_exports_id').val(data.certificate_exports_no);
                    }
                });
            }
        }


    </script>
@endpush
