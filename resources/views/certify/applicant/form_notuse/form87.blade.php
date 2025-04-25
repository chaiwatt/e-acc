
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>2. ประเภทสถานปฏิบัติการของห้องปฏิบัติการ (Types of laboratory’s facilities)</h4></legend>

                <div class="m-l-15 form-group {{ $errors->has('pl_2_1') ? 'has-error' : ''}}">
                    <div class="col-md-12 m-l-15">
                        {!! Form::checkbox('pl_2_1', '0', false, ['class'=>'check pl_2_1','data-checkbox'=>"icheckbox_flat-red"]) !!}
                        <label for="pl_2_1"> &nbsp;สถานปฏิบัติการถาวร  (Permanent facilities) &nbsp; </label>
                        {!! $errors->first('pl_2_1', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="m-l-15 form-group {{ $errors->has('pl_2_2') ? 'has-error' : ''}}">
                    <div class="col-md-12 m-l-15">
                        {!! Form::checkbox('pl_2_2', '0', false, ['class'=>'check pl_2_2','data-checkbox'=>"icheckbox_flat-red"]) !!}
                        <label for="pl_2_2"> &nbsp;สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities) &nbsp; </label>
                        {!! $errors->first('pl_2_2', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="m-l-15 form-group {{ $errors->has('pl_2_4') ? 'has-error' : ''}}">
                    <div class="col-md-12 m-l-15">
                        {!! Form::checkbox('pl_2_4', '0', false, ['class'=>'check pl_2_4','data-checkbox'=>"icheckbox_flat-red"]) !!}
                        <label for="pl_2_4"> &nbsp;สถานปฏิบัติการชั่วคราว (Temporary facilities) &nbsp; </label>
                        {!! $errors->first('pl_2_4', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="m-l-15 form-group {{ $errors->has('pl_2_3') ? 'has-error' : ''}}">
                    <div class="col-md-12 m-l-15">
                        {!! Form::checkbox('pl_2_3', '0', false, ['class'=>'check pl_2_3','data-checkbox'=>"icheckbox_flat-red"]) !!}
                        <label for="pl_2_3"> &nbsp;สถานปฏิบัติการเคลื่อนที่ (Mobile facilities) &nbsp; </label>
                        {!! $errors->first('pl_2_3', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="m-l-15 form-group {{ $errors->has('pl_2_5') ? 'has-error' : ''}}">
                    <div class="col-md-12 m-l-15">
                        {!! Form::checkbox('pl_2_5', '0', false, ['class'=>'check pl_2_5','data-checkbox'=>"icheckbox_flat-red"]) !!}
                        <label for="pl_2_5"> &nbsp;สถานปฏิบัติการหลายสถานะที่ (Multi-site facilities) &nbsp; </label>
                        {!! $errors->first('pl_2_5', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
                    <legend><h4>3. ระบบบริหารงานของห้องปฏิบัติการ (Management System of Laboratory)</h4></legend>
            <div class="m-l-15 form-group">
                <div class="col-md-12 m-l-15">
                    <label>{!! Form::radio('mn_3_1', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทางเลือก ก -- ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 - 2561 (ISO/IEC 17025 : 2017) (Option A – a management system in accordance with requirements of TIS 17025 – 2561(2018) (ISO/IEC 17025 : 2017))  &nbsp;</label>
                    {!! $errors->first('mn_3_1', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-12 m-l-15">
                    <label>{!! Form::radio('mn_3_1', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทางเลือก ข – ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 9001 – 2559 หรือ ISO 9001 : 2015 (Option B – a management system in accordance with requirements of TIS 9001 – 2559(2016) or ISO 9001 : 2015) &nbsp;</label>
                    {!! $errors->first('mn_3_1', '<p class="help-block">:message</p>') !!}
                </div>
           </div>
        </div>
    </div>
</div>
