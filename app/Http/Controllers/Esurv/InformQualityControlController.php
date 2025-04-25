<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\InformQualityControl as inform_quality_control;
use App\Models\Esurv\InformQualityControlLicense as InformQcLicense;
use Illuminate\Http\Request;

use Storage;
use HP;

class InformQualityControlController extends Controller
{
    private $attach_path; //ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->attach_path = 'esurv_attach/inform_quality_control/';
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('view-'.$model)) {
            $user_id = auth()->user()->getKey();

            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_quality_control = inform_quality_control::where('tb3_Tisno', 'LIKE', "%$keyword%")
                ->orWhere('factory_name', 'LIKE', "%$keyword%")
                ->orWhere('factory_address', 'LIKE', "%$keyword%")
                ->orWhere('check_date', 'LIKE', "%$keyword%")
                ->orWhere('inspector', 'LIKE', "%$keyword%")
                ->orWhere('attach', 'LIKE', "%$keyword%")
                ->orWhere('detail', 'LIKE', "%$keyword%")
                ->orWhere('applicant_name', 'LIKE', "%$keyword%")
                ->orWhere('tel', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $inform_quality_control = inform_quality_control::where("trader_id", auth()->user()->trader_id)
                                                                ->sortable(['id' => 'desc'])
                                                                ->with('user_created')
                                                                ->with('user_updated')
                                                                ->paginate($perPage);
            }

            return view('esurv.inform_quality_control.index', compact('inform_quality_control'));
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
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('add-'.$model)) {

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            $own_licenses = [];

            return view('esurv.inform_quality_control.create', compact('attachs', 'attach_path', 'own_licenses'));

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
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'check_date' => 'required',
        			'inspector' => 'required',
        			'detail' => 'required'
        		]);
            $request->request->add(['created_by' => auth()->user()->getKey()]); //user create
            $requestData = $request->all();
            $requestData['trader_id'] = auth()->user()->trader_id;
            //ไฟล์แนบ
            $attachs = [];
            if ($files = $request->file('attachs')) {

              $dir = $this->attach_path;
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

            $requestData['inspector'] = $requestData['inspector']==='NULL'?null:$requestData['inspector'];
            $requestData['inspector_other'] = is_null($requestData['inspector'])?$requestData['inspector_other']:null;
            $requestData['check_date'] = !is_null($requestData['check_date'])?HP::convertDate($requestData['check_date']):null;

            $inform_qc = inform_quality_control::create($requestData);

            $this->SaveLicenseAndDetail($inform_qc, $requestData, $request);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_quality_control')->with('flash_message', 'เพิ่ม inform_quality_control เรียบร้อยแล้ว');
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
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('view-'.$model)) {

            $inform_quality_control = inform_quality_control::findOrFail($id);

            //ไฟล์แนบ
            $attachs = json_decode($inform_quality_control['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //เลขที่ใบอนุญาต
            $inform_qc_licenses = InformQcLicense::where("inform_quality_control_id", $inform_quality_control->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_quality_control->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            return view('esurv.inform_quality_control.show', compact('inform_quality_control',
                                                                    'inform_qc_licenses',
                                                                    'own_licenses',
                                                                    'attachs',
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
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_quality_control = inform_quality_control::findOrFail($id);
            $inform_quality_control['inspector'] = is_null($inform_quality_control['inspector'])?'NULL':$inform_quality_control['inspector'];
            $inform_quality_control['check_date'] = HP::revertDate($inform_quality_control['check_date']);

            //ไฟล์แนบ
            $attachs = json_decode($inform_quality_control['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //เลขที่ใบอนุญาต
            $inform_qc_licenses = InformQcLicense::where("inform_quality_control_id", $inform_quality_control->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_quality_control->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            return view('esurv.inform_quality_control.edit', compact('inform_quality_control', 'own_licenses', 'inform_qc_licenses', 'attachs', 'attach_path'));

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
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'check_date' => 'required',
        			'inspector' => 'required',
        			'detail' => 'required'
        		]);

            $inform_quality_control = inform_quality_control::findOrFail($id);

            $input = $request->all();
            $input['trader_id'] = auth()->user()->trader_id;
            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($inform_quality_control->attach));

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

            $input['inspector'] = $input['inspector']==='NULL'?null:$input['inspector'];
            $input['inspector_other'] = is_null($input['inspector'])?$input['inspector_other']:null;
            $input['check_date'] = !is_null($input['check_date'])?HP::convertDate($input['check_date']):null;
            $input['attach'] = json_encode($attachs);
            $input['updated_by'] = auth()->user()->getKey();//user update

            $inform_quality_control->update($input);

            $this->SaveLicenseAndDetail($inform_quality_control, $input, $request);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_quality_control')->with('flash_message', 'แก้ไข inform_quality_control เรียบร้อยแล้ว!');
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
        $model = str_slug('inform_quality_control','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_quality_control;
            inform_quality_control::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_quality_control::destroy($id);
          }

          return redirect('esurv/inform_quality_control')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_quality_control','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_quality_control;
          inform_quality_control::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_quality_control')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save License And Detail
    */
    private function SaveLicenseAndDetail($inform_qc, $requestData, $request){

        $inform_licenses = InformQcLicense::where('inform_quality_control_id', $inform_qc->id)->pluck('tbl_licenseNo', 'id');//ข้อมูลใบอนุญาตที่เคยบันทึกไว้

        InformQcLicense::where('inform_quality_control_id', $inform_qc->id)->whereNotIn('tbl_licenseNo', (array)@$requestData['tbl_licenseNo'])->delete();//ลบใบอนุญาต

        /* บันทึกข้อมูลใบอนุญาต */
        foreach ((array)@$requestData['tbl_licenseNo'] as $tbl_licenseNo) {

          $inform_qc_license = InformQcLicense::where('inform_quality_control_id', $inform_qc->id)->where('tbl_licenseNo', $tbl_licenseNo)->first();

          if($inform_qc_license){
            continue;
          }

          $input_license = [];
          $input_license['tbl_licenseNo'] = $tbl_licenseNo;
          $input_license['inform_quality_control_id'] = $inform_qc->id;
          InformQcLicense::create($input_license);
        }

    }

}
