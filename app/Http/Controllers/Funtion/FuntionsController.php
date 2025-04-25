<?php

namespace App\Http\Controllers\Funtion;

use HP;
use stdClass;
use App\Models\Sso\User;
use App\Models\Basic\Amphur;
use Illuminate\Http\Request;
use App\Models\Basic\Zipcode;
use Illuminate\Http\Response;

use App\Models\Basic\District;
use App\Models\Basic\Province;

use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cookie;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certify\ApplicantCB\CertiCb;
use App\Models\Certify\ApplicantIB\CertiIb; 

class FuntionsController extends Controller
{

    public function __construct()
    {
        set_time_limit(0);
    }

    public function GetBranchAddreess($id){ // ดึงข้อมูลที่อยู่จาก ตำบล
        $user = User::find($id);
        $ipcode = $user->zipcode;

        // ดึงข้อมูล Zipcode ตามรหัสไปรษณีย์
        $zipcode = Zipcode::where('zipcode', $ipcode)->first();

        // ดึงข้อมูล District ตามรหัสที่ได้จาก Zipcode
        $district = District::where('DISTRICT_CODE', $zipcode->district_code)->first();

        // สร้างข้อมูล address_data โดยใช้ DB query
        $address_data = DB::table((new District)->getTable().' AS sub') // อำเภอ
            ->leftJoin((new Amphur)->getTable().' AS dis', 'dis.AMPHUR_ID', '=', 'sub.AMPHUR_ID') // ตำบล
            ->leftJoin((new Province)->getTable().' AS pro', 'pro.PROVINCE_ID', '=', 'sub.PROVINCE_ID') // จังหวัด
            ->leftJoin((new Zipcode)->getTable().' AS code', 'code.district_code', '=', 'sub.DISTRICT_CODE') // รหัสไปรษณีย์
            ->where(function($query) use($district) {
                $query->where('sub.DISTRICT_ID', $district->DISTRICT_ID); // ใช้รหัสอำเภอจากข้อมูลที่ได้
            })
            ->where(function($query) {
                $query->where(DB::raw("REPLACE(sub.DISTRICT_NAME,' ','')"), 'NOT LIKE', "%*%");
            })
            ->select(
                DB::raw("sub.DISTRICT_ID AS sub_ids"),
                DB::raw("TRIM(sub.DISTRICT_NAME) AS sub_title"),
                DB::raw("TRIM(sub.DISTRICT_NAME_EN) AS sub_title_en"),

                DB::raw("dis.AMPHUR_ID AS dis_id"),
                DB::raw("TRIM(dis.AMPHUR_NAME) AS dis_title"),
                DB::raw("TRIM(dis.AMPHUR_NAME_EN) AS dis_title_en"),

                DB::raw("pro.PROVINCE_ID AS pro_id"),
                DB::raw("TRIM(pro.PROVINCE_NAME) AS pro_title"),
                DB::raw("TRIM(pro.PROVINCE_NAME_EN) AS pro_title_en"),

                DB::raw("code.zipcode AS zip_code")
            )
            ->first();
            $address_data->address_no = $user->address_no;
            $address_data->moo = $user->moo;
            return response()->json($address_data);
    }

    public function GetAddreess($subdistrict_id){ // ดึงข้อมูลที่อยู่จาก ตำบล

        $address_data  =  DB::table((new District)->getTable().' AS sub') // อำเภอ
                    ->leftJoin((new Amphur)->getTable().' AS dis', 'dis.AMPHUR_ID', '=', 'sub.AMPHUR_ID') // ตำบล
                    ->leftJoin((new Province)->getTable().' AS pro', 'pro.PROVINCE_ID', '=', 'sub.PROVINCE_ID')  // จังหวัด
                    ->leftJoin((new Zipcode)->getTable().' AS code', 'code.district_code', '=', 'sub.DISTRICT_CODE')  // รหัสไปรษณีย์
                    ->where(function($query) use($subdistrict_id){
                        $query->where('sub.DISTRICT_ID', $subdistrict_id);
                    })
                    ->where(function($query){
                        $query->where(DB::raw("REPLACE(sub.DISTRICT_NAME,' ','')"),  'NOT LIKE', "%*%");
                    })
                    ->select(

                        DB::raw("sub.DISTRICT_ID AS sub_ids"),
                        DB::raw("TRIM(sub.DISTRICT_NAME) AS sub_title"),
                        DB::raw("TRIM(sub.DISTRICT_NAME_EN) AS sub_title_en"),

                        DB::raw("dis.AMPHUR_ID AS dis_id"),
                        DB::raw("TRIM(dis.AMPHUR_NAME) AS dis_title"),
                        DB::raw("TRIM(dis.AMPHUR_NAME_EN) AS dis_title_en"),

                        DB::raw("pro.PROVINCE_ID AS pro_id"),
                        DB::raw("TRIM(pro.PROVINCE_NAME) AS pro_title"),
                        DB::raw("TRIM(pro.PROVINCE_NAME_EN) AS pro_title_en"),

                        DB::raw("code.zipcode AS zip_code")

                    )
                    ->first();

        return response()->json($address_data);
    }

