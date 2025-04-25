<?php

namespace App\Http\Controllers\Certify;

use HP;
use File;
use App\User;
use stdClass;
use Carbon\Carbon;
use App\ApplicantCB;
use App\Http\Requests;
use App\Mail\CB\CBCostMail;
use App\Models\Basic\Amphur;
use Illuminate\Http\Request;
use App\Mail\CB\CBReportMail;
use App\Models\Esurv\Trader; 
use App\Models\Basic\District;
use App\Models\Basic\Province;
use App\Mail\CB\CBAuditorsMail;
use App\Mail\CB\CBPayInOneMail;
use App\Mail\CB\CBPayInTwoMail;
 
use App\Mail\CB\CBApplicantMail;
use App\Models\Bcertify\Formula;
use App\Mail\CB\CBInspectiontMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CB\CBSaveAssessmentMail;
use App\Mail\CB\CBConFirmAuditorsMail;
use App\Services\CreateCbScopeBcmsPdf;
use App\Services\CreateCbScopeIsicPdf;
use App\Mail\CB\CBRequestDocumentsMail;
use App\Models\Certificate\CbScopeBcms;
use App\Models\Certificate\CbTrustMark;

use Illuminate\Support\Facades\Storage;

use App\Models\Bcertify\CbScopeIsicIsic;

use App\Models\Certify\ApplicantCB\CertiCb;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Bcertify\CertificationBranch;
use App\Models\Certificate\CbDocReviewAuditor;
use App\Models\Certify\ApplicantCB\CertiCBCost;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantCB\CertiCBReport;
use App\Models\Certify\ApplicantCB\CertiCBReview;
use App\Models\Certificate\CbScopeBcmsTransaction;
use App\Models\Certificate\CbScopeIsicTransaction;
use App\Models\Certify\ApplicantCB\CertiCBFileAll;

use App\Models\Certify\ApplicantCB\CertiCbHistory;
use App\Models\Certify\ApplicantCB\CertiCBAuditors;
use App\Models\Certify\ApplicantCB\CertiCBCostItem;
use App\Models\Certify\ApplicantCB\CertiCBFormulas;
use App\Models\Certify\ApplicantCB\CertiCBPayInOne;
use App\Models\Certify\ApplicantCB\CertiCBPayInTwo;
use App\Models\Certify\ApplicantCB\CertiCBAttachAll;
use App\Models\Certify\ApplicantCB\CertiCbExportMapreq;
use App\Models\Certify\ApplicantCB\CertiCBSaveAssessment;
use App\Models\Certificate\CbScopeIsicCategoryTransaction;
use App\Models\Certify\ApplicantCB\CertiCBSaveAssessmentBug;
use App\Models\Certificate\CbScopeIsicSubCategoryTransaction;
 
class ApplicantCBController extends Controller
{
       private $attach_path;//ที่เก็บไฟล์แนบ
    public function __construct()
    {
        // $this->middleware('auth');
        $this->attach_path  = 'files/applicants/check_files_cb/';
    }

 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
         $model = str_slug('applicantcbs','-');
         $data_session     =    HP::CheckSession();

        if(!empty($data_session)){
            if(HP::CheckPermission('view-'.$model)){
                $filter = [];
                $filter['filter_status'] = $request->get('filter_status', '');
                $filter['filter_search'] = $request->get('filter_search', '');
                $filter['perPage'] = $request->get('perPage', 10);
    
                $Query = new CertiCb;
                if ($filter['filter_status']!='') {
                    $status =  $filter['filter_status'] ;
                    if($status == 10 || $status  ==  11){
                        $Query = $Query->whereIn('status', [10,11]);
                    }else{
                        $Query = $Query->where('status', $status);
                    }
                }
                if ($filter['filter_search'] != '') {
                    $Query = $Query->where('app_no','LIKE', '%'.$filter['filter_search'].'%');
                }

                if(!is_null($data_session->agent_id)){  // ตัวแทน
                    $Query = $Query->where('agent_id',  $data_session->agent_id ) ;
                }else{
                    if($data_session->branch_type == 1){  // สำนักงานใหญ่
                        $Query = $Query->where('tax_id',  $data_session->tax_number ) ;
                    }else{   // ผู้บันทึก
                        $Query = $Query->where('created_by',   auth()->user()->getKey()) ;
                    }
                }
                $certiCbs = $Query->orderby('id','desc')
                                ->sortable()
                                ->paginate($filter['perPage']);
    
                $attach_path = $this->attach_path;
                return view('certify.applicant_cb.index', compact('certiCbs',
                                                                  'filter',
                                                                  'attach_path'));
            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }



    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
     if(!empty($data_session)){
        if(HP::CheckPermission('add-'.$model)){
            $previousUrl = app('url')->previous();
            // $user_tis =  Trader::where('trader_autonumber',$data_session->id)->first();
            $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
            $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();

            $data_session->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
            $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';
            // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
            $data_session->AMPHUR_ID    =    $data_session->district ?? '';
            // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
            $data_session->DISTRICT_ID  =     $data_session->subdistrict ?? '';
            $certi_cb = new CertiCb;

            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',1)->get();

            $app_certi_cb = DB::table('app_certi_cb')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_cb_export')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_cb_export')->select('id')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->get();

            $certifieds = CertiCBExport::whereIn('app_no',$app_certi_cb->get()->pluck('app_no')->toArray())->get();
            // dd($certifieds);
            // $Formula_Arr = Formula::where('applicant_type',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');
            $Formula_Arr = Formula::where('applicant_type', 1)
                ->where('state', 1)
                ->whereHas('certificationBranchs', function ($query) {
                    $query->whereNotNull('model_name');
                })
                ->pluck('title', 'id');

            $cbTrustmarks = CbTrustMark::all();

            // dd(Formula::find(10)->certificationBranchs);
            return view('certify.applicant_cb.create',[
                                                        'tis_data'            =>  $data_session,
                                                        'previousUrl'         =>  $previousUrl,
                                                        'certi_cb'            =>  $certi_cb,
                                                        'data_session'        =>  $data_session,
                                                        'certificate_exports' =>  $certificate_exports,
                                                        'certificate_no'      =>  $certificate_no,
                                                        'formulas'            =>  $formulas,
                                                        'certifieds'            =>  $certifieds,
                                                        'Formula_Arr'            =>  $Formula_Arr,
                                                        'cbTrustmarks'            =>  $cbTrustmarks,
                                                        'methodType' => 'create'
                                                      ]);
         }
         abort(403);
     }else{
        return  redirect(HP::DomainTisiSso());  
    }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function SaveCertiCb($request, $data_session , $token = null)
    {
        $requestData = $request->all();

        $requestApp  = $request->all();
        if( is_null($token) ){

            $id = "RQ-CB-";
            $year = Carbon::now()->addYears(543)->format('y');
            $order = sprintf('%03d',CertiCb::whereYear('created_at',Carbon::now()->year)->count()+1);
            $genId = $id.$year."-".$order;

            $requestApp['app_no'] =  $genId;
            $requestApp['created_by'] = auth()->user()->getKey();

            $requestApp['name']                = $data_session->name ?? null;
            $requestApp['applicanttype_id']    = $data_session->applicanttype_id ?? null;
            $requestApp['tax_id']              = $data_session->tax_number ?? null;
            $requestApp['token']               = str_random(16);
            $requestApp['start_date'] = date('Y-m-d');
          
        }else{
            $requestApp['updated_by'] = auth()->user()->getKey();
            $requestApp['created_at'] = date('Y-m-d H:i:s');

        }

        if($request->status == 1){
            // $requestApp['start_date'] = date('Y-m-d');
            $requestApp['status'] = 1;
        }else{
            $requestApp['status'] = 0;
        }

        $requestApp['doc_auditor_assignment'] = "1";
        $requestApp['name_standard']         = !empty($request->name_standard)?$request->name_standard:null;
        $requestApp['name_en_standard']      = !empty($request->name_en_standard)?$request->name_en_standard:null;
        $requestApp['name_short_standard']   = !empty($request->name_short_standard)?$request->name_short_standard:null;

        $requestApp['checkbox_confirm']    = isset($request->checkbox_confirm) ? $request->checkbox_confirm : null;

        //ที่อยู่ห้องปฏิบัติการ TH
        $requestApp['address_no']              = !empty($request->address_no)?$request->address_no:null;
        $requestApp['allay']                   = !empty($request->allay)?$request->allay:null;
        $requestApp['village_no']              = !empty($request->village_no)?$request->village_no:null;
        $requestApp['road']                    = !empty($request->road)?$request->road:null;
        $requestApp['province_id']             = !empty($request->province_id)?$request->province_id:null;
        $requestApp['amphur_id']               = !empty($request->amphur_id)?$request->amphur_id:null;
        $requestApp['district_id']             = !empty($request->district_id)?$request->district_id:null;
        $requestApp['postcode']                = !empty($request->postcode)?$request->postcode:null;
        $requestApp['tel']                     = !empty($request->tel)?$request->tel:null;
        $requestApp['tel_fax']                 = !empty($request->tel_fax)?$request->tel_fax:null;

        $requestApp['cb_latitude']            = !empty($request->cb_latitude)?$request->cb_latitude:null;
        $requestApp['cb_longitude']           = !empty($request->cb_longitude)?$request->cb_longitude:null;

        //ที่อยู่ห้องปฏิบัติการ EN
        $requestApp['cb_address_no_eng']      = !empty($request->cb_address_no_eng)?$request->cb_address_no_eng:null;
        $requestApp['cb_moo_eng']             = !empty($request->cb_moo_eng)?$request->cb_moo_eng:null;
        $requestApp['cb_soi_eng']             = !empty($request->cb_soi_eng)?$request->cb_soi_eng:null;
        $requestApp['cb_street_eng']          = !empty($request->cb_street_eng)?$request->cb_street_eng:null;
        $requestApp['cb_province_eng']        = !empty($request->cb_province_eng)?$request->cb_province_eng:null;
        $requestApp['cb_amphur_eng']          = !empty($request->cb_amphur_eng)?$request->cb_amphur_eng:null;
        $requestApp['cb_district_eng']        = !empty($request->cb_district_eng)?$request->cb_district_eng:null;
        $requestApp['cb_postcode_eng']        = !empty($request->cb_postcode_eng)?$request->cb_postcode_eng:null;

        //ข้อมูลสำหรับการติดต่อ
        $requestApp['contactor_name']          = !empty($request->contactor_name)?$request->contactor_name:null;
        $requestApp['email']                   = !empty($request->email)?$request->email:null;
        $requestApp['contact_tel']             = !empty($request->contact_tel)?$request->contact_tel:null;
        $requestApp['telephone']               = !empty($request->telephone)?$request->telephone:null;
        $requestApp['petitioner_id']           = !empty($request->petitioner)?$request->petitioner:null;
        $requestApp['trust_mark_id']           = !empty($request->trust_mark)?$request->trust_mark:null;
       
        
        $requestApp['hq_date_registered']      = Carbon::hasFormat($request->hq_date_registered, 'd/m/Y')?Carbon::createFromFormat("d/m/Y", $request->hq_date_registered)->addYear(-543)->format('Y-m-d'):null;

        if(  is_null($token) ){
            $requestApp['agent_id']           =   !empty($data_session->agent_id) ? $data_session->agent_id : null;  

            $certi_cb =  CertiCb::create($requestApp);
            
            $certi_cb = CertiCb::find($certi_cb->id);
        }else{

            $certi_cb =  CertiCb::where('token',$token)->first();

            // วันที่เปลี่ยนสถานะฉบับร่างเป็นรอดำเนินการตรวจ
            if($request->status == 1 && $certi_cb->status == 0 ){
                $requestApp['created_at'] = date('Y-m-d h:m:s');
            }

            $certi_cb->update($requestApp);
            $certi_cb =  CertiCb::where('token',$token)->first();
            // dd('2');
        }
        // dd($certi_cb->id);
        return $certi_cb; 
    }

