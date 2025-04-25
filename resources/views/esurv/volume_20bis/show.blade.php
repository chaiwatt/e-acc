@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">volume_20bi {{ $volume_20bi->id }}</h3>
                    @can('view-'.str_slug('volume_20bis'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/volume_20bis') }}">
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
                                  <td>{{ $volume_20bi->id }}</td>
                              </tr>
                              <tr><th> Applicant 20bis Id </th><td> {{ $volume_20bi->applicant_20bis_id }} </td></tr><tr><th> Start Date </th><td> {{ $volume_20bi->start_date }} </td></tr><tr><th> End Date </th><td> {{ $volume_20bi->end_date }} </td></tr><tr><th> Attach </th><td> {{ $volume_20bi->attach }} </td></tr><tr><th> Inform Close </th><td> {{ $volume_20bi->inform_close }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $volume_20bi->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $volume_20bi->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($volume_20bi->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $volume_20bi->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($volume_20bi->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
