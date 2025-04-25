@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .p_condition{
            text-align: center;
            color: red;
        }
        .p_condition_detail{
            padding-left: 80px;
            color: red;
        }
    </style>
@endpush

<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'ชื่อผลิตภัณฑ์อุตสาหกรรม', ['class' => 'col-md-4 control-label required']) !!}
    <div class="col-md-6">
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group pull-right">
    <button type="button" class="btn btn-warning btn-sm add-row" id="plus-row"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มข้อมูล</button>
</div>

<table class="table color-bordered-table primary-bordered-table">
    <thead>
      <tr>
          <th class="text-center">รายการที่</th>
          <th class="text-center" width="50%">รายละเอียดผลิตภัณฑ์อุตสาหกรรม</th>
          <th class="text-center">ปริมาณที่ขอทำ</th>
          <th class="text-center">หน่วย</th>
          <th class="text-center">ลบ</th>
      </tr>
    </thead>
    <tbody id="table-body">
    @foreach ($product_details as $key => $item)
        <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="text-center align-top">
                {!! Form::hidden('product_detail_id[]', $item->id); !!}
                {!! Form::text('product_detail[]', !empty($item->detail)?$item->detail:null, ['class' => 'form-control']) !!}
            </td>
            <td class="text-center align-top">
                {!! Form::number('quantity_detail[]', !empty($item->quantity)?$item->quantity:null, ['class' => 'form-control quantity_detail text-left', 'step' => '0.01', 'max' => '9999999999.99']) !!}
            </td>
            <td class="text-center align-top">
                {!! Form::select('unit_detail[]',
                   App\Models\Basic\UnitCode::pluck('name_unit', 'Auto_num')->all(),
                   !empty($item->unit)?$item->unit:null,
                   ['class' => 'form-control', 'placeholder'=>'- เลือกหน่วย -', 'required' => 'required']) !!}
                {!! $errors->first('product_detail', '<p class="help-block">:message</p>') !!}
            </td>
            <td class="text-center align-top">
                <button type="button" class="btn btn-danger btn-xs remove-row">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"><span class="pull-right">รวม</span></td>
        <td><input class="form-control text-left" type="text" id="total_quantity" value=""></td>
        <td colspan="2"></td>
    </tr>
    </tfoot>
</table>

