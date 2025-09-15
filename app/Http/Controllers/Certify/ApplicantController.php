<?php

namespace App\Http\Controllers\Certify;

use HP;
use App\User;
use stdClass;
use Mpdf\Mpdf;
use Mpdf\Tag\Br;
use App\RoleUser;
use Carbon\Carbon;
use App\AttachFile;
use App\LabHtmlTemplate;
use Mpdf\HTMLParserMode;
use App\CertificateExport;
use App\Models\Basic\Staff;
use App\Models\Basic\Amphur;

use App\Models\Esurv\Trader;
use FontLib\Table\Type\post;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Mail\Lab\CertifyCost;
use App\Models\Basic\Zipcode;
use App\Models\Basic\District;
use App\Models\Basic\Province;
use App\Models\Esurv\FollowUp;
use App\Mail\Lab\CertifyPayIn1;
use App\Mail\Lab\CertifyReport;
use App\Models\Bcertify\Signer;
use App\Mail\Lab\LabScopeReview;
use App\Models\Bcertify\Formula;
use App\Models\Bcertify\SiteType;
use App\Models\Bcertify\TestItem;
use function GuzzleHttp\Psr7\str;
use App\Mail\Lab\CertifyApplicant;
use App\Mail\Lab\EditScopeRequest;
use App\Mail\Lab\NotifyTransferer;
use App\Mail\Lab\RequestEditScope;
use Illuminate\Support\Facades\DB;
use App\Mail\Lab\LabAbilityConfirm;
use App\Services\CreateLabScopePdf;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Certify\BoardAuditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

use App\Mail\Lab\CertifyBoardAuditor;

use App\Models\Bcertify\LabCalRequest;
use App\Models\Certify\Applicant\Cost;
use App\Mail\Lab\CertifySaveAssessment;
use App\Models\Bcertify\LabRequestType;
use App\Models\Bcertify\LabTestRequest;
use App\Models\Certify\Applicant\Check;

use App\Models\Certify\SetStandardUser;

use Illuminate\Support\Facades\Storage;
use App\Mail\Lab\CertifyCostCertificate;
use App\Models\Bcertify\BranchLabAdress;
use App\Models\Bcertify\TestBranchParam;
use App\Models\Certify\Applicant\Notice;
use App\Models\Certify\Applicant\Report;
use Illuminate\Support\Facades\Response;
use App\Mail\Lab\LABRequestDocumentsMail;
use App\Mail\Lab\SendTransferCertificate;
use App\Mail\Lab\CertifyConfirmAssessment;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Bcertify\LabCalMeasurement;
use App\Models\Bcertify\LabCalTransaction;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certify\Applicant\CostFile;
use App\Models\Certify\CertificateHistory;
use App\Models\Certify\SetStandardUserSub;

use App\Models\Bcertify\LabTestMeasurement;
use App\Models\Bcertify\LabTestTransaction;
use App\Models\Bcertify\TestBranchCategory;
use App\Models\Certify\BoardAuditorHistory;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\Lab\CertifyConFirmAuditorsMail;
use App\Models\Bcertify\LabScopeTransaction;
use App\Models\Certify\Applicant\Assessment;
use App\Models\Certify\Applicant\NoticeFile;
use App\Models\Certify\Applicant\NoticeItem;
use App\Models\Certify\SendCertificateLists;
use App\Models\Certify\Applicant\CostHistory;
use App\Models\Certify\Applicant\Information;
use App\Models\Certify\CertificateExportDesc;
use App\Models\Certify\CertificateExportFile;
use App\Models\Bcertify\LabCalMainMeasurement;
use App\Models\Bcertify\LabCalMainTransaction;
use App\Models\Certificate\TrackingAssessment;
use App\Models\Certificate\TrackingInspection;
use App\Models\Certify\Applicant\CertiLabInfo;
use App\Models\Bcertify\LabCalMeasurementRange;
use App\Models\Bcertify\LabCalScopeTransaction;
use App\Models\Bcertify\LabCalScopeUsageStatus;
use App\Models\Certify\Applicant\CertiLabPlace;
use App\Models\Bcertify\CalibrationBranchParam1;
use App\Models\Bcertify\CalibrationBranchParam2;
use App\Models\Certify\Applicant\CertiLabAttach;
use App\Models\Certify\Applicant\CertiToolsTest;
use App\Models\Certify\Applicant\CostAssessment;
use App\Models\Bcertify\LabRequestRejectTracking;
use App\Models\Certify\Applicant\AssessmentGroup;
use App\Models\Certify\Applicant\CertifyLabScope;
use App\Models\Certify\Applicant\CertiLabFileAll;
use App\Models\Certify\Applicant\CertiLabProgram;
use App\Models\Certify\Applicant\CertLabsFileAll;
use App\Models\Certify\Applicant\CostCertificate;
use App\Models\Certify\Applicant\CertifyTestScope;
use App\Models\Certify\Applicant\CertiLabCheckBox;
use App\Models\Certify\Applicant\CertiLabEmployee;
use App\Models\Bcertify\LabCalMainMeasurementRange;
use App\Models\Certify\Applicant\CertiLabAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrument;
use App\Models\Certify\Applicant\CertiLabAttachMore;
use App\Models\Certify\Applicant\CertiLabDeleteFile;
use App\Models\Certify\Applicant\AssessmentGroupFile;
use App\Models\Certify\Applicant\CertifyLabCalibrate;
use App\Models\Certify\Applicant\CertiLabMaterialLef;
use App\Models\Certify\Applicant\CertiToolsCalibrate;
use App\Models\Certify\Applicant\CertiLabExportMapreq;
use App\Models\Certify\Applicant\CertiLabCheckBoxImage;
use App\Models\Certify\Applicant\CostAssessmentHistory;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;

class ApplicantController extends Controller
{
    private $attach_path;//ที่เก็บไฟล์แนบ
    // private $categories = []; // ประกาศ array สำหรับเก็บค่าหมวดหมู่ทั้งหมด
    public function __construct()
    {
        // $this->middleware('auth');
        $this->attach_path = 'files/applicants/check_files/';

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd('ok');
        $model = str_slug('view-applicant','-');
        $data_session     =    HP::CheckSession();
        // dd($data_session);
        if(!empty($data_session)){
        if(HP::CheckPermission($model)){


            $filter = [];
            $filter['filter_status'] = $request->get('filter_status', '');
            $filter['filter_search'] = $request->get('filter_search', '');
            $filter['filter_state'] = $request->get('filter_state', '');
            $filter['filter_branch'] = $request->get('filter_branch', '');
            $filter['filter_start_date'] = $request->get('filter_start_date', '');
            $filter['filter_end_date'] = $request->get('filter_end_date', '');
            $filter['perPage'] = $request->get('perPage', 10);

            $Query = CertiLab::with(['certificate_exports_to' => function($q){
                                $q->where('status', 4);
                            }]);
            if ($filter['filter_status']!='') {
                $Query = $Query->where('status', $filter['filter_status']);
            }
            if ($filter['filter_search'] != '') {
                $Query = $Query->where(function($Query) use ($filter){
                    return $Query->where('app_no','LIKE', '%'.$filter['filter_search'].'%')->Orwhere('name','LIKE', '%'.$filter['filter_search'].'%');
                });
            }
            if ($filter['filter_state']!='') {
                $Query = $Query->where('lab_type', $filter['filter_state']);
            }

            if ($filter['filter_state']!='' && $filter['filter_branch']!='' ) {

                $lab_ids = [];
                if($filter['filter_state'] == 3){
                    $lab_ids =   CertifyTestScope::select('app_certi_lab_id')->where('branch_id',$filter['filter_branch']);
                }else{
                    $lab_ids =   CertifyLabCalibrate::select('app_certi_lab_id')->where('branch_id',$filter['filter_branch']);
                }
                $Query = $Query->whereIn('id', $lab_ids);
            }
           
            if ($filter['filter_start_date']  != '' && $filter['filter_end_date'] != ''){
                $start = !empty($filter['filter_start_date'])?HP::convertDate($filter['filter_start_date'],true):null;
                $end = !empty($filter['filter_end_date'])?HP::convertDate($filter['filter_end_date'],true):null;
                $Query = $Query->whereBetween('created_at', [$start,$end]);

            } elseif ($filter['filter_start_date']  != '' && $filter['filter_end_date'] == ''){
                $start = !empty($filter['filter_start_date'])?HP::convertDate($filter['filter_start_date'],true):null;
                $Query = $Query->whereDate('created_at',$start);
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
            
            // dd($Query->get()->pluck('app_no'),auth()->user()->getKey());
            $applicants =  $Query->sortable()
                                ->orderby('id','desc')
                                ->paginate($filter['perPage']);

            $applicants = $Query->with('certificate_exports_to') // เพิ่ม Eager Loading
                ->sortable()
                ->orderBy('id', 'desc')
                ->paginate($filter['perPage']);


            // foreach($applicants as $applicant)
            // {
            //     // dd($applicant->certificate_exports_to);
            //     // $certificateExport = CertificateExport::where('certificate_for',$applicant->id)->first();
            //     // $certificateExport = $applicant->certificate_exports_to;
            //     // dd($certificateExport);


            //     $certiLab = CertiLab::with('certificate_exports_to')->find($applicant->id);
            //     dd($certiLab->certificate_exports_to);
            // }
            
            return view('certify.applicant.index',[
                                                    'applicants' => $applicants,
                                                    'filter'     => $filter,
                                                    'attach_path' => $this->attach_path
                                                    ]);
        }
        abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data_session     =    HP::CheckSession();
        

       
        if(!empty($data_session)){
            
            $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->province).'%')->first();
            $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();

            $data_session->PROVINCE_ID  =    $Province->PROVINCE_ID ?? '';
            $data_session->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';
            // $Amphur =  Amphur::where('AMPHUR_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_amphur).'%')->first();
            $data_session->AMPHUR_ID    =    $data_session->district ?? '';
            // $District =  District::where('DISTRICT_NAME', 'LIKE', '%'.str_replace(" ","",$user_tis->trader_address_tumbol).'%')->first();
            $data_session->DISTRICT_ID  =     $data_session->subdistrict ?? '';


            $app_certi_labs = DB::table('app_certi_labs')->where('lab_type',3)->where('tax_id',$data_session->tax_number)->select('id');
            
            $certificate_exports = DB::table('certificate_exports')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->pluck('certificate_no','id');
            
            $certificate_no = DB::table('certificate_exports')->select('id')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->get();
            
            $branchs = DB::table('bcertify_test_branches')->where('state',1)->pluck('title','id');
            
            $attaches = DB::table('bcertify_config_attach_forms')->select('*')->where('form',1)->get();
            
            $data_session->branch_type    =   !empty($data_session->branch_type)?$data_session->branch_type:1;

            // dd($data_session);

            // dd($data_session->contact_subdistrict_id);

        //    // รับ response จากฟังก์ชัน GetAddreess
        //     $response = $this->GetAddreess($data_session->contact_subdistrict_id);

        //     // ดึงข้อมูล JSON จาก response
        //     $data = $response->getData(); // $data จะเป็น stdClass object

        //     // ถ้าคุณต้องการเข้าถึงค่าใน $data
        //     $sub_ids = $data->sub_ids;
        //     $sub_title = $data->sub_title;
        //     $sub_title_en = $data->sub_title_en;
        //     $dis_id = $data->dis_id;
        //     $dis_title = $data->dis_title;
        //     $dis_title_en = $data->dis_title_en;
        //     $pro_id = $data->pro_id;
        //     $pro_title = $data->pro_title;
        //     $pro_title_en = $data->pro_title_en;
        //     $zip_code = $data->zip_code;

        //     dd($sub_ids,$sub_title,$sub_title_en ,$dis_id,$dis_title ,$dis_title_en,$pro_id, $pro_title ,$pro_title_en,$zip_code);
                        

        
        $Query = CertiLab::with(['certificate_exports_to' => function($q){
            $q->where('status', 4);
        }]);

        $certifieds = collect() ;
        if(!is_null($data_session->agent_id)){  // ตัวแทน
            $certiLabs = $Query->where('agent_id',  $data_session->agent_id ) ;
        }else{
            if($data_session->branch_type == 1){  // สำนักงานใหญ่
                $certiLabs = $Query->where('tax_id',  $data_session->tax_number ) ;
            }else{   // ผู้บันทึก
                $certiLabs = $Query->where('created_by',   auth()->user()->getKey()) ;
            }
        }
    
        // dd($certiLabs);
       

        $certifieds = CertificateExport::whereIn('request_number',$certiLabs->get()->pluck('app_no')->toArray())->get();
        // dd($certifieds);

            return view('certify.applicant.create',[
                                                'tis_data'  => $data_session,
                                                'address_data'  => $this->GetAddreess($data_session->contact_subdistrict_id)->getData(),
                                                // 'formulas'  => $formulas,
                                                // 'province'  => $province,
                                                'attaches'  => $attaches,
                                                'branchs'   => $branchs,
                                                'certificate_exports'=> $certificate_exports,
                                                'certificate_no' => $certificate_no,
                                                'certifieds' => $certifieds

                // ,
                // 'follow_up' => $follow_up
            ]);
        }
       abort(403);
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

    public function getExistingBranch(Request $request)
    {
        $user = auth()->user();
        $username = $user->username;
        // ดึงข้อมูลผู้ใช้ที่ username ขึ้นต้นด้วยค่าใน $username และมีความยาวมากกว่า 13 หลัก
        $branches = User::where('username', 'like', $username . '%')
                    ->where('branch_type',2)
                    ->whereRaw('LENGTH(username) > 13')
                    ->get();
        // $branches = User::whereRaw('LENGTH(username) > 13')->get();
        // dd($branches->count());
        return response()->json($branches);
    }

    // สำหรับเพิ่มรูปไปที่ store
    public function storeFile($files, $app_no = 'files_lab', $name = null)
    {

        $defaultDisk = config('filesystems.default');
        // dd($defaultDisk);

        $no  = str_replace("RQ-","",$app_no);
        $no  = str_replace("-","_",$no);

        if ($files) {

            $attach_path  =  $this->attach_path.$no;
            $file_extension = $files->getClientOriginalExtension();
            $fileClientOriginal   =  HP::ConvertCertifyFileName($files->getClientOriginalName());
            $filename = pathinfo($fileClientOriginal, PATHINFO_FILENAME);
            $fullFileName =  str_random(10).'-date_time'.date('Ymd_hms') . '.' . $files->getClientOriginalExtension();
            $storagePath = Storage::putFileAs($attach_path, $files,  $fullFileName );
            $storageName = basename($storagePath); // Extract the filename
            // dd($attach_path,$no.'/'.$storageName);

            // $filePath = $attach_path .'/'. $fullFileName;
            // if (Storage::disk('ftp')->exists($filePath)) {
            //     dd('File Path on Server: ' . $filePath);
            // } else {
            //     dd('File not found on server!');
            // }
            // dd($filePath);
            return  $no.'/'.$storageName;
        }else{
            return null;
        }
    }



    function getLabCalibrationDate()
    {
        // Get current date as validFrom
        $validFrom = Carbon::now();

        // Calculate until as validFrom + 5 years
        $until = $validFrom->copy()->addYears(5);

        // Thai month names array
        $thaiMonths = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม'
        ];

        // Format validFrom
        $validFromThai = sprintf(
            '%d %s %d',
            $validFrom->day,
            $thaiMonths[$validFrom->month],
            $validFrom->year + 543
        );
        $validFromEnglish = sprintf(
            '%d %s B.E.%d (%d)',
            $validFrom->day,
            $validFrom->format('F'),
            $validFrom->year + 543,
            $validFrom->year
        );

        // Format until
        $untilThai = sprintf(
            '%d %s %d',
            $until->day,
            $thaiMonths[$until->month],
            $until->year + 543
        );
        $untilEnglish = sprintf(
            '%d %s B.E.%d (%d)',
            $until->day,
            $until->format('F'),
            $until->year + 543,
            $until->year
        );

        return [
            'validFrom' => [
                'th' => $validFromThai,
                'en' => $validFromEnglish
            ],
            'until' => [
                'th' => $untilThai,
                'en' => $untilEnglish
            ]
        ];
    }



