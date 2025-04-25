<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\Volume20Ter;
use App\Models\Esurv\Volume20TerProductDetail;
use App\Models\Esurv\Applicant20Ter;
use App\Models\Esurv\Applicant20TerProductDetail;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Storage;
use HP;
use PDF;

class Volume20TerController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');

        $this->attach_path = 'esurv_attach/volume_20ter/';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('view-'.$model)) {
            $keyword = $request->get('search');
            $perPage = 25;

            			$created_by = auth()->user()->getKey();

            if (!empty($keyword)) {
                $volume_20ter = Volume20Ter::where("trader_id",   auth()->user()->trader_id)
                ->where('applicant_20ter_id', 'LIKE', "%$keyword%")
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
                $volume_20ter = Volume20Ter::where("trader_id",   auth()->user()->trader_id)->sortable()->with('user_created')
                                                       ->with('user_updated')
                                                       ->with('applicant')
                                                       ->paginate($perPage);
            }


            return view('esurv.volume_20ter.index', compact('volume_20ter'));
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
        $user = auth()->user();

        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('add-'.$model)) {

            $applicant_20ters = $this->Applicant20Ters();

            $applicant_20ter_details = [];//ทั้งหมดที่มี ตามเลขอ้างอิง ว่างไว้

            $attachs = [(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            return view('esurv.volume_20ter.create', compact('applicant_20ters',
                                                             'applicant_20ter_details',
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
        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('add-'.$model)) {

            $this->validate($request, [
        			'applicant_20ter_id' => 'required',
        			'inform_close' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $requestData = $request->all();

            // dd($requestData);

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
            $requestData['khrang_thi'] = $this->get_khrang_thi($requestData['applicant_20ter_id'], $requestData['created_by']);

            $volume_20ter = Volume20Ter::create($requestData);

            $this->SaveDetail($volume_20ter, $requestData);//บันทึกปริมาณ

            return redirect('esurv/volume_20ter')->with('flash_message', 'เพิ่ม volume_20ter เรียบร้อยแล้ว');

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
        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('view-'.$model)) {
            $volume_20ter = Volume20Ter::findOrFail($id);
            return view('esurv.volume_20ter.show', compact('volume_20ter'));
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
        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('edit-'.$model)) {

          // $test = $this->get_khrang_thi(1, 568);
          // dd($test);

            $volume_20ter = Volume20Ter::findOrFail($id);

            $volume_20ter['start_date'] = $volume_20ter['start_date']?Carbon::createFromFormat("Y-m-d",$volume_20ter['start_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
            $volume_20ter['end_date'] = $volume_20ter['end_date']?Carbon::createFromFormat("Y-m-d",$volume_20ter['end_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;

            //list เลขคำขอทำ
            $applicant_20ters = $this->Applicant20Ters();

            //ไฟล์แนบ
            $attachs = json_decode($volume_20ter['attach']);
            $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];
            $attach_path = $this->attach_path;

            //รายละเอียดผลิตภัณฑ์อุตสาหกรรม
            $volume_20ter_details = Volume20TerProductDetail::where("volume_20ter_id", $volume_20ter->id)->pluck('quantity', 'detail_id')->toArray();//ที่ถูกเลือก
            $applicant_20ter_details = Applicant20TerProductDetail::where("applicant_20ter_id", $volume_20ter->applicant_20ter_id)
                                                                  ->with('data_unit')
                                                                  ->with('informed')
                                                                  ->get();//ทั้งหมดที่มี ตามเลขอ้างอิง

              // foreach ($applicant_20ter_details as $key => $item) {
              //       $sum_informed = 0;
              //       foreach ($item->informed as $informed) {
              //         $applicant_20ter_details[$key]['quantity_old'] = 555;
              //       }
              // }

                // dd($applicant_20ter_details);

            return view('esurv.volume_20ter.edit', compact('volume_20ter',
                                                           'attachs',
                                                           'attach_path',
                                                           'applicant_20ters',
                                                           'volume_20ter_details',
                                                           'applicant_20ter_details'
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
        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
        			'applicant_20ter_id' => 'required',
        			'inform_close' => 'required',
        			'applicant_name' => 'required',
        			'tel' => 'required',
        			'email' => 'required'
        		]);

            $volume_20ter = Volume20Ter::findOrFail($id);

            $requestData = $request->all();
            $requestData['updated_by'] = auth()->user()->getKey();//user update
            $requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['trader_id'] = auth()->user()->trader_id;
            //ข้อมูลไฟล์แนบ
            $attachs = array_values((array)json_decode($volume_20ter->attach));

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

            $volume_20ter->update($requestData);

            $this->SaveDetail($volume_20ter, $requestData);//บันทึกปริมาณ

            return redirect('esurv/volume_20ter')->with('flash_message', 'แก้ไข volume_20ter เรียบร้อยแล้ว!');
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
        $model = str_slug('volume_20ter','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new Volume20Ter;
            Volume20Ter::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            Volume20Ter::destroy($id);
          }

          return redirect('esurv/volume_20ter')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('volume_20ter','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new Volume20Ter;
          Volume20Ter::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/volume_20ter')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    /*
      **** Save Detail
    */
    private function SaveDetail($volume_20ter, $requestData){

        Volume20TerProductDetail::where('volume_20ter_id', $volume_20ter->id)->delete();

        /* บันทึกข้อมูลปริมาณตามรายละเอียดผลิตภัณฑ์ */
        foreach ((array)@$requestData['volume20_id'] as $key=>$tbl_licenseNo) {
          $input = [];
          $input['volume_20ter_id'] = $volume_20ter->id;
          $input['detail_id'] = $key;
          $input['quantity'] = $requestData['quantity'][$key]??0;
          Volume20TerProductDetail::create($input);
        }

    }

    private function Applicant20Ters() {
      return Applicant20Ter::select('id', 'ref_no', 'title', 'start_date', 'end_date')->where('created_by', auth()->user()->getKey())->where('state',4)->where('state_check',1)->get();
    }

    public function get_khrang_thi($applicant_20ter_id, $created_by){
           $max_id = Volume20Ter::where('applicant_20ter_id',$applicant_20ter_id)->where('created_by',$created_by)->max('id');
          //  var_dump($max_id); exit;
           $khrang_thi = 0;
           if($max_id){
              $result = Volume20Ter::select('khrang_thi')->where('id',$max_id)->first();
              $khrang_thi = $result->khrang_thi+1;
           } else {
             $khrang_thi = 1;
           }
           return $khrang_thi;
    }




}
