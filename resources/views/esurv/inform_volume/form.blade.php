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

<div class="row">

  <div class="col-md-6">

    <div class="form-group {{ $errors->has('inform_month') ? 'has-error' : ''}}">
      {!! Form::label('inform_month', 'เดือน', ['class' => 'col-md-3 control-label required']) !!}
      <div class="col-md-6">
        {!! Form::select('inform_month', HP::MonthList(), null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'-เลือกเดือน-']); !!}
        {!! $errors->first('inform_month', '<p class="help-block">:message</p>') !!}
      </div>
    </div>

  </div>
  <div class="col-md-6">

    <div class="form-group {{ $errors->has('inform_year') ? 'has-error' : ''}}">
      {!! Form::label('inform_year', 'ปี', ['class' => 'col-md-3 control-label required']) !!}
      <div class="col-md-6">
        {!! Form::select('inform_year', HP::YearList(), null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'-เลือกปี-']); !!}
        {!! $errors->first('inform_year', '<p class="help-block">:message</p>') !!}
      </div>
    </div>

  </div>

</div>

<!-- ข้อมูลการผลิต -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <div class="panel-heading">ข้อมูลปริมาณการผลิต</div>
      <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body panel-body-info">

          <div class="form-group {{ $errors->has('tb3_Tisno') ? 'has-error' : ''}}">
            {!! Form::label('tb3_Tisno', 'มาตรฐาน', ['class' => 'col-md-2 control-label required']) !!}
            <div class="col-md-8">
              {!! Form::select('tb3_Tisno', HP::OwnTisListGeneral(), null, ['class' => 'form-control tis select2', 'required' => 'required', 'placeholder'=>'-เลือกมาตรฐาน-']); !!}
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

              @if(@$inform_volume->starndard->tb3_Tisforce!='บ')

                @foreach ($own_licenses as $key => $own_license)

                @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses)===false)
                  @continue
                @endif

                  <div class="col-md-12 detail-item" id="detail{{ $own_license->Autono }}">
                    <h5>
                      <span class="order">{{ $key+1 }}</span>. ใบอนุญาตเลขที่ <span class="text-info">{{ $own_license->tbl_licenseNo }}</span> <span class="text-success">(มาตรฐานทั่วไป)</span>
                    </h5>
                    <div class="table-responsive">
                      <table class="table color-bordered-table info-bordered-table" id="table-detail{{ $own_license->Autono }}">
                        <thead>
                          <tr>
                            <th class="col-md-1 text-center" rowspan="2">รายการที่</th>
                            <th class="col-md-5 text-center" rowspan="2">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>
                            <th class="col-md-4 text-center" colspan="2">ปริมาณการผลิต</th>
                            <th class="col-md-2 text-center" rowspan="2">หน่วย</th>
                          </tr>
                          <tr>
                            <th class="text-center">แสดงเครื่องหมาย มอก.</th>
                            <th class="text-center">ไม่แสดงเครื่องหมาย มอก.</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($details[$own_license->tbl_licenseNo] as $key => $detail)

                          <tr>
                            <td class="text-center">{{ $key+1 }}.</td>
                            <td>{{ $detail->standard_detail }}</td>
                            <td>
                              <div class="col-md-12">
                                <div class="checkbox checkbox-success">
                                  <input id="license-detail1-{{ $detail->id }}" name="license_detail_checked[{{ $detail->id }}][2]" class="license-detail-item" type="checkbox" value="{{ $detail->id }}" @if(array_key_exists($detail->id,
                                  $inform_details) && !is_null($inform_details[$detail->id]->volume2)) checked="checked"
                                  @endif />
                                  <label for="license-detail1-{{ $detail->id }}"> ผลิต </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <input class="form-control" data-license-detail="{{ $detail->id }}" name="volume[{{ $detail->id }}][2]" type="number" step="0.01" max="9999999999.99"
                                @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume2))
                                  value="{{ $inform_details[$detail->id]->volume2 }}"
                                @else
                                  disabled="disabled"
                                @endif />
                              </div>
                            </td>
                            <td>
                              <div class="col-md-12">
                                <div class="checkbox checkbox-success">
                                  <input id="license-detail2-{{ $detail->id }}" name="license_detail_checked[{{ $detail->id }}][3]" class="license-detail-item" type="checkbox" value="{{ $detail->id }}"
                                  @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume3))
                                    checked="checked"
                                  @endif />
                                  <label for="license-detail2-{{ $detail->id }}"> ผลิต </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <input class="form-control" data-license-detail="{{ $detail->id }}" name="volume[{{ $detail->id }}][3]" type="number" step="0.01" max="9999999999.99"
                                @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume3))
                                  value="{{ $inform_details[$detail->id]->volume3 }}"
                                @else
                                  disabled="disabled"
                                @endif />
                              </div>
                            </td>
                            <td>
                              <div class="col-md-12" style="margin-top:5%">&nbsp;</div>
                              {!! Form::select("unit[$detail->id]", [$OwnTisUnitList[$inform_volume->tb3_Tisno]['id']=>$OwnTisUnitList[$inform_volume->tb3_Tisno]['title']], @$inform_details[$detail->id]->unit, ['class'=>'form-control']); !!}
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  @endforeach

                  @else

                      @foreach ($own_licenses as $key => $own_license)

                        @if(array_search($own_license->tbl_licenseNo, $inform_volume_licenses)===false)
                          @continue
                        @endif

                        <div class="col-md-12 detail-item" id="detail{{ $own_license->Autono }}">
                          <h5>
                            <span class="order">{{ $key+1 }}</span>. ใบอนุญาตเลขที่ <span class="text-info">{{ $own_license->tbl_licenseNo }}</span> <span class="text-danger">(มาตรฐานบังคับ)</span>
                          </h5>

                          <div class="table-responsive">

                            <table class="table color-bordered-table info-bordered-table" id="table-detail{{ $own_license->Autono }}">
                              <thead>
                                <tr>
                                  <th class="col-md-1 text-center">รายการที่</th>
                                  <th class="col-md-6 text-center">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>
                                  <th class="col-md-3 text-center">ปริมาณการผลิต</th>
                                  <th class="col-md-2 text-center">หน่วย</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($details[$own_license->tbl_licenseNo] as $key => $detail)

                                  <tr>
                                    <td class="text-center">{{ $key+1 }}.</td>
                                    <td>{{ $detail->standard_detail }}</td>
                                    <td>
                                      <div class="col-md-5">
                                        <div class="checkbox checkbox-success">
                                          <input id="license-detail{{ $detail->id }}"
                                                 name="license_detail_checked[{{ $detail->id }}][1]"
                                                 class="license-detail-item"
                                                 type="checkbox"
                                                 value="{{ $detail->id }}"
                                                 @if(array_key_exists($detail->id, $inform_details) && !is_null($inform_details[$detail->id]->volume1))
                                                   checked="checked"
                                                 @endif
                                          />
                                          <label for="license-detail{{ $detail->id }}"> ผลิต </label>
                                        </div>
                                      </div>
                                      <div class="col-md-7">
                                        <input class="form-control" data-license-detail="{{ $detail->id }}" name="volume[{{ $detail->id }}][1]" type="number" step="0.01" max="9999999999.99"
                                               @if(array_key_exists($detail->id, $inform_details) &&
                                               !is_null($inform_details[$detail->id]->volume1))
                                                 value="{{ $inform_details[$detail->id]->volume1 }}"
                                               @else
                                                 disabled="disabled"
                                               @endif />
                                      </div>
                                    </td>
                                    <td>
                                      {!! Form::select("unit[$detail->id]", [$OwnTisUnitList[$inform_volume->tb3_Tisno]['id']=>$OwnTisUnitList[$inform_volume->tb3_Tisno]['title']], @$inform_details[$detail->id]->unit, ['class'=>'form-control']); !!}
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>

                          </div>

                        </div>

                        @endforeach

                    @endif
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