    public function SaveFileSection($request, $name, $input_name, $section, $certi_cb )
    {
        $tb = new CertiCb;
        $requestData = $request->all();
        if( isset($requestData[ $name ]) ){
            $repeater_list = $requestData[ $name ];

            foreach( $repeater_list AS $item ){
                
                if( isset($item[ $input_name ]) ){
                    
                    $certi_cb_attach                   = new CertiCBAttachAll();
                    $certi_cb_attach->app_certi_cb_id = $certi_cb->id;
                    $certi_cb_attach->table_name       = $tb->getTable();
                    $certi_cb_attach->file_section     = (string)$section;
                    $certi_cb_attach->file_desc        = !empty($item[ 'attachs_txt' ])?$item[ 'attachs_txt' ]:null;
                    $certi_cb_attach->file             = $this->storeFile( $item[ $input_name ] ,$certi_cb->app_no);
                    $certi_cb_attach->file_client_name = HP::ConvertCertifyFileName( $item[ $input_name ]->getClientOriginalName());
                    $certi_cb_attach->token            = str_random(16);
                    $certi_cb_attach->save();
                }

            }

        }
    } 

    // public function SaveFileSection($request, $name, $input_name, $section, $certi_cb)
    // {
    //     try {
    //         $tb = new CertiCb;
    //         $requestData = $request->all();
            
    //         if (isset($requestData[$name])) {
    //             $repeater_list = $requestData[$name];
    //             foreach ($repeater_list as $item) {
    //                 if (isset($item[$input_name])) {
    //                     $certi_cb_attach = new CertiCBAttachAll();
    //                     $certi_cb_attach->app_certi_cb_id = $certi_cb->id;
    //                     $certi_cb_attach->table_name = $tb->getTable();
    //                     $certi_cb_attach->file_section = (string)$section;
    //                     $certi_cb_attach->file_desc = !empty($item['attachs_txt']) ? $item['attachs_txt'] : null;

    //                     $certi_cb_attach->file = $this->storeFile($item[$input_name], $certi_cb->app_no);

    //                     $certi_cb_attach->file_client_name = HP::ConvertCertifyFileName($item[$input_name]->getClientOriginalName());

    //                     $certi_cb_attach->token = str_random(16);
                        
    //                     $certi_cb_attach->save();

    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         // คุณสามารถใช้ log ข้อความเพื่อบันทึกข้อผิดพลาดหรือดำเนินการอย่างอื่น
    //         // \Log::error('Error in SaveFileSection: ' . $e->getMessage());
    //         // dd($e->getMessage());
    //         // หากต้องการส่งข้อความ error กลับไปยัง client
    //         // return response()->json(['error' => 'An error occurred while saving files.'], 500);
    //     }
    // }

    
    public function store(Request $request)
    {
        
        $request->json()->all();

        // ดึงข้อมูล JSON จาก request
        $cbScopeJson = json_decode($request->cbScopeJson, true);

        // dd($request->all());

        $selectedModel = $request->selectedModel;
        
        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('add-'.$model)){

                $requestData = $request->all();
                
                // add ceti cb
                $certi_cb = $this->SaveCertiCb($request, $data_session , null );
                // dd($certi_cb->id);
                // 1. คู่มือคุณภาพและขั้นตอนการดำเนินงานของระบบการบริหารงานคุณภาพที่สอดคล้องตามข้อกำหนดมาตรฐานที่ มอก. 17021-1 - 2559 (Certified body implementations which are conformed with TIS 17021-1 - 2559)
                if ( isset($requestData['repeater-section1'] ) ){
                    $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_cb );
                }
                
