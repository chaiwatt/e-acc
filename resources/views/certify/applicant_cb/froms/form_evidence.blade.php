

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
                            @if ($methodType != 'show')
                                <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section1->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                    <i class="fa fa-remove"></i>
                                </a>
                            @endif
                            
                        </div>
                    </div>
                @endforeach
                
            @endif

            @if ($methodType != 'show')
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
            @endif


        </div>
        @if ($methodType != 'show')
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                </div>
            </div> 
        </div>
        @endif

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
                            @if ($methodType != 'show')
                            <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section2->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                <i class="fa fa-remove"></i>
                            </a>
                            @endif
                          
                        </div>
                    </div>
                @endforeach
                
            @endif

            @if ($methodType != 'show')
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
            @endif

        </div>
        @if ($methodType != 'show')
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                    </div>
                </div> 
            </div>
        @endif

    </div>
</fieldset>

<button type="button" class="btn btn-info" id="button_store_cb_scope_isic_isic">Save Isic scope</button>
<button type="button" class="btn btn-info" id="button_load_isic">Load Isic scope</button>

<button type="button" class="btn btn-info" id="button_store_cb_scope_bcms">Save Bcms scope</button>
<button type="button" class="btn btn-info" id="button_load_bcms">Load Bcms scope</button>


    @if ($certi_cb == null || empty($certi_cb->doc_review_reject))
        <fieldset class="white-box">
            <legend>
                <h4>
                    <span class="text-danger">*</span> 3. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) 
                    {{-- <span class="text-danger">ไฟล์แนบ Word</span>
                    <span class="text-danger" style="font-size: 13px;"> (doc,docx)</span> --}}
                </h4>
            </legend>

            @if ( isset( $certi_cb->id ) && count( App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id )->where('file_section', '1')->get() ) > 0 )

                @php
                    $file_section3 = App\Models\Certify\ApplicantCB\CertiCBAttachAll::where('app_certi_cb_id', $certi_cb->id)
                                    ->where('file_section', '1')
                                    ->latest() // เรียงตาม created_at จากใหม่ไปเก่า
                                    ->first(); // ดึงรายการล่าสุดเพียงรายการเดียว
                    
                @endphp

    
                <div class="form-group">
                    <div class="col-md-4 text-light"></div>
                    <div class="col-md-6">
                        <a href="{!! HP::getFileStorage($attach_path.$file_section3->file) !!}" target="_blank" class="view-attach"> {!! HP::FileExtension($file_section3->file_client_name)  ?? '' !!} {!! $file_section3->file_client_name  ?? '' !!}</a>
                    
                    </div>
                </div>
            @endif
            
            @if ($methodType != 'show')
                <div class="row repeater-form-file">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <button type="button" id="btn_add_cb_scope_isic_isic" class="btn btn-success">
                                    <i class="icon-plus"></i>เพิ่มขอบข่าย
                                </button>
                            </div>
                        </div> 
                    </div>
                </div>
            @endif



        </fieldset>
    @endif


    {{-- @endif
@endif --}}




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
                            @if ($methodType != 'show')
                                <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section5->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                    <i class="fa fa-remove"></i>
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach

            @else

         
                <div class="form-group box_remove_file" data-repeater-item>
                    @if ($methodType != 'show')
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
                    @endif
                
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
                            @if ($methodType != 'show')
                                <a href="{{url('certify/applicant-cb/delete/file_app_certi_cb_attach_all').'/'.$section4->id.'/'.$certi_cb->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                    <i class="fa fa-remove"></i>
                                </a>
                            @endif
                          
                        </div>
                    </div>
                @endforeach
                
            @endif

            @if ($methodType != 'show')
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
            @endif

           
        </div>
        @if ($methodType != 'show')
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                    </div>
                </div> 
            </div>      
        @endif

    </div>
</fieldset>


