<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
        <legend>
            <h4><span class="text-danger">*</span> 1. คู่มือคุณภาพและขั้นตอนการดำเนินงานของ<span id="span_certification">{{!empty($certi_cb->CertiCBFormulasTo->title) ? $certi_cb->CertiCBFormulasTo->title : 'หน่วยรับรอง' }}</span>ที่สอดคล้องตามข้อกำหนดมาตรฐานที่ มอก.
                    <span class="span_tis">{{ !empty($certi_cb->FormulaTo->title) ?   str_replace("มอก.","",$certi_cb->FormulaTo->title)  : null }}</span> 
                    (Certified body implementations which are conformed with TIS
                     <span class="span_tis">{{ !empty($certi_cb->FormulaTo->title) ?   str_replace("มอก.","", $certi_cb->FormulaTo->title)   : null }}</span>)  
                     {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                </h4>
        </legend>
            <div class="row hide_attach">
                <div class="col-md-12 ">
                    <div id="other_attach-box">
                        <div class="form-group other_attach_item">
                            <div class="col-md-4 text-light">
                                {{-- {!! Form::text('attach_filenames[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!} --}}
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
                                        <input type="file"  name="attachs_sec1[]" class="check_max_size_file" {{ (isset($certi_cb) && $certi_cb->FileAttach1->count() == 0 ) ? 'required' : ''}}>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                                {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="col-md-2 text-left">
                                <button type="button" class="btn btn-sm btn-success attach-add" id="attach-add">
                                    <i class="icon-plus"></i>&nbsp;เพิ่ม
                                </button>
                                <div class="button_remove88"></div>
                            </div> 
                         </div>
                       </div>
                 </div>
            </div>
            <div class="clearfix"></div>
            {{-- {{$certi_cb->FileAttach1->count()}} --}}
            @if (isset($certi_cb) && $certi_cb->FileAttach1->count() > 0)
            <div class="row">
                @foreach($certi_cb->FileAttach1 as $data)
                  @if ($data->file)
                  <div class="col-md-12" id="deleteFlie{{$data->id}}">
                        <div class="form-group">
                            <div class="col-md-4 text-light"> </div>
                            <div class="col-md-6 text-light">
                                <a href="{{url('certify/check/file_cb_client/'.$data->file.'/'.( !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))}}" target="_blank">
                                        {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                </a>
                            </div>
                            <div class="col-md-2 text-left">
                                <button class="hide_attach btn btn-danger btn-sm"  type="button"  onclick="deleteFlie({{ $data->id }})">
                                    <i class="icon-close"></i> 
                                </button>
                            </div> 
                        </div>
                    </div>
                    @endif
                 @endforeach
              </div>
            @endif
  
     </div>
  </div>
</div>
@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add').click(function(event) {
                $('.other_attach_item:first').clone().appendTo('#other_attach-box');
                $('.other_attach_item:last').find('input').val('');
                $('.other_attach_item:last').find('a.fileinput-exists').click();
                $('.other_attach_item:last').find('a.view-attach').remove();
                $('.other_attach_item:last').find('button.attach-add').remove();
                $('.other_attach_item:last').find('.button_remove88').html('<button class="btn btn-danger btn-sm attach-remove" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove', function(event) {
                $(this).parent().parent().parent().remove();
            });


        });

    </script>
@endpush
