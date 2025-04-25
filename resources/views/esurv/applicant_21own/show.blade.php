@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">Applicant21Bi {{ $applicant21own->id }}</h3>
                    @can('view-'.str_slug('applicant-21owns'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/applicant_21owns') }}">
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
                                  <td>{{ $applicant21own->id }}</td>
                              </tr>
                              <tr><th> Title </th><td> {{ $applicant21own->title }} </td></tr><tr><th> Different No </th><td> {{ $applicant21own->different_no }} </td></tr><tr><th> Reason </th><td> {{ $applicant21own->reason }} </td></tr><tr><th> Foreign Standard Ref </th><td> {{ $applicant21own->foreign_standard_ref }} </td></tr><tr><th> Country Ref </th><td> {{ $applicant21own->country_ref }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $applicant21own->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $applicant21own->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($applicant21own->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $applicant21own->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($applicant21own->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
