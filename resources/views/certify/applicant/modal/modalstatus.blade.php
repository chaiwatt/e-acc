<!-- Modal เลข 4 Delete -->
<div class="modal fade" id="modalstatus{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ประวัติยื่นคำขอรับใบรับรองระบบงาน <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
            </div>
            <div class="modal-body">
                @php 
                 $history =   App\Models\Certify\CertificateHistory::select('id','system')
                                                                    ->where('app_no',$app_no)
                                                                    ->whereIn('system',[1,2,3,6])
                                                                    // ->groupBy('system')
                                                                    ->get();
                @endphp
                @if(count($history) > 0)
                   @foreach($history as $key => $item)
                    <div class="row">
                         <div class="col-md-2 text-right"> {{ $key +1 }} . </div>
                        <div class="col-md-8 text-left">
                            <p class="text-nowrap">
                                <a  href="{{url('certify/applicant/data_show/'.$token.'/'.$item->id)}}"> {{ $item->DataSystem ?? null }} </a>
                            </p>
                        </div>
                    </div>
                    @endforeach
                @endif
          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            </div>


        </div>
    </div>
</div>