    function uploadCalLabCmc(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:png|max:2048', // จำกัดขนาดไฟล์ที่ 2 MB
        ]);

        $attachPath  =  $this->attach_path;
        $file = $request->file('file');
        $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.' . $file->getClientOriginalExtension();

        // ใช้ disk 'uploads' ในการจัดเก็บ
        $path = $file->storeAs($attachPath, $fullFileName, 'uploads'); 
        // $storagePath = $this->storeFile($file);

        // dd($path);
        // $certi_lab_attach                   = new CertiLabAttachAll();
        // $certi_lab_attach->app_certi_lab_id = 888888888;
        // $certi_lab_attach->file_section     = 567;
        // $certi_lab_attach->file             = $storagePath;
        // $certi_lab_attach->file_client_name = basename($storagePath);
        // $certi_lab_attach->token            = str_random(16);
        // $certi_lab_attach->default_disk = config('filesystems.default');
        // $certi_lab_attach->save();

        // $url = '/certify/check/file_client/' . $storagePath . '/' . basename($storagePath); 

        // dd( $path );

        // ส่ง URL กลับไป
        $url = asset('uploads/' . $attachPath . $fullFileName);
        // dd($url);
        // $url = url('uploads/' . $attachPath . $fullFileName);
        return response()->json(['file_url' => $url]);

    }

    public function SaveCertiLab($request, $data_session , $token = null, $branchLabInfos ,$mainLabInfo)
    {
        $requestData = $request->all();

        if( is_null($token) ){
            $id = "RQ-LAB-";
            $year = Carbon::now()->addYears(543)->format('y');
            $order = sprintf('%03d',CertiLab::whereYear('created_at',Carbon::now()->year)->count()+1);
            $genId = $id.$year."-".$order;

            $requestLab['app_no'] =  $genId;
        }

        if ($request->lab_ability == 'test'){
            // $requestLab['lab_ability'] = 3;
            $request->lab_ability = 3;

        }elseif ($request->lab_ability == 'calibrate'){
            // $requestLab['lab_ability'] = 4;
            $request->lab_ability = 4;
        }

        if ($request->address_same_headquarter == 'on'){
            $requestLab['address_same_headquarter'] = 1;
            $request->address_same_headquarter = 1;
        } else{
            $requestLab['address_same_headquarter'] = 2;
            $request->address_same_headquarter = 2;
        }

        $requestLab['checkbox_confirm']        = isset($request->checkbox_confirm) ? $request->checkbox_confirm : null;
        $requestLab['purpose_type']            = !empty($request->purpose)?$request->purpose:1;
        $requestLab['standard_id']             = !empty($request->according_formula)?$request->according_formula:null;
        $requestLab['lab_type']                = !empty($request->lab_ability)?$request->lab_ability:null ;
        $requestLab['branch']                  = !empty($request->branch)?$request->branch:null;

        $requestLab['certificate_exports_id']  = !empty($request->certificate_exports_id)?$request->certificate_exports_id:null;
        $requestLab['accereditation_no']       = !empty($request->accereditation_no)?$request->accereditation_no:null;
        $requestLab['lab_name']                = !empty($request->lab_name)?$request->lab_name:null;
        $requestLab['lab_name_en']             = !empty($request->lab_name_en)?$request->lab_name_en:null;
        $requestLab['lab_name_short']          = !empty($request->lab_name)?$request->lab_name_short:null;
        $requestLab['same_address']            = !empty($request->address_same_headquarter)?$request->address_same_headquarter:null;

        //ที่อยู่ ที่อยู่ห้องปฏิบัติการ
        $requestLab['address_no']              = !empty($request->address_number)?$request->address_number:null;
        $requestLab['allay']                   = !empty($request->village_no)?$request->village_no:null;
        $requestLab['village_no']              = !empty($request->address_soi)?$request->address_soi:null;
        $requestLab['road']                    = !empty($request->address_street)?$request->address_street:null;
        $requestLab['province']                = !empty($request->address_city)?$request->address_city:null;
        $requestLab['amphur']                  = !empty($request->address_district)?$request->address_district:null;
        $requestLab['district']                = !empty($request->sub_district)?$request->sub_district:null;
        $requestLab['postcode']                = !empty($request->postcode)?$request->postcode:null;
        $requestLab['tel']                     = !empty($request->address_tel)?$request->address_tel:null;
        $requestLab['tel_fax']                 = !empty($request->fax)?$request->fax:null;

        $requestLab['lab_latitude']            = !empty($request->lab_latitude)?$request->lab_latitude:null;
        $requestLab['lab_longitude']           = !empty($request->lab_longitude)?$request->lab_longitude:null;

        //ที่อยู่ ที่อยู่ห้องปฏิบัติการ EN
        $requestLab['lab_address_no_eng']      = !empty($request->lab_address_no_eng)?$request->lab_address_no_eng:null;
        $requestLab['lab_moo_eng']             = !empty($request->lab_moo_eng)?$request->lab_moo_eng:null;
        $requestLab['lab_soi_eng']             = !empty($request->lab_soi_eng)?$request->lab_soi_eng:null;
        $requestLab['lab_street_eng']          = !empty($request->lab_street_eng)?$request->lab_street_eng:null;
        $requestLab['lab_province_eng']        = !empty($request->lab_province_eng)?$request->lab_province_eng:null;
        $requestLab['lab_amphur_eng']          = !empty($request->lab_amphur_eng)?$request->lab_amphur_eng:null;
        $requestLab['lab_district_eng']        = !empty($request->lab_district_eng)?$request->lab_district_eng:null;
        $requestLab['lab_postcode_eng']        = !empty($request->lab_postcode_eng)?$request->lab_postcode_eng:null;

        //ข้อมูลสำหรับการติดต่อ
        $requestLab['contactor_name']          = !empty($request->contact)?$request->contact:null;
        $requestLab['email']                   = !empty($request->address_email)?$request->address_email:null;
        $requestLab['contact_tel']             = !empty($request->contact_tel)?$request->contact_tel:null; // โทรศัพท์ผู้ติดต่อ
        $requestLab['telephone']               = !empty($request->contact_mobile)?$request->contact_mobile:null; // ทรศัพท์มือถือ

        $requestLab['management_lab']          = isset($request->mn_3_1)?$request->mn_3_1:null;

        //ข้อมูลสำนักงานใหญ่
        $requestLab['hq_address']              = !empty($request->head_num)?$request->head_num:null;
        $requestLab['hq_moo']                  = !empty($request->head_moo)?$request->head_moo:null;
        $requestLab['hq_soi']                  = !empty($request->head_soi)?$request->head_soi:null;
        $requestLab['hq_road']                 = !empty($request->head_street)?$request->head_street:null;
        $requestLab['hq_subdistrict_id']       = !empty($request->hq_subdistrict_id)?$request->hq_subdistrict_id:null;
        $requestLab['hq_district_id']          = !empty($request->hq_district_id)?$request->hq_district_id:null;
        $requestLab['hq_province_id']          = !empty($request->hq_province_id)?$request->hq_province_id:null;
        $requestLab['hq_zipcode']              = !empty($request->head_post)?$request->head_post:null;
        $requestLab['hq_date_registered']      = Carbon::hasFormat($request->entity_date, 'd/m/Y')?Carbon::createFromFormat("d/m/Y", $request->entity_date)->addYear(-543)->format('Y-m-d'):null;
        $requestLab['hq_telephone']            = !empty($request->head_tel)?$request->head_tel:null;
        $requestLab['hq_fax']                  = !empty($request->head_fax)?$request->head_fax:null;

        
        // โอนใบรับรอง
        if(!empty($request->transferer_id_number) && !empty($request->transferee_certificate_number))
        {
          
            $transfererIdNumber = $request->input('transferer_id_number');
            $certificateNumber = $request->input('transferee_certificate_number');           
    
            $certificateExport = CertificateExport::where('certificate_no',$certificateNumber)->first();
           
            if($certificateExport != null){
                $certiLab = CertiLab::where('app_no',$certificateExport->request_number)
                ->where('standard_id',$request->according_formula)
                ->where('lab_type',$request->lab_ability)
                ->first();
    
                if($certiLab != null)
                {
                    $taxId = $certiLab->tax_id;
                    if(trim($taxId) == trim($transfererIdNumber)) 
                    {
                        $requestLab['transferer_user_id']  = $transfererIdNumber;
                        $requestLab['transferer_export_id'] = $certificateExport->id;
                    }
                }
            }

        }





        if($request->lab_ability == 3 )
        {
            // ดึง categories จาก $labMainAddress
            $labTypes = $mainLabInfo['lab_types'];
            foreach ($labTypes as $key => $labTypeValues) {
                if (is_array($labTypeValues)) {
                    foreach ($labTypeValues as $labType) {
                        $categories[] = $labType['test_main_branch_id'];
                    }
                }
            }
            
            // ดึง categories จาก $labAddresses
            foreach ($branchLabInfos as $labAddress) {
                $labTypes = $labAddress['lab_types'];
                foreach ($labTypes as $key => $labTypeValues) {
                    if (is_array($labTypeValues)) {
                        foreach ($labTypeValues as $labType) {
                            $categories[] = $labType['test_main_branch_id'];
                        }
                    }
                }
            }
        }
       
        if($request->lab_ability == 4 )
        {
            // ดึง categories จาก $labMainAddress
            $labTypes = $mainLabInfo['lab_types'];
            foreach ($labTypes as $key => $labTypeValues) {
                if (is_array($labTypeValues)) {
                    foreach ($labTypeValues as $labType) {
                        $categories[] = $labType['cal_main_branch_id'];
                    }
                }
            }
            
            // ดึง categories จาก $labAddresses
            foreach ($branchLabInfos as $labAddress) {
                $labTypes = $labAddress['lab_types'];
                foreach ($labTypes as $key => $labTypeValues) {
                    if (is_array($labTypeValues)) {
                        foreach ($labTypeValues as $labType) {
                            $categories[] = $labType['cal_main_branch_id'];
                        }
                    }
                }
            }
        }



        $categories = $this->getCategories($request);

        // dd( $categories);
// dd($categories,$requestLab['lab_type'] );

        // กลุ่มงานตามมาตรฐานและสาขา
        if($requestLab['lab_type'] == 3){

                $set_standard  =  SetStandardUserSub::select('standard_user_id')
                                                    ->whereIn('test_branch_id',$categories)
                                                    ->first() ;                                
                if(!is_null($set_standard)){
                    $requestLab['subgroup'] =  $set_standard->set_standard_user->sub_department_id ?? 1804;
                }

        }else if($requestLab['lab_type'] == 4){
            //   6. ขอบข่ายที่ยื่นขอรับการรับรอง (สอบเทียบ)

            // if(isset($requestData['calibrate'])){
                // $set_standard  =  SetStandardUserSub::select('standard_user_id')
                //                                     ->whereIn('items_id',(array)$requestData['calibrate']['branch_id'][0])
                //                                     ->first() ;
                // dd($categories);
                $set_standard  =  SetStandardUserSub::select('standard_user_id')
                ->whereIn('test_branch_id',$categories)
                ->first() ;

                // dd($set_standard,$set_standard->set_standard_user->sub_department_id);

                // dd("cal",$set_standard,$set_standard,$set_standard->set_standard_user->sub_department_id);
                // if(!is_null($set_standard)){
                    // dd($set_standard->set_standard_user->sub_department_id);
                    // $requestLab['subgroup'] =  $set_standard->set_standard_user->sub_department_id ?? 1806;
                    $requestLab['subgroup'] =  1806;
                // }
        }

        // dd($categories);

        if(  is_null($token) ){

            if ($request->save){
                $requestLab['status'] = 1;
                $requestLab['start_date'] =  date('Y-m-d');
            }else{
                $requestLab['status'] = 0;
            }
            if($request->status == 1){}

            $requestLab['applicanttype_id']   =   !empty($data_session->applicanttype_id) ? $data_session->applicanttype_id : null;
            $requestLab['tax_id']             =   !empty($data_session->tax_number) ? $data_session->tax_number : null;
            $requestLab['created_by']         =   !empty($data_session->id) ? $data_session->id : null;
            $requestLab['name']               =   !empty($data_session->name) ? $data_session->name : null;
            $requestLab['agent_id']           =   !empty($data_session->agent_id) ? $data_session->agent_id : null;
            $requestLab['branch_type']        =   !empty($data_session->branch_type)?$data_session->branch_type:1;
            $requestLab['token']              =   str_random(16);

            $certi_lab = CertiLab::create($requestLab);
        }else{

            $certi_lab = CertiLab::where('token',$token)->first();
            // วันที่เปลี่ยนสถานะฉบับร่างเป็นรอดำเนินการตรวจ
            if($request->save == 1 && $certi_lab->status == 0 ){
                $requestLab['created_at'] = date('Y-m-d h:m:s');
                $requestLab['start_date'] = !empty( $certi_lab->start_date)?$certi_lab->start_date: date('Y-m-d');
            }

            // if($request->save == 1 ){
            //     $requestLab['start_date'] = date('Y-m-d');
            // }

            if ($certi_lab->status == 3){  // ขอเอกสารเพิ่มเติม
                $status = 3;  //Mail
                $requestLab['status'] = 2;
            }else{
                $status = 1;  //Mail
                if ($request->save){
                    $requestLab['status'] =  1;
                }
                if ($request->draft){
                    $requestLab['status'] = 0;
                }
            }

            $certi_lab->update( $requestLab );
        }


        return $certi_lab;

    }

    public function getCategories($request){
        $_labAblity = "";
        if($request->lab_ability == 3 )
        {
            $_labAblity = "test";
        }elseif($request->lab_ability == 4)
        {
            $_labAblity = "calibrate";
        }
//  dd("oo");
        $labHtmlTemplate = LabHtmlTemplate::where('user_id',auth()->user()->id)
            ->where('according_formula',$request->according_formula)
            ->where('purpose',$request->purpose)
            ->where('lab_ability',$_labAblity)
            ->first();

        $jsondata = null;
        if($labHtmlTemplate == null){
             

             if($request->purpose != 1)
             {


             $check = LabHtmlTemplate::where('user_id',auth()->user()->id)
                ->where('according_formula',$request->according_formula)
                // ->where('purpose',$request->purpose)
                ->where('lab_ability',$_labAblity)
                ->latest()->first();

                }

                $jsondata = $check->json_data;


             



            //  dd($labHtmlTemplate);

        }else{
            $jsondata = $labHtmlTemplate->json_data;
        }

        // dd($jsondata);
        $labCalItemsCollection = collect($jsondata);

        $categories = $labCalItemsCollection->map(function ($item) {
            // Decode the JSON string into an array
            $decoded = json_decode($item, true);
            return $decoded[0]['field'] ?? null;
        })->unique()->values()->all();
        return $categories;
    }

    public function SaveInformation($request, $certilab)
    {
        // dd($request->all());
        $certi_information =  Information::where('app_certi_lab_id',$certilab->id)->first();
        if( is_null($certi_information) ){
            $certi_information = new Information();
            $certi_information->token = str_random(16);
        }


        $certi_information->app_certi_lab_id            = $certilab->id;
        $certi_information->name                        = !empty($request->app_name)?$request->app_name:null;
        $certi_information->ages                        = !empty($request->app_old)?$request->app_old:null;
        $certi_information->nationality                 = !empty($request->app_nation)?$request->app_nation:null;
        $certi_information->tax_indentification_number  = !empty($request->id_tax)?$request->id_tax:null;
        $certi_information->address_headquarters        = !empty($request->head_num)?$request->head_num:null;
        $certi_information->headquarters_alley          = !empty($request->head_soi)?$request->head_soi:null;
        $certi_information->headquarters_road           = !empty($request->head_street)?$request->head_street:null;
        $certi_information->headquarters_village_no     = !empty($request->head_moo)?$request->head_moo:null;
        $certi_information->headquarters_district       = !empty($request->head_tumbon)?$request->head_tumbon:null;
        $certi_information->headquarters_amphur         = !empty($request->head_area)?$request->head_area:null;
        $certi_information->headquarters_province       = !empty($request->head_province)?$request->head_province:null;
        $certi_information->headquarters_postcode       = !empty($request->head_post)?$request->head_post:null;
        $certi_information->headquarters_tel            = !empty($request->head_tel)?$request->head_tel:null;
        $certi_information->headquarters_tel_fax        = !empty($request->head_fax)?$request->head_fax:null;
        $certi_information->date_regis_juristic_person  = !empty($request->entity_date)?Carbon::createFromFormat("d/m/Y",$request->entity_date)->addYear(-543)->formatLocalized('%Y-%m-%d'):null;

        $certi_information->save();

        
    }

    public function SaveCertiLabPlace($request, $certilab)
    {
        $certi_lab_place =  CertiLabPlace::where('app_certi_lab_id',$certilab->id)->first();
        if( is_null($certi_lab_place) ){
            $certi_lab_place = new CertiLabPlace();
            $certi_lab_place->token = str_random(16);
        }
        $certi_lab_place->app_certi_lab_id          = $certilab->id;
        $certi_lab_place->permanent_operating_site  = isset($request->pl_2_1)?$request->pl_2_1:null;
        $certi_lab_place->off_site_operations       = isset($request->pl_2_2)?$request->pl_2_2:null;
        $certi_lab_place->temporary_operating_site  = isset($request->pl_2_4)?$request->pl_2_4:null;
        $certi_lab_place->mobile_operating_facility = isset($request->pl_2_3)?$request->pl_2_3:null;
        $certi_lab_place->multi_site_facility       = isset($request->pl_2_5)?$request->pl_2_5:null;

        $certi_lab_place->save();
    }

    public function SaveCertiLabInfo($request, $certilab)
    {
        $certi_lab_info =  CertiLabInfo::where('app_certi_lab_id',$certilab->id)->first();
        if( is_null($certi_lab_info) ){
            $certi_lab_info = new CertiLabInfo();
            $certi_lab_info->token = str_random(16);
        }
        $certi_lab_info->app_certi_lab_id           = $certilab->id;
        $certi_lab_info->petitioner                 = !empty($request->man_applicant)?$request->man_applicant:null;
        $certi_lab_info->lab_type_other             = isset($request->at_1_1_1)?$request->at_1_1_1:null;

        if($request->hasFile('activity_file')){
            $certi_lab_info->desc_main_file         = $this->storeFile($request->activity_file,$certilab->app_no) ?? null;
            $certi_lab_info->activity_client_name   = HP::ConvertCertifyFileName($request->activity_file->getClientOriginalName());
        }
        if($request->hasFile('file_section')){
            $certi_lab_info->file_section           = $this->storeFile($request->file_section,$certilab->app_no) ?? null;
            $certi_lab_info->file_client_name       = HP::ConvertCertifyFileName($request->file_section->getClientOriginalName());
        }
        $certi_lab_info->only_own_depart               = isset($request->at_1_1_3)?$request->at_1_1_3:null;
        $certi_lab_info->depart_other                  = isset($request->at_1_1_4)?$request->at_1_1_4:null;
        $certi_lab_info->over_twenty                   = isset($request->at_1_1_5)?$request->at_1_1_5:null;
        $certi_lab_info->not_bankrupt                  = isset($request->at_1_1_6)?$request->at_1_1_6:null;
        $certi_lab_info->not_being_incompetent         = isset($request->at_1_1_7)?$request->at_1_1_7:null;
        $certi_lab_info->suspended_using_a_certificate = isset($request->at_1_1_8)?$request->at_1_1_8:null;
        $certi_lab_info->never_revoke_a_certificate    = isset($request->at_1_1_9)?$request->at_1_1_9:null;
        $certi_lab_info->save();
    }

    public function SaveFileSection($request, $name, $input_name, $section, $certilab )
    {
        $requestData = $request->all();
        if( isset($requestData[ $name ]) ){
            $repeater_list = $requestData[ $name ];

            foreach( $repeater_list AS $item ){

                if( isset($item[ $input_name ]) ){
                    // dd($item[ $input_name ]);
                    $certi_lab_attach                   = new CertiLabAttachAll();
                    $certi_lab_attach->app_certi_lab_id = $certilab->id;
                    $certi_lab_attach->file_section     = (string)$section;
                    $certi_lab_attach->file             = $this->storeFile( $item[ $input_name ] ,$certilab->app_no);
                    $certi_lab_attach->file_client_name = HP::ConvertCertifyFileName( $item[ $input_name ]->getClientOriginalName());
                    $certi_lab_attach->token            = str_random(16);
                    $certi_lab_attach->default_disk = config('filesystems.default');
                    $certi_lab_attach->save();

                }

            }

        }
    }

    public function SaveFileMore($request, $certilab )
    {

        $requestData = $request->all();
        if( isset($requestData[ 'repeater-section-other' ]) ){
            $repeater_list = $requestData[ 'repeater-section-other' ];

            foreach( $repeater_list AS $item ){
                if( isset($item[ 'another_attach_files' ]) ){

                    $certi_lab_attach_more                   = new CertiLabAttachMore();
                    $certi_lab_attach_more->app_certi_lab_id = $certilab->id;
                    $certi_lab_attach_more->file_desc        = !empty($item[ 'another_attach_files_desc' ])?$item[ 'another_attach_files_desc' ]:null;
                    $certi_lab_attach_more->file             = $this->storeFile( $item[ 'another_attach_files' ] ,$certilab->app_no);
                    $certi_lab_attach_more->file_client_name = HP::ConvertCertifyFileName( $item[ 'another_attach_files' ]->getClientOriginalName());
                    $certi_lab_attach_more->token            = str_random(16);
                    $certi_lab_attach_more->save();

                }
            }

        }

    }

    // private function save_certify_test_scope($main, $requestData){
    //     CertifyTestScope::where('app_certi_lab_id', $main->id)->delete();

    //     if( isset($requestData['test_scope']) ){
    //         /* ขอบข่ายที่ยื่นขอรับการรับรอง (ทดสอบ) */
    //         $test_scope = (array)@$requestData['test_scope'];

    //         foreach($test_scope['branch_id'] as $key => $itme) {
    //             $input = [];
    //             $input['app_certi_lab_id'] = $main->id;
    //             //   $input['category_product_id'] = $itme;
    //             $input['branch_id'] = $itme;
    //             $input['token'] = str_random(16);
    //             CertifyTestScope::create($input);
    //         }
    //     }

    // }

    private function save_certify_test_scope($main, $jsonData){
        CertifyTestScope::where('app_certi_lab_id', $main->id)->delete();

        // if( isset($requestData['test_scope']) ){
            /* ขอบข่ายที่ยื่นขอรับการรับรอง (ทดสอบ) */
            // $test_scope = (array)@$requestData['test_scope'];

            foreach($jsonData as $key => $itme) {
                $input = [];
                $input['app_certi_lab_id'] = $main->id;
                //   $input['category_product_id'] = $itme;
                $input['branch_id'] = $itme;
                $input['token'] = str_random(16);
                CertifyTestScope::create($input);
            }
        // }

    }
    private function save_certifyLab_calibrate($main, $jsonData){
        CertifyLabCalibrate::where('app_certi_lab_id', $main->id)->delete();

        // if( isset($requestData['calibrate']) ){
            /*  ขอบข่ายที่ยื่นขอรับการรับรอง (ทดสอบ) */
            // $calibrate = (array)@$requestData['calibrate'];
            foreach($jsonData as $key => $itme) {
                // dd($main->id,$itme);
                $input = [];
                $input['app_certi_lab_id'] = $main->id;
                //   $input['group_id'] = $itme;
                $input['branch_id'] = $itme;
                $input['token'] = str_random(16);
                CertifyLabCalibrate::create($input);
                
            }
        // }

    }

    

    public function copyExistFiles($newCertiLab, $certiLabId)
    {
        // ค้นหา CertiLab ที่ต้องการ
        $certilab = CertiLab::find($certiLabId);
    
        // ดึงไฟล์ที่เกี่ยวข้องจากฐานข้อมูล
        $existingFiles = CertiLabAttachAll::where('app_certi_lab_id', $certilab->id)->get();
    
        foreach ($existingFiles as $file) {
            // ดึง path เต็มของไฟล์จากฐานข้อมูล
            $filePath = public_path('uploads/files/applicants/check_files/' . $file->file);

            $newFilePath = $this->storeExistingFile($filePath, $newCertiLab->app_no);
    
            if ($newFilePath) {
                // บันทึกไฟล์ใหม่ในฐานข้อมูล
                $newFile = new CertiLabAttachAll();
                $newFile->app_certi_lab_id = $newCertiLab->id;
                $newFile->file_section = $file->file_section;
                $newFile->file = $newFilePath;
                $newFile->file_client_name = $file->file_client_name;
                $newFile->token = str_random(16);
                $newFile->save();
            } else {
                dd('Error copying file from ' . $filePath . ' to ' . $newFilePath);
            }
        }

        $existingMoreFiles = CertiLabAttachMore::where('app_certi_lab_id', $certilab->id)->get();

        foreach ($existingMoreFiles as $moreFile) {
            // ดึง path เต็มของไฟล์จากฐานข้อมูล
            $filePath = public_path('uploads/files/applicants/check_files/' . $moreFile->file);

            $newFilePath = $this->storeExistingFile($filePath, $newCertiLab->app_no);
    
            if ($newFilePath) {
                // บันทึกไฟล์ใหม่ในฐานข้อมูล
                $newFile = new CertiLabAttachMore();
                $newFile->app_certi_lab_id = $newCertiLab->id;
                $newFile->file_desc = $moreFile->another_attach_files_desc;
                $newFile->file = $newFilePath;
                $newFile->file_client_name = $moreFile->file_client_name;
                $newFile->token = str_random(16);
                $newFile->save();
            } 
        }


    }
    
    public function storeExistingFile($existingFilePath, $app_no = 'files_lab', $name = null)
    {
        $no  = str_replace("RQ-", "", $app_no);
        $no  = str_replace("-", "_", $no);

        if ($existingFilePath) {
            // สร้าง path ที่เก็บไฟล์
            $attach_path = $this->attach_path . $no;

            // ดึงข้อมูลไฟล์จาก path เดิม
            $fileClientOriginal = basename($existingFilePath); // ใช้ไฟล์ที่มีอยู่แล้ว
            $file_extension = pathinfo($fileClientOriginal, PATHINFO_EXTENSION);
            $filename = pathinfo($fileClientOriginal, PATHINFO_FILENAME);

            // สร้างชื่อไฟล์ใหม่
            $fullFileName = str_random(10) . '-date_time' . date('Ymd_hms') . '.' . $file_extension;

            // ใช้ Storage เพื่อเก็บไฟล์โดยใช้ไฟล์เดิม
            $storagePath = Storage::putFileAs($attach_path, new \Illuminate\Http\File($existingFilePath), $fullFileName);
            $storageName = basename($storagePath);

            return $no . '/' . $storageName;
        } else {
            return null;
        }
    }




    public function store(Request $request)
    {

       
        $newLabAbility = $request->lab_ability;
        $mainLabInfo = json_decode($request->input('main_lab_info'), true);
        $branchLabInfos = json_decode($request->input('branch_lab_infos'), true) ?? [];
       
        $user = auth()->user();
       

        $labHtmlTemplate = LabHtmlTemplate::where('user_id',$user->id)
            ->where('according_formula',$request->according_formula)
            ->where('purpose',$request->purpose)
            ->where('lab_ability',$newLabAbility)
            ->first();

            // dd($labHtmlTemplate);
        $checkLabHtmlTemplate = null;
        if($labHtmlTemplate == null){
           
            if($request->purpose != 1){
                $checkLabHtmlTemplate = LabHtmlTemplate::where('user_id',$user->id)
                    ->where('according_formula',$request->according_formula)
                    ->where('lab_ability',$newLabAbility)
                    ->latest()->first();
                // dd($checkLabHtmlTemplate,$request->all());
            }
      
        }
            

    //   dd($user->id,$request->all(),$template_type,$labHtmlTemplate );
$province = Province::find($request->address_city);
    // dd($request->all(),$province);
        $model = str_slug('applicant','-');
        $data_session     =    HP::CheckSession();
       
        if(!empty($data_session)){

            if(HP::CheckPermission('add-'.$model)){
                // try {
                    $requestData = $request->all();
 
                    // add ceti lab
                    $certilab = $this->SaveCertiLab($request, $data_session , null, $branchLabInfos ,$mainLabInfo );
// dd("ok");
                    if($labHtmlTemplate !== null)
                    {
                         $labHtmlTemplate->update([
                            'app_certi_lab_id' => $certilab->id
                         ]);
                    }else{
                      
                        if($request->purpose == 1){
                            LabHtmlTemplate::create([
                                'user_id' => $user->id,
                                'according_formula' => $request->according_formula,
                                'purpose' => $request->purpose,
                                'lab_ability' => $newLabAbility,
                                'app_certi_lab_id' => $certilab->id
                            ]);
                        }else{
                            //   dd("ddd",$request->according_formula,$request->lab_ability);
                            if($checkLabHtmlTemplate != null){

                               $labHtmlTemplate = LabHtmlTemplate::create([
                                    'user_id' => $user->id,
                                    'according_formula' => $request->according_formula,
                                    'purpose' => $request->purpose,
                                    'lab_ability' => $newLabAbility,
                                    'app_certi_lab_id' => $certilab->id,
                                    'json_data' => $checkLabHtmlTemplate->json_data,
                                    'html_pages' => $checkLabHtmlTemplate->html_pages,
                                    'template_type' => $checkLabHtmlTemplate->template_type,
                                ]);

                                // ,'html_pages', 'template_type','json_data'

                                // dd($labHtmlTemplate);
                                //  dd($checkLabHtmlTemplate,$labHtmlTemplate,$request->all(),$request->lab_ability,$request->purpose,$newLabAbility);
                            }
                            
                        }
                       
                    }
                    // dd("o");
                    // Save information
                    $this->SaveInformation($request, $certilab);
                   
                    // Save Place
                    $this->SaveCertiLabPlace($request, $certilab);

                    //Save lab info
                    $this->SaveCertiLabInfo($request, $certilab);
                    
                    // ตรวจสอบคำขอใบรับรองห้องปฏิบัติการ
                    $check = new Check;
                    $check->app_certi_lab_id = $certilab->id;
                    $check->save();

       
                    // $branchCategories = [
                    //     'branch_id' => $this->getCategories($request)
                    // ];

                    

                    // // dd($branchCategories);
                    // if($certilab->lab_type == 3){
                    //     //   6. ขอบข่ายที่ยื่นขอรับการรับรอง (ทดสอบ)
                    //     $requestData['test_scope'] = $branchCategories;
                    //     if(isset($requestData['test_scope'])){
                    //         $this->save_certify_test_scope($certilab,$requestData);
                    //     }
                    // }else if($certilab->lab_type == 4){
                    //     //   6. ขอบข่ายที่ยื่นขอรับการรับรอง (สอบเทียบ)
                    //     $requestData['calibrate'] = $branchCategories;
                    //     if(isset($requestData['calibrate'])){
                    //         $this->save_certifyLab_calibrate($certilab,$requestData);
                    //     }
                    // }

                    
                         $template_ability = "";
                        if($certilab->lab_type == 4){
                            $template_ability = "calibrate";
                        }else if($certilab->lab_type == 3)
                        {
                            $template_ability = "test";
                        }

                        $labHtmlTemplate = LabHtmlTemplate::where('user_id',auth()->user()->id)
                        ->where('according_formula',$request->according_formula)
                        ->where('purpose',$request->purpose)
                        ->where('lab_ability',$template_ability)
                        ->first();


                    

                        $jsonDataString = $labHtmlTemplate->json_data;

                        $dataArray = json_decode($jsonDataString, true);

                       

                        // 2. ดึงค่าจาก key 'field' ทั้งหมดออกมาเป็น array ใหม่
                        $fieldArray = array_column($dataArray, 'field');
              
                       $uniqueArray = array_unique($fieldArray);
                        if($certilab->lab_type == 3){

                            $this->save_certify_test_scope($certilab,$uniqueArray);
                        }else if($certilab->lab_type == 4)
                        {
                             

                            $this->save_certifyLab_calibrate($certilab,$uniqueArray);
                        }

                       

                        //  $template_ability = "";
                        // if($certilab->lab_type == 4){
                        //     $template_ability = "calibrate";
                        // }else if($certilab->lab_type == 3)
                        // {
                        //     $template_ability = "test";
                        // }


                    
                    // $labHtmlTemplate = LabHtmlTemplate::where('user_id',auth()->user()->id)
                    //     ->where('according_formula',$request->according_formula)
                    //     ->where('purpose',$request->purpose)
                    //     ->where('lab_ability',$template_ability)
                    //     ->first();


                    

                    //     $jsonDataString = $labHtmlTemplate->json_data;

                    //     $dataArray = json_decode($jsonDataString, true);


                    //     // 2. ดึงค่าจาก key 'field' ทั้งหมดออกมาเป็น array ใหม่
                    //     $fieldArray = array_column($dataArray, 'field');
              
                       
                    //     if($certilab->lab_type == 3){

                    //         $this->save_certify_test_scope($certilab,$fieldArray);
                    //     }else if($certilab->lab_type == 4)
                    //     {
                    //         $this->save_certifyLab_calibrate($certilab,$fieldArray);
                    //     }

                    

                    if ( isset($requestData['repeater-section4'] ) ){
                        $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certilab );
                    }

                    if ( isset($requestData['repeater-section5'] ) ){
                        $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certilab );
                    }

                    // if ( isset($requestData['repeater-section61'] ) ){
                    //     $this->SaveFileSection($request, 'repeater-section61', 'attachs_sec61', 61 , $certilab );
                    // }

                    // if ( isset($requestData['repeater-section62'] ) ){
                    //     $this->SaveFileSection($request, 'repeater-section62', 'attachs_sec62', 62 , $certilab );
                    // }

                    if ( isset($requestData['repeater-section71'] ) ){
                        $this->SaveFileSection($request, 'repeater-section71', 'attachs_sec71', 71 , $certilab );
                    }

                    if ( isset($requestData['repeater-section72'] ) ){
                        $this->SaveFileSection($request, 'repeater-section72', 'attachs_sec72', 72 , $certilab );
                    }

                    if ( isset($requestData['repeater-section8'] ) ){
                        $this->SaveFileSection($request, 'repeater-section8', 'attachs_sec8', 8 , $certilab );
                    }

                    if ( isset($requestData['repeater-section9'] ) ){
                        $this->SaveFileSection($request, 'repeater-section9', 'attachs_sec9', 9 , $certilab );
                    }

                    if ( isset($requestData['repeater-section10'] ) ){
                        $this->SaveFileSection($request, 'repeater-section10', 'attachs_sec10', 10 , $certilab );
                    }

                    if ( isset($requestData['repeater-section-other'] ) ){
                        $this->SaveFileMore($request, $certilab );
                    }
                   
                    // dd($request->all());
                    // เงื่อนไขเช็คมีใบรับรอง
                    $this->save_certilab_export_mapreq( $certilab );

                    $request_type = "";
                    if($certilab->lab_type == 3){
                        $request_type = "test";
                    }else if($certilab->lab_type == 4){
                        $request_type = "cal";
                    }
                    
                    $labScopeTransaction = new LabScopeTransaction();
                    $labScopeTransaction->app_certi_lab_id = $certilab->id;
                    $labScopeTransaction->lab_type = $mainLabInfo['lab_type'] ?? 'main';
                    $labScopeTransaction->request_type = $request_type;
                    $labScopeTransaction->address_number = $request->address_number ?? '';
                    $labScopeTransaction->village_no = $request->village_no ?? ''; // แก้จาก address_moo_add
                    $labScopeTransaction->address_city = $request->address_city ?? '';
                    $labScopeTransaction->address_city_text = trim($province->PROVINCE_NAME) ?? '';
                    $labScopeTransaction->address_district = $request->address_district ?? '';
                    $labScopeTransaction->sub_district = $request->sub_district ?? '';
                    $labScopeTransaction->postcode = $request->postcode  ?? '';
                    $labScopeTransaction->address_soi = $request->address_soi  ?? '';
                    $labScopeTransaction->address_street = $request->address_street  ?? '';
                    $labScopeTransaction->labress_no_eng = $request->lab_address_no_eng  ?? ''; // แก้จาก labress_no_eng
                    $labScopeTransaction->lab_moo_eng = $request->lab_moo_eng   ?? '';
                    $labScopeTransaction->lab_soi_eng = $request->lab_soi_eng   ?? '';
                    $labScopeTransaction->lab_street_eng = $request->lab_street_eng  ?? '';
                    $labScopeTransaction->lab_province_text_eng =  trim($province->PROVINCE_NAME_EN) ?? '';
                    $labScopeTransaction->lab_amphur_eng =$request->lab_amphur_eng   ?? '';
                    $labScopeTransaction->lab_district_eng = $request->lab_district_eng   ?? '';
                    $labScopeTransaction->lab_types = json_encode($mainLabInfo['lab_types'] ?? []); // แปลงเป็น JSON

                    $labScopeTransaction->save();

                    // foreach ($branchLabInfos as $branchId => $branchLabInfo) {
                    //     $labScopeTransaction = new LabScopeTransaction();
                    //     $labScopeTransaction->app_certi_lab_id = $certilab->id;
                    //     $labScopeTransaction->request_type = $request_type;
                    //     $labScopeTransaction->lab_type = $mainLabInfo['lab_type'] ?? 'branch';;
                    //     $labScopeTransaction->branch_id = $branchId;
                    //     $labScopeTransaction->address_number = $branchLabInfo['address_number_add'] ?? '';
                    //     $labScopeTransaction->village_no = $branchLabInfo['village_no_add'] ?? ''; // แก้จาก address_moo_add
                    //     $labScopeTransaction->address_city = $branchLabInfo['address_city_add'] ?? '';
                    //     $labScopeTransaction->address_city_text = $branchLabInfo['address_city_text_add'] ?? '';
                    //     $labScopeTransaction->address_district = $branchLabInfo['address_district_add'] ?? '';
                    //     $labScopeTransaction->sub_district = $branchLabInfo['sub_district_add'] ?? '';
                    //     $labScopeTransaction->postcode = $branchLabInfo['postcode_add'] ?? '';
                    //     $labScopeTransaction->address_soi = $branchLabInfo['address_soi_add'] ?? '';
                    //     $labScopeTransaction->address_street = $branchLabInfo['address_street_add'] ?? '';
                    //     $labScopeTransaction->lab_address_no_eng = $branchLabInfo['lab_address_no_eng_add'] ?? ''; // แก้จาก labress_no_eng
                    //     $labScopeTransaction->lab_moo_eng = $branchLabInfo['lab_moo_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_soi_eng = $branchLabInfo['lab_soi_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_street_eng = $branchLabInfo['lab_street_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_province_text_eng = $branchLabInfo['lab_province_text_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_amphur_eng = $branchLabInfo['lab_amphur_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_district_eng = $branchLabInfo['lab_district_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_types = json_encode($branchLabInfo['lab_types'] ?? []); // แปลงเป็น JSON
    
                    //     $labScopeTransaction->save();
                    // }


                    // if($certilab->lab_type == 4){
                    //     $labCalRequest = new LabCalRequest();

                    //     $labCalRequest->app_certi_lab_id = $certilab->id;
                    //     $labCalRequest->type = 1; // หรือกำหนดค่าตามที่ต้องการ
                    //     $labCalRequest->no = $mainLabInfo['address_number_add'] ?? '';
                    //     $labCalRequest->moo = $mainLabInfo['address_moo_add'] ?? '';
                    //     $labCalRequest->province_id = $mainLabInfo['address_city_add'] ?? '';
                    //     $labCalRequest->province_name = $mainLabInfo['address_city_text_add'] ?? '';
                    //     $labCalRequest->amphur_id = $mainLabInfo['amphur_id_add'] ?? '';
                    //     $labCalRequest->amphur_name = $mainLabInfo['address_district_add'] ?? '';
                    //     $labCalRequest->tambol_id = $mainLabInfo['tambol_id_add'] ?? '';
                    //     $labCalRequest->tambol_name = $mainLabInfo['sub_district_add'] ?? '';
                    //     $labCalRequest->postal_code = $mainLabInfo['postcode_add'] ?? '';
                    //     $labCalRequest->soi = $mainLabInfo['address_soi_add'] ?? '';
                    //     $labCalRequest->street = $mainLabInfo['address_street_add'] ?? '';
                    //     $labCalRequest->no_eng = $mainLabInfo['lab_address_no_eng_add'] ?? '';
                    //     $labCalRequest->moo_eng = $mainLabInfo['lab_moo_eng_add'] ?? '';
                    //     $labCalRequest->soi_eng = $mainLabInfo['lab_soi_eng_add'] ?? '';
                    //     $labCalRequest->street_eng = $mainLabInfo['lab_street_eng_add'] ?? '';
                    //     $labCalRequest->province_name_eng = $mainLabInfo['lab_province_text_eng_add'] ?? '';
                    //     $labCalRequest->amphur_name_eng = $mainLabInfo['lab_amphur_eng_add'] ?? '';
                    //     $labCalRequest->tambol_name_eng = $mainLabInfo['lab_district_eng_add'] ?? '';

                    //     $labCalRequest->save();
                    // }
                    // else if($certilab->lab_type == 3)
                    // {
                    //         $labTestRequest = new LabTestRequest();
                    //         $labTestRequest->app_certi_lab_id = $certilab->id;
                    //         $labTestRequest->type = 1; // หรือกำหนดค่าตามที่ต้องการ
                    //         $labTestRequest->no = $labMainAddress['address_number_add'] ?? '';
                    //         $labTestRequest->moo = $labMainAddress['address_moo_add'] ?? '';
                    //         $labTestRequest->province_id = $labMainAddress['address_city_add'] ?? '';
                    //         $labTestRequest->province_name = $labMainAddress['address_city_text_add'] ?? '';
                    //         $labTestRequest->amphur_id = $labMainAddress['amphur_id_add'] ?? '';
                    //         $labTestRequest->amphur_name = $labMainAddress['address_district_add'] ?? '';
                    //         $labTestRequest->tambol_id = $labMainAddress['tambol_id_add'] ?? '';
                    //         $labTestRequest->tambol_name = $labMainAddress['sub_district_add'] ?? '';
                    //         $labTestRequest->postal_code = $labMainAddress['postcode_add'] ?? '';
                    //         $labTestRequest->soi = $labMainAddress['address_soi_add'] ?? '';
                    //         $labTestRequest->street = $labMainAddress['address_street_add'] ?? '';
                    //         $labTestRequest->no_eng = $labMainAddress['lab_address_no_eng_add'] ?? '';
                    //         $labTestRequest->moo_eng = $labMainAddress['lab_moo_eng_add'] ?? '';
                    //         $labTestRequest->soi_eng = $labMainAddress['lab_soi_eng_add'] ?? '';
                    //         $labTestRequest->street_eng = $labMainAddress['lab_street_eng_add'] ?? '';
                    //         $labTestRequest->province_name_eng = $labMainAddress['lab_province_text_eng_add'] ?? '';
                    //         $labTestRequest->amphur_name_eng = $labMainAddress['lab_amphur_eng_add'] ?? '';
                    //         $labTestRequest->tambol_name_eng = $labMainAddress['lab_district_eng_add'] ?? '';
                    //         $labTestRequest->save();
                    // }


                    // dd($labHtmlTemplate);
                    if($certilab->status != 0){
                        $this->exportScopePdf($certilab->id,$labHtmlTemplate,'draft');
                    }
                    
                    // $pdfService = new CreateLabScopePdf($certilab);
                    // $pdfContent = $pdfService->generatePdf();

                    $babCalScopeUsageStatus = new LabCalScopeUsageStatus();
                    $babCalScopeUsageStatus->app_certi_lab_id = $certilab->id;
                    $babCalScopeUsageStatus->group = 1;
                    $babCalScopeUsageStatus->status = 2;
                    $babCalScopeUsageStatus->save();

                    $labRequestType = new LabRequestType();
                    $labRequestType->app_certi_lab_id = $certilab->id;
                    $labRequestType->request_type = $request->purpose;
                    $labRequestType->certificate_id = $request->select_certified_temp;
                    $labRequestType->save();
   
                    // ส่ง Email
                    if($certilab->status == 1){
                        $this->SET_EMAIL($certilab,1);
                    }

                    if(!empty($request->transferer_id_number) && !empty($request->transferee_certificate_number))
                    {
                      
                        $transfererIdNumber = $request->input('transferer_id_number');
                        $certificateNumber = $request->input('transferee_certificate_number');           
                
                        $certificateExport = CertificateExport::where('certificate_no',$certificateNumber)->first();
                       
                        if($certificateExport != null){
                            $certiLab = CertiLab::where('app_no',$certificateExport->request_number)
                            ->where('standard_id',$request->according_formula)
                            ->where('lab_type',$request->lab_ability)
                            ->first();
                
                            if($certiLab != null)
                            {
                                $taxId = $certiLab->tax_id;
                                if(trim($taxId) == trim($transfererIdNumber)) 
                                {
                                    $user = User::where('username',$transfererIdNumber)->first();
                                    
                                    $data_app =  [
                                                'certiLab'=>  $certiLab,
                                                'certificateExport'=>  $certificateExport,
                                                'transferee' => auth()->user(),
                                                'transferer' => $user,
                                                ];

                                    $html = new NotifyTransferer($data_app);
                                    $mail =  Mail::to($user->email)->send($html);


                                }
                            }
                        }
            
            
                    }

            // dd($request->all());

                    return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');

                abort(403);
            }else{
                return  redirect(HP::DomainTisiSso());
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($token)
    {
        // dd('ok');
        // = CertiLab::findOrFail($token);
        $certi_lab = CertiLab::where('token',$token)->first();
        $certi_information = Information::where('app_certi_lab_id',$certi_lab->id)->first();
        $certi_lab['app_name'] = $certi_information->name ?? '-' ;
        $certi_lab['app_old'] = $certi_information->ages ?? '-' ;
        $certi_lab['app_nation'] = $certi_information->nationality ?? '-' ;
        $certi_lab['home_num'] = $certi_information->address_no ?? '-' ;
        $certi_lab['home_soi'] = $certi_information->alley ?? '-' ;
        $certi_lab['home_street'] = $certi_information->road ?? '-' ;
        $certi_lab['home_moo'] = $certi_information->village_no ?? '-' ;
        $certi_lab['home_province'] = $certi_information->province ?? '-' ;
        $certi_lab['home_area'] = $certi_information->amphur ?? '-' ;
        $certi_lab['home_tumbon'] = $certi_information->district ?? '-' ;
        $certi_lab['home_post'] = $certi_information->postcode ?? '-' ;
        $certi_lab['home_phone'] = $certi_information->tel ?? '-' ;

    //    return $certi_lab;

        // add certi lab info
        $certi_lab_info =  CertiLabInfo::where('app_certi_lab_id',$certi_lab->id)->first();
        if(is_null($certi_lab_info)){
            $certi_lab_info = new CertiLabInfo;
        }
       // add certi lab place
         $certi_lab_place =  CertiLabPlace::where('app_certi_lab_id',$certi_lab->id)->first();
         if(is_null($certi_lab_place)){
            $certi_lab_place = new CertiLabPlace;
        }
        $branchs = DB::table('bcertify_test_branches')->select('*')->where('state',1)->pluck('title','id');
        $calibration_branchs = DB::table('bcertify_calibration_branches')->select('*')->where('state',1)->pluck('title','id');
        $province = DB::table('province')->select('*')->get();

        $attaches = DB::table('bcertify_config_attach_forms')->select('*')->where('form',1)->get();
        $certi_lab_attach_more = CertiLabAttachMore::where('app_certi_lab_id',$certi_lab->id)->get();
        $certi_lab_attach_all5 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '5')
                                                  ->get();
        $certi_lab_attach_all61 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '61')
                                                  ->get();
        $certi_lab_attach_all62 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '62')
                                                  ->get();
        $certi_lab_attach_all71 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '71')
                                                  ->get();
        $certi_lab_attach_all72 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '72')
                                                  ->get();
        $certi_lab_attach_all8 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '8')
                                                  ->get();
        $certi_lab_attach_all9 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                  ->where('file_section', '9')
                                                  ->get();
         $certi_lab_check_box = CertiLabCheckBox::where('app_certi_lab_id',$certi_lab->id)->first();
         if(is_null($certi_lab_check_box)){
            $certi_lab_check_box = new CertiLabCheckBox;
         }
        $certi_lab_check_box_image = !is_null($certi_lab_check_box) ? CertiLabCheckBoxImage::where('app_certi_lab_check_box_id', $certi_lab_check_box->id)->get() : null;
        $CertiLabDeleteFile = CertiLabDeleteFile::where('app_certi_lab_id', $certi_lab->id) ->get();

        $app_certi_labs = DB::table('app_certi_labs')->where('lab_type',$certi_lab->lab_type)->where('tax_id',$certi_lab->tax_id)->select('id');

        $certificate_exports = DB::table('certificate_exports')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->pluck('certificate_no','id');
        $certificate_no = DB::table('certificate_exports')->select('id')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->get();


        $data_session     =    HP::CheckSession();


        $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
        ->where('status', 2)
        ->first();



        $labCalScopeTransactions = $labCalScopeUsageStatus ? 
        $labCalScopeUsageStatus->transactions()->with([
        'calibrationBranch',
        'calibrationBranchInstrumentGroup',
        'calibrationBranchInstrument',
        'calibrationBranchParam1',
        'calibrationBranchParam2'
        ])->get() : [];

        if (is_null($labCalScopeTransactions)) {
        $labCalScopeTransactions = [];
        }


        $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certi_lab->id)->with([
                    'certiLab', 
                    'province', 
                    'amphur', 
                    'district'
                ])->get();


        $Query = CertiLab::with(['certificate_exports_to' => function($q){
        $q->where('status', 4);
        }]);
        $certifieds = collect() ;
        if(!is_null($data_session->agent_id)){  // ตัวแทน
        $certiLabs = $Query->where('agent_id',  $data_session->agent_id ) ;
        }else{
        if($data_session->branch_type == 1){  // สำนักงานใหญ่
        $certiLabs = $Query->where('tax_id',  $data_session->tax_number ) ;
        }else{   // ผู้บันทึก
        $certiLabs = $Query->where('created_by',   auth()->user()->getKey()) ;
        }
        }

        $certifieds = CertificateExport::whereIn('request_number',$certiLabs->get()->pluck('app_no')->toArray())->get();

        $labRequestType = LabRequestType::where('app_certi_lab_id',$certi_lab->id)->first();

        // Query ข้อมูลที่มี app_certi_lab_id เท่ากับ $certi_lab->id
        // Query ข้อมูลที่มี app_certi_lab_id เท่ากับ $certi_lab->id และดึงค่า 'group'

        $labCalScopeTransactionGroups = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
            ->where('status', 1)
            ->select('group', 'created_at') // เลือกฟิลด์ที่ต้องการ
            ->get()
            ->unique('group') // ทำให้ค่า group ไม่ซ้ำกัน
            ->values(); // รีเซ็ต index ของ Collection

        // dd($labCalScopeTransactionGroups->count());

        $labTestRequest = LabTestRequest::with([
            'certiLab', 
            'labTestTransactions.labTestMeasurements'
        ])
        ->where('app_certi_lab_id', $certi_lab->id)
        ->get();

        $labCalRequest = LabCalRequest::with([
            'certiLab', 
            'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
        ])
        ->where('app_certi_lab_id', $certi_lab->id)
        ->get();

        return view('certify.applicant.show',[
                                            'certi_lab'=>$certi_lab,
                                            'attaches' => $attaches,
                                            'certi_information' => $certi_information,
                                            'certi_lab_info'=> $certi_lab_info,
                                            'certi_lab_place'=>$certi_lab_place,
                                            'branchs' =>$branchs,
                                            'calibration_branchs'=> $calibration_branchs,
                                            'certi_lab_attach_more'=> $certi_lab_attach_more,
                                            'certi_lab_attach_all5' => $certi_lab_attach_all5,
                                            'certi_lab_attach_all61' => $certi_lab_attach_all61,
                                            'certi_lab_attach_all62' => $certi_lab_attach_all62,
                                            'certi_lab_attach_all71' => $certi_lab_attach_all71,
                                            'certi_lab_attach_all72' => $certi_lab_attach_all72,
                                            'certi_lab_attach_all8' => $certi_lab_attach_all8,
                                            'certi_lab_attach_all9' => $certi_lab_attach_all9,
                                            'certi_lab_check_box_image'=> $certi_lab_check_box_image,
                                            'CertiLabDeleteFile' => $CertiLabDeleteFile,
                                            'certificate_no' => $certificate_no,
                                            'certificate_exports' => $certificate_exports,
                                            'certifieds' => $certifieds,
                                            'branchLabAdresses' => $branchLabAdresses,
                                            'labCalScopeTransactions' => $labCalScopeTransactions,
                                            'labRequestType' => $labRequestType,
                                            'labCalScopeTransactionGroups' => $labCalScopeTransactionGroups,
                                            'labTestRequest' => $labTestRequest,
                                            'labCalRequest' => $labCalRequest,
                                             ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($token)
    {
       
        $model = str_slug('applicant','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){

                $certi_lab = CertiLab::where('token',$token)->first();

                // add certi lab info
                $certi_lab_info =  CertiLabInfo::where('app_certi_lab_id',$certi_lab->id)->first();
                if(is_null($certi_lab_info)){
                    $certi_lab_info = new CertiLabInfo;
                }
            // add certi lab place
                $certi_lab_place =  CertiLabPlace::where('app_certi_lab_id',$certi_lab->id)->first();
                if(is_null($certi_lab_place)){
                    $certi_lab_place = new CertiLabPlace;
                }
                $branchs = DB::table('bcertify_test_branches')->select('*')->where('state',1)->pluck('title','id');
                $calibration_branchs = DB::table('bcertify_calibration_branches')->select('*')->where('state',1)->pluck('title','id');
                $province = DB::table('province')->select('*')->get();

                $attaches = DB::table('bcertify_config_attach_forms')->select('*')->where('form',1)->get();
                $certi_lab_attach_more = CertiLabAttachMore::where('app_certi_lab_id',$certi_lab->id)->get();
                $certi_lab_attach_all5 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '5')
                                                        ->get();
                $certi_lab_attach_all61 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '61')
                                                        ->get();
                $certi_lab_attach_all62 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '62')
                                                        ->get();
                $certi_lab_attach_all71 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '71')
                                                        ->get();
                $certi_lab_attach_all72 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '72')
                                                        ->get();
                $certi_lab_attach_all8 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '8')
                                                        ->get();
                $certi_lab_attach_all9 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '9')
                                                        ->get();
                $certi_lab_check_box = CertiLabCheckBox::where('app_certi_lab_id',$certi_lab->id)->first();
                if(is_null($certi_lab_check_box)){
                    $certi_lab_check_box = new CertiLabCheckBox;
                }
                $certi_lab_check_box_image = !is_null($certi_lab_check_box) ? CertiLabCheckBoxImage::where('app_certi_lab_check_box_id', $certi_lab_check_box->id)->get() : null;
                $CertiLabDeleteFile = CertiLabDeleteFile::where('app_certi_lab_id', $certi_lab->id) ->get();

                // $follow_up = FollowUp::where('trader_autonumber',Auth::user()->getKey())->first() ;
                $user_tis = $data_session;
                $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.$user_tis->province.'%')->first();
                $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();

                $user_tis->PROVINCE_ID          =    $Province->PROVINCE_ID ?? '';
                $user_tis->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';

                $app_certi_labs = DB::table('app_certi_labs')->where('lab_type',$certi_lab->lab_type)->where('tax_id',$data_session->tax_number)->select('id');
                $certificate_exports = DB::table('certificate_exports')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->pluck('request_number','id');
                $certificate_no = DB::table('certificate_exports')->select('id')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->get();

                $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
                                        ->where('status', 2)
                                        ->first();


                                    
                $labCalScopeTransactions = $labCalScopeUsageStatus ? 
                    $labCalScopeUsageStatus->transactions()->with([
                        'calibrationBranch',
                        'calibrationBranchInstrumentGroup',
                        'calibrationBranchInstrument',
                        'calibrationBranchParam1',
                        'calibrationBranchParam2'
                    ])->get() : [];
                
                if (is_null($labCalScopeTransactions)) {
                    $labCalScopeTransactions = [];
                }


                $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certi_lab->id)->with([
                                                    'certiLab', 
                                                    'province', 
                                                    'amphur', 
                                                    'district'
                                                ])->get();

            
                $Query = CertiLab::with(['certificate_exports_to' => function($q){
                    $q->where('status', 4);
                }]);
                $certifieds = collect() ;
                if(!is_null($data_session->agent_id)){  // ตัวแทน
                    $certiLabs = $Query->where('agent_id',  $data_session->agent_id ) ;
                }else{
                    if($data_session->branch_type == 1){  // สำนักงานใหญ่
                        $certiLabs = $Query->where('tax_id',  $data_session->tax_number ) ;
                    }else{   // ผู้บันทึก
                        $certiLabs = $Query->where('created_by',   auth()->user()->getKey()) ;
                    }
                }

                $certifieds = CertificateExport::whereIn('request_number',$certiLabs->get()->pluck('app_no')->toArray())->get();
                
                $labRequestType = LabRequestType::where('app_certi_lab_id',$certi_lab->id)->first();

                $labCalScopeTransactionGroups = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
                ->where('status', 1)
                ->select('group', 'created_at') // เลือกฟิลด์ที่ต้องการ
                ->get()
                ->unique('group') // ทำให้ค่า group ไม่ซ้ำกัน
                ->values(); // รีเซ็ต index ของ Collection


                // $labCalRequest = LabCalRequest::where('app_certi_lab_id',$certi_lab->id)->first();
                // $labTestRequest = LabTestRequest::where('app_certi_lab_id',$certi_lab->id)->first();

                $labTestRequest = LabTestRequest::with([
                    'certiLab', 
                    'labTestTransactions.labTestMeasurements'
                ])
                ->where('app_certi_lab_id', $certi_lab->id)
                ->get();

                $labCalRequest = LabCalRequest::with([
                    'certiLab', 
                    'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
                ])
                ->where('app_certi_lab_id', $certi_lab->id)
                ->get();

                $mainLabScopeTransaction = LabScopeTransaction::where('app_certi_lab_id', $certi_lab->id)
                                    ->where('lab_type','main')
                                    ->first();
                $branchLabScopeTransactions = LabScopeTransaction::where('app_certi_lab_id', $certi_lab->id)
                                    ->where('lab_type','branch')
                                    ->get();

                return view('certify.applicant.edit',[
                        'certi_lab'=>$certi_lab,
                        'attaches' => $attaches,
                        // 'certi_information' => $certi_information,
                        'certi_lab_info'=> $certi_lab_info,
                        'certi_lab_place'=>$certi_lab_place,
                        'branchs' =>$branchs,
                        'calibration_branchs'=> $calibration_branchs,
                        'certi_lab_attach_more'=> $certi_lab_attach_more,
                        'certi_lab_attach_all5' => $certi_lab_attach_all5,
                        'certi_lab_attach_all61' => $certi_lab_attach_all61,
                        'certi_lab_attach_all62' => $certi_lab_attach_all62,
                        'certi_lab_attach_all71' => $certi_lab_attach_all71,
                        'certi_lab_attach_all72' => $certi_lab_attach_all72,
                        'certi_lab_attach_all8' => $certi_lab_attach_all8,
                        'certi_lab_attach_all9' => $certi_lab_attach_all9,
                        'certi_lab_check_box_image'=> $certi_lab_check_box_image,
                        'CertiLabDeleteFile'=> $CertiLabDeleteFile,
                        
                        'user_tis' => $user_tis,
                        'certificate_exports' => $certificate_exports,
                        'certificate_no' => $certificate_no,
                        'labCalScopeTransactions' => $labCalScopeTransactions,
                        'branchLabAdresses' => $branchLabAdresses,
                        'certifieds' => $certifieds,
                        'labRequestType' => $labRequestType,
                        'labCalScopeTransactionGroups' => $labCalScopeTransactionGroups,
                        'labCalRequest' => $labCalRequest,
                        'labTestRequest' => $labTestRequest,
                        'mainLabScopeTransaction' => $mainLabScopeTransaction,
                        'branchLabScopeTransactions' => $branchLabScopeTransactions,
                        ]);
            }
            abort(403);

            }else{
                return  redirect(HP::DomainTisiSso());
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $token)
    {
        //  dd("ok");
        // $labAddresses = json_decode($request->input('lab_addresses'), true);
        // $labMainAddress = json_decode($request->input('lab_main_address'), true);

        $mainLabInfo = json_decode($request->input('main_lab_info'), true);
        $branchLabInfos = json_decode($request->input('branch_lab_infos'), true) ?? [];

        $model = str_slug('applicant','-');
        $data_session     =    HP::CheckSession();

        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){

                try {

                    $requestData = $request->all();

                    // dd($requestData);

                    $certi_lab = CertiLab::where('token',$token)->first();

                    // dd($certi_lab->status);



                    if (!is_null($certi_lab)){


                        $template_ability = "";
                        if($certi_lab->lab_type == 4){
                            $template_ability = "calibrate";
                        }else if($certi_lab->lab_type == 3)
                        {
                            $template_ability = "test";
                        }

                        $labHtmlTemplate = LabHtmlTemplate::where('user_id',auth()->user()->id)
                            ->where('according_formula',$request->according_formula)
                            ->where('purpose',$request->purpose)
                            ->where('lab_ability',$template_ability)
                            ->first();


                        $certi_lab = $this->SaveCertiLab($request, $data_session , $token,$branchLabInfos,    $mainLabInfo  );

                        // Save information
                        $this->SaveInformation($request, $certi_lab);

                        // Save Place
                        $this->SaveCertiLabPlace($request, $certi_lab);

                        //Save lab info
                        $this->SaveCertiLabInfo($request, $certi_lab);

                        //  $branchCategories = [
                        //     'branch_id' => $this->getCategories($request)
                        // ];

                        

                    $labHtmlTemplate = LabHtmlTemplate::where('user_id',auth()->user()->id)
                        ->where('according_formula',$request->according_formula)
                        ->where('purpose',$request->purpose)
                        ->where('lab_ability',$template_ability)
                        ->first();

                        $jsonDataString = $labHtmlTemplate->json_data;

                        $dataArray = json_decode($jsonDataString, true);

                        

                        // 2. ดึงค่าจาก key 'field' ทั้งหมดออกมาเป็น array ใหม่
                        $fieldArray = array_column($dataArray, 'field');

                        // dd($fieldArray);

                        if($certi_lab->lab_type == 3){
                            $this->save_certify_test_scope($certi_lab,$fieldArray);
                        }else if($certi_lab->lab_type == 4)
                        {
                            $this->save_certifyLab_calibrate($certi_lab,$fieldArray);
                        }



                        if ( isset($requestData['repeater-section4'] ) ){
                            $this->SaveFileSection($request, 'repeater-section4', 'attachs_sec4', 4 , $certi_lab );
                        }

                        if ( isset($requestData['repeater-section5'] ) ){
                            $this->SaveFileSection($request, 'repeater-section5', 'attachs_sec5', 5 , $certi_lab );
                        }

                        // if ( isset($requestData['repeater-section61'] ) ){
                        //     $this->SaveFileSection($request, 'repeater-section61', 'attachs_sec61', 61 , $certi_lab );
                        // }

                        // if ( isset($requestData['repeater-section62'] ) ){
                        //     $this->SaveFileSection($request, 'repeater-section62', 'attachs_sec62', 62 , $certi_lab );
                        // }

                        if ( isset($requestData['repeater-section71'] ) ){
                            $this->SaveFileSection($request, 'repeater-section71', 'attachs_sec71', 71 , $certi_lab );
                        }

                        if ( isset($requestData['repeater-section72'] ) ){
                            $this->SaveFileSection($request, 'repeater-section72', 'attachs_sec72', 72 , $certi_lab );
                        }

                        if ( isset($requestData['repeater-section8'] ) ){
                            $this->SaveFileSection($request, 'repeater-section8', 'attachs_sec8', 8 , $certi_lab );
                        }

                        if ( isset($requestData['repeater-section9'] ) ){
                            $this->SaveFileSection($request, 'repeater-section9', 'attachs_sec9', 9 , $certi_lab );
                        }

                        if ( isset($requestData['repeater-section10'] ) ){
                            $this->SaveFileSection($request, 'repeater-section10', 'attachs_sec10', 10 , $certi_lab );
                        }

                        if ( isset($requestData['repeater-section-other'] ) ){
                            $this->SaveFileMore($request, $certi_lab );
                        }

                    $request_type = "";
                    if($certi_lab->lab_type == 3){
                        $request_type = "test";
                    }else if($certi_lab->lab_type == 4){
                        $request_type = "cal";
                    }

                    // LabScopeTransaction::where('app_certi_lab_id', $certi_lab->id)->delete();

                    // $labScopeTransaction = new LabScopeTransaction();
                    // $labScopeTransaction->app_certi_lab_id = $certi_lab->id;
                    // $labScopeTransaction->lab_type = $mainLabInfo['lab_type'] ?? 'main';
                    // $labScopeTransaction->request_type = $request_type;
                    // $labScopeTransaction->address_number = $mainLabInfo['address_number_add'] ?? '';
                    // $labScopeTransaction->village_no = $mainLabInfo['village_no_add'] ?? ''; // แก้จาก address_moo_add
                    // $labScopeTransaction->address_city = $mainLabInfo['address_city_add'] ?? '';
                    // $labScopeTransaction->address_city_text = $mainLabInfo['address_city_text_add'] ?? '';
                    // $labScopeTransaction->address_district = $mainLabInfo['address_district_add'] ?? '';
                    // $labScopeTransaction->sub_district = $mainLabInfo['sub_district_add'] ?? '';
                    // $labScopeTransaction->postcode = $mainLabInfo['postcode_add'] ?? '';
                    // $labScopeTransaction->address_soi = $mainLabInfo['address_soi_add'] ?? '';
                    // $labScopeTransaction->address_street = $mainLabInfo['address_street_add'] ?? '';
                    // $labScopeTransaction->labress_no_eng = $mainLabInfo['lab_address_no_eng_add'] ?? ''; // แก้จาก labress_no_eng
                    // $labScopeTransaction->lab_moo_eng = $mainLabInfo['lab_moo_eng_add'] ?? '';
                    // $labScopeTransaction->lab_soi_eng = $mainLabInfo['lab_soi_eng_add'] ?? '';
                    // $labScopeTransaction->lab_street_eng = $mainLabInfo['lab_street_eng_add'] ?? '';
                    // $labScopeTransaction->lab_province_text_eng = $mainLabInfo['lab_province_text_eng_add'] ?? '';
                    // $labScopeTransaction->lab_amphur_eng = $mainLabInfo['lab_amphur_eng_add'] ?? '';
                    // $labScopeTransaction->lab_district_eng = $mainLabInfo['lab_district_eng_add'] ?? '';
                    // $labScopeTransaction->lab_types = json_encode($mainLabInfo['lab_types'] ?? []); // แปลงเป็น JSON

                    // $labScopeTransaction->save();

                    // foreach ($branchLabInfos as $branchId => $branchLabInfo) {
                    //     $labScopeTransaction = new LabScopeTransaction();
                    //     $labScopeTransaction->app_certi_lab_id = $certi_lab->id;
                    //     $labScopeTransaction->request_type = $request_type;
                    //     $labScopeTransaction->lab_type = $mainLabInfo['lab_type'] ?? 'branch';;
                    //     $labScopeTransaction->branch_id = $branchId;
                    //     $labScopeTransaction->address_number = $branchLabInfo['address_number_add'] ?? '';
                    //     $labScopeTransaction->village_no = $branchLabInfo['village_no_add'] ?? ''; // แก้จาก address_moo_add
                    //     $labScopeTransaction->address_city = $branchLabInfo['address_city_add'] ?? '';
                    //     $labScopeTransaction->address_city_text = $branchLabInfo['address_city_text_add'] ?? '';
                    //     $labScopeTransaction->address_district = $branchLabInfo['address_district_add'] ?? '';
                    //     $labScopeTransaction->sub_district = $branchLabInfo['sub_district_add'] ?? '';
                    //     $labScopeTransaction->postcode = $branchLabInfo['postcode_add'] ?? '';
                    //     $labScopeTransaction->address_soi = $branchLabInfo['address_soi_add'] ?? '';
                    //     $labScopeTransaction->address_street = $branchLabInfo['address_street_add'] ?? '';
                    //     $labScopeTransaction->lab_address_no_eng = $branchLabInfo['lab_address_no_eng_add'] ?? ''; // แก้จาก labress_no_eng
                    //     $labScopeTransaction->lab_moo_eng = $branchLabInfo['lab_moo_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_soi_eng = $branchLabInfo['lab_soi_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_street_eng = $branchLabInfo['lab_street_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_province_text_eng = $branchLabInfo['lab_province_text_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_amphur_eng = $branchLabInfo['lab_amphur_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_district_eng = $branchLabInfo['lab_district_eng_add'] ?? '';
                    //     $labScopeTransaction->lab_types = json_encode($branchLabInfo['lab_types'] ?? []); // แปลงเป็น JSON
    
                    //     $labScopeTransaction->save();
                    // }



                        // dd($request->lab_ability ,$request->according_formula, $request->purpose,$request->lab_ability, $labHtmlTemplate);

                    // $pdfService = new CreateLabScopePdf($certi_lab);
                    // $pdfContent = $pdfService->generatePdf();

      

                        $babCalScopeUsageStatus = new LabCalScopeUsageStatus();
                        $babCalScopeUsageStatus->app_certi_lab_id = $certi_lab->id;
                        $babCalScopeUsageStatus->group = 1;
                        $babCalScopeUsageStatus->status = 2;
                        $babCalScopeUsageStatus->save();

                        $labRequestType = new LabRequestType();
                        $labRequestType->app_certi_lab_id = $certi_lab->id;
                        $labRequestType->request_type = $request->purpose;
                        $labRequestType->certificate_id = $request->select_certified_temp;
                        $labRequestType->save();


                        // เงื่อนไขเช็คมีใบรับรอง
                        $this->save_certilab_export_mapreq( $certi_lab );

                        if ($certi_lab->status == 3){  // ขอเอกสารเพิ่มเติม
                            $status = 3;  //Mail
                            $requestLab['status'] = 2;
                        }else{
                            $status = 1;  //Mail
                        }

                        // ส่ง Email
                        if($status == 3){
                            $this->SET_EMAIL_Request_Documents($certi_lab);
                        }else{
                            if($certi_lab->status == 1 || $certi_lab->status == 2){
                                $this->SET_EMAIL($certi_lab,$status);
                            }
                        }

                        LabRequestRejectTracking::where('app_certi_lab_id',$certi_lab->id)->delete();

                        ////////////////////////////////////////////////////////////////////////////////////////
                        // add certi lab check box image
                        // if (isset($requestData['attachs_sec4'] )  && $request->hasFile('attachs_sec4')){   // ถ้ามีการแนบ ไฟล์ มา
                        //     $certi_lab_check_box = CertiLabCheckBox::where('app_certi_lab_id',$certi_lab->id)->first();
                        //     if(is_null($certi_lab_check_box)){
                        //     $certi_lab_check_box =  CertiLabCheckBox::create(['app_certi_lab_id' => $certi_lab->id,
                        //                                                         'token'=>str_random(20)
                        //                                                         ]);
                        //     }
                        //     foreach ($request->attachs_sec4 as $index => $attachs_sec4){
                        //         $certi_lab_check_box_image = new CertiLabCheckBoxImage();
                        //         $certi_lab_check_box_image->app_certi_lab_check_box_id = $certi_lab_check_box->id;
                        //         $certi_lab_check_box_image->path_image = $this->storeFile($attachs_sec4,$certi_lab->app_no);
                        //         $certi_lab_check_box_image->file_client_name = HP::ConvertCertifyFileName($attachs_sec4->getClientOriginalName());
                        //         $certi_lab_check_box_image->token = str_random(16);
                        //         $certi_lab_check_box_image->save();
                        //     }
                        // }
                    }


                    return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
                } catch (\Exception $e) {

                    echo $e->getMessage();
                    exit;
                    return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }
            }else{
                return  redirect(HP::DomainTisiSso());
            }
        }

    }

    // public function editScope($token)
    // {
    //     // dd('ok');
    //     $model = str_slug('applicant','-');
    //     $data_session     =    HP::CheckSession();
    //     if(!empty($data_session)){
    //         if(HP::CheckPermission('edit-'.$model)){

    //             $certi_lab = CertiLab::where('token',$token)->first();

    //             // add certi lab info
    //             $certi_lab_info =  CertiLabInfo::where('app_certi_lab_id',$certi_lab->id)->first();
    //             if(is_null($certi_lab_info)){
    //                 $certi_lab_info = new CertiLabInfo;
    //             }
    //         // add certi lab place
    //             $certi_lab_place =  CertiLabPlace::where('app_certi_lab_id',$certi_lab->id)->first();
    //             if(is_null($certi_lab_place)){
    //                 $certi_lab_place = new CertiLabPlace;
    //             }
    //             $branchs = DB::table('bcertify_test_branches')->select('*')->where('state',1)->pluck('title','id');
    //             $calibration_branchs = DB::table('bcertify_calibration_branches')->select('*')->where('state',1)->pluck('title','id');
    //             $province = DB::table('province')->select('*')->get();

    //             $attaches = DB::table('bcertify_config_attach_forms')->select('*')->where('form',1)->get();
    //             $certi_lab_attach_more = CertiLabAttachMore::where('app_certi_lab_id',$certi_lab->id)->get();
    //             $certi_lab_attach_all5 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '5')
    //                                                     ->get();
    //             $certi_lab_attach_all61 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '61')
    //                                                     ->get();
    //             $certi_lab_attach_all62 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '62')
    //                                                     ->get();
    //             $certi_lab_attach_all71 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '71')
    //                                                     ->get();
    //             $certi_lab_attach_all72 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '72')
    //                                                     ->get();
    //             $certi_lab_attach_all8 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '8')
    //                                                     ->get();
    //             $certi_lab_attach_all9 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
    //                                                     ->where('file_section', '9')
    //                                                     ->get();
    //             $certi_lab_check_box = CertiLabCheckBox::where('app_certi_lab_id',$certi_lab->id)->first();
    //             if(is_null($certi_lab_check_box)){
    //                 $certi_lab_check_box = new CertiLabCheckBox;
    //             }
    //             $certi_lab_check_box_image = !is_null($certi_lab_check_box) ? CertiLabCheckBoxImage::where('app_certi_lab_check_box_id', $certi_lab_check_box->id)->get() : null;
    //             $CertiLabDeleteFile = CertiLabDeleteFile::where('app_certi_lab_id', $certi_lab->id) ->get();

    //             // $follow_up = FollowUp::where('trader_autonumber',Auth::user()->getKey())->first() ;
    //             $user_tis = $data_session;
    //             $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.$user_tis->province.'%')->first();
    //             $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();

    //             $user_tis->PROVINCE_ID          =    $Province->PROVINCE_ID ?? '';
    //             $user_tis->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';

    //             $app_certi_labs = DB::table('app_certi_labs')->where('lab_type',$certi_lab->lab_type)->where('tax_id',$data_session->tax_number)->select('id');
    //             $certificate_exports = DB::table('certificate_exports')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->pluck('request_number','id');
    //             $certificate_no = DB::table('certificate_exports')->select('id')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->get();

    //             $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
    //                                     ->where('status', 2)
    //                                     ->first();


                                    
    //             $labCalScopeTransactions = $labCalScopeUsageStatus ? 
    //                 $labCalScopeUsageStatus->transactions()->with([
    //                     'calibrationBranch',
    //                     'calibrationBranchInstrumentGroup',
    //                     'calibrationBranchInstrument',
    //                     'calibrationBranchParam1',
    //                     'calibrationBranchParam2'
    //                 ])->get() : [];
                
    //             if (is_null($labCalScopeTransactions)) {
    //                 $labCalScopeTransactions = [];
    //             }


    //             $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certi_lab->id)->with([
    //                                                 'certiLab', 
    //                                                 'province', 
    //                                                 'amphur', 
    //                                                 'district'
    //                                             ])->get();

            
    //             $Query = CertiLab::with(['certificate_exports_to' => function($q){
    //                 $q->where('status', 4);
    //             }]);
    //             $certifieds = collect() ;
    //             if(!is_null($data_session->agent_id)){  // ตัวแทน
    //                 $certiLabs = $Query->where('agent_id',  $data_session->agent_id ) ;
    //             }else{
    //                 if($data_session->branch_type == 1){  // สำนักงานใหญ่
    //                     $certiLabs = $Query->where('tax_id',  $data_session->tax_number ) ;
    //                 }else{   // ผู้บันทึก
    //                     $certiLabs = $Query->where('created_by',   auth()->user()->getKey()) ;
    //                 }
    //             }

    //             $certifieds = CertificateExport::whereIn('request_number',$certiLabs->get()->pluck('app_no')->toArray())->get();
                
    //             $labRequestType = LabRequestType::where('app_certi_lab_id',$certi_lab->id)->first();

    //             $labCalScopeTransactionGroups = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
    //             ->where('status', 1)
    //             ->select('group', 'created_at') // เลือกฟิลด์ที่ต้องการ
    //             ->get()
    //             ->unique('group') // ทำให้ค่า group ไม่ซ้ำกัน
    //             ->values(); // รีเซ็ต index ของ Collection


    //             // $labCalRequest = LabCalRequest::where('app_certi_lab_id',$certi_lab->id)->first();
    //             // $labTestRequest = LabTestRequest::where('app_certi_lab_id',$certi_lab->id)->first();

    //             $labTestRequest = LabTestRequest::with([
    //                 'certiLab', 
    //                 'labTestTransactions.labTestMeasurements'
    //             ])
    //             ->where('app_certi_lab_id', $certi_lab->id)
    //             ->get();

    //             $labCalRequest = LabCalRequest::with([
    //                 'certiLab', 
    //                 'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
    //             ])
    //             ->where('app_certi_lab_id', $certi_lab->id)
    //             ->get();

    //             // dd($labCalRequest);
    //             return view('certify.applicant.edit-scope',[
    //                     'certi_lab'=>$certi_lab,
    //                     'attaches' => $attaches,
    //                     // 'certi_information' => $certi_information,
    //                     'certi_lab_info'=> $certi_lab_info,
    //                     'certi_lab_place'=>$certi_lab_place,
    //                     'branchs' =>$branchs,
    //                     'calibration_branchs'=> $calibration_branchs,
    //                     'certi_lab_attach_more'=> $certi_lab_attach_more,
    //                     'certi_lab_attach_all5' => $certi_lab_attach_all5,
    //                     'certi_lab_attach_all61' => $certi_lab_attach_all61,
    //                     'certi_lab_attach_all62' => $certi_lab_attach_all62,
    //                     'certi_lab_attach_all71' => $certi_lab_attach_all71,
    //                     'certi_lab_attach_all72' => $certi_lab_attach_all72,
    //                     'certi_lab_attach_all8' => $certi_lab_attach_all8,
    //                     'certi_lab_attach_all9' => $certi_lab_attach_all9,
    //                     'certi_lab_check_box_image'=> $certi_lab_check_box_image,
    //                     'CertiLabDeleteFile'=> $CertiLabDeleteFile,
                        
    //                     'user_tis' => $user_tis,
    //                     'certificate_exports' => $certificate_exports,
    //                     'certificate_no' => $certificate_no,
    //                     'labCalScopeTransactions' => $labCalScopeTransactions,
    //                     'branchLabAdresses' => $branchLabAdresses,
    //                     'certifieds' => $certifieds,
    //                     'labRequestType' => $labRequestType,
    //                     'labCalScopeTransactionGroups' => $labCalScopeTransactionGroups,
    //                     'labCalRequest' => $labCalRequest,
    //                     'labTestRequest' => $labTestRequest
    //                     ]);
    //         }
    //         abort(403);

    //         }else{
    //             return  redirect(HP::DomainTisiSso());
    //         }
    // }


    public function editScope($token)
    {
        // dd("ok");
        $model = str_slug('applicant','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission('edit-'.$model)){

                $certi_lab = CertiLab::where('token',$token)->first();

                // add certi lab info
                $certi_lab_info =  CertiLabInfo::where('app_certi_lab_id',$certi_lab->id)->first();
                if(is_null($certi_lab_info)){
                    $certi_lab_info = new CertiLabInfo;
                }
            // add certi lab place
                $certi_lab_place =  CertiLabPlace::where('app_certi_lab_id',$certi_lab->id)->first();
                if(is_null($certi_lab_place)){
                    $certi_lab_place = new CertiLabPlace;
                }
                $branchs = DB::table('bcertify_test_branches')->select('*')->where('state',1)->pluck('title','id');
                $calibration_branchs = DB::table('bcertify_calibration_branches')->select('*')->where('state',1)->pluck('title','id');
                $province = DB::table('province')->select('*')->get();

                $attaches = DB::table('bcertify_config_attach_forms')->select('*')->where('form',1)->get();
                $certi_lab_attach_more = CertiLabAttachMore::where('app_certi_lab_id',$certi_lab->id)->get();
                $certi_lab_attach_all5 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '5')
                                                        ->get();
                $certi_lab_attach_all61 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '61')
                                                        ->get();
                $certi_lab_attach_all62 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '62')
                                                        ->get();
                $certi_lab_attach_all71 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '71')
                                                        ->get();
                $certi_lab_attach_all72 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '72')
                                                        ->get();
                $certi_lab_attach_all8 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '8')
                                                        ->get();
                $certi_lab_attach_all9 = CertiLabAttachAll::where('app_certi_lab_id', $certi_lab->id)
                                                        ->where('file_section', '9')
                                                        ->get();
                $certi_lab_check_box = CertiLabCheckBox::where('app_certi_lab_id',$certi_lab->id)->first();
                if(is_null($certi_lab_check_box)){
                    $certi_lab_check_box = new CertiLabCheckBox;
                }
                $certi_lab_check_box_image = !is_null($certi_lab_check_box) ? CertiLabCheckBoxImage::where('app_certi_lab_check_box_id', $certi_lab_check_box->id)->get() : null;
                $CertiLabDeleteFile = CertiLabDeleteFile::where('app_certi_lab_id', $certi_lab->id) ->get();

                // $follow_up = FollowUp::where('trader_autonumber',Auth::user()->getKey())->first() ;
                $user_tis = $data_session;
                $Province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.$user_tis->province.'%')->first();
                $contact_province =  Province::where('PROVINCE_NAME', 'LIKE', '%'.str_replace(" ","",$data_session->contact_province).'%')->first();

                $user_tis->PROVINCE_ID          =    $Province->PROVINCE_ID ?? '';
                $user_tis->contact_province_id  =    $contact_province->PROVINCE_ID ?? '';

                $app_certi_labs = DB::table('app_certi_labs')->where('lab_type',$certi_lab->lab_type)->where('tax_id',$data_session->tax_number)->select('id');
                $certificate_exports = DB::table('certificate_exports')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->pluck('request_number','id');
                $certificate_no = DB::table('certificate_exports')->select('id')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->get();

                $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
                                        ->where('status', 2)
                                        ->first();


                                    
                $labCalScopeTransactions = $labCalScopeUsageStatus ? 
                    $labCalScopeUsageStatus->transactions()->with([
                        'calibrationBranch',
                        'calibrationBranchInstrumentGroup',
                        'calibrationBranchInstrument',
                        'calibrationBranchParam1',
                        'calibrationBranchParam2'
                    ])->get() : [];
                
                if (is_null($labCalScopeTransactions)) {
                    $labCalScopeTransactions = [];
                }


                $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certi_lab->id)->with([
                                                    'certiLab', 
                                                    'province', 
                                                    'amphur', 
                                                    'district'
                                                ])->get();

            
                $Query = CertiLab::with(['certificate_exports_to' => function($q){
                    $q->where('status', 4);
                }]);
                $certifieds = collect() ;
                if(!is_null($data_session->agent_id)){  // ตัวแทน
                    $certiLabs = $Query->where('agent_id',  $data_session->agent_id ) ;
                }else{
                    if($data_session->branch_type == 1){  // สำนักงานใหญ่
                        $certiLabs = $Query->where('tax_id',  $data_session->tax_number ) ;
                    }else{   // ผู้บันทึก
                        $certiLabs = $Query->where('created_by',   auth()->user()->getKey()) ;
                    }
                }

                $certifieds = CertificateExport::whereIn('request_number',$certiLabs->get()->pluck('app_no')->toArray())->get();
                
                $labRequestType = LabRequestType::where('app_certi_lab_id',$certi_lab->id)->first();

                $labCalScopeTransactionGroups = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
                ->where('status', 1)
                ->select('group', 'created_at') // เลือกฟิลด์ที่ต้องการ
                ->get()
                ->unique('group') // ทำให้ค่า group ไม่ซ้ำกัน
                ->values(); // รีเซ็ต index ของ Collection


                // $labCalRequest = LabCalRequest::where('app_certi_lab_id',$certi_lab->id)->first();
                // $labTestRequest = LabTestRequest::where('app_certi_lab_id',$certi_lab->id)->first();

                $labTestRequest = LabTestRequest::with([
                    'certiLab', 
                    'labTestTransactions.labTestMeasurements'
                ])
                ->where('app_certi_lab_id', $certi_lab->id)
                ->get();

                $labCalRequest = LabCalRequest::with([
                    'certiLab', 
                    'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
                ])
                ->where('app_certi_lab_id', $certi_lab->id)
                ->get();

                $mainLabScopeTransaction = LabScopeTransaction::where('app_certi_lab_id', $certi_lab->id)
                                    ->where('lab_type','main')
                                    ->first();
                $branchLabScopeTransactions = LabScopeTransaction::where('app_certi_lab_id', $certi_lab->id)
                                    ->where('lab_type','branch')
                                    ->get();

                return view('certify.applicant.edit_scope',[
                        'certi_lab'=>$certi_lab,
                        'attaches' => $attaches,
                        // 'certi_information' => $certi_information,
                        'certi_lab_info'=> $certi_lab_info,
                        'certi_lab_place'=>$certi_lab_place,
                        'branchs' =>$branchs,
                        'calibration_branchs'=> $calibration_branchs,
                        'certi_lab_attach_more'=> $certi_lab_attach_more,
                        'certi_lab_attach_all5' => $certi_lab_attach_all5,
                        'certi_lab_attach_all61' => $certi_lab_attach_all61,
                        'certi_lab_attach_all62' => $certi_lab_attach_all62,
                        'certi_lab_attach_all71' => $certi_lab_attach_all71,
                        'certi_lab_attach_all72' => $certi_lab_attach_all72,
                        'certi_lab_attach_all8' => $certi_lab_attach_all8,
                        'certi_lab_attach_all9' => $certi_lab_attach_all9,
                        'certi_lab_check_box_image'=> $certi_lab_check_box_image,
                        'CertiLabDeleteFile'=> $CertiLabDeleteFile,
                        
                        'user_tis' => $user_tis,
                        'certificate_exports' => $certificate_exports,
                        'certificate_no' => $certificate_no,
                        'labCalScopeTransactions' => $labCalScopeTransactions,
                        'branchLabAdresses' => $branchLabAdresses,
                        'certifieds' => $certifieds,
                        'labRequestType' => $labRequestType,
                        'labCalScopeTransactionGroups' => $labCalScopeTransactionGroups,
                        'labCalRequest' => $labCalRequest,
                        'labTestRequest' => $labTestRequest,
                        'mainLabScopeTransaction' => $mainLabScopeTransaction,
                        'branchLabScopeTransactions' => $branchLabScopeTransactions,
                        ]);
            }
            abort(403);

            }else{
                return  redirect(HP::DomainTisiSso());
            }
    }

    public function updateScope(Request $request, $token)
    {
       
        //   $mainLabInfo = json_decode($request->input('main_lab_info'), true);
        // $branchLabInfos = json_decode($request->input('branch_lab_infos'), true) ?? [];

        //  dd($mainLabInfo);
     
        $model = str_slug('applicant','-');
        $data_session     =    HP::CheckSession();

        if(!empty($data_session)){
           
            // if(HP::CheckPermission('edit-'.$model)){

                try {

                    CertiLab::where('token',$token)->update([
                        'require_scope_update' => null
                    ]);
                    $certi_lab = CertiLab::where('token',$token)->first();

                    // dd($certi_lab);

                    if (!is_null($certi_lab)){

           

                    $template_ability = "";
                    if($certi_lab->lab_type == 3){
                        $template_ability = "test";
                    }else if($certi_lab->lab_type == 4){
                        $template_ability = "calibrate";
                    }



                        $labHtmlTemplate = LabHtmlTemplate::where('user_id',auth()->user()->id)
                        ->where('according_formula',$request->according_formula)
                        ->where('purpose',$request->purpose)
                        ->where('lab_ability',$template_ability)
                        ->where('app_certi_lab_id',$certi_lab->id)
                        ->first();

                        // dd($labHtmlTemplate);

                
                        $this->exportScopePdf2($certi_lab->id,$labHtmlTemplate,'draft');

                        // dd("break");
             
                        $babCalScopeUsageStatus = new LabCalScopeUsageStatus();
                        $babCalScopeUsageStatus->app_certi_lab_id = $certi_lab->id;
                        $babCalScopeUsageStatus->group = 1;
                        $babCalScopeUsageStatus->status = 2;
                        $babCalScopeUsageStatus->save();

                        $labRequestType = new LabRequestType();
                        $labRequestType->app_certi_lab_id = $certi_lab->id;
                        $labRequestType->request_type = $request->purpose;
                        $labRequestType->certificate_id = $request->select_certified_temp;
                        $labRequestType->save();
                    }
                    

                    CertiLab::where('token',$token)->first()->update([
                        'require_scope_update' => null
                    ]);
                    $app = CertiLab::where('token',$token)->first();
                    $notices = Notice::where('app_certi_lab_id', $app->id)->get();

                    // ตรวจสอบ $notices ก่อนทำงาน
                    if ($notices->isNotEmpty()) {
                        foreach ($notices as $notice) {
                            // เรียกใช้ฟังก์ชันเพื่อคัดลอก Scope
                            $copiedScope = $this->copyScopeLabFromAttachement($app);
                            // dd($copiedScope);
                            // ตรวจสอบค่าที่คัดลอกมาและอัปเดต
                            if ($copiedScope !== null) {
                                $notice->file_scope = $copiedScope;

                                // บันทึกการเปลี่ยนแปลง
                                $notice->save();
                            }
                        }
                    }

                    //อัพเดท report
                    $reports = Report::where('app_certi_lab_id', $app->id)->get();

                    if($reports->count() != 0 )
                    {
                        $json = $this->copyScopeLabFromAttachement($app);
                        $copiedScopes = json_decode($json, true);

                        foreach($reports as $report)
                        {
                            $report->update([
                                'file_loa' => $copiedScopes[0]['attachs'],
                                'file_loa_client_name' => $copiedScopes[0]['file_client_name'],
                            ]);
                        }
                    }


                    //ตรวจสอบใน tracking attach file ถ้ามีก็ให้อัพเดทไฟล์ด้วย
                    $trackingInspectionId = $this->getAttachedFileFromRequest($app->app_no);

                    if ($trackingInspectionId !=null) 
                    {

                        if($app->lab_type == 3){
                            $fileSection = "61";
                         }else if($app->lab_type == 4){
                            $fileSection = "62";
                         }
                       
                         $latestRecord = CertiLabAttachAll::where('app_certi_lab_id', $app->id)
                         ->where('file_section', $fileSection)
                         ->orderBy('created_at', 'desc') // เรียงลำดับจากใหม่ไปเก่า
                         ->first();

                        $filePath = 'files/applicants/check_files/' . $latestRecord->file ;

                        $localFilePath = HP::downloadFileFromTisiCloud($filePath);
                
                        $inspection = TrackingInspection::find($trackingInspectionId);
                
                        $check = AttachFile::where('systems','Center')
                        ->where('ref_id',$inspection->id)
                        ->where('section','file_scope')
                        ->first();
                        
                        if($check != null)
                        {
                            $check->delete();
                        }
                
                        $tax_number = (!empty(auth()->user()->reg_13ID) ?  str_replace("-","", auth()->user()->reg_13ID )  : '0000000000000');
                
                        $uploadedFile = new \Illuminate\Http\UploadedFile(
                            $localFilePath,      // Path ของไฟล์
                            basename($localFilePath), // ชื่อไฟล์
                            mime_content_type($localFilePath), // MIME type
                            null,               // ขนาดไฟล์ (null ถ้าไม่ทราบ)
                            true                // เป็นไฟล์ที่ valid แล้ว
                        );
                        // dd($uploadedFile,$inspection);
                        $attach_path = "files/trackinglabs";
                        // ใช้ไฟล์ที่จำลองในการอัปโหลด
                        HP::singleFileUploadRefno(
                            $uploadedFile,
                            $attach_path.'/'.$inspection->reference_refno,
                            ( $tax_number),
                            (auth()->user()->FullName ?? null),
                            'Center',
                            (  (new TrackingInspection)->getTable() ),
                            $inspection->id,
                            'file_scope',
                            null
                        );
                    } 

                    $this->updateScopeEmail($certi_lab);

                    // $config = HP::getConfig();
                    // $url  =   !empty($config->url_center) ? $config->url_center : url('');
                    // $data_app = [
                    //                 'email'     => $certi_lab->email,
                    //                 'certi_lab' =>$certi_lab,
                    //                 'url' => $url.'certify/auditor/',
                    //                 'email_cc'  =>  (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ? $certi_lab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                    //            ];

                    // $log_email =  HP::getInsertCertifyLogEmail( $certi_lab->app_no,
                    //                                             $certi_lab->id,
                    //                                             (new CertiLab)->getTable(),
                    //                                             (new Notice)->getTable(),
                    //                                             1,
                    //                                             'แจ้งการแก้ไขขอบข่าย',
                    //                                             view('mail.lab.mail_request_edit_lab_scope', $data_app),
                    //                                             $certi_lab->created_by,
                    //                                             $certi_lab->agent_id,
                    //                                             null,
                    //                                             $certi_lab->email,
                    //                                             implode(',',(array)$certi_lab->DataEmailDirectorLAB),
                    //                                             (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ?   implode(',',(array)$certi_lab->DataEmailDirectorLABCC) : 'lab1@tisi.mail.go.th',
                    //                                             null,
                    //                                             null
                    //                                          );


                    // $userIds = $app->CheckExaminers->pluck('user_id')->toArray(); 
                    // $examinerEmails = DB::table('user_register')
                    // ->whereIn('runrecno', $userIds)
                    // ->pluck('reg_email')
                    // ->toArray();


                    //     $html = new EditScopeRequest($data_app);
                    //     // $mail =    Mail::to($examinerEmails)->send($html);
                    //     $mail =    Mail::to($certi_lab->DataEmailDirectorLAB)->send($html);

                    //     if(is_null($mail) && !empty($log_email)){
                    //         HP::getUpdateCertifyLogEmail($log_email->id);
                    //     }



                    return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
                } catch (\Exception $e) {

                    echo $e->getMessage();
                    exit;
                    return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
                }
            }
            // else{
            //     return  redirect(HP::DomainTisiSso());
            // }
        // }

    }

    public function updateScopeEmail($certi_lab)
    {
        $config = HP::getConfig();
        $url  =   !empty($config->url_center) ? $config->url_center : url('');
        $data_app = [
                        'email'     => $certi_lab->email,
                        'certi_lab' =>$certi_lab,
                        'url'       =>$url.'certify/check_certificate/'.$certi_lab->id.'/show',
                        'email_cc'  =>  (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ? $certi_lab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                    ];

        $log_email =  HP::getInsertCertifyLogEmail( $certi_lab->app_no,
                                                    $certi_lab->id,
                                                    (new CertiLab)->getTable(),
                                                    $certi_lab->id,
                                                    (new CertiLab)->getTable(),
                                                    1,
                                                    'แจ้งการแก้ไขขอบข่าย',
                                                    view('mail.lab.mail_request_edit_lab_scope', $data_app),
                                                    $certi_lab->created_by,
                                                    $certi_lab->agent_id,
                                                    null,
                                                    $certi_lab->email,
                                                    implode(',',(array)$certi_lab->DataEmailDirectorLAB),
                                                    (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ?   implode(',',(array)$certi_lab->DataEmailDirectorLABCC) : 'lab1@tisi.mail.go.th',
                                                    null,
                                                    null
                                                    );
            // dd($certi_lab->DataEmailDirectorLAB)                                        ;
            $html = new EditScopeRequest($data_app);
            $mail =    Mail::to($certi_lab->DataEmailDirectorLAB)->send($html);

            if(is_null($mail) && !empty($log_email)){
                HP::getUpdateCertifyLogEmail($log_email->id);
            }
}


    public function getAttachedFileFromRequest($appNo)
    {
        $certificateExport = CertificateExport::where('request_number', $appNo)->first();
        if ($certificateExport != null) {
            $trackingAssessment = TrackingAssessment::where('ref_table', 'certificate_exports')
                ->where('ref_id', $certificateExport->id)
                ->first();

            if ($trackingAssessment != null) {
                $trackingInspection = TrackingInspection::where('reference_refno', $trackingAssessment->reference_refno)
                    ->first();

                if ($trackingInspection != null) {
                    $attachFile = AttachFile::where('ref_table', 'app_certi_tracking_inspection')
                        ->where('ref_id', $trackingInspection->id)
                        ->first();

                    if ($attachFile != null && $attachFile->filename != null) {
                        // return [
                        //     'filename' => $attachFile->filename,
                        //     'trackingInspection' => $trackingInspection
                        // ];
                        return $trackingInspection->id;
                    }
                }
            }
        }
        return null;
    }


    public function downloadScopeAndReUpload($appNo,$inspectionId,$filePath)
    {
 
        $filePath = 'files/applicants/check_files/' . $filePath;

        $localFilePath = HP::downloadFileFromTisiCloud($filePath);

        $check = AttachFile::where('systems','Center')
        ->where('ref_id',$inspectionId)
        ->where('section','file_scope')
        ->first();
        if($check != null)
        {
            $check->delete();
        }

        // dd($localFilePath);
        $tax_number = (!empty(auth()->user()->reg_13ID) ?  str_replace("-","", auth()->user()->reg_13ID )  : '0000000000000');

        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $localFilePath,      // Path ของไฟล์
            basename($localFilePath), // ชื่อไฟล์
            mime_content_type($localFilePath), // MIME type
            null,               // ขนาดไฟล์ (null ถ้าไม่ทราบ)
            true                // เป็นไฟล์ที่ valid แล้ว
        );

        $attach_path = "files/trackinglabs";
        // ใช้ไฟล์ที่จำลองในการอัปโหลด
        HP::singleFileUploadRefno(
            $uploadedFile,
            $attach_path.'/'.$inspection->reference_refno,
            ( $tax_number),
            (auth()->user()->FullName ?? null),
            'Center',
            (  (new TrackingInspection)->getTable() ),
            $inspection->id,
            'file_scope',
            null
        );


    }

    

    public function copyScopeLabFromAttachement($app)
    {
        $copiedScoped = null;
        $fileSection = null;

        if($app->lab_type == 3){
           $fileSection = "61";
        }else if($app->lab_type == 4){
           $fileSection = "62";
        }

        $latestRecord = CertiLabAttachAll::where('app_certi_lab_id', $app->id)
        ->where('file_section', $fileSection)
        ->orderBy('created_at', 'desc') // เรียงลำดับจากใหม่ไปเก่า
        ->first();

        $existingFilePath = 'files/applicants/check_files/' . $latestRecord->file ;

        // ตรวจสอบว่าไฟล์มีอยู่ใน FTP และดาวน์โหลดลงมา
        if (HP::checkFileStorage($existingFilePath)) {
            $localFilePath = HP::getFileStoragePath($existingFilePath); // ดึงไฟล์ลงมาที่เซิร์ฟเวอร์
            $no  = str_replace("RQ-","",$app->app_no);
            $no  = str_replace("-","_",$no);
            $dlName = 'scope_'.basename($existingFilePath);
            $attach_path  =  'files/applicants/check_files/'.$no.'/';

            if (file_exists($localFilePath)) {
                $storagePath = Storage::putFileAs($attach_path, new \Illuminate\Http\File($localFilePath),  $dlName );
                $filePath = $attach_path . $dlName;
                if (Storage::disk('ftp')->exists($filePath)) {
                    $list  = new  stdClass;
                    $list->attachs =  $no.'/'.$dlName;
                    $list->file_client_name =  $dlName;
                    $scope[] = $list;
                    $copiedScoped = json_encode($scope);
                } 
                unlink($localFilePath);
            }
        }

        return $copiedScoped;
    }

       // ส่ง Email
        public function SET_EMAIL($certilab,$status = null)
        {

          if(count($certilab->DataEmailDirectorLAB) > 0){

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');

            $request = '';
            if($status == 3){
                $request = 'ได้แก้ไข';
            }else{
                $request = 'ได้ดำเนิน';
            }
            $data_app =  ['email'=>  $certilab->email ?? '-',
                         'certilab'=>  $certilab,
                         'request' => $request,
                         'url'=>  $url.'/certify/check_certificate/'.$certilab->check->id .'/show' ,
                         'email_cc'=>  (count($certilab->DataEmailDirectorLABCC) > 0 ) ? $certilab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                        ];


            if(count($certilab->DataEmailDirectorLABCC) > 0){
                $email_cc =  implode(',', $certilab->DataEmailDirectorLABCC);
            }else{
                $email_cc =  'lab1@tisi.mail.go.th';
            }

            $log_email =  HP::getInsertCertifyLogEmail( $certilab->app_no,
                                                    $certilab->id,
                                                    (new CertiLab)->getTable(),
                                                    $certilab->id,
                                                    (new CertiLab)->getTable(),
                                                    1,
                                                    'คำขอรับบริการยืนยันความสามารถห้องปฏิบัติการ',
                                                    view('mail.lab.applicant', $data_app),
                                                    $certilab->created_by,
                                                    $certilab->agent_id,
                                                    null,
                                                    $certilab->email,
                                                    implode(',',(array)$certilab->DataEmailDirectorLAB),
                                                    $email_cc,
                                                    null,
                                                    null
                                                 );

               $html = new CertifyApplicant($data_app);
               $mail =  Mail::to($certilab->DataEmailDirectorLAB)->send($html);

                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }

          }

        }
        public function SET_EMAIL_Request_Documents($certilab)
        {
          if(count($certilab->DataEmailDirectorLAB) > 0){

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');

           $data_app = ['email'     =>  $certilab->email,
                        'certilab'  =>  $certilab,
                        'url'       =>  $url.'/certify/check_certificate/'.$certilab->check->id .'/show' ,
                        'email_cc'  =>  (count($certilab->DataEmailDirectorLABCC) > 0 ) ? $certilab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                      ];

            $log_email =  HP::getInsertCertifyLogEmail( $certilab->app_no,
                                                    $certilab->id,
                                                    (new CertiLab)->getTable(),
                                                    $certilab->id,
                                                    (new CertiLab)->getTable(),
                                                    1,
                                                    'ขอส่งเอกสารเพิ่มเติม',
                                                    view('mail.lab.request_documents', $data_app),
                                                    $certilab->created_by,
                                                    $certilab->agent_id,
                                                    null,
                                                    $certilab->email,
                                                    implode(',',(array)$certilab->DataEmailDirectorLAB),
                                                    (count($certilab->DataEmailDirectorLABCC) > 0 ) ?   implode(',',(array)$certilab->DataEmailDirectorLABCC) : 'lab1@tisi.mail.go.th',
                                                    null,
                                                    null
                                                 );


             $html = new LABRequestDocumentsMail($data_app);
             $mail =    Mail::to($certilab->DataEmailDirectorLAB)->send($html);

            if(is_null($mail) && !empty($log_email)){
               HP::getUpdateCertifyLogEmail($log_email->id);
            }

          }

        }




    public function updateToEight(Request $request)
    {
        $certi_lab = CertiLab::where('token',$request->findCertiLab)->first();
        $certi_lab->status = 8 ;
        $certi_lab->save();
        if(  $request->hasFile('activity_file')){
            $certi_lab_check = Check::where('app_certi_lab_id',$certi_lab->id)->first();
            $certi_lab_check->invoice = $this->storeFile($request->activity_file,$certi_lab->app_no);
            $certi_lab_check->save();
        }
        // return redirect(route('applicant.index'));
        return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
    }

    public function abilityConfirm(Request $request)
    {

        // dd($request->all());
        $certilab = CertiLab::find($request->id);


        if($certilab->purpose_type == 6)
        {
            if($certilab->transferer_export_id != null){
                // 1. copy ข้อมูล
                $province = Province::find($certilab->province);
                $export = CertificateExport::find($certilab->transferer_export_id);
                $holdStatus = $export->status;
                $exportId = $export->id;
                $mainCertiLabId = $export->certificate_for;
                
                CertificateExport::find($certilab->transferer_export_id)->update([
                    'request_number' => $certilab->app_no,
                    'certificate_for' => $certilab->id,
                    'org_name' => $certilab->name,
                    'lab_name' => $certilab->lab_name,
                    'lab_name_en' => $certilab->lab_name_en,
                    'address_no' => $certilab->address_no,
                    'address_no_en' => $certilab->lab_address_no_eng,
                    'address_moo' => $certilab->allay,
                    'address_moo_en' => $certilab->lab_moo_eng,
                    'address_soi' => $certilab->village_no,
                    'address_soi_en' => $certilab->lab_soi_eng,
                    'address_road' => $certilab->road,
                    'address_road_en' => $certilab->lab_street_eng,
                    'address_province' => $province->PROVINCE_NAME,  //มันเป็น ID
                    'address_province_en' => $province->PROVINCE_NAME_EN, //มันเป็น ID
                    'address_district' => $certilab->amphur,
                    'address_district_en' => $certilab->lab_amphur_eng,
                    'address_subdistrict' => $certilab->district,
                    'address_subdistrict_en' => $certilab->lab_district_eng,
                    'address_postcode' => $certilab->postcode,
                    'certificate_date_start' => Carbon::now(), //ใส่ carbon now
                    'contact_name' =>  $certilab->contactor_name,
                    'contact_tel' =>  $certilab->contact_tel,
                    'contact_mobile' =>  $certilab->telephone,
                    'contact_email' =>  $certilab->email,
                    'status' =>  2,
                    'hold_status' =>  $holdStatus
                ]);
              //2. เปลี่ยน status ของ certificate_exports เป็น 2 อย่าลืมเปลี่ยนกลับ
              //3. ลบ certify_send_certificate_list ที่มี ID ของ certificate_exports (certificate_id)
              SendCertificateLists::where('certificate_id',$exportId)->delete();
            
              $belongCertiLabIds = CertiLabExportMapreq::where('certificate_exports_id',$exportId)->pluck('app_certi_lab_id')->toArray();
              CertiLab::whereIn('id',$belongCertiLabIds)->update([
                'tax_id' => $certilab->tax_id,
                'email' => $certilab->email,
                'tel' => $certilab->tel,
                'contact_tel' => $certilab->contact_tel,
                'telephone' => $certilab->telephone,
              ]);

              CertiLabExportMapreq::where('app_certi_lab_id',$mainCertiLabId)->first()->update([
                'app_certi_lab_id' => $certilab->id
              ]);

            }
            
        }
 
        $isExported = $certilab->certi_lab_export_mapreq_to;

        // dd(Report::where('app_certi_lab_id',$request->id)->first());
 
        $report = Report::where('app_certi_lab_id',$request->id)->first()->update([
            'ability_confirm' => 1
        ]);

        $report = Report::where('app_certi_lab_id',$request->id)->first();



        $config = HP::getConfig();
        $url  =   !empty($config->url_center) ? $config->url_center : url('');


        $data_app =  ['email'=>  $certilab->email ?? '-',
                     'certi_lab'=>  $certilab,
                     'email_cc'=>  (count($certilab->DataEmailDirectorLABCC) > 0 ) ? $certilab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                    ];


        if(count($certilab->DataEmailDirectorLABCC) > 0){
            $email_cc =  implode(',', $certilab->DataEmailDirectorLABCC);
        }else{
            $email_cc =  'lab1@tisi.mail.go.th';
        }

        $log_email =  HP::getInsertCertifyLogEmail( $certilab->app_no,
                                                $certilab->id,
                                                (new CertiLab)->getTable(),
                                                $certilab->id,
                                                (new CertiLab)->getTable(),
                                                1,
                                                'ยืนยันความสามารถห้องปฏิบัติการ',
                                                view('mail.lab.ability_confirm', $data_app),
                                                $certilab->created_by,
                                                $certilab->agent_id,
                                                null,
                                                $certilab->email,
                                                implode(',',(array)$certilab->DataEmailDirectorLAB),
                                                $email_cc,
                                                null,
                                                null
                                             );

           $html = new LabAbilityConfirm($data_app);
           $mail =  Mail::to($certilab->DataEmailDirectorLAB)->send($html);

            if(is_null($mail) && !empty($log_email)){
                HP::getUpdateCertifyLogEmail($log_email->id);
            }

        if($certilab->scope_view_signer_id != null && $certilab->scope_view_status == null )
        {

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');

            $data_app =  [
                'email'=>  $certilab->email ?? '-',
                'certi_lab'=>  $certilab,
                'url'       =>  $url.'/certify/lab-scope-review' ,
                'email_cc'=>  (count($certilab->DataEmailDirectorLABCC) > 0 ) ? $certilab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
            ];
    
    
            if(count($certilab->DataEmailDirectorLABCC) > 0){
                $email_cc =  implode(',', $certilab->DataEmailDirectorLABCC);
            }else{
                $email_cc =  'lab1@tisi.mail.go.th';
            }
    
            $log_email =  HP::getInsertCertifyLogEmail( $certilab->app_no,
                                                $certilab->id,
                                                (new CertiLab)->getTable(),
                                                $certilab->id,
                                                (new CertiLab)->getTable(),
                                                1,
                                                'ลงนามยืนยันขอบข่าย',
                                                view('mail.lab.lab_scope_review', $data_app),
                                                $certilab->created_by,
                                                $certilab->agent_id,
                                                null,
                                                $certilab->email,
                                                implode(',',(array)$certilab->DataEmailDirectorLAB),
                                                $email_cc,
                                                null,
                                                null
                                                );
            
                
            // $singer = DB::table('besurv_signers')
            // ->where('id', $certilab->scope_view_signer_id)
            // ->first();

            // $user = Staff::find($singer->user_register_id); 
            
            $signer = DB::table('besurv_signers')
                ->where('id', $certilab->scope_view_signer_id)
                ->first();

            if ($signer && $signer->tax_number) {

                $user = Staff::whereRaw("REPLACE(reg_13ID, '-', '') = ?", [$signer->tax_number])->first();

                
                $html = new LabScopeReview($data_app);
                $mail =  Mail::to($user->reg_email)->send($html);

                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }
            }


        }

        if($certilab->purpose_type == 6)
        {
            if($certilab->transferer_export_id != null){

                    $config = HP::getConfig();
                    $url  =   !empty($config->url_center) ? $config->url_center : url('');
            
            
                    $data_app =  [
                            'email'=>  $certilab->email ?? '-',
                            'url'           =>  $url.'/certify/send-certificates/create',
                            'certilab'=>  $certilab,
                            'email_cc'=>  (count($certilab->DataEmailDirectorLABCC) > 0 ) ? $certilab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                        ];
            
            
                    if(count($certilab->DataEmailDirectorLABCC) > 0){
                        $email_cc =  implode(',', $certilab->DataEmailDirectorLABCC);
                    }else{
                        $email_cc =  'lab1@tisi.mail.go.th';
                    }
            
                    $log_email =  HP::getInsertCertifyLogEmail( $certilab->app_no,
                                                            $certilab->id,
                                                            (new CertiLab)->getTable(),
                                                            $certilab->id,
                                                            (new CertiLab)->getTable(),
                                                            1,
                                                            'ยืนยันความสามารถห้องปฏิบัติการ',
                                                            view('mail.lab.ability_confirm', $data_app),
                                                            $certilab->created_by,
                                                            $certilab->agent_id,
                                                            null,
                                                            $certilab->email,
                                                            implode(',',(array)$certilab->DataEmailDirectorLAB),
                                                            $email_cc,
                                                            null,
                                                            null
                                                         );
            
                       $html = new SendTransferCertificate($data_app);
                       $mail =  Mail::to($certilab->DataEmailDirectorLAB)->send($html);
            
                        if(is_null($mail) && !empty($log_email)){
                            HP::getUpdateCertifyLogEmail($log_email->id);
                        }



            }
        }

      

        return response()->json([
            'report' => $report
        ]);
    }


        
