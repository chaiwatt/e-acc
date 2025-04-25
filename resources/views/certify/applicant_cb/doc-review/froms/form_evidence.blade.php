<fieldset class="white-box">
    <legend>
        <h4><span class="text-danger">*</span> 1. คู่มือคุณภาพและขั้นตอนการดำเนินงานของ<span id="span_certification">{{!empty($certi_cb->CertiCBFormulasTo->title) ? $certi_cb->CertiCBFormulasTo->title : 'หน่วยรับรอง' }}</span>ที่สอดคล้องตามข้อกำหนดมาตรฐานที่ มอก.
            <span class="span_tis">{{ !empty($certi_cb->FormulaTo->title) ?   str_replace("มอก.","",$certi_cb->FormulaTo->title)  : null }}</span> 
            (Certified body implementations which are conformed with TIS
            <span class="span_tis">{{ !empty($certi_cb->FormulaTo->title) ?   str_replace("มอก.","", $certi_cb->FormulaTo->title)   : null }}</span>)  
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section1" data-repeater-list="repeater-section1" >

            @php
                $section1_required = 'required';
            @endphp

            @if ( isset( $certi_cb->id ) && count( App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '1')->get() ) > 0 )

                @php
                    $section1_required = '';
                    $file_sectionn1 = App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '1')->get();
                @endphp

                @foreach ( $file_sectionn1 as $section1 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section1->file) !!}" target="_blank" class="view-attach">{!! HP::FileExtension($section1->file_client_name)  ?? '' !!} {!! $section1->file_client_name  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section1->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec1" class="attachs_sec1 check_max_size_file" {!!  $section1_required !!}>
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec1', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec1" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4> 
            2. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section2" data-repeater-list="repeater-section2" >

            @if ( isset( $certi_cb->id ) && count( App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '2')->get() ) > 0 )

                @php
                    $file_sectionn2 = App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '2')->get();
                @endphp
        
                @foreach ( $file_sectionn2 as $section2 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section2->file) !!}" target="_blank" class="view-attach"> {!! HP::FileExtension($section2->file_client_name)  ?? '' !!} {!! $section2->file_client_name  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section2->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec2" class="attachs_sec2 check_max_size_file">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec2', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec2" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>
</fieldset>


