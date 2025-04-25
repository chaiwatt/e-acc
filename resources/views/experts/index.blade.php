@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left"><i class="mdi mdi-book"></i>ขึ้นทะเบียนผู้เชี่ยวชาญ</h3>

                       @if( count($experts->whereNotIn('status',  ['8'])) == 0 )
                            <a class="btn btn-success pull-right" href="{{url('/experts/create')}}">
                                <span class="btn-label"><i class="fa fa-plus"></i></span><b>เพิ่ม</b>
                            </a>
                        @endif

      
                    <div class="clearfix"></div>
                    <hr>

                     <div class="clearfix"></div>

                    <div class="table-responsive m-t-15">
                         
                         @php
                                $status  = ['1'=>'ยื่นคำขอ','2'=>'อยู่ระหว่างการตรวจสอบคำขอ','3'=>'ตีกลับคำขอ','4'=>'ตรวจสอบคำขอแก้ไข','5'=>'เอกสารผ่านการตรวจสอบ','6'=>'อนุมัติการขึ้นทะเบียน','7'=>'ยกเลิกคำขอ','8'=>'ยกเลิกผู้เชี่ยวชาญ'];
                         @endphp

                        <table class="table table-borderless" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="2%">#</th>
                                    <th class="text-center" width="20%">เลขคำขอ/วันที่ยื่นคำขอ</th>
                                    <th class="text-center" width="15%">ชื่อผู้เชี่ยวชาญ</th>
                                    <th class="text-center" width="15%">หน่วยงาน/สังกัด</th>
                                    <th class="text-center" width="15%">ไฟล์ความเชี่ยวชาญ</th>
                                    <th class="text-center" width="20%">สถานะ</th>
                                    <th class="text-center"width="10%">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($experts ) == 0 )
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            ไม่พบข้อมูล
                                        </td>
                                    </tr>
                                @endif
                                
                                @php
                                    $count = 1;
                                    $statusShow = 0;
                                @endphp 

                                @foreach($experts as $item)

                                    <tr>
                                        <td class="text-center text-top"  >
                                            {{ $loop->iteration + ( ((request()->query('page') ?? 1) - 1) * $experts->perPage() ) }}
                                        </td>
                                        <td class="text-top">
                                            {{ $item->ref_no }}
                                             <br>
                                            <i class="text-muted">{{  !empty( $item->created_at)? HP::DateThai($item->created_at):null  }}</i>
                                        </td>
                                        <td class="text-top">
                                            {{ $item->head_name }}
                                            {!! !empty($item->taxid ) ? '<br>('.$item->taxid  .')' : '' !!}   
                                        </td>
                                        <td class="text-top text-top">
                                           {!! !empty($item->appoint_department_to->title) ?  $item->appoint_department_to->title : '' !!}        
                                        </td>
                                        <td class="text-top text-center">
                                                    @if (isset($item) && $item->AttachFileHistorycvFileTo)
                                            @php
                                                $attach = $item->AttachFileHistorycvFileTo;
                                            @endphp
                                        
                                        
                                                        {!! !empty($attach->caption) ? $attach->caption : '' !!}
                                                        <a href="{{url('funtions/get-view/'.$attach->url.'/'.( !empty($attach->filename) ? $attach->filename :  basename($attach->url)  ))}}" target="_blank" 
                                                        title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}" >
                                                        {!! HP::FileIcon($attach->filename, '20px') !!}
                                                    </a>
                                            @endif
                                        </td>  
                                        <td class="text-top text-center">
                                                 {{{  array_key_exists($item->status,$status) ? $status[$item->status] : '-' }}}
                                        </td>
                                        <td class="text-top text-center">

                                            @if( HP::CheckPermission('view-'.str_slug('experts')))
                                                <a href="{{ url('/experts/' . $item->token) }}"  class="btn btn-info btn-xs">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                           @endif
 
                                            @if( HP::CheckPermission('edit-'.str_slug('experts')))

                                                @if (in_array($item->status,['1','2','3','4','5']))
                                                    <a href="{{ url('/experts/' . $item->token . '/edit') }}" class="btn btn-warning btn-xs">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                    </a>
                                                @else   
                                                    <a href="{{ url('/experts/' . $item->token . '/edit') }}" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"> </i>
                                                    </a>
                                                @endif
                                             
                                            @endif
                        
                                            @if( HP::CheckPermission('delete-'.str_slug('experts'))  && in_array($item->status,['1','2','3','4','5']))
                                                  {!! Form::open([
                                                        'method'=>'DELETE',
                                                        'url' => ['/experts', $item->token],
                                                          'style' => 'display:inline'
                                                 ]) !!}
                                                 {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', array(
                                                                    'type' => 'submit',
                                                                    'class' => 'btn btn-danger btn-xs confirm_delete',
                                                                    'data-token' =>  $item->token ,
                                                                     'onclick'=>'return confirm("ยืนยันการลบข้อมูล?")'
                                                                 )) !!}
                                                {!! Form::close() !!}
                                            @endif
                                     
                                        </td> 
                                    </tr>
                                    @php $count ++ @endphp
                                @endforeach
 
                            </tbody>
                        </table>

                        <div class="pull-right">
                              {{$experts->links()}}
                        </div>

 
                        <div class="pagination-wrapper">
 
                        </div>
                    </div>                   

                </div>
            </div>
        </div>
    </div>
@endsection
 
@push('js')
<script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>

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

        @if(\Session::has('message_error'))
            $.toast({
                heading: 'Error!',
                position: 'top-center',
                text: '{{session()->get('message_error')}}',
                loaderBg: '#ff6849',
                icon: 'error',
                hideAfter: 3000,
                stack: 6
            });
        @endif
    });

</script>
 
 
@endpush
