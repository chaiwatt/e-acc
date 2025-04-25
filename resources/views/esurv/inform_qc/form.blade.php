@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<!-- select2 -->
<link href="{{asset('plugins/components/custom-select/custom-select.css')}}" rel="stylesheet" type="text/css" />
@endpush

<div class="form-group {{ $errors->has('tb3_Tisno') ? 'has-error' : ''}}">
  {!! Form::label('tb3_Tisno', 'มาตรฐาน', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::select('tb3_Tisno', HP::OwnTisList(), null, ['class' => 'form-control tis select2', 'required' => 'required', 'placeholder'=>'-เลือกมาตรฐาน-']); !!}
    {!! $errors->first('tb3_Tisno', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('license') ? 'has-error' : ''}}">
  {!! Form::label('license', 'ใบอนุญาต', ['class' => 'col-md-4 control-label required']) !!}
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
          <input name="tbl_licenseNo[]" id="license{{ $own_license->Autono }}" data-license="{{ $own_license->Autono }}" class="license-item" type="checkbox" value="{{ $own_license->tbl_licenseNo }}" @if(array_search($own_license->tbl_licenseNo, $inform_qc_licenses)) checked="checked" @endif>
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
    <!-- แสดงชื่อโรงงานรายการในใบอนุญาต -->

    @foreach ($own_licenses as $key => $own_license)

      @php
        $search_key = array_search($own_license->tbl_licenseNo, $inform_qc_licenses);
      @endphp

      @if($search_key===false)
        @continue
      @endif

      <div class="col-md-12 detail-item" id="detail{{ $own_license->Autono }}" style="border: #00bbd9 1px solid; padding-bottom: 15px; margin-top:2px;">
        <h5><span class="order">{{ $key+1 }}</span>. ใบอนุญาตเลขที่ <span class="text-info">{{ $own_license->tbl_licenseNo }}</span></h5>
        <div class="table-responsive">
          <table class="table color-bordered-table dark-bordered-table" id="table-detail{{ $own_license->Autono }}" style="margin-bottom: 10px;">
            <thead>
              <tr>
                <th class="col-md-1 text-center">#</th>
                <th class="col-md-2 text-center">ชื่อโรงงงาน</th>
                <th class="col-md-2 text-center">ที่ตั้ง</th>
                <th class="col-md-2 text-center">ผลการประเมิน QC</th>
                <th class="col-md-2 text-center">ผู้ตรวจประเมิน</th>
                <th class="col-md-1 text-center">วันที่ตรวจ</th>
                <th class="col-md-2 text-center">รายละเอียด</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($inform_qc_details[$search_key] as $key => $detail)
                <tr>
                  <td class="text-center text-top">{{ $key+1 }}.</td>
                  <td class="text-top">
                    <input type="hidden" name="detail_id[{{ $own_license->Autono }}][]" value="{{ $detail->id }}" />
                    <input class="form-control" placeholder="กรอกชื่อโรงงาน" name="factory_name[{{ $own_license->Autono }}][]" type="text" value="{{ $detail->factory_name }}">
                  </td>
                  <td class="text-top">
                    <input class="form-control" placeholder="กรอกที่ตั้งโรงงาน" name="factory_address[{{ $own_license->Autono }}][]" type="text" value="{{ $detail->factory_address }}">
                  </td>
                  <td class="text-top">
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput" style="margin-bottom:0px;">
                      <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                      </div>
                      <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">เลือกไฟล์</span>
                        <span class="fileinput-exists">เปลี่ยน</span>
                        <input name="result_attach[{{ $own_license->Autono }}][]" type="file">
                      </span>
                    </div>

                    @php
                      $result_attach = json_decode($detail->result_attach);
                    @endphp

                    @if (is_file(public_path().'/esurv_attach/inform_qc_detail/'.@$result_attach->file_name))
                      <a href="{{ asset('esurv_attach/inform_qc_detail/'.$result_attach->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm pull-right"><i class="fa fa-search"></i></a>
                    @endif

                  </td>
                  <td class="text-top">
                    {!! Form::select('inspector['.$own_license->Autono.'][]', ['NULL'=>'อื่นๆ'], is_null($detail->inspector)?'NULL':$detail->inspector, ['class'=>'form-control', 'placeholder'=>'-เลือก-']) !!}
                    <input type="text" class="form-control inspector_other {{ is_null($detail->inspector)?'':'hide' }}" name="inspector_other[{{ $own_license->Autono }}][]" value="{{ $detail->inspector_other }}" placeholder="กรอกผู้ตรวจประเมิน"/>
                  </td>
                  <td class="text-top">
                    <input name="check_date[{{ $own_license->Autono }}][]" class="form-control mydatepicker" placeholder="yyyy/mm/dd" autocomplete="off" type="text" value="{{ !is_null($detail->check_date)?HP::revertDate($detail->check_date):'' }}">
                  </td>
                  <td class="text-top">
                    <input name="detail[{{ $own_license->Autono }}][]" class="form-control" type="text" value="{{ $detail->detail }}">

                    @if($key>0)
                      <button class="btn btn-danger btn-sm pull-right remove-factory" type="button" style="display: inline-block;">
                        <i class="icon-close"></i>
                      </button>
                    @endif

                  </td>
                </tr>
              @endforeach

            </tbody>
          </table> <button class="btn btn-success waves-effect waves-light add-factory" type="button"><span class="btn-label"><i class="fa fa-plus"></i></span>เพิ่มโรงงาน</button>
        </div>
      </div>

      @endforeach
  </div>

</div>

<div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
  {!! Form::label('remark', 'หมายเหตุ', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::textarea('remark', null, ['class' => 'form-control', 'rows'=>'2']) !!}
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('attach', 'ไฟล์แนบเอกสารที่เกี่ยวข้อง:', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-8">
    <button type="button" class="btn btn-sm btn-success" id="attach-add">
      <i class="icon-plus"></i>&nbsp;เพิ่ม
    </button>
  </div>
</div>

<div id="other_attach-box">

  @foreach ($attachs as $key => $attach)

  <div class="form-group other_attach_item">
    <div class="col-md-4">
      {!! Form::hidden('attach_filenames[]', $attach->file_name); !!}
    </div>
    <div class="col-md-3">
      {!! Form::text('attach_notes[]', $attach->file_note, ['class' => 'form-control', 'placeholder' => 'คำอธิบายไฟล์แนบ(ถ้ามี)']) !!}
    </div>
    <div class="col-md-3">

      <div class="fileinput fileinput-new input-group" data-provides="fileinput">
        <div class="form-control" data-trigger="fileinput">
          <i class="glyphicon glyphicon-file fileinput-exists"></i>
          <span class="fileinput-filename"></span>
        </div>
        <span class="input-group-addon btn btn-default btn-file">
          <span class="fileinput-new">เลือกไฟล์</span>
          <span class="fileinput-exists">เปลี่ยน</span>
          {!! Form::file('attachs[]', null) !!}
        </span>
        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
      </div>
      {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-2">

      @if (is_file(public_path().'/esurv_attach/inform_qc/'.$attach->file_name))
      <a href="{{ asset('esurv_attach/inform_qc/'.$attach->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
      @endif

      <button class="btn btn-danger btn-sm attach-remove" type="button">
        <i class="icon-close"></i>
      </button>

    </div>

  </div>

  @endforeach

</div>

<div class="form-group {{ $errors->has('applicant_name') ? 'has-error' : ''}}">
  {!! Form::label('applicant_name', 'ชื่อผู้บันทึก', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('applicant_name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('applicant_name', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
  {!! Form::label('tel', 'เบอร์โทร', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('tel', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
  {!! Form::label('email', 'E-mail', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::text('email', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
  {!! Form::label('state', 'สถานะ', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    <label>{!! Form::radio('state', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} ส่งข้อมูลให้สมอ.</label>
    <label>{!! Form::radio('state', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} ฉบับร่าง</label>

    {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-offset-4 col-md-4">

    <button class="btn btn-primary" type="submit">
      <i class="fa fa-paper-plane"></i> บันทึก
    </button>
    @can('view-'.str_slug('inform_qc'))
    <a class="btn btn-default" href="{{url('/esurv/inform_qc')}}">
      <i class="fa fa-rotate-left"></i> ยกเลิก
    </a>
    @endcan
  </div>
</div>

@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
<!-- input file -->
<script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
<!-- input calendar -->
<script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!-- select2 -->
<script src="{{ asset('plugins/components/custom-select/custom-select.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {

    //Select2
    $(".select2").select2();

    //ปฎิทิน
    $('.mydatepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      format: 'dd/mm/yyyy'
    });

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
              input_html.push('   <input name="tbl_licenseNo[]" id="license' + value.Autono + '" data-license="' + value.Autono + '" data-license_type="' + value.tbl_licenseType + '" class="license-item" type="checkbox" value="' +
                value.tbl_licenseNo + '">');
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

          var input_html = [];
          input_html.push('<div class="col-md-12 detail-item" id="detail' + $(this).attr('data-license') + '" style="border: #00bbd9 1px solid; padding-bottom: 15px; margin-top:2px;">');
          input_html.push('  <h5><span class="order">' + (amount_row + 1) + '</span>. ใบอนุญาตเลขที่ <span class="text-info">' + $(this).val() + '</span></h5>');
          input_html.push('</div>');

          $('.license-detail').append(input_html.join('')); //เพิ่มรายการ

          getLicenseDetail($(this).attr('data-license')); //แสดงตารางรายละเอียดผลิตภัณฑ์

        }

      } else { //เมื่อไม่เลือก

        $('#detail' + $(this).attr('data-license')).remove(); //ลบ element

        $('.license-detail').children('').each(function(index, el) { //รีเซตเลขลำดับ
          $(el).find('.order').text(index + 1);
        });
      }

    });

    //เพิ่มโรงงาน
    $('body').on('click', '.add-factory', function(event) {

      var tbody = $(this).prev('table').children('tbody');

      $(tbody).children('tr:first').clone().appendTo(tbody); // Clone Row

      var number = $(tbody).children().length;

      //Clear Value
      $(tbody).children('tr:last').find('input').val('');
      $(tbody).children('tr:last').find('i.fileinput-exists').hide();
      $(tbody).children('tr:last').find('span.fileinput-filename').text(''); //Clear File
      $(tbody).children('tr:last').find('td:first').text(number + '.'); //เลขลำดับ
      $(tbody).children('tr:last').find('td:last').append('<button class="btn btn-danger btn-sm pull-right remove-factory" type="button" style="display: inline-block;"><i class="icon-close"></i></button>'); //ปุ่มลบ
      $(tbody).children('tr:last').find('a.view-attach').remove(); //ลบปุ่มดูภาพ
      $(tbody).children('tr:last').find('input.inspector_other').hide(); //ซ่อนช่องกรอกผู้ประเมินอื่นๆ

      //ปฎิทิน
      jQuery('.mydatepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
      });

    });

    //ลบโรงงาน
    $('body').on('click', '.remove-factory', function(event) {

      var tbody = $(this).parent().parent().parent();

      $(this).parent().parent().remove();

      $(tbody).children('tr').each(function(index, el) {
        $(el).find('td:first').text((index + 1) + '.'); //เลขลำดับ
      });

    });

    //เมื่อเลือกผู้ตรวจประเมิน
    $('body').on('change', '.inspector', function(event) {

      if($(this).val()=='NULL'){//เลือกอื่น
        $(this).parent().find('.inspector_other').removeClass('hide');
        $(this).parent().find('.inspector_other').show();
      }else{
        $(this).parent().find('.inspector_other').hide();
      }

    });

    //เพิ่มไฟล์แนบ
    $('#attach-add').click(function(event) {
      $('.other_attach_item:first').clone().appendTo('#other_attach-box');

      $('.other_attach_item:last').find('input').val('');
      $('.other_attach_item:last').find('a.fileinput-exists').click();
      $('.other_attach_item:last').find('a.view-attach').remove();

      ShowHideRemoveBtn();
    });

    //ลบไฟล์แนบ
    $('body').on('click', '.attach-remove', function(event) {
      $(this).parent().parent().remove();
      ShowHideRemoveBtn();
    });

    ShowHideRemoveBtn();

  });

  function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

    if ($('.other_attach_item').length > 1) {
      $('.attach-remove').show();
    } else {
      $('.attach-remove').hide();
    }

  }

  function getLicenseDetail(Autono) { //ดึงรายละเอียดผลิตภัณฑ์

    var table_html = [];
    table_html.push('<div class="table-responsive">');
    table_html.push('  <table class="table color-bordered-table dark-bordered-table" id="table-detail' + Autono + '" style="margin-bottom: 10px;">');
    table_html.push('    <thead>');
    table_html.push('      <tr>');
    table_html.push('        <th class="col-md-1 text-center">#</th>');
    table_html.push('        <th class="col-md-2 text-center">ชื่อโรงงงาน</th>');
    table_html.push('        <th class="col-md-2 text-center">ที่ตั้ง</th>');
    table_html.push('        <th class="col-md-2 text-center">ผลการประเมิน QC</th>');
    table_html.push('        <th class="col-md-2 text-center">ผู้ตรวจประเมิน</th>');
    table_html.push('        <th class="col-md-1 text-center">วันที่ตรวจ</th>');
    table_html.push('        <th class="col-md-2 text-center">รายละเอียด</th>');
    table_html.push('      </tr>');
    table_html.push('    </thead>');
    table_html.push('    <tbody>');
    table_html.push('    </tbody>');
    table_html.push('  </table>');
    table_html.push('  <button class="btn btn-success waves-effect waves-light add-factory" type="button"><span class="btn-label"><i class="fa fa-plus"></i></span>เพิ่มโรงงาน</button>');
    table_html.push('</div>');

    //แสดงตารางรายละเอียดผลิตภัณ์
    $('#detail' + Autono).append(table_html.join(''));

    //ดึงรายละเอียดผลิตภัณฑ์
    $.ajax("{{ url('basic/license-item') }}/" + Autono)
      .done(function(data) {

        if (data) {

          var input_html = [];
          input_html.push('<tr>');
          input_html.push('  <td class="text-center text-top">1.</td>');
          input_html.push('  <td class="text-top"><input class="form-control" placeholder="กรอกชื่อโรงงาน" name="factory_name[' + Autono + '][]" type="text" value="' + data.tbl_factoryName + '"></td>');
          input_html.push('  <td class="text-top"><input class="form-control" placeholder="กรอกที่ตั้งโรงงาน" name="factory_address[' + Autono + '][]" type="text" value="' + data.tbl_factoryAddress + '"></td>');
          input_html.push('  <td class="text-top">');
          input_html.push('    <div class="fileinput fileinput-new input-group" data-provides="fileinput">');
          input_html.push('      <div class="form-control" data-trigger="fileinput">');
          input_html.push('        <i class="glyphicon glyphicon-file fileinput-exists"></i>');
          input_html.push('        <span class="fileinput-filename"></span>');
          input_html.push('      </div>');
          input_html.push('      <span class="input-group-addon btn btn-default btn-file">');
          input_html.push('        <span class="fileinput-new">เลือกไฟล์</span>');
          input_html.push('        <span class="fileinput-exists">เปลี่ยน</span>');
          input_html.push('        <input name="result_attach[' + Autono + '][]" type="file">');
          input_html.push('      </span>');
          input_html.push('    </div>');
          input_html.push('  </td>');
          input_html.push('  <td class="text-top">');
          input_html.push('    <select name="inspector[' + Autono + '][]" class="form-control inspector"><option value="">-เลือก-</option><option value="NULL">อื่นๆ</option></select>');
          input_html.push('    <input type="text" class="form-control inspector_other hide" name="inspector_other[' + Autono + '][]" placeholder="กรอกผู้ตรวจประเมิน" />');
          input_html.push('  </td>');
          input_html.push('  <td class="text-top"><input name="check_date[' + Autono + '][]" class="form-control mydatepicker" placeholder="yyyy/mm/dd" autocomplete="off" type="text"></td>');
          input_html.push('  <td class="text-top"><input name="detail[' + Autono + '][]" class="form-control" type="text" value=""></td>');
          input_html.push('</tr>');

          $('#table-detail' + Autono).children('tbody').append(input_html.join('')); //นำรายการไปแสดงในรายการ

          //ปฎิทิน
          jQuery('.mydatepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy'
          });

        }

      });

  }
</script>

@endpush
