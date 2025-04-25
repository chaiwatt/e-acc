<div id="viewForm91" class="{{$certi_lab->lab_type == 4 ? 'show':'hide'}}">
    <div class="m-l-10 form-group">
        <h4 class="m-l-5">6. ขอบข่ายที่ยื่นขอรับการรับรอง (สอบเทียบ)</h4>
        <input type="hidden" name="bound_Certificate_calibrate" id="bound_Certificate_calibrate">
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="branch_lab_calibrate">สาขาการสอบเทียบ: </label>
                        <select id="branch_lab_calibrate" name="branch_lab_calibrate" class="form-control">
                            <option value="0" selected disabled> - สาขาสอบเทียบ - </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_calibrate">หมวดหมู่รายการสอบเทียบ: </label>
                        <select id="type_calibrate" name="type_calibrate" class="form-control">
                            <option value="0" selected disabled> - หมวดหมู่รายการสอบเทียบ - </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="calibrate_list">รายการสอบเทียบ: </label>
                        <select id="calibrate_list" name="calibrate_list" class="form-control">
                            <option value="0" selected disabled> - รายการสอบเทียบ - </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="formula_technical">มาตรฐาน/เทคนิค/วิธี: </label>
                        <input type="text" id="formula_technical" class="form-control">
                        <small class="text-danger">* กรอกรายละเอียดแล้ว กด Enter</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" id="formula_adding_div" style="display: none">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6" id="formula_standard"></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="calibrate_detail_inType">รายละเอียดการสอบเทียบ: </label>
                        <input type="text" id="calibrate_detail_inType" class="form-control">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="limit_calibrate">ขีดความสามารถ: </label>
                        <input type="text" id="limit_calibrate" class="form-control">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="limit_calibrate">&nbsp;</label>
                        <button type="button" class="btn btn-success btn-block" id="btn_add_calibrate_detail">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="add_calibrate_detail_div" class="col-md-12" style="display: none">
            <div class="row">
                <div id="calibrate_detail_div"></div>
            </div>
        </div>

        <div class="col-md-12 m-t-10">
            <button type="button" class="btn btn-warning text-white pull-right m-l-5" id="clear_lab_calibrate" onclick="clearInputLabCalibrate()">ล้างข้อมูล</button>
            <button type="button" class="btn btn-primary pull-right m-l-5" id="add_CalibrateTable">เพิ่มรายการ</button>
            <button type="button" class="btn btn-danger pull-right m-l-5" id="cancel_edit_calibrate" style="display: none">ยกเลิกแก้ไข</button>
            <button type="button" class="btn btn-success pull-right m-l-5" id="edit_save_cilibrate" style="display: none">ยืนยันแก้ไข</button>
        </div>
        {{--    </div>--}}
    </div>

    <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
        <table class="table table-bordered" id="myTable_labCalibrate">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white col-xs-1">ลำดับ</th>
                <th class="text-center text-white col-xs-1">สาขาการสอบเทียบ</th>
                <th class="text-center text-white col-xs-1">หมวดหมู่รายการสอบเทียบ</th>
                <th class="text-center text-white col-xs-3">รายการสอบเทียบ/รายละเอียดการสอบเทียบ</th>
                <th class="text-center text-white col-xs-2">ขีดความสามารถของการสอบเทียบและการวัด</th>
                <th class="text-center text-white col-xs-3">มาตรฐาน/เทคนิค/วิธี/เครื่องมือที่ใช้</th>
                <th class="text-center text-white col-xs-1">เครื่องมือ</th>
            </tr>
            </thead>
            <tbody id="labCalibrate_tbody">
            </tbody>
        </table>
    </div>
</div>
<script>
    var sendToBoundCalibrate = [];
    var cacheInputCalibrate = [];
    var thisFormula = [];
    var nowCalibrateList ;
    var click_calibrate_edit = null;

    let lab_calibrate_edit_branch = '';
    let lab_calibrate_edit_branch_text = '';
    let lab_calibrate_edit_type = '';
    let lab_calibrate_edit_type_text = '';

