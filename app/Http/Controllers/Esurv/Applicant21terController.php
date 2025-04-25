<?php

namespace App\Http\Controllers\Esurv;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Esurv\Applicant21Ter;
use App\Models\Esurv\Applicant21TerProductDetail;
use App\Models\Basic\Tis;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Storage;
use HP;
use PDF;
use File;
use Response;

class Applicant21TerController extends Controller
{
	private $attach_path;//ที่เก็บไฟล์แนบ

    public function __construct()
    {
        $this->middleware('auth');
		$this->attach_path = 'esurv_attach/applicant_21ter/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('view-'.$model)) {

						$created_by = auth()->user()->getKey();

						$filter = [];
						$filter['search'] = $request->get('search', '');
						$filter['filter_state'] = $request->get('filter_state', '');
						$filter['perPage'] = $request->get('perPage', 10);

						$Query = new Applicant21Ter;
						$Query = $Query->where("trader_id",   auth()->user()->trader_id);

						if ($filter['search']!='') {

								$details = Applicant21TerProductDetail::select('applicant_21ter_id')
																		                  ->where('detail', 'LIKE', '%'.$filter['search'].'%')
																		                  ->pluck('applicant_21ter_id');

			          $Query = $Query->where(function ($query) use ($details, $filter) {
													  $query->whereIn('id', $details)
													        ->orWhere('title', 'LIKE', '%'.$filter['search'].'%');
												 });
            }

						$applicant_21ter = $Query->sortable()
																		 ->with('user_created')
																		 ->with('user_updated')
																	   ->paginate($filter['perPage']);

            return view('esurv.applicant_21ter.index', compact('applicant_21ter', 'filter'));
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
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('add-'.$model)) {

	        $product_details = [(object)['id'=>'']];

					$attach_import_plan = (object)['file_name'=>''];
					$attach_product_plan = (object)['file_name'=>''];
					$attach_export_plan = (object)['file_name'=>''];
					$attach_purchase_order = (object)['file_name'=>''];
					$attach_factory_license = (object)['file_name'=>''];
					$attach_standard_to_made = (object)['file_name'=>''];
					$attach_difference_standard = (object)['file_name'=>''];
					$attach_permission_letter = (object)['file_name'=>''];
					$attachs = [(object)['file_note'=>'', 'file_name'=>'']];

	        return view('esurv.applicant_21ter.create', compact('product_details',
																'attach_import_plan',
																'attach_product_plan',
																'attach_export_plan',
																'attach_purchase_order',
																'attach_factory_license',
																'attach_standard_to_made',
																'attach_difference_standard',
																'attach_permission_letter',
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
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('add-'.$model)) {

            $requestData = $request->all();
			$requestData['ref_no'] = $this->RunNumber();//เลขรัน
			$requestData['different_no'] = $request->different_no?json_encode($requestData['different_no']):null;
			$requestData['country_export'] = $request->country_export?json_encode($requestData['country_export']):null;
            $requestData['created_by'] = auth()->user()->getKey(); //user create
            $requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['start_import_date'] = $request->start_import_date?Carbon::createFromFormat("d/m/Y",$request->start_import_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_import_date'] = $request->end_import_date?Carbon::createFromFormat("d/m/Y",$request->end_import_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['start_export_date'] = $request->start_export_date?Carbon::createFromFormat("d/m/Y",$request->start_export_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            $requestData['end_export_date'] = $request->end_export_date?Carbon::createFromFormat("d/m/Y",$request->end_export_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
			$requestData['state'] = 1; //state
			$requestData['trader_id'] = auth()->user()->trader_id;
				//ไฟล์แนบแผนการนำเข้า
		        $attach_import_plans = '';
		        if ($attach_import_plan = $request->file('attach_import_plan')) {

					//Upload File
					$storagePath = Storage::put($this->attach_path, $attach_import_plan);
					$storageName = basename($storagePath); // Extract the filename

			        $attach_import_plans = ['file_name'=>$storageName,
				                      'file_client_name'=>$attach_import_plan->getClientOriginalName(),
					];

				}

		        //ไฟล์แนบแผนการผลิต
		        $attach_product_plans = '';
		        if ($attach_product_plan = $request->file('attach_product_plan')) {

					//Upload File
					$storagePath = Storage::put($this->attach_path, $attach_product_plan);
					$storageName = basename($storagePath); // Extract the filename

			        $attach_product_plans = ['file_name'=>$storageName,
				                      'file_client_name'=>$attach_product_plan->getClientOriginalName(),
					];

				}

				//ไฟล์แนบแผนการส่งออก
		        $attach_export_plans = '';
		        if ($attach_export_plan = $request->file('attach_export_plan')) {

					//Upload File
					$storagePath = Storage::put($this->attach_path, $attach_export_plan);
					$storageName = basename($storagePath); // Extract the filename

			        $attach_export_plans = ['file_name'=>$storageName,
				                      'file_client_name'=>$attach_export_plan->getClientOriginalName(),
					];

		        }

		        $requestData['attach_import_plan'] = json_encode($attach_import_plans);
		        $requestData['attach_product_plan'] = json_encode($attach_product_plans);
		        $requestData['attach_export_plan'] = json_encode($attach_export_plans);

		        $attach_purchase_orders = '';
		        if ($attach_purchase_order = $request->file('attach_purchase_order')) {

			        //Upload File
			        $storagePath = Storage::put($this->attach_path, $attach_purchase_order);
			        $storageName = basename($storagePath); // Extract the filename

			        $attach_purchase_orders = ['file_name'=>$storageName,
			                                 'file_client_name'=>$attach_purchase_order->getClientOriginalName(),
			        ];

		        }

		        $requestData['attach_purchase_order'] = json_encode($attach_purchase_orders);

		        $attach_factory_licenses = '';
		        if ($attach_factory_license = $request->file('attach_factory_license')) {

			        //Upload File
			        $storagePath = Storage::put($this->attach_path, $attach_factory_license);
			        $storageName = basename($storagePath); // Extract the filename

			        $attach_factory_licenses = ['file_name'=>$storageName,
			                                   'file_client_name'=>$attach_factory_license->getClientOriginalName(),
			        ];

		        }

		        $requestData['attach_factory_license'] = json_encode($attach_factory_licenses);

		        $attach_standard_to_mades = '';
		        if ($attach_standard_to_made = $request->file('attach_standard_to_made')) {

			        //Upload File
			        $storagePath = Storage::put($this->attach_path, $attach_standard_to_made);
			        $storageName = basename($storagePath); // Extract the filename

			        $attach_standard_to_mades = ['file_name'=>$storageName,
			                                    'file_client_name'=>$attach_standard_to_made->getClientOriginalName(),
			        ];

		        }

		        $requestData['attach_standard_to_made'] = json_encode($attach_standard_to_mades);

		        $attach_difference_standards = '';
		        if ($attach_difference_standard = $request->file('attach_difference_standard')) {

			        //Upload File
			        $storagePath = Storage::put($this->attach_path, $attach_difference_standard);
			        $storageName = basename($storagePath); // Extract the filename

			        $attach_difference_standards = ['file_name'=>$storageName,
			                                     'file_client_name'=>$attach_difference_standard->getClientOriginalName(),
			        ];

		        }

				$requestData['attach_difference_standard'] = json_encode($attach_difference_standards);

		        $attach_permission_letters = '';
		        if ($attach_permission_letter = $request->file('attach_permission_letter')) {

			        //Upload File
			        $storagePath = Storage::put($this->attach_path, $attach_permission_letter);
			        $storageName = basename($storagePath); // Extract the filename

			        $attach_permission_letters = ['file_name'=>$storageName,
			                                     'file_client_name'=>$attach_permission_letter->getClientOriginalName(),
			        ];

		        }

		        $requestData['attach_permission_letter'] = json_encode($attach_permission_letters);

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
				$requestData['made_factory_chk'] = array_key_exists('made_factory_chk', $requestData)?$requestData['made_factory_chk']:0;
				$requestData['store_factory_chk'] = array_key_exists('store_factory_chk', $requestData)?$requestData['store_factory_chk']:0;

	          $applicant_21ter = Applicant21Ter::create($requestData);

		        foreach ($requestData['product_detail'] as $key => $item) {
			        $product_detail = new Applicant21TerProductDetail();
			        $product_detail->detail = $item;
			        $product_detail->quantity = $requestData['quantity_detail'][$key];
			        $product_detail->unit = $requestData['unit_detail'][$key];
			        $product_detail->unit_other = $item;
			        $product_detail->applicant_21ter_id = $applicant_21ter->id;
			        $product_detail->save();
		        }

	          return redirect('esurv/applicant_21ter')->with('flash_message', 'เพิ่ม EsurvApplicant21ter เรียบร้อยแล้ว');
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
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('view-'.$model)) {
            $applicant_21ter = Applicant21Ter::findOrFail($id);
            return view('esurv.applicant_21ter.show', compact('applicant_21ter'));
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
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('edit-'.$model)) {

            $applicant_21ter = Applicant21Ter::findOrFail($id);
				$applicant_21ter['start_date'] = $applicant_21ter['start_date']?Carbon::createFromFormat("Y-m-d",$applicant_21ter['start_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
				$applicant_21ter['end_date'] = $applicant_21ter['end_date']?Carbon::createFromFormat("Y-m-d",$applicant_21ter['end_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;

				$applicant_21ter['start_import_date'] = $applicant_21ter['start_import_date']?Carbon::createFromFormat("Y-m-d",$applicant_21ter['start_import_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
				$applicant_21ter['end_import_date'] = $applicant_21ter['end_import_date']?Carbon::createFromFormat("Y-m-d",$applicant_21ter['end_import_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;

				$applicant_21ter['start_export_date'] = $applicant_21ter['start_export_date']?Carbon::createFromFormat("Y-m-d",$applicant_21ter['start_export_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;
				$applicant_21ter['end_export_date'] = $applicant_21ter['end_export_date']?Carbon::createFromFormat("Y-m-d",$applicant_21ter['end_export_date'])->addYear(543)->formatLocalized('%d/%m/%Y'):null;


				//รายละเอียดผลิตภัณฑ์
		        $product_details = Applicant21TerProductDetail::where("applicant_21ter_id", $applicant_21ter->id)->get();

				//แตกต่างจากมาตรฐานเลขที่
				$applicant_21ter['different_no'] = json_decode($applicant_21ter['different_no']);
				$applicant_21ter['country_export'] = json_decode($applicant_21ter['country_export']);

				//ไฟล์แนบ
				$attach_import_plan = json_decode($applicant_21ter['attach_import_plan']);
		        $attach_import_plan = !empty($attach_import_plan)?$attach_import_plan:(object)['file_name'=>'', 'file_client_name'=>''];

		        $attach_product_plan = json_decode($applicant_21ter['attach_product_plan']);
		        $attach_product_plan = !empty($attach_product_plan)?$attach_product_plan:(object)['file_name'=>'', 'file_client_name'=>''];

				$attach_export_plan = json_decode($applicant_21ter['attach_export_plan']);
		        $attach_export_plan = !empty($attach_export_plan)?$attach_export_plan:(object)['file_name'=>'', 'file_client_name'=>''];

		        $attach_purchase_order = json_decode($applicant_21ter['attach_purchase_order']);
		        $attach_purchase_order = !empty($attach_purchase_order)?$attach_purchase_order:(object)['file_name'=>'', 'file_client_name'=>''];

		        $attach_factory_license = json_decode($applicant_21ter['attach_factory_license']);
		        $attach_factory_license = !empty($attach_factory_license)?$attach_factory_license:(object)['file_name'=>'', 'file_client_name'=>''];

		        $attach_standard_to_made = json_decode($applicant_21ter['attach_standard_to_made']);
		        $attach_standard_to_made = !empty($attach_standard_to_made)?$attach_standard_to_made:(object)['file_name'=>'', 'file_client_name'=>''];

		        // $attach_difference_standard = json_decode($applicant_21ter['attach_difference_standard']);
		        // $attach_difference_standard = !empty($attach_difference_standard)?$attach_difference_standard:(object)['file_name'=>'', 'file_client_name'=>''];

				$attach_permission_letter = json_decode($applicant_21ter['attach_permission_letter']);
		        $attach_permission_letter = !empty($attach_permission_letter)?$attach_permission_letter:(object)['file_name'=>'', 'file_client_name'=>''];

		        //ไฟล์แนบ
		        $attachs = json_decode($applicant_21ter['attach_other']);
		        $attachs = !is_null($attachs)&&count((array)$attachs)>0?$attachs:[(object)['file_note'=>'', 'file_name'=>'']];

		        $attach_path = $this->attach_path; //path ไฟล์แนบ

            return view('esurv.applicant_21ter.edit', compact('applicant_21ter',
																'product_details',
																'attach_import_plan',
																'attach_product_plan',
																'attach_export_plan',
																'attach_purchase_order',
																'attach_factory_license',
																'attach_standard_to_made',
																// 'attach_difference_standard',
																'attach_permission_letter',
																'attachs',
																'attach_path'
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
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('edit-'.$model)) {

            $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
			$requestData = $request->all();
			$requestData['trader_id'] = auth()->user()->trader_id;
			// dd($requestData);

            $applicant_21ter = Applicant21Ter::findOrFail($id);

		        Applicant21TerProductDetail::whereNotIn('id', $requestData['product_detail_id'])->where('applicant_21ter_id', $applicant_21ter->id )->delete();

		        foreach ($requestData['product_detail_id'] as $key => $item) {
		        	if($item!=''){
				        $product_detail = Applicant21TerProductDetail::findOrFail($item);
			        } else {
				        $product_detail = new Applicant21TerProductDetail();
			        }
			        $product_detail->detail = $requestData['product_detail'][$key];
			        $product_detail->quantity = $requestData['quantity_detail'][$key];
			        $product_detail->unit = $requestData['unit_detail'][$key];
			        $product_detail->unit_other = '';
			        $product_detail->applicant_21ter_id = $applicant_21ter->id;
			        $product_detail->save();
		        }


			//ข้อมูลไฟล์แนบ แผนการนำเข้า
	        $attach_import_plan = json_decode($applicant_21ter->attach_import_plan);

	        if(@$attach_import_plan->file_name != "" && @$attach_import_plan->file_name != $requestData['attach_import_plan_file_name']){
		        Storage::delete($this->attach_path.$attach_import_plan->file_name);
		        $requestData['attach_import_plan'] = '';
	        }
	        if ($request_file = $request->file('attach_import_plan')) {
		        //Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_import_plans = ['file_name'=>$storageName,
		                                 'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_import_plan'] = json_encode($attach_import_plans);
		        if(@$attach_import_plan->file_name != "") {
			        Storage::delete($this->attach_path . $attach_import_plan->file_name);
		        }
	        }
	        //ข้อมูลไฟล์แนบ แผนการผลิต
	        $attach_product_plan = json_decode($applicant_21ter->attach_product_plan);

	        if(@$attach_product_plan->file_name != "" && @$attach_product_plan->file_name != $requestData['attach_product_plan_file_name']){
		        Storage::delete($this->attach_path.$attach_product_plan->file_name);
		        $requestData['attach_product_plan'] = '';
	        }
	        if ($request_file = $request->file('attach_product_plan')) {
		        //Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_product_plans = ['file_name'=>$storageName,
		                                 'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_product_plan'] = json_encode($attach_product_plans);
		        if(@$attach_product_plan->file_name != "") {
			        Storage::delete($this->attach_path . $attach_product_plan->file_name);
		        }
			}

			 //ข้อมูลไฟล์แนบ แผนการส่งออก
	        $attach_export_plan = json_decode($applicant_21ter->attach_export_plan);

	        if(@$attach_export_plan->file_name != "" && @$attach_export_plan->file_name != $requestData['attach_export_plan_file_name']){
		        Storage::delete($this->attach_path.$attach_export_plan->file_name);
		        $requestData['attach_export_plan'] = '';
	        }
	        if ($request_file = $request->file('attach_export_plan')) {
		        //Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_export_plans = ['file_name'=>$storageName,
		                                 'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_export_plan'] = json_encode($attach_export_plans);
		        if(@$attach_export_plan->file_name != "") {
			        Storage::delete($this->attach_path . $attach_export_plan->file_name);
		        }
	        }

	        $attach_purchase_order = json_decode($applicant_21ter->attach_purchase_order);

	        if(@$attach_purchase_order->file_name != "" && @$attach_purchase_order->file_name != $requestData['attach_purchase_order_file_name']){
		        Storage::delete($this->attach_path.$attach_purchase_order->file_name);
		        $requestData['attach_purchase_order'] = '';
	        }
	        if ($request_file = $request->file('attach_purchase_order')) {
		        //Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_purchase_orders = ['file_name'=>$storageName,
		                                 'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_purchase_order'] = json_encode($attach_purchase_orders);
		        if(@$attach_purchase_order->file_name != "") {
			        Storage::delete($this->attach_path . $attach_purchase_order->file_name);
		        }
	        }

	        $attach_factory_license = json_decode($applicant_21ter->attach_factory_license);

	        if(@$attach_factory_license->file_name != "" && @$attach_factory_license->file_name != $requestData['attach_factory_license_file_name']){
		        Storage::delete($this->attach_path.$attach_factory_license->file_name);
		        $requestData['attach_factory_license'] = '';
	        }
	        if ($request_file = $request->file('attach_factory_license')) {
		        //Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_factory_licenses = ['file_name'=>$storageName,
		                                   'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_factory_license'] = json_encode($attach_factory_licenses);
		        if(@$attach_factory_license->file_name != "") {
			        Storage::delete($this->attach_path . $attach_factory_license->file_name);
		        }
	        }

	        $attach_standard_to_made = json_decode($applicant_21ter->attach_standard_to_made);

	        if(@$attach_standard_to_made->file_name != "" && @$attach_standard_to_made->file_name != $requestData['attach_standard_to_made_file_name']){
		        Storage::delete($this->attach_path.$attach_standard_to_made->file_name);
		        $requestData['attach_standard_to_made'] = '';
	        }
	        if ($request_file = $request->file('attach_standard_to_made')) {
		        //Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_standard_to_mades = ['file_name'=>$storageName,
		                                    'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_standard_to_made'] = json_encode($attach_standard_to_mades);
		        if(@$attach_standard_to_made->file_name != "") {
			        Storage::delete($this->attach_path . $attach_standard_to_made->file_name);
		        }
	        }

	        // $attach_difference_standard = json_decode($applicant_21ter->attach_difference_standard);

	        // if(@$attach_difference_standard->file_name != "" && @$attach_difference_standard->file_name != $requestData['attach_difference_standard_file_name']){
		    //     Storage::delete($this->attach_path.$attach_difference_standard->file_name);
		    //     $requestData['attach_difference_standard'] = '';
	        // }
	        // if ($request_file = $request->file('attach_difference_standard')) {
		         //Upload File
		    //     $storagePath = Storage::put($this->attach_path, $request_file);
		    //     $storageName = basename($storagePath); // Extract the filename
		    //     $attach_difference_standards = ['file_name'=>$storageName,
		    //                                  'file_client_name'=>$request_file->getClientOriginalName(),
		    //     ];
		    //     $requestData['attach_difference_standard'] = json_encode($attach_difference_standards);
		    //     if(@$attach_difference_standard->file_name != "") {
			//         Storage::delete($this->attach_path . $attach_difference_standard->file_name);
		    //     }
			// }

			$attach_permission_letter = json_decode($applicant_21ter->attach_permission_letter);

	        if(@$attach_permission_letter->file_name != "" && @$attach_permission_letter->file_name != $requestData['attach_permission_letter_file_name']){
		        Storage::delete($this->attach_path.$attach_permission_letter->file_name);
		        $requestData['attach_permission_letter'] = '';
	        }
	        if ($request_file = $request->file('attach_permission_letter')) {
		        // Upload File
		        $storagePath = Storage::put($this->attach_path, $request_file);
		        $storageName = basename($storagePath); // Extract the filename
		        $attach_permission_letters = ['file_name'=>$storageName,
		                                     'file_client_name'=>$request_file->getClientOriginalName(),
		        ];
		        $requestData['attach_permission_letter'] = json_encode($attach_permission_letters);
		        if(@$attach_permission_letter->file_name != "") {
			        Storage::delete($this->attach_path . $attach_permission_letter->file_name);
		        }
	        }

	        //ไฟล์แนบอื่นๆ

	        //ข้อมูลไฟล์แนบเดิม
	        $attach_others = array_values((array)json_decode($applicant_21ter->attach_other));

	        //ไฟล์แนบ ที่ถูกกดลบ
	        foreach ($attach_others as $key => $attach_other) {

		        if(in_array($attach_other->file_name, $requestData['attach_filenames'])===false){//ถ้าไม่มีไฟล์เดิมกลับมา
			        unset($attach_others[$key]);
			        Storage::delete($this->attach_path.$attach_other->file_name);
		        }
	        }

	        //ไฟล์แนบ ข้อความที่แก้ไข
	        foreach ($attach_others as $key => $attach_other) {
		        $search_key = array_search($attach_other->file_name, $requestData['attach_filenames']);
		        if($search_key!==false){
			        $attach_other->file_note = $requestData['attach_notes'][$search_key];
		        }
	        }

	        //ไฟล์แนบ เพิ่มเติม
	        if ($files = $request->file('attach_other')) {

		        foreach ($files as $key => $file) {

			        //Upload File
			        $storagePath = Storage::put($this->attach_path, $file);
			        $newFile = basename($storagePath); // Extract the filename

			        if($requestData['attach_filenames'][$key]!=''){//ถ้าเป็นแถวเดิมที่มีในฐานข้อมูลอยู่แล้ว

				        //วนลูปค้นหาไฟล์เดิม
				        foreach ($attach_others as $key2 => $attach_other) {

					        if($attach_other->file_name == $requestData['attach_filenames'][$key]){ //ถ้าเจอแถวที่ตรงกันแล้ว

						        Storage::delete($this->attach_path.$attach_other->file_name); //ลบไฟล์เก่า

						        $attach_other->file_name = $newFile; //แก้ไขชื่อไฟล์ใน object
						        $attach_other->file_client_name = $file->getClientOriginalName(); //แก้ไขชื่อไฟล์ของผู้ใช้ใน object

						        break;
					        }
				        }

			        }else{//แถวที่เพิ่มมาใหม่

				        $attach_others[] = ['file_name'=>$newFile,
				                      'file_client_name'=>$file->getClientOriginalName(),
				                      'file_note'=>$requestData['attach_notes'][$key]
				        ];
			        }

		        }

	        }

	        $requestData['attach_other'] = json_encode($attach_others);
			$requestData['different_no'] = $request->different_no?json_encode($requestData['different_no']):null;
			$requestData['country_export'] = $request->country_export?json_encode($requestData['country_export']):null;

			 		$requestData['start_date'] = $request->start_date?Carbon::createFromFormat("d/m/Y",$request->start_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            		$requestData['end_date'] = $request->end_date?Carbon::createFromFormat("d/m/Y",$request->end_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
			 		$requestData['start_import_date'] = $request->start_import_date?Carbon::createFromFormat("d/m/Y",$request->start_import_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            		$requestData['end_import_date'] = $request->end_import_date?Carbon::createFromFormat("d/m/Y",$request->end_import_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
			 		$requestData['start_export_date'] = $request->start_export_date?Carbon::createFromFormat("d/m/Y",$request->start_export_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;
            		$requestData['end_export_date'] = $request->end_export_date?Carbon::createFromFormat("d/m/Y",$request->end_export_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;

					$requestData['made_factory_chk'] = array_key_exists('made_factory_chk', $requestData)?$requestData['made_factory_chk']:0;
					$requestData['store_factory_chk'] = array_key_exists('store_factory_chk', $requestData)?$requestData['store_factory_chk']:0;
					$requestData['state'] = 1; //state

	        $applicant_21ter->update($requestData);

	        return redirect('esurv/applicant_21ter')->with('flash_message', 'แก้ไข EsurvApplicant21ter เรียบร้อยแล้ว!');
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
        $model = str_slug('applicant-21ter','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new Applicant21Ter;
            Applicant21Ter::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            Applicant21Ter::destroy($id);
          }

          return redirect('esurv/applicant_21ter')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('applicant-21ter','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new Applicant21Ter;
          Applicant21Ter::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('esurv/applicant_21ter')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

		/*
		  **** รายการผลิตภัณฑ์
		*/
		public function detail_item($id){

			$details = Applicant21TerProductDetail::where('applicant_21ter_id', $id)
			                                      ->with('data_unit')
			                                      ->with('informed')
			                                      ->get();

			return response()->json($details);

		}

		/*
      **** Run เลขที่คำขอ
    */
    private function RunNumber(){

      $year = date('Y')+543;

      $license_cancel = Applicant21Ter::where('ref_no', 'LIKE', "%-$year%")->orderBy('id', 'desc')->first();

      if(is_null($license_cancel)){
        $result = '001-'.$year;
      }else{
        $last_number = (int)$license_cancel->ref_no;
        $result = str_pad(($last_number+1), 3, '0', STR_PAD_LEFT).'-'.$year;
      }

      return $result;

    }

	public function ExportPDF($id=null)
    {
		if(!is_null($id)){

			$applicant21ter = Applicant21Ter::Where('id', $id)->first();
			$ref_arr = explode("-", $applicant21ter->ref_no);
				$ref_no_number = $ref_arr[0];
				$numberforshow = self::genReceivingNumber($applicant21ter->different_no, $applicant21ter->ref_no);
           		$data_export = [
					'different_no'        =>  $applicant21ter->different_no,
					'numberforshow'       =>  $numberforshow,
					'created_name'        =>  $applicant21ter->CreatedName, // ชื่อบริษัท
					'applicant_name'      =>  $applicant21ter->applicant_name, // ชื่อผู้ยื่น
					'applicant_position'  =>  $applicant21ter->applicant_position, //ตำแหน่ง
					'ref_no_number'       =>  $ref_no_number,
					'approved_date'       =>  $applicant21ter->state_approved_date
				];

         $pdf = PDF::loadView('esurv/applicant_21ter/pdf/document', $data_export);
        //    return $pdf->stream("scope-thai.pdf");
         $files =   "applicant_21ter_".$id;  // ชื่อไฟล์

         $path = 'files/applicants/21TerPdf/'. $files.'.pdf';
         $public = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
              //delete old pic if exists
            if (File::exists($public . $path)) {
                File::delete($public . $path);
             }
         Storage::put($path, $pdf->output());
        //  return redirect('esurv/applicant_21ter/FilePdf/'.$files);
         return  $pdf->download($files.'.pdf');
        }
        abort(403);
    }

	public function FilePrintAttach21TerPDF($list){
		$public = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
		$file = File::get($public.'files/applicants/21TerPdf/'.$list.'.pdf');
		$response = Response::make($file, 200);
		$response->header('Content-Type', 'application/pdf');
		return $response;
	}

	public function pdf_download($id){
		$this->ExportPDF($id);
	}

	public function genReceivingNumber($different_no, $ref_no){
		$year = (date('n')>9)?date('Y')+1+543:date('Y')+543; // ปีงบประมาณ
		$different_decode = json_decode($different_no);
		$moao_number = $different_decode[0];
		$tb3_Tisno = Tis::Where('tb3_TisAutono', $moao_number)->select('tb3_Tisno')->first();
		$tb3_Tisno_arr = explode("-", $tb3_Tisno->tb3_Tisno);
		$tis_no = $tb3_Tisno_arr[0];
		$ref_arr = explode("-", $ref_no);
		$ref_no_number = $ref_arr[0];

		return "กค-๒๑-".self::ThaiNumber($tis_no)."-".self::ThaiNumber($ref_no_number)."/".self::ThaiNumber($year);
	}

	public static function ThaiNumber($num){
		return str_replace(array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ), array( "o", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙" ), $num);
	}


}
