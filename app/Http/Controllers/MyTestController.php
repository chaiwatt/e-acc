<?php

namespace App\Http\Controllers;
use HP;
use Storage;

use Mpdf\Mpdf;
// use App\Models\Bcertify\Signer;
use Mpdf\Tag\P;
use Carbon\Carbon;
use App\AttachFile;
use App\HtmlTemplate;
use Mpdf\HTMLParserMode;
use App\CertificateExport;
use App\Models\Basic\Staff;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Models\Basic\District;
use App\Models\Bcertify\Signer;
use App\Mail\Lab\LabScopeReview;
use App\Services\CreateIbScopePdf;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLabScopePdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Bcertify\LabCalRequest;
use App\Services\CreateCbScopeBcmsPdf;
use App\Services\CreateCbScopeIsicPdf;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use App\Models\Bcertify\CalibrationGroup;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certify\ApplicantCB\CertiCb;
use App\Models\Certify\ApplicantIB\CertiIb;
use App\Models\Certificate\TrackingAssessment;
use App\Models\Certificate\TrackingInspection;
use App\Models\Basic\ConfigRoles as config_roles;
use App\Models\Certificate\CbScopeIsicTransaction;
use App\Models\Bcertify\CalibrationBranchInstrument;
use App\Models\Bcertify\LabCalInstrumentTransaction;
use App\Models\Bcertify\LabCalParameterOneTransaction;
use App\Models\Certify\Applicant\CertiLabExportMapreq;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;

class MyTestController extends Controller
{

   public function abTest()
   {
    // lab_cal, lab_test, cb, ib
    $templateType = "lab_cal";
     return view('abtest.html',[
      'templateType' => $templateType
     ]);
   }


   public function showLabCalDetails()
    {
        $templateType = "lab_cal"; // กำหนด templateType เป็น "lab_cal"

        $labCalDetails = [
            'title' => [
                'th' => "รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ",
                'en' => "Scope of Accreditation for Calibration"
            ],
            'certificateNo' => "21-LB0036",
            'labName' => [
                'th' => "บริษัท เอ็นพีซีโซลูชั่นแอนด์เซอร์วิส จำกัด",
                'en' => "IRC Technologies Co.,Ltd."
            ],
            'accreditationNo' => [
                'th' => "สอบเทียบ 0203",
                'en' => "Calibration 0203"
            ],
            'issueNo' => "01",
            'validFrom' => [
                'th' => "2 กันยายน 2564", 
                'en' => "30 January B.E.2566 (2023)"
            ],
            'until' => [
                'th' => "1 กันยายน 2569",
                'en' => "29 January B.E. 2571 (2028)"
            ],

            'laboratory_status' => [
                'is_permanent' => true,
                'is_site' => false,
                'is_temporary' => false,
                'is_mobile' => false,
                'is_multisite' => false,
            ],
            'calibrationData' => [ 
                [
                    'field' => ['th' => "ไฟฟ้า", 'en' => "Electrical"],
                    'parameter' => "Measuring instrument<br>&nbsp;DC voltage<br>&nbsp;&nbsp;&nbsp;0 mV to < 220 mV<br>&nbsp;&nbsp;&nbsp;0.22 V to < 2.2 V<br>&nbsp;&nbsp;&nbsp;2.2 V to < 11 V",
                    'capability' => "<br><br>&nbsp;&nbsp;&nbsp;8.0 &mu;V/V + 1.8 &mu;V<br>&nbsp;&nbsp;&nbsp;7.0 &mu;V/V + 7.3 &mu;V<br>&nbsp;&nbsp;&nbsp;7.0 &mu;V/V + 8.1 &mu;V",
                    'method' => "<br>In-house method :<br>CP-01DCV by direct<br>measurement with<br>multifunction calibrator"
                ]
            ]
        ];

        return view('abtest.html', [
            'templateType' => $templateType,
            'labCalDetails' => $labCalDetails 
        ]);
    }
    public function showLabTestDetails()
    {
        $templateType = "lab_test";

        $labTestDetails = [
            'title' => [
                'th' => "รายละเอียดสาขาและขอบข่ายใบรับรองห้องปฏิบัติการ",
                'en' => "Scope of Accreditation for Testing" // เปลี่ยนเป็น Testing
            ],
            'certificateNo' => "21-LB0036", // อาจจะคนละเลขกับ Calibration ก็ได้
            'labName' => [
                'th' => "บริษัท เอ็นพีซีโซลูชั่นแอนด์เซอร์วิส จำกัด",
                'en' => "IRC Technologies Co.,Ltd."
            ],
            'accreditationNo' => [
                'th' => "ทดสอบ 0001", // หมายเลขการรับรองอาจจะต่างกัน
                'en' => "Testing 0001"
            ],
            'issueNo' => "01",
            'validFrom' => [
                'th' => "2 กันยายน 2564",
                'en' => "30 January B.E.2566 (2023)"
            ],
            'until' => [
                'th' => "1 กันยายน 2569",
                'en' => "29 January B.E. 2571 (2028)"
            ],
            'laboratory_status' => [
                'is_permanent' => true,
                'is_site' => false,
                'is_temporary' => false,
                'is_mobile' => false,
                'is_multisite' => false,
            ],
            'testLabData' => [
                [
                    'field' => ['th' => "สาขาโยธา", 'en' => "Civil field"],
                    'parameter' => "<br>ความละเอียดโดยเครื่องแอร์เพอร์มีอะบิลิตี<br>(Fineness by air-permeability)",
                    'method' => "<br>มอก. 2752 เล่ม 6-2562 (วิธี A)<br>(TIS 2752 Part 6-2562 (2019) (Method A))"
                ]
            ]
        ];

        return view('abtest.html', [
            'templateType' => $templateType,
            'labTestDetails' => $labTestDetails // ส่งข้อมูล Lab Test Details เข้าไป
        ]);
    }

    public function showCbDetails()
    {
        $templateType = "cb"; // กำหนด templateType เป็น "cb"

        $cbDetails = [
            'scopeOfAccreditation' => [
                'th' => "สาขาและขอบข่ายการรับรองระบบงาน",
                'en' => "Scope of Accreditation"
            ],
            'attachmentToCertificate' => [
                'th' => "แนบท้ายใบรับรองระบบงาน : หน่วยรับรองระบบงานการจัดการคุณภาพ",
                'en' => "Attachment to Certificate of Quality Management System Certification Body Accreditation"
            ],
            'certificateNo' => "24-CB0003",
            'certificationBody' => [
                'th' => "บริษัท เอ็นพีซีโซลูชั่นแอนด์เซอร์วิส จำกัด",
                'en' => "Thailand Institute of Scientific and Technological Research, Office of Certification Body"
            ],
            'premise' => [
                'th' => "35 หมู่ 3 เทคโนธานี ตำบลคลองห้า อำเภอคลองหลวง จังหวัดปทุมธานี",
                'en' => "35 Moo 3 Technopolis, Tambon Klong 5, Amphoe Khlong Luang, Pathum Thani"
            ],
            'accreditationCriteria' => [
                [ 'th' => "ISO/IEC 17021-1:2015 (มอก. 17021-1-2559)", 'en' => "ISO 17021-3:2017 (มอก. 17021-3-2562)" ],
            ],
            'certificationMark' => [
                'th' => "การรับรองระบบบริหารงานคุณภาพตามมาตรฐาน ISO 9001/มอก.9001 โดยมีสาขาและ<br>ขอบข่ายตามมาตรฐานการจัดประเภทอุตสาหกรรมตามกิจกรรมทางเศรษฐกิจทุกประเภท<br>ตามมาตรฐานสากล (ISIC) มอก.2000-2540 ดังต่อไปนี้",
                'en' => "Quality Management system Certification according to ISO 9001/TIS 9001, covered by International Standard industrial classification of all economic activities (ISIC) according to TIS 2000-2540 as following"
            ],
            'isicCodes' => [
                [ 'code' => "15", 'description_th' => "การผลิตผลิตภัณฑ์อาหารและเครื่องดื่ม", 'description_en' => "Manufacture of food products and beverages" ],
                
            ]
        ];

        return view('abtest.html', [
            'templateType' => $templateType,
            'cbDetails' => $cbDetails // ส่งข้อมูล CB Details เข้าไป
        ]);
    }

    // เมธอดใหม่สำหรับแสดงรายละเอียด IB (Inspection Body)
    public function showIbDetails()
    {
        $templateType = "ib"; // กำหนด templateType เป็น "ib"

        $ibDetails = [
            'title' => "รายละเอียดแนบท้ายใบรับรองระบบงานหน่วยตรวจ",
            'certificateNo' => "23-IB0005",
            'inspectionBodyName' => "บริษัท เอ็นพีซีโซลูชั่นแอนด์เซอร์วิส จำกัด",
            'headOfficeAddress' => "เลขที่ 1285/5 ถนนประชาราษฎร์ แขวงวงศ์สว่าง เขตบางซื่อ<br>กรุงเทพมหานคร",
            'branchOfficeAddress' => "เลขที่ 3 ซอยสาธุฯ 29 ถนนสุขสวัสดิ์ 105 แขวงบางนา<br>เขตบางนา กรุงเทพมหานคร",
            'accreditationNo' => "หน่วยตรวจ 0057",
            'inspectionBodyType' => "ประเภท A",
            'inspectionItems' => [
                [
                    'category' => "1. สินค้าเกษตร:<br>ข้าวหอมมะลิไทย",
                    'procedure' => "การตรวจในขั้นตอนก่อนปล่อยและขั้น<br>ตรวจปล่อย ในรายการต่อไปนี้",
                    'requirements' => "1. ประกาศกระทรวงพาณิชย์ เรื่อง<br>หลักเกณฑ์และวิธีการจัดให้มีการ<br>ตรวจสอบมาตรฐานสินค้า และการ<br>ออกใบรับรองมาตรฐานสินค้า<br>สำหรับสินค้าข้าวหอมมะลิไทย<br>พ.ศ. 2559"
                ]
            ]
        ];

        return view('abtest.html', [
            'templateType' => $templateType,
            'ibDetails' => $ibDetails // ส่งข้อมูล IB Details เข้าไป
        ]);
    }

     // เมธอดใหม่สำหรับบันทึก HTML template
    public function saveHtmlTemplate(Request $request)
    {
        $htmlPages = $request->input('html_pages');
        $templateType = $request->input('template_type');

        if (!is_array($htmlPages) || empty($htmlPages)) {
            return response()->json(['message' => 'Invalid or empty HTML content received.'], 400);
        }

        if (empty($templateType)) {
            return response()->json(['message' => 'Template type is missing.'], 400);
        }

        try {
            // ใช้ updateOrCreate:
            // ถ้าพบ template_type ที่ตรงกันในฐานข้อมูล จะทำการอัปเดต record นั้น
            // ถ้าไม่พบ จะทำการสร้าง record ใหม่
            HtmlTemplate::updateOrCreate(
                ['template_type' => $templateType], // เงื่อนไขในการค้นหา
                ['html_pages' => json_encode($htmlPages)] // ข้อมูลที่จะอัปเดตหรือสร้าง
            );

            return response()->json(['message' => 'Template saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error saving template: ' . $e->getMessage()], 500);
        }
    }

    public function downloadHtmlTemplate(Request $request)
    {
        $templateType = $request->input('template_type');

        if (empty($templateType)) {
            return response()->json(['message' => 'Template type is missing.'], 400);
        }

        try {
            // Retrieve the first template that matches the type
            $htmlTemplate = HtmlTemplate::where('template_type', $templateType)->first();

            if (!$htmlTemplate) {
                return response()->json(['message' => 'Template not found for the given type.'], 404);
            }

            // Decode the JSON string back into an array
            $htmlPages = json_decode($htmlTemplate->html_pages, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['message' => 'Error decoding HTML pages from database.'], 500);
            }

            // dd($htmlPages);

            return response()->json([
                'message' => 'Template loaded successfully!',
                'html_pages' => $htmlPages,
                'template_type' => $htmlTemplate->template_type
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error loading template: ' . $e->getMessage()], 500);
        }
    }

    // public function exportPdf(Request $request)
    // {
    //     $htmlPages = $request->input('html_pages');

    //     if (!is_array($htmlPages) || empty($htmlPages)) {
    //         return response()->json(['message' => 'Invalid or empty HTML content received.'], 400);
    //     }

    //     $type = 'I'; 
    //     $fontDirs = [public_path('pdf_fonts/')]; 

    //     $fontData = [
    //         'thsarabunnew' => [
    //             'R' => "THSarabunNew.ttf",
    //             'B' => "THSarabunNew-Bold.ttf",
    //             'I' => "THSarabunNew-Italic.ttf",
    //             'BI' => "THSarabunNew-BoldItalic.ttf",
    //         ],
    //         'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
    //             'R' => "DejaVuSans.ttf",
    //             'B' => "DejaVuSans-Bold.ttf",
    //             'I' => "DejaVuSerif-Italic.ttf",
    //             'BI' => "DejaVuSerif-BoldItalic.ttf",
    //         ],
  
    //     ];

    //     $mpdf = new Mpdf([
    //         'PDFA'              => $type == 'F' ? true : false,
    //         'PDFAauto'          => $type == 'F' ? true : false,
    //         'format'            => 'A4',
    //         'mode'              => 'utf-8',
    //         'default_font_size' => 15,
    //         'fontDir'           => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
    //         'fontdata'          => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
    //         'default_font'      => 'thsarabunnew',
    //         'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'], 
    //         'margin_left'       => 13,
    //         'margin_right'      => 13,
    //         'margin_top'        => 10,
    //         'margin_bottom'     => -1,
    //         'tempDir'           => sys_get_temp_dir(),
    //     ]);

    //     $stylesheet = file_get_contents(public_path('css/pdf-css/cb.css'));
    //     $mpdf->WriteHTML($stylesheet, 1);

    //      $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 12]);
   
    //        $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark
    //     // dd(count($htmlPages));
    //     foreach ($htmlPages as $index => $pageHtml) {
    //         if ($index > 0) {
    //             $mpdf->AddPage(); 
    //         }
    //         // ใช้ HTMLParserMode::HTML_BODY เพื่อให้ mPDF จัดการโครงสร้าง body สำหรับแต่ละหน้า
    //         $mpdf->WriteHTML($pageHtml,HTMLParserMode::HTML_BODY); 
    //     }

    //     // *** เปลี่ยนบรรทัดนี้เพื่อส่ง PDF Output พร้อม Header ที่ชัดเจน ***
    //     return Response::make($mpdf->Output(), 200, [
    //         'Content-Type'        => 'application/pdf',
    //         'Content-Disposition' => ($type === 'D' ? 'attachment' : 'inline') . '; filename="document.pdf"',
    //     ]);
    // }
   
    public function exportPdf(Request $request)
    {
        $htmlPages = $request->input('html_pages');

       

        if (!is_array($htmlPages) || empty($htmlPages)) {
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
    // $tempDirPath = sys_get_temp_dir();
    //     dd($tempDirPath);
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
            'tempDir'           => sys_get_temp_dir(),
        ]);

    
        Log::info('MPDF Temp Dir: ' . $tempDirPath);

        $stylesheet = file_get_contents(public_path('css/pdf-css/cb.css'));
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 12]);
        $mpdf->showWatermarkImage = true;

        // --- เพิ่ม Watermark Text "DRAFT" ตรงนี้ ---
        $mpdf->SetWatermarkText('DRAFT');
        $mpdf->showWatermarkText = true; // เปิดใช้งาน watermark text
        $mpdf->watermark_font = 'thsarabunnew'; // กำหนด font (ควรใช้ font ที่โหลดไว้แล้ว)
        $mpdf->watermarkTextAlpha = 0.1;
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

