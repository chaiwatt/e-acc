@extends('layouts.master')
@push('css')
    <link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .table>tbody>tr>td ,label{
            line-height: 1.7;
            color: #5f5f5f;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                   <h3 class="box-title pull-left">คำขอรับบริการห้องปฏิบัติการ (LAB)
                  
                    @if ($labCalRequest->count() == 0 && $labTestRequest->count() ==0)
                        <span class="text-warning">(คำขอระบบเก่า)</span>
                    @endif


                   </h3>
                    {{-- {!! Form::open(['url' => 'certify/applicant/store', 'class' => 'form-horizontal','id'=>'app_certi_form', 'files' => true]) !!} --}}
                    {{--                    @can('view-'.str_slug('board'))--}}
                    <a class="btn btn-danger text-white pull-right" href="{{url('certify/applicant')}}">
                        <i class="icon-arrow-left-circle"></i> กลับ
                    </a>
                    {{--                    @endcan--}}
                    <div class="clearfix"></div>
                    <hr>
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    {!! Form::model($certi_lab, [
                        'method' => 'post',
                        'url' => ['/certify/applicant/update', $certi_lab->token],
                        'class' => 'form-horizontal',
                        'files' => true,
                        'id'=>'app_certi_form',
                    ]) !!}
                    <div class="row" id="box-readonly">

                            {{-- @include ('certify.applicant.form_show.form84')
                            @include ('certify.applicant.form_show.form85')
                            <hr>
                            @include ('certify.applicant.form_show.form86')
                            @include ('certify.applicant.form_show.form87')
                            @include ('certify.applicant.form_show.form88')
                            @include ('certify.applicant.form_show.form89')
                            @include ('certify.applicant.form_show.form90')
                            @include ('certify.applicant.form_show.form91')

                            @include ('certify.applicant.form_show.form92')
                            @include ('certify.applicant.form_show.form93')
                            @include ('certify.applicant.form_show.form94')
                            @include ('certify.applicant.form_show.form95')
                            @include ('certify.applicant.form_show.form96') --}}

                            @include ('certify.applicant.form')

                            <div id="status_btn"></div>

                            <div class="col-md-12">
                                <a  href="{{url('certify/applicant')}}">
                                    <div class="alert alert-dark text-center" role="alert">
                                        <b>กลับ</b>
                                    </div>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                    </div>
                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')





    <script>
        jQuery(document).ready(function() {

            $('#box-readonly').find('input, select, textarea').prop('disabled', true);
            $('#box-readonly').find('button').remove();
            $('#box-readonly').find('.box_remove_file').remove();
            $('#show_add_address').remove();
            $('#show_map').remove();
            
      

            
           // จัดการข้อมูลในกล่องคำขอ false
            //   $('#box-readonly').find('button[type="submit"]').remove();
            //   $('#box-readonly').find('.icon-close').parent().remove();
            //   $('#box-readonly').find('.fa-copy').parent().remove();
            //   $('#box-readonly').find('.hide_attach').hide();
            //   $('#box-readonly').find('input').prop('disabled', true);
            //   $('#box-readonly').find('input').prop('disabled', true);
            //   $('#box-readonly').find('textarea').prop('disabled', true);
            //   $('#box-readonly').find('select').prop('disabled', true);
            //   $('#box-readonly').find('.bootstrap-tagsinput').prop('disabled', true);
            //   $('#box-readonly').find('span.tag').children('span[data-role="remove"]').remove();
            //   $('#box-readonly').find('button').prop('disabled', true);
            //   $('#box-readonly').find('button').remove();
            //   $('#box-readonly').find('button').remove();
            // $('body').on('click', '.attach-remove', function() {
            //     $(this).parent().parent().parent().find('input[type=hidden]').val('');
            //     $(this).parent().remove();
            // });
        });
    </script>

@endpush