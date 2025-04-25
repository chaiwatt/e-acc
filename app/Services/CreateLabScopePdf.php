<?php

namespace App\Services;
use HP;
use Mpdf\Mpdf;
use Carbon\Carbon;
use App\CertificateExport;
use Smalot\PdfParser\Parser;

use Illuminate\Support\Facades\DB;
use App\Models\Bcertify\TestBranch;
use App\Models\Bcertify\LabCalRequest;
use App\Models\Bcertify\LabTestRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Certify\Applicant\Report;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Bcertify\LabScopeTransaction;
use App\Models\Certify\Applicant\CertiLabAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrument;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;

class CreateLabScopePdf
{
    protected $certi_lab_id;
    protected $app_no;

    public function __construct($certi_lab)
    {
        $this->certi_lab_id = $certi_lab->id;
        $this->app_no = $certi_lab->app_no;
    }

    public function generatePdf()
    {

        $app_certi_lab = CertiLab::find($this->certi_lab_id);
        // dd($app_certi_lab->lab_type);
        if($app_certi_lab->lab_type == 3 ){
            $this->genTestPdf($this->certi_lab_id);
            // $this->generatePdfLabTestScope($this->certi_lab_id);
        }else if($app_certi_lab->lab_type == 4)
        {
            $this->genCalPdf($this->certi_lab_id);
            // $this->generatePdfLabCalScope($this->certi_lab_id);
        }
        // ตัวอย่าง: สร้าง PDF หรือดึงข้อมูล
        // อาจใช้ library เช่น DomPDF หรือ mPDF
        $data = $this->fetchLabData();

        // ตัวอย่างสมมติการสร้าง PDF
        return "PDF for Certi Lab ID: " . $this->certi_lab_id . " with data: " . json_encode($data);
    }

    protected function fetchLabData()
    {
        // ตัวอย่าง: ดึงข้อมูลจากฐานข้อมูลหรือแหล่งข้อมูลอื่น
        return [
            'name' => 'Lab Name',
            'scope' => 'Test Scope',
        ];
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
                $testBranch = TestBranch::find($transaction->category);
                 $transactionData = [
                     'index' => $transaction->index,
                     'category' =>  $testBranch->title_en,
                     'category_th' => $testBranch->title,
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
            'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
                'R' => "DejaVuSans.ttf",
                'B' => "DejaVuSans-Bold.ttf",
                'I' => "DejaVuSerif-Italic.ttf",
                'BI' => "DejaVuSerif-BoldItalic.ttf",
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
            'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
            'mode' => 'utf-8',
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

        // $mpdf->SetWatermarkImage('https://upload.wikimedia.org/wikipedia/commons/2/25/Siam_lilacpoint.jpg', 1, '', [170, 4]);

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
                'scopes' => collect($scopes),
                'index' => 0
            ]);
        $mpdf->WriteHTML($html);

        // แปลง PDF เป็น String
        $pdfContent = $mpdf->Output('', 'S');


    // ดูผลลัพธ์
    // dd($scopes);

        // $title = "mypdf.pdf";
        
        // $mpdf->Output($title, "I");  

        

