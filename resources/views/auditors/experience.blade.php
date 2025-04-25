<div class="white-box"> 
          <div class="row">
                <div class="col-sm-12">
         
                 <legend><h3 class="box-title">ประสบการณ์การทำงาน</h3></legend>
                 <div class="row ">
                   <div class="col-sm-3 form-group">
                           {!! HTML::decode(Form::label('', 'ปี'.' :<span class="text-danger">*</span>', ['class' => 'col-md-3 control-label text-left '])) !!}
                          <div class="col-md-9">
                               {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_experience_year']) !!}
                               {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                         </div>
                   </div>
                   <div class="col-sm-9 form-group">
                       {!! HTML::decode(Form::label('', 'หน่วยงาน'.' :<span class="text-danger">*</span>', ['class' => 'col-md-2 control-label  text-left'])) !!}
                       <div class="col-md-10">
                            {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_experience_department']) !!}
                            {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                      </div>
                   </div>
                 <div class="col-sm-5 form-group">
                     {!! HTML::decode(Form::label('', 'ตำแหน่ง'.' :<span class="text-danger">*</span>', ['class' => 'col-md-3 control-label text-left '])) !!}
                    <div class="col-md-9">
                         {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_experience_position']) !!}
                         {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                     </div>
                 </div>
                 <div class="col-sm-6 form-group">
                     {!! HTML::decode(Form::label('', 'บทบาทหน้าที่'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
                     <div class="col-md-8">
                         {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_experience_character']) !!}
                         {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                      </div>
                 </div>
                   <div class="col-md-1">
                       <div class="pull-right">
                           <button class="btn btn-success" type="button" id="add_experience"><i class="fa fa-plus"></i> เพิ่ม</button>
                       </div>
                   </div>
               </div>
                
                <hr>
               <div class="col-md-12" style="margin-top: 20px ; display: none" id="showErrorWork">
                   <p class="text-danger text-center">** กรุณากรอกข้อมูลให้ครบถ้วน **</p>
               </div>
         
          <div class="col-md-12">
             <div class="table-responsive">
              <table class="table color-table primary-table">
                 <thead>
                 <tr class=" text-center" >
                     <th class="text-center"  width="1%">No.</th>
                     <th class="text-center"  width="15%">ปีที่ทำงาน</th>
                     <th class="text-center"  width="20%">ตำแหน่ง</th>
                     <th class="text-center"  width="20%"> หน่วยงาน	</th>
                     <th class="text-center"  width="20%">บทบาทหน้าที่</th>
                     <th class="text-center"  width="15%">เครื่องมือ</th>
                 </tr>
                 </thead>
                 <tbody id="tbody_experience">
                     @if (!empty($information) && count($information->auditor_work_experience) > 0)
                         @foreach ($information->auditor_work_experience as $key => $item)
                         <tr>
                             <td class="text-center">{{ $key +1 }}</td>
                              <td>
                                 {{  (!empty($item->year) ? $item->year : null) }}
                             </td>
                             <td >
                                 {{  (!empty($item->department) ? $item->department : null) }}
                             </td>
                             <td >
                                 {{  (!empty($item->position) ? $item->position : null) }}
                             </td>
                             <td >
                                 {{  (!empty($item->role) ? $item->role : null) }}
                             </td>
                             <td class="text-center">
                                 <input type="hidden" name="experience[experience_year][]"  class="experience_year" value="{{ (!empty($item->year) ? $item->year : null)  }}">
                                 <input type="hidden" name="experience[experience_position][]"  class="experience_position" value="{{ (!empty($item->position) ? $item->position : null)  }}">
                                 <input type="hidden" name="experience[experience_department][]"  class="experience_department" value="{{ (!empty($item->department) ? $item->department : null)  }}">
                                 <input type="hidden" name="experience[experience_character][]"  class="experience_character" value="{{ (!empty($item->role) ? $item->role : null)  }}">
          
                                 <button class="btn clickEditExperience" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteExperience" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
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
         
         @push('js')
         <script type="text/javascript">
          $(document).ready(function() {
              $('#showErrorWork').fadeOut()
              ResetTableExperience();
             $('#add_experience').on('click', function () {
                     const experience_year = $('#filter_experience_year').val();
                     const experience_position = $('#filter_experience_position').val(); 
                     const experience_department = $('#filter_experience_department').val();
                     const experience_character = $('#filter_experience_character').val();
                     if (checkNone(experience_year)  && checkNone(experience_position) &&    checkNone(experience_department)   && checkNone(experience_character) ) {
                         $('#showErrorWork').fadeOut();
                             $('#tbody_experience').append('<tr>' +
                                 '<td class="text-center">1</td>' +
                                 '<td>'+experience_year+'</td>' +
                                 '<td>'+experience_position+'</td>' +
                                 '<td>'+experience_department+'</td>' +
                                 '<td>'+experience_character+'</td>' +
                                 '<td class="text-center">' +
                                 '<input type="hidden" name="experience[experience_year][]" class="experience_year"   value="'+experience_year+'">' +
                                 '<input type="hidden" name="experience[experience_position][]" class="experience_position"  value="'+experience_position+'">' +
                                 '<input type="hidden" name="experience[experience_department][]"   class="experience_department" value="'+experience_department+'">' +
                                 '<input type="hidden" name="experience[experience_character][]" class="experience_character" value="'+experience_character+'">' +
                                 '<button class="btn clickEditExperience" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                                 ' <button class="btn clickDeleteExperience" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                                 '</td>' +
                                 '</tr>');
                             ResetTableExperience();
                         $('#filter_experience_year').val("");
                         $('#filter_experience_position').val("");
                         $('#filter_experience_department').val("");
                         $('#filter_experience_character').val("");
                     }
                     else {
                         $('#showErrorWork').fadeIn()
                     }
                 })
         
                 $(document).on('click','.clickEditExperience',function () {
              
                     var row =   $(this).parent().parent() ;
         
                     var experience_year  =  row.find('.experience_year').val();
                     if (checkNone(experience_year)) { 
                         $('#filter_experience_year').val(experience_year);
                     }else{
                         $('#filter_experience_year').val('');
                     }
                     var experience_position  =  row.find('.experience_position').val();
                     if (checkNone(experience_position)) { 
                         $('#filter_experience_position').val(experience_position);
                     }else{
                         $('#filter_experience_position').val('');
                     }
                     var experience_department  =  row.find('.experience_department').val();
                     if (checkNone(experience_department)) { 
                         $('#filter_experience_department').val(experience_department);
                     }else{
                         $('#filter_experience_department').val('');
                     }
         
                     var experience_character  =  row.find('.experience_character').val();
                     if (checkNone(experience_character)) { 
                         $('#filter_experience_character').val(experience_character);
                     }else{
                         $('#filter_experience_character').val('');
                     }
         
                     $('#showErrorWork').fadeOut();
                     $(this).parent().parent().remove();
                     ResetTableExperience();
                 })
                      //ลบแถว
                   $('body').on('click', '.clickDeleteExperience', function(){
                       $(this).parent().parent().remove();
                       ResetTableExperience();
                   });
          });
         
          function ResetTableExperience(){
               var rows = $('#tbody_experience').children(); //แถวทั้งหมด
                  rows.each(function(index, el) {
                      //เลขรัน
                        $(el).children().first().html(index+1);
                   });
              }
         </script>     
         @endpush
         