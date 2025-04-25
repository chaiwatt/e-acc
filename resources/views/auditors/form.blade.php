@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <style>
        label[for=checkbox_confirm] {
            color: black !important;
        }
    </style>
@endpush
{{-- <div class="container"> --}}
    
<div class="row">
    <div class="col-xs-12">
        <div class="white-box"> 
            <div class="row">
        
 <div class="col-sm-12">
<!-- start ข้อมูลส่วนตัว -->
<h3 class="box-title">ข้อมูลส่วนตัว</h3>
<hr>

<div class="col-sm-12">
   <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
      {!! HTML::decode(Form::label('name', 'ชื่อผู้ประกอบการ(TH)'.' :', ['class' => 'col-md-3 control-label'])) !!}
      <div class="col-md-8">
            {!! Form::text('name',   (!empty($user->name) ? $user->name : null), ['class' => 'form-control',   'disabled' => true]) !!}
           {!! $errors->first('name', '<p class="help-block">:message</p>') !!} 
        </div>
   </div>
</div>
<div class="col-sm-12">
    <div class="form-group {{ $errors->has('name_en') ? 'has-error' : ''}}">
       {!! HTML::decode(Form::label('name_en', 'ชื่อผู้ประกอบการ(EN)'.' :', ['class' => 'col-md-3 control-label'])) !!}
       <div class="col-md-8">
             {!! Form::text('name_en',   (!empty($user->name_en) ? $user->name_en : null), ['class' => 'form-control',   'disabled' => true]) !!}
            {!! $errors->first('name_en', '<p class="help-block">:message</p>') !!} 
         </div>
    </div>
 </div>
 <div class="col-sm-12">
    <div class="form-group {{ $errors->has('tax_number') ? 'has-error' : ''}}">
         {!! HTML::decode(Form::label('tax_number', 'เลขประจำตัวผู้เสียภาษี'.' :', ['class' => 'col-md-3 control-label'])) !!}
         <div class="col-md-3">
             {!! Form::text('tax_number',   (!empty($user->tax_number) ? $user->tax_number : null), ['class' => 'form-control',   'disabled' => true]) !!}
            {!! $errors->first('tax_number', '<p class="help-block">:message</p>') !!} 
         </div>
         {!! HTML::decode(Form::label('date_of_birth', 'วันที่เกิด'.' :', ['class' => 'col-md-2 control-label'])) !!}
         <div class="col-md-3">
             {!! Form::text('date_of_birth',   (!empty($user->date_of_birth) ? HP::DateThai($user->date_of_birth) : null), ['class' => 'form-control',   'disabled' => true]) !!}
            {!! $errors->first('date_of_birth', '<p class="help-block">:message</p>') !!} 
         </div>
    </div>
 </div>
 <div class="col-sm-12">
    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
         {!! HTML::decode(Form::label('email', 'E-mail'.' :', ['class' => 'col-md-3 control-label'])) !!}
         <div class="col-md-3">
             {!! Form::text('email',   (!empty($user->email) ? $user->email : null), ['class' => 'form-control',   'disabled' => true]) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!} 
         </div>
    </div>
 </div>