</div>

<div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
  {!! Form::label('remark', 'หมายเหตุ', ['class' => 'col-md-4 control-label']) !!}
  <div class="col-md-6">
    {!! Form::textarea('remark', null, ['class' => 'form-control', 'rows'=>2]) !!}
    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group">
  {!! Html::decode(Form::label('attach', 'ไฟล์แนบเอกสารที่เกี่ยวข้อง:<br><span class="text-muted">รองรับไฟล์ .pdf และ .jpg ขนาดไม่เกิน 10 MB</span>', ['class' => 'col-md-4 control-label'])) !!}
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
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
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

  <div class="col-md-3">

  </div>

  <div class="col-md-6">

    <button class="btn btn-primary" type="button" onclick="myFunction(); return false">
         <i class="fa fa-paper-plane"></i> ส่งข้อมูล
    </button>
    @can('view-'.str_slug('inform_volume'))
    <a class="btn btn-default" href="{{url('/esurv/inform_volume')}}">
      <i class="fa fa-rotate-left"></i> ยกเลิก
    </a>
    @endcan

  </div>

  <div class="clearfix"></div>

@push('js')

<!-- icheck  -->
<script src="{{ asset('plugins/components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/components/icheck/icheck.init.js') }}"></script>
<script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
<!-- input file -->
<script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
<script>
  function myFunction() {
    var inform_month = $('#inform_month').val();
    var inform_year = $('#inform_year').val();
    var id = '{{ !empty($inform_volume->id) ? $inform_volume->id : "null" }}';

    if(inform_month != '' && inform_year != '' && $('input[name="state"][value="1"]').is(':checked') ){
      console.log('2');
      $.ajax({
            url: "{!! url('esurv/inform_volume/inform_month_and_year') !!}" + "/" + id + "/" + inform_month + "/" + inform_year
       }).done(function( object ) {
         console.log(object);

            if(object.data == 'not_null'){
              Swal.fire({
                      title: 'แจ้งปริมาณการผลิต เดือน '+object.inform_month+ ' ปี ' +object.inform_year +' นี้แล้ว ' ,
                      text: "เมื่อวันที่ " + object.created_at,
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'รับทราบ',
                      cancelButtonText: 'ยกเลิก',
                      width: 700,
                    }).then((result) => {
                      if (result.value) {
                        $('#form_inform_volume').submit();
                      }
                    })
            }else{
              $('#form_inform_volume').submit();
            }
       });

    }else{
      console.log('1');
      $('#form_inform_volume').submit();
    }
  }
  </script>

