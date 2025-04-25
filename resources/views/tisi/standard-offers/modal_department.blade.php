@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endpush

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModalAppointDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalExportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalAppointDepartmentLabel">เพิ่มหน่วยงานสำหรับผู้ยื่นข้อเสนอ (Proposer)
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; Close</span>
                    </button>
                </h4>
            </div>

            {!! Form::open(['url' => '/tisi/standard-offers/save_department', 'class' => 'form-horizontal', 'files' => true, 'method'=> 'POST', 'id' => 'form_department']) !!}

            <div class="modal-body">

                <div class="form-group required {{ $errors->has('title') ? 'has-error' : ''}}">
                  {!! Html::decode(Form::label('title', 'ชื่อหน่วยงาน <span class="text-danger">*</span>', ['class' => 'col-md-4 control-label'])) !!}
                    <div class="col-md-6">
                        {!! Form::text('title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                {{-- <div class="form-group {{ $errors->has('department_type') ? 'has-error' : ''}}">
                    {!! Form::label('department_type_id', 'ประเภทหน่วยงาน', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('department_type_id[]', HP::DepartmentTypes(), null, ['class' => 'select2-multiple', 'multiple' => 'multiple', 'data-placeholder'=>'- เลือกประเภทหน่วยงาน -']) !!}
                        {!! $errors->first('department_type_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div> --}}

                <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                    {!! Form::label('address', 'ที่อยู่', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control', 'rows'=>'2']) !!}
                        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
                    {!! Form::label('province_id', 'จังหวัด', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('province_id', App\Models\Basic\Province::pluck('PROVINCE_NAME', 'PROVINCE_ID'), null, ['class' => 'form-control', 'placeholder'=>'- เลือกจังหวัด -']) !!}
                        {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('amphur_id') ? 'has-error' : ''}}">
                    {!! Form::label('amphur_id', 'อำเภอ/เขต', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('amphur_id', $amphurs, null, ['class' => 'form-control', 'placeholder'=>'- เลือกอำเภอ -']) !!}
                        {!! $errors->first('amphur_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
                    {!! Form::label('district_id', 'ตำบล/แขวง', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('district_id', $districts, null, ['class' => 'form-control', 'placeholder'=>'- เลือกตำบล -']) !!}
                        {!! $errors->first('district_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('poscode') ? 'has-error' : ''}}">
                    {!! Form::label('poscode', 'รหัสไปรษณีย์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('poscode', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('poscode', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
                    {!! Form::label('tel', 'เบอร์โทร', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('tel', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}}">
                    {!! Form::label('mobile', 'มือถือ', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('fax') ? 'has-error' : ''}}">
                    {!! Form::label('fax', 'แฟกซ์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('fax', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('fax', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                    {!! Form::label('email', 'E-mail', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">

                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-paper-plane"></i> บันทึก
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fa fa-rotate-left"> ยกเลิก</span>
                        </button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
    <script>
       $(document).ready(function() {
        
            //เมื่อเลือกจังหวัด
            $('#province_id').change(function () {
        
                $('#amphur_id, #district_id').children(":not([value=''])").remove();

                var url = '{{ url('basic/amphur/list') }}/'+$(this).val();
                $.ajax({
                    'type': 'GET',
                    'url': url,
                    'success': function (datas) {

                    $.each(datas, function(index, data) {
                        $('#amphur_id').append('<option value="'+index+'">'+data+'</option>');
                    });

                    }
                });
                
            });


            //เมื่อเลือกอำเภอ
            $('#amphur_id').change(function () {

                $('#district_id').children(":not([value=''])").remove();

                var url = '{{ url('basic/district/list') }}/'+$(this).val();
                $.ajax({
                    'type': 'GET',
                    'url': url,
                    'success': function (datas) {

                    $.each(datas, function(index, data) {
                        $('#district_id').append('<option value="'+index+'">'+data+'</option>');
                    });

                    }
                });

            });
        });
    </script>

@endpush
