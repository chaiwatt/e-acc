<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\informCalibration as inform_calibration;
use App\Models\Esurv\InformCalibrationLicense;
use Illuminate\Http\Request;

use File;
use HP;

class InformCalibrationController extends Controller
{
    private $attach_path; //ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = public_path().'/esurv_attach/inform_calibration/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('view-'.$model)) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_calibration = inform_calibration::where('tb3_Tisno', 'LIKE', "%$keyword%")
                ->orWhere('calibration_date', 'LIKE', "%$keyword%")
                ->orWhere('detail', 'LIKE', "%$keyword%")
                ->orWhere('attach', 'LIKE', "%$keyword%")
                ->orWhere('applicant_name', 'LIKE', "%$keyword%")
                ->orWhere('tel', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $inform_calibration = inform_calibration::sortable()->with('user_created')
                                                         ->with('user_updated')
                                                         ->paginate($perPage);
            }

            return view('esurv.inform_calibration.index', compact('inform_calibration'));
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
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('add-'.$model)) {

            $user = auth()->user();

            $applicant = (object)[];
            $applicant->applicant_name = $user->trader_operater_name;
            $applicant->tel = $user->trader_mobile;
            $applicant->email = $user->agent_email;

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];

            $own_licenses = [];

            return view('esurv.inform_calibration.create', compact('attachs', 'applicant', 'own_licenses'));

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
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'calibration_date' => 'required'
        		]);

            $request->request->add(['created_by' => auth()->user()->getKey()]); //user create
            $requestData = $request->all();

            //ไฟล์แนบ
            $attachs = [];
            if ($files = $request->file('attachs')) {

              $dir = $this->attach_path;
              foreach ($files as $key => $file) {
                $newFile = str_random(10).'.'.$file->getClientOriginalExtension();
                $file->move($dir, $newFile);

                $attachs[] = ['file_name'=>$newFile,
                              'file_client_name'=>$file->getClientOriginalName(),
                              'file_note'=>$requestData['attach_notes'][$key]
                             ];
              }

            }

            $requestData['attach'] = json_encode($attachs);
            $requestData['calibration_date'] = HP::convertDate($requestData['calibration_date']);

            $inform_calibration = inform_calibration::create($requestData);

            $this->SaveLicenseAndDetail($inform_calibration, $requestData);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_calibration')->with('flash_message', 'เพิ่ม inform_calibration เรียบร้อยแล้ว');
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
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('view-'.$model)) {
            $inform_calibration = inform_calibration::findOrFail($id);
            return view('esurv.inform_calibration.show', compact('inform_calibration'));
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
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_calibration = inform_calibration::findOrFail($id);
            $inform_calibration->calibration_date = HP::revertDate($inform_calibration->calibration_date);

            //ผู้ยื่น
            $applicant = (object)[];
            $applicant->applicant_name = $inform_calibration->applicant_name;
            $applicant->tel = $inform_calibration->tel;
            $applicant->email = $inform_calibration->email;

            //ไฟล์แนบ
            $attachs = json_decode($inform_calibration['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];

            //เลขที่ใบอนุญาต
            $inform_change_licenses = informCalibrationLicense::where("inform_calibration_id", $inform_calibration->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_calibration->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            return view('esurv.inform_calibration.edit', compact('inform_calibration',
                                                                 'attachs',
                                                                 'applicant',
                                                                 'own_licenses',
                                                                 'inform_change_licenses'
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
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
			            'tb3_Tisno' => 'required',
			            'calibration_date' => 'required'
		        ]);

            $inform_calibration = inform_calibration::findOrFail($id);

            if (empty($inform_calibration)) {
                Flash::error('ไม่พบข้อมูลแจ้งผลการสอบเทียบเครื่องมือวัด');

                return redirect(route('esurv/inform_calibration'));
            }

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
            $input = $request->all();

            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($inform_calibration->attach));

            //ไฟล์แนบ ที่ถูกกดลบ
            foreach ($attachs as $key => $attach) {

              if(in_array($attach->file_name, $input['attach_filenames'])===false){//ถ้าไม่มีไฟล์เดิมกลับมา
                unset($attachs[$key]);
                File::delete($this->attach_path.$attach->file_name);
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
                $newFile = str_random(10).'.'.$file->getClientOriginalExtension();
                $file->move($dir, $newFile);

                if($input['attach_filenames'][$key]!=''){//ถ้าเป็นแถวเดิมที่มีในฐานข้อมูลอยู่แล้ว

                  //วนลูปค้นหาไฟล์เดิม
                  foreach ($attachs as $key2 => $attach) {

                    if($attach->file_name == $input['attach_filenames'][$key]){//ถ้าเจอแถวที่ตรงกันแล้ว

                      File::delete($this->attach_path.$attach->file_name);//ลบไฟล์เก่า

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
            $input['calibration_date'] = HP::convertDate($input['calibration_date']);

            $inform_calibration->update($input);

            $this->SaveLicenseAndDetail($inform_calibration, $input);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_calibration')->with('flash_message', 'แก้ไข inform_calibration เรียบร้อยแล้ว!');
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
        $model = str_slug('inform_calibration','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_calibration;
            inform_calibration::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_calibration::destroy($id);
          }

          return redirect('esurv/inform_calibration')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_calibration','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_calibration;
          inform_calibration::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_calibration')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save License And Detail
    */
    private function SaveLicenseAndDetail($inform_calibration, $requestData){

        informCalibrationLicense::where('inform_calibration_id', $inform_calibration->id)->delete();

        /* บันทึกข้อมูลใบอนุญาต */
        foreach ((array)@$requestData['tbl_licenseNo'] as $tbl_licenseNo) {
          $input_license = [];
          $input_license['tbl_licenseNo'] = $tbl_licenseNo;
          $input_license['inform_calibration_id'] = $inform_calibration->id;
          informCalibrationLicense::create($input_license);
        }

    }

}
