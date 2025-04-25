@extends('layouts.app-certifies')

@push('css')
<link rel="stylesheet" href="{{asset('plugins/components/jquery-datatables-editable/datatables.css')}}" />
<link href="{{asset('plugins/components/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
 
@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">รายชื่อมาตรฐานการตรวจสอบและรับรอง</h3>

            

                    <div class="clearfix"></div>
                    <hr>


                    <div class="row">
                        <div class="col-md-5 form-group">
                              {!! Form::label('filter_tb3_Tisno', 'ค้นหา:', ['class' => 'col-md-3 control-label text-right ']) !!}
                              <div class="form-group col-md-9">
                                  {!! Form::select('filter_std_no',
                                    //   App\Models\Certify\Standard::whereIn('status_id',[9])   
                                    //   ->where('publish_state',2)->select(DB::raw("CONCAT(std_no,' -  ',std_title) AS titles"),'id')
                                    //   ->orderbyRaw('CONVERT(titles USING tis620)')->pluck('titles','id'),
                                    ['1'=>'ตามเลข มตช.','2'=>'ตามชื่อ มตช.'],
                                    null,
                                   ['class' => 'form-control select2',
                                   'id'=>'filter_std_no',
                                   'placeholder'=>'-ค้นหาตามเลขที่และชื่อ มตช.-']) !!}
                             </div>
                        </div>
                        <div class="col-md-4 form-group ">
                          {!! Form::text('filter_search', null, ['class' => 'form-control', 'placeholder'=>'','id'=>'filter_search']); !!}
                        </div><!-- /.col-lg-5 -->
                        <div class="col-md-2 form-group ">
                          <div class=" pull-left">
                              <button type="button" class="btn btn-info waves-effect waves-light" id="button_search" style="margin-bottom: -1px;">ค้นหา</button>
                          </div>
                          <div class="  pull-left m-l-15">
                              <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                  ล้าง
                              </button>
                          </div>
                      </div><!-- /.col-lg-1 -->
                    </div><!-- /.row -->
  

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped" id="myTable">
                            <thead>
                            <tr>
                                <th width="1%" class="text-center">ลำดับ</th>
                                <th width="15%" class="text-center">เลขที่ มตช.</th>
                                <th  width="60%" class="text-center">ชื่อมาตรฐาน</th>
                                <th width="19%" class="text-center">ประกาศในราชกิจจานุเบกษา</th>
                                <th width="5%" class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
    @endsection


@push('js')
<script src="{{asset('plugins/components/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('plugins/components/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/components/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/components/datatables/dataTables.bootstrap.js')}}"></script>
   <!-- input calendar thai -->
   <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
   <!-- thai extension -->
   <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
   <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <script>
        $(document).ready(function () {
 
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                pageLength:25,
                ajax: {
                    url: '{!! url('/std-certifies/data_list') !!}',
                    data: function (d) {
                      
                        d.filter_search = $('#filter_search').val();
                        d.filter_std_no = $('#filter_std_no').val();
   
                    }
                },
                columns: [
                    { data: 'DT_Row_Index', searchable: false, orderable: false},
                    { data: 'std_full', name: 'std_full' },
                    { data: 'std_title', name: 'std_title' }, 
                    { data: 'gazette_post_date', name: 'gazette_post_date' },
                    { data: 'action', name: 'action' },
                ],
                columnDefs: [
                    { className: "text-center", targets:[0,-1] }
                ],
                fnDrawCallback: function() {
            //         $('#myTable_length').find('.totalrec').remove();
            //         var el = ' <span class=" totalrec" style="color:green;"><b>(ทั้งหมด '+ Comma(table.page.info().recordsTotal) +' รายการ)</b></span>';
            //         $('#myTable_length').append(el);
                          $('#myTable tbody').find('.dataTables_empty').addClass('text-center');
                }
            });



            $( "#button_search" ).click(function() {
                 table.draw();
            });

            $( "#filter_clear" ).click(function() {
              $('#filter_search').val('');
              $('#filter_std_no').val('').select2();
              table.draw();
 
           });

  
 
 });

        
 
        function Comma(Num)
        {
            Num += '';
            Num = Num.replace(/,/g, '');

            x = Num.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
            return x1 + x2;
        }

    </script>

@endpush
