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
		/*td:nth-of-type(1):before { content: "Column Name"; }*/

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แจ้งผลการนำเข้าเพื่อการส่งออก (21 ตรี)</h3>

                    <div class="pull-right">

                      @can('add-'.str_slug('volume_21ter'))
                          <a class="btn btn-success btn-sm waves-effect waves-light" href="{{ url('/esurv/volume_21ter/create') }}">
                            <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                          </a>
                      @endcan

                      @can('delete-'.str_slug('volume_21ter'))
                          <a class="btn btn-danger btn-sm waves-effect waves-light" href="#" onclick="Delete();">
                            <span class="btn-label"><i class="fa fa-trash-o"></i></span><b>ลบ</b>
                          </a>
                      @endcan

                    </div>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">

                      {!! Form::open(['url' => '/esurv/volume_21ter/multiple', 'method' => 'delete', 'id' => 'myForm', 'class'=>'hide']) !!}

                      {!! Form::close() !!}

                      {!! Form::open(['url' => '/esurv/volume_21ter/update-state', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                        <input type="hidden" name="state" id="state" />
                      {!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
	                            <tr>
	                                <th>#</th>
	                                <th>@sortablelink('applicant_21ter_id', 'เลขที่คำขออ้างอิง')</th>
																	<th>ชื่อผลิตภัณฑ์</th>
																	<th>@sortablelink('start_date', 'แผนการผลิต')</th>
																	<th>@sortablelink('start_import_date', 'แผนการนำเข้า')</th>
																	<th>@sortablelink('start_export_date', 'แผนการส่งออก')</th>
																	<th>@sortablelink('created_at', 'วันที่แจ้ง')</th>
																	<th>@sortablelink('inform_close', 'สถานะการแจ้งปริมาณ')</th>
	                                <th>@sortablelink('created_by', 'ผู้แจ้ง')</th>
	                                <th>จัดการ</th>
	                            </tr>
                            </thead>
                            <tbody>
														@php $status_css = ['0'=>'label-success', '1'=>'label-danger']; @endphp
                            @foreach($volume_21ter as $item)
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    <td>{{ $item->applicant->ref_no }}</td>
																		<td>{{ $item->applicant->title }}</td>
																		<td>{{ HP::DateThai($item->applicant->start_date)??'n/a' }} - {{ HP::DateThai($item->applicant->end_date)??'n/a' }}</td>
																		<td>{{ HP::DateThai($item->applicant->start_import_date)??'n/a' }} - {{ HP::DateThai($item->applicant->end_import_date)??'n/a' }}</td>
																		<td>{{ HP::DateThai($item->applicant->start_export_date)??'n/a' }} - {{ HP::DateThai($item->applicant->end_export_date)??'n/a ' }}</td>
																		<td>{{ HP::DateThai($item->created_at) }}</td>
                                    <td>
																			<span class="label {{ $status_css[$item->inform_close] }}">
																				<b>{{ HP::InformCloses()[$item->inform_close] }}</b>
																		  </span>
																		</td>
																		<td>{{ $item->applicant_name }}</td>

                                    <td>
                                        @can('view-'.str_slug('volume_21ter'))
                                            <a href="{{ url('/esurv/volume_21ter/' . $item->id) }}"
                                               title="View volume_21ter" class="btn btn-info btn-xs">
                                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        @endcan

                                        @can('edit-'.str_slug('volume_21ter'))
                                          @if($item->inform_close!='1')
                                            <a href="{{ url('/esurv/volume_21ter/' . $item->id . '/edit') }}"
                                               title="Edit volume_21ter" class="btn btn-primary btn-xs">
                                                  <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                            </a>
                                          @endif
                                        @endcan

                                        @can('delete-'.str_slug('volume_21ter'))
                                          @if($item->inform_close!='1')
                                            {!! Form::open([
                                                            'method'=>'DELETE',
                                                            'url' => ['/esurv/volume_21ter', $item->id],
                                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-xs',
                                                    'title' => 'Delete volume_21ter',
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
                              $volume_21ter->appends(['search' => Request::get('search'),
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
