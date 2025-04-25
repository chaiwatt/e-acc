<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\InformCalibrate as inform_calibrate;
use App\Models\Esurv\InformCalibrateLicense;
use App\Models\Esurv\InformCalibrateDetail;
use Illuminate\Http\Request;

use Storage;
use HP;

class InformCalibrateController extends Controller
{
    private $attach_path; //ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/inform_calibrate/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('view-'.$model)) {

            $user_id = auth()->user()->getKey();

            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_calibrate = inform_calibrate::where('tb3_Tisno', 'LIKE', "%$keyword%")
                ->orWhere('applicant_name', 'LIKE', "%$keyword%")
                ->orWhere('tel', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $inform_calibrate = inform_calibrate::where("trader_id",   auth()->user()->trader_id)
                                                    ->sortable(['id' => 'desc'])
                                                    ->with('user_created')
                                                    ->with('user_updated')
                                                    ->paginate($perPage);
            }

            return view('esurv.inform_calibrate.index', compact('inform_calibrate'));
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
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('add-'.$model)) {

            $own_licenses = [];

            $inform_details = [(object)['tool'=>'',
                                        'detail'=>json_encode(['']),
                                        'exam_date'=>'',
                                        'attach_result'=>json_encode([])]];

            $attach_path = $this->attach_path;//path ไฟล์แนบ

            return view('esurv.inform_calibrate.create', compact('own_licenses',
                                                                 'inform_details',
                                                                 'attach_path'
                                                                ));

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
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
			          'tb3_Tisno' => 'required'
		        ]);

            $request->request->add(['created_by' => auth()->user()->getKey()]); //user create
            $requestData = $request->all();
            $requestData['trader_id'] = auth()->user()->trader_id;
            $inform_calibrate = inform_calibrate::create($requestData);

            $this->SaveLicenseAndDetail($inform_calibrate, $requestData, $request);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_calibrate')->with('flash_message', 'เพิ่ม inform_calibrate เรียบร้อยแล้ว');
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
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('view-'.$model)) {

            $inform_calibrate = inform_calibrate::findOrFail($id);

            //เลขที่ใบอนุญาต
            $inform_change_licenses = InformCalibrateLicense::where("inform_calibrate_id", $inform_calibrate->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_calibrate->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            //ข้อมูลรายการที่ใช้วัด
            $inform_details = InformCalibrateDetail::where("inform_calibrate_id", $inform_calibrate->id)->get();

            $attach_path = $this->attach_path;//path ไฟล์แนบ

            return view('esurv.inform_calibrate.show', compact('inform_calibrate',
                                                               'own_licenses',
                                                               'inform_change_licenses',
                                                               'inform_details',
                                                               'attach_path'
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
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_calibrate = inform_calibrate::findOrFail($id);

            //เลขที่ใบอนุญาต
            $inform_change_licenses = InformCalibrateLicense::where("inform_calibrate_id", $inform_calibrate->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_calibrate->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            //ข้อมูลรายการที่ใช้วัด
            $inform_details = InformCalibrateDetail::where("inform_calibrate_id", $inform_calibrate->id)->get();

            $attach_path = $this->attach_path;//path ไฟล์แนบ

            return view('esurv.inform_calibrate.edit', compact('inform_calibrate',
                                                               'own_licenses',
                                                               'inform_change_licenses',
                                                               'inform_details',
                                                               'attach_path'
                                                              ));

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
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('edit-'.$model)) {

            $this->validate($request, [
			           'tb3_Tisno' => 'required'
		        ]);

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
            $requestData = $request->all();
         
            $inform_calibrate = inform_calibrate::findOrFail($id);

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
            $input = $request->all();
            $input['trader_id'] = auth()->user()->trader_id;
            
            $inform_calibrate->update($input);

            $this->SaveLicenseAndDetail($inform_calibrate, $input, $request);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_calibrate')->with('flash_message', 'แก้ไข inform_calibrate เรียบร้อยแล้ว!');
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
        $model = str_slug('inform_calibrate','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_calibrate;
            inform_calibrate::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_calibrate::destroy($id);
          }

          return redirect('esurv/inform_calibrate')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_calibrate','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_calibrate;
          inform_calibrate::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_calibrate')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save License And Detail
    */
    private function SaveLicenseAndDetail($inform_calibrate, $requestData, $request){

        InformCalibrateLicense::where('inform_calibrate_id', $inform_calibrate->id)->delete();

        /* บันทึกข้อมูลใบอนุญาต */
        foreach ((array)@$requestData['tbl_licenseNo'] as $tbl_licenseNo) {
          $input_license = [];
          $input_license['tbl_licenseNo'] = $tbl_licenseNo;
          $input_license['inform_calibrate_id'] = $inform_calibrate->id;
          InformCalibrateLicense::create($input_license);
        }

        $inform_details = InformCalibrateDetail::where('inform_calibrate_id', $inform_calibrate->id)->get();
        InformCalibrateDetail::where('inform_calibrate_id', $inform_calibrate->id)->delete();//ลบข้อมูลเดิม

        $old_files = [];
        foreach ($inform_details as $inform_detail) {//รวมข้อมูลไฟล์ไว้ในตัวแปรเดียว
          foreach(json_decode($inform_detail->attach_result) as $file_detail){
            $old_files[$file_detail->file_name] = $file_detail;
          }
        }

        /* บันทึกข้อมูลรายละเอียดการวัด */
        foreach ((array)@$requestData['tool'] as $key=>$tool) {

          $input_detail = [];
          $input_detail['tool'] = $tool;
          $input_detail['exam_date'] = !is_null($requestData['exam_date'][$key])?HP::convertDate($requestData['exam_date'][$key]):null;
          $input_detail['detail'] = json_encode($requestData['detail'][$key]);
          $input_detail['inform_calibrate_id'] = $inform_calibrate->id;

          //ไฟล์แนบ
          $attachs = [];
          if ($files = $request->file('attach_result')) {

            if(array_key_exists($key, $files)){

              foreach ($files[$key] as $file) {

                //Upload File
                $storagePath = Storage::put($this->attach_path, $file);
                $newFile = basename($storagePath); // Extract the filename

                $attachs[] = ['file_name'=>$newFile,
                              'file_client_name'=>$file->getClientOriginalName()
                             ];
              }

            }

          }

          //ไฟล์เดิมที่เซิร์ฟเวอร์ที่ไม่ได้ถูกกดลบ
          foreach((array)@$requestData['attach_file'][$key] as $file_name){
            if(isset($old_files[$file_name])){
              $attachs[] = $old_files[$file_name];
              unset($old_files[$file_name]);
            }
          }

          $input_detail['attach_result'] = json_encode($attachs);

          InformCalibrateDetail::create($input_detail);
        }

        //ลบไฟล์แนบที่ถูกกดลบ
        foreach($old_files as $file){
          Storage::delete($this->attach_path.$file->file_name);
        }

    }

}
