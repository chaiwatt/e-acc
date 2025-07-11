@extends('layouts.master')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ระบบตรวจติดตามใบรับรองระบบงาน (CB)</h3>

                    <div class="pull-right">
 
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::model($filter, ['url' => 'certify/tracking-cb', 'method' => 'get', 'id' => 'myFilter']) !!}

                    <div class="row">
                      <div class="col-md-4 form-group">
                            {!! Form::label('filter_tb3_Tisno', 'สถานะ:', ['class' => 'col-md-2 control-label label-filter']) !!}
                            <div class="form-group col-md-10">
                                {!! Form::select('filter_status',
                                     App\Models\Certificate\TrackingStatus::pluck('title','id'), 
                                  null,
                                 ['class' => 'form-control',
                                 'id'=>'filter_status',
                                 'placeholder'=>'-เลือกสถานะ-']) !!}
                           </div>
                      </div>
                      <div class="col-md-6">
                             {!! Form::label('filter_tb3_Tisno', 'เลขที่คำขอ:', ['class' => 'col-md-3 control-label label-filter text-right']) !!}
                               <div class="form-group col-md-5">
                                {!! Form::text('filter_search', null, ['class' => 'form-control', 'placeholder'=>'','id'=>'filter_search']); !!}
                              </div>
                              <div class="form-group col-md-4">
                                  {!! Form::label('perPage', 'Show', ['class' => 'col-md-4 control-label label-filter']) !!}
                                  <div class="col-md-8">
                                      {!! Form::select('perPage',
                                      ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100','500'=>'500'],
                                        null,
                                       ['class' => 'form-control']) !!}
                                  </div>
                              </div>
                      </div><!-- /.col-lg-5 -->
                      <div class="col-md-2">
                        <div class="form-group  pull-left">
                            <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button>
                        </div>
                        <div class="form-group  pull-left m-l-15">
                            <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                ล้าง
                            </button>
                        </div>
                    </div><!-- /.col-lg-1 -->
                  </div><!-- /.row -->

 

                    <input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
                    <input type="hidden" name="direction" value="{{ Request::get('direction') }}" />

		 {!! Form::close() !!}

                    <div class="clearfix"></div>

                        <table class="table table-borderless" id="myTable">
                            <thead>

                            <tr>
                                <th  class="text-center" width="2%">#</th>
                                <th  class="text-center" width="10%">เลขที่คำขอ</th>
                                <th  class="text-center" width="10%">ชื่อผู้ยื่น</th>
                                <th  class="text-center" width="10%">เลขที่มาตรฐาน</th>
                                <th  class="text-center" width="10%">สาขา</th>
                                <th  class="text-center"  width="10%">วันที่บันทึก</th>
                                <th  class="text-center"  width="10%">สถานะ</th>
                            </tr>
                            </thead>
                            <tbody>
                                  @foreach($query as $item)
                                        <tr>
                                                  <td class="text-center">{{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $query->perPage() ) }}</td>
                                                  <td>{{ $item->reference_refno ?? null  }}</td>
                                                  <td>{{ !empty($item->certificate_export_to->CertiCbTo->name) ? $item->certificate_export_to->CertiCbTo->name : null  }}</td>
                                                  <td>{{ !empty($item->certificate_export_to->CertiCbTo->FormulaTo->title)  ? $item->certificate_export_to->CertiCbTo->FormulaTo->title: null  }}</td>
                                                  <td>
                                                       {{ !empty($item->certificate_export_to->CertiCbTo->CertificationBranchName) ? $item->certificate_export_to->CertiCbTo->CertificationBranchName : null  }}     
                                                  </td>
                                                  <td>      {{ !empty($item->reference_date) ?  HP::DateThai($item->reference_date) : '-' }}</td>
                                                  <td>
                                                      @php
                                                        $status  =  !empty($item->tracking_status->title)? $item->tracking_status->title:'N/A';
                                                      @endphp

                                                      @if ($item->status_id == 2)
                                                      
                                                       @if ($item->trackingDocReviewAuditor != null)
                                                       
                                                               @if ($item->trackingDocReviewAuditor->status == 0)
                                                                   <button type="button" style="border: none" data-tracking_id="{{ $item->id }}"  id="show_tracking_doc_review_auditor" >
                                                                      <i class="mdi mdi-magnify"></i>เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร (ID:{{$item->status_id }})
                                                                  </button>

                                                                     <div class="modal fade text-left" id="tracking_doc_review_auditor_modal" tabindex="-1" role="dialog" >
                                                                        <div class="modal-dialog " style="width:900px !important">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="exampleModalLabel1"> เห็นชอบการแต่งตั้งคณะผู้ตรวจเอกสาร
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="modal-body"> 
                                                                    
                                                                                    <table  class="table color-bordered-table primary-bordered-table" id="tracking_doc_review_auditor_wrapper">
                                                                                        <thead>
                                                                                                <tr>
                                                                                                    <th width="10%" >ลำดับ</th>
                                                                                                    <th width="45%">ชื่อผู้ตรวจประเมิน</th>
                                                                                                    <th width="45%">หน่วยงาน</th>
                                                                                                </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                
                                                                                        </tbody>
                                                                                    </table>
                                                                                    
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" value="{{$item->id}}" id="tracking_id">
                                                                                        <div class="col-md-3">
                                                                                            <input type="radio" name="agree" value="1" id="agree" checked>
                                                                                            <label for="agree" class="control-label">เห็นชอบ</label>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <input type="radio" name="agree" value="2" id="not_agree">
                                                                                            <label for="not_agree" class="control-label">ไม่เห็นชอบ</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="form-group" style="margin-top: 25px">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-12" id="text-area-wrapper" style="display: none;">
                                                                                                <label> หมายเหตุ : </label>
                                                                                                <textarea class="form-control" name="remark_map" id="remark" rows="4" ></textarea>
                                                                                            </div>
                                                                                            <div class="col-sm-12" >
                                                                                                <button type="button" data-tracking_id="{{$item->id}}" class="btn btn-info waves-effect waves-light " style="margin-top:15px; float:right" id="agree_doc_review_team">
                                                                                                    บันทึก
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                    
                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @elseif($item->trackingDocReviewAuditor->status == 1 )

                                                                    @if ($item->doc_review_reject == 1)
                                                                              <button style="border: none" data-toggle="modal"  data-target="#TakeAction{{$loop->iteration}}" data-id="{{ $item->token }}"  >
                                                                            <i class="mdi mdi-magnify"></i>แก้ไขเอกสาร  (ID:{{$item->status_id }})
                                                                        </button>

                                                                        <div class="modal fade text-left" id="TakeAction{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
                                                                            <div class="modal-dialog " role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="exampleModalLabel1"> แก้ไขเอกสาร
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        </h4>
                                                                                    </div>
                                                                                    <div class="modal-body"> 
                                                                                        @php 
                                                                                            $auditors_btn =  '';
                                                                                            if($item->CertiAuditorsStatus == "statusInfo"){
                                                                                                $auditors_btn = 'btn-info';
                                                                                            }elseif($item->CertiAuditorsStatus == "statusSuccess"){
                                                                                                $auditors_btn =  'btn-success';
                                                                                            }else{
                                                                                                $auditors_btn = 'btn-danger';
                                                                                            }
                                                                                        @endphp
                                                                                        
                                                                                        <div class="form-group">
                                                                                            <label for="">{{$item->doc_review_reject_message}}</label>
                                                                                        </div>
                                                                                        
                                                                                        <div class="form-group" style="margin-top: 25px">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-12" >
                                                                                                    <a href="{{ url('/certify/applicant-cb/' . $item->certificate_export_to->CertiCbTo->token. '/edit') }}"  title="Edit ApplicantIB" class="btn btn-primary">
                                                                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"> </i> แก้ไขเอกสาร
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                  

                                                                  @elseif($item->trackingDocReviewAuditor->status == 2 )
                                                                    ไม่เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมินเอกสาร
                                                   
                                                                @endif
                                                              @else
                                                                  {!! $status !!} (ID:{{$item->status_id }})
                                                          @endif
                                                      @elseif($item->status_id == 3)
                                                        <button style="border: none" data-toggle="modal"
                                                                data-target="#TakeAction{{$loop->iteration}}"   >
                                                                <i class="mdi mdi-magnify"></i>    {!! $status !!}
                                                        </button>
                                                        @include ('certify.tracking-cb.modal.modalstatus3',['id'=> $loop->iteration,
                                                                                                            'certi' => $item
                                                                                                        ])
                                                      @elseif($item->status_id == 5  && !Is_null($item->tracking_inspection_to))  
                                                            <button style="border: none" data-toggle="modal"
                                                                  data-target="#inspection{{$loop->iteration}}"   >
                                                                  <i class="mdi mdi-magnify"></i>  {!! $status !!}
                                                            </button>
               
                                                              @include ('certify.tracking-cb.modal.modalstatus5',['id'=> $loop->iteration,
                                                                                                                      'certi' => $item,
                                                                                                                      'inspection'=> $item->tracking_inspection_to
                                                                                                                   ])   
                                                                                                                   
                                                     @elseif($item->status_id == 7 && $item->ability_confirm == null)  

                                                           <button style="border: none" data-toggle="modal"
                                                                  data-target="#report{{$loop->iteration}}"   >
                                                                  <i class="mdi mdi-magnify"></i>  ยืนยันความสามารถ
                                                            </button>     
                                                          
                                                            @php
                                                                $certificate= $item->certificate_export_to;
                                                                $applicant= $item->certificate_export_to->CertiCbTo;
                                                                // dd($applicant);
                                                                $id= $loop->iteration;
                                                                $tracking = $item;
                                                            @endphp
                                                            
                                                             @include ('certify.tracking-cb.modal.modalstatus_ability_confirm')                                                              
                                                      {{-- @elseif($item->status_id == 7 && !Is_null($item->tracking_report_to))                                                                  
                                                             <button style="border: none" data-toggle="modal"
                                                                  data-target="#report{{$loop->iteration}}"   >
                                                                  <i class="mdi mdi-magnify"></i>  {!! $status !!}
                                                            </button>
              
                                                              @include ('certify.tracking-cb.modal.modalstatus7',['id'=> $loop->iteration,
                                                                                                                      'certi' => $item,
                                                                                                                      'report'=> $item->tracking_report_to
                                                                                                       ])   
                                                      @elseif($item->status_id == 10 && !Is_null($item->tracking_payin_two_to))                                                                  
                                                      <button style="border: none" data-toggle="modal"
                                                            data-target="#PayIn2Modal{{$loop->iteration}}"   >
                                                            <i class="mdi mdi-magnify"></i>   {!! $status !!}
                                                      </button>
        
                                                        @include ('certify.tracking-cb.modal.pay_in2',['id'=> $loop->iteration,
                                                                                                          'certi' => $item,
                                                                                                          'pay_in'=> $item->tracking_payin_two_to,
                                                                                                          'std_name'=>  (!empty($item->CertiCbTo->FormulaTo->title)  ? $item->CertiCbTo->FormulaTo->title: null)
                                                                                                ])                                                                                   --}}
                                                                                                       
                                                      @else 
                                                           {!! $status !!}
                                                      @endif
                                                  </td>
                                        </tr>
                                   @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                            $query->appends(['search' => Request::get('search'),
                                                    'sort' => Request::get('sort'),
                                                    'direction' => Request::get('direction')
                                                  ])->render()
                        !!}
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>

    <script>

            $(document).ready(function () {
            $( "#filter_clear" ).click(function() {
                $('#filter_status').val('').select2();
                $('#filter_search').val('');

                $('#filter_state').val('').select2();
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_branch').val('').select2();
                window.location.assign("{{url('/certify/tracking-cb')}}");
            });

            if( checkNone($('#filter_state').val()) ||  checkNone($('#filter_start_date').val()) || checkNone($('#filter_end_date').val()) || checkNone($('#filter_branch').val())   ){
                // alert('มีค่า');
                $("#search_btn_all").click();
                $("#search_btn_all").removeClass('btn-primary').addClass('btn-success');
                $("#search_btn_all > span").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            }

            $("#search_btn_all").click(function(){
                $("#search_btn_all").toggleClass('btn-primary btn-success', 'btn-success btn-primary');
                $("#search_btn_all > span").toggleClass('glyphicon-menu-up glyphicon-menu-down', 'glyphicon-menu-down glyphicon-menu-up');
            });
            function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
             }
         });


        $(document).ready(function () {

            @if(\Session::has('message'))
                $.toast({
                    heading: 'Success!',
                    position: 'top-center',
                    text: '{{session()->get('message')}}',
                    loaderBg: '#70b7d6',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            @if(\Session::has('message_error'))
                $.toast({
                    heading: 'Error!',
                    position: 'top-center',
                    text: '{{session()->get('message_error')}}',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            @endif

            //เลือกทั้งหมด
            $('#checkall').change(function(event) {

              if($(this).prop('checked')){//เลือกทั้งหมด
                $('#myTable').find('input.cb').prop('checked', true);
              }else{
                $('#myTable').find('input.cb').prop('checked', false);
              }

            });

        });

        function Delete(){

          if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
            if(confirm_delete()){
              $('#myTable').find('input.cb:checked').appendTo("#myForm");
              $('#myForm').submit();
            }
          }else{//ยังไม่ได้เลือก
            alert("กรุณาเลือกข้อมูลที่ต้องการลบ");
          }

        }

        function confirm_delete() {
            return confirm("ยืนยันการลบข้อมูล?");
        }

        function UpdateState(state){

          if($('#myTable').find('input.cb:checked').length > 0){//ถ้าเลือกแล้ว
              $('#myTable').find('input.cb:checked').appendTo("#myFormState");
              $('#state').val(state);
              $('#myFormState').submit();
          }else{//ยังไม่ได้เลือก
            if(state=='1'){
              alert("กรุณาเลือกข้อมูลที่ต้องการเปิด");
            }else{
              alert("กรุณาเลือกข้อมูลที่ต้องการปิด");
            }
          }

        }

    </script>
    <script>
      function submit_form_pay1() {
           Swal.fire({
                   title: 'ยืนยันทำรายการ !',
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'บันทึก',
                   cancelButtonText: 'ยกเลิก'
                   }).then((result) => {
                       if (result.value) {
                           $.LoadingOverlay("show", {
                               image       : "",
                               text        : "กำลังบันทึก กรุณารอสักครู่..."
                           });
                           $('.pay_in1_form').submit();
                       }
                   })
           }



    $('input[name="agree"]').change(function() {
        if ($('#not_agree').is(':checked')) {
                    $('#text-area-wrapper').show(); // แสดงทันที
                } else {
                    $('#text-area-wrapper').hide(); // ซ่อนทันที
                    $("#remark").val("");
                }
    });

    $('#agree_doc_review_team').click(function(){
        
        // const _token = $('input[name="_token"]').val();
        var _token = $('meta[name="csrf-token"]').attr('content');
        let trackingId = $(this).data('tracking_id');
        
        // ดึงค่าของ radio ที่ถูกเลือก
        let agreeValue = $("input[name='agree']:checked").val();

        // ดึงค่าของ textarea
        let remarkText = $("#remark").val();


        $.ajax({
        url: "{{route('tracking.update_cb_doc_review_team')}}",
        // url: "/certify/applicant/api/test_parameter",
        method: "POST",
        data: {
            trackingId: trackingId,
            agreeValue: agreeValue,
            remarkText: remarkText,
            _token: _token
        },
        success: function(result) {
            location.reload();

        }
        });
   
    });

    $('#show_tracking_doc_review_auditor').click(function(){
        
        // let _token = $('input[name="_token"]').val();
        var _token = $('meta[name="csrf-token"]').attr('content');
        let trackingId = $(this).data('tracking_id');

        // console.log(_token,trackingId);

        // return;

        $.ajax({
            url: "{{route('tracking.get_cb_doc_review_auditor')}}",
            method: "POST",
            data: {
                trackingId: trackingId,
                _token: _token
            },
            success: function(result) {
                console.log(result);
                // location.reload();
                let auditors = result.trackingDocReviewAuditors;
                let tbody = $('#tracking_doc_review_auditor_wrapper tbody');
                tbody.empty(); // Clear existing rows

                let count = 1; // Initialize row counter
                auditors.forEach(function(auditor) {
                    auditor.temp_users.forEach(function(user, index) {
                        let department = auditor.temp_departments[index] !== 'ไม่มีรายละเอียดหน่วยงานโปรดแก้ไข' 
                            ? auditor.temp_departments[index] 
                            : '';

                        let row = `
                            <tr>
                                <td>${count}</td>
                                <td>${user}</td>
                                <td>${department}</td>
                            </tr>
                        `;
                        tbody.append(row);
                        count++;
                    });
                });
                $('#tracking_doc_review_auditor_modal').modal('show');

            }
        });

   
    });

   </script>
@endpush
