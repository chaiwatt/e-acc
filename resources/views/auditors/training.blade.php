<div class="white-box"> 
          <div class="row">
              <div class="col-sm-12">
      <!-- start การฝึกอบรม -->
      <legend><h3 class="box-title">การฝึกอบรม</h3></legend>
      <div class="row ">
          <div class="col-sm-7 form-group">
                  {!! HTML::decode(Form::label('', 'ชื่อหลักสูตร'.' :<span class="text-danger">*</span>', ['class' => 'col-md-3 control-label text-left '])) !!}
                 <div class="col-md-8">
                      {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_subject']) !!}
                      {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                </div>
          </div>
          <div class="col-sm-5 form-group">
              {!! HTML::decode(Form::label('', 'หน่วยงาน'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
              <div class="col-md-8">
                   {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_institution']) !!}
                   {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
             </div>
          </div>
          <div class="col-sm-10 form-group">
                <div class="row  input-daterange " id="date-range">
                    <div class="col-md-6">   
                         {!! HTML::decode(Form::label('', 'วันที่เริ่มอบรม'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
                         <div class="col-md-8">
                              {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_start_date']) !!}
                              {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                         </div>
                    </div> 
                    <div class="col-md-6">   
                         {!! HTML::decode(Form::label('', 'วันที่สิ้นสุด'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
                          <div class="col-md-8">
                              {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_end_date']) !!}
                              {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                          </div>
                    </div>           
              </div>
          </div>
          <div class="col-md-2">
              {{-- <div class="pull-right"> --}}
                  <button class="btn btn-success" type="button" id="add_history"><i class="fa fa-plus"></i> เพิ่ม</button>
              {{-- </div> --}}
          </div>
      </div>
       
      <hr>
      <div class="col-md-12" style="margin-top: 20px ; display: none" id="showErrorTraining">
          <p class="text-danger text-center">** กรุณากรอกข้อมูลให้ครบถ้วน **</p>
      </div>
      <div class="col-md-12">
      <div class="table-responsive">
          <table class="table color-table primary-table">
              <thead>
              <tr class=" text-center" >
                  <th class="text-center"  width="1%">No.</th>
                  <th class="text-center"  width="24%">วันที่อบรม</th>
                  <th class="text-center"  width="30%">ชื่อหลักสูตร</th>
                  <th class="text-center"  width="30%"> หน่วยงาน</th>
                  <th class="text-center"  width="15%">เครื่องมือ</th>
              </tr>
              </thead>
              <tbody id="tbody_training">
                  @if (!empty($information) && count($information->auditor_training) > 0)
                      @foreach ($information->auditor_training as $key => $item)
                      <tr>
                          <td class="text-center">{{ $key +1 }}</td>
                           <td>
                              {{  (!empty($item->start_training) && !empty($item->end_training)  ? HP::DateThai($item->start_training).' - '.HP::DateThai($item->end_training) : null) }}
                          </td>
                          <td >
                              {{  (!empty($item->course_name) ? $item->course_name : null) }}
                          </td>
                          <td >
                              {{  (!empty($item->department_name) ? $item->department_name : null) }}
                          </td>
                           <td class="text-center">
                              <input type="hidden" name="training[start_training][]"  class="start_training" value="{{ (!empty($item->start_training) ? HP::revertDate($item->start_training,true) : null)  }}">
                              <input type="hidden" name="training[end_training][]"  class="end_training" value="{{ (!empty($item->end_training) ? HP::revertDate($item->end_training,true) : null)  }}">
                              <input type="hidden" name="training[course_name][]"  class="course_name" value="{{ (!empty($item->course_name) ? $item->course_name : null)  }}">
                              <input type="hidden" name="training[department_name][]"  class="department_name" value="{{ (!empty($item->department_name) ? $item->department_name : null)  }}">
                              <button class="btn clickEditTraining" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickDeleteTraining" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
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

            //ช่วงวันที่
            jQuery('#date-range').datepicker({
              toggleActive: true,
              language:'th-th',
              format: 'dd/mm/yyyy',
            });


           $('#showErrorTraining').fadeOut()
           ResetTableTraining();
          $('#add_history').on('click', function () {
              
                  const  subject = $('#filter_subject').val();  // ชื่อหลักสูตร
                  const institution = $('#filter_institution').val();   // หน่วยงาน
                  const start_date = $('#filter_start_date').val();   // วันที่เริ่มอบรม
                  const  end_date = $('#filter_end_date').val();   // วันที่สิ้นสุด
                  
                  if (checkNone(subject)  &&  checkNone(institution)  && checkNone(start_date)   && checkNone(end_date) ) {
                      $('#showErrorTraining').fadeOut();
                          $('#tbody_training').append('<tr>' +
                              '<td class="text-center">1</td>' +
                              '<td>'+DateFormateTh(start_date)+' - '+ DateFormateTh(end_date) +'</td>' +
                              '<td>'+subject+'</td>' +
                              '<td>'+institution+'</td>' +  
                              '<td class="text-center">' +
                              '<input type="hidden" name="training[start_training][]"  class="start_training" value="'+start_date+'">' +
                              '<input type="hidden" name="training[end_training][]"  class="end_training" value="'+end_date+'">' +
                              '<input type="hidden" name="training[course_name][]" class="course_name"   value="'+subject+'">' +
                              '<input type="hidden" name="training[department_name][]" class="department_name"  value="'+institution+'">' +
                              '<button class="btn clickEditTraining" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                              ' <button class="btn clickDeleteTraining" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                              '</td>' +
                              '</tr>');
                          ResetTableTraining();
                      $('#filter_subject').val("");
                      $('#filter_institution').val("");
                      $('#filter_start_date').val("");
                      $('#filter_end_date').val("");
                  }
                  else {
                      $('#showErrorTraining').fadeIn()
                  }
              })
      
              $(document).on('click','.clickEditTraining',function () {
           
                  var row =   $(this).parent().parent() ;
                  var course_name  =  row.find('.course_name').val();
 
                  if (checkNone(course_name)) { 
                      $('#filter_subject').val(course_name);
                  }else{
                      $('#filter_subject').val('');
                  }
      
                  var department_name  =  row.find('.department_name').val();
                  if (checkNone(department_name)) { 
                      $('#filter_institution').val(department_name);
                  }else{
                      $('#filter_institution').val('');
                  }
      
                  var start_training  =  row.find('.start_training').val();
                  if (checkNone(start_training)) { 
                      $('#filter_start_date').val(start_training);
                  }else{
                      $('#filter_start_date').val('');
                  }
      
                  var end_training  =  row.find('.end_training').val();
                  if (checkNone(end_training)) { 
                      $('#filter_end_date').val(end_training);
                  }else{
                      $('#filter_end_date').val('');
                  }
      
                  $('#showErrorTraining').fadeOut();
                  $(this).parent().parent().remove();
                  ResetTableTraining();
              })
                   //ลบแถว
                $('body').on('click', '.clickDeleteTraining', function(){
                    $(this).parent().parent().remove();
                    ResetTableTraining();
                });
       });
      
       function ResetTableTraining(){
            var rows = $('#tbody_training').children(); //แถวทั้งหมด
               rows.each(function(index, el) {
                   //เลขรัน
                     $(el).children().first().html(index+1);
                });
           }

      </script>     
      @endpush
      