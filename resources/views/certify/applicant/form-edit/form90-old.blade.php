@push('css')
    <link href="{{asset('plugins/components/summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
<div id="viewForm90" class="{{$certi_lab->lab_type == 3 ? 'show':'hide'}}">
    <div class="m-l-10 form-group">
        <h4 class="m-l-5">6. ขอบข่ายที่ยื่นขอรับการรับรอง (ทดสอบ)</h4>
        <input type="hidden" name="bound_forCertificate" id="bound_forCertificate">
    </div>
    <div class="row">
        {{--    <div class="col-md-10 col-md-offset-1">--}}
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="branch_lab_test">สาขาการทดสอบ: </label>
                        <select name="branch_lab_test" id="branch_lab_test" class="form-control">
                            <option value="0" selected disabled> - สาขาการทดสอบ - </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_product">หมวดหมู่ผลิตภัณฑ์: </label>
                        <select name="type_product" id="type_product" class="form-control">
                            <option value="0" selected disabled> - หมวดหมู่ผลิตภัณฑ์ - </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="all_product">ผลิตภัณฑ์: </label>
                        <select name="all_product" id="all_product" class="form-control">
                            <option value="0" selected disabled> - เลือกผลิตภัณฑ์ - </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="test_list">รายการทดสอบ: </label>
                        <select name="test_list" id="test_list" class="form-control">
                            <option value="0" selected disabled> - รายการทดสอบ - </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="test_detail_inType">รายละเอียดการทดสอบ: </label>
                        <input type="text" name="test_detail_inType" id="test_detail_inType" class="form-control">
                        <small class="text-danger">* กรอกรายละเอียดแล้ว กด Enter</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="how_test_detail">วิธีการทดสอบ: </label>
                        <input type="text" name="how_test_detail" id="how_test_detail" class="form-control">
                        <small class="text-danger">* กรอกรายละเอียดแล้ว กด Enter</small>
                    </div>
                </div>
            </div>
        </div>

        <div id="add_test_detail_div" class="col-md-12" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div id="test_detail_div"></div>
                </div>
                <div class="col-md-6">
                    <div id="how_test_detail_div"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 m-t-10">
            <button type="button" class="btn btn-warning text-white pull-right m-l-5" id="clear_lab_test" onclick="clearInputLabTest()">ล้างข้อมูล</button>
            <button type="button" class="btn btn-primary pull-right m-l-5" id="add_testTable">เพิ่มรายการ</button>
            <button type="button" class="btn btn-danger pull-right m-l-5" id="cancel_edit" style="display: none">ยกเลิกแก้ไข</button>
            <button type="button" class="btn btn-success pull-right m-l-5" id="edit_save" style="display: none">ยืนยันแก้ไข</button>
        </div>
        {{--    </div>--}}
    </div>

    <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
        <table class="table table-bordered" id="myTable_labTest">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white col-xs-1">ลำดับ</th>
                <th class="text-center text-white col-xs-2">สาขาการทดสอบ</th>
                <th class="text-center text-white col-xs-1">หมวดหมู่ผลิตภัณฑ์</th>
                <th class="text-center text-white col-xs-1">ผลิตภัณฑ์</th>
                <th class="text-center text-white col-xs-3">รายละเอียดการทดสอบ</th>
                <th class="text-center text-white col-xs-3">วิธีทดสอบ</th>
                <th class="text-center text-white col-xs-1">เครื่องมือ</th>
            </tr>
            </thead>
            <tbody id="labtest_tbody">
            </tbody>
        </table>
    </div>
</div>
<script src="{{asset('plugins/components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('plugins/components/jqueryui/jquery-ui.min.js')}}"></script>
<script>
    var sendToBound = [];
    var cacheIntype = [];
    var cacheHowtest = [];
    let scope_branch = '';
    let scope_branch_text = '';
    let scope_type = '';
    let scope_type_text = '';
    let scope_product = '';
    let scope_product_text = '';
    let click_type_edit = null;
    let click_product_edit = null;
    let click_test_list_edit = null;
