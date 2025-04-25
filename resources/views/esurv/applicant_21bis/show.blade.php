@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">Applicant21Bi {{ $applicant21bi->id }}</h3>
                    @can('view-'.str_slug('applicant-21bis'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/applicant_21bis') }}">
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
                                  <td>{{ $applicant21bi->id }}</td>
                              </tr>
                              <tr><th> Title </th><td> {{ $applicant21bi->title }} </td></tr><tr><th> Different No </th><td> {{ $applicant21bi->different_no }} </td></tr><tr><th> Reason </th><td> {{ $applicant21bi->reason }} </td></tr><tr><th> Foreign Standard Ref </th><td> {{ $applicant21bi->foreign_standard_ref }} </td></tr><tr><th> Country Ref </th><td> {{ $applicant21bi->country_ref }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $applicant21bi->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $applicant21bi->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($applicant21bi->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $applicant21bi->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($applicant21bi->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
