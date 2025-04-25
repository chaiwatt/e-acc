
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            {{-- <legend><h4></h4></legend> --}}

<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
@if (count($formulas)==1)
<div class="form-group {{ $errors->has('according_formula') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('according_formula', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-4" >
                {!! Form::select('according_formula',
                App\Models\Bcertify\Formula::where('applicant_type',3)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                $formulas[0]->id,
                ['class' => 'form-control',
                'id'=>'according_formula',
                'readonly' => 'readonly',
                'required' => true,
                'placeholder' =>'- เลือกตามมาตรฐานเลข -']) !!}
            {!! $errors->first('according_formula', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@else
<div class="form-group {{ $errors->has('according_formula') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('according_formula', '<span class="text-danger">*</span> ตามมาตรฐานเลข'.':'.'<br/><span class="  font_size">(According to TIS)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
            <div class="col-md-4" >
                {!! Form::select('according_formula',
                App\Models\Bcertify\Formula::where('applicant_type',3)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                null,
                ['class' => 'form-control',
                'id'=>'according_formula',
                'required' => true,
                'placeholder' =>'- เลือกตามมาตรฐานเลข -']) !!}
            {!! $errors->first('according_formula', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif

@if (count($certificate_no) > 0)
<div class="form-group {{ $errors->has('purpose') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label  class="col-md-2 label-height" >
            {!! Form::radio('purpose', '1', false, ['class'=>'check ', 'data-radio'=>'iradio_square-green' ,'id'=>'purpose1', 'disabled'=>true ]) !!}
             &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(initial assessment)</span>
         </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose', '2', true, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose2']) !!}
            &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(renewal)</span>
        </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose3']) !!}
            &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(extending accreditation)</span>
        </label>
        <label  class="col-md-3 label-height">
            {!! Form::radio('purpose', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose4']) !!}
            &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(standard change)</span>
        </label>
        {!! $errors->first('purpose', '<p class="help-block">:message</p>') !!}
</div>
@else
<div class="form-group {{ $errors->has('purpose') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_name', 'วัตถุประสงค์ในการยื่นคำขอ'.':'.'<br/><span class=" font_size">(Apply to NSC for)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label  class="col-md-2 label-height" >
            {!! Form::radio('purpose', '1', true, ['class'=>'check ', 'data-radio'=>'iradio_square-green' ,'id'=>'purpose1' ]) !!}
             &nbsp;ยื่นขอครั้งแรก <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(initial assessment)</span>
         </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose2', 'disabled'=>true]) !!}
            &nbsp;ต่ออายุใบรับรอง <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(renewal)</span>
        </label>
        <label  class="col-md-2 label-height">
            {!! Form::radio('purpose', '3', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose3', 'disabled'=>true]) !!}
            &nbsp;ขยายขอบข่าย <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(extending accreditation)</span>
        </label>
        <label  class="col-md-3 label-height">
            {!! Form::radio('purpose', '4', false, ['class'=>'check', 'data-radio'=>'iradio_square-green','id'=>'purpose4', 'disabled'=>true]) !!}
            &nbsp;การเปลี่ยนแปลงมาตรฐาน <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font_size">(standard change)</span>
        </label>
        {!! $errors->first('purpose', '<p class="help-block">:message</p>') !!}
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
@elseif (count($certificate_no) > 0)
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

<div class="form-group {{ $errors->has('lab_ability') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('lab_ability', 'ความสามารถห้องปฏิบัติการ'.':'.'<br/><span class="  font_size">(Laboratory)</span>', ['class' => 'col-md-3 control-label label-height'])) !!}
        <label class="col-md-2  label-height" >
            {!! Form::radio('lab_ability', 'test', true, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!}
            &nbsp;ทดสอบ  <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <span class=" font_size">(Testing)</span>
        </label>
        <label class="col-md-2  label-height" >
            {!! Form::radio('lab_ability', 'calibrate', false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-red']) !!}
             &nbsp;สอบเทียบ <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <span class=" font_size">(Calibration)</span>
      </label>
    {!! $errors->first('lab_ability', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('branch_type') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('branch_type', '<span class="text-danger">*</span> ประเภทสาขา'.':'.'<br/><span class=" font_size">(Branch Type)</span>', ['class' => 'col-md-3 control-label  label-height'])) !!}
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
    <div class="col-md-6">
        <div class="checkbox checkbox-success  label-height">
            <input id="address_same_headquarter" class="address_same_headquarter" type="checkbox" name="address_same_headquarter">
            <label for="address_same_headquarter  label-height"> &nbsp;ใช้ที่อยู่ตามที่อยู่จดทะเบียน &nbsp; <br/> &nbsp;  &nbsp; <span class=" font_size">(Use Head offlce address)</span></label>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_number') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_number', '<span class="text-danger">*</span> เลขที่'.':'.'<br/><span class=" font_size">(Address)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('address_number', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('address_number', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('village_no') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('village_no', 'หมู่ที่'.':'.'<br/><span class=" font_size">(Mool)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('village_no', null, ['class' => 'form-control']) !!}
                {!! $errors->first('village_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_soi') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_soi', 'ตรอก/ซอย'.':'.'<br/><span class=" font_size">(Trok/Sol)</span>', ['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('address_soi', null, ['class' => 'form-control']) !!}
                {!! $errors->first('address_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_street') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_street', 'ถนน'.':'.'<br/><span class=" font_size">(Street/Road)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                {!! Form::text('address_street', null, ['class' => 'form-control']) !!}
                {!! $errors->first('address_street', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_city') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_city', 'จังหวัด'.':'.'<br/><span class=" font_size">(Province)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
              <select name="address_city" id="address_city" class="form-control" required>
                 <option value="" selected>- เลือกจังหวัด -</option>
                    @foreach($province as $data)
                     <option value="{{$data->PROVINCE_ID}}">{{$data->PROVINCE_NAME}}</option>
                   @endforeach
             </select>
             {{-- <input type="text" name="address_city" id="address_city" class="form-control"> --}}
                {!! $errors->first('address_city', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_district') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_district', 'เขต/อำเภอ'.':'.'<br/><span class=" font_size">(Arnphoe/Khet)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
               {{-- <select name="address_district" id="address_district" class="form-control" required>
                   <option value="" selected>- เลือกอำเภอ -</option>
              </select> --}}
                <input type="text" name="address_district" id="address_district" class="form-control">
                {!! $errors->first('according_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('sub_district') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('sub_district', 'แขวง/ตำบล'.':'.'<br/><span class=" font_size">(Zip code)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                 {{-- <select name="sub_district" id="sub_district" class="form-control" required>
                    <option value="" selected>- เลือกแขวง/ตำบล -</option>
                  </select> --}}
                <input type="text" name="sub_district" id="sub_district" class="form-control">
                {!! $errors->first('sub_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('postcode', '<span class="text-danger">*</span> รหัสไปรษณีย์'.':'.'<br/><span class=" font_size">(Tambon/Khwaeng)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="text" name="postcode" id="postcode" class="form-control" required>
                {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> โทรศัพท์'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="text" name="address_tel" id="address_tel" class="form-control" required>
                {!! $errors->first('address_tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('fax') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('fax', 'โทรสาร'.':'.'<br/><span class=" font_size">(Fax)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="text" name="fax" id="fax" class="form-control">
                {!! $errors->first('fax', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>


    <div class="col-md-12"><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <label for="">ข้อมูลสำหรับการติดต่อ (Contact information)</label> </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact', '<span class="text-danger">*</span> ชื่อบุคคลที่ติดต่อ'.':'.'<br/><span class=" font_size">(Contact Person)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="text" name="contact"   value="{{  $tis_data->contact_name  ?? null }}"  id="contactor_name" class="form-control" readonly >
                {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('address_tel', '<span class="text-danger">*</span> Email'.':'.'<br/><span class=" font_size text-danger">*หากต้องการเปลี่ยน e-mail กรุณาติดต่อเจ้าหน้าที่</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="email"  value="{{   $tis_data->email  ?? null  ?? null }}"  name="address_email" id="address_email" class="form-control" required placeholder="Email@gmail.com" readonly>
                {!! $errors->first('address_email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_mobile') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_mobile', '<span class="text-danger">*</span> โทรศัพท์ผู้ติดต่อ'.':'.'<br/><span class=" font_size">(Telephone)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="text" name="contact_mobile"  value="{{ $tis_data->contact_tel  ?? null   }}"   id="contact_mobile" class="form-control"   readonly>
                {!! $errors->first('contact_mobile', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_tel') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('contact_tel', '<span class="text-danger">*</span> โทรศัพท์มือถือ'.':'.'<br/><span class=" font_size">(Mobile)</span>',['class' => 'col-md-5 control-label label-height'])) !!}
            <div class="col-md-7">
                <input type="text" name="contact_tel" id="contact_tel" class="form-control"  readonly   value="{{  $tis_data->contact_phone_number  ?? '-'  }}" >
                {{-- <p style="color: red;">กรณีที่ต้องการเปลี่ยน e-mail และ เบอร์โทรศัพท์มือถือ กรุณาติดต่อเจ้าหน้าที่</p> --}}
                {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
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
        $("input[name=lab_ability]").on("ifChanged",function(){
            status_show_lab_ability();
        });
        status_show_lab_ability();
        function status_show_lab_ability(){
            var select = $("input[name=lab_ability]:checked").val();
            const _token = $('input[name="_token"]').val();
            $('#branch_lab_test').html('<option>- สาขาการทดสอบ -</option>').select2();
            $('#branch_lab_calibrate').html('<option>- สาขาสอบเทียบ -</option>').select2();
            if (select === 'test') {
                // ไฟล์แนบ
                $('.attachs_sec61').prop('required', true);
                $('.attachs_sec62').prop('required', false);

                $('.attachs_sec71').prop('required', true);
                $('.attachs_sec72').prop('required', false);



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

                        $.each(result,function (index,value) {
                            $('#branch_lab_test').append('<option value='+value.id+' >'+value.title+'</option>')
                        });
                    }
                });
            }
            else if (select === 'calibrate') {
                // ไฟล์แนบ
                $('.attachs_sec61').prop('required', false);
                $('.attachs_sec62').prop('required', true);

                $('.attachs_sec71').prop('required', false);
                $('.attachs_sec72').prop('required', true);

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
                        $.each(result,function (index,value) {
                            $('#branch_lab_calibrate').append('<option value='+value.id+' >'+value.title+'</option>')
                        })
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


          
                let address_city =  '{!! $tis_data->PROVINCE_ID   ?? '' !!}';
                let trader_address_amphur =  '{!! $tis_data->district !!}';
                let trader_address_tumbol =  '{!! $tis_data->subdistrict !!}';

                // let contactor_name =  '{!! $tis_data->agent_name  ?? null !!}';
                //  let contact_tel =  '{!! $tis_data->agent_mobile  ?? null !!}';
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

                // $('#contactor_name').val(contactor_name);
                //  $('#contact_mobile').val(contact_tel);
                    // $.ajax({
                    //     url:"{{route('api.district')}}",
                    //     method:"POST",
                    //     data:{select:address_district,_token:_token},
                    //     success:function (result){
                    //         $.each(result,function (index,value) {
                    //             let selected = (value.DISTRICT_ID == sub_district)?'selected="selected"':'';
                    //             $('#sub_district').append('<option value='+value.DISTRICT_ID+' '+selected+' >'+value.DISTRICT_NAME+'</option>');
                    //         });
                    //         $('#sub_district').select2();

                    //     }
                    // });

                // $('#address_email').val(agent_email);
                // $('#contact_tel').val(trader_mobile);
            }else{
                $('#address_number').val('');
                $('#village_no').val('');
                $('#address_soi').val('');
                $('#address_street').val('');
                $('#postcode').val('');
                $('#address_tel').val('');
                $('#fax').val('');
                $('#address_city').val('').select2();
                $('#address_district').val('');
                $('#sub_district').val('');
                // $('#contactor_name').val('');
                //  $('#contact_mobile').val('');
                // $('#address_district').empty();
                // $('#address_district').append('<option value="">- เลือกอำเภอ -</option>').select2();
                // $('#sub_district').empty();
                // $('#sub_district').append('<option value="">- เลือกแขวง/ตำบล -</option>').select2();
                // $('#address_email').val('');
                // $('#contact_tel').val('');
            }
        });

        $(".branch_type").on("ifChanged",function(){
            branch_type();
        });
        
    

        //      // รหัสสาขา
        function branch_type() {
               var row =  $('.branch_type:checked').val();

               let add_no = $('#head_num').val();
               let soi = $('#head_soi').val();
               let street = $('#head_street').val();
               let moo = $('#head_moo').val();
               let post = $('#head_post').val();
               let tel = $('#head_tel').val();
               let fax = $('#head_fax').val();
               let address_district = $('#head_area').val();
               let sub_district = $('#head_tumbon').val();
               let address_city =  '{!! $tis_data->PROVINCE_ID   ?? '' !!}';
               let trader_address_amphur =  '{!! $tis_data->district ?? null !!}';
               let trader_address_tumbol =  '{!! $tis_data->subdistrict ?? null !!}';

               let contact_address_no =  '{!! $tis_data->contact_address_no   ?? '' !!}';
               let contact_moo =  '{!! $tis_data->contact_moo ?? null !!}';
               let contact_street =  '{!! $tis_data->contact_street ?? null !!}';
               let contact_soi =  '{!! $tis_data->contact_soi   ?? null !!}';
               let contact_subdistrict =  '{!! $tis_data->contact_subdistrict ?? null !!}';
               let contact_district =  '{!! $tis_data->contact_district ?? null !!}';
               let contact_province_id =  '{!! $tis_data->contact_province_id ?? null !!}';
               let contact_zipcode =  '{!! $tis_data->contact_zipcode ?? null !!}';
               let contact_tel =  '{!! $tis_data->contact_tel ?? null !!}';
               let contact_fax =  '{!! $tis_data->contact_fax ?? null !!}';
               let contact_phone_number =  '{!! $tis_data->contact_phone_number ?? null !!}';

               if(row == 2){
                  $('.div_branch_name').show();
                  $('#branch_code').prop('required', true);

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
                  $('#branch_code').prop('required', false);
                  $('#branch_code').val('');

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
        $('.div_branch_name').hide();

     
            
           
            function checkNone(value) {
                return value !== '' && value !== null && value !== undefined;
            }
        // $('#address_city').on('change', function () {
        //     const select = $(this).val();
        //     let AMPHUR_ID =  '{!! $tis_data->AMPHUR_ID  ?? null !!}';

        //     const _token = $('input[name="_token"]').val();
        //     if(select != ''){
        //         $.ajax({
        //             url:"{{route('api.amphur')}}",
        //             method:"POST",
        //             data:{select:select,_token:_token},
        //             success:function (result){
        //                 $('#address_district').empty();
        //                 $('#address_district').append('<option value="">- เลือกอำเภอ -</option>').select2();
        //                 $('#sub_district').empty();
        //                 $('#sub_district').append('<option value="">- เลือกแขวง/ตำบล -</option>').select2();
        //                 $.each(result,function (index,value) {
        //                     let selected_district = (value.AMPHUR_ID == AMPHUR_ID)?'selected="selected"':'';
        //                     $('#address_district').append('<option value='+value.AMPHUR_ID+' '+selected_district+' >'+value.AMPHUR_NAME+'</option>');
        //                 });
        //                 $('#address_district').select2();
        //                 $('#address_district').change();
        //             }
        //         });
        //     }else{
        //         $('#address_district').empty();
        //         $('#address_district').append('<option value="">- เลือกอำเภอ -</option>').select2();
        //         $('#sub_district').empty();
        //         $('#sub_district').append('<option value="">- เลือกแขวง/ตำบล -</option>').select2();
        //     }


        // });

        // $('#address_district').on('change',function () {
        //         const select = $(this).val();
        //         let DISTRICT_ID =  '{!! $tis_data->DISTRICT_ID  ?? null !!}';
        //         const _token = $('input[name="_token"]').val();
        //      if (select != ""){
        //         $.ajax({
        //             url:"{{route('api.district')}}",
        //             method:"POST",
        //             data:{select:select,_token:_token},
        //             success:function (result){
        //                 $('#sub_district').empty();
        //                 $('#sub_district').append('<option value="">- เลือกแขวง/ตำบล -</option>').select2();
        //                 $.each(result,function (index,value) {
        //                     let selected = (value.DISTRICT_ID == DISTRICT_ID)?'selected="selected"':'';
        //                     $('#sub_district').append('<option value='+value.DISTRICT_ID+' '+selected+' >'+value.DISTRICT_NAME+'</option>');
        //                 });
        //                 $('#sub_district').select2();
        //             }
        //         });
        //     }else{
        //         $('#sub_district').empty();
        //         $('#sub_district').append('<option value="">- เลือกแขวง/ตำบล -</option>').select2();
        //     }
        // })

    </script>
@endpush
