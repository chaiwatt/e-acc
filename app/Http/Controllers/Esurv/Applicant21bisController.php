<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\Applicant21Bis;
use App\Models\Esurv\Applicant21BisProductDetail;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Storage;
use HP;

class Applicant21BisController extends Controller
{
	private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');
	    $this->attach_path = 'esurv_attach/applicant_21bis/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('view-'.$model)) {

			$created_by = auth()->user()->getKey();

						$filter = [];
						$filter['search'] = $request->get('search', '');
            $filter['filter_state'] = $request->get('filter_state', '');
            $filter['perPage'] = $request->get('perPage', 10);

						$Query = new Applicant21Bis;
						$Query = $Query->where("trader_id",   auth()->user()->trader_id);

						if ($filter['search']!='') {

								$details = Applicant21BisProductDetail
				                  ::select('applicant_21bis_id')
				                  ->where('detail', 'LIKE', '%'.$filter['search'].'%')
				                  ->pluck('applicant_21bis_id');

			          $Query = $Query->where(function ($query) use ($details, $filter) {
													  $query->whereIn('id', $details)
													        ->orWhere('title', 'LIKE', '%'.$filter['search'].'%');
												 });
            }

						$applicant_21bis = $Query->sortable()
												->with('user_created')
												->with('user_updated')
												->paginate($filter['perPage']);