private function formatDateStrings(string $dateString, string $type): array
{
    // 1. สร้าง Array สำหรับเดือนภาษาไทยไว้ใช้เอง ง่ายและแน่นอนที่สุด
    $thaiMonths = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];

    $date = Carbon::parse($dateString);

    // 2. แยกส่วนประกอบวันที่ออกมา
    $day = $date->day; // เช่น 7
    $monthIndex = $date->month - 1; // Carbon นับเดือน 1-12, Array นับ 0-11
    $buddhistYear = $date->year + 543; // เช่น 2568

    // 3. นำมาประกอบร่างใหม่เป็นข้อความภาษาไทย
    $prefixTh = ($type === 'start') ? 'ออกให้ตั้งแต่วันที่ ' : 'ถึงวันที่ ';
    $thaiText = $prefixTh . $day . ' ' . $thaiMonths[$monthIndex] . ' พ.ศ. ' . $buddhistYear;

    // 4. ส่วนของภาษาอังกฤษ (ยังคงรูปแบบเดิมที่ใช้งานได้ดี)
    $prefixEn = ($type === 'start') ? '(Valid from ' : '(Until ';
    $englishText = $prefixEn . $date->format('F j, Y') . ')';

    // dd($thaiText);

    return [
        'th' => $thaiText,
        'en' => $englishText,
    ];
}

    public function GetPayInOne($id = null,$token = null)
    {
           $previousUrl = app('url')->previous();
           $pay_in  =  CostAssessment::findOrFail($id);
        //    dd($pay_in);

           return view('certify/applicant/form_status.form_pay_in_one',  compact('previousUrl',
                                                                                    'pay_in'
                                                                                  ));
    }
    // Pay-IN ครั้งที่ 1
    public function updateStatusCostAssessment(Request $request ,$id)
    {

             $data_session     =    HP::CheckSession();
    //    try {

            $find_cost_assessment  =  CostAssessment::findOrFail($id);
            // dd($find_cost_assessment);
            if ($request->activity_file15  &&  $request->hasFile('activity_file15')){


            $find_certi_lab = CertiLab::findOrFail($find_cost_assessment->app_certi_lab_id);

            $find_cost_assessment->state = 2;
            $find_cost_assessment->remark = null;
            $find_cost_assessment->status_confirmed = null;
            $find_cost_assessment->invoice =  $this->storeFile($request->activity_file15,$find_certi_lab->app_no) ;
            $find_cost_assessment->invoice_client_name = HP::ConvertCertifyFileName($request->activity_file15->getClientOriginalName()) ;
            $find_cost_assessment->save();



            if(!empty($find_cost_assessment->assessment->auditor_id)){
                // สถานะ แต่งตั้งคณะกรรมการ
                $auditor = BoardAuditor::findOrFail($find_cost_assessment->assessment->auditor_id);
                if(!is_null($auditor)){
                    $auditor->step_id = 5; // แจ้งหลักฐานการชำระเงิน
                    $auditor->save();

                }
            }

            // Log
             $ao = new CostAssessment;
             $history = CertificateHistory::where('table_name',$ao->getTable())
                                                ->where('ref_id',$find_cost_assessment->id)
                                                ->where('system',3)
                                                ->orderby('id','desc')
                                                ->first();
             if(!is_null($history)){
                 $history->update([
                                      'attachs_file'    =>  $find_cost_assessment->invoice ?? null,
                                      'evidence'        =>  $find_cost_assessment->invoice_client_name ?? null,
                                      'updated_by'      =>  auth()->user()->getKey() ,
                                      'date'            =>  date('Y-m-d')
                                    ]);

             }

             // Mail ลท.
            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url('');

             if($find_certi_lab && !is_null($find_certi_lab->email)  && count($find_certi_lab->CertiEmailLt) > 0 ){


                       $data_app = ['certi_lab'      => $find_certi_lab,
                                    'assessment'    => $find_cost_assessment,
                                    'email'         => $find_certi_lab->email,
                                    'url'           =>  $url.'/certify/check_certificate/'.$find_certi_lab->check->id .'/show' ,
                                    'email_cc'      =>  (count($find_certi_lab->DataEmailAndLtLABCC) > 0 ) ? $find_certi_lab->DataEmailAndLtLABCC : 'lab1@tisi.mail.go.th'
                                  ];

                        $log_email =  HP::getInsertCertifyLogEmail( $find_certi_lab->app_no,
                                                                    $find_certi_lab->id,
                                                                    (new CertiLab)->getTable(),
                                                                    $find_cost_assessment->id,
                                                                    (new CostAssessment)->getTable(),
                                                                    1,
                                                                    'แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน',
                                                                    view('mail.lab.pay_in1', $data_app),
                                                                    $find_certi_lab->created_by,
                                                                    $find_certi_lab->agent_id,
                                                                    null,
                                                                    $find_certi_lab->email,
                                                                    implode(',',(array)$find_certi_lab->CertiEmailLt),
                                                                    (count($find_certi_lab->DataEmailAndLtLABCC) > 0 ) ?   implode(',',(array)$find_certi_lab->DataEmailAndLtLABCC) : 'lab1@tisi.mail.go.th',
                                                                    null,
                                                                    null
                                                                 );

                            $html = new CertifyPayIn1($data_app);
                            $mail =    Mail::to($find_certi_lab->CertiEmailLt)->send($html);

                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }


            }

            if(!empty($find_certi_lab->app_no) && !empty($find_cost_assessment->app_certi_assessment_id)){
                        //  เช็คการชำระ
                    $arrContextOptions=array();
                    if(strpos($url, 'https')===0){//ถ้าเป็น https
                        $arrContextOptions["ssl"] = array(
                                                        "verify_peer" => false,
                                                        "verify_peer_name" => false,
                                                    );
                    }
                    file_get_contents($url.'api/v1/checkbill?ref1='.$find_certi_lab->app_no.'-'.$find_cost_assessment->app_certi_assessment_id, false, stream_context_create($arrContextOptions));
            }

        }
            return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
    //   } catch (\Exception $e) {
    //         return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    //   }
    }


    public function updateStatusCostCertificate(Request $request,$id)
    {

       

        $data_session     =    HP::CheckSession();
        // try {

        $attach_path   = $this->attach_path;
        $find_cost_certificate = CostCertificate::findOrFail($id);

        if(!is_null($find_cost_certificate) &&  isset($request->activity_file19)  &&  $request->hasFile('activity_file19') ){
                //สถานะ
               
                $find_certi_lab = CertiLab::findOrFail($find_cost_certificate->app_certi_lab_id);
                $find_certi_lab->status = 24; //แจ้งหลักฐานการชำระค่าใบรับรอง
                $find_certi_lab->save();

                $find_cost_certificate->invoice              = $this->storeFile($request->activity_file19,$find_certi_lab->app_no);
                $find_cost_certificate->invoice_client_name = HP::ConvertCertifyFileName($request->activity_file19->getClientOriginalName()) ;


                $find_cost_certificate->save();

                $file = $find_cost_certificate->invoice;
                if( HP::checkFileStorage($attach_path.$file)){
                    HP::getFileStorage($attach_path.$file);
                }

            // Log
              $ao = new CostCertificate;
             $CertificateHistory = CertificateHistory::where('table_name',$ao->getTable())
                                                        ->where('ref_id',$id)
                                                        ->where('system',6)
                                                        ->orderby('id','desc')
                                                        ->first();
            if(!is_null($CertificateHistory)){
                $CertificateHistory->update([
                                                'attachs_file'     =>  $file ?? null,
                                                'evidence'         =>  $find_cost_certificate->invoice_client_name ?? null,
                                                'updated_by'       => auth()->user()->getKey() ,
                                                'date'             => date('Y-m-d')
                                             ]);
            }


        $config = HP::getConfig();
        $url  =   !empty($config->url_center) ? $config->url_center : url('');

            // ส่ง Email เจ้าหน้าที่มอบหมาย
        if(!is_null($find_certi_lab->email) && count($find_certi_lab->CertiEmailLt) > 0){
                    $data_app = [
                                'PayIn'         => $find_cost_certificate,
                                'find_certi'    => $find_certi_lab ,
                                'file'          => $file ,
                                'email'         => $find_certi_lab->email,
                                'url'           =>  $url.'/certify/check_certificate/'.$find_certi_lab->check->id .'/show' ,
                                'email_cc'      =>  (count($find_certi_lab->DataEmailAndLtLABCC) > 0 ) ? $find_certi_lab->DataEmailAndLtLABCC : 'lab1@tisi.mail.go.th'
                               ];

                        $log_email =  HP::getInsertCertifyLogEmail( $find_certi_lab->app_no,
                                                                    $find_certi_lab->id,
                                                                    (new CertiLab)->getTable(),
                                                                    $find_cost_certificate->id,
                                                                    (new CostCertificate)->getTable(),
                                                                    1,
                                                                    'แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง',
                                                                    view('mail.lab.pay_in_two', $data_app),
                                                                    $find_certi_lab->created_by,
                                                                    $find_certi_lab->agent_id,
                                                                    null,
                                                                    $find_certi_lab->email,
                                                                    implode(',',(array)$find_certi_lab->CertiEmailLt),
                                                                    (count($find_certi_lab->DataEmailAndLtLABCC) > 0 ) ?   implode(',',(array)$find_certi_lab->DataEmailAndLtLABCC) : 'lab1@tisi.mail.go.th',
                                                                    null,
                                                                    'certify/check/file_client/'.$file.'/'.$find_cost_certificate->invoice_client_name
                                                                 );

                            $html = new CertifyCostCertificate($data_app);
                            $mail =    Mail::to($find_certi_lab->CertiEmailLt)->send($html);

                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }


           }

           if(!empty($find_certi_lab->app_no)){
                        //  เช็คการชำระ
                    $arrContextOptions=array();
                    if(strpos($url, 'https')===0){//ถ้าเป็น https
                        $arrContextOptions["ssl"] = array(
                                                        "verify_peer" => false,
                                                        "verify_peer_name" => false,
                                                    );
                    }
                    file_get_contents($url.'api/v1/checkbill?ref1='.$find_certi_lab->app_no, false, stream_context_create($arrContextOptions));
            }

          }
            return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
    //  } catch (\Exception $e) {
    //         return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    // }
 }

    public function updateStatusStatusCertificate(Request $request)
    {
    // try {
        $find_certi_lab = CertiLab::where('token',$request->findCertiLab23)->first();
        $find_certificate_export = CertificateExport::where('request_number',$find_certi_lab->app_no)->first();

        if ($request->checkStatusCertificate == 1){
            $find_certi_lab->status = 25 ;
            $find_certi_lab->save();

            $find_certificate_export->status = 2;
            $find_certificate_export->save();
        }

        else{
            $find_certi_lab->status = 24 ;
            $find_certi_lab->save();

            $find_certificate_export->status = 0;
            $find_certificate_export->save();

            $find_desc = new CertificateExportDesc();
            $find_desc->certificate_exports_id = $find_certificate_export->id;
            $find_desc->description_detail = $request->remarkCertificate;
            $find_desc->description_date = Carbon::now();
            $find_desc->save();

            if ($request->another_attach_files_del23 &&  $request->hasFile('another_attach_files_del23')){
                foreach ($request->another_attach_files_del23 as $data){
                    $certificate_export_file = new CertificateExportFile();
                    $certificate_export_file->certificate_exports_id = $find_certificate_export->id;
                    $certificate_export_file->file_path = $this->storeFile($data,$find_certi_lab->app_no);
                    $certificate_export_file->save();
                }
            }

        }

        // return redirect(route('applicant.index'));
        return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');

        // } catch (\Exception $e) {
        //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
        // }
  }



    public function updateStatusNotice(Request $request)
    {
        // try {
        $certi_lab = CertiLab::where('token',$request->certiLab17)->first();
        $find_notice = Notice::where('app_certi_lab_id',$certi_lab->id)->get();

//        dd($request);

        $count_index = 1;
        $number = 0;


        foreach ($request->descNotice as $data){
            $find_notice[$number]->desc = $request->descNotice[$count_index];
            $find_notice[$number]->status_edit = 1;
            $find_notice[$number]->save();


            // add file
            $nameFile = "another_modal_attach_files17".$count_index;
            if ($request->$nameFile  &&  $request->hasFile('nameFile'))
            {
                foreach ($request->$nameFile as $file){
                    $notice_file = new NoticeFile();
                    $notice_file->app_certi_lab_notice_id = $find_notice[$number]->id;
                    $notice_file->file = $this->storeFile($file,$certi_lab->app_no);
                    $notice_file->save();


                }
                $count_index++;
                $number++;
            }

        }
        // return redirect(route('applicant.index'));
            return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
        // } catch (\Exception $e) {
        //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
        // }
    }

    public function removeFiles($path){
//        $model = str_slug('certificate','-');
//        if(auth()->user()->can('edit-'.$model)) {
            try{
                $file = storage_path().'/files/applicants/check_files/'.$path;
                if (!File::exists($file)) {
                    return Response::make("File does not exist.", 404);
                }
                if(is_file($file)){
                    File::delete($file);
                }else {
                    echo "File does not exist";
                }
                return true;
            }catch (\Exception $x){
                return false;
            }
//        }
//        abort(403);
    }

    public function removeFilesWithMessage($path,$token){
//        $model = str_slug('certificate','-');
//        if(auth()->user()->can('edit-'.$model)) {
            $obj = CertiLabCheckBoxImage::whereToken($token)->first() ?? CertiLabAttachMore::whereToken($token)->first() ?? null;

            try{
                $obj->delete();
                $file = storage_path().'/files/applicants/check_files/'.$path;
                if (!File::exists($file)) {
                    return Response::make("File does not exist.", 404);
                }
                if(is_file($file)){
                    File::delete($file);
                }else {
                    echo "File does not exist";
                }
                return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
            }catch (\Exception $x){
                echo "เกิดข้อผิดพลาด";
            }
//        }
//        abort(403);
    }

    public function removeFilesCertiLabAttachAll($path,$token){

               $certi_lab_attach = CertiLabAttachAll::where('token',$token)->first();

                try{
                    $certi_lab_attach->delete();
                    $file = storage_path().'/files/applicants/check_files/'.$path;
                    if(is_file($file)){
                        File::delete($file);
                    }
                    return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
                }catch (\Exception $x){
                    echo "เกิดข้อผิดพลาด";
                }
   }
   public function removeFilesCertiLabAttachhMoreAll($path,$token){
    $certi_lab_attach = CertiLabAttachMore::where('token',$token)->first();
     try{
         $certi_lab_attach->delete();
         $file = storage_path().'/files/applicants/check_files/'.$path;
         if(is_file($file)){
             File::delete($file);
         }
         return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
     }catch (\Exception $x){
         echo "เกิดข้อผิดพลาด";
     }
}
    public function removeFilesCertiLabCheckBoxImage($path,$token){
           $certi_lab_attach = CertiLabCheckBoxImage::where('token',$token)->first();
            try{
                     $certi_lab_attach->delete();
                     $file = storage_path().'/files/applicants/check_files/'.$path;
                     if(is_file($file)){
                         File::delete($file);
                     }
                return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
            }catch (\Exception $x){
             echo "เกิดข้อผิดพลาด";
           }
    }
    public function UpdateFileLabInfo($id,$token){
            $certi_lab_info =  CertiLabInfo::findOrFail($id);
        if(!is_null($certi_lab_info)){
            $certi_lab_info->desc_main_file = null;
            $certi_lab_info->save();
        }
        return redirect()->back()->with('message', 'ลบไฟล์แล้ว!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //แต่งตั้งคณะผู้ตรวจประเมิน
    public function updateStatusCommentOpinion(Request $request)
    {
    //    try{
        $certi_lab = CertiLab::where('token',$request->certiLab13)  ->orderby('id','desc')->first();
        $assessment = Assessment::where('app_certi_lab_id',$certi_lab->id)->first();
        $assessment_group = AssessmentGroup::where('app_certi_lab_id',$certi_lab->id)->where('app_certi_assessment_id',$assessment->id)->get();

        $count = 1;
        foreach ($assessment_group as $group){
            $status = "status13".$count;
            $file = "another_modal_attach_files13".$count;
            if ($request->$status == 1){
                $group->status = 1 ;
                $group->save();
            }
            else{
                $group->status = 2;
                $group->remark = $request->reason13[$count];
                $group->save();
                if ($request->$file &&  $request->hasFile('file')){
                    $countFile = 0;
                    foreach ($request->$file as $dataFile){
                        $add_file = new AssessmentGroupFile();
                        $add_file->app_certi_assessment_group_id = $group->id;
                        $add_file->file = $this->storeFile($request->$file[$countFile],$certi_lab->app_no);
                        $add_file->save();
                        $countFile++ ;
                    }
                }
            }
            $count++;
        }

        if(count($assessment_group) > 0){
           $assessment =  $assessment_group->last();
           $certi_lab->status =  !empty($assessment->status)? 22 :  20;
        }else{
            $certi_lab->status = 20;
        }
        $certi_lab->save();

        // return redirect(route('applicant.index'));
           return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
        // } catch (\Exception $e) {
        //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
        // }
    }


    public function deleteApplicant(Request $request)
    {

        $certi_lab = CertiLab::where('id',$request->find_certi_lab)->first();
        $certi_lab->desc_delete = $request->reason;
        $certi_lab->status = 4;
        $certi_lab->save();

        $number = 0 ;
        foreach ($request->another_attach_name as $data){
            $file_delete = new CertiLabDeleteFile();
            $file_delete->app_certi_lab_id = $certi_lab->id;
            $file_delete->name = $request->another_attach_name[$number];
            $file_delete->path = $this->storeFile($request->another_attach_files_del[$number],$certi_lab->app_no);
            $file_delete->save();
            $number ++ ;
        }

        // return redirect(route('applicant.index'));
        return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
    }


    public function apiTest(Request $request)
    {
        $branchs = DB::table('bcertify_test_branches')->select('*')->where('state',1)->get();
        return $branchs;
    }

    public function apiInstrumentGroup(Request $request)
    {
        $bcertify_calibration_branche_id = $request->bcertify_calibration_branche_id;

        $calibrationBranchInstrumentGroups = CalibrationBranchInstrumentGroup::where('bcertify_calibration_branche_id',$bcertify_calibration_branche_id)
                                        ->where('state',1)
                                        ->get();

        return $calibrationBranchInstrumentGroups;
    }

    public function apiTestCategory(Request $request)
    {
        $bcertify_test_branche_id = $request->bcertify_test_branche_id;
        
        
        $testBranchCategories = TestBranchCategory::where('bcertify_test_branche_id',$bcertify_test_branche_id)
                                        ->where('state',1)
                                        ->get();
        return $testBranchCategories;
    }

    public function apiInstrumentAndParameter(Request $request)
    {
        $calibration_branch_instrument_group_id = $request->calibration_branch_instrument_group_id;
       
        // ดึงข้อมูล instruments, parameter_one และ parameter_two
        $calibrationBranchInstruments = CalibrationBranchInstrument::where('calibration_branch_instrument_group_id', $calibration_branch_instrument_group_id)
                                            ->where('state', 1)
                                            ->get();

        $calibrationBranchParam1s = CalibrationBranchParam1::where('calibration_branch_instrument_group_id', $calibration_branch_instrument_group_id)
                                            ->where('state', 1)
                                            ->get();

        $calibrationBranchParam2s = CalibrationBranchParam2::where('calibration_branch_instrument_group_id', $calibration_branch_instrument_group_id)
                                            ->where('state', 1)
                                            ->get();

        // ส่งคืนข้อมูลในรูปแบบ JSON
        return response()->json([
            'instrument' => $calibrationBranchInstruments,
            'parameter_one' => $calibrationBranchParam1s,
            'parameter_two' => $calibrationBranchParam2s,
        ]);
    }

    
    public function apiTestParameter(Request $request)
    {
        $test_branch_category_id = $request->test_branch_category_id;
        $testBranchParams = TestBranchParam::where('test_branch_category_id', $test_branch_category_id)
                ->where('state', 1)
                ->get();

        // dd($testBranchParams);

        return $testBranchParams;
    }


    public function apiCalibrate(Request $request)
    {
        $branchs = DB::table('bcertify_calibration_branches')->select('*')->where('state',1)->get();
        return $branchs;
    }
    
    public function apiGetScope(Request $request)
    {
        $certiLab = CertiLab::find($request->certi_lab_id);

        $labCalScopeTransactions = LabCalScopeTransaction::where('app_certi_lab_id', $certiLab->id)->where('group',$request->group)->with([
            'calibrationBranch',
            'calibrationBranchInstrumentGroup',
            'calibrationBranchInstrument',
            'calibrationBranchParam1',
            'calibrationBranchParam2'
        ])
        ->get();

        if (is_null($labCalScopeTransactions)) {
        $labCalScopeTransactions = [];
        }


        $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certiLab->id)->with([
                    'certiLab', 
                    'province', 
                    'amphur', 
                    'district'
                ])->get();

        return response()->json([
            'attach_path' => $this->attach_path,
            'certiLab' => $certiLab,
            'labCalScopeTransactions' => $labCalScopeTransactions,
            'branchLabAdresses' => $branchLabAdresses
        ]);
    }
    


    public function apiGetCertificated(Request $request)
    {
    //    dd('assss');
        $certificateExport = CertificateExport::find($request->certified_id);
 
        $certiLab = CertiLab::where('app_no',$certificateExport->request_number)->first();

        
        $district= District::where('DISTRICT_NAME',trim($certiLab->district))->where('PROVINCE_ID',$certiLab->province)->first();

        // Fetching files for section 4
        $file_sectionn4s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '4')
            ->get();

        // Fetching files for section 5
        $file_sectionn5s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '5')
            ->get();

        $file_sectionn71s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '71')
            ->get();

        $file_sectionn72s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '72')
            ->get();

            $file_sectionn8s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '8')
            ->get();

            $file_sectionn9s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '9')
            ->get();

            $file_sectionn10s = CertiLabAttachAll::where('app_certi_lab_id', $certiLab->id)
            ->where('file_section', '10')
            ->get();

            $file_others = CertiLabAttachMore::where('app_certi_lab_id', $certiLab->id)
            ->get();

            $certi_lab_place = CertiLabPlace::Where('app_certi_lab_id',$certiLab->id)->first();


            $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $certiLab->id)
            ->where('status', 2)
            ->first();


        
            $labCalScopeTransactions = $labCalScopeUsageStatus ? 
            $labCalScopeUsageStatus->transactions()->with([
            'calibrationBranch',
            'calibrationBranchInstrumentGroup',
            'calibrationBranchInstrument',
            'calibrationBranchParam1',
            'calibrationBranchParam2'
            ])->get() : [];

            if (is_null($labCalScopeTransactions)) {
            $labCalScopeTransactions = [];
            }


            $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certiLab->id)->with([
                                    'certiLab', 
                                    'province', 
                                    'amphur', 
                                    'district'
                                ])->get();

            $certiLabInfo =  CertiLabInfo::where('app_certi_lab_id',$certiLab->id)->first();


            $labTestRequest = LabTestRequest::with([
                'certiLab', 
                'labTestTransactions.labTestMeasurements'
            ])
            ->where('app_certi_lab_id', $certiLab->id)
            ->get();

            $labCalRequest = LabCalRequest::with([
                'certiLab', 
                'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
            ])
            ->where('app_certi_lab_id', $certiLab->id)
            ->get();

            $mainLabScopeTransaction = LabScopeTransaction::where('app_certi_lab_id', $certiLab->id)
            ->where('lab_type','main')
            ->first();
            $branchLabScopeTransactions = LabScopeTransaction::where('app_certi_lab_id', $certiLab->id)
            ->where('lab_type','branch')
            ->get();

        return response()->json([
            'attach_path' => $this->attach_path,
            'certiLab' => $certiLab,
            'certificateExport' => $certificateExport,
            'address' => $this->GetAddreess($district->DISTRICT_ID),
            'file_sectionn4s' => $file_sectionn4s,
            'file_sectionn5s' => $file_sectionn5s,
            'file_sectionn71s' => $file_sectionn71s,
            'file_sectionn72s' => $file_sectionn72s,
            'file_sectionn8s' => $file_sectionn8s,
            'file_sectionn9s' => $file_sectionn9s,
            'file_sectionn10s' => $file_sectionn10s,
            'file_others' => $file_others,
            'certi_lab_place' => $certi_lab_place,
            'branchLabAdresses' => $branchLabAdresses,
            'labCalScopeTransactions' => $labCalScopeTransactions,
            'certiLabInfo' => $certiLabInfo,
            'labTestRequest' => $labTestRequest,
            'labCalRequest' => $labCalRequest,
            'mainLabScopeTransaction' => $mainLabScopeTransaction,
            'branchLabScopeTransactions' => $branchLabScopeTransactions
        ]);
    }


    public function apiCertificateExports(Request $request)
    {
        $data_session           = HP::CheckSession();

        if ($request->select == 'test'){
            $lab_ability = 3;
        }else{
            $lab_ability = 4;
        }

        $app_certi_labs         = CertiLab::where('lab_type',$lab_ability)->where('tax_id',$data_session->tax_number)->select('id');
        $certificate_exports    = DB::table('certificate_exports')->whereIn('certificate_for',$app_certi_labs)->where('status',3)->get();
        return response()->json($certificate_exports);
    }

    
    public function  getCertificatedBelong(Request $request)
    {
        $user = auth()->user();
        // dd($user->tax_number) ;
        $standardId = $request->input('std_id');
        $labType = $request->input('lab_type');

        $appCertiLabIds = CertiLab::where('tax_id',$user->tax_number)
        ->where('standard_id',$standardId)
        ->where('lab_type',$labType)
        ->pluck('id')->toArray();

        $certificateExports = CertificateExport::whereIn('certificate_for',$appCertiLabIds)->get();

        return response()->json([
            'certificateExports' => $certificateExports
       ]);
    }

    public function  checkTransferee(Request $request)
    {

        // dd($request->all());
        $user = null;
       
        $transfererIdNumber = $request->input('transferer_id_number');
        $certificateNumber = $request->input('transferee_certificate_number');
        $std_id = $request->input('std_id');
        $lab_type = $request->input('lab_type');

        $certificateExport = CertificateExport::where('certificate_no',$certificateNumber)->first();
       
        if($certificateExport != null){
            $certiLab = CertiLab::where('app_no',$certificateExport->request_number)
            ->where('standard_id',$std_id)
            ->where('lab_type',$lab_type)
            ->first();

            if($certiLab != null)
            {
                $taxId = $certiLab->tax_id;
                if(trim($taxId) == trim($transfererIdNumber)) 
                {
                    $user = User::where('username',$transfererIdNumber)->first();
                    // dd($user);
                }
            }
        }

        return response()->json([
            'user' => $user,
            // 'certiLab' => $certiLab,
       ]);
    }

    public function isLabTypeAndStandardBelong(Request $request)
    {
        $user = auth()->user();

        $standardId = $request->input('std_id');
        $labType = $request->input('lab_type');

        $appCertiLabIds = CertiLab::where('tax_id',$user->tax_number)->pluck('id')->toArray();
   
        $certiLabExportMapreqs = CertiLabExportMapreq::whereIn('app_certi_lab_id',$appCertiLabIds)->pluck('app_certi_lab_id')->toArray();
    
        $certiLabs = CertiLab::whereIn('id',$certiLabExportMapreqs)
                  ->where('lab_type',$labType)
                  ->where('standard_id',$standardId)
                  ->get();
    

       
       return response()->json([
            'certiLabs' => $certiLabs
       ]);
    }

    public function get_app_no_and_certificate_exports_no(Request $request)
    {
        $data_session           = HP::CheckSession();
        $standard_id = $request->input('std_id');
        $lab_type_check = $request->input('lab_type');
        if($lab_type_check == 'test'){
            $lab_type = 3;
        }else if($lab_type_check == 'calibrate'){
            $lab_type = 4;
        }

        try {
            $app_certi_lab         = CertiLab::with([
                                                    'certificate_exports_to' => function($q){
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
                                                ->where('standard_id', $standard_id)
                                                ->where('lab_type', $lab_type)
                                                ->first();
            $data = array(
                'status' => true,
                'app_no' => $app_certi_lab->app_no ?? null,
                'certificate_exports_no' => $app_certi_lab->certificate_exports_to->certificate_no ?? null
            );
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'satus' => false,
                'error_message' => $e
            ]);
        }
    }

    private function save_certilab_export_mapreq($certi_lab)
    { 
            // ตรวจสอบว่าบริษัทมีคำขอที่ใบรับรองจากมาตรฐาน standard_id และประเภทแลบ (สอบเทียบ / ทดสอบหรือไม่)
          $app_certi_lab  = CertiLab::with([
                                    'certificate_exports_to' => function($q){
                                        $q->whereIn('status',['0','1','2','3','4']);
                                    }
                                ])
                                ->where('created_by', $certi_lab->created_by)
                                ->whereNotIn('status', ['0','4'])
                                ->where('standard_id', $certi_lab->standard_id)
                                ->where('lab_type', $certi_lab->lab_type)
                                ->first();
        //  if(!Is_null($app_certi_lab)){
        // ถ้าพบว่ามีคำขอที่ได้รับใบรับรอง ในมาตรฐาน standard_id และประเภทแลบ (สอบเทียบ / ทดสอบหรือไม่)
        if($app_certi_lab !== null){
            // ให้ดึง id ของตารางใบรับรองนั้นออกมา 
             $certificate_exports_id = !empty($app_certi_lab->certificate_exports_to->id) ? $app_certi_lab->certificate_exports_to->id : null;
              if(!Is_null($certificate_exports_id)){
                  // จากนั้นนำไปเพิ่มในตาราง certificate_export_mapreq 
                  $mapreq =  CertiLabExportMapreq::where('app_certi_lab_id',$certi_lab->id)->where('certificate_exports_id', $certificate_exports_id)->first();
                  if(Is_null($mapreq)){
                      $mapreq = new  CertiLabExportMapreq;
                  }
                  $mapreq->app_certi_lab_id       = $certi_lab->id;
                  $mapreq->certificate_exports_id = $certificate_exports_id;
                  $mapreq->save();
              }
         }
    }



    public function apiTestItem(Request $request)
    {
        $arr_data = array();
        $test_item = DB::table('bcertify_test_items')->select('*')->where('test_branch_id',$request->select)->get();
        $product_categories = DB::table('bcertify_product_categories')->select('*')->where('test_branch_id',$request->select)->get();
        array_push($arr_data,$test_item,$product_categories);
        return $arr_data;
    }

    function dataApiTestItem($test_branch_id) {
        $arr_data = array();
        // ทดสอบ
        $test_item = DB::table('bcertify_test_items')->select(DB::raw("CONCAT(bcertify_test_branches.title,' - ',bcertify_test_items.title) AS titles"),'bcertify_test_items.id')
                            ->Join('bcertify_test_branches','bcertify_test_branches.id','=','bcertify_test_items.test_branch_id')
                            ->whereIn('bcertify_test_items.test_branch_id',explode(",",$test_branch_id))
                            ->get();
        //  สอบเทียบ
        $product_categories = DB::table('bcertify_product_categories')->select(DB::raw("CONCAT(bcertify_test_branches.title,' - ',bcertify_product_categories.title) AS titles"),'bcertify_product_categories.id')
                            ->Join('bcertify_test_branches','bcertify_test_branches.id','=','bcertify_product_categories.test_branch_id')
                            ->whereIn('bcertify_product_categories.test_branch_id',explode(",",$test_branch_id))
                            ->get();
        array_push($arr_data,$test_item,$product_categories);
        return response()->json($arr_data);
    }

    public function apiTestProduct(Request $request)
    {
        $product = DB::table('bcertify_product_items')->select('*')->where('product_category_id',$request->select)->get();
        return $product;
    }

    public function apiCalibrateItem(Request $request)
    {
        $calibration_groups = DB::table('bcertify_calibration_groups')->select('*')->where('calibration_branch_id',$request->select)->get();
        return $calibration_groups;
    }

    public function apiCalibrateList(Request $request)
    {
        $calibration_list = DB::table('bcertify_calibration_items')->select('*')->where('calibration_group_id',$request->select)->get();
        return $calibration_list;
    }

    public function apiAmphur(Request $request)
    {
        $amphur = DB::table('amphur')->select('AMPHUR_ID','AMPHUR_NAME')->where('PROVINCE_ID',$request->select)->orderbyRaw('CONVERT(AMPHUR_NAME USING tis620)')->get();
        return $amphur;
    }

    public function apiDistrict(Request $request)
    {
        $district = DB::table('district')->select('DISTRICT_ID','DISTRICT_NAME')->where('AMPHUR_ID',$request->select)->orderbyRaw('CONVERT(DISTRICT_NAME USING tis620)')->get();
        return $district;
    }



    public function assess($token)
    {
        $certi_lab = CertiLab::where('token',$token)->first();
        $certi_lab->name = $certi_lab->information->name ?? null;

        $find_notice = Notice::where('app_certi_lab_id',$certi_lab->id)->orderby('id','desc') ->first();
        $certi_lab->assessment_date = HP::revertDate($find_notice->assessment_date->format('Y-m-d'),true) ?? null;
        $certi_lab->DataGroupeTitle = $find_notice->DataGroupeTitle ?? null;
       return view('certify/applicant/form_status.form_status19',[
                                                                   'certi_lab'=>$certi_lab,
                                                                   'find_notice'=>$find_notice
                                                                   ]);
    }

    public function storeFileCut($files, $app_no = 'files_lab', $name = null)
    {
        $no  = str_replace("RQ-","",$app_no);
        $no  = str_replace("-","_",$no);

        if ($files) {
             $attach_path  =  $this->attach_path.$no;
             $file_extension = $files->getClientOriginalExtension();
             $fileClientOriginal   =  HP::ConvertCertifyFileName($files->getClientOriginalName());
             $filename = pathinfo($fileClientOriginal, PATHINFO_FILENAME);
             $fullFileName =  mb_substr(str_replace(" ","",$filename),-20).'-date_time'.date('Ymd_hms') . '.' . $files->getClientOriginalExtension();
             $fileData = mb_convert_encoding($fullFileName, "UTF-8", "auto");

             $storagePath = Storage::putFileAs($attach_path, $files, $fileData );
            $storageName = basename($storagePath); // Extract the filename
            return  $no.'/'.$storageName;
        }else{
            return null;
        }
    }



    public function PassInspection($id,$token)
    {
        // dd('ok');
        $certi_lab = CertiLab::where('token',$token)->first();
        $certi_lab->name = $certi_lab->name ?? null;


        $find_notice = Notice::where('id',base64_decode($id))->first();

        $certi_lab->assessment_date = HP::revertDate($find_notice->assessment_date->format('Y-m-d'),true) ?? null;
        $certi_lab->DataGroupeTitle = $find_notice->DataGroupeTitle ?? null;

       return view('certify.applicant.form_status.form_status15',[
                                                                   'certi_lab'=>$certi_lab,
                                                                   'find_notice'=>$find_notice
                                                                   ]);
    }

    public function inspection_update(Request $request, $id)
    {


    //   try{
         $data_session     =    HP::CheckSession();
         $notice           =    Notice::findOrFail($id);
         $certi_lab        =    CertiLab::findOrFail($notice->app_certi_lab_id);
         $committee        =    BoardAuditor::findOrFail($notice->auditor_id);
         $ao = new Notice;
          if(!is_null($notice)){

             if($request->status_scope == 1){  // update สถานะ



                 $notice->status = 1;
                 $notice->degree = 7;
                 $notice->save();

                // สถานะ แต่งตั้งคณะกรรมการ
                 $committee->step_id = 10; //ยืนยัน Scope
                 $committee->save();

              // สถานะ แต่งตั้งคณะกรรมการ
              $board_auditor = BoardAuditor::where('app_certi_lab_id',$certi_lab->id)
                                                ->whereIn('step_id',[9,10])
                                                ->whereNull('status_cancel')
                                                ->get();
               if(count($board_auditor) == count($certi_lab->certi_auditors_many)){
                    $json = $this->copyScopeLabFromAttachement($certi_lab);
                    $copiedScopes = json_decode($json, true);
                  //  สรุปรายงานและเสนออนุกรรมการฯ
                  $report = new Report;
                  $report->app_certi_assessment_id = $notice->app_certi_assessment_id;
                  $report->app_certi_lab_id        = $certi_lab->id;
                  $report->file_loa = $copiedScopes[0]['attachs'];
                  $report->file_loa_client_name = $copiedScopes[0]['file_client_name'];
                  $report->save();
                     // ทบทวน
                //   $certi_lab->review   = 1;
                //   $certi_lab->status   = 12;
                  $certi_lab->status   = 20;
                  $certi_lab->save();

                }

             }else{

            //    $notice->date_scope_edit  = date('Y-m-d h:m:s');
               $notice->status         = 2;
               $notice->degree         = 5;
               $notice->file_scope     =  null;

               $notice->save();


                    if($request->attach_files &&  $request->hasFile('attach_files')){   //  ไฟล์แนบ
                        foreach ($request->attach_files as $key => $itme) {
                        $list  = new  stdClass;
                        $list->attachs =   $this->storeFile($itme,$certi_lab->app_no);
                        $list->attachs_client_name =  HP::ConvertCertifyFileName($itme->getClientOriginalName());
                        $list->file_desc_text =   $request->file_desc_text[$key]  ?? null;
                        $evidence[] = $list;
                        }
                    }


               $committee->step_id = 11; // ขอแก้ไข Scope
               $committee->save();
             }
                $history = CertificateHistory::where('table_name',$ao->getTable())
                                                        ->where('ref_id',$notice->id)
                                                        ->where('system',11)
                                                        ->orderby('id','desc')
                                                        ->first();
                if(!is_null($history)){
                    $history->update([
                                            'status_scope'=> $notice->status ?? null,
                                            'remark'=> $request->remark_scope ?? null,
                                            'evidence'=>  isset($evidence)  ? json_encode($evidence) : null,
                                            'updated_by' =>  auth()->user()->getKey() ,
                                            'date' => date('Y-m-d')
                                            ]);
                }




             //Mail
            if(!is_null($certi_lab->email) && count($certi_lab->DataEmailDirectorLAB) > 0){
                    $config = HP::getConfig();
                    $url  =   !empty($config->url_center) ? $config->url_center : url('');
                   $status_scope = ['1'=>'เห็นชอบกับ Scope','2'=>'ไม่เห็นชอบกับ Scope'];


                    $config = HP::getConfig();
                    $url  =   !empty($config->url_center) ? $config->url_center : url('');

                    $data_app = [
                                'certi_lab'    => $certi_lab,
                                'email'         => $certi_lab->email,
                                'status_scope'  => $request->status_scope ??  '',
                                'remark'        => $request->remark_scope ?? null,
                                'evidence'      =>  isset($evidence)  ?  $evidence : null,
                                'url'           => $url.'/certify/check_certificate/'.$certi_lab->id.'/show' ,
                                'email_cc'      =>  (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ? $certi_lab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                                ];

                    $log_email =  HP::getInsertCertifyLogEmail( $certi_lab->app_no,
                                                                $certi_lab->id,
                                                                (new CertiLab)->getTable(),
                                                                $notice->id,
                                                                (new Notice)->getTable(),
                                                                1,
                                                                'ยืนยันขอบข่ายการรับรองหน่วยตรวจ',
                                                                view('mail.lab.certify_confirm_assessment', $data_app),
                                                                $certi_lab->created_by,
                                                                $certi_lab->agent_id,
                                                                null,
                                                                $certi_lab->email,
                                                                implode(',',(array)$certi_lab->DataEmailDirectorLAB),
                                                                (count($certi_lab->DataEmailAndLtLABCC) > 0 ) ?   implode(',',(array)$certi_lab->DataEmailAndLtLABCC) : 'lab1@tisi.mail.go.th',
                                                                null,
                                                                null
                                                                );

                        $html = new CertifyConfirmAssessment($data_app);
                        $mail =    Mail::to($certi_lab->DataEmailDirectorLAB)->send($html);

                        if(is_null($mail) && !empty($log_email)){
                            HP::getUpdateCertifyLogEmail($log_email->id);
                        }

           }

        }


          return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
        // } catch (\Exception $e) {
        //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
        // }
    }


    public function updateStatusReport(Request $request, $id)
    {

        $data_session     =    HP::CheckSession();
    //  try{

        $Report = Report::findOrFail($id);
        if(!is_null($Report) &&  isset($request->status_confirm)){
               $certi_lab = CertiLab::findOrFail($Report->app_certi_lab_id);
            if(!is_null($Report)){
                $certi_lab->update(['status'=>22]); // ยืนยันจัดทำใบรับรอง
                $Report->update([
                                  'start_date' => date('Y-m-d'),
                                  'updated_by' => auth()->user()->getKey()
                             ]);
                             if($request->cf_cer==1){
                                $Report->update(['cf_cer'=>1]);
                            }
                  $ao = new Report;
                 $CertificateHistory = CertificateHistory::where('table_name',$ao->getTable())
                                                    ->where('ref_id',$Report->id)
                                                    ->where('system',5)
                                                    ->orderby('id','desc')
                                                    ->first();
             if(!is_null($CertificateHistory)){
                $CertificateHistory->update([
                                            'updated_by' =>  auth()->user()->getKey() ,
                                            'date' => date('Y-m-d')
                                           ]);
              }


                //เจ้าหน้าที่มอบหมาย
                if(count($certi_lab->CertiEmailLt) > 0 ){
                    // ส่ง E-mail
                    $config = HP::getConfig();
                    $url  =   !empty($config->url_center) ? $config->url_center : url('');

                    $dataMail = ['1804'=> 'lab1@tisi.mail.go.th','1805'=> 'lab2@tisi.mail.go.th','1806'=> 'lab3@tisi.mail.go.th'];
                    $EMail =  array_key_exists($certi_lab->subgroup,$dataMail)  ? $dataMail[$certi_lab->subgroup] :'admin@admin.com';

                    $data_app =         [
                                            'email'     => $certi_lab->email,
                                            'certi_lab' => $certi_lab,
                                            'url'       => $url.'/certify/check_certificate/'.$certi_lab->id.'/show' ?? '-',
                                            'email_cc'  =>  (count($certi_lab->DataEmailAndLtLABCC) > 0 ) ? $certi_lab->DataEmailAndLtLABCC : 'lab1@tisi.mail.go.th'
                                        ];

                    $log_email =  HP::getInsertCertifyLogEmail($certi_lab->app_no,
                                                            $certi_lab->id,
                                                            (new CertiLab)->getTable(),
                                                            $Report->id,
                                                            (new Report)->getTable(),
                                                            1,
                                                            'ยืนยันสรุปรายงานเสนอคณะกรรมการ/คณะอนุกรรมการ',
                                                            view('mail.lab.report', $data_app),
                                                            $certi_lab->created_by,
                                                            $certi_lab->agent_id,
                                                            null,
                                                            $certi_lab->email,
                                                            implode(',',(array)$certi_lab->CertiEmailLt),
                                                            (count($certi_lab->DataEmailAndLtLABCC) > 0 ) ? implode(',',$certi_lab->DataEmailAndLtLABCC) : $EMail,
                                                            null,
                                                            null
                                                        );

                        $html = new CertifyReport($data_app);
                        $mail =  Mail::to($certi_lab->CertiEmailLt)->send($html);

                        if(is_null($mail) && !empty($log_email)){
                            HP::getUpdateCertifyLogEmail($log_email->id);
                        }

                    }
            }
          }
           return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
        // } catch (\Exception $e) {
        //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
        // }
    }


      //การประมาณค่าใช้จ่าย
      public function EditCost($token)
      {
       
        $previousUrl = app('url')->previous();
        $certi_lab = CertiLab::where('token',$token)->first();
        
        $find_certi_lab_cost =Cost::where('app_certi_lab_id',$certi_lab->id)->get();
        

        $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
        ->where('status', 2)
        ->first();


    
        $labCalScopeTransactions = $labCalScopeUsageStatus ? 
        $labCalScopeUsageStatus->transactions()->with([
        'calibrationBranch',
        'calibrationBranchInstrumentGroup',
        'calibrationBranchInstrument',
        'calibrationBranchParam1',
        'calibrationBranchParam2'
        ])->get() : [];

        if (is_null($labCalScopeTransactions)) {
        $labCalScopeTransactions = [];
        }


        $branchLabAdresses = BranchLabAdress::where('app_certi_lab_id', $certi_lab->id)->with([
                            'certiLab', 
                            'province', 
                            'amphur', 
                            'district'
                        ])->get();

        $labCalScopeTransactionGroups = LabCalScopeUsageStatus::where('app_certi_lab_id', $certi_lab->id)
        ->where('status', 1)
        ->select('group', 'created_at') // เลือกฟิลด์ที่ต้องการ
        ->get()
        ->unique('group') // ทำให้ค่า group ไม่ซ้ำกัน
        ->values(); // รีเซ็ต index ของ Collection

        $labTestRequest = LabTestRequest::with([
            'certiLab', 
            'labTestTransactions.labTestMeasurements'
        ])
        ->where('app_certi_lab_id', $certi_lab->id)
        ->get();

    $labCalRequest = LabCalRequest::with([
            'certiLab', 
            'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
        ])
        ->where('app_certi_lab_id', $certi_lab->id)
        ->get();
        // dd($find_certi_lab_cost);
        return view('certify/applicant/form_status.form_status11',[
                                                                    'certi_lab'=>$certi_lab,
                                                                    'find_certi_lab_cost'=>$find_certi_lab_cost,
                                                                    'previousUrl' => $previousUrl,
                                                                    'labCalScopeTransactions' => $labCalScopeTransactions,
                                                                    'branchLabAdresses' => $branchLabAdresses,
                                                                    'labCalScopeTransactionGroups' => $labCalScopeTransactionGroups,
                                                                    'labTestRequest' => $labTestRequest,
                                                                    'labCalRequest' => $labCalRequest,
                                                                 ]);
      }
      public function updateStatusCost(Request $request,$id)
      {
        


//   try{
        //   $certiLab = CertiLab::where('token',$request->token)->first();
          $certiLab = CertiLab::findOrFail($id);
          $certi_cost = Cost::where('app_certi_lab_id',$certiLab->id) ->orderby('id','desc')->first();
          $certi_cost->vehicle =  null;
          $certi_cost->status_scope = $request->status_scope ?? null;
          $certi_cost->check_status = $request->check_status ?? null;
          $certi_cost->date =    date('Y-m-d'); //วันที่บันทึก


            // dd($group_id);

          $attachs = null;
          $attachs_scope = null;

        if ($request->check_status == 1){
                $certi_cost->agree = 1;
        } else{

                $certi_cost->agree = 2;
                $certi_cost->remark =  $request->remark ?? null;
                if ($request->another_modal_attach_files &&  $request->hasFile('another_modal_attach_files')){  // หลักฐาน เห็นชอบกับค่าใช่จ่ายที่เสนอมา
                    foreach ($request->another_modal_attach_files as $key => $dataaa){
                        $certi_cost_find = new CostFile();
                        $certi_cost_find->app_certi_cost_id     = $certi_cost->id;
                        $certi_cost_find->file_desc             = !empty($request->file_desc[$key]) ?  $request->file_desc[$key]:'' ;
                        $certi_cost_find->file                  = $this->storeFile($dataaa,$certiLab->app_no);
                        $certi_cost_find->file_client_name      = HP::ConvertCertifyFileName($dataaa->getClientOriginalName()) ;
                        $certi_cost_find->save();

                        $cost_find = new stdClass();
                        $cost_find->file_desc             = $certi_cost_find->file_desc;
                        $cost_find->file                  =  $certi_cost_find->file ;
                        $cost_find->file_client_name      =   $certi_cost_find->file_client_name  ;
                        $attachs[]                        = $cost_find;
                    }
                }
        }

        if ($request->status_scope == 1){
                $certi_cost->agree = 1;
        } else{
                $certi_cost->agree = 2;
                $certi_cost->remark_scope = $request->remark_scope ?? null;
                if ($request->attach_files &&  $request->hasFile('attach_files')){  //หลักฐาน Scope
                    foreach ($request->attach_files as $key => $item){
                        $find = new stdClass();
                        $find->file_desc_text        = !empty($request->file_desc_text[$key]) ?  $request->file_desc_text[$key]:'' ;
                        $find->attach_files          = $this->storeFile($item,$certiLab->app_no);
                        $find->file_client_name      = HP::ConvertCertifyFileName($item->getClientOriginalName()) ;
                        $attachs_scope[]             = $find;
                    }
                }
        }


        if($request->status_scope == 1 && $request->check_status == 1){

                $certiLab->status = 12; //อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน
                // $certiLab->status           = 9; // อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน
                $certi_cost->remark         =   null;  //
                $certi_cost->remark_scope   =  null;  //
                $certi_cost->amount         = $certi_cost->SumAmountTotal ?? null;  //จำนวนเงินที่อนุมัติ

        }else{
                //  $certiLab->status = 7; // ประมาณการค่าใช้จ่าย
                $certiLab->status = 10;//ประมาณการค่าใช้จ่าย


        }
            $certi_cost->save();
            $certiLab->save(); // ตารางหลัก


        $config = HP::getConfig();
        $url  =   !empty($config->url_center) ? $config->url_center : url('');
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


         $this->CertificateHistory($certi_cost,$attachs,$attachs_scope);


     if(!is_null($certiLab->email) && count($certiLab->DataEmailDirectorLAB) > 0){  //  ส่ง E-mail


            $dataMail = ['1804'=> 'lab1@tisi.mail.go.th','1805'=> 'lab2@tisi.mail.go.th','1806'=> 'lab3@tisi.mail.go.th'];
            $EMail =  array_key_exists($certiLab->subgroup,$dataMail)  ? $dataMail[$certiLab->subgroup] :'admin@admin.com';
            $data_app =         ['email'             => $certiLab->email,
                                  'certiLab'         => $certiLab,
                                  'certi_cost'       =>  $certi_cost,
                                  'check_status'     => array_key_exists($certi_cost->check_status,$check_status)   ? $check_status[$certi_cost->check_status]   :  '-',
                                  'status_scope'     => array_key_exists($certi_cost->status_scope,$status_scope)   ? $status_scope[$certi_cost->status_scope]   :  '-',
                                  'attachs'          => !is_null($attachs) ? $attachs : '-',
                                  'attachs_scope'    => !is_null($attachs_scope) ? $attachs_scope : '-',
                                  'url'              =>  $url.'/certify/estimated_cost/'. $certi_cost->id .'/edit' ,
                                  'email_cc'         =>  (count($certiLab->DataEmailDirectorLABCC) > 0 ) ? $certiLab->DataEmailDirectorLABCC : $EMail
                                ];

            $log_email =  HP::getInsertCertifyLogEmail($certiLab->app_no,
                                                    $certiLab->id,
                                                    (new CertiLab)->getTable(),
                                                    $certi_cost->id,
                                                    (new Cost)->getTable(),
                                                    1,
                                                    'การประมาณการค่าใช้จ่าย',
                                                    view('mail.lab.certify_cost', $data_app),
                                                    $certiLab->created_by,
                                                    $certiLab->agent_id,
                                                    null,
                                                    $certiLab->email,
                                                    implode(',',(array)$certiLab->DataEmailDirectorLAB),
                                                    (count($certiLab->DataEmailDirectorLABCC) > 0 ) ? implode(',',$certiLab->DataEmailDirectorLABCC) : $EMail,
                                                    null,
                                                    null
                                                 );

               $html = new CertifyCost($data_app);
               $mail =  Mail::to($certiLab->DataEmailDirectorLAB)->send($html);

                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }

      }




        if($request->previousUrl){
            return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
        }else{
            return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
        }

    // } catch (\Exception $e) {
    //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    // }
  }

       //   คณะผู้ตรวจประเมิน
      public function EditAuditor($token)
      {
        $model = str_slug('applicant','-');
   
         if(!is_null(auth()->user()) &&   HP::CheckPermission('edit-'.$model)){ 
            $previousUrl = app('url')->previous();
            $certi_lab = CertiLab::where('token',$token)->first();
            $auditor = BoardAuditor::where('certi_no',$certi_lab->app_no)->get();

            return view('certify.applicant.form_status.form_status13',[
                                                                    'certi_lab'=>$certi_lab,
                                                                    'auditor'=>$auditor,
                                                                    'previousUrl' => $previousUrl
                                                                 ]);
        }else{
              return  redirect(HP::DomainTisiSso());
         }

      }
      public function updateStatusAuditor(Request $request ,$token)
      {

         $data_session     =    HP::CheckSession();
  $model = str_slug('applicant','-');

 if(!empty(auth()->user()) &&  HP::CheckPermission('edit-'.$model)){ 
//    try{     
        $certiLab = CertiLab::where('token',$token)->first();

        if(!is_null($certiLab)){
            $authorities = [];
            $data = [];

            // dd($request->auditors_id, $certiLab);

            foreach ($request->auditors_id as $key => $item){
                         $auditors = BoardAuditor::where('id',$item)->orderby('id','desc')->first();
                      
                 if(!is_null($auditors)){
                    //    dd($auditors,$request->status[$item]);
                        $auditors->status = $request->status[$item] ?? 2;
                    if($request->status == 2){
                        $auditors->remark =  $request->remark[$item] ?? null;
                        $auditors->vehicle =  2;
                        $auditors->step_id =  1; //อยู่ระหว่างแต่งตั้งคณะผู้ตรวจประเมิน
                    }else{
                        $auditors->remark = null;
                        $auditors->step_id =  3; //เห็นชอบการแต่งตั้งคณะผู้ตรวจประเมิน
                    }
                        $auditors->save();


                    // ไฟล์แนบ
                    $attachs = [];
                    if (isset($request->another_modal_attach_files[$item])){
                    foreach ($request->another_modal_attach_files[$item] as $key => $attach){
                            $find = new stdClass();
                            $find->file_desc             = $request->file_desc[$key] ?? null;
                            $find->file                  = $this->storeFile($attach,$certiLab->app_no);
                            $find->file_client_name      = HP::ConvertCertifyFileName($attach->getClientOriginalName());
                            $attachs[]                   =  $find;
                        }
                    }


                    $ao = new BoardAuditor;
                    $history = CertificateHistory::where('table_name',$ao->getTable())
                                                            ->where('ref_id',$item)
                                                            ->where('system',2)
                                                            ->orderby('id','desc')
                                                            ->first();

                    if(!is_null($history)){
                         $history->status        =  $auditors->status;
                         $history->attachs_file  = (count($attachs) > 0) ?  json_encode($attachs) : null;
                         $history->updated_by    =   auth()->user()->getKey();
                         $history->date          =  date('Y-m-d') ;
                         $history->save();
                    }



                    // pay in ครั้งที่ 1
                   if($auditors->status == 1){
                            // $assessment = Assessment::where('app_certi_lab_id',$certiLab->id)->where('auditor_id',$auditors->id)->first();
                            $assessment = Assessment::where('app_certi_lab_id',$certiLab->id)->where('auditor_id',$item)->first();
                            if(!is_null($assessment)){
                                    $cost_ass = CostAssessment::where('app_certi_lab_id',$certiLab->id)->where('app_certi_assessment_id',$assessment->id)->first();
                                if(is_null($cost_ass)){
                                    $cost_ass = new CostAssessment;
                                }
                                    $cost_ass->app_certi_assessment_id  = $assessment->id  ?? null;
                                    $cost_ass->app_certi_lab_id         = $certiLab->id;
                                    $cost_ass->save();
                            }
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

                    $dataMail = ['1804'=> 'lab1@tisi.mail.go.th','1805'=> 'lab2@tisi.mail.go.th','1806'=> 'lab3@tisi.mail.go.th'];
                    $EMail =  array_key_exists($certiLab->subgroup,$dataMail)  ? $dataMail[$certiLab->subgroup] :'admin@admin.com';

                    // ส่ง E-mail
                        $config = HP::getConfig();
                        $url  =   !empty($config->url_center) ? $config->url_center : url('');
                    if(!is_null($certiLab->email) && count($authorities) > 0){  //  ส่ง E-mail  เจ้าหน้าที่รับผิดชอบ

                       $data_app = ['email'         => $certiLab->email,
                                    'certi_Lab'     => $certiLab,
                                    'authorities'   => count($authorities) > 0 ?  $authorities : '-',
                                    'url'           => $url.'/certify/check_certificate/'.$certiLab->check->id .'/show' ,
                                    'email_cc'      => (count($certiLab->DataEmailDirectorLABCC) > 0 ) ? $certiLab->DataEmailDirectorLABCC : $EMail
                                    ];

                        $log_email =  HP::getInsertCertifyLogEmail( $certiLab->app_no,
                                                                    $certiLab->id,
                                                                    (new CertiLab)->getTable(),
                                                                    $auditors->id,
                                                                    (new BoardAuditor)->getTable(),
                                                                    1,
                                                                    'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                                    view('mail.lab.auditors', $data_app),
                                                                    $certiLab->created_by,
                                                                    $certiLab->agent_id,
                                                                    null,
                                                                    $certiLab->email,
                                                                    implode(',',(array)$certiLab->DataEmailDirectorLAB),
                                                                    (count($certiLab->DataEmailDirectorLABCC) > 0 ) ?   implode(',',(array)$certiLab->DataEmailDirectorLABCC) : 'lab1@tisi.mail.go.th',
                                                                    null,
                                                                    null
                                                                 );

                            $html = new CertifyBoardAuditor($data_app);
                            $mail =    Mail::to($certiLab->DataEmailDirectorLAB)->send($html);

                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }


                    }

                    if(!is_null($certiLab->email)  && count($certiLab->CertiEmailLt) > 0){  //  ส่ง E-mail เจ้าหน้าที ลท. CB

                      $data_app = ['email'          => $certiLab->email,
                                    'certi_Lab'     => $certiLab,
                                    'authorities'   => count($authorities) > 0 ?  $authorities : '-',
                                    'url'           => $url.'/certify/check_certificate/'.$certiLab->check->id .'/show' ,
                                    'email_cc'      => (count($certiLab->DataEmailDirectorLABCC) > 0 ) ? $certiLab->DataEmailDirectorLABCC : $EMail
                                  ];

                        $log_email =  HP::getInsertCertifyLogEmail( $certiLab->app_no,
                                                                    $certiLab->id,
                                                                    (new CertiLab)->getTable(),
                                                                    $auditors->id,
                                                                    (new BoardAuditor)->getTable(),
                                                                    1,
                                                                    'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                                    view('mail.lab.con_firm_auditors', $data_app),
                                                                    $certiLab->created_by,
                                                                    $certiLab->agent_id,
                                                                    null,
                                                                    $certiLab->email,
                                                                    implode(',',(array)$certiLab->CertiEmailLt),
                                                                    (count($certiLab->DataEmailDirectorLABCC) > 0 ) ?   implode(',',(array)$certiLab->DataEmailDirectorLABCC) : 'lab1@tisi.mail.go.th',
                                                                    null,
                                                                    null
                                                                 );

                            $html = new CertifyConFirmAuditorsMail($data_app);
                            $mail =    Mail::to($certiLab->CertiEmailLt)->send($html);

                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }
                    }



                if($request->previousUrl){
                    return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
                }else{
                    return redirect('certify/applicant-cb')->with('message', 'เรียบร้อยแล้ว!');
                }



         }else{
            return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');
         }

    // } catch (\Exception $e) {
    //     return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    // }
}else{
    return  redirect(HP::DomainTisiSso());
}
 }


      //บันทึกการแก้ไขข้อบกพร่อง / ข้อสังเกต
      public function EditAssessment($id,$token)
      {
        // dd('ok');
        $previousUrl = app('url')->previous();
        $certi_lab = CertiLab::where('token',$token)->first();
        $assessment = Notice::where('id',base64_decode($id))->first();

        return view('certify/applicant/form_status.form_status16',[
                                                                    'certi_lab'=>$certi_lab,
                                                                    'assessment'=>$assessment,
                                                                    'previousUrl' => $previousUrl
                                                                 ]);
      }

     public function UpdateAssessment(Request $request, $id)
     {
        // dd($request->all());

//   try {
            $data_session     =    HP::CheckSession();
            $tb               =    new Notice;

            $assessment       =    Notice::findOrFail($id);
            $assessment->degree = 2;
            $assessment->save();

            $certi_lab        =    $assessment->applicant;

            $requestData = $request->all();
            if(isset($requestData["detail"]) ){
                $detail = (array)$requestData["detail"];
                foreach ($detail['id'] as $key => $item) {
                        $notice_itme = NoticeItem::where('id',$item)->first();
                        $notice_itme->details =  $detail["details"][$key] ?? $notice_itme->details;
                        $notice_itme->user_cause =  $detail["user_cause"][$key] ?? $notice_itme->user_cause;
                        $assessment->check_file = 'false';
                        if($request->attachs  && $request->hasFile('attachs')){
                            $notice_itme->attachs             =  array_key_exists($key, $request->attachs) ?  $this->storeFile($request->attachs[$key],$certi_lab->app_no): @$notice_itme->attachs;
                            $notice_itme->attachs_client_name =  array_key_exists($key, $request->attachs) ?  HP::ConvertCertifyFileName($request->attachs[$key]->getClientOriginalName()) : @$notice_itme->attachs_client_name;
                            $assessment->check_file  = 'true';
                        }
                        $notice_itme->save();

                    }
            }

            $ao = new Notice;
           $CertificateHistory = CertificateHistory::where('table_name',$ao->getTable())
                                                   ->where('ref_id',$assessment->id)
                                                   ->where('system',4)
                                                   ->orderby('id','desc')
                                                   ->first();

          $NoticeItem = NoticeItem::select('remark','report','no','type','status','file_status','reporter','reporter_id','attachs','attachs','comment','comment_file','details','attachs_client_name','user_cause')
                                        ->where('app_certi_lab_notice_id',$assessment->id)
                                        ->get()
                                        ->toArray();
            if(!is_null($CertificateHistory)){
               $CertificateHistory->update([
                                         'details_table'=>  (count($NoticeItem) > 0) ? json_encode($NoticeItem) : null,
                                         'updated_by' =>  auth()->user()->getKey() ,
                                         'date' => date('Y-m-d')
                                       ]);
             }


             if(!is_null($certi_lab) && count($certi_lab->DataEmailDirectorLAB) > 0 ){
                        // ส่ง E-mail
                        $config = HP::getConfig();
                        $url  =   !empty($config->url_center) ? $config->url_center : url('');
                        $data_app = [
                                        'email'     => $certi_lab->email,
                                        'assessment'=>$assessment,
                                        'certi_lab' =>$certi_lab,
                                        'url'       =>$url.'certify/check_certificate/'.$certi_lab->id.'/show',
                                        'email_cc'  =>  (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ? $certi_lab->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                                   ];

                        $log_email =  HP::getInsertCertifyLogEmail( $certi_lab->app_no,
                                                                    $certi_lab->id,
                                                                    (new CertiLab)->getTable(),
                                                                    $assessment->id,
                                                                    (new Notice)->getTable(),
                                                                    1,
                                                                    'แจ้งแนวทางแก้ไข/ส่งหลักฐานการแก้ไขข้อบกพร่อง',
                                                                    view('mail.lab.assessment', $data_app),
                                                                    $certi_lab->created_by,
                                                                    $certi_lab->agent_id,
                                                                    null,
                                                                    $certi_lab->email,
                                                                    implode(',',(array)$certi_lab->DataEmailDirectorLAB),
                                                                    (count($certi_lab->DataEmailDirectorLABCC) > 0 ) ?   implode(',',(array)$certi_lab->DataEmailDirectorLABCC) : 'lab1@tisi.mail.go.th',
                                                                    null,
                                                                    null
                                                                 );

                            $html = new CertifySaveAssessment($data_app);
                            $mail =    Mail::to($certi_lab->DataEmailDirectorLAB)->send($html);

                            if(is_null($mail) && !empty($log_email)){
                                HP::getUpdateCertifyLogEmail($log_email->id);
                            }


              }


       return redirect('certify/applicant')->with('message', 'เรียบร้อยแล้ว!');

    // } catch (\Exception $e) {
    //    return redirect('certify/applicant')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
    // }
  }


      private function save_certi_tools_calibrate($main, $requestData){
        CertiToolsCalibrate::where('app_certi_lab_id', $main->id)->delete();
        foreach($requestData as $key => $itme) {
            if($itme != null || $itme != ''){
                $input = [];
                $input['app_certi_lab_id'] = $main->id;
                $input['name'] = $itme;
                $input['token'] = $main->token;
                CertiToolsCalibrate::create($input);
            }

        }
      }

      private function save_Certi_Tools_Test($main, $requestData){
        CertiToolsTest::where('app_certi_lab_id', $main->id)->delete();
        foreach($requestData as $key => $itme) {
          if($itme != null || $itme != ''){
            $input = [];
            $input['app_certi_lab_id'] = $main->id;
            $input['name'] = $itme;
            $input['token'] = $main->token;
            CertiToolsTest::create($input);
          }
        }
      }
      public function CertificateHistory($data,$file1 = null,$file2 = null)
      {





        $data_session     =    HP::CheckSession();
          $ao = new Cost;
          $Cost = Cost::select('app_certi_assessment_id', 'app_certi_lab_id', 'checker_id', 'draft', 'remark', 'agree', 'status_scope','check_status','remark_scope','amount','date','created_at')
                            ->where('id',$data->id)
                            ->first();
            if($file1 != null){
                $attachs_file  =  $file1;
            }
            if($file2 != null){
                $evidence  =  $file2;
            }


            // dd();
        $labCalScopeUsageStatus = LabCalScopeUsageStatus::where('app_certi_lab_id', $Cost->app_certi_lab_id)
            ->where('status', 2)
            ->first();
            
            if ($labCalScopeUsageStatus) {
                  $group_id = $labCalScopeUsageStatus->group;
              } else {
                  // จัดการกรณีที่ไม่มี $labCalScopeUsageStatus เช่นการแจ้งเตือนหรือค่าเริ่มต้น
                  $group_id = null; // หรือการกระทำอื่นที่คุณต้องการ
              }
        // dd($labCalScopeUsageStatus)      ;
        $CertificateHistory = CertificateHistory::where('table_name',$ao->getTable())
                                                ->where('ref_id',$data->id)
                                                ->where('system',1)
                                                ->orderby('id','desc')
                                                ->first();

          
         if(!is_null($CertificateHistory)){

            $CertificateHistory->update([
                                      'details'=>   !is_null($Cost) ? json_encode($Cost) : null,
                                      'check_status'=> $data->check_status ?? null ,
                                      'status_scope'=> $data->status_scope ?? null ,
                                      'attachs_file'=>  isset($attachs_file) ?  json_encode($attachs_file) : null,
                                      'evidence'=>  isset($evidence) ?  json_encode($evidence) : null,
                                      'updated_by' => auth()->user()->getKey() ,
                                      'date' => date('Y-m-d'),
                                      'scope_group' => $group_id
                                    ]);


          }

      }

      //log
      public function DataLogLab($token)
      {
        $previousUrl = app('url')->previous();
        $certi_lab = CertiLab::where('token',$token)->first();

        // ประวัติคำขอ
         $history  =  CertificateHistory::where('app_no',$certi_lab->app_no)
                                        ->orwhere('app_no',"RQ-".$certi_lab->app_no)
                                        ->orderby('id','desc')
                                        ->get();

        return view('certify/applicant.log',['certi_lab'=>$certi_lab,
                                                     'history' => $history,
                                                      'previousUrl' => $previousUrl
                                                     ]);
      }
      public function DataShow($token = null,$id = null)
      {
          $previousUrl = app('url')->previous();
          $history  =  CertificateHistory::findOrFail($id);

          return view('certify/applicant/history.history_detail',  compact('previousUrl',
                                                                    'history'
                                                                  ));
      }

    public function get_certificate(Request $request)
    {
        $id = $request->get('id');


        $certificate_no = DB::table('certificate_exports AS exports')
                                ->leftJoin('app_certi_labs AS lab', 'lab.id', '=', 'exports.certificate_for')
                                ->select('exports.*', 'lab.app_no')
                                ->where('exports.id',$id)
                                ->first();

        return response()->json($certificate_no);

    }

    public function draft_pdf($certilab_id = null)
    {

        if(!is_null($certilab_id)){

                $CertiLab = CertiLab::findOrFail($certilab_id);


                if($certilab_id == 21){
                    $certilab_id = 7;
                }

                // return $certilab_id;
                 $formula = Formula::where('id', $CertiLab->type_standard)
                                        ->whereState(1)->first();

                // if(!is_null($file) && !is_null($file->attach_pdf) ){

                     $url  =   url('/certify/check_files_lab/'. rtrim(strtr(base64_encode($certilab_id), '+/', '-_'), '=') );
                    //ข้อมูลภาพ QR Code
                     $image_qr = QrCode::format('png')->merge('plugins/images/tisi.png', 0.2, true)
                                  ->size(500)->errorCorrection('H')
                                  ->generate($url);

                // }

            // $last   = CertificateExport::where('certificate_for',$CertiLab->id)->whereYear('created_at',Carbon::now())->count() + 1;

            // $lab_type = ['1'=>'Testing','2'=>'Cal','3'=>'IB','4'=>'CB'];
            // $accreditation_no = '';
            // if(array_key_exists("1",$lab_type)){
            //     $accreditation_no .=  $lab_type[1].'-';
            // }
            // if(!is_null($CertiLab->app_no)){
            //     $app_no = explode('-', $CertiLab->app_no);
            //     $accreditation_no .= $app_no[2].'-';
            // }
            // if(!is_null($last)){
            //     $accreditation_no .=  str_pad($last, 3, '0', STR_PAD_LEFT).'-'.(date('Y') +543);
            // }

            //     $CertiLab->accreditation_no  =   $accreditation_no ? $accreditation_no : '&emsp;' ;

                $data_export = [
                    'app_no'             => $CertiLab->app_no,
                    'name'               => !empty($CertiLab->lab_name) ? $CertiLab->lab_name : '&emsp;' ,
                    'name_en'            =>  isset($CertiLab->lab_name_en) ?  '('.$CertiLab->lab_name_en.')' : '&emsp;',
                    'lab_name_font_size' => $this->CalFontSize($this->FormatAddress($CertiLab)),
                    'address'            => $this->FormatAddress($CertiLab),
                    'lab_name_font_size_address' => $this->CalFontSize($this->FormatAddress($CertiLab)),
                    'address_en'         => !empty($CertiLab->lab_address_no_eng) ? '('.$this->FormatAddressEn($CertiLab).')'  : '&emsp;',
                    // 'accreditation_no'   => $CertiLab->accreditation_no,
                    // 'accreditation_no_en'   => $CertiLab->accreditation_no_en,
                    'formula_title'      => !empty($CertiLab->get_standard->title) ? $CertiLab->get_standard->title : null,
                    'formula_title_en'      => !empty($CertiLab->get_standard->title_en) ? $CertiLab->get_standard->title_en : '&emsp;' ,
                    'image_qr'           => isset($image_qr) ? $image_qr : null,
                    'url'                => isset($url) ? $url : null,

                   ];

                    $config = ['instanceConfigurator' => function ($mpdf) {
                        $mpdf->SetWatermarkText('DRAFT');
                        $mpdf->watermark_font = 'DejaVuSansCondensed';
                        $mpdf->showWatermarkText = true;
                        $mpdf->watermarkTextAlpha = 0.12;
                    }];

              $pdf = Pdf::loadView('certify/applicant/pdf/draft-thai', $data_export, [], $config);
              return $pdf->stream("certificate-thai.pdf");

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

        //ที่อยู่ ที่อยู่ห้องปฏิบัติการ
private function FormatAddress($request){

    $address   = '';
    $address .= $request->address_no;

    if($request->allay!=''){
      $address .=  " หมู่ที่ " . $request->allay;
    }

    if($request->village_no!='' && $request->village_no !='-'  && $request->village_no !='--'){
      $address .=  " ซอย "  . $request->village_no;
    }

    if($request->road!='' && $request->road !='-'  && $request->road !='--'){
      $address .=  " ถนน ".$request->road;
    }

    if($request->district!=''){
        if(trim($request->province_to->PROVINCE_NAME)=='กรุงเทพมหานคร'){
            $address .= " แขวง".$request->district;
        }else{
            $address .= " ตำบล".$request->district;

        }
    }

    if($request->amphur!=''){
        if(trim($request->province_to->PROVINCE_NAME)=='กรุงเทพมหานคร'){
            $address .= " เขต".$request->amphur;
        }else{
            $address .= " อำเภอ".$request->amphur;
        }
    }

    if($request->province!=''){
        if(trim($request->province_to->PROVINCE_NAME)=='กรุงเทพมหานคร'){
            $address .=  " ".trim($request->province_to->PROVINCE_NAME);
        }else{
            $address .=  " จังหวัด".trim($request->province_to->PROVINCE_NAME);
        }
    }

    return $address;

}




 //ที่อยู่ ที่อยู่ห้องปฏิบัติการ EN
private function FormatAddressEn($request){
    $address   = [];
    $address[] = $request->lab_address_no_eng;

    if($request->lab_moo_eng!=''){
      $address[] =    'Moo '.$request->lab_moo_eng;
    }

    if($request->lab_soi_eng!='' && $request->lab_soi_eng !='-'  && $request->lab_soi_eng !='--'){
      $address[] =   $request->lab_soi_eng;
    }
    if($request->lab_street_eng!='' && $request->lab_street_eng !='-'  && $request->lab_street_eng !='--'){
        $address[] =   $request->lab_street_eng.',';
    }
    if($request->lab_district_eng!='' && $request->lab_district_eng !='-'  && $request->lab_district_eng !='--'){
        $address[] =   $request->lab_district_eng.',';
    }
    if($request->lab_amphur_eng!='' && $request->lab_amphur_eng !='-'  && $request->lab_amphur_eng !='--'){
        $address[] =   $request->lab_amphur_eng.',';
    }
    if(!empty($request->province_eng_to->PROVINCE_NAME_EN)){
        $address[] =   $request->province_eng_to->PROVINCE_NAME_EN;
    }
    if($request->lab_postcode_eng!='' && $request->lab_postcode_eng !='-'  && $request->lab_postcode_eng !='--'){
        $address[] =   $request->lab_postcode_eng;
    }
    return implode(' ', $address);
}


    public function get_appno(Request $request)
    {
            /*
            select * from app_certi_labs
            WHERE tax_id = '0185558000227' AND lab_type = 3 AND standard_id = 1 AND status NOT IN (4)

            โดยที่
            tax_id //ตามผู้ที่ดำเนินการ
            lab_type //ดึงจากตามที่เลือก
            standard_id //ตามที่เลือก
            */

        $tax_id = $request->get('tax_id');
        $lab_type = $request->get('lab_type');
        $standard_id = $request->get('standard_id');

        $where_condition = ['tax_id'=>$tax_id,'lab_type'=>$lab_type,'standard_id'=>$standard_id];
        $result = CertiLab::where($where_condition)->whereNotIn('status', [4])->select('app_no')->first();

        return response()->json($result);

    }

    public function getTestScopeData($id)
    {
 
     $latestCertiLab = CertiLab::find($id);
 
     $company = [];
 
     if ($latestCertiLab) {
         // ดึง LabCalRequest ที่มี app_certi_lab_id ตรงกับ $latestCertiLab->id (ทุกรายการ)
         $labTestRequests = LabTestRequest::with([
             'labTestTransactions.labTestMeasurements'
         ])->where('app_certi_lab_id', $latestCertiLab->id)->get();
 
         // สร้างข้อมูลในรูปแบบของ $company
         foreach ($labTestRequests as $key => $labTestRequest) {

           
             $data = [];
             foreach ($labTestRequest->labTestTransactions as $transaction) {
                
                 $transactionData = [
                     'index' => $transaction->index,
                     'category' =>  $transaction->category,
                     'category_th' => $transaction->category_th,
                     'description' => $transaction->description,
                     'standard' => $transaction->standard,
                     'test_field' => $transaction->test_field,
                     'test_field_eng' => $transaction->test_field_eng,
                     'code' => $transaction->code,
                     'key' => $transaction->key,
                     'measurements' => [],
                 ];
 
                 foreach ($transaction->labTestMeasurements as $measurement) {

                     $measurementData = [
                         'name' => $measurement->name,
                         'name_eng' => $measurement->name_eng,
                         'description' => $measurement->description,
                         'detail' => $measurement->detail,
                         'type' => $measurement->type,
                         'ranges' => [],
                     ];
 

 
                     $transactionData['measurements'][] = $measurementData;
                 }
 
                 $data[] = $transactionData;
             }
 
             // dd($labCalRequest->no);
             // สร้างชุดข้อมูลที่แบ่งตาม id, station_type, lab_type
               $company[] = [
                 "id" => $key + 1,  // ให้เพิ่ม 1 เพื่อเริ่มจาก 1
                 "station_type" => $key === '0' ? "main" : "branch" . ($key),  // กำหนดประเภท station
                 "lab_type" => $labTestRequest->certiLab->lab_type,  // lab_type จาก certiLab
                 "app_certi_lab" => $labTestRequest->certiLab,  // lab_type จาก certiLab
                 // เพิ่มคีย์ใหม่จากฟิลด์ใน lab_cal_requests
                 "no" => trim($labTestRequest->no ?? '') ?: null,
                 "moo" => trim($labTestRequest->moo ?? '') ?: null,
                 "soi" => trim($labTestRequest->soi ?? '') ?: null,
                 "street" => trim($labTestRequest->street ?? '') ?: null,
                 "province_name" => trim($labTestRequest->province_name ?? '') ?: null,
                 "amphur_name" => trim($labTestRequest->amphur_name ?? '') ?: null,
                 "tambol_name" => trim($labTestRequest->tambol_name ?? '') ?: null,
                 "postal_code" => trim($labTestRequest->postal_code ?? '') ?: null,
                 "no_eng" => trim($labTestRequest->no_eng ?? '') ?: null,
                 "moo_eng" => trim($labTestRequest->moo_eng ?? '') ?: null,
                 "soi_eng" => trim($labTestRequest->soi_eng ?? '') ?: null,
                 "street_eng" => trim($labTestRequest->street_eng ?? '') ?: null,
                 "tambol_name_eng" => trim($labTestRequest->tambol_name_eng ?? '') ?: null,
                 "amphur_name_eng" => trim($labTestRequest->amphur_name_eng ?? '') ?: null,
                 "province_name_eng" => trim($labTestRequest->province_name_eng ?? '') ?: null,
 
                 "scope" => $data
 
             ];
         }
     }
 
     // ส่งข้อมูลกลับในรูปแบบ JSON
     return response()->json($company);
    }


   public function getCalScopeData($id)
   {

    $latestCertiLab = CertiLab::find($id);

    $company = [];

    if ($latestCertiLab) {
        // ดึง LabCalRequest ที่มี app_certi_lab_id ตรงกับ $latestCertiLab->id (ทุกรายการ)
        $labCalRequests = LabCalRequest::with([
            'labCalTransactions.labCalMeasurements.labCalMeasurementRanges'
        ])->where('app_certi_lab_id', $latestCertiLab->id)->get();

        // สร้างข้อมูลในรูปแบบของ $company
        foreach ($labCalRequests as $key => $labCalRequest) {
            $data = [];
            foreach ($labCalRequest->labCalTransactions as $transaction) {


              $calibration_branch_name_en = null;

              if($transaction->category !== null){
                $calibrationBranch = CalibrationBranch::find($transaction->category);
                if($calibrationBranch!==null)
                {
                  $calibration_branch_name_en  = $calibrationBranch->title_en;
                }
              }

                $instrument_name = null;

                if($transaction->instrument !== null){
                  $calibrationBranchInstrumentGroup = CalibrationBranchInstrumentGroup::find($transaction->instrument);
                  if($calibrationBranchInstrumentGroup!==null)
                  {
                    $instrument_name  = $calibrationBranchInstrumentGroup->name;
                  }
                }

                $instrument_two_name = null;

                if($transaction->instrument_two !== null){
                  $calibrationBranchInstrument = CalibrationBranchInstrument::find($transaction->instrument_two);
                  if($calibrationBranchInstrument!==null)
                  {
                    $instrument_two_name  = $calibrationBranchInstrument->name;
                  }
                }

                $transactionData = [
                    'index' => $transaction->index,
                    'category' => $calibration_branch_name_en,
                    'category_th' => $transaction->category_th,
                    'instrument' => $instrument_name,
                    'instrument_two' => $instrument_two_name,
                    'description' => $transaction->description,
                    'standard' => $transaction->standard,
                    'code' => $transaction->code,
                    'key' => $transaction->key,
                    'measurements' => [],
                ];

                foreach ($transaction->labCalMeasurements as $measurement) {
                    $measurementData = [
                        'name' => $measurement->name,
                        'type' => $measurement->type,
                        'ranges' => [],
                    ];

                    foreach ($measurement->labCalMeasurementRanges as $range) {
                        $rangeData = [
                            'description' => $range->description,
                            'range' => $range->range,
                            'uncertainty' => $range->uncertainty,
                        ];

                        $measurementData['ranges'][] = $rangeData;
                    }

                    $transactionData['measurements'][] = $measurementData;
                }

                $data[] = $transactionData;
            }

            // dd($labCalRequest->no);
            // สร้างชุดข้อมูลที่แบ่งตาม id, station_type, lab_type
              $company[] = [
                "id" => $key + 1,  // ให้เพิ่ม 1 เพื่อเริ่มจาก 1
                "station_type" => $key === '0' ? "main" : "branch" . ($key),  // กำหนดประเภท station
                "lab_type" => $labCalRequest->certiLab->lab_type,  // lab_type จาก certiLab
                "app_certi_lab" => $labCalRequest->certiLab,  // lab_type จาก certiLab
                // เพิ่มคีย์ใหม่จากฟิลด์ใน lab_cal_requests
                "no" => trim($labCalRequest->no ?? '') ?: null,
                "moo" => trim($labCalRequest->moo ?? '') ?: null,
                "soi" => trim($labCalRequest->soi ?? '') ?: null,
                "street" => trim($labCalRequest->street ?? '') ?: null,
                "province_name" => trim($labCalRequest->province_name ?? '') ?: null,
                "amphur_name" => trim($labCalRequest->amphur_name ?? '') ?: null,
                "tambol_name" => trim($labCalRequest->tambol_name ?? '') ?: null,
                "postal_code" => trim($labCalRequest->postal_code ?? '') ?: null,
                "no_eng" => trim($labCalRequest->no_eng ?? '') ?: null,
                "moo_eng" => trim($labCalRequest->moo_eng ?? '') ?: null,
                "soi_eng" => trim($labCalRequest->soi_eng ?? '') ?: null,
                "street_eng" => trim($labCalRequest->street_eng ?? '') ?: null,
                "tambol_name_eng" => trim($labCalRequest->tambol_name_eng ?? '') ?: null,
                "amphur_name_eng" => trim($labCalRequest->amphur_name_eng ?? '') ?: null,
                "province_name_eng" => trim($labCalRequest->province_name_eng ?? '') ?: null,

                "scope" => $data

            ];
        }
    }

    // ส่งข้อมูลกลับในรูปแบบ JSON
    return response()->json($company);
   }

    public function getCalPageList($scopes,$pdfData,$details)
    {

        $pageArray = $this->getFirstCalPageList($scopes,$pdfData,$details);

        $firstPageArray = $pageArray[0];

        // ดึงค่า index ด้วย array_map และ array access
        $indexes = array_map(function ($item) {
            return $item->index;
        }, $firstPageArray[0]);

        $filteredScopes = array_filter($scopes, function ($item) use ($indexes) {
            return !in_array($item->index, $indexes);
        });
        
        $filteredScopes = array_values($filteredScopes);

        $pageArray = $this->getOtherCalPageList($filteredScopes,$pdfData,$details);

        $mergedArray = array_merge($firstPageArray, $pageArray);
        return $mergedArray;
    }
    
    public function getFirstCalPageList($scopes,$pdfData,$details)
    {
        $type = 'I';
        $fontDirs = [public_path('pdf_fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => 8, // ระบุขอบด้านซ้าย
            'margin_right'     => 3, // ระบุขอบด้านขวา
            // 'margin_top'       => 97, // ระบุขอบด้านบน
            // 'margin_bottom'    => 40, // ระบุขอบด้านล่าง
            'margin_top'       => 108, // ระบุขอบด้านบน
            'margin_bottom'    => 40, // ระบุขอบด้านล่าง
        ]);         

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        
        $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]); // กำหนด opacity, , ตำแหน่ง
        $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark

        $footer = view('certify.scope_pdf.calibration.cal-scope-footer', [
            'qrImage' => null,
            'sign1Image' => null,
            'sign2Image' => null,
            'sign3Image' => null
        ]);

        $viewBlade = "certify.scope_pdf.calibration.cal-scope-first-header";

        if ($pdfData->siteType == "multi")
        {
            $viewBlade = "certify.scope_pdf.calibration.cal-scope-first-header-multi";
        }
        // $scopes = $details->scope;
        $header = view($viewBlade, [
          'branchNo' => null,
          'company' => $details,
          'pdfData' => $pdfData
        ]);
        $mpdf->SetHTMLHeader($header,2);
        $mpdf->SetHTMLFooter($footer,2);
        
        $html = view('certify.scope_pdf.calibration.pdf-cal-scope', [
                'scopes' => collect($scopes)
            ]);
        $mpdf->WriteHTML($html);

        // แปลง PDF เป็น String
        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $chunks = $this->generateRangesWithCalData($scopes,$pdf);

        $firstPage = array_slice($chunks, 0, 1);

        $remainingItems = array_slice($chunks, 1);

        return [$firstPage,$remainingItems,$chunks];
    }

    public function getOtherCalPageList($scope,$pdfData,$details)
    {
        $type = 'I';
        $fontDirs = [public_path('pdf_fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => 8, // ระบุขอบด้านซ้าย
            'margin_right'     => 3, // ระบุขอบด้านขวา
            'margin_top'       => 97, // ระบุขอบด้านบน
            'margin_bottom'    => 40, // ระบุขอบด้านล่าง
        ]);         

        // $data = $this->getMeasurementsData()->getData();

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);

        // $company = $data->main;
        
        $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]); // กำหนด opacity, , ตำแหน่ง
        $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark

        $footer = view('certify.scope_pdf.calibration.cal-scope-footer', [
            'qrImage' => null,
            'sign1Image' => null,
            'sign2Image' => null,
            'sign3Image' => null
        ]);

        $header = view('certify.scope_pdf.calibration.cal-scope-first-header', [
          'company' => $details,
          'pdfData' => $pdfData
        ]);
        $mpdf->SetHTMLHeader($header,2);
        $mpdf->SetHTMLFooter($footer,2);
        
        $html = view('certify.scope_pdf.calibration.pdf-cal-scope', [
                'scopes' => collect($scope)
            ]);
        $mpdf->WriteHTML($html);

        // แปลง PDF เป็น String
        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $chunks = $this->generateRangesWithCalData($scope,$pdf);
        
        // $firstPage = reset($chunks);

        // $remainingItems = array_slice($chunks, 1);

        // dd($chunks,$firstPage,$remainingItems);

        return $chunks;
   
    }

    function generateRangesWithCalData($data, $pdf)
    {
        $maxNumber = []; // เก็บตัวเลขที่มากที่สุดของแต่ละหน้า

        // ดึงข้อความและค้นหาตัวเลขที่มากที่สุดในแต่ละหน้า
        foreach ($pdf->getPages() as $pageNumber => $page) {
            preg_match_all('/\*(\d+)\*/', $page->getText(), $matches); // ค้นหาตัวเลขในรูปแบบ *number*
            if (!empty($matches[1])) {
                $maxNumber[$pageNumber + 1] = max($matches[1]); // เก็บเลขที่มากที่สุดในหน้า
            }
        }
        // สร้างช่วงข้อมูลตาม maxNumber และดึงค่าจาก $data
        $start = 0;
        return array_map(function ($end) use (&$start, $data) {
            $range = range($start, (int)$end); // สร้างช่วง index
            $start = (int)$end + 1; // อัปเดตค่าเริ่มต้นสำหรับช่วงถัดไป
            return array_map(function ($index) use ($data) {
                return $data[$index] ?? null; // ดึงค่าจาก $data ตาม index
            }, $range);
        }, $maxNumber);
    }

  public function generatePdfLabCalScope($id)
  {
   
      $siteType = "single";
      $data = $this->getCalScopeData($id)->getData();
      
      if(count($data) > 1){
          $siteType = "multi";
      }
      $mpdfArray = []; 

    // วนลูปข้อมูล
      foreach ($data as $key => $details) {

        $scopes = $details->scope;

          // ใช้ array_map เพื่อดึงค่าของ 'key' จากแต่ละรายการใน $scopes
          $keys = array_map(function ($item) {
            return $item->key;
          }, $scopes);

          // ใช้ array_unique เพื่อลบค่าซ้ำใน $keys
          $uniqueKeys = array_unique($keys);

          $pdfData =  (object)[
            'certificate_no' => 'xx-LBxxx',
            'acc_no' => '',
            'book_no' => '',
            'from_date_th' => '',
            'from_date_en' => '',
            'to_date_th' => '',
            'to_date_en' => '',
            'uniqueKeys' => $uniqueKeys,
            'siteType' => $siteType
        ];

          // dd($uniqueKeys);

          $scopePages = $this->getCalPageList($scopes,$pdfData,$details);
          
          $type = 'I';
          $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
          $fontData = [
              'thsarabunnew' => [
                  'R' => "THSarabunNew.ttf",
                  'B' => "THSarabunNew-Bold.ttf",
                  'I' => "THSarabunNew-Italic.ttf",
                  'BI' => "THSarabunNew-BoldItalic.ttf",
              ],
          ];
  
          if ($siteType == "single") {
              $mpdf = new Mpdf([
                  'PDFA'             => $type == 'F' ? true : false,
                  'PDFAauto'         => $type == 'F' ? true : false,
                  'format'           => 'A4',
                  'mode'             => 'utf-8',
                  'default_font_size'=> '15',
                  'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                  'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                  'default_font'     => 'thsarabunnew',
                  'margin_left'      => 6,
                  'margin_right'     => 5,
                  'margin_top'       => 97,
                  'margin_bottom'    => 40,
              ]);
          } else { // multiple
              if($key == 0){
                  // $marginTop = 108;
                  $mpdf = new Mpdf([
                      'PDFA'             => $type == 'F' ? true : false,
                      'PDFAauto'         => $type == 'F' ? true : false,
                      'format'           => 'A4',
                      'mode'             => 'utf-8',
                      'default_font_size'=> '15',
                      'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                      'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                      'default_font'     => 'thsarabunnew',
                      'margin_left'      => 6,
                      'margin_right'     => 5,
                      'margin_top'       => 108,
                      'margin_bottom'    => 40,
                  ]);
              }else{
                  $mpdf = new Mpdf([
                      'PDFA'             => $type == 'F' ? true : false,
                      'PDFAauto'         => $type == 'F' ? true : false,
                      'format'           => 'A4',
                      'mode'             => 'utf-8',
                      'default_font_size'=> '15',
                      'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                      'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                      'default_font'     => 'thsarabunnew',
                      'margin_left'      => 6,
                      'margin_right'     => 5,
                      'margin_top'       => 85,
                      'margin_bottom'    => 40,
                  ]);
              }
            
          }
                
  
          $data = $this->getCalScopeData($id)->getData();
  
          $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
          $mpdf->WriteHTML($stylesheet, 1);
  
          // $mpdf->SetWatermarkImage(public_path(...), opacity, [size], [position]); 
  
        //   $mpdf->SetWatermarkImage(public_path('images/nc_logo.jpg'), 1, [23, 23], [170, 4]);
          $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 4]);
  
          $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark
  
          // เพิ่ม Text Watermark
          $mpdf->SetWatermarkText('Confidential', 0.1); // ระบุข้อความและ opacity
          $mpdf->showWatermarkText = true; // เปิดใช้งาน text watermark
              
          $signImage = public_path('images/sign.jpg');
          $sign1Image = public_path('images/sign1.png');
  
          // $footer = view('certify.scope_pdf.calibration.cal-scope-footer', [
          //     'sign1Image' => null,
          //     'sign2Image' => null,
          //     'sign3Image' => null
          // ]);
          // $mpdf->SetHTMLFooter($footer,2);
  
          $headerBlade = "certify.scope_pdf.calibration.cal-scope-first-header";
          $branchNo = null;

          if ($siteType == "multi")
          {
              $branchNo = $key + 1;
              if ($key == 0){
                  $headerBlade = "certify.scope_pdf.calibration.cal-scope-first-header-multi";
              }else{
                  $headerBlade = "certify.scope_pdf.calibration.cal-scope-first-header-multi-branch";
              }   
          }
          
          foreach ($scopePages as $index => $scopes) {
              if ($index == 0) {
                  $firstPageHeader = view($headerBlade, [
                      'branchNo' => $branchNo,
                      'company' => $details,
                      'pdfData' => $pdfData
                  ]);
                  $mpdf->SetHTMLHeader($firstPageHeader, 2);
                  $html = view('certify.scope_pdf.calibration.pdf-cal-scope', [
                      'scopes' => collect($scopes)
                  ]);
                  $mpdf->WriteHTML($html);
              } else if ($index > 0) {
  
                  $header = view('certify.scope_pdf.calibration.cal-scope-other-header', [
                      'branchNo' => null,
                      'company' => $details,
                      'pdfData' => $pdfData
                  ]);
                  $mpdf->SetHTMLHeader($header, 2);
                  $mpdf->AddPage('', '', '', '', '', 6, 5, 75, 30); 
                  $html = view('certify.scope_pdf.calibration.pdf-cal-scope', [
                      'scopes' => collect($scopes)
                  ]);
                  $mpdf->WriteHTML($html);
              }
          }

          $mpdfArray[$key] = $mpdf;
      }

      $combinedPdf = new \Mpdf\Mpdf([
          'PDFA'             => $type == 'F' ? true : false,
          'PDFAauto'         => $type == 'F' ? true : false,
          'format'           => 'A4',
          'mode'             => 'utf-8',
          'default_font_size'=> '15',
          'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
          'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
          'default_font'     => 'thsarabunnew',
      ]);

      $combinedPdf->SetImportUse();
      
      // สร้างไฟล์ PDF ชั่วคราวจาก `$mpdfArray`
      $tempFiles = []; // เก็บรายชื่อไฟล์ชั่วคราว
      foreach ($mpdfArray as $key => $mpdf) {
          $tempFileName = "{$key}.pdf"; // เช่น main.pdf, branch0.pdf
          $mpdf->Output($tempFileName, \Mpdf\Output\Destination::FILE); // บันทึก PDF ชั่วคราว
          $tempFiles[] = $tempFileName;
      }

      // รวม PDF
      foreach ($tempFiles as $fileName) {
          $pageCount = $combinedPdf->SetSourceFile($fileName); // เปิดไฟล์ PDF
          for ($i = 1; $i <= $pageCount; $i++) {
              $templateId = $combinedPdf->ImportPage($i);
              $combinedPdf->AddPage();
              $combinedPdf->UseTemplate($templateId);

              // ดึง HTML Footer จาก Blade Template
              $signImage = public_path('images/sign.jpg');
              $footer = view('certify.scope_pdf.calibration.cal-scope-footer', [
                  'sign1Image' => $signImage, // ส่งรูปภาพที่ต้องการใช้
                  'sign2Image' => $signImage,
                  'sign3Image' => $signImage
              ])->render();

              // ตั้งค่า Footer ใหม่สำหรับหน้า PDF
              $combinedPdf->SetHTMLFooter($footer);
          }
      }

      // ส่งออกไฟล์ PDF
      $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);

      // ลบไฟล์ชั่วคราว
      foreach ($tempFiles as $fileName) {
          unlink($fileName);
      }

  }


  public function generatePdfLabTestScope($id)
  {
      $siteType = "single";
      $data = $this->getTestScopeData($id)->getData();
      
      // dd(count($data));
      if(count($data) > 1){
          $siteType = "multi";
      }
      $mpdfArray = []; 

    // วนลูปข้อมูล
      foreach ($data as $key => $details) {

        $scopes = $details->scope;

        $keys = array_map(function ($item) {
        return $item->key;
        }, $scopes);

        // ใช้ array_unique เพื่อลบค่าซ้ำใน $keys
        $uniqueKeys = array_unique($keys);

        $pdfData =  (object)[
            'certificate_no' => 'xx-LBxxx',
            'acc_no' => '',
            'book_no' => '',
            'from_date_th' => '',
            'from_date_en' => '',
            'to_date_th' => '',
            'to_date_en' => '',
            'uniqueKeys' => $uniqueKeys,
            'siteType' => $siteType
        ];

        // dd($pdfData);


          $scopePages = $this->getPageTestList($scopes,$pdfData,$details);
          
          $type = 'I';
          $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
          $fontData = [
              'thsarabunnew' => [
                  'R' => "THSarabunNew.ttf",
                  'B' => "THSarabunNew-Bold.ttf",
                  'I' => "THSarabunNew-Italic.ttf",
                  'BI' => "THSarabunNew-BoldItalic.ttf",
              ],
          ];
  
          if ($siteType == "single") {
              
              $mpdf = new Mpdf([
                  'PDFA'             => $type == 'F' ? true : false,
                  'PDFAauto'         => $type == 'F' ? true : false,
                  'format'           => 'A4',
                  'mode'             => 'utf-8',
                  'default_font_size'=> '15',
                  'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                  'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                  'default_font'     => 'thsarabunnew',
                  'margin_left'      => 6,
                  'margin_right'     => 5,
                  'margin_top'       => 88,
                  'margin_bottom'    => 40,
              ]);
          } else { // multiple
   
              if($key == 0){
                  
                  // $marginTop = 108;
                  $mpdf = new Mpdf([
                      'PDFA'             => $type == 'F' ? true : false,
                      'PDFAauto'         => $type == 'F' ? true : false,
                      'format'           => 'A4',
                      'mode'             => 'utf-8',
                      'default_font_size'=> '15',
                      'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                      'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                      'default_font'     => 'thsarabunnew',
                      'margin_left'      => 6,
                      'margin_right'     => 5,
                      'margin_top'       => 99,
                      'margin_bottom'    => 40,
                  ]);
              }else{
                  $mpdf = new Mpdf([
                      'PDFA'             => $type == 'F' ? true : false,
                      'PDFAauto'         => $type == 'F' ? true : false,
                      'format'           => 'A4',
                      'mode'             => 'utf-8',
                      'default_font_size'=> '15',
                      'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                      'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                      'default_font'     => 'thsarabunnew',
                      'margin_left'      => 6,
                      'margin_right'     => 5,
                      'margin_top'       => 76,
                      'margin_bottom'    => 40,
                  ]);
              }
            
          }
                
  
          $data = $this->getTestScopeData($id)->getData();
  
          $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
          $mpdf->WriteHTML($stylesheet, 1);
  
          // $mpdf->SetWatermarkImage(public_path(...), opacity, [size], [position]); 
  
        //   $mpdf->SetWatermarkImage(public_path('images/nc_logo.jpg'), 1, [23, 23], [170, 4]);
          $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 4]);
  
          $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark
  
          // เพิ่ม Text Watermark
          $mpdf->SetWatermarkText('Confidential', 0.1); // ระบุข้อความและ opacity
          $mpdf->showWatermarkText = true; // เปิดใช้งาน text watermark
              
          $signImage = public_path('images/sign.jpg');
          $sign1Image = public_path('images/sign1.png');
  
          // $footer = view('pdf.scope.calibration.cal-scope-footer', [
          //     'sign1Image' => null,
          //     'sign2Image' => null,
          //     'sign3Image' => null
          // ]);
          // $mpdf->SetHTMLFooter($footer,2);
         
          $headerBlade = "certify.scope_pdf.test.test-scope-first-header";
          $branchNo = null;

          if ($siteType == "multi")
          {
              $branchNo = $key + 1;
              if ($key == 0){
                  $headerBlade = "certify.scope_pdf.test.test-scope-first-header-multi";
              }else{
                  $headerBlade = "certify.scope_pdf.test.test-scope-first-header-multi-branch";
              }   
          }
          // $headerBlade = "certify.scope_pdf.test.test-scope-first-header-multi";
          // dd($scopePages);
          foreach ($scopePages as $index => $scopes) {
              if ($index == 0) {
                  
                  $firstPageHeader = view($headerBlade, [
                      'branchNo' => $branchNo,
                      'company' => $details,
                      'pdfData' => $pdfData
                  ]);
                  $mpdf->SetHTMLHeader($firstPageHeader, 2);
                  $html = view('certify.scope_pdf.test.pdf-test-scope', [
                      'scopes' => collect($scopes) // ส่งเฉพาะส่วนย่อยไปที่ blade
                  ]);
                  $mpdf->WriteHTML($html);
              } else if ($index > 0) {
                  $header = view('certify.scope_pdf.test.test-scope-other-header', []);
                  $mpdf->SetHTMLHeader($header, 2);
                  $mpdf->AddPage('', '', '', '', '', 6, 5, 65, 40); 
                  $html = view('certify.scope_pdf.test.pdf-test-scope', [
                      'scopes' => collect($scopes) // ส่งเฉพาะส่วนย่อยไปที่ blade
                  ]);
                  $mpdf->WriteHTML($html);
              }
          }

          $mpdfArray[$key] = $mpdf;
      }
      

      // $title = "scope";
      // $mpdfArray[0]->Output($title, 'I'); 

      // dd(count($mpdfArray));
      $combinedPdf = new \Mpdf\Mpdf([
          'PDFA'             => $type == 'F' ? true : false,
          'PDFAauto'         => $type == 'F' ? true : false,
          'format'           => 'A4',
          'mode'             => 'utf-8',
          'default_font_size'=> '15',
          'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
          'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
          'default_font'     => 'thsarabunnew',
      ]);

      $combinedPdf->SetImportUse();
      
      // สร้างไฟล์ PDF ชั่วคราวจาก `$mpdfArray`
      $tempFiles = []; // เก็บรายชื่อไฟล์ชั่วคราว
      foreach ($mpdfArray as $key => $mpdf) {
          $tempFileName = "{$key}.pdf"; // เช่น main.pdf, branch0.pdf
          $mpdf->Output($tempFileName, \Mpdf\Output\Destination::FILE); // บันทึก PDF ชั่วคราว
          $tempFiles[] = $tempFileName;
      }

      // รวม PDF
      foreach ($tempFiles as $fileName) {
          $pageCount = $combinedPdf->SetSourceFile($fileName); // เปิดไฟล์ PDF
          for ($i = 1; $i <= $pageCount; $i++) {
              $templateId = $combinedPdf->ImportPage($i);
              $combinedPdf->AddPage();
              $combinedPdf->UseTemplate($templateId);

              // ดึง HTML Footer จาก Blade Template
              $signImage = public_path('images/sign.jpg');
              $footer = view('certify.scope_pdf.test.test-scope-footer', [
                  'sign1Image' => $signImage, // ส่งรูปภาพที่ต้องการใช้
                  'sign2Image' => $signImage,
                  'sign3Image' => $signImage
              ])->render();

              // ตั้งค่า Footer ใหม่สำหรับหน้า PDF
              $combinedPdf->SetHTMLFooter($footer);
          }
      }

      // ส่งออกไฟล์ PDF
      $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);

      // ลบไฟล์ชั่วคราว
      foreach ($tempFiles as $fileName) {
          unlink($fileName);
      }


  }
  
  public function getPageTestList($scopes,$pdfData,$details)
  {

      $pageArray = $this->getFirstTestPageList($scopes,$pdfData,$details);
      // dd($pageArray);

      $firstPageArray = $pageArray[0];

      

      // ดึงค่า index ด้วย array_map และ array access
      $indexes = array_map(function ($item) {
          return $item->index;
      }, $firstPageArray[0]);

     

      $filteredScopes = array_filter($scopes, function ($item) use ($indexes) {
          return !in_array($item->index, $indexes);
      });

     
      
      $filteredScopes = array_values($filteredScopes);

    

      $pageArray = $this->getOtherTestPageList($filteredScopes,$pdfData,$details);

   

      $mergedArray = array_merge($firstPageArray, $pageArray);

      // dd($indexes,$scopes,$filteredScopes,$pageArray, $mergedArray);
      return $mergedArray;
  }


  public function getFirstTestPageList($scopes,$pdfData,$details)
  {
      $type = 'I';
      $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
      $fontData = [
          'thsarabunnew' => [
              'R' => "THSarabunNew.ttf",
              'B' => "THSarabunNew-Bold.ttf",
              'I' => "THSarabunNew-Italic.ttf",
              'BI' => "THSarabunNew-BoldItalic.ttf",
          ],
      ];

      $mpdf = new Mpdf([
          'PDFA' 	=>  $type == 'F' ? true : false,
          'PDFAauto'	 =>  $type == 'F' ? true : false,
          'format'            => 'A4',
          'mode'              => 'utf-8',
          'default_font_size' => '15',
          'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
          'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
          'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
          'margin_left'      => 8, // ระบุขอบด้านซ้าย
          'margin_right'     => 3, // ระบุขอบด้านขวา
          // 'margin_top'       => 97, // ระบุขอบด้านบน
          // 'margin_bottom'    => 40, // ระบุขอบด้านล่าง
          'margin_top'       => 99, // ระบุขอบด้านบน
          'margin_bottom'    => 40, // ระบุขอบด้านล่าง
      ]);         
     
      $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
      $mpdf->WriteHTML($stylesheet, 1);
      
      $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]); // กำหนด opacity, , ตำแหน่ง
      $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark

      $footer = view('certify.scope_pdf.test.test-scope-footer', [
          'qrImage' => null,
          'sign1Image' => null,
          'sign2Image' => null,
          'sign3Image' => null
      ]);

      $viewBlade = "certify.scope_pdf.test.test-scope-first-header";

      if ($pdfData->siteType == "multi")
      {
          $viewBlade = "certify.scope_pdf.test.test-scope-first-header-multi";
      }

      $header = view($viewBlade, [
        'branchNo' => null,
        'company' => $details,
        'pdfData' => $pdfData
    ]);
      $mpdf->SetHTMLHeader($header,2);
      $mpdf->SetHTMLFooter($footer,2);
      
      $html = view('certify.scope_pdf.test.pdf-test-scope', [
              'scopes' => collect($scopes)
          ]);
      $mpdf->WriteHTML($html);
      
      // แปลง PDF เป็น String
      $pdfContent = $mpdf->Output('', 'S');

      // ใช้ PdfParser อ่าน PDF จาก String
      $parser = new Parser();
      $pdf = $parser->parseContent($pdfContent);

      $chunks = $this->generateRangesWithTestData($scopes,$pdf);
      // dd($scopes);
      $firstPage = array_slice($chunks, 0, 1);

      $remainingItems = array_slice($chunks, 1);
     
      return [$firstPage,$remainingItems,$chunks];
  }

  public function getOtherTestPageList($scope,$pdfData,$details)
  {
      $type = 'I';
      $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
      $fontData = [
          'thsarabunnew' => [
              'R' => "THSarabunNew.ttf",
              'B' => "THSarabunNew-Bold.ttf",
              'I' => "THSarabunNew-Italic.ttf",
              'BI' => "THSarabunNew-BoldItalic.ttf",
          ],
      ];

      $mpdf = new Mpdf([
          'PDFA' 	=>  $type == 'F' ? true : false,
          'PDFAauto'	 =>  $type == 'F' ? true : false,
          'format'            => 'A4',
          'mode'              => 'utf-8',
          'default_font_size' => '15',
          'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
          'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
          'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
          'margin_left'      => 8, // ระบุขอบด้านซ้าย
          'margin_right'     => 3, // ระบุขอบด้านขวา
          'margin_top'       => 97, // ระบุขอบด้านบน
          'margin_bottom'    => 40, // ระบุขอบด้านล่าง
      ]);         

      // $data = $this->getMeasurementsData()->getData();

      $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
      $mpdf->WriteHTML($stylesheet, 1);

      // $company = $data->main;
      
      $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]); // กำหนด opacity, , ตำแหน่ง
      $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark

      $footer = view('certify.scope_pdf.test.test-scope-footer', [
          'qrImage' => null,
          'sign1Image' => null,
          'sign2Image' => null,
          'sign3Image' => null
      ]);

      $header = view('certify.scope_pdf.test.test-scope-first-header', [
        'branchNo' => null,
        'company' => $details,
        'pdfData' => $pdfData
      ]);
      $mpdf->SetHTMLHeader($header,2);
      $mpdf->SetHTMLFooter($footer,2);
      
      $html = view('certify.scope_pdf.test.pdf-test-scope', [
              'scopes' => collect($scope)
          ]);
      $mpdf->WriteHTML($html);

      // แปลง PDF เป็น String
      $pdfContent = $mpdf->Output('', 'S');

      // ใช้ PdfParser อ่าน PDF จาก String
      $parser = new Parser();
      $pdf = $parser->parseContent($pdfContent);

      $chunks = $this->generateRangesWithTestData($scope,$pdf);
      
      // $firstPage = reset($chunks);

      // $remainingItems = array_slice($chunks, 1);

      // dd($chunks,$firstPage,$remainingItems);

      return $chunks;
 
  }

  function generateRangesWithTestData($data, $pdf)
  {
      $maxNumber = []; // เก็บตัวเลขที่มากที่สุดของแต่ละหน้า

      // ดึงข้อความและค้นหาตัวเลขที่มากที่สุดในแต่ละหน้า
      foreach ($pdf->getPages() as $pageNumber => $page) {
          preg_match_all('/\*(\d+)\*/', $page->getText(), $matches); // ค้นหาตัวเลขในรูปแบบ *number*
          if (!empty($matches[1])) {
              $maxNumber[$pageNumber + 1] = max($matches[1]); // เก็บเลขที่มากที่สุดในหน้า
          }
      }
      // สร้างช่วงข้อมูลตาม maxNumber และดึงค่าจาก $data
      $start = 0;
      return array_map(function ($end) use (&$start, $data) {
          $range = range($start, (int)$end); // สร้างช่วง index
          $start = (int)$end + 1; // อัปเดตค่าเริ่มต้นสำหรับช่วงถัดไป
          return array_map(function ($index) use ($data) {
              return $data[$index] ?? null; // ดึงค่าจาก $data ตาม index
          }, $range);
      }, $maxNumber);
  }

  public function confirmNotice(Request $request)
  {
    // dd($request->all());
    $notice = Notice::find($request->notice_id)->update([
        'accept_fault' => 1
    ]);
    return response()->json($notice);
  }


  public function specialSign()
  {
    return view('certify.applicant.special-sign');
  }

      public function scopeEditor(Request $request)
    {
    //   dd($request->input('is_permanent'),$request->input('is_site'),$request->input('is_temporary'));
        // Retrieve query parameters
        $accordingFormula = $request->input('according_formula');
        $labAbility = $request->input('lab_ability');
        $purpose = $request->input('purpose');
        $labName=  $request->input('lab_name');
        $labNameEn=  $request->input('lab_name_en');


        $templateType = "";

        $date = $this->getLabCalibrationDate();

        if($labAbility == "calibrate")
        {

            // dd("cal");
                $templateType = "lab_cal";
                $labCalDetails = [
                'title' => [
                    'th' => "รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ",
                    'en' => "Scope of Accreditation for Calibration"
                ],
                'certificateNo' => Carbon::now()->format('y')."-LB0000",
                'labName' => [
                    'th' => $labName,
                    'en' => $labNameEn
                ],
                'accreditationNo' => [
                    'th' => "สอบเทียบ 0000",
                    'en' => "Calibration 0000"
                ],
                'issueNo' => "01",
                'validFrom' => [
                        'th' => $date['validFrom']['th'],
                        'en' => $date['validFrom']['en']
                ],
                'until' => [
                    'th' => $date['until']['th'],
                    'en' => $date['until']['en']
                ],

                'laboratory_status' => [
                    // 'is_permanent' => $request->input('is_permanent') === 'true',
                    // 'is_site'      => $request->input('is_site') === 'true',
                    // 'is_temporary' => $request->input('is_temporary') === 'true',
                    // 'is_mobile'    => $request->input('is_mobile') === 'true',
                    // 'is_multisite' => $request->input('is_multisite') === 'true',
                    'is_permanent' => false,
                    'is_site'      => false,
                    'is_temporary' => false,
                    'is_mobile'    => false,
                    'is_multisite' => false,
                ],
                'calibrationData' => [ 
                    [
                        'field' => ['th' => "", 'en' => ""],
                        'parameter' => "",
                        'capability' => "",
                        'method' => ""
                    ]
                ]
            ];

            // dd()
        
            return view('certify.applicant.scope-editor', [
                'templateType' => $templateType,
                'labCalDetails' => $labCalDetails,
                'according_formula' => $accordingFormula,
                'lab_ability' => $labAbility,
                'purpose' => $purpose
            ]);
        }else if($labAbility == "test")
        {
            $templateType = "lab_test";

            $labTestDetails = [
                'title' => [
                    'th' => "รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ",
                    'en' => "Scope of Accreditation for Calibration"
                ],
                'certificateNo' => Carbon::now()->format('y')."-LB0000",
                'labName' => [
                    'th' => $labName,
                    'en' => $labNameEn
                ],
                'accreditationNo' => [
                    'th' => "ทดสอบ 0000", // หมายเลขการรับรองอาจจะต่างกัน
                    'en' => "Testing 0000"
                ],
                'issueNo' => "01",
                'validFrom' => [
                        'th' => $date['validFrom']['th'],
                        'en' => $date['validFrom']['en']
                ],
                'until' => [
                    'th' => $date['until']['th'],
                    'en' => $date['until']['en']
                ],
                'laboratory_status' => [
                    // 'is_permanent' => $request->input('is_permanent') === 'true',
                    // 'is_site'      => $request->input('is_site') === 'true',
                    // 'is_temporary' => $request->input('is_temporary') === 'true',
                    // 'is_mobile'    => $request->input('is_mobile') === 'true',
                    // 'is_multisite' => $request->input('is_multisite') === 'true',
                    'is_permanent' => false,
                    'is_site'      => false,
                    'is_temporary' => false,
                    'is_mobile'    => false,
                    'is_multisite' => false,
                ],
                'testLabData' => [
                    [
                        'field' => ['th' => "", 'en' => ""],
                        'parameter' => "",
                        'method' => ""
                    ]
                ]
            ];

             return view('certify.applicant.scope-editor', [
                'templateType' => $templateType,
                'labTestDetails' => $labTestDetails,
                 'according_formula' => $accordingFormula,
                'lab_ability' => $labAbility,
                'purpose' => $purpose
            ]);

        }

 
    }

    

    // เมธอดใหม่สำหรับบันทึก HTML template
    public function saveHtmlTemplate(Request $request)
    {
        // dd($request->all());
        // $labCalItems = $request->input('labCalItems'); 
        $labtems = ""; 
        $user =auth()->user();
        $htmlPages = $request->input('html_pages');




        $templateType = $request->input('template_type');
        $accordingFormula = $request->input('accordingFormula');
        $labAbility = $request->input('labAbility');
        $purpose = $request->input('purpose');

        $labtems = $request->input('labItems'); 
        
        $check =  LabHtmlTemplate::where('user_id', $user->id)
                ->where('according_formula',$accordingFormula)
                ->where('lab_ability',$labAbility)
                // ->where('purpose',$purpose)
                ->where('template_type',$templateType)
                ->first();

        // dd($labtems, json_decode( $check->json_data, true));
        if(count($labtems) == 0 ){
            if($check != null){
                $labtems = json_decode( $check->json_data, true);
            }
        }else{
            if($check != null){
                // $labtems_ext = json_decode( $check->json_data, true);
                // dd($labtems ,$labtems_ext);
                $labtems_ext = json_decode($check->json_data, true);
                $labtems = array_merge($labtems, $labtems_ext);
            }
        }

        // dd($labtems);

        $check =  LabHtmlTemplate::where('user_id', $user->id)
                            ->where('according_formula',$accordingFormula)
                            ->where('lab_ability',$labAbility)
                            ->where('purpose',$purpose)
                            ->where('template_type',$templateType)
                            ->first();


        if (!is_array($htmlPages) || empty($htmlPages)) {
            return response()->json(['message' => 'Invalid or empty HTML content received.'], 400);
        }

        if (empty($templateType)) {
            return response()->json(['message' => 'Template type is missing.'], 400);
        }

        try {
            LabHtmlTemplate::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'according_formula' => $accordingFormula,
                    'lab_ability' => $labAbility,
                    'purpose' => $purpose,
                    'template_type' => $templateType,
                ],
                [
                    'html_pages' => json_encode($htmlPages),
                    'json_data' => json_encode($labtems)
                ]
            );

             $labHtmlTemplate = LabHtmlTemplate::where('user_id', $user->id)
                            ->where('according_formula', $accordingFormula)
                            ->where('lab_ability', $labAbility)
                            ->where('purpose', $purpose)
                            ->where('template_type', $templateType)
                            ->first();

            $certilab = CertiLab::find($labHtmlTemplate->app_certi_lab_id);
            
            $jsonDataString = $labHtmlTemplate->json_data;

            $dataArray = json_decode($jsonDataString, true);

            

            // 2. ดึงค่าจาก key 'field' ทั้งหมดออกมาเป็น array ใหม่
            $fieldArray = array_column($dataArray, 'field');
            $uniqueArray = array_unique($fieldArray);

            // dd($fieldArray,$uniqueArray);

            if($certilab != null)
            {
                // $uniqueArray = array_unique($fieldArray);
                if($certilab->lab_type == 3){

                    $this->save_certify_test_scope($certilab,$uniqueArray);
                }else if($certilab->lab_type == 4)
                {
                        

                    $this->save_certifyLab_calibrate($certilab,$uniqueArray);
                }

            }
    
            // dd($certilab,$fieldArray);
 

            return response()->json(['message' => 'Template saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error saving template: ' . $e->getMessage()], 500);
        }
    }

    public function downloadHtmlTemplate(Request $request)
    {
       
        try {

            $user = auth()->user();
            $htmlTemplate = LabHtmlTemplate::where('user_id',$user->id)
            ->where('according_formula',$request->accordingFormula)
            ->where('purpose',$request->purpose)
            ->where('lab_ability',$request->labAbility)
            ->first();

            if( $htmlTemplate == null && $request->purpose >= 2)
            {
                $htmlTemplate = LabHtmlTemplate::where('user_id',$user->id)
                ->where('according_formula',$request->accordingFormula)
                ->where('purpose',1)
                ->where('lab_ability',$request->labAbility)
                ->first();
            }


            if (!$htmlTemplate) {
                return response()->json(['message' => 'Template not found for the given type.'], 404);
            }

            // Decode the JSON string back into an array
            $htmlPages = json_decode($htmlTemplate->html_pages, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['message' => 'Error decoding HTML pages from database.'], 500);
            }

            return response()->json([
                'message' => 'Template loaded successfully!',
                'html_pages' => $htmlPages,
                'template_type' => $htmlTemplate->template_type,
                'htmlTemplate' => $htmlTemplate
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error loading template: ' . $e->getMessage()], 500);
        }
    }


 public function exportScopePdf($id,$labHtmlTemplate,$isDraft)
    {

        $htmlPages = json_decode($labHtmlTemplate->html_pages);
        

        if (!is_array($htmlPages)) {
          
            return response()->json(['message' => 'Invalid or empty HTML content received.'], 400);
        }
        // กรองหน้าเปล่าออก (โค้ดเดิมที่เพิ่มไป)
        $filteredHtmlPages = [];
        foreach ($htmlPages as $pageHtml) {
            $trimmedPageHtml = trim(strip_tags($pageHtml, '<img>'));
            if (!empty($trimmedPageHtml)) {
                $filteredHtmlPages[] = $pageHtml;
            }
        }
  
        if (empty($filteredHtmlPages)) {
            return response()->json(['message' => 'No valid HTML content to export after filtering empty pages.'], 400);
        }
        $htmlPages = $filteredHtmlPages;

        $type = 'I';
        $fontDirs = [public_path('pdf_fonts/')];

        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
            'dejavusans' => [
                'R' => "DejaVuSans.ttf",
                'B' => "DejaVuSans-Bold.ttf",
                'I' => "DejaVuSerif-Italic.ttf",
                'BI' => "DejaVuSerif-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA'              => $type == 'F' ? true : false,
            'PDFAauto'          => $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => 15,
            'fontDir'           => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'          => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'      => 'thsarabunnew',
            'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
            'margin_left'       => 13,
            'margin_right'      => 13,
            'margin_top'        => 10,
            'margin_bottom'     => 0,
            // 'tempDir'           => sys_get_temp_dir(),
        ]);

    
        // Log::info('MPDF Temp Dir: ' . $tempDirPath);

        $stylesheet = file_get_contents(public_path('css/pdf-css/cb.css'));
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 12]);
        $mpdf->showWatermarkImage = true;

        // --- เพิ่ม Watermark Text "DRAFT" ตรงนี้ ---


        $footerHtml = '
        <div width="100%" style="display:inline;line-height:12px">

            <div style="display:inline-block;line-height:16px;float:left;width:70%;">
            <span style="font-size:20px;">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br>
            <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>
            </div>

            <div style="display: inline-block; width: 15%;float:right;width:25%">
        
            </div>

            <div width="100%" style="display:inline;text-align:center">
            <span>หน้าที่ {PAGENO}/{nbpg}</span>
            </div>
        </div>';

        if($isDraft == "draft")
        {
            $mpdf->SetWatermarkText('DRAFT');
            $mpdf->showWatermarkText = true; // เปิดใช้งาน watermark text
            $mpdf->watermark_font = 'thsarabunnew'; // กำหนด font (ควรใช้ font ที่โหลดไว้แล้ว)
            $mpdf->watermarkTextAlpha = 0.1;
        }else{
            $app_certi_lab = CertiLab::find($id);
            $attach1 = null;
            
                $targetRoleId = 22;
                $userRunrecnos = RoleUser::where('role_id', $targetRoleId)->pluck('user_runrecno');
                $groupAdminUsers = Staff::whereIn('runrecno', $userRunrecnos)->where('reg_subdepart',$app_certi_lab->subgroup)->get();

                $firstSignerGroup = null;
                if(count($groupAdminUsers) != 0){
                    $allReg13Ids = [];
                    foreach ($groupAdminUsers as $groupAdminUser) {
                        $reg13Id = str_replace('-', '', $groupAdminUser->reg_13ID);
                        $allReg13Ids[] = $reg13Id;
                    }

                    // $firstSignerGroups = Signer::whereIn('tax_number',$allReg13Ids)->get();

                    $firstSignerGroup = DB::table('besurv_signers')
                        ->whereIn('tax_number',$allReg13Ids)
                        ->first();
                        // dd($firstSignerGroup->id);
                }

                if($firstSignerGroup != null)
                {
                    $attach1 = AttachFile::where('ref_id',$firstSignerGroup->id)->where('ref_table','besurv_signers')
                        ->where('section','attach')
                        ->latest()
                        ->first();

                        $sign_url1 = $this->getSignature($attach1);

                        // dd($sign_url1);

                        $footerHtml = '
<div width="100%" style="display:inline;line-height:12px">

    <div style="display:inline-block;line-height:16px;float:left;width:70%;">
      <span style="font-size:20px;">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br>
      <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>
    </div>

    <div style="display: inline-block; width: 15%;float:right;width:25%">
            <img src="' . $sign_url1 . '" style="height:30px;">
    </div>

    <div width="100%" style="display:inline;text-align:center">
      <span>หน้าที่ {PAGENO}/{nbpg}</span>
    </div>
</div>';

                        // dd($sign_url1);

                    // $attach1 = !empty($firstSignerGroups->first()->AttachFileAttachTo) ? $firstSignerGroups->first()->AttachFileAttachTo : null;
                }

                
            

        }




