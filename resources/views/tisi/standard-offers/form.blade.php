<div class="container">
    
    <h3 class="mb-4">ผู้ยื่นข้อเสนอ (Proposer)</h3>
    <div class="row">
        <!-- คอลัมน์ที่ 1 (ครึ่งหนึ่งของหน้าจอสำหรับขนาดกลางขึ้นไป) -->
        <div class="col-md-6">
            <div class="form-group required {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('title', 'ชื่อหน่วยงาน', ['class' => 'control-label'])) !!}
                <div>
                    {!! Form::text('title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


            <div class="form-group required {{ $errors->has('province_id') ? 'has-error' : ''}}">
                {!! Form::label('province_id', 'จังหวัด', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::select('province_id', App\Models\Basic\Province::pluck('PROVINCE_NAME', 'PROVINCE_ID'), null, ['class' => 'form-control', 'placeholder'=>'- เลือกจังหวัด -', 'required' => 'required']) !!}
                    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group required {{ $errors->has('district_id') ? 'has-error' : ''}}">
                {!! Form::label('district_id', 'ตำบล/แขวง', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::select('district_id', $districts, null, ['class' => 'form-control', 'placeholder'=>'- เลือกตำบล -', 'required' => 'required']) !!}
                    {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

              <div class="form-group required {{ $errors->has('tel') ? 'has-error' : ''}}">
                {!! Form::label('tel', 'เบอร์โทร', ['class' => 'control-label']) !!}
                <div>
                    {{-- {!! Form::text('tel', null, ('required' == 'required') ?['class' => 'form-control']) !!} --}}
                    {!! Form::text('tel', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('fax') ? 'has-error' : ''}}">
                {!! Form::label('fax', 'แฟกซ์', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::text('fax', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('fax', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group required{{ $errors->has('fax') ? 'has-error' : ''}}">
                {!! Form::label('name', 'ผู้ประสานงาน', ['class' => 'control-label']) !!}
                <div>
                    {{-- {!! Form::text('name', null,  ['class' => 'form-control','required'=>true]) !!} --}}
                    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


        </div>

        <!-- คอลัมน์ที่ 2 (ครึ่งหนึ่งของหน้าจอสำหรับขนาดกลางขึ้นไป) -->
        <div class="col-md-6">
         
            <div class="form-group required{{ $errors->has('address') ? 'has-error' : ''}}">
                {!! Form::label('address', 'ที่อยู่', ['class' => 'control-label', 'required' => 'required']) !!}
                <div>
                    {!! Form::text('address', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

             {{-- <div class="form-group required {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('title', 'ชื่อหน่วยงาน', ['class' => 'control-label'])) !!}
                <div>
                    {!! Form::text('title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}

            <div class="form-group required{{ $errors->has('amphur_id') ? 'has-error' : ''}}">
                {!! Form::label('amphur_id', 'อำเภอ/เขต', ['class' => 'control-label']) !!}
                <div>
                    {{-- {!! Form::select('amphur_id', $amphurs, null, ['class' => 'form-control', 'placeholder'=>'- เลือกอำเภอ -']) !!} --}}
                    {!! Form::select('amphur_id', $amphurs, null, ['class' => 'form-control', 'placeholder'=>'- เลือกอำเภอ -', 'required' => 'required']) !!}
                    {!! $errors->first('amphur_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            
            <div class="form-group required{{ $errors->has('poscode') ? 'has-error' : ''}}">
                {!! Form::label('poscode', 'รหัสไปรษณีย์', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::text('poscode', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('poscode', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}}">
                {!! Form::label('mobile', 'มือถือ', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

    
             <div class="form-group required{{ $errors->has('email') ? 'has-error' : ''}}">
                {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                <div>
                    {{-- {!! Form::text('email', null, ['class' => 'form-control']) !!} --}}
                    {!! Form::text('email', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

           
        </div>
    </div>
</div>



<div class="container">
    <h3 class="mb-4">รายละเอียดมาตรฐาน</h3>
    <div class="row">
        <!-- คอลัมน์ที่ 1 (ครึ่งหนึ่งของหน้าจอสำหรับขนาดกลางขึ้นไป) -->
        <div class="col-md-6">
            <div class="form-group required {{ $errors->has('title') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                <label for="title" class="control-label">
                    ชื่อเรื่อง : 
                </label>
                <div>
                    <!-- Div ครอบ input ไม่มี col-md-X -->
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $yourModelInstance->title ?? '') }}" required>
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group required{{ $errors->has('std_type') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                {!! Form::label('std_type', 'ประเภทมาตรฐาน'.' : ', ['class' => 'control-label']) !!}
                <div>
                    <!-- Div ครอบ select ไม่มี col-md-X -->
                    {!! Form::select('std_type',
                        App\Models\Bcertify\Standardtype::orderbyRaw('CONVERT(offertype USING tis620)')->pluck('offertype', 'id'),
                        null,
                        ['class' => 'form-control',
                        'id'=>'std_type',
                        'placeholder'=>'- เลือกประเภทมาตรฐาน -']) !!}
                    {!! $errors->first('std_type', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group required{{ $errors->has('objectve') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                {!! Html::decode(Form::label('objectve', 'จุดประสงค์และเหตุผล'.' : ', ['class' => 'control-label'])) !!}
                <div>
                    <!-- Div ครอบ textarea ไม่มี col-md-X -->
                    {!! Form::text('objectve', null, [ 'class' => 'form-control', 'required'=>true]) !!}
                    {!! $errors->first('objectve', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            
        </div>

        <!-- คอลัมน์ที่ 2 (ครึ่งหนึ่งของหน้าจอสำหรับขนาดกลางขึ้นไป) -->
        <div class="col-md-6">
            <div class="form-group required{{ $errors->has('title_eng') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                {!! Form::label('title_eng', 'ชื่อเรื่อง (Eng)'.' : ', ['class' => 'control-label']) !!}
                <div>
                    <!-- Div ครอบ input ไม่มี col-md-X -->
                    {{-- {!! Form::text('title_eng', null, ['class' => 'form-control','required'=>false]) !!} --}}
                     {!! Form::text('title_eng', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('title_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('scope') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                {!! Form::label('scope', 'ขอบข่าย'.' : ', ['class' => 'control-label']) !!}
                <div>
                    <!-- Div ครอบ textarea ไม่มี col-md-X -->
                    {!! Form::text('scope', null, [ 'class' => 'form-control','required'=>false]) !!}
                    {!! $errors->first('scope', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('stakeholders') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                {!! Form::label('stakeholders', 'ผู้มีส่วนได้เสียที่เกี่ยวข้อง'.' : ', ['class' => 'control-label']) !!}
                <div>
                    <!-- Div ครอบ input ไม่มี col-md-X -->
                    {!! Form::text('stakeholders', null, ['class' => 'form-control','required'=>false]) !!}
                    {!! $errors->first('stakeholders', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('attach_file') ? 'has-error' : ''}}"> {{-- เปลี่ยนเป็น attach_file สำหรับ error check --}}
                <!-- Label ไม่มี col-md-X -->
                {!! Form::label('additional_documents', 'เอกสารเพิ่มเติม'.' : ', ['class' => 'control-label']) !!} {{-- เปลี่ยน ID/Name สำหรับ label --}}
                <div>
                    <!-- Div ครอบเนื้อหา ไม่มี col-md-X -->
                    <div class="form-group other_attach_item">
                        <div class="col-md-6"> {{-- ลบ text-light ออก เพราะไม่ใช่คลาสมาตรฐานของ Bootstrap 3 --}}
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
                            {!! $errors->first('attach', '<p class="help-block">:message</p>') !!} {{-- ยังคงใช้ attach สำหรับ error --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
    </div>
</div>


{{-- <section id="div" class="login-register"> --}}
    <div class="row form-group" >





    {{-- <div class="row">
        <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                        {!! Html::decode(Form::label('title', 'วันที่เสนอความเห็น'.' : ', ['class' => 'col-md-6 control-label'])) !!}
                        <div class="col-md-6 m-t-10">
                                {{ @HP::DateTimeFullThai(date('Y-m-d H:i:s')) ?? '-' }}
                        </div>
                </div>
        </div>
        <div class="col-md-6"></div>
    </div> --}}

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
        // alert("fuck");

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
                        console.log(result)
                        // document.getElementById('title').textContent = 'xxx';
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
                    var file = this.files[0];
                    var filename = file.name;
                    console.log(filename);
                   $(this).closest('.fileinput').find('.fileinput-filename').text(filename);
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
