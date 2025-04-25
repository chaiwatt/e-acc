@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">report_product {{ $report_product->id }}</h3>
                    @can('view-'.str_slug('report_product'))
                        <a class="btn btn-success pull-right" href="{{ url('/report_product/report_product') }}">
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
                                  <td>{{ $report_product->id }}</td>
                              </tr>
                              <tr><th> ID </th><td> {{ $report_product->ID }} </td></tr><tr><th> State </th><td> {{ $report_product->state }} </td></tr><tr><th> Created By </th><td> {{ $report_product->created_by }} </td></tr><tr><th> Updated By </th><td> {{ $report_product->updated_by }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $report_product->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $report_product->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($report_product->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $report_product->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($report_product->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
