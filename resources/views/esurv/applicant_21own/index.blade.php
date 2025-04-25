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
		td:nth-of-type(1):before { content: "ลำดับ:"; }
		td:nth-of-type(2):before { content: "เลือก:"; }
		td:nth-of-type(3):before { content: "เลขที่คำขอ:"; }
		td:nth-of-type(4):before { content: "ชื่อผลิตภัณฑ์:"; }
		td:nth-of-type(5):before { content: "รายละเอียดผลิตภัณฑ์:"; }
		td:nth-of-type(6):before { content: "ปริมาณที่ขอทำ:"; }
		td:nth-of-type(7):before { content: "ระยะเวลาที่ผลิต:"; }
		td:nth-of-type(8):before { content: "ชื่อบริษัทที่สั่งทำ:"; }
		td:nth-of-type(9):before { content: "วันที่ยื่น:"; }
		td:nth-of-type(10):before { content: "สถานะ:"; }
		td:nth-of-type(11):before { content: "เครื่องมือ:"; }

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ระบบยื่นคำขอการนำเข้าผลิตภัณฑ์เพื่อนำมาใช้เอง (21)</h3>

                    <div class="pull-right">

                      @can('add-'.str_slug('applicant-21own'))
                          <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/esurv/applicant_21own/create') }}">
                            <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                          </a>
                      @endcan

                      @can('delete-'.str_slug('applicant-21own'))
                          <a class="btn btn-danger btn-sm waves-effect waves-light" href="#" onclick="Delete();">
                            <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ลบ</b>
                          </a>
                      @endcan

                    </div>

                    <div class="clearfix"></div>
                    <hr>

										{!! Form::model($filter, ['url' => '/esurv/applicant_21own', 'method' => 'get', 'id' => 'myFilter']) !!}

											<div class="col-md-3">
												  {!! Form::label('perPage', 'Show:', ['class' => 'col-md-3 control-label label-filter']) !!}
												  <div class="col-md-9">
														{!! Form::select('perPage', ['10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100', '500'=>'500'], null, ['class' => 'form-control', 'onchange'=>'this.form.submit()']); !!}
												  </div>
											</div>

											<div class="col-md-4">
												  {!! Form::label('search', 'ค้นหา:', ['class' => 'col-md-3 control-label label-filter']) !!}
												  <div class="col-md-9">
														{!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'ชื่อผลิตภัณฑ์หรือรายละเอียด', 'onchange'=>'this.form.submit()']); !!}
												  </div>
											</div>

											{{-- <div class="col-md-3">
												  {!! Form::label('filter_state', 'สถานะ:', ['class' => 'col-md-3 control-label label-filter']) !!}
												  <div class="col-md-9">
														{!! Form::select('filter_state', ['1'=>'เปิดใช้งาน', '0'=>'ปิดใช้งาน'], null, ['class' => 'form-control', 'placeholder'=>'-เลือกสถานะ-', 'onchange'=>'this.form.submit()']); !!}
												  </div>
											</div> --}}

											<input type="hidden" name="sort" value="{{ Request::get('sort') }}" />
											<input type="hidden" name="direction" value="{{ Request::get('direction') }}" />

										{!! Form::close() !!}

										<div class="clearfix"></div>

                    <div class="table-responsive">

                      {!! Form::open(['url' => '/esurv/applicant_21own/multiple', 'method' => 'delete', 'id' => 'myForm', 'class'=>'hide']) !!}

                      {!! Form::close() !!}

                      {!! Form::open(['url' => '/esurv/applicant_21own/update-state', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                        <input type="hidden" name="state" id="state" />
                      {!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><input type="checkbox" id="checkall"></th>
                                <th>@sortablelink('ref_no', 'เลขที่คำขอ')</th>
																<th>@sortablelink('title', 'ชื่อผลิตภัณฑ์')</th>
																<th>รายละเอียดผลิตภัณฑ์</th>
																<th>ปริมาณที่ขอทำ</th>
																<th>@sortablelink('start_date', 'ระยะเวลาที่ผลิต')</th>
                                <th>@sortablelink('company_order', 'ชื่อบริษัทที่สั่งทำ')</th>
																<th>@sortablelink('created_at', 'วันที่ยื่น')</th>
                                <th>@sortablelink('state', 'สถานะ')</th>
                                <th class="text-center" width="100px">เครื่องมือ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applicant_21own as $key => $item)
                                <tr>
                                    {{-- <td>{{ $applicant_21own->firstItem()+$key }}</td> --}}
                                    <td class="text-top">{{ $applicant_21own->perPage()*($applicant_21own->currentPage()-1)+$loop->iteration }}</td>
                                    <td><input type="checkbox" name="cb[]" class="cb" value="{{ $item->id }}"></td>
                                    <td>{{ $item->ref_no }}</td>
																		<td>{{ $item->title }}</td>
																		<td>
																			@foreach ($item->detail_list as $detail)
																				<div>{{ $detail->detail }}</div>
																			@endforeach
																		</td>
																		<td>
																			@foreach ($item->detail_list as $detail)
                                        <div>{{ $detail->quantity }} {{ $detail->data_unit->name_unit ?? null }}</div>
																			@endforeach
																		</td>
																		<td>{{ HP::DateThai($item->start_date) }} - {{ HP::DateThai($item->end_date) }}</td>
                                    <td>{{ $item->company_order }}</td>
                                    <td>{{ HP::DateThai($item->created_at) }}</td>
																		<td>{{ HP::StateApplicants()[$item->state] }}</td>
                                    <td class="text-center">
                                        {{-- @can('view-'.str_slug('applicant-21own'))
                                            <a href="{{ url('/esurv/applicant_21own/' . $item->id) }}"
                                               title="View Applicant20Bi" class="btn btn-info btn-xs">
                                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        @endcan --}}

                                        @if(in_array($item->state,['1','3']))
		                                        @can('edit-'.str_slug('applicant-21own'))
		                                            <a href="{{ url('/esurv/applicant_21own/' . $item->id . '/edit') }}"
		                                               title="Edit Applicant20Bi" class="btn btn-primary btn-xs">
		                                                  <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
		                                            </a>
		                                        @endcan

		                                        @can('delete-'.str_slug('applicant-21own'))
		                                            {!! Form::open([
		                                                            'method'=>'DELETE',
		                                                            'url' => ['/esurv/applicant_21own', $item->id],
		                                                            'style' => 'display:inline'
		                                            ]) !!}
		                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
		                                                    'type' => 'submit',
		                                                    'class' => 'btn btn-danger btn-xs',
		                                                    'title' => 'Delete Applicant20Bis',
		                                                    'onclick'=>'return confirm("ยืนยันการลบข้อมูล?")'
		                                            )) !!}
		                                            {!! Form::close() !!}
		                                        @endcan
																				@endif

                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                              $applicant_21own->appends(['search' => Request::get('search'),
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
