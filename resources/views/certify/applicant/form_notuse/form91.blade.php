@push('css')
    <link href="{{asset('plugins/components/summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
<div id="viewForm91" style="display: none">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4><span class="text-danger">*</span> 6. ขอบข่ายที่ยื่นขอรับการรับรอง (<span class="text-warning">ห้องปฏิบัติการสอบเทียบ</span>) (Scope of Accreditation Sought (<span class="text-warning">For calibration laboratory</span>)) <span class="text-danger">ไฟล์แนบ Word</span><span class="text-danger" style="font-size: 13px;"> (doc,docx)</span></h4></legend>
                <input type="hidden" name="bound_Certificate_calibrate" id="bound_Certificate_calibrate">
{{-- 
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="branch_lab_calibrate">สาขาการสอบเทียบ: </label>
                        {!! Form::select('branch_lab_calibrate',
                        [],
                        null,
                        ['class' => 'form-control', 'id'=>'branch_lab_calibrate',
                          'placeholder' =>'- สาขาสอบเทียบ -']) !!}
                         {!! $errors->first('branch_lab_calibrate', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_calibrate">หมวดหมู่รายการสอบเทียบ: </label>
                        {!! Form::select('type_calibrate',
                        [],
                        null,
                         ['class' => 'form-control', 'id'=>'type_calibrate',
                           'placeholder' =>'- หมวดหมู่รายการสอบเทียบ -']) !!}
                         {!! $errors->first('type_calibrate', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 m-t-10">
            <button type="button" class="btn btn-primary pull-right m-l-5" id="add_CalibrateTable">เพิ่มรายการ</button>
        </div>
    </div> --}}
    <div class="row form-group">
        <label class="col-sm-2 text-right" for="branch_lab_test">สาขาการสอบเทียบ: </label>
        <div class="col-sm-6">
            {!! Form::select('branch_lab_calibrate',
            [],
            null, 
            ['class' => 'form-control', 'id'=>'branch_lab_calibrate',
              'placeholder' =>'- สาขาสอบเทียบ -']) !!}
             {!! $errors->first('branch_lab_calibrate', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-2  text-right">
                   <button type="button" class="btn btn-primary m-t-12" id="add_CalibrateTable">เพิ่มรายการ</button>
       </div>
      </div>

      <div class="row">
        <div class="col-md-10">
            <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
                <table class="table table-bordered" id="myTable_labCalibrate">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white "  width="10%">ลำดับ</th>
                        <th class="text-center text-white "  width="70%">สาขาการสอบเทียบ</th>
                        {{-- <th class="text-center text-white col-xs-1">หมวดหมู่รายการสอบเทียบ</th> --}}
                        <th class="text-center text-white"  width="10%">ลบรายการ</th>
                    </tr>
                    </thead>
                    <tbody id="labCalibrate_tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div id="other_attach-box62">
                <div class="form-group other_attach_item62">
                    <div class="col-md-4 text-light">
                        <label for="#" class="label_other_attach62 ctext-light">กรุณาแนบไฟล์ขอบข่ายที่ต้องการยื่นขอการรับรอง   
                            {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">เลือกไฟล์</span>
                                <span class="fileinput-exists">เปลี่ยน</span> 
                                <input type="file" accept=".doc,.docx" name="attachs_sec62[]" class="attachs_sec62 check_max_size_file">
                            </span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                        </div>
                    </div>
                    <div class="col-md-2 text-left">
                        <button type="button" class="btn btn-sm btn-success attach-add62" id="attach-add62">
                            <i class="icon-plus"></i>&nbsp;เพิ่ม
                        </button>
                        <div class="button_remove62"></div>
                    </div>
                </div>
               </div>
        </div>
    </div>


          </div>
       </div>
    </div>
</div>


@push('js')
<script src="{{ asset('plugins/components/summernote/summernote.js') }}"></script>
<script src="{{ asset('plugins/components/summernote/summernote-ext-specialchars.js') }}"></script>

<script>

    $(document).ready(function () {

        //เพิ่มไฟล์แนบ
        $('#attach-add62').click(function(event) {
            $('.other_attach_item62:first').clone().appendTo('#other_attach-box62');

            $('.other_attach_item62:last').find('input').val('');
            $('.other_attach_item62:last').find('a.fileinput-exists').click();
            $('.other_attach_item62:last').find('a.view-attach').remove();
            $('.other_attach_item62:last').find('.label_other_attach62').remove();
            $('.other_attach_item62:last').find('button.attach-add62').remove();
            $('.other_attach_item62:last').find('.button_remove62').html('<button class="btn btn-danger btn-sm attach-remove62" type="button"> <i class="icon-close"></i>  </button>');
            // ShowHideRemoveBtn91();
            AttachFile62();
            check_max_size_file();
        });

        //ลบไฟล์แนบ
        $('body').on('click', '.attach-remove62', function(event) {
            $(this).parent().parent().parent().remove();
            // ShowHideRemoveBtn91();
        });

        // ShowHideRemoveBtn91();
        AttachFile62();
    });

    // function ShowHideRemoveBtn91() { //ซ่อน-แสดงปุ่มลบ

    //     if ($('.other_attach_item62').length > 1) {
    //         $('.attach-remove62').show();
    //     } else {
    //         $('.attach-remove62').hide();
    //     }

    // }

        //  Attach File
          function  AttachFile62(){
            $('.attachs_sec62').change( function () {
                    var fileExtension = ['docx','doc'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1  && $(this).val() != '') {
                        Swal.fire(
                        'ไม่ใช่หลักฐานประเภทไฟล์ที่อนุญาต .doc หรือ .docx',
                        '',
                        'info'
                        )
                    this.value = '';
                    return false;
                    }
                });
        }
</script>

    <script>

        var sendToBoundCalibrate = [];
        var cacheInputCalibrate = [];
        var thisFormula = [];
        var nowCalibrateList ;
        var click_calibrate_edit = null;
        var click_calibrate_list_edit = null;
        $(document).ready(function () {

            // $(".checkLab").attr('checked',false);

            let nowEditCalibrate = null;
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            // $('#formula_technical').on('keyup',function (e) {
            //     e.preventDefault();
            //     let word = $(this).val();
            //     if (word !== ''){
            //         if (e.keyCode === 13){
            //             let list_calibrate = $('#calibrate_list').find('option:selected').val();
            //             let list_calibrate_text = $('#calibrate_list').find('option:selected').text();
            //             if (checkNone(list_calibrate) && checkNone(word)){
            //                 let token = stringRandom();
            //                 $('#formula_adding_div').show(300);
            //                 $('#formula_standard').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+token+'" ' +
            //                     'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="'+word+'">'+list_calibrate_text+' - '+word+'<span class="formulaDel text-danger" style="cursor: pointer">&emsp;x</span>');
            //                 thisFormula.push({list:list_calibrate,list_text:list_calibrate_text,formula:word,token:token});
            //                 $(this).val('');
            //             }else{
            //                 alert('กรุณาเลือกรายการสอบเทียบ!')
            //             }
            //         }
            //     }
            // });

            $('#formula_technical').summernote({
            toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']]
            ]
            });

            // summernote.enter
            $('#formula_technical').on('summernote.enter', function() {
                // var contents = $('#formula_technical').summernote('code');
                     var contents = $($("#formula_technical").summernote("code")).html();

                    while(contents.startsWith('<p>')){
                        contents=contents.replace('<p>','')
                    }

                    while(contents.endsWith('<br></p>')){
                        contents=contents.replace(new RegExp('<br></p>$'),'')
                    }

                    while(contents.endsWith('<br>')){
                        contents=contents.replace(new RegExp('<br>$'),'')
                    }

                    let token = stringRandom();
                    let list_calibrate = $('#calibrate_list').find('option:selected').val();
                    let list_calibrate_text = $('#calibrate_list').find('option:selected').text();
                    if (checkNone(list_calibrate) && checkNone(contents)){
                            $('#formula_adding_div').show(300);
                            $('#formula_standard').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+token+'" ' +
                                 'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="'+contents+'">'+list_calibrate_text+' - '+contents+'<span class="formulaDel text-danger" style="cursor: pointer">&emsp;x</span>');
                             thisFormula.push({list:list_calibrate,list_text:list_calibrate_text,formula:contents,token:token});
                    $("#formula_technical").summernote('reset');
                    $("#formula_technical").html('');
                    $("#formula_technical").summernote('destroy');
                    $("#formula_technical").val('');
                    $('#formula_technical').summernote({
                    toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']]
                    ],
                    focus: true,
                    });
                    $("#formula_technical").html('');
                } else {
                    $("#formula_technical").summernote('reset');
                    $("#formula_technical").html('');
                    $("#formula_technical").summernote('destroy');
                    $("#formula_technical").val('');
                    $('#formula_technical').summernote({
                    toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']]
                    ],
                    focus: true,
                    });
                    $("#formula_technical").html('');
                    alert('กรุณาเลือกรายการสอบเทียบ!')
                }

            });

            $('#calibrate_detail_inType').summernote({
            toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']]
            ]
            });

            $('#limit_calibrate').summernote({
            toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']]
            ]
            });

            $(document).on('click', '.formulaDel', function () {
                let parent = $(this).parent();
                let find = thisFormula.find(value => value.token  === parent.attr('data-token'));
                let index_find = thisFormula.indexOf(find);
                thisFormula.splice(index_find,1);
                parent.remove();
                console.log(thisFormula);
            });

            $('#btn_add_calibrate_detail').on('click',function () {
                let token = stringRandom();
                $('#add_calibrate_detail_div').show(200);

                let calibrate_list = $('#calibrate_list').find('option:selected').text();
                let calibrate_list_val = $('#calibrate_list').find('option:selected').val();
                // let calibrate_detail_inType = $('#calibrate_detail_inType').val();
                let calibrate_detail_inType = $('#calibrate_detail_inType').summernote('code');
                // let limit_calibrate = $('#limit_calibrate').val();
                let limit_calibrate = $('#limit_calibrate').summernote('code');

                // if (checkNone(calibrate_detail_inType) && checkNone(limit_calibrate) && checkNone(calibrate_list_val)){
                if (checkNone(calibrate_detail_inType)){
                    if (nowCalibrateList !== calibrate_list){
                        $('#calibrate_detail_div').append('<p style="font-weight: bold" data-list="'+calibrate_list+'">'+calibrate_list+'</p>');
                    }
                    nowCalibrateList = calibrate_list;

                    $('#calibrate_detail_div').append('<div class="col-md-12 calibrate_data_div" data-token="'+token+'">\n' +
                        '    <div class="row">\n' +
                        '        <div class="col-md-5">\n' +
                        '            <div class="form-group">\n' +
                        '                <input type="text" class="form-control toEditCalibrateDetail" data-token="'+token+'" value="'+calibrate_detail_inType+'">\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="col-md-5">\n' +
                        '            <div class="form-group">\n' +
                        '                <input type="text" class="form-control toEditLimit" data-token="'+token+'" value="'+limit_calibrate+'">\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="col-md-1">\n' +
                        '            <div class="form-group">\n' +
                        '                <button type="button" class="btn btn-warning btn-block editCalibrateDetail" data-token="'+token+'">แก้ไข</button>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="col-md-1">\n' +
                        '            <div class="form-group">\n' +
                        '                <button type="button" class="btn btn-danger btn-block delCalibrateDetail" data-token="'+token+'">ลบ</button>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '    </div>\n' +
                        '</div>');

                            $('input.toEditCalibrateDetail[data-token="'+token+'"]').summernote({
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']]
                                ]
                            });

                            $('input.toEditCalibrateDetail[data-token="'+token+'"]').summernote('code', calibrate_detail_inType);
                            $('input.toEditCalibrateDetail[data-token="'+token+'"]').summernote('disable');

                            $('input.toEditLimit[data-token="'+token+'"]').summernote({
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']]
                                ]
                            });

                            $('input.toEditLimit[data-token="'+token+'"]').summernote('code', limit_calibrate);
                            $('input.toEditLimit[data-token="'+token+'"]').summernote('disable');

                                // var contents_calibrate_detail_inType = $($("#calibrate_detail_inType").summernote("code")).html();
                                var contents_calibrate_detail_inType = $($('input.toEditCalibrateDetail[data-token="'+token+'"]').summernote("code")).html();
                                while(contents_calibrate_detail_inType.startsWith('<p>')){
                                    contents_calibrate_detail_inType=contents_calibrate_detail_inType.replace('<p>','')
                                }
                                while(contents_calibrate_detail_inType.endsWith('<br></p>')){
                                    contents_calibrate_detail_inType=contents_calibrate_detail_inType.replace(new RegExp('<br></p>$'),'')
                                }
                                while(contents_calibrate_detail_inType.endsWith('<br>')){
                                    contents_calibrate_detail_inType=contents_calibrate_detail_inType.replace(new RegExp('<br>$'),'')
                                }

                                // var contents_limit_calibrate = $($("#limit_calibrate").summernote("code")).html();
                                var contents_limit_calibrate = $($('input.toEditLimit[data-token="'+token+'"]').summernote("code")).html();
                                while(contents_limit_calibrate.startsWith('<p>')){
                                    contents_limit_calibrate=contents_limit_calibrate.replace('<p>','')
                                }
                                while(contents_limit_calibrate.endsWith('<br></p>')){
                                    contents_limit_calibrate=contents_limit_calibrate.replace(new RegExp('<br></p>$'),'')
                                }
                                while(contents_limit_calibrate.endsWith('<br>')){
                                    contents_limit_calibrate=contents_limit_calibrate.replace(new RegExp('<br>$'),'')
                                }


                    cacheInputCalibrate.push({calibrate_list:calibrate_list,calibrate_list_val:calibrate_list_val,detail:contents_calibrate_detail_inType,limit:contents_limit_calibrate,token:token});

                    // $('#calibrate_detail_inType').val('');
                    $("#calibrate_detail_inType").summernote('reset');
                    $("#calibrate_detail_inType").html('');
                    $("#calibrate_detail_inType").summernote('destroy');
                    $("#calibrate_detail_inType").val('');
                    $('#calibrate_detail_inType').summernote({
                    toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']]
                    ],
                    focus: true,
                    });
                    $("#calibrate_detail_inType").html('');

                    // $('#limit_calibrate').val('');
                    $("#limit_calibrate").summernote('reset');
                    $("#limit_calibrate").html('');
                    $("#limit_calibrate").summernote('destroy');
                    $("#limit_calibrate").val('');
                    $('#limit_calibrate').summernote({
                    toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']]
                    ],
                    focus: true,
                    });
                    $("#limit_calibrate").html('');
                }else{
                    alert('กรุณาใส่ข้อมูลให้ครบ!  88')
                }
            });

            $(document).on('click','.delCalibrateDetail',function () {
                let the_token = $(this).attr('data-token');
                let theDiv = $(this).parent().parent().parent().parent();
                let find = cacheInputCalibrate.find(value => value.token  === the_token);
                let index_find = cacheInputCalibrate.indexOf(find);
                cacheInputCalibrate.splice(index_find,1);
                theDiv.remove();
                console.log(cacheInputCalibrate);
                let findList = cacheInputCalibrate.find(value => value.calibrate_list  === find.calibrate_list); // ลบเอา list ออกถ้ามันหมด
                if (findList === undefined){
                    to_remove = $('#calibrate_detail_div').find('p[data-list="' + find.calibrate_list + '"]').remove();
                    nowCalibrateList = null;
                }
            });

            $(document).on('click','.editCalibrateDetail',function () {
                $(this).text('ยืนยัน');
                $(this).removeClass('editCalibrateDetail').removeClass('btn-warning').addClass('saveEditCalibrateDetail').addClass('btn-success');
                let this_parent = $(this).parent().parent().parent();
                // this_parent.find('input').prop('readonly',false);
                this_parent.find('input.toEditCalibrateDetail').summernote('enable')
                this_parent.find('input.toEditLimit').summernote('enable')
            });

            $(document).on('click','.saveEditCalibrateDetail',function () {
                let the_token = $(this).attr('data-token');
                let find = cacheInputCalibrate.find(value => value.token  === the_token);
                let index_find = cacheInputCalibrate.indexOf(find);
                let this_parent = $(this).parent().parent().parent();
                // let new_detailValue = this_parent.find('input.toEditCalibrateDetail').val();
                let new_detailValue = this_parent.find('input.toEditCalibrateDetail').summernote('code');
                // let new_LimitValue = this_parent.find('input.toEditLimit').val();
                let new_LimitValue = this_parent.find('input.toEditLimit').summernote('code');
                find.detail = new_detailValue;
                find.limit = new_LimitValue;
                cacheInputCalibrate[index_find] = find;
                // แก้เสร็จคืนค่า
                $(this).text('แก้ไข');
                $(this).removeClass('saveEditCalibrateDetail').removeClass('btn-success').addClass('editCalibrateDetail').addClass('btn-warning');
                // this_parent.find('input').prop('readonly',true);
                this_parent.find('input.toEditCalibrateDetail').summernote('disable')
                this_parent.find('input.toEditLimit').summernote('disable')
            });

            $(document).on('click','.inTypeDeleteCalibrate',function () {
               let the_token = $(this).attr('data-token');
               let branch = $(this).attr('data-branch');
               let find = sendToBoundCalibrate.find(value => value.token  === the_token);
               let index_find = sendToBoundCalibrate.indexOf(find);
               sendToBoundCalibrate.splice(index_find,1);
               $('#bound_Certificate_calibrate').attr('value',JSON.stringify(sendToBoundCalibrate));
               writeTableCalibrate();
               $("#branch_lab_calibrate option[value=" + branch + "]").prop('disabled', false); //  เปิดรายการ หมวดหมู่ผลิตภัณฑ์
            });

            $(document).on('click','.inTypeEditCalibrate',function () {
               let the_token = $(this).attr('data-token');
               let find = sendToBoundCalibrate.find(value => value.token  === the_token);
               let index_find = sendToBoundCalibrate.indexOf(find);
               nowEditCalibrate = find;
               cacheInputCalibrate = [];
               thisFormula = [];
               nowCalibrateList = null;
               clearInputLabCalibrate();

               $('#branch_lab_calibrate').val(find.branch).change();
               click_calibrate_edit = find.type;

               $('#add_CalibrateTable').hide(300);
               $('#clear_lab_calibrate').hide(300);
               $('#edit_save_cilibrate').show(300);
               $('#cancel_edit_calibrate').show(300);

               console.log(find.calibrate_information);

               $.each(find.calibrate_information,function (key,val) { // เอาค่ากลับคืน array และไปโชว์ที่ input
                   let list_text = val.list;
                   let list_val = val.list_val;
                   click_calibrate_list_edit = val.list_val;
                   $.each(val.detail,function (k,v) {
                       let token = stringRandom();
                       cacheInputCalibrate.push({calibrate_list:list_text,calibrate_list_val:list_val,detail:v.detail,limit:v.limit,token:token});
                   });
                   $.each(val.formula,function (k,v) {
                       let token = stringRandom();
                       thisFormula.push({list:list_val,list_text:list_text,formula:v,token:token});
                   });
               });
               writeTheCalibrateDetail();
               writeTheFormula();
               // ต่อไปเอาไปแสดงข้างบน แล้วอัพเดท และสร้างลงตารางเหมือนเดิม
            });

            $(document).on('click','#edit_save_cilibrate',function () {
                let branch_lab_calibrate = $('#branch_lab_calibrate').find('option:selected').val();
                let branch_lab_text = $('#branch_lab_calibrate').find('option:selected').text();
                let type_calibrate = $('#type_calibrate').find('option:selected').val();
                let type_calibrate_text = $('#type_calibrate').find('option:selected').text();

                if (checkNone(branch_lab_calibrate) && checkNone(type_calibrate)){
                    if (cacheInputCalibrate.length > 0 && thisFormula.length > 0){

                        sortLabCalibrateCache();
                        let list_array = [];
                        $.each(cacheInputCalibrate,function (key,value) {
                            //let find = list_array.includes(value.calibrate_list);
                            let list_text = value.calibrate_list;
                            let find = list_array.find(value => value.list  === list_text);
                            if (find === undefined || find === false){
                                list_array.push({list:value.calibrate_list,list_val:value.calibrate_list_val});
                            }
                        });

                        let all_information = [];
                        $.each(list_array,function (key,val) {
                            let list = val.list;
                            let all_formula = [];
                            let all_detail = [];
                            $.each(thisFormula,function (key,val) {
                                if (val.list_text === list){
                                    all_formula.push(val.formula);
                                }
                            });
                            $.each(cacheInputCalibrate,function (key,val) {
                                if (val.calibrate_list === list){
                                    let detail = {
                                        detail:val.detail,
                                        limit:val.limit
                                    };
                                    all_detail.push(detail);
                                }
                            });
                            let obj = {
                                list: val.list,
                                list_val:val.list_val,
                                formula:all_formula,
                                detail:all_detail
                            };
                            all_information.push(obj);
                        });

                        thisFormula = [];
                        cacheInputCalibrate = [];

                        let findInSend = sendToBoundCalibrate.find(value => value.token  === nowEditCalibrate.token);
                        let index_update = sendToBoundCalibrate.indexOf(findInSend);

                        findInSend.branch = branch_lab_calibrate;
                        findInSend.type = type_calibrate;
                        findInSend.branch_text = branch_lab_text;
                        findInSend.type_text = type_calibrate_text;
                        findInSend.calibrate_information = all_information;

                        sendToBoundCalibrate[index_update] = findInSend;
                        $('#bound_Certificate_calibrate').attr('value',JSON.stringify(sendToBoundCalibrate));
                        writeTableCalibrate();

                        $('#add_CalibrateTable').show(300);
                        $('#clear_lab_calibrate').show(300);
                        $('#edit_save_cilibrate').hide(300);
                        $('#cancel_edit_calibrate').hide(300);
                        nowEditCalibrate = null;
                        nowCalibrateList = null;
                    }else{
                        alert('กรุณาใส่ข้อมูลให้ครบ!');
                    }
                }else{
                    alert('กรุณาใส่ข้อมูลให้ครบ!');
                }
            });

            $(document).on('click','#cancel_edit_calibrate',function () {
                $('#add_CalibrateTable').show(300);
                $('#clear_lab_calibrate').show(300);
                $('#edit_save_cilibrate').hide(300);
                $('#cancel_edit_calibrate').hide(300);
                cacheInputCalibrate = [];
                thisFormula = [];
                nowCalibrateList = null;
                clearInputLabCalibrate();
            });

            /////////////////////// เพิ่มลง ตาราง ///////////////////////////
            $('#add_CalibrateTable').on('click',function () {
                let branch_lab_calibrate = $('#branch_lab_calibrate').find('option:selected').val();
                let branch_text = $('#branch_lab_calibrate').find('option:selected').text();
                let type_calibrate = $('#type_calibrate').find('option:selected').val();
                let type_text = $('#type_calibrate').find('option:selected').text();

                if (checkNone(branch_lab_calibrate)  && branch_lab_calibrate != '- สาขาสอบเทียบ -'){
                    addLabCalibrate(branch_lab_calibrate, type_calibrate, branch_text, type_text);
                }else{
                    alert('กรุณาเลือกสาขาสอบเทียบ!');
                }
            });

        });

        function addLabCalibrate(branch,type,branch_text,type_text) {
            let token = stringRandom();
            sortLabCalibrateCache();
            let list_array = [];
            $.each(cacheInputCalibrate,function (key,value) {
                //let find = list_array.includes(value.calibrate_list);
                let list_text = value.calibrate_list;
                let find = list_array.find(value => value.list  === list_text);
                if (find === undefined || find === false){
                    list_array.push({list:value.calibrate_list,list_val:value.calibrate_list_val});
                }
            });

            let all_information = [];
            $.each(list_array,function (key,val) {
                let list = val.list;
                let all_formula = [];
                let all_detail = [];
                $.each(thisFormula,function (key,val) {
                    if (val.list_text === list){
                        all_formula.push(val.formula);
                    }
                });
                $.each(cacheInputCalibrate,function (key,val) {
                    if (val.calibrate_list === list){
                        let detail = {
                            detail:val.detail,
                            limit:val.limit
                        };
                        all_detail.push(detail);
                    }
                });
                let obj = {
                    list: val.list,
                    list_val:val.list_val,
                    formula:all_formula,
                    detail:all_detail
                };
                all_information.push(obj);
            });

            console.log(cacheInputCalibrate);
            console.log(thisFormula);
            thisFormula = [];
            cacheInputCalibrate = [];

            let newValue = {
                branch:branch,
                type:type,
                branch_text:branch_text,
                type_text:type_text,
                calibrate_information:all_information,
                token:token
            };
            sendToBoundCalibrate.push(newValue);
            $('#bound_Certificate_calibrate').attr('value',JSON.stringify(sendToBoundCalibrate));
            writeTableCalibrate();
        }

        function writeTableCalibrate() {
            let theTable = $('#labCalibrate_tbody');
            theTable.empty();
            $.each(sendToBoundCalibrate,function (key,value) {
                let branch_Text = value.branch_text;
                let type_product_text = value.type_text;

                let this_in_list = '';
                let stringIntype = '';
                let limit_show = '';
                let formula = '';

                $.each(value.calibrate_information,function (key,value) {
                    if (value.list !== this_in_list){
                        // if (key > 0){
                            // stringIntype += '<hr>';
                            // limit_show += '<hr>';
                            // formula += '<hr>';
                        // }
                        stringIntype += '<p style="font-weight: bold">'+'- '+value.list+'</p>';
                        limit_show += '<p>&nbsp;</p>';
                        $.each(value.formula,function (k,v) {
                            formula += '<p>&nbsp;'+v+'</p>';
                        });
                    }
                    let formula_size = value.formula.length;

                    $.each(value.detail,function (k,v) {
                        stringIntype += '<p>'+'&nbsp;&nbsp;• '+v.detail+'</p>';
                        limit_show += '<p>'+'&nbsp;&nbsp;• '+v.limit+'</p>';

                        if (formula_size <= value.detail.length){
                            formula += '<p>&nbsp;</p>';
                            formula_size ++ ;
                        }
                    });
                });

                theTable.append('<tr>\n' +
                    '                    <td class="text-center" style="vertical-align:top">'+parseInt(key+1)+'</td>\n' +
                    '                    <td   style="vertical-align:top">'+branch_Text+'</td>\n' +
                    // '                    <td class="text-center" style="vertical-align:top">'+type_product_text+'</td>\n' +
                    // '                    <td style="vertical-align:top">'+stringIntype+'</td>\n' +
                    // '                    <td style="vertical-align:top">'+limit_show+'</td>\n' +
                    // '                    <td style="vertical-align:top">'+formula+'</td>\n' +
                    '                    <td class="text-center">' +
                    '                       <input type="hidden"  name="calibrate[branch_id][]"    class="calibrate_branch_id" value="'+ value.branch+'">\n' +
                    // '                    <button type="button" class="btn btn-primary btn-xs inTypeEditCalibrate" data-token="'+value.token+'"><i class="fa fa-pencil-square-o"></i></button>\n' +
                    '                    <button type="button" class="btn btn-danger btn-xs inTypeDeleteCalibrate" data-branch="'+value.branch+'"  data-token="'+value.token+'"><i class="fa fa-remove"></i></button></td>\n' +
                    '                </tr>');
             $("#branch_lab_calibrate option[value=" + value.branch + "]").prop('disabled', 'disabled'); //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
             $('#branch_lab_calibrate').val('- สาขาสอบเทียบ -').select2();
            });
            // clearInputLabCalibrate();
            //console.log(sendToBoundCalibrate);
        }

        function clearInputLabCalibrate() {
            $('#branch_lab_calibrate').val('').change();
            $('#type_calibrate').val('').change();
            $('#calibrate_list').val('').change();
            $('#formula_technical').val('');
            $('.calibrate_data_div').remove();
            $('#calibrate_detail_div').empty();
            $('#formula_standard').empty();
            cacheInputCalibrate = [];
            thisFormula = [];
            click_calibrate_edit = null;
            click_calibrate_list_edit = null;
        }

        function sortLabCalibrateCache() {
            cacheInputCalibrate.sort(function(a, b) {
                if ( a.calibrate_list_val < b.calibrate_list_val ){
                    return -1;
                }
                if ( a.calibrate_list_val > b.calibrate_list_val ){
                    return 1;
                }
                return 0;
            });
        }

        function writeTheCalibrateDetail() {
            $('#add_calibrate_detail_div').show(200);
            $.each(cacheInputCalibrate,function (key,value) {
                if (nowCalibrateList !== value.calibrate_list){
                    $('#calibrate_detail_div').append('<p style="font-weight: bold" data-list="'+value.calibrate_list+'">'+value.calibrate_list+'</p>');
                }
                nowCalibrateList = value.calibrate_list;
                $('#calibrate_detail_div').append('<div class="col-md-12 calibrate_data_div" data-token="'+value.token+'">\n' +
                    '    <div class="row">\n' +
                    '        <div class="col-md-5">\n' +
                    '            <div class="form-group">\n' +
                    '                <input type="text" class="form-control toEditCalibrateDetail" data-token="'+value.token+'" value="'+value.detail+'">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-5">\n' +
                    '            <div class="form-group">\n' +
                    '                <input type="text" class="form-control toEditLimit" data-token="'+value.token+'" value="'+value.limit+'">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-1">\n' +
                    '            <div class="form-group">\n' +
                    '                <button type="button" class="btn btn-warning btn-block editCalibrateDetail" data-token="'+value.token+'">แก้ไข</button>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-1">\n' +
                    '            <div class="form-group">\n' +
                    '                <button type="button" class="btn btn-danger btn-block delCalibrateDetail" data-token="'+value.token+'">ลบ</button>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>');

                    $('input.toEditCalibrateDetail[data-token="'+value.token+'"]').summernote({
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']],
                                    ['height', ['height']]
                                ]
                            });

                            $('input.toEditCalibrateDetail[data-token="'+value.token+'"]').summernote('code', value.detail);
                            $('input.toEditCalibrateDetail[data-token="'+value.token+'"]').summernote('disable');

                            $('input.toEditLimit[data-token="'+value.token+'"]').summernote({
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']],
                                    ['height', ['height']]
                                ]
                            });

                            $('input.toEditLimit[data-token="'+value.token+'"]').summernote('code', value.limit);
                            $('input.toEditLimit[data-token="'+value.token+'"]').summernote('disable');

            });
        }

        function writeTheFormula() {
            $('#formula_adding_div').show(300);
            $.each(thisFormula,function (key,value) {
                $('#formula_standard').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+value.token+'" ' +
                    'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="'+value.formula+'">'+value.list_text+' - '+value.formula+'<span class="formulaDel text-danger" style="cursor: pointer">&emsp;x</span>');
            });
        }
    </script>


    <script>
        $('#branch_lab_calibrate').on('change',function () {
            if ($(this).val() !== "0" || $(this).val() !== ""){
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('api.calibrate.items')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#type_calibrate').empty();
                        $('#type_calibrate').append('<option value="">- หมวดหมู่รายการสอบเทียบ -</option>').select2();
                        $.each(result,function (index,value) {
                            $('#type_calibrate').append('<option value='+value.id+' >'+value.title+'</option>');
                        });
                          //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
                            $('#labCalibrate_tbody').children('tr').each(function(index, tr) {
                        var type = $(tr).find('.type_calibrate').val();
                            $("#type_calibrate option[value=" + type + "]").prop("disabled", true);
                        });
                        // $("#type_calibrate").select2("destroy");
                        // $("#type_calibrate").select2();

                        if (click_calibrate_edit !== null){
                            $('#type_calibrate').val(click_calibrate_edit).change();
                        }
                    }
                });

            }


        });

        $('#type_calibrate').on('change',function () {
            if ($(this).val() !== "0" || $(this).val() !== ""){
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('api.calibrate.list')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){

                        $('#calibrate_list').empty();
                        $('#calibrate_list').append('<option value="">- รายการสอบเทียบ -</option>');
                        $.each(result,function (index,value) {
                            $('#calibrate_list').append('<option value='+value.id+' >'+value.title+'</option>');
                        });
                        if (click_calibrate_list_edit !== null){
                            $('#calibrate_list').val(click_calibrate_list_edit).change();
                        }
                    }
                });
            }
        })
    </script>
@endpush