//////////////////////

//             $attach1 = null;
//             if($selectedCertiLab->scope_view_signer_id == null )
//             {
//                 $targetRoleId = 22;
//                 $userRunrecnos = RoleUser::where('role_id', $targetRoleId)->pluck('user_runrecno');
//                 $groupAdminUsers = User::whereIn('runrecno', $userRunrecnos)->where('reg_subdepart',$selectedCertiLab->subgroup)->get();

//                 $firstSignerGroups = [];
//                 if(count($groupAdminUsers) != 0){
//                     $allReg13Ids = [];
//                     foreach ($groupAdminUsers as $groupAdminUser) {
//                         $reg13Id = str_replace('-', '', $groupAdminUser->reg_13ID);
//                         $allReg13Ids[] = $reg13Id;
//                     }

//                     $firstSignerGroups = Signer::whereIn('tax_number',$allReg13Ids)->get();
//                 }

//                 $attach1 = !empty($firstSignerGroups->first()->AttachFileAttachTo) ? $firstSignerGroups->first()->AttachFileAttachTo : null;
//             }else{
//                    $signer = Signer::find($selectedCertiLab->scope_view_signer_id);
//                     $attach1 = !empty($signer->AttachFileAttachTo) ? $signer->AttachFileAttachTo : null;
//             }

   