<!-- end ข้อมูลส่วนตัว -->
 </div>


 <div class="col-sm-12">
    <!-- start ที่อยู่ -->
    <h3 class="box-title">ที่อยู่</h3>
    <hr>
    
    <div class="col-sm-12">
       <div class="form-group {{ $errors->has('address_no') ? 'has-error' : ''}}">
          {!! HTML::decode(Form::label('address_no', 'ที่อยู่'.' :', ['class' => 'col-md-2 control-label'])) !!}
          <div class="col-md-10">
                {!! Form::text('address_no',   (!empty($user->address_no) ? $user->address_no : null), ['class' => 'form-control',   'disabled' => true]) !!}
               {!! $errors->first('address_no', '<p class="help-block">:message</p>') !!} 
            </div>
       </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group {{ $errors->has('soi') ? 'has-error' : ''}}">
           {!! HTML::decode(Form::label('soi', 'ตรอก/ซอย'.' :', ['class' => 'col-md-2 control-label'])) !!}
           <div class="col-md-3">
                 {!! Form::text('soi',   (!empty($user->soi) ? $user->soi : null), ['class' => 'form-control',   'disabled' => true]) !!}
                {!! $errors->first('soi', '<p class="help-block">:message</p>') !!} 
            </div>
            {!! HTML::decode(Form::label('moo', 'หมู่'.' :', ['class' => 'col-md-1 control-label'])) !!}
            <div class="col-md-2">
                  {!! Form::text('moo',   (!empty($user->moo) ? $user->moo : null), ['class' => 'form-control',   'disabled' => true]) !!}
                 {!! $errors->first('moo', '<p class="help-block">:message</p>') !!} 
             </div>
             {!! HTML::decode(Form::label('street', 'ถนน'.' :', ['class' => 'col-md-1 control-label'])) !!}
             <div class="col-md-3">
                   {!! Form::text('street',   (!empty($user->street) ? $user->street : null), ['class' => 'form-control',   'disabled' => true]) !!}
                  {!! $errors->first('street', '<p class="help-block">:message</p>') !!} 
              </div>
        </div>
     </div>
     <div class="col-sm-12">
        <div class="form-group {{ $errors->has('subdistrict') ? 'has-error' : ''}}">
           {!! HTML::decode(Form::label('subdistrict', 'แขวง/ตำบล'.' :', ['class' => 'col-md-2 control-label'])) !!}
           <div class="col-md-4">
                 {!! Form::text('subdistrict',   (!empty($user->subdistrict) ? $user->subdistrict : null), ['class' => 'form-control',   'disabled' => true]) !!}
                {!! $errors->first('subdistrict', '<p class="help-block">:message</p>') !!} 
            </div>
            {!! HTML::decode(Form::label('district', 'เขต/อำเภอ'.' :', ['class' => 'col-md-2 control-label'])) !!}
            <div class="col-md-4">
                  {!! Form::text('district',   (!empty($user->district) ? $user->district : null), ['class' => 'form-control',   'disabled' => true]) !!}
                 {!! $errors->first('district', '<p class="help-block">:message</p>') !!} 
             </div>
        </div>
     </div>
     <div class="col-sm-12">
        <div class="form-group {{ $errors->has('province') ? 'has-error' : ''}}">
           {!! HTML::decode(Form::label('province', 'จังหวัด'.' :', ['class' => 'col-md-2 control-label'])) !!}
           <div class="col-md-4">
                 {!! Form::text('province',   (!empty($user->province) ? $user->province : null), ['class' => 'form-control',   'disabled' => true]) !!}
                {!! $errors->first('province', '<p class="help-block">:message</p>') !!} 
            </div>
            {!! HTML::decode(Form::label('zipcode', 'รหัสไปรษณีย์'.' :', ['class' => 'col-md-2 control-label'])) !!}
            <div class="col-md-4">
                  {!! Form::text('zipcode',   (!empty($user->zipcode) ? $user->zipcode : null), ['class' => 'form-control',   'disabled' => true]) !!}
                 {!! $errors->first('zipcode', '<p class="help-block">:message</p>') !!} 
             </div>
        </div>
     </div>
     <div class="col-sm-12">
        <div class="form-group {{ $errors->has('tel') ? 'has-error' : ''}}">
           {!! HTML::decode(Form::label('tel', 'เบอร์โทรศัพท์'.' :', ['class' => 'col-md-2 control-label'])) !!}
           <div class="col-md-4">
                 {!! Form::text('tel',   (!empty($user->tel) ? $user->tel : null), ['class' => 'form-control',   'disabled' => true]) !!}
                {!! $errors->first('tel', '<p class="help-block">:message</p>') !!} 
            </div>
            {!! HTML::decode(Form::label('fax', 'เบอร์โทรสาร'.' :', ['class' => 'col-md-2 control-label'])) !!}
            <div class="col-md-4">
                  {!! Form::text('fax',   (!empty($user->fax) ? $user->fax : null), ['class' => 'form-control',   'disabled' => true]) !!}
                 {!! $errors->first('fax', '<p class="help-block">:message</p>') !!} 
             </div>
        </div>
     </div>
    <!-- end ที่อยู่ -->
     </div>
    
 <div class="col-sm-12">
   <h3 class="box-title">เลขทะเบียนผู้ประเมิน</h3>
   <hr>
  <!-- start เลขทะเบียนผู้ประเมิน -->   