<script type="text/javascript">
  $(document).ready(function() {
      check_max_size_file();
    //เมื่อเลือกมาตรฐาน
    $('.tis').change(function(event) {

      $(".license-list").html('');
      $(".license-detail").html('');

      if ($(this).val() != "") { //ถ้าเลือกใบอนุญาต

        $.ajax("{{ url('basic/license-list-nomoao5') }}/" + $(this).val())
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

    //เมื่อเลือกผลิตในตารางรายการผลิตภัณฑ์
    $('body').on('change', '.license-detail-item', function() {

      var input_text = $(this).parent().parent().parent().find('input[data-license-detail="' + $(this).val() + '"]');
      if ($(this).prop('checked')) { //ถ้าติ๊กเลือก

        $(input_text).prop('disabled', false);
        $(input_text).val(0);
        $(input_text).select();
      } else { //ถ้าไม่ติ๊กเลือก
        $(input_text).prop('disabled', true);
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

  });

  function ShowHideRemoveBtn() { //ซ่อน-แสดงปุ่มลบ

    if ($('.other_attach_item').length > 1) {
      $('.attach-remove').show();
    } else {
      $('.attach-remove').hide();
    }

  }

  var Units = JSON.parse('{!! json_encode(HP::OwnTisUnitList()) !!}');

  function getLicenseDetail(Autono, standard_type, license_type) { //ดึงรายละเอียดผลิตภัณฑ์

    if (standard_type == 'บ') { //มาตรฐานบังคับ

      var table_html = [];
      table_html.push('<div class="table-responsive">');
      table_html.push('  <table class="table color-bordered-table info-bordered-table" id="table-detail' + Autono + '">');
      table_html.push('    <thead>');
      table_html.push('      <tr>');
      table_html.push('        <th class="col-md-1 text-center">รายการที่</th>');
      table_html.push('        <th class="col-md-6 text-center">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>');
      table_html.push('        <th class="col-md-3 text-center">ปริมาณการผลิต</th>');
      table_html.push('        <th class="col-md-2 text-center">หน่วย</th>');
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
            input_html.push('  <td class="text-center">' + (key + 1) + '.</td>');
            input_html.push('  <td>' + value.standard_detail + '</td>');
            input_html.push('  <td>');
            input_html.push('    <div class="col-md-5">');
            input_html.push('      <div class="checkbox checkbox-success">');
            input_html.push('        <input id="license-detail' + value.id + '" name="license_detail_checked[' + value.id + '][1]" class="license-detail-item" type="checkbox" value="' + value.id + '">');
            input_html.push('        <label for="license-detail' + value.id + '"> ผลิต </label>');
            input_html.push('      </div>');
            input_html.push('    </div>');
            input_html.push('    <div class="col-md-7"><input class="form-control" disabled="disabled" data-license-detail="' + value.id + '" name="volume[' + value.id + '][1]" type="number" step="0.01" max="9999999999.99" value=""></div>');
            input_html.push('  </td>');
            input_html.push('  <td>');
            input_html.push('   <select class="form-control" name="unit[' + value.id + ']">');
            input_html.push('     <option value="'+Units[$('#tb3_Tisno').val()].id+'">'+Units[$('#tb3_Tisno').val()].title+'</option>');
            input_html.push('   </select>');
            input_html.push('  </td>');
            input_html.push('</tr>');

            $('#table-detail' + Autono).children('tbody').append(input_html.join('')); //นำรายการไปแสดงในรายการ

          });

        });

    } else { //มาตรฐานทั่วไป

      var table_html = [];
      table_html.push('<div class="table-responsive">');
      table_html.push('  <table class="table color-bordered-table info-bordered-table" id="table-detail' + Autono + '">');
      table_html.push('    <thead>');
      table_html.push('      <tr>');
      table_html.push('        <th class="col-md-1 text-center" rowspan="2">รายการที่</th>');
      table_html.push('        <th class="col-md-5 text-center" rowspan="2">รายละเอียดของผลิตภัณฑ์อุตสาหกรรมที่ได้รับอนุญาต</th>');
      table_html.push('        <th class="col-md-4 text-center" colspan="2">ปริมาณการผลิต</th>');
      table_html.push('        <th class="col-md-2 text-center" rowspan="2">หน่วย</th>');
      table_html.push('      </tr>');
      table_html.push('      <tr>');
      table_html.push('        <th class="text-center">แสดงเครื่องหมาย มอก.</th>');
      table_html.push('        <th class="text-center">ไม่แสดงเครื่องหมาย มอก.</th>');
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
            input_html.push('  <td class="text-center">' + (key + 1) + '.</td>');
            input_html.push('  <td>' + value.standard_detail + '</td>');
            input_html.push('  <td class="text-top">');
            input_html.push('    <div class="col-md-12">');
            input_html.push('      <div class="checkbox checkbox-success">');
            input_html.push('        <input id="license-detail1-' + value.id + '" name="license_detail_checked[' + value.id + '][2]" class="license-detail-item" type="checkbox" value="' + value.id + '">');
            input_html.push('        <label for="license-detail1-' + value.id + '"> ผลิต </label>');
            input_html.push('      </div>');
            input_html.push('    </div>');
            input_html.push('    <div class="col-md-12"><input class="form-control" disabled="disabled" data-license-detail="' + value.id + '" name="volume[' + value.id + '][2]" type="number" step="0.01" max="9999999999.99" value=""></div>');
            input_html.push('  </td>');
            input_html.push('  <td class="text-top">');
            input_html.push('    <div class="col-md-12">');
            input_html.push('      <div class="checkbox checkbox-success">');
            input_html.push('        <input id="license-detail2-' + value.id + '" name="license_detail_checked[' + value.id + '][3]" class="license-detail-item" type="checkbox" value="' + value.id + '">');
            input_html.push('        <label for="license-detail2-' + value.id + '"> ผลิต </label>');
            input_html.push('      </div>');
            input_html.push('    </div>');
            input_html.push('    <div class="col-md-12"><input class="form-control" disabled="disabled" data-license-detail="' + value.id + '" name="volume[' + value.id + '][3]" type="number" step="0.01" max="9999999999.99" value=""></div>');
            input_html.push('  </td>');
            input_html.push('  <td class="text-top">');
            input_html.push('   <div class="col-md-12" style="margin-top:5%">&nbsp;</div>');
            input_html.push('   <select class="form-control" name="unit[' + value.id + ']">');
            input_html.push('     <option value="'+Units[$('#tb3_Tisno').val()].id+'">'+Units[$('#tb3_Tisno').val()].title+'</option>');
            input_html.push('   </select>');
            input_html.push('  </td>');
            input_html.push('</tr>');

            $('#table-detail' + Autono).children('tbody').append(input_html.join('')); //นำรายการไปแสดงในรายการ

          });

        });

    }

  }
</script>
@endpush
