@extends('layouts.master')

@push('css')

<style type="text/css">

  ul.ul-detail{
		list-style-type: none;
		padding-left: 10px;
	}

  /*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
	.btn-circle {
		padding: 4px 0px;
	}

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
		td:nth-of-type(2):before { content: "เลขที่ใบอนุญาต"; }
		td:nth-of-type(3):before { content: "รหัสมาตรฐาน"; }
		td:nth-of-type(4):before { content: "ชื่อมาตรฐาน"; }
		td:nth-of-type(5):before { content: "สถานะ"; }
		td:nth-of-type(6):before { content: "ไฟล์"; }
		td:nth-of-type(7):before { content: "รายละเอียด"; }

	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">

						<div class="col-sm-12">
							<h3 class="pull-left">&nbsp;ข้อมูลใบอนุญาต</h3>
							<div class="pull-right">

							</div>
						</div>

            <div class="col-sm-12">

                <div class="white-box">
                    <h3 class="box-title pull-left">{{ auth()->user()->trader_operater_name }}</h3>
					<div class="pull-right">
						<a  href="{{ url('member/index-esurv') }}" class="btn btn-primary btn-rounded waves-effect waves-light">
							<span class="btn-label"><i class="fa fa-home"></i></span>หน้าหลัก
	                	</a>
						<a href="{{ url('esurv/tisi_license_notification/create') }}" class="btn btn-rounded waves-effect waves-light btn-success">
							<span class="btn-label"><i class="fa fa-search"></i></span>แจ้งข้อมูลใบอนุญาต
						</a>
					</div>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">

                      {!! Form::open(['url' => '/esurv/inform_volume/multiple', 'method' => 'delete', 'id' => 'myForm', 'class'=>'hide']) !!}

                      {!! Form::close() !!}

                      {!! Form::open(['url' => '/esurv/inform_volume/update-state', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                        <input type="hidden" name="state" id="state" />
                      {!! Form::close() !!}

											{!! Form::model($filter, ['url' => '/esurv/tisi_license', 'method' => 'get', 'id' => 'myFormFilter']) !!}

												<div class="col-md-6">
													{!! Form::select('filter_tis', HP::OwnTisList(), null, ['class' => 'form-control', 'placeholder'=>'-มาตรฐานผลิตภัณฑ์-', 'onChange'=>'$("#myFormFilter").submit();']); !!}
												</div>
												<div class="col-md-3">
													{!! Form::text('filter_licenseNo', null, ['class' => 'form-control', 'placeholder'=>'เลขที่ใบอนุญาต']) !!}
												</div>
												<div class="col-md-3">
													{!! Form::select('filter_status', ['NULL'=>'-สถานะ-']+$status, null, ['class' => 'form-control', 'onChange'=>'$("#myFormFilter").submit();']); !!}
												</div>

											{!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>@sortablelink('tbl_licenseNo', 'เลขที่ใบอนุญาต')</th>
																<th>@sortablelink('tbl_tisiNo', 'รหัสมาตรฐาน')</th>
																<th>ชื่อมาตรฐาน</th>
																<th>@sortablelink('tbl_licenseStatus', 'สถานะ')</th>
																<th class="text-center">ไฟล์</th>
																<th>รายละเอียด</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inform_volume as $item)
                                <tr>
                                    <td class="text-top">{{ $loop->iteration or $item->id }}</td>
																		<td class="text-top">{{ $item->tbl_licenseNo }}</td>
																		<td class="text-top">มอก. {{ $item->tbl_tisiNo }}</td>
																		<td class="text-top">{{ @$item->tis->tb3_TisThainame }}</td>
																		<td class="text-top">
																				<span class="label {{ $status_css[$item->tbl_licenseStatus] }}">
																						<b>{{ $status[$item->tbl_licenseStatus] }}</b>
																				</span>
																		</td>
																		<td class="text-top text-center">
																			@if(!empty($item->Is_Check_PDF_File==1))
																				<a href="http://appdb.tisi.go.th/tis_dev/p4_license_report/file/{{ HP::ConvertLicenseNoToFileName($item->tbl_licenseNo) }}.pdf" class="btn btn-danger waves-effect btn-circle waves-light" target="_blank">
																					<i class="fa fa-file-pdf-o"></i>
																				</a>
																		  @else
																				<button href="javascript:void(0);" class="btn btn-default btn-circle" title="ไม่มีไฟล์" style="cursor: default;" disabled>
																					<i class="fa fa-file-pdf-o"></i>
																				</button>
																		  @endif
																		</td>
																		<td class="text-center">
																			<button value="{{ $item->Autono }}" class="btn btn-primary btn-circle view-license-detail" title="คลิกเพื่อดูรายละเอียดผลิตภัณฑ์">
																				<i class="fa fa-angle-double-down"></i>
																			</button>
																		</td>
                                </tr>
																<tr class="tr-detail">
																	<td></td>
																	<td colspan="6">
																		<h5>รายละเอียดผลิตภัณฑ์ในใบอนุญาตจำนวน <span class="label label-success detail-amount"></span> รายการ</h5>
																		<ul class="ul-detail">
																			<!-- รายการรายละเอียดผลิตภัณฑ์ -->
																		</ul>
																	</td>
																</tr>
                              @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
													{!! $inform_volume->appends(['search' => Request::get('search'),
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

    <script type="text/javascript">

			$(document).ready(function() {

				//เมื่อคลิกรายละเอียด
				$('.view-license-detail').click(function(){

					var tr_detail = $(this).parent().parent().next();

					if($(tr_detail).is(":hidden")){
						$(tr_detail).show();
						$(this).find('i').removeClass('fa-angle-double-down');
						$(this).find('i').addClass('fa-angle-double-up');
					}else{
						$(tr_detail).hide();
						$(this).find('i').removeClass('fa-angle-double-up');
						$(this).find('i').addClass('fa-angle-double-down');
					}


					if($(tr_detail).find('.detail-amount').text()==''){

						//ดึงรายละเอียดผลิตภัณฑ์
			      $.ajax("{{ url('basic/license-detail-list') }}/" + $(this).val())
			        .done(function(data) {

								$(tr_detail).find('.detail-amount').text(data.length);

								$(tr_detail).find('.ul-detail').text('');

			          $.each(data, function(key, value) {

									var itemNo = (value.itemNo!=null)?value.itemNo:'-';

									$(tr_detail).find('.ul-detail').append('<li>'+itemNo+'. '+value.standard_detail+'</li>');

			          });

			        });

					}


				});

				//ซ่อนรายละเอียดผลิตภัณฑ์
				$('.tr-detail').hide();

			});


    </script>

@endpush
