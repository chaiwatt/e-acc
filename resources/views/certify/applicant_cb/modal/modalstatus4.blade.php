<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="actionFour{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">ยกเลิกคำขอ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <p>รายละเอียด : <span style="color:black;">{{ $desc ?? null }} </span> </p>
                    </div>
               </div>
                @if (count($file)   > 0)
                <div class="row">
                    @foreach($file as $data)
                      @if ($data->file)
                        <div class="col-md-2">  </div>
                        <div class="col-md-10 form-group">
                                   {{  @$data->file_desc }}
                                    <a href="{{url('certify/check/files_cb/'.$data->file)}}" target="_blank">
                                        {!! HP::FileExtension($data->file)  ?? '' !!}
                                            {{ basename($data->file) }}
                                    </a>
                        </div>
                        @endif
                     @endforeach
                  </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

