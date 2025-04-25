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
                    <h3 class="box-title pull-left">เอกสารสำคัญสำหรับขอรับบริการหน่วยรับรอง (CB)
                    </h3>

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

                    {!! Form::model($certi_cb, [
                        // 'method' => 'PATCH',
                        'url' => ['/certify/certi_cb/applicant_cb_doc_update',$certi_cb->id],
                        'class' => 'form-horizontal',
                        'files' => true,
                        'id'=>'app_certi_form'
                    ]) !!}

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                        @include ('certify.applicant_cb.doc-review.form')

                        <div class="row form-group">
                            <div class="col-md-12 text-center">
                                <div id="status_btn"></div>
                                <button type="button"class="btn btn-primary m-l-5" onclick="submit_form('1');return false">ส่งข้อมูล</button>
                              
                            
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

            @if( HP::check_api('check_api_certify_check_certificate_cb') && isset($certi_cb->id) && in_array( $certi_cb->status, [3] ) )
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
                            
                            var id    = '{!! $certi_cb->id !!}';
                            var table = '{!! (new App\Models\Certify\ApplicantCB\CertiCb)->getTable() !!}';

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

            @if( HP::check_api('check_api_certify_check_certificate_cb') && isset($certi_cb->id) && in_array( $certi_cb->status, [3] )  )

                var id    = '{!! $certi_cb->id !!}';
                var table = '{!! (new App\Models\Certify\ApplicantCB\CertiCb)->getTable() !!}';

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