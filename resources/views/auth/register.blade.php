@extends('layouts.app')

@section('content')
@push('css')
    <link href="{{asset('plugins/components/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/components/bootstrap-datepicker-thai/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
    <style>
    .login-register {
        background: url("{{asset('plugins/images/login-register.jpg')}}") center center/cover no-repeat !important;
        height: 100%;
        position: static;
    }
    </style>
@endpush
<section id="wrapper" class="login-register">
    <div style="width:80%; display: block; margin: auto;">
        <div class="white-box">
            <form class="form-horizontal" id="loginform" method="POST" action="{{ route('register') }}">
                {{csrf_field()}}
                <h3 class="box-title">ลงทะเบียน</h3>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label class="radio-inline">
                            <input type="radio" name="trader_type" id="trader_type1" value="นิติบุคคล" checked> นิติบุคคล
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="trader_type" id="trader_type2" value="บุคคลธรรมดา"> บุคคลธรรมดา
                        </label>
                    </div>
                    <div class="col-xs-6">
                        <select id="trader_inti" class="form-control{{ $errors->has('trader_inti') ? ' is-invalid' : '' }}" name="trader_inti" value="{{ old('trader_inti') }}" required autofocus>
                            <option value="">=== เลือกประเภทการจดทะเบียน ===</option>
                            <option value="บริษัท จำกัด"> บริษัท จำกัด </option>
                            <option value="บริษัท จำกัด มหาชน"> บริษัท จำกัด มหาชน </option>
                            <option value="ห้างหุ้นส่วนจำกัด"> ห้างหุ้นส่วนจำกัด </option>
                            <option value="รัฐวิสาหกิจ"> รัฐวิสาหกิจ </option>
                            <option value="อื่น ๆ"> อื่น ๆ </option>
                        </select>
                        @if ($errors->has('trader_inti'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('trader_inti') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-6">
                        <input id="trader_operater_name" type="text" class="form-control{{ $errors->has('trader_operater_name') ? ' is-invalid' : '' }}" placeholder="ชื่อสถานประกอบการ : พิมพ์ภาษาไทย เท่านั้น เช่น บริษัท ตัวอย่าง จำกัด" name="trader_operater_name" value="{{ old('trader_operater_name') }}" required autofocus>
                        @if ($errors->has('trader_operater_name'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('trader_operater_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-xs-4">
                        <input id="trader_id" type="text" class="form-control{{ $errors->has('trader_id') ? ' is-invalid' : '' }}" placeholder="เลขนิติบุคคล" name="trader_id" value="{{ old('trader_id') }}" required autofocus>

                        @if ($errors->has('trader_id'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('trader_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-xs-2" id="for_date_niti">
                        <div class="input-group">
                           <input id="trader_id_register" type="text" class="form-control {{ $errors->has('trader_id_register') ? ' is-invalid' : '' }} datepicker" placeholder=" วันที่จดทะเบียน นิติบุคคล" name="trader_id_register" value="{{ old('trader_id_register') }}" required>
                            <span class="input-group-addon"><i class="icon-calender"></i></span>
                        @if ($errors->has('trader_id_register'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_id_register') }}</strong>
                                    </span>
                        @endif
                        </div>
                    </div>
                </div>

                <h5 class="box-title" style="font-size: 20px;">Email และ Password สำหรับเข้าสู่ระบบ</h5>

                <div class="form-group">
                    <div class="col-xs-6">
                        <input id="trader_username" type="email" class="form-control" name="trader_username" placeholder="Email" required onblur="checkmailexits(this.value)">
                    </div>
                    <div class="col-xs-6">
                        <input id="trader_password" type="password" class="form-control" name="trader_password" placeholder="Password" required>
                    </div>
                </div>

                <h5 class="box-title" style="font-size: 20px;">ที่อยู่ ตามที่จดทะเบียน</h5>

                <div class="form-group ">
                    <div class="col-xs-3">
                        <input id="trader_address" type="text" class="form-control{{ $errors->has('trader_address') ? ' is-invalid' : '' }}" placeholder="เลขที่ / อาคาร ชั้น" name="trader_address" value="{{ old('trader_address') }}" required autofocus>

                        @if ($errors->has('trader_address'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="col-xs-3">
                        <input id="trader_address_soi" type="text" class="form-control{{ $errors->has('trader_address_soi') ? ' is-invalid' : '' }}" placeholder="ซอย/ตรอก" name="trader_address_soi" value="{{ old('trader_address_soi') }}" required autofocus>

                        @if ($errors->has('trader_address_soi'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address_soi') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-xs-3">
                        <input id="trader_address_road" type="text" class="form-control{{ $errors->has('trader_address_road') ? ' is-invalid' : '' }}" name="trader_address_road" placeholder="ถนน" value="{{ old('trader_address_road') }}" required>

                        @if ($errors->has('trader_address_road'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address_road') }}</strong>
                                    </span>
                        @endif
                    </div>
                      <div class="col-xs-3">
                        <input id="trader_address_moo" type="text" class="form-control{{ $errors->has('trader_address_moo') ? ' is-invalid' : '' }}" name="trader_address_moo" placeholder="หมู่" value="{{ old('trader_address_moo') }}" required>

                        @if ($errors->has('trader_address_moo'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address_moo') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-3">
                        <input id="trader_address_tumbol" type="text" class="form-control{{ $errors->has('trader_address_tumbol') ? ' is-invalid' : '' }}" name="trader_address_tumbol" placeholder="ตำบล/แขวง" value="{{ old('trader_address_tumbol') }}" required>

                        @if ($errors->has('trader_address_tumbol'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address_tumbol') }}</strong>
                                    </span>
                        @endif
                    </div>
                      <div class="col-xs-3">
                        <input id="trader_address_amphur" type="text" class="form-control{{ $errors->has('trader_address_amphur') ? ' is-invalid' : '' }}" name="trader_address_amphur" placeholder="อำเภอ/เขต" value="{{ old('trader_address_amphur') }}" required>

                        @if ($errors->has('trader_address_amphur'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address_amphur') }}</strong>
                                    </span>
                        @endif
                    </div>

                <div class="col-xs-3">

                        <select id="trader_provinceID" class="form-control{{ $errors->has('trader_provinceID') ? ' is-invalid' : '' }}" name="trader_provinceID" value="{{ old('trader_provinceID') }}" required autofocus>

                        <option value="">=== เลือกจังหวัด ===</option>
                                    <option value="กรุงเทพมหานคร   ">กรุงเทพมหานคร   </option>
                                    <option value="สมุทรปราการ   ">สมุทรปราการ   </option>
                                    <option value="นนทบุรี   ">นนทบุรี   </option>
                                    <option value="ปทุมธานี   ">ปทุมธานี   </option>
                                    <option value="พระนครศรีอยุธยา   ">พระนครศรีอยุธยา   </option>
                                    <option value="อ่างทอง   ">อ่างทอง   </option>
                                    <option value="ลพบุรี   ">ลพบุรี   </option>
                                    <option value="สิงห์บุรี   ">สิงห์บุรี   </option>
                                    <option value="ชัยนาท   ">ชัยนาท   </option>
                                    <option value="สระบุรี">สระบุรี</option>
                                    <option value="ชลบุรี   ">ชลบุรี   </option>
                                    <option value="ระยอง   ">ระยอง   </option>
                                    <option value="จันทบุรี   ">จันทบุรี   </option>
                                    <option value="ตราด   ">ตราด   </option>
                                    <option value="ฉะเชิงเทรา   ">ฉะเชิงเทรา   </option>
                                    <option value="ปราจีนบุรี   ">ปราจีนบุรี   </option>
                                    <option value="นครนายก   ">นครนายก   </option>
                                    <option value="สระแก้ว   ">สระแก้ว   </option>
                                    <option value="นครราชสีมา   ">นครราชสีมา   </option>
                                    <option value="บุรีรัมย์   ">บุรีรัมย์   </option>
                                    <option value="สุรินทร์   ">สุรินทร์   </option>
                                    <option value="ศรีสะเกษ   ">ศรีสะเกษ   </option>
                                    <option value="อุบลราชธานี   ">อุบลราชธานี   </option>
                                    <option value="ยโสธร   ">ยโสธร   </option>
                                    <option value="ชัยภูมิ   ">ชัยภูมิ   </option>
                                    <option value="อำนาจเจริญ   ">อำนาจเจริญ   </option>
                                    <option value="หนองบัวลำภู   ">หนองบัวลำภู   </option>
                                    <option value="ขอนแก่น   ">ขอนแก่น   </option>
                                    <option value="อุดรธานี   ">อุดรธานี   </option>
                                    <option value="เลย   ">เลย   </option>
                                    <option value="หนองคาย   ">หนองคาย   </option>
                                    <option value="มหาสารคาม   ">มหาสารคาม   </option>
                                    <option value="ร้อยเอ็ด   ">ร้อยเอ็ด   </option>
                                    <option value="กาฬสินธุ์   ">กาฬสินธุ์   </option>
                                    <option value="สกลนคร   ">สกลนคร   </option>
                                    <option value="นครพนม   ">นครพนม   </option>
                                    <option value="มุกดาหาร   ">มุกดาหาร   </option>
                                    <option value="เชียงใหม่   ">เชียงใหม่   </option>
                                    <option value="ลำพูน   ">ลำพูน   </option>
                                    <option value="ลำปาง   ">ลำปาง   </option>
                                    <option value="อุตรดิตถ์   ">อุตรดิตถ์   </option>
                                    <option value="แพร่   ">แพร่   </option>
                                    <option value="น่าน   ">น่าน   </option>
                                    <option value="พะเยา   ">พะเยา   </option>
                                    <option value="เชียงราย   ">เชียงราย   </option>
                                    <option value="แม่ฮ่องสอน   ">แม่ฮ่องสอน   </option>
                                    <option value="นครสวรรค์   ">นครสวรรค์   </option>
                                    <option value="อุทัยธานี   ">อุทัยธานี   </option>
                                    <option value="กำแพงเพชร   ">กำแพงเพชร   </option>
                                    <option value="ตาก   ">ตาก   </option>
                                    <option value="สุโขทัย   ">สุโขทัย   </option>
                                    <option value="พิษณุโลก   ">พิษณุโลก   </option>
                                    <option value="พิจิตร   ">พิจิตร   </option>
                                    <option value="เพชรบูรณ์   ">เพชรบูรณ์   </option>
                                    <option value="ราชบุรี   ">ราชบุรี   </option>
                                    <option value="กาญจนบุรี   ">กาญจนบุรี   </option>
                                    <option value="สุพรรณบุรี   ">สุพรรณบุรี   </option>
                                    <option value="นครปฐม   ">นครปฐม   </option>
                                    <option value="สมุทรสาคร   ">สมุทรสาคร   </option>
                                    <option value="สมุทรสงคราม   ">สมุทรสงคราม   </option>
                                    <option value="เพชรบุรี   ">เพชรบุรี   </option>
                                    <option value="ประจวบคีรีขันธ์   ">ประจวบคีรีขันธ์   </option>
                                    <option value="นครศรีธรรมราช   ">นครศรีธรรมราช   </option>
                                    <option value="กระบี่   ">กระบี่   </option>
                                    <option value="พังงา   ">พังงา   </option>
                                    <option value="ภูเก็ต   ">ภูเก็ต   </option>
                                    <option value="สุราษฎร์ธานี   ">สุราษฎร์ธานี   </option>
                                    <option value="ระนอง   ">ระนอง   </option>
                                    <option value="ชุมพร   ">ชุมพร   </option>
                                    <option value="สงขลา   ">สงขลา   </option>
                                    <option value="สตูล   ">สตูล   </option>
                                    <option value="ตรัง   ">ตรัง   </option>
                                    <option value="พัทลุง   ">พัทลุง   </option>
                                    <option value="ปัตตานี   ">ปัตตานี   </option>
                                    <option value="ยะลา   ">ยะลา   </option>
                                    <option value="นราธิวาส   ">นราธิวาส   </option>
                                    <option value="บึงกาฬ">บึงกาฬ</option>
                                </select>
                        @if ($errors->has('trader_provinceID'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_provinceID') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-xs-3">
                        <input id="trader_address_poscode" type="text" class="form-control{{ $errors->has('trader_address_poscode') ? ' is-invalid' : '' }}" placeholder="รหัสไปรษณีย์" name="trader_address_poscode" required>

                        @if ($errors->has('trader_address_poscode'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_address_poscode') }}</strong>
                                    </span>
                        @endif
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-xs-3">
                        <input id="trader_phone" type="text" class="form-control{{ $errors->has('trader_phone') ? ' is-invalid' : '' }}" placeholder="หมายเลขโทรศัพท์" name="trader_phone" required>

                        @if ($errors->has('trader_phone'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_phone') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-xs-3">
                        <input id="trader_phone_to" type="text" class="form-control{{ $errors->has('trader_phone_to') ? ' is-invalid' : '' }}" placeholder="ต่อ" name="trader_phone_to" required>

                        @if ($errors->has('trader_phone_to'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_phone_to') }}</strong>
                                    </span>
                        @endif
                    </div>


                    <div class="col-xs-3">
                        <input id="trader_fax" type="text" class="form-control{{ $errors->has('trader_fax') ? ' is-invalid' : '' }}" placeholder="หมายเลขโทรสาร" name="trader_fax" required>

                        @if ($errors->has('trader_fax'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_fax') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-xs-3">
                        <input id="trader_fax_to" type="text" class="form-control{{ $errors->has('trader_fax_to') ? ' is-invalid' : '' }}" placeholder="ต่อ" name="trader_fax_to" required>

                        @if ($errors->has('trader_fax_to'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_fax_to') }}</strong>
                                    </span>
                        @endif
                    </div>

                </div>

                <div class="form-group ">
                    <div class="col-xs-3">
                        <input id="trader_mobile" type="text" class="form-control{{ $errors->has('trader_mobile') ? ' is-invalid' : '' }}" placeholder="โทรศัพท์มือถือ" name="trader_mobile" required>

                        @if ($errors->has('trader_mobile'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('trader_mobile') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-xs-3"></div>

                    <div class="col-xs-6">
                        <input id="agent_email" type="agent_email" class="form-control{{ $errors->has('agent_email') ? ' is-invalid' : '' }}" placeholder="Email สำหรับติดต่อ" name="agent_email" required readonly>

                        @if ($errors->has('agent_email'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('agent_email') }}</strong>
                                    </span>
                        @endif
                        <span style="color: red; font-size: 16px;"> * ควรเป็น E-mail ที่ใช้งานได้จริง เพื่อรับข่าวสารจาก สมอ.</span>
                    </div>

                </div>

                <span style="color: red;"> * กรุณากรอกหมายเลขโทรศัพท์ ประเภทใดประเภทหนึ่งหรือทั้งหมด เพื่อให้เจ้าหน้าที่สามารถติดต่อกลับได้</span>

                <h5 class="box-title" style="font-size: 20px;">ข้อมูลสำหรับการติดต่อ (Contact information)</h5>

                  <div class="form-group">
                    <div class="col-xs-6">
                        <input id="agent_name" type="text" class="form-control{{ $errors->has('agent_name') ? ' is-invalid' : '' }}" placeholder="ชื่อบุคคลที่ติดต่อ" name="agent_name" required>

                        @if ($errors->has('agent_name'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('agent_name') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="col-xs-6">
                        <input id="agent_mobile" type="text" class="form-control{{ $errors->has('agent_mobile') ? ' is-invalid' : '' }}" placeholder="โทรศัพท์ผู้ติดต่อ" name="agent_mobile" required>

                        @if ($errors->has('agent_mobile'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('agent_mobile') }}</strong>
                                    </span>
                        @endif
                    </div>

                </div>

                <div class="col-md-12">
                      <div class="form-group">
                        <label>เงื่อนไขการใช้งาน และ การลงทะเบียน : </label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-file-text-o"></i>
                          </div>
                            <textarea type="text" class="form-control" name="" id="" rows="8" readonly="" style="font-size: 16px;">
1. จะต้องกรอกข้อมูลให้ครบถ้วน
2. เมื่อระบบได้รับการบันทึกการลงทะเบียน ผู้ใช้งานจะต้อง ยืนยันการใช้งาน และ กรอกข้อมูล ผ่าน e-mail ที่บันทึกข้อมูลไว้
3. ผู้ใช้งานจะต้องกำหนดรหัสผ่าน (Password) ที่มีความปลอดภัยสูง และต้องรักษาความลับของรหัสผ่านของตนเองไว้เป็นอย่างดี ตลอดจน ไม่ปล่อยปละละเลยให้บุคคลอื่นใช้งานบัญชีผู้ใช้งานของตน
4. ผู้ใช้งานจะต้องไม่กระทำการใดๆ ทั้งโดยตั้งใจหรือไม่ตั้งใจ ซึ่งเป็นเหตุทำให้ผู้อื่นเกิดความเสียหาย เสื่อมเสียชื่อเสียง ถูกดูหมิ่นเกลียดชัง และ/หรือ จะต้องไม่กระทำการใดๆ อันเป็นความผิดต่อพระราชบัญญัติว่าด้วยการกระทำความผิดเกี่ยวกับคอมพิวเตอร์ พ.ศ. 2560 และ/หรือ กฎหมายอื่นใดที่กำหนดความผิดเกี่ยวกับการใช้งานคอมพิวเตอร์และการใช้งานเครือข่ายอินเทอร์เน็ต
5. การกรอกข้อมูล และ แนบเอกสารอันเป็นเท็จ หรือ จงใจแนบเอกสารไม่ครบถ้วน ถือเป็นการปกปิดข้อมูล มีความผิดตามกฏหมาย
                            </textarea>
                          </div>
                      </div>
                    </div>


                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary p-t-0">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup"> &nbsp;&nbsp;ได้อ่านและยอมรับเงื่อนไขการใช้งาน การแนบเอกสารไม่ครบถ้วน ถือเป็นการจงใจปกปิดข้อมูล มีความผิดตามกฏหมาย
                                {{-- <a href="#">Terms</a> --}}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="sign_applicant" disabled>ลงทะเบียนผู้ประกอบการ</button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p>Already have an account? <a href="{{route('login')}}" class="text-primary m-l-5"><b>Sign In</b></a>
                            {{-- <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> ลืมรหัสผ่าน?</a>   --}}
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('js')
    <!-- input calendar thai -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <!-- thai extension -->
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('plugins/components/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('form').submit(function() {
                $(this).find("button[type='submit']").prop('disabled',true);
            });

            $('#checkbox-signup').attr('checked', false); // Unchecks it

            $('#checkbox-signup').click(function(){
                if($(this).is(':checked')){
                    $('#sign_applicant').attr('disabled', false);
                } else {
                    $('#sign_applicant').attr('disabled', true);
                }
            });

            // Date Picker Thai
            $('.datepicker').datepicker({
                autoclose: true,
                toggleActive: true,
                todayHighlight: true,
                language:'th-th',
                format: 'dd/mm/yyyy'
            });

            $('input[name="trader_type"]').click(function() {
                if ($('#trader_type1').is(':checked')) {
                    $('#trader_inti').html('');
                        var html = '<option value="">=== เลือกประเภทการจดทะเบียน ===</option>';
                            html += '<option value="บริษัท จำกัด"> บริษัท จำกัด </option>';
                            html += '<option value="บริษัท จำกัด มหาชน"> บริษัท จำกัด มหาชน </option>';
                            html += '<option value="ห้างหุ้นส่วนจำกัด"> ห้างหุ้นส่วนจำกัด </option>';
                            html += '<option value="รัฐวิสาหกิจ"> รัฐวิสาหกิจ </option>';
                            html += '<option value="อื่น ๆ"> อื่น ๆ </option>';
                    $('#trader_inti').append(html);
                    $('#operater_name').attr("placeholder", "ชื่อสถานประกอบการ : พิมพ์ภาษาไทย เท่านั้น เช่น บริษัท ตัวอย่าง จำกัด");
                    $('#trader_id').attr("placeholder", "เลขนิติบุคคล");
                    $('#for_date_niti').show(300);
                } else {
                    $('#trader_inti').html('');
                        var html = '<option value="">=== เลือกคำนำหน้า ===</option>';
                            html += '<option value="นาย"> นาย </option>';
                            html += '<option value="นาง"> นาง </option>';
                            html += '<option value="นางสาว"> นางสาว </option>';
                    $('#trader_inti').append(html);
                    $('#operater_name').attr("placeholder", "ขื่อ - สกุล");
                    $('#trader_id').attr("placeholder", "เลขบัตรประจำตัวประชาชน/Passpost ID");
                    $('#date').val('');
                    $('#for_date_niti').hide(300);
                }
            });
        });

        function checkmailexits(email)
        {
            if(email){
                $('#agent_email').val(email);
                $.ajax({
                    url: "{!! url('auth/checkemailexits') !!}",
                    type: 'POST',
                    data: { email: email, _token: '{{csrf_token()}}' },
                }).done(function(response) {
                    // console.log(response);
                    if(response == "already")
                    {
                    alert("Email Already In Use.");
                    $('#trader_username').val('');
                    $('#agent_email').val('');
                    }
                });
            }

        }
    </script>
@endpush

