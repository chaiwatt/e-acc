<div class="white-box"> 
          <div class="row">
              <div class="col-sm-12">
      <!-- start การศึกษา -->
      <legend><h3 class="box-title">ประวัติการศึกษา</h3></legend>
      <div class="row ">
          <div class="col-sm-4 form-group">
                  {!! HTML::decode(Form::label('', 'ปีที่สำเร็จ'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label text-left '])) !!}
                 <div class="col-md-8">
                      {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_year']) !!}
                      {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                </div>
          </div>
          <div class="col-sm-4 form-group">
              {!! HTML::decode(Form::label('', 'วุฒิการศึกษา'.' :<span class="text-danger">*</span>', ['class' => 'col-md-5 control-label  text-left'])) !!}
              <div class="col-md-7">
                  {!! Form::select('', 
                    ['1'=>'ป.ตรี','2'=>'ป.โท','3'=>'ป.เอก'], 
                   null,
                  ['class' => 'form-control',
                  'id' => 'filter_level_education',
                  'required' => false , 
                  'placeholder'=>'- เลือกวุฒิการศึกษา-' ]); !!}
                  {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
                
             </div>
          </div>
          <div class="col-sm-4 form-group">
              {!! HTML::decode(Form::label('', 'สาขา'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
              <div class="col-md-8">
                   {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_major_education']) !!}
                   {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
             </div>
          </div>
          <div class="col-sm-5 form-group">
              {!! HTML::decode(Form::label('', 'ชื่อสถานศึกษา'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
              <div class="col-md-8">
                   {!! Form::text('',  null, ['class' => 'form-control', 'placeholder'=>'', 'required' => false,'id'=>'filter_school_name']) !!}
                   {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
             </div>
          </div>
          <div class="col-sm-5 form-group">
              {!! HTML::decode(Form::label('', 'ประเทศ'.' :<span class="text-danger">*</span>', ['class' => 'col-md-4 control-label  text-left'])) !!}
              <div class="col-md-8">
                 {!! Form::select('', 
                   App\Models\Basic\Country::select(DB::raw("CONCAT(title,' -  ',title_en) AS titles"),'id')->orderbyRaw('CONVERT(titles USING tis620)')->pluck('titles','id'),
                    null,
                 ['class' => 'form-control',
                  'id' => 'filter_country',
                  'required' => false , 
                  'placeholder'=>'- เลือกประเทศ-' ]); !!}
                 {!! $errors->first('', '<p class="help-block">:message</p>') !!} 
             </div>
          </div>
          <div class="col-md-2">
              {{-- <div class="pull-right"> --}}
                  <button class="btn btn-success" type="button" id="addItemInformation"><i class="fa fa-plus"></i> เพิ่ม</button>
              {{-- </div> --}}
          </div>
      </div>
       
      <hr>
      <div class="col-md-12" style="margin-top: 20px ; display: none" id="showErrorEducation">
          <p class="text-danger text-center">** กรุณากรอกข้อมูลให้ครบถ้วน **</p>
      </div>
      <div class="col-md-12">
      <div class="table-responsive">
          <table class="table color-table primary-table">
              <thead>
              <tr class=" text-center" >
                  <th class="text-center"  width="1%">No.</th>
                  <th class="text-center"  width="10%">ปีที่สำเร็จ</th>
                  <th class="text-center"  width="10%">วุฒิการศึกษา</th>
                  <th class="text-center"  width="20%"> สาขา</th>
                  <th class="text-center"  width="20%">ชื่อสถานศึกษา</th>
                  <th class="text-center"  width="25%">ประเทศ</th>
                  <th class="text-center"  width="15%">เครื่องมือ</th>
              </tr>
              </thead>
              <tbody id="tbody_education">
                  @if (!empty($information) && count($information->auditor_education) > 0)
                      @foreach ($information->auditor_education as $key => $item)
                      <tr>
                          <td class="text-center">{{ $key +1 }}</td>
                           <td>
                              {{  (!empty($item->year) ? $item->year : null) }}
                          </td>
                          <td >
                              {{  (!empty($item->EducationName) ? $item->EducationName : null) }}
                          </td>
                          <td >
                              {{  (!empty($item->major_education) ? $item->major_education : null) }}
                          </td>
                          <td >
                              {{  (!empty($item->school_name) ? $item->school_name : null) }}
                          </td>
                          <td >
                              {{  (!empty($item->CountryName) ? $item->CountryName : null) }}
                          </td>
                          <td class="text-center">
                              <input type="hidden" name="education[year][]"  class="year" value="{{ (!empty($item->year) ? $item->year : null)  }}">
                              <input type="hidden" name="education[education][]"  class="education" value="{{ (!empty($item->level_education) ? $item->level_education : null)  }}">
                              <input type="hidden" name="education[major][]"  class="major" value="{{ (!empty($item->major_education) ? $item->major_education : null)  }}">
                              <input type="hidden" name="education[school_name][]"  class="school_name" value="{{ (!empty($item->school_name) ? $item->school_name : null)  }}">
                              <input type="hidden" name="education[country][]"  class="country" value="{{ (!empty($item->country) ? $item->country : null)  }}">
                              <button class="btn clickEditEducation" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>  <button class="btn clickEducation" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>
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
           $('#showErrorEducation').fadeOut()
           ResetTableEducation();
          $('#addItemInformation').on('click', function () {
                  const year = $('#filter_year').val();
                  const education = $('#filter_level_education').val();
                  const education_show = $('#filter_level_education :selected').text();
                  const major = $('#filter_major_education').val(); 
                  const school_name = $('#filter_school_name').val();
                  const country = $('#filter_country').val();
                  const country_show = $('#filter_country :selected').text();
                  if (checkNone(year)  && checkNone(education) &&  checkNone(major)  && checkNone(school_name)   && checkNone(country) ) {
                      $('#showErrorEducation').fadeOut();
                          $('#tbody_education').append('<tr>' +
                              '<td class="text-center">1</td>' +
                              '<td>'+year+'</td>' +
                              '<td>'+education_show+'</td>' +
                              '<td>'+major+'</td>' +
                              '<td>'+school_name+'</td>' +
                              '<td>'+country_show+'</td>' +    
                              '<td class="text-center">' +
                              '<input type="hidden" name="education[year][]"  class="year" value="'+year+'">' +
                              '<input type="hidden" name="education[education][]" class="education"   value="'+education+'">' +
                              '<input type="hidden" name="education[major][]" class="major"  value="'+major+'">' +
                              '<input type="hidden" name="education[school_name][]"   class="school_name" value="'+school_name+'">' +
                              '<input type="hidden" name="education[country][]" class="country" value="'+country+'">' +
                              '<button class="btn clickEditEducation" type="button"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"></i></button>' +
                              ' <button class="btn clickEducation" type="button"><i class="fa fa fa-trash-o text-danger" aria-hidden="true"></i></button>' +
                              '</td>' +
                              '</tr>');
                          ResetTableEducation();
                      $('#filter_year').val("");
                      $('#filter_level_education').val("").change();
                      $('#filter_major_education').val("");
                      $('#filter_school_name').val("");
                      $('#filter_country').val("").change();
                  }
                  else {
                      $('#showErrorEducation').fadeIn()
                  }
              })
      
              $(document).on('click','.clickEditEducation',function () {
           
                  var row =   $(this).parent().parent() ;
                  var year  =  row.find('.year').val();
                  console.log(year);
                  if (checkNone(year)) { 
                      $('#filter_year').val(year);
                  }else{
                      $('#filter_year').val('');
                  }
      
                  var education  =  row.find('.education').val();
                  if (checkNone(education)) { 
                      $('#filter_level_education').val(education).select2();
                  }else{
                      $('#filter_level_education').val('').select2();
                  }
      
                  var major  =  row.find('.major').val();
                  if (checkNone(major)) { 
                      $('#filter_school_name').val(major);
                  }else{
                      $('#filter_school_name').val('');
                  }
      
                  var school_name  =  row.find('.school_name').val();
                  if (checkNone(school_name)) { 
                      $('#filter_major_education').val(school_name);
                  }else{
                      $('#filter_major_education').val('');
                  }
      
                  var country  =  row.find('.country').val();
                  if (checkNone(country)) { 
                      $('#filter_country').val(country).select2();
                  }else{
                      $('#filter_country').val('').select2();
                  }
                  $('#showErrorEducation').fadeOut();
                  $(this).parent().parent().remove();
                  ResetTableEducation();
              })
                   //ลบแถว
                $('body').on('click', '.clickEducation', function(){
                    $(this).parent().parent().remove();
                    ResetTableEducation();
                });
       });
      
       function ResetTableEducation(){
            var rows = $('#tbody_education').children(); //แถวทั้งหมด
               rows.each(function(index, el) {
                   //เลขรัน
                     $(el).children().first().html(index+1);
                });
           }
      </script>     
      @endpush
      