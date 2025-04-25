@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">inform_calibration {{ $inform_calibration->id }}</h3>
                    @can('view-'.str_slug('inform_calibration'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_calibration') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
                        </a>
                    @endcan
                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table">
                            <tbody>
                              <tr>
                                  <th>ID</th>
                                  <td>{{ $inform_calibration->id }}</td>
                              </tr>
                              <tr><th> Tb3 Tisno </th><td> {{ $inform_calibration->tb3_Tisno }} </td></tr><tr><th> Calibration Date </th><td> {{ $inform_calibration->calibration_date }} </td></tr><tr><th> Detail </th><td> {{ $inform_calibration->detail }} </td></tr><tr><th> Attach </th><td> {{ $inform_calibration->attach }} </td></tr><tr><th> Applicant Name </th><td> {{ $inform_calibration->applicant_name }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $inform_calibration->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $inform_calibration->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($inform_calibration->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $inform_calibration->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($inform_calibration->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
