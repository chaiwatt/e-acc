<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\InformVolume as inform_volume;
use App\Models\Esurv\InformVolumeLicense;
use App\Models\Esurv\InformVolumeLicenseDetail;
use App\Models\Basic\TisiLicenseDetail;
use App\Models\Basic\TisiLicense;
use App\Models\Basic\Tis;
use App\Models\Basic\UnitCode;

use Illuminate\Http\Request;

use Storage;
use HP;
use Excel;
class InformVolumeController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/inform_volume/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_volume');
        if(auth()->user()->can('view-'.$model)) {

            $user_id = auth()->user()->getKey();

            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_volume = inform_volume::where('inform_month', 'LIKE', "%$keyword%")
                ->orWhere('inform_year', 'LIKE', "%$keyword%")
                ->orWhere('remark', 'LIKE', "%$keyword%")
                ->orWhere('attach', 'LIKE', "%$keyword%")
                ->orWhere('applicant_name', 'LIKE', "%$keyword%")
                ->orWhere('tel', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $inform_volume = inform_volume::where("trader_id",  auth()->user()->trader_id)
                                                                             ->sortable(['id' => 'desc'])
                                                                             ->with('user_created')
                                                                             ->with('user_updated')
                                                                             ->paginate($perPage);
            }

            return view('esurv.inform_volume.index', compact('inform_volume'));
        }
        abort(403);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = str_slug('inform_volume','-');

        if(auth()->user()->can('add-'.$model)) {

            $user = auth()->user();

            $inform_volume = new inform_volume();

            $applicant = (object)[];
            $applicant->applicant_name = $user->trader_operater_name;
            $applicant->tel = $user->trader_mobile;
            $applicant->email = $user->agent_email;

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            $own_licenses = [];

            return view('esurv.inform_volume.create', compact('inform_volume',
                                                              'applicant',
                                                              'attachs',
                                                              'attach_path',
                                                              'own_licenses'));

        }

        abort(403);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $model = str_slug('inform_volume','-');
        if(auth()->user()->can('add-'.$model)) {

            $this->validate($request, [
        			'inform_month' => 'required',
        			'inform_year' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required'
        		]);

            $request->request->add(['created_by' => auth()->user()->getKey()]); //user create
            $requestData = $request->all();
            $requestData['trader_id'] = auth()->user()->trader_id;
            //ไฟล์แนบ
            $attachs = [];
            if ($files = $request->file('attachs')) {

              foreach ($files as $key => $file) {

                //Upload File
                $storagePath = Storage::put($this->attach_path, $file);
                $storageName = basename($storagePath); // Extract the filename

                $attachs[] = ['file_name'=>$storageName,
                              'file_client_name'=>$file->getClientOriginalName(),
                              'file_note'=>$requestData['attach_notes'][$key]
                             ];
              }

            }

            $requestData['attach'] = json_encode($attachs);

            $inform_volume = inform_volume::create($requestData);//บันทึกตารางหลัก

            $this->SaveLicenseAndDetail($inform_volume, $requestData);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_volume')->with('flash_message', 'เพิ่ม inform_volume เรียบร้อยแล้ว');
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $model = str_slug('inform_volume','-');
        if(auth()->user()->can('view-'.$model)) {

            //ข้อมูลการแจ้งปริมาณ
            $inform_volume = inform_volume::findOrFail($id);
            $inform_volume->starndard = Tis::where("tb3_Tisno", $inform_volume->tb3_Tisno)->first();

            // dd($inform_volume);

            //ไฟล์แนบ
            $attachs = json_decode($inform_volume['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //เลขที่ใบอนุญาต
            $inform_volume_licenses = InformVolumeLicense::where("inform_volume_id", $inform_volume->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $inform_mount_year = $inform_volume->year."-".$inform_volume->month;

            // var_dump($inform_volume_licenses);
            $own_licenses = HP::OwnLicenseByTisForShow($inform_volume->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน


            //ปริมาณการผลิตตามรายละเอียดผลิตภัณฑ์
            $inform_details = [];
            foreach ($inform_volume_licenses as $key => $inform_volume_license) {
              $inform_volume_details = InformVolumeLicenseDetail::where("inform_volume_license_id", $key)->get();//ที่บันทึกไว้
              foreach ($inform_volume_details as $key => $value) {
                $inform_details[$value->elicense_detail_id] = $value;
              }
            }

            // dd($inform_details);

            //รายละเอียดผลิตภัณฑ์
            $details = [];
            foreach ($inform_volume_licenses as $key => $inform_volume_license) {
              $details[$inform_volume_license] = TisiLicenseDetail::where("licenseNo", $inform_volume_license)->get();
            }

                        // dd($inform_volume_licenses);


            return view('esurv.inform_volume.show', compact('inform_volume',
                                                            'inform_volume_licenses',
                                                            'own_licenses',
                                                            'attachs',
                                                            'attach_path',
                                                            'inform_details',
                                                            'details'
                                                           ));

        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $model = str_slug('inform_volume','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_volume = inform_volume::findOrFail($id);
            $inform_volume->starndard = Tis::where("tb3_Tisno", $inform_volume->tb3_Tisno)->first();

            //ผู้ยื่น
            $applicant = (object)[];
            $applicant->applicant_name = $inform_volume->applicant_name;
            $applicant->tel = $inform_volume->tel;
            $applicant->email = $inform_volume->email;

            //ไฟล์แนบ
            $attachs = json_decode($inform_volume['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //เลขที่ใบอนุญาต
            $inform_volume_licenses = InformVolumeLicense::where("inform_volume_id", $inform_volume->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTisNoMoao5($inform_volume->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            //ปริมาณการผลิตตามรายละเอียดผลิตภัณฑ์
            $inform_details = [];
            foreach ($inform_volume_licenses as $key => $inform_volume_license) {
              $inform_volume_details = InformVolumeLicenseDetail::where("inform_volume_license_id", $key)->get();//ที่บันทึกไว้
              foreach ($inform_volume_details as $key => $value) {
                $inform_details[$value->elicense_detail_id] = $value;
              }
            }

            //รายละเอียดผลิตภัณฑ์
            $details = [];
            foreach ($inform_volume_licenses as $key => $inform_volume_license) {
              $details[$inform_volume_license] = TisiLicenseDetail::where("licenseNo", $inform_volume_license)->get();
            }

            return view('esurv.inform_volume.edit', compact('inform_volume',
                                                            'applicant',
                                                            'attachs',
                                                            'attach_path',
                                                            'own_licenses',
                                                            'inform_volume_licenses',
                                                            'inform_details',
                                                            'details'
                                                           )
                       );
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $model = str_slug('inform_volume','-');
        if(auth()->user()->can('edit-'.$model)) {

            // $this->validate($request, [
        		// 	'inform_month' => 'required',
        		// 	'inform_year' => 'required',
        		// 	'applicant_name' => 'required',
        		// 	'tel' => 'required',
        		// 	'email' => 'required'
        		// ]);

            $inform_volume = inform_volume::findOrFail($id);

            if (empty($inform_volume)) {
                Flash::error('ไม่พบข้อมูลแจ้งปริมาณการผลิตตามเงื่อนไขใบอนุญาต');

                return redirect(route('esurv/inform_volume'));
            }

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
            $input = $request->all();
            $input['trader_id'] = auth()->user()->trader_id;
            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($inform_volume->attach));

            //ไฟล์แนบ ที่ถูกกดลบ
            foreach ($attachs as $key => $attach) {

              if(in_array($attach->file_name, $input['attach_filenames'])===false){//ถ้าไม่มีไฟล์เดิมกลับมา
                unset($attachs[$key]);
                Storage::delete($this->attach_path.$attach->file_name);
              }
            }

            //ไฟล์แนบ ข้อความที่แก้ไข
            foreach ($attachs as $key => $attach) {
              $search_key = array_search($attach->file_name, $input['attach_filenames']);
              if($search_key!==false){
                $attach->file_note = $input['attach_notes'][$search_key];
              }
            }

            //ไฟล์แนบ เพิ่มเติม
            if ($files = $request->file('attachs')) {

              $dir = $this->attach_path;
              foreach ($files as $key => $file) {

                //Upload File
                $storagePath = Storage::put($this->attach_path, $file);
                $newFile = basename($storagePath); // Extract the filename

                if($input['attach_filenames'][$key]!=''){//ถ้าเป็นแถวเดิมที่มีในฐานข้อมูลอยู่แล้ว

                  //วนลูปค้นหาไฟล์เดิม
                  foreach ($attachs as $key2 => $attach) {

                    if($attach->file_name == $input['attach_filenames'][$key]){//ถ้าเจอแถวที่ตรงกันแล้ว

                      Storage::delete($this->attach_path.$attach->file_name);//ลบไฟล์เก่า

                      $attach->file_name = $newFile;//แก้ไขชื่อไฟล์ใน object
                      $attach->file_client_name = $file->getClientOriginalName();//แก้ไขชื่อไฟล์ของผู้ใช้ใน object

                      break;
                    }
                  }

                }else{//แถวที่เพิ่มมาใหม่

                  $attachs[] = ['file_name'=>$newFile,
                                'file_client_name'=>$file->getClientOriginalName(),
                                'file_note'=>$input['attach_notes'][$key]
                               ];
                }

              }

            }

            $input['attach'] = json_encode($attachs);

            $inform_volume->update($input);

            $this->SaveLicenseAndDetail($inform_volume, $input);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_volume')->with('flash_message', 'แก้ไข inform_volume เรียบร้อยแล้ว!');
        }
        abort(403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {
        $model = str_slug('inform_volume','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_volume;
            inform_volume::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_volume::destroy($id);
          }

          return redirect('esurv/inform_volume')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_volume','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_volume;
          inform_volume::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_volume')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save License And Detail
    */
    private function SaveLicenseAndDetail($inform_volume, $requestData){

        InformVolumeLicense::where('inform_volume_id', $inform_volume->id)->delete();

        /* บันทึกข้อมูลใบอนุญาต */
        foreach ((array)@$requestData['tbl_licenseNo'] as $tbl_licenseNo) {
          $input_license = [];
          $input_license['tbl_licenseNo'] = $tbl_licenseNo;
          $input_license['inform_volume_id'] = $inform_volume->id;
          InformVolumeLicense::create($input_license);
        }

        /* บันทึกข้อมูลปริมาณการผลิตตามรายละเอียดผลิตภัณฑ์ */
        foreach ((array)@$requestData['license_detail_checked'] as $key => $details) {

          $input_detail = [];

          if(array_key_exists(1, $details)){
            $detail_id = $details[1];
            $input_detail['volume1'] = $requestData['volume'][$detail_id][1];
          }

          if(array_key_exists(2, $details)){
            $detail_id = $details[2];
            $input_detail['volume2'] = $requestData['volume'][$detail_id][2];
          }

          if(array_key_exists(3, $details)){
            $detail_id = $details[3];
            $input_detail['volume3'] = $requestData['volume'][$detail_id][3];;
          }

          $input_detail['unit'] = $requestData['unit'][$detail_id];

          $detail = TisiLicenseDetail::find($detail_id);//ข้อมูลรายละเอียดผลิตภัณฑ์
          $volumelicense = InformVolumeLicense::where('tbl_licenseNo', $detail->tbl_licenseNo)->where('inform_volume_id', $inform_volume->id)->first();//ข้อมูลใบอนุญาตที่ถูกบันทึกในชุดนี้

          $input_detail['inform_volume_license_id'] = $volumelicense->id;
          $input_detail['elicense_detail_id'] = $detail_id;

          InformVolumeLicenseDetail::create($input_detail);

        }
    }
    public function inform_month_and_year($id,$inform_month_id, $inform_year_id){
      $data = [];
      // if($id == 'null'){
            $inform_volume = inform_volume::where('inform_month',$inform_month_id)
                                           ->where('inform_year',$inform_year_id)
                                           ->where('created_by',auth()->user()->getKey())
                                            ->first();
            if(!is_null($inform_volume)){
                 $data['data'] = 'not_null';
                 $data['created_at'] =  HP::DateThai($inform_volume->created_at)  ;
                 $data['inform_month'] =  HP::MonthList()[$inform_volume->inform_month];
                 $data['inform_year'] =  HP::YearList()[$inform_volume->inform_year];
            }else{
                 $data['data'] = 'null';
            }
      // }else{
      //            $data['data'] = 'null';
      // }
      return  $data;
    }

    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);
    $path = $request->file('select_file')->getRealPath();
     $data = Excel::load($path)->get();
    $excel = [];

            Excel::load($path, function($reader) use (&$excel) {
                $objExcel = $reader->getExcel();
                $sheet = $objExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                //  Loop through each row of the worksheet in turn
                for ($row = 1; $row <= $highestRow; $row++)
                {
                    //  Read a row of data into an array
                      $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                       $excel[] = $rowData[0];
                }
            });

            $month = ['มกราคม'=>'01',
                      'กุมภาพันธ์'=>'02',
                      'มีนาคม'=>'03',
                      'เมษายน'=>'04',
                      'พฤษภาคม'=>'05',
                      'พฤษภาคม'=>'06',
                      'กรกฎาคม'=>'07',
                      'สิงหาคม'=>'08',
                      'กันยายน'=>'09',
                      'ตุลาคม'=>'10',
                      'พฤศจิกายน'=>'11',
                      'ธันวาคม'=>'12'];

          $data_have = []; //data ที่มีการ create แล้ว
          $tbl_not_licenseNo = [];   //data ที่มีการ create แล้ว
          $request = [];

          for ($i = 0; $i < count($excel); $i++) {

              for ($j = 0; $j < count($excel[$i]); $j++) {
                  // เดือน
                 if($excel[$i][$j] == "เดือน" && $excel[$i][2] == "ปี"){
                  //  เดือน
                    $MonthList = (array_key_exists($excel[$i][1],$month)) ?  $month[$excel[$i][1] ] :'';
                    //  ปี
                    $YearList = (in_array($excel[$i][3],HP::YearList())) ?  ($excel[$i][3] -543) : '';


                    if($MonthList != '' && $YearList != ''){
                      $requestData =[];
                      $requestData['inform_month'] = (string)$MonthList;
                      $requestData['inform_year']  = $YearList;
                    }
                    $inform_volume = inform_volume::where('inform_month',$MonthList)
                                                    ->where('inform_year',$YearList)
                                                    ->where('created_by',auth()->user()->getKey())
                                                   ->first();
                    if(!is_null($inform_volume)){
                     //data ที่มีอยู่แล้ว
                      $data =[];
                      $data['data'] = $inform_volume->id;
                      $data['created_at'] =  HP::DateThai($inform_volume->created_at)  ;
                      $data['inform_month'] =  HP::MonthList()[$inform_volume->inform_month];
                      $data['inform_year'] =  HP::YearList()[$inform_volume->inform_year];
                      $data_have[] = $data;
                    }
                  }
                  if($excel[$i][$j] == "มาตรฐาน"){
                    // มาตรฐาน
                    $str_license = explode(".", (string)$excel[$i][1]);
                    $last_license = substr($str_license[1], 0, 9);
                    $tb3_Tis = Tis::where('tb3_Tisno', 'LIKE', "%$last_license%")->first() ;
                    if(!is_null($tb3_Tis)){
                      $requestData['tb3_Tisno'] = $tb3_Tis->tb3_Tisno;
                       if($tb3_Tis->tb3_Tisforce == 'บ'){
                        $requestData['tb3_Tisforce'] ='มาตรฐานบังคับ';
                      }else{
                        $requestData['tb3_Tisforce'] ='มาตรฐานทั่วไป';
                      }
                    }else{
                      $requestData['tb3_Tisno'] = 'not';
                    }
                  }


                 if($excel[$i][$j] == "ใบอนุญาตเลขที่" && isset($requestData['tb3_Tisno']) &&$requestData['tb3_Tisno'] != 'not'){
                          $tb3_Tis =  $requestData['tb3_Tisno'];
                          $own_licenses = HP::OwnLicenseByTisNoMoao5($tb3_Tis);//ทั้งหมดที่มี ตามมาตรฐาน
                      // ใบอนุญาตเลขที่
                        foreach ($own_licenses as $key => $own_license){
                              if($own_license->tbl_licenseNo ==  str_replace(' ', '',$excel[$i][1])){
                                $requestData['tbl_licenseNo'][] = $own_license->tbl_licenseNo ; // ใบอนุญาตเลขที่

                                // รายการที่
                                $Autono =   HP::LicenseDetailByLicenseNo($own_license->Autono);
                                $number = ( $requestData['tb3_Tisforce'] == 'มาตรฐานบังคับ') ? 2 : 3;
                                $order = ($excel[$i+1][1] == "รายการที่")  ? $i + $number : null;

                                if(!is_null($order)){
                                  foreach ($Autono as $key => $itme) {
                                      if(($key +1) == $excel[$order][1]){
                                        if( $requestData['tb3_Tisforce'] == 'มาตรฐานบังคับ'){
                                          $requestData['license_detail_checked'][$itme->id][1] =!empty(($excel[$order][1] != "null")) ? $itme->id :'';
                                          $requestData['volume'][$itme->id][1] = $excel[$order][3];
                                          $list =  $excel[$order][4];
                                          $UnitCode = UnitCode::where('name_unit', 'LIKE', "%$list%")->first() ;
                                          $requestData['unit'][$itme->id] = !empty($UnitCode->Auto_num) ? $UnitCode->Auto_num:475;
                                        }else{  //มาตรฐานทั่วไป
                                          $requestData['license_detail_checked'][$itme->id][2] = !empty(($excel[$order][3] != "null")) ?$itme->id :'';
                                          $requestData['volume'][$itme->id][2] = $excel[$order][3];
                                          $requestData['license_detail_checked'][$itme->id][3] = !empty(($excel[$order][4] != "null")) ?$itme->id :'';
                                          $requestData['volume'][$itme->id][3] = $excel[$order][4];
                                          $list =  $excel[$order][5];
                                          $UnitCode = UnitCode::where('name_unit', 'LIKE', "%$list%")->first() ;
                                          $requestData['unit'][$itme->id] = !empty($UnitCode->Auto_num) ? $UnitCode->Auto_num:475;
                                        }
                                        $order++ ;
                                      }
                                  }
                                }
                                // $requestData['Autono'][] = $Autono;
                              }else{
                                $tbl_not_licenseNo[] = $excel[$i][1]; // not  ใบอนุญาตเลขที่4
                              }
                        }
                 }

                if($excel[$i][$j] == "หมายเหตุ"){
                    $requestData['remark'] = (string)$excel[$i][1];
                  }
                  if($excel[$i][$j] == "ชื่อผู้บันทึก"){
                    $requestData['applicant_name'] = (string)$excel[$i][1];
                  }
                  if($excel[$i][$j] == "เบอร์โทร"){
                    $requestData['tel'] = (string)$excel[$i][1];
                  }
                  if($excel[$i][$j] == "E-mail"){
                    $requestData['email'] = (string)$excel[$i][1];
                  }
                  if($excel[$i][$j] == "สถานะ"){
                    $requestData['state'] = ($excel[$i][1] == "ส่งข้อมูลให้สมอ.") ? 1 :0;
                    $request[]= $requestData;
                  }
              }

          }

          if(count($request) > 0 ){
            foreach ($request as $key => $itme) {
              $input = [];
              $input['inform_month'] = $itme['inform_month'];
              $input['inform_year'] = $itme['inform_year'];
              $input['tb3_Tisno'] = $itme['tb3_Tisno'];
              $input['remark'] = $itme['remark'];
              $input['applicant_name'] = $itme['applicant_name'];
              $input['email'] = $itme['email'];
              $input['state'] = $itme['state'];
              $input['tel'] = $itme['tel'];
              $input['created_by'] =auth()->user()->getKey();
              $inform_volume = inform_volume::create($input);
              $this->SaveLicenseAndDetail($inform_volume, $itme);//บันทึกข้อมูลใบอนุญาตและรายละเอียด
            }
          }
          return back()->with('success', 'Excel Data Imported successfully.');
          // return redirect('esurv/inform_volume', compact('tbl_not_licenseNo','data_have'))
          //       ->with('flash_message', 'บันทึกเรียบร้อยแล้ว!');
    }

}
