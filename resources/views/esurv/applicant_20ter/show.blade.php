@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ระบบยื่นคำขอการทำผลิตภัณฑ์เพื่อส่งออก (20 ตรี) {{ $applicant_20ter->id }}</h3>
                    @can('view-'.str_slug('applicant-20ter'))
                        <a class="btn btn-success pull-right" href="{{ url('/esurv/applicant_20ter') }}">
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
                                <td>{{ $applicant_20ter->id }}</td>
                            </tr>
                            <tr>
                                <th> Title</th>
                                <td> {{ $applicant_20ter->title }} </td>
                            </tr>
                            <tr>
                                <th> Different No</th>
                                <td> {{ $applicant_20ter->different_no }} </td>
                            </tr>
                            <tr>
                                <th> Reason</th>
                                <td> {{ $applicant_20ter->reason }} </td>
                            </tr>
                            <tr>
                                <th> Foreign Standard Ref</th>
                                <td> {{ $applicant_20ter->foreign_standard_ref }} </td>
                            </tr>
                            <tr>
                                <th> Country Ref</th>
                                <td> {{ $applicant_20ter->country_ref }} </td>
                            </tr>
                            <tr>
                                <th> สถานะ</th>
                                <td> {!! $applicant_20ter->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                            </tr>
                            <tr>
                                <th> ผู้สร้าง</th>
                                <td> {{ $applicant_20ter->createdName }} </td>
                            </tr>
                            <tr>
                                <th> วันเวลาที่สร้าง</th>
                                <td> {{ HP::DateTimeThai($applicant_20ter->created_at) }} </td>
                            </tr>
                            <tr>
                                <th> ผู้แก้ไข</th>
                                <td> {{ $applicant_20ter->updatedName }} </td>
                            </tr>
                            <tr>
                                <th> วันเวลาที่แก้ไข</th>
                                <td> {{ HP::DateTimeThai($applicant_20ter->updated_at) }} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
