

@extends('layouts.master')
@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />

@endpush
@section('content')
<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12">
      <div class="white-box">
        <h3 class="box-title pull-left">คำขอรับบริการหน่วยรับรอง (CB)</h3>

        <a class="btn btn-success pull-right" href="{{  url("$previousUrl")  }}" >
            <i class="icon-arrow-left-circle"></i> กลับ
        </a>

        <div class="clearfix"></div>
        <hr>


        @if($history->count() > 0 )
        <div class="white-box">
            <div class="row">
                <div class="col-sm-10">
                     <legend><h3 class="box-title">ประวัติคำขอรับใบรับรองหน่วยรับรอง</h3></legend>
                     <div class="table-responsive">
                        <table class="table color-bordered-table info-bordered-table table-bordered" id="myTable">
                            <thead>
                                    <tr>
                                        <th class="text-center" width="2%">ลำดับ</th>
                                        <th class="text-center" width="30%">วันที่/เวลาบันทึก</th>
                                        {{-- <th class="text-center" width="30%">เจ้าหน้าที่บันทึก</th> --}}
                                        <th class="text-center" width="38%">รายละเอียด</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $key => $item)
                                    <tr>
                                        <td class="text-center">{{ $key +1 }}</td>
                                        <td> {{HP::DateTimeThai($item->created_at) ?? '-'}} </td>
                                        {{-- <td> {{ $item->user_created->FullName ?? '-'}}</td> --}}
                                        <td>
                                              @if($item->DataSystem != '-')
                                                    <button type="button" class="btn btn-link" style="line-height: 16px;text-align: left;"
                                                        data-toggle="modal" data-target="#HistoryModal{{$item->id}}">
                                                            {{ @$item->DataSystem }}
                                                        <br>

                                                     </button>

                                                        @include ('certify/applicant_cb/history.history_detail',['history' => $item,'attach_path' => $attach_path])
                                                  @else
                                                                -
                                                  @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>
        @endif

        <div class="clearfix"></div>
        <hr>
        <a  href="{{ url("$previousUrl") }}"  class="btn btn-default btn-lg btn-block">
            <i class="icon-arrow-left-circle" aria-hidden="true"></i>
                 <b>กลับ</b>
         </a>

      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.check-readonly').prop('disabled', true);
            $('.check-readonly').parent().removeClass('disabled');
            $('.check-readonly').parent().css({"background-color": "rgb(238, 238, 238);","border-radius":"50%"});
         });

    </script>

@endpush
