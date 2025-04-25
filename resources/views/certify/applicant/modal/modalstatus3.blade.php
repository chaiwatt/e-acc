<!-- Modal เลข 3 -->
<div class="modal fade text-left" id="actionThree{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addBrand">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">ขอเอกสารเพิ่มเติม</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h6>รายละเอียด : <span style="color:black;">{{ $desc ?? null }} </span> </h6>
                    @if (count($file) > 0)
                        @foreach($file as $dataFile)
                            <p>ไฟล์แนบ : 
                                    <a href="{{url('certify/check/file_client/'.$dataFile->file.'/'.( !is_null($dataFile->file_client_name) ? $dataFile->file_client_name : basename($dataFile->file)  ))}}" target="_blank">
                                {!! HP::FileExtension($dataFile->file)  ?? '' !!}
                                {{basename($dataFile->file)}}
                            </a>
                            </p>
                        @endforeach
                    @endif
                    <p id="checkid"><a  class="btn btn-success"  href="{{ route('applicant.edit',['token'=>$token]) }}">แก้ไขคำขอ</a></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
 