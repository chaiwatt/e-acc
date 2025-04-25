{{-- work on Certify\ApplicantController --}}
<div id="viewForm90" style="display: none">
    <fieldset class="white-box">
        <legend>
            <h4>
                <span class="text-danger">*</span> 7. ขอบข่ายที่ยื่นขอรับการรับรอง 
                (<span class="text-warning">ห้องปฏิบัติการทดสอบ</span>) (Scope of Accreditation Sought (<span class="text-warning">For testing laboratory</span>)) 
                <span class="text-danger">ไฟล์แนบ Word</span><span class="text-danger" style="font-size: 13px;"> (doc,docx)</span>
            </h4>
        </legend>
    
        <div class="row">
            <input type="hidden" name="bound_forCertificate" id="bound_forCertificate">
        </div>
    
        <div class="row form-group">
            <label class="col-sm-2 text-right" for="branch_lab_test">สาขาการทดสอบ: </label>
            <div class="col-sm-6">
                {!! Form::select('branch_lab_test',$branchs ?? [], null,   ['class' => 'form-control', 'id'=>'branch_lab_test','placeholder' =>'- สาขาการทดสอบ -']) !!}
                {!! $errors->first('branch_lab_test', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2  text-right">
                <button type="button" class="btn btn-primary m-t-12" id="add_testTable">เพิ่มรายการ</button>
           </div>
       </div>
    
       <div class="row">
           <div class="col-md-10">
               <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
                   <table class="table table-bordered" id="myTable_labTest">
                       <thead class="bg-primary">
                            <tr>
                                <th class="text-center text-white" width="10%" >ลำดับ</th>
                                <th class="text-center text-white" width="70%">สาขาการทดสอบ</th>
                                <th class="text-center text-white" width="10%">ลบรายการ</th>
                            </tr>
                       </thead>
                       <tbody id="labtest_tbody">
                            @if ( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertifyTestScope::where('app_certi_lab_id', $certi_lab->id )->get() ) > 0 )
                                @php
                                    $certify_test_scope = App\Models\Certify\Applicant\CertifyTestScope::where('app_certi_lab_id', $certi_lab->id )->get();
                                @endphp

                                @foreach ( $certify_test_scope as $kt => $itemT )
                                    @php
                                        $Tablebranch = $itemT->Tablebranch;
                                    @endphp
                                    <tr>
                                        <td class="text-center" style="vertical-align:top">{!! $kt+1 !!}</td>
                                        <td style="vertical-align:top">{!! !empty($Tablebranch->title )?$Tablebranch->title:null !!}</td>
                                        <td class="text-center">
                                            <input type="hidden" name="test_scope[branch_id][]" class="test_scope_branch_id" value="{!! $itemT->branch_id !!}">

                                            <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-branch="{!! $itemT->branch_id !!}"  data-token="{!! $itemT->token !!}"><i class="fa fa-remove"></i></button>
                                        </td>
                                    </tr>

                                @endforeach
                            @endif
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
    
       <div class="row repeater-form-file">
            <div class="col-md-12 box_section6" >
                <div class="form-group">
                    <div class="col-md-4  text-light">
                        {!! Form::label('attachs_sec61', 'กรุณาแนบไฟล์ขอบข่ายที่ต้องการยื่นขอการรับรอง', ['class' => 'col-md-12 label_attach text-light  control-label ']) !!}
                    </div>
                    @php
                        $section61_required = 'required';
                    @endphp
                    <div class="col-md-6" data-repeater-list="repeater-section61" >
              
                        @if ( isset( $certi_lab->id ) && count( App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '61')->get() ) > 0 )

                            @php
                                $section61_required = '';
                                $file_sectionn61 = App\Models\Certify\Applicant\CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id )->where('file_section', '61')->get();
                            @endphp
               
                            @foreach ( $file_sectionn61 as $section61 )
                                <div class="row form-group">
                                    <div class="col-md-12">fff
                                        <a href="{!! HP::getFileStorage($attach_path.$section61->file) !!}" target="_blank" class="view_attach_sec6 btn btn-info btn-sm"> {!! HP::FileExtension($section61->file_client_name)  ?? '' !!}</a>
                                        <a href="{{url('certify/applicant/delete/file_app_certi_lab_attach_all').'/'.$section61->id.'/'.$certi_lab->token}}" class="btn btn-danger btn-xs box_remove_file" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
     
                        <div class="row box_remove_file" data-repeater-item>
                            <div class="col-md-10">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">เลือกไฟล์</span> 
                                        <span class="fileinput-exists">เปลี่ยน</span>
                                        <input type="file" name="attachs_sec61" class="attachs_sec61 check_max_size_file"  {!!  $section61_required !!}>
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger  delete-sec61" type="button" data-repeater-delete>
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success" data-repeater-create><i class="icon-plus"></i>เพิ่ม</button>
                    </div>
                </div> 
            </div>
        </div>
    
    </fieldset>
