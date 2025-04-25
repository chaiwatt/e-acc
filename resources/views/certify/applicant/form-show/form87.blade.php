<div class="m-l-10 form-group">
    <h4 class="m-l-5">2.ประเภทสถานปฏิบัติการของห้องปฏิบัติการ</h4>
</div>

@if ($certi_lab_place->permanent_operating_site === 0)
    <div class="m-l-15 form-group {{ $errors->has('pl_2_1') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label><input type="checkbox" checked disabled=""> &nbsp;สถานปฏิบัติการถาวร &nbsp;</label>
        </div>
    </div>
@endif


@if ($certi_lab_place->off_site_operations === 0)
    <div class="m-l-15 form-group {{ $errors->has('pl_2_2') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label><input type="checkbox" checked disabled=""> &nbsp;สถานปฏิบัติการนอกสถานที่ &nbsp;</label>
        </div>
    </div>
@endif

@if ($certi_lab_place->temporary_operating_site === 0)
    <div class="m-l-15 form-group {{ $errors->has('pl_2_4') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label><input type="checkbox" checked disabled=""> &nbsp;สถานปฏิบัติการชั่วคราว &nbsp;</label>
        </div>
    </div>
@endif

@if ($certi_lab_place->mobile_operating_facility === 0)
    <div class="m-l-15 form-group {{ $errors->has('pl_2_3') ? 'has-error' : ''}}">
        <div class="col-md-12 m-l-15">
            <label><input type="checkbox" checked disabled=""> &nbsp;สถานปฏิบัติการเคลื่อนที่ &nbsp;</label>
        </div>
    </div>
@endif



<div class="m-l-10 form-group">
    <h4 class="m-l-5">3.ระบบบริหารงานของห้องปฏิบัติการ</h4>
</div>
<div class="m-l-15 form-group">
    @if ($certi_lab->management_lab === 0)
        <div class="col-md-12 m-l-15">
            <label><input type="checkbox" disabled checked> &nbsp;ทางเลือก ก - ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 - 2561 (ISO/IEC 17025 : 2017) &nbsp;</label>
        </div>
    @elseif($certi_lab->management_lab === 1)
        <div class="col-md-12 m-l-15">
            <label><input type="checkbox" checked disabled=""> &nbsp;ทางเลือก ข - ระบบบริหารงานตามข้อกำหนดมาตรฐานเลขที่ มอก. 9001 – 2559 หรือ ISO 9001 : 2015 &nbsp;</label>
        </div>
    @endif


</div>