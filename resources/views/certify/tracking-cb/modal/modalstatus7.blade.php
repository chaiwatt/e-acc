
@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
     <!-- ===== Parsley js ===== -->
    <link href="{{asset('plugins/components/parsleyjs/parsley.css?20200630')}}" rel="stylesheet" />
@endpush

{!! Form::open(['url' => 'certify/tracking-cb/report/update/'.$report->id,    'method' => 'POST', 'class' => 'form-horizontal  ','id'=>'form-report', 'files' => true]) !!}

<div class="modal fade text-left" id="report{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
          <div class="modal-dialog  modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel1"> สรุปรายงานและเสนออนุกรรมการฯ
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </h4>
                  </div>
 <div class="modal-body"> 

<div class="row">
    <div class="col-md-12">

<div class="form-group {{ $errors->has('report_date') ? 'has-error' : ''}}">
        {!! HTML::decode(Form::label('report_date', 'วันที่ประชุม'.' :', ['class' => 'col-md-4 control-label text-right'])) !!}
        <div class="col-md-4">
            <label for="" class="control-label"> {{  !empty($report->report_date) ? HP::DateThai($report->report_date,true)  : '-' }}</label>
        </div>
</div>    

@if (!empty($report->details))
<div class="form-group {{ $errors->has('details') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('details', 'รายละเอียด'.' :', ['class' => 'col-md-4 control-label text-right'])) !!}
    <div class="col-md-4">
        <label for="" class="control-label">{{   !empty($report->details) ? $report->details : '-'  }}</label>
    </div>
</div>    
@endif

 
<div class="form-group {{ $errors->has('report_status') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('report_status', 'มติคณะอนุกรรมการ'.' :', ['class' => 'col-md-4 control-label text-right'])) !!}
    <div class="col-md-7">
        <label>{!! Form::radio('report_status', '1',($report->report_status==1) ?  true : false, ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-green']) !!} &nbsp; เห็นชอบ &nbsp;</label>
        <label>{!! Form::radio('report_status', '2',($report->report_status==2) ?  true : false , ['class'=>'check check-readonly', 'data-radio'=>'iradio_square-red']) !!} &nbsp; ไม่เห็นชอบ &nbsp;</label>
    </div>
</div>    
 

<div class="form-group {{ $errors->has('Report') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('Report', 'ขอบข่ายที่ได้รับการเห็นชอบ'.' :', ['class' => 'col-md-4 control-label text-right'])) !!}
    <div class="col-md-8">
        @if (!is_null($report->FileAttachFileLoaTo))
                <p>
                        <a href="{{url('funtions/get-view/'.$report->FileAttachFileLoaTo->url.'/'.( !empty($report->FileAttachFileLoaTo->filename) ? $report->FileAttachFileLoaTo->filename :  basename($report->FileAttachFileLoaTo->url)  ))}}" 
                            title="{{  !empty($report->FileAttachFileLoaTo->filename) ? $report->FileAttachFileLoaTo->filename : basename($report->FileAttachFileLoaTo->url) }}" target="_blank">
                            {!! HP::FileExtension($report->FileAttachFileLoaTo->url)  ?? '' !!}
                        </a> 
                </p>
        @endif
    </div>
</div> 
@if(count($report->FileAttachFilesMany) > 0)
<div class="form-group {{ $errors->has('Report') ? 'has-error' : ''}}">
    {!! HTML::decode(Form::label('Report', 'หลักฐานอื่นๆ'.' :', ['class' => 'col-md-4 control-label text-right'])) !!}
    <div class="col-md-8">
         @foreach($report->FileAttachFilesMany as  $key => $itme)
                <p>รายละเอียดไฟล์ : {{ @$itme->caption }}</p>
                <p>หลักฐาน : 
                    <a href="{{url('funtions/get-view/'.$itme->url.'/'.( !empty($itme->filename) ? $itme->filename :  basename($itme->url)  ))}}" 
                        title="{{  !empty($itme->filename) ? $itme->filename : basename($itme->url) }}" target="_blank">
                        {!! HP::FileExtension($itme->url)  ?? '' !!}
                    </a> 
                </p>
          @endforeach
    </div>
</div> 
@endif

 
 
<div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
    {!! Form::label('', '', ['class' => 'col-md-4 control-label  text-right']) !!}
    <div class="col-md-8 text-left">
         <div class="checkbox checkbox-success">
         <input type="checkbox" checked id="status_confirm" name="status_confirm" value="1">
             <label for="status_confirm"> &nbsp;ยืนยันขอบข่ายตามมติคณะกรรมการและขอรับใบรับรอง &nbsp; </label>
         </div>
    </div>
</div>


    </div> 
</div>

</div>

@if ($certi->status_id == 7)
<input type="hidden" name="previousUrl" id="previousUrl" value="{{  app('url')->previous()  }}">
<div class="modal-footer">
    <button type="submit" class="btn btn-success" onclick="submit_form();return false">ยืนยัน</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
</div> 
@endif


        </div>
    </div>
</div>
{!! Form::close() !!}
      
@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
     <!-- ===== PARSLEY JS Validation ===== -->
     <script src="{{asset('plugins/components/parsleyjs/parsley.min.js')}}"></script>
     <script src="{{asset('plugins/components/parsleyjs/language/th.js')}}"></script>
     <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
            $('.check-readonly').prop('disabled', true);//checkbox ความคิดเห็น
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%", "cursor": "not-allowed"});
        });
      function submit_form() {
        Swal.fire({
                title: 'ยืนยันการทำรายการ !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.value) {
                        $('#form-report').submit();
                    }
                })
        }
        jQuery(document).ready(function() {
        $('#form-report').parsley().on('field:validated', function() {
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
    