    public function SearchAddreess(Request $request){//ค้นหาที่อยู่จากตัวSelect 2
        
        $searchTerm = !empty($request->searchTerm)?$request->searchTerm:null;
        $searchTerm = str_replace(' ', '', $searchTerm);

        

        // $address_data  =  DB::table((new District)->getTable().' AS sub') // อำเภอ
        //                     ->leftJoin((new Amphur)->getTable().' AS dis', 'dis.AMPHUR_ID', '=', 'sub.AMPHUR_ID') // ตำบล
        //                     ->leftJoin((new Province)->getTable().' AS pro', 'pro.PROVINCE_ID', '=', 'sub.PROVINCE_ID')  // จังหวัด
        //                     ->leftJoin((new Zipcode)->getTable().' AS code', 'code.district_code', '=', 'sub.DISTRICT_CODE')  // รหัสไปรษณีย์
        //                     ->where(function($query) use($searchTerm){

        //                         // $query->Where(DB::raw("CONCAT( REPLACE(sub.DISTRICT_NAME,' ',''),'_', REPLACE(dis.AMPHUR_NAME,' ',''),'_', REPLACE(pro.PROVINCE_NAME,' ',''),'_', REPLACE(code.zipcode,' ','') )"), 'LIKE', "%".$searchTerm."%");
        //                         $query->where(DB::raw("REPLACE(sub.DISTRICT_NAME,' ','')"),  'LIKE', "%$searchTerm%")
        //                                 ->orWhere(DB::raw("REPLACE(dis.AMPHUR_NAME,' ','')"),  'LIKE', "%$searchTerm%")
        //                                 ->orWhere(DB::raw("REPLACE(pro.PROVINCE_NAME,' ','')"),  'LIKE', "%$searchTerm%")
        //                                 ->orWhere(DB::raw("REPLACE(code.zipcode,' ','')"),  'LIKE', "%$searchTerm%");
        //                     })
        //                     ->where(function($query){
        //                         $query->where(DB::raw("REPLACE(sub.DISTRICT_NAME,' ','')"),  'NOT LIKE', "%*%");
        //                     })
        //                     ->select(

        //                         DB::raw("sub.DISTRICT_ID AS sub_ids"),
        //                         DB::raw("TRIM(sub.DISTRICT_NAME) AS sub_title"),

        //                         DB::raw("dis.AMPHUR_ID AS dis_id"),
        //                         DB::raw("TRIM(dis.AMPHUR_NAME) AS dis_title"),

        //                         DB::raw("pro.PROVINCE_ID AS pro_id"),
        //                         DB::raw("TRIM(pro.PROVINCE_NAME) AS pro_title"),

        //                         DB::raw("code.zipcode AS sub_zip_code")

        //                     )
        //                     ->get();

        $address_data = DB::table((new District)->getTable().' AS sub')
                        ->leftJoin((new Amphur)->getTable().' AS dis', 'dis.AMPHUR_ID', '=', 'sub.AMPHUR_ID')
                        ->leftJoin((new Province)->getTable().' AS pro', 'pro.PROVINCE_ID', '=', 'sub.PROVINCE_ID')
                        ->leftJoin((new Zipcode)->getTable().' AS code', 'code.district_code', '=', 'sub.DISTRICT_CODE')
                        ->where(function($query) use ($searchTerm) {
                            $searchTerm = trim(strtolower($searchTerm)); // แปลงเป็นตัวพิมพ์เล็กและตัดช่องว่างออก
                            $query->whereRaw("LOWER(TRIM(sub.DISTRICT_NAME)) LIKE ?", ["%$searchTerm%"])
                                ->orWhereRaw("LOWER(TRIM(dis.AMPHUR_NAME)) LIKE ?", ["%$searchTerm%"])
                                ->orWhereRaw("LOWER(TRIM(pro.PROVINCE_NAME)) LIKE ?", ["%$searchTerm%"])
                                ->orWhereRaw("TRIM(code.zipcode) LIKE ?", ["%$searchTerm%"]); // zip code ไม่ต้องใช้ LOWER() เพราะเป็นตัวเลข
                        })
                        ->whereRaw("TRIM(sub.DISTRICT_NAME) NOT LIKE '%*%'") // กรองข้อมูลที่มี * ออกไป
                        ->select(
                            'sub.DISTRICT_ID AS sub_ids',
                            DB::raw("TRIM(sub.DISTRICT_NAME) AS sub_title"),
                            'dis.AMPHUR_ID AS dis_id',
                            DB::raw("TRIM(dis.AMPHUR_NAME) AS dis_title"),
                            'pro.PROVINCE_ID AS pro_id',
                            DB::raw("TRIM(pro.PROVINCE_NAME) AS pro_title"),
                            'code.zipcode AS sub_zip_code'
                        )
                        ->get();

        $data_list = [];

        foreach($address_data as $datas){

            $address = '';

            if(  strpos( $datas->dis_title , 'เขต' ) !== false ||  strpos( $datas->sub_title , 'แขวง' ) !== false  ){
                $address .= 'แขวง'.$datas->sub_title;
            }else{
                $address .= 'ต.'.$datas->sub_title;
            }

            if( strpos( $datas->dis_title , 'เขต' ) !== false  ){
                $address .= ' '.$datas->dis_title;
            }else{
                $address .= ' อ.'.$datas->dis_title;
            }

            $address .= ' จ.'.$datas->pro_title;
            $address .= ' '.$datas->sub_zip_code;

            $data = new stdClass;
            $data->id = $datas->sub_ids;
            $data->text = $address;

            $data_list[] = $data;
        }
        echo json_encode($data_list,JSON_UNESCAPED_UNICODE);
    }