            return view('esurv.applicant_21bis.index', compact('applicant_21bis', 'filter'));
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
        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('add-'.$model)) {

					  $product_details = [(object)['id'=>'', 'detail'=>'', 'quantity'=>'', 'unit'=>'']];

						$attach_product_plan = (object)['file_name'=>''];
						$attach_hiring_book = (object)['file_name'=>''];
						$attach_factory_license = (object)['file_name'=>''];
						$attach_standard_to_made = (object)['file_name'=>''];
						$attach_difference_standard = (object)['file_name'=>''];
						$attach_drawing = (object)['file_name'=>''];

						$attachs = [(object)['file_note'=>'', 'file_name'=>'']];

            return view('esurv.applicant_21bis.create', compact('product_details',
														'attach_product_plan',
														'attach_hiring_book',
														'attach_factory_license',
														'attach_standard_to_made',
														'attach_difference_standard',
														'attach_drawing',
														'attachs'
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

        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('add-'.$model)) {
            $this->validate($request, [
							'title' => 'required'
						]);

						$requestData = $request->all();
						$requestData['ref_no'] = $this->RunNumber();//เลขรัน
						$requestData['made_factory_chk'] = array_key_exists('made_factory_chk', $requestData)?$requestData['made_factory_chk']:0;
						$requestData['store_factory_chk'] = array_key_exists('store_factory_chk', $requestData)?$requestData['store_factory_chk']:0;
						$requestData['created_by'] = auth()->user()->getKey(); //user create
						$requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
						$requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
						$requestData['state'] = 1; //state

		        //ไฟล์แนบ 1
						$requestData['attach_product_plan'] = $this->Upload(null, '', $request->file('attach_product_plan'));
						$requestData['attach_hiring_book'] = $this->Upload(null, '', $request->file('attach_hiring_book'));
						$requestData['attach_factory_license'] = $this->Upload(null, '', $request->file('attach_factory_license'));
						$requestData['attach_standard_to_made'] = $this->Upload(null, '', $request->file('attach_standard_to_made'));
						$requestData['attach_difference_standard'] = $this->Upload(null, '', $request->file('attach_difference_standard'));
						$requestData['attach_drawing'] = $this->Upload(null, '', $request->file('attach_drawing'));
						$requestData['trader_id'] = auth()->user()->trader_id;
		        //ไฟล์แนบอื่นๆ
		        $attach_others = [];
		        if ($files = $request->file('attach_other')) {

			        foreach ($files as $key => $file) {

				        //Upload File
				        $storagePath = Storage::put($this->attach_path, $file);
				        $storageName = basename($storagePath); // Extract the filename

				        $attach_others[] = ['file_name'=>$storageName,
				                            'file_client_name'=>$file->getClientOriginalName(),
				                            'file_note'=>$requestData['attach_notes'][$key]
				        ];
			        }

		        }

		        $requestData['attach_other'] = json_encode($attach_others);
				$requestData['different_no'] = $request->different_no?json_encode($requestData['different_no']):null;

		        $applicant_21bis = Applicant21Bis::create($requestData);

						//บันทึกรายการผลิตภัณฑ์
		        foreach ($requestData['product_detail'] as $key => $item) {
			        $product_detail = new Applicant21BisProductDetail();
			        $product_detail->detail = $item;
			        $product_detail->quantity = $requestData['quantity_detail'][$key];
			        $product_detail->unit = $requestData['unit_detail'][$key];
			        $product_detail->unit_other = $item;
			        $product_detail->applicant_21bis_id = $applicant_21bis->id;
			        $product_detail->save();
		        }

            return redirect('esurv/applicant_21bis')->with('flash_message', 'เพิ่มคำขอทำผลิตภัณฑ์เพื่อใช้ในประเทศเรียบร้อยแล้ว');
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
        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('view-'.$model)) {
            $applicant21bi = Applicant21Bis::findOrFail($id);
            return view('esurv.applicant_21bis.show', compact('applicant21bi'));
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
        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('edit-'.$model)) {

            $applicant21bi = Applicant21Bis::findOrFail($id);
						$applicant21bi['start_date'] = $applicant21bi['start_date']?Carbon::createFromFormat("Y-m-d",$applicant21bi['start_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
						$applicant21bi['end_date'] = $applicant21bi['end_date']?Carbon::createFromFormat("Y-m-d",$applicant21bi['end_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;

						$applicant21bi['different_no'] = json_decode($applicant21bi['different_no']);

					  //รายละเอียดผลิตภัณฑ์
					  $product_details = Applicant21BisProductDetail::where("applicant_21bis_id", $applicant21bi->id)->get();

						//ไฟล์แนบ
		        $attach_product_plan = json_decode($applicant21bi['attach_product_plan']);
		        $attach_product_plan = !empty($attach_product_plan)?$attach_product_plan:(object)['file_name'=>'', 'file_client_name'=>''];

						//ไฟล์แนบ
						$attach_hiring_book = json_decode($applicant21bi['attach_hiring_book']);
		        $attach_hiring_book = !empty($attach_hiring_book)?$attach_hiring_book:(object)['file_name'=>'', 'file_client_name'=>''];

						//ไฟล์แนบ
						$attach_factory_license = json_decode($applicant21bi['attach_factory_license']);
		        $attach_factory_license = !empty($attach_factory_license)?$attach_factory_license:(object)['file_name'=>'', 'file_client_name'=>''];

						//ไฟล์แนบ
						$attach_standard_to_made = json_decode($applicant21bi['attach_standard_to_made']);
		        $attach_standard_to_made = !empty($attach_standard_to_made)?$attach_standard_to_made:(object)['file_name'=>'', 'file_client_name'=>''];

						//ไฟล์แนบ
						$attach_difference_standard = json_decode($applicant21bi['attach_difference_standard']);
		        $attach_difference_standard = !empty($attach_difference_standard)?$attach_difference_standard:(object)['file_name'=>'', 'file_client_name'=>''];

						//ไฟล์แนบ
						$attach_drawing = json_decode($applicant21bi['attach_drawing']);
						$attach_drawing = !empty($attach_drawing)?$attach_drawing:(object)['file_name'=>'', 'file_client_name'=>''];

						//ไฟล์แนบ
		        $attachs = json_decode($applicant21bi['attach_other']);
		        $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];

						$attach_path = $this->attach_path; //path ไฟล์แนบ

            return view('esurv.applicant_21bis.edit', compact('applicant21bi',
						                                                  'product_details',
																															'attach_product_plan',
																															'attach_hiring_book',
																															'attach_factory_license',
																															'attach_standard_to_made',
																															'attach_difference_standard',
																															'attach_drawing',
																														  'attachs',
																															'attach_path')
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
        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('edit-'.$model)) {
            $this->validate($request, [
							'title' => 'required'
						]);

						$applicant21bi = Applicant21Bis::findOrFail($id);//รายการที่จะแก้ไข

            			$requestData = $request->all();
						$requestData['updated_by'] = auth()->user()->getKey();//user update
						$requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            			$requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
						$requestData['made_factory_chk'] = array_key_exists('made_factory_chk', $requestData)?$requestData['made_factory_chk']:0; //ใช้ที่เดียวกับที่จดทะเบียน
						$requestData['store_factory_chk'] = array_key_exists('store_factory_chk', $requestData)?$requestData['store_factory_chk']:0; //ใช้ที่เดียวกับที่ผลิต
						$requestData['state'] = 1; //state
						$requestData['trader_id'] = auth()->user()->trader_id;
						//จัดการรายการ รายละเอียดผลิตภัณฑ์อุตสาหกรรม
						Applicant21BisProductDetail::whereNotIn('id', $requestData['product_detail_id'])->where('applicant_21bis_id', $applicant21bi->id)
						                                                                                ->delete();//ลบรายการที่ถูกกดลบ

						foreach ($requestData['product_detail_id'] as $key => $item) {//อัพเดท หรือ เพิ่ม
							if($item!=''){
								$product_detail = Applicant21BisProductDetail::findOrFail($item);
							} else {
								$product_detail = new Applicant21BisProductDetail();
							}
							$product_detail->detail = $requestData['product_detail'][$key];
							$product_detail->quantity = $requestData['quantity_detail'][$key];
							$product_detail->unit = $requestData['unit_detail'][$key];
							$product_detail->unit_other = '';
							$product_detail->applicant_21bis_id = $applicant21bi->id;
							$product_detail->save();
		        		}

						//จัดการไฟล์แนบ
						$requestData['attach_product_plan'] = $this->Upload($applicant21bi->attach_product_plan, $requestData['attach_product_plan_file_name'], $request->file('attach_product_plan'));
						$requestData['attach_hiring_book'] = $this->Upload($applicant21bi->attach_hiring_book, $requestData['attach_hiring_book_file_name'], $request->file('attach_hiring_book'));
						$requestData['attach_factory_license'] = $this->Upload($applicant21bi->attach_factory_license, $requestData['attach_factory_license_file_name'], $request->file('attach_factory_license'));
						$requestData['attach_standard_to_made'] = $this->Upload($applicant21bi->attach_standard_to_made, $requestData['attach_standard_to_made_file_name'], $request->file('attach_standard_to_made'));
						$requestData['attach_difference_standard'] = $this->Upload($applicant21bi->attach_difference_standard, $requestData['attach_difference_standard_file_name'], $request->file('attach_difference_standard'));
						$requestData['attach_drawing'] = $this->Upload($applicant21bi->attach_drawing, $requestData['attach_drawing_file_name'], $request->file('attach_drawing'));

						//ไฟล์แนบอื่นๆ
						$requestData['attach_other'] = $this->UploadOther($applicant21bi->attach_other, $request->file('attach_other'), $requestData['attach_filenames'], $requestData['attach_notes']);

						//แตกต่างจากมาตรฐาน
						$requestData['different_no'] = $request->different_no?json_encode($requestData['different_no']):null;


            $applicant21bi->update($requestData);

            return redirect('esurv/applicant_21bis')->with('flash_message', 'แก้ไข Applicant21Bis เรียบร้อยแล้ว!');
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

        $model = str_slug('applicant-21bis','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new Applicant21Bis;
            Applicant21Bis::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            Applicant21Bis::destroy($id);
          }

          return redirect('esurv/applicant_21bis')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }

    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('applicant-21bis','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new Applicant21Bis;
          Applicant21Bis::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/applicant_21bis')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

		/*
      **** Run เลขที่คำขอ
    */
    private function RunNumber(){

      $year = date('Y')+543;

      $license_cancel = Applicant21Bis::where('ref_no', 'LIKE', "%-$year%")->orderBy('id', 'desc')->first();

      if(is_null($license_cancel)){
        $result = '001-'.$year;
      }else{
        $last_number = (int)$license_cancel->ref_no;
        $result = str_pad(($last_number+1), 3, '0', STR_PAD_LEFT).'-'.$year;
      }

      return $result;

    }

		public function Upload($json_file, $file_old_name, $file){//อัพเดทไฟล์แนบ

			//ข้อมูลไฟล์แนบเดิม
			$result = $json_file;

			//ข้อมูลไฟล์แนบเดิม แตกเป็น object
			$attach_product_plan = json_decode($json_file);

			if(@$attach_product_plan->file_name != "" && @$attach_product_plan->file_name != $file_old_name){
				Storage::delete($this->attach_path.$attach_product_plan->file_name);
				$result = '';
			}

			if ($request_file = $file) {
				//Upload File
				$storagePath = Storage::put($this->attach_path, $request_file);
				$storageName = basename($storagePath); // Extract the filename
				$attach_product_plans = ['file_name'=>$storageName,
																 'file_client_name'=>$request_file->getClientOriginalName(),
				];
				$result = json_encode($attach_product_plans);
				if(@$attach_product_plan->file_name != "") {//ลบไฟล์เก่า
					Storage::delete($this->attach_path . $attach_product_plan->file_name);
				}
			}

			return $result;

		}

		public function UploadOther($json_file, $file_uploads, $attach_filenames, $attach_notes){//อัพเดทไฟล์แนบอื่นๆ

				$attach_others = array_values((array)json_decode($json_file));//ข้อมูลไฟล์แนบเดิม

				//ไฟล์แนบ ที่ถูกกดลบ
				foreach ($attach_others as $key => $attach_other) {

					if(in_array($attach_other->file_name, $attach_filenames)===false){//ถ้าไม่มีไฟล์เดิมกลับมา
						unset($attach_others[$key]);
						Storage::delete($this->attach_path.$attach_other->file_name);
					}
				}

				//ไฟล์แนบ ข้อความที่แก้ไข
				foreach ($attach_others as $key => $attach_other) {
					$search_key = array_search($attach_other->file_name, $attach_filenames);
					if($search_key!==false){
						$attach_other->file_note = $attach_notes[$search_key];
					}
				}

				//ไฟล์แนบ เพิ่มเติม
				if ($files = $file_uploads) {

					foreach ($files as $key => $file) {

						//Upload File
						$storagePath = Storage::put($this->attach_path, $file);
						$newFile = basename($storagePath); // Extract the filename

						if($attach_filenames[$key]!=''){//ถ้าเป็นแถวเดิมที่มีในฐานข้อมูลอยู่แล้ว

							//วนลูปค้นหาไฟล์เดิม
							foreach ($attach_others as $key2 => $attach_other) {

								if($attach_other->file_name == $attach_filenames[$key]){ //ถ้าเจอแถวที่ตรงกันแล้ว

									Storage::delete($this->attach_path.$attach_other->file_name); //ลบไฟล์เก่า

									$attach_other->file_name = $newFile; //แก้ไขชื่อไฟล์ใน object
									$attach_other->file_client_name = $file->getClientOriginalName(); //แก้ไขชื่อไฟล์ของผู้ใช้ใน object

									break;
								}
							}

						}else{//แถวที่เพิ่มมาใหม่

							$attach_others[] = ['file_name'=>$newFile,
																	'file_client_name'=>$file->getClientOriginalName(),
																	'file_note'=>$attach_notes[$key]
																 ];
						}

					}

				}

				return json_encode($attach_others);

		}

		/*
		  **** รายการผลิตภัณฑ์
		*/
		public function detail_item($id){

			$details = Applicant21BisProductDetail::where('applicant_21bis_id', $id)
			                                      ->with('data_unit')
			                                      ->with('informed')
			                                      ->get();

			return response()->json($details);

		}

}