        // dd($scopes);


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
            'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
                'R' => "DejaVuSans.ttf",
                'B' => "DejaVuSans-Bold.ttf",
                'I' => "DejaVuSerif-Italic.ttf",
                'BI' => "DejaVuSerif-BoldItalic.ttf",
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
            'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
            'mode' => 'utf-8',
            'margin_left'      => 8, // ระบุขอบด้านซ้าย
            'margin_right'     => 3, // ระบุขอบด้านขวา
            'margin_top'       => 97, // ระบุขอบด้านบน
            'margin_bottom'    => 40, // ระบุขอบด้านล่าง
        ]);         

        // $data = $this->getMeasurementsData()->getData();

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);

        // $company = $data->main;
        
        // $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]); // กำหนด opacity, , ตำแหน่ง
        $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, [23, 23], [170, 4]);
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
                'scopes' => collect($scope),
                'index' => 0
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

    public function genCalPdf($id)
    {
        $labScopeTransaction = LabScopeTransaction::where('app_certi_lab_id', $id)->where('lab_type', 'main')->first();
    
        // ตรวจสอบว่าพบ $labScopeTransaction หรือไม่
        if (!$labScopeTransaction) {
            throw new \Exception("ไม่พบข้อมูล LabScopeTransaction สำหรับ ID: {$id}");
        }
    
        // Decode lab_types จาก JSON string เป็น array
        $labTypes = json_decode($labScopeTransaction->lab_types, true);
    
        // dd($labTypes);
        // ตรวจสอบว่าการ decode สำเร็จหรือไม่
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($labTypes)) {
            $labTypes = [
                'pl_2_1_info' => [],
                'pl_2_2_info' => [],
                'pl_2_3_info' => [],
                'pl_2_4_info' => [],
                'pl_2_5_info' => []
            ];
        }
    
        // วนลูปสร้าง PDF สำหรับแต่ละ lab_type
        $pdfContents = [];
        foreach ($labTypes as $key => $labType) {

            
            // ตรวจสอบว่า labType มีข้อมูลหรือไม่
            if (is_array($labType) && count($labType) > 0) {
                
                // คำนวณ index จาก key (เช่น pl_2_1_info -> index = 0)
                $index = (int) str_replace(['pl_2_', '_info'], '', $key) - 1;
    
                // สร้าง mPDF instance ใหม่สำหรับแต่ละ lab_type
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
                    'PDFA' => $type == 'F' ? true : false,
                    'PDFAauto' => $type == 'F' ? true : false,
                    'format' => 'A4',
                    'mode' => 'utf-8',
                    'default_font_size' => '15',
                    'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                    'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                    'default_font' => 'thsarabunnew',
                    'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                    'mode' => 'utf-8',
                    'margin_left' => 8,
                    'margin_right' => 3,
                    'margin_top' => 108,
                    'margin_bottom' => 40,
                ]);
    
                $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
                $mpdf->WriteHTML($stylesheet, 1);
    
                $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]);
                $mpdf->showWatermarkImage = true;
                
                $viewBlade = "certify.scope_pdf.calibration.cal-scope-header";
                $header = view($viewBlade, [
                    'branchNo' => null,
                ]);
              
                $mpdf->SetHTMLHeader($header, 2);
                // dd($labType);
                // แปลงข้อมูล labType ให้อยู่ในรูปแบบที่ Blade view คาดหวัง
                $formattedLabType = [];
               
                foreach ($labType as $item) {
                    $formattedLabType[] = [
                        'cal_main_branch' => [
                            'id' => $item['cal_main_branch_id'] ?? '',
                            'text' => $item['cal_main_branch_text'] ?? ''
                        ],
                        'cal_instrumentgroup' => [
                            'id' => $item['cal_instrumentgroup_id'] ?? '',
                            'text' => $item['cal_instrumentgroup_text'] ?? ''
                        ],
                        'cal_instrument' => [
                            'id' => $item['cal_instrument_id'] ?? '',
                            'text' => $item['cal_instrument_text'] ?? ''
                        ],
                        'cal_parameter_one' => [
                            'id' => $item['cal_parameter_one_id'] ?? '',
                            'text' => $item['cal_parameter_one_text'] ?? ''
                        ],
                        'cal_parameter_two' => [
                            'id' => $item['cal_parameter_two_id'] ?? '',
                            'text' => $item['cal_parameter_two_text'] ?? ''
                        ],
                        'cal_standard' => $item['cal_standard'] ?? '',
                        'cal_cmc_info' => $item['cal_cmc_info'] ?? [],
                        'global_measture_description' => $item['global_measture_description'] ?? []
                    ];
                }
    
                
                // เรนเดอร์ HTML สำหรับ lab_type ปัจจุบัน
                $html = view('certify.scope_pdf.calibration.pdf-cal-scope', [
                    'labType' => $formattedLabType,
                    'index' => $index
                ]);
                $mpdf->WriteHTML($html);
    
                // แปลง PDF เป็น String และเก็บใน array
                // $pdfContents[] = $mpdf->Output('', 'S');

                $title = "mypdf.pdf";
    
                $mpdf->Output($title, "I");  
            }
        }
    
        // ถ้าไม่มี lab_type ที่มีข้อมูลเลย
        if (empty($pdfContents)) {
            throw new \Exception("ไม่มีข้อมูล lab_types สำหรับการสร้าง PDF");
        }
    
        // คืน array ของ PDF contents
        return $pdfContents;
    }


    public function genTestPdf($id)
    {
        $labScopeTransaction = LabScopeTransaction::where('app_certi_lab_id', $id)->where('lab_type', 'main')->first();
    
        // ตรวจสอบว่าพบ $labScopeTransaction หรือไม่
        if (!$labScopeTransaction) {
            throw new \Exception("ไม่พบข้อมูล LabScopeTransaction สำหรับ ID: {$id}");
        }
    
        // Decode lab_types จาก JSON string เป็น array
        $labTypes = json_decode($labScopeTransaction->lab_types, true);
    
        // ตรวจสอบว่าการ decode สำเร็จหรือไม่
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($labTypes)) {
            $labTypes = [
                'pl_2_1_info' => [],
                'pl_2_2_info' => [],
                'pl_2_3_info' => [],
                'pl_2_4_info' => [],
                'pl_2_5_info' => []
            ];
        }
    
        // วนลูปสร้าง PDF สำหรับแต่ละ lab_type
        $pdfContents = [];
        foreach ($labTypes as $key => $labType) {
            // ตรวจสอบว่า labType มีข้อมูลหรือไม่
            if (is_array($labType) && count($labType) > 0) {
                // คำนวณ index จาก key (เช่น pl_2_1_info -> index = 0)
                $index = (int) str_replace(['pl_2_', '_info'], '', $key) - 1;
    
                // สร้าง mPDF instance ใหม่สำหรับแต่ละ lab_type
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
                    'PDFA' => $type == 'F' ? true : false,
                    'PDFAauto' => $type == 'F' ? true : false,
                    'format' => 'A4',
                    'mode' => 'utf-8',
                    'default_font_size' => '15',
                    'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                    'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
                    'default_font' => 'thsarabunnew',
                    'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                    'mode' => 'utf-8',
                    'margin_left' => 8,
                    'margin_right' => 3,
                    'margin_top' => 95,
                    'margin_bottom' => 40,
                ]);
    
                $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
                $mpdf->WriteHTML($stylesheet, 1);
    
                $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]);
                $mpdf->showWatermarkImage = true;
    
                $viewBlade = "certify.scope_pdf.test.Firstheader";
                $header = view($viewBlade, [
                    'branchNo' => null,
                ]);
    
                $mpdf->SetHTMLHeader($header, 2);
    
                // แปลงข้อมูล labType ให้อยู่ในรูปแบบที่ Blade view คาดหวัง
                $formattedLabType = [];
                foreach ($labType as $item) {
                    $formattedLabType[] = [
                        'test_main_branch' => [
                            'id' => $item['test_main_branch_id'] ?? $item['test_main_branch']['id'] ?? '',
                            'text' => $item['test_main_branch_text'] ?? $item['test_main_branch']['text'] ?? ''
                        ],
                        'test_category' => [
                            'id' => $item['test_category_id'] ?? $item['test_category']['id'] ?? '',
                            'text' => $item['test_category_text'] ?? $item['test_category']['text'] ?? ''
                        ],
                        'test_parameter' => [
                            'id' => $item['test_parameter_id'] ?? $item['test_parameter']['id'] ?? '',
                            'text' => $item['test_parameter_text'] ?? $item['test_parameter']['text'] ?? ''
                        ],
                        'test_condition_description' => $item['test_condition_description'] ?? '',
                        'test_param_detail' => $item['test_param_detail'] ?? '',
                        'test_standard' => $item['test_standard'] ?? ''
                    ];
                }
    
                // dd($formattedLabType);
                // เรนเดอร์ HTML สำหรับ lab_type ปัจจุบัน
                $html = view('certify.scope_pdf.test.pdf-test-scope', [
                    'labType' => $formattedLabType,
                    'index' => $index
                ]);
                $mpdf->WriteHTML($html);
    
                // แปลง PDF เป็น String และเก็บใน array
                // $pdfContents[] = $mpdf->Output('', 'S');
    
                $title = "mypdf.pdf";
                $mpdf->Output($title, "I");
            }
        }
    
        // ถ้าไม่มี lab_type ที่มีข้อมูลเลย
        if (empty($pdfContents)) {
            throw new \Exception("ไม่มีข้อมูล lab_types สำหรับการสร้าง PDF");
        }
    
        // คืน array ของ PDF contents
        return $pdfContents;
    }

    
    // public function genTestPdf($id)
    // {
    //     $labScopeTransaction = LabScopeTransaction::where('app_certi_lab_id', $id)->where('lab_type', 'main')->first();
    
    //     if (!$labScopeTransaction) {
    //         throw new \Exception("ไม่พบข้อมูล LabScopeTransaction สำหรับ ID: {$id}");
    //     }
    
    //     $labTypes = json_decode($labScopeTransaction->lab_types, true);
    
    //     if (json_last_error() !== JSON_ERROR_NONE || !is_array($labTypes)) {
    //         $labTypes = [
    //             'pl_2_1_info' => [],
    //             'pl_2_2_info' => [],
    //             'pl_2_3_info' => [],
    //             'pl_2_4_info' => [],
    //             'pl_2_5_info' => []
    //         ];
    //     }
    
    //     $pdfContents = [];
    //     $type = 'I';
    //     $fontDirs = [public_path('pdf_fonts/')];
    //     $fontData = [
    //         'thsarabunnew' => [
    //             'R' => "THSarabunNew.ttf",
    //             'B' => "THSarabunNew-Bold.ttf",
    //             'I' => "THSarabunNew-Italic.ttf",
    //             'BI' => "THSarabunNew-BoldItalic.ttf",
    //         ],
    //         'dejavusans' => [
    //             'R' => "DejaVuSans.ttf",
    //             'B' => "DejaVuSans-Bold.ttf",
    //             'I' => "DejaVuSerif-Italic.ttf",
    //             'BI' => "DejaVuSerif-BoldItalic.ttf",
    //         ],
    //     ];
    
    //     // Render รอบแรกเพื่อหา $markKey
    //     $mpdf = new Mpdf([
    //         'PDFA' => $type == 'F' ? true : false,
    //         'PDFAauto' => $type == 'F' ? true : false,
    //         'format' => 'A4',
    //         'mode' => 'utf-8',
    //         'default_font_size' => '15',
    //         'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
    //         'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
    //         'default_font' => 'thsarabunnew',
    //         'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
    //         'mode' => 'utf-8',
    //         'margin_left' => 8,
    //         'margin_right' => 3,
    //         'margin_top' => 95,
    //         'margin_bottom' => 40,
    //     ]);
    
    //     $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
    //     $mpdf->WriteHTML($stylesheet, 1);
    
    //     $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]);
    //     $mpdf->showWatermarkImage = true;
    
    //     $firstHeader = view('certify.scope_pdf.test.Firstheader', ['branchNo' => null]);
    //     $otherHeader = view('certify.scope_pdf.test.otherHeader', ['branchNo' => null]);
    //     $mpdf->SetHTMLHeader($firstHeader, 'O');
    
    //     $formattedLabTypes = [];
    
    //     // เตรียมข้อมูลโดยไม่กำกับ markKey
    //     foreach ($labTypes as $key => $labType) {
    //         if (is_array($labType) && count($labType) > 0) {
    //             $index = (int) str_replace(['pl_2_', '_info'], '', $key) - 1;
    //             $formattedLabType = [];
    //             foreach ($labType as $itemIndex => $item) {
    //                 $formattedLabType[] = [
    //                     'test_main_branch' => [
    //                         'id' => $item['test_main_branch_id'] ?? $item['test_main_branch']['id'] ?? '',
    //                         'text' => $item['test_main_branch_text'] ?? $item['test_main_branch']['text'] ?? ''
    //                     ],
    //                     'test_category' => [
    //                         'id' => $item['test_category_id'] ?? $item['test_category']['id'] ?? '',
    //                         'text' => $item['test_category_text'] ?? $item['test_category']['text'] ?? ''
    //                     ],
    //                     'test_parameter' => [
    //                         'id' => $item['test_parameter_id'] ?? $item['test_parameter']['id'] ?? '',
    //                         'text' => $item['test_parameter_text'] ?? $item['test_parameter']['text'] ?? ''
    //                     ],
    //                     'test_condition_description' => $item['test_condition_description'] ?? '',
    //                     'test_param_detail' => $item['test_param_detail'] ?? '',
    //                     'test_standard' => $item['test_standard'] ?? ''
    //                 ];
    //             }
    //             $formattedLabTypes[$key] = $formattedLabType;
    
    //             // Render รอบแรกเฉพาะ pl_2_1_info
    //             if ($key === 'pl_2_1_info') {
    //                 $html = view('certify.scope_pdf.test.pdf-test-scope', [
    //                     'labType' => $formattedLabType,
    //                     'index' => $index
    //                 ]);
    //                 $mpdf->WriteHTML($html);
    //             }
    //         }
    //     }
    
    //     // บันทึก PDF เป็น string
    //     $pdfContent = $mpdf->Output('', 'S');
    
    //     // ใช้ PdfParser เพื่อดึงหน้าแรก
    //     $parser = new Parser();
    //     $pdf = $parser->parseContent($pdfContent);
    //     $pages = $pdf->getPages();
    //     $firstPage = $pages[0]; // หน้าแรก
    //     $firstPageText = $firstPage->getText();
    
    //     // หา $markKey สูงสุดในหน้าแรก (นับจำนวนแถว)
    //     $maxMarkKeyInFirstPage = 0;
    //     preg_match_all('/\*\*markKey:(\d+)\*\*/', $firstPageText, $matches);
    //     if (!empty($matches[1])) {
    //         $markKeys = array_map('intval', $matches[1]);
    //         $maxMarkKeyInFirstPage = max($markKeys);
    //     }
    
    //     // คำนวณจำนวนแถวที่ควรอยู่ในหน้าแรก
    //     $rowsInFirstPage = $maxMarkKeyInFirstPage + 1; // +1 เพราะ markKey เริ่มจาก 0
    
    //     // แยกข้อมูลตามจำนวนแถว
    //     $firstPageItems = [];
    //     $remainingItems = [];
    //     $currentRow = 0;
    
    //     foreach ($formattedLabTypes['pl_2_1_info'] as $item) {
    //         // คำนวณจำนวนแถวของ item นี้
    //         $rowCount = 1; // เริ่มจาก 1 (สำหรับ test_parameter.text)
    //         if (!empty($item['test_condition_description'])) {
    //             $rowCount++;
    //         }
    //         if (!empty($item['test_param_detail'])) {
    //             $rowCount++;
    //         }
    
    //         if ($currentRow < $rowsInFirstPage) {
    //             $firstPageItems[] = $item;
    //             $currentRow += $rowCount;
    //         } else {
    //             $remainingItems[] = $item;
    //         }
    //     }
    
    //     // Render PDF ครั้งสุดท้าย
    //     $mpdfFinal = new Mpdf([
    //         'PDFA' => $type == 'F' ? true : false,
    //         'PDFAauto' => $type == 'F' ? true : false,
    //         'format' => 'A4',
    //         'mode' => 'utf-8',
    //         'default_font_size' => '15',
    //         'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
    //         'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
    //         'default_font' => 'thsarabunnew',
    //         'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
    //         'mode' => 'utf-8',
    //         'margin_left' => 8,
    //         'margin_right' => 3,
    //         'margin_top' => 95,
    //         'margin_bottom' => 40,
    //     ]);
    
    //     $mpdfFinal->WriteHTML($stylesheet, 1);
    //     $mpdfFinal->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]);
    //     $mpdfFinal->showWatermarkImage = true;
    
    //     // Render หน้าแรก
    //     $mpdfFinal->SetHTMLHeader($firstHeader, 'O');
    //     $html = view('certify.scope_pdf.test.pdf-test-scope', [
    //         'labType' => $firstPageItems,
    //         'index' => 0
    //     ]);
    //     $mpdfFinal->WriteHTML($html);
    
    //     // เปลี่ยน header และ margin_top สำหรับหน้าต่อไป
    //     $mpdfFinal->SetHTMLHeader($otherHeader, 'O');
    //     $mpdfFinal->SetMargins(8, 3, 70);
    //     $mpdfFinal->AddPage();
    
    //     // Render หน้าต่อไป
    //     foreach ($formattedLabTypes as $key => $labType) {
    //         if ($key !== 'pl_2_1_info' && is_array($labType) && count($labType) > 0) {
    //             $index = (int) str_replace(['pl_2_', '_info'], '', $key) - 1;
    //             $html = view('certify.scope_pdf.test.pdf-test-scope', [
    //                 'labType' => $labType,
    //                 'index' => $index
    //             ]);
    //             $mpdfFinal->WriteHTML($html);
    //         }
    //     }
    
    //     // Render รายการที่เหลือจาก pl_2_1_info
    //     if (!empty($remainingItems)) {
    //         $html = view('certify.scope_pdf.test.pdf-test-scope', [
    //             'labType' => $remainingItems,
    //             'index' => 0
    //         ]);
    //         $mpdfFinal->WriteHTML($html);
    //     }
    
    //     if (empty($labTypes)) {
    //         throw new \Exception("ไม่มีข้อมูล lab_types สำหรับการสร้าง PDF");
    //     }
    
    //     $title = "mypdf.pdf";
    //     $mpdfFinal->Output($title, "I");
    
    //     return $pdfContents;
    // }

  public function generatePdfLabCalScope($id)
  {
    
   
    

    return;
      $siteType = "single";
      $data = $this->getCalScopeData($id)->getData();

    //   dd(count($data));
      
      if(count($data) > 1){
          $siteType = "multi";
      }
      $mpdfArray = []; 

    // วนลูปข้อมูล
      foreach ($data as $key => $details) {

        $scopes = $details->scope;

        // วนลูปผ่าน $scopes เพื่อเพิ่ม measurement_edit
        foreach ($scopes as $scope) {
            $measurementEdit = [];

            // วนลูปผ่าน measurements ของแต่ละ scope
            foreach ($scope->measurements as $measurement) {
                $groupedRanges = [];

                // จัดกลุ่ม ranges ตาม description
                foreach ($measurement->ranges as $range) {
                    $description = $range->description;

                    if (!isset($groupedRanges[$description])) {
                        $groupedRanges[$description] = [
                            'ranges' => [],
                            'uncertainties' => []
                        ];
                    }

                    $groupedRanges[$description]['ranges'][] = $range->range;
                    $groupedRanges[$description]['uncertainties'][] = $range->uncertainty;
                }

                // สร้างโครงสร้าง measurement_edit ใหม่
                $measurementEdit[] = [
                    'name' => $measurement->name,
                    'type' => $measurement->type,
                    'ranges' => $groupedRanges
                ];
            }

            // เพิ่มคีย์ measurement_edit ลงใน $scope
            $scope->measurement_edit = $measurementEdit;
        }

        // dd($scopes);

        // จัดเรียง $scopes ตาม category ตามตัวอักษร
        usort($scopes, function ($a, $b) {
            return strcmp($a->category, $b->category);
        });



          // ใช้ array_map เพื่อดึงค่าของ 'key' จากแต่ละรายการใน $scopes
          $keys = array_map(function ($item) {
            return $item->key;
          }, $scopes);

        // dd($scopes);

          // ใช้ array_unique เพื่อลบค่าซ้ำใน $keys
          $uniqueKeys = array_unique($keys);

         

          $report = Report::where('app_certi_lab_id',$id)->first();

          $from_date_th = '';
          $from_date_en = '';
          $to_date_th = '';
          $to_date_en = '';
          $certificate_no = 'xx-LBxxxx';
          if($report !== null){
                  $from_date_th = HP::formatDateThaiFull($report->start_date);
                  $to_date_th = HP::formatDateThaiFull($report->end_date);
                  $from_date_en = $this->formatThaiDate($report->start_date);
                  $to_date_en = $this->formatThaiDate($report->end_date);
          }
  
          $running =  Report::get()->count();
          $running_no =  str_pad(($running + 1), 4, '0', STR_PAD_LEFT);
          $certi_lab = CertiLab::find($id);
         

          $isExported = $certi_lab->certi_lab_export_mapreq_to;
  
          if($isExported !== null){
             $export_lab = CertificateExport::find($isExported['certificate_exports_id']);
              if($export_lab->certificate_no !== null)
              {
                  $certificate_no = $export_lab->certificate_no;
              }
          }
          
          $book_no = '01';
          $pdfData =  (object)[
              'certificate_no' => $certificate_no,
              'acc_no' => $running_no,
              'book_no' => $book_no,
              'from_date_th' => $from_date_th,
              'from_date_en' => $from_date_en,
              'to_date_th' => $to_date_th,
              'to_date_en' => $to_date_en,
              'uniqueKeys' => $uniqueKeys,
              'siteType' => $siteType
          ];


         

          $scopePages = $this->getCalPageList($scopes,$pdfData,$details);

          
          $type = 'I';
          $fontDirs = [public_path('pdf_fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
          $fontData = [
              'thsarabunnew' => [
                  'R' => "THSarabunNew.ttf",
                  'B' => "THSarabunNew-Bold.ttf",
                  'I' => "THSarabunNew-Italic.ttf",
                  'BI' => "THSarabunNew-BoldItalic.ttf",
              ],
              'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
                  'R' => "DejaVuSans.ttf",
                  'B' => "DejaVuSans-Bold.ttf",
                  'I' => "DejaVuSerif-Italic.ttf",
                  'BI' => "DejaVuSerif-BoldItalic.ttf",
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
                  'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                  'mode' => 'utf-8',
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
                      'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                      'mode' => 'utf-8',
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
                      'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                      'mode' => 'utf-8',
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
        //   $mpdf->SetWatermarkText('Confidential', 0.1); // ระบุข้อความและ opacity
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
                      'scopes' => collect($scopes),
                      'index' => $index
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
                      'scopes' => collect($scopes),
                      'index' => $index
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
          'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
          'mode' => 'utf-8',
      ]);

    //   $combinedPdf->SetImportUse();
      
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
            //   $signImage = public_path('images/sign.jpg');
            


            //   $systems = 'signers';
            //   $tax_number = '3210100336046';
            //   $new_filename = 'Pz6BGTZKud-date_time20250114_100153.png';

            //   $attach_path = 'files/' . $systems . '/' . $tax_number;
            //   $signImage = public_path('uploads/' . $attach_path . '/' . $new_filename);

            $signImage = null;
              
              $footer = view('certify.scope_pdf.calibration.cal-scope-footer', [
                  'sign1Image' => $signImage, // ส่งรูปภาพที่ต้องการใช้
                  'sign2Image' => $signImage,
                  'sign3Image' => $signImage
              ])->render();

              // ตั้งค่า Footer ใหม่สำหรับหน้า PDF
              $combinedPdf->SetHTMLFooter($footer);
          }
      }

    //   $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);

    // $title = "mypdf.pdf";
    
    // $combinedPdf->Output($title, "I");  

    // $defaultDisk = config('filesystems.default');
    // dd($defaultDisk);
    $app_certi_lab = CertiLab::find($id);
    $no = str_replace("RQ-", "", $app_certi_lab->app_no);
    $no = str_replace("-", "_", $no);

    $attachPath = '/files/applicants/check_files/' . $no . '/';
    $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.pdf';

    // สร้างไฟล์ชั่วคราว
    $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';

    // บันทึก PDF ไปยังไฟล์ชั่วคราว
    $combinedPdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);

    // ใช้ Storage::putFileAs เพื่อย้ายไฟล์
    Storage::putFileAs($attachPath, new \Illuminate\Http\File($tempFilePath), $fullFileName);

    $storePath = $no  . '/' . $fullFileName;

    // ลบไฟล์ชั่วคราว
    foreach ($tempFiles as $fileName) {
        unlink($fileName);
    }

    $certi_lab_attach = new CertiLabAttachAll();
    $certi_lab_attach->app_certi_lab_id = $id;
    $certi_lab_attach->file_section     = "62";
    $certi_lab_attach->file             = $storePath;
    $certi_lab_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
    $certi_lab_attach->token            = str_random(16);
    $certi_lab_attach->default_disk = config('filesystems.default');
    $certi_lab_attach->save();

    // ตรวจสอบ path บน server

    // $filePath = $attachPath . $fullFileName;
    // if (Storage::disk('ftp')->exists($filePath)) {
    //     dd('File Path on Server: ' . $filePath);
    // } else {
    //     dd('File not found on server!');
    // }

  }

  function formatThaiDate($date)
    {
        // แปลงวันที่ให้เป็น Carbon instance
        $carbonDate = Carbon::parse($date);
        
        // คำนวณปีพุทธศักราช
        $buddhistYear = $carbonDate->year + 543;
        
        // คืนค่ารูปแบบวันที่
        return $carbonDate->format('d F') . ' B.E. ' . $buddhistYear . ' (' . $carbonDate->year . ')';
    }


  public function generatePdfLabTestScope($id)
  {
      $siteType = "single";
      $data = $this->getTestScopeData($id)->getData();
      
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

        $report = Report::where('app_certi_lab_id',$id)->first();
     
        $from_date_th = '';
        $from_date_en = '';
        $to_date_th = '';
        $to_date_en = '';
        $certificate_no = 'xx-LBxxxx';
        if($report !== null){
                $from_date_th = HP::formatDateThaiFull($report->start_date);
                $to_date_th = HP::formatDateThaiFull($report->end_date);
                $from_date_en = $this->formatThaiDate($report->start_date);
                $to_date_en = $this->formatThaiDate($report->end_date);
        }

        $running =  Report::get()->count();
        $running_no =  str_pad(($running + 1), 4, '0', STR_PAD_LEFT);
        $certi_lab = CertiLab::find($id);

        $isExported = $certi_lab->certi_lab_export_mapreq_to;
  
        if($isExported !== null){
           $export_lab = CertificateExport::find($isExported['certificate_exports_id']);
            if($export_lab->certificate_no !== null)
            {
                $certificate_no = $export_lab->certificate_no;
            }
        }
        // $export_lab = CertificateExport::where('request_number', $certi_lab->app_no)->first();

        // if($export_lab !== null){
        //     if($export_lab->certificate_no !== null)
        //     {
        //         $certificate_no = $export_lab->certificate_no;
        //     }
        // }

        $book_no = '01';
        $pdfData =  (object)[
            'certificate_no' => $certificate_no,
            'acc_no' => $running_no,
            'book_no' => $book_no,
            'from_date_th' => $from_date_th,
            'from_date_en' => $from_date_en,
            'to_date_th' => $to_date_th,
            'to_date_en' => $to_date_en,
            'uniqueKeys' => $uniqueKeys,
            'siteType' => $siteType
        ];

        // dd($pdfData);


          $scopePages = $this->getPageTestList($scopes,$pdfData,$details);
          
          $type = 'I';
          $fontDirs = [public_path('pdf_fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
          $fontData = [
              'thsarabunnew' => [
                  'R' => "THSarabunNew.ttf",
                  'B' => "THSarabunNew-Bold.ttf",
                  'I' => "THSarabunNew-Italic.ttf",
                  'BI' => "THSarabunNew-BoldItalic.ttf",
              ],
              'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
                  'R' => "DejaVuSans.ttf",
                  'B' => "DejaVuSans-Bold.ttf",
                  'I' => "DejaVuSerif-Italic.ttf",
                  'BI' => "DejaVuSerif-BoldItalic.ttf",
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
                  'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                  'mode' => 'utf-8',
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
                      'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                      'mode' => 'utf-8',
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
                      'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
                      'mode' => 'utf-8',
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
        //      $mpdf->SetWatermarkImage(public_path('images/nc_hq.png'), 1, '', [170, 4]); // กำหนด opacity, , ตำแหน่ง
  
          $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark
  
          // เพิ่ม Text Watermark
        //   $mpdf->SetWatermarkText('Confidential', 0.1); // ระบุข้อความและ opacity
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
          'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
          'mode' => 'utf-8',
      ]);

    //   $combinedPdf->SetImportUse();
      
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
    //   $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);


    $app_certi_lab = CertiLab::find($id);
    $no = str_replace("RQ-", "", $app_certi_lab->app_no);
    $no = str_replace("-", "_", $no);

    $attachPath = '/files/applicants/check_files/' . $no . '/';
    $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.pdf';

    // สร้างไฟล์ชั่วคราว
    $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';

    // บันทึก PDF ไปยังไฟล์ชั่วคราว
    $combinedPdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);

    // ใช้ Storage::putFileAs เพื่อย้ายไฟล์
    Storage::putFileAs($attachPath, new \Illuminate\Http\File($tempFilePath), $fullFileName);

    $storePath = $no  . '/' . $fullFileName;

    // dd($app_certi_lab->app_no   , $storePath );
    
      // ลบไฟล์ชั่วคราว
      foreach ($tempFiles as $fileName) {
          unlink($fileName);
      }

    $certi_lab_attach = new CertiLabAttachAll();
    $certi_lab_attach->app_certi_lab_id = $id;
    $certi_lab_attach->file_section     = "61";
    $certi_lab_attach->file = $storePath;
    $certi_lab_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
    $certi_lab_attach->token = str_random(16);
    $certi_lab_attach->default_disk = config('filesystems.default');
    $certi_lab_attach->save();

    // ตรวจสอบ path บน server
    // $filePath = $attachPath . $fullFileName;
    // if (Storage::disk('ftp')->exists($filePath)) {
    //     dd('File Path on Server: ' . $filePath);
    // } else {
    //     dd('File not found on server!');
    // }

  }
  
  public function getPageTestList($scopes,$pdfData,$details)
  {

      $pageArray = $this->getFirstTestPageList($scopes,$pdfData,$details);

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
      $fontDirs = [public_path('pdf_fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
      $fontData = [
          'thsarabunnew' => [
              'R' => "THSarabunNew.ttf",
              'B' => "THSarabunNew-Bold.ttf",
              'I' => "THSarabunNew-Italic.ttf",
              'BI' => "THSarabunNew-BoldItalic.ttf",
          ],
          'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
              'R' => "DejaVuSans.ttf",
              'B' => "DejaVuSans-Bold.ttf",
              'I' => "DejaVuSerif-Italic.ttf",
              'BI' => "DejaVuSerif-BoldItalic.ttf",
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
          'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
          'mode' => 'utf-8',
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
      $fontDirs = [public_path('pdf_fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
      $fontData = [
          'thsarabunnew' => [
              'R' => "THSarabunNew.ttf",
              'B' => "THSarabunNew-Bold.ttf",
              'I' => "THSarabunNew-Italic.ttf",
              'BI' => "THSarabunNew-BoldItalic.ttf",
          ],
          'dejavusans' => [ // เพิ่มฟอนต์ DejaVu Sans
              'R' => "DejaVuSans.ttf",
              'B' => "DejaVuSans-Bold.ttf",
              'I' => "DejaVuSerif-Italic.ttf",
              'BI' => "DejaVuSerif-BoldItalic.ttf",
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
          'fontdata_fallback' => ['dejavusans', 'freesans', 'arial'],
          'mode' => 'utf-8',
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
}
