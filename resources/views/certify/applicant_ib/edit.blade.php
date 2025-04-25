@extends('layouts.master')
@push('css')
    <style>
        .alert-primary-new {
            color: #004085;
            background-color: #cce5ff;
            border-color: #b8daff;
        }

        .alert-danger-new {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">คำขอรับบริการหน่วยตรวจ (IB)</h3>
                    @if( HP::CheckPermission('view-'.str_slug('applicantibs')))
                        <a class="btn btn-success pull-right " href="{{ url('/certify/applicant-ib') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
                        </a>
                    @endif
                    <div class="clearfix"></div>
                    <hr>

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Check API -->  
                    @include ('api.notification')

                    {!! Form::model($certi_ib, [
                        'method' => 'PATCH',
                        'url' => ['/certify/applicant-ib', $certi_ib->token],
                        'class' => 'form-horizontal',
                        'files' => true,
                        'id'=>'app_certi_form'
                    ]) !!}

                        @include ('certify.applicant_ib.form')

                        {{-- @include ('certify.applicant_ib/from.form01')
                        @include ('certify.applicant_ib/from.form02')
                        @include ('certify.applicant_ib/from.form03')
                        @include ('certify.applicant_ib/from.form04')
                        @include ('certify.applicant_ib/from.form05')
                        @include ('certify.applicant_ib/from.form06')
                        @include ('certify.applicant_ib/from.form07')
                        @include ('certify.applicant_ib/from.form08')
                        @include ('certify.applicant_ib/from.form09')
                        @include ('certify.applicant_ib/from.form10') --}}
                    <div class="row form-group">
                        <div class="col-md-12 text-center">
                            <div id="status_btn"></div>
                            <button type="button"
                                    class="btn btn-primary m-l-5 "
                                    onclick="submit_form('1');return false">
                                    ส่งข้อมูล
                           </button>
                            <button  type="button"
                                    class="btn btn-warning text-white m-l-5 "
                                    onclick="submit_form_draft('0');return false">
                                    ฉบับร่าง
                            </button>
                            <a href="{{ url("certify/applicant-ib") }}"  class="btn btn-danger text-white m-l-5 " id="cancel_edit_calibrate">ยกเลิก</a>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

        $(document).ready(function () {

            @if( HP::check_api('check_api_certify_check_certificate_ib') && isset($certi_ib->id) && in_array( $certi_ib->status, [3] ) )
                $('.btn-update-compare').click(function (e) { 
                    
                    Swal.fire({
                        title: 'ยืนยันการอัพเดท',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.value) {
                            
                            var id    = '{!! $certi_ib->id !!}';
                            var table = '{!! (new App\Models\Certify\ApplicantIB\CertiIb)->getTable() !!}';

                            $.ajax({
                                type: 'get',
                                url: "{!! url('/funtions/update_api_pid') !!}",
                                data: {
                                    id:id,
                                    table:table
                                },
                            }).done(function( object ) {
                                if(object.status!=undefined){

                                    if(object.status=='success'){//ข้อมูลตรง
                                        $('#modal-compare').modal('hide');
                                        CheckUpdateDBD();
                                        location.reload(); 
                                    }else{
                                        CheckUpdateDBD();
                                    }

                                }
                            });

                        }
                    });
                });

                CheckUpdateDBD();
            @endif

        });

        function CheckUpdateDBD(){

            @if( HP::check_api('check_api_certify_check_certificate_ib') && isset($certi_ib->id) && in_array( $certi_ib->status, [3] ) )

                var id    = '{!! $certi_ib->id !!}';
                var table = '{!! (new App\Models\Certify\ApplicantIB\CertiIb)->getTable() !!}';

                $.ajax({
                    type: 'get',
                    url: "{!! url('/funtions/check_api_pid') !!}" ,
                    data: {
                        id:id,
                        table:table,
                        type:'false'
                    },
                }).done(function( result ) {

                    $('#show-compare').html('');//ข้อความจากเซิร์ฟเวอร์

                    $('.btn-update-compare').hide();

                    if(result.status!=undefined){

                        if(result.status=='success'){//ข้อมูลตรง
                            var html = '<div class="alert alert-primary-new" role="alert"><h4 class="alert-heading">ข้อมูลผู้ยื่นถูกต้อง<h4><div class="alert-message">ข้อมูลตรงกับหน่วยงานที่เกี่ยวข้อง <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-compare">คลิกดูรายละเอียด</a></div></div>';
                        }else if(result.status=='fail'){//ข้อมูลไม่ตรง
                            var html = '<div class="alert alert-danger-new" role="alert"><h4 class="alert-heading">ข้อมูลผู้ยื่นไม่ถูกต้อง</h4><div class="alert-message">ข้อมูลไม่ตรงกับหน่วยงานที่เกี่ยวข้อง <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-compare">คลิกดูรายละเอียด</a></div></div>';
                            $('.btn-update-compare').show();
                            $('#modal-compare').modal('show');
                        }else if(result.status=='error'){//เกิดข้อผิดพลาด
                            var html = '<div class="alert alert-danger-new" role="alert"><h4 class="alert-heading">ผิดพลาด</h4><div class="alert-message">เกิดผิดพลาดในระบบ <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-compare">คลิกดูรายละเอียด</a></div></div>';
                            $('#modal-compare').modal('show');
                        }

                        if( result.msg !=undefined ){

                            var object = result.msg;

                            var table  = '';
                            
                            if( object.data !=undefined && object.data.length > 0  ){

                                var thead = '';
                            
                                if( object.type !=undefined && object.type == 'company' ){
                                    thead = '<tr>';
                                    thead += '<th class="text-center">ชื่อข้อมูล</th>';
                                    thead += '<th class="text-center">ข้อมูลในระบบ</th>';
                                    thead += '<th class="text-center">ข้อมูลจากกรมพัฒนาธุรกิจการค้า</th>';
                                    thead += '</tr>';
                                }else if( object.type !=undefined && object.type == 'person' ){
                                    thead = '<tr>';
                                    thead += '<th class="text-center">ชื่อข้อมูล</th>';
                                    thead += '<th class="text-center">ข้อมูลในระบบ</th>';
                                    thead += '<th class="text-center">ข้อมูลจากกรมการปกครอง</th>';
                                    thead += '</tr>';
                                }

                                var tbody = '';
                                $(object.data).each(function(index, element){
                                    tbody += '<tr class="'+ ( element.status == true ? 'success':'danger' ) +'">';
                                    tbody += '<td>'+( element.label)+'</td>';
                                    tbody += '<td>'+( (element.old != null )?element.old:'')+'</td>';
                                    tbody += '<td>'+( (element.new != null )?element.new:'' )+'</td>';
                                    tbody += '</tr>';
                                });

                                table  = '<div class="col-md-12"><div class="table-responsive"><table class="table color-bordered-table info-bordered-table"><thead>'+(thead)+'</thead><tbody>'+(tbody)+'</tbody></table></div></div>';
                            }else{
                                table  = result.msg;
                            }
                           
                        }

                        $('#show-compare').html(html);//ข้อความจากเซิร์ฟเวอร์
                        $('#system-message-container').html(table);
                    }
                    
                });

            @endif
            
        }
    </script>
@endpush