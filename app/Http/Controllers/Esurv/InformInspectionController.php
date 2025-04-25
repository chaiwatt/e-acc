<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\informInspection as inform_inspection;
use Illuminate\Http\Request;

use Storage;
use HP;

class InformInspectionController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/inform_inspection/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('view-'.$model)) {

            $user_id = auth()->user()->getKey();

            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $inform_inspection = inform_inspection::where('tb3_Tisno', 'LIKE', "%$keyword%")
                ->orWhere('tbl_licenseNo', 'LIKE', "%$keyword%")
                ->orWhere('check_date', 'LIKE', "%$keyword%")
                ->orWhere('inspector', 'LIKE', "%$keyword%")
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
                $inform_inspection = inform_inspection::where("trader_id", auth()->user()->trader_id)
                                                      ->sortable(['id' => 'desc'])
                                                      ->with('user_created')
                                                      ->with('user_updated')
                                                      ->paginate($perPage);
            }

            return view('esurv.inform_inspection.index', compact('inform_inspection'));
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
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('add-'.$model)) {

            $user = auth()->user();

            //ใบอนุญาต
            $licenses = [];

            $inspector = '';

            //ข้อมูลผุ้บันทึก
            $applicant = (object)[];
            $applicant->applicant_name = $user->trader_operater_name;
            $applicant->tel = $user->trader_mobile;
            $applicant->email = $user->agent_email;

            //ไฟล์แนบ
            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            return view('esurv.inform_inspection.create', compact('attachs', 'attach_path', 'applicant', 'licenses', 'inspector'));

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
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('add-'.$model)) {

            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'tbl_licenseNo' => 'required',
        			'check_date' => 'required',
        			'inspector' => 'required',
        			'product_detail' => 'required'
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
            $requestData['check_date'] = HP::convertDate($requestData['check_date']);
            $requestData['inspector'] = $requestData['inspector']=='NULL'?null:$requestData['inspector'];

            inform_inspection::create($requestData);

            return redirect('esurv/inform_inspection')->with('flash_message', 'เพิ่ม inform_inspection เรียบร้อยแล้ว');
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
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('view-'.$model)) {

            $inform_inspection = inform_inspection::findOrFail($id);

            //ไฟล์แนบ
            $attachs = json_decode($inform_inspection['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            return view('esurv.inform_inspection.show', compact('inform_inspection',
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
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('edit-'.$model)) {

            $inform_inspection = inform_inspection::findOrFail($id);
            $inform_inspection->check_date = HP::revertDate($inform_inspection->check_date);

            //ใบอนุญาต
            $licenses = HP::OwnLicenseByTis($inform_inspection->tb3_Tisno)->pluck('tbl_licenseNo', 'tbl_licenseNo');

            $inspector = is_null($inform_inspection->inspector)?'NULL':$inform_inspection->inspector;

            //ผู้ยื่น
            $applicant = (object)[];
            $applicant->applicant_name = $inform_inspection->applicant_name;
            $applicant->tel = $inform_inspection->tel;
            $applicant->email = $inform_inspection->email;

            //ไฟล์แนบ
            $attachs = json_decode($inform_inspection['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            return view('esurv.inform_inspection.edit', compact('inform_inspection', 'attachs', 'attach_path', 'applicant', 'licenses', 'inspector'));

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
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
        			'tb3_Tisno' => 'required',
        			'tbl_licenseNo' => 'required',
        			'check_date' => 'required',
        			'inspector' => 'required',
              'product_detail' => 'required'
        		]);

            $inform_inspection = inform_inspection::findOrFail($id);

            if (empty($inform_inspection)) {
                Flash::error('ไม่พบข้อมูลแจ้งการตรวจสอบผลิตภัณฑ์');

                return redirect(route('esurv/inform_inspection'));
            }


            $input = $request->all();
            $input['inspector'] = (!empty($input['inspector']) && $input['inspector']!="NULL")?$input['inspector']:null;
            $input['check_date'] = HP::convertDate($input['check_date']);
            $input['updated_by'] = auth()->user()->getKey();//user update
            $input['trader_id'] = auth()->user()->trader_id;
            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($inform_inspection->attach));

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

            $inform_inspection->update($input);

            return redirect('esurv/inform_inspection')->with('flash_message', 'แก้ไข inform_inspection เรียบร้อยแล้ว!');
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
        $model = str_slug('inform_inspection','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new inform_inspection;
            inform_inspection::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            inform_inspection::destroy($id);
          }

          return redirect('esurv/inform_inspection')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('inform_inspection','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new inform_inspection;
          inform_inspection::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/inform_inspection')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

}
