
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endpush

<!-- Modal -->
<div class="modal fade" id="PayIn1Modal" tabindex="-1" role="dialog" aria-labelledby="PayIn1Modal" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
 <div class="modal-content">
     <div class="modal-header">
     <h4 class="modal-title" id="PayIn1Modal">แนบใบ Pay-in ครั้งที่ 1
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
     </h4>
     </div>
     {{-- readonly --}}
 {!! Form::open(['url' => 'certify/applicant-cb/pay-in/'.$id, 'class' => 'form-horizontal pay_in1_form','id'=>'app_certi_form', 'files' => true]) !!}
 @if($status == 'false')
     <div class="modal-body">
        <div class="container-fluid">
            <p>เรียน <span class="nameCertiLab">{{ $name }}</span> </p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ตามที่ท่านได้ยื่นคำขอรับใบรับรองหน่วยรับรอง หมายเลขคำขอที่
                 <span class="noCertiLab" style="color:blue">{{ $appNo }}</span> และเห็นด้วยกับการแต่งตั้งคณะผู้ตรวจประเมิน จึงขอแจ้งค่าใช้จ่ายในการตรวจประเมิน invoice ดังนี้
            </p>
            @php 
                $i = 1;
            @endphp
           @if(count($payin1) > 0)
            @foreach($payin1 as $key => $item)
              @if($item->state == 1)
                <p>
                    {{ ( $i++ ).'.' }}
                    <span  style="color:blue"> {{$item->CertiCBAuditorsTo->auditor ?? null }}</span>   
                    เมื่อวันที่ <span id="certiDate" style="color:blue">{{!empty($item->start_date) ? HP::DateThai($item->start_date) : '-' }}</span> 
                    จำนวนเงิน <span  style="color:blue">{{ number_format($item->amount,2) }}</span> บาท
                    โดยมีรายละเอียดแนบ
                    <span id="showInvoiceAssessment">
                        <a href="{{ url('certify/check/files_cb/'.$item->FileAttachPayInOne1To->file) }}"  target="_blank" >  
                            {!! HP::FileExtension($item->FileAttachPayInOne1To->file)  ?? 'หลักฐาน' !!}
                        </a> 
                    </span>
                </p>
               @endif
             @endforeach
            @endif
 
            <p>เรียน กลุ่มการคลัง</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ดำเนินการชำระค่าใช้จ่ายในการตรวจประเมินเรียบร้อยแล้ว ตามหลักฐานที่แนบมา โปรดออกใบเสร็จรับเงินในนาม
                <span class="nameCertiLab">{{ $name }}</span> อ้างอิงเลขคำขอที่ <span class="noCertiLab"  style="color:blue">{{ $appNo }}</span>
            </p>
            <br>
            <label for="file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px">หลักฐานการชำระเงิน :</label>
            @if(count($payin1) > 0)
            @foreach($payin1 as $key => $item)
              @if($item->state == 1)
                <input type="hidden" name="payin_id[]"  value="{{ $item->id ?? null}}">
                <div class="row">
                    <div class="col-sm-5 text-right"> 
                        <span  style="color:blue">{{$item->CertiCBAuditorsTo->auditor ?? null }}</span>  
                    </div>
                    <div class="col-sm-7"> 
                        <div class=" form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span>
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                            {!! Form::file('activity_file['.$item->id.']', null) !!}
                                        </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>
              @endif
              @endforeach
             @endif

       
             @if(count($payinRemark) > 0)
             <label for="file" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px;color:red">หมายเหตุ :</label>
             @foreach($payinRemark as $key => $item)
                @if($item->state == 1)
                    <div class="row">
                        <div class="col-sm-5 text-right"> 
                            <span  style="color:blue">{{ $item->CertiCBAuditorsTo->auditor ?? null }}</span>  
                        </div>
                        <div class="col-sm-7 text-left"> 
                            {{ $item->remark ?? null  }}
                        </div>
                    </div>
                @endif
               @endforeach
              @endif
 
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary " data-dismiss="modal">ยกเลิก</button>
        <button   type="submit" class="btn btn-primary " onclick="submit_form_pay1();return false">บันทึก</button>
    </div>
@else 
    <h1>รอแจ้งค่าใช้จ่ายในการตรวจประเมิน invoice</h1>
@endif
 {!! Form::close() !!}


     </div>
   </div>
</div>

 