@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">รายละเอียดแจ้งปริมาณการทำเพื่อส่งออก (20 ตรี) {{ $volume_20ter->id }}</h3>
                    @can('view-'.str_slug('volume_20ter'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/volume_20ter') }}">
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
                                  <td>{{ $volume_20ter->id }}</td>
                              </tr>
                              <tr><th> Applicant 20ter Id </th><td> {{ $volume_20ter->applicant_20ter_id }} </td></tr><tr><th> Start Date </th><td> {{ $volume_20ter->start_date }} </td></tr><tr><th> End Date </th><td> {{ $volume_20ter->end_date }} </td></tr><tr><th> Attach </th><td> {{ $volume_20ter->attach }} </td></tr><tr><th> Inform Close </th><td> {{ $volume_20ter->inform_close }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $volume_20ter->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $volume_20ter->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($volume_20ter->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $volume_20ter->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($volume_20ter->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
