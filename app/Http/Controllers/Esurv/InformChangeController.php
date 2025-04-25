<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\InformChange as inform_change;
use App\Models\Esurv\InformChangeLicense;
use Illuminate\Http\Request;

use Storage;
use HP;

class InformChangeController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/inform_change/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('view-'.$model)) {
            $user_id = auth()->user()->getKey();

            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_change = inform_change::where('tb3_Tisno', 'LIKE', "%$keyword%")
                ->orWhere('detail', 'LIKE', "%$keyword%")
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
                $inform_change = inform_change::where("trader_id",   auth()->user()->trader_id)
                                                                             ->sortable(['id' => 'desc'])
                                                                             ->with('user_created')
                                                                             ->with('user_updated')
                                                                             ->paginate($perPage);
            }

            return view('esurv.inform_change.index', compact('inform_change'));
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
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('add-'.$model)) {

            $user = auth()->user();

            $applicant = (object)[];
            $applicant->applicant_name = $user->trader_operater_name;
            $applicant->tel = $user->trader_mobile;
            $applicant->email = $user->agent_email;

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            $own_licenses = [];

            return view('esurv.inform_change.create', compact('attachs', 'attach_path', 'applicant', 'own_licenses'));

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
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'detail' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
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

            $inform_change = inform_change::create($requestData);//บันทึกตารางหลัก

            $this->SaveLicenseAndDetail($inform_change, $requestData);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_change')->with('flash_message', 'เพิ่ม inform_change เรียบร้อยแล้ว');
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
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('view-'.$model)) {

            $inform_change = inform_change::findOrFail($id);

            //ไฟล์แนบ
            $attachs = json_decode($inform_change['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //เลขที่ใบอนุญาต
            $inform_change_licenses = InformChangeLicense::where("inform_change_id", $inform_change->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_change->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            return view('esurv.inform_change.show', compact('inform_change',
                                                            'attachs',
                                                            'attach_path',
                                                            'inform_change_licenses',
                                                            'own_licenses'
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
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_change = inform_change::findOrFail($id);

            //ผู้ยื่น
            $applicant = (object)[];
            $applicant->applicant_name = $inform_change->applicant_name;
            $applicant->tel = $inform_change->tel;
            $applicant->email = $inform_change->email;

            //ไฟล์แนบ
            $attachs = json_decode($inform_change['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //เลขที่ใบอนุญาต
            $inform_change_licenses = InformChangeLicense::where("inform_change_id", $inform_change->id)->pluck('tbl_licenseNo', 'id')->toArray();//ที่ถูกเลือก
            $own_licenses = HP::OwnLicenseByTis($inform_change->tb3_Tisno);//ทั้งหมดที่มี ตามมาตรฐาน

            return view('esurv.inform_change.edit', compact('inform_change',
                                                            'applicant',
                                                            'attachs',
                                                            'attach_path',
                                                            'own_licenses',
                                                            'inform_change_licenses'
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
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'detail' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $inform_change = inform_change::findOrFail($id);

            if (empty($inform_change)) {
                Flash::error('ไม่พบข้อมูลแจ้งการเปลี่ยนแปลงที่มีผลกระทบต่อคุณภาพ');

                return redirect(route('esurv/inform_change'));
            }

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
            $input = $request->all();
            $input['trader_id'] = auth()->user()->trader_id;
            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($inform_change->attach));

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

            $inform_change->update($input);

            $this->SaveLicenseAndDetail($inform_change, $input);//บันทึกข้อมูลใบอนุญาตและรายละเอียด

            return redirect('esurv/inform_change')->with('flash_message', 'แก้ไข inform_change เรียบร้อยแล้ว!');
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
        $model = str_slug('inform_change','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_change;
            inform_change::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_change::destroy($id);
          }

          return redirect('esurv/inform_change')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_change','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_change;
          inform_change::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_change')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save License And Detail
    */
    private function SaveLicenseAndDetail($inform_change, $requestData){

        InformChangeLicense::where('inform_change_id', $inform_change->id)->delete();

        /* บันทึกข้อมูลใบอนุญาต */
        foreach ((array)@$requestData['tbl_licenseNo'] as $tbl_licenseNo) {
          $input_license = [];
          $input_license['tbl_licenseNo'] = $tbl_licenseNo;
          $input_license['inform_change_id'] = $inform_change->id;
          InformChangeLicense::create($input_license);
        }

    }

}
