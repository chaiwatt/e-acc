
<style>
    .icheckbox_square-blue {
    transition: none !important;
}
</style>

<fieldset class="white-box" hidden>
    <legend><h4>ข้อมูลขอรับบริการ</h4></legend>

    <div class="row">

        @php
            $province = App\Models\Basic\Province::orderbyRaw('CONVERT(PROVINCE_NAME USING tis620)');
            // $CertificationBranch = App\Models\Bcertify\CertificationBranch::select(DB::raw("CONCAT(title,' (',initial,')') AS titles"),'id')
            //                                                                 ->where('formula_id',@$certi_cb->type_standard)
            //                                                                 ->where('state',1)
            //                                                                 ->orderbyRaw('CONVERT(titles USING tis620)')
            //                                                                 ->pluck('titles','id');
            $CertificationBranch = App\Models\Bcertify\CertificationBranch::select(
                                        DB::raw("CONCAT(title, ' (', initial, ')') AS titles"),
                                        'id',
                                        'model_name' // เพิ่ม model_name เข้ามา
                                    )
                                    ->where('formula_id', @$certi_cb->type_standard)
                                    ->where('state', 1)
                                    ->orderByRaw('CONVERT(titles USING tis620)')
                                    ->get()
                                    ->pluck(null, 'id'); // ดึงค่าทั้งหมดโดยไม่แปลงเป็น key-value คู่เดียว



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

            // $Formula_Arr = App\Models\Bcertify\Formula::where('applicant_type',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');

        @endphp

        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>


        @if (count($formulas) == 1)
            <div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
                <label for="type_standard" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> ข้อกำหนดที่ใช้ในการรับรอง:
                    <br/><span class="font_size">(According to TIS)</span>
                </label>
                <div class="col-md-6">
                    <select name="type_standard" id="type_standard" class="form-control" required>
                        @foreach($Formula_Arr as $key => $value)
                            <option value="{{ $key }}" 
                                {{ (!empty($certi_cb->type_standard) && $certi_cb->type_standard == $key) || $formulas[0]->id == $key ? 'selected' : '' }}>
                                {{ $value }} 
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('type_standard'))
                        <p class="help-block">{{ $errors->first('type_standard') }}</p>
                    @endif
                </div>
            </div>
        @else
            <div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
                <label for="type_standard" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> ข้อกำหนดที่ใช้ในการรับรอง:
                    <br/><span class="font_size">(According to TIS)</span>
                </label>
                <div class="col-md-8">
                    <select name="type_standard" id="type_standard" class="form-control" required>
                        <option value="">- เลือกข้อกำหนดที่ใช้ในการรับรอง -</option>
                        @foreach($Formula_Arr as $key => $value)
                            <option value="{{ $key }}" 
                                {{ !empty($certi_cb->type_standard) && $certi_cb->type_standard == $key ? 'selected' : '' }}>
                                ({{$key}}) {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('type_standard'))
                        <p class="help-block">{{ $errors->first('type_standard') }}</p>
                    @endif
                </div>
            </div>
        @endif




        {{-- <div class="form-group {{ $errors->has('petitioner') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('petitioner', '<span class="text-danger">*</span> สาขาการรับรอง'.':'.'<br/><span class="  font_size">(ฺBranch)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-6" >
                {!! Form::select('petitioner', $CertificationBranch, !empty($certi_cb->petitioner)?$certi_cb->petitioner:null,['class' => 'form-control',  'id'=>'petitioner','required' => true,'placeholder' =>'- เลือกสาขาเข้าขอรับการรับรอง -']) !!}
                {!! $errors->first('petitioner', '<p class="help-block">:message</p>') !!}
            </div>
        </div> --}}

        <div class="form-group {{ $errors->has('petitioner') ? 'has-error' : ''}}">
            <label for="petitioner" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> สาขาการรับรอง:
                <br/><span class="font_size">(ฺBranch)</span>
            </label>
            <div class="col-md-8">
                <select name="petitioner" id="petitioner" class="form-control" required>
                    <option value="">- เลือกสาขาเข้าขอรับการรับรอง -</option>
                    @foreach($CertificationBranch as $key => $value)
                        <option value="{{ $key }}" data-model = "{{$value->model_name}}"
                            {{ !empty($certi_cb->petitioner) && $certi_cb->petitioner == $key ? 'selected' : '' }}>
                            {{ $value->titles }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('petitioner'))
                    <p class="help-block">{{ $errors->first('petitioner') }}</p>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('trust_mark') ? 'has-error' : ''}}">
            <label for="trust_mark" class="col-md-3 control-label label-height">
                <span class="text-danger">*</span> มาตรฐานที่ใช้รับรอง:
                <br/><span class="font_size">(Standard to TIS)</span>
            </label>
            <div class="col-md-8">
                <select name="trust_mark" id="trust_mark" class="form-control" required>
                    <option value="">- เลือกมาตรฐานที่ใช้รับรอง -</option>
                        @if (!empty($certi_cb->petitioner_id))
                            @foreach($cbTrustmarks as $key => $cbTrustmark)
                            <option value="{{ $cbTrustmark->id }}" 

                                @if ($cbTrustmark->bcertify_certification_branche_id == $certi_cb->petitioner_id )
                                    selected
                                @endif>
                                {{ $cbTrustmark->tis_no}}
                            </option>
                            @endforeach
                        @endif

      

                </select>
                @if ($errors->has('trust_mark'))
                    <p class="help-block">{{ $errors->first('trust_mark') }}</p>
                @endif
            </div>
        </div>
        


        @if( isset($certi_cb->id) && !empty($certi_cb->standard_change) )
            @php $selectedStandard = $certi_cb->standard_change; @endphp
        @else
            @php $selectedStandard = null; @endphp
        @endif

        <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
            <label for="standard_change" class="col-md-3 control-label label-height">
                วัตถุประสงค์ในการยื่นคำขอ:
                <br/><span class="font_size">(Apply to NSC for)</span>
            </label>
            @if ($certifieds->count() == 0)
                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="1" id="standard_change1" class="check" data-radio="iradio_square-green" 
                        {{ $selectedStandard == 1 ? 'checked' : '' }}>
                    &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(initial assessment)</span>
                </label>

                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="6" id="standard_change6" class="check" data-radio="iradio_square-green" 
                        {{ $selectedStandard == 1 ? 'checked' : '' }}>
                    &nbsp;โอนใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(transfer accreditation)</span>
                </label>
            @endif

            @if ($certifieds->count() > 0)
                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="1" id="standard_change1" class="check" data-radio="iradio_square-green" 
                        {{ $selectedStandard == 1 ? 'checked' : '' }}>
                    &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(initial assessment)</span>
                </label>
                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="2" id="standard_change2" class="check" data-radio="iradio_square-green" 
                        {{ $selectedStandard == 2 ? 'checked' : '' }}>
                    &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(renewal)</span>
                </label>

                <label class="col-md-2 label-height">
                    <input type="radio" name="standard_change" value="3" id="standard_change3" class="check" data-radio="iradio_square-green" 
                        {{ $selectedStandard == 3 ? 'checked' : '' }}>
                    &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(extending accreditation)</span>
                </label>

                <label class="col-md-3 label-height">
                    <input type="radio" name="standard_change" value="4" id="standard_change4" class="check" data-radio="iradio_square-green" 
                        {{ $selectedStandard == 4 ? 'checked' : '' }}>
                    &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font_size">(standard change)</span>
                </label>
            @endif


            @if ($errors->has('standard_change'))
                <p class="help-block">{{ $errors->first('standard_change') }}</p>
            @endif
        </div>

        @if ($certifieds->count() > 0)
        <div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
            <label for="" class="col-md-3 control-label label-height"></label>
            <label class="col-md-2 label-height">
                <input type="radio" name="standard_change" value="5" id="standard_change5" class="check" data-radio="iradio_square-green" 
                    {{ $selectedStandard == 5 ? 'checked' : '' }}>
                &nbsp;ย้ายสถานที่ <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="font_size">(Relocation)</span>
            </label>
            <label class="col-md-2 label-height">
                <input type="radio" name="standard_change" value="6" id="standard_change6" class="check" data-radio="iradio_square-green" 
                    {{ $selectedStandard == 6 ? 'checked' : '' }}>
                &nbsp;โอนใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="font_size">(transfer accreditation)</span>
            </label>
        </div>
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
            <div class="form-group">
                <label for="ref_application_no" class="col-md-3 control-label label-height">
                    อ้างอิงเลขที่คำขอ: <br/>
                    <span class="font_size">(Application No.)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="ref_application_no" name="ref_application_no">
                    <p class="help-block" id="error_ref_application_no"></p>
                </div>
            </div>
            {{-- <div class="form-group">
                <label for="certificate_exports_id" class="col-md-3 control-label label-height">
                    ใบรับรองเลขที่: <br/>
                    <span class="font_size">(Certificate No)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="certificate_exports_id" name="certificate_exports_id">
                    <p class="help-block" id="error_certificate_exports_id"></p>
                </div>
            </div> --}}
            <div class="form-group">
                <label for="accereditation_no" class="col-md-3 control-label label-height">
                    <span class="text-danger">*</span> หมายเลขการรับรองที่: <br/>
                    <span class="font_size">(Accreditation No. Calibration)</span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="accereditation_no" name="accereditation_no">
                    <p class="help-block" id="error_accereditation_no"></p>
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
        var certifieds;
        var certi_cb;

        $(document).ready(function () {

            $('#scope-editor').on('click', function(e) {
                e.preventDefault();
                
                // Get the values from the form inputs
                var typeStandard = $('#type_standard').val();
                var petitioner = $('#petitioner').val();
                var trustMark = $('#trust_mark').val();
                var standardChange = $('input[name="standard_change"]:checked').val();
                var nameStandard = $('#name_standard').val();
                var nameEnStandard = $('#name_en_standard').val();
                var address = $('#address').val();
                var allay = $('#allay').val();
                var villageNo = $('#village_no').val();
                var road = $('#road').val();
                var provinceId = $('#province_id').val();
                var provinceText = $('#province_id option:selected').text();
                var amphurId = $('#amphur_id').val();
                var districtId = $('#district_id').val();
                var postcode = $('#postcode').val();
                var cbAddressNoEng = $('#cb_address_no_eng').val();
                var cbMooEng = $('#cb_moo_eng').val();
                var cbSoiEng = $('#cb_soi_eng').val();
                var cbStreetEng = $('#cb_street_eng').val();
                var cbProvinceEng = $('#cb_province_eng').val();
                var cbProvinceEngText = $('#cb_province_eng option:selected').text();
                var cbAmphurEng = $('#cb_amphur_eng').val();
                var cbDistrictEng = $('#cb_district_eng').val();
                var cbPostcodeEng = $('#cb_postcode_eng').val();
                
                // Check if required values are undefined or empty
                if (!typeStandard || !petitioner || !trustMark || !standardChange || !nameStandard || 
                    !nameEnStandard || !address || !provinceId || !amphurId || !districtId || !postcode ||
                    !cbAddressNoEng || !cbProvinceEng || !cbAmphurEng || !cbDistrictEng || !cbPostcodeEng) {
                    alert('กรุณากรอกข้อมูลให้ครบถ้วน: ข้อกำหนดที่ใช้ในการรับรอง, สาขาการรับรอง, มาตรฐานที่ใช้รับรอง, วัตถุประสงค์ในการยื่นคำขอ, หน่วยรับรอง (TH), หน่วยรับรอง (EN), เลขที่ (TH), จังหวัด (TH), เขต/อำเภอ (TH), แขวง/ตำบล (TH), รหัสไปรษณีย์ (TH), เลขที่ (EN), จังหวัด (EN), เขต/อำเภอ (EN), แขวง/ตำบล (EN), และรหัสไปรษณีย์ (EN)');
                    return;
                }
                
                // Build the URL with query parameters
                var url = $(this).attr('href') + '?type_standard=' + encodeURIComponent(typeStandard) +
                        '&petitioner=' + encodeURIComponent(petitioner) +
                        '&trust_mark=' + encodeURIComponent(trustMark) +
                        '&standard_change=' + encodeURIComponent(standardChange) +
                        '&name_standard=' + encodeURIComponent(nameStandard) +
                        '&name_en_standard=' + encodeURIComponent(nameEnStandard) +
                        '&address=' + encodeURIComponent(address) +
                        (allay ? '&allay=' + encodeURIComponent(allay) : '') +
                        (villageNo ? '&village_no=' + encodeURIComponent(villageNo) : '') +
                        (road ? '&road=' + encodeURIComponent(road) : '') +
                        '&province=' + encodeURIComponent(provinceText) +
                        '&amphur_id=' + encodeURIComponent(amphurId) +
                        '&district_id=' + encodeURIComponent(districtId) +
                        '&postcode=' + encodeURIComponent(postcode) +
                        '&cb_address_no_eng=' + encodeURIComponent(cbAddressNoEng) +
                        (cbMooEng ? '&cb_moo_eng=' + encodeURIComponent(cbMooEng) : '') +
                        (cbSoiEng ? '&cb_soi_eng=' + encodeURIComponent(cbSoiEng) : '') +
                        (cbStreetEng ? '&cb_street_eng=' + encodeURIComponent(cbStreetEng) : '') +
                        '&cb_province_eng=' + encodeURIComponent(cbProvinceEngText) +
                        '&cb_amphur_eng=' + encodeURIComponent(cbAmphurEng) +
                        '&cb_district_eng=' + encodeURIComponent(cbDistrictEng) +
                        '&cb_postcode_eng=' + encodeURIComponent(cbPostcodeEng);
                
                // Open the URL in a new tab
                window.open(url, '_blank');
            });

            certifieds = @json($certifieds->mapWithKeys(function($certified) {
                return [$certified->id => $certified->certificate];
            }) ?? []);
            certi_cb = @json($certi_cb ?? []);
            
            console.log(certifieds);

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

                $('#trust_mark').html('<option value="">- เลือกมาตรฐานที่ใช้รับรอง -</option>').select2();
                
                $('#petitioner').html('<option value="">- เลือกสาขาเข้าขอรับการรับรอง  -</option>').select2();
                if($(this).val()!=""){
                    let type = $('#type_standard').find('option[value="'+$(this).val()+'"]').text();
                    // console.log('type',type);
                    // let row = type.replace("มอก.", "");
                    // $('.span_tis').html(row);

                    $.ajax({
                    url: "{!! url('/certify/applicant-cb/formulas2') !!}"  + "/" + $(this).val()
                    }).done(function( object ) {
                        let row = object.data;
                        console.log(row);
                        if(row != '-'){
                            $.each(row,function (index,value) {
                                $('#petitioner').append('<option value='+value.id+' data-model_name='+value.model_name+'  >'+value.title+'</option>');
                            });
                        }
                    });

                }else{
                    $('.span_tis').html('');
                }
            });

            // $('#petitioner').change(function(){
                
            //     $('#petitioner').html('<option value="">- เลือกสาขาเข้าขอรับการรับรอง  -</option>').select2();
            //     if($(this).val()!=""){
            //         let type = $('#petitioner').find('option[value="'+$(this).val()+'"]').text();
            //         console.log('value',$(this).val());
            //         // let row = type.replace("มอก.", "");
            //         // $('.span_tis').html(row);

            //         $.ajax({
            //         url: "{!! url('/applicant-cb/formulas-get-trust-mark') !!}"  + "/" + $(this).val()
            //         }).done(function( object ) {
            //             let data = object.cbTrustMarks;
            //             console.log(data);
            //             if(row != '-'){
            //                 // $.each(row,function (index,value) {
            //                 //     $('#petitioner').append('<option value='+value.id+'  >'+value.titles+'</option>');
            //                 // });
            //             }
            //         });

            //     }else{
            //         $('.span_tis').html('');
            //     }
            // });




            //  $('#type_standard').change();
            $('#petitioner').change(function(){
                if($(this).val()!=""){
                    let row = $('#petitioner').find('option[value="'+$(this).val()+'"]').text();
                    selectedModel = $(this).find(':selected').data('model_name'); // ค้นหา option ที่ถูกเลือก
                    console.log(selectedModel);
                    // $('#selectedModel').val(selectedModel);
                    $('#span_certification').html(row);

                    $.ajax({
                    url: "{!! url('/certify/applicant-cb/formulas-get-trust-mark') !!}"  + "/" + $(this).val()
                    }).done(function( response ) {
                        let data = response.cbTrustMarks; // ตรวจสอบว่าตัวแปรนี้มีค่าถูกต้อง

                        if (Array.isArray(data)) { // ตรวจสอบว่าเป็น Array
                            let select = $('#trust_mark');
                            select.empty(); // ล้าง option เดิม
                            select.append('<option value="">- เลือกมาตรฐานที่ใช้รับรอง -</option>');

                            $.each(data, function(index, item) {
                                select.append(`<option value="${item.id}">${item.tis_no}</option>`);
                            });
                            select.val('').trigger("change");

                        }
                     
                    });
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
            // $("input[name=standard_change]").on("ifChanged",function(){

            //     var isTypeSelected = $("#type_standard").val() !== "";
            //     var isPetitionerSelected = $("#petitioner").val() !== "";
            //     var isTrustMarkSelected = $("#trust_mark").val() !== "";

            //     // ตรวจสอบว่าทั้งสามตัวเลือกมีค่าหรือไม่
              
            //     box_ref_application_no();
            //     get_app_no_and_certificate_exports_no();
            //         // ทำสิ่งที่ต้องการเมื่อเลือกครบทั้งสาม

              
            // });
            // ฟังก์ชันรีเซ็ต UI (ตามที่คุณระบุ)
            // ฟังก์ชันรีเซ็ต UI (ตามที่คุณระบุ)
            function resetUI() {
                $("input[name=standard_change]").iCheck('uncheck');
            }

            // ตรวจสอบเมื่อพยายามคลิก checkbox
            $("input[name=standard_change]").on("ifClicked", function(e) {
                var isTypeSelected = $("#type_standard").val() !== "";
                var isPetitionerSelected = $("#petitioner").val() !== "";
                var isTrustMarkSelected = $("#trust_mark").val() !== "";

                if (isTypeSelected && isPetitionerSelected && isTrustMarkSelected) {
                    console.log("ทั้งสาม select มีค่าเลือกแล้ว");
                    // อนุญาตให้ check และเรียกฟังก์ชัน
                    setTimeout(() => {
                        box_ref_application_no();
                        get_app_no_and_certificate_exports_no();
                    }, 0);
                } else {
                    console.log("ยังเลือกไม่ครบทั้งสาม select");
                    alert("โปรดเลือกรายการให้ครบ");
                    // ป้องกันการ check และ uncheck ทันที
                    e.preventDefault();
                    setTimeout(() => {
                        $(this).iCheck('uncheck');
                    }, 0);
                    // ไม่เรียก resetUI() เพื่อหลีกเลี่ยงการ uncheck ซ้ำ
                }
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
            let typeStandard = $('#type_standard').val();
            let petitioner = $('#petitioner').val();
            let trustMark = $('#trust_mark').val();
            // if(standard_change >= 2){
            if(standard_change >= 2 && standard_change < 6){

                $.get("{{ url('/certify/certi_cb/get-certificate-belong') }}", { 
                    typeStandard: typeStandard,
                    petitioner: petitioner,
                    trustMark: trustMark
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
                // 
                // accereditatio_no
                $('#transfer-wrapper').hide(); 
            }else if(standard_change == 1){
                $('#box_ref_application_no').hide();
                $('#box_ref_application_no').find('input').prop('disabled', true);
                $('#accereditation_no').prop('required', false);
                console.log("ขอครั้งแรก")
                // console.log(standard_change,petitioner,trustMark)
                // resetCertifiedSelect();
                isCbTypeAndStandardBelong();
                $('#transfer-wrapper').hide(); 
            }else if(standard_change == 6){
                $('#box_ref_application_no').hide();
                $('#box_ref_application_no').find('input').prop('disabled', true);
                $('#accereditation_no').prop('required', false);
                // resetCertifiedSelect();
                $('#transfer-wrapper').show(); 
            }else
            {
                $('#transfer-wrapper').hide(); 
            }

        }

        // Function to clear and rebuild select_certified
        function resetCertifiedSelect() {
            $('#select_certified').empty();
            $.each(certifieds, function(id, certificate_no) {
                $('#select_certified').append('<option value="' + id + '">' + certificate_no + '</option>');
            });
            $('#select_certified').trigger('change');
        }


        function isCbTypeAndStandardBelong(){

            let typeStandard = $('#type_standard').val();
            let petitioner = $('#petitioner').val();
            let trustMark = $('#trust_mark').val();

            // console.log(typeStandard,petitioner,trustMark)

            $.get("{{ url('/certify/certi_cb/is-cb-type-and-standard-belong') }}", { 
                typeStandard: typeStandard,
                petitioner: petitioner,
                trustMark: trustMark
                }).done(function( data ) {
                    console.log(data);
                    if (data.certiCbs.length != 0)
                    {
                        alert('ไม่สามารถ "ยื่นขอครั้งแรก" สำหรับเลขมาตรฐาน "'+$('#type_standard option:selected').text().trim()+'" สาขาการรับรอง "'+$('#petitioner option:selected').text().trim()+'" และมาตรฐานที่ใช้รับรอง "'+$('#trust_mark option:selected').text().trim()+'" เนื่องจากมีใบรับรองแล้วในระบบแล้ว');
                        $("input[name=standard_change]").iCheck('uncheck');
                    }
                    
                });
        }

        // เมื่อ radio ของ lab_ability เปลี่ยนค่า
        $("input[name=lab_ability]").on("ifChanged", function(event) {
            // Uncheck radio ทั้งหมดในกลุ่ม purpose
            $("input[name=purpose]").iCheck('uncheck');
        });


        function get_app_no_and_certificate_exports_no(){
            // alert('ok');
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

        $(document).on('change', '#select_certified', function() {
            var certified_id = $(this).val();
            const _token = $('input[name="_token"]').val();
            console.log(certified_id)
            if (certified_id === '' || certified_id === undefined) {
                return;
            }

            $.ajax({
                url: "/certify/certi_cb/api/get_certificated",
                method: "POST",
                data: {
                    certified_id: certified_id,
                    _token: _token
                },
                success: function(result) {
                    attach_path = result.attach_path;

                    certi_cb = result.certiCb
                    
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
                    
                    $('#cb_province_eng').val(pro_id).trigger('change');
                    $('#cb_address_no_eng').val(result.certiCb.address);
                    $('#cb_moo_eng').val(result.certiCb.allay);
                    $('#cb_amphur_eng').val(dis_title_en);
                    $('#cb_district_eng').val(sub_title_en);
                    $('#cb_postcode_eng').val(zip_code);

                    $('#accereditation_no').val(certificateExport.accereditatio_no);
                             
                    $('#name_standard').val(certi_cb.name_standard);
                    $('#name_en_standard').val(certi_cb.name_en_standard);
                    $('#name_short_standard').val(certi_cb.name_short_standard);
                    

                    renderFiles(result.file_sectionn1s, '#repeater_section1_wrapper', '1');
                    $('.attachs_sec1').removeAttr('required');

                    renderFiles(result.file_sectionn2s, '#repeater_section2_wrapper', '2');
                    $('.attachs_sec2').removeAttr('required');

                    renderFiles(result.file_sectionn4s, '#repeater_section4_wrapper', '4');
                    $('.attachs_sec4').removeAttr('required');

                    renderFiles(result.file_sectionn5s, '#repeater_section5_wrapper', '5');
                    $('.attachs_sec5').removeAttr('required');
        
                }
            });
        });

        function renderFiles(files, wrapperSelector, section) {
            var wrapper = $(wrapperSelector);
            wrapper.empty(); // ล้างข้อมูลเก่าออก
            if (files.length > 0) {
                files.forEach(function(file) {
                    const fileName = file.file.split('/').pop();
                    var fileItem = `
                        <div class="form-group">
                            <div class="col-md-4 text-light"></div>
                            <div class="col-md-6">
                                <a href="${baseUrl}certify/check/file_cb_client/${file.file}/${file.file_client_name}" target="_blank" class="view-attach btn btn-info btn-sm">
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
        let typeStandard = $('#type_standard').val();
        let petitioner = $('#petitioner').val();
        let trustMark = $('#trust_mark').val();
        const _token            = $('input[name="_token"]').val();

        let pattern = /^\d{2}-CB\d{4}$/;

        if (!pattern.test(transferee_certificate_number)) {
            alert("รูปแบบใบรับรองไม่ถูกต้อง");
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
                url:"{{route('certi_cb.check_cb_transferee')}}",
                method:"POST",
                data:{
                    transferer_id_number:transferer_id_number,
                    transferee_certificate_number:transferee_certificate_number,
                    typeStandard:typeStandard,
                    petitioner:petitioner,
                    trustMark:trustMark,
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
