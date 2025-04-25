@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left"> แจ้งรายละเอียดค่าบริการในการตรวจประเมิน </h3>
                    @can('view-'.str_slug('tracking-ib'))
                        <a class="btn btn-success pull-right" href="{{  app('url')->previous() }}">
                            <i class="icon-arrow-left-circle"></i> กลับ
                        </a>
                    @endcan
                    <div class="clearfix"></div>
                    <hr>
                      
 {!! Form::open(['url' => 'certify/tracking-ib/update/pay-in/'.$pay_in->id,
                'class' => 'form-horizontal', 
                'files' => true,
                'method' => 'POST',
                'id'=>"pay_in1_form"]) 
!!}
    <p>เรียน <span class="nameCertiLab">{{ @$pay_in->certificate_export_to->org_name ?? null }}</span> </p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตามที่ท่านได้ยื่นคำขอรับใบรับรองระบบงาน
        หมายเลขคำขอที่ <span class="noCertiLab" style="color:blue">{{  !empty($pay_in->reference_refno) ? $pay_in->reference_refno : null }}</span> 
        และเห็นด้วยกับการแต่งตั้งคณะผู้ตรวจประเมิน จึงขอแจ้งค่าใช้จ่ายในการตรวจประเมิน invoice ดังนี้
   </p>
   <div class="row">
    <label class="col-sm-4 text-right">คณะผู้ตรวจประเมิน :</label>
    <div class="col-sm-8">
        <p>   {{ $pay_in->auditors_to->auditor ?? null }} </p>
    </div>
</div>
   @if ($pay_in->conditional_type == 1 || $pay_in->conditional_type == null) <!--  เรียกเก็บค่าธรรมเนียม -->
        <div class="row">
            <label class="col-sm-4 text-right">เมื่อวันที่ :</label>
            <div class="col-sm-8">
                <p>  {{!empty($pay_in->start_date) ? HP::DateThai($pay_in->start_date) : ' ' }} </p>
            </div>
        </div>
    @endif
    @if (!empty($pay_in->amount))
    <div class="row">
        <label class="col-sm-4 text-right">จำนวนเงิน :</label>
        <div class="col-sm-8">
            <p>{{ number_format($pay_in->amount,2) }} บาท</p>
        </div>
    </div>
    @endif
    @if ($pay_in->conditional_type == 1 || $pay_in->conditional_type == null) <!--  เรียกเก็บค่าธรรมเนียม -->

    @if (!is_null($pay_in->FileAttachPayInOne1To))
        <div class="form-group {{ $errors->has('amount_invoice') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('amount_invoice', ' โดยมีรายละเอียดแนบ :', ['class' => 'col-sm-4 text-right control-label'])) !!}
            <div class="col-md-7">
                <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInOne1To->url.'/'.( !empty($pay_in->FileAttachPayInOne1To->filename) ? $pay_in->FileAttachPayInOne1To->filename :  basename($pay_in->FileAttachPayInOne1To->url)  ))}}" 
                    title="{{  !empty($pay_in->FileAttachPayInOne1To->filename) ? $pay_in->FileAttachPayInOne1To->filename : basename($pay_in->FileAttachPayInOne1To->url) }}" target="_blank">
                    {!! HP::FileExtension($pay_in->FileAttachPayInOne1To->url)  ?? '' !!}
                </a> 
            </div>
        </div>
    @endif

    @elseif ($pay_in->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->

        <div class="form-group  {{ $errors->has('report_date') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('report_date', 'ช่วงเวลาการยกเว้นค่าธรรมเนียม :', ['class' => 'col-sm-4 text-right control-label'])) !!}
            <div class="col-md-4">
                <label class="control-label">    {{  !empty($pay_in->start_date_feewaiver) && !empty($pay_in->end_date_feewaiver) ? HP::DateFormatGroupTh($pay_in->start_date_feewaiver,$pay_in->end_date_feewaiver) :  '-' }}</label>
            </div>
        </div>
        @if (!is_null($pay_in->FileAttachPayInOne1To))
            <div class="form-group {{ $errors->has('amount_invoice') ? 'has-error' : ''}}">
                {!! HTML::decode(Form::label('amount_invoice', ' เอกสารยกเว้นค่าธรรมเนียม :', ['class' => 'col-sm-4 text-right control-label'])) !!}
                <div class="col-md-7">
                       <a href="{{url('funtions/get-view/'.base64_encode($pay_in->FileAttachPayInOne1To->url).'/'.( !empty($pay_in->FileAttachPayInOne1To->filename) ? $pay_in->FileAttachPayInOne1To->filename :  basename($pay_in->FileAttachPayInOne1To->url)  ))}}" target="_blank">
                             {!! HP::FileExtension($pay_in->FileAttachPayInOne1To->url)  ?? '' !!}
                        </a>
                </div>
            </div>
        @endif

    @elseif ($pay_in->conditional_type == 3) <!--  ชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่นๆ -->

        <div class="form-group s {{ $errors->has('detail') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('detail', ' หมายเหตุ :', ['class' => 'col-sm-4 text-right control-label'])) !!}
            <div class="col-md-8">
                <p class="text-left">{{!empty($pay_in->detail) ? $pay_in->detail: null}} </p>
            </div>
        </div>
        @if (!is_null($pay_in->FileAttachPayInOne1To))
            <div class="form-group  {{ $errors->has('other_attach') ? 'has-error' : ''}}" id="div-attach">
                {!! HTML::decode(Form::label('other_attach', ' ไฟล์แนบ :', ['class' => 'col-sm-4 text-right control-label'])) !!}
                <div class="col-md-7">
                    <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInOne1To->url.'/'.( !empty($pay_in->FileAttachPayInOne1To->filename) ? $pay_in->FileAttachPayInOne1To->filename :  basename($pay_in->FileAttachPayInOne1To->url)  ))}}" 
                        title="{{  !empty($pay_in->FileAttachPayInOne1To->filename) ? $pay_in->FileAttachPayInOne1To->filename : basename($pay_in->FileAttachPayInOne1To->url) }}" target="_blank">
                        {!! HP::FileExtension($pay_in->FileAttachPayInOne1To->url)  ?? '' !!}
                    </a> 
                </div>
        </div>
        @endif
    @endif

 
    <div class="row">
        <label class="col-sm-4 text-right"><span class="text-danger">*</span> หลักฐานการชำระเงิน :</label>
        <div class="col-sm-4">
            @if($pay_in->state == 1)
            <div class=" form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                          <input type="file" name="attachs_file"  class="check_max_size_file" required>
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
            </div>
            </div>
           @else 
                    @if (!is_null($pay_in->FileAttachPayInOne2To))
                            <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInOne2To->url.'/'.( !empty($pay_in->FileAttachPayInOne2To->filename) ? $pay_in->FileAttachPayInOne2To->filename : 'null' ))}}" target="_blank">
                                {!! HP::FileExtension($pay_in->FileAttachPayInOne2To->url)  ?? '' !!}
                            </a>
                    @endif
            @endif
        </div>
    </div>
    @if(!is_null($pay_in->remark))
    <div class="row">
        <label class="col-sm-4 text-right text-danger">หมายเหตุ :</label>
        <div class="col-sm-8">
            <p>{{!empty($pay_in->remark) ? $pay_in->remark  : null}}</p>
        </div>
    </div>
    @endif 
