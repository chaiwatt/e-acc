@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">Expert {{ $expert->id }}</h3>
                    @can('view-'.str_slug('experts'))
                        <a class="btn btn-success pull-right" href="{{ url('/experts') }}">
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
                                  <td>{{ $expert->id }}</td>
                              </tr>
                              <tr><th> Trader Id </th><td> {{ $expert->trader_id }} </td></tr><tr><th> Taxid </th><td> {{ $expert->taxid }} </td></tr><tr><th> Head Name </th><td> {{ $expert->head_name }} </td></tr><tr><th> Head Address No </th><td> {{ $expert->head_address_no }} </td></tr><tr><th> Head Village </th><td> {{ $expert->head_village }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $expert->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $expert->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($expert->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $expert->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($expert->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
