
<div width="100%" style="display:inline;line-height:12px;margin-top:-10px">

  @php
    // $issuedDate = "";
    $startDate = "";
    $toDate = "";
    // $issuedDateEn = "";
    $startDateEn = "";
    $toDateEn = "";
    $tmpIssueDate = \Carbon\Carbon::now()->format('Y/m/d');

    $issuedDate = HP::formatDateThaiFull($tmpIssueDate);
    $issuedDateEn  = HP::BEDate($tmpIssueDate);

    if($app_certi_ib->app_certi_ib_export != null)
    {
        if($app_certi_ib->app_certi_ib_export->date_start != null)
        {
            $startDate = HP::formatDateThaiFull($strDate);
            $startDateEn  = HP::BEDate($app_certi_ib->app_certi_ib_export->date_start);

            $tmpToDate = \Carbon\Carbon::parse($strDate)->addYears(5)->format('Y/m/d');
            $toDate = HP::formatDateThaiFull($tmpToDate);
            $toDateEn  = HP::BEDate($tmpToDate);


            
        }
    }
  @endphp

    <div style="display:inline-block;line-height:20px;float:left;width:70%;">
      <span style="font-size:18px;">Date of Initial Issue: {{$issuedDateEn}}</span><br> 
      <span style="font-size: 18px">Ministry of Industry Thailand, Thai Industrial Standards Institute</span>  
    </div>
  
    <div style="display: inline-block; width: 15%;float:right;width:25%">
      {{-- {{$sign1Image}} --}}
      @if($sign1Image)
      
        <div style="display: inline-block; width: 31%;float:left;">
          {{-- {{$sign1Image}} --}}
          <img src="{{ $sign1Image }}" style="width: 50px"/>
        </div>
      @endif
  
      {{-- @if($sign1Image)
        <div style="display: inline-block; width: 31%;margin-left:6px;float:left;">
          <img src="{{ $sign1Image }}" style="width: 50px"/>
        </div>
      @endif --}}
      
      @if($sign3Image)
        <div style="display: inline-block;  width:31% ;float:right;visibility: hidden">
          <img src="{{ $sign3Image }}" style="width: 50px"/>
        </div>
      @endif
    </div>
  
    <div width="100%" style="display:inline;text-align:center">
      <span>Page {{$currentPage}}/{{$totalPages}}</span>
    </div>
</div>
  