
<div class="row ">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend class="label-height">ข้อมูลส่วนตัว</legend>
            <hr>
 
<div class="row">
    <div class="col-md-6">
        <div class="form-group  {{ $errors->has('view_head_name') ? 'has-error' : ''}}">
            {!! Form::label('view_head_name', 'ชื่อ - นามสกุล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                 {!! Form::text('view_head_name', null ,  ['class' => 'form-control autofill','id'=>"view_head_name", 'placeholder' => 'ชื่อ-สกุล', 'readonly' => true]) !!}
                {!! $errors->first('view_head_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_taxid') ? 'has-error' : ''}}">
            {!! Form::label('view_taxid', 'เลขประจำตัวประชาชน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_taxid', null, ['class' => 'form-control autofill','id'=>"view_taxid", 'placeholder' => 'เลขประจำตัวผู้เสียภาษี', 'readonly' => true]) !!}
                {!! $errors->first('view_taxid', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_mobile_phone') ? 'has-error' : ''}}">
            {!! Form::label('view_mobile_phone', 'เบอร์โทรศัพท์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_mobile_phone', null,  ['class' => 'form-control autofill','id'=>"view_mobile_phone", 'maxlength' => 25, 'disabled' => true ]) !!}
                {!! $errors->first('view_mobile_phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_email') ? 'has-error' : ''}}">
            {!! Form::label('view_email', 'E-Mail:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_email', null,  ['class' => 'form-control autofill','id'=>"view_email", 'maxlength' => 255, 'disabled' => true ]) !!}
                {!! $errors->first('view_email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_department') ? 'has-error' : ''}}">
            {!! Form::label('view_department', 'หน่วยงาน/สังกัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_department', null,  ['class' => 'form-control autofill','id'=>"view_department", 'maxlength' => 255, 'disabled' => true]) !!}
                {!! $errors->first('view_department', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_position') ? 'has-error' : ''}}">
            {!! Form::label('view_position', 'ตำแหน่ง:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_position', null,  ['class' => 'form-control autofill','id'=>"view_position", 'maxlength' => 255, 'disabled' => true]) !!}
                {!! $errors->first('view_position', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->first('image', 'has-error') }}">
           {!! Form::label('', ''.'', ['class' => 'col-md-3 control-label']) !!}
           <div class="col-sm-8 text-center">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                 <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                 
                        <img src=""  alt="profile pic" id="view_pic_profile">       
                    
                 </div>
             </div>
           </div>
         </div>
  </div>
</div>
 


<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address_show', 'ที่อยู่ตามทะเบียนบ้าน', ['class' => 'col-md-2  control-label label_height']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group  {{ $errors->has('view_head_address_no') ? 'has-error' : ''}}">
            {!! Form::label('view_head_address_no', 'เลขที่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_address_no', null,  ['class' => 'form-control autofill','id'=>"view_head_address_no", 'disabled' => true]) !!}
                {!! $errors->first('view_head_address_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('view_head_soi') ? 'has-error' : ''}}">
            {!! Form::label('view_head_soi', 'ตรอก/ซอย:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_soi', null , ['class' => 'form-control autofill','id'=>"view_head_soi", 'disabled' => true]) !!}
                {!! $errors->first('view_head_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_head_subdistrict') ? 'has-error' : ''}}">
            {!! Form::label('view_head_subdistrict', 'แขวง/ตำบล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_subdistrict',null,  ['class' => 'form-control autofill','id'=>"view_head_subdistrict", 'disabled' => true ]) !!}
                {!! $errors->first('view_head_subdistrict', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_head_province') ? 'has-error' : ''}}">
            {!! Form::label('view_head_province', 'จังหวัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_province', null,  ['class' => 'form-control autofill','id'=>"view_head_province", 'disabled' => true]) !!}
                {!! $errors->first('view_head_province', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('view_head_village') ? 'has-error' : ''}}">
            {!! Form::label('view_head_village', 'อาคาร/หมู่บ้าน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_village', null,  ['class' => 'form-control autofill','id'=>"view_head_village", 'disabled' => true]) !!}
                {!! $errors->first('view_head_village', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('view_head_moo') ? 'has-error' : ''}}">
            {!! Form::label('view_head_moo', 'หมู่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_moo',null,  ['class' => 'form-control autofill','id'=>"view_head_moo", 'disabled' => true]) !!}
                {!! $errors->first('view_head_moo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_head_district') ? 'has-error' : ''}}">
            {!! Form::label('view_head_district', 'เขต/อำเภอ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_district', null,  ['class' => 'form-control autofill','id'=>"view_head_district", 'disabled' => true]) !!}
                {!! $errors->first('view_head_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('view_head_zipcode') ? 'has-error' : ''}}">
            {!! Form::label('view_head_zipcode', 'รหัสไปรษณีย์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('view_head_zipcode',null,  ['class' => 'form-control autofill','id'=>"view_head_zipcode", 'disabled' => true ]) !!}
                {!! $errors->first('view_head_zipcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
     {!! Form::label('address_show', 'ที่อยู่ที่สามารถติดต่อได้', ['class' => 'col-md-2  control-label label_height']) !!}
</div>

<div class="row">
<div class="col-md-6">
            <div class="form-group  {{ $errors->has('view_contact_address_no') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_address_no', 'เลขที่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_address_no', null,  ['class' => 'form-control autofill','id'=>"view_contact_address_no" , 'maxlength' => 255 , 'disabled' => true]) !!}
            {!! $errors->first('view_contact_address_no', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
            <div class="form-group {{ $errors->has('view_contact_soi') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_soi', 'ตรอก/ซอย:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_soi', null,  ['class' => 'form-control autofill','id'=>"view_contact_soi", 'maxlength' => 255, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_soi', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
            <div class="form-group  {{ $errors->has('view_contact_subdistrict') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_subdistrict', 'แขวง/ตำบล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_subdistrict', null,  ['class' => 'form-control autofill','id'=>"view_contact_subdistrict", 'maxlength' => 255, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_subdistrict', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
            <div class="form-group  {{ $errors->has('view_contact_province') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_province', 'จังหวัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_province', null,  ['class' => 'form-control autofill','id'=>"view_contact_province", 'maxlength' => 255, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_province', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
</div>
<div class="col-md-6">
            <div class="form-group {{ $errors->has('view_contact_village') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_village', 'อาคาร/หมู่บ้าน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_village', null,  ['class' => 'form-control autofill','id'=>"view_contact_village", 'maxlength' => 255, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_village', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
            <div class="form-group {{ $errors->has('view_contact_moo') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_moo', 'หมู่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_moo', null,  ['class' => 'form-control autofill','id'=>"view_contact_moo", 'maxlength' => 255, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_moo', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
            <div class="form-group  {{ $errors->has('view_contact_district') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_district', 'เขต/อำเภอ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_district', null,  ['class' => 'form-control autofill','id'=>"view_contact_district", 'maxlength' => 255, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_district', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
            <div class="form-group  {{ $errors->has('view_contact_zipcode') ? 'has-error' : ''}}">
            {!! Form::label('view_contact_zipcode', 'รหัสไปรษณีย์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
            {!! Form::text('view_contact_zipcode', null,  ['class' => 'form-control autofill','id'=>"view_contact_zipcode", 'maxlength' => 5, 'disabled' => true]) !!}
            {!! $errors->first('view_contact_zipcode', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
</div>
</div>



<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
     {!! Form::label('address_show', 'ข้อมูลบัญชีธนาคาร', ['class' => 'col-md-2  control-label label_height']) !!}
</div>
<div class="row">
            <div class="col-md-8">
                <div class="form-group {{ $errors->has('view_bank_name') ? 'has-error' : ''}}">
                    {!! Form::label('view_bank_name', 'ชื่อธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-9">
                        {!! Form::text('view_bank_name', null, ['class' => 'form-control autofill','id'=>"view_bank_name", 'maxlength' => 255, 'placeholder' => 'ชื่อธนาคาร', 'disabled' => true]) !!}
                        {!! $errors->first('view_bank_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('view_bank_title') ? 'has-error' : ''}}">
                    {!! Form::label('view_bank_title', 'ชื่อบัญชีธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-9">
                        {!! Form::text('view_bank_title', null,  ['class' => 'form-control autofill','id'=>"view_bank_title", 'maxlength' => 255, 'placeholder' => 'ชื่อบัญชีธนาคาร', 'disabled' => true]) !!}
                        {!! $errors->first('view_bank_title', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('view_bank_number') ? 'has-error' : ''}}">
                    {!! Form::label('view_bank_number', 'เลขบัญชีธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
                    <div class="col-md-9">
                        {!! Form::text('view_bank_number', null,  ['class' => 'form-control autofill','id'=>"view_bank_number", 'maxlength' => 255, 'placeholder' => 'เลขบัญชีธนาคาร', 'disabled' => true]) !!}
                        {!! $errors->first('view_bank_number', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="form-group {{ $errors->has('bank_file') ? 'has-error' : ''}}">
        
                            {!! Form::label('bank_file', 'เอกสารหน้าบัญชี:', ['class' => 'col-md-3 control-label']) !!}
                            <span id="span_bank_file">
                               @if (isset($expert) && $expert->AttachFileBankFileTo)
                                    @php
                                    $attach = $expert->AttachFileBankFileTo;
                                    @endphp
                                    
                                    <div class="col-md-9">
                                                <div class="form-group">
                                                            <div class="col-md-12" style="padding-top: 7px; margin-bottom: 0; text-align: left">
                                                                        {!! !empty($attach->caption) ? $attach->caption : '' !!}
                                                                        <a href="{{url('funtions/get-view/'.$attach->url.'/'.( !empty($attach->filename) ? $attach->filename :  basename($attach->url)  ))}}" target="_blank" 
                                                                                    title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}" >
                                                                                    {!! !empty($attach->filename) ? $attach->filename : '' !!}
                                                                        </a>
                                                            </div>
                                                </div>
                                    </div>
                                   @endif
                              </span>
                        </div>
        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
        
            </div>
        </div>

        </div>
    </div>
</div>

<div class="row ">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend class="label-height">ข้อมูลการศึกษา</legend>
            <hr>
       <table class="table color-bordered-table info-bordered-table">
              <thead>
              <tr class=" text-center" >
                  <th class="text-center"  width="1%">No.</th>
                  <th class="text-center"  width="10%">ปีที่สำเร็จ</th>
                  <th class="text-center"  width="20%">วุฒิการศึกษา</th>
                  <th class="text-center"  width="25%">สถานศึกษา</th>
                  <th class="text-center"  width="25%">หลักฐานการศึกษา</th>
              </tr>
              </thead>
              <tbody id="view-table-body">
                  
              </tbody>
        </table>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend class="label-height">ข้อมูลประสบการณ์/ประวัติการดำเนินงานกับ สมอ.</legend>
            <hr>
          <legend class="label-height-font10">ข้อมูลประสบการณ์</legend>
          <table class="table color-bordered-table info-bordered-table">
              <thead>
              <tr class=" text-center" >
                  <th class="text-center"  width="1%">No.</th>
                  <th class="text-center"  width="15%">ปี</th>
                  <th class="text-center"  width="20%">หน่วยงาน</th>
                  <th class="text-center"  width="25%">ตำแหน่ง</th>
                  <th class="text-center"  width="20%">บทบาทหน้าที่</th>
              </tr>
              </thead>
              <tbody id="view-experiences-body">
                  
              </tbody>
         </table>
         <legend class="label-height-font10">ประวัติการดำเนินงานกับ สมอ.</legend>
         <table class="table color-bordered-table info-bordered-table">
             <thead>
             <tr class=" text-center" >
                 <th class="text-center"  width="1%">No.</th>
                 <th class="text-center"  width="15%">วันที่ดำเนินการ</th>
                 <th class="text-center"  width="15%">หน่วยงาน</th>
                 <th class="text-center"  width="10%">คำสั่งที่ </th>
                 <th class="text-center"  width="15%">ความเชียวชาญด้าน</th>
                 <th class="text-center"  width="10%">ตำแหน่ง</th>
             </tr>
             </thead>
             <tbody id="view-historys-body">
                 
             </tbody>
        </table>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend class="label-height">ข้อมูลความเชี่ยวชาญ</legend>
            <hr>
<div class="row">
   <div class="col-md-12 ">
         <div class="form-group {{ $errors->has('view_historycv_text') ? 'has-error' : ''}}">
            {!! Form::label('view_historycv_text', 'ระบุความเชี่ยวชาญ:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-8">
                        {!! Form::text('view_historycv_text', $expert->historycv_text ?? null , ['class' => 'form-control autofill ',  'data-role'=>'tagsinput'  ,'id'=>'view_historycv_text','width'=>'1000px', 'disabled' => true]) !!}
                        {!! $errors->first('view_historycv_text', '<p class="help-block">:message</p>') !!}    
            </div>
      </div>
  </div>
     <div class="col-md-12 ">
         <div class="form-group {{ $errors->has('span_historycv_file') ? 'has-error' : ''}}">
            {!! Form::label('span_historycv_file', 'ไฟล์ประวัติความเชี่ยวชาญ (CV):', ['class' => 'col-md-3 control-label']) !!}
            <span id="span_historycv_file">
                        @if (isset($expert) && $expert->AttachFileHistorycvFileTo)
                        @php
                        $attach = $expert->AttachFileHistorycvFileTo;
                        @endphp
                        <div class="col-md-8">
                                    <div class="form-group">
                                                <div class="col-md-12" style="padding-top: 7px; margin-bottom: 0; text-align: left">
                                                            {!! !empty($attach->caption) ? $attach->caption : '' !!}
                                                            <a href="{{url('funtions/get-view/'.$attach->url.'/'.( !empty($attach->filename) ? $attach->filename :  basename($attach->url)  ))}}" target="_blank" 
                                                                        title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}" >
                                                                        {!! !empty($attach->filename) ? $attach->filename : '' !!}
                                                            </a>
                                                </div>
                                    </div>
                        </div>
                        @endif
            </span>
      </div>
  </div>
</div> 

        </div>
    </div>
</div>


{{-- <div class="row">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
                <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  value="1"    {{ isset($expert->id) ? 'checked': '' }}>
            <label for="checkbox_confirm"  >
                    &nbsp;  ยอมรับเงื่อนไข
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b><< Click >></b> </button>
            </label>
        </div>
    </div>
</div> --}}

<div class="row">
    <div id="div_sign_up">
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary p-t-0 p-l-4">
                    <input type="checkbox" class="checkbox_confirm" name="checkbox_confirm" id="checkbox_confirm" value="1" required {{ isset($expert->id) ? 'checked': '' }}>
                    <label for="checkbox_confirm"> &nbsp;&nbsp;ข้าพเจ้าขอรับรองว่าข้อมูลในใบสมัครฉบับนี้มีความครบถ้วน ถูกต้อง และตรงตามความเป็นจริงทุกประการ และยินยอมให้สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมจัดเก็บข้อมูล เผยแพร่ และส่งต่อเพื่อใช้งานต่อไปตาม<a href="{!! asset('downloads/policy/1-TISI_Privacy_Policy.pdf') !!}" target="_blank">นโยบายการคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy) สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</a></label>
                </div>
            </div>
        </div>
   </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                &nbsp;
                <br>
                &nbsp;
                <br>
                &nbsp;
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
  </div>