<div class="row">
<div class="col-md-12 form-group">
       <button type="button" class="btn btn-success btn-sm pull-right clearfix  " id="plus-row">
              <i class="icon-plus" aria-hidden="true"></i>
              เพิ่ม
       </button>
</div>
<div class="col-md-12 form-group">
       <table class="table color-bordered-table info-bordered-table">
              <thead>
              <tr class=" text-center" >
                  <th class="text-center"  width="1%">No.</th>
                  <th class="text-center"  width="15%">ปีที่สำเร็จ <span class="text-danger">*</span></th>
                  <th class="text-center"  width="20%">วุฒิการศึกษา <span class="text-danger">*</span></th>
                  <th class="text-center"  width="25%">สถานศึกษา <span class="text-danger">*</span></th>
                  <th class="text-center"  width="20%">หลักฐานการศึกษา</th>
                  <th class="text-center"  width="5%"></th>
              </tr>
              </thead>
              <tbody id="table-body">
                     @if (count($educations) > 0)
                            @foreach ($educations as $key => $education)
                                   <tr>
                                          <td>1</td>
                                          <td>
                                                 {!! Form::hidden('detail[id][]',$education->id ?? null) !!}
                                            {!! Form::text('detail[year][]', $education->year ?? null,  ['class' => 'form-control year input_required', 'maxlength' => 4, 'placeholder' => 'ปีที่สำเร็จ']) !!}
                                          </td>
                                          <td>
                                                 {!! Form::select('detail[education_id][]', 
                                                 ['1'=>'ป.ตรี','2'=>'ป.โท','3'=>'ป.เอก'], 
                                                      $education->education_id ?? null,
                                                    ['class' => 'form-control select2 education_id input_required',
                                                     'placeholder'=>'- เลือกวุฒิการศึกษา-' ]);
                                                 !!}
                                          </td>
                                          <td>
                                                 {!! Form::text('detail[academy][]',  $education->academy ??  null,  ['class' => 'form-control input_required academy', 'placeholder' => 'สถานศึกษา']) !!}
                                          </td>
                                          <td>
                                                 <span class="div_file_education">
                                                        @if (isset($education) && !is_null($education->AttachFileEducationTo))
                                                               @php
                                                                 $attach = $education->AttachFileEducationTo;
                                                               @endphp
                                                                 <a href="{{url('funtions/get-view/'.$attach->url.'/'.( !empty($attach->filename) ? $attach->filename :  basename($attach->url)  ))}}" target="_blank" 
                                                                      title="{!! !empty($attach->filename) ? $attach->filename : 'ไฟล์แนบ' !!}" class="a_file_education" >
                                                                       {!! !empty($attach->filename) ? $attach->filename : '' !!}
                                                                  </a>
                                                        @else
                                                               <div class="fileinput fileinput-new input-group " data-provides="fileinput">
                                                                      <div class="form-control" data-trigger="fileinput">
                                                                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                      <span class="fileinput-filename"></span>
                                                                      </div>
                                                                      <span class="input-group-addon btn btn-default btn-file">
                                                                      <span class="fileinput-new">เลือกไฟล์</span>
                                                                      <span class="fileinput-exists">เปลี่ยน</span>
                                                                      <input type="file" name="detail[file_education][]"  data-no=""   class="file_education check_max_size_file " >
                                                                      </span>
                                                                      <a href="#" class="input-group-addon btn btn-default fileinput-exists file_education_default" data-dismiss="fileinput">ลบ</a>
                                                               </div>
                                                               <span class="span_file_education"> </span>
                                                        @endif
                                                 </span>
                                          </td>
                                          <td  class="text-center">
                                                 <button type="button" class="btn btn-danger btn-xs repeater-remove">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                 </button>
                                          </td>
                                   </tr>
                            @endforeach 
                     @endif
                   
              </tbody>
        </table>
</div>    
</div>   
