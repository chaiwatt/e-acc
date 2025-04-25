@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">ExpertGroup {{ $expertgroup->id }}</h3>
                    @can('view-'.str_slug('ExpertGroup'))
                        <a class="btn btn-success pull-right" href="{{ url('/admin/basic/expert-groups') }}">
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
                                  <td>{{ $expertgroup->id }}</td>
                              </tr>
                              <tr><th> Title </th><td> {{ $expertgroup->title }} </td></tr><tr><th> State </th><td> {{ $expertgroup->state }} </td></tr><tr><th> Created By </th><td> {{ $expertgroup->created_by }} </td></tr><tr><th> Updated By </th><td> {{ $expertgroup->updated_by }} </td></tr>
                              <tr>
                                <th> สถานะ </th>
                                <td> {!! $expertgroup->state=='1'?'<span class="label label-success">เปิดใช้งาน</span>':'<span class="label label-danger">ปิดใช้งาน</span>' !!} </td>
                              </tr>
                              <tr>
                                <th> ผู้สร้าง </th>
                                <td> {{ $expertgroup->createdName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่สร้าง </th>
                                <td> {{ HP::DateTimeThai($expertgroup->created_at) }} </td>
                              </tr>
                              <tr>
                                <th> ผู้แก้ไข </th>
                                <td> {{ $expertgroup->updatedName }} </td>
                              </tr>
                              <tr>
                                <th> วันเวลาที่แก้ไข </th>
                                <td> {{ HP::DateTimeThai($expertgroup->updated_at) }} </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