</div>

@push('js')

 
<script>

    $(document).ready(function () {

        //เพิ่มไฟล์แนบ
        $('#attach-add61').click(function(event) {
            $('.other_attach_item61:first').clone().appendTo('#other_attach-box61');
            $('.other_attach_item61:last').find('input').val(''); 
            $('.other_attach_item61:last').find('a.fileinput-exists').click();  
            $('.other_attach_item61:last').find('a.view-attach').remove();
            $('.other_attach_item61:last').find('.label_other_attach').remove();
            $('.other_attach_item61:last').find('button.attach-add61').remove();
            $('.other_attach_item61:last').find('.button_remove').html('<button class="btn btn-danger btn-sm attach-remove61" type="button"> <i class="icon-close"></i>  </button>');
            
            AttachFile();
            check_max_size_file();
        });

            //ลบไฟล์แนบ
         $('body').on('click', '.attach-remove61', function(event) {
            $(this).parent().parent().parent().remove();
        });
        AttachFile();
    });

    //  Attach File
    function  AttachFile(){
        $('.attachs_sec61').change( function () {
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
</script>
<script>

    var cacheIntype = [];
    var cacheHowtest = [];
    var sendToBound = [];
    let click_type_edit = null;
    let click_product_edit = null;
    let click_test_list_edit = null;
    $(function () {

        let nowEdit = null;
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#test_detail_inType').summernote({
            toolbar: [
            // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']]
            ]
        });

        // summernote.enter
        $('#test_detail_inType').on('summernote.enter', function() {
            var contents = $('#test_detail_inType').summernote('code');
            var contents = $($("#test_detail_inType").summernote("code")).html();

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
            let test_list = $('#test_list').find('option:selected').text();
            let test_list_val = $('#test_list').find('option:selected').val();

            if (checkNone(test_list_val)) {
                $('#add_test_detail_div').show(300);
                $('#test_detail_div').append('<span class="badge badge-pill text-white badge-info font-15 m-5" data-token="'+token+'" ' +
                            'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="' + contents + '">'+test_list+' - '+contents+'<span class="testDetailDel text-danger" style="cursor: pointer">&emsp;x</span></span>');
                        cacheIntype.push({list:test_list,list_val:test_list_val,value:contents,token:token});
                $("#test_detail_inType").summernote('reset');
                $("#test_detail_inType").html('');
                $("#test_detail_inType").summernote('destroy');
                $("#test_detail_inType").val('');
                $('#test_detail_inType').summernote({
                toolbar: [
                // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']]
                ],
                focus: true,
                });
                $("#test_detail_inType").html('');
            } else {
                $("#test_detail_inType").summernote('reset');
                $("#test_detail_inType").html('');
                $("#test_detail_inType").summernote('destroy');
                $("#test_detail_inType").val('');
                $('#test_detail_inType').summernote({
                toolbar: [
                // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']]
                ],
                focus: true,
                });
                $("#test_detail_inType").html('');
                alert('กรุณาเลือกรายการทดสอบ!')
            }

        });

        $(document).on('click', '.testDetailDel', function () {
            let parent = $(this).parent();
            let find = cacheIntype.find(value => value.token  === parent.attr('data-token'));
            let index_find = cacheIntype.indexOf(find);
            cacheIntype.splice(index_find,1);
            parent.remove();
        });

        $('#how_test_detail').summernote({
            toolbar: [
            // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']]
            ]
        });

        // summernote.enter
        $('#how_test_detail').on('summernote.enter', function() {
            var contents = $('#how_test_detail').summernote('code');
                 var contents = $($("#how_test_detail").summernote("code")).html();

                while(contents.startsWith('<p>')){
                    contents=contents.replace('<p>','')
                    }

                while(contents.endsWith('<br></p>')){
                    contents=contents.replace(new RegExp('<br></p>$'),'')
                }

                while(contents.endsWith('<br>')){
                    contents=contents.replace(new RegExp('<br>$'),'')
                }

                console.log(contents);
                let token = stringRandom();
                let test_list = $('#test_list').find('option:selected').text();
                let test_list_val = $('#test_list').find('option:selected').val();
                if (checkNone(test_list_val)) {
                $('#add_test_detail_div').show(300);
                $('#how_test_detail_div').append('<span class="badge badge-pill text-white badge-info font-15 m-5" data-token="'+token+'" ' +
                            'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="' + contents + '">'+test_list+' - '+contents+'<span class="howDetailDel text-danger" style="cursor: pointer">&emsp;x</span></span>');
                            cacheHowtest.push({list:test_list,list_val:test_list_val,value:contents,token:token});
                $("#how_test_detail").summernote('reset');
                $("#how_test_detail").html('');
                $("#how_test_detail").summernote('destroy');
                $("#how_test_detail").val('');
                $('#how_test_detail').summernote({
                toolbar: [
                // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']]
                ],
                focus: true,
                });
                $("#how_test_detail").html('');
            } else {
                $("#how_test_detail").summernote('reset');
                $("#how_test_detail").html('');
                $("#how_test_detail").summernote('destroy');
                $("#how_test_detail").val('');
                $('#how_test_detail').summernote({
                toolbar: [
                // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript', 'specialchars']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']]
                ],
                focus: true,
                });
                $("#how_test_detail").html('');
                alert('กรุณาเลือกรายการทดสอบ!')
            }

        });

        $(document).on('click', '.howDetailDel', function () {
            let parent = $(this).parent();
            let find = cacheHowtest.find(value => value.token  === parent.attr('data-token'));
            let index_find = cacheHowtest.indexOf(find);
            cacheHowtest.splice(index_find,1);
            parent.remove();
        });

        /////////////////////// เพิ่มลง ตาราง ///////////////////////////
        $('#add_testTable').on('click',function () {
            let branch_lab_test = $('#branch_lab_test').find('option:selected').val();
            // let type_product = $('#type_product').find('option:selected').val();
            let type_text = $('#type_product').find('option:selected').text();
            let all_product = $('#all_product').find('option:selected').val();
            let product_text = $('#all_product').find('option:selected').text();
            // && checkNone(type_product)
            if (checkNone(branch_lab_test) && branch_lab_test != '- สาขาการทดสอบ -'){
                addLabTest(branch_lab_test, type_text, product_text, all_product);
            }else{
                alert('กรุณาเลือกสาขาการทดสอบ !');
            }
        });

        
        /////////////////////// เลือกมาแก้ ////////////////////////////
        $(document).on('click','.inTypeEdit',function () {
            let thisToken = $(this).attr('data-token');
            let thisInSend = sendToBound.find(value => value.token === thisToken);
            nowEdit = thisInSend;
            $('#add_testTable').hide(300);
            $('#clear_lab_test').hide();
            $('#edit_save').show(300);
            $('#cancel_edit').show(300);

            clearInputLabTest();
            $('#branch_lab_test').val(thisInSend.branch).change();

            click_type_edit = thisInSend.type;
            click_product_edit = thisInSend.product;
            click_test_list_edit = thisInSend.intype_detail[0].list_val;

            $('#test_list').val('').change();

            $('#add_test_detail_div').show(300);
            $.each(thisInSend.intype_detail,function (key,value) {
                $('#test_detail_div').append('<span class="badge badge-pill text-white badge-info font-15 m-5" data-token="'+value.token+'" ' +
                    'style="text-transform: initial;padding: 6px 10px;font-weight: normal" data-word="' + value.value + '">'+value.list+' - '+value.value+'<span class="testDetailDel text-danger" style="cursor: pointer">&emsp;x</span></span>');
                cacheIntype.push({list:value.list,list_val:value.list_val,value:value.value,token:value.token});
            });
            $.each(thisInSend.howtest,function (key,value) {
                $('#how_test_detail_div').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+value.token+'" ' +
                    'style="text-transform: initial;padding: 6px 10px;font-weight: normal" data-word="'+value.value+'">'+value.list+' - '+value.value+'<span class="howDetailDel text-danger" style="cursor: pointer">&emsp;x</span></span>');
                cacheHowtest.push({list:value.list,list_val:value.list_val,value:value.value,token:value.token});
            });
        });

        $('#edit_save').on('click',function () {
            let branch_lab_test = $('#branch_lab_test').find('option:selected').val();
            let type_product = $('#type_product').find('option:selected').val();
            let all_product = $('#all_product').find('option:selected').val();
            if (checkNone(branch_lab_test) && checkNone(type_product) && checkNone(all_product)){
                if (cacheHowtest.length > 0 && cacheIntype.length > 0){
                    sortLabTestCache();
                    nowEdit.branch = branch_lab_test;
                    nowEdit.type = type_product;
                    nowEdit.product = all_product;
                    nowEdit.intype_detail = cacheIntype;
                    nowEdit.howtest = cacheHowtest;

                    let thisInSend = sendToBound.find(value => value.token === nowEdit.token);
                    let index_find = sendToBound.indexOf(thisInSend);
                    if (checkNone(index_find)){
                        sendToBound[index_find] = nowEdit;
                        $('#bound_forCertificate').attr('value',JSON.stringify(sendToBound));
                        writeTable();
                        $('#add_testTable').show(300);
                        $('#clear_lab_test').show();
                        $('#edit_save').hide(300);
                        $('#cancel_edit').hide(300);
                        nowEdit = null;
                        clearInputLabTest();
                    }else{
                        alert('เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง!');
                    }

                }else{
                    alert('กรุณาใส่ข้อมูลให้ครบ!');
                }
            }else{
                alert('กรุณาใส่ข้อมูลให้ครบ!');
            }
        });

        /////////////////////// เลือกมาลบ ////////////////////////////
        $(document).on('click','.inTypeDelete',function () { 
            let branch = $(this).attr('data-branch');
            let thisToken = $(this).attr('data-token');
            let thisInSend = sendToBound.find(value => value.token === thisToken);
            let index_find = sendToBound.indexOf(thisInSend);
            sendToBound.splice(index_find,1);
            $('#bound_forCertificate').attr('value',JSON.stringify(sendToBound));
            writeTable();

            $("#branch_lab_test option[value=" + branch + "]").prop('disabled', false); //  เปิดรายการ หมวดหมู่ผลิตภัณฑ์
        });

        $('#cancel_edit').on('click',function () {
            $('#add_testTable').show(300);
            $('#clear_lab_test').show();
            $('#edit_save').hide(300);
            $('#cancel_edit').hide(300);
            nowEdit = null;
            clearInputLabTest()
        });

        $('#branch_lab_test').on('change', function () {
            if ($(this).val() !== "0" || $(this).val() !== ""){
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
                ajaxLabTest(select,_token)    
            }
        });

        $('#type_product').on('change',function () {
            if ($(this).val() !== "0" || $(this).val() !== ""){
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('api.test.product')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#all_product').empty();
                        $('#all_product').append('<option value=""> - เลือกผลิตภัณฑ์ - </option>');
                        $.each(result,function (index,value) {
                            $('#all_product').append('<option value='+value.id+' >'+value.title+'</option>');
                        });
                        if (click_product_edit !== null){
                            $('#all_product').val(click_product_edit).change();
                        }
                    }
                });
            }
        });


    });

    function addLabTest(branch,type_text,product_text,product) {
        let token = stringRandom();
        sortLabTestCache();
        let newValue = {
            branch:branch,
            type_text:type_text,
            product_text:product_text,
            product:product,
            intype_detail: cacheIntype,
            howtest:cacheHowtest,
            token:token
        };
        cacheIntype = [];
        cacheHowtest = [];
        // JSON.stringify(newValue.intype_detail);
        // JSON.stringify(newValue.howtest);
        sendToBound.push(newValue);
        $('#bound_forCertificate').attr('value',JSON.stringify(sendToBound));
        console.log($('#bound_forCertificate').val());
        writeTable();
    }

    function writeTable() {
        let theTable = $('#labtest_tbody');
        theTable.empty();
        $.each(sendToBound,function (key,value) {
            let branch_Text = $('#branch_lab_test').find('option[value="'+value.branch+'"]').text();
            let type_product_text = value.type_text;
            let all_product_text = value.product_text;

            let stringIntype = '';
            let stringHow = '';
            let this_in_list = '';
            let this_how_list = '';
            $.each(value.intype_detail,function (key,value) {
                if (value.list !== this_in_list){
                    stringIntype += '<p style="font-weight: bold">'+'- '+value.list+'</p>';
                    this_in_list = value.list;
                }
                stringIntype += '<p>'+'&nbsp;&nbsp;• '+value.value+'</p>';
            });
            $.each(value.howtest,function (key,value) {
                if (value.list !== this_how_list){
                    stringHow += '<p style="font-weight: bold">'+'- '+value.list+'</p>';
                    this_how_list = value.list;
                }
                stringHow += '<p>'+'&nbsp;&nbsp;• '+value.value+'</p>';
            });
            theTable.append('<tr>\n' +
                '                    <td class="text-center" style="vertical-align:top">'+parseInt(key+1)+'</td>\n' +
                '                    <td class=" style="vertical-align:top">'+branch_Text+'</td>\n' +
                // '                    <td class="text-center" style="vertical-align:top">'+type_product_text+'</td>\n' +
                // '                    <td class="text-center" style="vertical-align:top">'+all_product_text+'</td>\n' +
                // '                    <td style="vertical-align:top">'+stringIntype+'</td>\n' +
                // '                    <td style="vertical-align:top">'+stringHow+'</td>\n' +
                '                    <td class="text-center">' +
                '                    <input type="hidden" name="test_scope[branch_id][]" class="test_scope_branch_id" value="'+ value.branch+'">\n' +
                // '                    <button type="button" class="btn btn-primary btn-xs inTypeEdit" data-token="'+value.token+'"><i class="fa fa-pencil-square-o"></i></button>\n' +
                '                    <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-branch="'+value.branch+'"  data-token="'+value.token+'"><i class="fa fa-remove"></i></button></td>\n' +
                '                </tr>');

        $("#branch_lab_test option[value=" + value.branch + "]").prop('disabled', 'disabled'); //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
        });
        clearInputLabTest();
      
    }

    function clearInputLabTest() {
        $('#branch_lab_test').val('').change();
        $('#type_product').val('').change();
        $('#all_product').val('').change();
        $('#test_list').val('').change();
        $('#test_detail_div').find('span').remove();
        $('#how_test_detail_div').find('span').remove();
        cacheIntype = [];
        cacheHowtest = [];
        click_type_edit = null;
        click_product_edit = null;
        click_test_list_edit = null;
    }

    function checkNone(value) {
        return value !== '' && value !== null && value !== undefined;
    }

    function stringRandom() {
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }

    function sortLabTestCache() {
        cacheIntype.sort(function(a, b) {
            if ( a.list_val < b.list_val ){
                return -1;
            }
            if ( a.list_val > b.list_val ){
                return 1;
            }
            return 0;
        });
        cacheHowtest.sort(function(a, b) {
            if ( a.list_val < b.list_val ){
                return -1;
            }
            if ( a.list_val > b.list_val ){
                return 1;
            }
            return 0;
        });
    }

    function ajaxLabTest(select,token){
        $.ajax({
            url:"{{route('api.test.items')}}",
            method:"POST",
            data:{select:select,_token:token},
            success:function (result){
                $('#test_list').empty();
                $('#type_product').empty();

                $('#test_list').append('<option value=""> - รายการทดสอบ - </option>').change();
                $('#type_product').append('<option value=""> - หมวดหมู่ผลิตภัณฑ์ -</option>').change();

                $.each(result[0],function (index,value) {
                    $('#test_list').append('<option value='+value.id+' >'+value.title+'</option>');
                });
                $.each(result[1],function (index,value) {
                    $('#type_product').append('<option value='+value.id+'>'+value.title+'</option>');
                });
                $('#labtest_tbody').children('tr').each(function(index, tr) {
                    var type = $(tr).find('.type_product').val();
                    $("#type_product option[value=" + type + "]").prop("disabled", true); //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
                }); 
                if (click_type_edit !== null){
                    $('#type_product').val(click_type_edit).change();
                }

                if (click_test_list_edit !== null){
                    $('#test_list').val(click_test_list_edit).change();
                }
            }
        });
    }
</script> 

@endpush