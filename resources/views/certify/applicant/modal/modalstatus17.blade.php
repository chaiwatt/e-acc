<!-- Modal เลข 3 -->
<div class="modal fade" id="action17{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">แจ้งข้อบกพร่อง/ข้อสังเกต</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['url' => 'certify/applicant/update/status/notice', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!}
            <div class="modal-body">
                <div class="container-fluid" >
                    @foreach($find_notice as $data)
                        @php
                            $date = \Carbon\Carbon::parse($data->assessment_date)->addYear(543);
                            $month = array(
                                      "0"=>"",
                                      "1"=>"มกราคม",
                                      "2"=>"กุมภาพันธ์",
                                      "3"=>"มีนาคม",
                                      "4"=>"เมษายน",
                                      "5"=>"พฤษภาคม",
                                      "6"=>"มิถุนายน",
                                      "7"=>"กรกฎาคม",
                                      "8"=>"สิงหาคม",
                                      "9"=>"กันยายน",
                                      "10"=>"ตุลาคม",
                                      "11"=>"พฤศจิกายน",
                                      "12"=>"ธันวาคม"
                                  );
                            $show = $date->day." ".$month[$date->month]." ".$date->year;
                        $find_notice_item = \App\Models\Certify\Applicant\NoticeItem::where('app_certi_lab_notice_id',$data->id)->get();
                        $audit_information17 = $data->assessment->getSelectAuditors();
                        @endphp
                        <div class="col-md-12 white-box">
                            <div class="row">
                                <div class="col-md-4 text-right" >
                                    <p>วันที่ตรวจประเมิน :</p>
                                    @if ($audit_information17->count() > 0)
                                        @foreach($audit_information17 as $au)
                                            @if ($loop->iteration == 1)
                                                <p>ชื่อคณะผู้ตรวจประเมิน :</p>
                                                @else
                                                @if ($au->name_th)
                                                    <p>&nbsp;</p>
                                                @else
                                                    @continue
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                    <p>ข้อบกพร่อง/ข้อสังเกต :</p>
                                    <p>มอก. 17025 ข้อ :</p>
                                    <p>ประเภท :</p>
                                    <p>ผู้พบ :</p>
                                    <p>การแก้ไข :</p>
                                    <br>
                                    <br>
                                    <br>
                                    <p>ไฟล์แนบ (ถ้ามี) :</p>
                                </div>
                                <div class="col-md-8 text-left">
                                    <p>{{ $show }}</p>
                                    @if ($audit_information17->count() > 0)
                                        @foreach($audit_information17 as $au)
                                            @if ($au->name_th)
                                                <p>{{$au->name_th}}</p>
                                            @else
                                                @continue
                                            @endif
                                        @endforeach
                                    @endif
                                    @php
                                        $arr_item = array();
                                        $arr_item_no = array();
                                        $arr_item_type_value = array();
                                        $arr_item_type = array();
                                        $arr_item_reporter = array();
                                    @endphp
                                    @foreach($find_notice_item as $item)
                                       @php
                                           array_push($arr_item,$item->remark);
                                           array_push($arr_item_no,$item->no);
                                           if (!in_array($item->type,$arr_item_type_value)){
                                               array_push($arr_item_type_value,$item->type);
                                               if ($item->type == 1){
                                                    array_push($arr_item_type,"Major");
                                               }
                                               elseif ($item->type == 2){
                                                    array_push($arr_item_type,"Minor");
                                               }
                                               elseif ($item->type == 3){
                                                    array_push($arr_item_type,"Observation");
                                               }
                                           }
                                       $fullname = $item->reporter->title_th." ".$item->reporter->fname_th." ".$item->reporter->lname_th;
                                       array_push($arr_item_reporter,$fullname);

                                       @endphp
                                    @endforeach
                                    <p>{{ implode(',',$arr_item) }}</p>
                                    <p>{{ implode(',',$arr_item_no) }}</p>
                                    <p>{{ implode(',',$arr_item_type) }}</p>
                                    <p>{{ implode(',',$arr_item_reporter) }}</p>
                                    <textarea name="descNotice[{{$loop->iteration}}]" id="" cols="30" rows="3" class="form-control" ></textarea>
                                    <button style="margin-top: 15px" type="button" class="btn btn-sm btn-success m-l-10" id="modal_attach_add17{{$loop->iteration}}">
                                        <i class="icon-plus"></i>&nbsp;เพิ่ม
                                    </button>
                                    <div id="modal_attach_box17{{$loop->iteration}}">
                                        <div class="form-group another_modal_attach_files17{{$loop->iteration}} ">
                                            <div class="col-md-10">
                                                <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput">
                                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                    <span class="fileinput-new">เลือกไฟล์</span>
                                                    <span class="fileinput-exists">เปลี่ยน</span>
{{--                                                            <input type="file" name="another_modal_attach_files17{{$loop->iteration}}[]">--}}
                                                            <input type="file" name="another_modal_attach_files17{{$loop->iteration}}[]" class="check_max_size_file"> 
                                                    </span>
                                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                </div>
                                            </div>

                                            <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                                                <button class="btn btn-danger btn-sm another_modal_attach_remove17{{$loop->iteration}}" type="button">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @push('js')
                            <script>
                                $(document).ready(function () {
                                    //เพิ่มไฟล์แนบ
                                    $('#modal_attach_add17{{$loop->iteration}}').click(function(event) {

                                        $('.another_modal_attach_files17{{$loop->iteration}}:first').clone().appendTo('#modal_attach_box17{{$loop->iteration}}');

                                        $('.another_modal_attach_files17{{$loop->iteration}}:last').find('input').val('');
                                        $('.another_modal_attach_files17{{$loop->iteration}}:last').find('a.fileinput-exists').click();
                                        $('.another_modal_attach_files17{{$loop->iteration}}:last').find('a.view-attach').remove();

                                        ShowHideRemoveBtn17{{$loop->iteration}}();
                                    });
                                    //ลบไฟล์แนบ
                                    $('body').on('click', '.another_modal_attach_remove17{{$loop->iteration}}', function(event) {
                                        $(this).parent().parent().remove();
                                        ShowHideRemoveBtn17{{$loop->iteration}}();
                                    });

                                    ShowHideRemoveBtn17{{$loop->iteration}}();
                                });

                                function ShowHideRemoveBtn17{{$loop->iteration}}() { //ซ่อน-แสดงปุ่มลบ

                                    if ($('.another_modal_attach_files17{{$loop->iteration}}').length > 1) {
                                        $('.another_modal_attach_remove17{{$loop->iteration}}').show();
                                    } else {
                                        $('.another_modal_attach_remove17{{$loop->iteration}}').hide();
                                    }
                                }
                            </script>
                        @endpush
                    @endforeach
                </div>
                <input type="hidden" value="{{ $token_applicant }}" name="certiLab17" id="certiLab17">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success" >ส่ง</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>


@push('js')
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
@endpush