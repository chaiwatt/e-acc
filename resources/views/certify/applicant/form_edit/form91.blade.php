@push('css')
    <link href="{{asset('plugins/components/summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
<div id="viewForm91" style="display: none">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4>
                    <span class="text-danger">*</span> 
                    6. ขอบข่ายที่ยื่นขอรับการรับรอง (<span class="text-warning">ห้องปฏิบัติการสอบเทียบ</span>) (Scope of Accreditation Sought (<span class="text-warning">For calibration laboratory</span>)) 
                    <span class="text-danger">ไฟล์แนบ Word</span><span class="text-danger" style="font-size: 13px;"> (doc,docx)</span>
                    {{-- <span class="text-danger" style="font-size: 13px;"> ขนาดไฟล์ต้องไม่เกิน 4 MB</span> --}}
                </h4></legend>
   
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
                                    @if ($certi_lab->certi_lab_calibrate->count() > 0)
                                    @foreach ($certi_lab->certi_lab_calibrate as $key => $scope)
                                            <tr>
                                                <td class="text-center" style="vertical-align:top">{{ $key +1 }}</td>
                                                <td   style="vertical-align:top">{{ $scope->getBranch()->title ?? ""}}</td>
                                                <td class="text-center">
                                                    <input type="hidden" name="calibrate[branch_id][]"  accept=".doc,.docx"  class="calibrate_branch_id" value="{{ $scope->branch_id ?? "" }}">
                                                    <button type="button" class="btn btn-danger btn-xs inTypeDeleteCalibrate" data-types="{{ $scope->branch_id ?? "" }}" ><i class="fa fa-remove"></i></button>
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

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="branch_lab_calibrate">สาขาการสอบเทียบ: </label>
                        {!! Form::select('branch_lab_calibrate',
                         $calibration_branchs,
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

    {{-- <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
        <table class="table table-bordered" id="myTable_labCalibrate">
            <thead class="bg-primary">
            <tr>
                <th class="text-center text-white col-xs-1">ลำดับ</th>
                <th class="text-center text-white col-xs-1">สาขาการสอบเทียบ</th>
                <th class="text-center text-white col-xs-1">หมวดหมู่รายการสอบเทียบ</th>
                <th class="text-center text-white col-xs-1">ลบรายการ</th>
            </tr>
            </thead>
            <tbody id="labCalibrate_tbody">
                @if ($certi_lab->certi_lab_calibrate->count() > 0)
                @foreach ($certi_lab->certi_lab_calibrate as $key => $scope)
                        <tr>
                            <td class="text-center" style="vertical-align:top">{{ $key +1 }}</td>
                            <td class="text-center" style="vertical-align:top">{{ $scope->getBranch()->title ?? ""}}</td>
                            <td class="text-center" style="vertical-align:top"> {{ $scope->getGroup()->title ?? ""}}</td>
                            <td class="text-center">
                                <input type="hidden" name="calibrate[branch_id][]"  class="branch_id" value="{{ $scope->branch_id ?? "" }}">
                                <input type="hidden" name="calibrate[group_id][]" class="type_calibrate" value="{{ $scope->group_id ?? "" }}">
                                <input type="hidden" name="calibrate[token][]" value="{{ $scope->token ?? "" }}">
                                <button type="button" class="btn btn-danger btn-xs inTypeDeleteCalibrate" data-types="{{ $scope->getGroup()->id ?? "" }}" ><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div> --}}
    <div class="row">
        <div class="col-md-12 ">
            <div id="other_attach-box62">
                <div class="form-group other_attach_item62">
                    <div class="col-md-4 text-light">
                        <label for="#" class="label_other_attach62 ctext-light">กรุณาแนบไฟล์ขอบข่ายที่ต้องการยื่นขอการรับรอง</label>
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
                                <input type="file" name="attachs_sec62[]" class="attachs_sec62 check_max_size_file">
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
    <div class="clearfix"></div>
    @if ($certi_lab_attach_all62->count() > 0)
    <div class="row">
        @foreach($certi_lab_attach_all62 as $data)
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
        //เพิ่มไฟล์แนบ
        $('#attach-add62').click(function(event) {
            $('.other_attach_item62:first').clone().appendTo('#other_attach-box62');
            $('.other_attach_item62:last').find('input').val('');
            $('.other_attach_item62:last').find('a.fileinput-exists').click();
            $('.other_attach_item62:last').find('a.view-attach').remove();
            $('.other_attach_item62:last').find('.label_other_attach62').remove();
            $('.other_attach_item62:last').find('button.attach-add62').remove();
            $('.other_attach_item62:last').find('.button_remove62').html('<button class="btn btn-danger btn-sm attach-remove62" type="button"> <i class="icon-close"></i>  </button>');
            AttachFile62();
            check_max_size_file();
        });

        //ลบไฟล์แนบ
        $('body').on('click', '.attach-remove62', function(event) {
            $(this).parent().parent().parent().remove();
        });

        AttachFile62();
    });

        //  Attach File
          function  AttachFile62(){
            $('.attachs_sec62').change( function () {
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

        var sendToBoundCalibrate = [];
        var cacheInputCalibrate = [];
        var thisFormula = [];
        var nowCalibrateList ;

        $(document).ready(function () {
            ResetTableCalibrate();

            let nowEditCalibrate = null;
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });



            /////////////////////// เพิ่มลง ตาราง ///////////////////////////
            $('#add_CalibrateTable').on('click',function () {
                let branch_lab_calibrate = $('#branch_lab_calibrate').find('option:selected').val();
                let type_calibrate = $('#type_calibrate').find('option:selected').val();
                if (checkNone(branch_lab_calibrate)  && branch_lab_calibrate != '- สาขาสอบเทียบ -'){
                    addLabCalibrate(branch_lab_calibrate); //type_calibrate
                }else{
                    alert('กรุณาเลือกสาขาสอบเทียบ!');
                }
            });

        });

        function addLabCalibrate(branch_lab_calibrate) { // type_calibrate
            let theTable = $('#labCalibrate_tbody');
                let token = stringRandom();
                let branch = $('#branch_lab_calibrate').find('option[value="'+branch_lab_calibrate+'"]').text();
                // let type_product_text = $('#type_calibrate').find('option[value="'+type_calibrate+'"]').text();
                theTable.append('<tr>\n' +
                    '                    <td class="text-center" style="vertical-align:top">1</td>\n' +
                    '                    <td  style="vertical-align:top">'+branch+'</td>\n' +
                    // '                    <td  style="vertical-align:top">'+type_product_text+'</td>\n' +
                    '                    <td class="text-center">' +
                    '                       <input type="hidden"  name="calibrate[branch_id][]"    class="calibrate_branch_id"  value="'+ branch_lab_calibrate+'">\n' +
                    // '                       <input type="hidden"  name="calibrate[group_id][]"  class="type_calibrate" value="'+ type_calibrate+'">\n' +
                    // '                    <input type="hidden" name="calibrate[token][]" value="'+token+'">\n' +
                    '                    <button type="button" class="btn btn-danger btn-xs inTypeDeleteCalibrate" data-branch="'+branch_lab_calibrate+'"  data-token="'+token+'"><i class="fa fa-remove"></i></button></td>\n' +
                    '                </tr>');
            $("#branch_lab_calibrate option[value=" + branch_lab_calibrate + "]").prop('disabled', true); //  disabled รายการ หมวดหมู่ผลิตภัณฑ์
             $('#branch_lab_calibrate').val('- สาขาสอบเทียบ -').select2();
             ResetTableCalibrate();
        }
             /////////////////////// เลือกมาลบ ////////////////////////////

          $(document).on('click','.inTypeDeleteCalibrate',function () { 
                let branch = $(this).attr('data-branch');

                $(this).parent().parent().remove();
                ResetTableCalibrate();
                $("#branch_lab_calibrate option[value=" + branch + "]").prop('disabled', false); //  เปิดรายการ หมวดหมู่ผลิตภัณฑ์
            });
         //รีเซตเลขลำดับ
        function ResetTableCalibrate(){
            var rows = $('#labCalibrate_tbody').children(); //แถวทั้งหมด
            rows.each(function(index, el) {
                $(el).children().first().html(index+1);
            });
            }

        function stringRandom() {
            return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
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
