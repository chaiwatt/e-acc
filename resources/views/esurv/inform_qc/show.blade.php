@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">inform_qc {{ $inform_qc->id }}</h3>
                    @can('view-'.str_slug('inform_qc'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/inform_qc') }}">
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
                                  <td>{{ $inform_qc->id }}</td>
                              </tr>
                              <tr><th> Tb3 Tisno </th><td> {{ $inform_qc->tb3_Tisno }} </td></tr><tr><th> Remark </th><td> {{ $inform_qc->remark }} </td></tr><tr><th> Attach </th><td> {{ $inform_qc->attach }} </td></tr><tr><th> Applicant Name </th><td> {{ $inform_qc->applicant_name }} </td></tr><tr><th> Tel </th><td> {{ $inform_qc->tel }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $inform_qc->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $inform_qc->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($inform_qc->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $inform_qc->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($inform_qc->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
