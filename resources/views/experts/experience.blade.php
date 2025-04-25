<div class="row">
<div class="col-md-12">
              <h3 class="box-title pull-left">ประสบการณ์</h3>
              <button type="button" class="btn btn-success btn-sm pull-right" id="plus_experiences_row">
                            <i class="icon-plus" aria-hidden="true"></i>
                            เพิ่ม
                            </button>
              <div class="clearfix"></div>
              <hr>
</div>
<div class="col-md-12 form-group">
       <table class="table color-bordered-table info-bordered-table">
              <thead>
              <tr class=" text-center" >
                  <th class="text-center"  width="1%">No.</th>
                  <th class="text-center"  width="15%">ปี <span class="text-danger">*</span></th>
                  <th class="text-center"  width="20%">หน่วยงาน <span class="text-danger">*</span></th>
                  <th class="text-center"  width="25%">ตำแหน่ง <span class="text-danger">*</span></th>
                  <th class="text-center"  width="20%">บทบาทหน้าที่ <span class="text-danger">*</span></th>
                  <th class="text-center"  width="5%"></th>
              </tr>
              </thead>
              <tbody id="table_experiences_body">
                     @if (count($experiences) > 0)
                            @foreach ($experiences as $key => $experience)
                                   <tr>
                                          <td>1</td>
                                          <td>
                                                 {!! Form::hidden('experience[id][]',$experience->id ?? null) !!}
                 
                                                  {!! Form::select('experience[years][]', 
                                                       HP::Years(), 
                                                        $experience->years ?? null,
                                                        ['class' => 'form-control select2 years  input_required',
                                                        'placeholder'=>'- เลือกปี-' ]);
                                                  !!}
                                          </td>
                                          <td>
                                                 {!! Form::select('experience[department_id][]', 
                                                    App\Models\Basic\AppointDepartment::orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                                                      $experience->department_id ?? null,
                                                    ['class' => 'form-control select2 department_id input_required',
                                                     'placeholder'=>'- เลือกหน่วยงาน-' ]);
                                                 !!}
                                          </td>
                                          <td> 
                                                 {!! Form::text('experience[position][]',  $experience->position ??  null,  ['class' => 'form-control input_required position', 'maxlength' => '255', 'placeholder' => 'ตำแหน่ง']) !!}
                                          </td>
                                          <td>
                                                {!! Form::text('experience[role][]',  $experience->role ??  null,  ['class' => 'form-control input_required role', 'maxlength' => '255', 'placeholder' => 'บทบาทหน้าที่']) !!}
                                          </td>
                                          <td  class="text-center">
                                                 <button type="button" class="btn btn-danger btn-xs repeater_experiences_remove">
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
 

<div class="row">
<div class="col-md-12">
              <h3 class="box-title pull-left">ประวัติการดำเนินงานกับ สมอ.</h3>
              <button type="button" class="btn btn-success btn-sm pull-right" id="plus_historys_row">
                            <i class="icon-plus" aria-hidden="true"></i>
                            เพิ่ม
                            </button>
              <div class="clearfix"></div>
              <hr>
</div>
<div class="col-md-12 form-group">
         <table class="table color-bordered-table info-bordered-table">
              <thead>
              <tr class=" text-center" >
                            <th class="text-center"  width="1%">No.</th>
                            <th class="text-center"  width="15%">วันที่ดำเนินการ <span class="text-danger">*</span></th>
                            <th class="text-center"  width="15%">หน่วยงาน <span class="text-danger">*</span></th>
                            <th class="text-center"  width="10%">คำสั่งที่ </th>
                            <th class="text-center"  width="15%">ความเชียวชาญด้าน <span class="text-danger">*</span></th>
                            <th class="text-center"  width="10%">ตำแหน่ง <span class="text-danger">*</span></th>
                            <th class="text-center"  width="5%"></th>
              </tr>
              </thead>
              <tbody id="table_historys_body">
                            @if (count($historys) > 0)
                            @foreach ($historys as $key => $history)
                                          <tr>
                                          <td>1</td>
                                          <td>
                                                        {!! Form::hidden('history[id][]',$history->id ?? null) !!}
                                                        {!! Form::text('history[operation_at][]',  !empty( $history->operation_at)? HP::revertDate($history->operation_at,true):null , ['class' => 'form-control mydatepicker_th  operation_at input_required', 'maxlength' => '255', 'placeholder' => 'dd/mm/yyyy']) !!}
                                          </td>
                                          <td>
                                                        {!! Form::select('history[department_id][]', 
                                                        App\Models\Basic\AppointDepartment::orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                                                        $history->department_id ?? null,
                                                        ['class' => 'form-control select2 department_id input_required',
                                                        'placeholder'=>'- เลือกหน่วยงาน-' ]);
                                                        !!}
                                          </td>
                                          <td> 
                                                        {!! Form::text('history[committee_no][]',  $history->committee_no ??  null,  ['class' => 'form-control  committee_no', 'maxlength' => '255', 'placeholder' => 'คำสั่งที่']) !!}
                                          </td>
                                          <td>
                                                        {!! Form::select('history[expert_group_id][]', 
                                                        App\Models\Basic\ExpertGroup::orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                                                        $history->expert_group_id ?? null,
                                                        ['class' => 'form-control select2 expert_group_id input_required',
                                                        'placeholder'=>'- เลือกความเชียวชาญด้าน-' ]);
                                                        !!}
                                          </td>
                                          <td>
                                                        {!! Form::select('history[position_id][]', 
                                                        App\Models\Basic\BoardType::orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                                                        $history->position_id ?? null,
                                                        ['class' => 'form-control select2 position_id input_required',
                                                        'placeholder'=>'- เลือกตำแหน่ง-' ]);
                                                        !!}
                                          </td>
                                          <td  class="text-center">
                                                        <button type="button" class="btn btn-danger btn-xs repeater_historys_remove">
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