                //2. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responscbility)
                if ( isset($requestData['repeater-section2'] ) ){
                    $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_cb );
                }

                //3. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought)
                if ( isset($requestData['repeater-section3'] ) ){
                    $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_cb );
                }

                // เอกสารอื่นๆ (Others)
                if ( isset($requestData['repeater-section4'] ) ){
                    $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_cb );
                }

                if ( isset($requestData['repeater-section5'] ) ){
                    $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_cb );
                }


                if($selectedModel == "CbScopeIsicIsic")
                {
                    $this->storeCbScopeIsicIsic($cbScopeJson,$certi_cb);
                    $pdfService = new CreateCbScopeIsicPdf($certi_cb);
                    $pdfContent = $pdfService->generatePdf();
                

                }else if($selectedModel == "CbScopeBcms")
                {
                    $this->storeCbScopeBcms($cbScopeJson,$certi_cb);
                    $pdfService = new CreateCbScopeBcmsPdf($certi_cb);
                    $pdfContent = $pdfService->generatePdf();
                }

                // เงื่อนไขเช็คมีใบรับรอง 
                $this->save_certicb_export_mapreq( $certi_cb );

                if($certi_cb->status == 1){
                    $this->SET_EMAIL($certi_cb,1);
                  
                }
          
                return redirect('certify/applicant-cb')->with('message', 'เพิ่มเรียบร้อยแล้ว');

            }
            abort(403);

        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }

    public function clearCbScopeIsic($certiCb)
    {
        // ดึง transactions ก่อน
        $transactions = CbScopeIsicTransaction::where('certi_cb_id', $certiCb->id)->get();
        
        // ดึง category transactions ที่เกี่ยวข้อง
        $categoryTransactions = CbScopeIsicCategoryTransaction::whereIn('cb_scope_isic_transaction_id', 
            $transactions->pluck('id')->toArray()
        )->get();
    
        // ลบ Subcategories
        if ($categoryTransactions->isNotEmpty()) {
            CbScopeIsicSubCategoryTransaction::whereIn('cb_scope_isic_category_transaction_id', 
                $categoryTransactions->pluck('id')->toArray()
            )->delete();
        }
    
        // ลบ Categories
        if ($categoryTransactions->isNotEmpty()) {
            CbScopeIsicCategoryTransaction::whereIn('cb_scope_isic_transaction_id', 
                $transactions->pluck('id')->toArray()
            )->delete();
        }
    
        // ลบ ISIC transactions
        CbScopeIsicTransaction::where('certi_cb_id', $certiCb->id)->delete();
    }

    public function storeCbScopeIsicIsic($selectedIsicData,$certiCb) 
    {
        // dd($selectedIsicData);
        foreach ($selectedIsicData as $isicData) {
            if (empty($isicData['isic_id'])) {
                continue; // ข้ามหากไม่มี isic_id
            }

            // ตรวจสอบและบันทึก ISIC
            $transaction = CbScopeIsicTransaction::firstOrCreate([
                'certi_cb_id' => $certiCb->id,
                'isic_id' => $isicData['isic_id']
            ], [
                'is_checked' => $isicData['is_checked'] ?? true
            ]);

            // ตรวจสอบว่ามี categories หรือไม่
            if (!empty($isicData['categories'])) {
                foreach ($isicData['categories'] as $categoryData) {
                    if (empty($categoryData['category_id'])) {
                        continue; // ข้ามหากไม่มี category_id
                    }

                    // ตรวจสอบและบันทึก Category
                    $category = CbScopeIsicCategoryTransaction::firstOrCreate(
                        [
                            'cb_scope_isic_transaction_id' => $transaction->id,
                            'category_id' => $categoryData['category_id']
                        ],
                        [
                            'is_checked' => $categoryData['is_checked'] ?? false
                        ]
                    );

                    // ตรวจสอบว่ามี subcategories หรือไม่
                    if (!empty($categoryData['subcategories'])) {
                        foreach ($categoryData['subcategories'] as $subcategoryData) {
                            if (empty($subcategoryData['subcategory_id'])) {
                                continue; // ข้ามหากไม่มี subcategory_id
                            }

                            // ตรวจสอบและบันทึก Subcategory
                            CbScopeIsicSubCategoryTransaction::firstOrCreate(
                                [
                                    'cb_scope_isic_category_transaction_id' => $category->id,
                                    'subcategory_id' => $subcategoryData['subcategory_id']
                                ],
                                [
                                    'is_checked' => $subcategoryData['is_checked'] ?? false
                                ]
                            );
                        }
                    }
                }
            }
        }
    }

    public function clearCbScopeBcms($certiCb)
    {
        // ลบทุก record ที่เกี่ยวข้องกับ certi_cb_id
        CbScopeBcmsTransaction::where('certi_cb_id', $certiCb->id)
            ->delete();
    }

    public function storeCbScopeBcms($selectedBcmsData, $certiCb)
    {
        if (!is_array($selectedBcmsData) || empty($selectedBcmsData)) {
            return; // ตรวจสอบว่าข้อมูลมีค่าและอยู่ในรูปแบบ array ก่อนดำเนินการ
        }

        foreach ($selectedBcmsData as $bcmsData) {
            if (!isset($bcmsData['id'])) {
                continue; // ข้ามรายการถ้าไม่มี key 'id'
            }
            // ตรวจสอบและบันทึกข้อมูล
            CbScopeBcmsTransaction::firstOrCreate(
                [
                    'certi_cb_id' => $certiCb->id,
                    'bcms_id' => $bcmsData['id'],
                ]
            );

        }
    }

    public function show($token)
    {
        // dd('ok');
        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
     if(!empty($data_session)){
        if(HP::CheckPermission('view-'.$model)){
            $previousUrl    = app('url')->previous();
            $certi_cb       =  CertiCb::where('token',$token)->first();
            $tis_data       = $data_session;
            $attach_path    = $this->attach_path;//path ไฟล์แนบ
            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',1)->get();
            $app_certi_cb = DB::table('app_certi_cb')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_cb_export')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_cb_export')->select('id')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->get();

            $previousUrl = app('url')->previous();
            $certi_cb    =  CertiCb::where('token',$token)->first();

            $tis_data = $data_session;
 
            $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
            $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();
            $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';

            $tis_data->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
            // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
            $tis_data->AMPHUR_ID    =    $data_session->district ?? '';
            // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
            $tis_data->DISTRICT_ID  =     $data_session->subdistrict ?? '';

            $attach_path = $this->attach_path;//path ไฟล์แนบ

            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',1)->get();

            $app_certi_cb = DB::table('app_certi_cb')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_cb_export')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_cb_export')->select('id')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->get();
  
            $certifieds = CertiCBExport::whereIn('app_no',$app_certi_cb->get()->pluck('app_no')->toArray())->get();
            // dd($certifieds);
            // $Formula_Arr = Formula::where('applicant_type',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');
            $Formula_Arr = Formula::where('applicant_type', 1)
                ->where('state', 1)
                ->whereHas('certificationBranchs', function ($query) {
                    $query->whereNotNull('model_name');
                })
                ->pluck('title', 'id');
            
            $cbTrustmarks = CbTrustMark::where('bcertify_certification_branche_id',$certi_cb->petitioner_id)->get();
            // dd($cbTrustmarks);
            // $transactions = CbScopeIsicTransaction::where('certi_cb_id',$certi_cb->id)->with('cbScopeIsicCategoryTransactions.cbScopeIsicSubCategoryTransactions')->get();
            $certificationBranch = CertificationBranch::find($certi_cb->petitioner_id);
            $methodType = "show";
            // return view('certify.applicant_cb.show', compact('tis_data',
            //                                                  'previousUrl',
            //                                                  'certi_cb',
            //                                                  'attach_path',
            //                                                  'certificate_exports',
            //                                                  'certificate_no',
            //                                                  'formulas'
            //                                                 ));

                                                            return view('certify/applicant_cb.edit', compact('tis_data',
                                                            'previousUrl',
                                                            'certi_cb',
                                                            'attach_path',
                                                            'certificate_exports',
                                                            'certificate_no',
                                                            'formulas',
                                                            'certifieds',
                                                            'Formula_Arr',
                                                            'cbTrustmarks',
                                                            'certificationBranch',
                                                            'methodType'
                                                             ));                                                
        }
        abort(403);
    }else{
        return  redirect(HP::DomainTisiSso());  
    }

    }

    


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($token)
    {
        
        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
       if(!empty($data_session)){
        if(HP::CheckPermission('edit-'.$model)){
 
            $previousUrl = app('url')->previous();
            $certi_cb    =  CertiCb::where('token',$token)->first();

            $tis_data = $data_session;
 
            $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
            $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();
            $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';

            $tis_data->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
            // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
            $tis_data->AMPHUR_ID    =    $data_session->district ?? '';
            // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
            $tis_data->DISTRICT_ID  =     $data_session->subdistrict ?? '';

            $attach_path = $this->attach_path;//path ไฟล์แนบ

            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',1)->get();

            $app_certi_cb = DB::table('app_certi_cb')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_cb_export')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_cb_export')->select('id')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->get();
  
            $certifieds = CertiCBExport::whereIn('app_no',$app_certi_cb->get()->pluck('app_no')->toArray())->get();
            // dd($certifieds);
            // $Formula_Arr = Formula::where('applicant_type',1)->where('state',1)->orderbyRaw('CONVERT(title USING tis620)')->pluck('title','id');
            $Formula_Arr = Formula::where('applicant_type', 1)
                ->where('state', 1)
                ->whereHas('certificationBranchs', function ($query) {
                    $query->whereNotNull('model_name');
                })
                ->pluck('title', 'id');
            
            $cbTrustmarks = CbTrustMark::where('bcertify_certification_branche_id',$certi_cb->petitioner_id)->get();
            // dd($cbTrustmarks);
            // $transactions = CbScopeIsicTransaction::where('certi_cb_id',$certi_cb->id)->with('cbScopeIsicCategoryTransactions.cbScopeIsicSubCategoryTransactions')->get();
            $certificationBranch = CertificationBranch::find($certi_cb->petitioner_id);
            // dd($certi_cb);
            $methodType = "edit";
            return view('certify/applicant_cb.edit', compact('tis_data',
                                                             'previousUrl',
                                                             'certi_cb',
                                                             'attach_path',
                                                             'certificate_exports',
                                                             'certificate_no',
                                                             'formulas',
                                                             'certifieds',
                                                             'Formula_Arr',
                                                             'cbTrustmarks',
                                                             'certificationBranch',
                                                             'methodType'

                                                              ));
        }
          abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
       }
    }


    public function applicant_cb_doc_review($id)
    {

        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
       if(!empty($data_session)){
        if(HP::CheckPermission('edit-'.$model)){
 
            $previousUrl = app('url')->previous();
            $certi_cb    =  CertiCb::find($id);

            $tis_data = $data_session;
 
            $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
            $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();
            $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';

            $tis_data->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
            // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
            $tis_data->AMPHUR_ID    =    $data_session->district ?? '';
            // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
            $tis_data->DISTRICT_ID  =     $data_session->subdistrict ?? '';

            $attach_path = $this->attach_path;//path ไฟล์แนบ

            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',1)->get();

            $app_certi_cb = DB::table('app_certi_cb')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_cb_export')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_cb_export')->select('id')->whereIn('app_certi_cb_id',$app_certi_cb)->where('status',3)->get();
  
            return view('certify/applicant_cb.doc-review.edit', compact('tis_data',
                                                             'previousUrl',
                                                             'certi_cb',
                                                             'attach_path',
                                                             'certificate_exports',
                                                             'certificate_no',
                                                             'formulas'
                                                              ));
        }
          abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
       }
    }


 
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $token)
    {
        // ดึงข้อมูล JSON จาก request
        $cbScopeJson = json_decode($request->cbScopeJson, true);

        // dd($request->all());
        

        $selectedModel = $request->selectedModel;
        


        $certi_cb =  CertiCb::where('token',$token)->first();


        if($certi_cb->require_scope_update != "1")
        {
            if($certi_cb->status == 9 && $certi_cb->doc_review_reject !== null)
            {
                $this->docUpdate($request, $token);
                $certi_cb->update([
                    'doc_review_reject' => null
                ]);
            }else{
    
                if($selectedModel == "CbScopeIsicIsic")
                {
                    $this->clearCbScopeIsic($certi_cb);
                    $certi_cb =  CertiCb::where('token',$token)->first();
                    $this->storeCbScopeIsicIsic($cbScopeJson,$certi_cb);
                    $pdfService = new CreateCbScopeIsicPdf($certi_cb);
                    $pdfContent = $pdfService->generatePdf();
                
    
                }else if($selectedModel == "CbScopeBcms")
                {
                    $this->clearCbScopeBcms($certi_cb);
                    $certi_cb =  CertiCb::where('token',$token)->first();
                    $this->storeCbScopeBcms($cbScopeJson,$certi_cb);
                    $pdfService = new CreateCbScopeBcmsPdf($certi_cb);
                    $pdfContent = $pdfService->generatePdf();
                }
    
                $this->normalUpdate($request, $token);
            }
        }else{

            if($selectedModel == "CbScopeIsicIsic")
            {
                // dd($cbScopeJson);
                $this->clearCbScopeIsic($certi_cb);
                $certi_cb =  CertiCb::where('token',$token)->first();
                $this->storeCbScopeIsicIsic($cbScopeJson,$certi_cb);
                $pdfService = new CreateCbScopeIsicPdf($certi_cb);
                $pdfContent = $pdfService->generatePdf();
            

            }else if($selectedModel == "CbScopeBcms")
            {
                $this->clearCbScopeBcms($certi_cb);
                $certi_cb =  CertiCb::where('token',$token)->first();
                $this->storeCbScopeBcms($cbScopeJson,$certi_cb);
                $pdfService = new CreateCbScopeBcmsPdf($certi_cb);
                $pdfContent = $pdfService->generatePdf();
            }
            CertiCb::where('token',$token)->first()->update([
                'require_scope_update' => 2
            ]);

        }
        // dd($certi_cb->status);


        return redirect('certify/applicant-cb')->with('message', 'แก้ไขเรียบร้อยแล้ว!');
      

    }


    public function normalUpdate($request, $token)
    {
        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){

                try {
                    $requestData = $request->all();
                    $certi_cb = $this->SaveCertiCb($request, $data_session , $token );
                   
                    // 1. คู่มือคุณภาพและขั้นตอนการดำเนินงานของระบบการบริหารงานคุณภาพที่สอดคล้องตามข้อกำหนดมาตรฐานที่ มอก. 17021-1 - 2559 (Certified body implementations which are conformed with TIS 17021-1 - 2559)
                    if ( isset($requestData['repeater-section1'] ) ){
                        $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_cb );
                    }

                    //2. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responscbility)
                    if ( isset($requestData['repeater-section2'] ) ){
                        $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_cb );
                    }

                    //3. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought)
                    if ( isset($requestData['repeater-section3'] ) ){
                        $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_cb );
                    }

                    // เอกสารอื่นๆ (Others)
                    if ( isset($requestData['repeater-section4'] ) ){
                        $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_cb );
                    }

                    if ( isset($requestData['repeater-section5'] ) ){
                        $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_cb );
                    }

                      // เงื่อนไขเช็คมีใบรับรอง 
                     $this->save_certicb_export_mapreq( $certi_cb );


                     
   
    
                    if(!is_null($certi_cb)){
                        $status = $certi_cb->status ?? 1;
                        $certi_cb->update($requestData);

                        if($status == 3){
                            $this->SET_EMAIL_Request_Documents($certi_cb);
                        }else{
                            if($certi_cb->status == 1){
                                $this->SET_EMAIL($certi_cb,$status);
                            }
                        }
                    }


                    return redirect('certify/applicant-cb')->with('message', 'แก้ไขเรียบร้อยแล้ว!');
                } catch (\Exception $e) {
                    return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }    

            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }

    public function docUpdate($request, $token)
    {
        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){

                try {
                    $requestData = $request->all();
                    $certi_cb =  CertiCb::where('token',$token)->first();
                   
                    // 1. คู่มือคุณภาพและขั้นตอนการดำเนินงานของระบบการบริหารงานคุณภาพที่สอดคล้องตามข้อกำหนดมาตรฐานที่ มอก. 17021-1 - 2559 (Certified body implementations which are conformed with TIS 17021-1 - 2559)
                    if ( isset($requestData['repeater-section1'] ) ){
                        $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_cb );
                    }

                    //2. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responscbility)
                    if ( isset($requestData['repeater-section2'] ) ){
                        $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_cb );
                    }

                    // เอกสารอื่นๆ (Others)
                    if ( isset($requestData['repeater-section4'] ) ){
                        $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_cb );
                    }

                    if ( isset($requestData['repeater-section5'] ) ){
                        $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_cb );
                    }


                    return redirect('certify/applicant-cb')->with('message', 'แก้ไขเรียบร้อยแล้ว!');
                } catch (\Exception $e) {
                    return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }    

            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }

    public function applicant_cb_doc_update(Request $request, $id)
    {

        $model = str_slug('applicantcbs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){

                try {
                    $requestData = $request->all();
                    $certi_cb = CertiCb::find($id);
                   
                    // 1. คู่มือคุณภาพและขั้นตอนการดำเนินงานของระบบการบริหารงานคุณภาพที่สอดคล้องตามข้อกำหนดมาตรฐานที่ มอก. 17021-1 - 2559 (Certified body implementations which are conformed with TIS 17021-1 - 2559)
                    if ( isset($requestData['repeater-section1'] ) ){
                        $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_cb );
                    }

                    //2. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responscbility)
                    if ( isset($requestData['repeater-section2'] ) ){
                        $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_cb );
                    }

                    //3. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought)
                    if ( isset($requestData['repeater-section3'] ) ){
                        $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_cb );
                    }

                    // เอกสารอื่นๆ (Others)
                    if ( isset($requestData['repeater-section4'] ) ){
                        $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_cb );
                    }

                    if ( isset($requestData['repeater-section5'] ) ){
                        $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_cb );
                    }

                    //   // เงื่อนไขเช็คมีใบรับรอง 
                    //  $this->save_certicb_export_mapreq( $certi_cb );
   
    
                    // if(!is_null($certi_cb)){
                    //     $status = $certi_cb->status ?? 1;
                    //     $certi_cb->update($requestData);

                    //     if($status == 3){
                    //         $this->SET_EMAIL_Request_Documents($certi_cb);
                    //     }else{
                    //         if($certi_cb->status == 1){
                    //             $this->SET_EMAIL($certi_cb,$status);
                    //         }
                    //     }
                    // }


                    return redirect('certify/applicant-cb')->with('message', 'แก้ไขเรียบร้อยแล้ว!');
                } catch (\Exception $e) {
                    return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }    

            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }


              //การประมาณค่าใช้จ่าย
      public function EditCost($token)
      {
        $previousUrl = app('url')->previous();
        $certi_cb =  CertiCb::where('token',$token)->first();
        $attach_path = $this->attach_path;//path ไฟล์แนบ
        return view('certify.applicant_cb/form_status.form_status8', compact('previousUrl','certi_cb','attach_path'));
      }

      public function updateStatusCost(Request $request, $token)
      {

 try {

        $certi_cb =  CertiCb::where('token',$token)->first();
        $certi_cost = CertiCBCost::where('app_certi_cb_id',$certi_cb->id) ->orderby('id','desc')->first();
        $tb = new CertiCBCost;
        $attachs = null;
        $attachs_scope = null;

        if(!is_null($certi_cb) &&  !is_null($certi_cost)){

            if ($request->another_modal_attach_files  && $request->hasFile('another_modal_attach_files')){
                foreach ($request->another_modal_attach_files as $index => $item){
                    $certi_cb_attach_more                   = new CertiCBAttachAll();
                    $certi_cb_attach_more->app_certi_cb_id  = $certi_cb->id;
                    $certi_cb_attach_more->ref_id           = $certi_cost->id;
                    $certi_cb_attach_more->table_name       = $tb->getTable();
                    $certi_cb_attach_more->file_desc        = $request->file_desc[$index] ?? null;
                    $certi_cb_attach_more->file             = $this->storeFile($item,$certi_cb->app_no);
                    $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                    $certi_cb_attach_more->file_section     = '2';
                    $certi_cb_attach_more->token            = str_random(16);
                    $certi_cb_attach_more->save();

                    $cost_find                      = new stdClass();
                    $cost_find->file_desc           = $certi_cb_attach_more->file_desc;
                    $cost_find->file                = $certi_cb_attach_more->file ;
                    $cost_find->file_client_name    = $certi_cb_attach_more->file_client_name ;
                    $attachs[]                      = $cost_find;
                }
            }

            if ($request->attach_files  && $request->hasFile('attach_files')){
                foreach ($request->attach_files as $index => $item){
                    $certi_cb_attach_more                   = new CertiCBAttachAll();
                    $certi_cb_attach_more->app_certi_cb_id  = $certi_cb->id;
                    $certi_cb_attach_more->ref_id           = $certi_cost->id;
                    $certi_cb_attach_more->table_name       = $tb->getTable();
                    $certi_cb_attach_more->file_desc        = $request->file_desc_text[$index] ?? null;
                    $certi_cb_attach_more->file             = $this->storeFile($item,$certi_cb->app_no);
                    $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                    $certi_cb_attach_more->file_section     = '3';
                    $certi_cb_attach_more->token            = str_random(16);
                    $certi_cb_attach_more->save();

                    $find = new stdClass();
                    $find->file_desc_text   = $certi_cb_attach_more->file_desc;
                    $find->attach_files     = $certi_cb_attach_more->file ;
                    $find->file_client_name = $certi_cb_attach_more->file_client_name ;
                    $attachs_scope[]        = $find;
                }
            }

            $requestData = $request->all();

            if($request->status_scope == 1 && $request->check_status == 1){
                    $certi_cb->status = 9;
                    $requestData['remark']  =  null;
                    $requestData['remark_scope']  =  null;
            }else{
                $certi_cb->status = 7;
                if($request->check_status == 2){
                    $requestData['remark']  =  $request->remark ?? null;
                }else{
                    $requestData['remark']  =  null;
                }

                if($request->status_scope == 2){
                    $requestData['remark_scope']  =  $request->remark_scope ?? null;
                }else{
                    $requestData['remark_scope']  =  null;
                }
                $requestData['vehicle']  =  2;
            }
            $certi_cb->save();

            $requestData['draft']  = 3;
            $requestData['date']  = date('Y-m-d');

            $certi_cost->update($requestData);

            $check_status = ['1'=>'ยืนยัน','2'=>'แก้ไข'];
            $status_scope = ['1'=>'ยื่นยัน Scope','2'=>'ขอแก้ไข Scope'];
                $title = '';
            if($request->status_scope == 2 && $request->check_status == 2){
                $title = 'ขอแก้เห็นชอบกับค่าใช่จ่ายที่เสนอมา/เห็นชอบกับ Scope (การประมาณค่าใช้จ่าย)' ;
            }elseif($request->check_status == 2){
                $title = 'ขอแก้เห็นชอบกับค่าใช่จ่ายที่เสนอมา (การประมาณค่าใช้จ่าย)' ;
            }elseif($request->status_scope == 2){
                $title = 'ขอแก้เห็นชอบกับ Scope (การประมาณค่าใช้จ่าย)' ;
            }else{
                $title = 'การประมาณค่าใช้จ่าย' ;
            }
            $this->set_cost_history($certi_cost,$attachs,$attachs_scope);

            if(!is_null($certi_cb->email) && count($certi_cb->DataEmailDirectorCB) > 0){  //  ส่ง E-mail

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');    

             $data_app =[  'email'             => $certi_cb->email,
                            'certi_cb'         => $certi_cb ??  '-',
                            'title'            => $title,
                            'certi_cost'       => $certi_cost,
                            'check_status'     => array_key_exists($certi_cost->check_status,$check_status)   ? $check_status[$certi_cost->check_status]   :  '-',
                            'status_scope'     => array_key_exists($certi_cost->status_scope,$status_scope)   ? $status_scope[$certi_cost->status_scope]   :  '-',
                            'attachs'          => !is_null($attachs) ? $attachs : '-',
                            'attachs_scope'    => !is_null($attachs_scope) ? $attachs_scope : '-',
                            'url'              => $url.'/certify/estimated_cost-cb/'. $certi_cost->id .'/edit' ?? '-',
                            'email_cc'         => (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th'
                        ];

             $email_cc =    (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailDirectorCBCC): 'cb@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                    $certi_cb->id,
                                                    (new CertiCb)->getTable(),
                                                    $certi_cost->id,
                                                    (new CertiCBCost)->getTable(),
                                                    3,
                                                    'การประมาณการค่าใช้จ่าย',
                                                    view('mail.CB.cost', $data_app),
                                                    $certi_cb->created_by,
                                                    $certi_cb->agent_id,
                                                    null,
                                                    $certi_cb->email,
                                                    implode(',',(array)$certi_cb->DataEmailDirectorCB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                 );

            $html = new CBCostMail($data_app);
            $mail =  Mail::to($certi_cb->DataEmailDirectorCB)->send($html);
        
            if(is_null($mail) && !empty($log_email)){
                HP::getUpdateCertifyLogEmail($log_email->id);
            }
 
        }


        }

        if($request->previousUrl){
            return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
        }else{
            return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
        }

    } catch (\Exception $e) {
        return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    }    
      
  }
      public function set_cost_history($data,$file1,$file2)
      {
         $data_session     =    HP::CheckSession();
 
            if($file1 != null){
                $attachs_file  =  $file1;
            }
            if($file2 != null){
                $evidence  =  $file2;
            }
          $tb = new CertiCBCost;
          $Cost = CertiCBCost::select('app_certi_cb_id', 'draft', 'check_status', 'remark', 'status_scope', 'remark_scope')
                        ->where('id',$data->id)
                        ->first();

          $CostItem = CertiCBCostItem::select('app_certi_cost_id','detail','amount_date','amount')
                                ->where('app_certi_cost_id',$data->id)
                                ->get()
                                ->toArray();
         $CertiCbHistory = CertiCbHistory::where('table_name',$tb->getTable())
                                                ->where('ref_id',$data->id)
                                                ->where('system',4)
                                                ->orderby('id','desc')
                                                ->first();
         if(!is_null($CertiCbHistory)){
            $CertiCbHistory->update([
                                      'details_one'     =>  json_encode($Cost) ?? null,
                                      'attachs_file'    =>  isset($attachs_file) ?  json_encode($attachs_file) : null,
                                      'evidence'        =>  isset($evidence) ?  json_encode($evidence) : null,
                                      'updated_by'      =>   auth()->user()->getKey() , 
                                      'date'            =>   date('Y-m-d')
                                   ]);
         }

     }
        // สำหรับเพิ่มรูปไปที่ store
        public function storeFile($files, $app_no = 'files_cb', $name = null)
        {
            $no  = str_replace("RQ-","",$app_no);
            $no  = str_replace("-","_",$no);
            if ($files) {
                $attach_path  =  $this->attach_path.$no;
                $file_extension = $files->getClientOriginalExtension();
                $fileClientOriginal   =  HP::ConvertCertifyFileName($files->getClientOriginalName());
                $filename = pathinfo($fileClientOriginal, PATHINFO_FILENAME);
                $fullFileName =  str_random(10).'-date_time'.date('Ymd_hms') . '.' . $files->getClientOriginalExtension();
                $storagePath = Storage::putFileAs($attach_path, $files,  str_replace(" ","",$fullFileName) );
                $storageName = basename($storagePath); // Extract the filename
                return  $no.'/'.$storageName;
            }else{
                return null;
            }
        }

        public function removeFilesCertiCBAttachAll($path,$token){
              $certi_cb_attach = CertiCBAttachAll::where('token',$token)->first();
              if(!is_null($certi_cb_attach)){
                try{
                    $file = storage_path().'/'.$certi_cb_attach->file;
                        if(is_file($file)){
                            File::delete($file);
                        }
                    $certi_cb_attach->delete();
                    return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
                }catch (\Exception $x){
                    echo "เกิดข้อผิดพลาด";
                }
              }else{
                return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
              }
        }
        public function delete_file($id)
        {
            $Cost = CertiCBAttachAll::findOrFail($id);
            // $public = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
                if (!is_null($Cost)) {
                    // $filePath =  $public.'/' .$Cost->file;
                    // if( File::exists($filePath)){
                    //     File::delete($filePath);
                        $Cost->delete();
                        $file = 'true';
                    // }else{
                    //     $file = 'false';
                    // }
                }else{
                    $file = 'false';
                }
              return  $file;
        }
        public function deleteApplicant(Request $request)
        {

            $certi_cb = CertiCb::where('token',$request->token)->first();
            if(!is_null($certi_cb)){
                $certi_cb->desc_delete = $request->reason;
                $certi_cb->status = 4;
                $certi_cb->save();

                if ($request->another_attach_files_del && $request->hasFile('another_attach_files_del')){
                    $tb = new CertiCb;
                    foreach ($request->another_attach_files_del as $index => $item){
                        $certi_cb_attach_more = new CertiCBAttachAll();
                        $certi_cb_attach_more->app_certi_cb_id  = $certi_cb->id;
                        $certi_cb_attach_more->table_name       = $tb->getTable();
                        $certi_cb_attach_more->file_section     = '5';
                        $certi_cb_attach_more->file_desc        = $request->another_attach_name[$index] ?? null;
                        $certi_cb_attach_more->file             = $this->storeFile($item);
                        $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                        $certi_cb_attach_more->token            = str_random(16);
                        $certi_cb_attach_more->save();
                    }
                }
            }


            return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
        }

        // สาขาตามมาตรฐาน (CB)
        public function GetFormulas($id)
        {
            $data = CertiCBFormulas::select('title','id')->where('formulas_id',$id)->get();
            return response()->json(['data' => $data  ?? '-'  ], 200);
        }

        // สาขาตามมาตรฐาน (CB) ใหม่
        public function GetFormulas2($id)
        {
            $data = CertificationBranch::where('formula_id', $id)
                ->where('state', 1)
                ->select('title', 'id','model_name')
                ->get();

            return response()->json(['data' => $data  ?? '-'  ], 200);
        }

        public function updateDocReviewTeam(Request $request)
        {
            // dd($request->all());
            $certiCbId = $request->certiCbId;
            $cbDocReviewAuditor = CbDocReviewAuditor::where('app_certi_cb_id', $certiCbId)->first();
            $cbDocReviewAuditor->update([
                'status' => $request->agreeValue,
                'remark_text' => $request->remarkText,
            ]);
            
        }

        public function getCbIsicScope(Request $request)
        {
            return CbScopeIsicIsic::with('categories.subcategories')->get();
        }

        public function getCbBcmsScope(Request $request)
        {
            return CbScopeBcms::get();
        }

        public function demoStoreIsicScope(Request $request)
        {
            $data = $request->json()->all();

            

            if (!isset($data['selectedIsicData']) || empty($data['selectedIsicData'])) {
                return response()->json(['message' => 'ไม่มีข้อมูลที่ส่งมา'], 400);
            }

            foreach ($data['selectedIsicData'] as $isicData) {
                // ตรวจสอบและบันทึก ISIC
                $transaction = CbScopeIsicTransaction::firstOrCreate(
                    ['isic_id' => $isicData['isic_id']],
                    ['is_checked' => $isicData['is_checked'] ?? true]
                );

                foreach ($isicData['categories'] as $categoryData) {
                    // ตรวจสอบและบันทึก Category
                    $category = CbScopeIsicCategoryTransaction::firstOrCreate(
                        [
                            'cb_scope_isic_transaction_id' => $transaction->id,
                            'category_id' => $categoryData['category_id']
                        ],
                        ['is_checked' => $categoryData['is_checked']]
                    );

                    foreach ($categoryData['subcategories'] as $subcategoryData) {
                        // ตรวจสอบและบันทึก Subcategory
                        CbScopeIsicSubCategoryTransaction::firstOrCreate(
                            [
                                'cb_scope_isic_category_transaction_id' => $category->id,
                                'subcategory_id' => $subcategoryData['subcategory_id']
                            ],
                            ['is_checked' => $subcategoryData['is_checked']]
                        );
                    }
                }
            }

            return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ!']);
        }



        public function getCbScopeIsicTransaction(Request $request) 
        {
            $cbId = $request->cbId;
            // dd($cbId);
            $transactions = CbScopeIsicTransaction::where('certi_cb_id',$cbId)->with('cbScopeIsicCategoryTransactions.cbScopeIsicSubCategoryTransactions')->get();
            // dd($transactions);
            return response()->json($transactions);
        }


        public function demoStoreBcmsScope(Request $request)
        {
            $data = $request->json()->all();

            // ตรวจสอบว่ามีข้อมูล selectedBcmsData หรือไม่
            if (!isset($data['selectedBcmsData']) || !is_array($data['selectedBcmsData'])) {
                return response()->json(['error' => 'Invalid data format'], 400);
            }

            foreach ($data['selectedBcmsData'] as $bcmsData) {
                CbScopeBcmsTransaction::firstOrCreate([
                    'bcms_id' => $bcmsData['id'],
                ]);
            }

            return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ!'], 200);
        }

        public function getCbScopeBcmsTransaction(Request $request) 
        {
            $cbId = $request->cbId;
            $transactions = CbScopeBcmsTransaction::where('certi_cb_id',$cbId)->get();
            return response()->json($transactions);
        }


        public function GetTrustMark($id)
        {
            // dd($id);
            $cbTrustMarks = CbTrustMark::where('bcertify_certification_branche_id',$id)->get();
            return response()->json(['cbTrustMarks' => $cbTrustMarks  ?? '-'  ], 200);
        }


       // ส่ง Email
        public function SET_EMAIL($certi_cb,$status = null)
        {
          if(count($certi_cb->DataEmailDirectorCB) > 0){

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');   

            $request = '';
            if($status == 3){
                $request = 'ได้แก้ไข';
            }else{
                $request = 'ได้ยื่น';
            }

             $data_app =['email'    =>  $certi_cb->email ?? '-',
                        'title'    =>  'คำขอใบรับรองฯ (CB)' ?? '-',
                        'app_no'   =>  $certi_cb->app_no ?? ' -',
                        'name'     =>   !empty($certi_cb->name)  ? $certi_cb->name  : '-',
                        'request'  =>  $request,
                        'url'      =>  $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                        'email_cc' =>  (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th'
                        ];

            $email_cc =    (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailDirectorCBCC): 'cb@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                    $certi_cb->id,
                                                    (new CertiCb)->getTable(),
                                                    $certi_cb->id,
                                                    (new CertiCb)->getTable(),
                                                    3,
                                                    'คำขอรับบริการยืนยันความสามารถหน่วยรับรอง',
                                                    view('mail.CB.applicant', $data_app),
                                                    $certi_cb->created_by,
                                                    $certi_cb->agent_id,
                                                    null,
                                                    $certi_cb->email,
                                                    implode(',',(array)$certi_cb->DataEmailDirectorCB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                 );
                                           
            $html = new CBApplicantMail($data_app);
           
            $mail =  Mail::to($certi_cb->DataEmailDirectorCB)->send($html);
        
            if(is_null($mail) && !empty($log_email)){
                HP::getUpdateCertifyLogEmail($log_email->id);
            }
       
          }
        }
        public function SET_EMAIL_Request_Documents($certi_cb)
        {

          if(count($certi_cb->DataEmailDirectorCB) > 0){
            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url(''); 

             $data_app =['email'     =>  $certi_cb->email ?? '-',
                        'certi_cb'   =>  $certi_cb ?? ' -',
                        'name'       =>  !empty($certi_cb->name)  ? $certi_cb->name  : '-',
                        'url'        =>  $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                        'email_cc'   =>  (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th'
                        ];

            $email_cc =    (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailDirectorCBCC): 'cb@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                    $certi_cb->id,
                                                    (new CertiCb)->getTable(),
                                                    $certi_cb->id,
                                                    (new CertiCb)->getTable(),
                                                    3,
                                                    'ขอส่งเอกสารเพิ่มเติม',
                                                    view('mail.CB.request_documents', $data_app),
                                                    $certi_cb->created_by,
                                                    $certi_cb->agent_id,
                                                    null,
                                                    $certi_cb->email,
                                                    implode(',',(array)$certi_cb->DataEmailDirectorCB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                 );

               $html = new CBRequestDocumentsMail($data_app);
               $mail =  Mail::to($certi_cb->DataEmailDirectorCB)->send($html);
            
                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }
          }
        }

   //ขอความเห็นแต่งคณะผู้ตรวจประเมินเอกสาร
   public function EditAuditorDocReview($token)
   {
     $previousUrl = app('url')->previous();
     $certi_cb =  CertiCb::where('token',$token)->first();
       $config = HP::getConfig();
                $url  =   !empty($config->url_center) ? $config->url_center : url('');    
     $attach_path = $this->attach_path;//path ไฟล์แนบ
     return view('certify/applicant_cb/form_status.form_status9', compact('previousUrl','certi_cb','attach_path'));
   }

       //ขอความเห็นแต่งคณะผู้ตรวจประเมิน
       public function EditAuditor($token)
       {
         $previousUrl = app('url')->previous();
         $certi_cb =  CertiCb::where('token',$token)->first();
           $config = HP::getConfig();
                    $url  =   !empty($config->url_center) ? $config->url_center : url('');    
         $attach_path = $this->attach_path;//path ไฟล์แนบ
         return view('certify/applicant_cb/form_status.form_status10', compact('previousUrl','certi_cb','attach_path'));
       }


       public function updateAuditor(Request $request,$token = null)
      {
        $data_session     =    HP::CheckSession();
        try{
                $tb = new CertiCBAuditors;
                $certi_cb =  CertiCb::where('token',$token)->first();
                if(!is_null($certi_cb)){
                    $authorities = [];
                    $data = [];

                    foreach ($request->auditors_id as $key => $item){
                        $auditors = CertiCBAuditors::where('id',$item)->orderby('id','desc')->first();
                        if(!is_null($auditors)){

                                $auditors->status = $request->status[$item] ?? null;

                            if($request->status[$item] == 2){
                                $auditors->remark =  $request->remark[$item] ?? null;
                                $auditors->vehicle =  2;
                                $auditors->step_id =  1; //อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน
                            }else{
                                $auditors->remark = null;
                                $auditors->step_id =  3; //เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
                            }

                            $auditors->save();
                            $attachs = [];
                            // ไฟล์แนบ
                            if (isset($request->another_modal_attach_files[$item])){
                                foreach ($request->another_modal_attach_files[$item] as $key => $attach){
                                    if(is_file($attach->getRealPath())){
                                        $certi_cb_attach_more                   = new CertiCBAttachAll();
                                        $certi_cb_attach_more->app_certi_cb_id  = $certi_cb->id;
                                        $certi_cb_attach_more->ref_id           = $auditors->id;
                                        $certi_cb_attach_more->table_name       = $tb->getTable();
                                        $certi_cb_attach_more->file_desc        =  $request->file_desc[$item][$key] ?? null;
                                        $certi_cb_attach_more->file             =   $this->storeFile($attach,$certi_cb->app_no);
                                        $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($attach->getClientOriginalName());
                                        $certi_cb_attach_more->file_section     = '3';
                                        $certi_cb_attach_more->token            = str_random(16);
                                        $certi_cb_attach_more->save();
        
                                        $find                   = new stdClass();
                                        $find->file_desc        = $certi_cb_attach_more->file_desc ?? null;
                                        $find->file             = $certi_cb_attach_more->file ?? null;
                                        $find->file_client_name = $certi_cb_attach_more->file_client_name;
                                        $attachs[]              =  $find;
                                    }
                                }
                            }


                        $CertiCbHistory = CertiCbHistory::where('table_name',$tb->getTable())
                                                            ->where('ref_id',$auditors->id)
                                                            ->where('system',5)
                                                            ->orderby('id','desc')
                                                            ->first();
                            if(!is_null($CertiCbHistory)){
                            $CertiCbHistory->update([
                                                        'details_one'   =>  json_encode($auditors) ?? null,
                                                        'status'        =>  $auditors->status ??  null,
                                                        'attachs_file'  =>  (count($attachs) > 0) ?  json_encode($attachs) : null,
                                                        'updated_by'    =>   auth()->user()->getKey() , 
                                                        'date'          => date('Y-m-d')
                                                    ]);
                            }

                            // pay in ครั้งที่ 1
                        if($auditors->status == 1){
                                $payin =  new CertiCBPayInOne ;
                                $payin->app_certi_cb_id =  $certi_cb->id;
                                $payin->auditors_id = $auditors->id;
                                $payin->save();

                                $std = new stdClass(); // หมายเลขตำขอเห็นชอบ
                                $std->auditor =    $auditors->auditor  ?? null;
                                $data[]       =  $std;
                            }

                            $list = new stdClass();  // หมายเลขตำขอไม่เห็นชอบ
                            $list->auditor      =    $auditors->auditor  ?? null;
                            $list->status       =    $auditors->status  ?? null;
                            $list->created_at   =    $auditors->created_at  ?? null;
                            $list->updated_at   =    $auditors->updated_at  ?? null;
                            $list->remark       =    $auditors->remark ?? null;
                            $list->attachs      =    (count($attachs) > 0) ?  json_encode($attachs) : null;
                            $authorities[]      =    $list;
                        }
                    }

                }
                        $config = HP::getConfig();
                        $url  =   !empty($config->url_center) ? $config->url_center : url('');    
                        if(!is_null($certi_cb->email)&& count($authorities) > 0 && count($certi_cb->DataEmailDirectorCB) > 0){  //  ส่ง E-mail ผก. + เจ้าหน้าที่รับผิดชอบ
        
                            $data_app =['email'        => $certi_cb->email,
                                        'certi_cb'     => $certi_cb,
                                        'auditors'     => $auditors,
                                        'name'         => !empty($certi_cb->name)  ?  $certi_cb->name  : '-',
                                        'authorities'  => count($authorities) > 0 ?  $authorities : '-',
                                        'url'          => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-' ,
                                        'email_cc'     => (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th'
                                        ];
                
                            $email_cc =    (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailDirectorCBCC): 'cb@tisi.mail.go.th' ;
                
                            $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                                    $certi_cb->id,
                                                                    (new CertiCb)->getTable(),
                                                                    $auditors->id,
                                                                    (new CertiCBAuditors)->getTable(),
                                                                    3,
                                                                    'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                                    view('mail.CB.auditors', $data_app),
                                                                    $certi_cb->created_by,
                                                                    $certi_cb->agent_id,
                                                                    null,
                                                                    $certi_cb->email,
                                                                    implode(',',(array)$certi_cb->DataEmailDirectorCB),
                                                                    $email_cc,
                                                                    null,
                                                                    null
                                                                );
                
                            $html = new CBAuditorsMail($data_app);
                            $mail =  Mail::to($certi_cb->DataEmailDirectorCB)->send($html);
                            
                                if(is_null($mail) && !empty($log_email)){
                                    HP::getUpdateCertifyLogEmail($log_email->id);
                                }

                        }

                    if(!is_null($certi_cb->email)  && count($certi_cb->CertiEmailLt) > 0 && count($data) > 0){  //  ส่ง E-mail เจ้าหน้าที ลท. CB   + เจ้าหน้าที่รับผิดชอบ

                            $data_app =['email'        => $certi_cb->email,
                                        'certi_cb'      => $certi_cb,
                                        'auditors'      => $auditors,
                                        'name'          => !empty($certi_cb->name)  ?  $certi_cb->name  : '-',
                                        'authorities'   => count($authorities) > 0 ?  $authorities : '-',
                                        'url'           => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-' ,
                                        'email_cc'      => (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? $certi_cb->DataEmailAndLtCBCC : 'cb@tisi.mail.go.th'
                                    ];
                
                            $email_cc =    (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailAndLtCBCC): 'cb@tisi.mail.go.th' ;
                
                            $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                                    $certi_cb->id,
                                                                    (new CertiCb)->getTable(),
                                                                    $auditors->id,
                                                                    (new CertiCBAuditors)->getTable(),
                                                                    3,
                                                                    'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                                    view('mail.CB.con_firm_auditors', $data_app),
                                                                    $certi_cb->created_by,
                                                                    $certi_cb->agent_id,
                                                                    null,
                                                                    $certi_cb->email,
                                                                    implode(',',(array)$certi_cb->CertiEmailLt),
                                                                    $email_cc,
                                                                    null,
                                                                    null
                                                                );
                
                            $html = new CBConFirmAuditorsMail($data_app);
                            $mail =  Mail::to($certi_cb->CertiEmailLt)->send($html);
                            
                                if(is_null($mail) && !empty($log_email)){
                                    HP::getUpdateCertifyLogEmail($log_email->id);
                                }
        
                        }


                if($request->previousUrl){
                    return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
                }else{
                    return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
                }
            } catch (\Exception $e) {
                return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
            }    

            }
            public function GetCBPayInOne($id = null,$token = null)
            {
                $previousUrl = app('url')->previous();
                $pay_in  =  CertiCBPayInOne::findOrFail($id);
                $attach_path = $this->attach_path;//path ไฟล์แนบ
                return view('certify/applicant_cb/form_status.form_pay_in_one',  compact('previousUrl',
                                                                                            'pay_in',
                                                                                            'attach_path'
                                                                                        ));
            }
            public function CertiCBPayInOne(Request $request, $id){
                // dd($request->all());
                $data_session     =    HP::CheckSession();
            try{
                    $tb = new CertiCBPayInOne;
                    $pay_in  =  CertiCBPayInOne::findOrFail($id);
                    $certi_cb = CertiCb::findOrFail($pay_in->app_certi_cb_id);

                    if(!is_null($pay_in) && isset($request->activity_file)  && $request->hasFile('activity_file')){
                        // ไฟล์แนบ
                        $certi_cb_attach_more                      = new CertiCBAttachAll();
                        $certi_cb_attach_more->app_certi_cb_id     = $certi_cb->id;
                        $certi_cb_attach_more->ref_id              = $pay_in->id;
                        $certi_cb_attach_more->table_name          = $tb->getTable();
                        $certi_cb_attach_more->file                = $this->storeFile($request->activity_file,$certi_cb->app_no);
                        $certi_cb_attach_more->file_client_name    = HP::ConvertCertifyFileName($request->activity_file->getClientOriginalName());
                        $certi_cb_attach_more->file_section        = '2';
                        $certi_cb_attach_more->token               = str_random(16);
                        $certi_cb_attach_more->save();

                        $pay_in->update([
                            'state'=>2,
                            'status'=> null,
                            'remark'=> null
                        ]);


                    // สถานะ แต่งตั้งคณะกรรมการ
                        $auditor = CertiCBAuditors::findOrFail($pay_in->auditors_id);
                        if(!is_null($auditor) && $pay_in->state == 2){
                            $auditor->step_id = 5; // แจ้งหลักฐานการชำระเงิน
                            $auditor->save();
                        }

                    //  Log
                        $CertiCbHistory = CertiCbHistory::where('table_name',$tb->getTable())
                                                                    ->where('ref_id',$pay_in->id)
                                                                    ->where('system',6)
                                                                    ->orderby('id','desc')
                                                                    ->first();
                        if(!is_null($CertiCbHistory)){
                                $CertiCbHistory->update([
                                                        'attachs_file'  =>  $certi_cb_attach_more->file ?? null,
                                                        'evidence'      =>  $certi_cb_attach_more->file_client_name ?? null,
                                                        'updated_by'    =>   auth()->user()->getKey() , 
                                                        'date'          => date('Y-m-d')
                                                        ]);
                            }

                    $config     =   HP::getConfig();
                    $url        =   !empty($config->url_center) ? $config->url_center : url('');    

                    // Mail ลท.
                    if($certi_cb && !is_null($certi_cb->email) && count($certi_cb->CertiEmailLt) > 0){


                            $data_app =[ 'certi_cb'  => $certi_cb ?? '-',
                                        'files'     =>  $certi_cb_attach_more->file ?? null,
                                        'email'     => $certi_cb->email,
                                        'pay_in'    => $pay_in,
                                        'url'       => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                                        'email_cc'  =>  (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? $certi_cb->DataEmailAndLtCBCC : 'cb@tisi.mail.go.th'
                                    ];
            
                            $email_cc =    (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailAndLtCBCC): 'cb@tisi.mail.go.th' ;
            
                            $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no.'-'.@$pay_in->auditors_id,
                                                                $certi_cb->id,
                                                                (new CertiCb)->getTable(),
                                                                $pay_in->id,
                                                                (new CertiCBPayInOne)->getTable(),
                                                                3,
                                                                'แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน',
                                                                view('mail.CB.pay_in1', $data_app),
                                                                $certi_cb->created_by,
                                                                $certi_cb->agent_id,
                                                                null,
                                                                $certi_cb->email,
                                                                implode(',',(array)$certi_cb->CertiEmailLt),
                                                                $email_cc,
                                                                null,
                                                                isset($certi_cb_attach_more->file) ?    'certify/check/file_cb_client/'.$certi_cb_attach_more->file.'/'.$certi_cb_attach_more->file_client_name : null
                                                                );
            
                            $html = new CBPayInOneMail($data_app);
                            $mail =  Mail::to($certi_cb->CertiEmailLt)->send($html);
                        
                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }
                    }

                    if(!empty($certi_cb->app_no) && !empty($pay_in->auditors_id)){
                    //  เช็คการชำระ
                        $arrContextOptions=array();
                        if(strpos($url, 'https')===0){//ถ้าเป็น https
                            $arrContextOptions["ssl"] = array(
                                                            "verify_peer" => false,
                                                            "verify_peer_name" => false,
                                                        );
                        }
                        file_get_contents($url.'api/v1/checkbill?ref1='.$certi_cb->app_no.'-'.$pay_in->auditors_id, false, stream_context_create($arrContextOptions));
                    }

                }
                return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
            } catch (\Exception $e) {
                return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
            }    
            }

            public function EditInspectiont($id = null,$token = null)
            {
                $previousUrl = app('url')->previous();
                $assessment = CertiCBSaveAssessment::findOrFail($id);
                $certi_cb =  CertiCb::findOrFail($assessment->app_certi_cb_id);
                $attach_path = $this->attach_path;//path ไฟล์แนบ
                return view('certify/applicant_cb/form_status.form_status15', compact('previousUrl','certi_cb','assessment','attach_path'));
            }
            public function UpdateInspectiont(Request $request, $id)
            {
                $data_session     =    HP::CheckSession();
                try{   
                    $assessment = CertiCBSaveAssessment::findOrFail($id);
                    $certi_cb = CertiCb::findOrFail($assessment->app_certi_cb_id);

                    $committee = CertiCBAuditors::findOrFail($assessment->auditors_id);

                    $ao = new CertiCBSaveAssessment;
                    if(!is_null($assessment)){

                        if($request->status_scope == 1){  // update สถานะ

                            CertiCBAttachAll::where('table_name',$ao->getTable())
                                                ->where('file_section',6)
                                                ->where('ref_id',$assessment->id)
                                                ->delete();
                            $assessment->details = null;
                            $assessment->status = 1;
                            $assessment->degree = 7;
                            $assessment->save();

                            // สถานะ แต่งตั้งคณะกรรมการ
                            $committee->step_id = 10; //ยืนยัน Scope
                            $committee->save();

                        // สถานะ แต่งตั้งคณะกรรมการ
                            $auditor = CertiCBAuditors::where('app_certi_cb_id',$certi_cb->id)
                                                        ->whereIn('step_id',[9,10])
                                                        ->whereNull('is_review_state')
                                                        ->whereNull('status_cancel')
                                                        ->get();

                            if(count($auditor) == count($certi_cb->CertiAuditorsMany)){
                                $report = new   CertiCBReview;  //ทบทวนฯ
                                $report->app_certi_cb_id  = $certi_cb->id;
                                $report->save();
                                $certi_cb->update(['review'=>1,'status'=>11]);  // ทบทวน
                            }

                        }else{
                            $assessment->date_scope_edit = date('Y-m-d h:m:s');
                            $assessment->status         = 2;
                            $assessment->degree         = 5;
                            $assessment->details        = $request->details ?? null;
                            $assessment->save();
                            $certi_cb->update(['status'=>10]);  // อยู่ระหว่างดำเนินการ
                            // ไฟล์แนบ
                            if($request->attach_files  && $request->hasFile('attach_files')){
                                CertiCBAttachAll::where('table_name',$ao->getTable())
                                                ->where('file_section',6)
                                                ->where('ref_id',$assessment->id)
                                                ->delete();
                                foreach ($request->attach_files as $index => $item){
                                        $certi_cb_attach_more = new CertiCBAttachAll();
                                        $certi_cb_attach_more->app_certi_cb_id  = $assessment->app_certi_cb_id ?? null;
                                        $certi_cb_attach_more->ref_id           = $assessment->id;
                                        $certi_cb_attach_more->table_name       = $ao->getTable();
                                        $certi_cb_attach_more->file_desc        = $request->file_desc_text[$index] ?? null;
                                        $certi_cb_attach_more->file             = $this->storeFile($item,$certi_cb->app_no);
                                        $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                                        $certi_cb_attach_more->file_section     = '6';
                                        $certi_cb_attach_more->token            = str_random(16);
                                        $certi_cb_attach_more->save();
                                }
                            }

                            $committee->step_id = 11; // ขอแก้ไข Scope
                            $committee->save();
                        }


                        //Log
                        $CertiCbHistory = CertiCbHistory::where('table_name',$ao->getTable())
                                                                    ->where('ref_id',$assessment->id)
                                                                    ->where('system',8)
                                                                    ->orderby('id','desc')
                                                                    ->first();
                        if(!is_null($CertiCbHistory)){
                            $CertiCbHistory->update([
                                                        'status'         =>  $assessment->status  ??  null,
                                                            'remark'        =>  $assessment->details  ??  null,
                                                            'attachs_file'  =>  (count($assessment->FileAttachAssessment6Many) > 0) ? json_encode($assessment->FileAttachAssessment6Many) : null,
                                                            'updated_by'    =>   auth()->user()->getKey() ,
                                                            'date'          =>  date('Y-m-d')
                                                    ]);
                        }

                        //Mail
                        if($certi_cb && !is_null($certi_cb->email) && count($certi_cb->DataEmailDirectorCB) > 0 ){

                            $config = HP::getConfig();
                            $url  =   !empty($config->url_center) ? $config->url_center : url('');    

                            $data_app =['certi_cb'     => $certi_cb ?? '-',
                                        'email'         => $certi_cb->email,
                                        'assessment'    => $assessment,
                                        'url'           => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                                        'email_cc'      => count($certi_cb->DataEmailDirectorCBCC) > 0  ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th'
                                        ];
            
                            $email_cc =    (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailDirectorCBCC): 'cb@tisi.mail.go.th' ;
            
                            $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                                $certi_cb->id,
                                                                (new CertiCb)->getTable(),
                                                                $assessment->id,
                                                                (new CertiCBSaveAssessment)->getTable(),
                                                                3,
                                                                'ยืนยันขอบข่ายการรับรองหน่วยรับรอง',
                                                                view('mail.CB.inspectiont', $data_app),
                                                                $certi_cb->created_by,
                                                                $certi_cb->agent_id,
                                                                null,
                                                                $certi_cb->email,
                                                                implode(',',(array)$certi_cb->DataEmailDirectorCB),
                                                                $email_cc,
                                                                null,
                                                                null
                                                                );
            
                            $html = new CBInspectiontMail($data_app);
                            $mail =  Mail::to($certi_cb->DataEmailDirectorCB)->send($html);
                        
                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }

                        }


                        }
                        return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
                } catch (\Exception $e) {
                        return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                } 
      }

            // แก้ไขข้อบกพร่อง/ข้อสังเกต
    public function EditAssessment($id = null,$token = null)
    {
        $previousUrl = app('url')->previous();
        $assessment = CertiCBSaveAssessment::findOrFail($id);
        $certi_cb =  CertiCb::findOrFail($assessment->app_certi_cb_id);
        $attach_path = $this->attach_path;//path ไฟล์แนบ
       return view('certify/applicant_cb/form_status.form_status16', compact('previousUrl','certi_cb','assessment','attach_path'));
     }
     public function UpdateAssessment(Request $request, $id){

        $data_session     =    HP::CheckSession();
        $assessment       =    CertiCBSaveAssessment::findOrFail($id);
        $certi_cb         =    CertiCb::findOrFail($assessment->app_certi_cb_id);
        $tb               =    new CertiCBSaveAssessment;

  try {
              $assessment->update(['degree'=>2]);
              $requestData = $request->all();

               if(isset($requestData["detail"]) ){
                  $detail = (array)$requestData["detail"];
                  foreach ($detail['id'] as $key => $item) {
                          $bug = CertiCBSaveAssessmentBug::where('id',$item)->first();
                          $bug->details = $detail["details"][$key] ?? $bug->details;
                            $assessment->check_file = 'false';
                      if($request->attachs  && $request->hasFile('attachs')){
                           $bug->attachs            =  array_key_exists($key, $request->attachs) ?  $this->storeFile($request->attachs[$key],$certi_cb->app_no) : @$bug->attachs;
                           $bug->attach_client_name =  array_key_exists($key, $request->attachs) ?  HP::ConvertCertifyFileName($request->attachs[$key]->getClientOriginalName())  : @$bug->attach_client_name;
                           $assessment->check_file  = 'true';
                       }
                          $bug->save();
                  }
               }
                $CertiCbHistory = CertiCbHistory::where('table_name',$tb->getTable())
                                                                   ->where('ref_id',$id)
                                                                   ->where('system',7)
                                                                    ->orderby('id','desc')
                                                                   ->first();

                  $bug = CertiCBSaveAssessmentBug::select('report','remark','no','type','reporter_id','details','status','comment','file_status','file_comment','attachs','attach_client_name')
                                                  ->where('assessment_id',$id)
                                                  ->get()
                                                  ->toArray();
                  if(!is_null($CertiCbHistory)){
                          $CertiCbHistory->update([
                                                      'details_two'=>  (count($bug) > 0) ? json_encode($bug) : null,
                                                      'updated_by' =>   auth()->user()->getKey() ,
                                                      'date'       =>  date('Y-m-d')
                                                   ]);
                   }

 
                    if($certi_cb && !is_null($certi_cb->email) && count($certi_cb->DataEmailDirectorCB) > 0){

                        $config = HP::getConfig();
                        $url  =   !empty($config->url_center) ? $config->url_center : url('');    
        
                         $data_app =[   'certi_cb'   => $certi_cb ?? '-',
                                        'email'      => $certi_cb->email,
                                        'assessment' => $assessment,
                                        'url'        => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                                        'email_cc'   => count($certi_cb->DataEmailDirectorCBCC) > 0  ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th'
                                  ];
         
                         $email_cc =    (count($certi_cb->DataEmailDirectorCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailDirectorCBCC): 'cb@tisi.mail.go.th' ;
         
                         $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                             $certi_cb->id,
                                                             (new CertiCb)->getTable(),
                                                             $assessment->id,
                                                             (new CertiCBSaveAssessment)->getTable(),
                                                             3,
                                                             'แจ้งแนวทางแก้ไข/ส่งหลักฐานการแก้ไขข้อบกพร่อง',
                                                             view('mail.CB.assessment', $data_app),
                                                             $certi_cb->created_by,
                                                             $certi_cb->agent_id,
                                                             null,
                                                             $certi_cb->email,
                                                             implode(',',(array)$certi_cb->DataEmailDirectorCB),
                                                             $email_cc,
                                                             null,
                                                             null
                                                             );
         
                         $html = new CBSaveAssessmentMail($data_app);
                         $mail =  Mail::to($certi_cb->DataEmailDirectorCB)->send($html);
                     
                         if(is_null($mail) && !empty($log_email)){
                             HP::getUpdateCertifyLogEmail($log_email->id);
                         }
                     }
       return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
    } catch (\Exception $e) {
    //    return redirect('certify/applicant-cb/assessment/'.$assessment->id.'/'.$certi_cb->token)->with('message', 'เกิดข้อผิดพลาด!');
       return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    }
  }

    // รอยืนยันคำขอ
     public function UpdateReport(Request $request, $id)
     {
        $data_session     =    HP::CheckSession();

         if(isset($request->status_confirm)){
            $report = CertiCBReport::findOrFail($id);
            $certi_cb = CertiCb::findOrFail($report->app_certi_cb_id);
            $report->update(['status_confirm'=>1,
                             'start_date' => date('Y-m-d'),
                             'updated_by'=>  auth()->user()->getKey() 
                            ]);
                if($request->cf_cer==1){
                    $report->update(['cf_cer'=>1]);
                }
            $certi_cb->update(['status'=>14]); //ยืนยันจัดทำใบรับรอง
            //Log
            $tb = new CertiCBReport;
            $CertiCbHistory = CertiCbHistory::where('table_name',$tb->getTable())
                                                    ->where('ref_id',$report->id)
                                                    ->where('system',9)
                                                    ->orderby('id','desc')
                                                    ->first();

         if(!is_null($CertiCbHistory)){
              $CertiCbHistory->update([
                                          'status_scope'    => $request->status_confirm ?? null,
                                          'updated_by'      => auth()->user()->getKey() , 
                                          'date'            => date('Y-m-d')
                                        ]);
          }

          $PayIn = new CertiCBPayInTwo;
          $PayIn->app_certi_cb_id = $certi_cb->id;
          $PayIn->save();

          //  Mail แจ้งเตือน ผก. + ลท.    
          if($certi_cb && !is_null($certi_cb->email) && count($certi_cb->CertiEmailLt) > 0 ){

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');    

             $data_app =['certi_cb' => $certi_cb ,
                        'email'     => $certi_cb->email,
                        'url'       => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                        'email_cc'  => count($certi_cb->DataEmailAndLtCBCC) > 0  ? $certi_cb->DataEmailAndLtCBCC : 'cb@tisi.mail.go.th'
                        ];

             $email_cc =    (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailAndLtCBCC): 'cb@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                        $certi_cb->id,
                                                        (new CertiCb)->getTable(),
                                                        $report->id,
                                                        (new CertiCBReport)->getTable(),
                                                        3,
                                                        'ยืนยันสรุปรายงานเสนอคณะกรรมการ/คณะอนุกรรมการ',
                                                        view('mail.CB.report', $data_app),
                                                        $certi_cb->created_by,
                                                        $certi_cb->agent_id,
                                                        null,
                                                        $certi_cb->email,
                                                        implode(',',(array)$certi_cb->CertiEmailLt),
                                                        $email_cc,
                                                        null,
                                                        null
                                                   );

             $html = new CBReportMail($data_app);
             $mail =  Mail::to($certi_cb->CertiEmailLt)->send($html);
         
             if(is_null($mail) && !empty($log_email)){
                 HP::getUpdateCertifyLogEmail($log_email->id);
             }
 
           }
         }
        return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
    }

    

    public function UpdatePayInTwo(Request $request, $id)
    {
        $data_session     =    HP::CheckSession();
    try {
        $PayIn = CertiCBPayInTwo::findOrFail($id);
        $certi_cb = CertiCb::findOrFail($PayIn->app_certi_cb_id);
       $tb = new CertiCBPayInTwo;
       $attach_path = $this->attach_path;

       if($request->attach  && $request->hasFile('attach')){
           $certi_cb_attach_more                    = new CertiCBAttachAll();
           $certi_cb_attach_more->app_certi_cb_id   = $certi_cb->id;
           $certi_cb_attach_more->ref_id            = $PayIn->id;
           $certi_cb_attach_more->table_name        = $tb->getTable();
           $certi_cb_attach_more->file              = $this->storeFile($request->attach,$certi_cb->app_no);
           $certi_cb_attach_more->file_client_name  = HP::ConvertCertifyFileName($request->attach->getClientOriginalName());
           $certi_cb_attach_more->file_section      = '2';
           $certi_cb_attach_more->token             = str_random(16);
           $certi_cb_attach_more->save();

           $attach           = $certi_cb_attach_more->file;
           $file_client_name = $certi_cb_attach_more->file_client_name;
           if( HP::checkFileStorage($attach_path.$attach)){
               HP::getFileStorage($attach_path.$attach);
           }
       }
 
       $PayIn->degree = 2 ; 
       $PayIn->status = null ; 
       $PayIn->detail = null ; 
       $PayIn->save();

       $certi_cb->status = 16 ; //แจ้งหลักฐานการชำระค่าใบรับรอง
       $certi_cb->save();
 

        $CertiCbHistory = CertiCbHistory::where('table_name',$tb->getTable())
                                                   ->where('ref_id',$PayIn->id)
                                                   ->where('system',10)
                                                   ->orderby('id','desc')
                                                   ->first();

         if(!is_null($CertiCbHistory)){
             $CertiCbHistory->update([
                                         'attachs_file' =>  isset($attach) ?  $attach : null,
                                         'evidence'     =>  isset($file_client_name) ?  $file_client_name : null,
                                         'updated_by'   =>  auth()->user()->getKey() ,
                                         'date'         =>  date('Y-m-d')
                                       ]);
         }

         $config = HP::getConfig();
         $url  =   !empty($config->url_center) ? $config->url_center : url('');    

        // Mail
         if(count($certi_cb->CertiEmailLt) > 0){
             $data_app =[
                        'certi_cb'  => $certi_cb ,
                        'attach'    => isset($attach) ?  $attach : '',
                        'PayIn'     => $PayIn,
                        'email'     => $certi_cb->email,
                        'url'       => $url.'/certify/check_certificate-cb/'.$certi_cb->token ?? '-',
                        'email_cc'  =>  (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? $certi_cb->DataEmailAndLtCBCC : 'cb@tisi.mail.go.th'
                        ];

             $email_cc =    (count($certi_cb->DataEmailAndLtCBCC) > 0 ) ? implode(',', $certi_cb->DataEmailAndLtCBCC): 'cb@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                        $certi_cb->id,
                                                        (new CertiCb)->getTable(),
                                                        $PayIn->id,
                                                        (new CertiCBPayInTwo)->getTable(),
                                                        3,
                                                        'แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง',
                                                        view('mail.CB.pay_in_two', $data_app),
                                                        $certi_cb->created_by,
                                                        $certi_cb->agent_id,
                                                        null,
                                                        $certi_cb->email,
                                                        implode(',',(array)$certi_cb->CertiEmailLt),
                                                        $email_cc,
                                                        null,
                                                        null
                                                   );

             $html = new CBPayInTwoMail($data_app);
             $mail =  Mail::to($certi_cb->CertiEmailLt)->send($html);
         
             if(is_null($mail) && !empty($log_email)){
                 HP::getUpdateCertifyLogEmail($log_email->id);
             }

        }

        
        if(!empty($certi_cb->app_no)){
                //  เช็คการชำระ
            $arrContextOptions=array();
            if(strpos($url, 'https')===0){//ถ้าเป็น https
                $arrContextOptions["ssl"] = array(
                                                "verify_peer" => false,
                                                "verify_peer_name" => false,
                                            );
            }
            file_get_contents($url.'api/v1/checkbill?ref1='.$certi_cb->app_no, false, stream_context_create($arrContextOptions));
        }

       return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
    } catch (\Exception $e) {
        return redirect('certify/applicant-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    } 
   }

   public function abilityConfirm(Request $request)
   {
    // dd($request->all());
    CertiCBReport::where('app_certi_cb_id',$request->id)->first()->update([
        'ability_confirm' => 1
    ]);
   }

        //log
        public function DataLogCB($token)
        {
        $previousUrl = app('url')->previous();
        $certi_cb = CertiCb::where('token',$token)->first();

        // ประวัติคำขอ
        $history  =  CertiCbHistory::where('app_certi_cb_id',$certi_cb->id)
                                    ->whereNotIN('system',[11])
                                    ->orderby('id','desc')
                                    ->get();
        $attach_path = $this->attach_path;
        return view('certify/applicant_cb.log',['certi_cb'=>$certi_cb,
                                                'history' => $history,
                                                'attach_path' => $attach_path,
                                                'previousUrl' => $previousUrl
                                                ]);
        }

        public function draft_pdf($certicb_id = null)
        {

            if(!is_null($certicb_id)){

                    $CertiCb = CertiCb::findOrFail($certicb_id);

                    $file = CertiCBFileAll::where('state',1)
                                            ->where('app_certi_cb_id',$certicb_id)
                                            ->first();      
                    if($certicb_id == 21){
                        $certicb_id = 7;
                    }
        
                    // return $certi_id;
                     $formula = Formula::where('id', 'like', $CertiCb->type_standard)
                                            ->whereState(1)->first();
                    
                    // if(!is_null($file) && !is_null($file->attach_pdf) ){
                 
                         $url  =   url('/certify/check_files_cb/'. rtrim(strtr(base64_encode($certicb_id), '+/', '-_'), '=') );
                        //ข้อมูลภาพ QR Code
                         $image_qr = QrCode::format('png')->merge('plugins/images/tisi.png', 0.2, true)
                                      ->size(500)->errorCorrection('H')
                                      ->generate($url);
        
                    // }

                $last   = CertiCBExport::where('type_standard',$CertiCb->type_standard)->whereYear('created_at',Carbon::now())->count() + 1;
          
                $lab_type = ['1'=>'Testing','2'=>'Cal','3'=>'IB','4'=>'CB'];
                $accreditation_no = '';
                if(array_key_exists("4",$lab_type)){
                    $accreditation_no .=  $lab_type[4].'-';
                }
                if(!is_null($CertiCb->app_no)){
                    $app_no = explode('-', $CertiCb->app_no);
                    $accreditation_no .= $app_no[2].'-';
                }
                if(!is_null($last)){
                    $accreditation_no .=  str_pad($last, 3, '0', STR_PAD_LEFT).'-'.(date('Y') +543);
                }

                    $CertiCb->accreditation_no  =   $accreditation_no ? $accreditation_no : null;
                  
                    $data_export = [
                        'app_no'             => $CertiCb->app_no,
                        'name'               => !empty($CertiCb->name) ? $CertiCb->name : null,
                        'name_en'            =>  isset($CertiCb->name_standard_en) ?  '('.$CertiCb->name_standard_en.')' : '&emsp;', 
                        'lab_name_font_size' => $this->CalFontSize($CertiCb->name_standard),
                        'certificate'        => $CertiCb->certificate,
                        'name_unit'          => $CertiCb->name_unit,
                        'address'            => $this->FormatAddress($CertiCb),
                        'lab_name_font_size_address' => $this->CalFontSize($this->FormatAddress($CertiCb)),
                        'address_en'         => $this->FormatAddressEn($CertiCb),
                        'formula'            => $CertiCb->formula,
                        'formula_en'         =>  isset($CertiCb->formula_en) ?   $CertiCb->formula_en : '&emsp;', 
                        'accreditation_no'   => $CertiCb->accreditation_no,
                        'accreditation_no_en'   => $CertiCb->accreditation_no_en,
                        'date_start'         =>  !empty($CertiCb->date_start)? HP::convertDate($CertiCb->date_start,true) : null,
                        'date_end'           => !empty($CertiCb->date_end)? HP::convertDate($CertiCb->date_end,true) : null,
                        'date_start_en'      => !empty($CertiCb->date_start) ? HP::formatDateENertify(HP::convertDate($CertiCb->date_start,true)) : null ,
                        'date_end_en'        => !empty($CertiCb->date_end) ? HP::formatDateENFull($CertiCb->date_end) : null ,
                        'formula_title'      => !empty($CertiCb->FormulaTo->title) ? $CertiCb->FormulaTo->title : null,
                        'formula_title_en'      => !empty($CertiCb->FormulaTo->title_en) ? $CertiCb->FormulaTo->title_en : null,
                        'name_standard'      => !empty($CertiCb->name_standard) ? $CertiCb->name_standard : null,
                        'check_badge'        => isset($CertiCb->check_badge) ? $CertiCb->check_badge : null,
                        'image_qr'           => isset($image_qr) ? $image_qr : null,
                        'url'                => isset($url) ? $url : null,
                        'attach_pdf'         => isset($file->attach_pdf) ? $file->attach_pdf : null ,
                        'condition_th'       => !empty($formula->condition_th ) ? $formula->condition_th  : null ,
                        'condition_en'       => !empty($formula->condition_en ) ? $formula->condition_en  : null ,
                        'imagery'            =>  !empty($CertiCb->CertiCBFormulasTo->imagery) ?  $CertiCb->CertiCBFormulasTo->imagery : '-',
                        'image'              =>  !empty($CertiCb->CertiCBFormulasTo->image) ?  $CertiCb->CertiCBFormulasTo->image : '-',
                        'lab_name_font_size_condition' => !empty($formula->condition_th) ? $this->CalFontSizeCondition($formula->condition_th)  : '11',
                        'branch_th'          =>  !empty($CertiCb->certification_branch->title) ?  $CertiCb->certification_branch->title : '',
                        'branch_en'          =>  !empty($CertiCb->certification_branch->title_en) ?  '('.$CertiCb->certification_branch->title_en.')' : '',
                        'type_standard'      =>  $formula->id ?? null
                       ];

                        $config = ['instanceConfigurator' => function ($mpdf) {
                            $mpdf->SetWatermarkText('DRAFT');
                            $mpdf->watermark_font = 'DejaVuSansCondensed';
                            $mpdf->showWatermarkText = true;
                            $mpdf->watermarkTextAlpha = 0.12;
                        }];
         
                  $pdf = Pdf::loadView('certify/applicant_cb/pdf/draft-thai', $data_export, [], $config);
                  return $pdf->stream("certificatecb-thai.pdf");
           
            }

            abort(403);
           
        }

     //คำนวนขนาดฟอนต์ของชื่อหน่วยงานผู้ได้รับรอง
     private function CalFontSize($certificate_for){
        $alphas = array_combine(range('A', 'Z'), range('a', 'z'));
        $thais = array('ก','ข', 'ฃ', 'ค', 'ฅ', 'ฆ','ง','จ','ฉ','ช','ซ','ฌ','ญ', 'ฎ', 'ฏ', 'ฐ','ฑ','ฒ'
        ,'ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ','พ','ฟ','ภ','ม','ย','ร','ล'
        ,'ว','ศ','ษ','ส','ห','ฬ','อ','ฮ', 'ำ', 'า', 'แ');

                if(function_exists('mb_str_split')){
                $chars = mb_str_split($certificate_for);
                }else if(function_exists('preg_split')){
                $chars = preg_split('/(?<!^)(?!$)/u', $certificate_for);
                }

                $i = 0;
                foreach ($chars as $char) {
                    if(in_array($char, $alphas) || in_array($char, $thais)){
                        $i++;
                    }
                }

                // if($i>40 && $i<50){
                //     $font = 12;
                // }  else if($i>50 && $i<60){
                //     $font = 11;
                // }  else if($i>60 && $i<70){
                //     $font = 10;
                // }  else if($i>70 && $i<80){
                //     $font = 9;
                // }  else if($i>80 && $i<90){
                //     $font = 8;
                // }  else if($i>90 && $i<100){
                //     $font = 7;
                // }  else if($i>100 && $i<120){
                //     $font = 6;
                // }  else if($i>120 && $i<130){
                //     $font = 5;
                // }  else if($i>130){
                //     $font = 4;
                // }   else{
                //     $font = 12;
                // }

                if($i>60 && $i<70){
                    $font = 10;
                }  else if($i>70 && $i<80){
                    $font = 9;
                }  else if($i>80 && $i<90){
                    $font = 8;
                }  else if($i>90 && $i<100){
                    $font = 7;
                }  else if($i>100 && $i<120){
                    $font = 6;
                }  else if($i>120){
                    $font = 5;
                }  else{
                    $font = 11;
                }


                return $font;

            }

     private function CalFontSizeCondition($certificate_for){
        $alphas = array_combine(range('A', 'Z'), range('a', 'z'));
        $thais = array('ก','ข', 'ฃ', 'ค', 'ฅ', 'ฆ','ง','จ','ฉ','ช','ซ','ฌ','ญ', 'ฎ', 'ฏ', 'ฐ','ฑ','ฒ'
        ,'ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ','พ','ฟ','ภ','ม','ย','ร','ล'
        ,'ว','ศ','ษ','ส','ห','ฬ','อ','ฮ', 'ำ', 'า', 'แ');

                if(function_exists('mb_str_split')){
                $chars = mb_str_split($certificate_for);
                }else if(function_exists('preg_split')){
                $chars = preg_split('/(?<!^)(?!$)/u', $certificate_for);
                }

                $i = 0;
                foreach ($chars as $char) {
                    if(in_array($char, $alphas) || in_array($char, $thais)){
                        $i++;
                    }
                }

                if($i>60 && $i<70){
                    $font = 10;
                }  else if($i>70 && $i<80){
                    $font = 9;
                }  else if($i>80 && $i<90){
                    $font = 8;
                }  else if($i>90 && $i<100){
                    $font = 7;
                }  else if($i>100 && $i<120){
                    $font = 6;
                }  else if($i>120 && $i<130){
                    $font = 5;
                }  else if($i>130){
                    $font = 4;
                }  else{
                    $font = 11;
                }
                return $font;

         }


    private function FormatAddress($request){

        $address   = '';
        $address .= $request->address;

        if($request->allay!=''){
          $address .=  " หมู่ที่ " . $request->allay;
        }

        if($request->village_no!='' && $request->village_no !='-'  && $request->village_no !='--'){
          $address .=  " ซอย "  . $request->village_no;
        }

        if($request->road!='' && $request->road !='-'  && $request->road !='--'){
          $address .=  " ถนน ".$request->road;
        }

        if($request->district_id!=''){
            if(trim($request->BasicProvince->PROVINCE_NAME)=='กรุงเทพมหานคร'){
                $address .= " แขวง".$request->district_id;
            }else{
                $address .= " ตำบล".$request->district_id;

            }
        }

        if($request->amphur_id!=''){
            if(trim($request->BasicProvince->PROVINCE_NAME)=='กรุงเทพมหานคร'){
                $address .= " เขต".$request->amphur_id;
            }else{
                $address .= " อำเภอ".$request->amphur_id;
            }
        }

        if($request->province_id!=''){
            if(trim($request->BasicProvince->PROVINCE_NAME)=='กรุงเทพมหานคร'){
                $address .=  " ".trim($request->BasicProvince->PROVINCE_NAME);
            }else{
                $address .=  " จังหวัด".trim($request->BasicProvince->PROVINCE_NAME);
            }
        }

        return $address;
        
    }

    
    private function FormatAddressEn($request){
        $address   = [];
        $address[] = $request->cb_address_no_eng;

        if($request->cb_moo_eng!=''){
          $address[] =    'Moo '.$request->cb_moo_eng;
        }

        if($request->cb_soi_eng!='' && $request->cb_soi_eng !='-'  && $request->cb_soi_eng !='--'){
          $address[] =   $request->cb_soi_eng;
        }
        if($request->cb_street_eng!='' && $request->cb_street_eng !='-'  && $request->cb_street_eng !='--'){
            $address[] =   $request->cb_street_eng.',';
        }
        if($request->cb_district_eng!='' && $request->cb_district_eng !='-'  && $request->cb_district_eng !='--'){
            $address[] =   $request->cb_district_eng.',';
        }
        if($request->cb_amphur_eng!='' && $request->cb_amphur_eng !='-'  && $request->cb_amphur_eng !='--'){
            $address[] =   $request->cb_amphur_eng.',';
        }
        if($request->cb_province_eng!='' && $request->cb_province_eng !='-'  && $request->cb_province_eng !='--'){
            $address[] =   $request->cb_province_eng;
        }
        if($request->cb_postcode_eng!='' && $request->cb_postcode_eng !='-'  && $request->cb_postcode_eng !='--'){
            $address[] =   $request->cb_postcode_eng;
        }
        return implode(' ', $address);
    }

    public function get_app_no_and_certificate_exports_no(Request $request)
    {
        $data_session           = HP::CheckSession();
        $type_standard = $request->input('std_id');
        
        try {
            $app_certi_cb         = CertiCb::with([
                                                    'app_certi_cb_export' => function($q){
                                                        // $q->where('status', 3);
                                                        $q->whereIn('status',['0','1','2','3','4']);
                                                    }
                                                ])
                                                ->where( function($Query) use($data_session){
                                                    if(!is_null($data_session->agent_id)){  // ตัวแทน
                                                        $Query->where('agent_id',  $data_session->agent_id ) ;
                                                    }else{
                                                        if($data_session->branch_type == 1){  // สำนักงานใหญ่
                                                            $Query->where('tax_id',  $data_session->tax_number ) ;
                                                        }else{   // ผู้บันทึก
                                                            $Query->where('created_by', auth()->user()->getKey()) ;
                                                        }
                                                    }
                                                })
                                                ->whereNotIn('status', [0, 4])
                                                ->where('type_standard', $type_standard)
                                                ->first();
            $data = array(
                'status' => true,
                'app_no' => $app_certi_cb->app_no ?? null,
                'certificate_exports_no' => $app_certi_cb->app_certi_cb_export->certificate ?? null
            );
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'satus' => false,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    private function save_certicb_export_mapreq($certi_cb)
    {
          $app_certi_cb             = CertiCb::with([
                                                    'app_certi_cb_export' => function($q){
                                                        $q->whereIn('status',['0','1','2','3','4']);
                                                    }
                                                ])
                                                ->where('created_by', $certi_cb->created_by)
                                                ->whereNotIn('status', ['0','4'])
                                                ->where('type_standard', $certi_cb->type_standard)
                                                ->first();
         if(!Is_null($app_certi_cb)){
             $certificate_exports_id = !empty($app_certi_cb->app_certi_cb_export->id) ? $app_certi_cb->app_certi_cb_export->id : null;
              if(!Is_null($certificate_exports_id)){
                       $mapreq =  CertiCbExportMapreq::where('app_certi_cb_id',$certi_cb->id)->where('certificate_exports_id', $certificate_exports_id)->first();
                       if(Is_null($mapreq)){
                           $mapreq = new  CertiCbExportMapreq;
                       }
                       $mapreq->app_certi_cb_id       = $certi_cb->id;
                       $mapreq->certificate_exports_id = $certificate_exports_id;
                       $mapreq->save();
              }
         }
    }
    
    
    public function ConfirmBug(Request $request)
    {
      // dd($request->all());
      $notice = CertiCBSaveAssessment::find($request->assessment_id)->update([
          'accept_fault' => 1
      ]);
      return response()->json($notice);
    }

    public function getCbDocReviewAuditor(Request $request)
    {
        
        $cbDocReviewAuditor = CbDocReviewAuditor::where('app_certi_cb_id',$request->certiCbId)->first();
        // dd($cbDocReviewAuditor);
        return response()->json([
            'cbDocReviewAuditors' => json_decode($cbDocReviewAuditor->auditors, true),
        ]);
    }
}
