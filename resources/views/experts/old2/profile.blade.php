@push('css')
    <link rel="stylesheet" href="{{asset('plugins/components/dropify/dist/css/dropify.min.css')}}">
@endpush
<div class="row">
    <div class="col-md-6">

        <div class="form-group  {{ $errors->has('head_name') ? 'has-error' : ''}}">
            {!! Form::label('head_name', 'ชื่อ - นามสกุล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                 {!! Form::text('head_name', $user->name ,  ['class' => 'form-control','id'=>"head_name", 'placeholder' => 'ชื่อ-สกุล', 'readonly' => true]) !!}
                {!! $errors->first('head_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  {{ $errors->has('taxid') ? 'has-error' : ''}}">
            {!! Form::label('taxid', 'เลขประจำตัวประชาชน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('taxid', $user->tax_number, ['class' => 'form-control','id'=>"taxid", 'placeholder' => 'เลขประจำตัวผู้เสียภาษี', 'readonly' => true]) !!}
                {!! $errors->first('taxid', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  required{{ $errors->has('tel') ? 'has-error' : ''}}">
            {!! Form::label('mobile_phone', 'เบอร์โทรศัพท์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('mobile_phone', $user->contact_phone_number,  ['class' => 'form-control input_required','id'=>"mobile_phone", 'maxlength' => 25, 'readonly' => true, 'required' => true]) !!}
                {!! $errors->first('mobile_phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  required{{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'E-Mail:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('email', $user->email, ['class' => 'form-control','id'=>"email", 'placeholder' => 'เลขประจำตัวผู้เสียภาษี', 'readonly' => true]) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group  required{{ $errors->has('department_id') ? 'has-error' : ''}}">
            {!! Form::label('department_id', 'หน่วยงาน/สังกัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::select('department_id', 
                   App\Models\Basic\AppointDepartment::orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                     null,
                    ['class' => 'form-control input_required',
                    'id' => 'department_id',
                    'required' => true , 
                    'placeholder'=>'- เลือกหน่วยงาน/สังกัด -' ]); !!}
            </div>
        </div>
        <div class="form-group  required{{ $errors->has('position') ? 'has-error' : ''}}">
            {!! Form::label('position', 'ตำแหน่ง:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('position', null, ['class' => 'form-control input_required','id'=>"position", 'placeholder' => 'ตำแหน่ง']) !!}
                {!! $errors->first('position', '<p class="help-block">:message</p>') !!}
            </div>
        </div>


    </div>
    <div class="col-md-6">
           <div class="form-group {{ $errors->first('image', 'has-error') }}">
              {!! Form::label('', ''.'', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-sm-8 text-center">
                 {{-- <input type="file" id="input-file-now-custom-3" class="" data-height="500"  data-max-file-size="2M"  data-default-file="plugins/components/dropify/src/images/test-image-2.jpg" /> --}}
                 <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                        @if(!empty($expert->pic_profile))
                           <img src="{{ HP::getFileStorage($expert->pic_profile) }}" alt="profile pic"  id="pic_profile">    
                        @else
                           <img src="{{ asset('/images/user-placeholder.jpg') }}"  alt="profile pic" id="pic_profile" >       
                        @endif
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;" id="thumbnail_pic_profile">
                   </div>
                    <div>
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new">เปลี่ยนรูปภาพ</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                             <input name="pic_profile" type="file" class="form-control"/>
                        </span>
                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                </div>
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
            <div class="col-md-8">
                {!! Form::text('head_address_no', $user->address_no,  ['class' => 'form-control','id'=>"head_address_no", 'readonly' => true, 'required' => true]) !!}
                {!! $errors->first('head_address_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('head_soi') ? 'has-error' : ''}}">
            {!! Form::label('head_soi', 'ตรอก/ซอย:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_soi', $user->soi, ['class' => 'form-control','id'=>"head_soi", 'readonly' => true]) !!}
                {!! $errors->first('head_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('head_subdistrict') ? 'has-error' : ''}}">
            {!! Form::label('head_subdistrict', 'แขวง/ตำบล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_subdistrict', $user->subdistrict,  ['class' => 'form-control','id'=>"head_subdistrict", 'readonly' => true, 'required' => true]) !!}
                {!! $errors->first('head_subdistrict', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('head_province') ? 'has-error' : ''}}">
            {!! Form::label('head_province', 'จังหวัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_province', $user->province,  ['class' => 'form-control','id'=>"head_province", 'readonly' => true, 'required' => true]) !!}
                {!! $errors->first('head_province', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="form-group {{ $errors->has('head_village') ? 'has-error' : ''}}">
            {!! Form::label('head_village', 'อาคาร/หมู่บ้าน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_village', null,  ['class' => 'form-control','id'=>"head_village", 'readonly' => true]) !!}
                {!! $errors->first('head_village', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('head_moo') ? 'has-error' : ''}}">
            {!! Form::label('head_moo', 'หมู่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_moo', $user->moo,  ['class' => 'form-control','id'=>"head_moo", 'readonly' => true]) !!}
                {!! $errors->first('head_moo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group required {{ $errors->has('head_district') ? 'has-error' : ''}}">
            {!! Form::label('head_district', 'เขต/อำเภอ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_district', $user->district,  ['class' => 'form-control','id'=>"head_district", 'readonly' => true, 'required' => true]) !!}
                {!! $errors->first('head_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group required {{ $errors->has('head_zipcode') ? 'has-error' : ''}}">
            {!! Form::label('head_zipcode', 'รหัสไปรษณีย์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('head_zipcode', $user->zipcode,  ['class' => 'form-control','id'=>"head_zipcode", 'readonly' => true , 'required' => true]) !!}
                {!! $errors->first('head_zipcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('address_check', 'ที่อยู่ที่สามารถติดต่อได้', ['class' => 'col-md-2 control-label label-height'])) !!}
    <div class="col-md-8">
        <div class="checkbox checkbox-success  label-height">
            <input id="address_same_head" class="address_same_head" type="checkbox" name="address_same_head"  {{  !empty($expert->address_same_head) ? 'checked' : ''  }}>
            <label for="address_same_head  label-height"> &nbsp;ใช้ที่อยู่ตามทะเบียนบ้าน&nbsp;</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('contact_address_no') ? 'has-error' : ''}}">
            {!! Form::label('contact_address_no', 'เลขที่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_address_no', null,  ['class' => 'form-control input_required','id'=>"contact_address_no" , 'maxlength' => 255 , 'required' => true]) !!}
                {!! $errors->first('contact_address_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_soi') ? 'has-error' : ''}}">
            {!! Form::label('contact_soi', 'ตรอก/ซอย:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_soi', null,  ['class' => 'form-control','id'=>"contact_soi", 'maxlength' => 255]) !!}
                {!! $errors->first('contact_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_subdistrict') ? 'has-error' : ''}}">
            {!! Form::label('contact_subdistrict', 'แขวง/ตำบล:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_subdistrict', null,  ['class' => 'form-control input_required','id'=>"contact_subdistrict", 'maxlength' => 255, 'required' => true]) !!}
                {!! $errors->first('contact_subdistrict', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_province') ? 'has-error' : ''}}">
            {!! Form::label('contact_province', 'จังหวัด:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_province', null,  ['class' => 'form-control input_required','id'=>"contact_province", 'maxlength' => 255, 'required' => true]) !!}
                {!! $errors->first('contact_province', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_village') ? 'has-error' : ''}}">
            {!! Form::label('contact_village', 'อาคาร/หมู่บ้าน:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_village', null,  ['class' => 'form-control','id'=>"contact_village", 'maxlength' => 255]) !!}
                {!! $errors->first('contact_village', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact_moo') ? 'has-error' : ''}}">
            {!! Form::label('contact_moo', 'หมู่:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_moo', null,  ['class' => 'form-control','id'=>"contact_moo", 'maxlength' => 255]) !!}
                {!! $errors->first('contact_moo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_district') ? 'has-error' : ''}}">
            {!! Form::label('contact_district', 'เขต/อำเภอ:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_district', null,  ['class' => 'form-control input_required','id'=>"contact_district", 'maxlength' => 255, 'required' => true]) !!}
                {!! $errors->first('contact_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group required {{ $errors->has('contact_zipcode') ? 'has-error' : ''}}">
            {!! Form::label('contact_zipcode', 'รหัสไปรษณีย์:', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('contact_zipcode', null,  ['class' => 'form-control input_required','id'=>"contact_zipcode", 'maxlength' => 5, 'required' => true]) !!}
                {!! $errors->first('contact_zipcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group  {{ $errors->has('') ? 'has-error' : ''}}">
            {!! Form::label('', 'ข้อมูลบัญชีธนาคาร', ['class' => 'col-md-2 control-label label-height']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group {{ $errors->has('bank_name') ? 'has-error' : ''}}">
            {!! Form::label('bank_name', 'ชื่อธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('bank_name', null, ['class' => 'form-control','id'=>"bank_name", 'maxlength' => 255, 'placeholder' => 'ชื่อธนาคาร']) !!}
                {!! $errors->first('bank_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('bank_title') ? 'has-error' : ''}}">
            {!! Form::label('bank_title', 'ชื่อบัญชีธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('bank_title', null,  ['class' => 'form-control','id'=>"bank_title", 'maxlength' => 255, 'placeholder' => 'ชื่อบัญชีธนาคาร']) !!}
                {!! $errors->first('bank_title', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('bank_number') ? 'has-error' : ''}}">
            {!! Form::label('bank_number', 'เลขบัญชีธนาคาร:', ['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                {!! Form::text('bank_number', null,  ['class' => 'form-control','id'=>"bank_number", 'maxlength' => 255, 'placeholder' => 'เลขบัญชีธนาคาร']) !!}
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
                                <input type="file" name="bank_file" id="bank_file" class="check_max_size_file " >
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


@push('js')

    <script src="{{asset('plugins/components/dropify/dist/js/dropify.min.js')}}"></script>
    <script>
         $(document).ready(function () {
            // Basic
            $('.dropify').dropify();
         
  
            
        });
    </script>
@endpush
