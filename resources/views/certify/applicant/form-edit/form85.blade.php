
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
<div class="form-group {{ $errors->has('purpose') ? 'has-error' : ''}}">
    {!! Form::label('purpose', 'วัตถุประสงค์ในการยื่นคำขอ: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 m-t-5">
        @if ($certi_lab->purpose_type == 1)
            <label>{!! Form::radio('purpose', '1', true, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ขอใบรับรอง &nbsp;</label>
            <label>{!! Form::radio('purpose', '2', false, ['class'=>'check', 'data-radio'=>'iradio_square-red','disabled'=>'disabled']) !!} &nbsp;ต่ออายุใบรับรอง &nbsp;</label>
        @else
            <label>{!! Form::radio('purpose', '1', false, ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ขอใบรับรอง &nbsp;</label>
            <label>{!! Form::radio('purpose', '2', true, ['class'=>'check', 'data-radio'=>'iradio_square-red','disabled'=>'disabled']) !!} &nbsp;ต่ออายุใบรับรอง &nbsp;</label>
        @endif
        {!! $errors->first('purpose', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('according_formula') ? 'has-error' : ''}}">
    {!! Form::label('according_formula', 'ตามมาตรฐานเลขที่: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name="according_formula" id="according_formula" class="form-control pull-left" required>
            <option value="0" selected>- เลือกมาตรฐาน -</option>
            @foreach($formulas as $data)
                <option value="{{$data->id}}">{{$data->title}}</option>
            @endforeach
        </select>
        {!! $errors->first('according_formula', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lab_ability') ? 'has-error' : ''}}">
    {!! Form::label('lab_ability', 'ความสามารถห้องปฏิบัติการ: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 m-t-5">
        @if ($certi_lab->lab_type == 3)
            <label>{!! Form::radio('lab_ability', 'test', true, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทดสอบ &nbsp;</label>
            <label>{!! Form::radio('lab_ability', 'calibrate', false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-red']) !!} &nbsp;สอบเทียบ &nbsp;</label>
        @else
            <label>{!! Form::radio('lab_ability', 'test', false, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-green']) !!} &nbsp;ทดสอบ &nbsp;</label>
            <label>{!! Form::radio('lab_ability', 'calibrate', true, ['class'=>'check checkLab', 'data-radio'=>'iradio_square-red']) !!} &nbsp;สอบเทียบ &nbsp;</label>
        @endif
        {!! $errors->first('lab_ability', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('for_branch') ? 'has-error' : ''}}">
    {!! Form::label('for_branch', 'สาขาที่ขอรับการรับรอง: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name="for_branch" id="for_branch" class="form-control pull-left" required>
            <option value="0" selected>- เลือกสาขา -</option>
        </select>
        {!! $errors->first('for_branch', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lab_name') ? 'has-error' : ''}}">
    {!! Form::label('lab_name', 'ชื่อห้องปฏิบัติการ: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input type="text" class="form-control" name="lab_name" id="lab_name" required value="{{ $certi_lab->lab_name }}">
        {!! $errors->first('lab_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address_check', 'ที่อยู่: ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6 m-t-5">
        @if ($certi_lab->same_address == 1)
            <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" checked>&nbsp;ใช่ที่อยู่ตามที่อยู่จดทะเบียน &nbsp;</label>
        @else
            <label><input type="checkbox" id="address_same_headquarter" name="address_same_headquarter" checked>&nbsp;ใช่ที่อยู่ตามที่อยู่จดทะเบียน &nbsp;</label>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_number') ? 'has-error' : ''}}">
            <div class="col-md-4"></div>
            {!! Form::label('address_number', 'เลขท่ี: ', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-6">
                <input type="text" class="form-control" name="address_number" id="address_number" required value="{{ $certi_lab->address_no }}">
                {!! $errors->first('address_number', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('village_no') ? 'has-error' : ''}}">
            {!! Form::label('village_no', 'หมู่ที่: ', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-6">
                <input type="text" class="form-control" name="village_no" id="village_no" required value="{{ $certi_lab->allay }}">
                {!! $errors->first('village_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_soi') ? 'has-error' : ''}}">
            <div class="col-md-4"></div>
            {!! Form::label('address_soi', 'ตรอก/ซอย: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">
                <input type="text" class="form-control" name="address_soi" id="address_soi" required value="{{ $certi_lab->village_no }}">
                {!! $errors->first('address_soi', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_street') ? 'has-error' : ''}}">
            {!! Form::label('address_street', 'ถนน: ', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-6">
                <input type="text" class="form-control" name="address_street" id="address_street" required value="{{ $certi_lab->road }}">
                {!! $errors->first('address_street', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_city') ? 'has-error' : ''}}">
            <div class="col-md-2"></div>
            {!! Form::label('address_city', 'จังหวัด: ', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <input type="text" name="address_city" id="address_city" class="form-control" value="{{ $certi_lab->province }}">
                {!! $errors->first('address_city', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_district') ? 'has-error' : ''}}">
            {!! Form::label('address_district', 'เขต/อำเภอ: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">

                <input type="text" name="address_district" id="address_district" class="form-control" value="{{ $certi_lab->amphur }}">
                {!! $errors->first('according_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('sub_district') ? 'has-error' : ''}}">
            <div class="col-md-2"></div>
            {!! Form::label('sub_district', 'แขวง/ตำบล: ', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">

                <input type="text" name="sub_district" id="sub_district" class="form-control" value="{{ $certi_lab->district }}">
                {!! $errors->first('sub_district', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
            {!! Form::label('postcode', 'รหัสไปรษณีย์: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">
                <input type="number" name="postcode" id="postcode" class="form-control" required value="{{ $certi_lab->postcode }}">
                {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_tel') ? 'has-error' : ''}}">
            <div class="col-md-4"></div>
            {!! Form::label('address_tel', 'โทรศัพท์: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">
                <input type="text" name="address_tel" id="address_tel" class="form-control" required value="{{ $certi_lab->tel }}">
                {!! $errors->first('address_tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('fax') ? 'has-error' : ''}}">
            {!! Form::label('fax', 'โทรสาร: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">
                <input type="text" name="fax" id="fax" class="form-control" required value="{{ $certi_lab->tel_fax }}">
                {!! $errors->first('fax', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
            <div class="col-md-4"></div>
            {!! Form::label('contact', 'บุคคลติดต่อ: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">
                <input type="text" name="contact" id="contact" class="form-control" required value="{{ $certi_lab->contactor_name }}">
                {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address_email') ? 'has-error' : ''}}">
            {!! Form::label('address_email', 'Email: ', ['class' => 'col-md-2 control-label text-nowrap']) !!}
            <div class="col-md-6">
                <input type="email" name="address_email" id="address_email" class="form-control" required value="{{ $certi_lab->email }}">
                {!! $errors->first('address_email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_mobile') ? 'has-error' : ''}}">
            <div class="col-md-4"></div>
            {!! Form::label('contact_mobile', 'โทรศัพท์ผู้ติดต่อ: ', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-6">
                <input type="number" name="contact_mobile" id="contact_mobile" class="form-control" required value="{{ $certi_lab->contact_tel }}">
                {!! $errors->first('contact_mobile', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('contact_tel') ? 'has-error' : ''}}">
            {!! Form::label('contact_tel', 'โทรศัพท์มือถือ: ', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-6">
                <input type="number" name="contact_tel" id="contact_tel" class="form-control" required value="{{ $certi_lab->telephone }}">
                {!! $errors->first('contact_tel', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(document).ready(function () {
            let checkLabCheck = '{!! $certi_lab->lab_type ?? null !!}';
            if (checkLabCheck === '3'){
                clickCheckLab('test')
            }else if (checkLabCheck === '4'){
                clickCheckLab('calibrate');
            }

            $('#according_formula').val({!! $certi_lab->standard_id !!}).change();


        });
    </script>
    <script>
        $('.checkLab').on('change',function () {
            console.log($(this).val());
            const select = $(this).val();
            const _token = $('input[name="_token"]').val();
            $('#for_branch').empty();
            $('#branch_lab_test').empty();
            $('#branch_lab_calibrate').empty();
            if ($(this).val() === 'test') {
                $('#viewForm93').fadeIn();
                $('#viewForm92').hide();
                $.ajax({
                    url:"{{route('api.test')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#viewForm90').fadeIn();
                        $('#viewForm91').hide();
                        console.log(result);
                        $('#for_branch').append('<option value="" >- เลือกสาขา -</option>');
                        $('#branch_lab_test').append('<option value="" >- เลือกสาขา -</option>');
                        $.each(result,function (index,value) {
                            $('#for_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                            $('#branch_lab_test').append('<option value='+value.id+' >'+value.title+'</option>')
                        });
                    }
                });
            }
            else if ($(this).val() === 'calibrate') {
                $('#viewForm92').fadeIn();
                $('#viewForm93').hide();
                $.ajax({
                    url:"{{route('api.calibrate')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#viewForm91').fadeIn();
                        $('#viewForm90').hide();
                        console.log(result);
                        $('#for_branch').append('<option value="" >- เลือกสาขา -</option>');
                        $('#branch_lab_calibrate').append('<option value="" >- เลือกสาขา -</option>');
                        $.each(result,function (index,value) {
                            $('#for_branch').append('<option value='+value.id+' >'+value.title+'</option>')
                            $('#branch_lab_calibrate').append('<option value='+value.id+' >'+value.title+'</option>')
                        })
                    }
                });
            }
        });

        $('#for_branch').on('change',function () {
                var checkLabVal = $('.checkLab:checked').val();
                var forBranchVal = $(this).val();
                if (checkLabVal === 'test') {
                    $('#branch_lab_test').val(forBranchVal).change();
                    $('#branch_lab_test option').each(function() {
                        // alert($(this).val());
                        if($(this).val()==forBranchVal){
                                $(this).not("[value='']").removeAttr('disabled').attr('selected','selected');
                        } else {
                            $(this).not("[value='']").removeAttr('selected').attr('disabled','disabled');
                        }
                    });
                    $('#type_product').val('').change();
                    $('#all_product').val('').change();
                    $('#test_list').val('').change();
                    $('#test_detail_div').find('span').remove();
                    $('#how_test_detail_div').find('span').remove();
                    $('#branch_lab_test').change();
                }  else if (checkLabVal === 'calibrate') {
                    $('#branch_lab_calibrate').val(forBranchVal).change();
                    $('#branch_lab_calibrate option').each(function() {
                        if($(this).val()==forBranchVal){
                                $(this).not("[value='']").removeAttr('disabled').attr('selected','selected');
                        } else {
                            $(this).not("[value='']").removeAttr('selected').attr('disabled','disabled');
                        }

                    });
                    $('#type_calibrate').val('').change();
                    $('#calibrate_list').val('').change();
                    $('#formula_technical').val('');
                    $('.calibrate_data_div').remove();
                    $('#calibrate_detail_div').empty();
                    $('#formula_standard').empty();
                    $('#branch_lab_calibrate').change();
                }
        });

        $('#address_same_headquarter').on('change',function () {
            if ($(this).prop('checked')){
                        {{--let add_no = '{!! $tis_data->trader_address !!}';--}}
                        {{--let soi = '{!! $tis_data->trader_address_soi !!}';--}}
                        {{--let street = '{!! $tis_data->trader_address_road !!}';--}}
                        {{--let moo = '{!! $tis_data->trader_address_moo !!}';--}}
                        {{--let post = '{!! $tis_data->trader_address_poscode !!}';--}}
                        {{--let tel = '{!! $tis_data->trader_phone !!}';--}}
                        {{--let fax = '{!! $tis_data->trader_fax !!}';--}}
                        {{--let address_city = '{!! $tis_data->trader_provinceID !!}';--}}
                        {{--let address_district = '{!! $tis_data->trader_address_amphur !!}';--}}
                        {{--let sub_district = '{!! $tis_data->trader_address_tumbol !!}';--}}
                let add_no = $('#home_num').val();
                let soi = $('#home_soi').val();
                let street = $('#home_street').val();
                let moo = $('#home_moo').val();
                let post = $('#home_post').val();
                let tel = $('#home_phone').val();
                let fax = $('#head_fax').val();
                let address_city = $('#home_province').val();
                let address_district = $('#home_area').val();
                let sub_district = $('#home_tumbon').val();
                $('#address_number').val(add_no);
                $('#village_no').val(moo);
                $('#address_soi').val(soi);
                $('#address_street').val(street);
                $('#postcode').val(post);
                $('#address_tel').val(tel);
                $('#fax').val(fax);
                $('#address_city').val(address_city);
                $('#address_district').val(address_district);
                $('#sub_district').val(sub_district);
            }else{
                $('#address_number').val('');
                $('#village_no').val('');
                $('#address_soi').val('');
                $('#address_street').val('');
                $('#postcode').val('');
                $('#address_tel').val('');
                $('#fax').val('');
                $('#address_city').val('');
                $('#address_district').val('');
                $('#sub_district').val('');
            }
        });


        $('#address_city').on('change', function () {
            const select = $(this).val();
            const _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('api.amphur')}}",
                method:"POST",
                data:{select:select,_token:_token},
                success:function (result){
                    $('#address_district').empty();
                    $('#address_district').append('<option value="0">- เลือกอำเภอ -</option>');
                    $.each(result,function (index,value) {
                        $('#address_district').append('<option value='+value.AMPHUR_ID+' >'+value.AMPHUR_NAME+'</option>');
                    })
                }
            });
        });

        $('#address_district').on('change',function () {
            if ($(this).val() !== "0"){
                const select = $(this).val();
                const _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('api.district')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#sub_district').empty();
                        $('#sub_district').append('<option value="0">- เลือกแขวง/ตำบล -</option>');
                        $.each(result,function (index,value) {
                            $('#sub_district').append('<option value='+value.DISTRICT_ID+' >'+value.DISTRICT_NAME+'</option>');
                        })
                    }
                });
            }
        });

        /////// Show JS //////
        function clickCheckLab(checked) {
            const select = checked;
            const _token = $('input[name="_token"]').val();
            $('#for_branch').empty();
            $('#branch_lab_test').empty();
            $('#branch_lab_calibrate').empty();
            if (checked === 'test') {
                $.ajax({
                    url:"{{route('api.test')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#for_branch').append('<option value="" >- เลือกสาขา -</option>');
                        $('#branch_lab_test').append('<option value="" >- เลือกสาขา -</option>');
                        $.each(result,function (index,value) {
                            $('#for_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                            $('#branch_lab_test').append('<option value='+value.id+' >'+value.title+'</option>')
                        });
                        $('#for_branch').val({!! $certi_lab->branch_name !!}).change();
                    }
                });
            }
            else if (checked === 'calibrate') {
                $.ajax({
                    url:"{{route('api.calibrate')}}",
                    method:"POST",
                    data:{select:select,_token:_token},
                    success:function (result){
                        $('#for_branch').append('<option value="" >- เลือกสาขา -</option>');
                        $('#branch_lab_calibrate').append('<option value="" >- เลือกสาขา -</option>');
                        $.each(result,function (index,value) {
                            $('#for_branch').append('<option value='+value.id+' >'+value.title+'</option>');
                            $('#branch_lab_calibrate').append('<option value='+value.id+' >'+value.title+'</option>')
                        })
                        $('#for_branch').val({!! $certi_lab->branch_name !!}).change();
                    }
                });
            }
        }

    </script>
@endpush