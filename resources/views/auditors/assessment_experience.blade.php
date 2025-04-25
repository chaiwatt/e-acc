<div class="white-box"> 
          <div class="row">
             <div class="col-sm-12">
              <legend><h3 class="box-title">ประสบการณ์การตรวจประเมิน</h3></legend>
      
                 <div class="row  ">
                     <div class="col-sm-6  form-group">
                          {!! HTML::decode(Form::label('filter_experience_start_date', 'วันที่ตรวจประเมิน:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                          <div class="col-md-8">
                            <div class="input-daterange input-group" id="date-experience">
                              {!! Form::text('', null, ['class' => 'form-control','id'=>'filter_experience_start_date']) !!}
                              <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>
                              {!! Form::text('', null, ['class' => 'form-control','id'=>'filter_experience_end_date']) !!}
                            </div>
                          </div>
                     </div>  
                     <div class="col-sm-6  form-group">
                          {!! HTML::decode(Form::label('filter_experience_type_of_check', 'ประเภทการตรวจประเมิน:<span class="text-danger">*</span>', ['class' => 'col-md-5 control-label label-filter'])) !!}
                          <div class="col-md-7">
                                    {!! Form::select('', 
                                    ['1'=>'CB','2'=>'IB','3'=>'LAB สอบเทียบ','4'=>'LAB ทดสอบ'], 
                                     null,
                                    ['class' => 'form-control',
                                    'id' => 'filter_experience_type_of_check',
                                    'placeholder'=>'- เลือกประเภทการตรวจประเมิน -' ]) !!}
                                   {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                          </div>
                     </div>  
                </div>
                <div class="row">
                     <div class="col-sm-6  form-group">
                          {!! HTML::decode(Form::label('filter_experience_check_standard', 'มาตรฐาน:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                          <div class="col-md-8">
                                    {!! Form::select('', 
                                     [], 
                                     null,
                                    ['class' => 'form-control',
                                    'id' => 'filter_experience_check_standard',
                                    'placeholder'=>'- เลือกมาตรฐาน -' ]); !!}
                                   {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                          </div>
                     </div> 
                     <div class="col-sm-6  form-group" id="div_check_branch">
                          {!! HTML::decode(Form::label('filter_experience_check_branch', 'สาขา:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                          <div class="col-md-8">
                                 {!! Form::select('', 
                                     [], 
                                       null,
                                       ['class' => 'form-control',
                                      'id' => 'filter_experience_check_branch',
                                      'placeholder'=>'- เลือกสาขา -' ]); !!}
                                   {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                          </div>
                     </div>  
                </div>
              
                 <div class="row">
                      <!--start cb  -->
                          <div class="col-sm-6  form-group" id="div_experience_check_scop">
                               {!! Form::label('filter_experience_check_scope', 'ขอบข่าย:', ['class' => 'col-md-4 control-label label-filter']) !!}
                               <div class="col-md-8">
                                         {!! Form::select('', 
                                          [], 
                                          null,
                                         ['class' => 'form-control',
                                         'id' => 'filter_experience_check_scope',
                                         'placeholder'=>'- เลือกขอบข่าย -' ]); !!}
                                        {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                               </div>
                          </div> 
                      <!--end cb  -->
                      <!--start ib  -->
                          <div class="col-sm-6  form-group inspection">
                                  {!! Form::label('filter_experience_check_inspection', 'ประเภทหน่วยตรวจ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                                  <div class="col-md-8">
                                          {!! Form::select('', 
                                          [], 
                                          null,
                                          ['class' => 'form-control',
                                          'id' => 'filter_experience_check_inspection',
                                          'placeholder'=>'- เลือกประเภทหน่วยตรวจ -' ]); !!}
                                          {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                                  </div>
                          </div>  
                          <div class="col-sm-6  form-group inspection">
                              {!! Form::label('filter_experience_check_category', 'หมวดหมู่การตรวจ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                              <div class="col-md-8">
                                      {!! Form::select('', 
                                      [], 
                                      null,
                                      ['class' => 'form-control',
                                      'id' => 'filter_experience_check_category',
                                      'placeholder'=>'- เลือกหมวดหมู่การตรวจ -' ]); !!}
                                      {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                              </div>
                          </div>  
                      <!-- end ib  -->
                      <!--start LAB สอบเทียบ  -->
                          <div class="col-sm-6  form-group " id="calibration">
                              {!! Form::label('filter_experience_check_calibration', 'รายการสอบเทียบ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                              <div class="col-md-8">
                                      {!! Form::select('', 
                                      [], 
                                      null,
                                      ['class' => 'form-control',
                                      'id' => 'filter_experience_check_calibration',
                                      'placeholder'=>'- เลือกรายการสอบเทียบ -' ]); !!}
                                      {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                              </div>
                          </div>  
                      <!--end LAB สอบเทียบ  -->
                      <!--start LAB ทดสอบ  -->
                          <div class="col-sm-6  form-group product">
                              {!! Form::label('filter_experience_check_product', 'ผลิตภัณฑ์:', ['class' => 'col-md-4 control-label label-filter']) !!}
                              <div class="col-md-8">
                                      {!! Form::select('', 
                                      [], 
                                      null,
                                      ['class' => 'form-control',
                                      'id' => 'filter_experience_check_product',
                                      'placeholder'=>'- เลือกผลิตภัณฑ์ -' ]); !!}
                                      {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                              </div>
                          </div>  
                          <div class="col-sm-6  form-group product">
                              {!! Form::label('filter_experience_check_test', 'รายการทดสอบ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                              <div class="col-md-8">
                                      {!! Form::select('', 
                                      [], 
                                      null,
                                      ['class' => 'form-control',
                                      'id' => 'filter_experience_check_test',
                                      'placeholder'=>'- เลือกรายการทดสอบ -' ]); !!}
                                      {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                              </div>
                          </div>
                        <!-- end LAB ทดสอบ  -->  
                 </div>
                 <div class="row">
                          <div class="col-sm-6  form-group">
                              {!! Form::label('filter_experience_check_role', 'ความเชี่ยวชาญเฉพาะด้าน:', ['class' => 'col-md-4 control-label label-filter']) !!}
                              <div class="col-md-8">
                                    {!! Form::textarea('', null , ['class' => 'form-control', 'rows'=>'2' ,'id'=>'filter_experience_check_role']) !!}
                                    {!! $errors->first('', '<p class="help-block">:message</p>') !!}    
                              </div>
                         </div>  
                         <div class="col-sm-6  form-group">
                          {!! HTML::decode(Form::label('filter_experience_check_status', 'สถานะผู้ประเมิน:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                              <div class="col-md-8">
                                    {!! Form::select('', 
                                    App\Models\Bcertify\StatusAuditor::where('kind',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                                     null,
                                   ['class' => 'form-control',
                                    'id' => 'filter_experience_check_status', 
                                   'placeholder'=>'- เลือกสถานะผู้ประเมิน -' ]) !!}
                                  {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                              </div>
                         </div>  
                      </div>
      
      <div class="row">
         <div class="col-md-12">
            <div class="pull-right">
               <button class="btn btn-success" type="button" id="add_check" disabled><i class="fa fa-plus"></i> เพิ่ม</button>
           </div>
         </div>
      </div>
                      
       <div class="row">
         <div class="col-md-12" style="margin-top: 20px ; display: none" id="showErrorAssessment">
             <p class="text-danger text-center">** กรุณากรอกข้อมูลให้ครบถ้วน **</p>
         </div>
      </div>
      
      <div class="row" id="tableCheckCB">
          <div class="col-md-12">
              <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ประสบการณ์การตรวจประเมิน CB</h3>
                <div class="clearfix"></div>
                 <div class="table-responsive">
                    <table class="table color-table primary-table">
                          <thead>
                          <tr class="bg-primary text-center" >
                              <th class="text-center"  width="1%">No.</th>
                              <th class="text-center"  width="15%">วันที่ตรวจประเมิน</th>
                              <th class="text-center"  width="15%">มาตรฐาน</th>
                              <th class="text-center"  width="15%">สาขา</th>
                              <th class="text-center"  width="15%">สถานะผู้ประเมิน</th>
                              <th class="text-center"  width="15%">ขอบข่าย</th>
                              <th class="text-center"  width="10%">บทบาทหน้าที่</th>
                              <th class="text-center"  width="15%">เครื่องมือ</th>
                          </tr>
                          </thead>
                          <tbody id="add_cb">
                              @if (!empty($information) && count($information->auditor_assessment_experience_cb) > 0)
                                  @foreach ($information->auditor_assessment_experience_cb as $key => $item)
                                  <tr>
                                      <td class="text-center">{{ $key +1 }}</td>
                                      <td>
                                          {{  (!empty($item->start_date) && !empty($item->end_date)  ? HP::DateThai($item->start_date).' - '.HP::DateThai($item->end_date) : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->statusAuditor->title) ? $item->statusAuditor->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->ScopeTitleTo) ? $item->ScopeTitleTo : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->role) ? $item->role : null) }}
                                      </td>
                                      <td class="text-center">
                                          <input type="hidden" name="experience_cb[start_date][]"  class="start_date" value="{{  (!empty($item->start_date) ? HP::revertDate(date("Y-m-d",strtotime($item->start_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_cb[end_date][]"  class="end_date" value="{{  (!empty($item->end_date) ? HP::revertDate(date("Y-m-d",strtotime($item->end_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_cb[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                          <input type="hidden" name="experience_cb[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                          <input type="hidden" name="experience_cb[experience_check_status][]"  class="experience_check_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                          <input type="hidden" name="experience_cb[experience_check_scope][]"  class="experience_check_scope" value="{{ (!empty($item->scope_name) ? $item->scope_name : null)  }}">
                                          <input type="hidden" name="experience_cb[experience_check_role][]"  class="experience_check_role" value="{{ (!empty($item->role) ? $item->role : null)  }}">
                                          <button class="btn clickEditExperienceCb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExperienceCb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                      </td>
                                  </tr>
                                  @endforeach     
                             @endif 
                          </tbody>
                   </table>
             </div>
         </div>
      </div>
      
      
      
      <div class="row" id="tableCheckIB">
          <div class="col-md-12">
              <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ประสบการณ์การตรวจประเมิน IB</h3>
                <div class="clearfix"></div>
                 <div class="table-responsive">
                    <table class="table color-table primary-table">
                          <thead>
                          <tr class="bg-primary text-center" >
                              <th class="text-center"  width="1%">No.</th>
                              <th class="text-center"  width="15%">วันที่ตรวจประเมิน</th>
                              <th class="text-center"  width="15%">มาตรฐาน</th>
                              <th class="text-center"  width="15%">สาขา</th>
                              <th class="text-center"  width="15%">สถานะผู้ประเมิน</th>
                              <th class="text-center"  width="10%">ประเภทหน่วยตรวจ</th>
                              <th class="text-center"  width="10%">หมวดหมู่การตรวจ</th>
                              <th class="text-center"  width="10%">บทบาทหน้าที่</th>
                              <th class="text-center"  width="15%">เครื่องมือ</th>
                          </tr>
                          </thead>
                          <tbody id="add_ib">
                              @if (!empty($information) && count($information->auditor_assessment_experience_ib) > 0)
                                  @foreach ($information->auditor_assessment_experience_ib as $key => $item)
                                  <tr>
                                      <td class="text-center">{{ $key +1 }}</td>
                                      <td>
                                          {{  (!empty($item->start_date) && !empty($item->end_date)  ? HP::DateThai($item->start_date).' - '.HP::DateThai($item->end_date) : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->statusAuditor->title) ? $item->statusAuditor->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->type->title) ? $item->type->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->category->title) ? $item->category->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->role) ? $item->role : null) }}
                                      </td>
                                      <td class="text-center">
                                          <input type="hidden" name="experience_ib[start_date][]"  class="start_date" value="{{  (!empty($item->start_date) ? HP::revertDate(date("Y-m-d",strtotime($item->start_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_ib[end_date][]"  class="end_date" value="{{  (!empty($item->end_date) ? HP::revertDate(date("Y-m-d",strtotime($item->end_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_ib[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                          <input type="hidden" name="experience_ib[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                          <input type="hidden" name="experience_ib[experience_check_status][]"  class="experience_check_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                          <input type="hidden" name="experience_ib[type_of_examination][]" class="type_of_examination"  value="{{ (!empty($item->type_of_examination) ? $item->type_of_examination : null)  }}">
                                          <input type="hidden" name="experience_ib[examination_category][]" class="examination_category"  value="{{ (!empty($item->examination_category) ? $item->examination_category : null)  }}">
                                          <input type="hidden" name="experience_ib[experience_check_role][]"  class="experience_check_role" value="{{ (!empty($item->role) ? $item->role : null)  }}">
                                          <button class="btn clickEditExperienceIb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExperienceIb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                      </td>
                                  </tr>
                                  @endforeach     
                             @endif 
                          </tbody>
                   </table>
             </div>
         </div>
      </div>
      
      
      
      <div class="row" id="tableCheckCalibration">
          <div class="col-md-12">
              <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ประสบการณ์การตรวจประเมิน LAB สอบเทียบ</h3>
                <div class="clearfix"></div>
                 <div class="table-responsive">
                    <table class="table color-table primary-table">
                          <thead>
                          <tr class="bg-primary text-center" >
                              <th class="text-center"  width="1%">No.</th>
                              <th class="text-center"  width="15%">วันที่ตรวจประเมิน</th>
                              <th class="text-center"  width="15%">มาตรฐาน</th>
                              <th class="text-center"  width="15%">สาขา</th>
                              <th class="text-center"  width="15%">สถานะผู้ประเมิน</th>
                              <th class="text-center"  width="15%">รายการสอบเทียบ</th>
                              <th class="text-center"  width="10%">บทบาทหน้าที่</th>
                              <th class="text-center"  width="15%">เครื่องมือ</th>
                          </tr>
                          </thead>
                          <tbody id="add_calibration">
                              @if (!empty($information) && count($information->auditor_assessment_experience_lab_calibration) > 0)
                                  @foreach ($information->auditor_assessment_experience_lab_calibration as $key => $item)
                                  <tr>
                                      <td class="text-center">{{ $key +1 }}</td>
                                      <td>
                                          {{  (!empty($item->start_date) && !empty($item->end_date)  ? HP::DateThai($item->start_date).' - '.HP::DateThai($item->end_date) : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->statusAuditor->title) ? $item->statusAuditor->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->calibration->title) ? $item->calibration->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->role) ? $item->role : null) }}
                                      </td>
                                      <td class="text-center">
                                          <input type="hidden" name="experience_calibration[start_date][]"  class="start_date" value="{{  (!empty($item->start_date) ? HP::revertDate(date("Y-m-d",strtotime($item->start_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_calibration[end_date][]"  class="end_date" value="{{  (!empty($item->end_date) ? HP::revertDate(date("Y-m-d",strtotime($item->end_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_calibration[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                          <input type="hidden" name="experience_calibration[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                          <input type="hidden" name="experience_calibration[experience_check_status][]"  class="experience_check_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                          <input type="hidden" name="experience_calibration[calibration_list][]" class="calibration_list"  value="{{ (!empty($item->calibration_list) ? $item->calibration_list : null)  }}">
                                          <input type="hidden" name="experience_calibration[experience_check_role][]"  class="experience_check_role" value="{{ (!empty($item->role) ? $item->role : null)  }}">
                                          <button class="btn clickEditExperienceCalibration" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExperiencecalibration" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                      </td>
                                  </tr>
                                  @endforeach     
                             @endif 
                          </tbody>
                   </table>
             </div>
         </div>
      </div>
      
      
      <div class="row" id="tableCheckTest">
          <div class="col-md-12">
              <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ประสบการณ์การตรวจประเมิน  LAB ทดสอบ </h3>
                <div class="clearfix"></div>
                 <div class="table-responsive">
                    <table class="table color-table primary-table">
                          <thead>
                          <tr class="bg-primary text-center" >
                              <th class="text-center"  width="1%">No.</th>
                              <th class="text-center"  width="15%">วันที่ตรวจประเมิน</th>
                              <th class="text-center"  width="15%">มาตรฐาน</th>
                              <th class="text-center"  width="15%">สาขา</th>
                              <th class="text-center"  width="15%">สถานะผู้ประเมิน</th>
                              <th class="text-center"  width="10%">ผลิตภัณฑ์</th>
                              <th class="text-center"  width="10%">รายการทดสอบ</th>
                              <th class="text-center"  width="10%">บทบาทหน้าที่</th>
                              <th class="text-center"  width="15%">เครื่องมือ</th>
                          </tr>
                          </thead>
                          <tbody id="add_test">
                              @if (!empty($information) && count($information->auditor_assessment_experience_lab_test) > 0)
                                  @foreach ($information->auditor_assessment_experience_lab_test as $key => $item)
                                  <tr>
                                      <td class="text-center">{{ $key +1 }}</td>
                                      <td>
                                          {{  (!empty($item->start_date) && !empty($item->end_date)  ? HP::DateThai($item->start_date).' - '.HP::DateThai($item->end_date) : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->statusAuditor->title) ? $item->statusAuditor->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->product_show->title) ? $item->product_show->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->test->title) ? $item->test->title : null) }}
                                      </td>
                                      <td >
                                          {{  (!empty($item->role) ? $item->role : null) }}
                                      </td>
                                      <td class="text-center">
                                          <input type="hidden" name="experience_test[start_date][]"  class="start_date" value="{{  (!empty($item->start_date) ? HP::revertDate(date("Y-m-d",strtotime($item->start_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_test[end_date][]"  class="end_date" value="{{  (!empty($item->end_date) ? HP::revertDate(date("Y-m-d",strtotime($item->end_date)),true) : null)   }}">
                                          <input type="hidden" name="experience_test[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                          <input type="hidden" name="experience_test[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                          <input type="hidden" name="experience_test[experience_check_status][]"  class="experience_check_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                          <input type="hidden" name="experience_test[product][]" class="product"  value="{{ (!empty($item->product) ? $item->product : null)  }}">
                                          <input type="hidden" name="experience_test[test_list][]" class="test_list"  value="{{ (!empty($item->test_list) ? $item->test_list : null)  }}">
                                          <input type="hidden" name="experience_test[experience_check_role][]"  class="experience_check_role" value="{{ (!empty($item->role) ? $item->role : null)  }}">
                                          <button class="btn clickEditExperienceTest" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExperienceTest" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                      </td>
                                  </tr>
                                  @endforeach     
                             @endif 
                          </tbody>
                   </table>
             </div>
         </div>
      </div>
      
       
            </div>   
         </div>
      </div>
      
      @push('js')
      <script type="text/javascript">
       $(document).ready(function() {
      
            //ช่วงวันที่
            jQuery('#date-experience').datepicker({
              toggleActive: true,
              language:'th-th',
              format: 'dd/mm/yyyy',
            });
      
                div_experience_show_and_hide('0');
                $('#div_check_branch').fadeOut(); // สาขา
                $('#showErrorAssessment').fadeOut()
                ResetTableExperienceCb();
                ResetTableExperienceIb();
                ResetTableExperienceCalibration();
                ResetTableExperienceTest();
                 
             // ประเภทการตรวจประเมิน  -> มาตรฐาน และ สาขา
             $('#filter_experience_type_of_check').change(function () { 
                  $('#add_check').prop('disabled',true);    
                  const select = $(this).val();
                  const _token = $('input[name="_token"]').val();
                 $('#filter_experience_check_standard').html("<option value='' > - เลือกมาตรฐาน - </option>").select2();
                 $('#filter_experience_check_branch').html("<option value='' > - เลือกสาขา - </option>").select2();
                  div_experience_show_and_hide('0');
                  $('#div_check_branch').fadeOut(); //  สาขา
                  if(checkNone(select)){
                          //  มาตรฐาน 
                        experience_standard(select);
                         //  สาขา
                        experience_find_status(select);
                        //  show and hide  filter
                       div_experience_show_and_hide(select);
                        // ประเภทหน่วยตรวจ และ หมวดหมู่การตรวจ 
                       if(select == 2){
                          experience_check_scope(select); 
                       }
                       $('#add_check').prop('disabled',false);    
                   } 
              })
      
              $('#filter_experience_check_branch').change(function () { 
                 const select = $(this).val();
                  const type = $('#filter_experience_type_of_check').val(); // ประเภทการตรวจประเมิน
                  if(checkNone(select)){
                     if (type == "1"){  // CB ขอบข่าย
                         experience_check_scope(type,select);
                     }else if (type === "3"){  // LAB สอบเทียบ 
                        experience_check_scope(type,select);
                     }else if (type === "4"){  // LAB ทดสอบ 
                        experience_check_scope(type,select);
                     }        
                   }else{
                      $('#filter_experience_check_scope').html("<option value='' > - เลือกขอบข่าย - </option>").select2();
                      $('#filter_experience_check_inspection').html("<option value='' > - เลือกประเภทหน่วยตรวจ - </option>").select2();
                      $('#filter_experience_check_category').html("<option value='' > - เลือกหมวดหมู่การตรวจ - </option>").select2();
                      $('#filter_experience_check_calibration').html("<option value='' > - เลือกรายการสอบเทียบ - </option>").select2();
                      $('#filter_experience_check_product').html("<option value='' > - เลือกผลิตภัณฑ์ - </option>").select2();
                      $('#filter_experience_check_test').html("<option value='' > - เลือกรายการทดสอบ - </option>").select2();
                   } 
                });
      
      
          $('#add_check').on('click', function () {
                var type_of_check =   $('#filter_experience_type_of_check').val();
              if(checkNone(type_of_check)){ 
                  const experience_start_date = $('#filter_experience_start_date').val();  // start วันที่ตรวจประเมิน
                  const experience_end_date = $('#filter_experience_end_date').val();   // end วันที่ตรวจประเมิน
      
                  const experience_standard = $('#filter_experience_check_standard').val();   // มาตรฐาน
                  const experience_standard_text = $('#filter_experience_check_standard :selected').text();  
      
                  const experience_branch = $('#filter_experience_check_branch').val();   // สาขา
                  const experience_branch_text = $('#filter_experience_check_branch :selected').text();  
      
                  const experience_check_status = $('#filter_experience_check_status').val();   // สถานะผู้ประเมิน
                  const experience_check_status_text = $('#filter_experience_check_status :selected').text();  
      
                  const experience_check_role =  checkNone($('#filter_experience_check_role').val()) ?  $('#filter_experience_check_role').val() : '';   // บทบาทหน้าที่
              
                  if(type_of_check == '1'){ // CB
                    if (checkNone(experience_start_date)  &&  checkNone(experience_end_date)  && checkNone(experience_standard)   && checkNone(experience_branch) && checkNone(experience_check_status) ) {
                        
                          const experience_check_scope =  checkNone($('#filter_experience_check_scope').val()) ?  $('#filter_experience_check_scope').val() : '';   // ขอบข่าย
                          const experience_check_scope_text =  checkNone($('#filter_experience_check_scope').val()) ?  $('#filter_experience_check_scope :selected').text() : ''; 
                          $('#add_cb').append('<tr>' +
                                                  '<td class="text-center">1</td>' +
                                                  '<td>'+DateFormateTh(experience_start_date)+' - '+ DateFormateTh(experience_end_date) +'</td>' +
                                                  '<td>'+experience_standard_text+'</td>' +
                                                  '<td>'+experience_branch_text+'</td>' +  
                                                  '<td>'+experience_check_status_text+'</td>' +  
                                                  '<td>'+experience_check_scope_text+'</td>' +  
                                                  '<td>'+experience_check_role+'</td>' +  
                                                  '<td class="text-center">' +
                                                  '<input type="hidden" name="experience_cb[start_date][]"  class="start_date" value="'+experience_start_date+'">' + // start วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_cb[end_date][]"  class="end_date" value="'+experience_end_date+'">' + //  end วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_cb[standard][]" class="standard"  value="'+experience_standard+'">' +   // มาตรฐาน
                                                  '<input type="hidden" name="experience_cb[find_status][]" class="find_status"  value="'+experience_branch+'">' +  // สาขา
                                                  '<input type="hidden" name="experience_cb[experience_check_status][]" class="experience_check_status"  value="'+experience_check_status+'">' +  // สถานะผู้ประเมิน
                                                  '<input type="hidden" name="experience_cb[experience_check_scope][]" class="experience_check_scope"  value="'+experience_check_scope+'">' +  // ขอบข่าย
                                                  '<input type="hidden" name="experience_cb[experience_check_role][]" class="experience_check_role"  value="'+experience_check_role+'">' +  // บทบาทหน้าที่
                                                  '<button class="btn clickEditExperienceCb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                  ' <button class="btn clickDeleteExperienceCb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                  '</td>' +
                                              '</tr>');
                          ResetTableExperienceCb();
                          div_experience_show_and_hide('0');
                          default_value();
                      }
                      else {
                          $('#showErrorAssessment').fadeIn();
                      }
                  }else  if(type_of_check == '2'){ // IB
                      if (checkNone(experience_start_date)  &&  checkNone(experience_end_date)  && checkNone(experience_standard)   && checkNone(experience_branch) && checkNone(experience_check_status) ) {
                          const experience_check_inspection =  checkNone($('#filter_experience_check_inspection').val()) ?  $('#filter_experience_check_inspection').val() : '';   // ประเภทหน่วยตรวจ
                          const experience_check_inspection_text =  checkNone($('#filter_experience_check_inspection').val()) ?  $('#filter_experience_check_inspection :selected').text() : ''; 
                          const experience_check_category =  checkNone($('#filter_experience_check_category').val()) ?  $('#filter_experience_check_category').val() : '';   //  หมวดหมู่การตรวจ
                          const experience_check_category_text =  checkNone($('#filter_experience_check_category').val()) ?  $('#filter_experience_check_category :selected').text() : '';  
                          $('#add_ib').append('<tr>' +
                                                  '<td class="text-center">1</td>' +
                                                  '<td>'+DateFormateTh(experience_start_date)+' - '+ DateFormateTh(experience_end_date) +'</td>' +
                                                  '<td>'+experience_standard_text+'</td>' +
                                                  '<td>'+experience_branch_text+'</td>' +  
                                                  '<td>'+experience_check_status_text+'</td>' +  
                                                  '<td>'+experience_check_inspection_text+'</td>' +  
                                                  '<td>'+experience_check_category_text+'</td>' +  
                                                  '<td>'+experience_check_role+'</td>' +  
                                                  '<td class="text-center">' +
                                                  '<input type="hidden" name="experience_ib[start_date][]"  class="start_date" value="'+experience_start_date+'">' + // start วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_ib[end_date][]"  class="end_date" value="'+experience_end_date+'">' + //  end วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_ib[standard][]" class="standard"  value="'+experience_standard+'">' +   // มาตรฐาน
                                                  '<input type="hidden" name="experience_ib[find_status][]" class="find_status"  value="'+experience_branch+'">' +  // สาขา
                                                  '<input type="hidden" name="experience_ib[experience_check_status][]" class="experience_check_status"  value="'+experience_check_status+'">' +  // สถานะผู้ประเมิน 
                                                  '<input type="hidden" name="experience_ib[type_of_examination][]" class="type_of_examination"  value="'+experience_check_inspection+'">' +  // ประเภทหน่วยตรวจ
                                                  '<input type="hidden" name="experience_ib[examination_category][]" class="examination_category"  value="'+experience_check_category+'">' +  // หมวดหมู่การตรวจ
                                                  '<input type="hidden" name="experience_ib[experience_check_role][]" class="experience_check_role"  value="'+experience_check_role+'">' +  // บทบาทหน้าที่
                                                  '<button class="btn clickEditExperienceIb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                  ' <button class="btn clickDeleteExperienceIb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                  '</td>' +
                                              '</tr>');
                          ResetTableExperienceIb();
                          div_experience_show_and_hide('0');
                          default_value();
                      }
                      else {
                          $('#showErrorAssessment').fadeIn();
                      }
                  }else  if(type_of_check == '3'){ // LAB สอบเทียบ
                      if (checkNone(experience_start_date)  &&  checkNone(experience_end_date)  && checkNone(experience_standard)   && checkNone(experience_branch) && checkNone(experience_check_status) ) {
                          const calibration_list =  checkNone($('#filter_experience_check_calibration').val()) ?  $('#filter_experience_check_calibration').val() : '';   // ประเภทหน่วยตรวจ
                          const calibration_list_text =  checkNone($('#filter_experience_check_calibration').val()) ?  $('#filter_experience_check_calibration :selected').text() : ''; 
       
                          $('#add_calibration').append('<tr>' +
                                                  '<td class="text-center">1</td>' +
                                                  '<td>'+DateFormateTh(experience_start_date)+' - '+ DateFormateTh(experience_end_date) +'</td>' +
                                                  '<td>'+experience_standard_text+'</td>' +
                                                  '<td>'+experience_branch_text+'</td>' +  
                                                  '<td>'+experience_check_status_text+'</td>' +  
                                                  '<td>'+calibration_list_text+'</td>' +  
                                                  '<td>'+experience_check_role+'</td>' +  
                                                  '<td class="text-center">' +
                                                  '<input type="hidden" name="experience_calibration[start_date][]"  class="start_date" value="'+experience_start_date+'">' + // start วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_calibration[end_date][]"  class="end_date" value="'+experience_end_date+'">' + //  end วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_calibration[standard][]" class="standard"  value="'+experience_standard+'">' +   // มาตรฐาน
                                                  '<input type="hidden" name="experience_calibration[find_status][]" class="find_status"  value="'+experience_branch+'">' +  // สาขา
                                                  '<input type="hidden" name="experience_calibration[experience_check_status][]" class="experience_check_status"  value="'+experience_check_status+'">' +  // สถานะผู้ประเมิน 
                                                  '<input type="hidden" name="experience_calibration[calibration_list][]" class="calibration_list"  value="'+calibration_list+'">' +  //  รายการสอบเทียบ
                                                  '<input type="hidden" name="experience_calibration[experience_check_role][]" class="experience_check_role"  value="'+experience_check_role+'">' +  // บทบาทหน้าที่
                                                  '<button class="btn clickEditExperienceCalibration" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                  ' <button class="btn clickDeleteExperiencecalibration" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                  '</td>' +
                                              '</tr>');
                          ResetTableExperienceCalibration();
                          div_experience_show_and_hide('0');
                          default_value();
                      }
                      else {
                          $('#showErrorAssessment').fadeIn();
                      }
                  }else  if(type_of_check == '4'){ // LAB ทดสอบ
                      if (checkNone(experience_start_date)  &&  checkNone(experience_end_date)  && checkNone(experience_standard)   && checkNone(experience_branch) && checkNone(experience_check_status) ) {
                          const  experience_check_product =  checkNone($('#filter_experience_check_product').val()) ?  $('#filter_experience_check_product').val() : '';   // ประเภทหน่วยตรวจ
                          const experience_check_product_text =  checkNone($('#filter_experience_check_product').val()) ?  $('#filter_experience_check_product :selected').text() : ''; 
                          const experience_check_test =  checkNone($('#filter_experience_check_test').val()) ?  $('#filter_experience_check_test').val() : '';   //  หมวดหมู่การตรวจ
                          const experience_check_test_text =  checkNone($('#filter_experience_check_test').val()) ?  $('#filter_experience_check_test :selected').text() : '';  
                          $('#add_test').append('<tr>' +
                                                  '<td class="text-center">1</td>' +
                                                  '<td>'+DateFormateTh(experience_start_date)+' - '+ DateFormateTh(experience_end_date) +'</td>' +
                                                  '<td>'+experience_standard_text+'</td>' +
                                                  '<td>'+experience_branch_text+'</td>' +  
                                                  '<td>'+experience_check_status_text+'</td>' +  
                                                  '<td>'+experience_check_product_text+'</td>' +  
                                                  '<td>'+experience_check_test_text+'</td>' +  
                                                  '<td>'+experience_check_role+'</td>' +  
                                                  '<td class="text-center">' +
                                                  '<input type="hidden" name="experience_test[start_date][]"  class="start_date" value="'+experience_start_date+'">' + // start วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_test[end_date][]"  class="end_date" value="'+experience_end_date+'">' + //  end วันที่ตรวจประเมิน
                                                  '<input type="hidden" name="experience_test[standard][]" class="standard"  value="'+experience_standard+'">' +   // มาตรฐาน
                                                  '<input type="hidden" name="experience_test[find_status][]" class="find_status"  value="'+experience_branch+'">' +  // สาขา
                                                  '<input type="hidden" name="experience_test[experience_check_status][]" class="experience_check_status"  value="'+experience_check_status+'">' +  // สถานะผู้ประเมิน 
                                                  '<input type="hidden" name="experience_test[product][]" class="product"  value="'+experience_check_product+'">' +  // ผลิตภัณฑ์
                                                  '<input type="hidden" name="experience_test[test_list][]" class="test_list"  value="'+experience_check_test+'">' +  // รายการทดสอบ
                                                  '<input type="hidden" name="experience_test[experience_check_role][]" class="experience_check_role"  value="'+experience_check_role+'">' +  // บทบาทหน้าที่
                                                  '<button class="btn clickEditExperienceTest" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                  ' <button class="btn clickDeleteExperienceTest" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                  '</td>' +
                                              '</tr>');
                          ResetTableExperienceTest();
                          div_experience_show_and_hide('0');
                          default_value();
                      }else {
                          $('#showErrorAssessment').fadeIn();
                      }
                  }
                 }else{
                    $('#showErrorAssessment').fadeIn();
                 }
            })
      
      // start cb
              $(document).on('click','.clickEditExperienceCb',function () {
                  $('#showErrorAssessment').fadeOut();
                  var row =   $(this).parent().parent() ;
                  // วันที่ตรวจประเมิน
                  var start_date  =  row.find('.start_date').val();
                  if (checkNone(start_date)) { 
                      $('#filter_experience_start_date').val(start_date);
                  }
                  // วันที่ตรวจประเมิน
                  var end_date  =  row.find('.end_date').val();
                  if (checkNone(end_date)) { 
                      $('#filter_experience_end_date').val(end_date);
                  }
                  //ประเภทการตรวจประเมิน
                  $('#filter_experience_type_of_check').val('1').select2();
                    // มาตรฐาน
                  var standard  =  row.find('.standard').val();
                  if (checkNone(standard)) { 
                      experience_standard('1',standard);
                  }
                  // สาขา
                  var find_status  =  row.find('.find_status').val();
                  if (checkNone(find_status)) { 
                      experience_find_status('1',find_status);
                  }
                  // ขอบข่าย
                  var check_scope  =  row.find('.experience_check_scope').val();
                  if (checkNone(find_status) && checkNone(check_scope)) { 
                      console.log(check_scope);
                      experience_check_scope('1',find_status,check_scope,'');
                  }
                  // บทบาทหน้าที่
                  var check_role  =  row.find('.experience_check_role').val();
                  if (checkNone(check_role)) { 
                      $('#filter_experience_check_role').val(check_role);
                  }
                   // สถานะผู้ประเมิน
                  var check_status  =  row.find('.experience_check_status').val();
                  if (checkNone(check_status)) { 
                      $('#filter_experience_check_status').val(check_status).select2();
                  }
                  $(this).parent().parent().remove();
                  ResetTableExperienceCb();
                  div_experience_show_and_hide('1');
                  $('#add_check').prop('disabled',false);  
              })
              //ลบแถว
                $('body').on('click', '.clickDeleteExperienceCb', function(){
                    $(this).parent().parent().remove();
                    ResetTableExperienceCb();
                });
      // end cb
      // start ib
              $(document).on('click','.clickEditExperienceIb',function () {
                  $('#showErrorAssessment').fadeOut();
                  var row =   $(this).parent().parent() ;
                  // วันที่ตรวจประเมิน
                  var start_date  =  row.find('.start_date').val();
                  if (checkNone(start_date)) { 
                      $('#filter_experience_start_date').val(start_date);
                  }
                  // วันที่ตรวจประเมิน
                  var end_date  =  row.find('.end_date').val();
                  if (checkNone(end_date)) { 
                      $('#filter_experience_end_date').val(end_date);
                  }
                  //ประเภทการตรวจประเมิน
                  $('#filter_experience_type_of_check').val('2').select2();
                    // มาตรฐาน
                  var standard  =  row.find('.standard').val();
                  if (checkNone(standard)) { 
                      experience_standard('2',standard);
                  }
                  // สาขา
                  var find_status  =  row.find('.find_status').val();
                  if (checkNone(find_status)) { 
                      experience_find_status('2',find_status);
                  }
                  // ประเภทหน่วยตรวจ
                  var type_of_examination  =  row.find('.type_of_examination').val();
                  if (checkNone(type_of_examination)) { 
                      // $('#filter_experience_check_inspection').val(type_of_examination).select2();
                      experience_check_scope('2',find_status,type_of_examination);
                  }
                // หมวดหมู่การตรวจ
                  var examination_category  =  row.find('.examination_category').val();
                  if (checkNone(examination_category)) { 
                      // $('#filter_experience_check_category').val(examination_category).select2();
                      experience_check_scope('2',find_status,'',examination_category);
                  }
                  // บทบาทหน้าที่
                  var check_role  =  row.find('.experience_check_role').val();
                  if (checkNone(check_role)) { 
                      $('#filter_experience_check_role').val(check_role);
                  }
                   // สถานะผู้ประเมิน
                  var check_status  =  row.find('.experience_check_status').val();
                  if (checkNone(check_status)) { 
                      $('#filter_experience_check_status').val(check_status).select2();
                  }
                  $(this).parent().parent().remove();
                  ResetTableExperienceCb();
                  div_experience_show_and_hide('2');
                  $('#add_check').prop('disabled',false);  
              })
              //ลบแถว
              $('body').on('click', '.clickDeleteExperienceIb', function(){
                    $(this).parent().parent().remove();
                    ResetTableExperienceIb();
                });
      // end ib
      
      // start   LAB สอบเทียบ
      $(document).on('click','.clickEditExperienceCalibration',function () {
                  $('#showErrorAssessment').fadeOut();
                  var row =   $(this).parent().parent() ;
                  // วันที่ตรวจประเมิน
                  var start_date  =  row.find('.start_date').val();
                  if (checkNone(start_date)) { 
                      $('#filter_experience_start_date').val(start_date);
                  }
                  // วันที่ตรวจประเมิน
                  var end_date  =  row.find('.end_date').val();
                  if (checkNone(end_date)) { 
                      $('#filter_experience_end_date').val(end_date);
                  }
                  //ประเภทการตรวจประเมิน
                  $('#filter_experience_type_of_check').val('3').select2();
                    // มาตรฐาน
                  var standard  =  row.find('.standard').val();
                  if (checkNone(standard)) { 
                      experience_standard('3',standard);
                  }
                  // สาขา
                  var find_status  =  row.find('.find_status').val();
                  if (checkNone(find_status)) { 
                      experience_find_status('3',find_status);
                  }
                  // รายการสอบเทียบ
                  var calibration_list  =  row.find('.calibration_list').val();
                  if (checkNone(calibration_list) && checkNone(calibration_list)) { 
                      experience_check_scope('3',find_status,calibration_list,'');
                  }
                  // บทบาทหน้าที่
                  var check_role  =  row.find('.experience_check_role').val();
                  if (checkNone(check_role)) { 
                      $('#filter_experience_check_role').val(check_role);
                  }
                   // สถานะผู้ประเมิน
                  var check_status  =  row.find('.experience_check_status').val();
                  if (checkNone(check_status)) { 
                      $('#filter_experience_check_status').val(check_status).select2();
                  }
                  $(this).parent().parent().remove();
                  ResetTableExperienceCalibration();
                  div_experience_show_and_hide('3');
                  $('#add_check').prop('disabled',false);  
              })
              //ลบแถว
                $('body').on('click', '.clickDeleteExperiencecalibration', function(){
                    $(this).parent().parent().remove();
                    ResetTableExperienceCalibration();
                });
      
      //  end  LAB สอบเทียบ
      
      
      // start   LAB ทดสอบ
      $(document).on('click','.clickEditExperienceTest',function () {
                  $('#showErrorAssessment').fadeOut();
                  var row =   $(this).parent().parent() ;
                  // วันที่ตรวจประเมิน
                  var start_date  =  row.find('.start_date').val();
                  if (checkNone(start_date)) { 
                      $('#filter_experience_start_date').val(start_date);
                  }
                  // วันที่ตรวจประเมิน
                  var end_date  =  row.find('.end_date').val();
                  if (checkNone(end_date)) { 
                      $('#filter_experience_end_date').val(end_date);
                  }
                  //ประเภทการตรวจประเมิน
                  $('#filter_experience_type_of_check').val('4').select2();
                    // มาตรฐาน
                  var standard  =  row.find('.standard').val();
                  if (checkNone(standard)) { 
                      experience_standard('4',standard);
                  }
                  // สาขา
                  var find_status  =  row.find('.find_status').val();
                  if (checkNone(find_status)) { 
                      experience_find_status('4',find_status);
                  }
                  // ผลิตภัณฑ์
                  var product  =  row.find('.product').val();
                  if (checkNone(product)) { 
                      experience_check_scope('4',find_status,product,'');
                  }
                // ผลิตภัณฑ์
                 var test_list  =  row.find('.test_list').val();
                  if (checkNone(test_list)) { 
                      experience_check_scope('4',find_status,'',test_list);
                  }
                  // บทบาทหน้าที่
                  var check_role  =  row.find('.experience_check_role').val();
                  if (checkNone(check_role)) { 
                      $('#filter_experience_check_role').val(check_role);
                  }
                   // สถานะผู้ประเมิน
                  var check_status  =  row.find('.experience_check_status').val();
                  if (checkNone(check_status)) { 
                      $('#filter_experience_check_status').val(check_status).select2();
                  }
                  $(this).parent().parent().remove();
                  ResetTableExperienceTest();
                  div_experience_show_and_hide('4');
                  $('#add_check').prop('disabled',false);  
              })
              //ลบแถว
                $('body').on('click', '.clickDeleteExperienceTest', function(){
                    $(this).parent().parent().remove();
                    ResetTableExperienceTest();
                });
      //  end  LAB ทดสอบ
      
       });
      
       function experience_standard(select,value = ''){
            $('#filter_experience_check_standard').html("<option value='' > - เลือกมาตรฐาน - </option>").select2();
            const _token = $('input[name="_token"]').val();
             $.ajax({
                          url:"{{route('bcertify.api.check_standard')}}",
                          method:"POST",
                          data:{select:select,_token:_token},
                          success:function (result){
                             //    มาตรฐาน
                             if(result.formulas.length > 0){
                                $.each(result.formulas,function (index,item) {
                                  var selected = (item.id == value)?'selected="selected"':'';
                                   $('#filter_experience_check_standard').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                })    
                                $('#filter_experience_check_standard').select2();              
                             }
      
                          }
              })
        }
      
       function experience_find_status(select,value = ''){
           $('#div_check_branch').fadeIn(); //  สาขา
            $('#filter_experience_check_branch').html("<option value='' > - เลือกสาขา - </option>").select2();
            const _token = $('input[name="_token"]').val();
             $.ajax({
                          url:"{{route('bcertify.api.check_standard')}}",
                          method:"POST",
                          data:{select:select,_token:_token},
                          success:function (result){
                            //  สาขา
                             if(result.datas.length > 0){
                                $.each(result.datas,function (index,item) {
                                  var selected = (item.id == value)?'selected="selected"':'';
                                   $('#filter_experience_check_branch').append('<option value='+item.id+' '+selected+'  >'+item.title+'</option>');
                                })    
                                $('#filter_experience_check_branch').select2();           
                             }
                          }
              })
        }
      
       function experience_check_scope(type,select,value = '',value2 = ''){
                const _token = $('input[name="_token"]').val();
                if(type == 1){  // CB 
                      $('#filter_experience_check_scope').html("<option value='' > - เลือกขอบข่าย - </option>").select2();
                        $.ajax({
                          url:"{{route('bcertify.api.check_scope')}}",
                          method:"GET",
                          data:{id:select,_token:_token},
                          success:function (result) {
                               //    ขอบข่าย
                             if(result.datas.length > 0){
                                $.each(result.datas,function (index,item) {
                                    var selected = (item.id == value)?'selected="selected"':'';
                                   $('#filter_experience_check_scope').append('<option value='+item.id+' '+selected+'  >'+item.title+'</option>');
                                })      
                                $('#filter_experience_check_scope').select2();       
                             }
                          }
                      })
                }else if(type == 2){ // IB
                          if(value == ''){
                              $('#filter_experience_check_inspection').html("<option value='' > - เลือกประเภทหน่วยตรวจ - </option>").select2();
                          }
                          if(value2 == ''){
                              $('#filter_experience_check_category').html("<option value='' > - เลือกหมวดหมู่การตรวจ - </option>").select2();
                          }
                          $.ajax({
                              url:"{{route('bcertify.api.check_inspection')}}",
                              method:"POST",
                              data:{select_branch:select,_token:_token},
                              success:function (result) {
                                  //    ประเภทหน่วยตรวจ
                                  if(result.type_inspection.length > 0){
                                      $.each(result.type_inspection,function (index,item) {
                                          var selected = (item.id == value)?'selected="selected"':'';
                                          $('#filter_experience_check_inspection').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                      })    
                                      $('#filter_experience_check_inspection').select2();              
                                  }
                                  //    หมวดหมู่การตรวจ
                                  if(result.categories_inspection.length > 0){
                                      $.each(result.categories_inspection,function (index,item) {
                                          var selected = (item.id == value2)?'selected="selected"':'';
                                          $('#filter_experience_check_category').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                      })    
                                      $('#filter_experience_check_category').select2();              
                                  }
                              }
                         })
      
                }else if(type == 3){  // LAB สอบเทียบ 
                      $('#filter_experience_check_calibration').html("<option value='' > - เลือกรายการสอบเทียบ - </option>").select2();  
                      $.ajax({
                          url:"{{route('bcertify.api.check_calibration')}}",
                          method:"POST",
                          data:{id:select,_token:_token},
                          success:function (result) {
                              //   รายการสอบเทียบ
                               if(result.datas.length > 0){
                                $.each(result.datas,function (index,item) {
                                   var selected = (item.id == value)?'selected="selected"':'';
                                   $('#filter_experience_check_calibration').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                               })    
                               $('#filter_experience_check_calibration').select2();              
                              }
                          }
                      })
      
                }else if(type == 4){ //  LAB ทดสอบ 
                        if(value == ''){
                             $('#filter_experience_check_product').html("<option value='' > - เลือกผลิตภัณฑ์ - </option>").select2();
                          }
                          if(value2 == ''){
                              $('#filter_experience_check_test').html("<option value='' > - เลือกรายการทดสอบ - </option>").select2();
                          }
                 
                  
                          $.ajax({
                              url:"{{route('bcertify.api.check_product')}}",
                              method:"POST",
                              data:{id:select,_token:_token},
                              success:function (result) {
                                  //    ผลิตภัณฑ์
                                  if(result.products.length > 0){
                                      $.each(result.products,function (index,item) {
                                          var selected = (item.id == value)?'selected="selected"':'';
                                          $('#filter_experience_check_product').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                      })    
                                      $('#filter_experience_check_product').select2();              
                                  }
                                  //  รายการทดสอบ
                                  if(result.test.length > 0){
                                      $.each(result.test,function (index,item) {
                                          var selected = (item.id == value2)?'selected="selected"':'';
                                          $('#filter_experience_check_test').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                      })    
                                      $('#filter_experience_check_test').select2();              
                                  }
       
                              }
                          })
                } 
       }
       
          function div_experience_show_and_hide(type){
                  if(type == 1){  // CB  
                      $('#div_experience_check_scop').fadeIn(); // ขอบข่าย
                  }else if(type == 2){  // IB 
                      $('.inspection').fadeIn(); // ประเภทหน่วยตรวจ และ หมวดหมู่การตรวจ 
                  }else if(type == 3){  // LAB สอบเทียบ 
                      $('#calibration').fadeIn(); // รายการสอบเทียบ
                  }else if(type == 4){  // LAB ทดสอบ 
                      $('.product').fadeIn(); // ผลิตภัณฑ์ และ รายการทดสอบ 
                  }else{
                      $('#div_experience_check_scop').fadeOut(); // ขอบข่าย
                      $('.inspection').fadeOut(); // ประเภทหน่วยตรวจ และ หมวดหมู่การตรวจ
                      $('#calibration').fadeOut(); // รายการสอบเทียบ
                      $('.product').fadeOut(); // ผลิตภัณฑ์ และ รายการทดสอบ 
                  }
      
                  $('#filter_experience_check_scope').html("<option value='' > - เลือกขอบข่าย - </option>").select2();
                  $('#filter_experience_check_inspection').html("<option value='' > - เลือกประเภทหน่วยตรวจ - </option>").select2();
                  $('#filter_experience_check_category').html("<option value='' > - เลือกหมวดหมู่การตรวจ - </option>").select2();
                  $('#filter_experience_check_calibration').html("<option value='' > - เลือกรายการสอบเทียบ - </option>").select2();  
                  $('#filter_experience_check_product').html("<option value='' > - เลือกผลิตภัณฑ์ - </option>").select2();
                  $('#filter_experience_check_test').html("<option value='' > - เลือกรายการทดสอบ - </option>").select2();
          } 
      
          function default_value(){
              $('#filter_experience_start_date').val('');  // start วันที่ตรวจประเมิน
              $('#filter_experience_end_date').val('');   // end วันที่ตรวจประเมิน
              $('#filter_experience_type_of_check').val('').select2();  // ประเภทการตรวจประเมิน
              $('#filter_experience_check_standard').val('').select2();   // มาตรฐาน
              $('#filter_experience_check_branch').val('').select2();   // สาขา
              $('#filter_experience_check_role').val('');   // บทบาทหน้าที่
              $('#filter_experience_check_status').val('').select2();   // สถานะผู้ประเมิน
      
              //  cb
              $('#filter_experience_check_scope').val('').select2();   // ขอบข่าย
              //ib
              $('#filter_experience_check_inspection').val('').select2();   // ประเภทหน่วยตรวจ
              $('#filter_experience_check_category').val('').select2();   // หมวดหมู่การตรวจ
              //  LAB สอบเทียบ 
              $('#filter_experience_check_calibration').val('').select2();   // รายการสอบเทียบ
      
             //  LAB ทดสอบ  
              $('#filter_experience_check_product').val('').select2();   // ผลิตภัณฑ์
              $('#filter_experience_check_test').val('').select2();   // รายการทดสอบ
              
              $('#showErrorAssessment').fadeOut();
              $('#add_check').prop('disabled',true);  
          } 
      
      
           function ResetTableExperienceCb(){
            var rows = $('#add_cb').children(); //แถวทั้งหมด
                rows.each(function(index, el) {
                  $(el).children().first().html(index+1);   //เลขรัน
                });
                if(rows.length > 0){
                     $('#tableCheckCB').fadeIn(); // Table CB  
                }else{
                      $('#tableCheckCB').fadeOut(); // Table CB
                }
           }
           function ResetTableExperienceIb(){
            var rows = $('#add_ib').children(); //แถวทั้งหมด
                rows.each(function(index, el) {
                  $(el).children().first().html(index+1);   //เลขรัน
                });
                if(rows.length > 0){
                     $('#tableCheckIB').fadeIn(); // Table IB
                }else{
                      $('#tableCheckIB').fadeOut(); // Table IB
                }
           }
      
           function ResetTableExperienceCalibration(){
            var rows = $('#add_calibration').children(); //แถวทั้งหมด
                rows.each(function(index, el) {
                  $(el).children().first().html(index+1);   //เลขรัน
                });
                if(rows.length > 0){
                     $('#tableCheckCalibration').fadeIn(); // Table LAB สอบเทียบ 
                }else{
                      $('#tableCheckCalibration').fadeOut(); // Table LAB สอบเทียบ 
                }
           }
           function ResetTableExperienceTest(){
            var rows = $('#add_test').children(); //แถวทั้งหมด
                rows.each(function(index, el) {
                  $(el).children().first().html(index+1);   //เลขรัน
                });
                if(rows.length > 0){
                     $('#tableCheckTest').fadeIn(); // Table LAB ทดสอบ 
                }else{
                      $('#tableCheckTest').fadeOut(); // Table LAB ทดสอบ 
                }
           }
      </script>     
      @endpush
      