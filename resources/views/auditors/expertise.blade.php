<div class="white-box"> 
          <div class="row">
             <div class="col-sm-12">
              <legend><h3 class="box-title">ความเชี่ยวชาญ</h3></legend>
      
                 <div class="row  ">
                     <div class="col-sm-6  form-group">
                          {!! HTML::decode(Form::label('filter_type_of_check', 'ประเภทการตรวจประเมิน:<span class="text-danger">*</span>', ['class' => 'col-md-5 control-label label-filter'])) !!}
                          <div class="col-md-7">
                                    {!! Form::select('', 
                                    ['1'=>'CB','2'=>'IB','3'=>'LAB สอบเทียบ','4'=>'LAB ทดสอบ'], 
                                     null,
                                    ['class' => 'form-control',
                                    'id' => 'filter_type_of_check',
                                    'placeholder'=>'- เลือกประเภทการตรวจประเมิน -' ]) !!}
                                   {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                          </div>
                     </div>  
                     <div class="col-sm-6  form-group">
                      {!! HTML::decode(Form::label('filter_check_standard', 'มาตรฐาน:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                      <div class="col-md-8">
                                {!! Form::select('', 
                                 [], 
                                 null,
                                ['class' => 'form-control',
                                'id' => 'filter_check_standard',
                                'placeholder'=>'- เลือกมาตรฐาน -' ]); !!}
                               {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                       </div>
                   </div> 
                </div>
                <div class="row">
                     <div class="col-sm-6  form-group" id="check_branch">
                          {!! HTML::decode(Form::label('filter_check_branch', 'สาขา:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                          <div class="col-md-8">
                                 {!! Form::select('', 
                                     [], 
                                       null,
                                       ['class' => 'form-control',
                                      'id' => 'filter_check_branch',
                                      'placeholder'=>'- เลือกสาขา -' ]); !!}
                                   {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                          </div>
                     </div>  
                    <!--start cb  -->
                          <div class="col-sm-6  form-group" id="div_check_scop">
                               {!! Form::label('filter_check_scope', 'ขอบข่าย:', ['class' => 'col-md-4 control-label label-filter']) !!}
                               <div class="col-md-8">
                                         {!! Form::select('', 
                                          [], 
                                          null,
                                         ['class' => 'form-control',
                                         'id' => 'filter_check_scope',
                                         'placeholder'=>'- เลือกขอบข่าย -' ]); !!}
                                        {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                               </div>
                          </div> 
                      <!--end cb  -->
                     <!--start ib  -->
                          <div class="col-sm-6  form-group expertise_inspection">
                                  {!! Form::label('filter_check_category', 'หมวดหมู่การตรวจ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                                  <div class="col-md-8">
                                        {!! Form::select('', 
                                        [], 
                                        null,
                                        ['class' => 'form-control',
                                        'id' => 'filter_check_category',
                                        'placeholder'=>'- เลือกหมวดหมู่การตรวจ -' ]); !!}
                                        {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                                  </div>
                            </div>  
                          <div class="col-sm-6  form-group expertise_inspection">
                                  {!! Form::label('filter_check_expertise_inspection', 'ประเภทหน่วยตรวจ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                                  <div class="col-md-8">
                                          {!! Form::select('', 
                                          [], 
                                          null,
                                          ['class' => 'form-control',
                                          'id' => 'filter_check_expertise_inspection',
                                          'placeholder'=>'- เลือกประเภทหน่วยตรวจ -' ]); !!}
                                          {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                                  </div>
                          </div>  
                      <!-- end ib  -->
                      <!--start LAB สอบเทียบ  -->
                          <div class="col-sm-6  form-group " id="expertise_calibration">
                              {!! Form::label('filter_check_expertise_calibration', 'รายการสอบเทียบ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                              <div class="col-md-8">
                                      {!! Form::select('', 
                                      [], 
                                      null,
                                      ['class' => 'form-control',
                                      'id' => 'filter_check_expertise_calibration',
                                      'placeholder'=>'- เลือกรายการสอบเทียบ -' ]); !!}
                                      {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                              </div>
                          </div>  
                      <!--end LAB สอบเทียบ  -->
                         <!--start LAB ทดสอบ  -->
                         <div class="col-sm-6  form-group expertise_product">
                            {!! Form::label('filter_check_test', 'รายการทดสอบ:', ['class' => 'col-md-4 control-label label-filter']) !!}
                            <div class="col-md-8">
                                    {!! Form::select('', 
                                    [], 
                                    null,
                                    ['class' => 'form-control',
                                    'id' => 'filter_check_test',
                                    'placeholder'=>'- เลือกรายการทดสอบ -' ]); !!}
                                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                            </div>
                        </div>
                         <div class="col-sm-6  form-group expertise_product">
                            {!! Form::label('filter_check_expertise_product', 'ผลิตภัณฑ์:', ['class' => 'col-md-4 control-label label-filter']) !!}
                            <div class="col-md-8">
                                    {!! Form::select('', 
                                    [], 
                                    null,
                                    ['class' => 'form-control',
                                    'id' => 'filter_check_expertise_product',
                                    'placeholder'=>'- เลือกผลิตภัณฑ์ -' ]); !!}
                                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!} 
                            </div>
                        </div>  
                      <!-- end LAB ทดสอบ  -->  
     
                 </div>
                 <div class="row">
                          <div class="col-sm-6  form-group">
                              {!! Form::label('filter_check_role', 'ความเชี่ยวชาญเฉพาะด้าน:', ['class' => 'col-md-5 control-label label-filter']) !!}
                              <div class="col-md-7">
                                    {!! Form::textarea('', null , ['class' => 'form-control', 'rows'=>'2' ,'id'=>'filter_specialized_expertise']) !!}
                                    {!! $errors->first('', '<p class="help-block">:message</p>') !!}    
                              </div>
                         </div>  
                         <div class="col-sm-6  form-group">
                          {!! HTML::decode(Form::label('filter_check_status', 'สถานะผู้ประเมิน:<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label label-filter'])) !!}
                              <div class="col-md-8">
                                    {!! Form::select('', 
                                    App\Models\Bcertify\StatusAuditor::where('kind',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
                                     null,
                                   ['class' => 'form-control',
                                    'id' => 'filter_check_status', 
                                   'placeholder'=>'- เลือกสถานะผู้ประเมิน -' ]) !!}
                                  {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                              </div>
                         </div>  
                  </div>
                  <div class="row">
                      <div class="col-sm-6  form-group">  </div>  
                     <div class="col-sm-6  form-group" id="total_status">
                    
                     </div>  
                 </div>
     
      <div class="row">
         <div class="col-md-12">
            <div class="pull-right">
               <button class="btn btn-success" type="button" id="add_expertise" disabled><i class="fa fa-plus"></i> เพิ่ม</button>
           </div>
         </div>
      </div>
                      
       <div class="row">
         <div class="col-md-12" style="margin-top: 20px ; display: none" id="showErrorExpertise">
             <p class="text-danger text-center">** กรุณากรอกข้อมูลให้ครบถ้วน **</p>
         </div>
      </div>
      
      <div class="row" id="viewCB">
        <div class="col-md-12">
            <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ข้อมูลความเชี่ยวชาญ (CB)</h3>
              <div class="clearfix"></div>
               <div class="table-responsive">
                  <table class="table color-table primary-table">
                        <thead>
                        <tr class="bg-primary text-center" >
                            <th class="text-center"  width="1%">No.</th>
                            <th class="text-center"  width="15%">มาตรฐาน</th>
                            <th class="text-center"  width="15%">สาขา</th>
                            <th class="text-center"  width="15%">ขอบข่าย</th>
                            <th class="text-center"  width="10%">สถานผู้ตรวจประเมิน</th>
                            <th class="text-center"  width="15%">ความเชี่ยวชาญเฉพาะด้าน</th>
                            <th class="text-center"  width="15%">เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody id="add_expertise_CB">
                            @if (!empty($information) && count($information->auditor_expertise_cb) > 0)
                                @foreach ($information->auditor_expertise_cb as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key +1 }}</td>
                                    <td >
                                        {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->ScopeTitleTo) ? $item->ScopeTitleTo : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->AuditorStatusTitle) ? $item->AuditorStatusTitle : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->specialized_expertise) ? $item->specialized_expertise : null) }}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="expertise_cb[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                        <input type="hidden" name="expertise_cb[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                        <input type="hidden" name="expertise_cb[number_status][]"  class="number_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                        <input type="hidden" name="expertise_cb[check_scope][]"  class="check_scope" value="{{ (!empty($item->scope_name) ? $item->scope_name : null)  }}">
                                        <input type="hidden" name="expertise_cb[specialized_expertise][]"  class="specialized_expertise" value="{{ (!empty($item->specialized_expertise) ? $item->specialized_expertise : null)  }}">
                                        <button class="btn clickEditExpertiseCb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExpertiseCb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                @endforeach     
                           @endif 
                        </tbody>
                 </table>
           </div>
       </div>
    </div>
    
    
    <div class="row" id="viewIB">
        <div class="col-md-12">
            <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ข้อมูลความเชี่ยวชาญ (IB)</h3>
              <div class="clearfix"></div>
               <div class="table-responsive">
                  <table class="table color-table primary-table">
                        <thead>
                        <tr class="bg-primary text-center" >
                            <th class="text-center"  width="1%">No.</th>
                            <th class="text-center"  width="15%">มาตรฐาน</th>
                            <th class="text-center"  width="15%">สาขา</th>
                            <th class="text-center"  width="10%">ประเภทหน่วยตรวจ</th>
                            <th class="text-center"  width="10%">หมวดหมู่การตรวจ</th>
                            <th class="text-center"  width="10%">สถานผู้ตรวจประเมิน</th>
                            <th class="text-center"  width="15%">ความเชี่ยวชาญเฉพาะด้าน</th>
                            <th class="text-center"  width="15%">เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody id="add_expertise_IB">
                            @if (!empty($information) && count($information->auditor_expertise_ib) > 0)
                                @foreach ($information->auditor_expertise_ib as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key +1 }}</td>
                                    <td >
                                        {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->type->title) ? $item->type->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->category->title) ? $item->category->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->AuditorStatusTitle) ? $item->AuditorStatusTitle : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->specialized_expertise) ? $item->specialized_expertise : null) }}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="expertise_ib[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                        <input type="hidden" name="expertise_ib[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                        <input type="hidden" name="expertise_ib[number_status][]"  class="number_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                        <input type="hidden" name="expertise_ib[specialized_expertise][]"  class="specialized_expertise" value="{{ (!empty($item->specialized_expertise) ? $item->specialized_expertise : null)  }}">
                                        <input type="hidden" name="expertise_ib[type_of_examination][]"  class="type_of_examination" value="{{ (!empty($item->type_of_examination) ? $item->type_of_examination : null)  }}">
                                        <input type="hidden" name="expertise_ib[examination_category][]"  class="examination_category" value="{{ (!empty($item->examination_category) ? $item->examination_category : null)  }}">
                                        <button class="btn clickEditExpertiseIb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExpertiseIb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                @endforeach     
                           @endif 
                        </tbody>
                 </table>
           </div>
       </div>
    </div>
    
    
    
    <div class="row" id="viewCalibration">
        <div class="col-md-12">
            <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ข้อมูลความเชี่ยวชาญ (LAB สอบเทียบ)</h3>
              <div class="clearfix"></div>
               <div class="table-responsive">
                  <table class="table color-table primary-table">
                        <thead>
                        <tr class="bg-primary text-center" >
                            <th class="text-center"  width="1%">No.</th>
                            <th class="text-center"  width="15%">มาตรฐาน</th>
                            <th class="text-center"  width="15%">สาขา</th>
                            <th class="text-center"  width="15%">รายการสอบเทียบ</th>
                            <th class="text-center"  width="10%">สถานผู้ตรวจประเมิน</th>
                            <th class="text-center"  width="15%">ความเชี่ยวชาญเฉพาะด้าน</th>
                            <th class="text-center"  width="15%">เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody id="add_expertise_Calibration">
                            @if (!empty($information) && count($information->auditor_expertise_calibration) > 0)
                                @foreach ($information->auditor_expertise_calibration as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key +1 }}</td>
                                    <td >
                                        {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->calibration->title) ? $item->calibration->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->AuditorStatusTitle) ? $item->AuditorStatusTitle : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->specialized_expertise) ? $item->specialized_expertise : null) }}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="expertise_calibration[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                        <input type="hidden" name="expertise_calibration[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                        <input type="hidden" name="expertise_calibration[number_status][]"  class="number_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                        <input type="hidden" name="expertise_calibration[specialized_expertise][]"  class="specialized_expertise" value="{{ (!empty($item->specialized_expertise) ? $item->specialized_expertise : null)  }}">
                                        <input type="hidden" name="expertise_calibration[calibration_list][]"  class="calibration_list" value="{{ (!empty($item->calibration_list) ? $item->calibration_list : null)  }}">
                                        <button class="btn clickEditExpertiseCalibration" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExpertiseCalibration" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                @endforeach     
                           @endif 
                        </tbody>
                 </table>
           </div>
       </div>
    </div>
    
    <div class="row" id="viewTest">
        <div class="col-md-12">
            <h3 class="col-md-12" style="margin-top: 15px; padding: 0px">ข้อมูลความเชี่ยวชาญ (LAB ทดสอบ)</h3>
              <div class="clearfix"></div>
               <div class="table-responsive">
                  <table class="table color-table primary-table">
                        <thead>
                        <tr class="bg-primary text-center" >
                            <th class="text-center"  width="1%">No.</th>
                            <th class="text-center"  width="15%">มาตรฐาน</th>
                            <th class="text-center"  width="15%">สาขา</th>
                            <th class="text-center"  width="10%">ผลิตภัณฑ์</th>
                            <th class="text-center"  width="10%">รายการทดสอบ</th>
                            <th class="text-center"  width="10%">สถานผู้ตรวจประเมิน</th>
                            <th class="text-center"  width="15%">ความเชี่ยวชาญเฉพาะด้าน</th>
                            <th class="text-center"  width="15%">เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody id="add_expertise_Test">
                            @if (!empty($information) && count($information->auditor_expertise_test) > 0)
                                @foreach ($information->auditor_expertise_test as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key +1 }}</td>
                                    <td >
                                        {{  (!empty($item->formula->title) ? $item->formula->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->BranchTitleTo) ? $item->BranchTitleTo : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->product_show->title) ? $item->product_show->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->test->title) ? $item->test->title : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->AuditorStatusTitle) ? $item->AuditorStatusTitle : null) }}
                                    </td>
                                    <td >
                                        {{  (!empty($item->specialized_expertise) ? $item->specialized_expertise : null) }}
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="expertise_test[standard][]"  class="standard" value="{{ (!empty($item->standard) ? $item->standard : null)  }}">
                                        <input type="hidden" name="expertise_test[find_status][]"  class="find_status" value="{{ (!empty($item->branch_id) ? $item->branch_id : null)  }}">
                                        <input type="hidden" name="expertise_test[number_status][]"  class="number_status" value="{{ (!empty($item->auditor_status) ? $item->auditor_status : null)  }}">
                                        <input type="hidden" name="expertise_test[specialized_expertise][]"  class="specialized_expertise" value="{{ (!empty($item->specialized_expertise) ? $item->specialized_expertise : null)  }}">
                                        <input type="hidden" name="expertise_test[product][]"  class="product" value="{{ (!empty($item->product) ? $item->product : null)  }}">
                                        <input type="hidden" name="expertise_test[test_list][]"  class="test_list" value="{{ (!empty($item->test_list) ? $item->test_list : null)  }}">
                                        <button class="btn clickEditExpertiseTest" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExpertiseTest" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
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
    
             ResetTableExpertiseCb();
             ResetTableExpertiseIb();
             ResetTableExpertiseCalibration();
             ResetTableExpertiseTest();
            var status_auditor = $.parseJSON('{!! json_encode(  App\Models\Bcertify\StatusAuditor::pluck('title','id') ) !!}');
            // var keep_status = [];
            $('#filter_check_status').on('change',function () {
                    var keep_status = [];
                  $('.clickDelete').each(function (index,value) {
                       keep_status.push( $(value).attr('id') );
                  });
    
                $('#total_status').empty();
                if (!keep_status.includes($(this).val()) && $(this).val() !== "0"){
                    keep_status.push($(this).val());
                }
                $.each(keep_status,function (index,value) {
                    $('#total_status').append('<button  type="button" class="col-md-6 bg-primary text-white text-nowrap text-center clickDelete" id='+value+' style="border: 1px solid blue; padding: 5px 15px ; border-radius: 20px; font-size: 11px">'+status_auditor[value]+'</button>');
                })
            })
            $(document).on('click', '.clickDelete', function () {
                  var keep_status = [];
                   $('.clickDelete').each(function (index,value) {
                       keep_status.push( $(value).attr('id') );
                  });
                    var number_index = keep_status.indexOf($(this).attr('id'));
                    keep_status.splice(number_index,1);
                    $('#total_status').empty();
                    $.each(keep_status,function (index,value) {
                        $('#total_status').append('<button  type="button" class="col-md-6 bg-primary text-white text-nowrap text-center clickDelete" id='+value+' style="border: 1px solid blue; padding: 5px 15px ; border-radius: 20px; font-size: 11px">'+status_auditor[value]+'</button>');
                    });
    
                $('#filter_check_status').val('').select2();
            })
           
    
              div_expertise_show_and_hide('0');
              $('#check_branch').fadeOut(); // สาขา
    
               
           // ประเภทการตรวจประเมิน  -> มาตรฐาน และ สาขา
           $('#filter_type_of_check').change(function () { 
                $('#add_expertise').prop('disabled',true);    
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
               $('#filter_check_standard').html("<option value='' > - เลือกมาตรฐาน - </option>").select2();
               $('#filter_check_branch').html("<option value='' > - เลือกสาขา - </option>").select2();
                div_expertise_show_and_hide('0');
                $('#check_branch').fadeOut(); //  สาขา
                if(checkNone(select)){
                        //  มาตรฐาน 
                       expertise_standard(select);
                       //  สาขา
                       expertise_find_status(select);
                      //  show and hide  filter
                       div_expertise_show_and_hide(select);
                      // ประเภทหน่วยตรวจ และ หมวดหมู่การตรวจ 
                     if(select == 2){
                        experience_check(select); 
                     }
                     $('#add_expertise').prop('disabled',false);    
                 } 
            })
    
            $('#filter_check_branch').change(function () { 
               const select = $(this).val();
                const type = $('#filter_type_of_check').val(); // ประเภทการตรวจประเมิน
                if(checkNone(select)){
                   if (type == "1"){  // CB ขอบข่าย
                      experience_check(type,select);
                   }else if (type === "3"){  // LAB สอบเทียบ 
                      experience_check(type,select);
                   }else if (type === "4"){  // LAB ทดสอบ 
                      experience_check(type,select);
                   }        
                 }else{
                    $('#filter_check_scope').html("<option value='' > - เลือกขอบข่าย - </option>").select2();
                    $('#filter_check_expertise_inspection').html("<option value='' > - เลือกประเภทหน่วยตรวจ - </option>").select2();
                    $('#filter_check_category').html("<option value='' > - เลือกหมวดหมู่การตรวจ - </option>").select2();
                    $('#filter_check_expertise_calibration').html("<option value='' > - เลือกรายการสอบเทียบ - </option>").select2();
                    $('#filter_check_expertise_product').html("<option value='' > - เลือกผลิตภัณฑ์ - </option>").select2();
                    $('#filter_check_test').html("<option value='' > - เลือกรายการทดสอบ - </option>").select2();
                 } 
              });
        
    
    
         $(document).on('click', '#add_expertise', function () {
    
              var status_auditor = $.parseJSON('{!! json_encode(  App\Models\Bcertify\StatusAuditor::pluck('title','id') ) !!}');
              var type_of_check =   $('#filter_type_of_check').val();
                    var keep_status = [];
                    var  data_number_status = [];
                  $('.clickDelete').each(function (index,value) {
                       keep_status.push( $(value).attr('id') );
                       data_number_status.push(status_auditor[$(value).attr('id')]);  
                  });
    
            if(checkNone(type_of_check)  && keep_status.length > 0){ 
             
    
                const standard = $('#filter_check_standard').val();   // มาตรฐาน
                const standard_text = $('#filter_check_standard :selected').text();  
    
                const branch = $('#filter_check_branch').val();   // สาขา
                const branch_text = $('#filter_check_branch :selected').text();  
    
                const show_status = keep_status.join(",");
     
                const specialized_expertise =  checkNone($('#filter_specialized_expertise').val()) ?  $('#filter_specialized_expertise').val() : '';   // ความเชี่ยวชาญเฉพาะด้าน
            
                if(type_of_check == '1'){ // CB
                  if ( checkNone(standard)   && checkNone(branch)  ) {
                        const check_scope =  checkNone($('#filter_check_scope').val()) ?  $('#filter_check_scope').val() : '';   // ขอบข่าย
                        const check_scope_text =  checkNone($('#filter_check_scope').val()) ?  $('#filter_check_scope :selected').text() : ''; 
                       $('#add_expertise_CB').append('<tr>' +
                                                '<td class="text-center">1</td>' +
                                                '<td>'+standard_text+'</td>' +
                                                '<td>'+branch_text+'</td>' +  
                                                '<td>'+check_scope_text+'</td>' +   
                                                '<td>'+data_number_status.join(",")+'</td>' +  
                                                '<td>'+specialized_expertise+'</td>' +  
                                                '<td class="text-center">' +
                                                '<input type="hidden" name="expertise_cb[standard][]" class="standard"  value="'+standard+'">' +   // มาตรฐาน
                                                '<input type="hidden" name="expertise_cb[find_status][]" class="find_status"  value="'+branch+'">' +  // สาขา
                                                '<input type="hidden" name="expertise_cb[number_status][]" class="number_status"  value="'+show_status+'">' +  // สถานะผู้ประเมิน
                                                '<input type="hidden" name="expertise_cb[check_scope][]" class="check_scope"  value="'+check_scope+'">' +  // ขอบข่าย
                                                '<input type="hidden" name="expertise_cb[specialized_expertise][]" class="specialized_expertise"  value="'+specialized_expertise+'">' +  // ความเชี่ยวชาญเฉพาะด้าน
                                                '<button class="btn clickEditExpertiseCb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                ' <button class="btn clickDeleteExpertiseCb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                '</td>' +
                                            '</tr>');
                        ResetTableExpertiseCb();
                        div_expertise_show_and_hide('0');
                        default_expertise_value();
                    }
                    else {
                        $('#showErrorExpertise').fadeIn();
                    }
                }else  if(type_of_check == '2'){ // IB
                     if ( checkNone(standard)   && checkNone(branch)  ) {
                        const type_of_examination =  checkNone($('#filter_check_expertise_inspection').val()) ?  $('#filter_check_expertise_inspection').val() : '';   // ประเภทหน่วยตรวจ
                        const type_of_examination_text =  checkNone($('#filter_check_expertise_inspection').val()) ?  $('#filter_check_expertise_inspection :selected').text() : ''; 
                        const examination_category =  checkNone($('#filter_check_category').val()) ?  $('#filter_check_category').val() : '';   //  หมวดหมู่การตรวจ
                        const examination_category_text =  checkNone($('#filter_check_category').val()) ?  $('#filter_check_category :selected').text() : '';  
                        $('#add_expertise_IB').append('<tr>' +
                                                '<td class="text-center">1</td>' +
                                                '<td>'+standard_text+'</td>' +
                                                '<td>'+branch_text+'</td>' +  
                                                '<td>'+type_of_examination_text+'</td>' +   
                                                '<td>'+examination_category_text+'</td>' +  
                                                '<td>'+data_number_status.join(",")+'</td>' +  
                                                '<td>'+specialized_expertise+'</td>' +  
                                                '<td class="text-center">' +
                                                '<input type="hidden" name="expertise_ib[standard][]" class="standard"  value="'+standard+'">' +   // มาตรฐาน
                                                '<input type="hidden" name="expertise_ib[find_status][]" class="find_status"  value="'+branch+'">' +  // สาขา
                                                '<input type="hidden" name="expertise_ib[number_status][]" class="number_status"  value="'+show_status+'">' +  // สถานะผู้ประเมิน
                                                '<input type="hidden" name="expertise_ib[specialized_expertise][]" class="specialized_expertise"  value="'+specialized_expertise+'">' +  // ความเชี่ยวชาญเฉพาะด้าน
                                                '<input type="hidden" name="expertise_ib[type_of_examination][]" class="type_of_examination"  value="'+type_of_examination+'">' +  // ประเภทหน่วยตรวจ
                                                '<input type="hidden" name="expertise_ib[examination_category][]" class="examination_category"  value="'+examination_category+'">' +  // หมวดหมู่การตรวจ
                                                '<button class="btn clickEditExpertiseIb" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                ' <button class="btn clickDeleteExpertiseIb" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                '</td>' +
                                            '</tr>');
                        ResetTableExpertiseIb();
                        div_expertise_show_and_hide('0');
                        default_expertise_value();
     
                    }
                    else {
                        $('#showErrorExpertise').fadeIn();
                    }
                }else  if(type_of_check == '3'){ // LAB สอบเทียบ
    
                    if ( checkNone(standard)   && checkNone(branch)  ) {
                        const  check_expertise_calibration =  checkNone($('#filter_check_expertise_calibration').val()) ?  $('#filter_check_expertise_calibration').val() : '';   // ประเภทหน่วยตรวจ
                        const check_expertise_calibration_text =  checkNone($('#filter_check_expertise_calibration').val()) ?  $('#filter_check_expertise_calibration :selected').text() : ''; 
                        $('#add_expertise_Calibration').append('<tr>' +
                                                '<td class="text-center">1</td>' +
                                                '<td>'+standard_text+'</td>' +
                                                '<td>'+branch_text+'</td>' +  
                                                '<td>'+check_expertise_calibration_text+'</td>' +   
                                                '<td>'+data_number_status.join(",")+'</td>' +  
                                                '<td>'+specialized_expertise+'</td>' +  
                                                '<td class="text-center">' +
                                                '<input type="hidden" name="expertise_calibration[standard][]" class="standard"  value="'+standard+'">' +   // มาตรฐาน
                                                '<input type="hidden" name="expertise_calibration[find_status][]" class="find_status"  value="'+branch+'">' +  // สาขา
                                                '<input type="hidden" name="expertise_calibration[number_status][]" class="number_status"  value="'+show_status+'">' +  // สถานะผู้ประเมิน
                                                '<input type="hidden" name="expertise_calibration[specialized_expertise][]" class="specialized_expertise"  value="'+specialized_expertise+'">' +  // ความเชี่ยวชาญเฉพาะด้าน
                                                '<input type="hidden" name="expertise_calibration[calibration_list][]" class="calibration_list"  value="'+check_expertise_calibration+'">' +  // รายการสอบเทียบ
                                                '<button class="btn clickEditExpertiseCalibration" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                ' <button class="btn clickDeleteExpertiseCalibration" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                '</td>' +
                                            '</tr>');
                        ResetTableExpertiseCalibration();
                        div_expertise_show_and_hide('0');
                        default_expertise_value();
     
                    }
                    else {
                        $('#showErrorExpertise').fadeIn();
                    }
    
                }else  if(type_of_check == '4'){ // LAB ทดสอบ
     
                    if ( checkNone(standard)   && checkNone(branch)  ) {
                        const expertise_product =  checkNone($('#filter_check_expertise_product').val()) ?  $('#filter_check_expertise_product').val() : '';   // ผลิตภัณฑ์
                        const expertise_product_text =  checkNone($('#filter_check_expertise_product').val()) ?  $('#filter_check_expertise_product :selected').text() : ''; 
                        const check_test =  checkNone($('#filter_check_test').val()) ?  $('#filter_check_test').val() : '';   //  รายการทดสอบ
                        const check_test_text =  checkNone($('#filter_check_test').val()) ?  $('#filter_check_test :selected').text() : '';  
                        $('#add_expertise_Test').append('<tr>' +
                                                '<td class="text-center">1</td>' +
                                                '<td>'+standard_text+'</td>' +
                                                '<td>'+branch_text+'</td>' +  
                                                '<td>'+expertise_product_text+'</td>' +   
                                                '<td>'+check_test_text+'</td>' +  
                                                '<td>'+data_number_status.join(",")+'</td>' +  
                                                '<td>'+specialized_expertise+'</td>' +  
                                                '<td class="text-center">' +
                                                '<input type="hidden" name="expertise_test[standard][]" class="standard"  value="'+standard+'">' +   // มาตรฐาน
                                                '<input type="hidden" name="expertise_test[find_status][]" class="find_status"  value="'+branch+'">' +  // สาขา
                                                '<input type="hidden" name="expertise_test[number_status][]" class="number_status"  value="'+show_status+'">' +  // สถานะผู้ประเมิน
                                                '<input type="hidden" name="expertise_test[specialized_expertise][]" class="specialized_expertise"  value="'+specialized_expertise+'">' +  // ความเชี่ยวชาญเฉพาะด้าน
                                                '<input type="hidden" name="expertise_test[product][]" class="product"  value="'+expertise_product+'">' +  // ผลิตภัณฑ์
                                                '<input type="hidden" name="expertise_test[test_list][]" class="test_list"  value="'+check_test+'">' +  // รายการทดสอบ
                                                '<button class="btn clickEditExpertiseTest" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                                ' <button class="btn clickDeleteExpertiseTest" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                                '</td>' +
                                            '</tr>');
                        ResetTableExpertiseTest();
                        div_expertise_show_and_hide('0');
                        default_expertise_value();
                    }else {
                        $('#showErrorExpertise').fadeIn();
                    }
                }
               }else{
                  $('#showErrorExpertise').fadeIn();
               }
          })
    
    
    // start cb
    $(document).on('click','.clickEditExpertiseCb',function () {
                $('#showErrorExpertise').fadeOut();
                var row =   $(this).parent().parent() ;
     
                //ประเภทการตรวจประเมิน
                $('#filter_type_of_check').val('1').select2();
                  // มาตรฐาน
                var standard  =  row.find('.standard').val();
                if (checkNone(standard)) { 
                    expertise_standard('1',standard);
                }
                // สาขา
                var find_status  =  row.find('.find_status').val();
                if (checkNone(find_status)) { 
                    expertise_find_status('1',find_status);
                }
                // ขอบข่าย
                var check_scope  =  row.find('.check_scope').val();
                if (checkNone(find_status) && checkNone(check_scope)) { 
                    experience_check('1',find_status,check_scope,'');
                }
                // ความเชี่ยวชาญเฉพาะด้าน
                var specialized_expertise  =  row.find('.specialized_expertise').val();
                if (checkNone(specialized_expertise)) { 
                    $('#filter_specialized_expertise').val(specialized_expertise);
                }
                 // สถานะผู้ประเมิน
                var number_status  =  row.find('.number_status').val();
                if (checkNone(number_status)) { 
                    var keep_status = number_status.split(',');
                    $('#total_status').empty();
                    $.each(keep_status,function (index,value) {
                        $('#total_status').append('<button  type="button" class="col-md-6 bg-primary text-white text-nowrap text-center clickDelete" id='+value+' style="border: 1px solid blue; padding: 5px 15px ; border-radius: 20px; font-size: 11px">'+status_auditor[value]+'</button>');
                    });
                }
    
                $(this).parent().parent().remove();
                ResetTableExpertiseCb();
                div_expertise_show_and_hide('1');
                $('#add_expertise').prop('disabled',false);  
            })
            //ลบแถว
              $('body').on('click', '.clickDeleteExpertiseCb', function(){
                  $(this).parent().parent().remove();
                  ResetTableExpertiseCb();
              });
    // end cb
    
    // start ib
    $(document).on('click','.clickEditExpertiseIb',function () {
                $('#showErrorExpertise').fadeOut();
                var row =   $(this).parent().parent() ;
     
                //ประเภทการตรวจประเมิน
                $('#filter_type_of_check').val('2').select2();
                  // มาตรฐาน
                var standard  =  row.find('.standard').val();
                if (checkNone(standard)) { 
                    expertise_standard('2',standard);
                }
                // สาขา
                var find_status  =  row.find('.find_status').val();
                if (checkNone(find_status)) { 
                    expertise_find_status('2',find_status);
                }
                 // ประเภทหน่วยตรวจ
                 var type_of_examination  =  row.find('.type_of_examination').val();
                if (checkNone(type_of_examination)) { 
                    experience_check('2',find_status,type_of_examination);
                }
              // หมวดหมู่การตรวจ
                var examination_category  =  row.find('.examination_category').val();
                if (checkNone(examination_category)) { 
                    experience_check('2',find_status,'',examination_category);
                }
    
                // ความเชี่ยวชาญเฉพาะด้าน
                var specialized_expertise  =  row.find('.specialized_expertise').val();
                if (checkNone(specialized_expertise)) { 
                    $('#filter_specialized_expertise').val(specialized_expertise);
                }
                 // สถานะผู้ประเมิน
                var number_status  =  row.find('.number_status').val();
                if (checkNone(number_status)) { 
                    var keep_status = number_status.split(',');
                    $('#total_status').empty();
                    $.each(keep_status,function (index,value) {
                        $('#total_status').append('<button  type="button" class="col-md-6 bg-primary text-white text-nowrap text-center clickDelete" id='+value+' style="border: 1px solid blue; padding: 5px 15px ; border-radius: 20px; font-size: 11px">'+status_auditor[value]+'</button>');
                    });
                }
    
                $(this).parent().parent().remove();
                ResetTableExpertiseIb();
                div_expertise_show_and_hide('2');
                $('#add_expertise').prop('disabled',false);  
            })
            //ลบแถว
              $('body').on('click', '.clickDeleteExpertiseIb', function(){
                  $(this).parent().parent().remove();
                  ResetTableExpertiseIb();
              });
    // end ib
    
    // start  LAB สอบเทียบ
    $(document).on('click','.clickEditExpertiseCalibration',function () {
                $('#showErrorExpertise').fadeOut();
                var row =   $(this).parent().parent() ;
     
                //ประเภทการตรวจประเมิน
                $('#filter_type_of_check').val('3').select2();
                  // มาตรฐาน
                var standard  =  row.find('.standard').val();
                if (checkNone(standard)) { 
                    expertise_standard('3',standard);
                }
                // สาขา
                var find_status  =  row.find('.find_status').val();
                if (checkNone(find_status)) { 
                    expertise_find_status('3',find_status);
                }
                // รายการสอบเทียบ
                var calibration_list  =  row.find('.calibration_list').val();
                if (checkNone(find_status) && checkNone(calibration_list)) { 
                    experience_check('3',find_status,calibration_list,'');
                }
                // ความเชี่ยวชาญเฉพาะด้าน
                var specialized_expertise  =  row.find('.specialized_expertise').val();
                if (checkNone(specialized_expertise)) { 
                    $('#filter_specialized_expertise').val(specialized_expertise);
                }
                 // สถานะผู้ประเมิน
                var number_status  =  row.find('.number_status').val();
                if (checkNone(number_status)) { 
                    var keep_status = number_status.split(',');
                    $('#total_status').empty();
                    $.each(keep_status,function (index,value) {
                        $('#total_status').append('<button  type="button" class="col-md-6 bg-primary text-white text-nowrap text-center clickDelete" id='+value+' style="border: 1px solid blue; padding: 5px 15px ; border-radius: 20px; font-size: 11px">'+status_auditor[value]+'</button>');
                    });
                }
    
                $(this).parent().parent().remove();
                ResetTableExpertiseCalibration();
                div_expertise_show_and_hide('3');
                $('#add_expertise').prop('disabled',false);  
            })
            //ลบแถว
              $('body').on('click', '.clickDeleteExpertiseCalibration', function(){
                  $(this).parent().parent().remove();
                  ResetTableExpertiseCalibration();
              });
    // end  LAB สอบเทียบ
     
    // start ib
    $(document).on('click','.clickEditExpertiseTest',function () {
                $('#showErrorExpertise').fadeOut();
                var row =   $(this).parent().parent() ;
     
                //ประเภทการตรวจประเมิน
                $('#filter_type_of_check').val('4').select2();
                  // มาตรฐาน
                var standard  =  row.find('.standard').val();
                if (checkNone(standard)) { 
                    expertise_standard('4',standard);
                }
                // สาขา
                var find_status  =  row.find('.find_status').val();
                if (checkNone(find_status)) { 
                    expertise_find_status('4',find_status);
                }
                 // ผลิตภัณฑ์
                 var product  =  row.find('.product').val();
                if (checkNone(product)) { 
                    experience_check('4',find_status,product);
                }
              // รายการทดสอบ
                var test_list  =  row.find('.test_list').val();
                if (checkNone(test_list)) { 
                    experience_check('4',find_status,'',test_list);
                }
    
                // ความเชี่ยวชาญเฉพาะด้าน
                var specialized_expertise  =  row.find('.specialized_expertise').val();
                if (checkNone(specialized_expertise)) { 
                    $('#filter_specialized_expertise').val(specialized_expertise);
                }
                 // สถานะผู้ประเมิน
                var number_status  =  row.find('.number_status').val();
                if (checkNone(number_status)) { 
                    var keep_status = number_status.split(',');
                    $('#total_status').empty();
                    $.each(keep_status,function (index,value) {
                        $('#total_status').append('<button  type="button" class="col-md-6 bg-primary text-white text-nowrap text-center clickDelete" id='+value+' style="border: 1px solid blue; padding: 5px 15px ; border-radius: 20px; font-size: 11px">'+status_auditor[value]+'</button>');
                    });
                }
    
                $(this).parent().parent().remove();
                ResetTableExpertiseTest();
                div_expertise_show_and_hide('4');
                $('#add_expertise').prop('disabled',false);  
            })
            //ลบแถว
              $('body').on('click', '.clickDeleteExpertiseTest', function(){
                  $(this).parent().parent().remove();
                  ResetTableExpertiseTest();
              });
    // end ib
    
    
    
    
     });
    
          function experience_check(type,select,value = '',value2 = ''){
              const _token = $('input[name="_token"]').val();
              if(type == 1){  // CB 
                    $('#filter_check_scope').html("<option value='' > - เลือกขอบข่าย - </option>").select2();
                      $.ajax({
                        url:"{{route('bcertify.api.check_scope')}}",
                        method:"GET",
                        data:{id:select,_token:_token},
                        success:function (result) {  
                             //    ขอบข่าย
                           if(result.datas.length > 0){
                              $.each(result.datas,function (index,item) {
                                  var selected = (item.id == value)?'selected="selected"':'';
                                 $('#filter_check_scope').append('<option value='+item.id+' '+selected+'  >'+item.title+'</option>');
                              })      
                              $('#filter_check_scope').select2();       
                           }
                        }
                    })
              }else if(type == 2){ // IB
                        if(value == ''){
                            $('#filter_check_expertise_inspection').html("<option value='' > - เลือกประเภทหน่วยตรวจ - </option>").select2();
                        }
                        if(value2 == ''){
                            $('#filter_check_category').html("<option value='' > - เลือกหมวดหมู่การตรวจ - </option>").select2();
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
                                        $('#filter_check_expertise_inspection').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                    })    
                                    $('#filter_check_expertise_inspection').select2();              
                                }
                                //    หมวดหมู่การตรวจ
                                if(result.categories_inspection.length > 0){
                                    $.each(result.categories_inspection,function (index,item) {
                                        var selected = (item.id == value2)?'selected="selected"':'';
                                        $('#filter_check_category').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                    })    
                                    $('#filter_check_category').select2();              
                                }
                            }
                       })
    
              }else if(type == 3){  // LAB สอบเทียบ 
                    $('#filter_check_expertise_calibration').html("<option value='' > - เลือกรายการสอบเทียบ - </option>").select2();  
                    $.ajax({
                        url:"{{route('bcertify.api.check_calibration')}}",
                        method:"POST",
                        data:{id:select,_token:_token},
                        success:function (result) {
                            //   รายการสอบเทียบ
                             if(result.datas.length > 0){
                              $.each(result.datas,function (index,item) {
                                 var selected = (item.id == value)?'selected="selected"':'';
                                 $('#filter_check_expertise_calibration').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                             })    
                             $('#filter_check_expertise_calibration').select2();              
                            }
                        }
                    })
    
              }else if(type == 4){ //  LAB ทดสอบ 
                      if(value == ''){
                           $('#filter_check_expertise_product').html("<option value='' > - เลือกผลิตภัณฑ์ - </option>").select2();
                        }
                        if(value2 == ''){
                            $('#filter_check_test').html("<option value='' > - เลือกรายการทดสอบ - </option>").select2();
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
                                        $('#filter_check_expertise_product').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                    })    
                                    $('#filter_check_expertise_product').select2();              
                                }
                                //  รายการทดสอบ
                                if(result.test.length > 0){
                                    $.each(result.test,function (index,item) {
                                        var selected = (item.id == value2)?'selected="selected"':'';
                                        $('#filter_check_test').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                                    })    
                                    $('#filter_check_test').select2();              
                                }
     
                            }
                        })
              } 
     }
     
    
    
     function expertise_standard(select,value = ''){
          $('#filter_check_standard').html("<option value='' > - เลือกมาตรฐาน - </option>").select2();
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
                                 $('#filter_check_standard').append('<option value='+item.id+'  '+selected+' >'+item.title+'</option>');
                              })    
                              $('#filter_check_standard').select2();              
                           }
    
                        }
            })
      }
     function expertise_find_status(select,value = ''){
         $('#check_branch').fadeIn(); //  สาขา
          $('#filter_check_branch').html("<option value='' > - เลือกสาขา - </option>").select2();
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
                                 $('#filter_check_branch').append('<option value='+item.id+' '+selected+'  >'+item.title+'</option>');
                              })    
                              $('#filter_check_branch').select2();           
                           }
                        }
            })
      }
    
    
      function default_expertise_value(){
            var   keep_status = [];
            $('#filter_type_of_check').val('').select2();  // ประเภทการตรวจประเมิน
            $('#filter_check_standard').val('').select2();   // มาตรฐาน
            $('#filter_check_branch').val('').select2();   // สาขา
            $('#filter_specialized_expertise').val('');   //  ความเชี่ยวชาญเฉพาะด้าน
            $('#filter_check_status').val('').select2();   // สถานะผู้ประเมิน
    
            //  cb
            $('#filter_check_scope').val('').select2();   // ขอบข่าย
            //ib
            $('#filter_check_expertise_inspection').val('').select2();   // ประเภทหน่วยตรวจ
            $('#filter_check_category').val('').select2();   // หมวดหมู่การตรวจ
            //  LAB สอบเทียบ 
            $('#filter_check_expertise_calibration').val('').select2();   // รายการสอบเทียบ
    
           //  LAB ทดสอบ  
            $('#filter_check_expertise_product').val('').select2();   // ผลิตภัณฑ์
            $('#filter_check_test').val('').select2();   // รายการทดสอบ
            
            $('#total_status').html(''); 
            $('#showErrorExpertise').fadeOut();
            $('#add_expertise').prop('disabled',true);  
        } 
    
     
        function div_expertise_show_and_hide(type){
                if(type == 1){  // CB  
                    $('#div_check_scop').fadeIn(); // ขอบข่าย
                }else if(type == 2){  // IB 
                    $('.expertise_inspection').fadeIn(); // ประเภทหน่วยตรวจ และ หมวดหมู่การตรวจ 
                }else if(type == 3){  // LAB สอบเทียบ 
                    $('#expertise_calibration').fadeIn(); // รายการสอบเทียบ
                }else if(type == 4){  // LAB ทดสอบ 
                    $('.expertise_product').fadeIn(); // ผลิตภัณฑ์ และ รายการทดสอบ 
                }else{ 
                    $('#check_branch').fadeOut(); // สาขา
                    $('#div_check_scop').fadeOut(); // ขอบข่าย
                    $('.expertise_inspection').fadeOut(); // ประเภทหน่วยตรวจ และ หมวดหมู่การตรวจ
                    $('#expertise_calibration').fadeOut(); // รายการสอบเทียบ
                    $('.expertise_product').fadeOut(); // ผลิตภัณฑ์ และ รายการทดสอบ 
                }
                $('#filter_check_scope').html("<option value='' > - เลือกขอบข่าย - </option>").select2();
                $('#filter_check_expertise_inspection').html("<option value='' > - เลือกประเภทหน่วยตรวจ - </option>").select2();
                $('#filter_check_category').html("<option value='' > - เลือกหมวดหมู่การตรวจ - </option>").select2();
                $('#filter_check_expertise_calibration').html("<option value='' > - เลือกรายการสอบเทียบ - </option>").select2();  
                $('#filter_check_expertise_product').html("<option value='' > - เลือกผลิตภัณฑ์ - </option>").select2();
                $('#filter_check_test').html("<option value='' > - เลือกรายการทดสอบ - </option>").select2();
        } 
        function ResetTableExpertiseCb(){
          var rows = $('#add_expertise_CB').children(); //แถวทั้งหมด
              rows.each(function(index, el) {
                $(el).children().first().html(index+1);   //เลขรัน
              });
              if(rows.length > 0){
                   $('#viewCB').fadeIn(); // Table CB  
              }else{
                    $('#viewCB').fadeOut(); // Table CB
              }
         }
         function ResetTableExpertiseIb(){
          var rows = $('#add_expertise_IB').children(); //แถวทั้งหมด
              rows.each(function(index, el) {
                $(el).children().first().html(index+1);   //เลขรัน
              });
              if(rows.length > 0){
                   $('#viewIB').fadeIn(); // Table CB  
              }else{
                    $('#viewIB').fadeOut(); // Table CB
              }
         }
         function ResetTableExpertiseCalibration(){
          var rows = $('#add_expertise_Calibration').children(); //แถวทั้งหมด
              rows.each(function(index, el) {
                $(el).children().first().html(index+1);   //เลขรัน
              });
              if(rows.length > 0){
                   $('#viewCalibration').fadeIn(); // Table  LAB สอบเทียบ   
              }else{
                    $('#viewCalibration').fadeOut(); // Table  LAB สอบเทียบ 
              }
         }
         function ResetTableExpertiseTest(){
          var rows = $('#add_expertise_Test').children(); //แถวทั้งหมด
              rows.each(function(index, el) {
                $(el).children().first().html(index+1);   //เลขรัน
              });
              if(rows.length > 0){
                   $('#viewTest').fadeIn(); // Table  LAB สอบเทียบ   
              }else{
                    $('#viewTest').fadeOut(); // Table  LAB สอบเทียบ 
              }
         }
    </script>     
    @endpush
     