
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>2. ประเภทสถานปฏิบัติการของห้องปฏิบัติการ (Types of laboratory’s facilities)</h4></legend>
<div class="m-l-15 form-group {{ $errors->has('certi_lab_place[permanent_operating_site]') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        {!! Form::checkbox('certi_lab_place[permanent_operating_site]', '0', !empty($certi_lab_place->permanent_operating_site=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}
        <label for="certi_lab_place[permanent_operating_site]"> &nbsp;สถานปฏิบัติการถาวร  (Permanent facilities) &nbsp; </label>
        {!! $errors->first('certi_lab_place[permanent_operating_site]', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="m-l-15 form-group {{ $errors->has('certi_lab_place[off_site_operations]') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        {!! Form::checkbox('certi_lab_place[off_site_operations]', '0', !empty($certi_lab_place->off_site_operations=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}
        <label for="certi_lab_place[off_site_operations]">&nbsp;สถานปฏิบัติการนอกสถานที่ (Sites away from its permanent facilities) &nbsp; </label>
        {!! $errors->first('certi_lab_place[off_site_operations]', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="m-l-15 form-group {{ $errors->has('certi_lab_place[temporary_operating_site]') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
         {!! Form::checkbox('certi_lab_place[temporary_operating_site]', '0', !empty($certi_lab_place->temporary_operating_site=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}
        <label for="certi_lab_place[temporary_operating_site]">&nbsp;สถานปฏิบัติการชั่วคราว (Temporary facilities) &nbsp;  </label>
        {!! $errors->first('certi_lab_place[temporary_operating_site]', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="m-l-15 form-group {{ $errors->has('certi_lab_place[mobile_operating_facility]') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        {!! Form::checkbox('certi_lab_place[mobile_operating_facility]', '0', !empty($certi_lab_place->mobile_operating_facility=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}
        <label for="certi_lab_place[mobile_operating_facility]"> &nbsp;สถานปฏิบัติการเคลื่อนที่ (Mobile facilities) &nbsp;  </label>
      {!! $errors->first('certi_lab_place[mobile_operating_facility]', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="m-l-15 form-group {{ $errors->has('certi_lab_place[multi_site_facility]') ? 'has-error' : ''}}">
    <div class="col-md-12 m-l-15">
        {!! Form::checkbox('certi_lab_place[multi_site_facility]', '0', !empty($certi_lab_place->multi_site_facility=='0') ? true :false, ['class'=>'check','data-checkbox'=>"icheckbox_flat-red"]) !!}
        <label for="certi_lab_place[multi_site_facility]"> &nbsp;สถานปฏิบัติการหลายสถานะที่ (Multi-site facilities) &nbsp;  </label>
      {!! $errors->first('certi_lab_place[multi_site_facility]', '<p class="help-block">:message</p>') !!}
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
        <label>{!! Form::radio('management_lab', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!}&nbsp;ทางเลือก ก -- ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 - 2561 (ISO/IEC 17025 : 2017) (Option A – a management system in accordance with requirements of TIS 17025 – 2561(2018) (ISO/IEC 17025 : 2017))  &nbsp;</label>
        {!! $errors->first('management_lab', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-md-12 m-l-15">
        <label>{!! Form::radio('management_lab', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!}&nbsp;ทางเลือก ข – ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 9001 – 2559 หรือ ISO 9001 : 2015 (Option B – a management system in accordance with requirements of TIS 9001 – 2559(2016) or ISO 9001 : 2015) &nbsp;</label>
        {!! $errors->first('management_lab', '<p class="help-block">:message</p>') !!}
    </div>
           </div>
        </div>
    </div>
</div>
