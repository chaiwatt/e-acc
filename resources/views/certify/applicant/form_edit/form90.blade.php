@push('css')
    <link href="{{asset('plugins/components/summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endpush

<div id="viewForm90" style="display: none">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4>
                    <span class="text-danger">*</span> 
                      6. ขอบข่ายที่ยื่นขอรับการรับรอง (<span class="text-warning">ห้องปฏิบัติการทดสอบ</span>) (Scope of Accreditation Sought (<span class="text-warning">For testing laboratory</span>))
                     <span class="text-danger">ไฟล์แนบ Word</span><span class="text-danger" style="font-size: 13px;"> (doc,docx)</span>
                     {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                </h4></legend>
                <input type="hidden" name="bound_forCertificate" id="bound_forCertificate">

                <div class="row form-group">
                    <label class="col-sm-2 text-right" for="branch_lab_test">สาขาการทดสอบ: </label>
                    <div class="col-sm-6">
                               {!! Form::select('branch_lab_test',
                               $branchs ?? [],
                               null, 
                                ['class' => 'form-control', 'id'=>'branch_lab_test',
                                 'placeholder' =>'- สาขาการทดสอบ -']) !!}
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
                                   {{-- <th class="text-center text-white col-xs-1">หมวดหมู่ผลิตภัณฑ์</th> --}}
                                   <th class="text-center text-white" width="10%">ลบรายการ</th>
                               </tr>
                               </thead>
                               <tbody id="labtest_tbody">
                                @if ($certi_lab->certi_test_scope->count() > 0)
                                @foreach ($certi_lab->certi_test_scope as $key => $scope)
                                        <tr>
                                            <td class="text-center" style="vertical-align:top">
                                                    {{ $key +1 }}
                                            </td>
                                            <td  style="vertical-align:top">
                                                {{ $scope->getBranch()->title ?? ""}}
                                            </td>
                                            <td class="text-center"> 
                                                <input type="hidden"name="test_scope[branch_id][]" class="test_scope_branch_id" value="{{ $scope->branch_id ?? "" }}">
                                                <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-branch="{{ $scope->branch_id ?? ""  }}"  data-token="{{ $scope->token ?? "" }}"><i class="fa fa-remove"></i></button>
                                            </td>     
                                        </tr>
                                @endforeach
                                @endif
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
   
         
         
                {{-- <div class="row">
      

            <div class="row">


                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch_lab_test">สาขาการทดสอบ: </label>
                                {!! Form::select('branch_lab_test',
                                   $branchs,
                                  null,
                                   ['class' => 'form-control', 'id'=>'branch_lab_test',
                                    'placeholder' =>'- สาขาการทดสอบ -']) !!}
                                 {!! $errors->first('branch_lab_test', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type_product">หมวดหมู่ผลิตภัณฑ์: </label>
                                {!! Form::select('type_product',
                                [],
                               null,
                                ['class' => 'form-control', 'id'=>'type_product',
                                 'placeholder' =>'- หมวดหมู่ผลิตภัณฑ์ -']) !!}
                                {!! $errors->first('type_product', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 m-t-10">
                    <button type="button" class="btn btn-primary pull-right m-l-5" id="add_testTable">เพิ่มรายการ</button>
                </div>
            </div> --}}

            {{-- <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
                <table class="table table-bordered" id="myTable_labTest">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white col-xs-1">ลำดับ</th>
                        <th class="text-center text-white col-xs-2">สาขาการทดสอบ</th>
                        <th class="text-center text-white col-xs-1">หมวดหมู่ผลิตภัณฑ์</th>
                        <th class="text-center text-white col-xs-1">ลบรายการ</th>
                    </tr>
                    </thead>
                    <tbody id="labtest_tbody">
                        @if ($certi_lab->certi_test_scope->count() > 0)
                        @foreach ($certi_lab->certi_test_scope as $key => $scope)
                                <tr>
                                    <td class="text-center" style="vertical-align:top">
                                            {{ $key +1 }}
                                    </td>
                                    <td class="text-center" style="vertical-align:top">
                                        {{ $scope->getBranch()->title ?? ""}}
                                    </td>
                                    <td class="text-center" style="vertical-align:top">
                                        {{ $scope->get_category()->title ?? ""}}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="test_scope[branch_id][]"  class="branch_id" value="{{ $scope->branch_id ?? "" }}">
                                        <input type="hidden" name="test_scope[category_product_id][]" class="type_product" value="{{ $scope->category_product_id ?? "" }}">
                                        <input type="hidden" name="test_scope[token][]"   value="{{ $scope->token ?? "" }}">
                                        <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-types="{{ $scope->get_category()->id ?? "" }}"  data-token="{{ $scope->token ?? "" }}"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div> --}}

            <div class="row">
                <div class="col-md-12 ">
                    <div id="other_attach-box61">
                        <div class="form-group other_attach_item61">
                            <div class="col-md-4 text-light">
                                <label for="#" class="label_other_attach ctext-light">กรุณาแนบไฟล์ขอบข่ายที่ต้องการยื่นขอการรับรอง</label>
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
                                        <input type="file" name="attachs_sec61[]" accept=".doc,.docx" class="attachs_sec61 check_max_size_file">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                </div>
                            </div>
                            <div class="col-md-2 text-left">
                                <button type="button" class="btn btn-sm btn-success attach-add61" id="attach-add61">
                                    <i class="icon-plus"></i>&nbsp;เพิ่ม
                                </button>
                                <div class="button_remove"></div>
                            </div>
                        </div>
                       </div>
                </div>
            </div>
            <div class="clearfix"></div>
            @if ($certi_lab_attach_all61->count() > 0)
            <div class="row">
                @foreach($certi_lab_attach_all61 as $data)
                  @if ($data->file)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4 text-light"> </div>
                            <div class="col-md-6 text-light">
                                <a href="{{url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file)  ))}}" target="_blank">
                                    {!! HP::FileExtension($data->file)  ?? '' !!}
                                    {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                                </a>
                            </div>
                            <div class="col-md-2 text-left">
                                <a href="{{url('certify/applicant/delete/file_certiLab').'/'.basename($data->file).'/'.$data->token}}" class="btn btn-danger btn-xs"
                                     onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')" >
                                    <i class="fa fa-remove"></i>
                                </a>
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
</div>

@push('js')
<script src="{{ asset('plugins/components/summernote/summernote.js') }}"></script>
<script src="{{ asset('plugins/components/summernote/summernote-ext-specialchars.js') }}"></script>
<script>

    $(document).ready(function () {
        ResetTableNumber();
        AttachFile();
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

    });


            //  Attach File
        function  AttachFile(){
            $('.attachs_sec61').change( function () {
                    var fileExtension = ['docx','doc'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
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
        var cacheIntype = [];
        var cacheHowtest = [];


            /////////////////////// เพิ่มลง ตาราง ///////////////////////////
            $('#add_testTable').on('click',function () {
                let branch_lab_test = $('#branch_lab_test').find('option:selected').val();
                // let type_product = $('#type_product').find('option:selected').val();
                if (checkNone(branch_lab_test)  && branch_lab_test != '- สาขาการทดสอบ -'){
                    addLabTest(branch_lab_test);
                }else{
                    alert('กรุณาเลือกสาขาการทดสอบ !');
                }
            });
        function addLabTest(branch) {
            let theTable = $('#labtest_tbody');
            let token = stringRandom();
            let branchs = $('#branch_lab_test').find('option[value="'+branch+'"]').text();
            // let branch_Texts = $('#type_product').find('option[value="'+type_product+'"]').text();
                theTable.append('<tr>\n' +
                    '                    <td class="text-center" style="vertical-align:top">1</td>\n' +
                    '                    <td  style="vertical-align:top">'+branchs+'</td>\n' +
                    // '                    <td class="text-center" style="vertical-align:top">'+branch_Texts+'</td>\n' +
                    '                    <td class="text-center">' +
                    '                    <input type="hidden" name="test_scope[branch_id][]" class="test_scope_branch_id" value="'+branch+'">\n' +
                    // '                    <input type="hidden" name="test_scope[category_product_id][]" class="type_product" value="'+type_product+'">\n' +
                    // '                    <input type="hidden" name="test_scope[token][]" value="'+token+'">\n' +
                    '                    <button type="button" class="btn btn-danger btn-xs inTypeDelete" data-branch="'+branch+'"  data-token="'+token+'"><i class="fa fa-remove"></i></button></td>\n' +
                    '                </tr>');
            $("#branch_lab_test option[value=" + branch + "]").prop('disabled', 'disabled'); //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
            $('#branch_lab_test').val('- สาขาการทดสอบ -').select2();
            // clearInputLabTest();
            ResetTableNumber();
        }
        function clearInputLabTest() {
            $('#branch_lab_test').val('').change();
            $('#all_product').val('').change();
        }

            /////////////////////// เลือกมาลบ ////////////////////////////

            $(document).on('click','.inTypeDelete',function () { 
                let branch = $(this).attr('data-branch');

                $(this).parent().parent().remove();
                ResetTableNumber();
                $("#branch_lab_test option[value=" + branch + "]").prop('disabled', false); //  เปิดรายการ หมวดหมู่ผลิตภัณฑ์
            });


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
    </script>

    {{-- Api รายการทดสอบ จากสาขาที่เลือก--}}
    <script>
        function ajaxLabTest(select,token){
            $.ajax({
                url:"{{route('api.test.items')}}",
                method:"POST",
                data:{select:select,_token:token},
                success:function (result){
                    $('#type_product').empty();
                    $('#type_product').append('<option value=""> - หมวดหมู่ผลิตภัณฑ์ -</option>').change();
                    $.each(result[1],function (index,value) {
                        $('#type_product').append('<option value='+value.id+'>'+value.title+'</option>');
                    });
                    $('#labtest_tbody').children('tr').each(function(index, tr) {
                        var type = $(tr).find('.type_product').val();
                        $("#type_product option[value=" + type + "]").prop("disabled", true); //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
                    });
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
        //รีเซตเลขลำดับ
        function ResetTableNumber(){
            var rows = $('#labtest_tbody').children(); //แถวทั้งหมด
            rows.each(function(index, el) {
                $(el).children().first().html(index+1);
            });
            }
    </script>
@endpush
