<?php

use App\User;
use App\Expert;
use App\Address;
use App\RoleUser;
use Carbon\Carbon;
use App\AttachFile;
use App\Permission;
use App\PermissionRole;
use App\Models\Basic\Tis;
use App\Models\Agents\Agent;
use App\Models\Basic\Amphur;
use App\Models\Basic\Config;
use App\Models\Basic\Zipcode;

use App\Models\Basic\District;
use App\Models\Basic\Province;
use App\Models\Basic\Inspector;

use App\Models\Setting\Sessions;
use App\Models\Basic\TisiLicense;
use App\Models\Agents\AgentSystem;
use Illuminate\Support\Facades\DB;
use App\Models\Setting\SettingSystem;
use Illuminate\Support\Facades\File; 
use App\Models\Basic\TisiLicenseDetail;
use App\Models\Certify\CertifyLogEmail;
use Illuminate\Support\Facades\Storage;
use App\Models\Basic\InspectorInspectorType;
class HP
{
    public static function DateThai($strDate)
    {
        if (is_null($strDate)) {
            return '';
        }
        $strYear = date("Y", strtotime($strDate))+543;
        $strMonth= date("n", strtotime($strDate));
        $strDay= date("j", strtotime($strDate));

        $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];

        return "$strDay $strMonthThai $strYear";
    }

    public static function BEDate($date)
    {
        // แปลงวันที่ให้เป็น Carbon instance
        $carbonDate = Carbon::parse($date);
        
        // คำนวณปีพุทธศักราช
        $buddhistYear = $carbonDate->year + 543;
        
        // คืนค่ารูปแบบวันที่
        return $carbonDate->format('d F') . ' B.E. ' . $buddhistYear . ' (' . $carbonDate->year . ')';
    }


    public static function downloadFileFromTisiCloud($filePath)
    {
        $isExistingFile = self::checkFileStorage($filePath);
        
        if($isExistingFile)
        {
            // dd($isExistingFile);
            return self::getFileStoragePath($filePath); 
        }else
        {
            return null;
        }
    }

    
    public static function DateTimeThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate))+543;
        $strMonth= date("n", strtotime($strDate));
        $strDay= date("j", strtotime($strDate));
        $strHour= date("H", strtotime($strDate));
        $strMinute= date("i", strtotime($strDate));
        $strSeconds= date("s", strtotime($strDate));
        $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute น.";
    }

        //return เป็น path ของเซิร์ฟเวอร์
        static function getFileStoragePath($file_path){

            $result = '';
            $public = Storage::disk('uploads')->getDriver()->getAdapter()->getPathPrefix();
            
            if (is_file($public . $file_path)) { //ถ้ามีไลฟ์ที่พร้อมแสดงอยู่แล้ว
                
                $result = Storage::disk('uploads')->path($file_path);
                // dd($result);
            } else {
    
                $exists = Storage::exists($file_path);
                if ($exists) { //ถ้ามีไฟล์ใน storage
                    $stream = Storage::getDriver()->readStream($file_path);
    
                    $attach = str_replace(basename($file_path), "", $file_path);
    
                    if (!Storage::disk('uploads')->has($attach)) {
                        Storage::disk('uploads')->makeDirectory($attach);
                    }
                    $byte_put = file_put_contents($public . $file_path, stream_get_contents($stream), FILE_APPEND);
                    if ($byte_put !== false) {
                        $result = Storage::disk('uploads')->path($file_path);
                    }
                }
            }
    
            return $result;
    
        }

    public static function formatDateThaiFull($strDate)
    {
        if(is_null($strDate) || $strDate == '' || $strDate == '-' ){
            return '-';
        }
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("m", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $month = ['01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'];
        $strMonthThai = $month[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    public static function DateTimeFullThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute น.";
    }




    public static function MonthList()
    {
        $month = ['01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'];
        return $month;
    }

    public static function MonthShortList()
    {
        $month = ['01'=>'ม.ค.', '02'=>'ก.พ.', '03'=>'มี.ค.', '04'=>'เม.ย.', '05'=>'พ.ค.', '06'=>'มิ.ย.', '07'=>'ก.ค.', '08'=>'ส.ค.', '09'=>'ก.ย.', '10'=>'ต.ค.', '11'=>'พ.ย.', '12'=>'ธ.ค.'];
        return $month;
    }

    public static function YearList()
    {
        $start_year = 2019;
        $end_year = date('Y');

        $year = [];
        for ($i=$start_year; $i <= $end_year; $i++) {
            $year[$i] = $i+543;
        }

        return $year;
    }
    static function Years()
    {
        $years = [];
        for ($start_year = date('Y'); $start_year >= 1880; $start_year--) {
            $year = $start_year + 543;
            $years[$start_year] = $year;
        }

        return $years;

    }


    //แปลงวันที่รูปแบบ 31/01/2018 เป็น 2018-01-31
    public static function convertDate($date, $minus=false)
    {
        $negative = $minus===true?543:0;
        $dates = explode('/', $date);
        return ($dates['2']-$negative).'-'.$dates[1].'-'.$dates[0];
    }

    //แปลงวันที่รูปแบบ 2018-01-31 เป็น 31/01/2018
    public static function revertDate($date, $plus=false)
    {
        $positive = $plus===true?543:0;
        $dates = explode('-', $date);
        return (count($dates)=='3')?$dates['2'].'/'.$dates[1].'/'.($dates[0]+$positive):'';
    }


    public  static function formatDateThai($strDate) {

        if(is_null($strDate) || $strDate == '' || $strDate == '-' ){
            return '-';
        }
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("m", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $month = ['01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'];
        $strMonthThai = $month[$strMonth];
        return "วันที่ $strDay เดือน $strMonthThai พ.ศ. $strYear";
      }

    public static  function formatDateENertify($strDate)
    {
        if(is_null($strDate) || $strDate == '' || $strDate == '-' ){
            return '-';
        }
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("m", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthThai =  self::getMonthEn($strMonth);
        return "$strDay $strMonthThai B.E. ".($strYear+543)." ($strYear)";
    }

    static  function getMonthEn($months)
    {
        $thai_month_arr = array(
            "00" => "",
            "01" => "January",
            "02" => "February",
            "03" => "March",
            "04" => "April",
            "05" => "May",
            "06" => "June",
            "07" => "July",
            "08" => "August",
            "09" => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December"
        );

        return $thai_month_arr[$months];
    }

    public static  function formatDateENFull($strDate)
    {
        if(is_null($strDate) || $strDate == '' || $strDate == '-' ){
            return '-';
        }
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("m", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthThai =  self::getMonthEn($strMonth);
        return "$strDay $strMonthThai $strYear";
    }

    // icon สกุลไฟล์แนบต่างๆ
    static function FileExtension($file) {
            $result = '';
      if(!is_null($file) && $file != ''){
          $type = strrchr(basename($file),".");
          if($type == '.pdf'    || $type ==  '.PDF'){
              $result =  '<i class="fa fa-file-pdf-o" style="font-size:20px; color:red" aria-hidden="true"></i>';
          }elseif($type == '.xlsx'){
              $result =  '<i class="fa  fa-file-excel-o" style="font-size:20px; color:#00b300" aria-hidden="true"></i>';
          }elseif($type == '.doc' || $type == '.docx'){
              $result =  '<i  class="fa fa-file-word-o"  style="font-size:20px; color:#0000ff" aria-hidden="true"></i>';
          }elseif($type == '.png' || $type == '.jpg'  || $type == '.jpeg'){
              $result =  '<i class="fa  fa-file-photo-o" style="font-size:20px; color:#ff9900" aria-hidden="true"></i>';
          }elseif($type == '.zip' || $type == '.7z' ){
              $result =  '<i class="fa fa-file-zip-o" style="font-size:20px; color:#ff0000" aria-hidden="true"></i>';
          }else{
              $result =  '<i class="fa  fa-file-text" style="font-size:20px; color:#92b9b9" aria-hidden="true"></i>';
          }
      }else{
               $result =  '<i class="fa  fa-file-text" style="font-size:20px; color:#92b9b9" aria-hidden="true"></i>';
      }
      return $result;
  }
  static function FileIcon($file, $font_size='20px')
  {
      $result = '';
      if (!is_null($file) && $file != '') {
          $type = strrchr(basename($file), ".");
          if ($type == '.pdf'    || $type ==  '.PDF') {
              $result =  '<i class="fa fa-file-pdf-o" style="font-size:'.$font_size.'; color:red" aria-hidden="true"></i>';
          } elseif ($type == '.xlsx') {
              $result =  '<i class="fa  fa-file-excel-o" style="font-size:'.$font_size.'; color:#00b300" aria-hidden="true"></i>';
          } elseif ($type == '.doc' || $type == '.docx' || $type == '.DOCX'){
              $result =  '<i  class="fa fa-file-word-o"  style="font-size:'.$font_size.'; color:#0000ff" aria-hidden="true"></i>';
          } elseif ($type == '.png' || $type == '.jpg'  || $type == '.jpeg') {
              $result =  '<i class="fa  fa-file-photo-o" style="font-size:'.$font_size.'; color:#ff9900" aria-hidden="true"></i>';
          } elseif ($type == '.zip' || $type == '.7z') {
              $result =  '<i class="fa fa-file-zip-o" style="font-size:'.$font_size.'; color:#ff0000" aria-hidden="true"></i>';
          } else {
              $result =  '<i class="fa  fa-file-text" style="font-size:'.$font_size.'; color:#92b9b9" aria-hidden="true"></i>';
          }
      } else {
          $result =  '<i class="fa  fa-file-text" style="font-size:'.$font_size.'; color:#92b9b9" aria-hidden="true"></i>';
      }
      return $result;
  }
  static function DataStatusCertify()
  {
     $data = ['0'=> 'ฉบับร่าง',
              '1'=> 'รอดำเนินการตรวจ',
              '2'=> 'อยู่ระหว่างการตรวจสอบ',
              '3'=> 'ขอเอกสารเพิ่มเติม',
              '4'=> 'ยกเลิกคำขอ',
              '5'=> 'ไม่ผ่านการตรวจสอบ',
            //   '6'=> 'รอดำเนินการตรวจ',
            //   '7'=> 'รอดำเนินการตรวจ',
            //   '8'=> 'รอดำเนินการตรวจ',
              '9'=> 'รับคำขอ',
              '10'=> 'ประมาณการค่าใช้จ่าย',
              '11'=> 'ขอความเห็นประมาณการค่าใช้จ่าย',
              '12'=> 'อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน',
              '13'=> 'ขอความเห็นแต่งคณะผู้ตรวจประเมิน',
              '14'=> 'เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน',
              '15'=> 'แจ้งรายละเอียดค่าตรวจประเมิน',
              '16'=> 'แจ้งหลักฐานการชำระเงิน',
              '17'=> 'ยืนยันการชำระเงินค่าตรวจประเมิน',
              '18'=> 'ผ่านการตรวจสอบประเมิน',
              '19'=> 'แก้ไขข้อบกพร่อง/ข้อสังเกต',
              '20'=> 'สรุปรายงานและเสนออนุกรรมการฯ',
              '21'=> 'รอยืนยันขอบข่ายตามมติคณะอนุกรรมการ',
              '22'=> 'ยืนยันจัดทำใบรับรอง',
              '23'=> 'แจ้งรายละเอียดการชำระค่าใบรับรอง',
              '24'=> 'แจ้งหลักฐานการชำระค่าใบรับรอง',
              '25'=> 'ยืนยันการชำระเงินค่าใบรับรองและยืนยันความสามารถ',
              '26'=> 'ออกใบรับรอง และ ลงนาม',
              '27'=> 'ลงนามเรียบร้อย',
             ];
    return $data;
  }

    public static function DepartmentTypes()
    {
        return array('1' => 'ผู้ทำ', '2' => 'ผู้ใช้', '3' => 'นักวิชาการ');
    }

    public static function OwnTisList()
    {//รายการมาตรฐานบังคับที่ได้รับใบอนุญาต
        $data_session       =    HP::CheckSession();
        $tax                =  $data_session->tax_number;
        // $tax = auth()->user()->trader_id;
        $licenses = TisiLicense::where("tbl_taxpayer", $tax)->pluck('tbl_tisiNo', 'tbl_tisiNo');

        $tis = Tis::select(
                    DB::raw("CONCAT('มอก.', tb3_Tisno, ' ', ".(new Tis)->getTable().".tb3_TisThainame, ' ', IF(tb3_Tisforce='บ', '(มาตรฐานบังคับ)', '(มาตรฐานทั่วไป)')) AS name, tb3_Tisno")
                  )->whereIn("tb3_Tisno", $licenses)
                   ->pluck('name', 'tb3_Tisno');
        return $tis;
    }

    public static function OwnTisListGeneral()
    { //รายการมาตรฐานบังคับที่ได้รับใบอนุญาต
        $data_session       =    HP::CheckSession();
        $tax                =    $data_session->tax_number;
        // $tax = auth()->user()->trader_id;
        // $tax = "0745559004743";
        $licenses = TisiLicense::whereNotIn("tbl_licenseType", ['น','นค'])->where("tbl_taxpayer", $tax)->pluck('tbl_tisiNo', 'tbl_tisiNo');

        $tis = Tis::select(
            DB::raw("CONCAT('มอก.', tb3_Tisno, ' ', " . (new Tis)->getTable() . ".tb3_TisThainame, ' ', IF(tb3_Tisforce='บ', '(มาตรฐานบังคับ)', '(มาตรฐานทั่วไป)')) AS name, tb3_Tisno")
        )->whereIn("tb3_Tisno", $licenses)
            ->pluck('name', 'tb3_Tisno');

        return $tis;
    }

    public static function OwnTisUnitList()
    {//รายการหน่วยนับตามาตรฐานที่ได้รับใบอนุญาต
          // $tax = auth()->user()->trader_id;
        $data_session       =    HP::CheckSession();
        $tax                =  $data_session->tax_number;
        $licenses = TisiLicense::where("tbl_taxpayer", $tax)->pluck('tbl_tisiNo', 'tbl_tisiNo');//เลขมาตรฐานที่ได้รับอนุญาต

        $tis = Tis::whereIn("tb3_Tisno", $licenses)->with('unit_code')->get();

        $result = [];
        foreach ($tis as $item) {
            $result[$item->tb3_Tisno] = ['id'=>@$item->unit_code->Auto_num, 'title'=>@$item->unit_code->name_unit];
        }

        return $result;
    }

    public static function OwnLicenseByTis($tis_no)
    {//รายการเลขที่ใบอนุญาตของผปก.ตามมาตรฐาน

        // $tax = auth()->user()->trader_id;
        $data_session       =    HP::CheckSession();
        $tax                =  $data_session->tax_number;
        $licenses = TisiLicense::where("tbl_taxpayer", $tax)->where("tbl_tisiNo", $tis_no)->where("tbl_licenseStatus",'1')->get();

        return $licenses;
    }

    public static function OwnLicenseByTisForShow($tis_no)
    {//รายการเลขที่ใบอนุญาตของผปก.ตามมาตรฐาน

        // $tax = auth()->user()->trader_id;
        $data_session       =    HP::CheckSession();
        $tax                =  $data_session->tax_number;
        $licenses = TisiLicense::where("tbl_taxpayer", $tax)->where("tbl_tisiNo", $tis_no)->get();

        return $licenses;
    }

    public static function OwnLicenseByTisNoMoao5($tis_no)
    { //รายการเลขที่ใบอนุญาตของผปก.ตามมาตรฐาน

        // $tax = auth()->user()->trader_id;
        $data_session       =    HP::CheckSession();
        $tax                =  $data_session->tax_number;
        $licenses = TisiLicense::whereNotIn("tbl_licenseType", ['น','นค'])->where("tbl_taxpayer", $tax)->where("tbl_tisiNo", $tis_no)->where("tbl_licenseStatus",'1')->get();

        return $licenses;
    }



    public static function LicenseDetailByLicenseNo($Autono)
    {//รายการรายละเอียดผลิตภัณฑ์ใบอนุญาตตามเลขรันใบอนุญาต

        // $tax = auth()->user()->trader_id;
        // $data_session       =    HP::CheckSession();
        // $tax                =  $data_session->tax_number;
        $license = TisiLicense::where("Autono", $Autono)->first();//ใบอนุญาต

        $details = TisiLicenseDetail::where("licenseNo", $license->tbl_licenseNo)->orderBy('itemNo', 'asc')->get();//รายละเอียดผลิตภัณฑ์ในใบอนุญาต

        return $details;
    }

    public static function License($Autono)
    {//ข้อมูลใบอนุญาต

        $license = TisiLicense::where("Autono", $Autono)->first();//ข้อมูลใบอนุญาต

        return $license;
    }

    public static function getArrayFormSecondLevel($array, $key_value, $key_index=null)
    {//ดึงค่าจาก Array ชั้นที่ 2
        $array_result = array();
        foreach ($array as $array_two) {
            $array_two = (array)$array_two;
            if (is_null($key_index)) {
                $array_result[] = $array_two[$key_value];
            } else {
                $array_result[$array_two[$key_index]] = $array_two[$key_value];
            }
        }
        return $array_result;
    }

    public static function getFileStorage($file_path)
    {//get file from storage

        $result = '';
        $public = Storage::disk('uploads')->getDriver()->getAdapter()->getPathPrefix();
        if (is_file($public.$file_path)) {//ถ้ามีไลฟ์ที่พร้อมแสดงอยู่แล้ว
            // $result = Storage::disk('uploads')->url($file_path);
             $result = url('uploads/'.$file_path);
        } else {
            $exists = Storage::exists($file_path);
            if ($exists) {//ถ้ามีไฟล์ใน storage
                $stream = Storage::getDriver()->readStream($file_path);

                $attach =  str_replace(basename($file_path),"",$file_path);
                // $file = public_path('uploads/'.$attach);
                // if(!is_dir($file)) { // เช็ค โฟลเดอร์
                //    File::makeDirectory($file, true, true); // สร้าง โฟลเดอร์
                //  }
                 if(!Storage::disk('uploads')->has($attach)){
                    Storage::disk('uploads')->makeDirectory($attach) ;
                 }

                $byte_put = file_put_contents($public.$file_path, stream_get_contents($stream), FILE_APPEND);
                if ($byte_put!==false) {
                    // $result = Storage::disk('uploads')->url($file_path);
                    $result = url('uploads/'.$file_path);
                }
            }
        }
        return $result;
    }

    public static function getFileStorageClientName($file_path,$client_name)
    {//get file from storage
        $public = Storage::disk('uploads')->getDriver()->getAdapter()->getPathPrefix();
        $attach =  str_replace(basename($file_path),"",$file_path);
        if(!Storage::disk('uploads')->has($attach)){
           Storage::disk('uploads')->makeDirectory($attach) ;
        }

        if (is_file($public.$attach.$client_name)) {//ถ้ามีไลฟ์ที่พร้อมแสดงอยู่แล้ว
            $result = Storage::disk('uploads')->url($attach.$client_name);
        } else {
            $exists = Storage::exists($file_path);
            if ($exists) {//ถ้ามีไฟล์ใน storage
                $stream = Storage::getDriver()->readStream($file_path);
                $byte_put = file_put_contents($public.$attach.$client_name, stream_get_contents($stream), FILE_APPEND);
                if ($byte_put!==false) {
                    $result = Storage::disk('uploads')->url($file_path);
                }
            }
        }
        return $result;
    }
    public static function checkFileStorage($file_path)
    {//get file from storage

        $result = false;
        $public = Storage::disk('uploads')->getDriver()->getAdapter()->getPathPrefix();

        if (is_file($public.$file_path)) {//ถ้ามีไลฟ์ที่พร้อมแสดงอยู่แล้ว
            $result = true;
        } else {
            $exists = Storage::exists($file_path);
            if ($exists) {//ถ้ามีไฟล์ใน storage
                $result = true;
            }
        }

        return $result;
    }

    static function DateFormatGroupTh($start_date = null,$end_date = null) {
        $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $date = '';
      if(!is_null($start_date) &&!is_null($end_date)){
                 // ปี
                 $StartYear = date("Y", strtotime($start_date)) +543;
                 $EndYear = date("Y", strtotime($end_date)) +543;
                // เดือน
                $StartMonth= date("n", strtotime($start_date));
                $EndMonth= date("n", strtotime($end_date));
                //วัน
                $StartDay= date("j", strtotime($start_date));
                $EndDay= date("j", strtotime($end_date));
                if($StartYear == $EndYear){
                    if($StartMonth == $EndMonth){
                          if($StartDay == $EndDay){
                            $date =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear ;
                          }else{
                            $date =  $StartDay.'-'.$EndDay.' '.$strMonthCut[$StartMonth].' '.$StartYear ;
                          }
                    }else{
                        $date =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
                    }
                }else{
                    $date =  $StartDay.' '.$strMonthCut[$StartMonth].' '.$StartYear.' - '.$EndDay.' '.$strMonthCut[$EndMonth].' '.$EndYear ;
                }
        }
        return $date;
      }


    public static function OtherTypes()
    {//การแจ้งอื่นๆ

        return ['1'=>'แนะนำ', '2'=>'สอบถาม', '3'=>'ขอให้ดำเนินการ', '4'=>'ขอให้ปรับปรุงฐานข้อมูลใบอนุญาต', '5'=>'อื่นๆ'];
    }

    public static function TisList()
    {//รายการมาตรฐาน

        $tis = Tis::select(
                    DB::raw("CONCAT('มอก.', tb3_Tisno, ' ', ".(new Tis)->getTable().".tb3_TisThainame) AS name, ' ', tb3_Tisno")
             )->pluck('name', 'tb3_Tisno');
        return $tis;
    }

    public static function States()
    {
        return ['0'=>'ฉบับร่าง', '1'=>'อยู่ระหว่างดำเนินการ', '2'=>'รับเรื่อง', '3'=>'ไม่รับเรื่อง'];
    }

    public static function StateApplicants()
    {
        return ['0'=>'ฉบับร่าง', '1'=>'ยื่นคำขอ', '2'=>'อยู่ระหว่างดำเนินการ', '3'=>'เอกสารไม่ครบถ้วน', '4'=>'อนุมัติ', '5'=>'ไม่อนุมัติ'];
    }

    public static function StateCss()
    {
        return ['0'=>'label-default', '1'=>'label-info', '2'=>'label-success', '3'=>'label-danger'];
    }

    public static function InformCloses()
    {
        return ['0'=>'เปิดการแจ้งปริมาณ', '1'=>'ปิดการแจ้งปริมาณ'];
    }

    //Config ระบบ
    static function getConfig($cache = true)
    {

        $key    = __CLASS__.__FUNCTION__;
        $result = new stdClass();

        if(session()->exists($key) && $cache){//มีข้อมูลที่เก็บไว้ใน session แล้ว
            $result = session($key, (object)[]);
        }else{

            $generalList = Config::select(['variable', 'data'])->get();
            
            foreach ($generalList as $general) {
                $variable = $general->variable;
                $result->$variable = $general->data;
            }
            session([$key => $result]);
        }
        // dd(session()->all());
        return $result;
    }



    //ผู้ตรวจ รับค่าประเภทผู้ตรวจ
    public static function InspectorList($inspector_types=['1', '2', '3'])
    {
        $inspector_ids = InspectorInspectorType::whereIn('inspector_type_id', $inspector_types)->pluck('inspector_id', 'id')->toArray();

        return $inspector_list = Inspector::whereIn('id', $inspector_ids)->where('state', '1')->pluck('title', 'id')->toArray();
    }

    //
    public static function html_cut($text, $max_length)
    {
        $tags   = array();
        $result = "";

        $is_open   = false;
        $grab_open = false;
        $is_close  = false;
        $in_double_quotes = false;
        $in_single_quotes = false;
        $tag = "";

        $i = 0;
        $stripped = 0;

        $stripped_text = strip_tags($text);

        while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length) {
            $symbol  = $text{$i};
            $result .= $symbol;

            switch ($symbol) {
           case '<':
                $is_open   = true;
                $grab_open = true;
                break;

           case '"':
               if ($in_double_quotes) {
                   $in_double_quotes = false;
               } else {
                   $in_double_quotes = true;
               }

            break;

            case "'":
              if ($in_single_quotes) {
                  $in_single_quotes = false;
              } else {
                  $in_single_quotes = true;
              }

            break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes) {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open) {
                    $grab_open = false;
                } else {
                    $stripped++;
                }

                break;

            case '>':
                if ($is_open) {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                } elseif ($is_close) {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close) {
                    $tag .= $symbol;
                }

                if (!$is_open && !$is_close) {
                    $stripped++;
                }
        }

            $i++;
        }

        while ($tags) {
            $result .= "</".array_pop($tags).">";
        }

        return $result;
    }

    //แปลงเลขที่ใบอนุญาตเป็นชื่อไฟล์
    static function ConvertLicenseNoToFileName($license_no){

        // $license_no = str_replace(' ', '', $license_no);
        // $license_no = str_replace('(', '', $license_no);
        // $license_no = str_replace(')', '', $license_no);
        // $license_no = str_replace('-', '_', $license_no);
        // $license_no = str_replace('/', '_', $license_no);

        $license_no = str_replace('(', '', $license_no);
        $license_no = str_replace(')', '_', $license_no);
        $license_no = str_replace(' ', '', $license_no);
        $license_no = str_replace('-', '_', $license_no);
        $license_no = str_replace('/', '_', $license_no);

        return $license_no;

    }

    static function ConvertCertifyFileName($name){
        $name = str_replace('#', '', $name);
        $name = str_replace('/', '', $name);
        return $name;
    }


    static function TisLicense()
    {

        $tis_license = DB::table('tb4_tisilicense')->groupBy('tbl_tradeName')->pluck('tbl_tradeName');
        return $tis_license;
    }

    static function map_lap_status($id)
    {
        if($id == 1){
            return "นำส่งตัวอย่าง";
        }elseif($id == 2){
            return "อยู่ระหว่างดำเนินการ";
        }elseif($id == 3){
            return "ส่งผลการทดสอบ";
        }elseif($id == 4){
            return "ไม่รับเรื่อง";
        }
        elseif($id == 'ยกเลิก'){
            return "ยกเลิก";
        }elseif($id == '-'){
            return "-";
        }
    }

    static function map_lap_sizedetail($id)
    {
        $data = DB::table('tb4_licensesizedetial')->where('autoNo', $id)->first();
        if ($data != null) {
            return $data->sizeDetial;
        }
    }

    static function map_lap_test_detail2($id,$i,$example_id)
    {
        $data = DB::table('save_example_map_lap_detail')->where('maplap_id', $id)->where('example_id', $example_id)->get();
        if($data != null){
            foreach($data as $datas){
                $str[]  = $datas->test_id;
            }
            if(isset($str)){
                $data2 = DB::table('result_product_detail')->whereIn('id', $str)->get();

                if($data2 != null){
                    $name = '';
                    $j = 0;
                    foreach($data2 as $data2s){
                        $name  .= '<div class="col-md-12"><span style="display:block; float:left;">' . $data2s->name_result . '</span>';
                        if($data2s->type_result == 'Text'){
                            $name .= '<input name="type_detail['.$i.'][]" type="text" class="form-control input-sm"  value="'.$data[$j]->lab_input.'"></div>';
                        }elseif($data2s->type_result == 'ตัวเลข'){
                            $name .= '<input name="type_detail['.$i.'][]" type="number" class="form-control input-sm" value="'.$data[$j]->lab_input.'"></div>';
                        }elseif($data2s->type_result == 'Yes / No'){
                            $name .= '<select name="type_detail['.$i.'][]" class="form-control input-sm" >';

                            if($data[$j]->lab_input != null && $data[$j]->lab_input == 'Yes'){
                                $name .= '<option>'.$data[$j]->lab_input.'</option>';
                                $name .= '<option>No</option>';
                            }elseif($data[$j]->lab_input != null && $data[$j]->lab_input == 'No'){
                                $name .= '<option>'.$data[$j]->lab_input.'</option>';
                                $name .= '<option>Yes</option>';
                            }else{
                                $name .= '<option>Yes</option>';
                                $name .= '<option>No</option>';
                            }
                            $name .= '</select>';
                            $name .= '</div>';
                        }
                        $j++;

                    }
                    $name .= '';

                    return $name;

                }
            }
        }
    }

    static function map_lap_number3($id, $id2)
    {
        $c_data = DB::table('save_example_detail')->where('detail_volume', $id)->where('id_example', $id2)->first();
        if ($c_data != null) {
            $data = DB::table('save_example_detail')->where('detail_volume', $id)->where('id_example', $id2)->first(['number']);
            return $data->number;
        }
    }

    static function map_lap_num_ex3($id, $id2)
    {
        $c_data = DB::table('save_example_detail')->where('detail_volume', $id)->where('id_example', $id2)->first();
        if ($c_data != null) {
            $data = DB::table('save_example_detail')->where('detail_volume', $id)->where('id_example', $id2)->first(['num_ex']);
            return $data->num_ex;
        }
    }

    static function map_lap_test_detail_disable2($id,$i,$example_id)
    {
        $data = DB::table('save_example_map_lap_detail')->where('maplap_id', $id)->where('example_id', $example_id)->get();
        if($data != null){
            foreach($data as $datas){
                $str[]  = $datas->test_id;
            }
            if(isset($str)){
                $data2 = DB::table('result_product_detail')->whereIn('id', $str)->get();

                if($data2 != null){

                    $name = '';
                    $j = 0;
                    foreach($data2 as $data2s){
                        $name  .= '<div class="col-md-12"><span style="display:block; float:left;">' . $data2s->name_result . '</span>';
                        if($data2s->type_result == 'Text'){
                            $name .= '<input name="type_detail['.$i.'][]" type="text" class="form-control input-sm" value="'.$data[$j]->lab_input.'" disabled></div>';
                        }elseif($data2s->type_result == 'ตัวเลข'){
                            $name .= '<input name="type_detail['.$i.'][]" type="number" class="form-control input-sm" value="'.$data[$j]->lab_input.'" disabled></div>';
                        }elseif($data2s->type_result == 'Yes / No'){
                            $name .= '<select name="type_detail['.$i.'][]" class="form-control input-sm" disabled>';

                            if($data[$j]->lab_input != null && $data[$j]->lab_input == 'Yes'){
                                $name .= '<option>'.$data[$j]->lab_input.'</option>';
                                $name .= '<option>No</option>';
                            }elseif($data[$j]->lab_input != null && $data[$j]->lab_input == 'No'){
                                $name .= '<option>'.$data[$j]->lab_input.'</option>';
                                $name .= '<option>Yes</option>';
                            }else{
                                $name .= '<option>Yes</option>';
                                $name .= '<option>No</option>';
                            }
                            $name .= '</select>';
                            $name .= '</div>';
                        }
                        $j++;
                    }
                    $name .= '';

                    return $name;
                }
            }
        }
    }

    static function map_lap_file($id,$noexample_id)
    {
        $data = DB::table('save_example_file')->where('example_id', $noexample_id)->where('example_id_no', $id)->first();
        if ($data != null) {
            return $data->file;
        }
    }

    static function TisListSample(){
        $sub_query = TisiLicense::select('tbl_tisiNo')->distinct()->get();
        $tis = Tis::select(DB::raw("CONCAT('มอก.', tb3_Tisno, ' ', tb3_tis.tb3_TisThainame, ' ', IF(tb3_Tisforce='บ', '(มาตรฐานบังคับ)', '(มาตรฐานทั่วไป)')) AS name, tb3_Tisno")
        )->whereIN('tb3_Tisno',$sub_query)->pluck('name','tb3_Tisno');
        // dd($tis);
        return $tis;
    }

    public static  function toThaiNumber($number){
        $number_format_thai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
        $number_format_eng = array("1","2","3","4","5","6","7","8","9","0");
        $str = str_replace($number_format_eng, $number_format_thai, $number);
        return $str;
    }

    public static function CheckSession()
    {
       try {
        $request    = '';
        $cookie     =  Session::get('_session_login');
        
        if(!empty($cookie)){
           
            $session = Sessions::where('id', $cookie['session_id'])->where('user_agent', $cookie['user_agent'])->first();
          
      
            if(!is_null($session) && !empty($session->user_to)){
                     $user_result      =   $session->user_to;
                     
                if(!is_null($user_result)){ //ถ้าพบข้อมูล
                    
                    if(!is_null($session->act_instead) && !empty($session->act_instead_to)){ //ใช้ระบบในฐานะผู้รับมอบอำนาจ จะใช้ระบบได้ตามที่ได้รับมอบอำนาจ
                        $request                = self::format_user_data($session->act_instead_to);//ข้อมูลผู้มอบอำนาจให้เอามาใส่ส่วนหลัก
                        $request->act_instead   = self::format_user_data($user_result);//ผู้ใช้ที่ lgoin อยู่ที่ดำเนินการแทน
                     
                        $setting_systems        = self::getAgentSystems($user_result->id, $session->act_instead);
                        $setting_systems        = $setting_systems->filter(function ($setting_system, $key) {
                                                                return $setting_system->state == 1 && !is_null($setting_system->app_name);
                                                            }); //ไม่เอารายการที่ถูกปิด และไม่กรอก app_name

                                                        
                        $request->app_allow     = $setting_systems->pluck('app_name');
                        // $request->agent_id      = $session->act_instead; // ID ข้อมูลผู้มอบอำนาจให้เอามาใส่ส่วนหลัก
                        $request->agent_id      =  $user_result->id; 
                        $request->agent_name    =  !empty($request->name) ?  $request->name : '';  
              
                    }else   if(!is_null($session->user_id) && !empty($user_result)){  //ใช้ระบบในฐานะตัวเอง ใช้ระบบได้ทั้งหมด
                        
                        $request                = self::format_user_data($user_result); //จัดรูปแบบข้อมูลผู้ใช้งาน
                        $request->act_instead   = (object)[]; //ข้อมูลการได้รับมอบสิทธิ์
                        $request->app_allow     = SettingSystem::whereNotNull('app_name')->where('state', 1)->pluck('app_name');
                        $request->agent_id      = null; 
                        $request->agent_name    = null; 
               
 
                    }
                    
                        $request->params        =   !empty($user_result->params) ?  $user_result->params : '';    
                        $request->user_picture  =  !empty($user_result->picture) ?  $user_result->picture : null;  
                        $request->user_name     =  !empty($user_result->name) ?  $user_result->name : '';  
                        $contact_prefix_text    =  !empty($request->contact_prefix_text) ?  $request->contact_prefix_text : '';
                        $contact_prefix_text    .= !empty($request->contact_first_name) ? $request->contact_first_name : '';
                        $contact_prefix_text    .= !empty($request->contact_last_name) ?  ' '.$request->contact_last_name : '';
                        $request->first_name     =  $contact_prefix_text;
                        $request->session_id    = $cookie['session_id']; //session id
                 }else{
                    $request                    = false;
                 }
 

            }else{
                $request                    = false;
            }
        }else{
                $request                     = false;
        }
        // dd(json_encode($request));
          return @json_decode(json_encode($request));
        //   return json_encode($request);

        } catch (Exception $ex) {
            // dd('ok');
            return  redirect(HP::DomainTisiSso());  
        }
   }

   public static function getAgentSystems($agent_id, $user_id){
    $agents =  Agent::where('agent_id', $agent_id)
                    ->where('user_id', $user_id)
                    ->where(function($query){
                        $query->where('issue_type', 1)
                              ->orWhere(function($query){
                                $now = date('Y-m-d');
                                $query->where('issue_type', 2)
                                      ->whereDate('start_date', '<=', $now)
                                      ->whereDate('end_date', '>=', $now);
                              });
                    })
                    ->where('state', 2)//ดำเนินการตามรับมอบ
                    ->orderby('select_all', 'desc')
                    ->select('id', 'select_all')
                    ->get();

    $setting_systems = SettingSystem::get()->keyBy('id');
    $allows = collect([]);
    foreach ($agents as $agent) {
        if($agent->select_all==1){//มอบทุกระบบ
            $allows = $setting_systems;
            break;
        }else{
            $system_ids = AgentSystem::where('sso_agent_id', $agent->id)->pluck('setting_systems_id');//ไอดี ระบบที่มอบอำนาจให้
            $allow_tmps = $setting_systems->whereIn('id', $system_ids);//get จากระบบที่มีอยู่เพื่อดึงชุดข้อมูลและเช็ค
            $allows = $allows->merge($allow_tmps)->keyBy('id');//นำมารวมกับของรายการก่อนหน้า
        }
    }

    return $allows;
}

   public  static function  format_user_data($user_result){

            //ภาพประจำตัว
            $picture = !empty($user_result->picture) ? self::getFileStorage('sso_users/'.$user_result->picture) : null ;
    
            //เอกสารบริษัท
            $corporatefiles = json_decode($user_result->corporatefile);
            $corporatefile  = is_array($corporatefiles) && count($corporatefiles) > 0 ? self::getFileStorage("media/com_user/$user_result->tax_number/".$corporatefiles[0]->realfile) : null ;

            //เอกสารบุคคล
            $personfiles = json_decode($user_result->personfile);
            $personfile  = is_array($personfiles) && count($personfiles) > 0 ? self::getFileStorage("media/com_user/$user_result->tax_number/".$personfiles[0]->realfile) : null ;

            //จัดใส่อีกตัวแปรเพื่อจัดรูปแบบข้อมูล
            $user = (object)[];
            $user->id                  = $user_result->id;
            $user->username            = $user_result->username;//ชื่อผู้ใช้งาน
            $user->email               = $user_result->email;//อีเมล
            $user->block               = $user_result->block;//ระงับการใช้งาน
            $user->registerDate        = $user_result->registerDate;//วันที่ลงทะเบียน
            $user->lastvisitDate       = $user_result->lastvisitDate;//วันที่ log in ล่าสุด
            $user->sendEmail           = $user_result->sendEmail;//รับอีเมลจากระบบ
            $user->picture             = filter_var($picture, FILTER_VALIDATE_URL) ? $picture : null ;//URL ภาพประจำตัว
            $user->state               = $user_result->state;//สถานะการยืนยัน
            //ข้อมูลผู้ประกอบการ
            $user->prefix_text         = $user_result->prefix_text;//คำนำหน้าชื่อ
            $user->name                = $user_result->name;//ชื่อ
            $user->name_en             = $user_result->name_en;//ชื่อ
            $user->applicanttype_id    = $user_result->applicanttype_id;
            $user->person_type         = $user_result->person_type;//ประเภทข้อมูลที่ใช้ลงทะเบียน
            $user->tax_number          = $user_result->tax_number;//เลขผู้เสียภาษี
            $user->date_niti           = $user_result->date_niti;//วันที่จดทะเบียนนิติบุคคล
            $user->branch_type         = $user_result->branch_type;//ประเภทสาขา
            $user->branch_code         = $user_result->branch_code;//รหัสสาขา
            $user->corporatefile       = filter_var($corporatefile, FILTER_VALIDATE_URL) ? $corporatefile : null ;//เอกสารบริษัท
            $user->prefix_id           = $user_result->prefix_name;//ไอดีคำนำหน้าชื่อ
            $user->prefix_text         = $user_result->prefix_text;//ไอดีคำนำหน้าชื่อ
            $user->person_first_name   = $user_result->person_first_name;//ชื่อ
            $user->person_last_name    = $user_result->person_last_name;//สกุล
            $user->date_of_birth       = $user_result->date_of_birth;//วันเกิด
            $user->personfile          = filter_var($personfile, FILTER_VALIDATE_URL) ? $personfile : null ;//เอกสารบุคคล

            $address = HP::getDataAddress(  $user_result->province, $user_result->district, $user_result->subdistrict );

            //สำนักงานใหญ่
            $user->address_no          = $user_result->address_no;
            $user->building            = $user_result->building;
            $user->moo                 = $user_result->moo;
            $user->soi                 = $user_result->soi;
            $user->street              = $user_result->street;
            $user->subdistrict         = $user_result->subdistrict;
            $user->district            = $user_result->district;
            $user->province            = $user_result->province;
            $user->subdistrict_id      = !empty( $address->subdistrict_id )?$address->subdistrict_id:null;
            $user->district_id         = !empty( $address->district_id )?$address->district_id:null;
            $user->province_id         = !empty( $address->province_id )?$address->province_id:null;
            $user->zipcode             = $user_result->zipcode;
            $user->tel                 = $user_result->tel;
            $user->fax                 = $user_result->fax;
            $user->latitude            = $user_result->latitude;
            $user->longitude           = $user_result->longitude;

            $address_contact = HP::getDataAddress( $user_result->contact_province, $user_result->contact_district, $user_result->contact_subdistrict );

            //ที่อยู่ที่สามารถติดต่อได้
            $user->contact_name        = $user_result->contact_name;
            $user->contact_tax_id      = $user_result->contact_tax_id;
            $user->contact_prefix_id   = $user_result->contact_prefix_name;
            $user->contact_prefix_text = $user_result->contact_prefix_text; 
            $user->contact_first_name  = $user_result->contact_first_name;
            $user->contact_last_name   = $user_result->contact_last_name;
            $user->contact_tel         = $user_result->contact_tel;
            $user->contact_fax         = $user_result->contact_fax;
            $user->contact_phone_number= $user_result->contact_phone_number;
            $user->contact_position    = $user_result->contact_position;
            $user->contact_address_no  = $user_result->contact_address_no;
            $user->contact_building    = $user_result->contact_building;
            $user->contact_moo         = $user_result->contact_moo;
            $user->contact_soi         = $user_result->contact_soi;
            $user->contact_street      = $user_result->contact_street;
            $user->contact_subdistrict = $user_result->contact_subdistrict;
            $user->contact_district    = $user_result->contact_district;
            $user->contact_province    = $user_result->contact_province;

            $user->contact_subdistrict_id = !empty( $address_contact->subdistrict_id )?$address_contact->subdistrict_id:null;
            $user->contact_district_id  = !empty( $address_contact->district_id )?$address_contact->district_id:null;
            $user->contact_province_id  = !empty( $address_contact->province_id )?$address_contact->province_id:null;

            $user->contact_zipcode     = $user_result->contact_zipcode;
            $user->params              = $user_result->params;
            return $user;
    }

    static function GetIDAddress( $txt_sub = null, $txt_dis = null, $txt_pro = null )
    {
        $data = new stdClass;

        if( !empty($txt_sub) && !empty($txt_dis) && !empty($txt_pro)  ){

            $txt_sub = trim($txt_sub);
            $txt_dis = trim($txt_dis);
            $txt_pro = trim($txt_pro);

            if( strpos( $txt_sub , "ตำบล" ) === false ){
                $txt_sub =  !empty($txt_sub)?str_replace('ตำบล','',$txt_sub):null;
            }

            if( strpos( $txt_dis , "อำเภอ/เขต" ) === false ){
                $txt_dis =  !empty($txt_dis)?str_replace('อำเภอ/เขต','style="',$txt_dis):null;
            }else if( strpos( $txt_dis , "เขต" ) === false ){
                $txt_dis =  !empty($txt_dis)?str_replace('เขต','',$txt_sub):null;
            }else if( strpos( $txt_dis , "อำเภอ" ) === false ){
                $txt_dis =  !empty($txt_dis)?str_replace('อำเภอ','',$txt_dis):null;
            }

            if( strpos( $txt_pro , "จังหวัด" ) === false ){
                $txt_pro =  !empty($txt_pro)?str_replace('จังหวัด','',$txt_pro):null;
            }

            //จัดหวัด
            $provinces = Province::select(DB::raw("TRIM(`PROVINCE_NAME`) AS PROVINCE_NAME"), 'PROVINCE_ID')->pluck( 'PROVINCE_NAME', 'PROVINCE_ID')->toArray();

            //อำเภอ
            $districts = Amphur::select('AMPHUR_ID',  DB::raw("TRIM(`AMPHUR_NAME`) AS AMPHUR_NAME"), 'PROVINCE_ID')->where(DB::raw("REPLACE(AMPHUR_NAME,' ','')"),  'NOT LIKE', "%*%")->get();

            $district_group_tmps = $districts->groupBy('PROVINCE_ID')->toArray();

            $district_groups     = [];
            foreach ($district_group_tmps as $key => $tmp) {
                $district_groups[$key] = collect($tmp)->pluck('AMPHUR_NAME', 'AMPHUR_ID')->toArray();
            }
            $districts = $districts->pluck('AMPHUR_NAME', 'AMPHUR_ID')->toArray();

            //ตำบล
            $sub_districts = District::select('DISTRICT_ID', DB::raw("TRIM(`DISTRICT_NAME`) AS DISTRICT_NAME"), 'AMPHUR_ID')->where(DB::raw("REPLACE(DISTRICT_NAME,' ','')"),  'NOT LIKE', "%*%")->get()->makeHidden(['districtname', 'provincename']);
            $sub_district_group_tmps = collect($sub_districts->toArray())->groupBy('AMPHUR_ID')->toArray();
            $sub_district_groups     = [];
            foreach ($sub_district_group_tmps as $key => $tmp) {
                $sub_district_groups[$key] = collect($tmp)->pluck('DISTRICT_NAME', 'DISTRICT_ID')->toArray();
            }
            $sub_districts = $sub_districts->pluck('DISTRICT_NAME', 'DISTRICT_ID')->toArray();

            $province_ids = array_search($txt_pro, $provinces);
            $district_ids = array_search($txt_dis, $districts);
            $subdistrict_ids = array_search( $txt_sub , $sub_districts);

            if($province_ids!==false){
                $data->province_id = $province_ids;
            }else{
                $data->province_id = null;
            }

            if($province_ids!==false && $district_ids!==false){
                if( $province_ids == 1 ){
                    $txt_dis = 'เขต'.$txt_dis;
                }
                $district_ids = array_key_exists($province_ids, $district_groups) ? array_search( $txt_dis , $district_groups[ $province_ids ]) : false;
                $data->district_id = ( $district_ids!==false ? $district_ids : null );
            }else{
                $data->district_id = null;
            }

            if($district_ids!==false && $subdistrict_ids!==false){
                $subdistrict_ids = array_key_exists($district_ids, $sub_district_groups) ? array_search( $txt_sub , $sub_district_groups[ $district_ids ]) : false;
                $data->subdistrict_id = ( $subdistrict_ids!==false ? $subdistrict_ids : null );
            }else{
                $data->subdistrict_id = null;
            }

            if( $subdistrict_ids!==false ){
                $zipcode =  DB::table((new District)->getTable().' AS sub') // อำเภอ
                                ->leftJoin((new Zipcode)->getTable().' AS code', 'code.district_code', '=', 'sub.DISTRICT_CODE')  // รหัสไปรษณีย์
                                ->select('sub.DISTRICT_ID', 'code.zipcode' )
                                ->pluck( 'zipcode', 'DISTRICT_ID')
                                ->toArray();

                $data->zipcode = array_key_exists(  $subdistrict_ids , $zipcode )?$zipcode[ $subdistrict_ids ]:null;
            }else{
                $data->zipcode = null;
            }

        }else{
            $data->province_id = null;
            $data->district_id = null;
            $data->subdistrict_id = null;
            $data->zipcode = null;
        }

        return $data;
    }

   public static function DomainTisiSso()
   {
    
        $config     = HP::getConfig();
        $url_sso    = $config->url_sso;
        return  !empty($url_sso) ?  $url_sso : '';
    }



    public static function CheckPermission($row = '')
    {

        // $data_session               = HP::CheckSession();
        // $role_id                 = RoleUser::where('user_id',$data_session->id)->get()->pluck('role_id')->toArray();
        // dd($role_id);
        //dd(auth()->user());
        return auth()->user()->can($row);

            // $data_session               = HP::CheckSession();
            // $request                    = false;

            // if(!empty($data_session) ){
            //     // $tax_id                 = RoleUser::where('tax_id',$data_session->tax_number)->get()->pluck('role_id')->toArray();
            //     $role_id                 = RoleUser::where('user_id',$data_session->id)->get()->pluck('role_id')->toArray();
            //     if(count($role_id) > 0){
            //             $permission     =   DB::table((new PermissionRole)->getTable().' AS role')
            //                                     ->select('permission.name as name')
            //                                     ->leftJoin((new  Permission )->getTable().' AS permission', 'permission.id', '=', 'role.permission_id')
            //                                     ->whereIn('role.role_id',$role_id)
            //                                     ->where('permission.name',$row)
            //                                     ->first();
            //         if(!is_null($permission)){
            //             $request                    = true;
            //         }
            //     }
            // }else{
            //     $request                    = false;
            // }
         
        // return $request;
     }

   //ข้อมูลติดต่อ
    public static function SetDataTraderAddress() {
        $html  = '';
        $data_session               = HP::CheckSession();
        if(!empty($data_session)){
            $html  .= 'ข้อมูลติดต่อ ';
            $html .= '<br>';
            $html .= @$data_session->name;
            $html .= '<br>';
            // $html .= 'มือถือ : '.@$data_session->trader_mobile ?? '-';
            // $html .= '<br>';
            $html .= 'โทรศัพท์ : '.@$data_session->tel ?? '-';
            $html .= '<br>';
            $html .= 'E-mail : '.@$data_session->email ?? '-';

        }
       return  $html ?? '-';
  }

    public static function getExpertNextNo($field_use, $field_date)
    {

        $year = date('Y') + 543;
        $where = " YEAR($field_date)=YEAR(now())";
        $max_no = Expert::whereRaw("$where order by id desc")->value($field_use);

        if (!is_null($max_no) && $max_no != '') {
            $str_explode = explode("-", $max_no);
            $max_new = $str_explode[1] + 1;
        } else {
            $max_new = 1;
        }

        $running_no = str_pad($max_new, 4, '0', STR_PAD_LEFT);

        return "ep-" . $running_no . "-" . $year;
    }

    public static function StateEstandardOffers(){
        
        $request = [
                            '1' => 'เสนอความเห็น',
                            '2' => 'สมควรบรรจุในแผน',
                            '3' => 'ไม่สมควรบรรจุในแผน',
                            '4' => 'จัดทำแผน',
                           ];
        return $request;
    }
    public static function StandardTypes(){
        $request =  [
            '1' => 'มอก.',
            '2' => 'มอก.เอส',
            '3' => 'มตช.',
            '4' => 'มตช./ข้อกำหนดเผยแพร่',
            '5' => 'ข้อตกลงร่วม',
            '6' => 'มผช.'
        ];
        return $request;
    }

    public static function singleFileUpload($request_file, $attach_path = '', $tax_number='0000000000000', $username='0000000000000', $systems = "ACC", $table_name = null , $ref_id = null, $section = null, $attach_text = null){

        $attach             = $request_file;
        $file_size          = (method_exists($attach, 'getSize')) ? $attach->getSize() : 0;
        $file_extension     = $attach->getClientOriginalExtension();
        $fullFileName       = str_random(10).'-date_time'.date('Ymd_hms') . '.' .$file_extension ;

        $path               = Storage::putFileAs($attach_path.'/'.$tax_number, $attach,  str_replace(" ","",$fullFileName) );
        $file_name          = self::ConvertCertifyFileName($attach->getClientOriginalName());

        $request = AttachFile::create([
                            'tax_number'        => $tax_number,
                            'username'          => $username,
                            'systems'           => $systems,
                            'ref_table'         => $table_name,
                            'ref_id'            => $ref_id,
                            'url'               => $path,
                            'filename'          => $file_name,
                            'new_filename'      => $fullFileName,
                            'caption'           => $attach_text,
                            'size'              => $file_size,
                            'file_properties'   => $file_extension,
                            'section'           => $section,
                            'created_by'        =>  !empty(auth()->user()) ? auth()->user()->getKey() : null, 
                            'created_at'        => date('Y-m-d H:i:s')
                          ]);
           return $request;
       }

       public static function singleFileUploadRefno($request_file, $attach_path = '', $tax_number='0000000000000', $username='0000000000000', $systems = "ACC", $table_name = null , $ref_id = null, $section = null, $attach_text = null){

        $attach             = $request_file;
        $file_size          = (method_exists($attach, 'getSize')) ? $attach->getSize() : 0;
        $file_extension     = $attach->getClientOriginalExtension();
        $fullFileName       = str_random(10).'-date_time'.date('Ymd_hms') . '.' .$file_extension ;

        $path               = Storage::putFileAs($attach_path, $attach,  str_replace(" ","",$fullFileName) );
        $file_name          = self::ConvertCertifyFileName($attach->getClientOriginalName());

        $request = AttachFile::create([
                            'tax_number'        => $tax_number,
                            'username'          => $username,
                            'systems'           => $systems,
                            'ref_table'         => $table_name,
                            'ref_id'            => $ref_id,
                            'url'               => $path,
                            'filename'          => $file_name,
                            'new_filename'      => $fullFileName,
                            'caption'           => $attach_text,
                            'size'              => $file_size,
                            'file_properties'   => $file_extension,
                            'section'           => $section,
                            'created_by'        => auth()->user()->getKey(),
                            'created_at'        => date('Y-m-d H:i:s')
                          ]);
         return $request;
       }

       public static function getInsertCertifyLogEmail($app_no =  null, $app_id =  null, $app_table =  null,$ref_id =  null, $ref_table =  null, $certify = null, $subject = null,  $html = null, $user_id = null , $agent_id = null , $created_by = null , $email = null , $email_to = null  , $email_cc = null , $email_reply = null , $attach = null ){
        // $requestData = ['app_no'            => $app_no,
        //                 'app_id'            => $app_id,
        //                 'app_table'         => $app_table,
        //                 'ref_id'            => $ref_id,
        //                 'ref_table'         => $ref_table,
        //                 'certify'           => $certify,
        //                 'subject'           => $subject,
        //                 'detail'            => $html,
        //                 'user_id'           => $user_id,
        //                 'agent_id'          => $agent_id,
        //                 'created_by'        => $created_by,
        //                 'email'             => $email,
        //                 'email_to'          => $email_to,
        //                 'email_cc'          => $email_cc,
        //                 'email_reply'       => $email_reply,
        //                 'attach'            => $attach,
        //                 'status'            => 2
        //               ];
        //   return CertifyLogEmail::create($requestData);
        $certify_log                    = new  CertifyLogEmail;
        $certify_log->status            = 2;
        $certify_log->save();
        $request =  CertifyLogEmail::findOrFail($certify_log->id);
        if(!is_null($request)){
               $requestData = [ 'app_no'    => $app_no,
                                'app_id'            => $app_id,
                                'app_table'         => $app_table,
                                'ref_id'            => $ref_id,
                                'ref_table'         => $ref_table,
                                'certify'           => $certify,
                                'subject'           => $subject,
                                'detail'            => $html,
                                'user_id'           => $user_id,
                                'agent_id'          => $agent_id,
                                'created_by'        => $created_by,
                                'email'             => $email,
                                'email_to'          => $email_to,
                                'email_cc'          => $email_cc,
                                'email_reply'       => $email_reply,
                                'attach'            => $attach,
                                'status'            => 2
                              ];
            $request->update($requestData);
        }
       return $certify_log;


       }
       
       public static function getUpdateCertifyLogEmail($id =  null){
 
            $certify =  CertifyLogEmail::findOrFail($id);
            if(!is_null($certify)){
                $certify->status = 1;
                $certify->save();
            }
     
          return  $certify;
   
       }
       

       public static function buttonAction($id, $action_url, $controller_action, $str_slug_name, $show_view = true, $show_edit = true, $show_delete = true)
       {
           $form_action = '';
           if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-' . str_slug($str_slug_name)) && $show_view === true):
               $form_action .= '<a href="' . url('/' . $action_url . '/' . $id) . '"
                                                   title="View ' . substr($str_slug_name, 0, -1) . '" class="btn btn-info btn-xs">
                                                           <i class="fa fa-eye"></i>
                                                   </a>';
           endif;
           if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-' . str_slug($str_slug_name)) && $show_edit === true):
               $form_action .= ' <a href="' . url('/' . $action_url . '/' . $id . '/edit') . '"
                                                   title="Edit ' . substr($str_slug_name, 0, -1) . '" class="btn btn-warning btn-xs">
                                                           <i class="fa fa-pencil-square-o"></i>
                                                   </a>';
           endif;
           if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-' . str_slug($str_slug_name)) && $show_delete === true):
               $form_action .= '<form action="' . action($controller_action, ['id' => $id]) . '" method="POST" style="display:inline">
                                                   ' . csrf_field() . method_field('DELETE') . '
                                                   <button type="submit" class="btn btn-danger btn-xs" title="Delete ' . substr($str_slug_name, 0, -1) . '" onclick="return confirm_delete()"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                   </form>';
           endif;
           return $form_action;
        }
   
	private static function clearTeaxtSearch($text, $type){
        if(is_numeric($text)){
            goto end;
        }
        switch ($type) {
            case 1:
                $text = trim(str_replace("จังหวัด", "", $text));
                break;
            case 2:
                if(strpos($text, 'อำเภอ/เขต') == 0){
                    $text = str_replace("อำเภอ/เขต", "", $text);
                }
                if(strpos($text, 'อำเภอ') == 0){
                    $text = str_replace("อำเภอ", "", $text);
                }
                if(strpos($text, 'เขต') == 0){
                    $text = str_replace("เขต", "", $text);
                }
                break;
            case 3:
                $district_text = trim($text);
                if(strpos($text, 'ตำบล/แขวง') == 0){
                    $text = str_replace("ตำบล/แขวง", "", $text);
                }
                if(strpos($text, 'ตำบล') == 0){
                    $text = str_replace("ตำบล", "", $text);
                }
                if(strpos($text, 'แขวง') == 0){
                    $text = str_replace("แขวง", "", $text);
                }
                $text = trim($text);
                break;
            default:
                $text = $text;
        }
        end:
		return $text;
	}

	private static function getConditionFindDataText($text, $type, $province=null, $district=null){
		$conditions = '';
        switch ($type) {
            case 1:
                if(is_numeric($text)){
                    $conditions .= 'PROVINCE_ID='.intval($text);
                }else{
                    $conditions .= 'TRIM(PROVINCE_NAME)="'.$text.'"';
                }
                break;
            case 2:
                if(is_numeric($text)){
                    $conditions .= 'AMPHUR_ID='.intval($text);
                }else{
                    $conditions .= 'IF(POSITION("เขต" IN TRIM(AMPHUR_NAME)) = 1,';
                    $conditions .= 'TRIM(REPLACE(AMPHUR_NAME, "เขต", "")),';
                    $conditions .= 'IF(POSITION("อำเภอ" IN TRIM(AMPHUR_NAME)) = 1,';
                    $conditions .= 'TRIM(REPLACE(AMPHUR_NAME, "อำเภอ", "")),';
                    $conditions .= 'TRIM(AMPHUR_NAME)))';
                    $conditions .= '="'.$text.'"';
                }
                break;
            case 3:
                if(is_numeric($text)){
                    $conditions .= 'DISTRICT_ID='.intval($text);
                }else{
                    $conditions .= 'IF(POSITION("แขวง" IN TRIM(DISTRICT_NAME)) = 1,';
                    $conditions .= 'TRIM(REPLACE(DISTRICT_NAME, "แขวง", "")),';
                    $conditions .= 'IF(POSITION("ตำบล" IN TRIM(DISTRICT_NAME)) = 1,';
                    $conditions .= 'TRIM(REPLACE(DISTRICT_NAME, "ตำบล", "")),';
                    $conditions .= 'TRIM(DISTRICT_NAME)))';
                    $conditions .= '="'.$text.'"';
                }
                break;
            default:
                $conditions .= '1=0';
                goto end;
        }
		if(!empty($district->id)){
			$conditions .= ' AND AMPHUR_ID='.intval($district->id);
		}
		if(!empty($province->id)){
			$conditions .= ' AND PROVINCE_ID='.intval($province->id);
		}
        end:
		return $conditions;
	}

	private static function setDataAddress($results, $province, $district, $sub_district){
		if(!empty($province)){
			$results->province_id = $province->PROVINCE_ID;
            $results->province_name = $province->PROVINCE_NAME;
            $results->province_name_en = $province->PROVINCE_NAME_EN;
		}
		if(!empty($district)){
			$results->district_id = $district->AMPHUR_ID;
            $results->district_name = $district->AMPHUR_NAME;
            $results->district_name_en = $district->AMPHUR_NAME_EN;
		}
		if(!empty($sub_district)){
			$results->subdistrict_id = $sub_district->DISTRICT_ID;
            $results->subdistrict_name = $sub_district->DISTRICT_NAME;
            $results->subdistrict_name_en = $sub_district->DISTRICT_NAME_EN;
		}
		return $results;
	}

	public static function getDataAddress($province_text, $district_text, $subdistrict_text){
        $province_text = self::clearTeaxtSearch($province_text, 1);
        $district_text = self::clearTeaxtSearch($district_text, 2);
        $subdistrict_text = self::clearTeaxtSearch($subdistrict_text, 3);

		$results = new Address;

		$province = DB::table((new Province)->getTable())
                        ->selectRaw('PROVINCE_ID, PROVINCE_NAME, PROVINCE_NAME_EN')
                        ->whereRaw(self::getConditionFindDataText($province_text, 1))
                        ->first();
		$district = DB::table((new Amphur)->getTable())
                        ->selectRaw('AMPHUR_ID, AMPHUR_NAME, AMPHUR_NAME_EN')
                        ->whereRaw(self::getConditionFindDataText($district_text, 2, $province))
                        ->first();
		$sub_district = DB::table((new District)->getTable())
                        ->selectRaw('DISTRICT_ID, DISTRICT_NAME, DISTRICT_NAME_EN')
                        ->whereRaw(self::getConditionFindDataText($subdistrict_text, 3, $province, $district))
                        ->first();

		return self::setDataAddress($results, $province, $district, $sub_district);
	}

    static function check_api($key_page){ //true=เปิดใช้, false=ปิดใช้
        $config = HP::getConfig();
        $check_api = property_exists($config, $key_page) ? $config->{$key_page} : 0 ;//0=ไม่ต้องเช็ค api, 1=เช็ค api
        return $check_api==1 ? true : false ;
    }
    

}




class HP_WS
{
    public static function getiJuristicID($JuristicID)
    {//รับค่า $JuristicID=เลขทะเบียนพาณิชน์ที่ต้องการทราบข้อมูล, $AgentID=เลขประชาชนของเจ้าหน้าที่

        $user = auth()->user();//user login object
    $TokenIndustry = session('industry-token', null);//session object
    $result = (object)array();

        $AgentID = $JuristicID;//ผู้เรียกดูข้อมูล

        /* ส่วนเรียกดูข้อมูล */
        if (is_null($TokenIndustry)) {//ถ้ายังไม่มี token
      $Validate = self::ValidateAPI($AgentID);//ส่งข้อมูลไปเพื่อ validate ขอ token
      if ($Validate->HttpCode==200) {//ถ้า validate ผ่าน
        session(['industry-token' => $Validate->Token]);
          $result = self::iJuristicIDAPI($JuristicID, $Validate->Token);//เรียกดูข้อมูล
      } else {//ถ้า validate ไม่ผ่าน
        $result = $Validate;
      }
        } else {//ถ้ามีแล้ว
      $result = self::iJuristicIDAPI($JuristicID, $TokenIndustry);//เรียกดูข้อมูล
      if ($result->HttpCode!=200) {//ถ้าเรียกดูข้อมูลไม่สำเร็จ token อาจหมดอายุ
        $Validate = self::ValidateAPI($AgentID);//ส่งข้อมูลไปเพื่อ validate ขอ tokenใหม่
        if ($Validate->HttpCode==200) {//ถ้า validate ผ่าน
          session(['industry-token' => $Validate->Token]);//บันทึกลง session ไว้ใช้ต่อไป
          $result = self::iJuristicIDAPI($JuristicID, $Validate->Token);//เรียกดูข้อมูล
        } else {//ถ้า validate ไม่ผ่าน
          $result = $Validate;
        }
      }
        }

        return $result;
    }

    public static function ValidateAPI($AgentID)
    {//ขั้นตอนการ Validate ขอ Token จาก กระทรวงอุตสาหกรรม

        $response = (object)[]; //Result Response

        $config = HP::getConfig();

        $url = $config->industry_auth_url.$AgentID; //URL

        $header =  array("Content-Type: application/json");

        $data_string = json_encode(array('ClientID'=>$config->industry_client_id, 'ClientSecret'=>$config->industry_client_secret));

        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Disable SSL verification host
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Accept Header Response
        curl_setopt($ch, CURLOPT_HEADER, 1);

        //Method
        curl_setopt($ch, CURLOPT_POST, 1);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Add Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // Body JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Execute
        $response->Result = curl_exec($ch);

        //get Status Code
        @$response->HttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Retudn headers seperatly from the Response Body
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response->Result, 0, $header_size);
        $body = substr($response->Result, $header_size);

        // Closing
        curl_close($ch);

        //Format Body And Token
        $response->Body = str_replace('"', '', $body);
        $response->Token = self::extract_header($headers)['Token'];

        // Will dump a beauty json :3
        return $response;
    }

    public static function iJuristicIDAPI($JuristicID, $TokenIndustry)
    {//เช็คข้อมูลนิติบุคคลว่าผ่านการลงทะเบียนกับกระทรางอุตสาหกรรมหรือยัง

        $response = (object)[]; //Result Response

        $config = HP::getConfig();
        $url = $config->industry_ijuristicid_url.$JuristicID; //URL

        $header =  array("Token: $TokenIndustry");

        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Disable SSL verification host
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Add Header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Execute
        $response = json_decode(curl_exec($ch));

        //get Status Code
        @$response->HttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Closing
        curl_close($ch);

        // Will dump a beauty json :3
        return $response;
    }

    // สร้างฟังก์ชั้นแยกตัวเลข ออกจากตัวแปรข้อความ
    public static function extract_int($str)
    {
        $strings = str_split((string)$str, 1);

        $results = [];
        foreach ($strings as $key => $string) {
            if ($string==='0' || $string==='1' || $string==='2' || $string==='3' || $string==='4' || $string==='5' || $string==='6' || $string==='7' || $string==='8' || $string==='9') {
                $results[] = $string;
            }
        }

        return implode('', $results);
    }

    public static function extract_header($header_input)
    {
        $headers = [];
        $data = explode("\n", $header_input);
        $headers['status'] = $data[0];
        array_shift($data);

        foreach ($data as $part) {
            $middle=explode(":", $part);
            if (count($middle)>=2) {
                $headers[trim($middle[0])] = trim($middle[1]);
            }
        }

        return $headers;
    }

    public static function update_reg_industry($trader_autonumber)
    {//อัพเดทสถานะการลงทะเบียนในระบบ i industry

        $user = User::find($trader_autonumber);
        $user->reg_industry = '1';
        $user->save();
    }



}