    public function check_api_pid(Request $request)
    {
        
        $table = $request->get('table');
        $id = $request->get('id');

        if( (new CertiLab)->getTable() == $table ){
            $data  =  CertiLab::findOrFail($id);
        }else if( (new CertiCb)->getTable() == $table ){
            $data  =  CertiCb::findOrFail($id);
        }else if( (new CertiIb)->getTable() == $table ){
            $data  =  CertiIb::findOrFail($id);
        }

        return $this->CheckDataApiPid( $data , $table );
        
    }

    public function CheckDataApiPid($item,$table, $update = false){

        $object = (object)[];

        if($table  == (new CertiLab)->getTable()){ // lab

            if( !is_null($item->hq_subdistrict)  ){
                $hq_subdistrict = trim($item->hq_subdistrict->DISTRICT_NAME);
                $hq_subdistrict = !empty($hq_subdistrict) && (mb_strpos($hq_subdistrict, 'แขวง')===0 || mb_strpos($hq_subdistrict, 'ตำบล')===0) ? trim(mb_substr($hq_subdistrict, 4)) : $hq_subdistrict ; //ตัดคำว่าตำบล/แขวง คำแรกออก
            }

            if( !is_null($item->hq_district)  ){
                $hq_district = trim($item->hq_district->AMPHUR_NAME);
                $hq_district = !empty($hq_district) && mb_strpos($hq_district, 'อำเภอ')===0 ? trim(mb_substr($hq_district, 5)) : $hq_district ; //ตัดคำว่าอำเภอ คำแรกออก
                $hq_district = !empty($hq_district) && mb_strpos($hq_district, 'เขต')===0 ? trim(mb_substr($hq_district, 3)) : $hq_district ; //ตัดคำว่าเขต คำแรกออก
            }

            $object->user_created       =  $item->user_created;
            $object->applicanttype_id   =  $item->user_created->applicanttype_id ?? null  ;
            $object->tax_number         =  $item->tax_id  ;
            $object->name               =  $item->name;
            $object->address_no         =  $item->hq_address;
            $object->soi                =  $item->hq_soi;
            $object->street             =  $item->hq_road;
            $object->moo                =  $item->hq_moo;
            $object->subdistrict        =  !empty($hq_subdistrict)?$hq_subdistrict : null ;
            $object->district           =  !empty($hq_district)?$hq_district : null ;
            $object->province           =  !is_null($item->hq_province) ? trim($item->hq_province->PROVINCE_NAME) : null ;
            $object->applicantion       =  1;

        }  else if($table  == (new CertiCb)->getTable()){ // cb

            if( !is_null($item->hq_subdistrict)  ){
                $hq_subdistrict = trim($item->hq_subdistrict->DISTRICT_NAME);
                $hq_subdistrict = !empty($hq_subdistrict) && (mb_strpos($hq_subdistrict, 'แขวง')===0 || mb_strpos($hq_subdistrict, 'ตำบล')===0) ? trim(mb_substr($hq_subdistrict, 4)) : $hq_subdistrict ; //ตัดคำว่าตำบล/แขวง คำแรกออก
            }

            if( !is_null($item->hq_district)  ){
                $hq_district = trim($item->hq_district->AMPHUR_NAME);
                $hq_district = !empty($hq_district) && mb_strpos($hq_district, 'อำเภอ')===0 ? trim(mb_substr($hq_district, 5)) : $hq_district ; //ตัดคำว่าอำเภอ คำแรกออก
                $hq_district = !empty($hq_district) && mb_strpos($hq_district, 'เขต')===0 ? trim(mb_substr($hq_district, 3)) : $hq_district ; //ตัดคำว่าเขต คำแรกออก
            }
  
            $object->user_created       =  $item->user_created;
            $object->applicanttype_id   =  $item->user_created->applicanttype_id ?? null  ;
            $object->tax_number         =  $item->tax_id  ;
            $object->name               =  $item->name;
            $object->address_no         =  $item->hq_address;
            $object->soi                =  $item->hq_soi;
            $object->street             =  $item->hq_road;
            $object->moo                =  $item->hq_moo;
            $object->subdistrict        =  !empty($hq_subdistrict)?$hq_subdistrict : null ;
            $object->district           =  !empty($hq_district)?$hq_district : null ;
            $object->province           =  !is_null($item->hq_province) ? trim($item->hq_province->PROVINCE_NAME) : null ;
            $object->applicantion       =  1;

        }  else if($table  == (new CertiIb)->getTable()){ // ib

            if( !is_null($item->hq_subdistrict)  ){
                $hq_subdistrict = trim($item->hq_subdistrict->DISTRICT_NAME);
                $hq_subdistrict = !empty($hq_subdistrict) && (mb_strpos($hq_subdistrict, 'แขวง')===0 || mb_strpos($hq_subdistrict, 'ตำบล')===0) ? trim(mb_substr($hq_subdistrict, 4)) : $hq_subdistrict ; //ตัดคำว่าตำบล/แขวง คำแรกออก
            }

            if( !is_null($item->hq_district)  ){
                $hq_district = trim($item->hq_district->AMPHUR_NAME);
                $hq_district = !empty($hq_district) && mb_strpos($hq_district, 'อำเภอ')===0 ? trim(mb_substr($hq_district, 5)) : $hq_district ; //ตัดคำว่าอำเภอ คำแรกออก
                $hq_district = !empty($hq_district) && mb_strpos($hq_district, 'เขต')===0 ? trim(mb_substr($hq_district, 3)) : $hq_district ; //ตัดคำว่าเขต คำแรกออก
            }

            $object->user_created       =  $item->user_created;
            $object->applicanttype_id   =  $item->user_created->applicanttype_id ?? null ;
            $object->tax_number         =  $item->tax_id;
            $object->name               =  $item->name;
            $object->address_no         =  $item->hq_address;
            $object->soi                =  $item->hq_soi;
            $object->street             =  $item->hq_road;
            $object->moo                =  $item->hq_moo;
            $object->subdistrict        =  !empty($hq_subdistrict)?$hq_subdistrict : null ;
            $object->district           =  !empty($hq_district)?$hq_district : null ;
            $object->province           =  !is_null($item->hq_province) ? trim($item->hq_province->PROVINCE_NAME) : null ;
            $object->applicantion       =  1;

        }

        if( $update == true ){
            return $object;
        }else{
            return $this->CheckLegalEntityANDPerson($object);   // นิติบุคคล
        }
  

    }

