@push('css')
{{-- <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> --}}
<link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
<style>
 
    .detail-result {
        display: block;
        padding: 6px 12px;
    }

    .detail-result-underline {
        display: block;
        padding: 6px 12px;
        /* border-top: #000000 solid 1px; */
        border-bottom: #000000 solid 1px;
    }
    
    .label-height{
        line-height: 25px;
        font-size: 20px;
        font-weight: 600 !important;
        color: black !important;
    }

    .font_size{
        font-size: 10px;
    }
  .tab {
    display: none;
  }

  .step {
    margin: 0 2px; 
    color: #fff;
    background-color: #b3b4b5;
    border-color: #b3b4b5;
    padding: 5px 10px;
    font-size: 16px;
  }

  .autofill {

    border-right-width: 0px !important;
    border-left-width: 0px !important;
    border-top-width: 0px !important;
    border-bottom: 1px !important;
    border-style: dotted !important;
    border-color: #585858 !important;
    background-color: #fff !important;
    /* cursor: no-drop; */
}
.label_height{
        line-height: 25px;
        font-size: 16px;
        font-weight: 600 !important;
        color: black !important;
        text-align:left;
  }
  .label-height-font10{
      line-height: 25px;
      font-size: 16px;
      font-weight: 600 !important;
      color: black !important;
  }
  .no-drop {cursor: no-drop;}
 .bootstrap-tagsinput {
  width: 500px !important;
}
label[for=checkbox_confirm] {
    color: black !important;
}
</style>
@endpush

<div style="text-align:center;margin-top:40px;">
    <span class="step btn ">ส่วนที่1 : ข้อมูลส่วนตัว</span> <span><i class="fa fa-angle-double-right"></i></span>
    <span class="step btn ">ส่วนที่2 : ข้อมูลการศึกษา</span> <span><i class="fa fa-angle-double-right"></i></span>
    <span class="step btn ">ส่วนที่3 : ประสบการณ์/การทำงาน</span>  <span><i class="fa fa-angle-double-right"></i></span>
    <span class="step btn ">ส่วนที่3 : ข้อมูลความเชี่ยวชาญ</span>  <span><i class="fa fa-angle-double-right"></i></span>
    <span class="step btn ">ส่วนที่4 : สรุปข้อมูล</span>
</div>
  <hr>

<div class="tab" id="tab1">
    @include ('experts.profile')
</div>
<div class="tab" id="tab2">
      @include ('experts.educational')
</div>
<div class="tab" id="tab3">
      @include ('experts.experience')
</div>
<div class="tab" id="tab4">
    @include ('experts.information')
</div>
<div class="tab" id="tab5">
     @include ('experts.view')
</div>


<div class="row">
  <div class="col-md-12 text-center prevBtn_nextBtn">
    <button type="button" id="prevBtn" class="btn btn-primary" onclick="nextPrev(-1)">กลับ</button>
    <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">ถัดไป</button>
  </div>
</div>
 




