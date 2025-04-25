<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\LicenseNotification;
use Illuminate\Http\Request;
use Storage;
class TisiLicenseNotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->attach_path = 'esurv_attach/notification/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {

        $model = str_slug('tisi-license-notification','-');
        if(auth()->user()->can('view-'.$model)) {

            $user_id = auth()->user()->getKey();

            $filter['filter_Tisno'] = $request->get('filter_Tisno','');
            $filter['filter_state'] = $request->get('filter_state','');
            $filter['perPage'] = $request->get('perPage', 10);
            $query = new LicenseNotification;

            if (!empty($filter['filter_Tisno'])) {
              $query = $query->where('tb3_Tisno', $filter['filter_Tisno']);
            }
            if (!empty($filter['filter_state'])) {
              $query = $query->where('state', $filter['filter_state']);
            }
            $inform_volume = $query->where("trader_id",   auth()->user()->trader_id)
                                   ->sortable()
                                   ->orderby('id','desc')
                                   ->paginate($filter['perPage']);

            return view('esurv.tisi-license-notification.index', compact('inform_volume','filter'));
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
        $model = str_slug('tisi-license-notification','-');
        if(auth()->user()->can('add-'.$model)) {

            //มาตรฐาน
           //ไฟล์แนบ
           $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
           $attach_path = $this->attach_path;
            return view('esurv.tisi-license-notification.create', compact('attachs', 'attach_path'));
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
        $model = str_slug('tisi-license-notification','-');
        if(auth()->user()->can('view-'.$model)) {

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
            LicenseNotification::create($requestData);
            return redirect('esurv/tisi_license_notification')->with('flash_message', 'เพิ่ม TisiLicenseNotification เรียบร้อยแล้ว');
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
        $model = str_slug('tisi-license-notification','-');
        if(auth()->user()->can('view-'.$model)) {
            $license = LicenseNotification::findOrFail($id);
            //ไฟล์แนบ
            $attachs = json_decode($license['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;
            return view('esurv.tisi-license-notification.show', compact('license','attachs','attach_path'));
        }
        abort(403);
    }

    public function edit($id)
    {
        $model = str_slug('tisi-license-notification','-');
        if(auth()->user()->can('edit-'.$model)) {

            $license = LicenseNotification::findOrFail($id);
             //ไฟล์แนบ
             $attachs = json_decode($license['attach']);
             $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];

            $attach_path = $this->attach_path;
            // return $license;
            return view('esurv.tisi-license-notification.edit',  compact('license','attachs','attach_path'));

        }
        abort(403);
     }
        public function update(Request $request, $id)
        {
            $model = str_slug('tisi-license-notification','-');
            if(auth()->user()->can('edit-'.$model)) {
                $request->request->add(['updated_by' => auth()->user()->getKey()]); //user create
                $receive_volume = LicenseNotification::findOrFail($id);
                $requestData = $request->all();
                $requestData['trader_id'] = auth()->user()->trader_id;
	        //ข้อมูลไฟล์แนบเดิม

            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($receive_volume->attach));

            //ไฟล์แนบ ที่ถูกกดลบ
            foreach ($attachs as $key => $attach) {

              if(in_array($attach->file_name, $requestData['attach_filenames'])===false){//ถ้าไม่มีไฟล์เดิมกลับมา
                unset($attachs[$key]);
                Storage::delete($this->attach_path.$attach->file_name);
              }
            }

            //ไฟล์แนบ ข้อความที่แก้ไข
            foreach ($attachs as $key => $attach) {
              $search_key = array_search($attach->file_name, $requestData['attach_filenames']);
              if($search_key!==false){
                $attach->file_note = $requestData['attach_notes'][$search_key];
              }
            }

            //ไฟล์แนบ เพิ่มเติม
            if ($files = $request->file('attachs')) {

              foreach ($files as $key => $file) {

                //Upload File
                $storagePath = Storage::put($this->attach_path, $file);
                $newFile = basename($storagePath); // Extract the filename

                if($requestData['attach_filenames'][$key]!=''){//ถ้าเป็นแถวเดิมที่มีในฐานข้อมูลอยู่แล้ว

                  //วนลูปค้นหาไฟล์เดิม
                  foreach ($attachs as $key2 => $attach) {

                    if($attach->file_name == $requestData['attach_filenames'][$key]){//ถ้าเจอแถวที่ตรงกันแล้ว

                      Storage::delete($this->attach_path.$attach->file_name);//ลบไฟล์เก่า

                      $attach->file_name = $newFile;//แก้ไขชื่อไฟล์ใน object
                      $attach->file_client_name = $file->getClientOriginalName();//แก้ไขชื่อไฟล์ของผู้ใช้ใน object

                      break;
                    }
                  }

                }else{//แถวที่เพิ่มมาใหม่

                  $attachs[] = ['file_name'=>$newFile,
                                'file_client_name'=>$file->getClientOriginalName(),
                                'file_note'=>$requestData['attach_notes'][$key]
                               ];
                }

              }

            }

            $requestData['attach'] = json_encode($attachs);
            $receive_volume->update($requestData);
                return redirect('esurv/tisi_license_notification')->with('flash_message', 'บันทึกรับแจ้งปริมาณเรียบร้อยแล้ว!');
            }
            abort(403);

        }

        public function destroy($id, Request $request)
        {
            $model = str_slug('tisi-license-notification','-');
            if(auth()->user()->can('delete-'.$model)) {
                LicenseNotification::destroy($id);
              return redirect('esurv/tisi_license_notification')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
            }
            abort(403);

        }


}
