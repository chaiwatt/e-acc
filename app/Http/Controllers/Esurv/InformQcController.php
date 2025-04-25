<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\informQc as inform_qc;
use App\Models\Esurv\InformQcLicense;
use App\Models\Esurv\InformQcLicenseDetail;
use App\Models\Basic\TisiLicense;
use Illuminate\Http\Request;

use File;
use HP;

class InformQcController extends Controller
{
    private $attach_path; //ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = public_path().'/esurv_attach/inform_qc/';
        $this->attach_path_detail = public_path().'/esurv_attach/inform_qc_detail/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('view-'.$model)) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_qc = inform_qc::where('tb3_Tisno', 'LIKE', "%$keyword%")
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
                $inform_qc = inform_qc::sortable()->with('user_created')
                                                         ->with('user_updated')
                                                         ->paginate($perPage);
            }

            return view('esurv.inform_qc.index', compact('inform_qc'));
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
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('add-'.$model)) {

            $user = auth()->user();

            $applicant = (object)[];
            $applicant->applicant_name = $user->trader_operater_name;
            $applicant->tel = $user->trader_mobile;
            $applicant->email = $user->agent_email;

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];

            $own_licenses = [];

            return view('esurv.inform_qc.create', compact('attachs', 'applicant', 'own_licenses'));

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
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
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

            $inform_qc = inform_qc::create($requestData);

            $this->SaveLicenseAndDetail($inform_qc, $requestData, $request);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_qc')->with('flash_message', 'เพิ่ม inform_qc เรียบร้อยแล้ว');
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
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('view-'.$model)) {
            $inform_qc = inform_qc::findOrFail($id);
            return view('esurv.inform_qc.show', compact('inform_qc'));
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
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_qc = inform_qc::findOrFail($id);

            //ผู้ยื่น
            $applicant = (object)[];
            $applicant->applicant_name = $inform_qc->applicant_name;
            $applicant->tel = $inform_qc->tel;
            $applicant->email = $inform_qc->email;

            //ไฟล์แนบ
            $attachs = json_decode($inform_qc['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];

            //เลขที่ใบอนุญาต
            $inform_qc_licenses = InformQcLicense::where("inform_qc_id", $inform_qc->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_qc->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            //รายละเอียดการประเมิน
            $inform_qc_details = [];
            foreach ($inform_qc_licenses as $key => $inform_qc_license) {
              $inform_qc_details[$key] = InformQcLicenseDetail::where("inform_qc_license_id", $key)->get();//ผลประเมินที่บันทึกไว้
            }

            return view('esurv.inform_qc.edit', compact('inform_qc',
                                                        'attachs',
                                                        'applicant',
                                                        'inform_qc_licenses',
                                                        'own_licenses',
                                                        'inform_qc_details'
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
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('edit-'.$model)) {

            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $inform_qc = inform_qc::findOrFail($id);

            if (empty($inform_qc)) {
                Flash::error('ไม่พบข้อมูลแจ้งปริมาณการผลิตตามเงื่อนไขใบอนุญาต');

                return redirect(route('esurv/inform_volume'));
            }

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
            $input = $request->all();

            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($inform_qc->attach));

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

            $inform_qc->update($input);

            $this->SaveLicenseAndDetail($inform_qc, $input, $request);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_qc')->with('flash_message', 'แก้ไข inform_qc เรียบร้อยแล้ว!');
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
        $model = str_slug('inform_qc','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_qc;
            inform_qc::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_qc::destroy($id);
          }

          return redirect('esurv/inform_qc')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_qc','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_qc;
          inform_qc::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_qc')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save License And Detail
    */
    private function SaveLicenseAndDetail($inform_qc, $requestData, $request){

        $files = $request->file('result_attach');

        $request_detail_ids = (array)@$requestData['detail_id'];

        //รวมไอดีข้อมูลผลประเมินเดิมที่ไม่ถูกกดลบ
        $detail_ids = [];
        foreach($request_detail_ids as $tmp_detail_ids){
          $detail_ids = array_merge($detail_ids, $tmp_detail_ids);
        }

        $inform_licenses = InformQcLicense::where('inform_qc_id', $inform_qc->id)->pluck('tbl_licenseNo', 'id');//ข้อมูลใบอนุญาตที่เคยบันทึกไว้

        /* ลบข้อมูลผลการประเมิน QC */
        foreach ($inform_licenses as $inform_qc_license_id => $tbl_licenseNo) {

          $inform_details = InformQcLicenseDetail::where('inform_qc_license_id', $inform_qc_license_id)->get();
          foreach ($inform_details as $key => $inform_detail) {

            if(!in_array($inform_detail->id, $detail_ids)){
              $attach = json_decode($inform_detail->result_attach);
              File::delete($this->attach_path_detail.@$attach->file_name);//ลบไฟล์เก่า
              $inform_detail->delete();
            }

          }

        }


        InformQcLicense::where('inform_qc_id', $inform_qc->id)->whereNotIn('tbl_licenseNo', (array)@$requestData['tbl_licenseNo'])->delete();//ลบใบอนุญาต

        /* บันทึกข้อมูลใบอนุญาต */
        foreach ((array)@$requestData['tbl_licenseNo'] as $tbl_licenseNo) {

          $inform_qc_license = InformQcLicense::where('inform_qc_id', $inform_qc->id)->where('tbl_licenseNo', $tbl_licenseNo)->first();

          if($inform_qc_license){
            continue;
          }

          $input_license = [];
          $input_license['tbl_licenseNo'] = $tbl_licenseNo;
          $input_license['inform_qc_id'] = $inform_qc->id;
          InformQcLicense::create($input_license);
        }

        /* บันทึกข้อมูลผลการประเมิน QC */
        foreach ((array)@$requestData['factory_name'] as $Autono => $factory_names) {

          foreach ($factory_names as $key => $factory_name) {

            $detail_id = (int)@$requestData['detail_id'][$Autono][$key];//ไอดี

            $input_detail = [];

            $input_detail['factory_name'] = $factory_name;
            $input_detail['factory_address'] = $requestData['factory_address'][$Autono][$key];
            $input_detail['inspector'] = $requestData['inspector'][$Autono][$key]==='NULL'?null:$requestData['inspector'][$Autono][$key];
            $input_detail['inspector_other'] = $requestData['inspector_other'][$Autono][$key];
            $input_detail['check_date'] = !is_null($requestData['check_date'][$Autono][$key])?HP::convertDate($requestData['check_date'][$Autono][$key]):null;
            $input_detail['detail'] = $requestData['detail'][$Autono][$key];

            $license = TisiLicense::find($Autono);//ข้อมูลรายละเอียดผลิตภัณฑ์
            $qclicense = InformQcLicense::where('tbl_licenseNo', $license->tbl_licenseNo)->where('inform_qc_id', $inform_qc->id)->first();//ข้อมูลใบอนุญาตที่ถูกบันทึกในชุดนี้

            $input_detail['inform_qc_license_id'] = $qclicense->id;

            if($detail_id===0){//เพิ่ม

              //ไฟล์แนบ
              $file = @$files[$Autono][$key];
              if($file){
                $newFile = str_random(10).'.'.$file->getClientOriginalExtension();
                $file->move($this->attach_path_detail, $newFile);
                $input_detail['result_attach'] = ['file_name'=>$newFile,
                                                'file_client_name'=>$file->getClientOriginalName()
                                               ];
                $input_detail['result_attach'] = json_encode($input_detail['result_attach']);
              }else{
                $input_detail['result_attach'] = null;
              }

              InformQcLicenseDetail::create($input_detail);

            }else{//แก้ไข

              $inform_qc_license_detail = InformQcLicenseDetail::findOrFail($detail_id);

              //ไฟล์แนบ
              $file = @$files[$Autono][$key];
              if($file){
                $newFile = str_random(10).'.'.$file->getClientOriginalExtension();
                $file->move($this->attach_path_detail, $newFile);
                $input_detail['result_attach'] = ['file_name'=>$newFile,
                                                'file_client_name'=>$file->getClientOriginalName()
                                               ];
                $input_detail['result_attach'] = json_encode($input_detail['result_attach']);

                $attach = json_decode($inform_qc_license_detail->result_attach);

                File::delete($this->attach_path_detail.@$attach->file_name);//ลบไฟล์เก่า

              }

              $inform_qc_license_detail->update($input_detail);

            }

          }

        }

    }

}