// แล้วนำไปกำหนดให้ mPDF เป็น Footer
$mpdf->SetHTMLFooter($footerHtml);

        foreach ($htmlPages as $index => $pageHtml) {
            if ($index > 0) {
                $mpdf->AddPage();
            }
            $mpdf->WriteHTML($pageHtml,HTMLParserMode::HTML_BODY);
        }

        return Response::make($mpdf->Output(), 200, [
            'Content-Type'      => 'application/pdf',
            'Content-Disposition' => ($type === 'D' ? 'attachment' : 'inline') . '; filename="document.pdf"',
        ]);
    }

    public function index()
    {

      // $config_roles  =  config_roles::select('role_id')->whereIn('group_type', [1, 2])->get()->pluck('role_id');
      // dd($config_roles);
      // // ดึงรายการ permissions ทั้งหมด
      // $permissions = Permission::all();

      // $user = auth()->user();
      // $results = [];

      // foreach ($permissions as $permission) {
      //    $results[$permission->name] = $user->can($permission->name);
      // }

      // // แสดงผลลัพธ์
      // foreach ($results as $permission => $can) {
      //    echo "User can {$permission}: " . ($can ? 'Yes' : 'No') . ".<br>";
      // }

       $branche  = CalibrationBranch::find(23);
      //  dd($branche->calibrationBranchInstrumentGroups->pluck('name')->toArray());

       $instrument = CalibrationBranchInstrumentGroup::find(5);
      //  dd($instrument->name);
       dd(
        $branche->calibrationBranchInstrumentGroups->pluck('name')->toArray(),
        $instrument->calibrationBranch->title,
        $instrument->name,
        $instrument->calibrationBranchInstruments->pluck('name')->toArray(),
        $instrument->calibrationBranchParam1s->pluck('name')->toArray(),
        $instrument->calibrationBranchParam2s->pluck('name')->toArray()
      );
    }

    public function addLabCalScope()
    {
     

    }

    public function getLabCalScope()
    {
    

    }

    public function updateDistrict()
    {
        $setOnes = [
            [
              "ID" => 3577,
              "TH_NAME" => "ห้วยโจด",
              "EN_NAME" => "Huai Chod"
            ],
            [
              "ID" => 3578,
              "TH_NAME" => "ห้วยยาง",
              "EN_NAME" => "Huai Yang"
            ],
            [
              "ID" => 3579,
              "TH_NAME" => "บ้านฝาง",
              "EN_NAME" => "Ban Fang"
            ],
            [
              "ID" => 3582,
              "TH_NAME" => "หนองโน",
              "EN_NAME" => "Nong No"
            ],
            [
              "ID" => 3583,
              "TH_NAME" => "น้ำอ้อม",
              "EN_NAME" => "Nam Om"
            ],
            [
              "ID" => 3588,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 3600,
              "TH_NAME" => "หินตั้ง",
              "EN_NAME" => "Hin Tang"
            ],
            [
              "ID" => 3602,
              "TH_NAME" => "หนองน้ำใส",
              "EN_NAME" => "Nong Nam Sai"
            ],
            [
              "ID" => 3612,
              "TH_NAME" => "วังม่วง",
              "EN_NAME" => "Wang Muang"
            ],
            [
              "ID" => 3613,
              "TH_NAME" => "ขามป้อม",
              "EN_NAME" => "Kham Pom"
            ],
            [
              "ID" => 3614,
              "TH_NAME" => "สระแก้ว",
              "EN_NAME" => "Sra Kaeo"
            ],
            [
              "ID" => 3639,
              "TH_NAME" => "โนนทอง",
              "EN_NAME" => "Non Thong"
            ],
            [
              "ID" => 3641,
              "TH_NAME" => "โนนสะอาด",
              "EN_NAME" => "Non Sa-at"
            ],
            [
              "ID" => 3643,
              "TH_NAME" => "ก้านเหลือง",
              "EN_NAME" => "Kan Lueang"
            ],
            [
              "ID" => 3652,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 3658,
              "TH_NAME" => "วังหิน",
              "EN_NAME" => "Wang Hin"
            ],
            [
              "ID" => 3659,
              "TH_NAME" => "หนองไผ่ล้อม",
              "EN_NAME" => "Nong Phai Lom"
            ],
            [
              "ID" => 3666,
              "TH_NAME" => "นาหว้า",
              "EN_NAME" => "Na Wa"
            ],
            [
              "ID" => 3672,
              "TH_NAME" => "สงเปือย",
              "EN_NAME" => "Song Puer"
            ],
            [
              "ID" => 3686,
              "TH_NAME" => "ท่าศาลา",
              "EN_NAME" => "Tha Sala"
            ],
            [
              "ID" => 3693,
              "TH_NAME" => "บ้านแท่น",
              "EN_NAME" => "Ban Taen"
            ],
            [
              "ID" => 3694,
              "TH_NAME" => "ศรีบุญเรือง",
              "EN_NAME" => "Sri Bun Reuang"
            ],
            [
              "ID" => 3700,
              "TH_NAME" => "โนนสมบูรณ์",
              "EN_NAME" => "Non Samboon"
            ],
            [
              "ID" => 3703,
              "TH_NAME" => "นาฝาย",
              "EN_NAME" => "Na Fai"
            ],
            [
              "ID" => 3712,
              "TH_NAME" => "บ้านโคก",
              "EN_NAME" => "Ban Khok"
            ],
            [
              "ID" => 3714,
              "TH_NAME" => "ซับสมบูรณ์",
              "EN_NAME" => "Sap Samboon"
            ],
            [
              "ID" => 3717,
              "TH_NAME" => "บ้านโคก",
              "EN_NAME" => "Ban Khok"
            ],
            [
              "ID" => 3720,
              "TH_NAME" => "โคกสำราญ",
              "EN_NAME" => "Khok Samran"
            ],
            [
              "ID" => 3721,
              "TH_NAME" => "โนนสมบูรณ์",
              "EN_NAME" => "Non Samboon"
            ],
            [
              "ID" => 3722,
              "TH_NAME" => "หนองแซง",
              "EN_NAME" => "Nong Saeng"
            ],
            [
              "ID" => 3724,
              "TH_NAME" => "หนองปลาหมอ",
              "EN_NAME" => "Nong Pla Mo"
            ],
            [
              "ID" => 3725,
              "TH_NAME" => "บ้านหัน",
              "EN_NAME" => "Ban Han"
            ],
            [
              "ID" => 3727,
              "TH_NAME" => "โนนแดง",
              "EN_NAME" => "Non Daeng"
            ],
            [
              "ID" => 3728,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 3730,
              "TH_NAME" => "เขาน้อย",
              "EN_NAME" => "Khao Noi"
            ],
            [
              "ID" => 3735,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 3737,
              "TH_NAME" => "โนนสูง",
              "EN_NAME" => "Non Sung"
            ],
            [
              "ID" => 3742,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Di"
            ],
            [
              "ID" => 3746,
              "TH_NAME" => "หนองไฮ",
              "EN_NAME" => "Nong Hai"
            ],
            [
              "ID" => 3747,
              "TH_NAME" => "นาข่า",
              "EN_NAME" => "Na Kha"
            ],
            [
              "ID" => 3750,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 3752,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 3764,
              "TH_NAME" => "เชียงเพ็ง",
              "EN_NAME" => "Chiang Peng"
            ],
            [
              "ID" => 3766,
              "TH_NAME" => "เมืองเพีย",
              "EN_NAME" => "Mueang Pia"
            ],
            [
              "ID" => 3773,
              "TH_NAME" => "หนองบัวบาน",
              "EN_NAME" => "Nong Bua Ban"
            ],
            [
              "ID" => 3786,
              "TH_NAME" => "ปะโค",
              "EN_NAME" => "Pa Ko"
            ],
            [
              "ID" => 3791,
              "TH_NAME" => "หนองหว้า",
              "EN_NAME" => "Nong Wa"
            ],
            [
              "ID" => 3797,
              "TH_NAME" => "โนนสะอาด",
              "EN_NAME" => "Non Sa-at"
            ],
            [
              "ID" => 3802,
              "TH_NAME" => "โคกกลาง",
              "EN_NAME" => "Khok Klang"
            ],
            [
              "ID" => 3804,
              "TH_NAME" => "หนองเม็ก",
              "EN_NAME" => "Nong Mek"
            ],
            [
              "ID" => 3813,
              "TH_NAME" => "โพนงาม",
              "EN_NAME" => "Phon Ngam"
            ],
            [
              "ID" => 3816,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 3829,
              "TH_NAME" => "ทุ่งใหญ่",
              "EN_NAME" => "Thung Yai"
            ],
            [
              "ID" => 3830,
              "TH_NAME" => "นาชุมแสง",
              "EN_NAME" => "Na Chum Saeng"
            ],
            [
              "ID" => 3833,
              "TH_NAME" => "หนองหลัก",
              "EN_NAME" => "Nong Lak"
            ],
            [
              "ID" => 3838,
              "TH_NAME" => "บ้านโปร่ง",
              "EN_NAME" => "Ban Prong"
            ],
            [
              "ID" => 3839,
              "TH_NAME" => "หัวนาคำ",
              "EN_NAME" => "Hua Na Kham"
            ],
            [
              "ID" => 3842,
              "TH_NAME" => "ตาดทอง",
              "EN_NAME" => "Tad Thong"
            ],
            [
              "ID" => 3846,
              "TH_NAME" => "ผาสุก",
              "EN_NAME" => "Pha Suk"
            ],
            [
              "ID" => 3852,
              "TH_NAME" => "โพนสูง",
              "EN_NAME" => "Phon Sung"
            ],
            [
              "ID" => 3858,
              "TH_NAME" => "วังทอง",
              "EN_NAME" => "Wang Thong"
            ],
            [
              "ID" => 3860,
              "TH_NAME" => "บ้านตาด",
              "EN_NAME" => "Ban Tad"
            ],
            [
              "ID" => 3861,
              "TH_NAME" => "นาคำ",
              "EN_NAME" => "Na Kham"
            ],
            [
              "ID" => 3928,
              "TH_NAME" => "บ้านผือ",
              "EN_NAME" => "Ban Puer"
            ],
            [
              "ID" => 3929,
              "TH_NAME" => "หายโศก",
              "EN_NAME" => "Hai Sok"
            ],
            [
              "ID" => 3932,
              "TH_NAME" => "โนนทอง",
              "EN_NAME" => "Non Thong"
            ],
            [
              "ID" => 3935,
              "TH_NAME" => "กลางใหญ่",
              "EN_NAME" => "Klang Yai"
            ],
            [
              "ID" => 3939,
              "TH_NAME" => "บ้านค้อ",
              "EN_NAME" => "Ban Khao"
            ],
            [
              "ID" => 3940,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 3946,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 3951,
              "TH_NAME" => "ศรีสำราญ",
              "EN_NAME" => "Sri Samran"
            ],
            [
              "ID" => 3953,
              "TH_NAME" => "สามัคคี",
              "EN_NAME" => "Samakkhi"
            ],
            [
              "ID" => 3957,
              "TH_NAME" => "บ้านธาตุ",
              "EN_NAME" => "Ban That"
            ],
            [
              "ID" => 3961,
              "TH_NAME" => "นาบัว",
              "EN_NAME" => "Na Bua"
            ],
            [
              "ID" => 3962,
              "TH_NAME" => "บ้านเหล่า",
              "EN_NAME" => "Ban Lao"
            ],
            [
              "ID" => 3965,
              "TH_NAME" => "โคกกลาง",
              "EN_NAME" => "Khok Klang"
            ],
            [
              "ID" => 3973,
              "TH_NAME" => "บ้านโคก",
              "EN_NAME" => "Ban Khok"
            ],
            [
              "ID" => 3976,
              "TH_NAME" => "หนองแสง",
              "EN_NAME" => "Nong Saeng"
            ],
            [
              "ID" => 3978,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Di"
            ],
            [
              "ID" => 3980,
              "TH_NAME" => "นายูง",
              "EN_NAME" => "Na Yung"
            ],
            [
              "ID" => 3983,
              "TH_NAME" => "โนนทอง",
              "EN_NAME" => "Non Thong"
            ],
            [
              "ID" => 3984,
              "TH_NAME" => "บ้านแดง",
              "EN_NAME" => "Ban Daeng"
            ],
            [
              "ID" => 3990,
              "TH_NAME" => "คอนสาย",
              "EN_NAME" => "Kon Sai"
            ],
            [
              "ID" => 3995,
              "TH_NAME" => "เมือง",
              "EN_NAME" => "Mueang"
            ],
            [
              "ID" => 3999,
              "TH_NAME" => "เสี้ยว",
              "EN_NAME" => "Sieo"
            ],
            [
              "ID" => 4005,
              "TH_NAME" => "นาแขม",
              "EN_NAME" => "Na Khaem"
            ],
            [
              "ID" => 4013,
              "TH_NAME" => "ธาตุ",
              "EN_NAME" => "That"
            ],
            [
              "ID" => 4015,
              "TH_NAME" => "เขาแก้ว",
              "EN_NAME" => "Khao Kaeo"
            ],
            [
              "ID" => 4018,
              "TH_NAME" => "จอมศรี",
              "EN_NAME" => "Chom Sri"
            ],
            [
              "ID" => 4028,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Di"
            ],
            [
              "ID" => 4029,
              "TH_NAME" => "โคกงาม",
              "EN_NAME" => "Khok Ngam"
            ],
            [
              "ID" => 4030,
              "TH_NAME" => "โพนสูง",
              "EN_NAME" => "Phon Sung"
            ],
            [
              "ID" => 4033,
              "TH_NAME" => "โป่ง",
              "EN_NAME" => "Pong"
            ],
            [
              "ID" => 4048,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 4049,
              "TH_NAME" => "ท่าศาลา",
              "EN_NAME" => "Tha Sala"
            ],
            [
              "ID" => 4054,
              "TH_NAME" => "ท่าลี่",
              "EN_NAME" => "Tha Li"
            ],
            [
              "ID" => 4055,
              "TH_NAME" => "หนองผือ",
              "EN_NAME" => "Nong Puer"
            ],
            [
              "ID" => 4058,
              "TH_NAME" => "โคกใหญ่",
              "EN_NAME" => "Khok Yai"
            ],
            [
              "ID" => 4061,
              "TH_NAME" => "ทรายขาว",
              "EN_NAME" => "Sai Khao"
            ],
            [
              "ID" => 4071,
              "TH_NAME" => "โคกขมิ้น",
              "EN_NAME" => "Khok Khamin"
            ],
          [
              "ID" => 4076,
              "TH_NAME" => "ศรีฐาน",
              "EN_NAME" => "Sri Than"
            ],
            [
              "ID" => 4102,
              "TH_NAME" => "หนองหิน",
              "EN_NAME" => "Nong Hin"
            ],
            [
              "ID" => 4105,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 4107,
              "TH_NAME" => "โพธิ์ชัย",
              "EN_NAME" => "Pho Chai"
            ],
            [
              "ID" => 4113,
              "TH_NAME" => "บ้านเดื่อ",
              "EN_NAME" => "Ban Due"
            ],
            [
              "ID" => 4115,
              "TH_NAME" => "สองห้อง",
              "EN_NAME" => "Song Hong"
            ],
            [
              "ID" => 4121,
              "TH_NAME" => "ปะโค",
              "EN_NAME" => "Pa Ko"
            ],
            [
              "ID" => 4128,
              "TH_NAME" => "บ้านเดื่อ",
              "EN_NAME" => "Ban Due"
            ],
            [
              "ID" => 4131,
              "TH_NAME" => "นาข่า",
              "EN_NAME" => "Na Kha"
            ],
            [
              "ID" => 4136,
              "TH_NAME" => "โนนสมบูรณ์",
              "EN_NAME" => "Non Samboon"
            ],
            [
              "ID" => 4140,
              "TH_NAME" => "โคกก่อง",
              "EN_NAME" => "Khok Kong"
            ],
            [
              "ID" => 4161,
              "TH_NAME" => "วัดหลวง",
              "EN_NAME" => "Wat Luang"
            ],
            [
              "ID" => 4172,
              "TH_NAME" => "บ้านโพธิ์",
              "EN_NAME" => "Ban Pho"
            ],
            [
              "ID" => 4179,
              "TH_NAME" => "บ้านผือ",
              "EN_NAME" => "Ban Puer"
            ],
            [
              "ID" => 4190,
              "TH_NAME" => "บ้านหม้อ",
              "EN_NAME" => "Ban Mo"
            ],
            [
              "ID" => 4191,
              "TH_NAME" => "พระพุทธบาท",
              "EN_NAME" => "Phra Phutthabat"
            ],
            [
              "ID" => 4197,
              "TH_NAME" => "บ้านม่วง",
              "EN_NAME" => "Ban Muang"
            ],
            [
              "ID" => 4198,
              "TH_NAME" => "นางิ้ว",
              "EN_NAME" => "Nangiw"
            ],
            [
              "ID" => 4208,
              "TH_NAME" => "ท่าสะอาด",
              "EN_NAME" => "Tha Sa-at"
            ],
            [
              "ID" => 4221,
              "TH_NAME" => "ดงบัง",
              "EN_NAME" => "Dong Bang"
            ],
            [
              "ID" => 4228,
              "TH_NAME" => "บุ่งคล้า",
              "EN_NAME" => "Bung Kla"
            ],
            [
              "ID" => 4233,
              "TH_NAME" => "บ้านฝาง",
              "EN_NAME" => "Ban Fang"
            ],
            [
              "ID" => 4235,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Di"
            ],
            [
              "ID" => 4236,
              "TH_NAME" => "หนองหลวง",
              "EN_NAME" => "Nong Luang"
            ],
            [
              "ID" => 4243,
              "TH_NAME" => "โพนแพง",
              "EN_NAME" => "Phon Paeng"
            ],
            [
              "ID" => 4245,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phon Thong"
            ],
            [
              "ID" => 4247,
              "TH_NAME" => "ตลาด",
              "EN_NAME" => "Talat"
            ],
            [
              "ID" => 4249,
              "TH_NAME" => "ท่าตูม",
              "EN_NAME" => "Tha Tum"
            ],
            [
              "ID" => 4257,
              "TH_NAME" => "หนองปลิง",
              "EN_NAME" => "Nong Pling"
            ],
            [
              "ID" => 4259,
              "TH_NAME" => "หนองโน",
              "EN_NAME" => "Nong No"
            ],
            [
              "ID" => 4262,
              "TH_NAME" => "วังแสง",
              "EN_NAME" => "Wang Saeng"
            ],
            [
              "ID" => 4263,
              "TH_NAME" => "มิตรภาพ",
              "EN_NAME" => "Mittraphap"
            ],
            [
              "ID" => 4264,
              "TH_NAME" => "หนองกุง",
              "EN_NAME" => "Nong Kung"
            ],
            [
              "ID" => 4268,
              "TH_NAME" => "วังยาว",
              "EN_NAME" => "Wang Yao"
            ],
            [
              "ID" => 4272,
              "TH_NAME" => "หนองเหล็ก",
              "EN_NAME" => "Nong Lek"
            ],
            [
              "ID" => 4273,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 4276,
              "TH_NAME" => "หนองบอน",
              "EN_NAME" => "Nong Bon"
            ],
            [
              "ID" => 4277,
              "TH_NAME" => "โพนงาม",
              "EN_NAME" => "Phon Ngam"
            ],
            [
              "ID" => 4285,
              "TH_NAME" => "มะค่า",
              "EN_NAME" => "Ma Kha"
            ],
            [
              "ID" => 4290,
              "TH_NAME" => "ศรีสุข",
              "EN_NAME" => "Sri Suk"
            ],
            [
              "ID" => 4293,
              "TH_NAME" => "เชียงยืน",
              "EN_NAME" => "Chiang Yun"
            ],
            [
              "ID" => 4303,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phon Thong"
            ],
            [
              "ID" => 4309,
              "TH_NAME" => "หนองม่วง",
              "EN_NAME" => "Nong Muang"
            ],
            [
              "ID" => 4312,
              "TH_NAME" => "โนนแดง",
              "EN_NAME" => "Non Daeng"
            ],
            [
              "ID" => 4314,
              "TH_NAME" => "หนองจิก",
              "EN_NAME" => "Nong Jik"
            ],
            [
              "ID" => 4319,
              "TH_NAME" => "วังใหม่",
              "EN_NAME" => "Wang Mai"
            ],
            [
              "ID" => 4320,
              "TH_NAME" => "ยาง",
              "EN_NAME" => "Yang"
            ],
            [
              "ID" => 4322,
              "TH_NAME" => "หนองสิม",
              "EN_NAME" => "Nong Sim"
            ],
            [
              "ID" => 4323,
              "TH_NAME" => "หนองโก",
              "EN_NAME" => "Nong Ko"
            ],
            [
              "ID" => 4326,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 4327,
              "TH_NAME" => "หนองแดง",
              "EN_NAME" => "Nong Daeng"
            ],
            [
              "ID" => 4328,
              "TH_NAME" => "เขวาไร่",
              "EN_NAME" => "Kha Wai"
            ],
            [
              "ID" => 4331,
              "TH_NAME" => "หนองเม็ก",
              "EN_NAME" => "Nong Mek"
            ],
            [
              "ID" => 4332,
              "TH_NAME" => "หนองเรือ",
              "EN_NAME" => "Nong Rue"
            ],
            [
              "ID" => 4333,
              "TH_NAME" => "หนองกุง",
              "EN_NAME" => "Nong Kung"
            ],
            [
              "ID" => 4351,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 4355,
              "TH_NAME" => "หนองแสง",
              "EN_NAME" => "Nong Saeng"
            ],
            [
              "ID" => 4356,
              "TH_NAME" => "ขามป้อม",
              "EN_NAME" => "Kham Pom"
            ],
            [
              "ID" => 4358,
              "TH_NAME" => "ดงใหญ่",
              "EN_NAME" => "Dong Yai"
            ],
            [
              "ID" => 4359,
              "TH_NAME" => "โพธิ์ชัย",
              "EN_NAME" => "Pho Chai"
            ],
            [
              "ID" => 4360,
              "TH_NAME" => "หัวเรือ",
              "EN_NAME" => "Hua Rue"
            ],
            [
              "ID" => 4361,
              "TH_NAME" => "แคน",
              "EN_NAME" => "Kaen"
            ],
            [
              "ID" => 4363,
              "TH_NAME" => "นาข่า",
              "EN_NAME" => "Na Kha"
            ],
            [
              "ID" => 4365,
              "TH_NAME" => "หนองไฮ",
              "EN_NAME" => "Nong Hai"
            ],
            [
              "ID" => 4367,
              "TH_NAME" => "หนองทุ่ม",
              "EN_NAME" => "Nong Thum"
            ],
            [
              "ID" => 4374,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 4375,
              "TH_NAME" => "หนองคู",
              "EN_NAME" => "Nong Khu"
            ],
            [
              "ID" => 4376,
              "TH_NAME" => "ดงบัง",
              "EN_NAME" => "Dong Bang"
            ],
            [
              "ID" => 4390,
              "TH_NAME" => "นาโพธิ์",
              "EN_NAME" => "Na Pho"
            ],
            [
              "ID" => 4392,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 4393,
              "TH_NAME" => "ห้วยเตย",
              "EN_NAME" => "Huai Toey"
            ],
            [
              "ID" => 4395,
              "TH_NAME" => "กุดปลาดุก",
              "EN_NAME" => "Kud Pla Duk"
            ],
            [
              "ID" => 4397,
              "TH_NAME" => "หนองกุง",
              "EN_NAME" => "Nong Kung"
            ],
            [
              "ID" => 4398,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 4399,
              "TH_NAME" => "รอบเมือง",
              "EN_NAME" => "Rop Mueang"
            ],
            [
              "ID" => 4402,
              "TH_NAME" => "นาโพธิ์",
              "EN_NAME" => "Na Pho"
            ],
            [
              "ID" => 4406,
              "TH_NAME" => "ปอภาร  (ปอพาน)",
              "EN_NAME" => "Po Phar (Po Phan)"
            ],
            [
              "ID" => 4407,
              "TH_NAME" => "โนนรัง",
              "EN_NAME" => "Non Rang"
            ],
            [
              "ID" => 4414,
              "TH_NAME" => "หนองแก้ว",
              "EN_NAME" => "Nong Kaeo"
            ],
            [
              "ID" => 4415,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 4417,
              "TH_NAME" => "ดงลาน",
              "EN_NAME" => "Dong Lan"
            ],
            [
              "ID" => 4433,
              "TH_NAME" => "เมืองบัว",
              "EN_NAME" => "Mueang Bua"
            ],
            [
              "ID" => 4437,
              "TH_NAME" => "บ้านฝาง",
              "EN_NAME" => "Ban Fang"
            ],
            [
              "ID" => 4438,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 4439,
              "TH_NAME" => "กำแพง",
              "EN_NAME" => "Kamphaeng"
            ],
            [
              "ID" => 4441,
              "TH_NAME" => "น้ำอ้อม",
              "EN_NAME" => "Nam Om"
            ],
            [
              "ID" => 4442,
              "TH_NAME" => "โนนสว่าง",
              "EN_NAME" => "Non Sa-wang"
            ],
            [
              "ID" => 4448,
              "TH_NAME" => "โพนสูง",
              "EN_NAME" => "Phon Sung"
            ],
            [
              "ID" => 4449,
              "TH_NAME" => "โนนสวรรค์",
              "EN_NAME" => "Non Sawann"
            ],
            [
              "ID" => 4450,
              "TH_NAME" => "สระบัว",
              "EN_NAME" => "Sra Bua"
            ],
            [
              "ID" => 4452,
              "TH_NAME" => "ขี้เหล็ก",
              "EN_NAME" => "Khi Lek"
            ],
            [
              "ID" => 4453,
              "TH_NAME" => "หัวช้าง",
              "EN_NAME" => "Hua Chang"
            ],
            [
              "ID" => 4454,
              "TH_NAME" => "หนองผือ",
              "EN_NAME" => "Nong Puer"
            ],
            [
              "ID" => 4456,
              "TH_NAME" => "โคกล่าม",
              "EN_NAME" => "Khok Lam"
            ],
            [
              "ID" => 4459,
              "TH_NAME" => "ดงกลาง",
              "EN_NAME" => "Dong Klang"
            ],
            [
              "ID" => 4462,
              "TH_NAME" => "ลิ้นฟ้า",
              "EN_NAME" => "Lin Fa"
            ],
            [
              "ID" => 4467,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 4479,
              "TH_NAME" => "ไพศาล",
              "EN_NAME" => "Phisai"
            ],
            [
              "ID" => 4481,
              "TH_NAME" => "เมืองน้อย",
              "EN_NAME" => "Mueang Noi"
            ],
            [
              "ID" => 4490,
              "TH_NAME" => "แสนสุข",
              "EN_NAME" => "Saen Suk"
            ],
          [
              "ID" => 4491,
              "TH_NAME" => "กุดน้ำใส",
              "EN_NAME" => "Kud Nam Sai"
            ],
            [
              "ID" => 4493,
              "TH_NAME" => "โพธิ์ใหญ่",
              "EN_NAME" => "Pho Yai"
            ],
            [
              "ID" => 4495,
              "TH_NAME" => "โคกสว่าง",
              "EN_NAME" => "Khok Sa-wang"
            ],
            [
              "ID" => 4499,
              "TH_NAME" => "โพธิ์ชัย",
              "EN_NAME" => "Pho Chai"
            ],
            [
              "ID" => 4502,
              "TH_NAME" => "สระแก้ว",
              "EN_NAME" => "Sra Kaeo"
            ],
            [
              "ID" => 4503,
              "TH_NAME" => "ค้อใหญ่",
              "EN_NAME" => "Khao Yai"
            ],
            [
              "ID" => 4509,
              "TH_NAME" => "สว่าง",
              "EN_NAME" => "Sa-wang"
            ],
            [
              "ID" => 4510,
              "TH_NAME" => "หนองใหญ่",
              "EN_NAME" => "Nong Yai"
            ],
            [
              "ID" => 4514,
              "TH_NAME" => "อุ่มเม่า",
              "EN_NAME" => "Um Mao"
            ],
            [
              "ID" => 4515,
              "TH_NAME" => "คำนาดี",
              "EN_NAME" => "Kham Na Di"
            ],
            [
              "ID" => 4519,
              "TH_NAME" => "โคกสูง",
              "EN_NAME" => "Khok Sung"
            ],
            [
              "ID" => 4526,
              "TH_NAME" => "ขามเปี้ย",
              "EN_NAME" => "Kham Pia"
            ],
            [
              "ID" => 4530,
              "TH_NAME" => "สะอาด",
              "EN_NAME" => "Sa-at"
            ],
            [
              "ID" => 4534,
              "TH_NAME" => "โพธิ์ศรี",
              "EN_NAME" => "Pho Sri"
            ],
            [
              "ID" => 4535,
              "TH_NAME" => "หนองพอก",
              "EN_NAME" => "Nong Pok"
            ],
            [
              "ID" => 4537,
              "TH_NAME" => "ภูเขาทอง",
              "EN_NAME" => "Phu Khao Thong"
            ],
            [
              "ID" => 4539,
              "TH_NAME" => "โคกสว่าง",
              "EN_NAME" => "Khok Sa-wang"
            ],
            [
              "ID" => 4541,
              "TH_NAME" => "รอบเมือง",
              "EN_NAME" => "Rop Mueang"
            ],
            [
              "ID" => 4544,
              "TH_NAME" => "กลาง",
              "EN_NAME" => "Klang"
            ],
            [
              "ID" => 4545,
              "TH_NAME" => "นางาม",
              "EN_NAME" => "Na Ngam"
            ],
            [
              "ID" => 4549,
              "TH_NAME" => "วังหลวง",
              "EN_NAME" => "Wang Luang"
            ],
            [
              "ID" => 4550,
              "TH_NAME" => "ท่าม่วง",
              "EN_NAME" => "Tha Muang"
            ],
            [
              "ID" => 4552,
              "TH_NAME" => "โพธิ์ทอง",
              "EN_NAME" => "Pho Thong"
            ],
            [
              "ID" => 4553,
              "TH_NAME" => "ภูเงิน",
              "EN_NAME" => "Phu Ngern"
            ],
            [
              "ID" => 4554,
              "TH_NAME" => "เกาะแก้ว",
              "EN_NAME" => "Ko Kaeo"
            ],
            [
              "ID" => 4555,
              "TH_NAME" => "นาเลิง",
              "EN_NAME" => "Na Leang"
            ],
            [
              "ID" => 4558,
              "TH_NAME" => "หนองหลวง",
              "EN_NAME" => "Nong Luang"
            ],
            [
              "ID" => 4559,
              "TH_NAME" => "พรสวรรค์",
              "EN_NAME" => "Phonsawan"
            ],
            [
              "ID" => 4560,
              "TH_NAME" => "ขวัญเมือง",
              "EN_NAME" => "Khwan Mueang"
            ],
            [
              "ID" => 4563,
              "TH_NAME" => "ดอกไม้",
              "EN_NAME" => "Dok Mai"
            ],
            [
              "ID" => 4569,
              "TH_NAME" => "ทุ่งหลวง",
              "EN_NAME" => "Thung Luang"
            ],
            [
              "ID" => 4570,
              "TH_NAME" => "หัวช้าง",
              "EN_NAME" => "Hua Chang"
            ],
            [
              "ID" => 4571,
              "TH_NAME" => "น้ำคำ",
              "EN_NAME" => "Nam Kham"
            ],
            [
              "ID" => 4574,
              "TH_NAME" => "ทุ่งกุลา",
              "EN_NAME" => "Thung Kula"
            ],
            [
              "ID" => 4577,
              "TH_NAME" => "หนองผือ",
              "EN_NAME" => "Nong Puer"
            ],
            [
              "ID" => 4578,
              "TH_NAME" => "หนองหิน",
              "EN_NAME" => "Nong Hin"
            ],
            [
              "ID" => 4579,
              "TH_NAME" => "คูเมือง",
              "EN_NAME" => "Khu Mueang"
            ],
            [
              "ID" => 4584,
              "TH_NAME" => "ศรีสว่าง",
              "EN_NAME" => "Sri Sa-wang"
            ],
            [
              "ID" => 4585,
              "TH_NAME" => "ยางคำ",
              "EN_NAME" => "Yang Kham"
            ],
            [
              "ID" => 4588,
              "TH_NAME" => "โพนเมือง",
              "EN_NAME" => "Phon Mueang"
            ],
            [
              "ID" => 4592,
              "TH_NAME" => "หนองขาม",
              "EN_NAME" => "Nong Kham"
            ],
            [
              "ID" => 4594,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 4595,
              "TH_NAME" => "ขี้เหล็ก",
              "EN_NAME" => "Khi Lek"
            ],
            [
              "ID" => 4596,
              "TH_NAME" => "บ้านดู่",
              "EN_NAME" => "Ban Du"
            ],
            [
              "ID" => 4601,
              "TH_NAME" => "โพธิ์ทอง",
              "EN_NAME" => "Pho Thong"
            ],
            [
              "ID" => 4604,
              "TH_NAME" => "หนองใหญ่",
              "EN_NAME" => "Nong Yai"
            ],
            [
              "ID" => 4609,
              "TH_NAME" => "ดินดำ",
              "EN_NAME" => "Din Dam"
            ],
            [
              "ID" => 4614,
              "TH_NAME" => "ยางใหญ่",
              "EN_NAME" => "Yang Yai"
            ],
            [
              "ID" => 4618,
              "TH_NAME" => "พลับพลา",
              "EN_NAME" => "Phlap Phla"
            ],
            [
              "ID" => 4619,
              "TH_NAME" => "พระธาตุ",
              "EN_NAME" => "Phra That"
            ],
            [
              "ID" => 4621,
              "TH_NAME" => "หมูม้น",
              "EN_NAME" => "Mu Mon"
            ],
            [
              "ID" => 4629,
              "TH_NAME" => "บึงงาม",
              "EN_NAME" => "Bueng Ngam"
            ],
            [
              "ID" => 4631,
              "TH_NAME" => "เหล่า",
              "EN_NAME" => "Lao"
            ],
            [
              "ID" => 4635,
              "TH_NAME" => "ไผ่",
              "EN_NAME" => "Phai"
            ],
            [
              "ID" => 4646,
              "TH_NAME" => "หนองกุง",
              "EN_NAME" => "Nong Kung"
            ],
            [
              "ID" => 4650,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phon Thong"
            ],
            [
              "ID" => 4660,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 4663,
              "TH_NAME" => "โพนงาม",
              "EN_NAME" => "Phon Ngam"
            ],
            [
              "ID" => 4668,
              "TH_NAME" => "หนองแปน",
              "EN_NAME" => "Nong Paen"
            ],
            [
              "ID" => 4675,
              "TH_NAME" => "สามัคคี",
              "EN_NAME" => "Samakkhi"
            ],
            [
              "ID" => 4683,
              "TH_NAME" => "สามขา",
              "EN_NAME" => "Sam Kha"
            ],
            [
              "ID" => 4685,
              "TH_NAME" => "หนองห้าง",
              "EN_NAME" => "Nong Hang"
            ],
            [
              "ID" => 4687,
              "TH_NAME" => "สมสะอาด",
              "EN_NAME" => "Som Sa-at"
            ],
            [
              "ID" => 4690,
              "TH_NAME" => "สงเปลือย",
              "EN_NAME" => "Song Pluer"
            ],
            [
              "ID" => 4691,
              "TH_NAME" => "หนองผือ",
              "EN_NAME" => "Nong Puer"
            ],
            [
              "ID" => 4701,
              "TH_NAME" => "หัวงัว",
              "EN_NAME" => "Hua Ngau"
            ],
            [
              "ID" => 4702,
              "TH_NAME" => "อุ่มเม่า",
              "EN_NAME" => "Um Mao"
            ],
            [
              "ID" => 4706,
              "TH_NAME" => "หัวนาคำ",
              "EN_NAME" => "Hua Na Kham"
            ],
            [
              "ID" => 4709,
              "TH_NAME" => "นาเชือก",
              "EN_NAME" => "Na Cheuak"
            ],
            [
              "ID" => 4712,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Di"
            ],
            [
              "ID" => 4713,
              "TH_NAME" => "โนนสูง",
              "EN_NAME" => "Non Sung"
            ],
            [
              "ID" => 4722,
              "TH_NAME" => "โนนสะอาด",
              "EN_NAME" => "Non Sa-at"
            ],
            [
              "ID" => 4723,
              "TH_NAME" => "ทรายทอง",
              "EN_NAME" => "Sai Thong"
            ],
            [
              "ID" => 4727,
              "TH_NAME" => "โนนศิลา",
              "EN_NAME" => "Non Sila"
            ],
            [
              "ID" => 4728,
              "TH_NAME" => "นิคม",
              "EN_NAME" => "Nikhom"
            ],
            [
              "ID" => 4749,
              "TH_NAME" => "กุดจิก",
              "EN_NAME" => "Kud Jik"
            ],
            [
              "ID" => 4750,
              "TH_NAME" => "นาตาล",
              "EN_NAME" => "Na Tal"
            ],
            [
              "ID" => 4754,
              "TH_NAME" => "หนองกุงศรี",
              "EN_NAME" => "Nong Kung Sri"
            ],
            [
              "ID" => 4755,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 4757,
              "TH_NAME" => "หนองสรวง",
              "EN_NAME" => "Nong Suang"
            ],
            [
              "ID" => 4759,
              "TH_NAME" => "หนองใหญ่",
              "EN_NAME" => "Nong Yai"
            ],
            [
              "ID" => 4762,
              "TH_NAME" => "หนองหิน",
              "EN_NAME" => "Nong Hin"
            ],
            [
              "ID" => 4764,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 4767,
              "TH_NAME" => "หมูม่น",
              "EN_NAME" => "Mu Mon"
            ],
            [
              "ID" => 4769,
              "TH_NAME" => "ศรีสมเด็จ",
              "EN_NAME" => "Sri Samdet"
            ],
            [
              "ID" => 4771,
              "TH_NAME" => "คำบง",
              "EN_NAME" => "Kham Bong"
            ],
            [
              "ID" => 4775,
              "TH_NAME" => "สำราญ",
              "EN_NAME" => "Samran"
            ],
            [
              "ID" => 4779,
              "TH_NAME" => "นาคู",
              "EN_NAME" => "Na Khu"
            ],
            [
              "ID" => 4782,
              "TH_NAME" => "บ่อแก้ว",
              "EN_NAME" => "Bo Kaeo"
            ],
            [
              "ID" => 4791,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 4795,
              "TH_NAME" => "ขมิ้น",
              "EN_NAME" => "Khamin"
            ],
            [
              "ID" => 4797,
              "TH_NAME" => "โนนหอม",
              "EN_NAME" => "Non Hom"
            ],
            [
              "ID" => 4799,
              "TH_NAME" => "เชียงเครือ",
              "EN_NAME" => "Chiang Kher"
            ],
            [
              "ID" => 4805,
              "TH_NAME" => "ห้วยยาง",
              "EN_NAME" => "Huai Yang"
            ],
            [
              "ID" => 4808,
              "TH_NAME" => "ดงมะไฟ",
              "EN_NAME" => "Dong Ma Fai"
            ],
            [
              "ID" => 4814,
              "TH_NAME" => "โคกก่อง",
              "EN_NAME" => "Khok Kong"
            ],
            [
              "ID" => 4822,
              "TH_NAME" => "นาโพธิ์",
              "EN_NAME" => "Na Pho"
            ],
            [
              "ID" => 4823,
              "TH_NAME" => "นาเพียง",
              "EN_NAME" => "Na Phiang"
            ],
            [
              "ID" => 4825,
              "TH_NAME" => "อุ่มจาน",
              "EN_NAME" => "Um Jan"
            ],
            [
              "ID" => 4839,
              "TH_NAME" => "สว่าง",
              "EN_NAME" => "Sa-wang"
            ],
          [
                  "ID" => 4851,
                  "TH_NAME" => "หนองลาด",
                  "EN_NAME" => "Nong Lad"
              ],
              [
                  "ID" => 4855,
                  "TH_NAME" => "หนองปลิง",
                  "EN_NAME" => "Nong Pling"
              ],
              [
                  "ID" => 4856,
                  "TH_NAME" => "หนองบัว",
                  "EN_NAME" => "Nong Bua"
              ],
              [
                  "ID" => 4863,
                  "TH_NAME" => "ธาตุ",
                  "EN_NAME" => "That"
              ],
              [
                  "ID" => 4864,
                  "TH_NAME" => "หนองแวง",
                  "EN_NAME" => "Nong Waeng"
              ],
              [
                  "ID" => 4868,
                  "TH_NAME" => "นาคำ",
                  "EN_NAME" => "Na Kham"
              ],
              [
                  "ID" => 4869,
                  "TH_NAME" => "คอนสวรรค์",
                  "EN_NAME" => "Kon Sawann"
              ],
              [
                  "ID" => 4874,
                  "TH_NAME" => "นาแต้",
                  "EN_NAME" => "Na Tae"
              ],
              [
                  "ID" => 4876,
                  "TH_NAME" => "ม่วง",
                  "EN_NAME" => "Muang"
              ],
              [
                  "ID" => 4882,
                  "TH_NAME" => "โนนสะอาด",
                  "EN_NAME" => "Non Sa-at"
              ],
              [
                  "ID" => 4884,
                  "TH_NAME" => "บ่อแก้ว",
                  "EN_NAME" => "Bo Kaew"
              ],
              [
                  "ID" => 4886,
                  "TH_NAME" => "โพนแพง",
                  "EN_NAME" => "Phom Paeng"
              ],
              [
                  "ID" => 4888,
                  "TH_NAME" => "โพนงาม",
                  "EN_NAME" => "Phom Ngam"
              ],
              [
                  "ID" => 4899,
                  "TH_NAME" => "โพนสูง",
                  "EN_NAME" => "Phom Sung"
              ],
              [
                  "ID" => 4900,
                  "TH_NAME" => "โคกสี",
                  "EN_NAME" => "Khok Si"
              ],
              [
                  "ID" => 4902,
                  "TH_NAME" => "หนองหลวง",
                  "EN_NAME" => "Nong Luang"
              ],
              [
                  "ID" => 4906,
                  "TH_NAME" => "แวง",
                  "EN_NAME" => "Waeng"
              ],
              [
                  "ID" => 4907,
                  "TH_NAME" => "ทรายมูล",
                  "EN_NAME" => "Sai Moon"
              ],
              [
                  "ID" => 4912,
                  "TH_NAME" => "ธาตุทอง",
                  "EN_NAME" => "That Thong"
              ],
              [
                  "ID" => 4913,
                  "TH_NAME" => "บ้านถ่อน",
                  "EN_NAME" => "Ban Thon"
              ],
              [
                  "ID" => 4920,
                  "TH_NAME" => "นาตาล",
                  "EN_NAME" => "Na Tal"
              ],
              [
                  "ID" => 4926,
                  "TH_NAME" => "บ้านเหล่า",
                  "EN_NAME" => "Ban Lao"
              ],
              [
                  "ID" => 4930,
                  "TH_NAME" => "หนองแปน",
                  "EN_NAME" => "Nong Paen"
              ],
              [
                  "ID" => 4940,
                  "TH_NAME" => "ในเมือง",
                  "EN_NAME" => "Nai Mueang"
              ],
              [
                  "ID" => 4941,
                  "TH_NAME" => "หนองแสง",
                  "EN_NAME" => "Nong Saeng"
              ],
              [
                  "ID" => 4942,
                  "TH_NAME" => "นาทราย",
                  "EN_NAME" => "Na Sai"
              ],
              [
                  "ID" => 4946,
                  "TH_NAME" => "อาจสามารถ",
                  "EN_NAME" => "Aat Sa-maarn"
              ],
              [
                  "ID" => 4947,
                  "TH_NAME" => "ขามเฒ่า",
                  "EN_NAME" => "Kham Tao"
              ],
              [
                  "ID" => 4948,
                  "TH_NAME" => "บ้านกลาง",
                  "EN_NAME" => "Ban Klang"
              ],
              [
                  "ID" => 4950,
                  "TH_NAME" => "คำเตย",
                  "EN_NAME" => "Kham Toey"
              ],
              [
                  "ID" => 4954,
                  "TH_NAME" => "โพธิ์ตาก",
                  "EN_NAME" => "Pho Teak"
              ],
              [
                  "ID" => 4956,
                  "TH_NAME" => "หนองฮี",
                  "EN_NAME" => "Nong Hee"
              ],
              [
                  "ID" => 4958,
                  "TH_NAME" => "โคกสว่าง",
                  "EN_NAME" => "Khok Sa-wang"
              ],
              [
                  "ID" => 4959,
                  "TH_NAME" => "โคกสูง",
                  "EN_NAME" => "Khok Sung"
              ],
              [
                  "ID" => 4961,
                  "TH_NAME" => "นามะเขือ",
                  "EN_NAME" => "Na Makhue"
              ],
              [
                  "ID" => 4964,
                  "TH_NAME" => "โนนตาล",
                  "EN_NAME" => "Non Tal"
              ],
              [
                  "ID" => 4978,
                  "TH_NAME" => "ไผ่ล้อม",
                  "EN_NAME" => "Pai Lom"
              ],
              [
                  "ID" => 4979,
                  "TH_NAME" => "โพนทอง",
                  "EN_NAME" => "Phom Thong"
              ],
              [
                  "ID" => 4980,
                  "TH_NAME" => "หนองแวง",
                  "EN_NAME" => "Nong Waeng"
              ],
              [
                  "ID" => 4984,
                  "TH_NAME" => "นางัว",
                  "EN_NAME" => "Na Ngoua"
              ],
              [
                  "ID" => 4987,
                  "TH_NAME" => "ฝั่งแดง",
                  "EN_NAME" => "Fang Daeng"
              ],
              [
                  "ID" => 4988,
                  "TH_NAME" => "โพนแพง",
                  "EN_NAME" => "Phom Paeng"
              ],
              [
                  "ID" => 4999,
                  "TH_NAME" => "โพนทอง",
                  "EN_NAME" => "Phom Thong"
              ],
              [
                  "ID" => 5000,
                  "TH_NAME" => "ท่าลาด",
                  "EN_NAME" => "Tha Lad"
              ],
              [
                  "ID" => 5001,
                  "TH_NAME" => "นางาม",
                  "EN_NAME" => "Na Ngam"
              ],
              [
                  "ID" => 5006,
                  "TH_NAME" => "นาขาม",
                  "EN_NAME" => "Na Kham"
              ],
              [
                  "ID" => 5007,
                  "TH_NAME" => "นาแก",
                  "EN_NAME" => "Na Kae"
              ],
              [
                  "ID" => 5009,
                  "TH_NAME" => "หนองสังข์",
                  "EN_NAME" => "Nong Sank"
              ],
              [
                  "ID" => 5010,
                  "TH_NAME" => "นาคู่",
                  "EN_NAME" => "Na Khu"
              ],
              [
                  "ID" => 5013,
                  "TH_NAME" => "ก้านเหลือง",
                  "EN_NAME" => "Kan Lueang"
              ],
              [
                  "ID" => 5014,
                  "TH_NAME" => "หนองบ่อ",
                  "EN_NAME" => "Nong Bo"
              ],
              [
                  "ID" => 5018,
                  "TH_NAME" => "บ้านแก้ง",
                  "EN_NAME" => "Ban Kaeng"
              ],
              [
                  "ID" => 5021,
                  "TH_NAME" => "สีชมพู",
                  "EN_NAME" => "Si Chom Phu"
              ],
              [
                  "ID" => 5023,
                  "TH_NAME" => "ศรีสงคราม",
                  "EN_NAME" => "Si Songkhram"
              ],
              [
                  "ID" => 5029,
                  "TH_NAME" => "นาคำ",
                  "EN_NAME" => "Na Kham"
              ],
              [
                  "ID" => 5032,
                  "TH_NAME" => "นาหว้า",
                  "EN_NAME" => "Na Wa"
              ],
              [
                  "ID" => 5033,
                  "TH_NAME" => "นางัว",
                  "EN_NAME" => "Na Ngoua"
              ],
              [
                  "ID" => 5037,
                  "TH_NAME" => "ท่าเรือ",
                  "EN_NAME" => "Tha Rue"
              ],
              [
                  "ID" => 5039,
                  "TH_NAME" => "นาหัวบ่อ",
                  "EN_NAME" => "Na Hua Bo"
              ],
              [
                  "ID" => 5042,
                  "TH_NAME" => "บ้านค้อ",
                  "EN_NAME" => "Ban Kho"
              ],
              [
                  "ID" => 5044,
                  "TH_NAME" => "นาใน",
                  "EN_NAME" => "Na Nai"
              ],
              [
                  "ID" => 5045,
                  "TH_NAME" => "นาทม",
                  "EN_NAME" => "Na Thom"
              ],
              [
                  "ID" => 5048,
                  "TH_NAME" => "วังยาง",
                  "EN_NAME" => "Wang Yang"
              ],
              [
                  "ID" => 5049,
                  "TH_NAME" => "โคกสี",
                  "EN_NAME" => "Khok Si"
              ],
              [
                  "ID" => 5051,
                  "TH_NAME" => "หนองโพธิ์",
                  "EN_NAME" => "Nong Pho"
              ],
              [
                  "ID" => 5053,
                  "TH_NAME" => "ศรีบุญเรือง",
                  "EN_NAME" => "Si Bun Rueang"
              ],
              [
                  "ID" => 5054,
                  "TH_NAME" => "บ้านโคก",
                  "EN_NAME" => "Ban Khok"
              ],
              [
                  "ID" => 5056,
                  "TH_NAME" => "โพนทราย",
                  "EN_NAME" => "Phom Sai"
              ],
              [
                  "ID" => 5059,
                  "TH_NAME" => "นาสีนวน",
                  "EN_NAME" => "Na Si Nuann"
              ],
              [
                  "ID" => 5062,
                  "TH_NAME" => "ดงเย็น",
                  "EN_NAME" => "Dong Yen"
              ],
              [
                  "ID" => 5072,
                  "TH_NAME" => "นากอก",
                  "EN_NAME" => "Na Kok"
              ],
              [
                  "ID" => 5073,
                  "TH_NAME" => "หนองแวง",
                  "EN_NAME" => "Nong Waeng"
              ],
              [
                  "ID" => 5075,
                  "TH_NAME" => "นาอุดม",
                  "EN_NAME" => "Na Udom"
              ],
              [
                  "ID" => 5076,
                  "TH_NAME" => "โชคชัย",
                  "EN_NAME" => "Chok Chai"
              ],
              [
                  "ID" => 5079,
                  "TH_NAME" => "โพธิ์ไทร",
                  "EN_NAME" => "Pho Sai"
              ],
              [
                  "ID" => 5080,
                  "TH_NAME" => "ป่าไร่",
                  "EN_NAME" => "Pa Rai"
              ],
              [
                  "ID" => 5082,
                  "TH_NAME" => "บ้านบาก",
                  "EN_NAME" => "Ban Bak"
              ],
              [
                  "ID" => 5084,
                  "TH_NAME" => "บ้านแก้ง",
                  "EN_NAME" => "Ban Kaeng"
              ],
              [
                  "ID" => 5086,
                  "TH_NAME" => "หนองบัว",
                  "EN_NAME" => "Nong Bua"
              ],
              [
                  "ID" => 5088,
                  "TH_NAME" => "หนองแคน",
                  "EN_NAME" => "Nong Kaen"
              ],
              [
                  "ID" => 5096,
                  "TH_NAME" => "บ้านค้อ",
                  "EN_NAME" => "Ban Kho"
              ],
              [
                  "ID" => 5097,
                  "TH_NAME" => "บ้านเหล่า",
                  "EN_NAME" => "Ban Lao"
              ],
              [
                  "ID" => 5098,
                  "TH_NAME" => "โพนงาม",
                  "EN_NAME" => "Phom Ngam"
              ],
              [
                  "ID" => 5116,
                  "TH_NAME" => "บ้านเป้า",
                  "EN_NAME" => "Ban Pao"
              ],
              [
                  "ID" => 5119,
                  "TH_NAME" => "ศรีภูมิ",
                  "EN_NAME" => "Si Phumi"
              ],
              [
                  "ID" => 5125,
                  "TH_NAME" => "ช้างเผือก",
                  "EN_NAME" => "Chang Phueak"
              ],
              [
                  "ID" => 5129,
                  "TH_NAME" => "หนองหอย",
                  "EN_NAME" => "Nong Hoi"
              ],
              [
                  "ID" => 5130,
                  "TH_NAME" => "ท่าศาลา",
                  "EN_NAME" => "Tha Sala"
              ],
              [
                  "ID" => 5137,
                  "TH_NAME" => "บ้านหลวง",
                  "EN_NAME" => "Ban Luang"
              ],
              [
                  "ID" => 5168,
                  "TH_NAME" => "ตลาดขวัญ",
                  "EN_NAME" => "Talat Khwan"
              ],
              [
                  "ID" => 5169,
                  "TH_NAME" => "สำราญราษฎร์",
                  "EN_NAME" => "Samran Ratsada"
              ],
              [
                  "ID" => 5178,
                  "TH_NAME" => "ขี้เหล็ก",
                  "EN_NAME" => "Khie Lek"
              ],
              [
                  "ID" => 5182,
                  "TH_NAME" => "บ้านเป้า",
                  "EN_NAME" => "Ban Pao"
              ],
              [
                  "ID" => 5186,
                  "TH_NAME" => "บ้านช้าง",
                  "EN_NAME" => "Ban Chang"
              ],
              [
                  "ID" => 5193,
                  "TH_NAME" => "ขี้เหล็ก",
                  "EN_NAME" => "Khie Lek"
              ],
              [
                  "ID" => 5195,
                  "TH_NAME" => "ห้วยทราย",
                  "EN_NAME" => "Huai Sai"
              ],
              [
                  "ID" => 5204,
                  "TH_NAME" => "บ่อแก้ว",
                  "EN_NAME" => "Bo Kaew"
              ],
              [
                  "ID" => 5217,
                  "TH_NAME" => "โป่งน้ำร้อน",
                  "EN_NAME" => "Pong Nam Ron"
              ],
              [
                  "ID" => 5228,
                  "TH_NAME" => "บ้านหลวง",
                  "EN_NAME" => "Ban Luang"
              ],
              [
                  "ID" => 5230,
                  "TH_NAME" => "เวียง",
                  "EN_NAME" => "Wiang"
              ],
          [
                  "ID" => 5231,
                  "TH_NAME" => "ทุ่งหลวง",
                  "EN_NAME" => "Thung Luang"
              ],
              [
                  "ID" => 5234,
                  "TH_NAME" => "สันทราย",
                  "EN_NAME" => "San Sai"
              ],
              [
                  "ID" => 5247,
                  "TH_NAME" => "บ้านกลาง",
                  "EN_NAME" => "Ban Klang"
              ],
              [
                  "ID" => 5257,
                  "TH_NAME" => "ทรายมูล",
                  "EN_NAME" => "Sai Moon"
              ],
              [
                  "ID" => 5266,
                  "TH_NAME" => "ห้วยทราย",
                  "EN_NAME" => "Huai Sai"
              ],
              [
                  "ID" => 5268,
                  "TH_NAME" => "สันกลาง",
                  "EN_NAME" => "San Klang"
              ],
              [
                  "ID" => 5288,
                  "TH_NAME" => "หนองแก๋ว",
                  "EN_NAME" => "Nong Kaew"
              ],
              [
                  "ID" => 5297,
                  "TH_NAME" => "น้ำแพร่",
                  "EN_NAME" => "Nam Phrae"
              ],
              [
                  "ID" => 5298,
                  "TH_NAME" => "หางดง",
                  "EN_NAME" => "Hang Dong"
              ],
              [
                  "ID" => 5300,
                  "TH_NAME" => "บ้านตาล",
                  "EN_NAME" => "Ban Tal"
              ],
              [
                  "ID" => 5317,
                  "TH_NAME" => "สารภี",
                  "EN_NAME" => "Saraphi"
              ],
              [
                  "ID" => 5324,
                  "TH_NAME" => "ดอนแก้ว",
                  "EN_NAME" => "Don Kaew"
              ],
              [
                  "ID" => 5326,
                  "TH_NAME" => "สันทราย",
                  "EN_NAME" => "San Sai"
              ],
              [
                  "ID" => 5334,
                  "TH_NAME" => "หนองบัว",
                  "EN_NAME" => "Nong Bua"
              ],
              [
                  "ID" => 5350,
                  "TH_NAME" => "ในเมือง",
                  "EN_NAME" => "Nai Mueang"
              ],
              [
                  "ID" => 5357,
                  "TH_NAME" => "บ้านแป้น",
                  "EN_NAME" => "Ban Paen"
              ],
              [
                  "ID" => 5361,
                  "TH_NAME" => "บ้านกลาง",
                  "EN_NAME" => "Ban Klang"
              ],
              [
                  "ID" => 5381,
                  "TH_NAME" => "แม่ตืน",
                  "EN_NAME" => "Mae Teun"
              ],
              [
                  "ID" => 5382,
                  "TH_NAME" => "นาทราย",
                  "EN_NAME" => "Na Sai"
              ],
              [
                  "ID" => 5387,
                  "TH_NAME" => "ป่าไผ่",
                  "EN_NAME" => "Pa Phi"
              ],
              [
                  "ID" => 5388,
                  "TH_NAME" => "ศรีวิชัย",
                  "EN_NAME" => "Si Wichai"
              ],
              [
                  "ID" => 5411,
                  "TH_NAME" => "เวียงเหนือ",
                  "EN_NAME" => "Wiang Nuea"
              ],
              [
                  "ID" => 5412,
                  "TH_NAME" => "หัวเวียง",
                  "EN_NAME" => "Hua Wiang"
              ],
              [
                  "ID" => 5419,
                  "TH_NAME" => "บ้านแลง",
                  "EN_NAME" => "Ban Laeng"
              ],
              [
                  "ID" => 5424,
                  "TH_NAME" => "บ้านเป้า",
                  "EN_NAME" => "Ban Pao"
              ],
              [
                  "ID" => 5428,
                  "TH_NAME" => "นิคมพัฒนา",
                  "EN_NAME" => "Nikhom Phatthana"
              ],
              [
                  "ID" => 5432,
                  "TH_NAME" => "บ้านดง",
                  "EN_NAME" => "Ban Dong"
              ],
              [
                  "ID" => 5438,
                  "TH_NAME" => "นาแก้ว",
                  "EN_NAME" => "Na Kaew"
              ],
              [
                  "ID" => 5443,
                  "TH_NAME" => "นาแส่ง",
                  "EN_NAME" => "Na Saeng"
              ],
              [
                  "ID" => 5444,
                  "TH_NAME" => "ท่าผา",
                  "EN_NAME" => "Tha Pha"
              ],
              [
                  "ID" => 5452,
                  "TH_NAME" => "บ้านโป่ง",
                  "EN_NAME" => "Ban Pong"
              ],
              [
                  "ID" => 5455,
                  "TH_NAME" => "นาแก",
                  "EN_NAME" => "Na Kae"
              ],
              [
                  "ID" => 5472,
                  "TH_NAME" => "วังเหนือ",
                  "EN_NAME" => "Wang Nuea"
              ],
              [
                  "ID" => 5475,
                  "TH_NAME" => "วังทอง",
                  "EN_NAME" => "Wang Thong"
              ],
              [
                  "ID" => 5484,
                  "TH_NAME" => "นาโป่ง",
                  "EN_NAME" => "Na Pong"
              ],
              [
                  "ID" => 5493,
                  "TH_NAME" => "ป่าตัน",
                  "EN_NAME" => "Pa Tan"
              ],
              [
                  "ID" => 5498,
                  "TH_NAME" => "หัวเสือ",
                  "EN_NAME" => "Hua Seu"
              ],
              [
                  "ID" => 5517,
                  "TH_NAME" => "หัวเมือง",
                  "EN_NAME" => "Hua Mueang"
              ],
              [
                  "ID" => 5518,
                  "TH_NAME" => "ท่าอิฐ",
                  "EN_NAME" => "Tha It"
              ],
              [
                  "ID" => 5520,
                  "TH_NAME" => "บ้านเกาะ",
                  "EN_NAME" => "Ban Ko"
              ],
              [
                  "ID" => 5526,
                  "TH_NAME" => "งิ้วงาม",
                  "EN_NAME" => "Ngiw Ngam"
              ],
              [
                  "ID" => 5528,
                  "TH_NAME" => "บ้านด่าน",
                  "EN_NAME" => "Ban Dan"
              ],
              [
                  "ID" => 5536,
                  "TH_NAME" => "วังแดง",
                  "EN_NAME" => "Wang Daeng"
              ],
              [
                  "ID" => 5537,
                  "TH_NAME" => "บ้านแก่ง",
                  "EN_NAME" => "Ban Kaeng"
              ],
              [
                  "ID" => 5553,
                  "TH_NAME" => "แสนตอ",
                  "EN_NAME" => "Saen To"
              ],
              [
                  "ID" => 5560,
                  "TH_NAME" => "สองคอน",
                  "EN_NAME" => "Song Kon"
              ],
              [
                  "ID" => 5561,
                  "TH_NAME" => "บ้านเสี้ยว",
                  "EN_NAME" => "Ban Sieo"
              ],
              [
                  "ID" => 5562,
                  "TH_NAME" => "สองห้อง",
                  "EN_NAME" => "Song Hong"
              ],
              [
                  "ID" => 5564,
                  "TH_NAME" => "บ้านโคก",
                  "EN_NAME" => "Ban Khok"
              ],
              [
                  "ID" => 5567,
                  "TH_NAME" => "ในเมือง",
                  "EN_NAME" => "Nai Mueang"
              ],
              [
                  "ID" => 5572,
                  "TH_NAME" => "บ้านหม้อ",
                  "EN_NAME" => "Ban Mo"
              ],
              [
                  "ID" => 5577,
                  "TH_NAME" => "นายาง",
                  "EN_NAME" => "Na Yang"
              ],
              [
                  "ID" => 5583,
                  "TH_NAME" => "ไผ่ล้อม",
                  "EN_NAME" => "Pai Lom"
              ],
              [
                  "ID" => 5588,
                  "TH_NAME" => "บ่อทอง",
                  "EN_NAME" => "Bo Thong"
              ],
              [
                  "ID" => 5601,
                  "TH_NAME" => "บ้านถิ่น",
                  "EN_NAME" => "Ban Thin"
              ],
              [
                  "ID" => 5605,
                  "TH_NAME" => "ทุ่งกวาว",
                  "EN_NAME" => "Thung Khao"
              ],
              [
                  "ID" => 5606,
                  "TH_NAME" => "ท่าข้าม",
                  "EN_NAME" => "Tha Kham"
              ],
              [
                  "ID" => 5633,
                  "TH_NAME" => "หัวทุ่ง",
                  "EN_NAME" => "Hua Thung"
              ],
              [
                  "ID" => 5638,
                  "TH_NAME" => "น้ำชำ",
                  "EN_NAME" => "Nam Cham"
              ],
              [
                  "ID" => 5639,
                  "TH_NAME" => "หัวฝาย",
                  "EN_NAME" => "Hua Fai"
              ],
              [
                  "ID" => 5641,
                  "TH_NAME" => "บ้านเหล่า",
                  "EN_NAME" => "Ban Lao"
              ],
              [
                  "ID" => 5643,
                  "TH_NAME" => "บ้านปง",
                  "EN_NAME" => "Ban Pong"
              ],
              [
                  "ID" => 5652,
                  "TH_NAME" => "ห้วยไร่",
                  "EN_NAME" => "Huai Rai"
              ],
              [
                  "ID" => 5655,
                  "TH_NAME" => "บ้านกลาง",
                  "EN_NAME" => "Ban Klang"
              ],
              [
                  "ID" => 5657,
                  "TH_NAME" => "เตาปูน",
                  "EN_NAME" => "Tao Poon"
              ],
              [
                  "ID" => 5658,
                  "TH_NAME" => "หัวเมือง",
                  "EN_NAME" => "Hua Mueang"
              ],
              [
                  "ID" => 5667,
                  "TH_NAME" => "ป่าสัก",
                  "EN_NAME" => "Pa Sak"
              ],
              [
                  "ID" => 5669,
                  "TH_NAME" => "แม่คำมี",
                  "EN_NAME" => "Mae Kham Mee"
              ],
              [
                  "ID" => 5672,
                  "TH_NAME" => "วังหลวง",
                  "EN_NAME" => "Wang Luang"
              ],
              [
                  "ID" => 5675,
                  "TH_NAME" => "ในเวียง",
                  "EN_NAME" => "Nai Wiang"
              ],
              [
                  "ID" => 5676,
                  "TH_NAME" => "บ่อ",
                  "EN_NAME" => "Bo"
              ],
              [
                  "ID" => 5678,
                  "TH_NAME" => "ไชยสถาน",
                  "EN_NAME" => "Chai Sathan"
              ],
              [
                  "ID" => 5681,
                  "TH_NAME" => "นาซาว",
                  "EN_NAME" => "Na Sao"
              ],
              [
                  "ID" => 5698,
                  "TH_NAME" => "หนองแดง",
                  "EN_NAME" => "Nong Daeng"
              ],
              [
                  "ID" => 5712,
                  "TH_NAME" => "บัวใหญ่",
                  "EN_NAME" => "Bua Yai"
              ],
              [
                  "ID" => 5716,
                  "TH_NAME" => "สถาน",
                  "EN_NAME" => "Sathan"
              ],
              [
                  "ID" => 5733,
                  "TH_NAME" => "ศรีภูมิ",
                  "EN_NAME" => "Si Phumi"
              ],
              [
                  "ID" => 5734,
                  "TH_NAME" => "จอมพระ",
                  "EN_NAME" => "Jom Phra"
              ],
              [
                  "ID" => 5741,
                  "TH_NAME" => "ตาลชุม",
                  "EN_NAME" => "Tal Chum"
              ],
              [
                  "ID" => 5753,
                  "TH_NAME" => "แม่สา",
                  "EN_NAME" => "Mae Sa"
              ],
              [
                  "ID" => 5764,
                  "TH_NAME" => "เชียงคาน",
                  "EN_NAME" => "Chiang Khan"
              ],
              [
                  "ID" => 5765,
                  "TH_NAME" => "พระธาตุ",
                  "EN_NAME" => "Phra That"
              ],
              [
                  "ID" => 5770,
                  "TH_NAME" => "พระพุทธบาท",
                  "EN_NAME" => "Phra Phutthabat"
              ],
              [
                  "ID" => 5774,
                  "TH_NAME" => "บ่อแก้ว",
                  "EN_NAME" => "Bo Kaew"
              ],
              [
                  "ID" => 5797,
                  "TH_NAME" => "เวียง",
                  "EN_NAME" => "Wiang"
              ],
              [
                  "ID" => 5806,
                  "TH_NAME" => "แม่กา",
                  "EN_NAME" => "Mae Ka"
              ],
              [
                  "ID" => 5807,
                  "TH_NAME" => "บ้านใหม่",
                  "EN_NAME" => "Ban Mai"
              ],
              [
                  "ID" => 5819,
                  "TH_NAME" => "ทุ่งรวงทอง",
                  "EN_NAME" => "Thung Ruang Thong"
              ],
              [
                  "ID" => 5828,
                  "TH_NAME" => "เวียง",
                  "EN_NAME" => "Wiang"
              ],
              [
                  "ID" => 5843,
                  "TH_NAME" => "บ้านปิน",
                  "EN_NAME" => "Ban Pin"
              ],
              [
                  "ID" => 5846,
                  "TH_NAME" => "ป่าซาง",
                  "EN_NAME" => "Pa Sang"
              ],
              [
                  "ID" => 5847,
                  "TH_NAME" => "หนองหล่ม",
                  "EN_NAME" => "Nong Lom"
              ],
              [
                  "ID" => 5861,
                  "TH_NAME" => "แม่สุก",
                  "EN_NAME" => "Mae Suk"
              ],
              [
                  "ID" => 5862,
                  "TH_NAME" => "ป่าแฝก",
                  "EN_NAME" => "Pa Faek"
              ],
              [
                  "ID" => 5863,
                  "TH_NAME" => "บ้านเหล่า",
                  "EN_NAME" => "Ban Lao"
              ],
              [
                  "ID" => 5866,
                  "TH_NAME" => "ป่าสัก",
                  "EN_NAME" => "Pa Sak"
              ],
              [
                  "ID" => 5870,
                  "TH_NAME" => "ห้วยแก้ว",
                  "EN_NAME" => "Huai Kaew"
              ],
              [
                  "ID" => 5873,
                  "TH_NAME" => "เวียง",
                  "EN_NAME" => "Wiang"
              ],
              [
                  "ID" => 5875,
                  "TH_NAME" => "บ้านดู่",
                  "EN_NAME" => "Ban Du"
              ],
              [
                  "ID" => 5879,
                  "TH_NAME" => "สันทราย",
                  "EN_NAME" => "San Sai"
              ]
          
          ];
          
          
          $setTwos = [
            [
              "ID" => 155,
              "TH_NAME" => "บางจาก",
              "EN_NAME" => "Bang Chak"
            ],
            [
              "ID" => 197,
              "TH_NAME" => "สวนหลวง",
              "EN_NAME" => "Suan Luang"
            ],
            [
              "ID" => 211,
              "TH_NAME" => "คลองเตยเหนือ",
              "EN_NAME" => "Khlong Toei Nuea"
            ],
            [
              "ID" => 212,
              "TH_NAME" => "คลองตันเหนือ",
              "EN_NAME" => "Khlong Tan Nuea"
            ],
            [
              "ID" => 213,
              "TH_NAME" => "พระโขนงเหนือ",
              "EN_NAME" => "Phra Khanong Nuea"
            ],
            [
              "ID" => 214,
              "TH_NAME" => "บางแค",
              "EN_NAME" => "Bang Khae"
            ],
            [
              "ID" => 215,
              "TH_NAME" => "บางแคเหนือ",
              "EN_NAME" => "Bang Khae Nuea"
            ],
            [
              "ID" => 216,
              "TH_NAME" => "บางไผ่",
              "EN_NAME" => "Bang Phai"
            ],
            [
              "ID" => 223,
              "TH_NAME" => "คันนายาว",
              "EN_NAME" => "Khan Na Yao"
            ],
            [
              "ID" => 224,
              "TH_NAME" => "สะพานสูง",
              "EN_NAME" => "Saphan Sung"
            ],
            [
              "ID" => 234,
              "TH_NAME" => "บางมด",
              "EN_NAME" => "Bang Mot"
            ],
            [
              "ID" => 249,
              "TH_NAME" => "บางด้วน",
              "EN_NAME" => "Bang Duan"
            ],
            [
              "ID" => 280,
              "TH_NAME" => "บางจาก",
              "EN_NAME" => "Bang Chak"
            ],
            [
              "ID" => 306,
              "TH_NAME" => "บางไผ่",
              "EN_NAME" => "Bang Phai"
            ],
            [
              "ID" => 339,
              "TH_NAME" => "คลองขวาง",
              "EN_NAME" => "Khlong Khwang"
            ],
            [
              "ID" => 340,
              "TH_NAME" => "ทวีวัฒนา",
              "EN_NAME" => "Thavi Watthana"
            ],
            [
              "ID" => 343,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 354,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 362,
              "TH_NAME" => "บางพูด",
              "EN_NAME" => "Bang Phued"
            ],
            [
              "ID" => 391,
              "TH_NAME" => "คลองพระอุดม",
              "EN_NAME" => "Khlong Phra Udom"
            ],
            [
              "ID" => 427,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 461,
              "TH_NAME" => "หน้าไม้",
              "EN_NAME" => "Na Mai"
            ],
            [
              "ID" => 466,
              "TH_NAME" => "กระแชง",
              "EN_NAME" => "Krachaeng"
            ],
            [
              "ID" => 474,
              "TH_NAME" => "บ้านเกาะ",
              "EN_NAME" => "Ban Ko"
            ],
            [
              "ID" => 478,
              "TH_NAME" => "เชียงรากน้อย",
              "EN_NAME" => "Chiang Rak Noi"
            ],
            [
              "ID" => 482,
              "TH_NAME" => "ไทรน้อย",
              "EN_NAME" => "Sai Noi"
            ],
            [
              "ID" => 491,
              "TH_NAME" => "บางหลวง",
              "EN_NAME" => "Bang Luang"
            ],
            [
              "ID" => 497,
              "TH_NAME" => "เชียงรากน้อย",
              "EN_NAME" => "Chiang Rak Noi"
            ],
            [
              "ID" => 503,
              "TH_NAME" => "วัดยม",
              "EN_NAME" => "Wat Yom"
            ],
            [
              "ID" => 508,
              "TH_NAME" => "บ้านแป้ง",
              "EN_NAME" => "Ban Paeng"
            ],
            [
              "ID" => 510,
              "TH_NAME" => "ตลิ่งชัน",
              "EN_NAME" => "Taling Chan"
            ],
            [
              "ID" => 516,
              "TH_NAME" => "บางเดื่อ",
              "EN_NAME" => "Bang Due"
            ],
            [
              "ID" => 524,
              "TH_NAME" => "บ้านม้า",
              "EN_NAME" => "Ban Ma"
            ],
            [
              "ID" => 541,
              "TH_NAME" => "โคกช้าง",
              "EN_NAME" => "Khok Chang"
            ],
            [
              "ID" => 565,
              "TH_NAME" => "ลำไทร",
              "EN_NAME" => "Lam Sai"
            ],
            [
              "ID" => 601,
              "TH_NAME" => "เสนา",
              "EN_NAME" => "Sena"
            ],
            [
              "ID" => 609,
              "TH_NAME" => "น้ำเต้า",
              "EN_NAME" => "Nam Tao"
            ],
            [
              "ID" => 610,
              "TH_NAME" => "บางนา",
              "EN_NAME" => "Bang Na"
            ],
            [
              "ID" => 617,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 619,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 624,
              "TH_NAME" => "บางแก้ว",
              "EN_NAME" => "Bang Kaew"
            ],
            [
              "ID" => 631,
              "TH_NAME" => "หัวไผ่",
              "EN_NAME" => "Hua Phai"
            ],
            [
              "ID" => 649,
              "TH_NAME" => "โรงช้าง",
              "EN_NAME" => "Rong Chang"
            ],
            [
              "ID" => 656,
              "TH_NAME" => "บางพลับ",
              "EN_NAME" => "Bang Phlat"
            ],
            [
              "ID" => 659,
              "TH_NAME" => "บางระกำ",
              "EN_NAME" => "Bang Rakam"
            ],
            [
              "ID" => 680,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 751,
              "TH_NAME" => "หนองแขม",
              "EN_NAME" => "Nong Khaem"
            ],
            [
              "ID" => 812,
              "TH_NAME" => "บางพึ่ง",
              "EN_NAME" => "Bang Phueng"
            ],
            [
              "ID" => 827,
              "TH_NAME" => "ท่าหลวง",
              "EN_NAME" => "Tha Luang"
            ],
            [
              "ID" => 859,
              "TH_NAME" => "หัวไผ่",
              "EN_NAME" => "Hua Phai"
            ],
            [
              "ID" => 862,
              "TH_NAME" => "บางกระบือ",
              "EN_NAME" => "Bang Krabuea"
            ],
            [
              "ID" => 867,
              "TH_NAME" => "แม่ลา",
              "EN_NAME" => "Mae La"
            ],
            [
              "ID" => 874,
              "TH_NAME" => "ท่าข้าม",
              "EN_NAME" => "Tha Kham"
            ],
            [
              "ID" => 881,
              "TH_NAME" => "บ้านแป้ง",
              "EN_NAME" => "Ban Paeng"
            ],
            [
              "ID" => 883,
              "TH_NAME" => "โรงช้าง",
              "EN_NAME" => "Rong Chang"
            ],
            [
              "ID" => 891,
              "TH_NAME" => "งิ้วราย",
              "EN_NAME" => "Ngiw Rai"
            ],
            [
              "ID" => 899,
              "TH_NAME" => "บ้านกล้วย",
              "EN_NAME" => "Ban Kluai"
            ],
            [
              "ID" => 917,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 920,
              "TH_NAME" => "บ่อแร่",
              "EN_NAME" => "Bo Rae"
            ],
            [
              "ID" => 930,
              "TH_NAME" => "บางหลวง",
              "EN_NAME" => "Bang Luang"
            ],
            [
              "ID" => 970,
              "TH_NAME" => "ตลิ่งชัน",
              "EN_NAME" => "Taling Chan"
            ],
            [
              "ID" => 992,
              "TH_NAME" => "โคกตูม",
              "EN_NAME" => "Khok Toom"
            ],
            [
              "ID" => 996,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phom Thong"
            ],
            [
              "ID" => 1000,
              "TH_NAME" => "หนองแขม",
              "EN_NAME" => "Nong Khaem"
            ],
            [
              "ID" => 1005,
              "TH_NAME" => "หนองปลิง",
              "EN_NAME" => "Nong Pling"
            ],
            [
              "ID" => 1013,
              "TH_NAME" => "หนองแซง",
              "EN_NAME" => "Nong Saeng"
            ],
            [
              "ID" => 1022,
              "TH_NAME" => "บ้านหมอ",
              "EN_NAME" => "Ban Mo"
            ],
            [
              "ID" => 1025,
              "TH_NAME" => "ตลาดน้อย",
              "EN_NAME" => "Talat Noi"
            ],
            [
              "ID" => 1030,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 1037,
              "TH_NAME" => "บ้านหลวง",
              "EN_NAME" => "Ban Luang"
            ],
            [
              "ID" => 1041,
              "TH_NAME" => "ดอนทอง",
              "EN_NAME" => "Don Thong"
            ],
            [
              "ID" => 1058,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 1087,
              "TH_NAME" => "หนองรี",
              "EN_NAME" => "Nong Ree"
            ],
            [
              "ID" => 1118,
              "TH_NAME" => "หนองปรือ",
              "EN_NAME" => "Nong Prue"
            ],
            [
              "ID" => 1119,
              "TH_NAME" => "หนองปลาไหล",
              "EN_NAME" => "Nong Pla Lai"
            ],
            [
              "ID" => 1122,
              "TH_NAME" => "ห้วยใหญ่",
              "EN_NAME" => "Huai Yai"
            ],
            [
              "ID" => 1124,
              "TH_NAME" => "นาเกลือ",
              "EN_NAME" => "Na Khluea"
            ],
            [
              "ID" => 1135,
              "TH_NAME" => "บางหัก",
              "EN_NAME" => "Bang Hak"
            ],
            [
              "ID" => 1146,
              "TH_NAME" => "ท่าข้าม",
              "EN_NAME" => "Tha Kham"
            ],
            [
              "ID" => 1148,
              "TH_NAME" => "หนองปรือ",
              "EN_NAME" => "Nong Prue"
            ],
            [
              "ID" => 1153,
              "TH_NAME" => "บ้านช้าง",
              "EN_NAME" => "Ban Chang"
            ],
            [
              "ID" => 1178,
              "TH_NAME" => "บ่อทอง",
              "EN_NAME" => "Bo Thong"
            ],
            [
              "ID" => 1190,
              "TH_NAME" => "ปากน้ำ",
              "EN_NAME" => "Pak Nam"
            ],
            [
              "ID" => 1199,
              "TH_NAME" => "ห้วยโป่ง",
              "EN_NAME" => "Huai Pong"
            ],
            [
              "ID" => 1206,
              "TH_NAME" => "บ้านฉาง",
              "EN_NAME" => "Ban Chang"
            ],
            [
              "ID" => 1214,
              "TH_NAME" => "บ้านนา",
              "EN_NAME" => "Ban Na"
            ],
            [
              "ID" => 1237,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 1251,
              "TH_NAME" => "ละหาร",
              "EN_NAME" => "La Har"
            ],
            [
              "ID" => 1258,
              "TH_NAME" => "เขาน้อย",
              "EN_NAME" => "Khao Noi"
            ],
            [
              "ID" => 1263,
              "TH_NAME" => "ตลาด",
              "EN_NAME" => "Talat"
            ],
            [
              "ID" => 1268,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 1272,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 1278,
              "TH_NAME" => "บางชัน",
              "EN_NAME" => "Bang Chan"
            ],
            [
              "ID" => 1309,
              "TH_NAME" => "เขาแก้ว",
              "EN_NAME" => "Khao Kaew"
            ],
            [
              "ID" => 1327,
              "TH_NAME" => "ท่าหลวง",
              "EN_NAME" => "Tha Luang"
            ],
            [
              "ID" => 1358,
              "TH_NAME" => "วังใหม่",
              "EN_NAME" => "Wang Mai"
            ],
            [
              "ID" => 1362,
              "TH_NAME" => "คลองพลู",
              "EN_NAME" => "Khlong Plu"
            ],
            [
              "ID" => 1364,
              "TH_NAME" => "บางพระ",
              "EN_NAME" => "Bang Phra"
            ],
            [
              "ID" => 1378,
              "TH_NAME" => "คลองใหญ่",
              "EN_NAME" => "Khlong Yai"
            ],
            [
              "ID" => 1383,
              "TH_NAME" => "วังตะเคียน",
              "EN_NAME" => "Wang Takien"
            ],
           [
              "ID" => 1387,
              "TH_NAME" => "เทพนิมิต",
              "EN_NAME" => "Thep Nimit"
            ],
            [
              "ID" => 1397,
              "TH_NAME" => "หนองบอน",
              "EN_NAME" => "Nong Bon"
            ],
            [
              "ID" => 1405,
              "TH_NAME" => "คลองใหญ่",
              "EN_NAME" => "Khlong Yai"
            ],
            [
              "ID" => 1413,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 1416,
              "TH_NAME" => "บางไผ่",
              "EN_NAME" => "Bang Phai"
            ],
            [
              "ID" => 1418,
              "TH_NAME" => "บางแก้ว",
              "EN_NAME" => "Bang Kaew"
            ],
            [
              "ID" => 1421,
              "TH_NAME" => "วังตะเคียน",
              "EN_NAME" => "Wang Takien"
            ],
            [
              "ID" => 1423,
              "TH_NAME" => "บางพระ",
              "EN_NAME" => "Bang Phra"
            ],
            [
              "ID" => 1429,
              "TH_NAME" => "บางเตย",
              "EN_NAME" => "Bang Te"
            ],
            [
              "ID" => 1438,
              "TH_NAME" => "ปากน้ำ",
              "EN_NAME" => "Pak Nam"
            ],
            [
              "ID" => 1448,
              "TH_NAME" => "บึงน้ำรักษ์",
              "EN_NAME" => "Bueng Nam Rak"
            ],
            [
              "ID" => 1452,
              "TH_NAME" => "ศาลาแดง",
              "EN_NAME" => "Sala Daeng"
            ],
            [
              "ID" => 1461,
              "TH_NAME" => "หนองจอก",
              "EN_NAME" => "Nong Chok"
            ],
            [
              "ID" => 1463,
              "TH_NAME" => "ท่าข้าม",
              "EN_NAME" => "Tha Kham"
            ],
            [
              "ID" => 1465,
              "TH_NAME" => "เขาดิน",
              "EN_NAME" => "Khao Din"
            ],
            [
              "ID" => 1466,
              "TH_NAME" => "บ้านโพธิ์",
              "EN_NAME" => "Ban Pho"
            ],
            [
              "ID" => 1468,
              "TH_NAME" => "คลองขุด",
              "EN_NAME" => "Khlong Khud"
            ],
            [
              "ID" => 1475,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 1486,
              "TH_NAME" => "เมืองเก่า",
              "EN_NAME" => "Mueang Kao"
            ],
            [
              "ID" => 1487,
              "TH_NAME" => "หนองยาว",
              "EN_NAME" => "Nong Yao"
            ],
            [
              "ID" => 1502,
              "TH_NAME" => "หัวสำโรง",
              "EN_NAME" => "Hua Samrong"
            ],
            [
              "ID" => 1510,
              "TH_NAME" => "บางตลาด",
              "EN_NAME" => "Bang Talat"
            ],
            [
              "ID" => 1511,
              "TH_NAME" => "หน้าเมือง",
              "EN_NAME" => "Na Mueang"
            ],
            [
              "ID" => 1513,
              "TH_NAME" => "วัดโบสถ์",
              "EN_NAME" => "Wat Bos"
            ],
            [
              "ID" => 1515,
              "TH_NAME" => "ท่างาม",
              "EN_NAME" => "Tha Ngam"
            ],
            [
              "ID" => 1525,
              "TH_NAME" => "เมืองเก่า",
              "EN_NAME" => "Mueang Kao"
            ],
            [
              "ID" => 1529,
              "TH_NAME" => "วังตะเคียน",
              "EN_NAME" => "Wang Takien"
            ],
            [
              "ID" => 1532,
              "TH_NAME" => "บ้านนา",
              "EN_NAME" => "Ban Na"
            ],
            [
              "ID" => 1533,
              "TH_NAME" => "บ่อทอง",
              "EN_NAME" => "Bo Thong"
            ],
            [
              "ID" => 1536,
              "TH_NAME" => "เขาไม้แก้ว",
              "EN_NAME" => "Khao Mai Kaew"
            ],
            [
              "ID" => 1544,
              "TH_NAME" => "สะพานหิน",
              "EN_NAME" => "Saphan Hin"
            ],
            [
              "ID" => 1569,
              "TH_NAME" => "บ้านสร้าง",
              "EN_NAME" => "Ban Sang"
            ],
            [
              "ID" => 1571,
              "TH_NAME" => "บางเตย",
              "EN_NAME" => "Bang Te"
            ],
            [
              "ID" => 1576,
              "TH_NAME" => "บางขาม",
              "EN_NAME" => "Bang Kham"
            ],
            [
              "ID" => 1579,
              "TH_NAME" => "เกาะลอย",
              "EN_NAME" => "Ko Loi"
            ],
            [
              "ID" => 1590,
              "TH_NAME" => "ท่าตูม",
              "EN_NAME" => "Tha Toom"
            ],
            [
              "ID" => 1650,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 1651,
              "TH_NAME" => "บ้านใหญ่",
              "EN_NAME" => "Ban Yai"
            ],
            [
              "ID" => 1653,
              "TH_NAME" => "ท่าทราย",
              "EN_NAME" => "Tha Sai"
            ],
            [
              "ID" => 1666,
              "TH_NAME" => "ท่าเรือ",
              "EN_NAME" => "Tha Rue"
            ],
            [
              "ID" => 1667,
              "TH_NAME" => "หนองแสง",
              "EN_NAME" => "Nong Saeng"
            ],
            [
              "ID" => 1669,
              "TH_NAME" => "บ้านนา",
              "EN_NAME" => "Ban Na"
            ],
            [
              "ID" => 1674,
              "TH_NAME" => "บางอ้อ",
              "EN_NAME" => "Bang O"
            ],
            [
              "ID" => 1685,
              "TH_NAME" => "บางปลากด",
              "EN_NAME" => "Bang Pla Kot"
            ],
            [
              "ID" => 1687,
              "TH_NAME" => "องครักษ์",
              "EN_NAME" => "Ongkharak"
            ],
            [
              "ID" => 1689,
              "TH_NAME" => "คลองใหญ่",
              "EN_NAME" => "Khlong Yai"
            ],
            [
              "ID" => 1691,
              "TH_NAME" => "บ้านแก้ง",
              "EN_NAME" => "Ban Kaeng"
            ],
            [
              "ID" => 1700,
              "TH_NAME" => "หนองบอน",
              "EN_NAME" => "Nong Bon"
            ],
            [
              "ID" => 1718,
              "TH_NAME" => "วังน้ำเย็น",
              "EN_NAME" => "Wang Nam Yen"
            ],
            [
              "ID" => 1729,
              "TH_NAME" => "หนองน้ำใส",
              "EN_NAME" => "Nong Nam Sai"
            ],
            [
              "ID" => 1740,
              "TH_NAME" => "ท่าข้าม",
              "EN_NAME" => "Tha Kham"
            ],
            [
              "ID" => 1754,
              "TH_NAME" => "หนองม่วง",
              "EN_NAME" => "Nong Muang"
            ],
            [
              "ID" => 1755,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 1758,
              "TH_NAME" => "วังใหม่",
              "EN_NAME" => "Wang Mai"
            ],
            [
              "ID" => 1759,
              "TH_NAME" => "วังทอง",
              "EN_NAME" => "Wang Thong"
            ],
            [
              "ID" => 1760,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 1763,
              "TH_NAME" => "โคกสูง",
              "EN_NAME" => "Khok Sung"
            ],
            [
              "ID" => 1771,
              "TH_NAME" => "บ้านเกาะ",
              "EN_NAME" => "Ban Ko"
            ],
            [
              "ID" => 1772,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 1774,
              "TH_NAME" => "บ้านโพธิ์",
              "EN_NAME" => "Ban Pho"
            ],
            [
              "ID" => 1776,
              "TH_NAME" => "โคกกรวด",
              "EN_NAME" => "Khok Krot"
            ],
            [
              "ID" => 1781,
              "TH_NAME" => "ตลาด",
              "EN_NAME" => "Talat"
            ],
            [
              "ID" => 1783,
              "TH_NAME" => "หนองกระทุ่ม",
              "EN_NAME" => "Nong Krathum"
            ],
            [
              "ID" => 1784,
              "TH_NAME" => "หนองไข่น้ำ",
              "EN_NAME" => "Nong Khai Nam"
            ],
            [
              "ID" => 1792,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 1809,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 1817,
              "TH_NAME" => "จักราช",
              "EN_NAME" => "Chakkarat"
            ],
            [
              "ID" => 1818,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 1819,
              "TH_NAME" => "ทองหลาง",
              "EN_NAME" => "Thong Klang"
            ],
            [
              "ID" => 1821,
              "TH_NAME" => "หนองขาม",
              "EN_NAME" => "Nong Kham"
            ],
            [
              "ID" => 1831,
              "TH_NAME" => "พลับพลา",
              "EN_NAME" => "Phlat Phla"
            ],
            [
              "ID" => 1845,
              "TH_NAME" => "บ้านเก่า",
              "EN_NAME" => "Ban Kao"
            ],
            [
              "ID" => 1854,
              "TH_NAME" => "ห้วยบง",
              "EN_NAME" => "Huai Bong"
            ],
            [
              "ID" => 1862,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 1880,
              "TH_NAME" => "หลุมข้าว",
              "EN_NAME" => "Lum Khao"
            ],
            [
              "ID" => 1881,
              "TH_NAME" => "มะค่า",
              "EN_NAME" => "Maka"
            ],
            [
              "ID" => 1898,
              "TH_NAME" => "ห้วยยาง",
              "EN_NAME" => "Huai Yang"
            ],
            [
              "ID" => 1904,
              "TH_NAME" => "หนองหว้า",
              "EN_NAME" => "Nong Wa"
            ],
            [
              "ID" => 1907,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phom Thong"
            ],
            [
              "ID" => 1909,
              "TH_NAME" => "กุดจอก",
              "EN_NAME" => "Kud Chok"
            ],
            [
              "ID" => 1913,
              "TH_NAME" => "สามเมือง",
              "EN_NAME" => "Sam Mueang"
            ],
            [
              "ID" => 1922,
              "TH_NAME" => "กระทุ่มราย",
              "EN_NAME" => "Krathum Rai"
            ],
            [
              "ID" => 1926,
              "TH_NAME" => "หนองพลวง",
              "EN_NAME" => "Nong Phluang"
            ],
            [
              "ID" => 1940,
              "TH_NAME" => "โคกไทย",
              "EN_NAME" => "Khok Thai"
            ],
            [
              "ID" => 1941,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 1958,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 1962,
              "TH_NAME" => "ท่าหลวง",
              "EN_NAME" => "Tha Luang"
            ],
            [
              "ID" => 1965,
              "TH_NAME" => "นิคมสร้างตนเอง",
              "EN_NAME" => "Nikhom Sang Ton Eng"
            ],
            [
              "ID" => 1969,
              "TH_NAME" => "หนองระเวียง",
              "EN_NAME" => "Nong Rawiang"
            ],
            [
              "ID" => 1974,
              "TH_NAME" => "หินดาด",
              "EN_NAME" => "Hin Dat"
            ],
            [
              "ID" => 1975,
              "TH_NAME" => "งิ้ว",
              "EN_NAME" => "Ngiw"
            ],
            [
              "ID" => 1984,
              "TH_NAME" => "ตลาดไทร",
              "EN_NAME" => "Talat Sai"
            ],
            [
              "ID" => 1990,
              "TH_NAME" => "บ้านยาง",
              "EN_NAME" => "Ban Yang"
            ],
            [
              "ID" => 2011,
              "TH_NAME" => "หนองสรวง",
              "EN_NAME" => "Nong Sruang"
            ],
            [
              "ID" => 2019,
              "TH_NAME" => "หนองน้ำใส",
              "EN_NAME" => "Nong Nam Sai"
            ],
            [
              "ID" => 2021,
              "TH_NAME" => "มิตรภาพ",
              "EN_NAME" => "Mittraphap"
            ],
            [
              "ID" => 2023,
              "TH_NAME" => "ดอนเมือง",
              "EN_NAME" => "Don Mueang"
            ],
            [
              "ID" => 2042,
              "TH_NAME" => "หนองตะไก้",
              "EN_NAME" => "Nong Takai"
            ],
            [
              "ID" => 2045,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 2049,
              "TH_NAME" => "สีสุก",
              "EN_NAME" => "Si Suk"
            ],
          [
              "ID" => 2053,
              "TH_NAME" => "สำพะเนียง",
              "EN_NAME" => "Samphaniang"
            ],
            [
              "ID" => 2062,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 2069,
              "TH_NAME" => "สระพระ",
              "EN_NAME" => "Sra Phra"
            ],
            [
              "ID" => 2070,
              "TH_NAME" => "มาบกราด",
              "EN_NAME" => "Mab Krad"
            ],
            [
              "ID" => 2071,
              "TH_NAME" => "พังเทียม",
              "EN_NAME" => "Phang Thiam"
            ],
            [
              "ID" => 2072,
              "TH_NAME" => "ทัพรั้ง",
              "EN_NAME" => "Thaprang"
            ],
            [
              "ID" => 2073,
              "TH_NAME" => "หนองหอย",
              "EN_NAME" => "Nong Hoi"
            ],
            [
              "ID" => 2074,
              "TH_NAME" => "ขุย",
              "EN_NAME" => "Khu"
            ],
            [
              "ID" => 2075,
              "TH_NAME" => "บ้านยาง",
              "EN_NAME" => "Ban Yang"
            ],
            [
              "ID" => 2076,
              "TH_NAME" => "ช่องแมว",
              "EN_NAME" => "Chong Maew"
            ],
            [
              "ID" => 2077,
              "TH_NAME" => "ไพล",
              "EN_NAME" => "Plai"
            ],
            [
              "ID" => 2078,
              "TH_NAME" => "เมืองพะไล",
              "EN_NAME" => "Mueang Phalai"
            ],
            [
              "ID" => 2079,
              "TH_NAME" => "โนนจาน",
              "EN_NAME" => "Non Chan"
            ],
            [
              "ID" => 2080,
              "TH_NAME" => "บัวลาย",
              "EN_NAME" => "Bualai"
            ],
            [
              "ID" => 2081,
              "TH_NAME" => "หนองหว้า",
              "EN_NAME" => "Nong Wa"
            ],
            [
              "ID" => 2082,
              "TH_NAME" => "สีดา",
              "EN_NAME" => "Sida"
            ],
            [
              "ID" => 2083,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phom Thong"
            ],
            [
              "ID" => 2084,
              "TH_NAME" => "โนนประดู่",
              "EN_NAME" => "Non Pradu"
            ],
            [
              "ID" => 2085,
              "TH_NAME" => "สามเมือง",
              "EN_NAME" => "Sam Mueang"
            ],
            [
              "ID" => 2086,
              "TH_NAME" => "หนองตาดใหญ่",
              "EN_NAME" => "Nong Tat Yai"
            ],
            [
              "ID" => 2087,
              "TH_NAME" => "ช้างทอง",
              "EN_NAME" => "Chang Thong"
            ],
            [
              "ID" => 2088,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 2089,
              "TH_NAME" => "พระพุทธ",
              "EN_NAME" => "Phra Phut"
            ],
            [
              "ID" => 2090,
              "TH_NAME" => "หนองงูเหลือม",
              "EN_NAME" => "Nong Ngu Luem"
            ],
            [
              "ID" => 2091,
              "TH_NAME" => "หนองยาง",
              "EN_NAME" => "Nong Yang"
            ],
            [
              "ID" => 2092,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 2094,
              "TH_NAME" => "เสม็ด",
              "EN_NAME" => "Samet"
            ],
            [
              "ID" => 2099,
              "TH_NAME" => "บ้านยาง",
              "EN_NAME" => "Ban Yang"
            ],
            [
              "ID" => 2104,
              "TH_NAME" => "ถลุงเหล็ก",
              "EN_NAME" => "Thalung Lek"
            ],
            [
              "ID" => 2109,
              "TH_NAME" => "สองห้อง",
              "EN_NAME" => "Song Hong"
            ],
            [
              "ID" => 2129,
              "TH_NAME" => "กระสัง",
              "EN_NAME" => "Krasang"
            ],
            [
              "ID" => 2132,
              "TH_NAME" => "สูงเนิน",
              "EN_NAME" => "Sung Noen"
            ],
            [
              "ID" => 2134,
              "TH_NAME" => "เมืองไผ่",
              "EN_NAME" => "Mueang Phai"
            ],
            [
              "ID" => 2135,
              "TH_NAME" => "ชุมแสง",
              "EN_NAME" => "Chum Saeng"
            ],
            [
              "ID" => 2144,
              "TH_NAME" => "ชุมแสง",
              "EN_NAME" => "Chum Saeng"
            ],
            [
              "ID" => 2153,
              "TH_NAME" => "หนองไทร",
              "EN_NAME" => "Nong Sai"
            ],
            [
              "ID" => 2164,
              "TH_NAME" => "หัวถนน",
              "EN_NAME" => "Hua Thanon"
            ],
            [
              "ID" => 2166,
              "TH_NAME" => "หนองโสน",
              "EN_NAME" => "Nong Son"
            ],
            [
              "ID" => 2173,
              "TH_NAME" => "หนองกี่",
              "EN_NAME" => "Nong Ki"
            ],
            [
              "ID" => 2175,
              "TH_NAME" => "เมืองไผ่",
              "EN_NAME" => "Mueang Phai"
            ],
            [
              "ID" => 2177,
              "TH_NAME" => "โคกสว่าง",
              "EN_NAME" => "Khok Sa-wang"
            ],
            [
              "ID" => 2181,
              "TH_NAME" => "โคกสูง",
              "EN_NAME" => "Khok Sung"
            ],
            [
              "ID" => 2189,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 2210,
              "TH_NAME" => "หนองบอน",
              "EN_NAME" => "Nong Bon"
            ],
            [
              "ID" => 2213,
              "TH_NAME" => "โคกตูม",
              "EN_NAME" => "Khok Toom"
            ],
            [
              "ID" => 2236,
              "TH_NAME" => "บ้านยาง",
              "EN_NAME" => "Ban Yang"
            ],
            [
              "ID" => 2242,
              "TH_NAME" => "แสลงพัน",
              "EN_NAME" => "Saeng Phan"
            ],
            [
              "ID" => 2246,
              "TH_NAME" => "โคกกลาง",
              "EN_NAME" => "Khok Klang"
            ],
            [
              "ID" => 2247,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 2249,
              "TH_NAME" => "บ้านยาง",
              "EN_NAME" => "Ban Yang"
            ],
            [
              "ID" => 2252,
              "TH_NAME" => "หินโคน",
              "EN_NAME" => "Hin Kon"
            ],
            [
              "ID" => 2255,
              "TH_NAME" => "หนองโดน",
              "EN_NAME" => "Nong Don"
            ],
            [
              "ID" => 2263,
              "TH_NAME" => "หนองใหญ่",
              "EN_NAME" => "Nong Yai"
            ],
            [
              "ID" => 2268,
              "TH_NAME" => "ชุมแสง",
              "EN_NAME" => "Chum Saeng"
            ],
            [
              "ID" => 2272,
              "TH_NAME" => "สนามชัย",
              "EN_NAME" => "Sanam Chai"
            ],
            [
              "ID" => 2273,
              "TH_NAME" => "กระสัง",
              "EN_NAME" => "Krasang"
            ],
            [
              "ID" => 2276,
              "TH_NAME" => "ไทยเจริญ",
              "EN_NAME" => "Thai Charoen"
            ],
            [
              "ID" => 2277,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 2285,
              "TH_NAME" => "สระแก้ว",
              "EN_NAME" => "Sra Kaeo"
            ],
            [
              "ID" => 2286,
              "TH_NAME" => "ห้วยหิน",
              "EN_NAME" => "Huai Hin"
            ],
            [
              "ID" => 2287,
              "TH_NAME" => "ไทยสามัคคี",
              "EN_NAME" => "Thai Samakkhi"
            ],
            [
              "ID" => 2295,
              "TH_NAME" => "สะเดา",
              "EN_NAME" => "Sadeao"
            ],
            [
              "ID" => 2296,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 2311,
              "TH_NAME" => "เมืองยาง",
              "EN_NAME" => "Mueang Yang"
            ],
            [
              "ID" => 2315,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 2316,
              "TH_NAME" => "ทองหลาง",
              "EN_NAME" => "Thong Klang"
            ],
            [
              "ID" => 2323,
              "TH_NAME" => "บ้านด่าน",
              "EN_NAME" => "Ban Dan"
            ],
            [
              "ID" => 2324,
              "TH_NAME" => "ปราสาท",
              "EN_NAME" => "Prasat"
            ],
            [
              "ID" => 2336,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 2339,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Dee"
            ],
            [
              "ID" => 2344,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 2371,
              "TH_NAME" => "ท่าตูม",
              "EN_NAME" => "Tha Toom"
            ],
            [
              "ID" => 2375,
              "TH_NAME" => "เมืองแก",
              "EN_NAME" => "Mueang Kae"
            ],
            [
              "ID" => 2377,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 2388,
              "TH_NAME" => "ชุมแสง",
              "EN_NAME" => "Chum Saeng"
            ],
            [
              "ID" => 2392,
              "TH_NAME" => "ไพล",
              "EN_NAME" => "Plai"
            ],
            [
              "ID" => 2396,
              "TH_NAME" => "หนองใหญ่",
              "EN_NAME" => "Nong Yai"
            ],
            [
              "ID" => 2397,
              "TH_NAME" => "โคกยาง",
              "EN_NAME" => "Khok Yang"
            ],
            [
              "ID" => 2398,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 2399,
              "TH_NAME" => "บ้านไทร",
              "EN_NAME" => "Ban Sai"
            ],
            [
              "ID" => 2407,
              "TH_NAME" => "ประทัดบุ",
              "EN_NAME" => "Prathat Bu"
            ],
            [
              "ID" => 2422,
              "TH_NAME" => "ตะเคียน",
              "EN_NAME" => "Takien"
            ],
            [
              "ID" => 2457,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 2473,
              "TH_NAME" => "พระแก้ว",
              "EN_NAME" => "Phra Kaew"
            ],
            [
              "ID" => 2486,
              "TH_NAME" => "ลำดวน",
              "EN_NAME" => "Lam Duan"
            ],
            [
              "ID" => 2492,
              "TH_NAME" => "หนองไผ่ล้อม",
              "EN_NAME" => "Nong Phai Lom"
            ],
            [
              "ID" => 2496,
              "TH_NAME" => "เกาะแก้ว",
              "EN_NAME" => "Ko Kaew"
            ],
            [
              "ID" => 2502,
              "TH_NAME" => "สะเดา",
              "EN_NAME" => "Sadeao"
            ],
            [
              "ID" => 2508,
              "TH_NAME" => "โคกกลาง",
              "EN_NAME" => "Khok Klang"
            ],
            [
              "ID" => 2514,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 2515,
              "TH_NAME" => "ศรีสุข",
              "EN_NAME" => "Si Suk"
            ],
            [
              "ID" => 2517,
              "TH_NAME" => "บึง",
              "EN_NAME" => "Bueng"
            ],
            [
              "ID" => 2546,
              "TH_NAME" => "หนองแก้ว",
              "EN_NAME" => "Nong Kaew"
            ],
            [
              "ID" => 2563,
              "TH_NAME" => "บึงบอน",
              "EN_NAME" => "Bueng Bon"
            ],
            [
              "ID" => 2568,
              "TH_NAME" => "ยาง",
              "EN_NAME" => "Yang"
            ],
            [
              "ID" => 2569,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 2570,
              "TH_NAME" => "หนองแก้ว",
              "EN_NAME" => "Nong Kaew"
            ],
            [
              "ID" => 2576,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 2579,
              "TH_NAME" => "จาน",
              "EN_NAME" => "Chan"
            ],
            [
              "ID" => 2604,
              "TH_NAME" => "กระแชง",
              "EN_NAME" => "Krachaeng"
            ],
          [
              "ID" => 2605,
              "TH_NAME" => "โนนสำราญ",
              "EN_NAME" => "Non Samran"
            ],
            [
              "ID" => 2620,
              "TH_NAME" => "กันทรารมย์",
              "EN_NAME" => "Kanthararom"
            ],
            [
              "ID" => 2632,
              "TH_NAME" => "ตะเคียน",
              "EN_NAME" => "Takien"
            ],
            [
              "ID" => 2634,
              "TH_NAME" => "นิคมพัฒนา",
              "EN_NAME" => "Nikhom Phatthana"
            ],
            [
              "ID" => 2637,
              "TH_NAME" => "ปราสาท",
              "EN_NAME" => "Prasat"
            ],
            [
              "ID" => 2641,
              "TH_NAME" => "ห้วยสำราญ",
              "EN_NAME" => "Huai Samran"
            ],
            [
              "ID" => 2643,
              "TH_NAME" => "กฤษณา",
              "EN_NAME" => "Krisana"
            ],
            [
              "ID" => 2650,
              "TH_NAME" => "ดินแดง",
              "EN_NAME" => "Din Daeng"
            ],
            [
              "ID" => 2658,
              "TH_NAME" => "ตูม",
              "EN_NAME" => "Toom"
            ],
            [
              "ID" => 2662,
              "TH_NAME" => "ดู่",
              "EN_NAME" => "Du"
            ],
            [
              "ID" => 2663,
              "TH_NAME" => "สวาย",
              "EN_NAME" => "Saway"
            ],
            [
              "ID" => 2672,
              "TH_NAME" => "โนนสูง",
              "EN_NAME" => "Non Sung"
            ],
            [
              "ID" => 2677,
              "TH_NAME" => "เมืองคง",
              "EN_NAME" => "Mueang Khon"
            ],
            [
              "ID" => 2679,
              "TH_NAME" => "หนองแค",
              "EN_NAME" => "Nong Kae"
            ],
            [
              "ID" => 2683,
              "TH_NAME" => "ด่าน",
              "EN_NAME" => "Dan"
            ],
            [
              "ID" => 2684,
              "TH_NAME" => "ดู่",
              "EN_NAME" => "Du"
            ],
            [
              "ID" => 2687,
              "TH_NAME" => "ไผ่",
              "EN_NAME" => "Phai"
            ],
            [
              "ID" => 2688,
              "TH_NAME" => "ส้มป่อย",
              "EN_NAME" => "Som Poi"
            ],
            [
              "ID" => 2696,
              "TH_NAME" => "ก้านเหลือง",
              "EN_NAME" => "Kan Lueang"
            ],
            [
              "ID" => 2698,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 2700,
              "TH_NAME" => "หนองไฮ",
              "EN_NAME" => "Nong Hai"
            ],
            [
              "ID" => 2709,
              "TH_NAME" => "โพธิ์ชัย",
              "EN_NAME" => "Pho Chai"
            ],
            [
              "ID" => 2730,
              "TH_NAME" => "ผักไหม",
              "EN_NAME" => "Phak Mai"
            ],
            [
              "ID" => 2732,
              "TH_NAME" => "ปราสาท",
              "EN_NAME" => "Prasat"
            ],
            [
              "ID" => 2735,
              "TH_NAME" => "โพธิ์",
              "EN_NAME" => "Pho"
            ],
            [
              "ID" => 2741,
              "TH_NAME" => "ตูม",
              "EN_NAME" => "Toom"
            ],
            [
              "ID" => 2752,
              "TH_NAME" => "ธาตุ",
              "EN_NAME" => "That"
            ],
            [
              "ID" => 2756,
              "TH_NAME" => "ทุ่งสว่าง",
              "EN_NAME" => "Thung Sa-wang"
            ],
            [
              "ID" => 2757,
              "TH_NAME" => "วังหิน",
              "EN_NAME" => "Wang Hin"
            ],
            [
              "ID" => 2768,
              "TH_NAME" => "หนองใหญ่",
              "EN_NAME" => "Nong Yai"
            ],
            [
              "ID" => 2770,
              "TH_NAME" => "หนองหว้า",
              "EN_NAME" => "Nong Wa"
            ],
            [
              "ID" => 2771,
              "TH_NAME" => "หนองงูเหลือม",
              "EN_NAME" => "Nong Ngu Luem"
            ],
            [
              "ID" => 2773,
              "TH_NAME" => "ท่าคล้อ",
              "EN_NAME" => "Tha Khl"
            ],
            [
              "ID" => 2780,
              "TH_NAME" => "เสียว",
              "EN_NAME" => "Siao"
            ],
            [
              "ID" => 2788,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 2807,
              "TH_NAME" => "ปะอาว",
              "EN_NAME" => "Pa Aow"
            ],
            [
              "ID" => 2818,
              "TH_NAME" => "ดอนใหญ่",
              "EN_NAME" => "Don Yai"
            ],
            [
              "ID" => 2820,
              "TH_NAME" => "ห้วยยาง",
              "EN_NAME" => "Huai Yang"
            ],
            [
              "ID" => 2823,
              "TH_NAME" => "ห้วยไผ่",
              "EN_NAME" => "Huai Phai"
            ],
            [
              "ID" => 2838,
              "TH_NAME" => "โนนรัง",
              "EN_NAME" => "Non Rang"
            ],
            [
              "ID" => 2840,
              "TH_NAME" => "ศรีสุข",
              "EN_NAME" => "Si Suk"
            ],
            [
              "ID" => 2885,
              "TH_NAME" => "โนนสมบูรณ์",
              "EN_NAME" => "Non Sombun"
            ],
            [
              "ID" => 2887,
              "TH_NAME" => "โนนสมบูรณ์",
              "EN_NAME" => "Non Sombun"
            ],
            [
              "ID" => 2894,
              "TH_NAME" => "ยาง",
              "EN_NAME" => "Yang"
            ],
            [
              "ID" => 2903,
              "TH_NAME" => "โพนงาม",
              "EN_NAME" => "Phom Ngam"
            ],
            [
              "ID" => 2906,
              "TH_NAME" => "นาโพธิ์",
              "EN_NAME" => "Na Pho"
            ],
            [
              "ID" => 2908,
              "TH_NAME" => "โนนค้อ",
              "EN_NAME" => "Non Kho"
            ],
            [
              "ID" => 2909,
              "TH_NAME" => "บัวงาม",
              "EN_NAME" => "Bua Ngam"
            ],
            [
              "ID" => 2917,
              "TH_NAME" => "โคกจาน",
              "EN_NAME" => "Khok Chan"
            ],
            [
              "ID" => 2927,
              "TH_NAME" => "หนองเต่า",
              "EN_NAME" => "Nong Tao"
            ],
            [
              "ID" => 2929,
              "TH_NAME" => "ท่าหลวง",
              "EN_NAME" => "Tha Luang"
            ],
            [
              "ID" => 2951,
              "TH_NAME" => "หนองเมือง",
              "EN_NAME" => "Nong Mueang"
            ],
            [
              "ID" => 2955,
              "TH_NAME" => "หนองเหล่า",
              "EN_NAME" => "Nong Lao"
            ],
            [
              "ID" => 2956,
              "TH_NAME" => "หนองฮาง",
              "EN_NAME" => "Nong Hang"
            ],
            [
              "ID" => 2958,
              "TH_NAME" => "ไผ่ใหญ่",
              "EN_NAME" => "Phai Yai"
            ],
            [
              "ID" => 2962,
              "TH_NAME" => "ธาตุ",
              "EN_NAME" => "That"
            ],
            [
              "ID" => 2964,
              "TH_NAME" => "ท่าลาด",
              "EN_NAME" => "Tha Lad"
            ],
            [
              "ID" => 2967,
              "TH_NAME" => "คูเมือง",
              "EN_NAME" => "Khu Mueang"
            ],
            [
              "ID" => 2978,
              "TH_NAME" => "แสนสุข",
              "EN_NAME" => "Saen Suk"
            ],
            [
              "ID" => 3028,
              "TH_NAME" => "ทรายมูล",
              "EN_NAME" => "Sai Moon"
            ],
            [
              "ID" => 3029,
              "TH_NAME" => "นาโพธิ์",
              "EN_NAME" => "Na Pho"
            ],
            [
              "ID" => 3033,
              "TH_NAME" => "โพธิ์ศรี",
              "EN_NAME" => "Pho Si"
            ],
            [
              "ID" => 3037,
              "TH_NAME" => "อ่างศิลา",
              "EN_NAME" => "Ang Sila"
            ],
            [
              "ID" => 3044,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 3046,
              "TH_NAME" => "หนองกุง",
              "EN_NAME" => "Nong Kung"
            ],
            [
              "ID" => 3049,
              "TH_NAME" => "โพธิ์ไทร",
              "EN_NAME" => "Pho Sai"
            ],
            [
              "ID" => 3051,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 3052,
              "TH_NAME" => "สองคอน",
              "EN_NAME" => "Song Kon"
            ],
            [
              "ID" => 3053,
              "TH_NAME" => "สารภี",
              "EN_NAME" => "Saraphi"
            ],
            [
              "ID" => 3055,
              "TH_NAME" => "สำโรง",
              "EN_NAME" => "Samrong"
            ],
            [
              "ID" => 3057,
              "TH_NAME" => "หนองไฮ",
              "EN_NAME" => "Nong Hai"
            ],
            [
              "ID" => 3060,
              "TH_NAME" => "โคกสว่าง",
              "EN_NAME" => "Khok Sa-wang"
            ],
            [
              "ID" => 3061,
              "TH_NAME" => "โนนกลาง",
              "EN_NAME" => "Non Klang"
            ],
            [
              "ID" => 3063,
              "TH_NAME" => "ขามป้อม",
              "EN_NAME" => "Kham Pom"
            ],
            [
              "ID" => 3079,
              "TH_NAME" => "คำเขื่อนแก้ว",
              "EN_NAME" => "Kham Khuean Kaew"
            ],
            [
              "ID" => 3094,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Dee"
            ],
            [
              "ID" => 3105,
              "TH_NAME" => "ท่าช้าง",
              "EN_NAME" => "Tha Chang"
            ],
            [
              "ID" => 3110,
              "TH_NAME" => "ขี้เหล็ก",
              "EN_NAME" => "Khie Lek"
            ],
            [
              "ID" => 3111,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 3112,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 3121,
              "TH_NAME" => "สิงห์",
              "EN_NAME" => "Sing"
            ],
            [
              "ID" => 3125,
              "TH_NAME" => "หนองคู",
              "EN_NAME" => "Nong Khu"
            ],
            [
              "ID" => 3128,
              "TH_NAME" => "หนองเรือ",
              "EN_NAME" => "Nong Rue"
            ],
            [
              "ID" => 3134,
              "TH_NAME" => "ทรายมูล",
              "EN_NAME" => "Sai Moon"
            ],
            [
              "ID" => 3138,
              "TH_NAME" => "ไผ่",
              "EN_NAME" => "Phai"
            ],
            [
              "ID" => 3144,
              "TH_NAME" => "หนองหมี",
              "EN_NAME" => "Nong Mee"
            ],
            [
              "ID" => 3145,
              "TH_NAME" => "โพนงาม",
              "EN_NAME" => "Phom Ngam"
            ],
            [
              "ID" => 3147,
              "TH_NAME" => "หนองแหน",
              "EN_NAME" => "Nong Haen"
            ],
            [
              "ID" => 3152,
              "TH_NAME" => "ทุ่งมน",
              "EN_NAME" => "Thung Mon"
            ],
            [
              "ID" => 3153,
              "TH_NAME" => "นาคำ",
              "EN_NAME" => "Na Kham"
            ],
            [
              "ID" => 3161,
              "TH_NAME" => "โพธิ์ไทร",
              "EN_NAME" => "Pho Sai"
            ],
            [
              "ID" => 3168,
              "TH_NAME" => "คูเมือง",
              "EN_NAME" => "Khu Mueang"
            ],
            [
              "ID" => 3175,
              "TH_NAME" => "สงยาง",
              "EN_NAME" => "Song Yang"
            ],
            [
              "ID" => 3182,
              "TH_NAME" => "น้ำอ้อม",
              "EN_NAME" => "Nam Om"
            ],
            [
              "ID" => 3197,
              "TH_NAME" => "ศรีแก้ว",
              "EN_NAME" => "Si Kaew"
            ],
            [
              "ID" => 3204,
              "TH_NAME" => "ไทยเจริญ",
              "EN_NAME" => "Thai Charoen"
            ],
            [
              "ID" => 3205,
              "TH_NAME" => "น้ำคำ",
              "EN_NAME" => "Nam Kham"
            ],
            [
              "ID" => 3209,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 3210,
              "TH_NAME" => "รอบเมือง",
              "EN_NAME" => "Rop Mueang"
            ],
            [
              "ID" => 3211,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phom Thong"
            ],
            [
              "ID" => 3213,
              "TH_NAME" => "บ้านค่าย",
              "EN_NAME" => "Ban Khai"
            ],
            [
              "ID" => 3220,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 3223,
              "TH_NAME" => "ห้วยบง",
              "EN_NAME" => "Huai Bong"
            ],
            [
              "ID" => 3224,
              "TH_NAME" => "โนนสำราญ",
              "EN_NAME" => "Non Samran"
            ],
            [
              "ID" => 3225,
              "TH_NAME" => "โคกสูง",
              "EN_NAME" => "Khok Sung"
            ],
            [
              "ID" => 3235,
              "TH_NAME" => "โนนแดง",
              "EN_NAME" => "Non Daeng"
            ],
            [
              "ID" => 3243,
              "TH_NAME" => "หนองขาม",
              "EN_NAME" => "Nong Kham"
            ],
            [
              "ID" => 3244,
              "TH_NAME" => "ศรีสำราญ",
              "EN_NAME" => "Si Samran"
            ],
            [
              "ID" => 3245,
              "TH_NAME" => "บ้านยาง",
              "EN_NAME" => "Ban Yang"
            ],
            [
              "ID" => 3246,
              "TH_NAME" => "บ้านหัน",
              "EN_NAME" => "Ban Han"
            ],
            [
              "ID" => 3248,
              "TH_NAME" => "บ้านเป้า",
              "EN_NAME" => "Ban Pao"
            ],
            [
              "ID" => 3254,
              "TH_NAME" => "บ้านบัว",
              "EN_NAME" => "Ban Bua"
            ],
            [
              "ID" => 3263,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 3264,
              "TH_NAME" => "คูเมือง",
              "EN_NAME" => "Khu Mueang"
            ],
            [
              "ID" => 3270,
              "TH_NAME" => "บ้านกอก",
              "EN_NAME" => "Ban Kok"
            ],
            [
              "ID" => 3271,
              "TH_NAME" => "หนองบัวบาน",
              "EN_NAME" => "Nong Buaban"
            ],
            [
              "ID" => 3274,
              "TH_NAME" => "กุดน้ำใส",
              "EN_NAME" => "Kud Nam Sai"
            ],
            [
              "ID" => 3275,
              "TH_NAME" => "หนองโดน",
              "EN_NAME" => "Nong Don"
            ],
            [
              "ID" => 3280,
              "TH_NAME" => "หนองบัวโคก",
              "EN_NAME" => "Nong Bua Khok"
            ],
            [
              "ID" => 3282,
              "TH_NAME" => "ส้มป่อย",
              "EN_NAME" => "Som Poi"
            ],
            [
              "ID" => 3289,
              "TH_NAME" => "หัวทะเล",
              "EN_NAME" => "Hua Thale"
            ],
            [
              "ID" => 3300,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 3310,
              "TH_NAME" => "บ้านแก้ง",
              "EN_NAME" => "Ban Kaeng"
            ],
            [
              "ID" => 3312,
              "TH_NAME" => "บ้านเพชร",
              "EN_NAME" => "Ban Phet"
            ],
            [
              "ID" => 3313,
              "TH_NAME" => "โคกสะอาด",
              "EN_NAME" => "Khok Sa-at"
            ],
            [
              "ID" => 3316,
              "TH_NAME" => "ธาตุทอง",
              "EN_NAME" => "That Thong"
            ],
            [
              "ID" => 3322,
              "TH_NAME" => "หนองคู",
              "EN_NAME" => "Nong Khu"
            ],
            [
              "ID" => 3323,
              "TH_NAME" => "ช่องสามหมอ",
              "EN_NAME" => "Chong Sam Mo"
            ],
            [
              "ID" => 3324,
              "TH_NAME" => "หนองขาม",
              "EN_NAME" => "Nong Kham"
            ],
            [
              "ID" => 3326,
              "TH_NAME" => "บ้านแก้ง",
              "EN_NAME" => "Ban Kaeng"
            ],
            [
              "ID" => 3327,
              "TH_NAME" => "หนองสังข์",
              "EN_NAME" => "Nong Sank"
            ],
            [
              "ID" => 3332,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 3335,
              "TH_NAME" => "โนนคูณ",
              "EN_NAME" => "Non Khun"
            ],
            [
              "ID" => 3336,
              "TH_NAME" => "ห้วยยาง",
              "EN_NAME" => "Huai Yang"
            ],
            [
              "ID" => 3338,
              "TH_NAME" => "ดงบัง",
              "EN_NAME" => "Dong Bang"
            ],
            [
              "ID" => 3343,
              "TH_NAME" => "วังทอง",
              "EN_NAME" => "Wang Thong"
            ],
            [
              "ID" => 3344,
              "TH_NAME" => "แหลมทอง",
              "EN_NAME" => "Laem Thong"
            ],
            [
              "ID" => 3365,
              "TH_NAME" => "ห้วยไร่",
              "EN_NAME" => "Huai Rai"
            ],
            [
              "ID" => 3383,
              "TH_NAME" => "คำเขื่อนแก้ว",
              "EN_NAME" => "Kham Khuean Kaew"
            ],
            [
              "ID" => 3387,
              "TH_NAME" => "หนองข่า",
              "EN_NAME" => "Nong Kha"
            ],
            [
              "ID" => 3402,
              "TH_NAME" => "โพนทอง",
              "EN_NAME" => "Phom Thong"
            ],
            [
              "ID" => 3404,
              "TH_NAME" => "นาเวียง",
              "EN_NAME" => "Na Wiang"
            ],
            [
              "ID" => 3405,
              "TH_NAME" => "หนองไฮ",
              "EN_NAME" => "Nong Hai"
            ],
            [
              "ID" => 3407,
              "TH_NAME" => "หัวตะพาน",
              "EN_NAME" => "Hua Tapan"
            ],
            [
              "ID" => 3410,
              "TH_NAME" => "หนองแก้ว",
              "EN_NAME" => "Nong Kaew"
            ],
            [
              "ID" => 3418,
              "TH_NAME" => "ดงบัง",
              "EN_NAME" => "Dong Bang"
            ],
            [
              "ID" => 3421,
              "TH_NAME" => "โคกกลาง",
              "EN_NAME" => "Khok Klang"
            ],
            [
              "ID" => 3422,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 3424,
              "TH_NAME" => "โพธิ์ชัย",
              "EN_NAME" => "Pho Chai"
            ],
            [
              "ID" => 3426,
              "TH_NAME" => "หัวนา",
              "EN_NAME" => "Hua Na"
            ],
            [
              "ID" => 3427,
              "TH_NAME" => "บ้านขาม",
              "EN_NAME" => "Ban Kham"
            ],
            [
              "ID" => 3429,
              "TH_NAME" => "บ้านพร้าว",
              "EN_NAME" => "Ban Prao"
            ],
            [
              "ID" => 3432,
              "TH_NAME" => "กุดจิก",
              "EN_NAME" => "Kud Chik"
            ],
            [
              "ID" => 3436,
              "TH_NAME" => "หนองหว้า",
              "EN_NAME" => "Nong Wa"
            ],
            [
              "ID" => 3437,
              "TH_NAME" => "นากลาง",
              "EN_NAME" => "Na Klang"
            ],
            [
              "ID" => 3438,
              "TH_NAME" => "ด่านช้าง",
              "EN_NAME" => "Dan Chang"
            ],
            [
              "ID" => 3445,
              "TH_NAME" => "โนนเมือง",
              "EN_NAME" => "Non Mueang"
            ],
            [
              "ID" => 3449,
              "TH_NAME" => "กุดแห่",
              "EN_NAME" => "Kud Hae"
            ],
            [
              "ID" => 3456,
              "TH_NAME" => "โนนสัง",
              "EN_NAME" => "Non Sang"
            ],
            [
              "ID" => 3458,
              "TH_NAME" => "หนองเรือ",
              "EN_NAME" => "Nong Rue"
            ],
            [
              "ID" => 3461,
              "TH_NAME" => "โนนเมือง",
              "EN_NAME" => "Non Mueang"
            ],
            [
              "ID" => 3462,
              "TH_NAME" => "โคกใหญ่",
              "EN_NAME" => "Khok Yai"
            ],
            [
              "ID" => 3463,
              "TH_NAME" => "โคกม่วง",
              "EN_NAME" => "Khok Muang"
            ],
            [
              "ID" => 3464,
              "TH_NAME" => "นิคมพัฒนา",
              "EN_NAME" => "Nikhom Phatthana"
            ],
            [
              "ID" => 3466,
              "TH_NAME" => "เมืองใหม่",
              "EN_NAME" => "Mueang Mai"
            ],
            [
              "ID" => 3471,
              "TH_NAME" => "โนนสะอาด",
              "EN_NAME" => "Non Sa-at"
            ],
            [
              "ID" => 3475,
              "TH_NAME" => "หนองแก",
              "EN_NAME" => "Nong Kae"
            ],
            [
              "ID" => 3480,
              "TH_NAME" => "นาดี",
              "EN_NAME" => "Na Dee"
            ],
            [
              "ID" => 3482,
              "TH_NAME" => "ดงมะไฟ",
              "EN_NAME" => "Dong Ma Fai"
            ],
            [
              "ID" => 3487,
              "TH_NAME" => "นาแก",
              "EN_NAME" => "Na Kae"
            ],
            [
              "ID" => 3488,
              "TH_NAME" => "วังทอง",
              "EN_NAME" => "Wang Thong"
            ],
            [
              "ID" => 3491,
              "TH_NAME" => "ในเมือง",
              "EN_NAME" => "Nai Mueang"
            ],
            [
              "ID" => 3492,
              "TH_NAME" => "สำราญ",
              "EN_NAME" => "Samran"
            ],
            [
              "ID" => 3496,
              "TH_NAME" => "เมืองเก่า",
              "EN_NAME" => "Mueang Kao"
            ],
            [
              "ID" => 3499,
              "TH_NAME" => "บ้านหว้า",
              "EN_NAME" => "Ban Wa"
            ],
            [
              "ID" => 3500,
              "TH_NAME" => "บ้านค้อ",
              "EN_NAME" => "Ban Kho"
            ],
            [
              "ID" => 3501,
              "TH_NAME" => "แดงใหญ่",
              "EN_NAME" => "Daeng Yai"
            ],
            [
              "ID" => 3506,
              "TH_NAME" => "หนองตูม",
              "EN_NAME" => "Nong Toom"
            ],
            [
              "ID" => 3511,
              "TH_NAME" => "หนองบัว",
              "EN_NAME" => "Nong Bua"
            ],
            [
              "ID" => 3521,
              "TH_NAME" => "หนองแวง",
              "EN_NAME" => "Nong Waeng"
            ],
            [
              "ID" => 3522,
              "TH_NAME" => "ขามป้อม",
              "EN_NAME" => "Kham Pom"
            ],
            [
              "ID" => 3523,
              "TH_NAME" => "หนองเรือ",
              "EN_NAME" => "Nong Rue"
            ],
            [
              "ID" => 3528,
              "TH_NAME" => "โนนทอง",
              "EN_NAME" => "Non Thong"
            ],
          [
              "ID" => 3530,
              "TH_NAME" => "โนนทัน",
              "EN_NAME" => "Non Than"
            ],
            [
              "ID" => 3531,
              "TH_NAME" => "โนนสะอาด",
              "EN_NAME" => "Non Sa-at"
            ],
            [
              "ID" => 3532,
              "TH_NAME" => "บ้านผือ",
              "EN_NAME" => "Ban Phuea"
            ],
            [
              "ID" => 3535,
              "TH_NAME" => "นาหนองทุ่ม",
              "EN_NAME" => "Na Nong Thum"
            ],
            [
              "ID" => 3536,
              "TH_NAME" => "โนนอุดม",
              "EN_NAME" => "Non Udom"
            ],
            [
              "ID" => 3538,
              "TH_NAME" => "หนองไผ่",
              "EN_NAME" => "Nong Phai"
            ],
            [
              "ID" => 3544,
              "TH_NAME" => "โนนสะอาด",
              "EN_NAME" => "Non Sa-at"
            ],
            [
              "ID" => 3546,
              "TH_NAME" => "ศรีสุข",
              "EN_NAME" => "Si Suk"
            ],
            [
              "ID" => 3553,
              "TH_NAME" => "บ้านใหม่",
              "EN_NAME" => "Ban Mai"
            ],
            [
              "ID" => 3557,
              "TH_NAME" => "หนองกุง",
              "EN_NAME" => "Nong Kung"
            ],
            [
              "ID" => 3558,
              "TH_NAME" => "บัวใหญ่",
              "EN_NAME" => "Bua Yai"
            ],
            [
              "ID" => 3560,
              "TH_NAME" => "ม่วงหวาน",
              "EN_NAME" => "Muang Wan"
            ],
            [
              "ID" => 3561,
              "TH_NAME" => "บ้านขาม",
              "EN_NAME" => "Ban Kham"
            ],
            [
              "ID" => 3563,
              "TH_NAME" => "ทรายมูล",
              "EN_NAME" => "Sai Moon"
            ],
            [
              "ID" => 3566,
              "TH_NAME" => "กุดน้ำใส",
              "EN_NAME" => "Kud Nam Sai"
            ],
            [
              "ID" => 3567,
              "TH_NAME" => "โคกสูง",
              "EN_NAME" => "Khok Sung"
            ],
            [
              "ID" => 3570,
              "TH_NAME" => "นาคำ",
              "EN_NAME" => "Na Kham"
            ]
          
          
          ];



        $setThrees = [
        [
            "ID" => 5903,
            "TH_NAME" => "เวียงชัย",
            "EN_NAME" => "Wiangchai"
        ],
        [
            "ID" => 5905,
            "TH_NAME" => "เวียงเหนือ",
            "EN_NAME" => "Wiang Nuea"
        ],
        [
            "ID" => 5910,
            "TH_NAME" => "เวียง",
            "EN_NAME" => "Wiang"
        ],
        [
            "ID" => 5911,
            "TH_NAME" => "สถาน",
            "EN_NAME" => "Sathan"
        ],
        [
            "ID" => 5922,
            "TH_NAME" => "เวียง",
            "EN_NAME" => "Wiang"
        ],
        [
            "ID" => 5923,
            "TH_NAME" => "งิ้ว",
            "EN_NAME" => "Ngiu"
        ],
        [
            "ID" => 5943,
            "TH_NAME" => "สันติสุข",
            "EN_NAME" => "Santisuk"
        ],
        [
            "ID" => 5949,
            "TH_NAME" => "ทรายขาว",
            "EN_NAME" => "Sai Khao"
        ],
        [
            "ID" => 5950,
            "TH_NAME" => "สันกลาง",
            "EN_NAME" => "San Klang"
        ],
        [
            "ID" => 5952,
            "TH_NAME" => "เมืองพาน",
            "EN_NAME" => "Mueang Phan"
        ],
        [
            "ID" => 5958,
            "TH_NAME" => "ป่าแดด",
            "EN_NAME" => "Pa Daet"
        ],
        [
            "ID" => 5961,
            "TH_NAME" => "โรงช้าง",
            "EN_NAME" => "Rong Chang"
        ],
        [
            "ID" => 5966,
            "TH_NAME" => "ป่าซาง",
            "EN_NAME" => "Pa Sang"
        ],
        [
            "ID" => 5967,
            "TH_NAME" => "สันทราย",
            "EN_NAME" => "San Sai"
        ],
        [
            "ID" => 5980,
            "TH_NAME" => "เวียง",
            "EN_NAME" => "Wiang"
        ],
        [
            "ID" => 5981,
            "TH_NAME" => "ป่าสัก",
            "EN_NAME" => "Pa Sak"
        ],
        [
            "ID" => 5988,
            "TH_NAME" => "เกาะช้าง",
            "EN_NAME" => "Kao Chang"
        ],
        [
            "ID" => 5995,
            "TH_NAME" => "ป่าแดด",
            "EN_NAME" => "Pa Daet"
        ],
        [
            "ID" => 5996,
            "TH_NAME" => "แม่พริก",
            "EN_NAME" => "Mae Phrik"
        ],
        [
            "ID" => 5997,
            "TH_NAME" => "ศรีถ้อย",
            "EN_NAME" => "Si Thoi"
        ],
        [
            "ID" => 6002,
            "TH_NAME" => "เวียง",
            "EN_NAME" => "Wiang"
        ],
        [
            "ID" => 6003,
            "TH_NAME" => "บ้านโป่ง",
            "EN_NAME" => "Ban Pong"
        ],
        [
            "ID" => 6004,
            "TH_NAME" => "ป่างิ้ว",
            "EN_NAME" => "Pa Ngiu"
        ],
        [
            "ID" => 6010,
            "TH_NAME" => "แม่ต๋ำ",
            "EN_NAME" => "Mae Tam"
        ],
        [
            "ID" => 6017,
            "TH_NAME" => "ท่าข้าม",
            "EN_NAME" => "Tha Kham"
        ],
        [
            "ID" => 6019,
            "TH_NAME" => "ป่าตาล",
            "EN_NAME" => "Pa Tan"
        ],
        [
            "ID" => 6021,
            "TH_NAME" => "เทอดไทย",
            "EN_NAME" => "Thoet Thai"
        ],
        [
            "ID" => 6032,
            "TH_NAME" => "ป่าซาง",
            "EN_NAME" => "Pa Sang"
        ],
        [
            "ID" => 6034,
            "TH_NAME" => "โชคชัย",
            "EN_NAME" => "Chokchai"
        ],
        [
            "ID" => 6037,
            "TH_NAME" => "ห้วยโป่ง",
            "EN_NAME" => "Huai Pong"
        ],
        [
            "ID" => 6052,
            "TH_NAME" => "เวียงเหนือ",
            "EN_NAME" => "Wiang Nuea"
        ],
        [
            "ID" => 6058,
            "TH_NAME" => "บ้านกาศ",
            "EN_NAME" => "Ban Kat"
        ],
        [
            "ID" => 6064,
            "TH_NAME" => "ป่าแป๋",
            "EN_NAME" => "Pa Pae"
        ],
        [
            "ID" => 6094,
            "TH_NAME" => "บางม่วง",
            "EN_NAME" => "Bang Muang"
        ],
        [
            "ID" => 6096,
            "TH_NAME" => "บ้านแก่ง",
            "EN_NAME" => "Ban Kaeng"
        ],
        [
            "ID" => 6097,
            "TH_NAME" => "พระนอน",
            "EN_NAME" => "Phra Non"
        ],
        [
            "ID" => 6101,
            "TH_NAME" => "หนองปลิง",
            "EN_NAME" => "Nong Pling"
        ],
        [
            "ID" => 6107,
            "TH_NAME" => "นากลาง",
            "EN_NAME" => "Na Klang"
        ],
        [
            "ID" => 6108,
            "TH_NAME" => "ศาลาแดง",
            "EN_NAME" => "Sala Daeng"
        ],
        [
            "ID" => 6112,
            "TH_NAME" => "ชุมแสง",
            "EN_NAME" => "Chum Saeng"
        ],
        [
            "ID" => 6124,
            "TH_NAME" => "หนองบัว",
            "EN_NAME" => "Nong Bua"
        ],
        [
            "ID" => 6130,
            "TH_NAME" => "ห้วยใหญ่",
            "EN_NAME" => "Huai Yai"
        ],
        [
            "ID" => 6131,
            "TH_NAME" => "ทุ่งทอง",
            "EN_NAME" => "Thung Thong"
        ],
        [
            "ID" => 6136,
            "TH_NAME" => "อ่างทอง",
            "EN_NAME" => "Ang Thong"
        ],
        [
            "ID" => 6138,
            "TH_NAME" => "บางแก้ว",
            "EN_NAME" => "Bang Kaew"
        ],
        [
            "ID" => 6141,
            "TH_NAME" => "ด่านช้าง",
            "EN_NAME" => "Dan Chang"
        ],
        [
            "ID" => 6142,
            "TH_NAME" => "หนองกรด",
            "EN_NAME" => "Nong Krot"
        ],
        [
            "ID" => 6146,
            "TH_NAME" => "มหาโพธิ",
            "EN_NAME" => "Maha Phothi"
        ],
        [
            "ID" => 6148,
            "TH_NAME" => "หนองเต่า",
            "EN_NAME" => "Nong Tao"
        ],
        [
            "ID" => 6149,
            "TH_NAME" => "เขาดิน",
            "EN_NAME" => "Khao Din"
        ],
        [
            "ID" => 6150,
            "TH_NAME" => "หัวดง",
            "EN_NAME" => "Hua Dong"
        ],
        [
            "ID" => 6154,
            "TH_NAME" => "ห้วยหอม",
            "EN_NAME" => "Huai Hom"
        ],
        [
            "ID" => 6163,
            "TH_NAME" => "หัวถนน",
            "EN_NAME" => "Hua Thanon"
        ],
        [
            "ID" => 6170,
            "TH_NAME" => "หนองหลวง",
            "EN_NAME" => "Nong Luang"
        ],
        [
            "ID" => 6190,
            "TH_NAME" => "ลาดยาว",
            "EN_NAME" => "Lat Yao"
        ],
        [
            "ID" => 6196,
            "TH_NAME" => "หนองยาว",
            "EN_NAME" => "Nong Yao"
        ],
        [
            "ID" => 6198,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6206,
            "TH_NAME" => "สระแก้ว",
            "EN_NAME" => "Sra Kaew"
        ],
        [
            "ID" => 6232,
            "TH_NAME" => "หนองแก",
            "EN_NAME" => "Nong Kae"
        ],
        [
            "ID" => 6234,
            "TH_NAME" => "หนองเต่า",
            "EN_NAME" => "Nong Tao"
        ],
        [
            "ID" => 6237,
            "TH_NAME" => "ทุ่งใหญ่",
            "EN_NAME" => "Thung Yai"
        ],
        [
            "ID" => 6243,
            "TH_NAME" => "หนองหญ้าปล้อง",
            "EN_NAME" => "Nong Ya Plong"
        ],
        [
            "ID" => 6244,
            "TH_NAME" => "โคกหม้อ",
            "EN_NAME" => "Khok Mo"
        ],
        [
            "ID" => 6247,
            "TH_NAME" => "หนองกระทุ่ม",
            "EN_NAME" => "Nong Krathum"
        ],
        [
            "ID" => 6250,
            "TH_NAME" => "สว่างอารมณ์",
            "EN_NAME" => "Sawang Arom"
        ],
        [
            "ID" => 6251,
            "TH_NAME" => "หนองหลวง",
            "EN_NAME" => "Nong Luang"
        ],
        [
            "ID" => 6256,
            "TH_NAME" => "หนองยาง",
            "EN_NAME" => "Nong Yang"
        ],
        [
            "ID" => 6258,
            "TH_NAME" => "หนองสรวง",
            "EN_NAME" => "Nong Sruang"
        ],
        [
            "ID" => 6259,
            "TH_NAME" => "บ้านเก่า",
            "EN_NAME" => "Ban Kao"
        ],
        [
            "ID" => 6266,
            "TH_NAME" => "หนองไผ่",
            "EN_NAME" => "Nong Phai"
        ],
        [
            "ID" => 6267,
            "TH_NAME" => "ดอนกลอย",
            "EN_NAME" => "Don Kloy"
        ],
        [
            "ID" => 6273,
            "TH_NAME" => "ดงขวาง",
            "EN_NAME" => "Dong Khwang"
        ],
        [
            "ID" => 6274,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6276,
            "TH_NAME" => "ห้วยแห้ง",
            "EN_NAME" => "Huai Haeng"
        ],
        [
            "ID" => 6278,
            "TH_NAME" => "วังหิน",
            "EN_NAME" => "Wang Hin"
        ],
        [
            "ID" => 6281,
            "TH_NAME" => "หนองจอก",
            "EN_NAME" => "Nong Jok"
        ],
        [
            "ID" => 6283,
            "TH_NAME" => "บ้านบึง",
            "EN_NAME" => "Ban Bueng"
        ],
        [
            "ID" => 6299,
            "TH_NAME" => "ทองหลาง",
            "EN_NAME" => "Thong Lang"
        ],
        [
            "ID" => 6301,
            "TH_NAME" => "ในเมือง",
            "EN_NAME" => "Nai Mueang"
        ],
        [
            "ID" => 6303,
            "TH_NAME" => "อ่างทอง",
            "EN_NAME" => "Ang Thong"
        ],
        [
            "ID" => 6310,
            "TH_NAME" => "หนองปลิง",
            "EN_NAME" => "Nong Pling"
        ],
        [
            "ID" => 6314,
            "TH_NAME" => "วังทอง",
            "EN_NAME" => "Wang Thong"
        ],
        [
            "ID" => 6319,
            "TH_NAME" => "สระแก้ว",
            "EN_NAME" => "Sra Kaew"
        ],
        [
            "ID" => 6327,
            "TH_NAME" => "มหาชัย",
            "EN_NAME" => "Mahachai"
        ],
        [
            "ID" => 6328,
            "TH_NAME" => "พานทอง",
            "EN_NAME" => "Phan Thong"
        ],
        [
            "ID" => 6331,
            "TH_NAME" => "โป่งน้ำร้อน",
            "EN_NAME" => "Pong Nam Ron"
        ],
        [
            "ID" => 6338,
            "TH_NAME" => "แสนตอ",
            "EN_NAME" => "Saen To"
        ],
        [
            "ID" => 6353,
            "TH_NAME" => "วังยาง",
            "EN_NAME" => "Wang Yang"
        ],
        [
            "ID" => 6355,
            "TH_NAME" => "หัวถนน",
            "EN_NAME" => "Hua Thanon"
        ],
        [
            "ID" => 6356,
            "TH_NAME" => "วังไทร",
            "EN_NAME" => "Wang Sai"
        ],
        [
            "ID" => 6367,
            "TH_NAME" => "ท่าไม้",
            "EN_NAME" => "Tha Mai"
        ],
        [
            "ID" => 6377,
            "TH_NAME" => "หนองหลวง",
            "EN_NAME" => "Nong Luang"
        ],
        [
            "ID" => 6383,
            "TH_NAME" => "ทุ่งทอง",
            "EN_NAME" => "Thung Thong"
        ],
        [
            "ID" => 6385,
            "TH_NAME" => "โพธิ์ทอง",
            "EN_NAME" => "Pho Thong"
        ],
        [
            "ID" => 6391,
            "TH_NAME" => "เทพนิมิต",
            "EN_NAME" => "Thep Nimit"
        ],
        [
            "ID" => 6395,
            "TH_NAME" => "ระแหง",
            "EN_NAME" => "Rahaeng"
        ],
        [
            "ID" => 6396,
            "TH_NAME" => "หนองหลวง",
            "EN_NAME" => "Nong Luang"
        ],
        [
            "ID" => 6401,
            "TH_NAME" => "โป่งแดง",
            "EN_NAME" => "Pong Daeng"
        ],
        [
            "ID" => 6403,
            "TH_NAME" => "วังหิน",
            "EN_NAME" => "Wang Hin"
        ],
        [
            "ID" => 6407,
            "TH_NAME" => "หนองบัวใต้",
            "EN_NAME" => "Nong Bua Tai"
        ],
        [
            "ID" => 6420,
            "TH_NAME" => "วังหมัน",
            "EN_NAME" => "Wang Man"
        ],
        [
            "ID" => 6422,
            "TH_NAME" => "ย่านรี",
            "EN_NAME" => "Yan Ree"
        ],
        [
            "ID" => 6423,
            "TH_NAME" => "บ้านนา",
            "EN_NAME" => "Ban Na"
        ],
        [
            "ID" => 6424,
            "TH_NAME" => "วังจันทร์",
            "EN_NAME" => "Wang Chan"
        ],
        [
            "ID" => 6428,
            "TH_NAME" => "แม่ตื่น",
            "EN_NAME" => "Mae Tuean"
        ],
        [
            "ID" => 6430,
            "TH_NAME" => "พระธาตุ",
            "EN_NAME" => "Phra That"
        ],
        [
            "ID" => 6443,
            "TH_NAME" => "แม่ปะ",
            "EN_NAME" => "Mae Pa"
        ],
        [
            "ID" => 6453,
            "TH_NAME" => "หนองหลวง",
            "EN_NAME" => "Nong Luang"
        ],
        [
            "ID" => 6455,
            "TH_NAME" => "แม่จัน",
            "EN_NAME" => "Mae Chan"
        ],
        [
            "ID" => 6462,
            "TH_NAME" => "บ้านสวน",
            "EN_NAME" => "Ban Suan"
        ],
        [
            "ID" => 6463,
            "TH_NAME" => "เมืองเก่า",
            "EN_NAME" => "Mueang Kao"
        ],
        [
            "ID" => 6466,
            "TH_NAME" => "บ้านกล้วย",
            "EN_NAME" => "Ban Kluai"
        ],
        [
            "ID" => 6472,
            "TH_NAME" => "บ้านด่าน",
            "EN_NAME" => "Ban Dan"
        ],
        [
            "ID" => 6475,
            "TH_NAME" => "ตลิ่งชัน",
            "EN_NAME" => "Taling Chan"
        ],
        [
            "ID" => 6476,
            "TH_NAME" => "หนองหญ้าปล้อง",
            "EN_NAME" => "Nong Ya Plong"
        ],
        [
            "ID" => 6478,
            "TH_NAME" => "โตนด",
            "EN_NAME" => "Ton D"
        ],
        [
            "ID" => 6479,
            "TH_NAME" => "ทุ่งหลวง",
            "EN_NAME" => "Thung Luang"
        ],
        [
            "ID" => 6480,
            "TH_NAME" => "บ้านป้อม",
            "EN_NAME" => "Ban Pom"
        ],
        [
            "ID" => 6483,
            "TH_NAME" => "หนองจิก",
            "EN_NAME" => "Nong Chik"
        ],
        [
            "ID" => 6494,
            "TH_NAME" => "ป่าแฝก",
            "EN_NAME" => "Pa Faek"
        ],
        [
            "ID" => 6496,
            "TH_NAME" => "ท่าฉนวน",
            "EN_NAME" => "Tha Chanoan"
        ],
        [
            "ID" => 6497,
            "TH_NAME" => "หนองตูม",
            "EN_NAME" => "Nong Toom"
        ],
        [
            "ID" => 6500,
            "TH_NAME" => "ป่างิ้ว",
            "EN_NAME" => "Pa Ngiu"
        ],
        [
            "ID" => 6504,
            "TH_NAME" => "หนองอ้อ",
            "EN_NAME" => "Nong O"
        ],
        [
            "ID" => 6505,
            "TH_NAME" => "ท่าชัย",
            "EN_NAME" => "Tha Chai"
        ],
        [
            "ID" => 6508,
            "TH_NAME" => "บ้านแก่ง",
            "EN_NAME" => "Ban Kaeng"
        ],
        [
            "ID" => 6511,
            "TH_NAME" => "วังลึก",
            "EN_NAME" => "Wang Luk"
        ],
        [
            "ID" => 6512,
            "TH_NAME" => "สามเรือน",
            "EN_NAME" => "Sam Ruean"
        ],
        [
            "ID" => 6513,
            "TH_NAME" => "บ้านนา",
            "EN_NAME" => "Ban Na"
        ],
        [
            "ID" => 6514,
            "TH_NAME" => "วังทอง",
            "EN_NAME" => "Wang Thong"
        ],
        [
            "ID" => 6518,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6521,
            "TH_NAME" => "วังใหญ่",
            "EN_NAME" => "Wang Yai"
        ],
        [
            "ID" => 6524,
            "TH_NAME" => "ในเมือง",
            "EN_NAME" => "Nai Mueang"
        ],
        [
            "ID" => 6533,
            "TH_NAME" => "ปากน้ำ",
            "EN_NAME" => "Pak Nam"
        ],
        [
            "ID" => 6536,
            "TH_NAME" => "หนองกลับ",
            "EN_NAME" => "Nong Klap"
        ],
        [
            "ID" => 6546,
            "TH_NAME" => "หนองบัว",
            "EN_NAME" => "Nong Bua"
        ],
        [
            "ID" => 6550,
            "TH_NAME" => "กลางดง",
            "EN_NAME" => "Klang Dong"
        ],
        [
            "ID" => 6552,
            "TH_NAME" => "ในเมือง",
            "EN_NAME" => "Nai Mueang"
        ],
        [
            "ID" => 6556,
            "TH_NAME" => "ท่าทอง",
            "EN_NAME" => "Tha Thong"
        ],
        [
            "ID" => 6559,
            "TH_NAME" => "ดอนทอง",
            "EN_NAME" => "Don Thong"
        ],
        [
            "ID" => 6560,
            "TH_NAME" => "บ้านป่า",
            "EN_NAME" => "Ban Pa"
        ],
        [
            "ID" => 6562,
            "TH_NAME" => "หัวรอ",
            "EN_NAME" => "Hua Ro"
        ],
        [
            "ID" => 6563,
            "TH_NAME" => "จอมทอง",
            "EN_NAME" => "Jom Thong"
        ],
        [
            "ID" => 6564,
            "TH_NAME" => "บ้านกร่าง",
            "EN_NAME" => "Ban Klang"
        ],
        [
            "ID" => 6571,
            "TH_NAME" => "งิ้วงาม",
            "EN_NAME" => "Ngiu Ngam"
        ],
        [
            "ID" => 6576,
            "TH_NAME" => "นาบัว",
            "EN_NAME" => "Na Bua"
        ],
        [
            "ID" => 6577,
            "TH_NAME" => "นครชุม",
            "EN_NAME" => "Nakhon Chum"
        ],
        [
            "ID" => 6581,
            "TH_NAME" => "บ้านพร้าว",
            "EN_NAME" => "Ban Prao"
        ],
        [
            "ID" => 6583,
            "TH_NAME" => "ป่าแดง",
            "EN_NAME" => "Pa Daeng"
        ],
        [
            "ID" => 6586,
            "TH_NAME" => "บ้านดง",
            "EN_NAME" => "Ban Dong"
        ],
        [
            "ID" => 6589,
            "TH_NAME" => "บางระกำ",
            "EN_NAME" => "Bang Rakam"
        ],
        [
            "ID" => 6596,
            "TH_NAME" => "นิคมพัฒนา",
            "EN_NAME" => "Nikhom Phatthana"
        ],
        [
            "ID" => 6597,
            "TH_NAME" => "บ่อทอง",
            "EN_NAME" => "Bo Thong"
        ],
        [
            "ID" => 6601,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6602,
            "TH_NAME" => "โคกสลุด",
            "EN_NAME" => "Khok Salut"
        ],
        [
            "ID" => 6605,
            "TH_NAME" => "ไผ่ล้อม",
            "EN_NAME" => "Phai Lom"
        ],
        [
            "ID" => 6610,
            "TH_NAME" => "ท่าช้าง",
            "EN_NAME" => "Tha Chang"
        ],
        [
            "ID" => 6617,
            "TH_NAME" => "หนองแขม",
            "EN_NAME" => "Nong Khaem"
        ],
        [
            "ID" => 6621,
            "TH_NAME" => "วัดโบสถ์",
            "EN_NAME" => "Wat Bosth"
        ],
        [
            "ID" => 6622,
            "TH_NAME" => "ท่างาม",
            "EN_NAME" => "Tha Ngam"
        ],
        [
            "ID" => 6624,
            "TH_NAME" => "บ้านยาง",
            "EN_NAME" => "Ban Yang"
        ],
        [
            "ID" => 6625,
            "TH_NAME" => "หินลาด",
            "EN_NAME" => "Hin Lat"
        ],
        [
            "ID" => 6627,
            "TH_NAME" => "วังทอง",
            "EN_NAME" => "Wang Thong"
        ],
        [
            "ID" => 6630,
            "TH_NAME" => "บ้านกลาง",
            "EN_NAME" => "Ban Klang"
        ],
        [
            "ID" => 6643,
            "TH_NAME" => "ชมพู",
            "EN_NAME" => "Chom Phu"
        ],
        [
            "ID" => 6645,
            "TH_NAME" => "ไทรย้อย",
            "EN_NAME" => "Sai Yoi"
        ],
        [
            "ID" => 6649,
            "TH_NAME" => "วังยาง",
            "EN_NAME" => "Wang Yang"
        ],
        [
            "ID" => 6651,
            "TH_NAME" => "ในเมือง",
            "EN_NAME" => "Nai Mueang"
        ],
        [
            "ID" => 6652,
            "TH_NAME" => "ไผ่ขวาง",
            "EN_NAME" => "Phai Khwang"
        ],
        [
            "ID" => 6653,
            "TH_NAME" => "ย่านยาว",
            "EN_NAME" => "Yan Yao"
        ],
        [
            "ID" => 6657,
            "TH_NAME" => "โรงช้าง",
            "EN_NAME" => "Rong Chang"
        ],
        [
            "ID" => 6658,
            "TH_NAME" => "เมืองเก่า",
            "EN_NAME" => "Mueang Kao"
        ],
        [
            "ID" => 6659,
            "TH_NAME" => "ท่าหลวง",
            "EN_NAME" => "Tha Luang"
        ],
        [
            "ID" => 6661,
            "TH_NAME" => "ฆะมัง",
            "EN_NAME" => "Kha Mang"
        ],
        [
            "ID" => 6663,
            "TH_NAME" => "หัวดง",
            "EN_NAME" => "Hua Dong"
        ],
        [
            "ID" => 6670,
            "TH_NAME" => "ดงกลาง",
            "EN_NAME" => "Dong Klang"
        ],
        [
            "ID" => 6680,
            "TH_NAME" => "หนองปลาไหล",
            "EN_NAME" => "Nong Plai"
        ],
        [
            "ID" => 6681,
            "TH_NAME" => "หนองพระ",
            "EN_NAME" => "Nong Phra"
        ],
        [
            "ID" => 6682,
            "TH_NAME" => "หนองปล้อง",
            "EN_NAME" => "Nong Plong"
        ],
        [
            "ID" => 6689,
            "TH_NAME" => "ทุ่งใหญ่",
            "EN_NAME" => "Thung Yai"
        ],
        [
            "ID" => 6691,
            "TH_NAME" => "งิ้วราย",
            "EN_NAME" => "Ngiu Rai"
        ],
        [
            "ID" => 6695,
            "TH_NAME" => "ทุ่งโพธิ์",
            "EN_NAME" => "Thung Pho"
        ],
        [
            "ID" => 6699,
            "TH_NAME" => "วังหว้า",
            "EN_NAME" => "Wang Wa"
        ],
        [
            "ID" => 6708,
            "TH_NAME" => "บางไผ่",
            "EN_NAME" => "Bang Phai"
        ],
        [
            "ID" => 6710,
            "TH_NAME" => "เนินมะกอก",
            "EN_NAME" => "Noen Makok"
        ],
        [
            "ID" => 6711,
            "TH_NAME" => "วังสำโรง",
            "EN_NAME" => "Wang Samrong"
        ],
        [
            "ID" => 6722,
            "TH_NAME" => "โพทะเล",
            "EN_NAME" => "Pho Thale"
        ],
        [
            "ID" => 6728,
            "TH_NAME" => "ท่าเสา",
            "EN_NAME" => "Tha Sao"
        ],
        [
            "ID" => 6738,
            "TH_NAME" => "สามง่าม",
            "EN_NAME" => "Sam Ngam"
        ],
        [
            "ID" => 6744,
            "TH_NAME" => "หนองโสน",
            "EN_NAME" => "Nong Son"
        ],
        [
            "ID" => 6752,
            "TH_NAME" => "ท่าเยี่ยม",
            "EN_NAME" => "Tha Yiam"
        ],
        [
            "ID" => 6756,
            "TH_NAME" => "ห้วยแก้ว",
            "EN_NAME" => "Huai Kaew"
        ],
        [
            "ID" => 6763,
            "TH_NAME" => "ห้วยร่วม",
            "EN_NAME" => "Huai Ruam"
        ],
        [
            "ID" => 6766,
            "TH_NAME" => "บ้านนา",
            "EN_NAME" => "Ban Na"
        ],
        [
            "ID" => 6770,
            "TH_NAME" => "ในเมือง",
            "EN_NAME" => "Nai Mueang"
        ],
        [
            "ID" => 6775,
            "TH_NAME" => "นางั่ว",
            "EN_NAME" => "Nang Ua"
        ],
        [
            "ID" => 6778,
            "TH_NAME" => "บ้านโคก",
            "EN_NAME" => "Ban Khok"
        ],
        [
            "ID" => 6780,
            "TH_NAME" => "นาป่า",
            "EN_NAME" => "Na Pa"
        ],
        [
            "ID" => 6781,
            "TH_NAME" => "นายม",
            "EN_NAME" => "Nayom"
        ],
        [
            "ID" => 6782,
            "TH_NAME" => "วังชมภู",
            "EN_NAME" => "Wang Chom Phu"
        ],
        [
            "ID" => 6785,
            "TH_NAME" => "ห้วยใหญ่",
            "EN_NAME" => "Huai Yai"
        ],
        [
            "ID" => 6787,
            "TH_NAME" => "ชนแดน",
            "EN_NAME" => "Chon Daen"
        ],
        [
            "ID" => 6789,
            "TH_NAME" => "ท่าข้าม",
            "EN_NAME" => "Tha Kham"
        ],
        [
            "ID" => 6792,
            "TH_NAME" => "บ้านกล้วย",
            "EN_NAME" => "Ban Kluai"
        ],
        [
            "ID" => 6801,
            "TH_NAME" => "ตาลเดี่ยว",
            "EN_NAME" => "Tal Diao"
        ],
        [
            "ID" => 6807,
            "TH_NAME" => "บ้านโสก",
            "EN_NAME" => "Ban Sok"
        ],
        [
            "ID" => 6809,
            "TH_NAME" => "ห้วยไร่",
            "EN_NAME" => "Huai Rai"
        ],
        [
            "ID" => 6811,
            "TH_NAME" => "ปากช่อง",
            "EN_NAME" => "Pak Chong"
        ],
        [
            "ID" => 6815,
            "TH_NAME" => "บุ่งคล้า",
            "EN_NAME" => "Bung Kla"
        ],
        [
            "ID" => 6817,
            "TH_NAME" => "บ้านกลาง",
            "EN_NAME" => "Ban Klang"
        ],
        [
            "ID" => 6819,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6821,
            "TH_NAME" => "บ้านหวาย",
            "EN_NAME" => "Ban Wai"
        ],
        [
            "ID" => 6827,
            "TH_NAME" => "ศิลา",
            "EN_NAME" => "Sila"
        ],
        [
            "ID" => 6828,
            "TH_NAME" => "นาแซง",
            "EN_NAME" => "Na Saeng"
        ],
        [
            "ID" => 6835,
            "TH_NAME" => "สามแยก",
            "EN_NAME" => "Sam Yaek"
        ],
        [
            "ID" => 6837,
            "TH_NAME" => "น้ำร้อน",
            "EN_NAME" => "Nam Ron"
        ],
        [
            "ID" => 6842,
            "TH_NAME" => "ซับสมบูรณ์",
            "EN_NAME" => "Sap Samboon"
        ],
        [
            "ID" => 6844,
            "TH_NAME" => "วังใหญ่",
            "EN_NAME" => "Wang Yai"
        ],
        [
            "ID" => 6855,
            "TH_NAME" => "โคกสะอาด",
            "EN_NAME" => "Khok Sa-at"
        ],
        [
            "ID" => 6864,
            "TH_NAME" => "ห้วยโป่ง",
            "EN_NAME" => "Huai Pong"
        ],
        [
            "ID" => 6867,
            "TH_NAME" => "หนองไผ่",
            "EN_NAME" => "Nong Phai"
        ],
        [
            "ID" => 6875,
            "TH_NAME" => "วังพิกุล",
            "EN_NAME" => "Wang Phikul"
        ],
        [
            "ID" => 6878,
            "TH_NAME" => "สระแก้ว",
            "EN_NAME" => "Sra Kaeo"
        ],
        [
            "ID" => 6887,
            "TH_NAME" => "วังหิน",
            "EN_NAME" => "Wang Hin"
        ],
        [
            "ID" => 6896,
            "TH_NAME" => "หน้าเมือง",
            "EN_NAME" => "Na Mueang"
        ],
        [
            "ID" => 6900,
            "TH_NAME" => "ห้วยไผ่",
            "EN_NAME" => "Huai Phai"
        ],
        [
            "ID" => 6903,
            "TH_NAME" => "อ่างทอง",
            "EN_NAME" => "Ang Thong"
        ],
        [
            "ID" => 6904,
            "TH_NAME" => "โคกหม้อ",
            "EN_NAME" => "Khok Mo"
        ],
        [
            "ID" => 6905,
            "TH_NAME" => "สามเรือน",
            "EN_NAME" => "Sam Reuan"
        ],
        [
            "ID" => 6906,
            "TH_NAME" => "พิกุลทอง",
            "EN_NAME" => "Phikul Thong"
        ],
        [
            "ID" => 6909,
            "TH_NAME" => "หินกอง",
            "EN_NAME" => "Hin Kong"
        ],
        [
            "ID" => 6917,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6919,
            "TH_NAME" => "ปากช่อง",
            "EN_NAME" => "Pak Chong"
        ],
        [
            "ID" => 6940,
            "TH_NAME" => "บัวงาม",
            "EN_NAME" => "Bua Ngam"
        ],
        [
            "ID" => 6941,
            "TH_NAME" => "บ้านไร่",
            "EN_NAME" => "Ban Rai"
        ],
        [
            "ID" => 6947,
            "TH_NAME" => "บ้านโป่ง",
            "EN_NAME" => "Ban Pong"
        ],
        [
            "ID" => 6948,
            "TH_NAME" => "ท่าผา",
            "EN_NAME" => "Tha Pha"
        ],
        [
            "ID" => 6951,
            "TH_NAME" => "หนองกบ",
            "EN_NAME" => "Nong Khop"
        ],
        [
            "ID" => 6952,
            "TH_NAME" => "หนองอ้อ",
            "EN_NAME" => "Nong Ao"
        ],
        [
            "ID" => 6954,
            "TH_NAME" => "สวนกล้วย",
            "EN_NAME" => "Suan Kluai"
        ],
        [
            "ID" => 6956,
            "TH_NAME" => "บ้านม่วง",
            "EN_NAME" => "Ban Muang"
        ],
        [
            "ID" => 6958,
            "TH_NAME" => "หนองปลาหมอ",
            "EN_NAME" => "Nong Pla Mo"
        ],
        [
            "ID" => 6960,
            "TH_NAME" => "เบิกไพร",
            "EN_NAME" => "Beik Phrai"
        ],
        [
            "ID" => 6961,
            "TH_NAME" => "ลาดบัวขาว",
            "EN_NAME" => "Lad Buakhao"
        ],
        [
            "ID" => 6963,
            "TH_NAME" => "วังเย็น",
            "EN_NAME" => "Wang Yen"
        ],
        [
            "ID" => 6966,
            "TH_NAME" => "ดอนใหญ่",
            "EN_NAME" => "Don Yai"
        ],
        [
            "ID" => 6967,
            "TH_NAME" => "ดอนคา",
            "EN_NAME" => "Don Ka"
        ],
        [
            "ID" => 6970,
            "TH_NAME" => "ดอนกระเบื้อง",
            "EN_NAME" => "Don Krabuang"
        ],
        [
            "ID" => 6971,
            "TH_NAME" => "หนองโพ",
            "EN_NAME" => "Nong Pho"
        ],
        [
            "ID" => 6975,
            "TH_NAME" => "บ้านสิงห์",
            "EN_NAME" => "Ban Sing"
        ],
        [
            "ID" => 6976,
            "TH_NAME" => "ดอนทราย",
            "EN_NAME" => "Don Sai"
        ],
        [
            "ID" => 6978,
            "TH_NAME" => "คลองข่อย",
            "EN_NAME" => "Khlong Khoi"
        ],
        [
            "ID" => 6983,
            "TH_NAME" => "เตาปูน",
            "EN_NAME" => "Tao Poon"
        ],
        [
            "ID" => 6988,
            "TH_NAME" => "ทุ่งหลวง",
            "EN_NAME" => "Thung Luang"
        ],
        [
            "ID" => 6990,
            "TH_NAME" => "ดอนทราย",
            "EN_NAME" => "Don Sai"
        ],
        [
            "ID" => 6991,
            "TH_NAME" => "หนองกระทุ่ม",
            "EN_NAME" => "Nong Krathum"
        ],
        [
            "ID" => 7003,
            "TH_NAME" => "บ้านคา",
            "EN_NAME" => "Ban Ka"
        ],
        [
            "ID" => 7004,
            "TH_NAME" => "บ้านบึง",
            "EN_NAME" => "Ban Bueng"
        ],
        [
            "ID" => 7011,
            "TH_NAME" => "หนองบัว",
            "EN_NAME" => "Nong Bua"
        ],
        [
            "ID" => 7018,
            "TH_NAME" => "บ้านเก่า",
            "EN_NAME" => "Ban Kao"
        ],
        [
            "ID" => 7021,
            "TH_NAME" => "วังเย็น",
            "EN_NAME" => "Wang Yen"
        ],
        [
            "ID" => 7023,
            "TH_NAME" => "ท่าเสา",
            "EN_NAME" => "Tha Sao"
        ],
        [
            "ID" => 7024,
            "TH_NAME" => "สิงห์",
            "EN_NAME" => "Sing"
        ],
        [
            "ID" => 7026,
            "TH_NAME" => "วังกระแจะ",
            "EN_NAME" => "Wang Krajae"
        ],
        [
            "ID" => 7027,
            "TH_NAME" => "ศรีมงคล",
            "EN_NAME" => "Si Mongkol"
        ],
        [
            "ID" => 7029,
            "TH_NAME" => "บ่อพลอย",
            "EN_NAME" => "Bo Ploy"
        ],
        [
            "ID" => 7031,
            "TH_NAME" => "หนองรี",
            "EN_NAME" => "Nong Ri"
        ],
        [
            "ID" => 7040,
            "TH_NAME" => "หนองเป็ด",
            "EN_NAME" => "Nong Pet"
        ],
        [
            "ID" => 7041,
            "TH_NAME" => "ท่ากระดาน",
            "EN_NAME" => "Tha Kradan"
        ],
        [
            "ID" => 7047,
            "TH_NAME" => "ท่าไม้",
            "EN_NAME" => "Tha Mai"
        ],
        [
            "ID" => 7050,
            "TH_NAME" => "ท่าเรือ",
            "EN_NAME" => "Tha Rue"
        ],
        [
            "ID" => 7057,
            "TH_NAME" => "แสนตอ",
            "EN_NAME" => "Saen To"
        ],
        [
            "ID" => 7059,
            "TH_NAME" => "ท่าเสา",
            "EN_NAME" => "Tha Sao"
        ],
        [
            "ID" => 7061,
            "TH_NAME" => "ท่าม่วง",
            "EN_NAME" => "Tha Muang"
        ],
        [
            "ID" => 7066,
            "TH_NAME" => "ทุ่งทอง",
            "EN_NAME" => "Thung Thong"
        ],
        [
            "ID" => 7067,
            "TH_NAME" => "เขาน้อย",
            "EN_NAME" => "Khao Noi"
        ],
        [
            "ID" => 7069,
            "TH_NAME" => "บ้านใหม่",
            "EN_NAME" => "Ban Mai"
        ],
        [
            "ID" => 7076,
            "TH_NAME" => "หินดาด",
            "EN_NAME" => "Hin Dad"
        ],
        [
            "ID" => 7085,
            "TH_NAME" => "หนองโรง",
            "EN_NAME" => "Nong Rong"
        ],
        [
            "ID" => 7086,
            "TH_NAME" => "ทุ่งสมอ",
            "EN_NAME" => "Thung Somo"
        ],
        [
            "ID" => 7088,
            "TH_NAME" => "พังตรุ",
            "EN_NAME" => "Pang Tru"
        ],
        [
            "ID" => 7094,
            "TH_NAME" => "หนองสาหร่าย",
            "EN_NAME" => "Nong Sahrai"
        ],
        [
            "ID" => 7097,
            "TH_NAME" => "หนองโสน",
            "EN_NAME" => "Nong Son"
        ],
        [
            "ID" => 7099,
            "TH_NAME" => "หนองปลิง",
            "EN_NAME" => "Nong Pling"
        ],
        [
            "ID" => 7106,
            "TH_NAME" => "หนองไผ่",
            "EN_NAME" => "Nong Phai"
        ],
        [
            "ID" => 7107,
            "TH_NAME" => "หนองปรือ",
            "EN_NAME" => "Nong Pru"
        ],
        [
            "ID" => 7108,
            "TH_NAME" => "หนองปลาไหล",
            "EN_NAME" => "Nong Pla Lai"
        ],
        [
            "ID" => 7118,
            "TH_NAME" => "ไผ่ขวาง",
            "EN_NAME" => "Phai Khwang"
        ],
        [
            "ID" => 7120,
            "TH_NAME" => "ดอนตาล",
            "EN_NAME" => "Don Tal"
        ],
        [
            "ID" => 7125,
            "TH_NAME" => "บ้านโพธิ์",
            "EN_NAME" => "Ban Pho"
        ],
        [
            "ID" => 7126,
            "TH_NAME" => "สระแก้ว",
            "EN_NAME" => "Sra Kaeo"
        ],
        [
            "ID" => 7127,
            "TH_NAME" => "ตลิ่งชัน",
            "EN_NAME" => "Taling Chan"
        ],
        [
            "ID" => 7128,
            "TH_NAME" => "บางกุ้ง",
            "EN_NAME" => "Bang Kung"
        ],
        [
            "ID" => 7131,
            "TH_NAME" => "สนามชัย",
            "EN_NAME" => "Sanam Chai"
        ],
        [
            "ID" => 7133,
            "TH_NAME" => "สนามคลี",
            "EN_NAME" => "Sanam Khlī"
        ],
        [
            "ID" => 7134,
            "TH_NAME" => "เขาพระ",
            "EN_NAME" => "Khao Phra"
        ],
        [
            "ID" => 7137,
            "TH_NAME" => "เขาดิน",
            "EN_NAME" => "Khao Din"
        ],
        [
            "ID" => 7138,
            "TH_NAME" => "ปากน้ำ",
            "EN_NAME" => "Pak Nam"
        ],
        [
            "ID" => 7140,
            "TH_NAME" => "โคกช้าง",
            "EN_NAME" => "Khok Chang"
        ],
        [
            "ID" => 7142,
            "TH_NAME" => "หัวนา",
            "EN_NAME" => "Hua Na"
        ],
        [
            "ID" => 7147,
            "TH_NAME" => "หนองกระทุ่ม",
            "EN_NAME" => "Nong Krathum"
        ],
        [
            "ID" => 7153,
            "TH_NAME" => "ด่านช้าง",
            "EN_NAME" => "Dan Chang"
        ],
        [
            "ID" => 7154,
            "TH_NAME" => "ห้วยขมิ้น",
            "EN_NAME" => "Huai Khamin"
        ],
        [
            "ID" => 7158,
            "TH_NAME" => "วังยาว",
            "EN_NAME" => "Wang Yao"
        ],
        [
            "ID" => 7162,
            "TH_NAME" => "บางใหญ่",
            "EN_NAME" => "Bang Yai"
        ],
        [
            "ID" => 7163,
            "TH_NAME" => "กฤษณา",
            "EN_NAME" => "Kritsana"
        ],
        [
            "ID" => 7166,
            "TH_NAME" => "องครักษ์",
            "EN_NAME" => "Ongkharak"
        ],
        [
            "ID" => 7170,
            "TH_NAME" => "วังน้ำเย็น",
            "EN_NAME" => "Wang Nam Yen"
        ],
        [
            "ID" => 7171,
            "TH_NAME" => "วัดโบสถ์",
            "EN_NAME" => "Wat Bots"
        ],
        [
            "ID" => 7174,
            "TH_NAME" => "บ้านกร่าง",
            "EN_NAME" => "Ban Khlang"
        ],
        [
            "ID" => 7179,
            "TH_NAME" => "วังหว้า",
            "EN_NAME" => "Wang Wa"
        ],
        [
            "ID" => 7181,
            "TH_NAME" => "วังยาง",
            "EN_NAME" => "Wang Yang"
        ],
        [
            "ID" => 7182,
            "TH_NAME" => "ดอนเจดีย์",
            "EN_NAME" => "Don Chedi"
        ],
        [
            "ID" => 7183,
            "TH_NAME" => "หนองสาหร่าย",
            "EN_NAME" => "Nong Sahrai"
        ],
        [
            "ID" => 7187,
            "TH_NAME" => "สองพี่น้อง",
            "EN_NAME" => "Song Phi Nong"
        ],
        [
            "ID" => 7188,
            "TH_NAME" => "บางเลน",
            "EN_NAME" => "Bang Len"
        ],
        [
            "ID" => 7191,
            "TH_NAME" => "บ้านกุ่ม",
            "EN_NAME" => "Ban Kum"
        ],
        [
            "ID" => 7193,
            "TH_NAME" => "บางพลับ",
            "EN_NAME" => "Bang Phlat"
        ],
        [
            "ID" => 7195,
            "TH_NAME" => "บ้านช้าง",
            "EN_NAME" => "Ban Chang"
        ],
        [
            "ID" => 7196,
            "TH_NAME" => "ต้นตาล",
            "EN_NAME" => "Ton Tal"
        ],
        [
            "ID" => 7197,
            "TH_NAME" => "ศรีสำราญ",
            "EN_NAME" => "Si Samran"
        ],
        [
            "ID" => 7199,
            "TH_NAME" => "หนองบ่อ",
            "EN_NAME" => "Nong Bo"
        ],
        [
            "ID" => 7202,
            "TH_NAME" => "ย่านยาว",
            "EN_NAME" => "Yan Yao"
        ],
        [
            "ID" => 7203,
            "TH_NAME" => "วังลึก",
            "EN_NAME" => "Wang Luk"
        ],
        [
            "ID" => 7216,
            "TH_NAME" => "บ้านดอน",
            "EN_NAME" => "Ban Don"
        ],
        [
            "ID" => 7220,
            "TH_NAME" => "ดอนคา",
            "EN_NAME" => "Don Ka"
        ],
        [
            "ID" => 7226,
            "TH_NAME" => "หนองหญ้าไซ",
            "EN_NAME" => "Nong Ya Sai"
        ],
        [
            "ID" => 7228,
            "TH_NAME" => "หนองโพธิ์",
            "EN_NAME" => "Nong Pho"
        ],
        [
            "ID" => 7230,
            "TH_NAME" => "หนองขาม",
            "EN_NAME" => "Nong Kham"
        ],
        [
            "ID" => 7231,
            "TH_NAME" => "ทัพหลวง",
            "EN_NAME" => "Thap Luang"
        ],
        [
            "ID" => 7238,
            "TH_NAME" => "สนามจันทร์",
            "EN_NAME" => "Sanam Chan"
        ],
        [
            "ID" => 7243,
            "TH_NAME" => "วังตะกู",
            "EN_NAME" => "Wang Takoo"
        ],
        [
            "ID" => 7246,
            "TH_NAME" => "ทุ่งน้อย",
            "EN_NAME" => "Thung Noi"
        ],
        [
            "ID" => 7248,
            "TH_NAME" => "วังเย็น",
            "EN_NAME" => "Wang Yen"
        ],
        [
            "ID" => 7254,
            "TH_NAME" => "ทัพหลวง",
            "EN_NAME" => "Thap Luang"
        ],
        [
            "ID" => 7255,
            "TH_NAME" => "หนองงูเหลือม",
            "EN_NAME" => "Nong Ngu Luem"
        ],
        [
            "ID" => 7256,
            "TH_NAME" => "บ้านยาง",
            "EN_NAME" => "Ban Yang"
        ],
        [
            "ID" => 7260,
            "TH_NAME" => "ห้วยขวาง",
            "EN_NAME" => "Huai Khwang"
        ],
        [
            "ID" => 7261,
            "TH_NAME" => "ทุ่งขวาง",
            "EN_NAME" => "Thung Khwang"
        ],
        [
            "ID" => 7267,
            "TH_NAME" => "ห้วยม่วง",
            "EN_NAME" => "Huai Muang"
        ],
        [
            "ID" => 7270,
            "TH_NAME" => "หนองกระทุ่ม",
            "EN_NAME" => "Nong Krathum"
        ],
        [
            "ID" => 7271,
            "TH_NAME" => "วังน้ำเขียว",
            "EN_NAME" => "Wang Nam Khieo"
        ],
        [
            "ID" => 7273,
            "TH_NAME" => "บางกระเบา",
            "EN_NAME" => "Bang Krabao"
        ],
        [
            "ID" => 7276,
            "TH_NAME" => "บางแก้ว",
            "EN_NAME" => "Bang Kaeo"
        ],
        [
            "ID" => 7281,
            "TH_NAME" => "บางระกำ",
            "EN_NAME" => "Bang Rakam"
        ],
        [
            "ID" => 7291,
            "TH_NAME" => "บางพระ",
            "EN_NAME" => "Bang Phra"
        ],
        [
            "ID" => 7294,
            "TH_NAME" => "งิ้วราย",
            "EN_NAME" => "Ngio Rai"
        ],
        [
            "ID" => 7302,
            "TH_NAME" => "สามง่าม",
            "EN_NAME" => "Sam Ngam"
        ],
        [
            "ID" => 7306,
            "TH_NAME" => "บ้านหลวง",
            "EN_NAME" => "Ban Luang"
        ],
        [
            "ID" => 7310,
            "TH_NAME" => "บางเลน",
            "EN_NAME" => "Bang Len"
        ],
        [
            "ID" => 7311,
            "TH_NAME" => "บางปลา",
            "EN_NAME" => "Bang Pla"
        ],
        [
            "ID" => 7312,
            "TH_NAME" => "บางหลวง",
            "EN_NAME" => "Bang Luang"
        ],
        [
            "ID" => 7314,
            "TH_NAME" => "บางระกำ",
            "EN_NAME" => "Bang Rakam"
        ],
        [
            "ID" => 7317,
            "TH_NAME" => "ไทรงาม",
            "EN_NAME" => "Sai Ngam"
        ],
        [
            "ID" => 7325,
            "TH_NAME" => "ท่าข้าม",
            "EN_NAME" => "Tha Kham"
        ],
        [
            "ID" => 7326,
            "TH_NAME" => "ทรงคนอง",
            "EN_NAME" => "Song Khanong"
        ],
        [
            "ID" => 7329,
            "TH_NAME" => "บางเตย",
            "EN_NAME" => "Bang Taye"
        ],
        [
            "ID" => 7339,
            "TH_NAME" => "บ้านใหม่",
            "EN_NAME" => "Baan Mai"
        ],
        [
            "ID" => 7343,
            "TH_NAME" => "มหาสวัสดิ์",
            "EN_NAME" => "Maha Sawat"
        ],
        [
            "ID" => 7344,
            "TH_NAME" => "มหาชัย",
            "EN_NAME" => "Maha Chai"
        ],
        [
            "ID" => 7352,
            "TH_NAME" => "นาดี",
            "EN_NAME" => "Na Dee"
        ],
        [
            "ID" => 7353,
            "TH_NAME" => "ท่าทราย",
            "EN_NAME" => "Tha Sai"
        ],
        [
            "ID" => 7358,
            "TH_NAME" => "บ้านเกาะ",
            "EN_NAME" => "Baan Ko"
        ],
        [
            "ID" => 7360,
            "TH_NAME" => "บางหญ้าแพรก",
            "EN_NAME" => "Bang Ya Pae"
        ],
        [
            "ID" => 7364,
            "TH_NAME" => "ท่าไม้",
            "EN_NAME" => "Tha Mai"
        ],
        [
            "ID" => 7365,
            "TH_NAME" => "สวนหลวง",
            "EN_NAME" => "Suan Luang"
        ],
        [
            "ID" => 7366,
            "TH_NAME" => "บางยาง",
            "EN_NAME" => "Bang Yang"
        ],
        [
            "ID" => 7371,
            "TH_NAME" => "ท่าเสา",
            "EN_NAME" => "Tha Sao"
        ],
        [
            "ID" => 7374,
            "TH_NAME" => "ยกกระบัตร",
            "EN_NAME" => "Yok Krabat"
        ],
        [
            "ID" => 7376,
            "TH_NAME" => "หนองสองห้อง",
            "EN_NAME" => "Nong Song Hong"
        ],
        [
            "ID" => 7377,
            "TH_NAME" => "หนองบัว",
            "EN_NAME" => "Nong Bua"
        ],
        [
            "ID" => 7378,
            "TH_NAME" => "หลักสอง",
            "EN_NAME" => "Lak Song"
        ],
        [
            "ID" => 7380,
            "TH_NAME" => "คลองตัน",
            "EN_NAME" => "Klong Tan"
        ],
        [
            "ID" => 7384,
            "TH_NAME" => "แม่กลอง",
            "EN_NAME" => "Mae Klong"
        ],
        [
            "ID" => 7386,
            "TH_NAME" => "ลาดใหญ่",
            "EN_NAME" => "Lat Yai"
        ],
        [
            "ID" => 7388,
            "TH_NAME" => "บางแก้ว",
            "EN_NAME" => "Bang Kaew"
        ],
        [
            "ID" => 7401,
            "TH_NAME" => "บางพรม",
            "EN_NAME" => "Bang Phrom"
        ],
        [
            "ID" => 7402,
            "TH_NAME" => "บางกุ้ง",
            "EN_NAME" => "Bang Kung"
        ],
        [
            "ID" => 7406,
            "TH_NAME" => "บางกระบือ",
            "EN_NAME" => "Bang Krabuea"
        ],
        [
            "ID" => 7409,
            "TH_NAME" => "สวนหลวง",
            "EN_NAME" => "Suan Luang"
        ],
        [
            "ID" => 7413,
            "TH_NAME" => "บางช้าง",
            "EN_NAME" => "Bang Chang"
        ],
        [
            "ID" => 7416,
            "TH_NAME" => "บางแค",
            "EN_NAME" => "Bang Khae"
        ],
        [
            "ID" => 7420,
            "TH_NAME" => "ท่าราบ",
            "EN_NAME" => "Tha Rap"
        ],
        [
            "ID" => 7425,
            "TH_NAME" => "บ้านกุ่ม",
            "EN_NAME" => "Baan Kum"
        ],
        [
            "ID" => 7426,
            "TH_NAME" => "หนองโสน",
            "EN_NAME" => "Nong Son"
        ],
        [
            "ID" => 7429,
            "TH_NAME" => "บางจาก",
            "EN_NAME" => "Bang Chak"
        ],
        [
            "ID" => 7430,
            "TH_NAME" => "บ้านหม้อ",
            "EN_NAME" => "Baan Mo"
        ],
        [
            "ID" => 7446,
            "TH_NAME" => "สระพัง",
            "EN_NAME" => "Sa Pang"
        ],
        [
            "ID" => 7449,
            "TH_NAME" => "หนองปลาไหล",
            "EN_NAME" => "Nong Pla Lai"
        ],
        [
            "ID" => 7452,
            "TH_NAME" => "ห้วยโรง",
            "EN_NAME" => "Huai Rong"
        ],
        [
            "ID" => 7458,
            "TH_NAME" => "หนองหญ้าปล้อง",
            "EN_NAME" => "Nong Ya Plong"
        ],
        [
            "ID" => 7461,
            "TH_NAME" => "ท่าตะคร้อ",
            "EN_NAME" => "Tha Takro"
        ],
        [
            "ID" => 7464,
            "TH_NAME" => "นายาง",
            "EN_NAME" => "Na Yang"
        ],
        [
            "ID" => 7474,
            "TH_NAME" => "หนองจอก",
            "EN_NAME" => "Nong Chok"
        ],
        [
            "ID" => 7504,
            "TH_NAME" => "โรงเข้",
            "EN_NAME" => "Rong Khee"
        ],
        [
            "ID" => 7507,
            "TH_NAME" => "ท่าช้าง",
            "EN_NAME" => "Tha Chang"
        ],
        [
            "ID" => 7510,
            "TH_NAME" => "บ้านแหลม",
            "EN_NAME" => "Baan Laem"
        ],
        [
            "ID" => 7513,
            "TH_NAME" => "บางแก้ว",
            "EN_NAME" => "Bang Kaew"
        ],
        [
            "ID" => 7518,
            "TH_NAME" => "ท่าแร้ง",
            "EN_NAME" => "Tha Raeng"
        ],
        [
            "ID" => 7521,
            "TH_NAME" => "สองพี่น้อง",
            "EN_NAME" => "Song Phi Nong"
        ],
        [
            "ID" => 7522,
            "TH_NAME" => "วังจันทร์",
            "EN_NAME" => "Wang Chan"
        ],
        [
            "ID" => 7529,
            "TH_NAME" => "ห้วยทราย",
            "EN_NAME" => "Huai Sai"
        ],
        [
            "ID" => 7540,
            "TH_NAME" => "อ่างทอง",
            "EN_NAME" => "Ang Thong"
        ],
        [
            "ID" => 7543,
            "TH_NAME" => "ห้วยยาง",
            "EN_NAME" => "Huai Yang"
        ],
        [
            "ID" => 7547,
            "TH_NAME" => "ร่อนทอง",
            "EN_NAME" => "Ron Thong"
        ],
        [
            "ID" => 7548,
            "TH_NAME" => "ธงชัย",
            "EN_NAME" => "Thong Chai"
        ],
        [
            "ID" => 7552,
            "TH_NAME" => "ปากแพรก",
            "EN_NAME" => "Pak Praek"
        ],
        [
            "ID" => 7554,
            "TH_NAME" => "ทรายทอง",
            "EN_NAME" => "Sai Thong"
        ],
        [
            "ID" => 7558,
            "TH_NAME" => "เขาน้อย",
            "EN_NAME" => "Khao Noi"
        ],
        [
            "ID" => 7566,
            "TH_NAME" => "หัวหิน",
            "EN_NAME" => "Hua Hin"
        ],
        [
            "ID" => 7567,
            "TH_NAME" => "หนองแก",
            "EN_NAME" => "Nong Kae"
        ],
        [
            "ID" => 7568,
            "TH_NAME" => "หินเหล็กไฟ",
            "EN_NAME" => "Hin Lek Fai"
        ],
        [
            "ID" => 7569,
            "TH_NAME" => "หนองพลับ",
            "EN_NAME" => "Nong Plab"
        ],
        [
            "ID" => 7572,
            "TH_NAME" => "บึงนคร",
            "EN_NAME" => "Bueng Nakhon"
        ],
        [
            "ID" => 7578,
            "TH_NAME" => "ในเมือง",
            "EN_NAME" => "Nai Mueang"
        ],
        [
            "ID" => 7585,
            "TH_NAME" => "นาทราย",
            "EN_NAME" => "Na Sai"
        ],
        [
            "ID" => 7593,
            "TH_NAME" => "ท่างิ้ว",
            "EN_NAME" => "Tha Ngew"
        ],
        [
            "ID" => 7596,
            "TH_NAME" => "บางจาก",
            "EN_NAME" => "Bang Chak"
        ],
        [
            "ID" => 7599,
            "TH_NAME" => "ท่าเรือ",
            "EN_NAME" => "Tha Reua"
        ],
        [
            "ID" => 7606,
            "TH_NAME" => "บ้านเกาะ",
            "EN_NAME" => "Baan Ko"
        ],
        [
            "ID" => 7610,
            "TH_NAME" => "เขาแก้ว",
            "EN_NAME" => "Khao Kaew"
        ],
        [
            "ID" => 7633,
            "TH_NAME" => "เขาพระ",
            "EN_NAME" => "Khao Phra"
        ],
        [
            "ID" => 7639,
            "TH_NAME" => "บ้านกลาง",
            "EN_NAME" => "Baan Klang"
        ],
        [
            "ID" => 7640,
            "TH_NAME" => "บ้านเนิน",
            "EN_NAME" => "Baan Noen"
        ],
        [
            "ID" => 7662,
            "TH_NAME" => "ท่าศาลา",
            "EN_NAME" => "Tha Sala"
        ],
        [
            "ID" => 7665,
            "TH_NAME" => "หัวตะพาน",
            "EN_NAME" => "Hua Tapan"
        ],
        [
            "ID" => 7667,
            "TH_NAME" => "สระแก้ว",
            "EN_NAME" => "Sa Kaeo"
        ],
        [
            "ID" => 7671,
            "TH_NAME" => "ดอนตะโก",
            "EN_NAME" => "Don Takho"
        ],
        [
            "ID" => 7672,
            "TH_NAME" => "ตลิ่งชัน",
            "EN_NAME" => "Taling Chan"
        ],
        [
            "ID" => 7674,
            "TH_NAME" => "โพธิ์ทอง",
            "EN_NAME" => "Pho Thong"
        ],
        [
            "ID" => 7676,
            "TH_NAME" => "ปากแพรก",
            "EN_NAME" => "Pak Praek"
        ],
        [
            "ID" => 7685,
            "TH_NAME" => "น้ำตก",
            "EN_NAME" => "Namtok"
        ],
        [
            "ID" => 7687,
            "TH_NAME" => "นาโพธิ์",
            "EN_NAME" => "Na Pho"
        ],
        [
            "ID" => 7695,
            "TH_NAME" => "นาบอน",
            "EN_NAME" => "Na Bon"
        ],
        [
            "ID" => 7698,
            "TH_NAME" => "ท่ายาง",
            "EN_NAME" => "Tha Yang"
        ],
        [
            "ID" => 7700,
            "TH_NAME" => "ทุ่งใหญ่",
            "EN_NAME" => "Thung Yai"
        ],
        [
            "ID" => 7706,
            "TH_NAME" => "คลองน้อย",
            "EN_NAME" => "Klong Noi"
        ],
        [
            "ID" => 7711,
            "TH_NAME" => "บ้านใหม่",
            "EN_NAME" => "Baan Mai"
        ],
        [
            "ID" => 7716,
            "TH_NAME" => "บางพระ",
            "EN_NAME" => "Bang Phra"
        ],
        [
            "ID" => 7721,
            "TH_NAME" => "ปากแพรก",
            "EN_NAME" => "Pak Praek"
        ],
        [
            "ID" => 7725,
            "TH_NAME" => "เสาธง",
            "EN_NAME" => "Sao Thong"
        ],
        [
            "ID" => 7740,
            "TH_NAME" => "เทพราช",
            "EN_NAME" => "Thep Rat"
        ],
        [
            "ID" => 7741,
            "TH_NAME" => "เขาน้อย",
            "EN_NAME" => "Khao Noi"
        ],
        [
            "ID" => 7746,
            "TH_NAME" => "หัวไทร",
            "EN_NAME" => "Hua Sai"
        ],
        [
            "ID" => 7748,
            "TH_NAME" => "ทรายขาว",
            "EN_NAME" => "Sai Khao"
        ],
        [
            "ID" => 7759,
            "TH_NAME" => "วังหิน",
            "EN_NAME" => "Wang Hin"
        ],
        [
            "ID" => 7763,
            "TH_NAME" => "ดุสิต",
            "EN_NAME" => "Dusit"
        ],
        [
            "ID" => 7767,
            "TH_NAME" => "ทุ่งโพธิ์",
            "EN_NAME" => "Thung Pho"
        ],
        [
            "ID" => 7783,
            "TH_NAME" => "สวนหลวง",
            "EN_NAME" => "Suan Luang"
        ],
        [
            "ID" => 7785,
            "TH_NAME" => "ปากน้ำ",
            "EN_NAME" => "Pak Nam"
        ],
        [
            "ID" => 7790,
            "TH_NAME" => "เขาทอง",
            "EN_NAME" => "Khao Thong"
        ],
        [
            "ID" => 7812,
            "TH_NAME" => "เขาดิน",
            "EN_NAME" => "Khao Din"
        ],
        [
            "ID" => 7820,
            "TH_NAME" => "คลองยาง",
            "EN_NAME" => "Klong Yang"
        ],
        [
            "ID" => 7825,
            "TH_NAME" => "ทรายขาว",
            "EN_NAME" => "Sai Khao"
        ],
        [
            "ID" => 7836,
            "TH_NAME" => "เขาใหญ่",
            "EN_NAME" => "Khao Yai"
        ],
        [
            "ID" => 7838,
            "TH_NAME" => "บ้านกลาง",
            "EN_NAME" => "Baan Klang"
        ],
        [
            "ID" => 7849,
            "TH_NAME" => "ดินแดง",
            "EN_NAME" => "Din Daeng"
        ],
        [
            "ID" => 7854,
            "TH_NAME" => "โคกยาง",
            "EN_NAME" => "Khok Yang"
        ],
        [
            "ID" => 7855,
            "TH_NAME" => "ตลิ่งชัน",
            "EN_NAME" => "Taling Chan"
        ],
        [
            "ID" => 7861,
            "TH_NAME" => "บางเตย",
            "EN_NAME" => "Bang Taye"
        ],
        [
            "ID" => 7862,
            "TH_NAME" => "ตากแดด",
            "EN_NAME" => "Tak Daed"
        ],
        [
            "ID" => 7866,
            "TH_NAME" => "ป่ากอ",
            "EN_NAME" => "Pa Ko"
        ],
        [
            "ID" => 7884,
            "TH_NAME" => "ตะกั่วป่า",
            "EN_NAME" => "Takua Pa"
        ],
        [
            "ID" => 7886,
            "TH_NAME" => "บางไทร",
            "EN_NAME" => "Bang Sai"
        ],
        [
            "ID" => 7887,
            "TH_NAME" => "บางม่วง",
            "EN_NAME" => "Bang Muang"
        ],
        [
            "ID" => 7901,
            "TH_NAME" => "โคกเจริญ",
            "EN_NAME" => "Khok Charoen"
        ],
        [
            "ID" => 7909,
            "TH_NAME" => "ตลาดใหญ่",
            "EN_NAME" => "Talat Yai"
        ],
        [
            "ID" => 7911,
            "TH_NAME" => "เกาะแก้ว",
            "EN_NAME" => "Ko Kaew"
        ],
        [
            "ID" => 7914,
            "TH_NAME" => "ฉลอง",
            "EN_NAME" => "Chalong"
        ],
        [
            "ID" => 7926,
            "TH_NAME" => "ตลาด",
            "EN_NAME" => "Talat"
        ],
        [
            "ID" => 7928,
            "TH_NAME" => "วัดประดู่",
            "EN_NAME" => "Wat Pradu"
        ],
        [
            "ID" => 7929,
            "TH_NAME" => "ขุนทะเล",
            "EN_NAME" => "Khun Thale"
        ],
        [
            "ID" => 7932,
            "TH_NAME" => "คลองน้อย",
            "EN_NAME" => "Klong Noi"
        ],
        [
            "ID" => 7933,
            "TH_NAME" => "บางไทร",
            "EN_NAME" => "Bang Sai"
        ],
        [
            "ID" => 7935,
            "TH_NAME" => "บางกุ้ง",
            "EN_NAME" => "Bang Kung"
        ],
        [
            "ID" => 7938,
            "TH_NAME" => "ท่าทอง",
            "EN_NAME" => "Tha Thong"
        ],
        [
            "ID" => 7942,
            "TH_NAME" => "ช้างซ้าย",
            "EN_NAME" => "Chang Sai"
        ],
        [
            "ID" => 7945,
            "TH_NAME" => "ตะเคียนทอง",
            "EN_NAME" => "Takhian Thong"
        ],
        [
            "ID" => 7953,
            "TH_NAME" => "ปากแพรก",
            "EN_NAME" => "Pak Praek"
        ],
        [
            "ID" => 7954,
            "TH_NAME" => "อ่างทอง",
            "EN_NAME" => "Ang Thong"
        ],
        [
            "ID" => 7957,
            "TH_NAME" => "หน้าเมือง",
            "EN_NAME" => "Na Mueang"
        ],
        [
            "ID" => 7962,
            "TH_NAME" => "บ้านใต้",
            "EN_NAME" => "Baan Tai"
        ],
        [
            "ID" => 7967,
            "TH_NAME" => "เวียง",
            "EN_NAME" => "Wiang"
        ],
        [
            "ID" => 7980,
            "TH_NAME" => "บ้านยาง",
            "EN_NAME" => "Baan Yang"
        ],
        [
            "ID" => 7985,
            "TH_NAME" => "ท่ากระดาน",
            "EN_NAME" => "Tha Kradaan"
        ],
        [
            "ID" => 7986,
            "TH_NAME" => "ย่านยาว",
            "EN_NAME" => "Yan Yao"
        ],
        [
            "ID" => 7990,
            "TH_NAME" => "เขาวง",
            "EN_NAME" => "Khao Wong"
        ],
        [
            "ID" => 7991,
            "TH_NAME" => "พะแสง",
            "EN_NAME" => "Phasaeng"
        ],
        [
            "ID" => 8002,
            "TH_NAME" => "ท่าเคย",
            "EN_NAME" => "Tha Koey"
        ],
        [
            "ID" => 8007,
            "TH_NAME" => "นาสาร",
            "EN_NAME" => "Na Sar"
        ],
        [
            "ID" => 8015,
            "TH_NAME" => "น้ำพุ",
            "EN_NAME" => "Nam Phu"
        ],
        [
            "ID" => 8020,
            "TH_NAME" => "บ้านนา",
            "EN_NAME" => "Baan Na"
        ],
        [
            "ID" => 8021,
            "TH_NAME" => "ท่าเรือ",
            "EN_NAME" => "Tha Reua"
        ],
        [
            "ID" => 8028,
            "TH_NAME" => "บ้านเสด็จ",
            "EN_NAME" => "Baan Sed"
        ],
        [
            "ID" => 8032,
            "TH_NAME" => "ทุ่งหลวง",
            "EN_NAME" => "Thung Luang"
        ],
        [
            "ID" => 8035,
            "TH_NAME" => "สินปุน",
            "EN_NAME" => "Sin Pun"
        ],
        [
            "ID" => 8040,
            "TH_NAME" => "สาคู",
            "EN_NAME" => "Saku"
        ],
        [
            "ID" => 8043,
            "TH_NAME" => "ท่าข้าม",
            "EN_NAME" => "Tha Kham"
        ],
        [
            "ID" => 8049,
            "TH_NAME" => "กรูด",
            "EN_NAME" => "Kroot"
        ],
        [
            "ID" => 8052,
            "TH_NAME" => "ศรีวิชัย",
            "EN_NAME" => "Srivichai"
        ],
        [
                "ID" => 8053,
                "TH_NAME" => "น้ำรอบ",
                "EN_NAME" => "Nam Rob"
            ],
            [
                "ID" => 8056,
                "TH_NAME" => "หนองไทร",
                "EN_NAME" => "Nong Sai"
            ],
            [
                "ID" => 8060,
                "TH_NAME" => "สองแพรก",
                "EN_NAME" => "Song Pae"
            ],
            [
                "ID" => 8062,
                "TH_NAME" => "คลองน้อย",
                "EN_NAME" => "Klong Noi"
            ],
            [
                "ID" => 8063,
                "TH_NAME" => "ไทรทอง",
                "EN_NAME" => "Sai Thong"
            ],
            [
                "ID" => 8068,
                "TH_NAME" => "หงาว",
                "EN_NAME" => "Hngao"
            ],
            [
                "ID" => 8070,
                "TH_NAME" => "ปากน้ำ",
                "EN_NAME" => "Pak Nam"
            ],
            [
                "ID" => 8079,
                "TH_NAME" => "บางแก้ว",
                "EN_NAME" => "Bang Kaeo"
            ],
            [
                "ID" => 8085,
                "TH_NAME" => "บ้านนา",
                "EN_NAME" => "Ban Na"
            ],
            [
                "ID" => 8092,
                "TH_NAME" => "ปากจั่น",
                "EN_NAME" => "Pak Chan"
            ],
            [
                "ID" => 8095,
                "TH_NAME" => "บางใหญ่",
                "EN_NAME" => "Bang Yai"
            ],
            [
                "ID" => 8099,
                "TH_NAME" => "ปากน้ำ",
                "EN_NAME" => "Pak Nam"
            ],
            [
                "ID" => 8100,
                "TH_NAME" => "ท่ายาง",
                "EN_NAME" => "Tha Yang"
            ],
            [
                "ID" => 8102,
                "TH_NAME" => "นาทุ่ง",
                "EN_NAME" => "Na Thung"
            ],
            [
                "ID" => 8104,
                "TH_NAME" => "ตากแดด",
                "EN_NAME" => "Tak Daed"
            ],
            [
                "ID" => 8107,
                "TH_NAME" => "วังไผ่",
                "EN_NAME" => "Wang Phai"
            ],
            [
                "ID" => 8108,
                "TH_NAME" => "วังใหม่",
                "EN_NAME" => "Wang Mai"
            ],
            [
                "ID" => 8109,
                "TH_NAME" => "บ้านนา",
                "EN_NAME" => "Ban Na"
            ],
            [
                "ID" => 8120,
                "TH_NAME" => "ท่าข้าม",
                "EN_NAME" => "Tha Kham"
            ],
            [
                "ID" => 8124,
                "TH_NAME" => "สองพี่น้อง",
                "EN_NAME" => "Song Phi Nong"
            ],
            [
                "ID" => 8129,
                "TH_NAME" => "ดอนยาง",
                "EN_NAME" => "Don Yang"
            ],
            [
                "ID" => 8135,
                "TH_NAME" => "นาขา",
                "EN_NAME" => "Na Kha"
            ],
            [
                "ID" => 8139,
                "TH_NAME" => "บางน้ำจืด",
                "EN_NAME" => "Bang Nam Chued"
            ],
            [
                "ID" => 8140,
                "TH_NAME" => "ปากน้ำ",
                "EN_NAME" => "Pak Nam"
            ],
            [
                "ID" => 8146,
                "TH_NAME" => "ทุ่งหลวง",
                "EN_NAME" => "Thung Luang"
            ],
            [
                "ID" => 8147,
                "TH_NAME" => "สวนแตง",
                "EN_NAME" => "Suan Taeng"
            ],
            [
                "ID" => 8153,
                "TH_NAME" => "นาโพธิ์",
                "EN_NAME" => "Na Po"
            ],
            [
                "ID" => 8156,
                "TH_NAME" => "ท่าหิน",
                "EN_NAME" => "Tha Hin"
            ],
            [
                "ID" => 8157,
                "TH_NAME" => "ปากแพรก",
                "EN_NAME" => "Pak Pae"
            ],
            [
                "ID" => 8161,
                "TH_NAME" => "นาสัก",
                "EN_NAME" => "Na Sak"
            ],
            [
                "ID" => 8166,
                "TH_NAME" => "ตะโก",
                "EN_NAME" => "Takho"
            ],
            [
                "ID" => 8168,
                "TH_NAME" => "บ่อยาง",
                "EN_NAME" => "Bo Yang"
            ],
            [
                "ID" => 8198,
                "TH_NAME" => "กระดังงา",
                "EN_NAME" => "Kradangnga"
            ],
            [
                "ID" => 8199,
                "TH_NAME" => "สนามชัย",
                "EN_NAME" => "Sanam Chai"
            ],
            [
                "ID" => 8201,
                "TH_NAME" => "ชุมพล",
                "EN_NAME" => "Chumphon"
            ],
            [
                "ID" => 8204,
                "TH_NAME" => "ท่าหิน",
                "EN_NAME" => "Tha Hin"
            ],
            [
                "ID" => 8205,
                "TH_NAME" => "วัดจันทร์",
                "EN_NAME" => "Wat Chan"
            ],
            [
                "ID" => 8208,
                "TH_NAME" => "บ้านนา",
                "EN_NAME" => "Ban Na"
            ],
            [
                "ID" => 8212,
                "TH_NAME" => "นาหว้า",
                "EN_NAME" => "Na Wa"
            ],
            [
                "ID" => 8221,
                "TH_NAME" => "ตลิ่งชัน",
                "EN_NAME" => "Taling Chan"
            ],
            [
                "ID" => 8225,
                "TH_NAME" => "คลองทราย",
                "EN_NAME" => "Klong Sai"
            ],
            [
                "ID" => 8227,
                "TH_NAME" => "ท่าประดู่",
                "EN_NAME" => "Tha Pradu"
            ],
            [
                "ID" => 8229,
                "TH_NAME" => "ทับช้าง",
                "EN_NAME" => "Thap Chang"
            ],
            [
                "ID" => 8236,
                "TH_NAME" => "ท่าม่วง",
                "EN_NAME" => "Tha Muang"
            ],
            [
                "ID" => 8237,
                "TH_NAME" => "วังใหญ่",
                "EN_NAME" => "Wang Yai"
            ],
            [
                "ID" => 8238,
                "TH_NAME" => "สะกอม",
                "EN_NAME" => "Sakom"
            ],
            [
                "ID" => 8245,
                "TH_NAME" => "เขาแดง",
                "EN_NAME" => "Khao Daeng"
            ],
            [
                "ID" => 8252,
                "TH_NAME" => "บ้านใหม่",
                "EN_NAME" => "Ban Mai"
            ],
            [
                "ID" => 8258,
                "TH_NAME" => "บ้านขาว",
                "EN_NAME" => "Ban Khao"
            ],
            [
                "ID" => 8275,
                "TH_NAME" => "เขาพระ",
                "EN_NAME" => "Khao Phra"
            ],
            [
                "ID" => 8280,
                "TH_NAME" => "สะเดา",
                "EN_NAME" => "Sadeao"
            ],
            [
                "ID" => 8281,
                "TH_NAME" => "ปริก",
                "EN_NAME" => "Prik"
            ],
            [
                "ID" => 8285,
                "TH_NAME" => "ท่าโพธิ์",
                "EN_NAME" => "Tha Po"
            ],
            [
                "ID" => 8299,
                "TH_NAME" => "ทุ่งใหญ่",
                "EN_NAME" => "Thung Yai"
            ],
            [
                "ID" => 8301,
                "TH_NAME" => "ท่าข้าม",
                "EN_NAME" => "Tha Kham"
            ],
            [
                "ID" => 8325,
                "TH_NAME" => "ห้วยลึก",
                "EN_NAME" => "Huai Luek"
            ],
            [
                "ID" => 8326,
                "TH_NAME" => "บางเหรียง",
                "EN_NAME" => "Bang Riang"
            ],
            [
                "ID" => 8328,
                "TH_NAME" => "ท่าช้าง",
                "EN_NAME" => "Tha Chang"
            ],
            [
                "ID" => 8333,
                "TH_NAME" => "ทำนบ",
                "EN_NAME" => "Thamnop"
            ],
            [
                "ID" => 8336,
                "TH_NAME" => "ชะแล้",
                "EN_NAME" => "Chalae"
            ],
            [
                "ID" => 8339,
                "TH_NAME" => "หัวเขา",
                "EN_NAME" => "Hua Khao"
            ],
            [
                "ID" => 8341,
                "TH_NAME" => "ม่วงงาม",
                "EN_NAME" => "Muang Ngam"
            ],
            [
                "ID" => 8344,
                "TH_NAME" => "โคกม่วง",
                "EN_NAME" => "Khok Muang"
            ],
            [
                "ID" => 8347,
                "TH_NAME" => "พิมาน",
                "EN_NAME" => "Pimarn"
            ],
            [
                "ID" => 8348,
                "TH_NAME" => "คลองขุด",
                "EN_NAME" => "Klong Khud"
            ],
            [
                "ID" => 8350,
                "TH_NAME" => "บ้านควน",
                "EN_NAME" => "Ban Khuan"
            ],
            [
                "ID" => 8351,
                "TH_NAME" => "ฉลุง",
                "EN_NAME" => "Chalong"
            ],
            [
                "ID" => 8362,
                "TH_NAME" => "ย่านซื่อ",
                "EN_NAME" => "Yan Sue"
            ],
            [
                "ID" => 8372,
                "TH_NAME" => "ท่าเรือ",
                "EN_NAME" => "Tha Rue"
            ],
            [
                "ID" => 8373,
                "TH_NAME" => "กำแพง",
                "EN_NAME" => "Khampaeng"
            ],
            [
                "ID" => 8375,
                "TH_NAME" => "เขาขาว",
                "EN_NAME" => "Khao Khao"
            ],
            [
                "ID" => 8376,
                "TH_NAME" => "ปากน้ำ",
                "EN_NAME" => "Pak Nam"
            ],
            [
                "ID" => 8385,
                "TH_NAME" => "นิคมพัฒนา",
                "EN_NAME" => "Nikhom Pattana"
            ],
            [
                "ID" => 8390,
                "TH_NAME" => "บ้านควน",
                "EN_NAME" => "Ban Khuan"
            ],
            [
                "ID" => 8394,
                "TH_NAME" => "บางรัก",
                "EN_NAME" => "Bang Rak"
            ],
            [
                "ID" => 8400,
                "TH_NAME" => "น้ำผุด",
                "EN_NAME" => "Nam Phud"
            ],
            [
                "ID" => 8403,
                "TH_NAME" => "บ้านโพธิ์",
                "EN_NAME" => "Ban Po"
            ],
            [
                "ID" => 8415,
                "TH_NAME" => "บางหมาก",
                "EN_NAME" => "Bang Mak"
            ],
            [
                "ID" => 8417,
                "TH_NAME" => "วังวน",
                "EN_NAME" => "Wang Won"
            ],
            [
                "ID" => 8419,
                "TH_NAME" => "โคกยาง",
                "EN_NAME" => "Khok Yang"
            ],
            [
                "ID" => 8421,
                "TH_NAME" => "ย่านซื่อ",
                "EN_NAME" => "Yan Sue"
            ],
            [
                "ID" => 8424,
                "TH_NAME" => "นาเกลือ",
                "EN_NAME" => "Na Kluea"
            ],
            [
                "ID" => 8428,
                "TH_NAME" => "หนองบ่อ",
                "EN_NAME" => "Nong Bo"
            ],
            [
                "ID" => 8435,
                "TH_NAME" => "ท่าข้าม",
                "EN_NAME" => "Tha Kham"
            ],
            [
                "ID" => 8436,
                "TH_NAME" => "ทุ่งยาว",
                "EN_NAME" => "Thung Yao"
            ],
            [
                "ID" => 8438,
                "TH_NAME" => "บางด้วน",
                "EN_NAME" => "Bang Duan"
            ],
            [
                "ID" => 8441,
                "TH_NAME" => "บ้านนา",
                "EN_NAME" => "Ban Na"
            ],
            [
                "ID" => 8449,
                "TH_NAME" => "เขาไม้แก้ว",
                "EN_NAME" => "Khao Mai Kaeo"
            ],
            [
                "ID" => 8463,
                "TH_NAME" => "บางกุ้ง",
                "EN_NAME" => "Bang Kung"
            ],
            [
                "ID" => 8465,
                "TH_NAME" => "เขาขาว",
                "EN_NAME" => "Khao Khao"
            ],
            [
                "ID" => 8471,
                "TH_NAME" => "ท่างิ้ว",
                "EN_NAME" => "Tha Ngio"
            ],
            [
                "ID" => 8496,
                "TH_NAME" => "หนองบัว",
                "EN_NAME" => "Nong Bua"
            ],
            [
                "ID" => 8497,
                "TH_NAME" => "หนองปรือ",
                "EN_NAME" => "Nong Pru"
            ],
            [
                "ID" => 8502,
                "TH_NAME" => "คูหาสวรรค์",
                "EN_NAME" => "Kuhha Sawarn"
            ],
            [
                "ID" => 8509,
                "TH_NAME" => "ท่าแค",
                "EN_NAME" => "Tha Kae"
            ],
            [
                "ID" => 8514,
                "TH_NAME" => "ชัยบุรี",
                "EN_NAME" => "Chai Buri"
            ],
            [
                "ID" => 8531,
                "TH_NAME" => "โคกม่วง",
                "EN_NAME" => "Khok Muang"
            ],
            [
                "ID" => 8540,
                "TH_NAME" => "คลองใหญ่",
                "EN_NAME" => "Klong Yai"
            ],
            [
                "ID" => 8541,
                "TH_NAME" => "ควนขนุน",
                "EN_NAME" => "Khuan Khanun"
            ],
            [
                "ID" => 8550,
                "TH_NAME" => "ดอนทราย",
                "EN_NAME" => "Don Sai"
            ],
            [
                "ID" => 8564,
                "TH_NAME" => "เกาะหมาก",
                "EN_NAME" => "Ko Mak"
            ],
            [
                "ID" => 8567,
                "TH_NAME" => "ดอนทราย",
                "EN_NAME" => "Don Sai"
            ],
            [
                "ID" => 8578,
                "TH_NAME" => "วังใหม่",
                "EN_NAME" => "Wang Mai"
            ],
            [
                "ID" => 8584,
                "TH_NAME" => "เกาะเต่า",
                "EN_NAME" => "Ko Tao"
            ],
            [
                "ID" => 8585,
                "TH_NAME" => "บ้านพร้าว",
                "EN_NAME" => "Ban Prao"
            ],
            [
                "ID" => 8586,
                "TH_NAME" => "ชุมพล",
                "EN_NAME" => "Chumphon"
            ],
            [
                "ID" => 8587,
                "TH_NAME" => "บ้านนา",
                "EN_NAME" => "Ban Na"
            ],
            [
                "ID" => 8588,
                "TH_NAME" => "อ่างทอง",
                "EN_NAME" => "Ang Thong"
            ],
            [
                "ID" => 8606,
                "TH_NAME" => "ป่าบอน",
                "EN_NAME" => "Pa Bon"
            ],
            [
                "ID" => 8607,
                "TH_NAME" => "ทรายขาว",
                "EN_NAME" => "Sai Khao"
            ],
            [
                "ID" => 8613,
                "TH_NAME" => "ท่าเรือ",
                "EN_NAME" => "Tha Rue"
            ],
            [
                "ID" => 8624,
                "TH_NAME" => "บ่อทอง",
                "EN_NAME" => "Bo Thong"
            ],
            [
                "ID" => 8631,
                "TH_NAME" => "ท่าข้าม",
                "EN_NAME" => "Tha Kham"
            ],
            [
                "ID" => 8633,
                "TH_NAME" => "ดอน",
                "EN_NAME" => "Don"
            ],
            [
                "ID" => 8636,
                "TH_NAME" => "คอกกระบือ",
                "EN_NAME" => "Khok Krabuea"
            ],
            [
                "ID" => 8638,
                "TH_NAME" => "บ้านกลาง",
                "EN_NAME" => "Ban Klang"
            ],
            [
                "ID" => 8660,
                "TH_NAME" => "บางเก่า",
                "EN_NAME" => "Bang Kao"
            ],
            [
                "ID" => 8664,
                "TH_NAME" => "ละหาร",
                "EN_NAME" => "La Han"
            ],
            [
                "ID" => 8668,
                "TH_NAME" => "ไทรทอง",
                "EN_NAME" => "Sai Thong"
            ],
            [
                "ID" => 8671,
                "TH_NAME" => "ดอนทราย",
                "EN_NAME" => "Don Sai"
            ],
            [
                "ID" => 8680,
                "TH_NAME" => "บางปู",
                "EN_NAME" => "Bang Pu"
            ],
            [
                "ID" => 8698,
                "TH_NAME" => "คลองใหม่",
                "EN_NAME" => "Klong Mai"
            ],
            [
                "ID" => 8705,
                "TH_NAME" => "แม่ลาน",
                "EN_NAME" => "Mae Lan"
            ],
            [
                "ID" => 8706,
                "TH_NAME" => "ม่วงเตี้ย",
                "EN_NAME" => "Muang Tia"
            ],
            [
                "ID" => 8707,
                "TH_NAME" => "ป่าไร่",
                "EN_NAME" => "Pa Rai"
            ],
            [
                "ID" => 8735,
                "TH_NAME" => "ตลิ่งชัน",
                "EN_NAME" => "Taling Chan"
            ],
            [
                "ID" => 8777,
                "TH_NAME" => "ลำภู",
                "EN_NAME" => "Lam Phu"
            ],
            [
                "ID" => 8782,
                "TH_NAME" => "โคกเคียน",
                "EN_NAME" => "Khok Kian"
            ],
            [
                "ID" => 8785,
                "TH_NAME" => "พร่อน",
                "EN_NAME" => "Phron"
            ],
            [
                "ID" => 8791,
                "TH_NAME" => "บาเจาะ",
                "EN_NAME" => "Ba Cho"
            ],
            [
                "ID" => 8798,
                "TH_NAME" => "ละหาร",
                "EN_NAME" => "La Han"
            ],
            [
                "ID" => 8818,
                "TH_NAME" => "สามัคคี",
                "EN_NAME" => "Samakkhi"
            ],
            [
                "ID" => 8830,
                "TH_NAME" => "กาหลง",
                "EN_NAME" => "Kalong"
            ],
            [
                "ID" => 8832,
                "TH_NAME" => "แว้ง",
                "EN_NAME" => "Waeng"
            ],
            [
                "ID" => 8837,
                "TH_NAME" => "เอราวัณ",
                "EN_NAME" => "Erawan"
            ],
            [
                "ID" => 8842,
                "TH_NAME" => "ภูเขาทอง",
                "EN_NAME" => "Phu Khao Thong"
            ],
            [
                "ID" => 8857,
                "TH_NAME" => "ช้างเผือก",
                "EN_NAME" => "Chang Phueak"
            ],
            [
                "ID" => 8861,
                "TH_NAME" => "สะพานสอง",
                "EN_NAME" => "Saphan Song"
            ],
            [
                "ID" => 8862,
                "TH_NAME" => "คลองเจ้าคุณสิงห์",
                "EN_NAME" => "Klong Chao Khun Sing"
            ],
            [
                "ID" => 8863,
                "TH_NAME" => "พลับพลา",
                "EN_NAME" => "Phlat Phla"
            ],
            [
                "ID" => 8867,
                "TH_NAME" => "ดอนเมือง",
                "EN_NAME" => "Don Mueang"
            ],
            [
                "ID" => 8868,
                "TH_NAME" => "สนามบิน",
                "EN_NAME" => "Sanam Bin"
            ],
            [
                "ID" => 8869,
                "TH_NAME" => "วงศ์สว่าง",
                "EN_NAME" => "Wong Sawang"
            ],
            [
                "ID" => 8871,
                "TH_NAME" => "รัชดาภิเษก",
                "EN_NAME" => "Ratchadaphisek"
            ]


        ];

          
        foreach ($setOnes as $setOne) {
            // Update the District where DISTRICT_ID matches the ID
            District::where('DISTRICT_ID', $setOne['ID'])
                    ->update(['DISTRICT_NAME_EN' => $setOne['EN_NAME']]);
        }

        foreach ($setTwos as $setTwo) {
            // Update the District where DISTRICT_ID matches the ID
            District::where('DISTRICT_ID', $setTwo['ID'])
                    ->update(['DISTRICT_NAME_EN' => $setTwo['EN_NAME']]);
        }

        foreach ($setThrees as $setThree) {
            // Update the District where DISTRICT_ID matches the ID
            District::where('DISTRICT_ID', $setThree['ID'])
                    ->update(['DISTRICT_NAME_EN' => $setThree['EN_NAME']]);
        }

        return "Done";
    }

    public function update13id()
    {
        // ดึงข้อมูลผู้ลงนามทั้งหมดจากตาราง besurv_signers
        $signers = DB::table('besurv_signers')->get();

        foreach ($signers as $signer) {
            $rawName = $signer->name;

            $prefixes = ["นาย", "นาง", "นางสาว"];
            $rawName = str_replace($prefixes, '', $rawName);
            
            $rawName = trim($rawName);
            $nameParts = explode(" ", $rawName);
            $firstName = isset($nameParts[0]) ? trim($nameParts[0]) : '';
            $lastName = isset($nameParts[1]) ? trim($nameParts[1]) : '';

            $staff = Staff::where('reg_fname', $firstName)
                ->where('reg_lname', $lastName)
                ->first();

            if ($staff !== null) {
                echo "พบข้อมูล Staff:\n";
                echo "ID: {$staff->runrecno}\n";
                echo "ชื่อ: {$staff->reg_fname} {$staff->reg_lname}\n";

                // อัปเดตโดยใช้ DB::table
                DB::table('besurv_signers')
                    ->where('id', $signer->id)
                    ->update(['user_register_id' => $staff->runrecno]);
            }
        }
    }

    public function getCalScopeData()
    {
     $latestCertiLab = CertiLab::latest('created_at')->first();
 
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
 
     public function getPageList($scopes,$pdfData,$details)
     {
 
         $pageArray = $this->getFirstPageList($scopes,$pdfData,$details);
 
         $firstPageArray = $pageArray[0];
 
         // ดึงค่า index ด้วย array_map และ array access
         $indexes = array_map(function ($item) {
             return $item->index;
         }, $firstPageArray[0]);
 
         $filteredScopes = array_filter($scopes, function ($item) use ($indexes) {
             return !in_array($item->index, $indexes);
         });
         
         $filteredScopes = array_values($filteredScopes);
 
         $pageArray = $this->getOtherPageList($filteredScopes,$pdfData,$details);
 
         $mergedArray = array_merge($firstPageArray, $pageArray);
         return $mergedArray;
     }
     
     public function getFirstPageList($scopes,$pdfData,$details)
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
 
         $chunks = $this->generateRangesWithData($scopes,$pdf);
 
         $firstPage = array_slice($chunks, 0, 1);
 
         $remainingItems = array_slice($chunks, 1);
 
         return [$firstPage,$remainingItems,$chunks];
     }
 
     public function getOtherPageList($scope,$pdfData,$details)
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
 
         $chunks = $this->generateRangesWithData($scope,$pdf);
         
         // $firstPage = reset($chunks);
 
         // $remainingItems = array_slice($chunks, 1);
 
         // dd($chunks,$firstPage,$remainingItems);
 
         return $chunks;
    
     }
 
     function generateRangesWithData($data, $pdf)
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
 

     public function generateScopePDF()
     {
      // $certilab = CertiLab::find(2085);
    

      $certilab = CertiLab::orderBy('id', 'desc')->first();

      $pdfService = new CreateLabScopePdf($certilab);
      $pdfContent = $pdfService->generatePdf();
     }

   public function generatePdfLabScope()
   {
       
       $siteType = "single";
       $data = $this->getCalScopeData()->getData();
       
       // dd($data);
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
 
           $scopePages = $this->getPageList($scopes,$pdfData,$details);
           
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
                 
   
           $data = $this->getCalScopeData()->getData();
   
           $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
           $mpdf->WriteHTML($stylesheet, 1);
   
           // $mpdf->SetWatermarkImage(public_path(...), opacity, [size], [position]); 
   
          //  $mpdf->SetWatermarkImage(public_path('images/nc_logo.jpg'), 1, [23, 23], [170, 4]);
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
 
       $combinedPdf = new Mpdf([
           'PDFA'             => $type == 'F' ? true : false,
           'PDFAauto'         => $type == 'F' ? true : false,
           'format'           => 'A4',
           'mode'             => 'utf-8',
           'default_font_size'=> '15',
           'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
           'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
           'default_font'     => 'thsarabunnew',
       ]);
       
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
 
   public function generatePDF()
   {
      $latestCertiLab = CertiLab::latest('created_at')->first();
      $pdfService = new CreateLabScopePdf($latestCertiLab);
      $pdfContent = $pdfService->generatePdf();
   }

   public function financeData()
   {
    // การใช้งาน
    // $fiscalData = $this->getAllFiscalYearData();

    // foreach ($fiscalData as $data) {
    //     echo "Fiscal Year: " . $data['fiscal_year'] . "<br>";
    //     echo "Count: " . $data['count'] . "<br>";
    //     echo "Request Numbers: " . implode(', ', $data['request_numbers']->toArray()) . "<br>====<br>";
    // }

    // การใช้งาน
      $currentFiscalData = $this->getCurrentFiscalYearData();

      echo "Fiscal Year: " . $currentFiscalData['fiscal_year'] . "<br>";
      echo "Count: " . $currentFiscalData['count'] . "<br>";
      echo "Request Numbers: " . implode(', ', $currentFiscalData['request_numbers']->toArray()) . "<br>";
   }

   function getCurrentFiscalYearData()
{
    // คำนวณช่วงปีงบประมาณปัจจุบัน
    $currentDate = now();
    $currentYear = $currentDate->month >= 10 ? $currentDate->year : $currentDate->year - 1;

    $startOfFiscalYear = Carbon::createFromDate($currentYear, 10, 1)->startOfDay();
    $endOfFiscalYear = Carbon::createFromDate($currentYear + 1, 9, 30)->endOfDay();

    // นับจำนวนรายการในปีงบประมาณปัจจุบัน
    $count = CertificateExport::whereBetween('created_at', [$startOfFiscalYear, $endOfFiscalYear])->count();

    // ดึง request_no ทั้งหมดในปีงบประมาณปัจจุบัน
    $requestNumbers = CertificateExport::whereBetween('created_at', [$startOfFiscalYear, $endOfFiscalYear])
        ->pluck('request_number');

    // คืนค่าข้อมูลปีงบประมาณปัจจุบัน
    return [
        'fiscal_year' => $currentYear,
        'count' => $count,
        'request_numbers' => $requestNumbers,
    ];
}

   function getAllFiscalYearData()
  {
      // ดึงวันที่แรกและวันที่สุดท้ายจากข้อมูลในตาราง
      $firstDate = CertificateExport::min('created_at');
      $lastDate = CertificateExport::max('created_at');

      if (!$firstDate || !$lastDate) {
          // กรณีไม่มีข้อมูลในตาราง
          return [];
      }

      // คำนวณปีงบประมาณเริ่มต้นและสิ้นสุด
      $startYear = Carbon::parse($firstDate)->year;
      $endYear = Carbon::parse($lastDate)->year;

      $fiscalData = [];

      // ลูปทุกปีงบประมาณตั้งแต่ปีเริ่มต้นจนถึงปีสิ้นสุด
      for ($year = $startYear; $year <= $endYear; $year++) {
          $startOfFiscalYear = Carbon::createFromDate($year, 10, 1)->startOfDay();
          $endOfFiscalYear = Carbon::createFromDate($year + 1, 9, 30)->endOfDay();

          // นับจำนวนรายการในช่วงปีงบประมาณ
          $count = CertificateExport::whereBetween('created_at', [$startOfFiscalYear, $endOfFiscalYear])->count();

          // ดึง request_no ทั้งหมดในปีงบประมาณนั้น
          $requestNumbers = CertificateExport::whereBetween('created_at', [$startOfFiscalYear, $endOfFiscalYear])
              ->pluck('request_number');

          // บันทึกข้อมูลใน array
          if ($count > 0) {
              $fiscalData[] = [
                  'fiscal_year' => $year,
                  'count' => $count,
                  'request_numbers' => $requestNumbers,
              ];
          }
      }

      return $fiscalData;
  }

  public function mailToScopeViewer()
  {
    $config = HP::getConfig();
    $url  =   !empty($config->url_center) ? $config->url_center : url('');
    $certilab = CertiLab::find(1991);
    if($certilab->scope_view_signer_id != null && $certilab->scope_view_status == null )
    {

        $data_app =  ['email'=>  $certilab->email ?? '-',
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




        $singer = DB::table('besurv_signers')
        ->where('id', $certilab->scope_view_signer_id)
        ->first();

        // dd($singer)                              ;
        $user = Staff::find($singer->user_register_id);                                    

        $html = new LabScopeReview($data_app);
        $mail =  Mail::to($user->reg_email)->send($html);

        if(is_null($mail) && !empty($log_email)){
            HP::getUpdateCertifyLogEmail($log_email->id);
        }

    }
  }


  public function isRequestBelong()
  {
    $labType = 3;
    $standardId = 1;
    $appCertiLabIds = CertiLab::where('tax_id','3560200325574')->pluck('id')->toArray();
   
    $certiLabExportMapreqs = CertiLabExportMapreq::whereIn('app_certi_lab_id',$appCertiLabIds)->pluck('app_certi_lab_id')->toArray();

    $certiLabs = CertiLab::whereIn('id',$certiLabExportMapreqs)
              ->where('lab_type',$labType)
              ->where('standard_id',$standardId)
              ->get();

    
    if($certiLabs->count() != 0)
    {
      dd('ความสามารถห้องปฏิบัติการ'.$labType.' และตามมาตรฐานเลข '.$standardId.' ได้รับการรับรองแล้ว');
    }
  }

  public function getAttachedFileFromRequest()
  {
      // $certificateExport = CertificateExport::where('request_number','CAL-68-007')->first();
      // if($certificateExport != null)
      // {
      //     $trackingAssessment = TrackingAssessment::where('ref_table','certificate_exports')->where('ref_id',$certificateExport->id)->first();
      //     if($trackingAssessment != null)
      //     {
      //         $trackingInspection = TrackingInspection::where('reference_refno',$trackingAssessment->reference_refno)->first();
      //         if($trackingInspection != null)
      //         {
      //             $attachFile = AttachFile::where('ref_table','app_certi_tracking_inspection')->where('ref_id',$trackingInspection->id)->first();
                  
      //             if($attachFile->filename != null)
      //             {
      //                 dd($attachFile->filename);
      //             }
      //         }
      //     }
      // }
      $appNo = "CAL-68-007";
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
                      //     'trackingInspectionId' => $trackingInspection->id
                      // ];
                      return $trackingInspection->id;
                  }
              }
          }
      }
      // return [];
      null;
  }

  public function cbIsicSopePdf()
  {

    // $cbScopeIsicTransactions = CbScopeIsicTransaction::where('certi_cb_id',241)->get();

    // dd($cbScopeIsicTransactions);

    $certiCb = CertiCb::find(242);
    $pdfService = new CreateCbScopeIsicPdf($certiCb);
    $pdfContent = $pdfService->generatePdf();

    // $certiCb = CertiCb::find(228);
    // $pdfService = new CreateCbScopeBcmsPdf($certiCb);
    // $pdfContent = $pdfService->generatePdf();
  }

  public function ibSopePdf()
  {

    // $cbScopeIsicTransactions = CbScopeIsicTransaction::where('certi_cb_id',241)->get();

    // dd($cbScopeIsicTransactions);

    $certiCb = CertiIb::find(159);
    $pdfService = new CreateIbScopePdf($certiCb);
    $pdfContent = $pdfService->generatePdf();

    // $certiCb = CertiCb::find(228);
    // $pdfService = new CreateCbScopeBcmsPdf($certiCb);
    // $pdfContent = $pdfService->generatePdf();
  }

  
  public function certiCbMapReq()
  {
    $certiCb = CertiCb::find(253);
    // $app_certi_cbs = CertiCb::with([
    //       'app_certi_cb_export' => function($q){
    //           $q->whereIn('status',['0','1','2','3','4']);
    //       }
    //   ])
    //   ->where('created_by', $certiCb->created_by)
    //   ->whereNotIn('status', ['0','4'])
    //   ->where('type_standard', $certiCb->type_standard)
    //   ->where('petitioner_id', $certiCb->petitioner_id)
    //   ->where('trust_mark_id', $certiCb->trust_mark_id)
    //   ->get();
    // dd($app_certi_cbs);
        $app_certi_cbs = CertiCb::whereHas('certiCBExport', function($q){
          $q->whereIn('status', ['0','1','2','3','4']);
      })
      ->where('created_by', $certiCb->created_by)
      ->whereNotIn('status', ['0','4'])
      ->where('type_standard', $certiCb->type_standard)
      ->where('petitioner_id', $certiCb->petitioner_id)
      ->where('trust_mark_id', $certiCb->trust_mark_id)
      ->get();

      dd($app_certi_cbs);

  }

}