    public function CheckLegalEntityANDPerson($data_user){

        $response = (object)['status' => 'error', 'msg' => ''];

        if(!empty($data_user->tax_number)  &&  strlen($data_user->tax_number) == 13){

            if($data_user->applicanttype_id == 1){ // เช็ค นิติบุคคล ใน DBD

                $entity  =  self::CheckLegalEntity($data_user->tax_number);   // นิติบุคคล

                if($entity['status'] === 'false'){

                    $response->msg = 'ขออภัยเลขนิติบุคคล '.$data_user->tax_number .' ไม่พบการขึ้นทะเบียนกับกรมพัฒนาธุรกิจการค้า';

                }else if($entity['status'] === true){ /// request api ไม่ได้อนุญาตให้ login ได้

                    $response->msg = '<h3 class="text-center">ไม่สามารถเชื่อมต่อบริการได้ในขณะนี้</h3>';

                }else if(!in_array($entity['status'], [1,2,3])){ //1.ยังดำเนินกิจการอยู่, 2.ฟื้นฟู, 3.คืนสู่ทะเบียน
                    
                    $response->msg = 'เลขนิติบุคคล'. $data_user->tax_number . ' เนื่องจากมีสถานะกิจการเป็น:&nbsp;<u>'.$entity['status'].'</u>';

                }else if(in_array($entity['status'], [1,2,3])){ //1.ยังดำเนินกิจการอยู่, 2.ฟื้นฟู, 3.คืนสู่ทะเบียน // Login ปกติ

                    $compare_msg =  self::compareCompanyAndUpdate($data_user, $entity['data']);//เปรียบเทียบข้อมูลและอัพเดทลงฐานข้อมูล

                    if($compare_msg->msg != ''){
                        $response =  $compare_msg;
                    }else{
                        $response->msg = '<h3 class="text-center">ไม่พบข้อมูลในกรมพัฒนาธุรกิจการค้า</h3>';
                    }
                }

            }elseif($data_user->applicanttype_id == 2){ // เช็ค บุคคลธรรมดา ใน DOPA

                $person = self::getPerson($data_user->tax_number);

                if(is_null($person)){//ไม่พบข้อมูลในทะเบียนราษฎร์

                    $response->msg =   'ขออภัยเลขประจำตัวประชาชน '. $data_user->tax_number . ' ไม่พบในทะเบียนราษฎร์';
                    
                }elseif($person === true){ // request api ไม่ได้อนุญาตให้ login ได้

                    $response->msg = '<h3 class="text-center">ไม่สามารถเชื่อมต่อบริการได้ในขณะนี้</h3>';

                }elseif($person->statusOfPersonCode == '1'){//เสียชีวิต

                    $response->msg =  'เลขประจำตัวประชาชน '. $data_user->tax_number . ' ไม่สามารถ Login ได้ เนื่องจากมีสถานะเป็น:&nbsp;<u>เสียชีวิต</u>';

                }else{// Login ปกติ

                    $compare_msg = self::comparePersonAndUpdate($data_user,$person);//เปรียบเทียบข้อมูลและอัพเดทลงฐานข้อมูล

                    if($compare_msg != ''){
                        $response =  $compare_msg;
                    }else{
                        $response->msg = '<h3 class="text-center">ไม่พบข้อมูลในกรมการปกครอง</h3>';
                    }
                }
            }

        }

        return response()->json($response);
    }

