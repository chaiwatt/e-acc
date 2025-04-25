<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="NotValidated{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >
                ไม่ผ่านการตรวจสอบ
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </h4>
            </div>
            <div class="modal-body">

                   <div class="row form-group ">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2 text-right">รายละเอียด :</div>
                        <div class="col-sm-9">{{ $desc ?? null }}</div>
                  </div>

                  @if(count($files) > 0)
                    <div class="row form-group ">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2 text-right">หลักฐาน :</div>
                        <div class="col-sm-9">
                            @foreach ($files as $item) 
                            {{  @$item->file_desc }}
                            <a href="{{url('certify/check/files_ib/'.$item->file)}}" target="_blank">
                                {!! HP::FileExtension($item->file)  ?? '' !!}
                                {!!  @basename($item->file) ?? '' !!}
                            </a> <br>
                        @endforeach
                        </div>
                    </div>
                  @endif

                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

