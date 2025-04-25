@if(!is_null($history->details_two))
@php 
    $details_one = json_decode($history->details_one);
    $details_two =json_decode($history->details_two);
@endphp              
   <h4 class=" text-left">1. จำนวนวันที่ใช้ตรวจประเมินทั้งหมด <span>{{ $history->MaxAmountDate  ?? '-' }}</span> วัน</h4>
   <h4 class=" text-left">2. ค่าใช้จ่ายในการตรวจประเมินทั้งหมด <span>{{ $history->SumAmount ?? '-' }}</span> บาท </h4>
    <table class="table table-bordered" id="myTable_labTest">
        <thead class="bg-primary">
        <tr>
            <th class="text-center bg-info  text-white" width="2%">ลำดับ</th>
            <th class="text-center bg-info  text-white" width="38%">รายละเอียด</th>
            <th class="text-center bg-info  text-white" width="20%">จำนวนเงิน (บาท)</th>
            <th class="text-center bg-info  text-white" width="20%">จำนวนวัน (วัน)</th>
            <th class="text-center bg-info  text-white" width="20%">รวม (บาท)</th>
        </tr>
        </thead>
        <tbody id="costItem">
            @foreach($details_two as $key => $item2)
                @php     
                $amount_date = !empty($item2->amount_date) ? $item2->amount_date : 0 ;
                $amount = !empty($item2->amount) ? $item2->amount : 0 ;
                $sum =   $amount*$amount_date;
                $details =  App\Models\Bcertify\StatusAuditor::where('id',$item2->detail)->first();
                @endphp
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ !is_null($details) ? $details->title : null  }}</td>
                    <td class="text-right">{{ number_format($amount, 2) }}</td>
                    <td class="text-right">{{ $amount_date }}</td>
                    <td class="text-right">{{ number_format($sum, 2) ?? '-'}}</td>
                </tr>
            @endforeach
        </tbody>
        <footer>
            <tr>
                <td colspan="4" class="text-right">รวม</td>
                <td class="text-right">
                     {{ $history->SumAmount ?? '-' }} 
                </td>
            </tr>
        </footer>
    </table>
@endif

@if(!is_null($history->attachs)) 
@php 
$attachs = json_decode($history->attachs);
@endphp
<div class="row">
<div class="col-md-4 text-right">
<p >ขอบข่าย:</p>
</div>
<div class="col-md-8  text-left">
   @foreach($attachs as $scope)
   <p>      
        <a href="{{url('certify/check/file_ib_client/'.$scope->file.'/'.( !empty($scope->file_client_name) ? $scope->file_client_name : @basename($scope->file) ))}}" target="_blank">
            {{  !empty($scope->file_client_name) ? $scope->file_client_name :  basename($scope->file)   }}
        </a>
   </p>
   @endforeach
</div>
</div>
@endif

@if(isset($details_one->check_status))
<legend><h3>เหตุผล / หมายเหตุ ขอแก้ไข</h3></legend>

<div class="row">
   <div class="col-md-4 text-right">
            <p >เห็นชอบกับค่าใช่จ่ายที่เสนอมา</p>
    </div>
    <div class="col-md-8  text-left">
        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($details_one->check_status == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน &nbsp;</label>
        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($details_one->check_status == 2 ) ? 'checked' : ' '  }}>  &nbsp;แก้ไข &nbsp;</label>
    </div>
</div>
@endif
@if(isset($details_one->remark) && $details_one->check_status == 2) 
    <div class="row">
    <div class="col-md-4 text-right">
    <p >หมายเหตุ</p>
    </div>
    <div class="col-md-8  text-left">
       {{ @$details_one->remark ?? ''}}
    </div>
    </div>
@endif

@if(!is_null($history->attachs_file))
        @php 
        $attachs_file = json_decode($history->attachs_file);
        @endphp 
        <div class="row">
        <div class="col-md-4 text-right">
        <p >หลักฐาน:</p>
        </div>
        <div class="col-md-8  text-left">
        @foreach($attachs_file as $files)
            <p> 
                @if(isset($files->file))
                {{  @$files->file_desc  }}
                <a href="{{url('certify/check/file_ib_client/'.$files->file.'/'.( !empty($files->file_client_name) ? $files->file_client_name :  @basename($files->file) ))}}" target="_blank">
                    {{  !empty($files->file_client_name) ? $files->file_client_name :  basename($files->file)   }}
                 </a>
                @endif
            </p>
        @endforeach
        </div>
        </div>
 @endif

 @if(isset($details_one->status_scope))
<div class="row">
   <div class="col-md-4 text-right">
       <p >เห็นชอบกับ Scope</p>
    </div>
    <div class="col-md-8  text-left">
        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-green" {{ ($details_one->status_scope == 1 ) ? 'checked' : ' '  }}>  &nbsp;ยืนยัน Scope &nbsp;</label>
        <label>   <input type="radio" class="check check-readonly" data-radio="iradio_square-red" {{ ($details_one->status_scope == 2 ) ? 'checked' : ' '  }}>  &nbsp; แก้ไข Scope &nbsp;</label>
    </div>
</div>
@endif
@if(isset($details_one->remark_scope) && $details_one->status_scope == 2) 
    <div class="row">
    <div class="col-md-4 text-right">
    <p >หมายเหตุ</p>
    </div>
    <div class="col-md-8  text-left">
       {{ @$details_one->remark_scope ?? ''}}
    </div>
    </div>
@endif


@if(!is_null($history->evidence))
@php 
$evidence = json_decode($history->evidence);
@endphp 
<div class="row">
<div class="col-md-4 text-right">
<p >หลักฐาน:</p>
</div>
<div class="col-md-8  text-left">
@foreach($evidence as $files)
    <p> 
        @if(isset($files->attach_files))
          {{  @$files->file_desc_text  }}
          <a href="{{url('certify/check/file_ib_client/'.$files->attach_files.'/'.( !empty($files->file_client_name) ? $files->file_client_name :  @basename($files->attach_files) ))}}" target="_blank">
            {!! HP::FileExtension($files->attach_files)  ?? '' !!}
            {{ !empty($files->file_client_name) ? $files->file_client_name : basename($files->attach_files)}}
          </a> 
        @endif
    </p>
@endforeach
</div>
</div>
@endif

@if(!is_null($history->date)) 
   <div class="row">
       <div class="col-md-4 text-right">
           <p >วันที่บันทึก</p>
       </div>
       <div class="col-md-8  text-left">
           {{ @HP::DateThai($history->date) ?? '-' }}
       </div>
   </div>
@endif