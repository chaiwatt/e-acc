<div class="m-l-10 m-t-20 form-group" style="margin-bottom: 0">
    <h4 class="m-l-5">5. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่</h4>
</div>

<div id="work_responsibility_container">

  <div class="form-group" style="margin-bottom: 10px;margin-left: 10px">
      <div class="col-md-6"> </div>
      <button type="button" class="btn btn-sm btn-success" id="attach-add5">
          <i class="icon-plus"></i>&nbsp;เพิ่ม
      </button>
  </div>

  <div id="other_attach-box5">
      <div class="form-group other_attach_item5">
          <div class="col-md-2">
              {!! Form::text('attachs_desc5[]', null, ['class' => 'form-control m-t-10', 'placeholder' => 'ชื่อไฟล์']) !!}
          </div>
          <div class="col-md-4">
              <div class="fileinput fileinput-new input-group m-t-10" data-provides="fileinput">
                  <div class="form-control" data-trigger="fileinput">
                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                      <span class="fileinput-filename"></span>
                  </div>
                  <span class="input-group-addon btn btn-default btn-file">
                                      <span class="fileinput-new">เลือกไฟล์</span>
                                      <span class="fileinput-exists">เปลี่ยน</span>
                                          {!! Form::file('attachs_sec5[]', null) !!}
                                      </span>
                  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
              </div>
          </div>

          <div class="col-md-2 text-left m-t-15" style="margin-top: 3px">
              <button class="btn btn-danger btn-sm attach-remove5" type="button">
                  <i class="icon-close"></i>
              </button>
          </div>

      </div>
  </div>

  @if ($certi_lab_attach_all5->count() > 0)
      <div class="col-md-12" style="padding-left: 4rem;padding-right: 4rem">
          <div class="container-fluid">
              <table class="table table-bordered" id="myTable_labTest">
                  <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white col-xs-4">ชื่อไฟล์</th>
                        <th class="text-center text-white col-xs-3">ดาวน์โหลด</th>
                        <th class="text-center text-white col-xs-3">ลบ</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($certi_lab_attach_all5 as $data)
                      <tr>
                          @if ($data->file)
                              <td class="text-center">
                                  {{$data->file_desc}}
                              </td>
                              <td class="text-center">
                                  <a href="{{url('check/files/'.basename($data->file))}}" target="_blank">
                                      <i class="fa fa-file-pdf-o" style="font-size:25px; color:red" aria-hidden="true"></i>
                                  </a>
                              </td>
                              <td class="text-center">
                                  <a href="{{url('certify/applicant/delete/file').'/'.basename($data->file).'/'.$data->token}}" class="btn btn-danger btn-xs" onclick="return confirm('ต้องการลบไฟล์นี้ใช่หรือไม่ ?')">
                                      <i class="fa fa-remove"></i>
                                  </a>
                              </td>
                          @endif
                      </tr>
                  @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  @endif

</div>

@push('js')
    <script>
        $(document).ready(function () {
            //เพิ่มไฟล์แนบ
            $('#attach-add5').click(function(event) {
                $('.other_attach_item5:first').clone().appendTo('#other_attach-box5');

                $('.other_attach_item5:last').find('input').val('');
                $('.other_attach_item5:last').find('a.fileinput-exists').click();
                $('.other_attach_item5:last').find('a.view-attach').remove();

                ShowHideRemoveBtn89();

            });

            //ลบไฟล์แนบ
            $('body').on('click', '.attach-remove5', function(event) {
                $(this).parent().parent().remove();
                ShowHideRemoveBtn89();
            });

            // ทำ checkBox
            $('.check88').on('change',function () {
                let checked = $(this).prop('checked');
                let find_tag_id = $(this).attr('id')+'_text';
                if (checked === true){
                    $('input[name='+find_tag_id+']').prop('readonly',false).css('border-color','green').attr('placeholder','กรุณาใส่ชื่อไฟล์').focus();
                }else{
                    $('input[name='+find_tag_id+']').prop('readonly',true).css('border-color','#e5ebec').attr('placeholder','').val('');
                }
            });

            ShowHideRemoveBtn89();
        });

        function ShowHideRemoveBtn89() { //ซ่อน-แสดงปุ่มลบ

            if ($('.other_attach_item5').length > 1) {
                $('.attach-remove5').show();
            } else {
                $('.attach-remove5').hide();
            }

        }
    </script>
@endpush
