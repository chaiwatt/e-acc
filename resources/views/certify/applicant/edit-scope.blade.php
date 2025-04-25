@extends('layouts.master')
@push('css')

    <style>
        .table>tbody>tr>td ,label{
            line-height: 1.7;
            color: #5f5f5f;
        }

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
        .modal-xl {
            width: 80%; /* กำหนดความกว้างตามที่คุณต้องการ */
            max-width: none; /* ยกเลิกค่า max-width เริ่มต้น */
        }
        .modal-xxl {
            width: 90%; /* กำหนดความกว้างตามที่คุณต้องการ */
            max-width: none; /* ยกเลิกค่า max-width เริ่มต้น */
        }
        .non-editable {
            pointer-events: none; /* ทำให้ไม่สามารถคลิกหรือแก้ไขได้ */
            opacity: 0.9; /* กำหนดความทึบของ textarea */
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขขอบข่ายคำขอรับบริการห้องปฏิบัติการ (LAB) </h3>

                    <a class="btn btn-danger text-white pull-right" href="{{url('certify/applicant')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                    </a>

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

                    {!! Form::model($certi_lab, [
                        'method' => 'post',
                        'url' => ['/certify/applicant/update-scope', $certi_lab->token],
                        'class' => 'form-horizontal',
                        'id'=>'app_certi_form',
                        'files' => true
                    ]) !!}

                        {{-- @include ('certify.applicant.form_edit.form84')
                        @include ('certify.applicant.form_edit.form85')
                        <hr>
                        @include ('certify.applicant.form_edit.form86')
                        @include ('certify.applicant.form_edit.form87')
                        @include ('certify.applicant.form_edit.form88')
                        @include ('certify.applicant.form_edit.form89')
                        @include ('certify.applicant.form_edit.form90')
                        @include ('certify.applicant.form_edit.form91')

                        @include ('certify.applicant.form_edit.form92')
                        @include ('certify.applicant.form_edit.form93')
                        @include ('certify.applicant.form_edit.form94')
                        @include ('certify.applicant.form_edit.form95')
                        @include ('certify.applicant.form_edit.form96') --}}

                        
                        @include ('certify.applicant.form-edit-scope',
                        ['scope_edit' => true])

                        <center>
                            <div class="col-md-12 text-center">
                                <div id="status_btn"></div>
                                <button type="button"class="btn btn-default m-l-5" value="ส่งข้อมูล"  name="save" onclick="submit_form('1');return false" disabled>ส่งข้อมูล</button>
                                {{-- <button type="button" class="btn btn-warning text-white m-l-5" id="draft" name="draft" value="ฉบับร่าง" onclick="submit_form_draft('0');return false">ฉบับร่าง</button> --}}
                                <a href="{{url('certify/applicant')}}" class="btn btn-danger text-white m-l-5" id="cancel_edit_calibrate">ยกเลิก</a>
                            </div>
                        </center>

                        <div class="clearfix"></div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <script>

        $(document).ready(function () {

            @if(\Session::has('flash_message'))
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('flash_message')}}',
                loaderBg: '#70b7d6',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
            @endif

            @if( HP::check_api('check_api_certify_check_certificate') && isset($certi_lab->id) && in_array( $certi_lab->status, [3] ) )
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
                            
                            var id    = '{!! $certi_lab->id !!}';
                            var table = '{!! (new App\Models\Certify\Applicant\CertiLab)->getTable() !!}';

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

            @if( HP::check_api('check_api_certify_check_certificate') && isset($certi_lab->id) && in_array( $certi_lab->status, [3] )  )

                var id    = '{!! $certi_lab->id !!}';
                var table = '{!! (new App\Models\Certify\Applicant\CertiLab)->getTable() !!}';

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
