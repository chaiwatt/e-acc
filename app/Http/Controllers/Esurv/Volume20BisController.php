<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\Volume20Bis;
use App\Models\Esurv\Volume20BisProductDetail;
use App\Models\Esurv\Applicant20Bis;
use App\Models\Esurv\Applicant20BisProductDetail;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Storage;
use HP;

class Volume20BisController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/volume_20bis/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('view-'.$model)) {
            $keyword = $request->get('search');
            $perPage = 25;

            			$created_by = auth()->user()->getKey();

            if (!empty($keyword)) {
                $volume_20bis = Volume20Bis::where("trader_id",   auth()->user()->trader_id)
                ->where('applicant_20bis_id', 'LIKE', "%$keyword%")
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
                $volume_20bis = Volume20Bis::where("trader_id", auth()->user()->trader_id)->sortable()->with('user_created')
                                                         ->with('user_updated')
                                                         ->paginate($perPage);
            }


            return view('esurv.volume_20bis.index', compact('volume_20bis'));
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
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('add-'.$model)) {

            $applicant_20biss = $this->Applicant20Biss();
            $applicant_20bis_details = [];//ทั้งหมดที่มี ตามเลขอ้างอิง ว่างไว้

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            return view('esurv.volume_20bis.create', compact('applicant_20biss',
                                                             'applicant_20bis_details',
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
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
        			'applicant_20bis_id' => 'required',
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

            $volume_20bis = Volume20Bis::create($requestData);

            $this->SaveDetail($volume_20bis, $requestData);//บันทึกปริมาณ

            return redirect('esurv/volume_20bis')->with('flash_message', 'เพิ่ม volume_20bi เรียบร้อยแล้ว');
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
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('view-'.$model)) {
            $volume_20bi = Volume20Bis::findOrFail($id);
            return view('esurv.volume_20bis.show', compact('volume_20bi'));
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
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('edit-'.$model)) {

            $volume_20bi = Volume20Bis::findOrFail($id);

            $volume_20bi['start_date'] = $volume_20bi['start_date']?Carbon::createFromFormat("Y-m-d",$volume_20bi['start_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
            $volume_20bi['end_date'] = $volume_20bi['end_date']?Carbon::createFromFormat("Y-m-d",$volume_20bi['end_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;

            //list เลขคำขอทำ
            $applicant_20biss = $this->Applicant20Biss();

            //ไฟล์แนบ
            $attachs = json_decode($volume_20bi['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //รายละเอียดผลิตภัณฑ์อุตสาหกรรม
            $volume_20bis_details = Volume20BisProductDetail::where("volume_20bis_id", $volume_20bi->id)->pluck('quantity', 'detail_id')->toArray();//ที่ถูกเลือก
            $applicant_20bis_details = Applicant20BisProductDetail::where("applicant_20bis_id", $volume_20bi->applicant_20bis_id)
                                                                  ->with('data_unit')
                                                                  ->with('informed')
                                                                  ->get();//ทั้งหมดที่มี ตามเลขอ้างอิง

            return view('esurv.volume_20bis.edit', compact('volume_20bi',
                                                           'attachs',
                                                           'attach_path',
                                                           'applicant_20biss',
                                                           'volume_20bis_details',
                                                           'applicant_20bis_details'
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
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
        			'applicant_20bis_id' => 'required',
        			'inform_close' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $volume_20bis = Volume20Bis::findOrFail($id);

            $requestData = $request->all();
            $requestData['updated_by'] = auth()->user()->getKey();//user update
            $requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['trader_id'] = auth()->user()->trader_id;
            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($volume_20bis->attach));

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

            $volume_20bis->update($requestData);

            $this->SaveDetail($volume_20bis, $requestData);//บันทึกปริมาณ

            return redirect('esurv/volume_20bis')->with('flash_message', 'แก้ไข volume_20bi เรียบร้อยแล้ว!');
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
        $model = str_slug('volume_20bis','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new Volume20Bis;
            Volume20Bis::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            Volume20Bis::destroy($id);
          }

          return redirect('esurv/volume_20bis')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('volume_20bis','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new Volume20Bis;
          Volume20Bis::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/volume_20bis')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save Detail
    */
    private function SaveDetail($volume_20bis, $requestData){

        Volume20BisProductDetail::where('volume_20bis_id', $volume_20bis->id)->delete();

        /* บันทึกข้อมูลปริมาณตามรายละเอียดผลิตภัณฑ์ */
        foreach ((array)@$requestData['volume20_id'] as $key=>$tbl_licenseNo) {
          $input = [];
          $input['volume_20bis_id'] = $volume_20bis->id;
          $input['detail_id'] = $key;
          $input['quantity'] = $requestData['quantity'][$key]??0;
          Volume20BisProductDetail::create($input);
        }

    }

    private function Applicant20Biss() {
      return Applicant20Bis::select('id', 'ref_no', 'title', 'start_date', 'end_date')->where('created_by', auth()->user()->getKey())->where('state',4)->where('state_check',1)->get();
    }

}