<br>
@if($pay_in->state == 1)
<hr>
<input type="hidden" name="previousUrl" id="previousUrl" value="{{ app('url')->previous() }}">
<div class="row form-group">
    <div class="col-md-offset-4 col-md-4 m-t-15">
        <button class="btn btn-primary" type="submit" id="form-save" onclick="submit_form();return false">
            <i class="fa fa-paper-plane"></i> บันทึก
        </button>
        <a class="btn btn-default" href="{{ app('url')->previous() }}">
            <i class="fa fa-rotate-left"></i> ยกเลิก
        </a>
    </div>
</div>
 @else 
 <a class="btn btn-lg btn-block  btn-default" href="{{ app('url')->previous() }}">
    <i class="fa fa-rotate-left"></i> ยกเลิก
</a>
@endif
 {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
<script>
              function submit_form() {
               Swal.fire({
                    title: 'ยืนยันทำรายการ !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.value) {
                            $('#pay_in1_form').submit();
                        }
                    })
            
            }
            
  $(document).ready(function(){

            $('#pay_in1_form').parsley().on('field:validated', function() {
                        var ok = $('.parsley-error').length === 0;
                        $('.bs-callout-info').toggleClass('hidden', !ok);
                        $('.bs-callout-warning').toggleClass('hidden', ok);
                    })  .on('form:submit', function() {
               
                            // Text
                            $.LoadingOverlay("show", {
                            image       : "",
                            text  : "กำลังบันทึก กรุณารอสักครู่..."
                            });
                        return true; // Don't submit form for this demo
                    });
    });
</script>

@endpush