<div class="col-sm-12">
       <div class="form-group {{ $errors->has('information[regis_number]') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('information[regis_number]', 'เลขทะเบียนผู้ประเมิน'.' :<span class="text-danger">*</span> ', ['class' => 'col-md-3 control-label'])) !!}
           <div class="col-md-8">
                {!! Form::text('information[regis_number]',  
                 (!empty($information->number_auditor) ? $information->number_auditor : null),
                  ['class' => 'form-control text-center', 
                  'placeholder'=>'กรอกเลขทะเบียนผู้ประเมิน', 
                   'required' =>   (!empty($information->number_auditor) ?  false : true),
                   'readonly' =>   (!empty($information->number_auditor) ?  true   : false)
                  ]) !!}
                {!! $errors->first('information[regis_number]', '<p class="help-block">:message</p>') !!} 
          </div>
      </div>
</div>
<div class="col-sm-12">
   <div class="form-group {{ $errors->has('information[department]') ? 'has-error' : ''}}">
      {!! HTML::decode(Form::label('information[department]', 'หน่วยงาน'.' :<span class="text-danger">*</span> ', ['class' => 'col-md-3 control-label'])) !!}
      <div class="col-md-8">
          {!! Form::select('information[department]', 
          App\Models\Basic\Department::orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id'),
          (!empty($information->department_id) ? $information->department_id : null),
          ['class' => 'form-control',
          'id' => 'department',
          'required' => true , 
          'placeholder'=>'- เลือกหน่วยงาน -' ]); !!}
           {!! $errors->first('information[department]', '<p class="help-block">:message</p>') !!} 
     </div>
   </div>
</div>
<div class="col-sm-12">
       <div class="form-group {{ $errors->has('information[position]') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('information[position]', 'ตำแหน่ง'.' :<span class="text-danger">*</span> ', ['class' => 'col-md-3 control-label'])) !!}
           <div class="col-md-8">
                {!! Form::text('information[position]',   (!empty($information->position) ? $information->position : null), ['class' => 'form-control', 'placeholder'=>'', 'required' => true]) !!}
                {!! $errors->first('information[position]', '<p class="help-block">:message</p>') !!} 
          </div>
      </div>
</div>
<div class="col-sm-12">
       <div class="form-group {{ $errors->has('information[choice]') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('information[choice]', 'เจ้าหน้าที่ AB'.' : ', ['class' => 'col-md-3 control-label'])) !!}
           <div class="col-md-8">
                {!! Form::checkbox('choice', '2',(!empty($information->status_ab) && $information->status_ab == 1  ?  true :  false)  , ['class'=>'check','data-checkbox'=>"icheckbox_flat-red",'id'=>"choice"]) !!} Yes
          </div>
      </div>
</div>
<div class="col-sm-12 " id="group_space">
       <div class="form-group {{ $errors->has('information[group]') ? 'has-error' : ''}}">
            {!! HTML::decode(Form::label('information[group]', 'กลุ่ม'.' : <span class="text-danger">*</span>', ['class' => 'col-md-3 control-label'])) !!}
           <div class="col-md-8">
           {!! Form::select('information[group]', 
            ['1'=>'CB','2'=>'IB','3'=>'LAB 1 //ทดสอบ','4'=>'LAB 2 //ทดสอบ','5'=>'LAB 3 //สอบเทียบ'], 
            (!empty($information->group_id) ? $information->group_id : null),
            ['class' => 'form-control',
            'id' => 'group',
            'required' => false , 
            'placeholder'=>'- เลือกกลุ่ม -' ]); !!}
             <p class="text-center">(เฉพาะเลือก AB เท่านั้น)</p>
           {!! $errors->first('group', '<p class="help-block">:message</p>') !!} 
          </div>
      </div>
