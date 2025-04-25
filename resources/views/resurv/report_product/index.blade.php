@extends('layouts.master')

@push('css')

    <style>

        th {
            text-align: center;
        }

        td {
            text-align: center;
        }

        /*
          Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
          */
        @media only screen
        and (max-width: 760px), (min-device-width: 768px)
        and (max-device-width: 1024px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin: 0 0 1rem 0;
            }

            tr:nth-child(odd) {
                background: #eee;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                /* Now like a table header */
                /*position: absolute;*/
                /* Top/left values mimic padding */
                top: 0;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }



            /*
            Label the data
        You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
            */
            /*td:nth-of-type(1):before { content: "Column Name"; }*/

        }
        fieldset {
            padding: 20px;
        }
    </style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="white-box">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="box-title">ระบบรับ - แจ้งผลการทดสอบ (สำหรับ LAB)</h1>
                            <hr class="hr-line bg-primary">
                        </div>
                    </div>

                    <fieldset class="row">
                        {!! Form::model($filter, ['url' => '/resurv/report_product', 'method' => 'get', 'id' => 'myFilter']) !!}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    {!! Form::text('filter_search', null, ['class' => 'form-control', 'id' => 'filter_text_search', 'placeholder'=>'ค้นหา ผู้ได้รับใบอนุญาต']); !!}
                                </div><!-- /form-group -->
                            </div><!-- /.col-lg-4 -->
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-parent="#capital_detail" href="#search-btn" data-toggle="collapse" id="search_btn_all">
                                        <small>เครื่องมือค้นหา</small> <span class="glyphicon glyphicon-menu-up"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group  pull-left">
                                    <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button>
                                </div>
                                <div class="form-group  pull-left m-l-15">
                                    <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                        ล้าง
                                    </button>
                                </div>
                            </div><!-- /.col-lg-1 -->
                            <div class="col-lg-5">
                                <div class="form-group col-md-7">
                                    <div class="col-md-12">
                                        {!! Form::select('filter_status', ['1'=>'นำส่งตัวอย่าง','2'=>'อยู่ระหว่างดำเนินการ','3'=>'ส่งผลการทดสอบ','4'=>'ไม่รับเรื่อง','ยกเลิก'=>'ยกเลิก','-'=>'-'], null, ['class' => 'form-control', 'placeholder'=>'-เลือกสถานะ-']); !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        {!! Form::label('perPage', 'Show', ['class' => 'col-md-4 control-label label-filter']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('perPage', ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100', '500'=>'500'], null, ['class' => 'form-control']); !!}
                                        </div>
                                    </div>
                            </div><!-- /.col-lg-5 -->
                        </div><!-- /.row -->

                    	<div id="search-btn" class="panel-collapse collapse">
                            <div class="white-box" style="display: flex; flex-direction: column;">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_tb3_Tisno', 'มาตรฐาน', ['class' => 'col-md-3 control-label label-filter']) !!}
                                        <div class="col-md-9">
                                            {!! Form::select('filter_tb3_Tisno', HP::TisListSample(), null, ['class' => 'form-control', 'placeholder'=>'-เลือกมาตรฐาน-']); !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_status_send', 'สถานะการส่ง', ['class' => 'col-md-3 control-label label-filter']) !!}
                                        <div class="col-md-9">
                                            {!! Form::select('filter_status_send', ['รอ'=>'รอ','ส่ง'=>'ส่ง','ปฏิเสธ'=>'ปฏิเสธ'], null, ['class' => 'form-control', 'placeholder'=>'-เลือกมาตรฐาน-']); !!}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_department', 'กลุ่มงานหลัก', ['class' => 'col-md-3 control-label label-filter']) !!}
                                        <div class="col-md-9">
                                        {!! Form::select('filter_department', App\Models\Besurv\Department::whereIn('did',[10,11,12])->pluck('depart_name', 'did'), null, ['class' => 'form-control', 'placeholder'=>'-เลือกกลุ่มงานหลัก-']); !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Form::label('filter_sub_department', 'กลุ่มงานย่อย', ['class' => 'col-md-3 control-label label-filter']) !!}
                                        <div class="col-md-9">
                                        {!! Form::select('filter_sub_department', !empty($subDepartments)?$subDepartments:[], null, ['class' => 'form-control', 'placeholder'=>'-เลือกกลุ่มงานหลักย่อย-']); !!}
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    {!! Form::close() !!}

                           <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="table color-bordered-table primary-bordered-table" id="myTable">
                                    <thead>
                                        <tr bgcolor="#5B9BD5">
                                            <th style="width: 2%;color: white">No.</th>
                                            <th style="width: 2%;color: white"><input type="checkbox" id="checkall"></th>
                                            <th style="width: 10%;color: white">เลขที่อ้างอิง</th>
                                            <th style="width: 25%;color: white">ผู้รับใบอนุญาต</th>
                                            <th style="width: 7%;color: white">เลข มอก.</th>
                                            <th style="width: 38%;color: white">ชื่อมาตรฐาน</th>
                                            <th style="width: 8%;color: white">สถานะ</th>
                                            <th style="width: 8%;color: white">รายละเอียด</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($report_product as $list)
                                        <tr>
                                            <td>{{$temp_num++}}</td>
                                            <td><input type="checkbox" name="cb[]" class="cb" value=""></td>
                                            <td>{{ $list->no_example_id }}</td>
                                            <td>{{ $list->licensee }}</td>
                                            <td>{{ $list->tis_standard }}</td>
                                            <td class="text-left">{{ $list->tis->tb3_TisThainame }}</td>
                                            <td>{{HP::map_lap_status($list->status)}}</td>
                                            <td>

                                              @can('edit-'.str_slug('report_product'))

                                                  @if($list->status === '3' || $list->status === '4')
                                                      <a href="{{url('/resurv/report_product/detail/'. $list->no_example_id )}}"
                                                         class="btn btn-primary btn-xs test" id="test">
                                                          รายละเอียด
                                                      </a>
                                                  @else
                                                      <a href="{{url('/resurv/report_product/'. $list->no_example_id .'/edit')}}"
                                                         class="btn btn-primary btn-xs test" id="test">
                                                          รายละเอียด
                                                      </a>
                                                  @endif
                                              @endcan    
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper">
                                    @php
                                        $page = array_merge($filter, ['sort' => Request::get('sort'),
                                                                      'direction' => Request::get('direction'),
                                                                      'perPage' => Request::get('perPage')
                                                                     ]);
                                    @endphp
                                    {!!
                                        $report_product->appends($page)->links()
                                    !!}
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("#filter_tb3_Tisno").select2({minimumInputLength: 2});

            $( "#filter_clear" ).click(function() {

                $('#filter_search').val('');
                $('#filter_status').val('').select2();
                $('#filter_tb3_Tisno').val('').select2();
                $('#filter_status_send').val('');

                window.location.assign("{{url('/resurv/report_product')}}");
            });
            if($('#filter_tb3_Tisno').val()!="" || $('#filter_status_send').val()!=""){

                $("#search_btn_all").click();
                $("#search_btn_all").removeClass('btn-primary').addClass('btn-success');
                $("#search_btn_all > span").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');

            }
            $("#search_btn_all").click(function(){
                $("#search_btn_all").toggleClass('btn-primary btn-success', 'btn-success btn-primary');
                $("#search_btn_all > span").toggleClass('glyphicon-menu-up glyphicon-menu-down', 'glyphicon-menu-down glyphicon-menu-up');
            });

        });

        function alert_setting() {
            if (confirm('ตั้งค่ารายการผลทดสอบผลิตภัณฑ์ของเลข มอก. นี้') == true) {
                window.location.href = "{{url('/resurv/results_product')}}";
            }
        }

        console.log($('.test').length);

    </script>

@endpush
