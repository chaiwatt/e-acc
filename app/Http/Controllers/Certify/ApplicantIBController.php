<?php

namespace App\Http\Controllers\Certify;

use HP;
use App\User;

use stdClass;
use Carbon\Carbon;
use App\applicantIB;
use App\Http\Requests;
use App\Mail\IB\IBCostMail; 
use App\Models\Basic\Amphur;
use App\Models\Esurv\Trader;
use Illuminate\Http\Request;
use App\Models\Basic\Zipcode;
use App\Mail\IB\IBReportMail; 

use App\Models\Basic\District;
use App\Models\Basic\Province;

use App\Mail\IB\IBAuditorsMail; 
use App\Mail\IB\IBPayInOneMail; 

use App\Mail\IB\IBPayInTwoMail; 
use App\Models\Bcertify\Formula;
use App\Mail\IB\IBApplicantMail; 

use App\Mail\Lab\NotifyTransferer;
use App\Services\CreateIbScopePdf;
use Illuminate\Support\Facades\DB;
use App\Mail\IB\IBInspectiontMail; 
use App\Http\Controllers\Controller;
use App\Mail\Lab\NotifyIBTransferer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; 
use App\Mail\IB\IBSaveAssessmentMail; 

use Illuminate\Support\Facades\Storage;
use App\Mail\IB\IBConFirmAuditorsMail;  

use App\Mail\IB\IBRequestDocumentsMail; 
use App\Models\Certificate\IbScopeTopic;
use App\Models\Certificate\IbScopeDetail;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Certify\ApplicantIB\CertiIb; 
use App\Models\Certify\SendCertificateLists;
use App\Models\Certificate\IbDocReviewAuditor;
use App\Models\Certificate\IbScopeTransaction;
use App\Models\Certificate\IbSubCategoryScope;
use App\Models\Certificate\IbMainCategoryScope;
use App\Models\Certify\ApplicantIB\CertiIBCost; 

use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;
use App\Models\Certify\ApplicantIB\CertiIBReview;
use App\Models\Certify\ApplicantIB\CertiIBFileAll;
use App\Models\Certify\ApplicantIB\CertiIBReport; 
use App\Models\Certify\ApplicantIB\CertiIBAuditors;
use App\Models\Certify\ApplicantIB\CertiIBCostItem;
use App\Models\Certify\ApplicantIB\CertiIbHistory; 
use App\Models\Certify\ApplicantIB\CertiIBPayInTwo;
use App\Models\Certificate\TrackingDocReviewAuditor;
use App\Models\Certify\ApplicantIB\CertiIBPayInOne; 
use App\Models\Certify\ApplicantIB\CertiIBAttachAll; 
use App\Models\Certify\ApplicantIB\CertiIbExportMapreq;
use App\Models\Certify\ApplicantIB\CertiIBSaveAssessment; 
use App\Models\Certify\ApplicantIB\CertiIBSaveAssessmentBug;