</script>
<script>
    function addLabCalibrateEdit(branch,type,branch_text,type_text) {
        let token = stringRandom();
        sortLabCalibrateCache();
        let list_array = [];
        $.each(cacheInputCalibrate,function (key,value) {
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
        writeTableCalibrateEdit();
    }

    function writeTableCalibrateEdit() {
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
                '                    <td class="text-center" style="vertical-align:top">'+branch_Text+'</td>\n' +
                '                    <td class="text-center" style="vertical-align:top">'+type_product_text+'</td>\n' +
                '                    <td style="vertical-align:top">'+stringIntype+'</td>\n' +
                '                    <td style="vertical-align:top">'+limit_show+'</td>\n' +
                '                    <td style="vertical-align:top">'+formula+'</td>\n' +
                '                    <td class="text-center">' +
                '                    <button type="button" class="btn btn-primary btn-xs inTypeEditCalibrate" data-token="'+value.token+'"><i class="fa fa-pencil-square-o"></i></button>\n' +
                '                    <button type="button" class="btn btn-danger btn-xs inTypeDeleteCalibrate" data-token="'+value.token+'"><i class="fa fa-remove"></i></button></td>\n' +
                '                </tr>');
        });
        console.log(sendToBoundCalibrate);
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
</script>
@if ($certi_lab)
    @if ($certi_lab->certi_lab_calibrate->count() > 0)
        @foreach($certi_lab->certi_lab_calibrate as $lab_calibrate)
            <script>
                lab_calibrate_edit_branch = '{{$lab_calibrate->branch_id ?? ""}}';
                lab_calibrate_edit_branch_text = '{{$lab_calibrate->getBranch()->title ?? ""}}';
                lab_calibrate_edit_type = '{{$lab_calibrate->group_id ?? ""}}';
                lab_calibrate_edit_type_text = '{{$lab_calibrate->getGroup()->title ?? ""}}';
            </script>
            @foreach ($lab_calibrate->get_all_item() as $item)
                @if ($item->item_id)
                    <?php
                        $in_item_list = \Illuminate\Support\Facades\DB::table('bcertify_calibration_items')->select('title')->where('id',$item->item_id)->first() ?? null;
                        $formula_col = \Illuminate\Support\Facades\DB::table('app_certi_scope_calibrate_item_formula')
                                ->select('formula')
                                ->where('scope_calibrate_item_id',$item->id)->get() ?? null;
                    ?>
                    @if ($formula_col->count() > 0)
                        @foreach ($formula_col as $formula)
                            <script>
                                addToFormulaCalibrate();
                                function addToFormulaCalibrate() {
                                    let token = stringRandom();
                                    let list_calibrate = '{!! $item->id ?? "" !!}'; // val หรือ id
                                    let list_calibrate_text = '{!! $in_item_list ? $in_item_list->title ?? "" : "" !!}'; // ตัวหนังสือ
                                    let word = '{!! $formula->formula ?? "" !!}';
                                    thisFormula.push({list:list_calibrate,list_text:list_calibrate_text,formula:word,token:token});
                                }
                            </script>
                        @endforeach
                    @endif

                    <?php
                    $detail_arr = \Illuminate\Support\Facades\DB::table('app_certi_scope_calibrate_item_detail')->select('detail','limit')
                            ->where('scope_calibrate_item_id',$item->id)->get() ?? null;
                    ?>
                    @if ($detail_arr->count() > 0)
                        @foreach ($detail_arr as $deli)
                            <script>
                                addToInputCalibrate();
                                function addToInputCalibrate(){
                                    let token = stringRandom();
                                    let calibrate_list = '{!! $in_item_list ? $in_item_list->title ?? "" : "" !!}'; // ตัวหนังสือ
                                    let calibrate_list_val = '{!! $item->id ?? "" !!}'; // val หรือ id
                                    let calibrate_detail_inType = '{!! $deli->detail ?? "" !!}';
                                    let limit_calibrate = '{!! $deli->limit ?? "" !!}';
                                    cacheInputCalibrate.push({calibrate_list:calibrate_list,calibrate_list_val:calibrate_list_val,detail:calibrate_detail_inType,limit:limit_calibrate,token:token});
                                }
                            </script>
                        @endforeach
                    @endif
                @endif
            @endforeach
            <script>
                addLabCalibrateEdit(lab_calibrate_edit_branch,lab_calibrate_edit_type,lab_calibrate_edit_branch_text,lab_calibrate_edit_type_text);
            </script>
        @endforeach
    @endif
@endif



