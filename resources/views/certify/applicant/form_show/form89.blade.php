<?php $key=0?>

<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4><span class="text-danger">*</span> 5. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)</h4></legend>

<div id="work_responsibility_container">


<div class="clearfix"></div>
@if ($certi_lab_attach_all5->count() > 0)
<div class="row">
    @foreach($certi_lab_attach_all5 as $data)
      @if ($data->file)
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12 text-light">
                    <a href="{{url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name :  basename($data->file) ))}}" target="_blank">
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