//   $sign_url1 = $this->getSignature($attach1);


// $footerHtml = '
// <div width="100%" style="display:inline;line-height:12px">

//     <div style="display:inline-block;line-height:16px;float:left;width:70%;">
//       <span style="font-size:20px;">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br>
//       <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>
//     </div>

//     <div style="display: inline-block; width: 15%;float:right;width:25%">
//             <img src="' . $sign_url1 . '" style="height:30px;">
//     </div>

//     <div width="100%" style="display:inline;text-align:center">
//       <span>หน้าที่ {PAGENO}/{nbpg}</span>
//     </div>
// </div>';



/////////////////////













// แล้วนำไปกำหนดให้ mPDF เป็น Footer
$mpdf->SetHTMLFooter($footerHtml);

        foreach ($htmlPages as $index => $pageHtml) {
            if ($index > 0) {
                $mpdf->AddPage();
            }
            $mpdf->WriteHTML($pageHtml,HTMLParserMode::HTML_BODY);
        }

    //  $mpdf->Output('', 'S');
    //  $title = "mypdf.pdf";
    //  $mpdf->Output($title, "I");  

      $app_certi_lab = CertiLab::find($id);
      $no = str_replace("RQ-", "", $app_certi_lab->app_no);
      $no = str_replace("-", "_", $no);
  
      $attachPath = '/files/applicants/check_files/' . $no . '/';
      $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.pdf';
  
      // สร้างไฟล์ชั่วคราว
      $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
  
      // บันทึก PDF ไปยังไฟล์ชั่วคราว
      $mpdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);
  
      // ใช้ Storage::putFileAs เพื่อย้ายไฟล์
      Storage::putFileAs($attachPath, new \Illuminate\Http\File($tempFilePath), $fullFileName);
  
      $storePath = $no  . '/' . $fullFileName;
        $fileSection = "61";
        if($app_certi_lab->lab_type == 3){
           $fileSection = "61";
        }else if($app_certi_lab->lab_type == 4){
           $fileSection = "62";
        }
    //   dd($fileSection);
      $certi_lab_attach = new CertiLabAttachAll();
      $certi_lab_attach->app_certi_lab_id = $id;
      $certi_lab_attach->file_section     = $fileSection;
      $certi_lab_attach->file             = $storePath;
      $certi_lab_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
      $certi_lab_attach->token            = str_random(16);
      $certi_lab_attach->default_disk = config('filesystems.default');
      $certi_lab_attach->save();

    }

     public function exportScopePdf2($id,$labHtmlTemplate,$isDraft)
    {
        $htmlPages = json_decode($labHtmlTemplate->html_pages);
        

        if (!is_array($htmlPages)) {
          
            return response()->json(['message' => 'Invalid or empty HTML content received.'], 400);
        }
        // กรองหน้าเปล่าออก (โค้ดเดิมที่เพิ่มไป)
        $filteredHtmlPages = [];
        foreach ($htmlPages as $pageHtml) {
            $trimmedPageHtml = trim(strip_tags($pageHtml, '<img>'));
            if (!empty($trimmedPageHtml)) {
                $filteredHtmlPages[] = $pageHtml;
            }
        }
  
        if (empty($filteredHtmlPages)) {
            return response()->json(['message' => 'No valid HTML content to export after filtering empty pages.'], 400);
        }
        $htmlPages = $filteredHtmlPages;

        $type = 'I';
        $fontDirs = [public_path('pdf_fonts/')];

        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
            'dejavusans' => [
                'R' => "DejaVuSans.ttf",
                'B' => "DejaVuSans-Bold.ttf",
                'I' => "DejaVuSerif-Italic.ttf",
                'BI' => "DejaVuSerif-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA'              => $type == 'F' ? true : false,
            'PDFAauto'          => $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => 15,
            'fontDir'           => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'          => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'      => 'thsarabunnew',
            'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
            'margin_left'       => 13,
            'margin_right'      => 13,
            'margin_top'        => 10,
            'margin_bottom'     => 0,
            // 'tempDir'           => sys_get_temp_dir(),
        ]);

    
        // Log::info('MPDF Temp Dir: ' . $tempDirPath);

        $stylesheet = file_get_contents(public_path('css/pdf-css/cb.css'));
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 12]);
        $mpdf->showWatermarkImage = true;

        // --- เพิ่ม Watermark Text "DRAFT" ตรงนี้ ---


        $footerHtml = '
        <div width="100%" style="display:inline;line-height:12px">

            <div style="display:inline-block;line-height:16px;float:left;width:70%;">
            <span style="font-size:20px;">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br>
            <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>
            </div>

            <div style="display: inline-block; width: 15%;float:right;width:25%">
        
            </div>

            <div width="100%" style="display:inline;text-align:center">
            <span>หน้าที่ {PAGENO}/{nbpg}</span>
            </div>
        </div>';

        if($isDraft == "draft")
        {
            $mpdf->SetWatermarkText('DRAFT');
            $mpdf->showWatermarkText = true; // เปิดใช้งาน watermark text
            $mpdf->watermark_font = 'thsarabunnew'; // กำหนด font (ควรใช้ font ที่โหลดไว้แล้ว)
            $mpdf->watermarkTextAlpha = 0.1;
        }else{
            $app_certi_lab = CertiLab::find($id);
            $attach1 = null;
            
                $targetRoleId = 22;
                $userRunrecnos = RoleUser::where('role_id', $targetRoleId)->pluck('user_runrecno');
                $groupAdminUsers = Staff::whereIn('runrecno', $userRunrecnos)->where('reg_subdepart',$app_certi_lab->subgroup)->get();

                $firstSignerGroup = null;
                if(count($groupAdminUsers) != 0){
                    $allReg13Ids = [];
                    foreach ($groupAdminUsers as $groupAdminUser) {
                        $reg13Id = str_replace('-', '', $groupAdminUser->reg_13ID);
                        $allReg13Ids[] = $reg13Id;
                    }

                    // $firstSignerGroups = Signer::whereIn('tax_number',$allReg13Ids)->get();

                    $firstSignerGroup = DB::table('besurv_signers')
                        ->whereIn('tax_number',$allReg13Ids)
                        ->first();
                        // dd($firstSignerGroup->id);
                }

                if($firstSignerGroup != null)
                {
                    $attach1 = AttachFile::where('ref_id',$firstSignerGroup->id)->where('ref_table','besurv_signers')
                        ->where('section','attach')
                        ->latest()
                        ->first();

                        $sign_url1 = $this->getSignature($attach1);

                        // dd($sign_url1);

                        $footerHtml = '
<div width="100%" style="display:inline;line-height:12px">

    <div style="display:inline-block;line-height:16px;float:left;width:70%;">
      <span style="font-size:20px;">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br>
      <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>
    </div>

    <div style="display: inline-block; width: 15%;float:right;width:25%">
            <img src="' . $sign_url1 . '" style="height:30px;">
    </div>

    <div width="100%" style="display:inline;text-align:center">
      <span>หน้าที่ {PAGENO}/{nbpg}</span>
    </div>
</div>';

                        // dd($sign_url1);

                    // $attach1 = !empty($firstSignerGroups->first()->AttachFileAttachTo) ? $firstSignerGroups->first()->AttachFileAttachTo : null;
                }

                
            

        }




