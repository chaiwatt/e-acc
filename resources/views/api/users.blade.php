@extends('layouts.app')

@section('content')
@push('css')
    <style>
    /* The max width is dependant on the container (more info below) */
.popover{
    max-width: 100%; /* Max Width of the popover (depending on the container!) */
}
  .popover-content {
        width: 325px;
        padding: 9px 14px;
        font-size: 16px;
    }

    </style>
@endpush

@section('content')
    <div class="container-fluid  "    >
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12 ">
            <div class="white-box">

                <ul class="nav nav-tabs tabs customtab">
                    <li class="active tab">
                        <a href="#user_trader" data-toggle="tab">  <h1> TB : user_trader</h1> </a>
                    </li>
                    <li class="tab">
                        <a href="#ros_users" data-toggle="tab">  <h1> TB : ros_users</h1>  </a>
                    </li>
          
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="user_trader">
                        <div class="table-responsive">
                            <table class="table color-table primary-table">
                                <thead>
                                <tr>
                                    <th  class="text-center">#</th>
                                    <th  class="text-center">เลขนิติบุคคล FK</th>
                                     <th class="text-center">ชื่อผู้ประกอบการ</th>
                                     <th class="text-center">Username</th>
                                     <th class="text-center">Password</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($traders as $key =>  $trader)
                                        @php
                                        $trader_ids =   App\Models\Esurv\Trader::select('trader_operater_name','trader_id','trader_username','trader_password')->where('trader_id',$trader->trader_id)->get();
                                        @endphp
                                        @if (count($trader_ids))
                                              @foreach ($trader_ids as $keys =>   $trader)
                                                    <tr>
                                                          <td class="text-center"> {{ ($keys==0) ? $key +1 : null }}</td>
                                                          <td class="text-center"> {{ ($keys==0) ? $trader->trader_id : null }}</td>
                                                          <td> {{$trader->trader_operater_name}}</td>
                                                          <td> {{$trader->trader_username}}</td>
                                                          <td>
                                                              @if ($trader->trader_password == "")
                                                                    @php
                                                                    $trader10 =   App\Tb10Trader::select('trader_password')->where('trader_id',$trader->trader_username)->first();
                                                                    @endphp
                                                                    {{   $trader10->trader_password ?? null }}
    
                                                              @else
                                                                         {{$trader->trader_password}}  
                                                              @endif
                                                              
                                                         
                                                        </td>
                                                    </tr>
                                              @endforeach  
                                        @endif
                                      
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="ros_users">
                        <div class="table-responsive">
                            <table class="table color-table primary-table">
                                <thead>
                                <tr>
                                    <th  class="text-center">#</th>
                                    <th  class="text-center">เลขนิติบุคคล FK</th>
                                     <th class="text-center">ชื่อผู้ประกอบการ</th>
                                     <th class="text-center">Username</th>
                                     <th class="text-center">Password</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($users as $key =>  $user)
                                        @php
                                         $trader_ids =   App\User::select('name','username','password')->where('tax_number',$user->tax_number)->get();
                                        @endphp
                                        @if (count($trader_ids))
                                              @foreach ($trader_ids as $keys =>   $trader)
                                                    <tr>
                                                          <td class="text-center"> {{ ($keys==0) ? $key +1 : null }}</td>
                                                          <td class="text-center"> {{ ($keys==0) ? $user->tax_number : null }}</td>
                                                          <td> {{$trader->name}}</td>
                                                          <td>  {{ $trader->username }}</td>
                                                          <td>
                                                                {{$trader->password}}  
                                                        </td>
                                                    </tr>
                                              @endforeach  
                                        @endif
                                      
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               

            </div>
      </div>
    </div>
 </div>            
@endsection
 

@push('js')
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>

    <script>
        $(document).ready(function () {
 

        });

    </script>

@endpush
