<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\Volume21Own;
use App\Models\Esurv\Volume21OwnProductDetail;
use App\Models\Esurv\Applicant21Own;
use App\Models\Esurv\Applicant21OwnProductDetail;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Storage;
use HP;

class Volume21OwnController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/volume_21own/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('view-'.$model)) {
            $keyword = $request->get('search');
            $perPage = 25;

            			$created_by = auth()->user()->getKey();

            if (!empty($keyword)) {
                $volume_21own = Volume21Own::where("trader_id",   auth()->user()->trader_id)
                ->where('applicant_21own_id', 'LIKE', "%$keyword%")
                ->orWhere('start_date', 'LIKE', "%$keyword%")
                ->orWhere('end_date', 'LIKE', "%$keyword%")
                ->orWhere('attach', 'LIKE', "%$keyword%")
                ->orWhere('inform_close', 'LIKE', "%$keyword%")
                ->orWhere('because_close', 'LIKE', "%$keyword%")
                ->orWhere('applicant_name', 'LIKE', "%$keyword%")
                ->orWhere('tel', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('created_by', 'LIKE', "%$keyword%")
                ->orWhere('updated_by', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $volume_21own = Volume21Own::where("trader_id",   auth()->user()->trader_id)->sortable()->with('user_created')
                                                         ->with('user_updated')
                                                         ->paginate($perPage);
            }


            return view('esurv.volume_21own.index', compact('volume_21own'));
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
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('add-'.$model)) {

            $applicant_21owns = $this->Applicant21Owns();
            $applicant_21own_details = [];//ทั้งหมดที่มี ตามเลขอ้างอิง ว่างไว้

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            return view('esurv.volume_21own.create', compact('applicant_21owns',
                                                             'applicant_21own_details',
                                                             'attachs',
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
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
        			'applicant_21own_id' => 'required',
        			'inform_close' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $requestData = $request->all();
            $requestData['created_by'] = auth()->user()->getKey();//user create
            $requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
			      $requestData['state'] = 1; //state
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

            $volume_21own = Volume21Own::create($requestData);

            $this->SaveDetail($volume_21own, $requestData);//บันทึกปริมาณ

            return redirect('esurv/volume_21own')->with('flash_message', 'เพิ่ม volume_21bi เรียบร้อยแล้ว');
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
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('view-'.$model)) {
            $volume_21bi = Volume21Own::findOrFail($id);
            return view('esurv.volume_21own.show', compact('volume_21bi'));
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
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('edit-'.$model)) {

            $volume_21bi = Volume21Own::findOrFail($id);

            $volume_21bi['start_date'] = $volume_21bi['start_date']?Carbon::createFromFormat("Y-m-d",$volume_21bi['start_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
            $volume_21bi['end_date'] = $volume_21bi['end_date']?Carbon::createFromFormat("Y-m-d",$volume_21bi['end_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;

            //list เลขคำขอทำ
            $applicant_21owns = $this->Applicant21Owns();

            //ไฟล์แนบ
            $attachs = json_decode($volume_21bi['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //รายละเอียดผลิตภัณฑ์อุตสาหกรรม
            $volume_21own_details = Volume21OwnProductDetail::where("volume_21own_id", $volume_21bi->id)->pluck('quantity', 'detail_id')->toArray();//ที่ถูกเลือก
            $applicant_21own_details = Applicant21OwnProductDetail::where("applicant_21own_id", $volume_21bi->applicant_21own_id)
                                                                  ->with('data_unit')
                                                                  ->with('informed')
                                                                  ->get();//ทั้งหมดที่มี ตามเลขอ้างอิง

            return view('esurv.volume_21own.edit', compact('volume_21bi',
                                                           'attachs',
                                                           'attach_path',
                                                           'applicant_21owns',
                                                           'volume_21own_details',
                                                           'applicant_21own_details'
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
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
        			'applicant_21own_id' => 'required',
        			'inform_close' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $volume_21own = Volume21Own::findOrFail($id);

            $requestData = $request->all();
            $requestData['updated_by'] = auth()->user()->getKey();//user update
            $requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_date']   = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['trader_id'] = auth()->user()->trader_id;

            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($volume_21own->attach));

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

              $dir = $this->attach_path;
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

            $requestData['attach'] = json_encode($attachs);//ข้อมูลไฟล์แนบ

            $volume_21own->update($requestData);

            $this->SaveDetail($volume_21own, $requestData);//บันทึกปริมาณ

            return redirect('esurv/volume_21own')->with('flash_message', 'แก้ไข volume_21bi เรียบร้อยแล้ว!');
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
        $model = str_slug('volume_21own','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new Volume21Own;
            Volume21Own::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            Volume21Own::destroy($id);
          }

          return redirect('esurv/volume_21own')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('volume_21own','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new Volume21Own;
          Volume21Own::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/volume_21own')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save Detail
    */
    private function SaveDetail($volume_21own, $requestData){

        Volume21OwnProductDetail::where('volume_21own_id', $volume_21own->id)->delete();

        /* บันทึกข้อมูลปริมาณตามรายละเอียดผลิตภัณฑ์ */
        foreach ((array)@$requestData['volume21_id'] as $key=>$tbl_licenseNo) {
          $input = [];
          $input['volume_21own_id'] = $volume_21own->id;
          $input['detail_id'] = $key;
          $input['quantity'] = $requestData['quantity'][$key]??0;
          Volume21OwnProductDetail::create($input);
        }

    }

    private function Applicant21Owns() {
      return Applicant21Own::select('id', 'ref_no', 'title', 'start_date', 'end_date')->where('created_by', auth()->user()->getKey())->where('state',4)->where('state_check',1)->get();
    }

}
