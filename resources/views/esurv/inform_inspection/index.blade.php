@extends('layouts.master')

@push('css')

<style>
  /*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
	@media
	  only screen
    and (max-width: 760px), (min-device-width: 768px)
    and (max-device-width: 1024px)  {

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
		td:nth-of-type(1):before { content: "No."; }
		td:nth-of-type(2):before { content: "เลือก"; }
		td:nth-of-type(3):before { content: "วันที่แจ้ง"; }
		td:nth-of-type(4):before { content: "มาตรฐาน"; }
		td:nth-of-type(5):before { content: "เลขที่ใบอนุญาต"; }
		td:nth-of-type(6):before { content: "หน่วยงานที่ตรวจ"; }
		td:nth-of-type(7):before { content: "วันที่ตรวจ"; }
		td:nth-of-type(8):before { content: "ผู้บันทึก"; }
		td:nth-of-type(9):before { content: "สถานะ"; }
		td:nth-of-type(10):before { content: "จัดการ"; }

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">

						<div class="col-sm-12">
							<h3 class="pull-left">&nbsp;แจ้งผลการทดสอบผลิตภัณฑ์</h3>
							<div class="pull-right">
								<a  href="{{ url('member/index-esurv') }}" class="btn btn-primary btn-rounded waves-effect waves-light">
									<span class="btn-label"><i class="fa fa-home"></i></span>หน้าหลัก
                </a>
								<a href="{{ url('esurv/tisi_license') }}" class="btn btn-rounded waves-effect waves-light btn-success">
									<span class="btn-label"><i class="fa fa-search"></i></span>ดูข้อมูลใบอนุญาต
								</a>
							</div>
						</div>

            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">{{ auth()->user()->trader_operater_name }}</h3>

                    <div class="pull-right">

                      @can('edit-'.str_slug('inform_inspection'))

                          {{-- <a class="btn btn-success btn-sm btn-outline waves-effect waves-light" href="#" onclick="UpdateState(1);">
                            <span class="btn-label"><i class="fa fa-check"></i></span><b>เปิด</b>
                          </a>

                          <a class="btn btn-danger btn-sm btn-outline waves-effect waves-light" href="#" onclick="UpdateState(0);">
                            <span class="btn-label"><i class="fa fa-close"></i></span><b>ปิด</b>
                          </a> --}}

                      @endcan

                      @can('add-'.str_slug('inform_inspection'))
                          <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/esurv/inform_inspection/create') }}">
                            <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                          </a>
                      @endcan

                      @can('delete-'.str_slug('inform_inspection'))
                          <a class="btn btn-danger btn-sm waves-effect waves-light" href="#" onclick="Delete();">
                            <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ลบ</b>
                          </a>
                      @endcan

                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">

                      {!! Form::open(['url' => '/esurv/inform_inspection/multiple', 'method' => 'delete', 'id' => 'myForm', 'class'=>'hide']) !!}

                      {!! Form::close() !!}

                      {!! Form::open(['url' => '/esurv/inform_inspection/update-state', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                        <input type="hidden" name="state" id="state" />
                      {!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
	                            <tr>
	                                <th>#</th>
	                                <th><input type="checkbox" id="checkall"></th>
	                                <th>@sortablelink('created_by', 'วันที่แจ้ง')</th>
																	<th>@sortablelink('tb3_Tisno', 'มาตรฐาน')</th>
																	<th>@sortablelink('tbl_licenseNo', 'เลขที่ใบอนุญาต')</th>
	                                <th>@sortablelink('inspector', 'หน่วยงานที่ตรวจ')</th>
																	<th>@sortablelink('created_at', 'วันที่ตรวจ')</th>
																	<th>@sortablelink('updated_by', 'ผู้บันทึก')</th>
	                                <th>@sortablelink('state', 'สถานะ')</th>
	                                <th>จัดการ</th>
	                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inform_inspection as $item)
                                <tr>
                                    <td class="text-top">{{ $loop->iteration or $item->id }}</td>
                                    <td class="text-top">
																			@if($item->state=='0')
																			  <input type="checkbox" name="cb[]" class="cb" value="{{ $item->id }}">
																			@endif
																		</td>
                                    <td class="text-top">{{ HP::DateThai($item->created_at) }}</td>
																		<td class="text-top">มอก. {{ $item->tb3_Tisno }}</td>
																		<td class="text-top">{{ $item->tbl_licenseNo }}</td>
                                    <td class="text-top">{{ is_null($item->inspector) || $item->inspector==0?$item->inspector_other:$item->InspectorUName }}</td>
																		<td class="text-top">{{ HP::DateThai($item->check_date) }}</td>
                                    <td class="text-top">{{ $item->applicant_name }}</td>
                                    <td class="text-top">
																			<span class="label {{ HP::StateCss()[$item->state] }}">
                                        <b>{{ HP::States()[$item->state] }}</b>
                                      </span>
																		</td>
                                    <td class="text-top">
                                        @can('view-'.str_slug('inform_inspection'))
                                            <a href="{{ url('/esurv/inform_inspection/' . $item->id) }}"
                                               title="View inform_inspection" class="btn btn-info btn-xs">
                                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        @endcan

                                        @can('edit-'.str_slug('inform_inspection'))
																					@if($item->state=='0')
                                            <a href="{{ url('/esurv/inform_inspection/' . $item->id . '/edit') }}"
                                               title="Edit inform_inspection" class="btn btn-primary btn-xs">
                                                  <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                            </a>
																					@endif
                                        @endcan

                                        @can('delete-'.str_slug('inform_inspection'))
																					@if($item->state=='0')
                                            {!! Form::open([
                                                            'method'=>'DELETE',
                                                            'url' => ['/esurv/inform_inspection', $item->id],
                                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-xs',
                                                    'title' => 'Delete inform_inspection',
                                                    'onclick'=>'return confirm("ยืนยันการลบข้อมูล?")'
                                            )) !!}
                                            {!! Form::close() !!}
																					@endif
                                        @endcan

                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                              $inform_inspection->appends(['search' => Request::get('search'),
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

    <script>
        $(document).ready(function () {

            @if(\Session::has('flash_message'))
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('flash_message')}}',
                loaderBg: '#70b7d6',
                icon: 'success',
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

@endpush