    //  DBD
    static function CheckLegalEntity($tax_number){

        $response = ['status' => 'false', 'data' => null];

        $config = HP::getConfig();

        $url = $config->tisi_api_corporation_url; //'https://www3.tisi.go.th/moiapi/srv.asp?pid=1';

        $data = array(
                        'val' => $tax_number,
                        'IP' =>  $_SERVER['REMOTE_ADDR'],    // IP Address,
                        'Refer' => 'accr.tisi.go.th'
                    );

        $options = array(
                            'http' => array(
                                'header'  => "Content-type: application/x-www-form-urlencoded",
                                'method'  => 'POST',
                                'content' => http_build_query($data),
                                'timeout' => 30
                            )
                        );

        if(strpos($url, 'https')===0){//ถ้าเป็น https
            $options["ssl"] = array(
                                        "verify_peer" => false,
                                        "verify_peer_name" => false,
                                    );
        }

        $context  = stream_context_create($options);
        $i = 1;

        start:
        if($i <= 3){
            try {
                $json_data = file_get_contents($url, false, $context);
                $api = json_decode($json_data);
                if(!empty($api->JuristicName_TH)){
                    $juristic_status = ['ยังดำเนินกิจการอยู่' => '1', 'ฟื้นฟู' => '2', 'คืนสู่ทะเบียน' => '3'];
                    $status = array_key_exists($api->JuristicStatus,$juristic_status) ? $juristic_status[$api->JuristicStatus] : $api->JuristicStatus ;  //สถานะนิติบุคคล
                    $response['status'] = $status;
                    $response['data'] = $api;
                }
            } catch (\Exception $e) {
                $i ++;
                goto start;
            }
        }else{
            $response['status'] = true;
        }

        return $response;

    }

    //  ประชาชน
    static function getPerson($tax_id){
        $person = null;

        $config = HP::getConfig();

        $url = $config->tisi_api_person_url; //'https://www3.tisi.go.th/moiapi/srv.asp?pid=2';

        $data = array(
                        'val'   => $tax_id,
                        'IP' =>  $_SERVER['REMOTE_ADDR'],    // IP Address,
                        'Refer' => 'sso.tisi.go.th'
                    );

        $options = array(
                            'http' => array(
                                'header'  => "Content-type: application/x-www-form-urlencoded",
                                'method'  => 'POST',
                                'content' => http_build_query($data),
                                'timeout' => 30
                            )
                        );

        if(strpos($url, 'https')===0){//ถ้าเป็น https
            $options["ssl"] = array(
                                        "verify_peer" => false,
                                        "verify_peer_name" => false,
                                    );
        }

        $context  = stream_context_create($options);

        $i = 1;
        start:
        if($i <= 3){
            try {
                $json_data = file_get_contents($url, false, $context);
                $api = json_decode($json_data);
                if(!empty($api->firstName)){
                    $person = $api;
                }elseif(property_exists($api, 'Code') && $api->Code=='90001'){//ไม่ได้ login ที่ API สปอ. ให้ผ่านเข้าระบบได้
                    $person = true;
                }
            } catch (\Exception $e) {
                $i ++;
                goto start;
            }
        }else{
            $person = true;
        }

        return $person;
    }

    //เปรียบเทียบข้อมูลและอัพเดทลงฐานข้อมูล นิติบุคคล
    static function compareCompanyAndUpdate($user, $company){

        $result = (object)['status' => 'error', 'msg' => ''];
        $data_changes = [];//เก็บข้อมูลที่ไม่ตรงเพื่อแสดงผล
        $msg_html     = '';

        if(in_array($company->JuristicType, ['บริษัทจำกัด', 'บริษัทมหาชนจำกัด'])){
            $company_name = 'บริษัท '.$company->JuristicName_TH;
        }else if(in_array($company->JuristicType, ['ห้างหุ้นส่วนจำกัด'])){
            $company_name = 'ห้างหุ้นส่วนจำกัด '.$company->JuristicName_TH;
        }else{
            $company_name = $company->JuristicName_TH;
        }

        replace_space:
        $company_name = str_replace('  ', ' ', trim($company_name));
        if(mb_strpos($company_name, '  ')!==false){//ยังมีการช่องว่างมากกว่า 1 ช่องติดกัน
            goto replace_space;
        }

        if($user->name!=$company_name){//ชื่อบริษัทไม่ตรง
            $user->name = $company_name;
        }

        //ชื่อบริษัท
        $data_changes[] = ['label' => 'ชื่อบริษัท', 'old' => $user->name, 'new' => $company_name, 'status' => ($user->name == $company_name )];

        //ที่ตั้งสำนักงาน
        $address = [];
        if(property_exists($company, 'AddressInformations') && count($company->AddressInformations) > 0){

            foreach ($company->AddressInformations as $info) {
                if($info->AddressName=='สำนักงานใหญ่'){
                    $address = $info;
                    break;
                }
            }

            if(count((array)$address)==0){//ไม่มี สำนักงานใหญ่ ให้เอาข้อมูล Array ชุดแรกเป็นสำนักงานใหญ่
                $address = $company->AddressInformations[0];
            }

            $address = self::format_address_company_api($address);

            //เลขที่
            $data_changes[] = [ 'label' => 'เลขที่ (สำนักงานใหญ่)', 'old' => $user->address_no, 'new' => $address->AddressNo, 'status' => ($user->address_no == $address->AddressNo ) ];

            //หมู่
            $data_changes[] = ['label' => 'หมู่ (สำนักงานใหญ่)', 'old' => $user->moo, 'new' => $address->Moo , 'status' => ($user->moo == $address->Moo ) ];

            //ซอย
            $data_changes[] = ['label' => 'ตรอก/ซอย (สำนักงานใหญ่)', 'old' => $user->soi, 'new' => $address->Soi, 'status' => ($user->soi == $address->Soi ) ];

            //ถนน
            $data_changes[] = ['label' => 'ถนน (สำนักงานใหญ่)', 'old' => $user->street, 'new' => $address->Road, 'status' => ($user->street == $address->Road ) ];

            //ตำบล/แขวง
            $data_changes[] = ['label' => 'ตำบล/แขวง (สำนักงานใหญ่)', 'old' => $user->subdistrict, 'new' => $address->Tumbol, 'status' => ($user->subdistrict == $address->Tumbol ) ];

            //ตำบล/แขวง
            $data_changes[] = ['label' => 'อำเภอ/เขต (สำนักงานใหญ่)', 'old' => $user->district, 'new' => $address->Ampur, 'status' => ($user->district == $address->Ampur ) ];

            //จังหวัด
            $data_changes[] = ['label' => 'จังหวัด (สำนักงานใหญ่)', 'old' => $user->province, 'new' => $address->Province,  'status' => ($user->province == $address->Province ) ];

        }

        //HTML แสดงข้อมูลที่เปลี่ยนแปลง
        $type = 'company';

        $amount_data = count($data_changes);
        $amount_true = 0;
        foreach( $data_changes AS $item ){
            if( $item['status'] == true ){
                $amount_true++;
            }
        }

        $result->status = $amount_data==$amount_true ? 'success' : 'fail'; //success=ข้อมูลตรงกันทั้งหมด
        $result->msg    =  (object)[ 'data' => $data_changes, 'type' => $type  ];
        return $result;

    }