@push('js')
    <script>
        $(document).ready(function () {
            let nowEditCalibrate = null;
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $('#formula_technical').on('keyup',function (e) {
                e.preventDefault();
                let word = $(this).val();
                if (word !== ''){
                    if (e.keyCode === 13){
                        let list_calibrate = $('#calibrate_list').find('option:selected').val();
                        let list_calibrate_text = $('#calibrate_list').find('option:selected').text();
                        if (checkNone(list_calibrate) && checkNone(word)){
                            let token = stringRandom();
                            $('#formula_adding_div').show(300);
                            $('#formula_standard').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+token+'" ' +
                                'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="'+word+'">'+list_calibrate_text+' - '+word+'<span class="formulaDel text-danger" style="cursor: pointer">&emsp;x</span>');
                            thisFormula.push({list:list_calibrate,list_text:list_calibrate_text,formula:word,token:token});
                            $(this).val('');
                        }else{
                            alert('กรุณาเลือกรายการสอบเทียบ!')
                        }
                    }
                }
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
                let calibrate_detail_inType = $('#calibrate_detail_inType').val();
                let limit_calibrate = $('#limit_calibrate').val();

                if (checkNone(calibrate_detail_inType) && checkNone(limit_calibrate) && checkNone(calibrate_list_val)){
                    if (nowCalibrateList !== calibrate_list){
                        $('#calibrate_detail_div').append('<p style="font-weight: bold" data-list="'+calibrate_list+'">'+calibrate_list+'</p>');
                    }
                    nowCalibrateList = calibrate_list;
                    $('#calibrate_detail_div').append('<div class="col-md-12 calibrate_data_div" data-token="'+token+'">\n' +
                        '    <div class="row">\n' +
                        '        <div class="col-md-5">\n' +
                        '            <div class="form-group">\n' +
                        '                <input type="text" class="form-control toEditCalibrateDetail" readonly data-token="'+token+'" value="'+calibrate_detail_inType+'">\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '        <div class="col-md-5">\n' +
                        '            <div class="form-group">\n' +
                        '                <input type="text" class="form-control toEditLimit" readonly data-token="'+token+'" value="'+limit_calibrate+'">\n' +
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

                    cacheInputCalibrate.push({calibrate_list:calibrate_list,calibrate_list_val:calibrate_list_val,detail:calibrate_detail_inType,limit:limit_calibrate,token:token});

                    $('#calibrate_detail_inType').val('');
                    $('#limit_calibrate').val('');
                }else{
                    alert('กรุณาใส่ข้อมูลให้ครบ!')
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
                this_parent.find('input').prop('readonly',false);
            });

            $(document).on('click','.saveEditCalibrateDetail',function () {
                let the_token = $(this).attr('data-token');
                let find = cacheInputCalibrate.find(value => value.token  === the_token);
                let index_find = cacheInputCalibrate.indexOf(find);
                let this_parent = $(this).parent().parent().parent();
                let new_detailValue = this_parent.find('input.toEditCalibrateDetail').val();
                let new_LimitValue = this_parent.find('input.toEditLimit').val();
                find.detail = new_detailValue;
                find.limit = new_LimitValue;
                cacheInputCalibrate[index_find] = find;
                // แก้เสร็จคืนค่า
                $(this).text('แก้ไข');
                $(this).removeClass('saveEditCalibrateDetail').removeClass('btn-success').addClass('editCalibrateDetail').addClass('btn-warning');
                this_parent.find('input').prop('readonly',true);
            });

            $(document).on('click','.inTypeDeleteCalibrate',function () {
               let the_token = $(this).attr('data-token');
               let find = sendToBoundCalibrate.find(value => value.token  === the_token);
               let index_find = sendToBoundCalibrate.indexOf(find);
               sendToBoundCalibrate.splice(index_find,1);
               $('#bound_Certificate_calibrate').attr('value',JSON.stringify(sendToBoundCalibrate));
               writeTableCalibrate();
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

               $.each(find.calibrate_information,function (key,val) { // เอาค่ากลับคืน array และไปโชว์ที่ input
                   let list_text = val.list;
                   let list_val = val.list_val;
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

                if (checkNone(branch_lab_calibrate) && checkNone(type_calibrate)){
                    if (cacheInputCalibrate.length > 0 && thisFormula.length > 0){
                        addLabCalibrate(branch_lab_calibrate,type_calibrate,branch_text,type_text);
                    }else{
                        alert('กรุณาใส่ข้อมูลให้ครบ!');
                    }
                }else{
                    alert('กรุณาใส่ข้อมูลให้ครบ!');
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
                    '                    <td class="text-center" style="vertical-align:top">'+branch_Text+'</td>\n' +
                    '                    <td class="text-center" style="vertical-align:top">'+type_product_text+'</td>\n' +
                    '                    <td style="vertical-align:top">'+stringIntype+'</td>\n' +
                    '                    <td style="vertical-align:top">'+limit_show+'</td>\n' +
                    '                    <td style="vertical-align:top">'+formula+'</td>\n' +
                    '                    <td class="text-center">' +
                    '                    <button type="button" class="btn btn-primary btn-xs inTypeEditCalibrate" data-token="'+value.token+'"><i class="fa fa-pencil-square-o"></i></button>\n' +
                    '                    <button type="button" class="btn btn-danger btn-xs inTypeDeleteCalibrate" data-token="'+value.token+'"><i class="fa fa-remove"></i></button></td>\n' +
                    '                </tr>');
            });
            clearInputLabCalibrate();
            console.log(sendToBoundCalibrate);
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
                    '                <input type="text" class="form-control toEditCalibrateDetail" readonly data-token="'+value.token+'" value="'+value.detail+'">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-5">\n' +
                    '            <div class="form-group">\n' +
                    '                <input type="text" class="form-control toEditLimit" readonly data-token="'+value.token+'" value="'+value.limit+'">\n' +
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
            });
        }

        function writeTheFormula() {
            $('#formula_adding_div').show(300);
            $.each(thisFormula,function (key,value) {
                $('#formula_standard').append('<span class="badge badge-pill text-white badge-success font-15 m-5" data-token="'+value.token+'" ' +
                    'style="text-transform: initial;padding: 6px 10px;font-weight: normal;white-space: normal" data-word="'+value.formula+'">'+value.list_text+' - '+value.formula+'<span class="formulaDel text-danger" style="cursor: pointer">&emsp;x</span>');
            });
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
                        $('#type_calibrate').append('<option value="">- หมวดหมู่รายการสอบเทียบ -</option>');
                        $.each(result,function (index,value) {
                            $('#type_calibrate').append('<option value='+value.id+' >'+value.title+'</option>');
                        });
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
                    }
                });
            }
        })
    </script>
@endpush