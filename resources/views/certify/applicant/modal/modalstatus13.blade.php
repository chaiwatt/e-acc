<!-- Modal เลข 13 -->
<div class="modal fade" id="actionThirteen{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered modal-lg text-left" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">แต่งตั้งคณะผู้ตรวจประเมิน</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
{{--            {{ dd($this_groups) }}--}}
            {!! Form::open(['url' => 'certify/applicant/update/status/comment/opinion', 'class' => 'form-horizontal', 'files' => true]) !!}
            <div class="modal-body" id="assessmentShow">
                <div class="container-fluid">
                    @foreach ($this_groups as $group)
                        <div class="white-box">
                            <h5>คณะผู้ตรวจประเมินที่ {{$loop->iteration}}</h5>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>ชื่อคณะผู้ตรวจประเมิน :</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <span>
                                            @if (count($group->auditors) > 0)
                                            @foreach ($group->auditors as $audit)
                                                @if ($loop->iteration == sizeof($group->auditors))
                                                        {{$audit->auditor->no ?? '-'}}
                                                    @else
                                                        {{$audit->auditor->no ?? '-'}}
                                              @endif
                                            @endforeach
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>วันที่ตรวจประเมิน :</h6>
                                    </div>
                                    <div class="col-md-6">
                                        @foreach ($group->auditors as $audit)
                                        @if ($loop->iteration == sizeof($group->auditors))
                                                {!! !empty($audit->auditor->DataBoardAuditorDateTitle)  ? $audit->auditor->DataBoardAuditorDateTitle : '-' !!}
                                        @else
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>หนังสือแต่งตั้งคณะผู้ตรวจประเมิน :</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <span>
                                            @foreach ($group->auditors as $audit)
                                                <a href="{{ url('certify/auditor/') . '/' . $audit->auditor->file}}" target="_blank">
                                                    <i class="fa fa-file-pdf-o" style="font-size:38px; color:red"
                                                    aria-hidden="true"></i>
                                                </a>
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>โดยคณะผู้ตรวจประเมิน มีรายนามดังต่อไปนี้ :</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            @php $lapAudit = 0 @endphp
                                            @foreach ($group->auditors as $audit)
                                                @foreach ($audit->auditor->auditor_information as $user)
                                                    <div class="row">
                                                        <div class="col-md-6" style="padding-left: 0px">
                                                            <h6 class="text-nowrap">{{$loop->iteration.'. '.$user->auditor->name_th}}</h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php
                                                                $findGroupBoard = App\Models\Certify\BoardAuditorGroup::where('board_auditor_id',$audit->auditor->id)->get();
                                                                try{
                                                                $sa = $findGroupBoard[$lapAudit]->sa->title;
                                                                }catch (Exception $x){$sa='-';}
                                                            @endphp
                                                            <h6>{{ $sa }}</h6>
                                                        </div>
                                                    </div>
                                                    @php $lapAudit += 1 @endphp
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 m-t-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="text-nowrap">เห็นชอบกับค่าใช่จ่ายที่เสนอมา:</p>
                                    </div>
                                    <div class="col-md-9">
                                        <label>
                                            <input type="radio" name="status13{{$loop->iteration}}" value="1" checked data-radio="iradio_square-green">
                                            &nbsp;เห็นชอบดำเนินการแต่งตั้งคณะผู้ตรวจประเมินต่อไป &nbsp;
                                        </label>
                                        <label>
                                            <input type="radio" name="status13{{$loop->iteration}}" value="2" data-radio="iradio_square-red">
                                            &nbsp;ไม่เห็นด้วย เพราะ &nbsp;
                                        </label>
                                    </div>
                                </div>

                                <div id="notAccept13{{$loop->iteration}}" style="display: none">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <label for="reason13">ระบุเหตุผล :</label>
                                            <textarea name="reason13[{{$loop->iteration}}]" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <label class="m-t-5">ไฟล์แนบ (ถ้ามี):</label>
                                            <button type="button" class="btn btn-sm btn-success m-l-10" id="modal_attach_add13{{$loop->iteration}}">
                                                <i class="icon-plus"></i>&nbsp;เพิ่ม
                                            </button>
                                            <div id="modal_attach_box13{{$loop->iteration}}">
                                                <div class="form-group another_modal_attach_files13{{$loop->iteration}}">
                                                    <div class="col-md-10">
                                                        <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                                                            <div class="form-control" data-trigger="fileinput">
                                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                <span class="fileinput-filename"></span>
                                                            </div>
                                                            <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">เลือกไฟล์</span>
                                                            <span class="fileinput-exists">เปลี่ยน</span>
                                                                <input type="file" name="another_modal_attach_files13{{$loop->iteration}}[]" class="check_max_size_file">
                                                            </span>
                                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
                                                        <button class="btn btn-danger btn-sm another_modal_attach_remove13{{$loop->iteration}}" type="button">
                                                            <i class="icon-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @push('js')
                            <script>
                                $(document).ready(function () {
                                    //เพิ่มไฟล์แนบ
                                    $('#modal_attach_add13{{$loop->iteration}}').click(function(event) {

                                        $('.another_modal_attach_files13{{$loop->iteration}}:first').clone().appendTo('#modal_attach_box13{{$loop->iteration}}');

                                        $('.another_modal_attach_files13{{$loop->iteration}}:last').find('input').val('');
                                        $('.another_modal_attach_files13{{$loop->iteration}}:last').find('a.fileinput-exists').click();
                                        $('.another_modal_attach_files13{{$loop->iteration}}:last').find('a.view-attach').remove();

                                        ShowHideRemoveBtn13{{$loop->iteration}}();
                                    });
                                    //ลบไฟล์แนบ
                                    $('body').on('click', '.another_modal_attach_remove13{{$loop->iteration}}', function(event) {
                                        $(this).parent().parent().remove();
                                        ShowHideRemoveBtn13{{$loop->iteration}}();
                                    });

                                    ShowHideRemoveBtn13{{$loop->iteration}}();
                                });

                                function ShowHideRemoveBtn13{{$loop->iteration}}() { //ซ่อน-แสดงปุ่มลบ

                                    if ($('.another_modal_attach_files13{{$loop->iteration}}').length > 1) {
                                        $('.another_modal_attach_remove13{{$loop->iteration}}').show();
                                    } else {
                                        $('.another_modal_attach_remove13{{$loop->iteration}}').hide();
                                    }
                                }

                                $('input[name=status13{{$loop->iteration}}]').on('click',function () {
                                    if ($(this).val() === "2"){
                                        $('#notAccept13{{$loop->iteration}}').fadeIn();
                                    }
                                    else {
                                        $('#notAccept13{{$loop->iteration}}').hide();
                                    }
                                });
                            </script>
                        @endpush
                    @endforeach
                </div>

            </div>

            <input type="hidden" id="certiLab13" name="certiLab13" value="{{ $token }}">
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
{{--    <script>--}}
{{--        $('#btn13').on('click',function () {--}}
{{--            $('#certiLab13').val($(this).attr('data-id'));--}}
{{--        });--}}
{{--    </script>--}}
@endpush