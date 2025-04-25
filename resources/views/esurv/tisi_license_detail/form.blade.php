@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .panel-body-info {
    border: #00bbd9 1px solid;
  }
</style>
@endpush

@php
  $OwnTisUnitList = HP::OwnTisUnitList();
@endphp

<!-- ข้อมูลการผลิต -->
<div class="row">
  <div class="col-md-12">
      <div class="panel-wrapper collapse in" aria-expanded="true">

          <div class="form-group {{ $errors->has('tb3_Tisno') ? 'has-error' : ''}}">
            {!! Form::label('tb3_Tisno', 'มาตรฐาน', ['class' => 'col-md-2 control-label required']) !!}
            <div class="col-md-8">
              {!! Form::select('tb3_Tisno', HP::OwnTisList(), null, ['class' => 'form-control tis select2', 'required' => 'required', 'placeholder'=>'-เลือกมาตรฐาน-']); !!}
              {!! $errors->first('tb3_Tisno', '<p class="help-block">:message</p>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('license') ? 'has-error' : ''}}">
            {!! Form::label('license', 'ใบอนุญาต', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-8">

              <div class="row select-all">
                <div class="col-md-4">
                  <div class="checkbox checkbox-success">
                    <input id="license-all" class="license-all" type="checkbox">
                    <label for="license-all"> เลือกทั้งหมด </label>
                  </div>
                </div>
              </div>

              <div class="row license-list">
                <!-- แสดงเลขที่ใบอนุญาต -->
                @foreach ($own_licenses as $key => $own_license)

                <div class="col-md-4">
                  <div class="checkbox checkbox-success">
                    <input name="tbl_licenseNo[]" id="license{{ $own_license->Autono }}" data-license="{{ $own_license->Autono }}" class="license-item" type="checkbox" value="{{ $own_license->tbl_licenseNo }}" @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses)) checked="checked" @endif>
                      <label for="license{{ $own_license->Autono }}"> {{ $own_license->tbl_licenseNo }} </label>
                  </div>
                </div>

                @endforeach

              </div>

              {!! $errors->first('license', '<p class="help-block">:message</p>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">

            <div class="row license-detail col-md-12">
              <!-- แสดงรายละเอียดรายการในใบอนุญาต -->
            </div>

          </div>

      </div>

  </div>

</div>



  <div class="col-md-3">

  </div>

  <div class="col-md-6">

    <button class="btn btn-primary" type="submit" onclick="var result = beforeSubmit(); if(result==true){ this.form.submit(); }">
      <i class="fa fa-save"></i> บันทึก
    </button>

    @can('view-'.str_slug('inform_volume'))
    <a class="btn btn-default" href="{{ url('member/index-esurv') }}">
      <i class="fa fa-rotate-left"></i> ยกเลิก
    </a>
    @endcan

  </div>

  <div class="clearfix"></div>

  <!-- Start an Alert -->
  <div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-bottom alertbottom">
    <i class="ti-user"></i> ข้อมูลลำดับรายละเอียดผลิตภัณฑ์ซ้ำกับลำดับอื่นๆ
    <a href="#" class="closed">&times;</a>
  </div>

@push('js')

<!-- icheck  -->
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>

<!-- Toast -->
<script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {

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

    //เมื่อเลือกมาตรฐาน
    $('.tis').change(function(event) {

      $(".license-list").html('');
      $(".license-detail").html('');

      if ($(this).val() != "") { //ถ้าเลือกใบอนุญาต

        $.ajax("{{ url('basic/license-list') }}/" + $(this).val())
          .done(function(data) {

            $.each(data, function(key, value) {

              var input_html = [];
              input_html.push('<div class="col-md-4">');
              input_html.push('  <div class="checkbox checkbox-success">');
              input_html.push('   <input name="tbl_licenseNo[]" id="license' + value.Autono + '" data-license="' + value.Autono + '" data-license_type="' + value.tbl_licenseType + '" class="license-item" type="checkbox" value="' + value.tbl_licenseNo + '">');
              input_html.push('   <label for="license' + value.Autono + '"> ' + value.tbl_licenseNo + ' </label>');
              input_html.push('  </div>');
              input_html.push('</div>');

              $(".license-list").append(input_html.join(''));

            });

          });

      } else {

      }

    });

    //เลือกใบอนุญาตทั้งหมด
    $('.license-all').change(function(event) {

      if ($(this).prop('checked')) { //ถ้าเลือก
        $('.license-item').prop('checked', true);
      } else { //ถ้าไม่เลือก
        $('.license-item').prop('checked', false);
      }

      $('.license-item').change();

    });

    //เลือกใบอนุญาต
    $('body').on('change', '.license-item', function(event) {

      if ($(this).prop('checked')) { //เมื่อเลือก

        if (typeof($('#detail' + $(this).attr('data-license')).html()) == "undefined") {

          //นับจำนวนรายการเลขที่ใบอนุญาต
          var amount_row = $('.license-detail').children('').length;

          //ข้อความ มาตรฐานบังคับ | มาตรฐานทั่วไป
          var main_box = $(this).parent().parent().parent().parent().parent().parent();
          var standard = $(main_box).find('select.tis').children('option:selected').html();
          var standard_type = standard.search("มาตรฐานบังคับ") == '-1' ? 'ท' : 'บ';
          var standard_text = standard_type == 'ท' ? '<span class="text-success">(มาตรฐานทั่วไป)</span>' : '<span class="text-danger">(มาตรฐานบังคับ)</span>';

          //ประเภทใบอนุญาต
          var license_type = $(this).attr('data-license_type');

          var input_html = [];
          input_html.push('<div class="col-md-12 detail-item" id="detail' + $(this).attr('data-license') + '">');
          input_html.push('  <h5><span class="order">' + (amount_row + 1) + '</span>. ใบอนุญาตเลขที่ <span class="text-info">' + $(this).val() + '</span> ' + standard_text + '</h5>');
          input_html.push('</div>');

          $('.license-detail').append(input_html.join('')); //เพิ่มรายการ

          getLicenseDetail($(this).attr('data-license'), standard_type, license_type); //แสดงตารางรายละเอียดผลิตภัณฑ์

        }

      } else { //เมื่อไม่เลือก

        $('#detail' + $(this).attr('data-license')).remove(); //ลบ element

        $('.license-detail').children('').each(function(index, el) { //รีเซตเลขลำดับ
          $(el).find('.order').text(index + 1);
        });
      }

    });

    //Close Alert
    $(".myadmin-alert .closed").click(function (event) {
      $(this).parents(".myadmin-alert").fadeToggle(350);
      return false;
    });

  });

  function getLicenseDetail(Autono, standard_type, license_type) { //ดึงรายละเอียดผลิตภัณฑ์

      var table_html = [];
      table_html.push('<div class="table-responsive">');
      table_html.push('  <table class="table color-bordered-table info-bordered-table table-detail" id="table-detail' + Autono + '">');
      table_html.push('    <thead>');
      table_html.push('      <tr>');
      table_html.push('        <th class="col-md-1 text-center">ลำดับที่</th>');
      table_html.push('        <th class="col-md-11 text-center">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>');
      table_html.push('      </tr>');
      table_html.push('    </thead>');
      table_html.push('    <tbody>');
      table_html.push('    </tbody>');
      table_html.push('  </table>');
      table_html.push('</div>');

      //แสดงตารางรายละเอียดผลิตภัณ์
      $('#detail' + Autono).append(table_html.join(''));

      //ดึงรายละเอียดผลิตภัณฑ์
      $.ajax("{{ url('basic/license-detail-list') }}/" + Autono)
        .done(function(data) {

          $.each(data, function(key, value) {

            var input_html = [];
            input_html.push('<tr>');
            input_html.push('  <td class="text-center"><input type="number" name="itemNo['+value.id+']" class="form-control ordering" min="1" required="required" value="'+value.itemNo+'" /></td>');
            input_html.push('  <td>' + value.standard_detail + '</td>');
            input_html.push('</tr>');

            $('#table-detail' + Autono).children('tbody').append(input_html.join('')); //นำรายการไปแสดงในรายการ

          });

        });

  }

  //เช็คข้อมูลก่อนบันทึก
  function beforeSubmit(){

      event.preventDefault();

      var all_result = true;

      //วนรอบตารางมาตรฐาน
      $('.table-detail').each(function(table_order, table) {

          var tmps = Array();
          var result = true;

          //วนรอบรายละเอียดผลิตภัณฑ์
          $(table).find('.ordering').each(function(index, ordering) {

            if(tmps.includes($(ordering).val())){

                $(".alertbottom").fadeIn(350);
                $(ordering).focus();
                $(ordering).select();
                result = false;
                return result;
            }else{
                tmps.push($(ordering).val());
            }

          });

          if(result==false){
            all_result = false;
            return false;
          }

      });

      return all_result;

  }

</script>
@endpush
