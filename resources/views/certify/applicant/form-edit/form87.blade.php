<div class="m-l-10 form-group">
    <h4 class="m-l-5">2.ประเภทสถานปฏิบัติการของห้องปฏิบัติการ</h4>
</div>

<div class="m-l-15 form-group {{ $errors->has('pl_2_1') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        @if ($certi_lab_place->permanent_operating_site === 0)
            <label>{!! Form::checkbox('pl_2_1', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการถาวร &nbsp;</label>
        @else
            <label>{!! Form::checkbox('pl_2_1', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการถาวร &nbsp;</label>
        @endif
        {!! $errors->first('pl_2_1', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="m-l-15 form-group {{ $errors->has('pl_2_2') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        @if ($certi_lab_place->off_site_operations === 0)
            <label>{!! Form::checkbox('pl_2_2', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการนอกสถานที่ &nbsp;</label>
        @else
            <label>{!! Form::checkbox('pl_2_2', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการนอกสถานที่ &nbsp;</label>
        @endif
        {!! $errors->first('pl_2_2', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="m-l-15 form-group {{ $errors->has('pl_2_4') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        @if ($certi_lab_place->temporary_operating_site === 0)
            <label>{!! Form::checkbox('pl_2_4', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการชั่วคราว &nbsp;</label>
        @else
            <label>{!! Form::checkbox('pl_2_4', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการชั่วคราว &nbsp;</label>
        @endif
        {!! $errors->first('pl_2_4', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="m-l-15 form-group {{ $errors->has('pl_2_3') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        @if ($certi_lab_place->mobile_operating_facility === 0)
            <label>{!! Form::checkbox('pl_2_3', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการเคลื่อนที่ &nbsp;</label>
        @else
            <label>{!! Form::checkbox('pl_2_3', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;สถานปฏิบัติการเคลื่อนที่ &nbsp;</label>
        @endif
        {!! $errors->first('pl_2_3', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="m-l-10 form-group">
    <h4 class="m-l-5">3.ระบบบริหารงานของห้องปฏิบัติการ</h4>
</div>
<div class="m-l-15 form-group">
    @if ($certi_lab->management_lab == 0)
        <div class="col-md-12 m-l-15">
            <label>{!! Form::radio('mn_3_1', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทางเลือก ก - ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 - 2561 (ISO/IEC 17025 : 2017) &nbsp;</label>
            {!! $errors->first('mn_3_1', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-md-12 m-l-15">
            <label>{!! Form::radio('mn_3_1', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทางเลือก ข - ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 9001 – 2559 หรือ ISO 9001 : 2015 &nbsp;</label>
            {!! $errors->first('mn_3_1', '<p class="help-block">:message</p>') !!}
        </div>

    @else
        <div class="col-md-12 m-l-15">
            <label>{!! Form::radio('mn_3_1', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทางเลือก ก - ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 - 2561 (ISO/IEC 17025 : 2017) &nbsp;</label>
            {!! $errors->first('mn_3_1', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-md-12 m-l-15">
            <label>{!! Form::radio('mn_3_1', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทางเลือก ข - ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 9001 – 2559 หรือ ISO 9001 : 2015 &nbsp;</label>
            {!! $errors->first('mn_3_1', '<p class="help-block">:message</p>') !!}
        </div>
    @endif

</div>