
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">

<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
<div class="form-group {{ $errors->has('purpose_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-4 control-label label-height'])) !!}
    <label  class="col-md-2 label-height" >
        {!! Form::radio('purpose_type', '1', true, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green']) !!}
         &nbsp;ยื่นขอครั้งแรก  <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class=" font_size" >(initial assessment)</span>
     </label>
    <label  class="col-md-3 label-height">
        {!! Form::radio('purpose_type', '2', false, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green']) !!}
        &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class=" font_size">(renewal)</span>
    </label>
    <label  class="col-md-2 label-height">
        {!! Form::radio('purpose_type', '3', false, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green']) !!}
        &nbsp;ขยายขอบข่าย  <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class=" font_size">(extending accreditation)</span>
    </label>
</div>

<div class="form-group {{ $errors->has('lab_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_type', 'ความสามารถห้องปฏิบัติการ'.':'.'<br/><span class="  font_size">(Laboratory)</span>', ['class' => 'col-md-4 control-label label-height'])) !!}
    <label class="col-md-2  label-height" >
        {!! Form::radio('lab_type', '3', !empty($certi_lab->lab_type=='3') ?true:false, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green']) !!}
        &nbsp;ทดสอบ  <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <span class=" font_size">(Testing)</span>
    </label>
    <label class="col-md-2  label-height" >
        {!! Form::radio('lab_type', '4', !empty($certi_lab->lab_type=='4') ?true:false, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-red']) !!}
         &nbsp;สอบเทียบ <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <span class=" font_size">(Calibration)</span>
  </label>
   {!! $errors->first('font_size', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('lab_name') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'ชื่อห้องปฏิบัติการ'.':'.'<br/><span class=" font_size">(Name laboratory)</span>', ['class' => 'col-md-4 control-label  label-height'])) !!}
    <div class="col-md-6">
        {!! Form::text('lab_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('lab_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address_check', 'ที่อยู่: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 m-t-5">
        <div class="checkbox checkbox-success">
            <input id="address_same_headquarter" class="address_same_headquarter" type="checkbox" name="address_same_headquarter" disabled  {{ ($certi_lab->same_address== 1 ? 'checked' : '')  }}>
            <label for="address_same_headquarter  label-height"> &nbsp;ใช้ที่อยู่ตามที่อยู่จดทะเบียน &nbsp; <br/> &nbsp;  &nbsp; <span class=" font_size">(Use Head offlce address)</span></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_no') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_number', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('address_no', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('address_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('allay') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('village_no', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('allay', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('allay', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('village_no') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_soi', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('village_no', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('village_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('road') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_street', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('road', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
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
                'placeholder' =>'- เลือกจังหวัด -','disabled'=>true]) !!}
             {!! $errors->first('province', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('amphur') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_district', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('amphur', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('amphur', '<p class="help-block">:message</p>') !!}
                {{-- {!! Form::select('amphur',
                App\Models\Basic\Amphur::orderbyRaw('CONVERT(AMPHUR_NAME USING tis620)')->where('PROVINCE_ID',@$certi_lab->province)->pluck('AMPHUR_NAME','AMPHUR_ID'),
                null,
               ['class' => 'form-control', 'id'=>'amphur',
                   'placeholder' =>'- เลือกอำเภอ -','disabled'=>true]) !!}
               {!! $errors->first('amphur', '<p class="help-block">:message</p>') !!} --}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('district') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('district', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('district', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('district', '<p class="help-block">:message</p>') !!}
                {{-- {!! Form::select('district',
                App\Models\Basic\District::orderbyRaw('CONVERT(DISTRICT_NAME USING tis620)')->where('AMPHUR_ID',@$certi_lab->amphur)->pluck('DISTRICT_NAME','DISTRICT_ID'),
                null,
               ['class' => 'form-control', 'id'=>'district',
                   'placeholder' =>'-  เลือกแขวง/ตำบล -','disabled'=>true]) !!}
               {!! $errors->first('district', '<p class="help-block">:message</p>') !!} --}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('postcode', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('postcode', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
                 {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> โทรศัพท์'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('tel', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('tel_fax') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('fax', ' โทรสาร'.':'.'<br/><span class=" font_size">(Fax)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('tel_fax', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('tel_fax', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-12"><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <label for="">ข้อมูลสำหรับการติดต่อ (Contact information)</label> </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contactor_name') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact', '<span class="text-danger">*</span> ชื่อบุคคลที่ติดต่อ'.':'.'<br/><span class=" font_size">(Contact Person)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('contactor_name', null, ['class' => 'form-control', 'required' => 'required','disabled'=>true]) !!}
                {!! $errors->first('contactor_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('email',null, ['class' => 'form-control','required'=>"required","placeholder"=>"Email@gmail.com",'disabled'=>true]) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_mobile', '<span class="text-danger">*</span> โทรศัพท์ผู้ติดต่อ'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('contact_tel',null, ['class' => 'form-control','required'=>"required",'disabled'=>true]) !!}
                {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_tel', '<span class="text-danger">*</span> โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('telephone', null, ['class' => 'form-control','required'=>"required",'disabled'=>true]) !!}
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

      var lab_type = '{{   !empty($certi_lab->lab_type) ? $certi_lab->lab_type :null  }}';
            if(lab_type == '3'){
                $('#viewForm93').fadeIn();
                $('#viewForm92').hide();

                $('#viewForm90').fadeIn();
                $('#viewForm91').hide();

            }else if(lab_type == '4'){
                $('#viewForm92').fadeIn();
                $('#viewForm93').hide();

                $('#viewForm91').fadeIn();
                $('#viewForm90').hide();
            }
        // change   สาขาที่ขอรับการรับรอง
        $('.checkLab').on('change',function () {

            const select = $(this).val();
            const _token = $('input[name="_token"]').val();
            $('#branch_lab_test').empty();
            $('#branch_lab_calibrate').empty();
            if ($(this).val() === '3') {
                $('#viewForm93').fadeIn();
                $('#viewForm92').hide();
                $.ajax({
                    url:"{{route('api.test')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#viewForm90').fadeIn();
                         $('#viewForm91').hide();
                         $('#type_product').val('').change();
                         $('#branch_lab_test').val('').change();
                        $.each(result,function (index,value) {
                            $('#branch_lab_test').append('<option value='+value.id+' >'+value.title+'</option>')
                        });
                    }
                });
            }
            else if ($(this).val() === '4') {
                $('#viewForm92').fadeIn();
                $('#viewForm93').hide();
                $.ajax({
                    url:"{{route('api.calibrate')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#viewForm91').fadeIn();
                        $('#viewForm90').hide();
                         $('#type_calibrate').val('').change();
                          $('#branch_lab_calibrate').val('').change();
                        $.each(result,function (index,value) {
                            $('#branch_lab_calibrate').append('<option value='+value.id+' >'+value.title+'</option>')
                        })
                    }
                });
            }
        });

        $('#address_same_headquarter').on('change',function () {
            if ($(this).prop('checked')){

                let add_no = $('#home_num').val();
                let soi = $('#home_soi').val();
                let street = $('#home_street').val();
                let moo = $('#home_moo').val();
                let post = $('#home_post').val();
                let tel = $('#home_phone').val();
                let fax = $('#head_fax').val();
                let address_city = $('#home_province').val();
                let address_district = $('#home_area').val();
                let sub_district = $('#home_tumbon').val();
                $('#address_number').val(add_no);
                $('#village_no').val(moo);
                $('#address_soi').val(soi);
                $('#address_street').val(street);
                $('#postcode').val(post);
                $('#address_tel').val(tel);
                $('#fax').val(fax);
                $('#address_city').val(address_city);
                $('#address_district').val(address_district);
                $('#sub_district').val(sub_district);
            }else{
                $('#address_number').val('');
                $('#village_no').val('');
                $('#address_soi').val('');
                $('#address_street').val('');
                $('#postcode').val('');
                $('#address_tel').val('');
                $('#fax').val('');
                $('#address_city').val('');
                $('#address_district').val('');
                $('#sub_district').val('');
            }
        });

    </script>
@endpush
