<?php $key=0?>
<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    <h4 class="m-l-5">5. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่</h4>
</div>
<input type="hidden" name="nameResponsibility" id="nameResponsibility" value="1">
<div id="work_responsibility_container">
    <div class="work-box">
        <div class="row work-item">
            <div class="col-md-12 m-b-10">
                <div class="row">
                    <div class="col-md-8"></div>
                    {!! $errors->first('positions[]', '<p class="help-block">:message</p>') !!}
                    <div class="col-md-4">
                        @if($key==0)
                            <button class="btn btn-success pull-right btn-sm" id="work-add" type="button">
                                <i class="icon-plus"></i> เพิ่ม
                            </button>
                        @else
                            <button class="btn btn-danger pull-right btn-sm work-remove" type="button">
                                <i class="icon-close"></i> &nbsp;ลบ
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box" style="border: 2px solid #e5ebec;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('fname_qualification[]') ? 'has-error' : ''}}">
                                {!! Form::label('fname_qualification[]', 'ชื่อ: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-7">
                                    {!! Form::text('fname_qualification[]',$employee->first_name ?? '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('fname_qualification[]', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('lname_qualification[]') ? 'has-error' : ''}}">
                                {!! Form::label('lname_qualification[]', 'นามสกุล: ', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-7">
                                    {!! Form::text('lname_qualification[]',$employee->last_name ?? '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('lname_qualification[]', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('position_qualification[]') ? 'has-error' : ''}}">
                                {!! Form::label('position_qualification[]', 'ตำแหน่ง: ', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-7">
                                    {!! Form::text('position_qualification[]',$employee->position ?? '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('position_qualification[]', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('qualification[]') ? 'has-error' : ''}}">
                                {!! Form::label('qualification[]', 'คุณวุฒิ: ', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-7">
                                    {!! Form::text('qualification[]',$employee->quali ?? '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('qualification[]', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('responsibility[]') ? 'has-error' : ''}}">
                                {!! Form::label('responsibility[]', 'ความรับผิดชอบ: ', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-9">
                                    <textarea name="responsibility[]" id="responsibility" class="form-control" style="width: 94.4%" rows="7">{{$employee->responsible ?? ''}}</textarea>
                                    {!! $errors->first('responsibility[]', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $key++ ?>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            let box_work = $('.work-box:first').clone();
            //เพิ่มตำแหน่งงาน
            $('#work-add').click(function() {
                let newBox = box_work.clone();
                newBox.find('input').val('');
                newBox.find('textarea').text('');
                newBox.appendTo('#work_responsibility_container');

                var last_new = $('.work-box').children(':last');

                {!! $key+=1 !!}
                //Change Button
                $(last_new).find('button').removeClass('btn-success');
                $(last_new).find('button').addClass('btn-danger work-remove');
                $(last_new).find('button').html('<i class="icon-close"></i> &nbsp;ลบ');

                if (resetOrder89() === 1){
                    last_new.find('button').remove();
                }

            });

            //ลบตำแหน่ง
            $('body').on('click', '.work-remove', function() {

                $(this).parent().parent().parent().parent().parent().remove();

                if (resetOrder89() === 0){
                    $('#work-add').trigger('click');
                    $('#nameResponsibility').val(1);
                }

            });
        });

        function resetOrder89(){//รีเซตลำดับของตำแหน่ง
            let new_val = 0;
            $('.work-box').each(function(index, el) {
                new_val ++;
            });
            $('#nameResponsibility').val(new_val);
            return new_val;
        }
    </script>
@endpush