    //เปรียบเทียบข้อมูลและอัพเดทลงฐานข้อมูล บุคคลธรรมดา
    static function comparePersonAndUpdate($user, $person){

        $result = (object)['status' => 'error', 'msg' => ''];

        $data_changes = [];//เก็บข้อมูลที่ไม่ตรงเพื่อแสดงผล
        $msg_html     = '';

        $person_name = $person->titleName.$person->firstName.' '.$person->lastName;//ชื่อเต็ม

        replace_space:
        $person_name = str_replace('  ', ' ', trim($person_name));
        if(mb_strpos($person_name, '  ')!==false){//ยังมีการช่องว่างมากกว่า 1 ช่องติดกัน
            goto replace_space;
        }

        //ชื่อ
        $data_changes[] = ['label' => 'ชื่อ', 'old' => $user->name, 'new' => $person_name, 'status' => ($user->name == $person_name )];

        $type = 'person';
        // $msg_html = view('api.modal.change_address',compact('data_changes', 'type'));

        $amount_data = count($data_changes);
        $amount_true = 0;
        foreach( $data_changes AS $item ){
            if( $item['status'] == true ){
                $amount_true++;
            }
        }

        $result->status = $amount_data==$amount_true ? 'success' : 'fail'; //success=ข้อมูลตรงกันทั้งหมด
        $result->msg    =  (object)[ 'data' => $data_changes, 'type' => $type  ];
        return $result;

    }

    
    //ประเภทการลงทะเบียน
    static function applicant_types(){
        return [
                    '1' => 'นิติบุคคล',
                    '2' => 'บุคคลธรรมดา',
                    '3' => 'คณะบุคคล',
                    '4' => 'ส่วนราชการ',
                    '5' => 'อื่นๆ'
               ];
    }

    //ประเภทนิติบุคคล
    static function juristic_types(){
        return [
                    '1' => 'บริษัทจำกัด',
                    '2' => 'บริษัทมหาชนจำกัด',
                    '3' => 'ห้างหุ้นส่วนจำกัด',
                    '4' => 'ห้างหุ้นส่วนสามัญนิติบุคคล'
               ];
    }

    //ประเภทสาขา
    static function branch_types(){
        return [
                    '1' => 'สำนักงานใหญ่',
                    '2' => 'สาขา'
               ];
    }