<fieldset class="white-box">
    <legend>
        <h4>
            <span class="text-danger">*</span> 3. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) 
            <span class="text-danger">ไฟล์แนบ Word</span>
            <span class="text-danger" style="font-size: 13px;"> (doc,docx)</span>
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section3" data-repeater-list="repeater-section3" >

            @if ( isset( $certi_cb->id ) && count( App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '3')->get() ) > 0 )

                @php
                    $file_sectionn3 = App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '3')->get();
                @endphp
        
                @foreach ( $file_sectionn3 as $section3 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section3->file) !!}" target="_blank" class="view-attach"> {!! HP::FileExtension($section3->file_client_name)  ?? '' !!} {!! $section3->file_client_name  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section3->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light"></div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">เลือกไฟล์</span>
                            <span class="fileinput-exists">เปลี่ยน</span>
                            <input type="file" name="attachs_sec3" class="attachs_sec3 check_max_size_file" accept=".doc,.docx">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec3', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec3" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>
            4. เอกสารอ้างอิง ชื่อย่อ
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section5" data-repeater-list="repeater-section5" >
            
            @if ( isset( $certi_cb->id ) && count( App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '5')->get() ) > 0 )

                @php
                    $file_sectionn5 = App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '5')->get();
                @endphp
        
                @foreach ( $file_sectionn5 as $section5 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section5->file) !!}" target="_blank" class="view-attach"> {!! HP::FileExtension($section5->file_client_name)  ?? '' !!} {!! $section5->file_client_name  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section5->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

            @else

                <div class="form-group box_remove_file" data-repeater-item>
                    <div class="col-md-4 text-light"></div>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">เลือกไฟล์</span>
                                <span class="fileinput-exists">เปลี่ยน</span>
                                <input type="file" name="attachs_sec5" class="attachs_sec5 check_max_size_file">
                            </span> 
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                        {!! $errors->first('attachs_sec5', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                
            @endif

        </div>
    </div>

</fieldset>

<fieldset class="white-box">
    <legend>
        <h4>
            เอกสารอื่นๆ (Others)    
        </h4>
    </legend>

    <div class="row repeater-form-file">
        <div class="col-md-12 box_section_other" data-repeater-list="repeater-section4" >

            @if ( isset( $certi_cb->id ) && count( App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '4')->get() ) > 0 )

                @php
                    $file_sectionn4 = App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '4')->get();
                @endphp
        
                @foreach ( $file_sectionn4 as $section4 )
                    <div class="form-group">
                        <div class="col-md-4 text-light"><input type="text" class='form-control' value="{!! !empty( $section4->file_desc )?$section4->file_desc:null !!}" disabled></div>
                        <div class="col-md-6">
                            <a href="{!! HP::getFileStorage($attach_path.$section4->file) !!}" target="_blank" class="view-attach"> {!! HP::FileExtension($section4->file_client_name)  ?? '' !!} {!! $section4->file_client_name  ?? '' !!}</a>
                            <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section4->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @endif

            <div class="form-group box_remove_file" data-repeater-item>
                <div class="col-md-4 text-light">
                    {!! Form::text('attachs_txt', null, ['class' => 'form-control', 'placeholder' => 'กรุณากรอกชื่อไฟล์']) !!}
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
                            <input type="file" name="attachs_sec4" class="attachs_sec4 check_max_size_file">
                        </span> 
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                    </div>
                    {!! $errors->first('attachs_sec4', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-sec4" type="button" data-repeater-delete>
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
    </div>
</fieldset>


@push('js')
    <script>
        $(document).ready(function () {

            // ส่วนที่ 1
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

            // ส่วนที่ 2
            //เพิ่มไฟล์แนบ
            $('#attach-add2').click(function(event) {
                $('.other_attach_item2:first').clone().appendTo('#other_attach-box2');
                $('.other_attach_item2:last').find('input').val('');
                $('.other_attach_item2:last').find('a.fileinput-exists').click();
                $('.other_attach_item2:last').find('a.view-attach').remove();
                $('.other_attach_item2:last').find('button.attach-add2').remove();
                $('.other_attach_item2:last').find('.button_remove2').html('<button class="btn btn-danger btn-sm attach-remove5" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove5', function(event) {
                $(this).parent().parent().parent().remove();
            });


            //ส่วนที่ 2
            AttachFile3();
            check_max_size_file();
            //เพิ่มไฟล์แนบ
            $('#attach-add3').click(function(event) {
                $('.other_attach_item3:first').clone().appendTo('#other_attach-box3');
                $('.other_attach_item3:last').find('input').val('');
                $('.other_attach_item3:last').find('a.fileinput-exists').click();
                $('.other_attach_item3:last').find('a.view-attach').remove();
                $('.other_attach_item3:last').find('.label_other_attach').remove();
                $('.other_attach_item3:last').find('button.attach-add3').remove();
                $('.other_attach_item3:last').find('.button_remove89').html('<button class="btn btn-danger btn-sm attach-remove3" type="button"> <i class="icon-close"></i>  </button>');
                AttachFile3();
                check_max_size_file();
            });
            
            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove3', function(event) {
                $(this).parent().parent().parent().remove();
            });

            //เพิ่มไฟล์แนบ
            $('#attach-add7').click(function(event) {
                $('#other_attach-box7').append($('.other_attach_item7:first').clone());
                let row =  $('#other_attach-box7').find('.other_attach_item7:last');
                row.find('input').val('');
                row.find('a.fileinput-exists').click();
                row.find('a.view-attach').remove();
                row.find('.label_attach').remove();
                row.find('button.attach-add7').remove();
                row.find('.button_remove7').html('<button class="btn btn-danger btn-sm attach-remove7" type="button"> <i class="icon-close"></i>  </button>');
                check_max_size_file();
            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove7', function(event) {
                $(this).parent().parent().parent().remove();
            });

        });

        //  Attach File
        function  AttachFile3(){
            $('.attachs_sec3').change( function () {
                var fileExtension = ['docx','doc'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1 && $(this).val() != '') {
                    Swal.fire(
                        'ไม่ใช่หลักฐานประเภทไฟล์ที่อนุญาต .doc หรือ .docx',
                        '',
                        'info'
                    );
                    this.value = '';
                    return false;
                }
            });
        }

        function  CheckFile(){
            $('.check_max_size_file').bind('change', function() {
                var size =   this.files[0].size/1024/1024 ; // หน่วย MB
                if(size > 4){
                    Swal.fire(
                            'ขนาดไฟล์เกินกว่า 4 GB',
                            '',
                            'info'
                    );
                    this.value = '';
                    return false;
                } 
           });
        }

        function  deleteFlie(id){

            Swal.fire({
                icon: 'error',
                title: 'ยื่นยันการลบไฟล์แนบ !',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{!! url('certify/certi_cb/delete_file') !!}"  + "/" + id
                    }).done(function( object ) {
                        if(object == 'true'){
                            $('form').find('#deleteFlie'+id).remove();
                        }else{
                            Swal.fire('ข้อมูลผิดพลาด');
                        }
                    });
                }
            });
        }

    </script>
@endpush