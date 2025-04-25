@extends('layouts.master')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ระบบตรวจติดตามใบรับรองหน่วยตรวจ (IB)</h3>

                    <div class="pull-right">
 
                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::model($filter, ['url' => 'certify/tracking-ib', 'method' => 'get', 'id' => 'myFilter']) !!}

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
                                <th  class="text-center" width="10%">หน่วยตรวจประเภท</th>
                                <th  class="text-center"  width="10%">วันที่บันทึก</th>
                                <th  class="text-center"  width="10%">สถานะ</th>
                            </tr>
                            </thead>
                            <tbody>
                              @php
                                $type_unit =  ['1'=>'A','2'=>'B','3'=>'C'] ;
                            @endphp
                                  @foreach($query as $item)
                                        <tr>
                                                  <td class="text-center">{{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $query->perPage() ) }}</td>
                                                  <td>{{ $item->reference_refno ?? null  }}</td>
                                                  <td>{{ !empty($item->certificate_export_to->CertiIBCostTo->name) ? $item->certificate_export_to->CertiIBCostTo->name : null  }}</td>
                                                  <td>
                                                    {{  !empty($item->certificate_export_to->CertiIBCostTo->type_unit) && array_key_exists($item->certificate_export_to->CertiIBCostTo->type_unit,$type_unit) ? $type_unit[$item->certificate_export_to->CertiIBCostTo->type_unit]  :'-' }}
                                                </td>
                                                  <td>      
                                                    {{ !empty($item->reference_date) ?  HP::DateThai($item->reference_date) : '-' }}
                                                  </td>
                                                  <td>
                                                      @php
                                                        $status  =  !empty($item->tracking_status->title)? $item->tracking_status->title:'N/A';
                                                      @endphp
                                                      @if($item->status_id == 3)
                                                      <button style="border: none" data-toggle="modal"
                                                               data-target="#TakeAction{{$loop->iteration}}"   >
                                                               <i class="mdi mdi-magnify"></i>    {!! $status !!}
                                                      </button>
                                                      @include ('certify.tracking-ib.modal.modalstatus3',['id'=> $loop->iteration,
                                                                                                          'certi' => $item
                                                                                                      ])
                                                       @elseif($item->status_id == 5  && !Is_null($item->tracking_inspection_to))                  
                                                            <button style="border: none" data-toggle="modal"
                                                                  data-target="#inspection{{$loop->iteration}}"   >
                                                                  <i class="mdi mdi-magnify"></i>  {!! $status !!}
                                                            </button>
               
                                                              @include ('certify.tracking-ib.modal.modalstatus5',['id'=> $loop->iteration,
                                                                                                                      'certi' => $item,
                                                                                                                      'inspection'=> $item->tracking_inspection_to
                                                                                                                   ])          
                                                      {{-- @elseif($item->status_id == 7 && !Is_null($item->tracking_report_to))                                                                  
                                                             <button style="border: none" data-toggle="modal"
                                                                  data-target="#report{{$loop->iteration}}"   >
                                                                  <i class="mdi mdi-magnify"></i>  {!! $status !!}
                                                            </button>
              
                                                              @include ('certify.tracking-ib.modal.modalstatus7',['id'=> $loop->iteration,
                                                                                                                      'certi' => $item,
                                                                                                                      'report'=> $item->tracking_report_to
                                                                                                       ])    --}}
                                                      {{-- @elseif($item->status_id == 10 && !Is_null($item->tracking_payin_two_to))                                                                  
                                                      <button style="border: none" data-toggle="modal"
                                                            data-target="#PayIn2Modal{{$loop->iteration}}"   >
                                                            <i class="mdi mdi-magnify"></i>   {!! $status !!}
                                                      </button>
        
                                                        @include ('certify.tracking-ib.modal.pay_in2',['id'=> $loop->iteration,
                                                                                                          'certi' => $item,
                                                                                                          'pay_in'=> $item->tracking_payin_two_to,
                                                                                                          'std_name'=>  (!empty($item->CertiIBCostTo->FormulaTo->title)  ? $item->CertiIBCostTo->FormulaTo->title: null)
                                                                                                ])                                                                                  
                                                                                                        --}}
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
                window.location.assign("{{url('/certify/tracking-ib')}}");
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
                $('#myTable').find('input.ib').prop('checked', true);
              }else{
                $('#myTable').find('input.ib').prop('checked', false);
              }

            });

        });

        function Delete(){

          if($('#myTable').find('input.ib:checked').length > 0){//ถ้าเลือกแล้ว
            if(confirm_delete()){
              $('#myTable').find('input.ib:checked').appendTo("#myForm");
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

          if($('#myTable').find('input.ib:checked').length > 0){//ถ้าเลือกแล้ว
              $('#myTable').find('input.ib:checked').appendTo("#myFormState");
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
   </script>
@endpush
