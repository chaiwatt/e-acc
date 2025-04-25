
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet">
@endpush
<!-- Modal เลข 11 ประมาณค่าใช้จ่าย -->
<div class="modal fade text-left" id="action27{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">คำขอใบรับรอง  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
               
            </div>
            <div class="modal-body">
                @if(!is_null($report))
                {!! Form::open(['url' => 'certify/applicant/update/status_confirm/'.$report->id, 
                                'class' => 'form-horizontal',
                                'id'=>'app_certi_form', 
                                'method' => 'post',
                                'files' => true
                                ])
                 !!}
                  <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('save_date', 'วันที่ประชุม : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-4 text-left">
                           <label for="" class="control-label  ">{{ !empty($report->meet_date) ? HP::DateThai($report->meet_date) :  null}}</label>
                           </div>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('save_date', 'รายละเอียด : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-4 text-left">
                           <label for="" class="control-label   ">{{!empty($report->desc) ?$report->desc :  null }}</label>
                           </div>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                           {!! HTML::decode(Form::label('status', 'มติคณะอนุกรรมการ'.':', ['class' => 'col-md-4 control-label text-right'])) !!}
                           <div class="col-md-7 text-left">
                            <label>{!! Form::radio('report_status', '1', isset($report) && !empty($report->status==2) ? false : true, ['class'=>'check check_readonly', 'data-radio'=>'iradio_square-green']) !!} &nbsp; เห็นชอบ &nbsp;</label>
                            <label>{!! Form::radio('report_status', '2', isset($report)  &&  !empty($report->status==2) ? true : false , ['class'=>'check check_readonly', 'data-radio'=>'iradio_square-red']) !!} &nbsp; ไม่เห็นชอบ &nbsp;</label>
                          </div>
                       </div>
                     </div>
                  </div>
        
                   @if(!is_null($report->file_loa) && $report->file_loa != '')
                   <div class="row">
                       <div class="col-sm-12">
                       <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                           {!! Form::label('files', 'ขอบข่ายที่ได้รับการเห็นชอบ : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                           <div class="col-md-7 ">
                               <p style="padding-top: 5px;">
                                <a href="{{url('certify/check/file_client/'.$report->file_loa.'/'.( !empty($report->file_loa_client_name) ? $report->file_loa_client_name : basename($report->file_loa)   ))}}" target="_blank">
                                    {!! HP::FileExtension($report->file_loa)  ?? '' !!}
                               </a>
                               </p>
                           </div>
                       </div>
                       </div>
                   </div>
                   @endif
                     @if(count($report->files) > 0)
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
                            {!! Form::label('files', 'หลักฐานอื่นๆ : ', ['class' => 'col-md-4 control-label  text-right']) !!}
                            <div class="col-md-7 ">
                                @foreach($report->files as  $key => $itme)
                                <p>รายละเอียดไฟล์ : {{ $itme->file_desc }}</p>
                                <p style="padding-top: 5px;">หลักฐาน : 
                                    <a href="{{url('certify/check/file_client/'.$itme->file.'/'.( !empty($itme->file_client_name) ? $itme->file_client_name : basename($itme->file)   ))}}" target="_blank">
                                        {!! HP::FileExtension($itme->file)  ?? '' !!}
                                    </a>
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
                               <div class="col-md-7 text-left">
                                    <div class="checkbox checkbox-success">
                                    <input type="checkbox" checked id="status_confirm" name="status_confirm">
                                        <label for="status_confirm "> &nbsp;ยืนยันขอบข่ายตามมติคณะอนุกรรมการและขอรับใบรับรอง &nbsp; </label>
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
                                   <a href="{{url('certify/applicant/draft_pdf/'.$applicant->id)}}" title="" target="_blank">
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
                    <button type="submit" class="btn btn-success" >บันทึก</button>
                </div>
               {!! Form::close() !!}
               @endif
        </div>
    </div>
    </div>
</div>


@push('js')
<script src="{{asset('plugins/components/icheck/icheck.min.js')}}"></script>
<script src="{{asset('plugins/components/icheck/icheck.init.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
       $(document).ready(function () {
            $('.check_readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check_readonly').parent().removeClass('disabled');
            $('.check_readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});
        });
    </script>
@endpush