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



	}
</style>

@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                  <h3 class="box-title pull-left">{{ auth()->user()->trader_operater_name }}</h3>
                    <div class="pull-right">
                      <a  href="{{ url('member/index-esurv') }}" class="btn btn-primary btn-rounded waves-effect waves-light">
                        <span class="btn-label"><i class="fa fa-home"></i></span>หน้าหลัก
                              </a>
                      <a href="{{ url('esurv/tisi_license_notification/create') }}" class="btn btn-rounded waves-effect waves-light btn-success">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>แจ้งข้อมูลใบอนุญาต
                      </a>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::model($filter, ['url' => '/esurv/tisi_license_notification', 'method' => 'get', 'id' => 'myFilter']) !!}
                    <div class="row">
                      <div class="col-md-5 form-group">
                        {!! Form::select('filter_Tisno',
                        App\Models\Basic\Tis::select( DB::raw("CONCAT('มอก.', tb3_Tisno, ' ', ".(new  App\Models\Basic\Tis)->getTable().".tb3_TisThainame) AS name, ' ', tb3_Tisno"))->pluck('name', 'tb3_Tisno'),
                        null,
                         ['class' => 'form-control',
                        'placeholder'=>'- เลือกมาตรฐาน -']) !!}
                    </div><!-- /form-group -->
                     <div class="col-lg-3">
                       {!! Form::label('filter_state', 'สถานะ:', ['class' => 'col-md-3 control-label label-filter']) !!}
                       <div class="col-md-9">
                         {!! Form::select('filter_state',
                         ['0' => 'ฉบับร่าง', '1' => 'ส่งข้อมูลให้ สมอ.', '2' => 'อยู่ระหว่างดำเนินการ', '3' => 'ปิดเรื่อง'],
                         null,
                          ['class' => 'form-control',
                           'placeholder'=>'-เลือกสถานะ-']); !!}
                       </div>
                     </div><!-- /.col-lg-1 -->
                     <div class="col-lg-2">
                       {!! Form::label('perPage', 'Show:', ['class' => 'col-md-3 control-label label-filter']) !!}
                       <div class="col-md-9">
                         {!! Form::select('perPage', [ '10'=>'10', '20'=>'20', '50'=>'50', '100'=>'100', '500'=>'500'], null, ['class' => 'form-control']); !!}
                       </div>
                     </div><!-- /.col-lg-5 -->
                     <div class="col-lg-2">
                        <div class="form-group  pull-left">
                            <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-bottom: -1px;">ค้นหา</button>
                        </div>
                        <div class="form-group  pull-left m-l-15">
                            <button type="button" class="btn btn-warning waves-effect waves-light" id="filter_clear">
                                ล้าง
                            </button>
                        </div>
                    </div><!-- /.col-lg-5 -->
                 </div><!-- /.row -->

                   {!! Form::close() !!}
                   <div class="clearfix"></div>
                    <div class="table-responsive">

                      {!! Form::open(['url' => '/esurv/tisi-license-notification/multiple', 'method' => 'delete', 'id' => 'myForm', 'class'=>'hide']) !!}

                      {!! Form::close() !!}

                      {!! Form::open(['url' => '/esurv/tisi-license-notification/update-state', 'method' => 'put', 'id' => 'myFormState', 'class'=>'hide']) !!}
                        <input type="hidden" name="state" id="state" />
                      {!! Form::close() !!}

                        <table class="table table-borderless" id="myTable">
                            <thead>
                            <tr>
                                <th class="text-center" width="2%">#</th>
                                <th  class="text-center" width="35%">มาตรฐาน</th>
																<th  class="text-center" width="30%">รายละเอียด</th>
																<th  class="text-center" width="12%">ชื่อผู้บันทึก</th>
                                <th  class="text-center" width="10%">สถานะ</th>
                                <th  class="text-center" width="10%">เครื่องมือ</th>
                            </tr>
                            </thead>
                            <tbody>
                           @foreach($inform_volume as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration or $item->id }}</td>
                                    <td>มอก. {{ @$item->tb3_Tisno.' '.@$item->Basic_Tis->tb3_TisThainame }}</td>
                                    <td>{{ $item->detail }}</td>
                                    <td>{{ $item->applicant_name  }}</td>
                                    <td>
                                      @php
                                       $status_css = ['0'=>'label-warning','1'=>'label-info', '2'=>'label-success', '3'=>'label-danger'];
                                      $status_receive  =  ['0' => 'ฉบับร่าง', '1' => 'รอดำเนินการ', '2' => 'อยู่ระหว่างดำเนินการ', '3' => 'ปิดเรื่อง'];
                                      @endphp
                                      @if(array_key_exists($item->state,$status_css) && array_key_exists($item->state,$status_receive))
                                         <span class="label {{ $status_css[$item->state] }}">
                                            <b>{{ $status_receive[$item->state] }}</b>
                                        </span>
                                      @else
                                         <span class="label label-info">
                                            <b>รอดำเนินการ</b>
                                        </span>
                                      @endif
                                    </td>
                                    <td class="text-center">
                                      @if($item->state == 0)
                                            @can('view-'.str_slug('tisi-license-notification'))
                                            <a href="{{ url('/esurv/tisi_license_notification/' . $item->id) }}"
                                              title="View other" class="btn btn-info btn-xs">
                                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            @endcan
                                            @can('edit-'.str_slug('tisi-license-notification'))
                                            <a href="{{ url('/esurv/tisi_license_notification/' . $item->id . '/edit') }}"
                                                title="Edit Tisi License Notification"   class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                </a>
                                            @endcan
                                            @can('delete-'.str_slug('tisi-license-notification'))
                                            @if($item->state=='0')
                                              {!! Form::open([
                                                              'method'=>'DELETE',
                                                              'url' => ['/esurv/tisi_license_notification', $item->id],
                                                              'style' => 'display:inline'
                                              ]) !!}
                                              {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                      'type' => 'submit',
                                                      'class' => 'btn btn-danger btn-xs',
                                                      'title' => 'Delete other',
                                                      'onclick'=>'return confirm("ยืนยันการลบข้อมูล?")'
                                              )) !!}
                                              {!! Form::close() !!}
                                              @endcan
                                        @endif
                                      @else
                                           @can('view-'.str_slug('tisi-license-notification'))
                                            <a href="{{ url('/esurv/tisi_license_notification/' . $item->id) }}"
                                            title="View Tisi License Notification" class="btn btn-info btn-xs">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                           </a>
                                        @endcan

                                      @endif
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                          {!!
                              $inform_volume->appends(['search' => Request::get('search'),
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
            $( "#filter_clear" ).click(function() {
                // alert('sofksofk');
                $('#filter_Tisno').val('').select2();
                $('#filter_state').val('').select2();
                window.location.assign("{{url('/esurv/tisi_license_notification')}}");
            });
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
