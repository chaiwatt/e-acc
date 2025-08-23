{{-- StandardOffersController --}}
@extends('layouts.master')

@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .img{
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .label-filter{
            margin-top: 7px;
        }
        /*
          Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
          */
        @media
        only screen
        and (max-width: 760px), (min-device-width: 768px)
        and (max-device-width: 1024px)  {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin: 0 0 1rem 0;
            }

            tr:nth-child(odd) {
                background: #eee;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                /* Now like a table header */
                /*position: absolute;*/
                /* Top/left values mimic padding */
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }

            /*
            Label the data
        You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
            */
            td:nth-of-type(1):before { content: "No.:"; }
            td:nth-of-type(2):before { content: "เลือก:"; }
            td:nth-of-type(3):before { content: "ชื่อ-สกุล:"; }
            td:nth-of-type(4):before { content: "เลขประจำตัวประชาชน:"; }
            td:nth-of-type(5):before { content: "หน่วยงาน:"; }
            td:nth-of-type(6):before { content: "สาขา:"; }
            td:nth-of-type(7):before { content: "ประเภทของคณะกรรมการ:"; }
            td:nth-of-type(8):before { content: "ผู้สร้าง:"; }
            td:nth-of-type(9):before { content: "วันที่สร้าง:"; }
            td:nth-of-type(10):before { content: "สถานะ:"; }
            td:nth-of-type(11):before { content: "จัดการ:"; }

        }
    </style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <h3 class="box-title pull-left">เสนอความเห็นการกำหนดมาตรฐานการตรวจสอบและรับรอง #</h3>

                    <div class="pull-right">

                        @if( HP::CheckPermission('add-'.str_slug('applicantcbs')))
                            <a class="btn btn-info btn-sm waves-effect waves-light" href="{{url('tisi/standard-offers')}}">
                                <span class="btn-label"><i class="icon-arrow-left-circle"></i></span><b>กลับ</b>
                            </a>
                        @endif


                    </div>

                    <div class="clearfix"></div>
                    <hr>

                  
                    
                    {!! Form::open(['url' => '/tisi/standard-offers/store',  'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
                        {{-- @include ('tisi.standard-offers.form') --}}
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


            {{-- <div class="form-group required {{ $errors->has('province_id') ? 'has-error' : ''}}">
                {!! Form::label('province_id', 'จังหวัด', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::select('province_id', App\Models\Basic\Province::pluck('PROVINCE_NAME', 'PROVINCE_ID'), null, ['class' => 'form-control', 'placeholder'=>'- เลือกจังหวัด -', 'required' => 'required']) !!}
                    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}

            <div class="form-group required {{ $errors->has('province_id') ? 'has-error' : ''}}">
                <label for="province_id" class="control-label">จังหวัด</label>
                <div>
                    <select name="province_id" id="province_id" class="form-control" required>
                        <option value="" selected="selected">- เลือกจังหวัด -</option>
                        @foreach(App\Models\Basic\Province::pluck('PROVINCE_NAME', 'PROVINCE_ID') as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('province_id'))
                        <p class="help-block">{{ $errors->first('province_id') }}</p>
                    @endif
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

            <div class="form-group required{{ $errors->has('mobile') ? 'has-error' : ''}}">
                {!! Form::label('mobile', 'มือถือ', ['class' => 'control-label']) !!}
                <div>
                    {{-- {!! Form::text('mobile', null, ['class' => 'form-control']) !!} --}}
                     {!! Form::text('mobile', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
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

้<hr>

<div class="container">
    <h3 class="mb-4">รายละเอียดมาตรฐาน</h3>
    <div class="row">
        <!-- คอลัมน์ที่ 1 (ครึ่งหนึ่งของหน้าจอสำหรับขนาดกลางขึ้นไป) -->
        <div class="col-md-6">
            {{-- <div class="form-group required {{ $errors->has('title') ? 'has-error' : ''}}">
                <!-- Label ไม่มี col-md-X -->
                <label for="title" class="control-label">
                    ชื่อเรื่อง : 
                </label>
                <div>
                    <!-- Div ครอบ input ไม่มี col-md-X -->
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $yourModelInstance->title ?? '') }}" required>
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}

{{--             
            <div class="form-group{{ $errors->has('title') ? ' has-error' : ''}}" hidden>
                {!! Form::label('title', 'ชื่อเรื่อง (Eng)'.' : ', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::text('title', 'temp name', ['class' => 'form-control']) !!}
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}

            {{-- {!! Form::select('province_id', App\Models\Basic\Province::pluck('PROVINCE_NAME', 'PROVINCE_ID'), null, ['class' => 'form-control', 'placeholder'=>'- เลือกจังหวัด -', 'required' => 'required']) !!} --}}

            <div class="form-group required {{ $errors->has('std_type') ? ' has-error' : '' }}">
                <label for="std_type" class="control-label">ประเภทมาตรฐาน :</label>
                <div>
                    <select name="std_type" id="std_type" class="form-control" required>
                        <option value="" selected="selected">- เลือกประเภทมาตรฐาน -</option>
                        @foreach(App\Models\Bcertify\Standardtype::orderbyRaw('CONVERT(offertype USING tis620)')->pluck('offertype', 'id') as $id => $offertype)
                            <option value="{{ $id }}">{{ $offertype }}</option>
                        @endforeach

                    </select>
                    
                    @if ($errors->has('std_type'))
                        <p class="help-block">{{ $errors->first('std_type') }}</p>
                    @endif
                </div>
            </div>

            <div class="form-group required{{ $errors->has('std_type') ? ' has-error' : '' }}">
                <label for="proposer_type" class="control-label">ประเภทข้อเสนอ (Proposer) :</label>
                <div>
                    <select name="proposer_type" id="proposer_type" class="form-control" required>
                        <option value="">-- กรุณาเลือก --</option>
                        <option value="sdo_advanced">SDO ขั้นสูง</option>
                        <option value="sdo_basic_or_non_sdo">SDO ขั้นต้น หรือหน่วยงานที่ไม่ใช่ SDO</option>
                    </select>
                </div>
                @if ($errors->has('proposer_type'))
                    <p class="help-block">{{ $errors->first('proposer_type') }}</p>
                @endif
            </div>

  

            <div class="form-group required{{ $errors->has('stakeholders') ? 'has-error' : ''}}">
                <label for="stakeholders" class="control-label">ผู้มีส่วนได้เสียที่เกี่ยวข้อง :</label>
                <div>
                    <textarea name="stakeholders" id="stakeholders" class="form-control" required></textarea>
                    @if ($errors->has('stakeholders'))
                        <p class="help-block">{{ $errors->first('stakeholders') }}</p>
                    @endif
                </div>
            </div>

        <div class="form-group {{ $errors->has('iso_number') ? 'has-error' : ''}}">
            <label for="iso_number" class="control-label">เลขมาตรฐาน ISO :</label>
            <div>
                <input class="form-control" placeholder="เลขมาตรฐาน ISO" name="iso_number" type="text" id="iso_number">
                @if ($errors->has('iso_number'))
                    <p class="help-block">{{ $errors->first('iso_number') }}</p>
                @endif
            </div>
        </div>

            <div class="form-group required{{ $errors->has('standard_name_en') ? 'has-error' : ''}}">
                <label for="standard_name_en" class="control-label">ชื่อมาตรฐาน(Eng) :</label>
                <div>
                    <input class="form-control" placeholder="ชื่อมาตรฐาน" name="standard_name_en" type="text" id="standard_name_en" required>
                    @if ($errors->has('standard_name_en'))
                        <p class="help-block">{{ $errors->first('standard_name_en') }}</p>
                    @endif
                </div>
            </div>



            
        </div>
         <div class="col-md-6">


            {{-- <div class="form-group required{{ $errors->has('objectve') ? 'has-error' : ''}}">
                {!! Html::decode(Form::label('objectve', 'จุดประสงค์และเหตุผล'.' : ', ['class' => 'control-label'])) !!}
                <div>
                    {!! Form::text('objectve', null, [ 'class' => 'form-control', 'required'=>true]) !!}
                    {!! $errors->first('objectve', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}



            {{-- <div class="form-group required{{ $errors->has('title_eng') ? 'has-error' : ''}}">
                {!! Form::label('title_eng', 'ชื่อเรื่อง (Eng)'.' : ', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::text('title_eng', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                    {!! $errors->first('title_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}

            {{-- <div class="form-group{{ $errors->has('title_eng') ? ' has-error' : ''}}" hidden>
                {!! Form::label('title_eng', 'ชื่อเรื่อง (Eng)'.' : ', ['class' => 'control-label']) !!}
                <div>
                    {!! Form::text('title_eng', 'temp name', ['class' => 'form-control']) !!}
                    {!! $errors->first('title_eng', '<p class="help-block">:message</p>') !!}
                </div>
            </div> --}}
         </div>


        <!-- คอลัมน์ที่ 2 (ครึ่งหนึ่งของหน้าจอสำหรับขนาดกลางขึ้นไป) -->
        <div class="col-md-6">


            <div class="form-group required{{ $errors->has('objectve') ? ' has-error' : '' }}">
                <label for="objectve" class="control-label">จุดประสงค์และเหตุผลในการจัดทำ :</label>
                <div>
                    <select name="objectve" id="objectve" class="form-control" required>
                        <option value="">- เลือกจุดประสงค์ -</option>
                        <option value="first_creation">จัดทำครั้งแรก</option>
                        <option value="standard_revision">ปรับปรุงมาตรฐาน</option>
                    </select>
                </div>
                
                @if ($errors->has('objectve'))
                    <p class="help-block">{{ $errors->first('objectve') }}</p>
                @endif
            </div>


            <div class="form-group {{ $errors->has('scope') ? 'has-error' : '' }}">
                <label for="scope" class="control-label">ขอบข่าย :</label>
                <div>
                    <input class="form-control" name="scope" type="text" id="scope">
                    @if ($errors->has('scope'))
                        <p class="help-block">{{ $errors->first('scope') }}</p>
                    @endif
                </div>
            </div>

            <div class="form-group required{{ $errors->has('meeting_count') ? ' has-error' : '' }}">
                <label for="meeting_count" class="control-label" style="text-align: left">จำนวนการประชุมเชิงปฏิบัติการที่คาดว่าจะจัดและช่วงเวลาที่คาดว่าจะจัดการประชุมเชิงปฏิบัติการ (เฉพาะกรณีจัดทำข้อตกลงร่วม) :</label>
                <div>
                    <input class="form-control" name="meeting_count" type="text" id="meeting_count" required>
                </div>
                
                @if ($errors->has('meeting_count'))
                    <p class="help-block">{{ $errors->first('meeting_count') }}</p>
                @endif
            </div>

            <div class="form-group required{{ $errors->has('standard_name') ? 'has-error' : ''}}">
                <label for="standard_name" class="control-label">ชื่อมาตรฐาน (ไทย):</label>
                <div>
                    <input class="form-control" placeholder="ชื่อมาตรฐาน" name="standard_name" type="text" id="standard_name" required>
                    @if ($errors->has('standard_name'))
                        <p class="help-block">{{ $errors->first('standard_name') }}</p>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('national_strategy') ? 'has-error' : ''}}">
                <label for="national_strategy" class="control-label" style="text-align: left">แผนยุทธศาสตร์ชาติ 20 ปี/แผนพัฒนาเศรษฐกิจและสังคมแห่งชาติ ฉบับที่ 13 (ถ้ามี) :</label>
                <div>
                    <input class="form-control" placeholder="ระบุแผนยุทธศาสตร์ชาติ..." name="national_strategy" type="text" id="national_strategy">
                    @if ($errors->has('national_strategy'))
                        <p class="help-block">{{ $errors->first('national_strategy') }}</p>
                    @endif
                </div>
            </div>


    

        </div>
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('stakeholders') ? 'has-error' : ''}}">
                <label for="reason" class="control-label">เหตุผล :</label>
                <div>
                    <textarea name="reason" id="reason" class="form-control" ></textarea>
                    @if ($errors->has('reason'))
                        <p class="help-block">{{ $errors->first('reason') }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="col-md-12">
            <div class="form-group {{ $errors->has('attach_file') ? 'has-error' : ''}}"> 
                {!! Form::label('additional_documents', 'เอกสารเพิ่มเติม โปรดระบุ เช่น แผนการดำเนินงาน, ร่างมาตรฐานหรืออื่น ๆ กรณีเป็นลิงก์ดาวน์โหลดให้ใส่ใน Text file'.' : ', ['class' => 'control-label']) !!} 
                <div>
                    <div class="form-group other_attach_item">
                        <div class="col-md-6"> 
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
        </div>            --}}

        <div class="col-md-12">
            <div class="form-group {{ $errors->has('attach_file') ? 'has-error' : ''}}">
                <label for="additional_documents" class="control-label">เอกสาร (.zip) ประกอบด้วย แผนการดำเนินงาน, ร่างมาตรฐาน หรืออื่น ๆ กรณีเป็นลิงก์ดาวน์โหลดให้ใส่ใน Text file แล้ว zip : <span class="text-danger">*</span> </label>
                <div>
                    <div class="form-group other_attach_item">
                        <div class="col-md-6">
                            <input class="form-control" placeholder="รายละเอียดเอกสาร" name="caption" type="text">
                        </div>
                        <div class="col-md-6">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">เลือกไฟล์</span>
                                    <span class="fileinput-exists">เปลี่ยน</span>
                                    <input type="file" name="attach_file" class="attach check_max_size_file" accept=".zip,.rar" required>
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                            </div>
                            @if ($errors->has('attach'))
                                <p class="help-block">{{ $errors->first('attach') }}</p>
                            @endif
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



                    {!! Form::close() !!}
             
                    @include ('tisi.standard-offers.modal_department')
       

                </div>
            </div>
        </div>
    </div>             
@endsection



@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
  <!-- input calendar thai -->
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
  <!-- thai extension -->
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
  <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

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




            $(document).ready(function () {
            $( "#filter_clear" ).click(function() {
                $('#filter_status').val('').select2();
                $('#filter_search').val('');

                $('#filter_state').val('').select2();
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_branch').val('').select2();
                window.location.assign("{{url('/certify/applicant')}}");
            });

            if( checkNone($('#filter_state').val()) ||  checkNone($('#filter_start_date').val()) || checkNone($('#filter_end_date').val()) || checkNone($('#filter_branch').val())   ){
                // alert('มีค่า');
                $("#search_btn_all").click();
                $("#search_btn_all").removeClass('btn-primary').addClass('btn-success');
                $("#search_btn_all > span").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            }

            $("#search_btn_all").click(function(){
                $("#search_btn_all").toggleClass('btn-primary btn-success', 'btn-success btn-primary');
                $("#search_btn_all > span").toggleClass('glyphicon-menu-up glyphicon-menu-down', 'glyphicon-menu-down glyphicon-menu-up');
            });
            function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
             }
 
            @if(\Session::has('message'))
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '{{session()->get('message')}}',
                    loaderBg: '#70b7d6',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            @if(\Session::has('message_error'))
                $.toast({
                    heading: 'Error!',
                    position: 'top-center',
                    text: '{{session()->get('message_error')}}',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            //ปฎิทิน
            jQuery('#date-range').datepicker({
              toggleActive: true,
              language:'th-th',
              format: 'dd/mm/yyyy'
            });


            //เลือกทั้งหมด
            $('#checkall').change(function(event) {

                if($(this).prop('checked')){//เลือกทั้งหมด
                    $('#myTable').find('input.cb').prop('checked', true);
                }else{
                    $('#myTable').find('input.cb').prop('checked', false);
                }

            });


    });

        function Delete(){

            if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
                if(confirm_delete()){
                    $('#myTable').find('input.cb:checked').appendTo("#myForm");
                    $('#myForm').submit();
                }
            }else{//ยังไม่ได้เลือก
                alert("กรุณาเลือกข้อมูลที่ต้องการลบ");
            }

        }

        function confirm_delete() {
            return confirm("ยืนยันการลบข้อมูล?");
        }

        function UpdateState(state){

            if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
                $('#myTable').find('input.cb:checked').appendTo("#myFormState");
                $('#state').val(state);
                $('#myFormState').submit();
            }else{//ยังไม่ได้เลือก
                if(state=='1'){
                    alert("กรุณาเลือกข้อมูลที่ต้องการเปิด");
                }else{
                    alert("กรุณาเลือกข้อมูลที่ต้องการปิด");
                }
            }

        }

    </script>


    <script>
        $('#filter_state').on('change',function () {

            const select = $(this).text();
            const _token = $('input[name="_token"]').val();
            $('#filter_branch').empty();
            $('#filter_branch').append('<option value="-1" >- เลือกสาขา -</option>').select2();
            if ($(this).val() === '3') {
                $.ajax({
                    url:"{{route('api.test')}}",
                    method:"POST",
                    data:{select:select,_token: _token},
                    success:function (result){
                        $.each(result,function (index,value) {
                            $('#filter_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                        });
                    }
                });
            }
            else if ($(this).val() === '4') {
                $.ajax({
                    url:"{{route('api.calibrate')}}",
                    method:"POST",
                    data:{select:select,_token: _token},
                    success:function (result){
                        $.each(result,function (index,value) {
                            $('#filter_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                        })
                    }
                });
            }
        });
    </script>

@endpush
