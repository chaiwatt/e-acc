<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="actionFour{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">ไม่ผ่านการตรวจสอบ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h6>รายละเอียด : <span style="color:black;">{{ $desc ?? null }} </span> </h6>
                    @foreach($file as $dataFile)
                        <p>ไฟล์แนบ : <a href="{{ url('certify/check/files/'.$dataFile->file) }}">
                            {!! HP::FileExtension($dataFile->file)  ?? '' !!}
                            {{basename($dataFile->file)}}</a>
                        </p>
                    @endforeach
                    @if(count($delete_file) > 0)
                        @foreach($delete_file as $item)
                            <p>ไฟล์แนบ : 
                                {{ $item->name ?? ' '  }}
                                <a href="{{ url('certify/check/files/'.$item->path) }}">
                                {!! HP::FileExtension($item->path)  ?? '' !!}
                                 {{basename($item->path)}}</a>
                            </p>
                        @endforeach
                     @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