</script>
<script>
    function addLabTestEdit(branch,branch_text,type_text,product_text,type_product,product) {
        let token = stringRandom();
        sortLabTestCache();
        let newValue = {
            branch:branch,
            branch_text:branch_text,
            type:type_product,
            type_text:type_text,
            product_text:product_text,
            product:product,
            intype_detail: cacheIntype,
            howtest:cacheHowtest,
            token:token
        };
        cacheIntype = [];
        cacheHowtest = [];

        sendToBound.push(newValue);
        $('#bound_forCertificate').attr('value',JSON.stringify(sendToBound));
        console.log($('#bound_forCertificate').val());
        writeTableEdit();
    }

    function writeTableEdit() {
        let theTable = $('#labtest_tbody');
        theTable.empty();
        $.each(sendToBound,function (key,value) {
            let branch_Text = value.branch_text;
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
                '                    <td class="text-center" style="vertical-align:top">'+branch_Text+'</td>\n' +
                '                    <td class="text-center" style="vertical-align:top">'+type_product_text+'</td>\n' +
                '                    <td class="text-center" style="vertical-align:top">'+all_product_text+'</td>\n' +
                '                    <td style="vertical-align:top">'+stringIntype+'</td>\n' +
                '                    <td style="vertical-align:top">'+stringHow+'</td>\n' +
                '                    <td class="text-center">' +
                '                    <button type="button" class="btn btn-primary btn-xs inTypeEdit" data-token="'+value.token+'"><i class="fa fa-pencil-square-o"></i></button>\n' +
                '                    <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-token="'+value.token+'"><i class="fa fa-remove"></i></button></td>\n' +
                '                </tr>');
        });
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
</script>
@if ($certi_lab)
    @if ($certi_lab->certi_test_scope->count() > 0)
        @foreach ($certi_lab->certi_test_scope as $scope)
            <script>
                scope_branch = '{!! $scope->branch_id ?? "" !!}';
                scope_branch_text = '{{$scope->getBranch()->title ?? ""}}';
                scope_type = '{!! $scope->category_product_id ?? "" !!}';
                scope_type_text = '{!! $scope->get_category()->title ?? "" !!}';
                scope_product = '{!! $scope->product_id ?? "" !!}';
                scope_product_text = '{!! $scope->get_product()->title ?? "" !!}';
            </script>
            @foreach($scope->get_detail() as $detail)
                <?php
                if ($detail->test_item_id){
                    $in_list = \Illuminate\Support\Facades\DB::table('bcertify_test_items')->select('title','title_en')->where('id',$detail->test_item_id)->first() ?? '';
                }
                ?>
                <script>
                    addingTestingToTable();
                    function addingTestingToTable(){
                        let token = stringRandom();
                        let test_list = '{!! $in_list ? $in_list->title ?? "" : "" !!}';
                        let test_list_val = '{!! $detail->test_item_id ?? "" !!}';
                        let word = '{!! $detail->detail_test ?? "" !!}';
                        cacheIntype.push({list:test_list,list_val:test_list_val,value:word,token:token});
                    }
                </script>
            @endforeach
            @foreach ($scope->get_how() as $how)
                <?php
                if ($how->test_item_id){
                    $in_how = \Illuminate\Support\Facades\DB::table('bcertify_test_items')->select('title','title_en')->where('id',$how->test_item_id)->first() ?? '';
                }
                ?>
                <script>
                    addTestHowToTable();
                    function addTestHowToTable(){
                        let token = stringRandom();
                        let test_list = '{!! $in_how ? $in_how->title ?? "" : "" !!}';
                        let test_list_val = '{!! $how->test_item_id ?? ""!!}';
                        let word = '{!! $how->how_test ?? "" !!}';
                        cacheHowtest.push({list:test_list,list_val:test_list_val,value:word,token:token});
                    }
                </script>
            @endforeach
            <script>
                addLabTestEdit(scope_branch,scope_branch_text,scope_type_text,scope_product_text,scope_type,scope_product);
            </script>
        @endforeach
    @endif
@endif