</div>

<div class="col-sm-12">
    <div class="form-group {{ $errors->has('information[onOrOff]') ? 'has-error' : ''}}">
          {!! HTML::decode(Form::label('information[onOrOff]', 'สถานะ'.' : ', ['class' => 'col-md-3 control-label'])) !!}
          <div class="col-md-8">
              <label>{!! Form::radio('information[onOrOff]', '1', (!empty($information->onOrOff)  ?  false :  true), ['class'=>'check', 'data-radio'=>'iradio_square-green']) !!} เปิด</label>
              <label>{!! Form::radio('information[onOrOff]', '0',   (!empty($information->onOrOff) ? true : false), ['class'=>'check', 'data-radio'=>'iradio_square-red']) !!} ปิด</label>
          </div>
      </div>
 </div>
<!-- end เลขทะเบียนผู้ประเมิน -->
 </div>
 <hr>
 <div class="row">
    <div class="col-xs-12">
         <div class="tab" role="tabpanel">
                  <!-- Nav tabs -->
                  <ul class="nav nav-pills" role="tablist">
                    <li class="tab active">
                        <a data-toggle="tab" href="#education" aria-expanded="true"> 
                          <span><i class='fa fa-graduation-cap'></i></span>
                            การศึกษา
                       </a>
                    </li>
                    <li class="tab  ">
                      <a data-toggle="tab" href="#training" aria-expanded="false"> 
                          <span><i class='fa fa-book'></i></span>
                          การฝึกอบรม
                      </a>
                    </li>
                    <li class="tab  ">
                      <a data-toggle="tab" href="#expertise" aria-expanded="false"> 
                          <span><i class='fa fa-child'></i></span>
                          ความเชี่ยวชาญ
                      </a>
                    </li>
                    <li class="tab ">
                      <a data-toggle="tab" href="#experience" aria-expanded="false"> 
                          <span><i class='fa fa-building'></i></span>
                          ประสบการณ์การทำงาน
                      </a>
                    </li>
                    <li class="tab ">
                      <a data-toggle="tab" href="#assessment_experience" aria-expanded="false"> 
                          <span><i class='fa fa-medkit'></i></span>
                          ประสบการณ์การตรวจประเมิน
                      </a>
                    </li>
                </ul>
                <div class="tab-content">
                   <div role="education" class="tab-pane fade in active" id="education">
                        @include ('auditors.education') 
                    </div>
                    <div id="training" class="tab-pane">
                        @include ('auditors.training') 
                    </div>
                    <div id="expertise" class="tab-pane ">
                        @include ('auditors.expertise') 
                    </div>
                    <div id="experience" class="tab-pane ">
                       @include ('auditors.experience') 
                    </div>
                    <div id="assessment_experience" class="tab-pane  ">
                        @include ('auditors.assessment_experience') 
                    </div>
                </div>

            </div>
      </div>
 </div>




            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
                <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  value="1"    {{ (isset($information->checkbox_confirm) && $information->checkbox_confirm == 1) ? 'checked': '' }}>
            <label for="checkbox_confirm"  >
                    &nbsp;  ยอมรับเงื่อนไข
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b><< Click >></b> </button>
            </label>
        </div>
    </div>
</div> --}}

