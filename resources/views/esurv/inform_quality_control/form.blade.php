@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

<div class="form-group {{ $errors->has('tb3_Tisno') ? 'has-error' : ''}}">
  {!! Form::label('tb3_Tisno', 'มาตรฐาน:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::select('tb3_Tisno', HP::OwnTisList(), null, ['class' => 'form-control tis select2', 'required' => 'required', 'placeholder'=>'-เลือกมาตรฐาน-']); !!}
    {!! $errors->first('tb3_Tisno', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('license') ? 'has-error' : ''}}">
  {!! Form::label('license', 'ใบอนุญาต:', ['class' => 'col-md-4 control-label required']) !!}
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
          <input name="tbl_licenseNo[]"
                 id="license{{ $own_license->Autono }}"
                 data-license="{{ $own_license->Autono }}"
                 data-factory_name="{{ $own_license->tbl_factoryName }}"
                 data-factory_address="{{ $own_license->tbl_factoryAddress }}"
                 class="license-item"
                 type="checkbox"
                 value="{{ $own_license->tbl_licenseNo }}"
                 @if(array_search(trim($own_license->tbl_licenseNo), $inform_qc_licenses))
                   checked="checked"
                 @endif>
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

<div class="form-group {{ $errors->has('check_date') ? 'has-error' : ''}}">
  {!! Form::label('check_date', 'วันที่ตรวจ (ผ่าน):', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('check_date', null, ['class' => 'form-control mydatepicker', 'required' => 'required', 'placeholder' => 'dd/mm/yyyy']) !!}
    {!! $errors->first('check_date', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('inspector') ? 'has-error' : ''}}">
  {!! Form::label('inspector', 'ผู้ตรวจประเมิน:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::select('inspector', HP::InspectorList(['1'])+['NULL'=>'อื่นๆ'], null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'-เลือกผู้ตรวจประเมิน-']) !!}
    {!! $errors->first('inspector', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('inspector_other') ? 'has-error' : ''}}" id="box-inspector_other">
  {!! Form::label('inspector_other', ' ', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::text('inspector_other', null, ['class' => 'form-control', 'placeholder'=>'กรอกผู้ตรวจประเมิน']) !!}
    {!! $errors->first('inspector_other', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  {!! Html::decode(Form::label('attach', 'ผลการตรวจประเมิน:<br><span class="text-muted">รองรับไฟล์ .pdf และ .jpg ขนาดไม่เกิน 10 MB</span>', ['class' => 'col-md-4 control-label'])) !!}
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
             {{-- {!! Form::file('attachs[]', null) !!} --}}
             <input type="file" name="attachs[]" class="check_max_size_file">
        </span>
        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
      </div>
      {!! $errors->first('attachs', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-2">

      @if($attach->file_name!='' && HP::checkFileStorage($attach_path.$attach->file_name))
        <a href="{{ HP::getFileStorage($attach_path.$attach->file_name) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
      @endif

      <button class="btn btn-danger btn-sm attach-remove" type="button">
        <i class="icon-close"></i>
      </button>

    </div>

  </div>

  @endforeach

</div>

<div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
  {!! Form::label('detail', 'รายละเอียด (ถ้ามี):', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::textarea('detail', null, ['class' => 'form-control', 'rows'=>2]) !!}
    {!! $errors->first('detail', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('applicant_name') ? 'has-error' : ''}}">
  {!! Form::label('applicant_name', 'ชื่อผู้บันทึก:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('applicant_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('applicant_name', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
  {!! Form::label('tel', 'เบอร์โทร:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('tel', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
  {!! Form::label('email', 'E-mail:', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
  {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
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
    @can('view-'.str_slug('inform_quality_control'))
    <a class="btn btn-default" href="{{url('/esurv/inform_quality_control')}}">
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
<script type="text/javascript">

  $(document).ready(function() {

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
              input_html.push('   <input name="tbl_licenseNo[]" id="license' + value.Autono + '" data-license="' + value.Autono + '" data-license_type="' + value.tbl_licenseType + '" data-factory_name="' + value.tbl_factoryName + '" data-factory_address="' + value.tbl_factoryAddress + '" class="license-item" type="checkbox" value="' +
                value.tbl_licenseNo + '">');
              input_html.push('   <label for="license' + value.Autono + '"> ' + value.tbl_licenseNo + ' </label>');
              input_html.push('  </div>');
              input_html.push('</div>');

              $(".license-list").append(input_html.join(''));

            });

          });

      }

    });

    //เมื่อเลือกผู้ตรวจ
    $('#inspector').change(function(event) {
      if($(this).val()=='NULL'){
        $('#box-inspector_other').show();
      }else{
        $('#box-inspector_other').hide();
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
    //เพิ่มไฟล์แนบ
    $('#attach-add').click(function(event) {
      $('.other_attach_item:first').clone().appendTo('#other_attach-box');

      $('.other_attach_item:last').find('input').val('');
      $('.other_attach_item:last').find('a.fileinput-exists').click();
      $('.other_attach_item:last').find('a.view-attach').remove();

      ShowHideRemoveBtn();
      check_max_size_file();
    });

    //ลบไฟล์แนบ
    $('body').on('click', '.attach-remove', function(event) {
      $(this).parent().parent().remove();
      ShowHideRemoveBtn();
    });

    $('#inspector').change();

    ShowHideRemoveBtn();

    ShowHideFactory();//ซ่อนแสดงชื่อโรงงานตามใบอนุญาต

  });

  function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

    if ($('.other_attach_item').length > 1) {
      $('.attach-remove').show();
    } else {
      $('.attach-remove').hide();
    }

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
