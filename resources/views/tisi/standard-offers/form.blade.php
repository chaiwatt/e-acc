

{{-- <section id="div" class="login-register"> --}}
    <div class="row form-group" >
        <div class="col-md-1"></div>
        <div class="col-md-12">
            {{-- <div class="white-box" style="border: 2px solid #e5ebec;"> --}}
                {{-- <legend><b>เสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง</b></legend> --}}
    <b>รายละเอียดมาตรฐาน</b>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
        {!! Html::decode(Form::label('title', 'ชื่อเรื่อง'.' : '.'<span class="text-danger">*</span>', ['class' => 'col-md-2 control-label'])) !!}
        <div class="col-md-9">
            {!! Form::text('title', null,  ['class' => 'form-control','required'=>true]) !!}
            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('title_eng') ? 'has-error' : ''}}">
        {!! Form::label('title_eng', 'ชื่อเรื่อง (Eng)'.' : ', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-9">
            {!! Form::text('title_eng', null,  ['class' => 'form-control','required'=>false]) !!}
            {!! $errors->first('title_eng', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('std_type') ? 'has-error' : ''}}">
        {!! Form::label('std_type', 'ประเภทมาตรฐาน'.' : ', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-9">
            {!! Form::select('std_type',
                App\Models\Bcertify\Standardtype::orderbyRaw('CONVERT(offertype USING tis620)')->pluck('offertype', 'id'), 
                null,
                ['class' => 'form-control',
                'id'=>'std_type',
                'placeholder'=>'- เลือกประเภทมาตรฐาน -']) !!}
            {!! $errors->first('std_type', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('scope') ? 'has-error' : ''}}">
        {!! Form::label('scope', 'ขอบข่าย'.' : ', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-9">
        {!! Form::textarea('scope', null, [ 'rows' => 2,'cols'=>'85','required'=>false]) !!}
            {!! $errors->first('scope', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('objectve') ? 'has-error' : ''}}">
        {!! Html::decode(Form::label('objectve', 'จุดประสงค์และเหตุผล'.' : '.'<span class="text-danger">*</span>', ['class' => 'col-md-2 control-label'])) !!}
        <div class="col-md-9">
        {!! Form::textarea('objectve', null, [ 'rows' => 2,'cols'=>'85','required'=>true]) !!}
            {!! $errors->first('objectve', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('stakeholders') ? 'has-error' : ''}}">
        {!! Form::label('stakeholders', 'ผู้มีส่วนได้เสียที่เกี่ยวข้อง'.' : ', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-9">
            {!! Form::text('stakeholders', null,  ['class' => 'form-control','required'=>false]) !!}
            {!! $errors->first('stakeholders', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('stakeholders') ? 'has-error' : ''}}">
        {!! Form::label('stakeholders', 'เอกสารเพิ่มเติม'.' : ', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-9">
                <div class="form-group other_attach_item">
                        <div class="col-md-6 text-light">
                                {!! Form::text('caption', null, ['class' => 'form-control ', 'placeholder' => 'รายละเอียดเอกสาร']) !!}
                        </div>
                        <div class="col-md-6">
                                <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                    <input type="file" name="attach_file" class="attach check_max_size_file" >
                                    </span> 
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('attach', '<p class="help-block">:message</p>') !!}
                        </div>
                </div>
        </div>
    </div>

    <b>ผู้ยื่นข้อเสนอ (Proposer)</b>
    
    <div class="row">
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('name', 'ผู้ประสานงาน'.' : '.'<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                        <div class="col-md-8">
                                {!! Form::text('name', null,  ['class' => 'form-control','required'=>true]) !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('department_id') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('department_id', 'ชื่อหน่วยงาน'.' : '.'<span class="text-danger">*</span>', ['class' => 'col-md-3 control-label'])) !!}
                        <div class="col-md-8">
                                {!! Form::select('department_id',
                                App\Models\Basic\Department::orderbyRaw('CONVERT(title USING tis620)')->pluck('title', 'id'), 
                            null,
                            ['class' => 'form-control',
                            'id'=>'department_id',
                            'required'=>true,
                            'placeholder'=>'- เลือกชื่อหน่วยงาน -']) !!}
                                {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
                        </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('address', 'ที่อยู่หน่วยงาน'.' : ', ['class' => 'col-md-4 control-label'])) !!}
                        <div class="col-md-8">
                                {!! Form::textarea('address', null, ['id'=>'address', 'rows' => 2,'cols'=>'45','required'=>false]) !!}
                                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                        </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('add_depart') ? 'has-error' : ''}}">
                    {!! Html::decode(Form::label('add_depart', ' ', ['class' => 'col-md-3 control-label'])) !!}
                    <div class="col-md-8">
                        <button type="button" class="btn btn-md btn-info" data-toggle="modal" data-target="#exampleModalAppointDepartment" style="width:100%;">
                            <i class="icon-plus"></i>&nbsp;สร้างหน่วยงานสำหรับผู้ยื่นข้อเสนอ (Proposer)
                        </button>
                    </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('telephone', 'เบอร์โทรศัพท์'.' : '.'<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                        <div class="col-md-8">
                                {!! Form::text('telephone', null,  ['class' => 'form-control','required'=>true]) !!}
                                {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
                        </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('email', 'อีเมล'.' : '.'<span class="text-danger">*</span>', ['class' => 'col-md-3 control-label'])) !!}
                        <div class="col-md-8">
                                {!! Form::email('email', null,  ['class' => 'form-control','required'=>true]) !!}
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('title', 'วันที่เสนอความเห็น'.' : ', ['class' => 'col-md-4 control-label'])) !!}
                        <div class="col-md-8 m-t-10">
                                {{ @HP::DateTimeFullThai(date('Y-m-d H:i:s')) ?? '-' }}
                        </div>
                </div>
        </div>
        <div class="col-md-6"></div>
    </div>

    <input type="hidden" name="previousUrl" id="previousUrl" value="{{   app('url')->previous() }}">

    <div class="form-group">
        <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-primary" type="submit">
                <i class="fa fa-paper-plane"></i> บันทึก
                </button>
                <a class="btn btn-default" href="{{ app('url')->previous() }}">
                <i class="fa fa-rotate-left"></i> ยกเลิก
                </a>
        </div>
    </div>

            {{-- </div> --}}


        </div>
    </div>
    



    </div>
{{-- </section> --}}

@push('js')

    <script>
       $(document).ready(function() {

           //Validate
           if ($('form').length > 0 && $('form:first:not(.not_validated)').length > 0) {
               $('form:first:not(.not_validated)').parsley({
                   excluded: "input[type=button], input[type=submit], input[type=reset], [disabled], input[type=hidden]"
               }).on('field:validated', function() {
                   var ok = $('.parsley-error').length === 0;
                   $('.bs-callout-info').toggleClass('hidden', !ok);
                   $('.bs-callout-warning').toggleClass('hidden', ok);
               }).on('form:submit', function() {
                   console.log('oook');
                   $('form').find('button, input[type=button], input[type=submit], input[type=reset]').prop('disabled', true);
                   $('form').find('a').removeAttr('href');

                   return true;

               });
           }


        $('#department_id').on('change',function () {

            if ( $(this).val() !== ""){
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
               
                $.ajax({
                    url:"{{url('tisi/standard-offers/address_department')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                     if(result.address){
                            $('#address').val(result.address);
                     }else{
                            $('#address').val('');
                     }
                    }
                });
            }else{
              $('#address').val('');
            }
        })

           check_max_size_file();

       $('#form_department').on('submit', function (event) {

            event.preventDefault();
            $('button[type="submit"]').attr('disabled', true);
            var form_data = new FormData(this);
       
            $.ajax({
                type: "POST",
                url: "{{url('tisi/standard-offers/save_department')}}",
                datatype: "script",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "success") {
                        console.log(data);
                        var opt;
                        opt = "<option value='" + data.id + "'>" + data.title + "</option>";
                        $('#exampleModalAppointDepartment').modal('hide');
                        $('button[type="submit"]').attr('disabled', false);
                        $('select#department_id').append(opt).trigger('change');
                    } else if (data.status == "error") {
                        $('button[type="submit"]').attr('disabled', false);
                        alert('บันทึกไม่สำเร็จ โปรดบันทึกใหม่อีกครั้ง')
                    } else {
                        alert('ระบบขัดข้อง โปรดตรวจสอบ !');
                    }
                }
            });

        });

       });

       function check_max_size_file() {
           var max_size = "{{ ini_get('upload_max_filesize') }}";
           var res = max_size.replace("M", "");
           $('.check_max_size_file').bind('change', function() {
               if ($(this).val() != '') {
                   var size = (this.files[0].size) / 1024 / 1024; // หน่วย MB
                   console.log(this.files[0]);
                   if (size > res) {
                       Swal.fire(
                           'ขนาดไฟล์เกินกว่า ' + res + ' MB',
                           '',
                           'info'
                       )
                       //  this.value = '';
                       $(this).parent().parent().find('.fileinput-exists').click();
                       return false;
                   }
               }
           });
       }
   </script> 
@endpush

