@push('css')
<link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endpush

<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
  {!! Form::label('title', 'เรื่อง:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('inform_type') ? 'has-error' : ''}}">
  {!! Form::label('inform_type', 'ประเภทการแจ้ง:', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::select('inform_type', HP::OtherTypes(), null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => '-เลือกประเภทการแจ้ง-']) !!}
    {!! $errors->first('inform_type', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
  {!! Form::label('detail', 'รายละเอียด:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::textarea('detail', null, ['class' => 'form-control', 'required' => 'required', 'rows'=>'3']) !!}
    {!! $errors->first('detail', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('tb3_Tisno') ? 'has-error' : ''}}">
  {!! Form::label('tb3_Tisno', 'มาตรฐาน (ถ้ามี):', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::select('tb3_Tisno[]', HP::TisList(), null, ['class' => 'select2 select2-multiple', 'multiple' => 'multiple', 'data-placeholder'=>'- เลือกมาตรฐาน -']) !!}
    {!! $errors->first('tb3_Tisno', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  {!! Html::decode(Form::label('attach', 'ไฟล์แนบ (ถ้ามี):<br><span class="text-muted">รองรับไฟล์ .pdf และ .jpg ขนาดไม่เกิน 10 MB</span>', ['class' => 'col-md-4 control-label'])) !!}
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

<div class="form-group {{ $errors->has('applicant_name') ? 'has-error' : ''}}">
  {!! Form::label('applicant_name', 'ชื่อผู้บันทึก:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('applicant_name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('applicant_name', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
  {!! Form::label('tel', 'เบอร์โทร:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::text('tel', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('tel', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
  {!! Form::label('email', 'Email:', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group data_hide{{ $errors->has('state') ? 'has-error' : ''}}">
  {!! Form::label('state', 'สถานะ:', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    <label>{!! Form::radio('state', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} ส่งข้อมูลให้ สมอ.</label>
    <label>{!! Form::radio('state', '0', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} ฉบับร่าง</label>

    {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-offset-4 col-md-4">

    <button class="btn btn-primary" type="submit">
      <i class="fa fa-paper-plane"></i> บันทึก
    </button>
    @can('view-'.str_slug('other'))
    <a class="btn btn-default data_hide" href="{{url('/esurv/other')}}">
      <i class="fa fa-rotate-left"></i> ยกเลิก
    </a>
    @endcan
  </div>
</div>

@push('js')

<!-- icheck -->
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>

<!-- input file -->
<script src="{{ asset('js/jasny-bootstrap.js') }}"></script>

<script type="text/javascript">

  $(document).ready(function() {
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

    ShowHideRemoveBtn();

  });

  function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

    if ($('.other_attach_item').length > 1) {
      $('.attach-remove').show();
    } else {
      $('.attach-remove').hide();
    }

  }

</script>
@endpush
