@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<style type="text/css">

  .margin-m8{
    margin-top: -8px;
  }

  .margin-p8{
    margin-top: 8px;
  }

  .fileinput{
    margin-bottom: 0px;
  }

</style>
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
      <div class="col-md-8">
        <div class="checkbox checkbox-success">
          <input id="license-all" class="license-all" type="checkbox">
          <label for="license-all"> เลือกทั้งหมด <span class="text-muted">(กรณีมี 1 โรงงาน)</span> </label>
        </div>
      </div>
    </div>

    <div class="row license-list">
      <!-- แสดงเลขที่ใบอนุญาต -->
      @foreach ($own_licenses as $key => $own_license)

      <div class="col-md-4">
        <div class="checkbox checkbox-success">
          <input name="tbl_licenseNo[]" id="license{{ $own_license->Autono }}" data-license="{{ $own_license->Autono }}" data-factory_name="{{ $own_license->tbl_factoryName }}" data-factory_address="{{ $own_license->tbl_factoryAddress }}" class="license-item" type="checkbox" value="{{ $own_license->tbl_licenseNo }}" @if(array_search($own_license->tbl_licenseNo, $inform_change_licenses)) checked="checked" @endif>
          <label for="license{{ $own_license->Autono }}"> {{ $own_license->tbl_licenseNo }} </label>
        </div>
      </div>

      @endforeach

    </div>

    {!! $errors->first('license', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">โรงงาน:</label>
  <div class="col-md-6" id="factory-box">
    <!-- แสดงชื่อโรงงานและที่อยู่ -->
  </div>
</div>

<div class="table-responsive">

  <table class="table color-bordered-table info-bordered-table" id="table-detail">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th class="col-md-2 text-center">ชื่อเครื่องมือ</th>
        <th class="col-md-4 text-center">รายการที่ใช้วัด</th>
        <th class="col-md-2 text-center">วันที่สอบเทียบ</th>
        <th class="col-md-3 text-center">
          ผลการสอบเทียบ
          <div class="text-warning">รองรับไฟล์ .pdf และ .jpg ขนาดไม่เกิน {{ ini_get('upload_max_filesize') }}B</div>
        </th>
        <th class="text-center">ลบ</th>
      </tr>
    </thead>
    <tbody>

      @foreach ($inform_details as $key => $inform_detail)
        <tr>
          <td>1.</td>
          <td>
            <input type="text" name="tool[]" class="form-control" value="{{ $inform_detail->tool }}" />
          </td>
          <td class="td-detail">
            @foreach (json_decode($inform_detail->detail) as $key_detail => $detail)

              <div class="col-md-12">
                <div class="pull-left margin-p8">{{ $key_detail+1 }}.&nbsp;</div>
                <div class="pull-left">
                  <input type="text" name="detail[{{ $key }}][]" class="form-control" value="{{ $detail }}" />
                </div>
                <div class="pull-left" style="margin-left:5px;">
                  <button class="btn btn-success btn-sm add-detail" type="button">
                    <i class="icon-plus"></i>
                  </button>
                </div>
              </div>

            @endforeach

          </td>
          <td>
            <input type="text" name="exam_date[]" class="form-control mydatepicker" value="{{ HP::revertDate($inform_detail->exam_date) }}" />
          </td>
          <td>
            {{-- แนบไฟล์ --}}
            <div class="td-file">

              <div class="col-md-12">

                <div class="fileinput fileinput-new input-group pull-left col-md-8" data-provides="fileinput">
                  <div class="form-control" data-trigger="fileinput">
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                    <span class="fileinput-filename"></span>
                  </div>
                  <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">เลือกไฟล์</span>
                    <span class="fileinput-exists">เปลี่ยน</span>
                    {{-- {!! Form::file('attach_result[{{ $key }}][]', null) !!} --}}
                    <input type="file" name="attach_result[{{ $key }}][]" class="check_max_size_file">
                  </span>
                  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                </div>

                <div class="pull-left col-md-4">
                  <button type="button" class="btn btn-sm btn-success add-attach">
                    <i class="icon-plus"></i>
                  </button>
                </div>

              </div>

            </div>

            {{-- ดูไฟล์ --}}
            <div class="col-md-12 file-view">
              @foreach (json_decode($inform_detail->attach_result) as $attach_result)
                @if(HP::checkFileStorage($attach_path.$attach_result->file_name))
                  <div class="col-md-12">
                    <button class="btn btn-danger btn-sm remove-file pull-right" type="button">
                      <i class="icon-close"></i>
                    </button>
                    <a href="{{ HP::getFileStorage($attach_path.$attach_result->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm pull-right"><i class="fa fa-search"></i></a>
                    <input type="hidden" name="attach_file[{{ $key }}][]" value="{{ $attach_result->file_name }}" />
                  </div>
                @endif
              @endforeach
            </div>

          </td>

          <td class="text-center">
            <button class="btn btn-danger btn-sm margin-m8 remove-list" type="button">
              <i class="icon-close"></i>
            </button>
          </td>
        </tr>
      @endforeach

    </tbody>
  </table>

  <button id="add-list" class="btn btn-success waves-effect waves-light pull-right" type="button"><span class="btn-label"><i class="fa fa-plus"></i></span>เพิ่มเครื่องมือ</button>

</div>

<div class="form-group {{ $errors->has('applicant_name') ? 'has-error' : ''}}">
  {!! Form::label('applicant_name', 'ผู้ติดต่อ', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('applicant_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('applicant_name', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
  {!! Form::label('tel', 'เบอร์โทร', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('tel', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
  {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::text('email', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
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

    <button class="btn btn-primary" type="submit" onclick="ShowHideRemoveBtn();">
      <i class="fa fa-paper-plane"></i> บันทึก
    </button>
    @can('view-'.str_slug('inform_calibrate'))
    <a class="btn btn-default" href="{{url('/esurv/inform_calibrate')}}">
      <i class="fa fa-rotate-left"></i> ยกเลิก
    </a>
    @endcan
  </div>
</div>

@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
<!-- input calendar -->
<script src="{{ asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!-- input file -->
<script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function() {
      check_max_size_file();
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

      ShowHideFactory();

      if ($(this).val() != "") { //ถ้าเลือกใบอนุญาต

        $.ajax("{{ url('basic/license-list') }}/" + $(this).val())
          .done(function(data) {

            $.each(data, function(key, value) {

              var input_html = [];
              input_html.push('<div class="col-md-4">');
              input_html.push('  <div class="checkbox checkbox-success">');
              input_html.push('   <input name="tbl_licenseNo[]" id="license' + value.Autono + '" data-license="' + value.Autono + '" data-license_type="' + value.tbl_licenseType + '" data-factory_name="' + value.tbl_factoryName + '" data-factory_address="' + value.tbl_factoryAddress + '" class="license-item" type="checkbox" value="' + value.tbl_licenseNo + '">');
              input_html.push('   <label for="license' + value.Autono + '"> ' + value.tbl_licenseNo + ' </label>');
              input_html.push('  </div>');
              input_html.push('</div>');

              $(".license-list").append(input_html.join(''));

            });

          });

      }

    });

    //เลือกใบอนุญาตทั้งหมด
    $('.license-all').change(function(event) {

      if ($(this).prop('checked')) { //ถ้าเลือก
        $('.license-item').prop('checked', true);
      } else { //ถ้าไม่เลือก
        $('.license-item').prop('checked', false);
      }

      ShowHideFactory();//ซ่อนแสดงชื่อโรงงานตามใบอนุญาต

    });

    //เลือกใบอนุญาต
    $('body').on('click', '.license-item', function(){

      ShowHideFactory();//ซ่อนแสดงชื่อโรงงานตามใบอนุญาต

    });
    check_max_size_file();
    //เพิ่มรายการที่ใช้วัด
    $('body').on('click', '.add-detail', function(){

      var first = $(this).parent().parent();
      var td = $(this).parent().parent().parent();

      $(first).clone().appendTo(td); //Clone Element

      //Edit Last
      var last_button = $(td).children(':last').find('button');
      $(last_button).removeClass('btn-success');
      $(last_button).removeClass('add-detail');
      $(last_button).addClass('btn-danger remove-detail');
      $(last_button).html('<i class="icon-close"></i>');

      $(td).children(':last').find('div:first').html($(td).children().length+'.&nbsp;');
      check_max_size_file();
    });

    //ลบรายการที่ใช้วัด
    $('body').on('click', '.remove-detail', function(){

      var td = $(this).parent().parent().parent();
      $(this).parent().parent().remove();

      //reset number
      $(td).children().each(function(index, el) {
        $(el).find('div:first').html((index+1)+'.&nbsp;');
      });

    });

    //เพิ่มไฟล์แนบ
    $('body').on('click', '.add-attach', function() {

      var first = $(this).parent().parent();
      var td = $(this).parent().parent().parent();

      $(first).clone().appendTo(td); //Clone Element

      //Edit Last
      var last_button = $(td).children(':last').find('button');
      $(last_button).removeClass('btn-success');
      $(last_button).removeClass('add-attach');
      $(last_button).addClass('btn-danger remove-attach');
      $(last_button).html('<i class="icon-close"></i>');

      var last_file = $(td).children(':last').find('.fileinput');
      $(last_file).find('input').val('');
      $(last_file).find('a.fileinput-exists').click();
      $(last_file).find('a.view-attach').remove();
      check_max_size_file();
    });

    //ลบไฟล์แนบ
    $('body').on('click', '.remove-attach', function() {

      var td = $(this).parent().parent().parent();
      $(this).parent().parent().remove();

    });

    //ลบไฟล์แนบที่เคยบันทึกไว้ที่เซิร์ฟเวอร์
    $('body').on('click', '.remove-file', function() {
      $(this).parent().remove();
    })

    //กดเพิ่มรายการ
    $('#add-list').click(function(){

      var tbody = $(this).prev('table').children('tbody');

      $(tbody).children('tr:first').clone().appendTo(tbody); // Clone Row

      //calendar
      $('.mydatepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
      });

      var last_new = $(tbody).children(':last');

      //input file
      var last_file = $(last_new).find('.fileinput');
      $(last_file).find('input').val('');
      $(last_file).find('a.fileinput-exists').click();
      $(last_file).find('a.view-attach').remove();

      //ลบรายการย่อยที่มีมากกว่า 1
      $(last_new).find('.td-detail').children(':not(:first)').remove();
      $(last_new).find('.td-file').children(':not(:first)').remove();

      //ลบปุ่มดูไฟล์เดิม
      $(last_new).find('.file-view').remove();

      //Clear Value
      $(last_new).find('input').val('');

      ShowHideRemoveBtn();
      check_max_size_file();

    });

    //กดลบรายการ
    $('body').on('click', '.remove-list', function() {
      $(this).parent().parent().remove();
      ShowHideRemoveBtn();
    });

    ShowHideRemoveBtn();

    ShowHideFactory();//ซ่อนแสดงชื่อโรงงานตามใบอนุญาต

  });

  function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

    if ($('.remove-list').length > 1) {
      $('.remove-list').show();
    } else {
      $('.remove-list').hide();
    }

    //รีเซตลำดับ
    $('#table-detail tbody').children().each(function(index, el) {
      $(el).children(':first').text((index+1)+'.');//#
      $(el).find('input[type="text"][name*="detail"]').prop('name', 'detail['+index+'][]');//รายการที่ใช้วัด
      $(el).find('input[type="file"]').prop('name', 'attach_result['+index+'][]');//ผลการสอบเทียบ
      $(el).find('input[type="hidden"][name*="attach_file"]').prop('name', 'attach_file['+index+'][]');//ไฟล์ที่เคยบันทึกไว้

    });

  }

  //ซ่อนแสดงชื่อโรงงานตามใบอนุญาต
  function ShowHideFactory(){

    $('#factory-box').html('');

    if($('.license-item:checked').length>0){

      var factorys = Array();

      $('#factory-box').parent().show();
      $('.license-item:checked').each(function(index, item) {

        var option = '<p class="form-control-static">' + $(item).attr('data-factory_name') + ' ' + $(item).attr('data-factory_address') + '</p>';

        if(factorys.includes(option)===false){
          factorys.push(option);
          $('#factory-box').append(option);
        }

      });

    }else{
      $('#factory-box').parent().hide();
    }

  }

</script>
@endpush