//////////////////////

//             $attach1 = null;
//             if($selectedCertiLab->scope_view_signer_id == null )
//             {
//                 $targetRoleId = 22;
//                 $userRunrecnos = RoleUser::where('role_id', $targetRoleId)->pluck('user_runrecno');
//                 $groupAdminUsers = User::whereIn('runrecno', $userRunrecnos)->where('reg_subdepart',$selectedCertiLab->subgroup)->get();

//                 $firstSignerGroups = [];
//                 if(count($groupAdminUsers) != 0){
//                     $allReg13Ids = [];
//                     foreach ($groupAdminUsers as $groupAdminUser) {
//                         $reg13Id = str_replace('-', '', $groupAdminUser->reg_13ID);
//                         $allReg13Ids[] = $reg13Id;
//                     }

//                     $firstSignerGroups = Signer::whereIn('tax_number',$allReg13Ids)->get();
//                 }

//                 $attach1 = !empty($firstSignerGroups->first()->AttachFileAttachTo) ? $firstSignerGroups->first()->AttachFileAttachTo : null;
//             }else{
//                    $signer = Signer::find($selectedCertiLab->scope_view_signer_id);
//                     $attach1 = !empty($signer->AttachFileAttachTo) ? $signer->AttachFileAttachTo : null;
//             }

   

