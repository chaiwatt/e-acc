
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">

<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
@if (count($formulas)==1)
<div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('type_standard', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
    <div class="col-md-4" >
        {!! Form::select('type_standard',
        App\Models\Bcertify\Formula::where('applicant_type',2)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
        $formulas[0]->id,
       ['class' => 'form-control',
        'id'=>'type_standard',
        'required' => true,
        'placeholder' =>'- เลือกตามมาตรฐานเลข -']) !!}
       {!! $errors->first('type_standard', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@else
<div class="form-group {{ $errors->has('type_standard') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('type_standard', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
    <div class="col-md-4" >
        {!! Form::select('type_standard',
        App\Models\Bcertify\Formula::where('applicant_type',2)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
        null,
       ['class' => 'form-control',
       'id'=>'type_standard',
        'required' => true,
        'placeholder' =>'- เลือกตามมาตรฐานเลข -']) !!}
       {!! $errors->first('type_standard', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
@if (count($certificate_no) > 0)
<div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label  class="col-md-2 label-height" >
            {!! Form::radio('standard_change', '1', false, ['class'=>'check ', 'data-radio'=>'iradio_square-green' ,'id'=>'purpose1', 'disabled'=>true ]) !!}
             &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(initial assessment)</span>
         </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('standard_change', '2', true, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose2']) !!}
            &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(renewal)</span>
        </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('standard_change', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose3']) !!}
            &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(extending accreditation)</span>
        </label>
        <label  class="col-md-3 label-height">
            {!! Form::radio('standard_change', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose4']) !!}
            &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(standard change)</span>
        </label>
        {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
</div>

@else
<div class="form-group {{ $errors->has('standard_change') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label  class="col-md-2 label-height" >
            {!! Form::radio('standard_change', '1', true, ['class'=>'check ', 'data-radio'=>'iradio_square-green' ,'id'=>'purpose1' ]) !!}
             &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(initial assessment)</span>
         </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('standard_change', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose2', 'disabled'=>true]) !!}
            &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(renewal)</span>
        </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('standard_change', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose3', 'disabled'=>true]) !!}
            &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(extending accreditation)</span>
        </label>
        <label  class="col-md-3 label-height">
            {!! Form::radio('standard_change', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose4', 'disabled'=>true]) !!}
            &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(standard change)</span>
        </label>
        {!! $errors->first('standard_change', '<p class="help-block">:message</p>') !!}
</div>

@endif
@if (!is_null($certificate_exports))

@if (count($certificate_no)==1)
<div class="form-group div_certificate_exports_id{{ $errors->has('certificate_exports_id') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('certificate_exports_id', '<span class="text-danger">*</span> ใบรับรองเลขที่'.':'.'<br/><span class="  font_size">(Certificate No)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-4" >
                {!! Form::select('certificate_exports_id',
                $certificate_exports,
                $certificate_no[0]->id,
                ['class' => 'form-control',
                'id'=>'certificate_exports_id',
                'required' => true,
                'placeholder' =>'- ใบรับรองเลขที่ -']) !!}
            {!! $errors->first('certificate_exports_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@elseif (count($certificate_no) > 1)
<div class="form-group div_certificate_exports_id{{ $errors->has('certificate_exports_id') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('certificate_exports_id', '<span class="text-danger">*</span> ใบรับรองเลขที่'.':'.'<br/><span class="  font_size">(Certificate No)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-4" >
                {!! Form::select('certificate_exports_id',
                $certificate_exports,
                null,
                ['class' => 'form-control',
                'id'=>'certificate_exports_id',
                'required' => true,
                'placeholder' =>'- ใบรับรองเลขที่ -']) !!}
            {!! $errors->first('certificate_exports_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif

@endif

<div class="form-group {{ $errors->has('branch_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('branch_type', '<span class="text-danger">*</span>ประเภทสาขา'.':'.'<br/><span class=" font_size">(Branch Type)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
    <div class="col-md-4" >
        {!! Form::radio('branch_type', '1', false, ['class'=>'check branch_type', 'data-radio'=>'iradio_square-blue','id'=>'branch_type1']) !!}
        <label for="branch_type1">&nbsp;สำนักงานใหญ่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        {!! Form::radio('branch_type', '2', false, ['class'=>'check branch_type', 'data-radio'=>'iradio_square-blue','id'=>'branch_type2']) !!}
        <label for="branch_type2">&nbsp;สาขา</label>
    </div>
   
    <div class="col-md-4 div_branch_name" >
        {!! Form::text('branch', null, ['class' => 'form-control check_format_en','id'=>'branch','placeholder'=>'ระบุสาขา','required'=> false]) !!}
        {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('type_unit') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('type_unit', 'หน่วยตรวจประเภท'.':'.'<br/><span class="  font_size">(Type examination unit)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
    <label class="col-md-1  label-height" >
        {!! Form::radio('type_unit', '1', true, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
        &nbsp;A
    </label>
    <label class="col-md-1  label-height" >
        {!! Form::radio('type_unit', '2',false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
         &nbsp;B
     </label>
     <label class="col-md-1  label-height" >
        {!! Form::radio('type_unit', '3',false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
         &nbsp;C
     </label>
   {!! $errors->first('type_unit', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_unit') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('name_unit', ' หน่วยตรวจสอบ'.':'.'<br/><span class=" font_size">(Examination room name)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
    <div class="col-md-6">
        {!! Form::text('name_unit', null, ['class' => 'form-control', 'required' => false]) !!}
        {!! $errors->first('name_unit', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{-- <div class="form-group {{ $errors->has('checkbox_address') ? 'has-error' : ''}}">
    {!! Form::label('checkbox_address', 'ที่อยู่: ', ['class' => 'col-md-3 control-label  label-height']) !!}
    <div class="col-md-6 m-t-5">
        <div class="checkbox checkbox-success  label-height">
            <input id="checkbox_address" class="checkbox_address" type="checkbox" name="checkbox_address"
                   value="1"  {{ (isset($certi_ib) && $certi_ib->checkbox_address == 1) ? 'checked': '' }}>
            <label for="checkbox_address  label-height"> &nbsp;ใช้ที่อยู่ตามที่อยู่จดทะเบียน &nbsp;
                <br/> &nbsp;  &nbsp; <span class=" font_size">(Use Head offlce address)</span>
           </label>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_number', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('address', null, ['class' => 'form-control', 'required' => 'required','id'=>'address']) !!}
                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('allay') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('allay', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('allay', null, ['class' => 'form-control','id'=>'allay']) !!}
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
                {!! Form::text('village_no', null, ['class' => 'form-control','id'=>'village_no']) !!}
                {!! $errors->first('village_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('road') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_street', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('road', null, ['class' => 'form-control','id'=>'road']) !!}
                {!! $errors->first('road', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('province') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_city', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::select('province_id',
                  App\Models\Basic\Province::orderbyRaw('CONVERT(PROVINCE_NAME USING tis620)')->pluck('PROVINCE_NAME','PROVINCE_ID'),
                   null,
                 ['class' => 'form-control',
                  'id'=>'province',
                  'placeholder' =>'- เลือกจังหวัด -']) !!}
               {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('amphur_id') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('amphur_id', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {{-- {!! Form::select('amphur_id',
                 App\Models\Basic\Amphur::orderbyRaw('CONVERT(AMPHUR_NAME USING tis620)')->where('PROVINCE_ID',@$certi_ib->province_id)->pluck('AMPHUR_NAME','AMPHUR_ID'),
                 null,
                ['class' => 'form-control', 'id'=>'amphur',
                    'placeholder' =>'- เลือกอำเภอ -']) !!}
                {!! $errors->first('amphur_id', '<p class="help-block">:message</p>') !!} --}}
                {!! Form::text('amphur_id', null, ['class' => 'form-control','id'=>'amphur']) !!}
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
                {{-- {!! Form::select('district_id',
                App\Models\Basic\District::orderbyRaw('CONVERT(DISTRICT_NAME USING tis620)')->where('AMPHUR_ID',@$certi_ib->amphur_id)->pluck('DISTRICT_NAME','DISTRICT_ID'),
                null,
               ['class' => 'form-control', 'id'=>'district',
                   'placeholder' =>'-  เลือกแขวง/ตำบล -']) !!}
               {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!} --}}
               {!! Form::text('district_id', null, ['class' => 'form-control','id'=>'district']) !!}
               {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('postcode', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('postcode', null, ['class' => 'form-control', 'required' => 'required','id'=>'postcode']) !!}
                {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> โทรศัพท์'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('tel', null, ['class' => 'form-control', 'required' => 'required','id'=>'tel']) !!}
                {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('tel_fax') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('fax', 'โทรสาร'.':'.'<br/><span class=" font_size">(Fax)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('tel_fax', null, ['class' => 'form-control','id'=>'tel_fax']) !!}
                {!! $errors->first('tel_fax', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
    <div class="col-md-12"><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <label for="">ข้อมูลสำหรับการติดต่อ (Contact information)</label> </div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contactor_name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact', '<span class="text-danger">*</span> ชื่อบุคคลที่ติดต่อ'.':'.'<br/><span class=" font_size">(Contact Person)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('contactor_name',  $tis_data->contact_name  ?? null, ['class' => 'form-control','id'=>'contactor_name','readonly'=>true]) !!}
                {!! $errors->first('contactor_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('email', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('email', $tis_data->email  ?? null, ['class' => 'form-control','required'=>"required","placeholder"=>"Email@gmail.com",'id'=>"address_email",'readonly'=>true]) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_mobile', '<span class="text-danger">*</span> โทรศัพท์ผู้ติดต่อ'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('contact_tel',  $tis_data->contact_tel  ?? null, ['class' => 'form-control','id'=>'contact_tel','readonly'=>true]) !!}
                {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('telephone', 'โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('telephone', $tis_data->contact_phone_number  ?? '-' , ['class' => 'form-control','id'=>"telephone",'readonly'=>true]) !!}
                {{-- <p style="color: red;">กรณีที่ต้องการเปลี่ยน e-mail และ เบอร์โทรศัพท์มือถือ กรุณาติดต่อเจ้าหน้าที่</p> --}}
                {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function () {
        $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
         $('.check-readonly').parent().removeClass('disabled');
         $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});

    });
</script>
    <script>
        $('#checkbox_address').on('change',function () {

            if ($(this).prop('checked')){
                 let add_no =  '{!! $tis_data->address_no  ?? null !!}';
                 let allay =  '{!! $tis_data->moo  ?? null !!}';
                 let village_no =  '{!! $tis_data->soi  ?? null !!}';
                 let road =  '{!! $tis_data->street  ?? null !!}';

                 let province =  '{!! $tis_data->PROVINCE_ID  ?? null !!}';
                 let trader_address_amphur =  '{!! $tis_data->district !!}';
                let trader_address_tumbol =  '{!! $tis_data->subdistrict !!}';

                 let poscode =  '{!! $tis_data->zipcode  ?? null !!}';
                 let phone =  '{!! $tis_data->tel  ?? null !!}';
                 let trader_fax =  '{!! $tis_data->fax  ?? null !!}';

                //  let contactor_name =  '{!! $tis_data->agent_name  ?? null !!}';
                //  let contact_tel =  '{!! $tis_data->agent_mobile  ?? null !!}';
                $('#address').val(add_no);
                $('#allay').val(allay);

                $('#village_no').val(village_no);
                $('#road').val(road);

                $('#province').val(province).select2();
                $('#amphur').val(trader_address_amphur);
                $('#district').val(trader_address_tumbol);
                //  $('#province').change();
                //  $('#amphur').change();

                 $('#postcode').val(poscode);
                  $('#tel').val(phone);
                 $('#tel_fax').val(trader_fax);

                //  $('#contactor_name').val(contactor_name);
                //  $('#contact_tel').val(contact_tel);
            }else{
                $('#address').val('');
                $('#allay').val('');

                $('#village_no').val('');
                $('#road').val('');

                $('#postcode').val('');
                $('#tel').val('');
                $('#tel_fax').val('');

                $('#province').val('').select2();
                $('#amphur').val('');
                $('#district').val('');
                
            }
        });
        $(".branch_type").on("ifChanged",function(){
            branch_type();
        });

        function branch_type() {
               var row =  $('.branch_type:checked').val();
               
               let add_no =  '{!! $tis_data->address_no  ?? null !!}';
               let allay =  '{!! $tis_data->moo  ?? null !!}';
               let village_no =  '{!! $tis_data->soi  ?? null !!}';
               let road =  '{!! $tis_data->street  ?? null !!}';
               let province =  '{!! $tis_data->PROVINCE_ID  ?? null !!}';
               let trader_address_amphur =  '{!! $tis_data->district !!}';
               let trader_address_tumbol =  '{!! $tis_data->subdistrict !!}';
               let poscode =  '{!! $tis_data->zipcode  ?? null !!}';
               let phone =  '{!! $tis_data->tel  ?? null !!}';
               let trader_fax =  '{!! $tis_data->fax  ?? null !!}';

               let contact_add_no =  '{!! $tis_data->contact_address_no  ?? null !!}';
               let contact_allay =  '{!! $tis_data->contact_moo  ?? null !!}';
               let contact_village_no =  '{!! $tis_data->contact_soi  ?? null !!}';
               let contact_road =  '{!! $tis_data->contact_street  ?? null !!}';
               let contact_province =  '{!! $tis_data->contact_province_id  ?? null !!}';
               let contact_trader_address_amphur =  '{!! $tis_data->contact_district ?? null!!}';
               let contact_trader_address_tumbol =  '{!! $tis_data->contact_subdistrict ?? null !!}';
               let contact_poscode =  '{!! $tis_data->contact_zipcode  ?? null !!}';
               let contact_phone =  '{!! $tis_data->contact_tel  ?? null !!}';
               let contact_trader_fax =  '{!! $tis_data->contact_fax  ?? null !!}';

             
               if(row == 2){
                    $('.div_branch_name').show();
                    $('#branch').prop('required', true);  

                    $('#address').val(contact_add_no);
                    $('#allay').val(contact_allay);
                    $('#village_no').val(contact_village_no);
                    $('#road').val(contact_road);
                    $('#province').val(contact_province).select2();
                    $('#amphur').val(contact_trader_address_amphur);
                    $('#district').val(contact_trader_address_tumbol);
                    $('#postcode').val(contact_poscode);
                    $('#tel').val(contact_phone);
                    $('#tel_fax').val(contact_trader_fax);

               }else if(row == 1){
                    $('.div_branch_name').hide();
                    $('#branch').prop('required', false);
                    $('#branch').val('');

                    $('#address').val(add_no);
                    $('#allay').val(allay);
                    $('#village_no').val(village_no);
                    $('#road').val(road);
                    $('#province').val(province).select2();
                    $('#amphur').val(trader_address_amphur);
                    $('#district').val(trader_address_tumbol);
                    $('#postcode').val(poscode);
                    $('#tel').val(phone);
                    $('#tel_fax').val(trader_fax);
               }
        }

    </script>
@endpush
