
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">

<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
<div class="form-group {{ $errors->has('according_formula') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('according_formula', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-4" >
                {!! Form::select('standard_id',
                App\Models\Bcertify\Formula::where('applicant_type',3)->orWhere('applicant_type',4)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                null,
                ['class' => 'form-control',
                'id'=>'standard_id',
                'required' => true,
                'placeholder' =>'- เลือกตามมาตรฐานเลข -']) !!}
            {!! $errors->first('standard_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@if (!is_null($certificate_exports))
<div class="form-group {{ $errors->has('purpose_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('purpose_type', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label  class="col-md-2 label-height" >
            {!! Form::radio('purpose_type', '1', false, ['class'=>'check ', 'data-radio'=>'iradio_square-green' ,'id'=>'purpose1', 'disabled'=>true ]) !!}
             &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(initial assessment)</span>
         </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose_type', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose2']) !!}
            &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(renewal)</span>
        </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose_type', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose3']) !!}
            &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(extending accreditation)</span>
        </label>
        <label  class="col-md-3 label-height">
            {!! Form::radio('purpose_type', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose4']) !!}
            &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(standard change)</span>
        </label>
        {!! $errors->first('purpose_type', '<p class="help-block">:message</p>') !!}
</div>
@else
<div class="form-group {{ $errors->has('purpose_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label  class="col-md-2 label-height" >
            {!! Form::radio('purpose_type', '1', false, ['class'=>'check ', 'data-radio'=>'iradio_square-green' ,'id'=>'purpose1' ]) !!}
             &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(initial assessment)</span>
         </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose_type', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose2', 'disabled'=>true]) !!}
            &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(renewal)</span>
        </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose_type', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose3', 'disabled'=>true]) !!}
            &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(extending accreditation)</span>
        </label>
        <label  class="col-md-3 label-height">
            {!! Form::radio('purpose_type', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose4', 'disabled'=>true]) !!}
            &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(standard change)</span>
        </label>
        {!! $errors->first('purpose_type', '<p class="help-block">:message</p>') !!}
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

<div class="form-group {{ $errors->has('lab_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_type', 'ความสามารถห้องปฏิบัติการ'.':'.'<br/><span class="  font_size">(Laboratory)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
    <label class="col-md-2  label-height" >
        {!! Form::radio('lab_type', '3', !empty($certi_lab->lab_type=='3') ?true:false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
        &nbsp;ทดสอบ  <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <span class=" font_size">(Testing)</span>
    </label>
    <label class="col-md-2  label-height" >
        {!! Form::radio('lab_type', '4', !empty($certi_lab->lab_type=='4') ?true:false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-red']) !!}
         &nbsp;สอบเทียบ <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <span class=" font_size">(Calibration)</span>
  </label>
   {!! $errors->first('font_size', '<p class="help-block">:message</p>') !!}
</div>

{{-- <div class="form-group {{ $errors->has('lab_name') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'ชื่อห้องปฏิบัติการ'.':'.'<br/><span class=" font_size">(Name laboratory)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
    <div class="col-md-6">
        {!! Form::text('lab_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('lab_name', '<p class="help-block">:message</p>') !!}
    </div>
</div> --}}

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

<div class="form-group {{ $errors->has('lab_name') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'ชื่อห้องปฏิบัติการ'.':'.'<br/><span class=" font_size">(Name laboratory)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
    <div class="col-md-4">
        {!! Form::text('lab_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('lab_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="col-md-12"><br></div>

{{-- <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address_check', 'ที่อยู่: ', ['class' => 'col-md-4 control-label  label-height']) !!}
    <div class="col-md-6 m-t-5">
        <div class="checkbox checkbox-success  label-height">
            <input id="address_same_headquarter" class="address_same_headquarter" type="checkbox" name="address_same_headquarter" {{ ($certi_lab->same_address== 1 ? 'checked' : '')  }}>
            <label for="address_same_headquarter  label-height"> &nbsp;ใช้ที่อยู่ตามที่อยู่จดทะเบียน &nbsp; <br/> &nbsp;  &nbsp; <span class=" font_size">(Use Head offlce address)</span></label>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_no') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_number', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('address_no', null, ['class' => 'form-control', 'required' => 'required','id'=>'address_no']) !!}
                {!! $errors->first('address_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('allay') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('village_no', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('allay', null, ['class' => 'form-control','id'=>'allay']) !!}
                {!! $errors->first('allay', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
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
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('province') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_city', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::select('province',
                  App\Models\Basic\Province::orderbyRaw('CONVERT(PROVINCE_NAME USING tis620)')->pluck('PROVINCE_NAME','PROVINCE_ID'),
                   null,
                 ['class' => 'form-control', 'id'=>'province',
                  'placeholder' =>'- เลือกจังหวัด -']) !!}
               {!! $errors->first('province', '<p class="help-block">:message</p>') !!}
                {{-- {!! Form::text('province', null, ['class' => 'form-control','id'=>'province']) !!}
                {!! $errors->first('province', '<p class="help-block">:message</p>') !!} --}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('amphur') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_district', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {{-- {!! Form::select('amphur',
                 App\Models\Basic\Amphur::orderbyRaw('CONVERT(AMPHUR_NAME USING tis620)')->where('PROVINCE_ID',@$certi_lab->province)->pluck('AMPHUR_NAME','AMPHUR_ID'),
                 null,
                ['class' => 'form-control', 'id'=>'amphur',
                    'placeholder' =>'- เลือกอำเภอ -']) !!}
                {!! $errors->first('amphur', '<p class="help-block">:message</p>') !!} --}}
                {!! Form::text('amphur', null, ['class' => 'form-control','id'=>'amphur']) !!}
                {!! $errors->first('amphur', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('district') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('district', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {{-- {!! Form::select('district',
                App\Models\Basic\District::orderbyRaw('CONVERT(DISTRICT_NAME USING tis620)')->where('AMPHUR_ID',@$certi_lab->amphur)->pluck('DISTRICT_NAME','DISTRICT_ID'),
                null,
               ['class' => 'form-control', 'id'=>'district',
                   'placeholder' =>'-  เลือกแขวง/ตำบล -']) !!}
               {!! $errors->first('district', '<p class="help-block">:message</p>') !!} --}}
                {!! Form::text('district', null, ['class' => 'form-control','id'=>'district']) !!}
                {!! $errors->first('district', '<p class="help-block">:message</p>') !!}
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

    <div class="col-md-12"><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <label for="">ข้อมูลสำหรับการติดต่อ (Contact information)</label> </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contactor_name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact', '<span class="text-danger">*</span> ชื่อบุคคลที่ติดต่อ'.':'.'<br/><span class=" font_size">(Contact Person)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('contactor_name', null, ['class' => 'form-control' ,'id'=>'contactor_name','readonly'=>true]) !!}
                {!! $errors->first('contactor_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('email',null, ['class' => 'form-control','required'=>"required","placeholder"=>"Email@gmail.com",'id'=>"address_email",'readonly'=>true]) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_mobile', '<span class="text-danger">*</span> โทรศัพท์ผู้ติดต่อ'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('contact_tel',null, ['class' => 'form-control' ,'id'=>'contact_tel','readonly'=>true]) !!}
                {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_tel', '<span class="text-danger">*</span> โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('telephone',null, ['class' => 'form-control','required'=>"required",'id'=>"telephone",'readonly'=>true]) !!}
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

        // change   สาขาที่ขอรับการรับรอง
        $("input[name=lab_type]").on("ifChanged",function(){
            status_show_lab_ability();
        });
        status_show_lab_ability();
        function status_show_lab_ability(){
            var select = $("input[name=lab_type]:checked").val();
            const _token = $('input[name="_token"]').val();
            $('#branch_lab_test').html('<option>- สาขาการทดสอบ -</option>').select2();
            $('#branch_lab_calibrate').html('<option>- สาขาสอบเทียบ -</option>').select2();
            if (select === '3') {
                $('#viewForm93').fadeIn();
                $('#viewForm92').hide();
                   // ไฟล์แนบ
                //    $('.attachs_sec71').prop('required', true);
                //    $('.attachs_sec72').prop('required', false);
                $.ajax({
                    url:"{{route('api.test')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                         $('#viewForm90').fadeIn();
                         $('#viewForm91').hide();
                         $('#type_product').val('').change();

                        $.each(result,function (index,value) {
                            $('#branch_lab_test').append('<option value='+value.id+' >'+value.title+'</option>')
                        });

                            //  disabled รายการ
                            $('#labtest_tbody').children('tr').each(function(index, tr) {
                                let row = $(tr).find('.test_scope_branch_id').val();
                                $('#branch_lab_test').find('option[value="'+row+'"]').prop("disabled", true);
                            });
                    }
                });

            }
            else if (select === '4') {
                $('#viewForm92').fadeIn();
                $('#viewForm93').hide();
                // ไฟล์แนบ
                //  $('.attachs_sec71').prop('required', false);
                // $('.attachs_sec72').prop('required', true);
                $.ajax({
                    url:"{{route('api.calibrate')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#viewForm91').fadeIn();
                        $('#viewForm90').hide();
                         $('#type_calibrate').val('').change();
                        $.each(result,function (index,value) {
                            $('#branch_lab_calibrate').append('<option value='+value.id+' >'+value.title+'</option>')
                        })

                          //  disabled รายการ
                          $('#labCalibrate_tbody').children('tr').each(function(index, tr) {
                                let row = $(tr).find('.calibrate_branch_id').val();
                                $('#branch_lab_calibrate').find('option[value="'+row+'"]').prop("disabled", true);
                            });
                    }
                });
            }
          }




        $('#address_same_headquarter').on('change',function () {
            if ($(this).prop('checked')){

                let add_no = $('#head_num').val();
                let soi = $('#head_soi').val();
                let street = $('#head_street').val();
                let moo = $('#head_moo').val();
                let post = $('#head_post').val();
                let tel = $('#head_tel').val();
                let fax = $('#head_fax').val();
                // let address_city = $('#head_province').val();
                let address_district = $('#head_area').val();
                let sub_district = $('#head_tumbon').val();

                let address_city =  '{!! $user_tis->PROVINCE_ID   ?? '' !!}';
                let trader_address_amphur =  '{!! $user_tis->district !!}';
                let trader_address_tumbol =  '{!! $user_tis->subdistrict !!}';

                // let contactor_name =  '{!! $user_tis->agent_name  ?? null !!}';
                //  let contact_tel =  '{!! $user_tis->agent_mobile  ?? null !!}';
                $('#address_no').val(add_no);
                $('#allay').val(moo);
                $('#village_no').val(soi);
                $('#address_street').val(street);
                $('#postcode').val(post);
                $('#tel').val(tel);
                $('#tel_fax').val(fax);

                $('#province').val(address_city).select2();
                $('#province').change();

                $('#amphur').val(trader_address_amphur);
                $('#district').val(trader_address_tumbol);

                // $('#contactor_name').val(contactor_name);
                //  $('#contact_tel').val(contact_tel);
                // $('#address_email').val(agent_email);
                // $('#telephone').val(trader_mobile);
            }else{
                $('#address_no').val('');
                $('#allay').val('');
                $('#village_no').val('');
                $('#address_street').val('');
                $('#postcode').val('');
                $('#tel').val('');
                $('#tel_fax').val('');

                $('#province').val('').select2();
                $('#amphur').val('');
                $('#district').val('');
                // $('#contactor_name').val('');
                //  $('#contact_tel').val('');
                // $('#amphur').empty();
                // $('#amphur').append('<option value="">- เลือกอำเภอ -</option>').select2();
                // $('#district').empty();
                // $('#district').append('<option value="">- เลือกแขวง/ตำบล -</option>').select2();
                // $('#address_email').val('');
                // $('#telephone').val('');
            }      
        });
        $(".branch_type").on("ifChanged",function(){
            branch_type();
        });

    
        function checkNone(value) {
                return value !== '' && value !== null && value !== undefined;
        }

        function branch_type() {
               var row =  $('.branch_type:checked').val();

               let add_no = '{!! $user_tis->address_no  ?? null !!}';
               let soi =  '{!! $user_tis->soi  ?? null !!}';
               let street = '{!! $user_tis->street  ?? null !!}';
               let moo  = '{!! $user_tis->moo  ?? null !!}';
               let post = '{!! $user_tis->zipcode  ?? null !!}';
               let tel =  '{!! $user_tis->tel  ?? null !!}';
               let fax = '{!! $user_tis->fax  ?? null !!}';
               let address_district = '{!! $user_tis->district !!}';
               let sub_district = '{!! $user_tis->subdistrict !!}';
               let address_city =  '{!! $user_tis->PROVINCE_ID   ?? '' !!}';
               let trader_address_amphur =  '{!! $user_tis->district ?? null !!}';
               let trader_address_tumbol =  '{!! $user_tis->subdistrict ?? null !!}';

               let contact_address_no =  '{!! $user_tis->contact_address_no   ?? '' !!}';
               let contact_moo =  '{!! $user_tis->contact_moo  ?? null !!}';
               let contact_street =  '{!! $user_tis->contact_street  ?? null !!}';
               let contact_soi =  '{!! $user_tis->contact_soi   ?? '' !!}';
               let contact_subdistrict =  '{!! $user_tis->contact_subdistrict !!}';
               let contact_district =  '{!! $user_tis->contact_district !!}';
               let contact_province_id =  '{!! $user_tis->contact_province_id !!}';
               let contact_zipcode =  '{!! $user_tis->contact_zipcode !!}';
               let contact_tel =  '{!! $user_tis->contact_tel !!}';
               let contact_fax =  '{!! $user_tis->contact_fax !!}';
               let contact_phone_number =  '{!! $user_tis->contact_phone_number !!}';

               if(row == 2){
                  $('.div_branch_name').show();
                  $('#branch').prop('required', true);

                  $('#address_number').val(contact_address_no);
                  $('#village_no').val(contact_moo);
                  $('#address_soi').val(contact_soi);
                  $('#address_street').val(contact_street);
                  $('#postcode').val(contact_zipcode);
                  $('#address_tel').val(contact_tel);
                  $('#fax').val(contact_fax);

                  $('#address_city').val(contact_province_id).select2();
                  $('#address_city').change();
                  $('#address_district').val(contact_district);
                  $('#sub_district').val(contact_subdistrict);
                 
               }else if(row == 1){
                  $('.div_branch_name').hide();
                  $('#branch').prop('required', false);
                  $('#branch').val('');

                  $('#address_number').val(add_no);
                  $('#village_no').val(moo);
                  $('#address_soi').val(soi);
                  $('#address_street').val(street);
                  $('#postcode').val(post);
                  $('#address_tel').val(tel);
                  $('#fax').val(fax);

                  $('#address_city').val(address_city).select2();
                  $('#address_city').change();
                  $('#address_district').val(trader_address_amphur);
                  $('#sub_district').val(trader_address_tumbol);
               }
        }
 

    </script>
@endpush
