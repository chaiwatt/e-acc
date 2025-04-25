@push('css')
    <link href="{{asset('plugins/components/summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
<div id="viewForm91" style="display: none">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="white-box" style="border: 2px solid #e5ebec;">
                <legend><h4><span class="text-danger">*</span> 6. ขอบข่ายที่ยื่นขอรับการรับรอง (<span class="text-warning">ห้องปฏิบัติการสอบเทียบ</span>) (Scope of Accreditation Sought (<span class="text-warning">For calibration laboratory</span>)) <span class="text-danger">ไฟล์แนบ Word</span><span class="text-danger" style="font-size: 13px;"> (doc,docx)</span></h4></legend>
   
          <div class="row">
                    <div class="col-md-10">
                        <div class="white-box m-t-20" style="border: 2px solid #e5ebec;">
                            <table class="table table-bordered" id="myTable_labCalibrate">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="text-center text-white "  width="10%">ลำดับ</th>
                                    <th class="text-center text-white "  width="70%">สาขาการสอบเทียบ</th>
                                </tr>
                                </thead>
                                <tbody id="labCalibrate_tbody">
                                    @if ($certi_lab->certi_lab_calibrate->count() > 0)
                                    @foreach ($certi_lab->certi_lab_calibrate as $key => $scope)
                                            <tr>
                                                <td class="text-center" style="vertical-align:top">{{ $key +1 }}</td>
                                                <td   style="vertical-align:top">{{ $scope->getBranch()->title ?? ""}}</td>    
                                            </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
             </div>
             
    <div class="clearfix"></div>
    @if ($certi_lab_attach_all62->count() > 0)
    <div class="row">
        @foreach($certi_lab_attach_all62 as $data)
          @if ($data->file)
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 text-light">
                        <a href="{{url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name :   basename($data->file) ))}}" target="_blank">
                               {!! HP::FileExtension($data->file)  ?? '' !!}
                               {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)   }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
         @endforeach
      </div>
    @endif

          </div>
       </div>
    </div>
</div>


@push('js')
<script src="{{ asset('plugins/components/summernote/summernote.js') }}"></script>
<script src="{{ asset('plugins/components/summernote/summernote-ext-specialchars.js') }}"></script>

    <script>
        $(document).ready(function () {
            ResetTableCalibrate();

         //รีเซตเลขลำดับ
        function ResetTableCalibrate(){
            var rows = $('#labCalibrate_tbody').children(); //แถวทั้งหมด
            rows.each(function(index, el) {
                $(el).children().first().html(index+1);
            });
            }
            
        });   

    </script>

@endpush
