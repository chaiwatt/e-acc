@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
     <!-- ===== Parsley js ===== -->
    <link href="{{asset('plugins/components/parsleyjs/parsley.css?20200630')}}" rel="stylesheet" />
@endpush
<div class="modal fade text-left" id="PayIn2Modal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel1">
                          แจ้งรายละเอียดการชำระเงินค่าใบรับรอง
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </h4>
                  </div>
                  @if(!is_null($pay_in))
                        {!! Form::open(['url' => 'certify/tracking-labs/pay-in2/update/'.$pay_in->id,    'method' => 'POST', 'class' => 'form-horizontal app_form_pay_in2 ','id'=>'app_form_pay_in2', 'files' => true]) !!}
                  @php
                 $formula = App\Models\Bcertify\Formula::Where([['applicant_type',3],['state',1]])->first();
                  $amount  =  !empty($pay_in->amount) ? $pay_in->amount :  '0';
                  $amount_fee  =  !empty($pay_in->amount_fee) ?$pay_in->amount_fee :  '0';
                  $sum =   ((string)$amount +   (string)$amount_fee);
                  @endphp
                  <div class="modal-body">
                      <div class="container-fluid">
                          <h3 class="text-center"><span >{{ HP::formatDateThai($pay_in->report_date) ?? '-' }}</span></h3>
                              <p>&nbsp;</p>
                              <p>เรียน <span>  {{ $certi->org_name ?? null }}</span></p>
                              <p>เรื่อง <span>การยืนยันความสามารถ และการขอรับใบรับรองระบบงาน</span></p>
                              <p style="text-indent: 50px;">ตามที่  {{ $certi->org_name ?? null  }} ได้แจ้งขอรับบริการการตรวจประเมินความสามารถ 
                                  ตามมาตรฐาน มอก. {{ !is_null($formula)?$formula->title:'-' }}    นั้น
                              </p>
                              <p style="text-indent: 50px;"> สำนักงานขอยืนยันว่าหน่วยงานของท่าน มีความสามารถครบถ้วนตามหลักเกณฑ์ที่สำนักงานกำหนด หากท่านประสงค์จะขอรับใบรับรอง โปรดชำระค่าธรรมเนียมตามรายละเอียดที่แจ้งมาพร้อมนี้ ภายใน 30 วัน นับจากวันที่ที่ระบุไว้ในหนังสือฉบับนี้</p>
                              <p style="text-indent: 50px;"> จึงเรียนมาเพื่อโปรดดำเนินการ  </p>
      
       
                              @if ($pay_in->conditional_type == 1) <!--  เรียกเก็บค่าธรรมเนียม -->
                                  <p>	ค่าธรรมเนียมคำขอการใบรับรอง สก. :
                                      <span style="color:#26ddf5;">{{ number_format($pay_in->amount_fixed,2).' บาท ' ??'0.00' }}</span>
                                  </p>
                                  <p>	ค่าตรวจสอบคำขอ :
                                      <span style="color:#26ddf5;">{{ number_format($pay_in->amount,2).' บาท '  ??'0.00' }}</span>
                                  </p>
                                  <p>ค่าธรรมเนียมใบรับรอง สก. :
                                      <span style="color:#26ddf5;">{{ number_format($pay_in->amount_fee,2).' บาท '  ??'0.00' }}</span>
                                  </p>
                                  <p>ใบแจ้งหนี้ค่าธรรมเนียม :
                                        @if(!is_null($pay_in->FileAttachPayInTwo1To))
                                                  <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInTwo1To->url.'/'.( !empty($pay_in->FileAttachPayInTwo1To->filename) ? $pay_in->FileAttachPayInTwo1To->filename :  basename($pay_in->FileAttachPayInTwo1To->url)  ))}}" 
                                                            title="{{  !empty($pay_in->FileAttachPayInTwo1To->filename) ? $pay_in->FileAttachPayInTwo1To->filename : basename($pay_in->FileAttachPayInTwo1To->url) }}" target="_blank">
                                                            {!! HP::FileExtension($pay_in->FileAttachPayInTwo1To->url)  ?? '' !!}
                                                  </a> 
                                        @endif 
                                  </p>
                              @elseif ($pay_in->conditional_type == 2) <!--  ยกเว้นค่าธรรมเนียม -->
                                  <p> เอกสารยกเว้นค่าธรรมเนียม :
                                      @if(!is_null($pay_in->FileAttachPayInTwo1To))
                                        <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInTwo1To->url.'/'.( !empty($pay_in->FileAttachPayInTwo1To->filename) ? $pay_in->FileAttachPayInTwo1To->filename :  basename($pay_in->FileAttachPayInTwo1To->url)  ))}}" 
                                                  title="{{  !empty($pay_in->FileAttachPayInTwo1To->filename) ? $pay_in->FileAttachPayInTwo1To->filename : basename($pay_in->FileAttachPayInTwo1To->url) }}" target="_blank">
                                                  {!! HP::FileExtension($pay_in->FileAttachPayInTwo1To->url)  ?? '' !!}
                                        </a> 
                                      @endif 
                                  </p>
                               @elseif ($pay_in->conditional_type == 3) <!--  ชำระเงินนอกระบบ, ไม่เรียกชำระเงิน หรือ กรณีอื่น -->
                                  <p>
                                                หมายเหตุ :  {{!empty($pay_in->remark) ? $pay_in->remark: null}} 
                                  </p>
                                  <p>ไฟล์แนบ :
                                        @if(!is_null($pay_in->FileAttachPayInTwo1To))
                                                  <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInTwo1To->url.'/'.( !empty($pay_in->FileAttachPayInTwo1To->filename) ? $pay_in->FileAttachPayInTwo1To->filename :  basename($pay_in->FileAttachPayInTwo1To->url)  ))}}" 
                                                            title="{{  !empty($pay_in->FileAttachPayInTwo1To->filename) ? $pay_in->FileAttachPayInTwo1To->filename : basename($pay_in->FileAttachPayInTwo1To->url) }}" target="_blank">
                                                            {!! HP::FileExtension($pay_in->FileAttachPayInTwo1To->url)  ?? '' !!}
                                                  </a> 
                                       @endif 
                                  </p>
                              @endif
       
               
                          <div class=" form-group {{ $errors->has('attach') ? 'has-error' : ''}}">
                              <label for="attach" class="col-md-12" style="padding-top: 7px;margin-bottom: 13px"><span class="text-danger">*</span> หลักฐานค่าธรรมเนียม :</label>
                              <div class="col-md-10">
                                   @if($pay_in->state == 1)
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                                  <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                  <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span>
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                                  <input type="file" name="attach" required class="check_max_size_file">
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                        </div>
                                        {!! $errors->first('attach', '<p class="help-block">:message</p>') !!}
                                   @elseif(!is_null($pay_in->FileAttachPayInTwo2To))
                                        <a href="{{url('funtions/get-view/'.$pay_in->FileAttachPayInTwo2To->url.'/'.( !empty($pay_in->FileAttachPayInTwo2To->filename) ? $pay_in->FileAttachPayInTwo2To->filename :  basename($pay_in->FileAttachPayInTwo2To->url)  ))}}" 
                                        title="{{  !empty($pay_in->FileAttachPayInTwo2To->filename) ? $pay_in->FileAttachPayInTwo2To->filename : basename($pay_in->FileAttachPayInTwo2To->url) }}" target="_blank">
                                        {!! HP::FileExtension($pay_in->FileAttachPayInTwo2To->url)  ?? '' !!}
                                        </a> 
                                  @endif
                              </div>
                          </div>
                         
                      </div>
      
      
                      @if(!is_null($pay_in->detail))
                           <br>
                          <p>หมายเหตุ :</p>
                          <p>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{  $pay_in->detail ?? '-' }}
                          </p>
                      @endif
      
      
                  </div>
                    @if($pay_in->state == 1)
                              <div class="modal-footer">
                                        <input type="hidden" name="previousUrl" id="previousUrl" value="{{  app('url')->previous()  }}">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-success" onclick="submit_form_pay_in2();return false">แจ้งชำระเงิน</button>
                              </div>
                    @endif
                  {!! Form::close() !!}
                  @endif
      
              </div>
          </div>
      </div>
      
      @push('js')
      <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
     <!-- ===== PARSLEY JS Validation ===== -->
     <script src="{{asset('plugins/components/parsleyjs/parsley.min.js')}}"></script>
     <script src="{{asset('plugins/components/parsleyjs/language/th.js')}}"></script>
     <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
      <script type="text/javascript">
      
            function  submit_form_pay_in2(){
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
                          $('.app_form_pay_in2').submit();
                      }
                  })
             }
             jQuery(document).ready(function() {
              $('.app_form_pay_in2').parsley().on('field:validated', function() {
                                  var ok = $('.parsley-error').length === 0;
                                  $('.bs-callout-info').toggleClass('hidden', !ok);
                                  $('.bs-callout-warning').toggleClass('hidden', ok);
                   })
                   .on('form:submit', function() {
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
      