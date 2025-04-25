
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
@endpush
<!-- Modal เลข 11 ประมาณค่าใช้จ่าย -->
<div class="modal fade text-left" id="ReportModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">คำขอใบรับรอง  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
               
            </div>
            <div class="modal-body">
                @if(isset($report) && !is_null($report))
                {!! Form::open(['url' => 'certify/applicant-cb/update_report/'.$report->id, 
                                'class' => 'form-horizontal',
                                'id'=>'app_form_report', 
                                'files' => true])
                 !!}
                  <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('save_date', 'วันที่ประชุม : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-4 text-left">
                           <label for="" class="control-label"> {{  !empty($report->report_date) ? HP::DateThai($report->report_date,true)  : '-' }}</label>
                           </div>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('save_date', 'รายละเอียด : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-4 text-left">
                           <label for="" class="control-label">{{   !empty($report->details) ? $report->details : '-'  }}</label>
                           </div>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('report_status') ? 'has-error' : ''}}">
                           {!! HTML::decode(Form::label('report_status', 'มติคณะอนุกรรมการ'.':', ['class' => 'col-md-4 control-label text-right'])) !!}
                           <div class="col-md-7 text-left">
                            <label>{!! Form::radio('report_status', '1',($report->report_status==1) ?  true : false, ['class'=>'check check_readonly', 'data-radio'=>'iradio_square-green']) !!} &nbsp; เห็นชอบ &nbsp;</label>
                            <label>{!! Form::radio('report_status', '2',($report->report_status==2) ?  true : false , ['class'=>'check check_readonly', 'data-radio'=>'iradio_square-red']) !!} &nbsp; ไม่เห็นชอบ &nbsp;</label>
                          </div>
                       </div>
                     </div>
                  </div>
        
                   @if(!is_null($report->FileAttachReport1To))
                   <div class="row">
                       <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('files', 'ขอบข่ายที่ได้รับการเห็นชอบ : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-7 ">
                               <p style="padding-top: 5px;">
                                    <a href="{{url('certify/check/file_cb_client/'.$report->FileAttachReport1To->file.'/'.( !empty($report->FileAttachReport1To->file_client_name) ? $report->FileAttachReport1To->file_client_name :  basename($report->FileAttachReport1To->file) ))}}" 
                                        title="{{ !empty($report->FileAttachReport1To->file_client_name) ? $report->FileAttachReport1To->file_client_name :  basename($report->FileAttachReport1To->file) }}" target="_blank">
                                    {!! HP::FileExtension($report->FileAttachReport1To->file)  ?? '' !!}
                               </a>
                               </p>
                           </div>
                       </div>
                       </div>
                   </div>
                   @endif
                     @if(count($report->FileAttachReport2Many) > 0)
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                            {!! Form::label('files', 'หลักฐานอื่นๆ : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                            <div class="col-md-7 ">
                                @foreach($report->FileAttachReport2Many as  $key => $itme)
                                    <p>รายละเอียดไฟล์ : {{ $itme->file_desc }}</p>
                                    <p>หลักฐาน : 
                                        <a href="{{url('certify/check/file_cb_client/'.$itme->file.'/'.( !empty($itme->file_client_name) ? $itme->file_client_name :  basename($itme->file) ))}}" 
                                            title="{{ !empty($itme->file_client_name) ? $itme->file_client_name :  basename($itme->file) }}" target="_blank">
                                           {!! HP::FileExtension($itme->file)  ?? '' !!}
                                        </a>
                                </p>
                                @endforeach
                            </div>
                        </div>
                        </div>
                    </div>
                    @endif 

                    <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                               {!! Form::label('', '', ['class' => 'col-md-4 control-label  text-right']) !!}
                               <div class="col-md-6 text-left">
                                    <div class="checkbox checkbox-success">
                                    <input type="checkbox" checked id="status_confirm" name="status_confirm" value="1">
                                        <label for="status_confirm"> &nbsp;ยืนยันขอบข่ายตามมติคณะกรรมการและขอรับใบรับรอง &nbsp; </label>
                                    </div>
                               </div>
                           </div>
                         </div>
                    </div>

                    <div class="row">
                       <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('draft') ? 'has-error' : ''}}">
                           {!! Form::label('files', 'แบบร่างใบรับรองระบบงาน : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-7 ">
                               <p style="padding-top: 5px;">
                                   <a href="{{url('certify/applicant-cb/draft_pdf/'.$id)}}" title="" target="_blank">
                                       <i class="fa fa-file-pdf-o" style="font-size:20px; color:red" aria-hidden="true"></i>
                                   </a>
                               </p>
                           </div>
                       </div>
                       </div>
                   </div>

                    <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group {{ $errors->has('cf_cer') ? 'has-error' : ''}}">
                               {!! Form::label('', '', ['class' => 'col-md-4 control-label  text-right']) !!}
                               <div class="col-md-8 text-left">
                                    <div class="checkbox checkbox-success">
                                    <input type="checkbox" checked id="cf_cer" name="cf_cer" value="1">
                                        <label for="cf_cer"> &nbsp;ยืนยันรับใบรับรองระบบงาน (กรุณาตรวจสอบร่างใบรับรองก่อนกดยืนยัน) &nbsp; </label>
                                    </div>
                               </div>
                           </div>
                         </div>
                    </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success"  onclick="submit_form_report();return false">บันทึก</button>
                </div>
               {!! Form::close() !!}
               @endif
        </div>
    </div>
</div>


@push('js')
<script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
<script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
          function  submit_form_report(){
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
                // Text
                 $.LoadingOverlay("show", {
                image       : "",
                text  : "กำลังบันทึก กรุณารอสักครู่..."
                 });
                $('#app_form_report').submit();
            }
        })
   }
   jQuery(document).ready(function() {
 
            $('.check_readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check_readonly').parent().removeClass('disabled');
            $('.check_readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});
        });
    </script>

    
@endpush