class ApplicantIBController extends Controller
{
        private $attach_path;//ที่เก็บไฟล์แนบ
    public function __construct()
    {
        // $this->middleware('auth');
        $this->attach_path = 'files/applicants/check_files_ib/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {

        $model = str_slug('applicantibs','-');
        $data_session     =    HP::CheckSession();

        // dd($data_session);
       if(!empty($data_session)){
        if(HP::CheckPermission('view-'.$model)){
            $filter = [];
            $filter['filter_status'] = $request->get('filter_status', '');
            $filter['filter_search'] = $request->get('filter_search', '');
            $filter['perPage'] = $request->get('perPage', 10);

            $Query = new CertiIb;
            if ($filter['filter_status']!='') {
                $Query = $Query->where('status', $filter['filter_status']);
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

            $certiIbs =  $Query->orderby('id','desc')
                               ->sortable()
                               ->paginate($filter['perPage']);

                            //    dd($certiIbs);

            return view('certify.applicant_ib.index', compact('certiIbs','filter'));
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
 
       $model = str_slug('applicantibs','-');
       $data_session     =    HP::CheckSession();
       if(!empty($data_session)){
           if(HP::CheckPermission('add-'.$model)){
            $previousUrl = app('url')->previous();

            $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
            $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();
            $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';
            $data_session->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
            $data_session->AMPHUR_ID    =    $data_session->district ?? '';
            $data_session->DISTRICT_ID  =     $data_session->subdistrict ?? '';

            $certi_ib = new CertiIb;
       
            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',2)->get();
// dd( $formulas );
            $app_certi_ib = DB::table('app_certi_ib')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_ib_export')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_ib_export')->select('id')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->get();
            // dd('ok');

            $Query = CertiIb::with(['app_certi_ib_export' => function($q){
                $q->where('status', 4);
            }]);


            $certifieds = collect() ;
            if(!is_null($data_session->agent_id)){  // ตัวแทน
                $certiIbs = $Query->where('agent_id',  $data_session->agent_id ) ;
            }else{
                if($data_session->branch_type == 1){  // สำนักงานใหญ่
                    $certiIbs = $Query->where('tax_id',  $data_session->tax_number ) ;
                }else{   // ผู้บันทึก
                    $certiIbs = $Query->where('created_by',   auth()->user()->getKey()) ;
                }
            }

     
            $certifieds = CertiIBExport::whereIn('app_no',$certiIbs->get()->pluck('app_no')->toArray())->get();
          
            return view('certify.applicant_ib.create',[
                                                        'tis_data'=>$data_session,
                                                        'previousUrl' =>$previousUrl,
                                                        'certi_ib' => $certi_ib,
                                                        'formulas' => $formulas,
                                                        'certificate_exports' => $certificate_exports,
                                                        'certificate_no' => $certificate_no,
                                                        'methodType' => 'create',
                                                        'certifieds' => $certifieds
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
    public function storeIbScope($request,$certiIbId)
    {
        // แปลง JSON เป็น array
        $transactions = json_decode($request->transactions, true);

        // ลบ transactions เดิมทั้งหมดที่ผูกกับ certi_ib_id
        IbScopeTransaction::where('certi_ib_id', $certiIbId)->delete();

        // สร้าง transactions ใหม่ทั้งหมด
        foreach ($transactions as $transaction) {
            IbScopeTransaction::create([
                'certi_ib_id' => $certiIbId,
                'ib_main_category_scope_id' => $transaction['ib_main_category_scope_id'],
                'ib_sub_category_scope_id' => $transaction['ib_sub_category_scope_id'],
                'ib_scope_topic_id' => $transaction['ib_scope_topic_id'],
                'ib_scope_detail_id' => $transaction['ib_scope_detail_id'],
                'standard' => $transaction['standard'],
                'standard_en' => $transaction['standard_en'],
            ]);
        }
    }

    public function SaveCertiIb($request, $data_session , $token = null)
    {
        // $requestData = $request->all();

        $requestApp  = $request->all();
        if( is_null($token) ){

            $id = "RQ-IB-";
            $year = Carbon::now()->addYears(543)->format('y');
            $order = sprintf('%03d',CertiIb::whereYear('created_at',Carbon::now()->year)->count()+1);
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
        $requestApp['name_unit']         = !empty($request->name_unit)?$request->name_unit:null;
        $requestApp['name_en_unit']      = !empty($request->name_en_unit)?$request->name_en_unit:null;
        $requestApp['name_short_unit']   = !empty($request->name_short_unit)?$request->name_short_unit:null;

        $requestApp['type_standard']     = !empty($request->type_standard)?$request->type_standard:'2';

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

        $requestApp['ib_latitude']            = !empty($request->ib_latitude)?$request->ib_latitude:null;
        $requestApp['ib_longitude']           = !empty($request->ib_longitude)?$request->ib_longitude:null;

        //ที่อยู่ห้องปฏิบัติการ EN
        $requestApp['ib_address_no_eng']      = !empty($request->ib_address_no_eng)?$request->ib_address_no_eng:null;
        $requestApp['ib_moo_eng']             = !empty($request->ib_moo_eng)?$request->ib_moo_eng:null;
        $requestApp['ib_soi_eng']             = !empty($request->ib_soi_eng)?$request->ib_soi_eng:null;
        $requestApp['ib_street_eng']          = !empty($request->ib_street_eng)?$request->ib_street_eng:null;
        $requestApp['ib_province_eng']        = !empty($request->ib_province_eng)?$request->ib_province_eng:null;
        $requestApp['ib_amphur_eng']          = !empty($request->ib_amphur_eng)?$request->ib_amphur_eng:null;
        $requestApp['ib_district_eng']        = !empty($request->ib_district_eng)?$request->ib_district_eng:null;
        $requestApp['ib_postcode_eng']        = !empty($request->ib_postcode_eng)?$request->ib_postcode_eng:null;

        //ข้อมูลสำหรับการติดต่อ
        $requestApp['contactor_name']          = !empty($request->contactor_name)?$request->contactor_name:null;
        $requestApp['email']                   = !empty($request->email)?$request->email:null;
        $requestApp['contact_tel']             = !empty($request->contact_tel)?$request->contact_tel:null;
        $requestApp['telephone']               = !empty($request->telephone)?$request->telephone:null;

        $requestApp['hq_date_registered']      = Carbon::hasFormat($request->hq_date_registered, 'd/m/Y')?Carbon::createFromFormat("d/m/Y", $request->hq_date_registered)->addYear(-543)->format('Y-m-d'):null;


        if(!empty($request->transferer_id_number) && !empty($request->transferee_certificate_number))
        {
            
            $transfererIdNumber = $request->input('transferer_id_number');
            $certificateNumber = $request->input('transferee_certificate_number');           
    
            $certificateExport = CertiIBExport::where('certificate',$certificateNumber)->first();
            

            if($certificateExport != null){
                $certiIb = CertiIb::find($certificateExport->app_certi_ib_id);
     
                if($certiIb != null)
                {
                    $taxId = $certiIb->tax_id;
                    // dd(trim($taxId) , trim($transfererIdNumber),$certiIb ,$request->transferer_id_number,$request->transferee_certificate_number, $certificateExport);
                    if(trim($taxId) == trim($transfererIdNumber)) 
                    {
                        $requestApp['transferer_user_id']  = $transfererIdNumber;
                        $requestApp['transferer_export_id'] = $certificateExport->id;
                    }
                }
            }
        }


        if(  is_null($token) ){
            $requestApp['agent_id']           =   !empty($data_session->agent_id) ? $data_session->agent_id : null;  
            $certi_ib =  CertiIb::create($requestApp);
        }else{
            $certi_ib =  CertiIb::where('token',$token)->first();
            // วันที่เปลี่ยนสถานะฉบับร่างเป็นรอดำเนินการตรวจ
            if($request->status == 1 && $certi_ib->status == 0 ){
                $requestApp['created_at'] = date('Y-m-d h:m:s');
            }
            $certi_ib->update($requestApp);
        }

        $this->storeIbScope($request,$certi_ib->id);

        return $certi_ib;
    }

    public function SaveFileSection($request, $name, $input_name, $section, $certi_ib )
    {
        $tb = new CertiIb;
        $requestData = $request->all();
        if( isset($requestData[ $name ]) ){
            $repeater_list = $requestData[ $name ];

            foreach( $repeater_list AS $item ){

                if( isset($item[ $input_name ]) ){

                    $certi_ib_attach                   = new CertiIBAttachAll();
                    $certi_ib_attach->app_certi_ib_id  = $certi_ib->id;
                    $certi_ib_attach->table_name       = $tb->getTable();
                    $certi_ib_attach->file_section     = (string)$section;
                    $certi_ib_attach->file_desc        = !empty($item[ 'attachs_txt' ])?$item[ 'attachs_txt' ]:null;
                    $certi_ib_attach->file             = $this->storeFile( $item[ $input_name ] ,$certi_ib->app_no);
                    $certi_ib_attach->file_client_name = HP::ConvertCertifyFileName( $item[ $input_name ]->getClientOriginalName());
                    $certi_ib_attach->token            = str_random(16);
                    $certi_ib_attach->save();

                }

            }

        }
    } 
    


    public function store(Request $request)
    {
        // dd($request->all());
        $model = str_slug('applicantibs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('add-'.$model)){

                   
                $requestData = $request->all();

                // add ceti ib
                $certi_ib = $this->SaveCertiIb($request, $data_session , null );
                

                //  2. การปฏิบัติของหน่วยงานตรวจสอบที่สอดคล้องตามข้อกำหนดฐานฐานเลขที่ มอก.17020 (Inspection body implementations which are conformed with TIS 17020)
                if ( isset($requestData['repeater-section1'] ) ){
                    $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_ib );
                }

                //  3. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)
                if ( isset($requestData['repeater-section2'] ) ){
                    $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_ib );
                }

                // 4. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) ไฟล์แนบ Word (doc,docx)
                if ( isset($requestData['repeater-section3'] ) ){
                    $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_ib );
                }

                //  5. เครื่องมือ (Equipment) 
                if ( isset($requestData['repeater-section4'] ) ){
                    $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_ib );
                }

                // 6. วัสดุอ้างอิง/มาตรบานอ้างอิง (Reference material / Reference TIS)
                if ( isset($requestData['repeater-section5'] ) ){
                    $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_ib );
                }

                // 7. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)
                if ( isset($requestData['repeater-section6'] ) ){
                    $this->SaveFileSection($request, 'repeater-section6', 'attachs_sec6', 6 , $certi_ib );
                }

                // 8. เอกสารอื่นๆ (Others)
                if ( isset($requestData['repeater-section7'] ) ){
                    $this->SaveFileSection($request, 'repeater-section7', 'attachs_sec7', 7 , $certi_ib );
                }

                if ( isset($requestData['repeater-section8'] ) ){
                    $this->SaveFileSection($request, 'repeater-section8', 'attachs_sec8', 8 , $certi_ib );
                }


                $pdfService = new CreateIbScopePdf($certi_ib);
                $pdfContent = $pdfService->generatePdf();

                // dd($this->checkCertiIbExport($certi_ib));
                // เงื่อนไขเช็คมีใบรับรอง 
                $this->save_certiib_export_mapreq( $certi_ib );

                if($certi_ib->status == 1){
                    $this->SET_EMAIL($certi_ib,1);
                }  

                if(!empty($request->transferer_id_number) && !empty($request->transferee_certificate_number))
                {
                   
                    $transfererIdNumber = $request->input('transferer_id_number');
                        $certificateNumber = $request->input('transferee_certificate_number');           
                
                        $certificateExport = CertiIBExport::where('certificate',$certificateNumber)->first();
                       
                        if($certificateExport != null){
                            $certiIb = CertiIb::find($certificateExport->app_certi_ib_id);

                            if($certiIb != null)
                            {
                                $taxId = $certiIb->tax_id;
                                if(trim($taxId) == trim($transfererIdNumber)) 
                                {
                                    $user = User::where('username',$transfererIdNumber)->first();
                                    
                                    $data_app =  [
                                                'certiIb'=>  $certiIb,
                                                'certificateExport'=>  $certificateExport,
                                                'transferee' => auth()->user(),
                                                'transferer' => $user,
                                                ];

                                    $html = new NotifyIBTransferer($data_app);
                                    $mail =  Mail::to($user->email)->send($html);

                                }
                            }
                        }
                }

                return redirect('certify/applicant-ib')->with('flash_message', 'เพิ่มเรียบร้อยแล้ว');
            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }



    public function checkCertiIbExport($certi_ib)
    {
        // dd(CertiIBExport::where('app_certi_ib_id',$certi_ib->id)->get());
        $app_certi_ib             = CertiIb::with([
            'app_certi_ib_export' => function($q){
                $q->whereIn('status',['0','1','2','3','4']);
            }
        ])
            ->where('created_by', $certi_ib->created_by)
            ->whereNotIn('status', ['0','4'])
            ->where('type_standard', $certi_ib->type_standard)
            ->first();

        // dd($app_certi_ib);
        if(!Is_null($app_certi_ib)){
            // dd('block1',$app_certi_ib->app_certi_ib_export);
            $certificate_exports_id = !empty($app_certi_ib->app_certi_ib_export->id) ? $app_certi_ib->app_certi_ib_export->id : null;
             if(!Is_null($certificate_exports_id)){
                dd($app_certi_ib);
             }
        }
        dd('block');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($token)
    {
        $model = str_slug('applicantibs','-');
        $data_session     =    HP::CheckSession();
     if(!empty($data_session)){
        if(HP::CheckPermission('view-'.$model)){
            
            $previousUrl = app('url')->previous();
            $certi_ib =  CertiIb::where('token',$token)->first();
            $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',2)->get();

            $app_certi_ib = DB::table('app_certi_ib')->where('tax_id',$data_session->tax_number)->select('id');
            $certificate_exports = DB::table('app_certi_ib_export')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->pluck('certificate','id');
            $certificate_no = DB::table('app_certi_ib_export')->select('id')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->get();


            $tis_data = $data_session;
            $methodType = "show";
            return view('certify.applicant_ib.show', compact('tis_data',
                                                             'previousUrl',
                                                             'certi_ib',
                                                             'formulas',
                                                             'certificate_exports',
                                                             'certificate_no' ,
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
       
        $model = str_slug('applicantibs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
           if(HP::CheckPermission('edit-'.$model)){

                $previousUrl = app('url')->previous();
                $certi_ib =  CertiIb::where('token',$token)->first();

                $tis_data = $data_session;
                $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
                $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();
                $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';
                $tis_data->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
                // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
                $tis_data->AMPHUR_ID    =    $data_session->district ?? '';
                // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
                $tis_data->DISTRICT_ID  =     $data_session->subdistrict ?? '';

                $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',2)->get();

                $app_certi_ib = DB::table('app_certi_ib')->where('tax_id',$data_session->tax_number)->select('id');
                $certificate_exports = DB::table('app_certi_ib_export')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->pluck('certificate','id');
                $certificate_no = DB::table('app_certi_ib_export')->select('id')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->get();
                $methodType = "edit";
                $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id', $certi_ib->id)
                ->with([
                    'ibMainCategoryScope',
                    'ibSubCategoryScope',
                    'ibScopeTopic',
                    'ibScopeDetail'
                ])
                ->get();

                $certifieds = collect() ;
                $Query = CertiIb::with(['app_certi_ib_export' => function($q){
                    $q->where('status', 4);
                }]);
                if(!is_null($data_session->agent_id)){  // ตัวแทน
                    $certiIbs = $Query->where('agent_id',  $data_session->agent_id ) ;
                }else{
                    if($data_session->branch_type == 1){  // สำนักงานใหญ่
                        $certiIbs = $Query->where('tax_id',  $data_session->tax_number ) ;
                    }else{   // ผู้บันทึก
                        $certiIbs = $Query->where('created_by',   auth()->user()->getKey()) ;
                    }
                }
    
        
                $certifieds = CertiIBExport::whereIn('app_no',$certiIbs->get()->pluck('app_no')->toArray())->get();
                // dd('ok');
                return view('certify.applicant_ib.edit', compact('tis_data',
                                                                'previousUrl',
                                                                'certi_ib',
                                                                'formulas',
                                                                'certificate_exports',
                                                                'certificate_no',
                                                                'methodType',
                                                                'ibScopeTransactions',
                                                                'certifieds'
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
        $model = str_slug('applicantibs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){
                try {  

  
                    $requestData = $request->all();

                    $certi_ib =  CertiIb::where('token',$token)->first();

                    if($certi_ib->require_scope_update != "1")
                    {
                        
                        if($certi_ib->tracking == null)
                        {
                            if($certi_ib->status == 9 && $certi_ib->doc_review_reject !== null)
                            {
                                // dd($certi_ib->status,$certi_ib->doc_review_reject);
                                $this->docUpdate($request, $token);
                                $certi_ib->update([
                                    'doc_review_reject' => null
                                ]);
                            }
                            else
                            {
                                $certi_ib = $this->SaveCertiIb($request, $data_session , $token );

                                // dd($certi_ib);
            
                            
            
                                //  2. การปฏิบัติของหน่วยงานตรวจสอบที่สอดคล้องตามข้อกำหนดฐานฐานเลขที่ มอก.17020 (Inspection body implementations which are conformed with TIS 17020)
                                if ( isset($requestData['repeater-section1'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_ib );
                                }
                
                                //  3. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)
                                if ( isset($requestData['repeater-section2'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_ib );
                                }
                
                                // 4. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) ไฟล์แนบ Word (doc,docx)
                                if ( isset($requestData['repeater-section3'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_ib );
                                }
                
                                //  5. เครื่องมือ (Equipment) 
                                if ( isset($requestData['repeater-section4'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_ib );
                                }
                
                                // 6. วัสดุอ้างอิง/มาตรบานอ้างอิง (Reference material / Reference TIS)
                                if ( isset($requestData['repeater-section5'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_ib );
                                }
                
                                // 7. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)
                                if ( isset($requestData['repeater-section6'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section6', 'attachs_sec6', 6 , $certi_ib );
                                }
                
                                // 8. เอกสารอื่นๆ (Others)
                                if ( isset($requestData['repeater-section7'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section7', 'attachs_sec7', 7 , $certi_ib );
                                }
                
                                if ( isset($requestData['repeater-section8'] ) ){
                                    $this->SaveFileSection($request, 'repeater-section8', 'attachs_sec8', 8 , $certi_ib );
                                }
                                // เงื่อนไขเช็คมีใบรับรอง 
                                $this->save_certiib_export_mapreq( $certi_ib );
            
                                $pdfService = new CreateIbScopePdf($certi_ib);
                                $pdfContent = $pdfService->generatePdf();
            
            
                                $status = $certi_ib->status ?? 1;
            
                                if($status == 3){
                                    $this->SET_EMAIL_Request_Documents($certi_ib);
                                }else{
                                    if($certi_ib->status == 1){
                                        $this->SET_EMAIL($certi_ib,$status);
                                    }   
                                }

                            }
                        }else{
                            // dd('ok',$certi_ib->tracking);
                                $this->trackingDocUpdate($request, $token);
                        }
                        
                    }
                    // else
                    // {
                    //     dd('แก้ไขขอบข่าย');
                    // }
                    
                

                    return redirect('certify/applicant-ib')->with('flash_message', 'แก้ไข applicantIB เรียบร้อยแล้ว!');

                } catch (\Exception $e) {
                    return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }   
            }
            abort(403);

        }else{
            return  redirect(HP::DomainTisiSso());  
        }

    }

    public function editScope($token)
    {
        // dd($token);
        $model = str_slug('applicantibs','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
           if(HP::CheckPermission('edit-'.$model)){

                $previousUrl = app('url')->previous();
                $certi_ib =  CertiIb::where('token',$token)->first();

                $tis_data = $data_session;
                $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
                $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();
                $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';
                $tis_data->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
                // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
                $tis_data->AMPHUR_ID    =    $data_session->district ?? '';
                // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
                $tis_data->DISTRICT_ID  =     $data_session->subdistrict ?? '';

                $formulas = DB::table('bcertify_formulas')->select('*')->where('state',1)->where('applicant_type',2)->get();

                $app_certi_ib = DB::table('app_certi_ib')->where('tax_id',$data_session->tax_number)->select('id');
                $certificate_exports = DB::table('app_certi_ib_export')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->pluck('certificate','id');
                $certificate_no = DB::table('app_certi_ib_export')->select('id')->whereIn('app_certi_ib_id',$app_certi_ib)->where('status',3)->get();
                $methodType = "edit";
                $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id', $certi_ib->id)
                ->with([
                    'ibMainCategoryScope',
                    'ibSubCategoryScope',
                    'ibScopeTopic',
                    'ibScopeDetail'
                ])
                ->get();

                $certifieds = collect() ;
                $Query = CertiIb::with(['app_certi_ib_export' => function($q){
                    $q->where('status', 4);
                }]);
                if(!is_null($data_session->agent_id)){  // ตัวแทน
                    $certiIbs = $Query->where('agent_id',  $data_session->agent_id ) ;
                }else{
                    if($data_session->branch_type == 1){  // สำนักงานใหญ่
                        $certiIbs = $Query->where('tax_id',  $data_session->tax_number ) ;
                    }else{   // ผู้บันทึก
                        $certiIbs = $Query->where('created_by',   auth()->user()->getKey()) ;
                    }
                }
    
        
                $certifieds = CertiIBExport::whereIn('app_no',$certiIbs->get()->pluck('app_no')->toArray())->get();
                // dd('ok');
                return view('certify.applicant_ib.edit_scope', compact('tis_data',
                                                                'previousUrl',
                                                                'certi_ib',
                                                                'formulas',
                                                                'certificate_exports',
                                                                'certificate_no',
                                                                'methodType',
                                                                'ibScopeTransactions',
                                                                'certifieds'
                                                                ));
            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }

    public function updateScope(Request $request, $token)
    {
        // dd("ok");
        CertiIb::where('token',$token)->update([
            'require_scope_update' => null
         ]);
        $certi_ib =  CertiIb::where('token',$token)->first();
        $this->storeIbScope($request,$certi_ib->id);
        $pdfService = new CreateIbScopePdf($certi_ib);
        $pdfContent = $pdfService->generatePdf();

        return redirect('certify/applicant-ib')->with('flash_message', 'แก้ไข applicantIB เรียบร้อยแล้ว!');
    }

    public function docUpdate($request, $token)
    {
        // dd('doc update');
        $certi_ib =  CertiIb::where('token',$token)->first();
        
        //  2. การปฏิบัติของหน่วยงานตรวจสอบที่สอดคล้องตามข้อกำหนดฐานฐานเลขที่ มอก.17020 (Inspection body implementations which are conformed with TIS 17020)
        if ( isset($requestData['repeater-section1'] ) ){
            $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_ib );
        }

        //  3. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)
        if ( isset($requestData['repeater-section2'] ) ){
            $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_ib );
        }

        // 4. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) ไฟล์แนบ Word (doc,docx)
        if ( isset($requestData['repeater-section3'] ) ){
            $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_ib );
        }

        //  5. เครื่องมือ (Equipment) 
        if ( isset($requestData['repeater-section4'] ) ){
            $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_ib );
        }

        // 6. วัสดุอ้างอิง/มาตรบานอ้างอิง (Reference material / Reference TIS)
        if ( isset($requestData['repeater-section5'] ) ){
            $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_ib );
        }

        // 7. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)
        if ( isset($requestData['repeater-section6'] ) ){
            $this->SaveFileSection($request, 'repeater-section6', 'attachs_sec6', 6 , $certi_ib );
        }

        // 8. เอกสารอื่นๆ (Others)
        if ( isset($requestData['repeater-section7'] ) ){
            $this->SaveFileSection($request, 'repeater-section7', 'attachs_sec7', 7 , $certi_ib );
        }

        if ( isset($requestData['repeater-section8'] ) ){
            $this->SaveFileSection($request, 'repeater-section8', 'attachs_sec8', 8 , $certi_ib );
        }


        $certi_ib->update([
            'doc_review_reject' => null
        ]);

        $pdfService = new CreateIbScopePdf($certi_ib);
        $pdfContent = $pdfService->generatePdf();

        return redirect('certify/applicant-ib')->with('flash_message', 'แก้ไข applicantIB เรียบร้อยแล้ว!');
        
    }



    public function trackingDocUpdate($request, $token)
    {
        // dd('doc update');
        $certi_ib =  CertiIb::where('token',$token)->first();
        
        //  2. การปฏิบัติของหน่วยงานตรวจสอบที่สอดคล้องตามข้อกำหนดฐานฐานเลขที่ มอก.17020 (Inspection body implementations which are conformed with TIS 17020)
        if ( isset($requestData['repeater-section1'] ) ){
            $this->SaveFileSection($request, 'repeater-section1', 'attachs_sec1', 1 , $certi_ib );
        }

        //  3. รายชื่อคุณวุฒิประสบการณ์และขอบข่ายความรับผิดชอบของเจ้าหน้าที่ (List of relevant personnel providing name, qualification, experience and responsibility)
        if ( isset($requestData['repeater-section2'] ) ){
            $this->SaveFileSection($request, 'repeater-section2', 'attachs_sec2', 2 , $certi_ib );
        }

        // 4. ขอบข่ายที่ยื่นขอรับการรับรอง (Scope of Accreditation Sought) ไฟล์แนบ Word (doc,docx)
        if ( isset($requestData['repeater-section3'] ) ){
            $this->SaveFileSection($request, 'repeater-section3', 'attachs_sec3', 3 , $certi_ib );
        }

        //  5. เครื่องมือ (Equipment) 
        if ( isset($requestData['repeater-section4'] ) ){
            $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_ib );
        }

        // 6. วัสดุอ้างอิง/มาตรบานอ้างอิง (Reference material / Reference TIS)
        if ( isset($requestData['repeater-section5'] ) ){
            $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_ib );
        }

        // 7. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison)
        if ( isset($requestData['repeater-section6'] ) ){
            $this->SaveFileSection($request, 'repeater-section6', 'attachs_sec6', 6 , $certi_ib );
        }

        // 8. เอกสารอื่นๆ (Others)
        if ( isset($requestData['repeater-section7'] ) ){
            $this->SaveFileSection($request, 'repeater-section7', 'attachs_sec7', 7 , $certi_ib );
        }

        if ( isset($requestData['repeater-section8'] ) ){
            $this->SaveFileSection($request, 'repeater-section8', 'attachs_sec8', 8 , $certi_ib );
        }

        // $trackingDocReviewAuditor = TrackingDocReviewAuditor::where('tracking_id',$certi_ib->tracking->id)->first();

        //  dd($certi_ib->tracking->trackingDocReviewAuditor);

        $certi_ib->tracking->update([
            'doc_review_reject' => null
        ]);


        return redirect('certify/tracking-ib')->with('flash_message', 'แก้ไข applicantIB เรียบร้อยแล้ว!');
        
    }


        // สำหรับเพิ่มรูปไปที่ store
        public function storeFile($files, $app_no = 'files_ib', $name = null)
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

        public function removeFilesCertiIBAttachAll($path,$token){
              $certi_ib_attach = CertiIBAttachAll::where('token',$token)->first();
              if(!is_null($certi_ib_attach)){
                try{
                    $file = storage_path().'/'.$certi_ib_attach->file;
                        if(is_file($file)){
                            File::delete($file);
                        }
                    $certi_ib_attach->delete();
                    return redirect()->back()->with('flash_message', 'ลบไฟล์แล้ว!');
                }catch (\Exception $x){
                    echo "เกิดข้อผิดพลาด";
                }
              }else{
                return redirect()->back()->with('flash_message', 'ลบไฟล์แล้ว!');
              }
        }       
         
        public function deleteApplicant(Request $request)
        {
         
            $certi_ib = CertiIb::where('token',$request->token)->first();
            if(!is_null($certi_ib)){
                $certi_ib->desc_delete = $request->reason;
                $certi_ib->status = 4;
                $certi_ib->save();
                 $tb = new CertiIb;
                if ($request->another_attach_files_del && $request->hasFile('another_attach_files_del')){
                         $attachs = [];
                    foreach ($request->another_attach_files_del as $index => $item){
                        $certi_ib_attach_more                   = new CertiIBAttachAll();
                        $certi_ib_attach_more->app_certi_ib_id  = $certi_ib->id;
                        $certi_ib_attach_more->table_name       = $tb->getTable();
                        $certi_ib_attach_more->file_section     = '8';
                        $certi_ib_attach_more->file_desc        = $request->another_attach_name[$index] ?? null;
                        $certi_ib_attach_more->file             = $this->storeFile($item,$certi_ib->app_no);
                        $certi_ib_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                        $certi_ib_attach_more->token            = str_random(16);
                        $certi_ib_attach_more->save();
                        $list               = new  stdClass;
                        $list->file_desc    = $certi_ib_attach_more->file_desc ;
                        $list->file         = $certi_ib_attach_more->file ;
                        $attachs[]          = $list;
                    }
                }
             // log
               CertiIbHistory::create([
                                    'app_no'        => $certi_ib->app_no ?? null,
                                    'system'        => 2,
                                    'table_name'    => $tb->getTable(),
                                    'status'        => $certi_ib->status ?? null,
                                    'ref_id'        => $certi_ib->id,
                                    'details_two'   => $certi_ib->desc_delete ?? null,
                                    'attachs'       => isset($attachs) ?  json_encode($attachs) : null,
                                    'created_by'    =>  auth()->user()->runrecno
                                  ]); 

            }


            return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');
        }


            // ส่ง Email
        public function SET_EMAIL($certi_ib,$status = null)
        {
            
            if(count($certi_ib->DataEmailDirectorIB) > 0){  
                $config =   HP::getConfig();
                $url    =   !empty($config->url_center) ? $config->url_center : url('');    
          
                     $request = '';
                  if($status == 3){
                      $request = 'ได้แก้ไข';
                  }else{
                      $request = 'ได้ดำเนิน';
                  }
             $data_app = ['email'        =>  $certi_ib->email,
                        'certi_ib'      =>  $certi_ib,
                        'request'       =>  $request,
                        'url'           =>  $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-',
                        'email_cc'      =>  (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? $certi_ib->DataEmailDirectorIBCC : 'ib@tisi.mail.go.th'
                        ];


              $email_cc =    (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailDirectorIBCC): 'ib@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_ib->app_no,
                                                    $certi_ib->id,
                                                    (new CertiIb)->getTable(),
                                                    $certi_ib->id,
                                                    (new CertiIb)->getTable(),
                                                    2,
                                                    'คำขอรับบริการยืนยันความสามารถหน่วยตรวจ',
                                                    view('mail.IB.applicant', $data_app),
                                                    $certi_ib->created_by,
                                                    $certi_ib->agent_id,
                                                    null,
                                                    $certi_ib->email,
                                                    implode(',',(array)$certi_ib->DataEmailDirectorIB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                 );

               $html = new IBApplicantMail($data_app);
               $mail =  Mail::to($certi_ib->DataEmailDirectorIB)->send($html);
            
                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }

          }
        }
        public function SET_EMAIL_Request_Documents($certi_ib)
        {
             
          if(count($certi_ib->DataEmailDirectorIB) > 0){
            $config =   HP::getConfig();
            $url    =   !empty($config->url_center) ? $config->url_center : url('');    

             $data_app = ['email'       =>  $certi_ib->email ?? '-',
                        'certi_ib'      =>  $certi_ib ,
                        'url'           =>  $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-',
                        'email_cc'      =>  (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? $certi_ib->DataEmailDirectorIBCC : 'ib@tisi.mail.go.th'
                      ];

             $email_cc =    (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailDirectorIBCC): 'ib@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail( $certi_ib->app_no,
                                                    $certi_ib->id,
                                                    (new CertiIb)->getTable(),
                                                    $certi_ib->id,
                                                    (new CertiIb)->getTable(),
                                                    2,
                                                    'ขอส่งเอกสารเพิ่มเติม',
                                                    view('mail.IB.request_documents', $data_app),
                                                    $certi_ib->created_by,
                                                    $certi_ib->agent_id,
                                                    null,
                                                    $certi_ib->email,
                                                    implode(',',(array)$certi_ib->DataEmailDirectorIB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                 );

               $html = new IBRequestDocumentsMail($data_app);
               $mail =  Mail::to($certi_ib->DataEmailDirectorIB)->send($html);
            
                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }
          }
        }
              //การประมาณค่าใช้จ่าย
      public function EditCost($token)
      {

        $previousUrl = app('url')->previous();
        $certi_ib =  CertiIb::where('token',$token)->first();

        return view('certify.applicant_ib/form_status.form_status8', compact('previousUrl','certi_ib'));
 
      }
      public function updateStatusCost(Request $request)
      {
    try {    
        $certi_ib =  CertiIb::where('token',$request->token)->first();
        $certi_cost = CertiIBCost::where('app_certi_ib_id',$certi_ib->id) ->orderby('id','desc')->first();
        $tb = new CertiIBCost;
        $attachs = null;
        $attachs_scope = null;

        if(!is_null($certi_ib) &&  !is_null($certi_cost)){

            if ($request->another_modal_attach_files && $request->hasFile('another_modal_attach_files')){
                foreach ($request->another_modal_attach_files as $index => $item){
                    $certi_ib_attach_more                   = new CertiIBAttachAll();
                    $certi_ib_attach_more->app_certi_ib_id  = $certi_ib->id; 
                    $certi_ib_attach_more->ref_id           = $certi_cost->id; 
                    $certi_ib_attach_more->table_name       = $tb->getTable();
                    $certi_ib_attach_more->file_desc        = $request->file_desc[$index] ?? null;
                    $certi_ib_attach_more->file             = $this->storeFile($item,$certi_ib->app_no);
                    $certi_ib_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                    $certi_ib_attach_more->file_section     = '2';
                    $certi_ib_attach_more->token            = str_random(16);
                    $certi_ib_attach_more->save();

                    $cost_find = new stdClass();
                    $cost_find->file_desc        =   $certi_ib_attach_more->file_desc;
                    $cost_find->file             =   $certi_ib_attach_more->file ;
                    $cost_find->file_client_name =   $certi_ib_attach_more->file_client_name ;
                    $attachs[] = $cost_find;
                }
            } 

            if ($request->attach_files  && $request->hasFile('attach_files')){
                foreach ($request->attach_files as $index => $item){
                    $certi_ib_attach_more                   = new CertiIBAttachAll();
                    $certi_ib_attach_more->app_certi_ib_id  = $certi_ib->id; 
                    $certi_ib_attach_more->ref_id           = $certi_cost->id; 
                    $certi_ib_attach_more->table_name       = $tb->getTable();
                    $certi_ib_attach_more->file_desc        = $request->file_desc_text[$index] ?? null;
                    $certi_ib_attach_more->file             = $this->storeFile($item,$certi_ib->app_no);
                    $certi_ib_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                    $certi_ib_attach_more->file_section     = '3';
                    $certi_ib_attach_more->token            = str_random(16);
                    $certi_ib_attach_more->save();

                    $find = new stdClass();
                    $find->file_desc_text   = $certi_ib_attach_more->file_desc;
                    $find->attach_files     = $certi_ib_attach_more->file ;
                    $find->file_client_name = $certi_ib_attach_more->file_client_name ;
                    $attachs_scope[] = $find;
                }
            } 

            $requestData = $request->all();

            if($request->status_scope == 1 && $request->check_status == 1){  
                    $certi_ib->status = 9; 
                    $requestData['remark']  =  null;
                    $requestData['remark_scope']  =  null;
            }else{
                $certi_ib->status = 7; 
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
            $certi_ib->save();
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

            if(!is_null($certi_ib->email) && count($certi_ib->DataEmailDirectorIB) > 0){  //  ส่ง E-mail
                
                $config = HP::getConfig();
                $url  =   !empty($config->url_center) ? $config->url_center : url('');    

                $data_app =['email'            => $certi_ib->email, 
                            'certi_ib'         => $certi_ib,
                            'title'            => $title,
                            'certi_cost'       => $certi_cost,
                            'check_status'     => array_key_exists($certi_cost->check_status,$check_status)   ? $check_status[$certi_cost->check_status]   :  '-',
                            'status_scope'     => array_key_exists($certi_cost->status_scope,$status_scope)   ? $status_scope[$certi_cost->status_scope]   :  '-',
                            'attachs'          => !is_null($attachs) ? $attachs : '-',
                            'attachs_scope'    => !is_null($attachs_scope) ? $attachs_scope : '-',
                            'url'              =>  $url.'/certify/estimated_cost-ib/'. $certi_cost->id .'/edit' ?? '-',
                            'email_cc'         =>  (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? $certi_ib->DataEmailDirectorIBCC : 'ib@tisi.mail.go.th'
                        ];

                $email_cc =    (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailDirectorIBCC): 'ib@tisi.mail.go.th' ;

                $log_email =  HP::getInsertCertifyLogEmail($certi_ib->app_no,
                                                    $certi_ib->id,
                                                    (new CertiIb)->getTable(),
                                                    $certi_cost->id,
                                                    (new CertiIBCost)->getTable(),
                                                    2,
                                                    'การประมาณการค่าใช้จ่าย',
                                                    view('mail.IB.cost', $data_app),
                                                    $certi_ib->created_by,
                                                    $certi_ib->agent_id,
                                                    null,
                                                    $certi_ib->email,
                                                    implode(',',(array)$certi_ib->DataEmailDirectorIB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                    );
                $html = new IBCostMail($data_app);
                $mail =  Mail::to($certi_ib->DataEmailDirectorIB)->send($html);
                
                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }
 
             }

       
        }

        if($request->previousUrl){
            return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
        }else{
            return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');
        }
        
    } catch (\Exception $e) {
        return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    }   
     
      } 

      public function set_cost_history($data,$file1,$file2)
      {
            if($file1 != null){
                $attachs_file  =  $file1;
            }
            if($file2 != null){
                $evidence  =  $file2;
            }
          $tb = new CertiIBCost;
          $Cost = CertiIBCost::select('app_certi_ib_id', 'draft', 'check_status', 'remark', 'status_scope', 'remark_scope')
                        ->where('id',$data->id)
                        ->first();
        
          $CostItem = CertiIBCostItem::select('app_certi_cost_id','detail','amount_date','amount')
                                ->where('app_certi_cost_id',$data->id)
                                ->get()
                                ->toArray();
         $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                ->where('ref_id',$data->id)
                                                ->where('system',4)
                                                ->orderby('id','desc')
                                                ->first();
         if(!is_null($CertiIbHistory)){
            $CertiIbHistory->update([
                                      'details_one'     =>  json_encode($Cost) ?? null,
                                      'attachs_file'    =>  isset($attachs_file) ?  json_encode($attachs_file) : null,
                                      'evidence'        =>  isset($evidence) ?  json_encode($evidence) : null,
                                      'updated_by'      =>  auth()->user()->getKey() ,
                                      'date'            => date('Y-m-d')
                                   ]);
         }                         
   
     }


       //ขอความเห็นแต่งคณะผู้ตรวจประเมิน
      public function EditAuditor($token)
      {
        $previousUrl = app('url')->previous();
        $certi_ib =  CertiIb::where('token',$token)->first();
        return view('certify/applicant_ib/form_status.form_status10', compact('previousUrl','certi_ib'));
      }

      public function updateAuditor(Request $request,$token = null)
      {
      try {  
        // return $request;
        $tb = new CertiIBAuditors;
        $certi_ib =  CertiIb::where('token',$token)->first();
        if(!is_null($certi_ib) && isset($request->auditors_id)){
            $authorities = [];
            $data = [];
          
            foreach ($request->auditors_id as $key => $item){
                  $auditors = CertiIBAuditors::where('id',$item)->orderby('id','desc')->first();
                 if(!is_null($auditors)){

                    $auditors->status = $request->status[$item] ?? null;
 
                    if($request->status[$item] == 2){
                        $auditors->remark   =  $request->remark[$item] ?? null;
                        $auditors->vehicle  =  2;
                        $auditors->step_id  =  1; //อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน
                    }else{
                        $auditors->remark   = null; 
                        $auditors->step_id  =  3; //เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
                    }

                    $auditors->save();   
                    $attachs = [];
                     // ไฟล์แนบ
                     if (isset($request->another_modal_attach_files[$item])  ){
                        foreach ($request->another_modal_attach_files[$item] as $key => $attach){
                            if(is_file($attach->getRealPath())){
                             $certi_ib_attach_more                   = new CertiIBAttachAll();
                             $certi_ib_attach_more->app_certi_ib_id  = $certi_ib->id; 
                             $certi_ib_attach_more->ref_id           = $auditors->id; 
                             $certi_ib_attach_more->table_name       = $tb->getTable();
                             $certi_ib_attach_more->file_desc        =  $request->file_desc[$item][$key] ?? null;
                             $certi_ib_attach_more->file             = $this->storeFile($attach,$certi_ib->app_no);
                             $certi_ib_attach_more->file_client_name = HP::ConvertCertifyFileName($attach->getClientOriginalName());
                             $certi_ib_attach_more->file_section     = '3';
                             $certi_ib_attach_more->token            = str_random(16);
                             $certi_ib_attach_more->save();
                             
                             $find = new stdClass();
                             $find->file_desc           =   $certi_ib_attach_more->file_desc ?? null;
                             $find->file                =   $certi_ib_attach_more->file ?? null;
                             $find->file_client_name    =   $certi_ib_attach_more->file_client_name ?? null;
                             $attachs[]                 =   $find;
                            }
                         }
                      }


                  $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                    ->where('ref_id',$auditors->id)
                                                    ->where('system',5)
                                                    ->orderby('id','desc')
                                                    ->first();
                    if(!is_null($CertiIbHistory)){
                    $CertiIbHistory->update([
                                                'details_one'   =>  json_encode($auditors) ?? null,
                                                'status'        =>   $auditors->status ??  null,
                                                'attachs_file'  =>  (count($attachs) > 0) ?  json_encode($attachs) : null,
                                                'updated_by'    =>  auth()->user()->getKey() ,
                                                'date'          => date('Y-m-d')
                                            ]);
                    }

                    // pay in ครั้งที่ 1  
                    if($auditors->status == 1){
                        $payin =  new CertiIBPayInOne ;
                        $payin->app_certi_ib_id =  $certi_ib->id;
                        $payin->auditors_id     = $auditors->id;
                        $payin->save();

                        $std = new stdClass(); // หมายเลขตำขอเห็นชอบ 
                        $std->auditor =    $auditors->auditor  ?? null;
                        $data[] =  $std;
                    }
                        $list = new stdClass();  // หมายเลขตำขอไม่เห็นชอบ 
                        $list->auditor      =  $auditors->auditor  ?? null;
                        $list->status       =  $auditors->status  ?? null;
                        $list->created_at   =  $auditors->created_at  ?? null;
                        $list->updated_at   =  $auditors->updated_at  ?? null;
                        $list->remark       =  $auditors->remark ?? null;
                        $list->attachs      = (count($attachs) > 0) ?  json_encode($attachs) : null;
                        $authorities[]      =  $list;
                    

                 }
            }

 
                   $config = HP::getConfig();
                   $url  =   !empty($config->url_center) ? $config->url_center : url('');    

                 if(!is_null($certi_ib->email) && count($authorities) > 0 && count($certi_ib->DataEmailDirectorIB) > 0){  //  ส่ง E-mail  ผก. + เจ้าหน้าที่รับผิดชอบ 
                     $data_app = [  'email'        => $certi_ib->email, 
                                    'certi_ib'     => $certi_ib,
                                    'auditors'     => $auditors,
                                    'authorities'  => count($authorities) > 0 ?  $authorities : '-',
                                    'url'          => $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-' ,
                                    'email_cc'     => count($certi_ib->DataEmailDirectorIBCC) > 0  ? $certi_ib->DataEmailDirectorIBCC : 'ib@tisi.mail.go.th'
                                 ];
        
                     $email_cc =    (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailDirectorIBCC): 'ib@tisi.mail.go.th' ;
        
                     $log_email =  HP::getInsertCertifyLogEmail( $certi_ib->app_no,
                                                            $certi_ib->id,
                                                            (new CertiIb)->getTable(),
                                                            $auditors->id,
                                                            (new CertiIBAuditors)->getTable(),
                                                            2,
                                                            'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                            view('mail.IB.auditors', $data_app),
                                                            $certi_ib->created_by,
                                                            $certi_ib->agent_id,
                                                            null,
                                                            $certi_ib->email,
                                                            implode(',',(array)$certi_ib->DataEmailDirectorIB),
                                                            $email_cc,
                                                            null,
                                                            null
                                                         );
        
                       $html = new IBAuditorsMail($data_app);
                       $mail =  Mail::to($certi_ib->DataEmailDirectorIB)->send($html);
                    
                        if(is_null($mail) && !empty($log_email)){
                            HP::getUpdateCertifyLogEmail($log_email->id);
                        }
                }
 
               if(!is_null($certi_ib->email)   && count($certi_ib->CertiEmailLt) > 0   && count($data) > 0){  //  ส่ง E-mail เจ้าหน้าที ลท. IB  

                     $data_app =['email'       => $certi_ib->email, 
                                'certi_ib'     => $certi_ib,
                                'auditors'     => $auditors,
                                'authorities'  => count($authorities) > 0 ?  $authorities : '-',
                                'url'          => $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-' ,
                                'email_cc'     => (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? $certi_ib->DataEmailAndLtIBCC : 'ib@tisi.mail.go.th'
                                ];
        
                     $email_cc =    (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailAndLtIBCC): 'ib@tisi.mail.go.th' ;
        
                     $log_email =  HP::getInsertCertifyLogEmail( $certi_ib->app_no,
                                                            $certi_ib->id,
                                                            (new CertiIb)->getTable(),
                                                            $auditors->id,
                                                            (new CertiIBAuditors)->getTable(),
                                                            2,
                                                            'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                            view('mail.IB.con_firm_auditors', $data_app),
                                                            $certi_ib->created_by,
                                                            $certi_ib->agent_id,
                                                            null,
                                                            $certi_ib->email,
                                                            implode(',',(array)$certi_ib->CertiEmailLt),
                                                            $email_cc,
                                                            null,
                                                            null
                                                         );
        
                       $html = new IBConFirmAuditorsMail($data_app);
                       $mail =  Mail::to($certi_ib->CertiEmailLt)->send($html);
                    
                        if(is_null($mail) && !empty($log_email)){
                            HP::getUpdateCertifyLogEmail($log_email->id);
                        }                     
                }

       }
        if($request->previousUrl){
            return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
        }else{
            return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');
        }

    } catch (\Exception $e) {
        return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    }     

      }
      public function GetIBPayInOne($id = null,$token = null)
      {
             $previousUrl = app('url')->previous();
             $pay_in  =  CertiIBPayInOne::findOrFail($id);
      
             return view('certify/applicant_ib/form_status.form_pay_in_one',  compact('previousUrl',
                                                                                      'pay_in'
                                                                                    ));
      } 
      public function CertiIBPayInOne(Request $request, $id){
      try {  
            $tb = new CertiIBPayInOne;
            $pay_in  =  CertiIBPayInOne::findOrFail($id);
            $certi_ib = CertiIb::findOrFail($pay_in->app_certi_ib_id);  
            if(!is_null($pay_in) && isset($request->activity_file) && $request->hasFile('activity_file')){
                // ไฟล์แนบ
                 $certi_ib_attach_more                      = new CertiIBAttachAll();
                 $certi_ib_attach_more->app_certi_ib_id     = $certi_ib->id; 
                 $certi_ib_attach_more->ref_id              = $pay_in->id; 
                 $certi_ib_attach_more->table_name          = $tb->getTable();
                 $certi_ib_attach_more->file                = $this->storeFile($request->activity_file,$certi_ib->app_no);
                 $certi_ib_attach_more->file_client_name    = HP::ConvertCertifyFileName($request->activity_file->getClientOriginalName());
                 $certi_ib_attach_more->file_section        = '2';
                 $certi_ib_attach_more->token               = str_random(16);
                 $certi_ib_attach_more->save();

 
                 $pay_in->state = 2;
                 $pay_in->status = null;
                 $pay_in->remark = null;
                 $pay_in->save(); 
                 
              // สถานะ แต่งตั้งคณะกรรมการ
                $auditor = CertiIBAuditors::findOrFail($pay_in->auditors_id); 
                if(!is_null($auditor) && $pay_in->state == 2){
                    $auditor->step_id = 5; // แจ้งหลักฐานการชำระเงิน
                    $auditor->save();
                 }

               //  Log
                $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                            ->where('ref_id',$pay_in->id)
                                                            ->where('system',6)
                                                             ->orderby('id','desc')
                                                            ->first();                                   
                  if(!is_null($CertiIbHistory)){
                        $CertiIbHistory->update([
                                                'attachs_file'  =>  $certi_ib_attach_more->file ?? null,
                                                'evidence'      =>  $certi_ib_attach_more->file_client_name ?? null,
                                                'updated_by'    =>  auth()->user()->getKey() ,
                                                'date'          =>  date('Y-m-d')
                                                ]);
                    }
             
       
                $config = HP::getConfig();
                $url  =   !empty($config->url_center) ? $config->url_center : url('');   
                
                 // Mail ลท.
               if($certi_ib && !is_null($certi_ib->email) && count($certi_ib->CertiEmailLt) > 0){

                     $data_app = [  'certi_ib'    => $certi_ib,
                                    'files'       =>  $certi_ib_attach_more->file ?? null,
                                    'url'         => $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-',
                                    'pay_in'      => $pay_in, 
                                    'email'       => $certi_ib->email, 
                                    'email_cc'    =>  (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? $certi_ib->DataEmailAndLtIBCC : 'ib@tisi.mail.go.th'
                                 ];
        
                     $email_cc =    (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailAndLtIBCC): 'ib@tisi.mail.go.th' ;
        
                     $log_email =  HP::getInsertCertifyLogEmail($certi_ib->app_no.'-'.@$pay_in->auditors_id,
                                                            $certi_ib->id,
                                                            (new CertiIb)->getTable(),
                                                            $pay_in->id,
                                                            (new CertiIBPayInOne)->getTable(),
                                                            2,
                                                            'แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน',
                                                            view('mail.IB.pay_in1', $data_app),
                                                            $certi_ib->created_by,
                                                            $certi_ib->agent_id,
                                                            null,
                                                            $certi_ib->email,
                                                            implode(',',(array)$certi_ib->CertiEmailLt),
                                                            $email_cc,
                                                            null,
                                                            isset($certi_ib_attach_more->file) ?    'certify/check/file_ib_client/'.$certi_ib_attach_more->file.'/'.$certi_ib_attach_more->file_client_name : null
                                                         );
        
                       $html = new IBPayInOneMail($data_app);
                       $mail =  Mail::to($certi_ib->CertiEmailLt)->send($html);
                    
                        if(is_null($mail) && !empty($log_email)){
                            HP::getUpdateCertifyLogEmail($log_email->id);
                        }              
              }

             if(!empty($certi_ib->app_no) && !empty($pay_in->auditors_id)){
                        //  เช็คการชำระ
                    $arrContextOptions=array();
                    if(strpos($url, 'https')===0){//ถ้าเป็น https
                        $arrContextOptions["ssl"] = array(
                                                        "verify_peer" => false,
                                                        "verify_peer_name" => false,
                                                    );
                    }
                    file_get_contents($url.'api/v1/checkbill?ref1='.$certi_ib->app_no.'-'.$pay_in->auditors_id, false, stream_context_create($arrContextOptions));
            }
        }   

        return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');

    } catch (\Exception $e) {
        return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    }    


      }
      

      // แก้ไขข้อบกพร่อง/ข้อสังเกต 
      public function EditAssessment($id = null, $token = null)
      {
        $previousUrl = app('url')->previous();
        $assessment = CertiIBSaveAssessment::findOrFail($id);
        $certi_ib =  CertiIb::findOrFail($assessment->app_certi_ib_id);                 
        return view('certify/applicant_ib/form_status.form_status16', compact('previousUrl','certi_ib','assessment'));
      }
    public function UpdateAssessment(Request $request, $id)
    {
        try {  
                $assessment = CertiIBSaveAssessment::findOrFail($id);
                $certi_ib = CertiIb::findOrFail($assessment->app_certi_ib_id); 
                $tb = new CertiIBSaveAssessment;
                
                $assessment->update(['degree'=>2]);  
                $requestData = $request->all();
                
                if(isset($requestData["detail"])){
                    $detail = (array)$requestData["detail"];
                    foreach ($detail['id'] as $key => $item) {
                            $bug = CertiIBSaveAssessmentBug::where('id',$item)->first();
                            $bug->details = $detail["details"][$key] ?? $bug->details;
                            $assessment->check_file = 'false';  
                        if($request->attachs && $request->hasFile('attachs')){
                            $bug->attachs            =  array_key_exists($key, $request->attachs) ?  $this->storeFile($request->attachs[$key],$certi_ib->app_no) : @$bug->attachs;
                            $bug->attach_client_name =  array_key_exists($key, $request->attachs) ?  HP::ConvertCertifyFileName($request->attachs[$key]->getClientOriginalName()) : @$bug->attach_client_name;
                            $assessment->check_file = 'true';
                        }
                            $bug->save();
                    }
                }
                $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                                    ->where('ref_id',$id)
                                                                    ->where('system',7)
                                                                    ->orderby('id','desc')
                                                                    ->first();  

                    $bug = CertiIBSaveAssessmentBug::select('report','remark','no','type','reporter_id','details','status','comment','file_status','file_comment','attachs','attach_client_name')
                                                    ->where('assessment_id',$id)
                                                    ->get()
                                                    ->toArray();                             
                    if(!is_null($CertiIbHistory)){
                            $CertiIbHistory->update([
                                                        'details_two'=>  (count($bug) > 0) ? json_encode($bug) : null,
                                                        'updated_by' =>  auth()->user()->getKey() ,
                                                        'date'       => date('Y-m-d')
                                                    ]);
                    }


                    if($certi_ib && !is_null($certi_ib->email) && count($certi_ib->DataEmailDirectorIB) > 0 ){
                        $config = HP::getConfig();
                        $url    =   !empty($config->url_center) ? $config->url_center : url('');    
                        
                        $data_app = ['certi_ib'      => $certi_ib,
                                        'email'         => $certi_ib->email,
                                        'assessment'    =>  $assessment,
                                        'url'           =>  $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-',
                                        'email_cc'      =>  count($certi_ib->DataEmailDirectorIBCC) > 0  ? $certi_ib->DataEmailDirectorIBCC : 'ib@tisi.mail.go.th'
                                    ];
                
                            $email_cc =    (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailDirectorIBCC): 'ib@tisi.mail.go.th' ;
            
                            $log_email =  HP::getInsertCertifyLogEmail($certi_ib->app_no,
                                                                    $certi_ib->id,
                                                                    (new CertiIb)->getTable(),
                                                                    $assessment->id,
                                                                    (new CertiIBSaveAssessment)->getTable(),
                                                                    2,
                                                                    'แจ้งแนวทางแก้ไข/ส่งหลักฐานการแก้ไขข้อบกพร่อง',
                                                                    view('mail.IB.assessment', $data_app),
                                                                    $certi_ib->created_by,
                                                                    $certi_ib->agent_id,
                                                                    null,
                                                                    $certi_ib->email,
                                                                    implode(',',(array)$certi_ib->DataEmailDirectorIB),
                                                                    $email_cc,
                                                                    null,
                                                                    null
                                                                );
                
                            $html = new IBSaveAssessmentMail($data_app);
                            $mail =  Mail::to($certi_ib->DataEmailDirectorIB)->send($html);
                        
                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }             

                    }
                    
                return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');
            } catch (\Exception $e) {
                return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
            }   

     }
      
     public function EditInspectiont($id = null, $token = null)
     {
        $previousUrl = app('url')->previous();
        $assessment = CertiIBSaveAssessment::findOrFail($id);
        $certi_ib =  CertiIb::findOrFail($assessment->app_certi_ib_id);
       return view('certify/applicant_ib/form_status.form_status15', compact('previousUrl','certi_ib','assessment'));
     }

     public function UpdateInspectiont(Request $request, $id)
     {
     try {  
          $assessment = CertiIBSaveAssessment::findOrFail($id);
          $certi_ib = CertiIb::findOrFail($assessment->app_certi_ib_id);
           // สถานะ แต่งตั้งคณะกรรมการ
           $committee = CertiIBAuditors::findOrFail($assessment->auditors_id);  
          $tb = new CertiIBSaveAssessment;
          if(!is_null($assessment)){
  
            if($request->status_scope == 1){  // update สถานะ
                 CertiIBAttachAll::where('table_name',$tb->getTable())
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
              $auditor = CertiIBAuditors::where('app_certi_ib_id',$certi_ib->id)
                                          ->whereIn('step_id',[9,10])
                                          ->whereNull('status_cancel')
                                          ->get(); 
              if(count($auditor) == count($certi_ib->CertiIBAuditorsMany)){
                  $report = new   CertiIBReview;  //ทบทวนฯ
                  $report->app_certi_ib_id  = $certi_ib->id;
              
                  $report->save();
                //   $certi_ib->update(['review'=>1,'status'=>11]);  // ทบทวน
                   $certi_ib->review = 1;  // ทบทวน
                   $certi_ib->status = 11;  
                   $certi_ib->save(); 
               }

            }else{
                $assessment->status = 2;
                $assessment->degree = 5;
                $assessment->details = $request->details ?? null;
                $assessment->save();
                $certi_ib->update(['status'=>10]);  // อยู่ระหว่างดำเนินการ
                // ไฟล์แนบ
                if($request->attach_files && $request->hasFile('attach_files')){
                    CertiIBAttachAll::where('table_name',$tb->getTable())
                                      ->where('file_section',6)
                                      ->where('ref_id',$assessment->id)
                                      ->delete();
                    foreach ($request->attach_files as $index => $item){
                            $certi_ib_attach_more                   = new CertiIBAttachAll(); 
                            $certi_ib_attach_more->app_certi_ib_id  = $assessment->app_certi_ib_id ?? null;
                            $certi_ib_attach_more->ref_id           = $assessment->id;
                            $certi_ib_attach_more->table_name       = $tb->getTable();
                            $certi_ib_attach_more->file_desc        = $request->file_desc_text[$index] ?? null;
                            $certi_ib_attach_more->file             = $this->storeFile($item,$certi_ib->app_no);
                            $certi_ib_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                            $certi_ib_attach_more->file_section     = '6';
                            $certi_ib_attach_more->token            = str_random(16);
                            $certi_ib_attach_more->save();
                    }
                }
                
                $committee->step_id = 11; // ขอแก้ไข Scope  
                $committee->save();
            }
        
            //Log
           $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                             ->where('ref_id',$id)
                                                             ->where('system',8)
                                                              ->orderby('id','desc')
                                                             ->first();                          
            if(!is_null($CertiIbHistory)){
                    $CertiIbHistory->update([
                                                'status'        => $assessment->status  ??  null,
                                                'remark'        => $assessment->details  ??  null,
                                                'attachs_file'  => (count($assessment->FileAttachAssessment6Many) > 0) ? json_encode($assessment->FileAttachAssessment6Many) : null,
                                                'updated_by'    => auth()->user()->getKey() ,
                                                'date'          => date('Y-m-d')
                                             ]);
             }

              //Mail  
  
             if($certi_ib && !is_null($certi_ib->email) && count($certi_ib->DataEmailDirectorIB) > 0){

                $config = HP::getConfig();
                $url    =   !empty($config->url_center) ? $config->url_center : url('');    
                
                $data_app =['certi_ib'     => $certi_ib ?? '-',
                            'email'     => $certi_ib->email,
                            'assessment'=> $assessment,
                            'url'       => $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-',
                            'email_cc'  => count($certi_ib->DataEmailDirectorIBCC) > 0  ? $certi_ib->DataEmailDirectorIBCC : 'ib@tisi.mail.go.th'
                          ];
     
                 $email_cc =    (count($certi_ib->DataEmailDirectorIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailDirectorIBCC): 'ib@tisi.mail.go.th' ;
 
                 $log_email =  HP::getInsertCertifyLogEmail($certi_ib->app_no,
                                                         $certi_ib->id,
                                                         (new CertiIb)->getTable(),
                                                         $assessment->id,
                                                         (new CertiIBSaveAssessment)->getTable(),
                                                         2,
                                                         'ยืนยันขอบข่ายการรับรองห้องปฏิบัติการ',
                                                         view('mail.IB.inspectiont', $data_app),
                                                         $certi_ib->created_by,
                                                         $certi_ib->agent_id,
                                                         null,
                                                         $certi_ib->email,
                                                         implode(',',(array)$certi_ib->DataEmailDirectorIB),
                                                         $email_cc,
                                                         null,
                                                         null
                                                      );
     
                 $html = new IBInspectiontMail($data_app);
                 $mail =  Mail::to($certi_ib->DataEmailDirectorIB)->send($html);
             
                 if(is_null($mail) && !empty($log_email)){
                     HP::getUpdateCertifyLogEmail($log_email->id);
                 }          

              }


          }

             return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');
       } catch (\Exception $e) {
            return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
       }   
     }

     // รอยืนยันคำขอ
     public function UpdateReport(Request $request, $id)
     { 
    try {  
         if(isset($request->status_confirm)){
            $report = CertiIBReport::findOrFail($id);
            $certi_ib = CertiIb::findOrFail($report->app_certi_ib_id);
            $report->update(['status_confirm'=>1,
                                'start_date' => date('Y-m-d'), 
                                'updated_by'=>  auth()->user()->getKey() 
                            ]);
                if($request->cf_cer==1){
                    $report->update(['cf_cer'=>1]);
                }
            $certi_ib->update(['status'=>14]); //ยืนยันจัดทำใบรับรอง
            $tb = new CertiIBReport;
            $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                    ->where('ref_id',$report->id)
                                                    ->where('system',9)
                                                    ->orderby('id','desc')
                                                    ->first();               
        
         if(!is_null($CertiIbHistory)){
              $CertiIbHistory->update([
                                          'status_scope'    => $request->status_confirm ?? null,
                                          'updated_by'      =>  auth()->user()->getKey() ,
                                          'date'            => date('Y-m-d')
                                        ]);
          }

          $PayIn = new CertiIBPayInTwo;  
          $PayIn->app_certi_ib_id = $certi_ib->id;
          $PayIn->save();

            //  Mail แจ้งเตือน ผก. + ลท.
          if($certi_ib && !is_null($certi_ib->email) && count($certi_ib->CertiEmailLt) > 0){

            $config = HP::getConfig();
            $url    =   !empty($config->url_center) ? $config->url_center : url('');    
            
            $data_app =['certi_ib' => $certi_ib  ,
                        'email'    => $certi_ib->email,
                        'url'      => $url.'/certify/check_certificate-ib/'.$certi_ib->token ?? '-',
                        'email_cc' =>  count($certi_ib->DataEmailAndLtIBCC) > 0  ? $certi_ib->DataEmailAndLtIBCC : 'ib@tisi.mail.go.th'
                      ];
 
             $email_cc =    (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailAndLtIBCC): 'ib@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail($certi_ib->app_no,
                                                     $certi_ib->id,
                                                     (new CertiIb)->getTable(),
                                                     $report->id,
                                                     (new CertiIBReport)->getTable(),
                                                     2,
                                                     'ยืนยันสรุปรายงานเสนอคณะกรรมการ/คณะอนุกรรมการ',
                                                     view('mail.IB.report', $data_app),
                                                     $certi_ib->created_by,
                                                     $certi_ib->agent_id,
                                                     null,
                                                     $certi_ib->email,
                                                     implode(',',(array)$certi_ib->CertiEmailLt),
                                                     $email_cc,
                                                     null,
                                                     null
                                                  );
 
             $html = new IBReportMail($data_app);
             $mail =  Mail::to($certi_ib->CertiEmailLt)->send($html);
         
             if(is_null($mail) && !empty($log_email)){
                 HP::getUpdateCertifyLogEmail($log_email->id);
             } 

           }

         }
        return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');

     } catch (\Exception $e) {
        return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
     }  
    }

   // รอยืนยันคำขอ
    public function UpdatePayInTwo(Request $request, $id)
    { 
            $PayIn = CertiIBPayInTwo::findOrFail($id);
            $certi_ib = CertiIb::findOrFail($PayIn->app_certi_ib_id);
            $attach_path = $this->attach_path;//path ไฟล์แนบ
            $tb = new CertiIBPayInTwo;
    try { 
       
            if($request->attach  && $request->hasFile('attach')){
                $certi_ib_attach_more                   = new CertiIBAttachAll();
                $certi_ib_attach_more->app_certi_ib_id  = $certi_ib->id; 
                $certi_ib_attach_more->ref_id           = $PayIn->id; 
                $certi_ib_attach_more->table_name       = $tb->getTable();
                $certi_ib_attach_more->file             = $this->storeFile($request->attach,$certi_ib->app_no);
                $certi_ib_attach_more->file_client_name = HP::ConvertCertifyFileName($request->attach->getClientOriginalName());
                $certi_ib_attach_more->file_section     = '2';
                $certi_ib_attach_more->token            = str_random(16);
                $certi_ib_attach_more->save();

                 $attach           = $certi_ib_attach_more->file;
                 $file_client_name = $certi_ib_attach_more->file_client_name;
                if( HP::checkFileStorage($attach_path.$attach)){
                    HP::getFileStorage($attach_path.$attach);
                }
            }

            
            $PayIn->update(['degree'=>2,'status'=> null,'detail'=> null ]);
            $certi_ib->update(['status'=>16]); //แจ้งหลักฐานการชำระค่าใบรับรอง
  
             $CertiIbHistory = CertiIbHistory::where('table_name',$tb->getTable())
                                                        ->where('ref_id',$PayIn->id)
                                                        ->where('system',10)
                                                        ->orderby('id','desc')
                                                        ->first();               
              if(!is_null($CertiIbHistory)){
                  $CertiIbHistory->update([  
                                              'attachs_file'    =>  isset($attach) ?  $attach : null,
                                              'evidence'        =>  isset($file_client_name) ?  $file_client_name : null,
                                              'updated_by'      =>  auth()->user()->getKey() ,
                                              'date'            => date('Y-m-d')
                                            ]);
              }

        $config     = HP::getConfig();
        $url        =   !empty($config->url_center) ? $config->url_center : url('');    

            // Mail       
         if(count($certi_ib->CertiEmailLt) > 0){
            
            $data_app =['certi_ib'   => $certi_ib ,
                        'attach'    =>  isset($attach) ?  $attach : '',
                        'PayIn'     =>  $PayIn,
                        'url'       => $url.'/certify/check_certificate-ib/'.$certi_ib->token ,
                        'email'     => $certi_ib->email, 
                        'email_cc'  =>  (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? $certi_ib->DataEmailAndLtIBCC : 'ib@tisi.mail.go.th'
                        ];
 
             $email_cc =    (count($certi_ib->DataEmailAndLtIBCC) > 0 ) ? implode(',', $certi_ib->DataEmailAndLtIBCC): 'ib@tisi.mail.go.th' ;

             $log_email =  HP::getInsertCertifyLogEmail($certi_ib->app_no,
                                                     $certi_ib->id,
                                                     (new CertiIb)->getTable(),
                                                     $PayIn->id,
                                                     (new CertiIBPayInTwo)->getTable(),
                                                     2,
                                                     'แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง',
                                                     view('mail.IB.pay_in_two', $data_app),
                                                     $certi_ib->created_by,
                                                     $certi_ib->agent_id,
                                                     null,
                                                     $certi_ib->email,
                                                     implode(',',(array)$certi_ib->CertiEmailLt),
                                                     $email_cc,
                                                     null,
                                                     isset($attach) ?  'certify/check/file_ib_client/'.$attach.'/'.$file_client_name : null
                                                  );
 
             $html = new IBPayInTwoMail($data_app);
             $mail =  Mail::to($certi_ib->CertiEmailLt)->send($html);
         
             if(is_null($mail) && !empty($log_email)){
                 HP::getUpdateCertifyLogEmail($log_email->id);
             }                                                
        }


        if(!empty($certi_ib->app_no)){
                    //  เช็คการชำระ
                $arrContextOptions=array();
                if(strpos($url, 'https')===0){//ถ้าเป็น https
                    $arrContextOptions["ssl"] = array(
                                                    "verify_peer" => false,
                                                    "verify_peer_name" => false,
                                                );
                }
                file_get_contents($url.'api/v1/checkbill?ref1='.$certi_ib->app_no, false, stream_context_create($arrContextOptions));
        }


        return redirect('certify/applicant-ib')->with('message', 'เรียบร้อยแล้ว!');
   } catch (\Exception $e) {
        return redirect('certify/applicant-ib')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
   }  
        }


    public function abilityConfirm(Request $request)
    {
        $certilIb = CertiIb::find($request->id);
        if($certilIb->standard_change == 6)
        {
            if($certilIb->transferer_export_id != null){
                $province = Province::find($certilIb->province_id);
                $export = CertiIBExport::find($certilIb->transferer_export_id);
                $holdStatus = $export->status;
                $exportId = $export->id;
                $mainCertiIbId = $export->app_certi_ib_id;
                CertiIBExport::find($certilIb->transferer_export_id)->update([
                'app_no' => $certilIb->app_no,
                'app_certi_ib_id' => $certilIb->id,
                'name_unit' => $certilIb->name_unit,
                'name_unit_en' => $certilIb->name_en_unit,
                'address' => $certilIb->address,
                'allay' => $certilIb->allay,
                'village_no' => $certilIb->village_no,
                'road' => $certilIb->road,
                'province_name' => $province->PROVINCE_NAME,
                'amphur_name' => $certilIb->amphur_id,
                'district_name' => $certilIb->district_id,
                'postcode' => $certilIb->postcode,
                'address_en' => $certilIb->ib_address_no_eng,
                'allay_en' => $certilIb->ib_moo_eng,
                'village_no_en' => $certilIb->ib_soi_eng,
                'road_en' => $certilIb->ib_street_eng,
                'province_name_en' => $province->PROVINCE_NAME_EN,
                'amphur_name_en' => $certilIb->ib_amphur_eng,
                'district_name_en' => $certilIb->ib_district_eng,
                'date_start' => Carbon::now(), //ใส่ carbon now
                'contact_name' =>  $certilIb->contactor_name,
                'contact_tel' =>  $certilIb->contact_tel,
                'contact_mobile' =>  $certilIb->telephone,
                'contact_email' =>  $certilIb->email,
                'status' =>  2,
                'hold_status' =>  $holdStatus
            ]);

            SendCertificateLists::where('certificate_id',$exportId)->delete();

            $belongCertiIbsIds = CertiIbExportMapreq::where('certificate_exports_id',$exportId)->pluck('app_certi_ib_id')->toArray();

            CertiIb::whereIn('id',$belongCertiIbsIds)->update([
                'tax_id' => $certilIb->tax_id,
                'email' => $certilIb->email,
                'tel' => $certilIb->tel,
                'contact_tel' => $certilIb->contact_tel,
                'telephone' => $certilIb->telephone,
              ]);

              CertiIbExportMapreq::where('app_certi_ib_id',$mainCertiIbId)->first()->update([
                'app_certi_ib_id' => $certilIb->id
              ]);
            }

        }
        CertiIBReport::where('app_certi_ib_id',$request->id)->first()->update([
            'ability_confirm' => 1
        ]);
    }

        //log
    public function DataLogIB($token)
        {
            $previousUrl = app('url')->previous();
            $certi_ib = CertiIb::where('token',$token)->first();
        
        // ประวัติคำขอ
            $history  =  CertiIbHistory::where('app_certi_ib_id',$certi_ib->id)
                                            ->whereNotIN('system',[11])
                                            ->orderby('id','desc')
                                            ->get();
                
            return view('certify/applicant_ib.log',['certi_ib'=>$certi_ib,
                                                    'history' => $history,
                                                    'previousUrl' => $previousUrl
                                                ]);
        }


        public function draft_pdf($certiib_id = null)
         {
 
             if(!is_null($certiib_id)){
 
                     $CertiIb = CertiIb::findOrFail($certiib_id);
 
                     $file = CertiIBFileAll::where('state',1)
                                             ->where('app_certi_ib_id',$certiib_id)
                                             ->first();      
                     if($certiib_id == 21){
                         $certiib_id = 7;
                     }
         
                     // return $certi_id;
                      $formula = Formula::where('id', 'like', @$CertiIb->type_standard)
                                             ->whereState(1)->first();
                     
                     // if(!is_null($file) && !is_null($file->attach_pdf) ){
                  
                          $url  =   url('/certify/check_files_ib/'. rtrim(strtr(base64_encode($certiib_id), '+/', '-_'), '=') );
                         //ข้อมูลภาพ QR Code
                          $image_qr = QrCode::format('png')->merge('plugins/images/tisi.png', 0.2, true)
                                       ->size(500)->errorCorrection('H')
                                       ->generate($url);
         
                     // }
 
                 $last   = CertiIBExport::where('type_standard',@$CertiIb->type_standard)->whereYear('created_at',Carbon::now())->count() + 1;
           
                 $lab_type = ['1'=>'Testing','2'=>'Cal','3'=>'IB','4'=>'CB'];
                 $accreditation_no = '';
                 if(array_key_exists("3",$lab_type)){
                     $accreditation_no .=  $lab_type[3].'-';
                 }
                 if(!is_null($CertiIb->app_no)){
                     $app_no = explode('-', $CertiIb->app_no);
                     $accreditation_no .= $app_no[2].'-';
                 }
                 if(!is_null($last)){
                     $accreditation_no .=  str_pad($last, 3, '0', STR_PAD_LEFT).'-'.(date('Y') +543);
                 }
 
                     $CertiIb->accreditation_no  =   $accreditation_no ? $accreditation_no : null;
                   
                     $data_export = [
                         'app_no'             => $CertiIb->app_no,
                         'name'               => !empty($CertiIb->name) ? $CertiIb->name : null,
                         'name_en'            =>  isset($CertiIb->name_standard_en) ?  '('.$CertiIb->name_standard_en.')' : '&emsp;', 
                         'lab_name_font_size' => $this->CalFontSize($CertiIb->name_standard),
                         'certificate'        => $CertiIb->certificate,
                         'name_unit'          => $CertiIb->name_unit,
                         'address'            => $this->FormatAddress($CertiIb),
                         'lab_name_font_size_address' => $this->CalFontSize($this->FormatAddress($CertiIb)),
                         'address_en'         => $this->FormatAddressEn($CertiIb),
                         'formula'            => $CertiIb->formula,
                         'formula_en'         =>  isset($CertiIb->formula_en) ?   $CertiIb->formula_en : '&emsp;', 
                         'accreditation_no'   => $CertiIb->accreditation_no,
                         'accreditation_no_en'   => $CertiIb->accreditation_no_en,
                         'date_start'         =>  !empty($CertiIb->date_start)? HP::convertDate($CertiIb->date_start,true) : null,
                         'date_end'           => !empty($CertiIb->date_end)? HP::convertDate($CertiIb->date_end,true) : null,
                         'date_start_en'      => !empty($CertiIb->date_start) ? HP::formatDateENertify(HP::convertDate($CertiIb->date_start,true)) : null ,
                         'date_end_en'        => !empty($CertiIb->date_end) ? HP::formatDateENFull($CertiIb->date_end) : null ,
                         'formula_title'      => !empty($CertiIb->FormulaTo->title) ? $CertiIb->FormulaTo->title : null,
                         'formula_title_en'      => !empty($CertiIb->FormulaTo->title_en) ? $CertiIb->FormulaTo->title_en : null,
                         'name_standard'      => !empty($CertiIb->name_standard) ? $CertiIb->name_standard : null,
                         'check_badge'        => isset($CertiIb->check_badge) ? $CertiIb->check_badge : null,
                         'image_qr'           => isset($image_qr) ? $image_qr : null,
                         'url'                => isset($url) ? $url : null,
                         'attach_pdf'         => isset($file->attach_pdf) ? $file->attach_pdf : null ,
                         'condition_th'       => !empty($formula->condition_th ) ? $formula->condition_th  : null ,
                         'condition_en'       => !empty($formula->condition_en ) ? $formula->condition_en  : null ,
                         'imagery'            =>  !empty($CertiIb->CertiCBFormulasTo->imagery) ?  $CertiIb->CertiCBFormulasTo->imagery : '-',
                         'image'              =>  !empty($CertiIb->CertiCBFormulasTo->image) ?  $CertiIb->CertiCBFormulasTo->image : '-',
                         'lab_name_font_size_condition' => !empty($formula->condition_th) ? $this->CalFontSizeCondition($formula->condition_th)  : '11',
                         'branch_th'          =>  !empty($CertiIb->CertificationBranchTo->title) ?  $CertiIb->CertificationBranchTo->title : '',
                         'branch_en'          =>  !empty($CertiIb->CertificationBranchTo->title_en) ?  '('.$CertiIb->CertificationBranchTo->title_en.')' : '',
                         'type_standard'      =>  @$formula->id ?? null
                        ];
 
                         $config = ['instanceConfigurator' => function ($mpdf) {
                             $mpdf->SetWatermarkText('DRAFT');
                             $mpdf->watermark_font = 'DejaVuSansCondensed';
                             $mpdf->showWatermarkText = true;
                             $mpdf->watermarkTextAlpha = 0.12;
                         }];
          
                   $pdf = Pdf::loadView('certify/applicant_ib/pdf/draft-thai', $data_export, [], $config);
                   return $pdf->stream("certificateib-thai.pdf");
            
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
         $address[] = $request->ib_address_no_eng;
 
         if($request->ib_moo_eng!=''){
           $address[] =    'Moo '.$request->ib_moo_eng;
         }
 
         if($request->ib_soi_eng!='' && $request->ib_soi_eng !='-'  && $request->ib_soi_eng !='--'){
           $address[] =   $request->ib_soi_eng;
         }
         if($request->ib_street_eng!='' && $request->ib_street_eng !='-'  && $request->ib_street_eng !='--'){
             $address[] =   $request->ib_street_eng.',';
         }
         if($request->ib_district_eng!='' && $request->ib_district_eng !='-'  && $request->ib_district_eng !='--'){
             $address[] =   $request->ib_district_eng.',';
         }
         if($request->ib_amphur_eng!='' && $request->ib_amphur_eng !='-'  && $request->ib_amphur_eng !='--'){
             $address[] =   $request->ib_amphur_eng.',';
         }
         if($request->ib_province_eng!='' && $request->ib_province_eng !='-'  && $request->ib_province_eng !='--'){
             $address[] =   $request->ib_province_eng;
         }
         if($request->ib_postcode_eng!='' && $request->ib_postcode_eng !='-'  && $request->ib_postcode_eng !='--'){
             $address[] =   $request->ib_postcode_eng;
         }
         return implode(' ', $address);
     }
     public function isIbTypeAndStandardBelong(Request $request)
     {
         $user = auth()->user();
         $appCertiIbIds = CertiIb::where('tax_id',$user->tax_number)->pluck('id')->toArray();
         $certiIbExportMapreqs = CertiIbExportMapreq::whereIn('app_certi_ib_id',$appCertiIbIds)->pluck('app_certi_ib_id')->toArray();
         $certiIbs = CertiIb::whereIn('id',$certiIbExportMapreqs)
                   ->where('type_unit',$request->typeUnit)
                   ->where('type_standard',$request->typeStandard)
                   ->get();
     
        return response()->json([
             'certiIbs' => $certiIbs
        ]);
     }

     public function getCertificatedBelong(Request $request)
     {
        $user = auth()->user();
        $appCertiIbIds = CertiIb::where('tax_id',$user->tax_number)
        ->where('type_unit',$request->typeUnit)
        ->where('type_standard',$request->typeStandard)
        ->pluck('id')->toArray();

        $certificateExports = CertiIBExport::whereIn('app_certi_ib_id',$appCertiIbIds)->get();

        return response()->json([
            'certificateExports' => $certificateExports
       ]);
     }

    public function  checkTransferee(Request $request)
    {
        $user = null;
       
        $transfererIdNumber = $request->input('transferer_id_number');
        $certificateNumber = $request->input('transferee_certificate_number');

        $certificateExport = CertiIBExport::where('certificate',$certificateNumber)->first();
       
        if($certificateExport != null){
            $certiIb = CertiIb::find($certificateExport->app_certi_ib_id);
            if($certiIb != null)
            {
                $taxId = $certiIb->tax_id;
                if(trim($taxId) == trim($transfererIdNumber)) 
                {
                    $user = User::where('username',$transfererIdNumber)->first();
                }
            }
        }

        return response()->json([
            'user' => $user,
            // 'certiIb' => $certiIb,
       ]);
    }


     public function get_app_no_and_certificate_exports_no(Request $request)
     {
         $data_session           = HP::CheckSession();
         $type_standard = $request->input('std_id');
         
         try {
             $app_certi_ib         = CertiIb::with([
                                                     'app_certi_ib_export' => function($q){
                                                        //  $q->where('status', 3);
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
                 'app_no' => $app_certi_ib->app_no ?? null,
                 'certificate_exports_no' => $app_certi_ib->app_certi_ib_export->certificate ?? null
             );
             return response()->json($data);
         } catch (\Exception $e) {
             return response()->json([
                 'satus' => false,
                 'error_message' => $e
             ]);
         }
     }

     private function save_certiib_export_mapreq($certi_ib)
     {
        //    $app_certi_ib  = CertiIb::with([
        //                                              'app_certi_ib_export' => function($q){
        //                                                  $q->whereIn('status',['0','1','2','3','4']);
        //                                              }
        //                                          ])
        //                                          ->where('created_by', $certi_ib->created_by)
        //                                          ->whereNotIn('status', ['0','4'])
        //                                          ->where('type_standard', $certi_ib->type_standard)
        //                                          ->first();
           $app_certi_ib  = CertiIb::whereHas('certiIBExport', function($q){
                                $q->whereIn('status', ['0','1','2','3','4']);
                            })
                        ->where('created_by', $certi_ib->created_by)
                        ->whereNotIn('status', ['0','4'])
                        ->where('type_standard', $certi_ib->type_standard)
                        ->where('type_unit', $certi_ib->type_unit)
                        ->first();
          if(!Is_null($app_certi_ib)){
              $certificate_exports_id = !empty($app_certi_ib->app_certi_ib_export->id) ? $app_certi_ib->app_certi_ib_export->id : null;
               if(!Is_null($certificate_exports_id)){
                        $mapreq =  CertiIbExportMapreq::where('app_certi_ib_id',$certi_ib->id)->where('certificate_exports_id', $certificate_exports_id)->first();
                        if(Is_null($mapreq)){
                            $mapreq = new  CertiIbExportMapreq;
                        }
                        $mapreq->app_certi_ib_id       = $certi_ib->id;
                        $mapreq->certificate_exports_id = $certificate_exports_id;
                        $mapreq->save();
               }
          }
     }
 
 
   public function getIbMainCategory()
   {
        $ibMainCategoryScopes = IbMainCategoryScope::all();
        return response()->json([
            'ibMainCategoryScopes' => $ibMainCategoryScopes,
        ]);
   }
   // ดึงข้อมูล IbSubCategoryScope ตาม ib_main_category_scope_id
   public function getIbSubCategory(Request $request)
   {
       $ibMainCategoryScopeId = $request->input('ib_main_category_scope_id');
       $ibSubCategoryScopes = IbSubCategoryScope::where('ib_main_category_scope_id', $ibMainCategoryScopeId)->get();
       return response()->json([
           'ibSubCategoryScopes' => $ibSubCategoryScopes,
       ]);
   }

   // ดึงข้อมูล IbScopeTopic ตาม ib_sub_category_scope_id
   public function getIbScopeTopic(Request $request)
   {
       $ibSubCategoryScopeId = $request->input('ib_sub_category_scope_id');
       $ibScopeTopics = IbScopeTopic::where('ib_sub_category_scope_id', $ibSubCategoryScopeId)->get();
       return response()->json([
           'ibScopeTopics' => $ibScopeTopics,
       ]);
   }

   // ดึงข้อมูล IbScopeDetail ตาม ib_scope_topic_id
   public function getIbScopeDetail(Request $request)
   {
       $ibScopeTopicId = $request->input('ib_scope_topic_id');
       $ibScopeDetails = IbScopeDetail::where('ib_scope_topic_id', $ibScopeTopicId)->get();
       return response()->json([
           'ibScopeDetails' => $ibScopeDetails,
       ]);
   }

   public function updateDocReviewTeam(Request $request)
   {
    //    dd($request->all());
       $certiIbId = $request->certiIbId;
       $ibDocReviewAuditor = IbDocReviewAuditor::where('app_certi_ib_id', $certiIbId)->first();
       $ibDocReviewAuditor->update([
           'status' => $request->agreeValue,
           'remark_text' => $request->remarkText,
       ]);
       
   }

   public function getIbDocReviewAuditor(Request $request)
   {
       $ibDocReviewAuditor = IbDocReviewAuditor::where('app_certi_ib_id',$request->certiIbId)->first();
       return response()->json([
           'ibDocReviewAuditors' => json_decode($ibDocReviewAuditor->auditors, true),
       ]);
   }
   public function ConfirmBug(Request $request)
   {
     // dd($request->all());
     $assessment = CertiIBSaveAssessment::find($request->assessment_id)->update([
         'accept_fault' => 1
     ]);
     return response()->json($assessment);
   }

   public function GetAddreess($subdistrict_id){ // ดึงข้อมูลที่อยู่จาก ตำบล

        $address_data  =  DB::table((new District)->getTable().' AS sub') // อำเภอ
                    ->leftJoin((new Amphur)->getTable().' AS dis', 'dis.AMPHUR_ID', '=', 'sub.AMPHUR_ID') // ตำบล
                    ->leftJoin((new Province)->getTable().' AS pro', 'pro.PROVINCE_ID', '=', 'sub.PROVINCE_ID')  // จังหวัด
                    ->leftJoin((new Zipcode)->getTable().' AS code', 'code.district_code', '=', 'sub.DISTRICT_CODE')  // รหัสไปรษณีย์
                    ->where(function($query) use($subdistrict_id){
                        $query->where('sub.DISTRICT_ID', $subdistrict_id);
                    })
                    ->where(function($query){
                        $query->where(DB::raw("REPLACE(sub.DISTRICT_NAME,' ','')"),  'NOT LIKE', "%*%");
                    })
                    ->select(

                        DB::raw("sub.DISTRICT_ID AS sub_ids"),
                        DB::raw("TRIM(sub.DISTRICT_NAME) AS sub_title"),
                        DB::raw("TRIM(sub.DISTRICT_NAME_EN) AS sub_title_en"),

                        DB::raw("dis.AMPHUR_ID AS dis_id"),
                        DB::raw("TRIM(dis.AMPHUR_NAME) AS dis_title"),
                        DB::raw("TRIM(dis.AMPHUR_NAME_EN) AS dis_title_en"),

                        DB::raw("pro.PROVINCE_ID AS pro_id"),
                        DB::raw("TRIM(pro.PROVINCE_NAME) AS pro_title"),
                        DB::raw("TRIM(pro.PROVINCE_NAME_EN) AS pro_title_en"),

                        DB::raw("code.zipcode AS zip_code")

                    )
                    ->first();

        return response()->json($address_data);
    }

   public function apiGetCertificated(Request $request)
   {
    $data_session     =    HP::CheckSession();
        // dd($request->all());
        $certificateExport = CertiIBExport::find($request->certified_id);
    
        $certiIb = CertiIb::find($certificateExport->app_certi_ib_id);

        $district= District::where('DISTRICT_NAME',trim($certiIb->district_id))->where('PROVINCE_ID',$certiIb->province_id)->first();
        $address = $this->GetAddreess($district->DISTRICT_ID);

        // dd($district,$certiIb->district_id,$certiIb->province_id);
        $file_sectionn1s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '1')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn2s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '2')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn3s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '3')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn4s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '4')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn5s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '5')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn6s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '6')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn7s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '7')
                    ->where('table_name','app_certi_ib')
                    ->get();

        $file_sectionn8s = CertiIBAttachAll::where('app_certi_ib_id', $certiIb->id)
                    ->where('file_section', '8')
                    ->where('table_name','app_certi_ib')
                    ->get();


        $methodType = "edit";
        $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id', $certiIb->id)
                    ->with([
                        'ibMainCategoryScope',
                        'ibSubCategoryScope',
                        'ibScopeTopic',
                        'ibScopeDetail'
                    ])
                    ->get();

        $certifieds = collect() ;
        $Query = CertiIb::with(['app_certi_ib_export' => function($q){
            $q->where('status', 4);
        }]);
        if(!is_null($data_session->agent_id)){  // ตัวแทน
            $certiIbs = $Query->where('agent_id',  $data_session->agent_id ) ;
        }else{
            if($data_session->branch_type == 1){  // สำนักงานใหญ่
                $certiIbs = $Query->where('tax_id',  $data_session->tax_number ) ;
            }else{   // ผู้บันทึก
                $certiIbs = $Query->where('created_by',   auth()->user()->getKey()) ;
            }
        }

     
            $certifieds = CertiIBExport::whereIn('app_no',$certiIbs->get()->pluck('app_no')->toArray())->get();            
        return response()->json([
            'attach_path' => $this->attach_path,
            'certiIb' => $certiIb,
            'certificateExport' => $certificateExport,
            'address' => $address,
            'file_sectionn1s' => $file_sectionn1s,
            'file_sectionn2s' => $file_sectionn2s,
            'file_sectionn3s' => $file_sectionn3s,
            'file_sectionn4s' => $file_sectionn4s,
            'file_sectionn5s' => $file_sectionn5s,
            'file_sectionn6s' => $file_sectionn6s,
            'file_sectionn7s' => $file_sectionn7s,
            'file_sectionn8s' => $file_sectionn8s,
            'ibScopeTransactions' => $ibScopeTransactions,
            'certifieds' => $certifieds,
            'methodType' => $methodType
        ]);           

   }

}






                // if( isset($item[ $input_name ]) ){

                //     $certi_ib_attach                   = new CertiIBAttachAll();
                //     $certi_ib_attach->app_certi_ib_id  = $certi_ib->id;
                //     $certi_ib_attach->table_name       = $tb->getTable();
                //     $certi_ib_attach->file_section     = (string)$section;
                //     $certi_ib_attach->file_desc        = !empty($item[ 'attachs_txt' ])?$item[ 'attachs_txt' ]:null;
                //     $certi_ib_attach->file             = $this->storeFile( $item[ $input_name ] ,$certi_ib->app_no);
                //     $certi_ib_attach->file_client_name = HP::ConvertCertifyFileName( $item[ $input_name ]->getClientOriginalName());
                //     $certi_ib_attach->token            = str_random(16);
                //     $certi_ib_attach->save();

                // }