<div class="form-group {{ $errors->has('different_no') ? 'has-error' : ''}}">
    {!! Form::label('different_no', 'มาตรฐานเลขที่', ['class' => 'col-md-4 control-label required']) !!}
    <div class="col-md-6">
        {!! Form::select('different_no[]',
        App\Models\Basic\Tis::selectRaw('CONCAT(tb3_Tisno," : ",tb3_TisThainame) As tb3_Tisno, tb3_TisAutono')->pluck('tb3_Tisno', 'tb3_TisAutono')->all(),
        null,
        ('required' == 'required') ? ['class' => 'select2 select2-multiple', 'required' => 'required', 'multiple'=>'multiple', 'data-placeholder'=>'- เลือกมาตรฐาน -'] : ['class' => 'select2 select2-multiple', 'multiple'=>'multiple', 'data-placeholder'=>'- เลือกมาตรฐาน -']) !!}
        {!! $errors->first('different_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('reason') ? 'has-error' : ''}}">
    {!! Form::label('reason', 'เหตุผลความจำเป็นที่ต้องนำเข้า', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('reason', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows'=>4] : ['class' => 'form-control', 'rows'=>4]) !!}
        {!! $errors->first('reason', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{{-- <div class="form-group {{ $errors->has('foreign_standard_ref') ? 'has-error' : ''}}">
    {!! Form::label('foreign_standard_ref', 'เพื่อให้เป็นไปตามมาตรฐาน', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('foreign_standard_ref', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('foreign_standard_ref', '<p class="help-block">:message</p>') !!}
    </div>
</div> --}}
<div class="form-group {{ $errors->has('country_ref') ? 'has-error' : ''}}">
    {!! Form::label('country_ref', 'แหล่งที่มา', ['class' => 'col-md-4 control-label required']) !!}
    <div class="col-md-6">
        {!! Form::select('country_ref',
            App\Models\Basic\Country::pluck('title', 'id')->all(),
            null,
            ['class' => 'select2 form-control', 'required' => 'required', 'placeholder'=>'- เลือกประเทศ -'])
        !!}
        {!! $errors->first('country_ref', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('start_import_date') ? 'has-error' : ''}}">
    {!! Form::label('start_import_date', 'แผนการนำเข้า', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-3">
        <div class="input-group">
        {!! Form::text('start_import_date', null, ('' == 'required') ? ['class' => 'form-control datepicker', 'required' => 'required', 'placeholder'=>'dd/mm/yyyy'] : ['class' => 'form-control datepicker', 'placeholder'=>'dd/mm/yyyy']) !!}
            <span class="input-group-addon"><i class="icon-calender"></i></span>
        </div>
        {!! $errors->first('start_import_date', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('end_import_date', 'ถึง', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-3">
        <div class="input-group">
        {!! Form::text('end_import_date', null, ('' == 'required') ? ['class' => 'form-control datepicker', 'required' => 'required', 'placeholder'=>'dd/mm/yyyy'] : ['class' => 'form-control datepicker', 'placeholder'=>'dd/mm/yyyy']) !!}
            <span class="input-group-addon"><i class="icon-calender"></i></span>
        </div>
            {!! $errors->first('end_import_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
    {!! Form::label('start_date', 'แผนการผลิต', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-3">
        <div class="input-group">
        {!! Form::text('start_date', null, ('' == 'required') ? ['class' => 'form-control datepicker', 'required' => 'required', 'placeholder'=>'dd/mm/yyyy'] : ['class' => 'form-control datepicker', 'placeholder'=>'dd/mm/yyyy']) !!}
            <span class="input-group-addon"><i class="icon-calender"></i></span>
        </div>
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('end_date', 'ถึง', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-3">
        <div class="input-group">
        {!! Form::text('end_date', null, ('' == 'required') ? ['class' => 'form-control datepicker', 'required' => 'required', 'placeholder'=>'dd/mm/yyyy'] : ['class' => 'form-control datepicker', 'placeholder'=>'dd/mm/yyyy']) !!}
            <span class="input-group-addon"><i class="icon-calender"></i></span>
        </div>
            {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('start_export_date') ? 'has-error' : ''}}">
    {!! Form::label('start_export_date', 'แผนการส่งออก', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-3">
        <div class="input-group">
        {!! Form::text('start_export_date', null, ('' == 'required') ? ['class' => 'form-control datepicker', 'required' => 'required', 'placeholder'=>'dd/mm/yyyy'] : ['class' => 'form-control datepicker', 'placeholder'=>'dd/mm/yyyy']) !!}
            <span class="input-group-addon"><i class="icon-calender"></i></span>
        </div>
        {!! $errors->first('start_export_date', '<p class="help-block">:message</p>') !!}
    </div>
    {!! Form::label('end_export_date', 'ถึง', ['class' => 'col-md-1 control-label']) !!}
    <div class="col-md-3">
        <div class="input-group">
        {!! Form::text('end_export_date', null, ('' == 'required') ? ['class' => 'form-control datepicker', 'required' => 'required', 'placeholder'=>'dd/mm/yyyy'] : ['class' => 'form-control datepicker', 'placeholder'=>'dd/mm/yyyy']) !!}
            <span class="input-group-addon"><i class="icon-calender"></i></span>
        </div>
            {!! $errors->first('end_export_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{-- <div class="form-group {{ $errors->has('country_export') ? 'has-error' : ''}}">
    {!! Form::label('country_export', 'ประเทศที่ส่งออกผลิตภัณฑ์', ['class' => 'col-md-4 control-label required']) !!}
    <div class="col-md-6">
        {!! Form::select('country_export',
            App\Models\Basic\Country::pluck('title', 'id')->all(),
            null,
            ['class' => 'select2 form-control', 'required' => 'required', 'placeholder'=>'- เลือกประเทศ -'])
        !!}
        {!! $errors->first('country_export', '<p class="help-block">:message</p>') !!}
    </div>
</div> --}}

<div class="form-group {{ $errors->has('country_export') ? 'has-error' : ''}}">
    {!! Form::label('country_export', 'ประเทศที่ส่งออกผลิตภัณฑ์', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('country_export[]',
        App\Models\Basic\Country::pluck('title', 'id')->all(),
        null,
        ('' == 'required') ? ['class' => 'select2 select2-multiple', 'required' => 'required', 'multiple'=>'multiple', 'data-placeholder'=>'- เลือกประเทศ -'] : ['class' => 'select2 select2-multiple', 'multiple'=>'multiple', 'data-placeholder'=>'- เลือกประเทศ -']) !!}
        {!! $errors->first('country_export', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="row">

    <div class="white-box">
        <fieldset>

            <div class="col-md-8">
                <div class="form-group {{ $errors->has('made_factory_chk') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_chk', 'สถานที่ผลิตผลิตภัณฑ์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::checkbox('made_factory_chk', 1, null, ['class' => 'check']) !!}
                        &nbsp;ใช้ที่เดียวกับที่จดทะเบียน
                        {!! $errors->first('made_factory_chk', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>

            <div class="col-md-12">
                <div class="form-group {{ $errors->has('made_factory_name') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_name', 'โรงงานชื่อ', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('made_factory_addr_no') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_addr_no', 'ตั้งอยู่เลขที่', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_addr_no', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_addr_no', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('made_factory_nicom') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_nicom', 'นิคมอุตสาหกรรม (ถ้ามี)', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        {!! Form::text('made_factory_nicom', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_nicom', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_soi') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_soi', 'ตรอก/ซอย', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_soi', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_soi', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_road') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_road', 'ถนน', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_road', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_road', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_moo') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_moo', 'หมู่ที่', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_moo', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_moo', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_subdistrict') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_subdistrict', 'ตำบล/แขวง', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_subdistrict', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_subdistrict', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_district') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_district', 'อำเภอ/เขต', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_district', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_district', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_province') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_province', 'จังหวัด', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_province', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_province', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_zipcode') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_zipcode', 'รหัสไปรษณีย์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_zipcode', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_zipcode', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_tel') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_tel', 'โทรศัพท์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_tel', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_tel', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('made_factory_fax') ? 'has-error' : ''}}">
                    {!! Form::label('made_factory_fax', 'โทรสาร', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('made_factory_fax', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('made_factory_fax', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
</div>

<div class="row">
    <div class="white-box">
        <fieldset>

            <div class="col-md-8">
                <div class="form-group {{ $errors->has('store_factory_chk') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_chk', 'สถานที่เก็บผลิตภัณฑ์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::checkbox('store_factory_chk', '1', null, ['class' => 'check']) !!}
                        &nbsp;ใช้ที่เดียวกับที่ทำผลิตภัณฑ์
                        {!! $errors->first('store_factory_chk', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4"></div>

            <div class="col-md-12">
                <div class="form-group {{ $errors->has('store_factory_name') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_name', 'โรงงานชื่อ', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('store_factory_addr_no') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_addr_no', 'ตั้งอยู่เลขที่', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_addr_no', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_addr_no', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('store_factory_nicom') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_nicom', 'นิคมอุตสาหกรรม (ถ้ามี)', ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        {!! Form::text('store_factory_nicom', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_nicom', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_soi') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_soi', 'ตรอก/ซอย', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_soi', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_soi', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_road') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_road', 'ถนน', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_road', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_road', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_moo') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_moo', 'หมู่ที่', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_moo', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_moo', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_subdistrict') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_subdistrict', 'ตำบล/แขวง', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_subdistrict', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_subdistrict', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_district') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_district', 'อำเภอ/เขต', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_district', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_district', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_province') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_province', 'จังหวัด', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_province', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_province', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_zipcode') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_zipcode', 'รหัสไปรษณีย์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_zipcode', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_zipcode', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_tel') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_tel', 'โทรศัพท์', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_tel', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_tel', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store_factory_fax') ? 'has-error' : ''}}">
                    {!! Form::label('store_factory_fax', 'โทรสาร', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::text('store_factory_fax', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        {!! $errors->first('store_factory_fax', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

</div>



<div class="row">
    <div class="white-box">
        <fieldset>
            <legend>พร้อมแนบเอกสาร ดังนี้</legend>
            <div class="form-group {{ $errors->has('attach_import_plan') ? 'has-error' : ''}}">
                {!! Form::label('attach_import_plan', 'แผนการนำเข้า', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_import_plan_file_name', $attach_import_plan->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_import_plan', ['required' => true,'class'=>'check_max_size_file']) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                      @if($attach_import_plan->file_name!='' && HP::checkFileStorage($attach_path.$attach_import_plan->file_name))
                          <a href="{{ HP::getFileStorage($attach_path.$attach_import_plan->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                          <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                          </button>
                      @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('attach_product_plan') ? 'has-error' : ''}}">
                {!! Form::label('attach_product_plan', 'แผนการผลิต', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_product_plan_file_name', $attach_product_plan->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_product_plan', ['required' => true,'class'=>'check_max_size_file']) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                      @if($attach_product_plan->file_name!='' && HP::checkFileStorage($attach_path.$attach_product_plan->file_name))
                          <a href="{{ HP::getFileStorage($attach_path.$attach_product_plan->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                          <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                          </button>
                      @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('attach_export_plan') ? 'has-error' : ''}}">
                {!! Form::label('attach_export_plan', 'แผนการส่งออก', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_export_plan_file_name', $attach_export_plan->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_export_plan', ['required' => true,'class'=>'check_max_size_file']) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                      @if($attach_export_plan->file_name!='' && HP::checkFileStorage($attach_path.$attach_export_plan->file_name))
                          <a href="{{ HP::getFileStorage($attach_path.$attach_export_plan->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                          <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                          </button>
                      @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('attach_purchase_order') ? 'has-error' : ''}}">
                {!! Form::label('attach_purchase_order', 'คำสั่งซื้อจากต่างประเทศ/สำเนาหนังสือสัญญาว่าจ้าง/ข้อตกลงการว่าจ้าง', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_purchase_order_file_name', $attach_purchase_order->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_purchase_order', ['required' => true,'class'=>'check_max_size_file']) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                        @if($attach_purchase_order->file_name!='' && HP::checkFileStorage($attach_path.$attach_purchase_order->file_name))
                            <a href="{{ HP::getFileStorage($attach_path.$attach_purchase_order->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                        <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('attach_factory_license') ? 'has-error' : ''}}">
                {!! Form::label('attach_factory_license', 'สำเนาใบอนุญาตประกอบกิจการ (ร.ง.4 กนอ. ฯลฯ)', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_factory_license_file_name', $attach_factory_license->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_factory_license', ['required' => true,'class'=>'check_max_size_file']) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                        @if($attach_factory_license->file_name!='' && HP::checkFileStorage($attach_path.$attach_factory_license->file_name))
                            <a href="{{ HP::getFileStorage($attach_path.$attach_factory_license->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                        <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('attach_standard_to_made') ? 'has-error' : ''}}">
                {!! Form::label('attach_standard_to_made', 'แบบที่ใช้ในการผลิตที่แสดงให้เห็นถึงความเกี่ยวข้องระหว่างผลิตภัณฑ์ที่นำเข้าผลิตภัณฑ์เพื่อส่งออก', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_standard_to_made_file_name', $attach_standard_to_made->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_standard_to_made', ['required' => true,'class'=>'check_max_size_file']) !!}
                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                        @if($attach_standard_to_made->file_name!='' && HP::checkFileStorage($attach_path.$attach_standard_to_made->file_name))
                            <a href="{{ HP::getFileStorage($attach_path.$attach_standard_to_made->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                        <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <div class="form-group {{ $errors->has('attach_difference_standard') ? 'has-error' : ''}}">
                {!! Form::label('attach_difference_standard', 'เอกสารแสดงข้อแตกต่างของมาตรฐานต่างประเทศที่ขอทำกับมาตรฐานของไทย', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_difference_standard_file_name', $attach_difference_standard->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_difference_standard', ['required' => true]) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                        @if($attach_difference_standard->file_name!='' && HP::checkFileStorage($attach_path.$attach_difference_standard->file_name))
                            <a href="{{ HP::getFileStorage($attach_path.$attach_difference_standard->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                        <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div> --}}

            <div class="form-group {{ $errors->has('attach_permission_letter') ? 'has-error' : ''}}">
                {!! Form::label('attach_permission_letter', 'หนังสือขออนุญาต', ['class' => 'col-md-4 control-label required']) !!}
                {!! Form::hidden('attach_permission_letter_file_name', $attach_permission_letter->file_name); !!}
                <div class="col-md-8">
                    <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            {!! Form::file('attach_permission_letter', ['required' => true,'class'=>'check_max_size_file']) !!}
                          </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    <div class="col-md-4">
                        @if($attach_permission_letter->file_name!='' && HP::checkFileStorage($attach_path.$attach_permission_letter->file_name))
                            <a href="{{ HP::getFileStorage($attach_path.$attach_permission_letter->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                        <button class="btn btn-danger btn-sm attach-remove" type="button">
                            <i class="icon-close"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('attach_other', 'เอกสารอื่นๆ (ถ้ามี)', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-8">
                    <button type="button" class="btn btn-sm btn-success" id="add-attach">
                        <i class="icon-plus"></i>&nbsp;เพิ่ม
                    </button>
                </div>
            </div>

            <div id="other_attach_box">
                @foreach ($attachs as $key => $attach)
                <div class="form-group other_attach_item">
                    <div class="col-md-4">
                        {!! Form::hidden('attach_filenames[]', $attach->file_name); !!}
                        {!! Form::text('attach_notes[]', $attach->file_note, ['class' => 'form-control', 'placeholder' => 'ระบุชื่อเอกสาร']) !!}
                    </div>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new input-group pull-left col-md-10" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                              <span class="fileinput-new">เลือกไฟล์</span>
                              <span class="fileinput-exists">เปลี่ยน</span>
                                  {{-- {!! Form::file('attach_other[]', null) !!} --}}
                                  <input name="attach_other[]"  type="file"   class="check_max_size_file">
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if($attach->file_name!='' && HP::checkFileStorage($attach_path.$attach->file_name))
                            <a href="{{ HP::getFileStorage($attach_path.$attach->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                            <button class="btn btn-danger btn-sm remove-attach_other" type="button">
                                <i class="icon-close"></i>
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
                {!! Form::label('remark', 'หมายเหตุ', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::textarea('remark', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows'=>4] : ['class' => 'form-control', 'rows'=>4]) !!}
                    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

             <div class="form-group {{ $errors->has('applicant_name') ? 'has-error' : ''}}">
                {!! Form::label('applicant_name', 'ชื่อผู้ยื่น', ['class' => 'col-md-4 control-label required']) !!}
                <div class="col-md-6">
                    {!! Form::text('applicant_name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('applicant_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('applicant_position') ? 'has-error' : ''}}">
                {!! Form::label('applicant_position', 'ตำแหน่ง', ['class' => 'col-md-4 control-label required']) !!}
                <div class="col-md-6">
                    {!! Form::text('applicant_position', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('applicant_position', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

        </fieldset>
    </div>
</div>

<div class="row">
    <div class="white-box center">
        <fieldset>
            <p class="p_condition">
                <u>21 ตรี</u>
            </p>
            <p class="p_condition">
                ประกาศคณะกรรมการมาตรฐานผลิตภัณฑ์อุตสาหกรรม เรื่อง หลักเกณฑ์และเงื่อนไขในการนำ<br>
                ผลิตภัณฑ์อุตสาหกรรมเข้ามาในราชอาณาจักรเพื่อผลิต ผสม ประกอบ บรรจุ หรือดำเนินการด้วยวิธีอื่นใดกับ<br>
                ผลิตภัณฑ์อุตสาหกรรมนั้นแล้วส่งออกไปนอกราชอาณาจักรทั้งหมด<br>
                ประกาศ ณ วันที่ 6 สิงหาคม 2562</p>
            <p class="p_condition_detail">
                1. ต้องนำผลิตภัณฑ์อุตสาหกรรมเข้ามาในราชอาณาจักร เพื่อผลิต ผสม ประกอบ บรรจุ หรือดำเนินการด้วยวิธีอื่นใด<br>
                ตามที่ได้แจ้งไว้ต่อสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมเท่านั้น ห้ามนำไปจำหน่ายเป็นการทั่วไป
            </p>
            <p class="p_condition_detail">
                2. ต้องแจ้งให้สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมทราบก่อนการนำเข้าทุกครั้ง
            </p>
            <p class="p_condition_detail">
            3. ผลิตภัณฑ์อุตสาหกรรมที่นำเข้าตามข้อ 1 ต้องแสดงข้อความชี้บ่งว่าเป็นผลิตภัณฑ์อุตสาหกรรมที่ได้รับแจ้งตามมาตรา 21 ตรี<br>
            และต้องแยกเก็บมิให้ปะปนกับผลิตภัณฑ์อุตสาหกรรมที่ได้รับใบอนุญาตหรือการอนุญาตอื่นที่ออกโดยสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม

            </p>
            <p class="p_condition_detail">
            4. เมื่อผลิต ผสม ประกอบ หรือดำเนินการด้วยวิธีอื่นใดแล้ว ต้องส่งออกไปประเทศตามที่ได้แจ้งไว้เท่านั้น <br>
            และให้ผู้นำเข้าต้องรายงานปริมาณการผลิต ผสม ประกอบ บรรจุ หรือดำเนินการด้วยวิธีอื่นใด รายงานปริมาณการส่งออก<br>
            พร้อมส่งสำเนาเอกสารหลักฐานใบขนสินค้าขาออก ซึ่งต้องระบุจำนวนผลิตภัณฑ์อุตสาหกรรมที่ส่งออก <br>
            รายงานปริมาณคงเหลือของผลิตภัณฑ์อุตสาหกรรมที่ได้รับแจ้งการนำเข้า ตลอดจนการดำเนินการจัดการกับสิ่งที่คงเหลือ (ถ้ามี)<br>
            ให้สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมทราบภายในสามสิบวันนับแต่วันที่ส่งออก

            </p>
            <p class="p_condition" style="margin-top: 40px">
            ทั้งนี้ การไม่ปฏิบัติตามหลักเกณฑ์และเงื่อนไขข้างต้น ต้องระวางโทษจำคุกไม่เกินสองปี หรือปรับไม่เกิน<br>
            สองล้านบาท หรือทั้งจำทั้งปรับตามมาตรา 48 ทวิ แห่งพระราชบัญญัติมาตรฐานผลิตภัณฑ์อุตสาหกรรม<br>
            พ.ศ. 2511 และที่แก้ไขเพิ่มเติม
            </p>

            <div class="col-md-10" style="margin-top: 40px">
                <div class="form-group {{ $errors->has('accept_chk') ? 'has-error' : ''}}">
                    {!! Form::label('accept_chk', '&nbsp;', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::checkbox('accept_chk', '1', null, ['class' => 'check']) !!}
                        &nbsp;<u>รับทราบและยินยอมยินยอมปฏิบัติตามหลักเกณฑ์และเงื่อนไขข้างต้น</u>
                        {!! $errors->first('accept_chk', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>


        </fieldset>
    </div>
</div>
{{--<div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('state', 'สถานะ', ['class' => 'col-md-4 control-label']) !!}--}}
    {{--<div class="col-md-6">--}}
        {{--<label>{!! Form::radio('state', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} ส่งข้อมูลให้สมอ.</label>--}}
        {{--<label>{!! Form::radio('state', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} ฉบับร่าง</label>--}}

        {{--{!! $errors->first('state', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}

@if(isset($applicant_21ter) && $applicant_21ter->state=='3')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> ผลการพิจารณา </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <div class="form-horizontal" role="form">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">สถานะ :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"> {{ HP::StateApplicants()[$applicant_21ter->state] }} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">ความคิดเห็นเพิ่มเติม :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"> {!! nl2br($applicant_21ter->remake_officer_export) !!} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">ผู้พิจารณา :</label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"> {!! App\Models\Basic\Staff::find($applicant_21ter->officer_export)->FullName !!} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">

        <button class="btn btn-primary" type="submit" {{ $disabled_or_not }}>
            <i class="fa fa-paper-plane"></i> ยื่นคำขอ
        </button>
        @can('view-'.str_slug('inform_calibrate'))
            <a class="btn btn-default" href="{{url('/esurv/applicant_21ter')}}">
                <i class="fa fa-rotate-left"></i> ยกเลิก
            </a>
        @endcan
    </div>
</div>

@push('js')
    <!-- icheck -->
    <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>

    <!-- input calendar thai -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <!-- thai extension -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <!-- input file -->
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>

    <script>
        jQuery(document).ready(function () {
            check_max_size_file();
            //กรณีแก้ไข
            @if(isset($applicant_21ter))

              $('input[type="file"]').removeAttr('required');
              $('.attach-remove').click(function(){
                $(this).parent().parent().find('input[type="file"]').prop('required', true);
              });

            @endif

            ResetTableNumber();

            //Edit Last
            var last_button = $(other_attach_box).children(':not(:first)').find('button');
            $(last_button).removeClass('btn-success');
            $(last_button).removeClass('add-attach');
            $(last_button).addClass('btn-danger remove-attach_other');
            $(last_button).html('<i class="icon-close"></i>');

            // Date Picker Thai
            jQuery('.datepicker').datepicker({
                autoclose: true,
                toggleActive: true,
                todayHighlight: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });

            //เพิ่มแถว
            $('#plus-row').click(function(event) {

                $('#table-body').children('tr:first').clone().appendTo('#table-body');
                ResetTableNumber();

                //รีเซตค่า id
                $('#table-body').children('tr:last').find('input[type="hidden"]').val('');

                //แถวสุดท้ายที่เพิ่มมา
                var last_row = $('#table-body').children('tr:last');

                //Clear ค่า
                last_row.find('input').val('');

                //Select2 Destroy
                last_row.find('select').prev().remove();
                last_row.find('select').removeAttr('style');
                last_row.find('select').select2();
                check_max_size_file();
            });

            //ลบแถว
            $('body').on('click', '.remove-row', function(){
                $(this).parent().parent().remove();
                ResetTableNumber();
            });

            quantityAll();

            $('body').on('keyup change blur', '.quantity_detail', function(){
                // var totalAll = 0;
                // var $quantityVal = $('.quantity_detail');
                //     $.each($quantityVal,function (index,value) {
                //         totalAll += parseFloat($(value).val());
                //     });
                // $('#total_quantity').val(totalAll);
                quantityAll();
            });

            //เพิ่มไฟล์แนบ
            $('body').on('click', '#add-attach', function() {

                var first = $('#other_attach_box').children(':first');
                var other_attach_box = $('#other_attach_box');

                $(first).clone().appendTo(other_attach_box); //Clone Element

                //Edit Last
                var last_button = $(other_attach_box).children(':not(:first)').find('button');
                $(last_button).removeClass('btn-success');
                $(last_button).removeClass('add-attach');
                $(last_button).addClass('btn-danger remove-attach_other');
                $(last_button).html('<i class="icon-close"></i>');

                var last_file = $(other_attach_box).children(':last').find('.fileinput');
                $(last_file).find('input').val('');
                $(last_file).find('a.fileinput-exists').click();
                $(last_file).find('a.view-attach').remove();

                //Clear Text
                $(other_attach_box).children(':last').find('input[type="text"]').val('');
                $(other_attach_box).children(':last').find('.view-attach').remove();
                $(other_attach_box).children(':last').find('input[name*="attach_filenames"]').val('');

                ShowHideRemoveBtn();
                check_max_size_file();
            });

            //ลบไฟล์แนบ อื่นๆ
            $('body').on('click', '.remove-attach_other', function() {
              $(this).parent().parent().remove();
              ShowHideRemoveBtn();
            });

            $('body').on('click', '.attach-remove', function() {
                $(this).parent().parent().parent().find('input[type=hidden]').val('');
                $(this).parent().remove();
            });

            //ใช้ที่เดียวกับที่จดทะเบียน
            $('#made_factory_chk').on('ifChanged', function (event) {

              $(event.target).trigger('change');

              if($(this).prop('checked')){//ถ้าติ๊ก
                $('#made_factory_name').val('{{ auth()->user()->trader_operater_name }}');
                $('#made_factory_addr_no').val('{{ auth()->user()->trader_address }}');
                $('#made_factory_soi').val('{{ auth()->user()->trader_address_soi }}');
                $('#made_factory_road').val('{{ auth()->user()->trader_address_road }}');
                $('#made_factory_moo').val('{{ auth()->user()->trader_address_moo }}');
                $('#made_factory_subdistrict').val('{{ auth()->user()->trader_address_tumbol }}');
                $('#made_factory_district').val('{{ auth()->user()->trader_address_amphur }}');
                $('#made_factory_province').val('{{ auth()->user()->trader_provinceID }}');
                $('#made_factory_zipcode').val('{{ auth()->user()->trader_address_poscode }}');
                $('#made_factory_tel').val('{{ auth()->user()->trader_phone }}');
                $('#made_factory_fax').val('{{ auth()->user()->trader_fax }}');
              } else {
                $('#made_factory_name').val('');
                $('#made_factory_addr_no').val('');
                $('#made_factory_soi').val('');
                $('#made_factory_road').val('');
                $('#made_factory_moo').val('');
                $('#made_factory_subdistrict').val('');
                $('#made_factory_district').val('');
                $('#made_factory_province').val('');
                $('#made_factory_zipcode').val('');
                $('#made_factory_tel').val('');
                $('#made_factory_fax').val('');
              }

            });

            //ใช้ที่เดียวกับที่ผลิตภัณฑ์
            $('#store_factory_chk').on('ifChanged', function (event) {

              $(event.target).trigger('change');

              if($(this).prop('checked')){//ถ้าติ๊ก
                $('#store_factory_name').val( $('#made_factory_name').val() );
                $('#store_factory_addr_no').val( $('#made_factory_addr_no').val() );
                $('#store_factory_nicom').val( $('#made_factory_nicom').val() );
                $('#store_factory_soi').val( $('#made_factory_soi').val() );
                $('#store_factory_road').val( $('#made_factory_road').val() );
                $('#store_factory_moo').val( $('#made_factory_moo').val() );
                $('#store_factory_subdistrict').val( $('#made_factory_subdistrict').val() );
                $('#store_factory_district').val( $('#made_factory_district').val() );
                $('#store_factory_province').val( $('#made_factory_province').val() );
                $('#store_factory_zipcode').val( $('#made_factory_zipcode').val() );
                $('#store_factory_tel').val( $('#made_factory_tel').val() );
                $('#store_factory_fax').val( $('#made_factory_fax').val() );
              }

            });

            ShowHideRemoveBtn();

            //ยอมรับเงื่อนไข
            $('#accept_chk').on('ifChanged', function (event) {
              $(event.target).trigger('change');
                if($(this).prop('checked')){//ถ้าติ๊ก
                    $('button[type="submit"]').prop('disabled',false);
                }else{

                    $('button[type="submit"]').prop('disabled',true);
                }
            });

        });

        //รีเซตเลขลำดับ รายละเอียดผลิตภัณฑ์อุตสาหกรรม
        function ResetTableNumber(){
            var rows = $('#table-body').children(); //แถวทั้งหมด
            (rows.length==1)?$('.remove-row').hide():$('.remove-row').show();
            rows.each(function(index, el) {
                $(el).children().first().html(index+1);
                $(el).children().find('select[name*="scholarship_name_id"]').attr('name','frame_detail[scholarship_name_id]['+index+'][]');
            });
        }

        //ซ่อนแสดงปุ่มลบไฟล์แนบอื่นๆ
        function ShowHideRemoveBtn(){

          if($('#other_attach_box').children().length>1){
            $('.remove-attach_other').show();
          }else{
            $('.remove-attach_other').hide();
          }

        }

        function quantityAll(){
            var totalAll = 0;
            var $quantityVal = $('.quantity_detail');
            $.each($quantityVal,function (index,value) {
                totalAll += parseFloat($(value).val());
            });
            if(isNaN(totalAll)) {
                $('#total_quantity').val('0.00');
            } else {
                $('#total_quantity').val(totalAll.toFixed(2));
            }
        }

    </script>
@endpush