@push('js')
<script src="{{ asset('plugins/components/summernote/summernote.js') }}"></script>
<script src="{{ asset('plugins/components/summernote/summernote-ext-specialchars.js') }}"></script>
    <script>
        $(document).ready(function () {
            let nowEdit = null;
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            // $('#test_detail_inType').on('keyup',function (e) {
            //     e.preventDefault();
            //     let word = $(this).val();
            //     if (word !== ''){
            //         if (e.keyCode === 13){
            //             let test_list = $('#test_list').find('option:selected').text();
            //             let test_list_val = $('#test_list').find('option:selected').val();
            //             if (checkNone(test_list_val)) {
            //                 let token = stringRandom();
            //                 $('#add_test_detail_div').show(300);
            //                 $('#test_detail_div').append('<span class="badge badge-pill text-white badge-info font-15 m-5" data-token="'+token+'" ' +
            //                     'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="' + word + '">'+test_list+' - '+word+'<span class="testDetailDel text-danger" style="cursor: pointer">&emsp;x</span></span>');
            //                 cacheIntype.push({list:test_list,list_val:test_list_val,value:word,token:token});
            //                 $(this).val('');
            //             }else{
            //                 alert('กรุณาเลือกรายการทดสอบ!')
            //             }
            //         }
            //     }
            // });

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
                  
                    console.log(contents);
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

            // $('#how_test_detail').on('keyup',function (e) {
            //     e.preventDefault();
            //     let word = $(this).val();
            //     if (word !== ''){
            //         if (e.keyCode === 13){
            //             let test_list = $('#test_list').find('option:selected').text();
            //             let test_list_val = $('#test_list').find('option:selected').val();
            //             if (checkNone(test_list_val)){
            //                 let token = stringRandom();
            //                 $('#add_test_detail_div').show(300);
            //                 $('#how_test_detail_div').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+token+'" ' +
            //                     'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="'+word+'">'+test_list+' - '+word+'<span class="howDetailDel text-danger" style="cursor: pointer">&emsp;x</span>');
            //                 cacheHowtest.push({list:test_list,list_val:test_list_val,value:word,token:token});
            //                 $(this).val('');
            //             }else{
            //                 alert('กรุณาเลือกรายการทดสอบ!')
            //             }
            //         }
            //     }
            // });

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
                let type_product = $('#type_product').find('option:selected').val();
                let type_text = $('#type_product').find('option:selected').text();
                let all_product = $('#all_product').find('option:selected').val();
                let product_text = $('#all_product').find('option:selected').text();
                if (checkNone(branch_lab_test) && checkNone(type_product) && checkNone(all_product)){
                    if (cacheHowtest.length > 0 && cacheIntype.length > 0){
                        addLabTest(branch_lab_test,type_text,product_text,type_product,all_product);
                    }else{
                        alert('กรุณาใส่ข้อมูลให้ครบ!');
                    }
                }else{
                    alert('กรุณาใส่ข้อมูลให้ครบ!');
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
                        'style="text-transform: initial;padding: 6px 10px;font-weight: normal" data-word="'+value.value+'">'+value.list+' - '+value.value+'<span class="howDetailDel text-danger" style="cursor: pointer">&emsp;x</span>');
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
                let thisToken = $(this).attr('data-token');
                let thisInSend = sendToBound.find(value => value.token === thisToken);
                let index_find = sendToBound.indexOf(thisInSend);
                sendToBound.splice(index_find,1);
                $('#bound_forCertificate').attr('value',JSON.stringify(sendToBound));
                console.log($('#bound_forCertificate').val());
                writeTable();
            });

            $('#cancel_edit').on('click',function () {
                $('#add_testTable').show(300);
                $('#clear_lab_test').show();
                $('#edit_save').hide(300);
                $('#cancel_edit').hide(300);
                nowEdit = null;
                clearInputLabTest()
            });

        });

        function addLabTest(branch,type_text,product_text,type_product,product) {
            let token = stringRandom();
            sortLabTestCache();
            let newValue = {
                branch:branch,
                type:type_product,
                type_text:type_text,
                product_text:product_text,
                product:product,
                intype_detail: cacheIntype,
                howtest:cacheHowtest,
                token:token
            };
            cacheIntype = [];
            cacheHowtest = [];

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
                    '                    <td class="text-center" style="vertical-align:top">'+branch_Text+'</td>\n' +
                    '                    <td class="text-center" style="vertical-align:top">'+type_product_text+'</td>\n' +
                    '                    <td class="text-center" style="vertical-align:top">'+all_product_text+'</td>\n' +
                    '                    <td style="vertical-align:top">'+stringIntype+'</td>\n' +
                    '                    <td style="vertical-align:top">'+stringHow+'</td>\n' +
                    '                    <td class="text-center">' +
                    '                    <button type="button" class="btn btn-primary btn-xs inTypeEdit" data-token="'+value.token+'"><i class="fa fa-pencil-square-o"></i></button>\n' +
                    '                    <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-token="'+value.token+'"><i class="fa fa-remove"></i></button></td>\n' +
                    '                </tr>');
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
    </script>

    {{-- Api รายการทดสอบ จากสาขาที่เลือก--}}
    <script>
        function ajaxLabTest(select,token){
            $.ajax({
                url:"{{route('api.test.items')}}",
                method:"POST",
                data:{select:select,_token:token},
                success:function (result){
                    $('#test_list').empty();
                    $('#type_product').empty();

                    $('#test_list').append('<option value=""> - รายการทดสอบ - </option>');
                    $('#type_product').append('<option value=""> - หมวดหมู่ผลิตภัณฑ์ -</option>');

                    $.each(result[0],function (index,value) {
                        $('#test_list').append('<option value='+value.id+' >'+value.title+'</option>');
                    });
                    $.each(result[1],function (index,value) {
                        $('#type_product').append('<option value='+value.id+' >'+value.title+'</option>');
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
        })

    </script>
@endpush