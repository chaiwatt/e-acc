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
		td:nth-of-type(4):before { content: "ประเภทการแจ้ง"; }
		td:nth-of-type(5):before { content: "เรื่อง"; }
		td:nth-of-type(6):before { content: "รายละเอียด"; }
		td:nth-of-type(7):before { content: "ผู้บันทึก"; }
		td:nth-of-type(8):before { content: "สถานะ"; }
		td:nth-of-type(9):before { content: "เครื่องมือ"; }

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">

						<div class="col-sm-12">
							<h3 class="pull-left">&nbsp;แจ้งข้อมูลอื่นๆ</h3>
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

                      @can('edit-'.str_slug('other'))

                          {{-- <a class="btn btn-success btn-sm btn-outline waves-effect waves-light" href="#" onclick="UpdateState(1);">
                            <span class="btn-label"><i class="fa fa-check"></i></span><b>เปิด</b>
                          </a>

                          <a class="btn btn-danger btn-sm btn-outline waves-effect waves-light" href="#" onclick="UpdateState(0);">
                            <span class="btn-label"><i class="fa fa-close"></i></span><b>ปิด</b>
                          </a> --}}

                      @endcan

                      @can('add-'.str_slug('other'))
                          <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/esurv/other/create') }}">
                            <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                          </a>
                      @endcan

                      @can('delete-'.str_slug('other'))
                          <a class="btn btn-danger btn-sm waves-effect waves-light" href="#" onclick="Delete();">
                            <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ลบ</b>
                          </a>
                      @endcan

                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">

                      {!! Form::open(['url' => '/esurv/other/multiple', 'method' => 'delete', 'id' => 'myForm', 'class'=>'hide']) !!}

                      {!! Form::close() !!}

                      {!! Form::open(['url' => '/esurv/other/update-state', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                        <input type="hidden" name="state" id="state" />
                      {!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
                            <tr>
                                <th class="text-center" width="2%">#</th>
                                <th><input type="checkbox" id="checkall" width="3%"></th>
                                <th  class="text-center"width="10%">@sortablelink('created_at', 'วันที่แจ้ง')</th>
																<th  class="text-center"width="10%">@sortablelink('inform_type', 'ประเภทการแจ้ง')</th>
																<th  class="text-center"width="20%">@sortablelink('title', 'เรื่อง')</th>
																<th  class="text-center"width="30%">@sortablelink('detail', 'รายละเอียด')</th>
                                <th  class="text-center"width="10%">@sortablelink('applicant_name', 'ผู้บันทึก')</th>
                                <th  class="text-center"width="10%">@sortablelink('state', 'สถานะ')</th>
                                <th  class="text-center"width="5%">จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($other as $item)
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    <td>
																			@if($item->state=='0')
																			  <input type="checkbox" name="cb[]" class="cb" value="{{ $item->id }}">
																			@endif
																		</td>
                                    <td>{{ HP::DateThai($item->created_at) }}</td>
																		<td>{{ HP::OtherTypes()[$item->inform_type] }}</td>
																		<td>{{ $item->title }}</td>
																		<td>{{ $item->detail }}</td>
																		<td>{{ $item->applicant_name }}</td>
                                    <td class="text-top">
                                      @php
                                       $status_css = ['0'=>'label-warning','1'=>'label-info', '2'=>'label-success', '3'=>'label-danger'];
                                      $status_receive  =  ['0' => 'ฉบับร่าง', '1' => 'รอดำเนินการ', '2' => 'อยู่ระหว่างดำเนินการ', '3' => 'ปิดเรื่อง'];
                                      @endphp
                                      @if(array_key_exists($item->state,$status_css) && array_key_exists($item->state,$status_receive))
                                         <span class="label {{ $status_css[$item->state] }}">
                                            <b>{{ $status_receive[$item->state] }}</b>
                                        </span>
                                      @else 
                                         <span class="label label-success">
                                            <b>อยู่ระหว่างดำเนินการ</b>
                                        </span>
                                      @endif
																		</td>
                                    <td>
                                        @can('view-'.str_slug('other'))
                                            <a href="{{ url('/esurv/other/' . $item->id) }}"
                                               title="View other" class="btn btn-info btn-xs">
                                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        @endcan

                                        @can('edit-'.str_slug('other'))
																					@if($item->state=='0')
                                            <a href="{{ url('/esurv/other/' . $item->id . '/edit') }}"
                                               title="Edit other" class="btn btn-primary btn-xs">
                                                  <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                            </a>
																					@endif
                                        @endcan

                                        @can('delete-'.str_slug('other'))
																					@if($item->state=='0')
                                            {!! Form::open([
                                                            'method'=>'DELETE',
                                                            'url' => ['/esurv/other', $item->id],
                                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-xs',
                                                    'title' => 'Delete other',
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
                              $other->appends(['search' => Request::get('search'),
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