    static function format_address_company_api($address){
        $FullAddress = $address->FullAddress;

        $address_no = $building = $floor = $room_no = $village_name = $moo = $soi = $road = null;

        //ค้นหาอาคาร
        $index_building = mb_strpos($FullAddress, 'อาคาร');

        //ค้นหาชั้นที่
        $index_floor = mb_strpos($FullAddress, 'ชั้นที่');

        //ค้นหาห้องเลขที่
        $index_room_no = mb_strpos($FullAddress, 'ห้องเลขที่');

        //ค้นหาหมู่บ้าน
        $index_village_name = mb_strpos($FullAddress, 'หมู่บ้าน');

        //ค้นหาหมู่
        $index_moo = mb_strpos($FullAddress, 'หมู่ที่');

        //ค้นหาซอย
        $index_soi = mb_strpos($FullAddress, 'ซอย');

        //ค้นหาถนน
        $index_road = mb_strpos($FullAddress, 'ถนน');

        //หาเลขที่
        $address_no = self::cut_string($FullAddress, 0, [$index_moo, $index_soi, $index_road]);

        //หาชื่ออาคาร
        if($index_building!==false){
            $building = self::cut_string($FullAddress, $index_building, [$index_floor, $index_room_no, $index_village_name, $index_moo, $index_soi, $index_road]);
        }

        //หาชื่อชั้น
        if($index_floor!==false){
            $floor = self::cut_string($FullAddress, $index_floor, [$index_room_no, $index_village_name, $index_moo, $index_soi, $index_road]);
        }

        //หาชื่อห้อง
        if($index_room_no!==false){
            $room_no = self::cut_string($FullAddress, $index_room_no, [$index_village_name, $index_moo, $index_soi, $index_road]);
        }

            //หาชื่อหมู่บ้าน
        if($index_village_name!==false){
            $village_name = self::cut_string($FullAddress, $index_village_name, [$index_moo, $index_soi, $index_road]);
        }

        //หาชื่อหมู่ที่
        if($index_moo!==false){
            $moo = self::cut_string($FullAddress, $index_moo, [$index_soi, $index_road]);
        }

        //หาชื่อซอย
        if($index_soi!==false){
            $soi = self::cut_string($FullAddress, $index_soi, [$index_road]);
        }

        //หาชื่อถนน
        if($index_road!==false){
            $road = self::cut_string($FullAddress, $index_road, [mb_strlen($FullAddress)]);
        }

        if((is_null($address->AddressNo) && !is_null($address_no)) || (strlen(trim($address->AddressNo)) > strlen(trim($address_no)) && !is_null($address_no))){//ถ้าเลขที่ในข้อมูลย่อยไม่มีให้เอาไปใส่แทน หรือข้อมูลย่อยยาวกว่า
            $address->AddressNo = self::replace_multi_space($address_no);
        }

        if(is_null($address->Building) && !is_null($building)){//ถ้าหมู่ที่ในข้อมูลย่อยไม่มีให้เอาไปใส่แทน
            $address->Building = self::replace_multi_space(mb_substr($building, mb_strlen('หมู่ที่')));
        }elseif(!is_null($address->Building)){
            $address->Building = trim($address->Building);
            $address->Building = !empty($address->Building) && mb_strpos($address->Building, 'อาคาร')===0 ? trim(mb_substr($address->Building, 5)) : $address->Building ; //ตัดคำว่าอาคาร คำแรกออก
        }

        if(is_null($address->Moo) && !is_null($moo)){//ถ้าหมู่ที่ในข้อมูลย่อยไม่มีให้เอาไปใส่แทน
            $address->Moo = self::replace_multi_space(mb_substr($moo, mb_strlen('หมู่ที่')));
        }elseif(!is_null($address->Moo)){
            $address->Moo = trim($address->Moo);
            $address->Moo = !empty($address->Moo) && mb_strpos($address->Moo, 'หมู่ที่')===0 ? trim(mb_substr($address->Moo, 7)) : $address->Moo ; //ตัดคำว่าหมู่ที่ คำแรกออก
        }

        if(is_null($address->Soi) && !is_null($soi)){//ถ้าซอยในข้อมูลย่อยไม่มีให้เอาไปใส่แทน
            $address->Soi = self::replace_multi_space(mb_substr($soi, mb_strlen('ซอย')));
        }elseif(!is_null($address->Soi)){
            $address->Soi = trim($address->Soi);
            $address->Soi = !empty($address->Soi) && mb_strpos($address->Soi, 'ซอย')===0 ? trim(mb_substr($address->Soi, 3)) : $address->Soi ; //ตัดคำว่าซอย คำแรกออก
        }

        if(is_null($address->Road) && !is_null($road)){//ถ้าถนนในข้อมูลย่อยไม่มีให้เอาไปใส่แทน
            $address->Road = self::replace_multi_space(mb_substr($road, mb_strlen('ถนน')));
        }elseif(!is_null($address->Road)){
            $address->Road = trim($address->Road);
            $address->Road = !empty($address->Road) && mb_strpos($address->Road, 'ถนน')===0 ? trim(mb_substr($address->Road, 3)) : $address->Road ; //ตัดคำว่าถนน คำแรกออก
        }

        $address->Tumbol = trim($address->Tumbol);
        $address->Tumbol = !empty($address->Tumbol) && (mb_strpos($address->Tumbol, 'แขวง')===0 || mb_strpos($address->Tumbol, 'ตำบล')===0) ? trim(mb_substr($address->Tumbol, 4)) : $address->Tumbol ; //ตัดคำว่าตำบล/แขวง คำแรกออก

        $address->Ampur = trim($address->Ampur);
        $address->Ampur = !empty($address->Ampur) && mb_strpos($address->Ampur, 'อำเภอ')===0 ? trim(mb_substr($address->Ampur, 5)) : $address->Ampur ; //ตัดคำว่าอำเภอ คำแรกออก
        $address->Ampur = !empty($address->Ampur) && mb_strpos($address->Ampur, 'เขต')===0 ? trim(mb_substr($address->Ampur, 3)) : $address->Ampur ; //ตัดคำว่าเขต คำแรกออก

        //เปลี่ยนข้อมูลเลขที่ใหม่โดยรวมเอา อาคาร ชั้น ห้อง หมู่บ้าน มาต่อท้าย
        $address->AddressNo = self::replace_multi_space($address_no);

        return $address;
    }

    static function cut_string($FullAddress, $index_source, $index_compares){

        $result = null;

        foreach ($index_compares as $key => $index_compare) {
            if($index_compare!==false){//ถ้าพบข้อมูล
                $result = mb_substr($FullAddress, $index_source, $index_compare-$index_source);
                break;
            }
        }

        if(is_null($result)){//ถ้าเป็น null แสดงว่าเป็นคำสุดท้ายของ FullAddress
            $result = mb_substr($FullAddress, $index_source);
        }

        return $result;

    }

