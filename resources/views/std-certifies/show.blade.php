@extends('layouts.app-certifies')

@push('css')
 
<style>
.pointer {cursor: pointer;}

    .label-height{
        line-height: 25px;
        font-size: 20px;
        font-weight: 600 !important;
        color: black !important;
    }
    .span_show{
        padding-top: 7px;
        margin-bottom: 0;
    }
    .span_show_b{
        padding-top: 7px;
        margin-bottom: 0;
        font-size: 1.1em;
        font-weight: 400;
    }
</style>
@endpush

@section('content')
 
<section>

    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">รายละเอียดมาตรฐานการตรวจสอบและรับรอง</h3>
                    <a class="btn btn-success text-white pull-right" href="{{url('std-certifies')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                    </a>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">

                        <div class="form-horizontal">

                            <div class="row">
                                <div class="col-md-12  ">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('name','เลขที่ มตช.'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->std_full) ? $standard->std_full : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('name','ชื่อมาตรฐาน.'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->std_title) ? $standard->std_title : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('name','ชื่อมาตรฐาน (ภาษาอังกฤษ)'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->std_title_en) ? $standard->std_title_en : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('name','บทคัดย่อ'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->std_abstract) ? $standard->std_abstract : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('name','บทคัดย่อ (ภาษาอังกฤษ)'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->std_abstract_en) ? $standard->std_abstract_en : null !!}</div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group  {{ $errors->has('') ? 'has-error' : ''}}">
                                            {!! Form::label('', 'ประกาศในราชกิจจานุเบกษา', ['class' => 'col-md-3 control-label label-height']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('gazette_book') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('gazette_book','ฉบับ'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-3">
                                            <div class="span_show">{!! !empty($standard->gazette_book) ? $standard->gazette_book : null !!}</div>
                                        </div>
                                        {!! HTML::decode(Form::label('gazette_book','ที่'.' :', ['class' => 'col-md-1 control-label text-right '])) !!}
                                        <div class="col-md-3">
                                            <div class="span_show">{!! !empty($standard->gazette_standard->gazette->gazette_govbook) ? $standard->gazette_standard->gazette->gazette_govbook : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('gazette_no') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('gazette_no','เล่ม'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->gazette_no) ? $standard->gazette_no : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('gazette_section') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('gazette_section','ตอน'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->gazette_section) ? $standard->gazette_section : null !!}</div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        {!! HTML::decode(Form::label('name','วันที่'.' :', ['class' => 'col-md-3 control-label text-right '])) !!}
                                        <div class="col-md-7">
                                            <div class="span_show">{!! !empty($standard->gazette_post_date) ? HP::DateThai($standard->gazette_post_date) : null !!}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

@endsection