@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
<script src="{{asset('plugins/components/moment/moment.js')}}"></script>
<script src="{{asset('js/jasny-bootstrap.js')}}"></script>
<script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
    <!-- input calendar thai -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <!-- thai extension -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
    <script src="{{asset('plugins/components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script>

          @if(\Session::has('flash_message'))
          $.toast({
              heading: 'Success!',
              position: 'top-center',
              text: '{{session()->get('flash_message')}}',
              loaderBg: '#70b7d6',
              icon: 'success',
              hideAfter: 3000,
              stack: 6
          });
          @endif
          @if(!empty($expert) )
              var currentTab = 4; 
          @else
              var currentTab = 0; 
           @endif

           @if ((!is_null($expert) && in_array($expert->state,[1,2,5,6,7,8]))) 
                 $('.prevBtn_nextBtn').hide();
                 $('#checkbox_confirm').attr('disabled',true);
              
           @endif  
 
    showTab(currentTab); 

    $(document).ready(function () {
          $('.input_required').keyup(function(event) {
            checkInput($(this));
          });
          $('.input_required').change(function(event) {
            checkInput($(this));
          });
          $('.input_required').blur(function(event) {
              checkInput($(this));
          });

            //ปฎิทิน
            $('.mydatepicker_th').datepicker({
                toggleActive: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });

          $('#address_same_head').on('change', function() {
            if ($(this).prop('checked')) {
                $('#contact_address_no').val($('#head_address_no').val());
                $('#contact_soi').val($('#head_soi').val());
                $('#contact_subdistrict').val($('#head_subdistrict').val());
                $('#contact_province').val($('#head_province').val());
                $('#contact_village').val($('#head_village').val());
                $('#contact_moo').val($('#head_moo').val());
                $('#contact_district').val($('#head_district').val());
                $('#contact_zipcode').val($('#head_zipcode').val());
            } else {
                $('#contact_address_no').val('');
                $('#contact_soi').val('');
                $('#contact_subdistrict').val('');
                $('#contact_province').val('');
                $('#contact_village').val('');
                $('#contact_moo').val('');
                $('#contact_district').val('');
                $('#contact_zipcode').val('');
                $('#contact_address_no').removeClass('parsley-error');
                $('#contact_address_no').removeClass('parsley-success');
                $('#contact_subdistrict').removeClass('parsley-error');
                $('#contact_subdistrict').removeClass('parsley-success');
                $('#contact_district').removeClass('parsley-error');
                $('#contact_district').removeClass('parsley-success');
                $('#contact_province').removeClass('parsley-error');
                $('#contact_province').removeClass('parsley-success');
                $('#contact_zipcode').removeClass('parsley-error');
                $('#contact_zipcode').removeClass('parsley-success');
            }
             if($('#contact_address_no').parent().find('ul').html() !== undefined && checkNone($('#contact_address_no').val())){
                $('#contact_address_no').removeClass('parsley-error');
                $('#contact_address_no').addClass('parsley-success');
                 $('#contact_address_no').parent().find('ul').remove();
             }
             if($('#contact_subdistrict').parent().find('ul').html() !== undefined && checkNone($('#contact_subdistrict').val())){
                $('#contact_subdistrict').removeClass('parsley-error');
                $('#contact_subdistrict').addClass('parsley-success');
                 $('#contact_subdistrict').parent().find('ul').remove();
             }
             if($('#contact_district').parent().find('ul').html() !== undefined && checkNone($('#contact_district').val())){
                $('#contact_district').removeClass('parsley-error');
                 $('#contact_district').addClass('parsley-success');
                 $('#contact_district').parent().find('ul').remove();
             }
             if($('#contact_province').parent().find('ul').html() !== undefined  && checkNone($('#contact_province').val())){
               $('#contact_province').removeClass('parsley-error');
                 $('#contact_province').addClass('parsley-success');
                 $('#contact_province').parent().find('ul').remove();
             }
             if($('#contact_zipcode').parent().find('ul').html() !== undefined && checkNone($('#contact_zipcode').val())){
                $('#contact_zipcode').removeClass('parsley-error');
                 $('#contact_zipcode').addClass('parsley-success');
                 $('#contact_zipcode').parent().find('ul').remove();
             }
          
        });
        ResetTableNumber();
        file_education();
        //  DataListDisabled();
        //เพิ่มแถว
        $('#plus-row').click(function(event) {
          //Clone
          $('#table-body').children('tr:first()').clone().appendTo('#table-body');
          //Clear value
            var row = $('#table-body').children('tr:last()');
            row.find('input[type="text"],input[type="hidden"],textarea').val('');
            row.find('ul').remove();
            row.find('select.select2').val('');
            row.find('select.select2').prev().remove();
            row.find('select.select2').removeAttr('style');
            row.find('select.select2').select2();
            row.find('.input_required').removeClass('parsley-error');
            row.find('.input_required').removeClass('parsley-success');

            row.find('.div_file_education').html('');
            var text = '<span class="div_file_education">';
                text += '<div class="fileinput fileinput-new input-group " data-provides="fileinput">';
                text += '<div class="form-control" data-trigger="fileinput">';
                text += '<i class="glyphicon glyphicon-file fileinput-exists"></i>';
                text += '<span class="fileinput-filename"></span>';
                text += '</div>';
                text += '<span class="input-group-addon btn btn-default btn-file">';
                text += '<span class="fileinput-new">เลือกไฟล์</span>';
                text += '<span class="fileinput-exists">เปลี่ยน</span>';
                text += '<input type="file" name="detail[file_education][]"  data-no=""   class="file_education check_max_size_file " >';
                text += '</span>';
                text += '<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>';
                text += '</div>';
                text += '<span class="span_file_education"> </span>';
                text += ' </span>';
            row.find('.div_file_education').html(text);

            ResetTableNumber();
            check_max_size_file();
            file_education();
            // DataListDisabled();
          });
        //ลบแถว
           $('body').on('click', '.repeater-remove', function(){
              $(this).parent().parent().remove();
              ResetTableNumber();
              // DataListDisabled();
         });
         $('body').on('click', '.file_education_default', function(){
              $(this).parent().parent().parent().find('.span_file_education').html('');
              ResetTableNumber();
         });

         ResetTableExperiencesNumber();
        //เพิ่มแถวประสบการณ์
        $('#plus_experiences_row').click(function(event) {
          $('#table_experiences_body').children('tr:first()').clone().appendTo('#table_experiences_body');
            var row = $('#table_experiences_body').children('tr:last()');
            row.find('input[type="text"],input[type="hidden"],textarea').val('');
            row.find('ul').remove();
            row.find('select.select2').val('');
            row.find('select.select2').prev().remove();
            row.find('select.select2').removeAttr('style');
            row.find('select.select2').select2();
            row.find('.input_required').removeClass('parsley-error');
            row.find('.input_required').removeClass('parsley-success');
            ResetTableExperiencesNumber();
          });
        //ลบแถวประสบการณ์
           $('body').on('click', '.repeater_experiences_remove', function(){
              $(this).parent().parent().remove();
              ResetTableExperiencesNumber();
         });
       
         
         ResetTablehistorysNumber();
        //เพิ่มแถวประวัติการดำเนินงานกับ สมอ.
        $('#plus_historys_row').click(function(event) {
          $('#table_historys_body').children('tr:first()').clone().appendTo('#table_historys_body');
            var row = $('#table_historys_body').children('tr:last()');
            row.find('input[type="text"],input[type="hidden"],textarea').val('');
            row.find('ul').remove();
            row.find('select.select2').val('');
            row.find('select.select2').prev().remove();
            row.find('select.select2').removeAttr('style');
            row.find('select.select2').select2();
            row.find('.input_required').removeClass('parsley-error');
            row.find('.input_required').removeClass('parsley-success');
             //ปฎิทิน
            row.find('.mydatepicker_th').datepicker({
                toggleActive: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });
            ResetTablehistorysNumber();
          });
        //ลบแถวประวัติการดำเนินงานกับ สมอ.
           $('body').on('click', '.repeater_historys_remove', function(){
              $(this).parent().parent().remove();
              ResetTablehistorysNumber();
         });
        

            //Validate
            // $('#form-experts').parsley().on('field:validated', function() {
            //     var ok = $('.parsley-error').length === 0;
            //     $('.bs-callout-info').toggleClass('hidden', !ok);
            //     $('.bs-callout-warning').toggleClass('hidden', ok);
            // }).on('form:submit', function() {
            //     // Text
            //     $.LoadingOverlay("show", {
            //         image       : "",
            //         text        : "กำลังบันทึก กรุณารอสักครู่..."
            //     });
            //     return true; // Don't submit form for this demo
            // });



          
    });


        function checkInput(value){
            if(!checkNone(value.val())){//ถ้าเป็น mail ไม่ให้ไปต่อ
                $(value).addClass('parsley-error');
                $(value).removeClass('parsley-success');
                if($(value).parent().find('ul').html() === undefined  && checkNone($(value).val())){
                    $(value).parent().append('<ul class="parsley-errors-list " ><li class="parsley-required">โปรดป้อนข้อมูลนี้</li></ul>');
                }else if($(value).parent().find('ul > li').html() === undefined  && checkNone($(value).val())){
                     $(value).parent().find('ul').html('<li class="parsley-required">โปรดป้อนข้อมูลนี้</li>');
                }
            }else{
          
                if($(value).parent().find('ul').html() !== undefined  && checkNone($(value).val())){
                   $(value).removeClass('parsley-error');
                    $(value).addClass('parsley-success');
                    $(value).parent().find('ul').remove();
                }
            }
        }
        function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
        }
        
        function ResetTableNumber(){
                var rows = $('#table-body').children(); //แถวทั้งหมด
                (rows.length==1)?$('.repeater-remove').hide():$('.repeater-remove').show();
                  rows.each(function(index, el) {
                    $(el).children().first().html(index+1);
                    $(el).find('.file_education').attr("name",'detail[file_education]['+index+']');  
                    $(el).find('.file_education').attr("data-no",index);  
                });
           }
           function ResetTableExperiencesNumber(){
                var rows = $('#table_experiences_body').children(); //แถวทั้งหมด
                (rows.length==1)?$('.repeater_experiences_remove').hide():$('.repeater_experiences_remove').show();
                  rows.each(function(index, el) {
                    $(el).children().first().html(index+1);
                });
           }
           function ResetTablehistorysNumber(){
                var rows = $('#table_historys_body').children(); //แถวทั้งหมด
                (rows.length==1)?$('.repeater_historys_remove').hide():$('.repeater_historys_remove').show();
                  rows.each(function(index, el) {
                    $(el).children().first().html(index+1);
                    $(el).find('.committee_no').attr("name",'history[committee_no]['+index+']');  
                });
           }
           function file_education() {
              $('.file_education').change(function(event) {
               var row =   $(this).parent().parent().parent().find('.span_file_education');
                   row.html('');
                  if( checkNone($(this).prop('files')[0])){
                    var formData = new FormData();
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('file', $(this)[0].files[0]);

                      $.ajax({
                            type: "POST",
                            url: "{{ url('/experts/update_document') }}",
                            datatype: "script",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (msg) {
                                console.log(msg);
                                if (msg != "") {
                                      if( checkNone(msg.file) ){
                                        var file = '<input type="hidden" value="'+(msg.file)+'" class="hidden_file_education"/>';
                                            file += '<input type="hidden" value="'+(msg.file_odl)+'" class="hidden_file_odl_education"/>';
                                            row.html(file);
                                      }
                                }   
                            }
                        });
                  }
              });
        }


           
        // function DataListDisabled(){
        //         $('.education').children('option').prop('disabled',false);
        //         $('.education').each(function(index , item){
        //             var data_list = $(item).val();
        //             $('.education').children('option[value="'+data_list+'"]:not(:selected):not([value=""])').prop('disabled',true);
        //         });
        //  }  

     function data_view() {
      $('#view_head_name').val($('#head_name').val()); 
      $('#view_taxid').val($('#taxid').val());

        let department = $('#department_id').find('option:selected').text();
        $('#view_department').val(department);
        $('#view_mobile_phone').val($('#mobile_phone').val());
        $('#view_position').val($('#position').val());
        $('#view_email').val($('#email').val());
        

        if(checkNone($('#thumbnail_pic_profile').find('img').prop('src'))){
          $('#view_pic_profile').attr('src',$('#thumbnail_pic_profile').find('img').prop('src'));
        }else{
          $('#view_pic_profile').attr('src',$('#pic_profile').prop('src'));
        }

     
      
      $('#view_head_address_no').val($('#head_address_no').val());
      $('#view_head_soi').val($('#head_soi').val());
      $('#view_head_subdistrict').val($('#head_subdistrict').val());
      $('#view_head_province').val($('#head_province').val());
      $('#view_head_village').val($('#head_village').val());
      $('#view_head_moo').val($('#head_moo').val());
      $('#view_head_district').val($('#head_district').val());
      $('#view_head_zipcode').val($('#head_zipcode').val());

      $('#view_contact_address_no').val($('#contact_address_no').val());
      $('#view_contact_soi').val($('#contact_soi').val());
      $('#view_contact_subdistrict').val($('#contact_subdistrict').val());
      $('#view_contact_province').val($('#contact_province').val());
      $('#view_contact_village').val($('#contact_village').val());
      $('#view_contact_moo').val($('#contact_moo').val());
      $('#view_contact_district').val($('#contact_district').val());
      $('#view_contact_zipcode').val($('#contact_zipcode').val());

      $('#view_bank_name').val($('#bank_name').val());
      $('#view_bank_title').val($('#bank_title').val());
      $('#view_bank_number').val($('#bank_number').val());


      $('#view_historycv_text').tagsinput('add', $('#historycv_text').val());

      // ข้อมูลการศึกษา
      var rows = $('#table-body').children(); //แถวทั้งหมด
      if(rows.length > 0){
          $('#view-table-body').html('');
         rows.each(function(index, el) {
              var year =   $(el).find('.year').val();
              let department = $(el).find('.education_id option:selected').text();
              var academy =   $(el).find('.academy').val();


              var file_education =   $(el).find('.hidden_file_education').val();
              var file_odl_education =   $(el).find('.hidden_file_odl_education').val();

              var a_file_education =   $(el).find('.a_file_education').parent().clone().html();
            
              var file = '';
              if(checkNone(file_education) && checkNone(file_odl_education)){
                var file = '<a  href="'+(file_education)+'"  target="_blank">'+(file_odl_education)+'</a>';
              }else if(checkNone(a_file_education)){
                 var file = a_file_education;
              }

             var html = '';
                 html += '<tr>';
                    html += '<td>'+(index+1)+'</td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(year)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(department)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(academy)+'" disabled> </td>';
                    html += '<td> '+file+'</td>';
                 html += '</tr>';
             $('#view-table-body').append(html);     
         });
      }
         
      // ข้อมูลประสบการณ์
      var experiences = $('#table_experiences_body').children(); //แถวทั้งหมด
      if(experiences.length > 0){
          $('#view-experiences-body').html('');
          experiences.each(function(index, el) {
              let years      =   $(el).find('.years option:selected').text();
              let department =   $(el).find('.department_id option:selected').text();
              var position   =   $(el).find('.position').val();
              var role       =   $(el).find('.role').val();
             var html = '';
                 html += '<tr>';
                    html += '<td>'+(index+1)+'</td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(years)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(department)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(position)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(role)+'" disabled> </td>';
                 html += '</tr>';
             $('#view-experiences-body').append(html);     
         });
      }

      // ประวัติการดำเนินงานกับ สมอ.
       var historys = $('#table_historys_body').children(); //แถวทั้งหมด
      if(historys.length > 0){
          $('#view-historys-body').html('');
          historys.each(function(index, el) {

              var operation_at       =   $(el).find('.operation_at').val();
              let department         =   $(el).find('.department_id option:selected').text();
              var committee_no       =   $(el).find('.committee_no').val();
              let expert_group       =   $(el).find('.expert_group_id option:selected').text();
              let position           =   $(el).find('.position_id option:selected').text();
             var html = '';
                 html += '<tr>';
                    html += '<td>'+(index+1)+'</td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(operation_at)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(department)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(committee_no)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(expert_group)+'" disabled> </td>';
                    html += '<td> <input type="text" class="form-control autofill"  value="'+(position)+'" disabled> </td>';
                 html += '</tr>';
             $('#view-historys-body').append(html);     
         });
      }
               
    }



    function update_document(type) {
        if(type == 1){
          var file =   $('#bank_file')[0].files[0] ;
        }else{
          var file =   $('#historycv_file')[0].files[0] ; 
        }
        if(checkNone(file)){
          var formData = new FormData();
              formData.append('_token', "{{ csrf_token() }}");
              formData.append('file', file);

            $.ajax({
                  type: "POST",
                  url: "{{ url('/experts/update_document') }}",
                  datatype: "script",
                  data: formData,
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function (msg) {
  
                      if (msg != "") {
                            if( checkNone(msg.file) ){
                              var   text = '<a  href="'+(msg.file)+'"  target="_blank">'+(msg.file_odl)+'</a>';
                                   
                              if(type == 1){
                                   $('#span_bank_file').html('');
                                    $('#span_bank_file').html(text);
                              }else{
                                   $('#span_historycv_file').html('');
                                    $('#span_historycv_file').html(text);
                              }
                            }
                      }   
                  }
              });
          }
    }


    

    
    function showTab(n) {
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      //... and fix the Previous/Next buttons:
      if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
      } else {
        document.getElementById("prevBtn").style.display = "inline";
      }
      if (n == (x.length - 1)) {
          data_view();
          document.getElementById("nextBtn").innerHTML = "ยื่นข้อมูล";
          $('#nextBtn').removeClass('btn-primary').addClass('btn-success');
      } else {
        document.getElementById("nextBtn").innerHTML = "ถัดไป";
        $('#nextBtn').removeClass('btn-success').addClass('btn-primary');
      }
     
            fixStepIndicator(n)
       

    }
    
    function nextPrev(n) {
      // This function will figure out which tab to display
      var x = document.getElementsByClassName("tab");
      // Exit the function if any field in the current tab is invalid:
      if (n == 1 && !validateForm()){
            return false;
      } 
      
      if ((n+currentTab) <5){
        // Increase or decrease the current tab by 1:
        x[currentTab].style.display = "none";
      }
      currentTab = currentTab + n;
     
      if (currentTab >= x.length) {

        if($('#checkbox_confirm').prop('checked')){
            Swal.fire({
                  title: 'ยืนยันการทำรายงาน !',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'บันทึก',
                  cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                  if (result.value) {
                    // Text
                      $.LoadingOverlay("show", {
                          image       : "",
                          text        : "กำลังบันทึก กรุณารอสักครู่..."
                      });
                      document.getElementById("form-experts").submit();
                      return false;    
                  }
              });

        }else{
            Swal.fire({
              position: 'center',
              type: 'info',
              title: 'กรุณายอมรับเงื่อนไข',
              showConfirmButton: false,
              timer: 1500
            })

        }
     
       


      }else{

          if(currentTab == 1){ // เอกสารหน้าบัญชี
              if(checkNone($('#bank_file').val()) && checkNone($('#bank_file').prop('files')[0])){
                  update_document(1);
              }
          }else  if(currentTab == 4){ // ไฟล์ประวัติความเชี่ยวชาญ (CV)
              if(checkNone($('#historycv_file').val()) && checkNone($('#historycv_file').prop('files')[0])){
                  update_document(4);
              }
          }
         
            showTab(currentTab);
        
         
      }

    }
        // $('#form-experts').submit(function(e) {
        //    e.preventDefault();
        // });


    function validateForm() {
        var  valid = true;
        var row =  currentTab;  
    
        var tab =   $('#tab'+(row+1)).find('.input_required');
        var  number = 0;
        $(tab).each(function(i, el){
          console.log($(el).prop('tegName'));
          if($(el).prop('tagName') != 'DIV'){
              if($(el).val() == '')
              {
                  $(el).addClass('parsley-error');
                  console.log();
                  if($(el).parent().find('ul:not(.select2-results)').html() === undefined ){
                      $(el).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+(i+1)+'"><li class="parsley-required">โปรดป้อนข้อมูลนี้</li></ul>');
                  }       
                  number = 1; 
              }else{
                  $(el).removeClass('parsley-error');
                  if($(el).parent().find('ul').html() !== undefined){
                      $(el).parent().find('ul').remove();
                  }
              }
          }
         });
         console.log(number);

         if(number == 1){
           valid = false;
         } 
    
         return valid; // return the valid status
    }
    
    function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName("step");
      for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active btn-primary", "");
      }
 
      //... and adds the "active" class on the current step:
        x[n].className += " active btn-primary";
      
    }

    </script>

@endpush