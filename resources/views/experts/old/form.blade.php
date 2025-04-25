@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">

    .free-dot {
        border-bottom: thin dotted #000000;
        padding-bottom: 0px !important;
    }

    .detail-result {
        display: block;
        padding: 6px 12px;
    }

    .detail-result-underline {
        display: block;
        padding: 6px 12px;
        /* border-top: #000000 solid 1px; */
        border-bottom: #000000 solid 1px;
    }
    
    .label-height{
        line-height: 25px;
        font-size: 20px;
        font-weight: 600 !important;
        color: black !important;
    }

    .font_size{
        font-size: 10px;
    }

</style>
@endpush

<div class="form-group {{ $errors->has('head_name') ? 'has-error' : ''}}">
    <div class="row">
        <!-- <div class="col-md-6">
            {!! Form::number('trader_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('trader_id', '<p class="help-block">:message</p>') !!}
        </div> -->
        <div class="col-md-12">

            {!! Form::label('head_name', 'ชื่อผู้ประกอบการ:', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-5">
                {!! Form::text('head_name', $user->name , ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'ชื่อ-สกุล', 'readonly' => 'readonly'] : ['class' => 'form-control', 'placeholder' => 'ชื่อ-สกุล', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_name', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-md-5">
                {!! Form::text('taxid', $user->tax_number, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'เลขประจำตัวผู้เสียภาษี', 'readonly' => 'readonly'] : ['class' => 'form-control', 'placeholder' => 'เลขประจำตัวผู้เสียภาษี', 'readonly' => 'readonly']) !!}
                {!! $errors->first('taxid', '<p class="help-block">:message</p>') !!}
            </div>
        </div>


    </div>

</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address_show', '&nbsp; ', ['class' => 'col-md-2 control-label label-height']) !!}
    <div class="col-md-8">
        <div class="label-height">
            <label class="label-height">ที่อยู่ตามทะเบียนบ้าน</label>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6">

        <div class="form-group required {{ $errors->has('head_address_no') ? 'has-error' : ''}}">
            {!! Form::label('head_address_no', 'เลขที่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_address_no', $user->address_no, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_address_no', '<p class="help-block">:message</p>') !!}
            </div>

        </div>

        <div class="form-group {{ $errors->has('head_soi') ? 'has-error' : ''}}">
            {!! Form::label('head_soi', 'ตรอก/ซอย:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_soi', $user->soi, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('head_subdistrict') ? 'has-error' : ''}}">
            {!! Form::label('head_subdistrict', 'แขวง/ตำบล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_subdistrict', $user->subdistrict, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_subdistrict', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('head_province') ? 'has-error' : ''}}">
            {!! Form::label('head_province', 'จังหวัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_province', $user->province, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_province', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="form-group {{ $errors->has('head_village') ? 'has-error' : ''}}">
            {!! Form::label('head_village', 'อาคาร/หมู่บ้าน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_village', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_village', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('head_moo') ? 'has-error' : ''}}">
            {!! Form::label('head_moo', 'หมู่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_moo', $user->moo, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_moo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group required {{ $errors->has('head_district') ? 'has-error' : ''}}">
            {!! Form::label('head_district', 'เขต/อำเภอ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_district', $user->district, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group required {{ $errors->has('head_zipcode') ? 'has-error' : ''}}">
            {!! Form::label('head_zipcode', 'รหัสไปรษณีย์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('head_zipcode', $user->zipcode, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('head_zipcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>


</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {{-- {!! HTML::decode(Form::label('address_check', 'ที่อยู่ที่สามารถติดต่อได้ <span class="text-danger"> *</span>', ['class' => 'col-md-2 control-label label-height'])) !!} --}}
    {!! HTML::decode(Form::label('address_check', 'ที่อยู่ที่สามารถติดต่อได้', ['class' => 'col-md-2 control-label label-height'])) !!}
    <div class="col-md-8">
        <div class="checkbox checkbox-success  label-height">
            <input id="address_same_head" class="address_same_head" type="checkbox" name="address_same_head">
            <label for="address_same_head  label-height"> &nbsp;ใช้ที่อยู่ตามทะเบียนบ้าน&nbsp;</label>
        </div>
    </div>
</div>

<div class="row">


    <div class="col-md-6">

        <div class="form-group required {{ $errors->has('contact_address_no') ? 'has-error' : ''}}">
            {!! Form::label('contact_address_no', 'เลขที่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_address_no', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_address_no', '<p class="help-block">:message</p>') !!}
            </div>

        </div>

        <div class="form-group {{ $errors->has('contact_soi') ? 'has-error' : ''}}">
            {!! Form::label('contact_soi', 'ตรอก/ซอย:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_soi', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_subdistrict') ? 'has-error' : ''}}">
            {!! Form::label('contact_subdistrict', 'แขวง/ตำบล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_subdistrict', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_subdistrict', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_province') ? 'has-error' : ''}}">
            {!! Form::label('contact_province', 'จังหวัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_province', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_province', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="form-group {{ $errors->has('contact_village') ? 'has-error' : ''}}">
            {!! Form::label('contact_village', 'อาคาร/หมู่บ้าน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_village', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_village', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('contact_moo') ? 'has-error' : ''}}">
            {!! Form::label('contact_moo', 'หมู่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_moo', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_moo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group required {{ $errors->has('contact_district') ? 'has-error' : ''}}">
            {!! Form::label('contact_district', 'เขต/อำเภอ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_district', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group required {{ $errors->has('contact_zipcode') ? 'has-error' : ''}}">
            {!! Form::label('contact_zipcode', 'รหัสไปรษณีย์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('contact_zipcode', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('contact_zipcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('mobile_phone') ? 'has-error' : ''}}">
            {!! Form::label('mobile_phone', 'เบอร์โทรศัพท์มือถือ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('mobile_phone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                {!! $errors->first('mobile_phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'E-Mail:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-7">
                {!! Form::text('email', $user->email, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'] : ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>



</div>

<div class="row">
    <div class="col-md-8 ">
        <!-- <div id="other_attach-box8"> -->
        <div class="form-group {{ $errors->has('historycv_file') ? 'has-error' : ''}}">

            {!! Form::label('historycv_file', 'ไฟล์ประวัติความเชี่ยวชาญ (CV):', ['class' => 'col-md-3 control-label']) !!}
            @if (isset($expert) && $expert->AttachFileHistorycvFileTo)
            @php
                $attach = $expert->AttachFileHistorycvFileTo;
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
            @else
            <div class="col-md-9">
                <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                        {!! Form::file('historycv_file', null, ['class'=>'check_max_size_file']) !!}
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>
                {!! $errors->first('historycv_file', '<p class="help-block">:message</p>') !!}
            </div>
            @endif

        </div>

        <!-- </div> -->
    </div>
</div>

<div class="form-group {{ $errors->has('bank_data') ? 'has-error' : ''}}">
    {!! Form::label('bank_data', '&nbsp; ', ['class' => 'col-md-2 control-label label-height']) !!}
    <div class="col-md-8">
        <div class="label-height">
            <label class="label-height">ข้อมูลบัญชีธนาคาร</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        {{-- <div class="form-group {{ $errors->has('bank_data') ? 'has-error' : ''}}">
            {!! Form::label('bank_data', 'ข้อมูลบัญชีธนาคาร', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-7">

            </div>
        </div> --}}

        <div class="form-group {{ $errors->has('bank_name') ? 'has-error' : ''}}">
            {!! Form::label('bank_name', 'ชื่อธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('bank_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'ชื่อธนาคาร'] : ['class' => 'form-control', 'placeholder' => 'ชื่อธนาคาร']) !!}
                {!! $errors->first('bank_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('bank_title') ? 'has-error' : ''}}">
            {!! Form::label('bank_title', 'ชื่อบัญชีธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('bank_title', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'ชื่อบัญชีธนาคาร'] : ['class' => 'form-control', 'placeholder' => 'ชื่อบัญชีธนาคาร']) !!}
                {!! $errors->first('bank_title', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('bank_number') ? 'has-error' : ''}}">
            {!! Form::label('bank_number', 'เลขบัญชีธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('bank_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'เลขบัญชีธนาคาร'] : ['class' => 'form-control', 'placeholder' => 'เลขบัญชีธนาคาร']) !!}
                {!! $errors->first('bank_number', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12 ">

                <div class="form-group {{ $errors->has('bank_file') ? 'has-error' : ''}}">

                    {!! Form::label('bank_file', 'เอกสารหน้าบัญชี:', ['class' => 'col-md-3 control-label']) !!}
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
                    @else
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">เลือกไฟล์</span>
                                <span class="fileinput-exists">เปลี่ยน</span>
                                {!! Form::file('bank_file', null, ['class'=>'check_max_size_file']) !!}
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                        {!! $errors->first('bank_file', '<p class="help-block">:message</p>') !!}
                    </div>
                    @endif

                </div>

            </div>
        </div>



    </div>
    <div class="col-md-4">

    </div>





</div>

<div class="row" style="float:right; padding-right:7%">
    <div class="form-group">

        <div style="float: left; width: 50px;">
            ลงชื่อ
        </div>
        <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
            {!! str_repeat("&nbsp;", 10) !!} {!! isset($expert) && $expert->head_name?$expert->head_name:'-' !!} {!! str_repeat("&nbsp;", 10) !!}
        </div>
        &nbsp;ผู้ประกอบการ
    </div>
    <div class="form-group">

        <div style="float: left; width: 50px;">
            ลงชื่อ
        </div>
        <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
            {!! str_repeat("&nbsp;", 10) !!} {!! auth()->user()->name !!} {!! str_repeat("&nbsp;", 10) !!}
        </div>
        &nbsp;ผู้ยื่นคำขอ
    </div>
    <div class="form-group">

        <div style="float: left; width: 60px;">
            ลงวันที่
        </div>
        <div style="float: left; width: auto; text-align: left; line-height: 23px;" class="free-dot">
            {!! str_repeat("&nbsp;", 10) !!} {!! isset($expert) && $expert->comfirm_date?$expert->comfirm_date:'-' !!} {!! str_repeat("&nbsp;", 10) !!}
        </div>

    </div>
</div>

<div style="clear: both; margin: 5pt; padding: 0pt;"></div>


<div class="form-group">
    <div class="col-md-offset-4 col-md-4">

        <button class="btn btn-primary" type="submit">
            <i class="fa fa-paper-plane"></i> บันทึก
        </button>
        @can('view-'.str_slug('experts'))
        <a class="btn btn-default" href="{{url('/experts')}}">
            <i class="fa fa-rotate-left"></i> ยกเลิก
        </a>
        @endcan
    </div>
</div>


<!-- <div class="form-group {{ $errors->has('operation_id') ? 'has-error' : ''}}">
        {!! Form::label('operation_id', 'Operation Id', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('operation_id', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('operation_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('ref_no') ? 'has-error' : ''}}">
        {!! Form::label('ref_no', 'Ref No', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('ref_no', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            {!! $errors->first('ref_no', '<p class="help-block">:message</p>') !!}
        </div>
    </div> -->

<div class="row">

    <div class="white-box" style="border: 2px solid #e5ebec;">
        <legend style="padding: 3px 10px; background-color: #20B2AA;">
            <h4 style="color: white;">ผลการพิจารณา</h4>
        </legend>

        <div class="form-group {{ $errors->has('assign_date') ? 'has-error' : ''}}">
            {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <span class="detail-result">{{$status}}</span>
            </div>
        </div>

        <div class="form-group {{ $errors->has('assign_date') ? 'has-error' : ''}}">
            {!! Form::label('action_date', 'วันที่ดำเนินการ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <span class="detail-result">{{ !is_null($expert)?HP::DateTimeFullThai($expert->created_at):'-' }}</span>
            </div>
        </div>

        <div class="form-group {{ $errors->has('expert_no') ? 'has-error' : ''}}">
            {!! Form::label('expert_no', 'รหัสผู้เชี่ยวชาญ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <span class="detail-result">{{ !is_null($expert)?$expert->expert_no:'-' }}</span>
            </div>
        </div>

        <div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
            {!! Form::label('detail', 'รายละเอียดความเชี่ยวชาญ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                 @foreach ($expert_type as $key=>$item)
                        <span class="detail-result-underline">{{ ($key+1).'.' }} {{ $item }}</span>
                 @endforeach
                {{-- <span class="detail-result-underline">1. คณะกรรมการที่มีอำนาจในการประกาศมาตรฐาน</span>
                <span class="detail-result-underline">2. ผู้เชี่ยวชาญ</span>
                <span class="detail-result-underline">3. SDO</span> --}}
            </div>
        </div>

        <div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
            {!! Form::label('detail', 'รายละเอียดชื่อตามที่กฎหมายกำหนด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
              @foreach ($board_type as $key=>$item)
                        <span class="detail-result-underline">{{ ($key+1).'.' }} {{ $item }}</span>
                 @endforeach
                {{-- <span class="detail-result-underline">1. คณะกรรมการที่มีอำนาจในการประกาศมาตรฐาน</span>
                <span class="detail-result-underline">2. ผู้เชี่ยวชาญ</span>
                <span class="detail-result-underline">3. SDO</span> --}}
            </div>
        </div>

    </div>

</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">

        @can('view-'.str_slug('experts'))
        <a class="btn btn-default" href="{{url('/experts')}}">
            <i class="fa fa-rotate-left"></i> ปิด
        </a>
        @endcan
    </div>
</div>


<!-- <div class="form-group {{ $errors->has('receive_date') ? 'has-error' : ''}}">
    {!! Form::label('receive_date', 'Receive Date', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('receive_date', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('receive_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('receive_by') ? 'has-error' : ''}}">
    {!! Form::label('receive_by', 'Receive By', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('receive_by', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('receive_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('confirm_date') ? 'has-error' : ''}}">
    {!! Form::label('confirm_date', 'Confirm Date', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('confirm_date', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('confirm_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('confirm_by') ? 'has-error' : ''}}">
    {!! Form::label('confirm_by', 'Confirm By', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('confirm_by', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('confirm_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('revoke_date') ? 'has-error' : ''}}">
    {!! Form::label('revoke_date', 'Revoke Date', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('revoke_date', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('revoke_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('revoke_detail') ? 'has-error' : ''}}">
    {!! Form::label('revoke_detail', 'Revoke Detail', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('revoke_detail', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('revoke_detail', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('revoke_by') ? 'has-error' : ''}}">
    {!! Form::label('revoke_by', 'Revoke By', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('revoke_by', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('revoke_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
    {!! Form::label('state', 'State', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <label>{!! Form::radio('state', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} เปิด</label>
        <label>{!! Form::radio('state', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} ปิด</label>

        {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
    {!! Form::label('created_by', 'Created By', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('created_by', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('updated_by') ? 'has-error' : ''}}">
    {!! Form::label('updated_by', 'Updated By', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('updated_by', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('updated_by', '<p class="help-block">:message</p>') !!}
    </div>
</div> -->

<!-- <div class="form-group">
    <div class="col-md-offset-4 col-md-4">

        <button class="btn btn-primary" type="submit">
            <i class="fa fa-paper-plane"></i> บันทึก
        </button>
        @can('view-'.str_slug('experts'))
        <a class="btn btn-default" href="{{url('/experts')}}">
            <i class="fa fa-rotate-left"></i> ยกเลิก
        </a>
        @endcan
    </div>
</div> -->

@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
<script src="{{asset('js/jasny-bootstrap.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#address_same_head').on('change', function() {
            if ($(this).prop('checked')) {
                $('#contact_address_no').val($('#head_address_no').val());
                $('#contact_soi').val($('#head_soi').val());
                $('#contact_subdistrict').val($('#head_subdistrict').val());
                $('#contact_province').val($('#head_province').val());
                $('#contact_village').val($('#head_village').val());
                $('#contact_moo').val($('#head_moo').val());
                $('#contact_district').val($('#head_district').val());
                $('#contact_zipcode').val($('#head_zipcode').val());
            } else {
                $('#contact_address_no').val('');
                $('#contact_soi').val('');
                $('#contact_subdistrict').val('');
                $('#contact_province').val('');
                $('#contact_village').val('');
                $('#contact_moo').val('');
                $('#contact_district').val('');
                $('#contact_zipcode').val('');
            }
        });

    });
</script>

@endpush