<div class="row">
    <div id="div_sign_up">
        <div class="form-group">
            <div class="col-md-12">
                <div class="checkbox checkbox-primary p-t-0 p-l-4">
                    <input type="checkbox" class="checkbox_confirm" name="checkbox_confirm" id="checkbox_confirm" value="1" required {{ (isset($information->checkbox_confirm) && $information->checkbox_confirm == 1) ? 'checked': '' }}>
                    <label for="checkbox_confirm"> &nbsp;&nbsp;ข้าพเจ้าขอรับรองว่าข้อมูลในใบสมัครฉบับนี้มีความครบถ้วน ถูกต้อง และตรงตามความเป็นจริงทุกประการ และยินยอมให้สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมจัดเก็บข้อมูล เผยแพร่ และส่งต่อเพื่อใช้งานต่อไปตาม<a href="{!! asset('downloads/policy/1-TISI_Privacy_Policy.pdf') !!}" target="_blank">นโยบายการคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy) สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</a></label>
                </div>
            </div>
        </div>
   </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                &nbsp;
                <br>
                &nbsp;
                <br>
                &nbsp;
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
  </div>
 
 
{{-- </div> --}}
    <div class="form-group">
        <div class="col-md-offset-3 col-md-6 text-center">
            <button class="btn btn-primary" name="submit" type="submit"   id="send_data"    {{ (isset($information->checkbox_confirm) && $information->checkbox_confirm == 1) ? '' : 'disabled' }}> 
            <i class="fa fa-paper-plane"></i> บันทึก
            </button>
            @can('view-'.str_slug('acc-auditors'))
                <a class="btn btn-default" href="{{url('/home')}}">
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
    <script src="{{asset('plugins/components/sweet-alert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.js')}}"></script>
    <script src="{{asset('plugins/components/toast-master/js/jquery.toast.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {

            $('#checkbox_confirm').click(function(){
                // $('#send_data').toggleClass('btn-success btn-primary ', 'btn-primary btn-success');
                if($(this).prop('checked')){
                    $('#send_data').attr('disabled',false);
                }else{
                    $('#send_data').attr('disabled',true);
                }
            });

        $('#title').change(function () {
             const select = $(this).val();
             $('#title_en_js').val(select).select2();
         })
         $('#title').change();

         
         $("#choice").on("ifChanged",function(){
             if($(this).prop('checked')){
                     $('#group_space').fadeIn ();
                     $('#group').prop('required',true);
              }else{
                     $('#group_space').fadeOut();    
                     $('#group').prop('required',false);
              }
          })
          $('#group_space').fadeOut();
          @if (!empty($information->status_ab) && $information->status_ab == 1)
                $('#group_space').fadeIn();
                 $('#group').prop('required',true );    
          @endif
 

        @if(\Session::has('message'))
      
            $.toast({
                heading: 'Success!',
                position: 'top-center',
                text: '{{session()->get('message')}}',
                loaderBg: '#70b7d6',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
        @endif

    });
 </script>     
    <script type="text/javascript">
 
      

        function checkNone(value) {
            return value !== '' && value !== null && value !== undefined;
        }
        function DateFormateTh(str){
            var arr_mount = {} ;
                arr_mount['01']  = 'ม.ค.';
                arr_mount['02']  = 'ก.พ.';
                arr_mount['03']  = 'มี.ค.';
                arr_mount['04']  = 'เม.ษ.';
                arr_mount['05']  = 'พ.ค.';
                arr_mount['06']  = 'มิ.ย.';
                arr_mount['07']  = 'ก.ค.';
                arr_mount['08']  = 'ส.ค.';
                arr_mount['09']  = 'ก.ย.';
                arr_mount['10']  = 'ต.ค.';
                arr_mount['11']  = 'พ.ย.';
                arr_mount['12']  = 'ธ.ค.';
              var appoint_date=str;
              var getdayBirth=appoint_date.split("/");
              var YB=getdayBirth[2];
              var MB=getdayBirth[1];
              var DB=getdayBirth[0];
              var date = DB+' '+arr_mount[MB]+' '+YB ;
              return date;
          }

    </script>
@endpush