    static function replace_multi_space($string){//ลบช่องว่างที่อยู่ติดกันให้เหลือเว้นแค่ 1 ช่อง

        replace_space:
        $string = str_replace('  ', ' ', trim($string));
        if(mb_strpos($string, '  ')!==false){//ยังมีการช่องว่างมากกว่า 1 ช่องติดกัน
            goto replace_space;
        }

        return $string;

    }

    //เช็คข้อมูลเป็นตัวเลขทั้งหมดหรือไม่ ครบ 13 หลักหรือไม่
    static function check_number_counter($input, $counter=13){
        $converted = preg_replace("/[^0-9]/", '', $input);
        return $converted===$input && strlen($input)===$counter ? true : false;
    }

    public function update_api_pid(Request $request)
    {
        $table = $request->get('table');
        $id = $request->get('id');

        if( (new CertiLab)->getTable() == $table ){
            $data  =  CertiLab::findOrFail($id);
        }else if( (new CertiCb)->getTable() == $table ){
            $data  =  CertiCb::findOrFail($id);
        }else if( (new CertiIb)->getTable() == $table ){
            $data  =  CertiIb::findOrFail($id);
        }

        $result = (object)['status' => 'error', 'msg' => ''];

        if( !is_null($data) ){
            $applicanttype_id   =  $data->user_created->applicanttype_id ?? null ;
            $tax_number         =  $data->tax_id;

            if(!empty($tax_number) && self::check_number_counter($tax_number, 13) ){

                if($applicanttype_id == 1){ // เช็ค นิติบุคคล ใน DBD

                    $entity =  self::CheckLegalEntity($tax_number);   // นิติบุคคล

                    $company = $entity['data'];

                    if(isset($company->JuristicType)){//ได้ข้อมูล

                        if(in_array($company->JuristicType, ['บริษัทจำกัด', 'บริษัทมหาชนจำกัด'])){
                            $company_name = 'บริษัท '.$company->JuristicName_TH;
                        }else if(in_array($company->JuristicType, ['ห้างหุ้นส่วนจำกัด'])){
                            $company_name = 'ห้างหุ้นส่วนจำกัด '.$company->JuristicName_TH;
                        }else{
                            $company_name = $company->JuristicName_TH;
                        }
        
                        $company_name = self::replace_multi_space($company_name);
        
                        //เซตข้อมูล
                        $data->name = $company_name;

                        //ที่ตั้งสำนักงาน
                        $address = [];
                        if(property_exists($company, 'AddressInformations') && count($company->AddressInformations) > 0){

                            foreach ($company->AddressInformations as $info) {
                                if($info->AddressName=='สำนักงานใหญ่'){
                                    $address = $info;
                                    break;
                                }
                            }

                            if(count((array)$address)==0){//ไม่มี สำนักงานใหญ่ ให้เอาข้อมูล Array ชุดแรกเป็นสำนักงานใหญ่
                                $address = $company->AddressInformations[0];
                            }

                            $address = self::format_address_company_api($address);

                            $DataAddress = HP::getDataAddress(  $address->Province, $address->Ampur, $address->Tumbol );

                            //เซตข้อมูล
                            $data->hq_address        = $address->AddressNo;//เลขที่
                            $data->hq_moo            = $address->Moo;//หมู่
                            $data->hq_soi            = $address->Soi;//ซอย
                            $data->hq_road           = $address->Road;//ถนน
                            $data->hq_subdistrict_id = !empty( $DataAddress->subdistrict_id )?$DataAddress->subdistrict_id:null;//ตำบล
                            $data->hq_district_id    = !empty( $DataAddress->district_id )?$DataAddress->district_id:null;//อำเภอ
                            $data->hq_province_id    = !empty( $DataAddress->province_id )?$DataAddress->province_id:null;//จังหวัด

                            $data->save();

                            $result->status = 'success';
                            $result->msg    = 'อัพเดทข้อมูลเรียบร้อยแล้ว';

                        }
                            
                    }else{
                        $result->msg = '<h3 class="text-center">ไม่พบข้อมูลในกรมพัฒนาธุรกิจการค้า</h3>';
                    }

                }elseif($applicanttype_id == 2){ // เช็ค บุคคลธรรมดา ใน DOPA

                    $person = self::getPerson($tax_number);

                    if(isset($person->Code)){
                        if($person->Code=='00404'){
                            $result->msg = '<h3 class="text-center">ไม่พบข้อมูลในกรมการปกครอง</h3>';
                        }else{
                            $result->msg = '<h3 class="text-center">'.$person->Message.'</h3>';
                        }
                    }elseif($person->status=='no-connect'){
                        $result->msg = '<h3 class="text-center">ไม่สามารถเชื่อมต่อบริการได้ในขณะนี้</h3>';
                    }elseif(isset($person->firstName)){//ได้ข้อมูล

                        $person_name = $person->titleName.$person->firstName.' '.$person->lastName;//ชื่อเต็ม
                        //เซตข้อมูล
                        $data->name = $person_name;
                        $data->save();

                        $result->status = 'success';
                        $result->msg    = 'อัพเดทข้อมูลเรียบร้อยแล้ว';

                    }else{
                        $result->msg = '<h3 class="text-center">ไม่พบข้อมูลในกรมการปกครอง</h3>';
                    }

                }

            }else{
                $result->msg = 'รูปแบบข้อมูลเลขประจำตัวผู้เสียภาษีไม่ถูกต้อง';
            }

        }

        return response()->json($result);

    }

}