@push('js')
    <script>

        var selectedIsicData = [];
        var selectedBcmsData = [];
        var certi_cb = null;
        var currentMethod = null;

        $(document).ready(function () {
            certi_cb = @json($certi_cb ?? []);
            certificationBranch = @json($certificationBranch ?? []);
            currentMethod = checkUrl();
            // console.log(currentMethod);
            if(currentMethod == "edit")
            {
                selectedModel = certificationBranch.model_name;
                console.log(selectedModel);

            if(selectedModel == "CbScopeIsicIsic")
            {
                loadCbScopeIsic();
            }
            else if(selectedModel == "CbScopeBcms")
            {
                loadCbScopeBcms();
            }


            }
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

        function checkUrl() {
            var currentUrl = window.location.href;

            // ตรวจสอบว่า URL มี applicant/create หรือไม่
            if (currentUrl.includes("/create")) {
                return "create";
            }

            // ตรวจสอบว่า URL มี applicant/edit หรือไม่
            if (currentUrl.includes("/edit")) {
                return "edit";
            }

                // ตรวจสอบว่า URL มี applicant/edit หรือไม่
            if (currentUrl.includes("/show")) {
                return "show";
            }

            // ถ้าไม่ตรงทั้ง "create" และ "edit"
            return null;
        }

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

        // 

        $('#btn_add_cb_scope_isic_isic').click(function(event) {
          
            var selectedOption = $('#petitioner option:selected'); // หา option ที่ถูกเลือก
            var modelName = selectedOption.data('model'); // ดึงค่า data-model

            console.log(modelName);
            // alert(modelName);
            if(selectedModel == null)
            {
                selectedModel = modelName;
            }
            
            if(selectedModel == null)
            {
                alert('โปรดเลือกข้อกำหนด สาขาการรับรอง และมาตรฐานที่ใช้รับรอง')
            }

            console.log(selectedModel);
            if(selectedModel == "CbScopeIsicIsic")
            {
                loadCbScopeIsic();
                addCbScopeIsicModel();
            }
            else if(selectedModel == "CbScopeBcms")
            {
                loadCbScopeBcms();
                addCbScopeBcmsModel()
            }

        });

        function addCbScopeIsicModel() {
            const _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{route('applicant_cb.get_cb_isic_scope')}}",
                method: "POST",
                data: {
                    selectedModel: selectedModel,
                    _token: _token
                },
                success: function(result) {
                    let accordionWrapper = $("#cb_scope_isic_accordion_wrapper");
                    accordionWrapper.empty(); // ล้างข้อมูลเก่าก่อน

                    let accordionId = "accordion" + Math.floor(Math.random() * 100000);
                    let accordionHtml = `<div class="panel-group" id="${accordionId}" role="tablist" aria-multiselectable="false">`;

                    $.each(result, function(index, item) {
                        var panelId = `panel_${item.id}`;
                        var headingId = `heading_${item.id}`;
                        var collapseId = `collapse_${item.id}`;
                        var accordionId = `accordion_${item.id}`;

                        accordionHtml += `
                            <div class="panel panel-default" id="${panelId}" data-id="${item.id}">
                                <div class="panel-heading" role="tab" id="${headingId}">
                                    <h5 class="panel-title">
                                        <div style="display: inline-block; margin-right: 10px;">
                                            <input id="isic_${item.id}" class="isic_check" type="checkbox" name="isic_checkbox[]"
                                                value="${item.id}" data-id="${item.id}">
                                            <label for="isic_${item.id}">
                                                <span style="font-size:17px !important">ISIC#${item.isic_code}: ${item.description_th}</span>
                                            </label>
                                        </div>
                                        ${item.categories.length > 0 ? `
                                            <a role="button" data-toggle="collapse" class="accordion-plus-toggle collapsed"
                                                data-parent="#${accordionId}"
                                                href="#${collapseId}"
                                                aria-expanded="false"
                                                aria-controls="${collapseId}"
                                                id="${panelId}" 
                                                data-isic="${item.id}"
                                                style="position: relative; top:-10px;">
                                            </a>
                                        ` : ''}
                                    </h5>
                                </div>
                                <div id="${collapseId}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="${headingId}">
                                    <div class="panel-body" style="padding:0">
                                        <div class="categories-list">
                                            ${item.categories.map(category => {
                                                return `
                                                    <ul>
                                                        <li style="list-style: none; margin-bottom: 5px;">
                                                            <input id="category_${category.id}" class="category_check" type="checkbox" 
                                                                name="category_checkbox[${panelId}][${category.id}][]" value="${category.id}" data-id="${category.id}">
                                                            <label for="category_${category.id}">
                                                                <span style="font-size:16px !important">${category.description_th}</span>
                                                            </label>
                                                        </li>
                                                        ${category.subcategories.map(subcategory => {
                                                            return `
                                                                <ul style="padding-left: 20px;">
                                                                    <li style="list-style: none; margin-bottom: 5px;">
                                                                        <input id="subcategory_${subcategory.id}" class="subcategory_check" type="checkbox" 
                                                                            name="subcategory_checkbox[${panelId}][${category.id}][${subcategory.id}][]" value="${subcategory.id}" 
                                                                            data-id="${subcategory.id}" data-category-id="${category.id}">
                                                                        <label for="subcategory_${subcategory.id}">
                                                                            <span style="font-size:16px !important">${subcategory.description_th}</span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                            `;
                                                        }).join('')}
                                                    </ul>
                                                `;
                                            }).join('')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    accordionHtml += `</div>`;
                    accordionWrapper.append(accordionHtml);

                    // โหลดข้อมูลเดิมจาก selectedIsicData
                    selectedIsicData.forEach(function(isic) {
                        $(`#isic_${isic.isic_id}`).prop('checked', true);
                        isic.categories.forEach(function(category) {
                            $(`#category_${category.category_id}`).prop('checked', category.is_checked);
                            category.subcategories.forEach(function(subcategory) {
                                $(`#subcategory_${subcategory.subcategory_id}`).prop('checked', subcategory.is_checked);
                            });
                        });
                    });

                    // อัพเดท selectedIsicData เมื่อมีการเปลี่ยนแปลง checkbox
                    function updateSelectedIsicData() {
                        selectedIsicData = []; // เคลียร์ข้อมูลเก่า

                        $('.panel').each(function() {
                            var panelId = $(this).attr('id');
                            var isicId = $(this).data('id');
                            var isIsicChecked = $(`#${panelId} .isic_check`).prop('checked');

                            if (isIsicChecked) {
                                var isic = result.find(item => item.id == isicId);
                                if (isic) {
                                    var isicData = {
                                        isic_id: isic.id,
                                        categories: []
                                    };

                                    $(`#${panelId} .category_check`).each(function() {
                                        var categoryId = $(this).data('id');
                                        var isCategoryChecked = $(this).prop('checked');
                                        
                                        if (isCategoryChecked) {
                                            var category = isic.categories.find(cat => cat.id == categoryId);
                                            if (category) {
                                                var categoryData = {
                                                    category_id: category.id,
                                                    is_checked: true,
                                                    subcategories: []
                                                };

                                                $(`#${panelId} .subcategory_check[data-category-id="${categoryId}"]`).each(function() {
                                                    var subcategoryId = $(this).data('id');
                                                    var isSubcategoryChecked = $(this).prop('checked');
                                                    
                                                    if (isSubcategoryChecked) {
                                                        var subcategory = category.subcategories.find(sub => sub.id == subcategoryId);
                                                        if (subcategory) {
                                                            categoryData.subcategories.push({
                                                                subcategory_id: subcategory.id,
                                                                is_checked: true
                                                            });
                                                        }
                                                    }
                                                });

                                                isicData.categories.push(categoryData);
                                            }
                                        }
                                    });

                                    selectedIsicData.push(isicData);
                                }
                            }
                        });
                    }

                    // Event listener สำหรับการเปลี่ยนแปลง checkbox
                    $(document).on('change', '.isic_check, .category_check, .subcategory_check', function() {
                        updateSelectedIsicData();
                        console.log(JSON.stringify(selectedIsicData, null, 2));
                    });

                    // เมื่อกดบันทึก
                    $(document).on('click', '#button_add_cb_scope_isic_isic', function() {
                        updateSelectedIsicData(); // อัพเดทข้อมูลล่าสุด
                        console.log(JSON.stringify(selectedIsicData, null, 2));
                        $('#modal-add-cb-scope-isic-isic').modal('hide');
                    });
                }
            });

            $('#modal-add-cb-scope-isic-isic').modal('show');
        }

        // function addCbScopeIsicModel()
        // {
        //     const _token = $('input[name="_token"]').val();
        //     console.log(selectedModel,_token)

        //         $.ajax({
        //         url: "{{route('applicant_cb.get_cb_isic_scope')}}",
        //         method: "POST",
        //         data: {
        //             selectedModel: selectedModel,
        //             _token: _token
        //         },
        //         success: function(result) {
        //             console.log(result);

        //             let accordionWrapper = $("#cb_scope_isic_accordion_wrapper");
        //             accordionWrapper.empty(); // ล้างข้อมูลเก่าก่อน

        //             let accordionId = "accordion" + Math.floor(Math.random() * 100000); // สร้าง ID ไม่ซ้ำกัน
        //             let accordionHtml = `<div class="panel-group" id="${accordionId}" role="tablist" aria-multiselectable="false">`;

        //             $.each(result, function(index, item) {
        //                 // สร้าง panelHtml โดยใช้ item.id จากข้อมูลที่ได้รับมา
        //                 var panelId = `panel_${item.id}`;  // สร้าง panelId จาก item.id
        //                 var headingId = `heading_${item.id}`;
        //                 var collapseId = `collapse_${item.id}`;
        //                 var accordionId = `accordion_${item.id}`;

        //                 accordionHtml += `
        //                     <div class="panel panel-default" id="${panelId}" data-id="${item.id}">
        //                         <div class="panel-heading" role="tab" id="${headingId}">
        //                             <h5 class="panel-title">
        //                                 <div style="display: inline-block; margin-right: 10px;">
        //                                     <input id="isic_${item.id}" class="isic_check" type="checkbox" name="isic_checkbox[]"
        //                                         value="${item.id}" data-id="${item.id}">
        //                                     <label for="isic_${item.id}">
        //                                         <span style="font-size:17px !important">ISIC#${item.isic_code}: ${item.description_th}</span>
        //                                     </label>
        //                                 </div>
        //                                 ${item.categories.length > 0 ? `
        //                                     <a role="button" data-toggle="collapse" class="accordion-plus-toggle collapsed"
        //                                         data-parent="#${accordionId}"
        //                                         href="#${collapseId}"
        //                                         aria-expanded="false"
        //                                         aria-controls="${collapseId}"
        //                                         id="${panelId}" 
        //                                         data-isic="${item.id}"
        //                                         style="position: relative; top:-10px;">
        //                                     </a>
        //                                 ` : ''}
        //                             </h5>
        //                         </div>
        //                         <div id="${collapseId}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="${headingId}">
        //                             <div class="panel-body" style="padding:0">
        //                                 <div class="categories-list">
        //                                     ${item.categories.map(category => {
        //                                         return `
        //                                             <ul>
        //                                                 <li style="list-style: none; margin-bottom: 5px;">
        //                                                     <input id="category_${category.id}" class="category_check" type="checkbox" 
        //                                                         name="category_checkbox[${panelId}][${category.id}][]" value="${category.id}" data-id="${category.id}">
        //                                                     <label for="category_${category.id}">
        //                                                         <span style="font-size:16px !important">${category.description_th}</span>
        //                                                     </label>
        //                                                 </li>
        //                                                 ${category.subcategories.map(subcategory => {
        //                                                     return `
        //                                                         <ul style="padding-left: 20px;">
        //                                                             <li style="list-style: none; margin-bottom: 5px;">
        //                                                                 <input id="subcategory_${subcategory.id}" class="subcategory_check" type="checkbox" 
        //                                                                     name="subcategory_checkbox[${panelId}][${category.id}][${subcategory.id}][]" value="${subcategory.id}" 
        //                                                                     data-id="${subcategory.id}" data-category-id="${category.id}">
        //                                                                 <label for="subcategory_${subcategory.id}">
        //                                                                     <span style="font-size:16px !important">${subcategory.description_th}</span>
        //                                                                 </label>
        //                                                             </li>
        //                                                         </ul>
        //                                                     `;
        //                                                 }).join('')}
        //                                             </ul>
        //                                         `;
        //                                     }).join('')}
        //                                 </div>
        //                             </div>
        //                         </div>
        //                     </div>
        //                 `;
        //             });

        //             accordionHtml += `</div>`;
        //             accordionWrapper.append(accordionHtml);
        //             console.log(selectedIsicData)
        //                     // ทำการเช็คค่า checkbox หลังจาก UI สร้างเสร็จ
        //             selectedIsicData.forEach(function(isic) {
        //                 var panelId = `panel_${isic.isic_id}`;
        //                 $(`#isic_${isic.isic_id}`).prop('checked', true);  // เช็ค ISIC checkbox

        //                 isic.categories.forEach(function(category) {
        //                     // เช็ค checkbox ของ category
        //                     $(`#${panelId} .category_check[data-id="${category.category_id}"]`).prop('checked', category.is_checked);
        //                     category.subcategories.forEach(function(subcategory) {
        //                         // เช็ค checkbox ของ subcategory
        //                         $(`#subcategory_${subcategory.subcategory_id}`).prop('checked', subcategory.is_checked);
        //                     });
        //                 });
        //             });

        //                 $(document).on('click', '#button_add_cb_scope_isic_isic', function() {
        //                     $('.panel').each(function() {
        //                         var panelId = $(this).attr('id');
        //                         var isicId = $(this).data('id'); // panel มี data-isic-id เป็น isic_code

        //                         var isIsicChecked = $(`#${panelId} .isic_check`).prop('checked');
        //                         if (isIsicChecked) {
        //                             // กรองข้อมูลจาก result ที่มี isic_id ตรงกับ isicId ที่เลือก
        //                             var isic = result.find(item => item.id == isicId); // กรอง isic ตาม isic_id ที่ตรง
        //                             if (isic) {
        //                                 // สร้างข้อมูลสำหรับ JSON
        //                                 var isicData = {
        //                                     isic_id: isic.id,
        //                                     categories: isic.categories.map(category => {
        //                                         return {
        //                                             category_id: category.id,
        //                                             subcategories: category.subcategories.map(subcategory => {
        //                                                 return {
        //                                                     subcategory_id: subcategory.id,
        //                                                     is_checked: $(`#subcategory_${subcategory.id}`).prop('checked') // เช็คว่า subcategory ถูกเลือกหรือไม่
        //                                                 };
        //                                             }),
        //                                             is_checked: $(`#category_${category.id}`).prop('checked') // เช็คว่า category ถูกเลือกหรือไม่
        //                                         };
        //                                     })
        //                                 };
        //                                 selectedIsicData.push(isicData);
        //                             }
        //                         }
        //                     });
        //                     console.log(JSON.stringify(selectedIsicData, null, 2));
        //                     $('#modal-add-cb-scope-isic-isic').modal('hide');

        //                 });
        //         }
        //     });

        //     $('#modal-add-cb-scope-isic-isic').modal('show');
        // }

        // function addCbScopeBcmsModel()
        // {
        //     const _token = $('input[name="_token"]').val();
        //     console.log(selectedModel,_token)

        //     $.ajax({
        //         url: "{{route('applicant_cb.get_cb_bcms_scope')}}",
        //         method: "POST",
        //         data: {
        //             selectedModel: selectedModel,
        //             _token: _token
        //         },
        //         success: function(result) {
        //             console.log(result);

        //             let tableHtml = `
        //                 <table class="table table-bordered">
        //                     <thead>
        //                         <tr>
        //                             <th>เลือก</th>
        //                             <th>หมวดหมู่</th>
        //                             <th>กิจกรรม</th>
        //                         </tr>
        //                     </thead>
        //                     <tbody>
        //             `;

        //             result.forEach(item => {
        //                 tableHtml += `
        //                     <tr>
        //                         <td style="text-align:center">
        //                             <input id="bcms_${item.id}" class="bcms_check" type="checkbox" name="bcms_checkbox[]" 
        //                                 value="${item.id}" 
        //                                 data-id="${item.id}" 
        //                                 data-category="${item.category}" 
        //                                 data-activity_th="${item.activity_th}">
        //                         </td>
        //                         <td style="text-align:center">${item.category}</td>
        //                         <td>${item.activity_th}</td>
        //                     </tr>
        //                 `;
        //             });
        //             tableHtml += `</tbody></table>`;
        //             $("#cb_scope_bcms_wrapper").html(tableHtml);

        //             if (selectedBcmsData.length > 0) {
        //                 selectedBcmsData.forEach(function(bcms) {
        //                     $(`#bcms_${bcms.id}`).prop("checked", true);
        //                 });
        //             }

        //             $(document).on('click', '#button_add_cb_scope_bcms', function() {
                          
        //                 $(".bcms_check:checked").each(function () {
        //                     selectedBcmsData.push({
        //                         id: $(this).data("id")
        //                     });
        //                 });
        //                 console.log(selectedBcmsData);
        //                 $('#modal-add-cb-scope-bcms').modal('hide');
        //             });
        //         }
        //     });


        //     $('#modal-add-cb-scope-bcms').modal('show');
        // }

        function addCbScopeBcmsModel() {
            const _token = $('input[name="_token"]').val();
            console.log(selectedModel, _token);

            $.ajax({
                url: "{{route('applicant_cb.get_cb_bcms_scope')}}",
                method: "POST",
                data: {
                    selectedModel: selectedModel,
                    _token: _token
                },
                success: function(result) {
                    console.log(result);

                    let tableHtml = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>เลือก</th>
                                    <th>หมวดหมู่</th>
                                    <th>กิจกรรม</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    result.forEach(item => {
                        tableHtml += `
                            <tr>
                                <td style="text-align:center">
                                    <input id="bcms_${item.id}" class="bcms_check" type="checkbox" name="bcms_checkbox[]" 
                                        value="${item.id}" 
                                        data-id="${item.id}" 
                                        data-category="${item.category}" 
                                        data-activity_th="${item.activity_th}">
                                </td>
                                <td style="text-align:center">${item.category}</td>
                                <td>${item.activity_th}</td>
                            </tr>
                        `;
                    });
                    tableHtml += `</tbody></table>`;
                    $("#cb_scope_bcms_wrapper").html(tableHtml);

                    // โหลดข้อมูลเดิมจาก selectedBcmsData
                    if (selectedBcmsData.length > 0) {
                        selectedBcmsData.forEach(function(bcms) {
                            $(`#bcms_${bcms.id}`).prop("checked", true);
                        });
                    }

                    // ฟังก์ชันอัพเดท selectedBcmsData
                    function updateSelectedBcmsData() {
                        selectedBcmsData = []; // เคลียร์ข้อมูลเก่า

                        $(".bcms_check:checked").each(function() {
                            var $this = $(this);
                            selectedBcmsData.push({
                                id: $this.data("id")
                            });
                        });
                    }

                    // Event listener สำหรับการเปลี่ยนแปลง checkbox
                    $(document).on('change', '.bcms_check', function() {
                        updateSelectedBcmsData();
                        console.log(JSON.stringify(selectedBcmsData, null, 2));
                    });

                    // เมื่อกดบันทึก
                    $(document).on('click', '#button_add_cb_scope_bcms', function() {
                        updateSelectedBcmsData(); // อัพเดทข้อมูลล่าสุด
                        console.log(JSON.stringify(selectedBcmsData, null, 2));
                        $('#modal-add-cb-scope-bcms').modal('hide');
                    });
                }
            });

            $('#modal-add-cb-scope-bcms').modal('show');
        }

        $(document).on('change', '.isic_check', function() {
            var panelId = $(this).closest('.panel').attr('id');  // หาค่า panelId
            console.log(panelId);  // ดูค่า panelId ใน console
            
            if (!panelId) {
                // ถ้าไม่พบ panelId ให้ลองใช้ .parents()
                panelId = $(this).parents('.panel').attr('id');
                console.log(panelId); // ดูค่า panelId ที่ได้จาก .parents()
            }

            // ตรวจสอบว่า checkbox ของ panel ถูกเลือกหรือไม่
            var isChecked = $(this).prop('checked');
            
            // เลือกหรือยกเลิกการเลือก checkbox ของ category ใน panel นี้
            $(`#${panelId} .category_check`).prop('checked', isChecked);
            
            // เลือกหรือยกเลิกการเลือก checkbox ของ subcategory ใน panel นี้
            $(`#${panelId} .subcategory_check`).prop('checked', isChecked);
        });


        // เมื่อเลือกหรือยกเลิกการเลือก checkbox ของ category
        $(document).on('change', '.category_check', function() {
            var panelId = $(this).closest('.panel').attr('id'); // หาค่า panelId
            var categoryId = $(this).data('id'); // หาค่า categoryId

            // ตรวจสอบว่า checkbox ของ panel ถูกเลือกหรือไม่
            var panelChecked = $(`#${panelId} .isic_check`).prop('checked');

            // ถ้า checkbox ของ panel ไม่ถูกเลือก จะไม่สามารถเลือก category ได้
            if (!panelChecked) {
                $(this).prop('checked', false); // ยกเลิกการเลือก checkbox ของ category
                return; // ไม่ทำอะไรต่อ
            }

            // ตรวจสอบว่า checkbox ของ category ถูกเลือกหรือไม่
            var isChecked = $(this).prop('checked');

            // ตรวจสอบว่ามี subcategory หรือไม่
            var subcategories = $(`#${panelId} .subcategory_check[data-category-id="${categoryId}"]`);
            
            if (subcategories.length > 0) {
                // เลือกหรือยกเลิกการเลือก checkbox ของ subcategory ที่อยู่ภายใน category นี้
                subcategories.prop('checked', isChecked);
            }
        });

        // เมื่อเลือกหรือยกเลิกการเลือก checkbox ของ subcategory
        $(document).on('change', '.subcategory_check', function() {
            var panelId = $(this).closest('.panel').attr('id'); // หาค่า panelId
            var categoryId = $(this).data('category-id'); // หาค่า categoryId

            // ตรวจสอบว่า checkbox ของ category ใน panel นี้ถูกเลือกหรือไม่
            var categoryChecked = $(`#${panelId} .category_check[data-id="${categoryId}"]`).prop('checked');
            
            // ถ้า checkbox ของ category ไม่ถูกเลือก, ไม่ให้เลือกหรือยกเลิกการเลือก subcategory
            if (!categoryChecked) {
                $(this).prop('checked', false); // ยกเลิกการเลือก checkbox ของ subcategory
                return; // ไม่ทำอะไรต่อ
            }

            // ตรวจสอบว่า checkbox ของ subcategory ถูกเลือกหรือไม่
            var isChecked = $(this).prop('checked');
            
            // ตรวจสอบสถานะของ checkbox subcategory ทั้งหมด
            var allSubcategoriesChecked = $(`#${panelId} .subcategory_check[data-category-id="${categoryId}"]`).length === $(`#${panelId} .subcategory_check[data-category-id="${categoryId}"]:checked`).length;
            
            // เลือกหรือยกเลิกการเลือก checkbox ของ category ถ้าทุก subcategory ถูกเลือก
            // แก้ไขตรงนี้: ไม่ควรอัพเดท category_check จากการเลือก subcategory
            // if (allSubcategoriesChecked) {
            //     // หากทุก subcategory ถูกเลือก ให้เลือก checkbox ของ category
            //     $(`#${panelId} .category_check[data-id="${categoryId}"]`).prop('checked', true);
            // } else {
            //     // หากไม่ครบ ให้ยกเลิกการเลือก checkbox ของ category
            //     $(`#${panelId} .category_check[data-id="${categoryId}"]`).prop('checked', false);
            // }
        });



        // เมื่อเลือกหรือยกเลิกการเลือก checkbox 'toggle-all-panel-checkbox'
        $(document).on('change', '#toggle-all-panel-checkbox', function() {
            var isChecked = $(this).prop('checked');  // ตรวจสอบว่า checkbox ถูกเลือกหรือไม่

            // เปลี่ยนสถานะ checkbox ทั้งหมดในทุก panel ที่เกี่ยวข้อง
            $('.panel .isic_check').prop('checked', isChecked);  // เปลี่ยนสถานะ checkbox ของ ISIC ทั้งหมด
            $('.panel .category_check').prop('checked', isChecked);  // เปลี่ยนสถานะ checkbox ของ Category ทั้งหมด
            $('.panel .subcategory_check').prop('checked', isChecked);  // เปลี่ยนสถานะ checkbox ของ Subcategory ทั้งหมด
        });

        $(document).on('change', '#toggle-all-cbms-checkbox', function() {
            const isChecked = $(this).prop('checked');
            $(".bcms_check").prop('checked', isChecked);
        });



        $('#button_store_cb_scope_isic_isic').on('click', function() {
            const _token = $('input[name="_token"]').val();

            if (!selectedIsicData.length) {
                console.warn('ไม่มีข้อมูลให้บันทึก!');
                return;
            }

            $.ajax({
                url: "{{ route('applicant_cb.demo_store_cb_isic_scope') }}",
                method: "POST",
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: JSON.stringify({ selectedIsicData: selectedIsicData }),
                success: function(response) {
                    console.log(response.message);
                    alert('บันทึกข้อมูลสำเร็จ!');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                }
            });
        });



        $(document).on('click', '#button_load_isic', function() {
            // console.log('aha');
            loadCbScopeIsic();
           
        });

        function loadCbScopeIsic()
        {
            const _token = $('input[name="_token"]').val();
            cbId = certi_cb.id;
            if(cbId == undefined){
                return;
            }
            
            // console.log(cbId);
            // return;
            $.ajax({
                url: "{{route('applicant_cb.get_cb_isic_scope_transaction')}}",
                method: "POST",
                data: {
                    cbId: cbId,
                    _token: _token
                },

                success: function(data) {
                    console.log(data);
                    selectedIsicData = []; // ล้างข้อมูลเก่า

                    data.forEach(function(isic) {
                        let isicData = {
                            isic_id: isic.isic_id,
                            categories: isic.cb_scope_isic_category_transactions.map(category => ({
                                category_id: category.category_id,
                                subcategories: category.cb_scope_isic_sub_category_transactions.map(subcategory => ({
                                    subcategory_id: subcategory.subcategory_id,
                                    is_checked: subcategory.is_checked
                                })),
                                is_checked: category.is_checked
                            }))
                        };

                        selectedIsicData.push(isicData);
                    });

                    // console.log(JSON.stringify(selectedIsicData, null, 2)); // ตรวจสอบผลลัพธ์
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        
        $('#button_store_cb_scope_bcms').on('click', function() {
            const _token = $('input[name="_token"]').val();

            if (!selectedBcmsData.length) {
                console.warn('ไม่มีข้อมูลให้บันทึก!');
                return;
            }

            $.ajax({
                url: "{{ route('applicant_cb.demo_store_cb_bcms_scope') }}",
                method: "POST",
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: JSON.stringify({ selectedBcmsData: selectedBcmsData }),
                success: function(response) {
                    console.log(response.message);
                    alert('บันทึกข้อมูลสำเร็จ!');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                }
            });
        });

        $(document).on('click', '#button_load_bcms', function() {
            loadCbScopeBcms();
        });

        function loadCbScopeBcms()
        {
            const _token = $('input[name="_token"]').val();
            cbId = certi_cb.id;
            if(cbId == undefined){
                return;
            }
            
            $.ajax({
                url: "{{route('applicant_cb.get_cb_bcms_scope_transaction')}}",
                method: "POST",
                data: {
                    cbId: cbId,
                    _token: _token
                },
                success: function(data) {
                    selectedBcmsData = []; // ล้างข้อมูลเก่า

                    data.forEach(function(bcms) {
                        selectedBcmsData.push({
                            id: bcms.bcms_id // ใช้ bcms_id ตามโครงสร้างของตาราง
                        });

                        // เช็คและติ๊ก checkbox ที่ตรงกับข้อมูลที่โหลดมา
                        $(`#bcms_${bcms.bcms_id}`).prop("checked", true);
                    });

                    // console.log(JSON.stringify(selectedBcmsData, null, 2)); // ตรวจสอบผลลัพธ์
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }



    </script>
@endpush