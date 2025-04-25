<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>4.	การปฏิบัติของห้องปฏิบัติการที่สอดคล้องตามข้อกำหนดมาตรฐานเลขที่ มอก. 17025 – 2561 (ISO/IEC 17025 : 2017)  (Laboratory’s implementations which are conformed with TIS 17025 - 2561 (2018) (ISO/IEC 17025 : 2017))</h4></legend>


 <div class="clearfix"></div>
 @if (!is_null($certi_lab_check_box_image) && $certi_lab_check_box_image->count() > 0)
 <div class="row">
     @foreach($certi_lab_check_box_image as $data)
       @if ($data->path_image)
         <div class="col-md-12">
             <div class="form-group">
                 <div class="col-md-12 text-light">
                     <a href="{{url('certify/check/file_client/'.$data->path_image.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->path_image)  ))}}" target="_blank">
                         {!! HP::FileExtension($data->path_image)  ?? '' !!}
                         {{  !empty($data->file_client_name) ? $data->file_client_name :  basename($data->path_image)   }}   
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