//   $sign_url1 = $this->getSignature($attach1);


// $footerHtml = '
// <div width="100%" style="display:inline;line-height:12px">

//     <div style="display:inline-block;line-height:16px;float:left;width:70%;">
//       <span style="font-size:20px;">กระทรวงอุตสาหกรรม สํานักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม</span><br>
//       <span style="font-size: 16px">(Ministry of Industry, Thai Industrial Standards Institute)</span>
//     </div>

//     <div style="display: inline-block; width: 15%;float:right;width:25%">
//             <img src="' . $sign_url1 . '" style="height:30px;">
//     </div>

//     <div width="100%" style="display:inline;text-align:center">
//       <span>หน้าที่ {PAGENO}/{nbpg}</span>
//     </div>
// </div>';



/////////////////////













// แล้วนำไปกำหนดให้ mPDF เป็น Footer
$mpdf->SetHTMLFooter($footerHtml);

        foreach ($htmlPages as $index => $pageHtml) {
            if ($index > 0) {
                $mpdf->AddPage();
            }
            $mpdf->WriteHTML($pageHtml,HTMLParserMode::HTML_BODY);
        }

    //  $mpdf->Output('', 'S');
    //  $title = "mypdf.pdf";
    //  $mpdf->Output($title, "I");  

      $app_certi_lab = CertiLab::find($id);
      $no = str_replace("RQ-", "", $app_certi_lab->app_no);
      $no = str_replace("-", "_", $no);
  
      $attachPath = '/files/applicants/check_files/' . $no . '/';
      $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.pdf';
  
      // สร้างไฟล์ชั่วคราว
      $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
  
      // บันทึก PDF ไปยังไฟล์ชั่วคราว
      $mpdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);
  
      // ใช้ Storage::putFileAs เพื่อย้ายไฟล์
      Storage::putFileAs($attachPath, new \Illuminate\Http\File($tempFilePath), $fullFileName);

    
  
      $storePath = $no  . '/' . $fullFileName;
        $fileSection = "61";
        if($app_certi_lab->lab_type == 3){
           $fileSection = "61";
        }else if($app_certi_lab->lab_type == 4){
           $fileSection = "62";
        }

      $certi_lab_attach = new CertiLabAttachAll();
      $certi_lab_attach->app_certi_lab_id = $id;
      $certi_lab_attach->file_section     = $fileSection;
      $certi_lab_attach->file             = $storePath;
      $certi_lab_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
      $certi_lab_attach->token            = str_random(16);
      $certi_lab_attach->default_disk = null;
      $certi_lab_attach->save();

    //   $certi_lab_attach->delete();
    //   dd("aaa");

    }


    public function getSignature($attach)
    {
        
        $existingFilePath = $attach->url;//  'files/signers/3210100336046/tvE4QPMaEC-date_time20241211_011258.png'  ;

        $attachPath = 'bcertify_attach/signer';
        $fileName = basename($existingFilePath) ;// 'tvE4QPMaEC-date_time20241211_011258.png';
        // dd($existingFilePath);

        // ตรวจสอบไฟล์ใน disk uploads ก่อน
        if (Storage::disk('uploads')->exists("{$attachPath}/{$fileName}")) {
            // หากพบไฟล์ใน disk
            $storagePath = Storage::disk('uploads')->path("{$attachPath}/{$fileName}");
            $filePath = 'uploads/'.$attachPath .'/'.$fileName;
            // dd('File already exists in uploads',  $filePath);
            return $filePath;
        } else {
            // หากไม่พบไฟล์ใน disk ให้ไปตรวจสอบในเซิร์ฟเวอร์
            if (HP::checkFileStorage($existingFilePath)) {
                // ดึง path ของไฟล์ที่อยู่ในเซิร์ฟเวอร์
                $localFilePath = HP::getFileStoragePath($existingFilePath);

                // ตรวจสอบว่าไฟล์มีอยู่หรือไม่
                if (file_exists($localFilePath)) {
                    // บันทึกไฟล์ลง disk 'uploads' โดยใช้ subfolder ที่กำหนด
                    $storagePath = Storage::disk('uploads')->putFileAs($attachPath, new \Illuminate\Http\File($localFilePath), $fileName);

                    // ตอบกลับว่าพบไฟล์และบันทึกสำเร็จ
                    $filePath = 'uploads/'.$attachPath .'/'.$fileName;
                    return $filePath;
                    // dd('File exists in server and saved to uploads', $storagePath);
                } else {
                    // กรณีไฟล์ไม่สามารถเข้าถึงได้ใน path เดิม
                    return null;
                }
            } else {
                // ตอบกลับกรณีไม่มีไฟล์ในเซิร์ฟเวอร์
                return null;
            }
        }
        
    }

}
