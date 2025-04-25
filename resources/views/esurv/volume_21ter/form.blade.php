@push('css')
  <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush

<div class="form-group {{ $errors->has('applicant_21ter_id') ? 'has-error' : ''}}">
  {!! Form::label('applicant_21ter_id', 'เลขที่คำขออ้างอิง:', ['class' => 'col-md-3 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::select('applicant_21ter_id',
                      $applicant_21ters->pluck('ref_no', 'id'),
                      null,
                      ['class' => 'select2 form-control', 'required' => 'required', 'placeholder'=>'- เลือกเลขที่คำขอ -'])
    !!}
    {!! $errors->first('applicant_21ter_id', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('title', 'ชื่อผลิตภัณฑ์:', ['class' => 'col-md-3 control-label required']) !!}
  <div class="col-md-3">
    <input type="text" class="form-control" id="show-title" disabled="disabled" value="{{ @$applicant_21ters->pluck('title', 'id')[@$volume_21ter->applicant_21ter_id] }}">
  </div>

    {!! Form::label('title', 'แผนการนำเข้า:', ['class' => 'col-md-2 control-label required']) !!}

  <div class="col-md-3">
    <input type="text" class="form-control" id="show-import_date" disabled="disabled"
          value="{{ !empty($applicant_21ters->pluck('start_import_date'))?HP::DateThai(@$applicant_21ters->pluck('start_import_date', 'id')[@$volume_21ter->applicant_21ter_id]):'n/a' }} - {{ !empty($applicant_21ters->pluck('end_import_date'))?HP::DateThai(@$applicant_21ters->pluck('end_import_date', 'id')[@$volume_21ter->applicant_21ter_id]):'n/a' }}
          ">
  </div>
</div>

<div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
  {!! Form::label('start_date', 'แผนการผลิต:', ['class' => 'col-md-3 control-label required']) !!}
  <div class="col-md-3">
     <input type="text" class="form-control" id="show-date" disabled="disabled"
            value="{{ !empty($applicant_21ters->pluck('start_date'))?HP::DateThai(@$applicant_21ters->pluck('start_date', 'id')[@$volume_21ter->applicant_21ter_id]):'n/a' }} - {{ !empty($applicant_21ters->pluck('end_date'))?HP::DateThai(@$applicant_21ters->pluck('end_date', 'id')[@$volume_21ter->applicant_21ter_id]):'n/a' }}
            ">
  </div>

    {!! Form::label('title', 'แผนการส่งออก:', ['class' => 'col-md-2 control-label required']) !!}

  <div class="col-md-3">
    <input type="text" class="form-control" id="show-export_date" disabled="disabled"
            value="{{ !empty($applicant_21ters->pluck('start_export_date'))?HP::DateThai(@$applicant_21ters->pluck('start_export_date', 'id')[@$volume_21ter->applicant_21ter_id]):'n/a' }} - {{ !empty($applicant_21ters->pluck('end_export_date'))?HP::DateThai(@$applicant_21ters->pluck('end_export_date', 'id')[@$volume_21ter->applicant_21ter_id]):'n/a' }}
            ">
  </div>
</div>

<table class="table color-bordered-table primary-bordered-table">
    <thead>
      <tr>
          <th class="text-center">รายการที่</th>
          <th class="text-center" width="25%">รายละเอียดผลิตภัณฑ์อุตสาหกรรม</th>
          <th class="text-center">ปริมาณที่ขอ</th>
          <th class="text-center">รวมปริมาณการส่งออก</th>
          <th class="text-center" width="5%"></th>
          <th class="text-center">ปริมาณ</th>
          <th class="text-center">หน่วย</th>
          <th class="text-center" width="285px;">วันที่</th>
      </tr>
    </thead>
    <tbody id="table-body">
      <tr>
        <td class="text-center" colspan="8">
          <span class="text-info">จะแสดงรายการรายละเอียดผลิตภัณฑ์อุตสาหกรรมเมื่อเลือกเลขที่คำขออ้างอิง</span>
        </td>
      </tr>
      {{-- {{ dd($applicant_21ter_details) }} --}}
      @foreach ($applicant_21ter_details as $key => $item)

        @php
          $sum_informed = 0;
          foreach ($item->informed as $informed) {
            if($informed->volume_21ter_id!=$volume_21ter->id && $informed->volume_21ter_id<$volume_21ter->id){
              $sum_informed += $informed->quantity_export;
            }
          }
        @endphp

        <tr>
          <td class="text-center">{{ $key+1 }}</td>
          <td>{{ $item->detail }}<input type="hidden" name="volume21_id[{{ $item->id }}]" value="{{ $item->id }}'"></td>
          <td class="text-right">{{ $item->quantity }}</td>
          <td class="text-right">{{ number_format($sum_informed) }}</td>
          <td>
            <div class="checkbox checkbox-success">
              <input id="detail-{{$item->id}}" name="detail_id[{{ $item->id }}]" class="detail-item" type="checkbox" value="1" @if(array_key_exists($item->id, $volume_21ter_details)) checked="checked" @endif>
              <label for="detail-{{$item->id}}"> ผลิต </label>
            </div>
            <div class="checkbox checkbox-success">
              <input id="detail_export-{{$item->id}}" name="detail_export[{{ $item->id }}]" class="detail-item_export" type="checkbox" value="1" @if(array_key_exists($item->id, $volume_21ter_details)) checked="checked" @endif>
              <label for="detail_export-{{$item->id}}"> ส่งออก </label>
            </div>
          </td>
          <td>
            <input class="form-control quantity" name="quantity[{{ $item->id }}]" type="number" @if(array_key_exists($item->id, $volume_21ter_details)) value="{{ $volume_21ter_details[$item->id] }}" @else disabled="disabled" @endif step="0.01" max="9999999999.99">
            <input class="form-control quantity_export" name="quantity_export[{{ $item->id }}]" type="number" @if(array_key_exists($item->id, $volume_21ter_details2)) value="{{ $volume_21ter_details2[$item->id] }}" @else disabled="disabled" @endif step="0.01" max="9999999999.99">
          </td>
          <td>
             <div style="height: 42px;">{{ $item->data_unit->name_unit ?? null }}</div>
             <div style="height: 42px;">{{ $item->data_unit->name_unit ?? null }}</div>
          </td>
          <td>

             <div class="input-daterange input-group" id="date-range" style="font-size: 16px;">
      {!! Form::text('start_product_date[{{ $item->id }}]', array_key_exists($item->id,$volume_21ter_detail_start_product_date) ? HP::revertDate($volume_21ter_detail_start_product_date[$item->id],true) : null, ['class' => 'form-control datepicker product_date']); !!}
            <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>
      {!! Form::text('end_product_date[{{ $item->id }}]', array_key_exists($item->id,$volume_21ter_detail_end_product_date) ?  HP::revertDate($volume_21ter_detail_end_product_date[$item->id],true)  :null, ['class' => 'form-control datepicker product_date']); !!}
    </div>
             <div class="input-daterange input-group" id="date-range" style="font-size: 16px;">
      {!! Form::text('start_export_date['.$item->id.']', array_key_exists($item->id,$volume_21ter_detail_start_export_date) ?  HP::revertDate($volume_21ter_detail_start_export_date[$item->id],true) :null, ['class' => 'form-control datepicker export_date']); !!}
            <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>
      {!! Form::text('end_export_date['.$item->id.']',  array_key_exists($item->id,$volume_21ter_detail_end_export_date)  ?  HP::revertDate($volume_21ter_detail_end_export_date[$item->id],true) :null, ['class' => 'form-control datepicker export_date']); !!}
    </div>
          </td>
        </tr>
      @endforeach

    </tbody>
</table>

<div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
  {!! Form::label('start_date', 'ใบขนขาออก :', ['class' => 'col-md-4 control-label required']) !!}
    <div class="col-md-6">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput">
              <i class="glyphicon glyphicon-file fileinput-exists"></i>
              <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn btn-default btn-file">
              <span class="fileinput-new">เลือกไฟล์</span>
              <span class="fileinput-exists">เปลี่ยน</span>
              <input type="file" name="file_leave" class="check_max_size_file" {{  (!empty($file_leave) && HP::checkFileStorage($attach_path.$file_leave['file_name'])) ? '' : 'required' }}>
            </span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
        </div>
    </div>
    <div class="col-md-2">
        @if(!empty($file_leave) && HP::checkFileStorage($attach_path.$file_leave['file_name']))
          <a href="{{ HP::getFileStorage($attach_path.$file_leave['file_name']) }}" target="_blank" class="view-attach btn btn-info btn-sm"><i class="fa fa-search"></i></a>
        @endif
    </div>
</div>


<div class="form-group">
  {!! Html::decode(Form::label('attach', 'ไฟล์แนบเอกสารที่เกี่ยวข้อง:<br><span class="text-muted">รองรับไฟล์ .pdf, .xlsx และ .jpg ขนาดไม่เกิน 10 MB</span>', ['class' => 'col-md-4 control-label'])) !!}
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
           <input type="file" name="attachs[]" accept=".pdf, .xlsx, .jpg" class="check_max_size_file">
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

<div class="form-group {{ $errors->has('inform_close') ? 'has-error' : ''}}">
  {!! Form::label('inform_close', 'ขอปิดการแจ้งปริมาณ:', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-8">
    {!! Form::radio('inform_close', '0', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} ไม่ปิด
    {!! $errors->first('inform_close', '<p class="help-block">:message</p>') !!}
  </div>
  <div class="col-md-8 row" style="margin-top:7px;">
    <div class="col-md-4" style="margin-top:5px;">
      {!! Form::radio('inform_close', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} ปิดการแจ้งปริมาณเพราะ
    </div>
    <div class="col-md-5">
      {!! Form::text('because_close', null, ['class' => 'form-control']) !!}
    </div>
    {!! $errors->first('inform_close', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group {{ $errors->has('because_close') ? 'has-error' : ''}}">
  <div class="col-md-4"></div>
  <div class="col-md-6">
    {!! $errors->first('because_close', '<p class="help-block">:message</p>') !!}
  </div>
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
  {!! Form::label('email', 'E-mail:', ['class' => 'col-md-4 control-label required']) !!}
  <div class="col-md-6">
    {!! Form::email('email', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-offset-4 col-md-4">

    <button class="btn btn-primary" type="submit">
      <i class="fa fa-paper-plane"></i> บันทึก
    </button>
    @can('view-'.str_slug('volume_21ter'))
    <a class="btn btn-default" href="{{url('/esurv/volume_21ter')}}">
      <i class="fa fa-rotate-left"></i> ยกเลิก
    </a>
    @endcan
  </div>
</div>

@push('js')
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>

<!-- input calendar thai -->
<script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<!-- thai extension -->
<script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

<!-- input file -->
<script src="{{asset('js/jasny-bootstrap.js')}}"></script>

<script type="text/javascript">

  $(document).ready(function() {
    check_max_size_file();
//     $('.fileinput').on("change.bs.fileinput", function (e) {
// var file = $(e.delegateTarget, $("form")).find('input[type=file]')[0].files[0];

//     var fileExtension = file.name.split(".");
//     fileExtension = fileExtension[fileExtension.length - 1].toLowerCase();

//     var arrayExtensions = ["jpg", "jpeg", "png"];

//     if (arrayExtensions.lastIndexOf(fileExtension) == -1) {
//         alert('Only Images can be uploaded');
//         $(this).fileinput('clear');
//     }
//     else {
//         if (file["size"] >= 4194304 && (fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png")) {
//             alert('Max 4 MB of file size can be uploaded.');
//             $(this).fileinput('clear');
//         }
//     }
// });

    var applicant_21ters = JSON.parse('{!! json_encode($applicant_21ters->toArray()) !!}'); //ข้อมูลคำขอทำ
    console.log(applicant_21ters);

    //เมื่อเลือกเลขที่อ้างอิง
    $('#applicant_21ter_id').change(function(event) {

      var id = $(this).val();

      $('#show-title, #show-date, #show-import_date, #show-export_date').val(''); //clear value
      $('#table-body').children(':not(:first)').remove(); //clear record

      if(id!=''){

        //แสดงข้อมูลคำขอ
        $(applicant_21ters).each(function(index, item) {
          if(item.id==id){
            $('#show-title').val(item.title);
            $('#show-date').val(DateThai2(item.start_date)+' - '+DateThai2(item.end_date));
            $('#show-import_date').val(DateThai2(item.start_import_date)+' - '+DateThai2(item.end_import_date));
            $('#show-export_date').val(DateThai2(item.start_export_date)+' - '+DateThai2(item.end_export_date));
          }
        });

        //ดึงรายละเอียดผลิตภัณฑ์
        $.ajax("{{ url('esurv/applicant_21ter/detail-item') }}/" + id)
         .done(function(data) {

            if(data.length>0){

              $(data).each(function(index, item) {

                var sum_informed = 0;

                $(item.informed).each(function(index, informed) {
                  if(informed.volume_21ter_id!={{(int)@$volume_21ter->id}}){
                    sum_informed += parseFloat(informed.quantity_export);
                  }
                });

                var tr = Array();
                    tr.push('<tr>');
                    tr.push('  <td class="text-center">'+(index+1)+'</td>');
                    tr.push('  <td>'+item.detail+'<input type="hidden" name="volume21_id['+item.id+']" value="'+item.id+'"></td>');
                    tr.push('  <td>'+item.quantity+'</td>');
                    tr.push('  <td class="text-right">'+numberWithCommas(sum_informed)+'</td>');
                    tr.push('  <td>');
                    tr.push('    <div class="checkbox checkbox-success">');
                    tr.push('     <input id="detail-'+item.id+'" name="detail_id['+item.id+']" class="detail-item" type="checkbox" value="1">');
                    tr.push('     <label for="detail-'+item.id+'"> ผลิต </label>');
                    tr.push('    </div>');
                    tr.push('    <div class="checkbox checkbox-success">');
                    tr.push('     <input id="detail_export-'+item.id+'" name="detail_export['+item.id+']" class="detail-item_export" type="checkbox" value="1">');
                    tr.push('     <label for="detail_export-'+item.id+'"> ส่งออก </label>');
                    tr.push('    </div>');
                    tr.push('  </td>');
                    tr.push('  <td>');
                    tr.push('    <input class="form-control quantity" name="quantity['+item.id+']" type="number" disabled="disabled" step="0.01" max="9999999999.99">');
                    tr.push('    <input class="form-control quantity_export" name="quantity_export['+item.id+']" type="number" disabled="disabled" step="0.01" max="9999999999.99">');
                    tr.push('  </td>');
                    tr.push('  <td><div style="height:42px">'+item.data_unit.name_unit+'</div><div style="height:42px">'+item.data_unit.name_unit+'</div></td>');
                    tr.push('  <td>');
                    tr.push(' <div class="input-daterange input-group" id="date-range" style="font-size: 16px;">');
                    tr.push('<input type="text" name="start_product_date['+item.id+']" class="form-control datepicker product_date" disabled="disabled">');
                    tr.push('     <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>');
                    tr.push('<input type="text" name="end_product_date['+item.id+']" class="form-control datepicker product_date" disabled="disabled">');
                    tr.push('</div>');
                    tr.push(' <div class="input-daterange input-group" id="date-range" style="font-size: 16px;">');
                    tr.push('<input type="text" name="start_export_date['+item.id+']" class="form-control datepicker export_date" disabled="disabled">');
                    tr.push('     <span class="input-group-addon bg-info b-0 text-white"> ถึง </span>');
                    tr.push('<input type="text" name="end_export_date['+item.id+']" class="form-control datepicker export_date" disabled="disabled">');
                    tr.push('</div>');
                    tr.push('  </td>');
                    tr.push('</tr>');

                $('#table-body').append(tr.join(''));

                 jQuery('.datepicker').datepicker({
        autoclose: true,
        toggleActive: true,
        todayHighlight: true,
        language:'th-th',
        format: 'dd/mm/yyyy'
    });

              });

              ShowHideFirst();

            }

         });

      }else{

        ShowHideFirst();

      }

    });

    // Date Picker Thai
    jQuery('.datepicker').datepicker({
        autoclose: true,
        toggleActive: true,
        todayHighlight: true,
        language:'th-th',
        format: 'dd/mm/yyyy'
    });

    //เมื่อเลือกผลิต
    $('body').on('change', '.detail-item', function(event) {

      var quantity = $(this).parent().parent().parent().find('.quantity');
      var productDate = $(this).parent().parent().parent().find('.product_date');

      if($(this).prop('checked')) { //ถ้าเลือก
        $(quantity).attr('disabled', false);
        $(productDate).attr('disabled', false).attr('required', true);
        $(quantity).focus();
      } else { //ถ้าไม่เลือก
        $(quantity).attr('disabled', true);
        $(productDate).attr('disabled', true).attr('required', false);
      }

    });

    //เมื่อเลือกส่งออก
    $('body').on('change', '.detail-item_export', function(event) {

      var quantity_export = $(this).parent().parent().parent().find('.quantity_export');
      var exportDate = $(this).parent().parent().parent().find('.export_date');


      if($(this).prop('checked')) { //ถ้าเลือก
        $(quantity_export).attr('disabled', false);
        $(exportDate).attr('disabled', false).attr('required', true);
        $(quantity_export).focus();
      } else { //ถ้าไม่เลือก
        $(quantity_export).attr('disabled', true);
        $(exportDate).attr('disabled', true).attr('required', false);
      }

    });

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
    ShowHideFirst();

  });

  function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

    if ($('.other_attach_item').length > 1) {
      $('.attach-remove').show();
    } else {
      $('.attach-remove').hide();
    }

  }

  function ShowHideFirst(){ //ซ่อน-แสดงแถวแรก

    if($('#table-body').children().length > 1){
      $('#table-body').children(':first').hide();
    }else{
      $('#table-body').children(':first').show();
    }

  }

  function DateThai2(date, plus_year){
  var month = Array();
      month['01'] = 'ม.ค.';
      month['02'] = 'ก.พ.';
      month['03'] = 'มี.ค.';
      month['04'] = 'เม.ย.';
      month['05'] = 'พ.ค.';
      month['06'] = 'มิ.ย.';
      month['07'] = 'ก.ค.';
      month['08'] = 'ส.ค.';
      month['09'] = 'ก.ย.';
      month['10'] = 'ต.ค.';
      month['11'] = 'พ.ย.';
      month['12'] = 'ธ.ค.';

  if (date) {
    var dates = date.split('-');
    var year = (plus_year!==false)?parseInt(dates[0])+543:dates[0];
    return dates[2]+' '+month[dates[1]]+' '+year;
  } else {
    return 'n/a';
  }

}

</script>
@endpush
