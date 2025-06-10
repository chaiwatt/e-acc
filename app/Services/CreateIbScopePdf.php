<?php

namespace App\Services;
use HP;
use stdClass;
use Mpdf\Mpdf;
use Carbon\Carbon;
use App\AttachFile;

use App\CertificateExport;
use Smalot\PdfParser\Parser;
use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;
use Illuminate\Support\Facades\DB;
use App\Models\Bcertify\TestBranch;
use App\Models\Bcertify\LabCalRequest;
use App\Models\Bcertify\LabTestRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Certify\Applicant\Report;
use App\Models\Bcertify\CalibrationBranch;

use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certify\ApplicantIB\CertiIb;

use App\Models\Certificate\IbScopeTransaction;

use App\Models\Certificate\TrackingInspection;
use App\Models\Certify\ApplicantIB\CertiIBReport;

use App\Models\Certify\Applicant\CertiLabAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrument;

use App\Models\Certify\ApplicantIB\CertiIBAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;
use App\Models\Certify\ApplicantIB\CertiIBSaveAssessment;

class CreateIbScopePdf
{
    protected $certi_ib_id;
    protected $app_no;

    public function __construct($certi_ib)
    {
        $this->certi_ib_id = $certi_ib->id;
        $this->app_no = $certi_ib->app_no;
    }


    public function generatePdf()
    {
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id',$app_certi_ib->id)->get();
        
        $mpdfTh = $this->genThPage($app_certi_ib,$ibScopeTransactions);

        $mpdfEn = $this->genEnPage($app_certi_ib,$ibScopeTransactions);

        $mpdfArray = [$mpdfTh, $mpdfEn]; 

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

    

        $tempFiles = []; // เก็บรายชื่อไฟล์ชั่วคราว
        foreach ($mpdfArray as $key => $mpdf) {
            $tempFileName = "temp_{$key}.pdf"; // เช่น temp_0.pdf, temp_1.pdf
            $mpdf->Output($tempFileName, \Mpdf\Output\Destination::FILE); // บันทึก PDF ชั่วคราว
            $tempFiles[] = $tempFileName;
        }

        
        $finalPdf = new \Mpdf\Mpdf([
                'PDFA' 	=>  $type == 'F' ? true : false,
                'PDFAauto'	 =>  $type == 'F' ? true : false,
                'format'           => 'A4',
                'mode'             => 'utf-8',
                'default_font_size'=> '15',
                'fontDir'          => array_merge((new ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                'fontdata'         => array_merge((new FontVariables())->getDefaults()['fontdata'], $fontData),
                'default_font'     => 'thsarabunnew',
        ]);

        $totalPages = 0;
        foreach ($tempFiles as $fileName) {
            $totalPages += $finalPdf->SetSourceFile($fileName); // นับจำนวนหน้าจาก tempFiles
        }

        // $totalPagesThai = HP::toThaiNumber($totalPages); // จำนวนหน้าทั้งหมดในรูปแบบเลขไทย

        // 4. รวมไฟล์ทั้งหมด โดยเริ่มจาก tempFiles
        $currentPage = 1; // ตัวนับหน้าเริ่มต้น
        foreach ($tempFiles as $key => $fileName) {
            $pageCount = $finalPdf->SetSourceFile($fileName); // เปิดไฟล์ PDF
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $finalPdf->ImportPage($i);
                $finalPdf->AddPage();
                $finalPdf->UseTemplate($templateId);

                $sign1Image = public_path('images/sign.jpg');
                $footer = view('certify.scope_pdf.ib.pdf-scope-footer', [
                    'qrImage' => null,
                    'sign1Image' => $sign1Image,
                    'sign2Image' => null,
                    'sign3Image' => null,
                    'totalPages' => HP::toThaiNumber(count($tempFiles)), // จำนวนหน้าทั้งหมด
                    'currentPage' => HP::toThaiNumber($key+1), // หน้าปัจจุบัน
                    'app_certi_ib' => $app_certi_ib
                    

                ]);
                $finalPdf->SetHTMLFooter($footer);
                $currentPage++; // เพิ่มหน้าปัจจุบัน
            }
        }

        // $title = "combined_final.pdf";
        // $finalPdf->Output($title, "I");

         // 7. ลบไฟล์ชั่วคราว (ถ้าต้องการ)
         foreach ($tempFiles as $file) {
            unlink($file);
        }


        $tbx = new CertiIBSaveAssessment;
        $tb = new CertiIBReport;


        // $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        $no = str_replace("RQ-", "", $app_certi_ib->app_no);
        $no = str_replace("-", "_", $no);


        $attachPath = '/files/applicants/check_files_ib/' . $no . '/';
        $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.pdf';
    
        // สร้างไฟล์ชั่วคราว
        $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
        // บันทึก PDF ไปยังไฟล์ชั่วคราว
        $finalPdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);
        // ใช้ Storage::putFileAs เพื่อย้ายไฟล์
        Storage::putFileAs($attachPath, new \Illuminate\Http\File($tempFilePath), $fullFileName);
    
        $storePath = $no  . '/' . $fullFileName;
    
        // ลบไฟล์ชั่วคราว
        // foreach ($tempFiles as $fileName) {
        //     unlink($fileName);
        // }
    
        $tb = new CertiIb;
        $certi_ib_attach                   = new CertiIBAttachAll();
        $certi_ib_attach->app_certi_ib_id = $app_certi_ib->id;
        $certi_ib_attach->table_name       = $tb->getTable();
        $certi_ib_attach->file_section     = '3';
        $certi_ib_attach->file_desc        = null;
        $certi_ib_attach->file             = $storePath;
        $certi_ib_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
        $certi_ib_attach->token            = str_random(16);
        $certi_ib_attach->save();

        $checkScopeCertiIBSaveAssessment = CertiIBAttachAll::where('app_certi_ib_id',$this->certi_ib_id)
        ->where('table_name', (new CertiIBSaveAssessment)->getTable())
        ->where('file_section', 2)
        ->latest() // ใช้ latest() เพื่อให้เรียงตาม created_at โดยอัตโนมัติ
        ->first(); // ดึง record ล่าสุดเพียงตัวเดียว


        if($checkScopeCertiIBSaveAssessment != null)
        {
            $assessment = CertiIBSaveAssessment::find($checkScopeCertiIBSaveAssessment->ref_id);
            $json = $this->copyScopeIbFromAttachement($assessment->app_certi_ib_id);
            $copiedScopes = json_decode($json, true);
            $tbx = new CertiIBSaveAssessment;
            $certi_ib_attach_more = new CertiIBAttachAll();
            $certi_ib_attach_more->app_certi_ib_id      = $assessment->app_certi_ib_id ?? null;
            $certi_ib_attach_more->ref_id               = $assessment->id;
            $certi_ib_attach_more->table_name           = $tbx->getTable();
            $certi_ib_attach_more->file_section         = '2';
            $certi_ib_attach_more->file                 = $copiedScopes[0]['attachs'];
            $certi_ib_attach_more->file_client_name     = $copiedScopes[0]['file_client_name'];
            $certi_ib_attach_more->token                = str_random(16);
            $certi_ib_attach_more->save();
        }

        $checkScopeCertiIBReport= CertiIBAttachAll::where('app_certi_ib_id',$this->certi_ib_id)
        ->where('table_name',(new CertiIBReport)->getTable())
        ->where('file_section',1)
        ->latest() // ใช้ latest() เพื่อให้เรียงตาม created_at โดยอัตโนมัติ
        ->first(); // ดึง record ล่าสุดเพียงตัวเดียว

        if($checkScopeCertiIBReport != null)
        {
            $report = CertiIBReport::find($checkScopeCertiIBReport->ref_id);
            $json = $this->copyScopeIbFromAttachement($report->app_certi_ib_id);
            $copiedScopes = json_decode($json, true);
            $tb = new CertiIBReport;
            $certi_ib_attach_more = new CertiIBAttachAll();
            $certi_ib_attach_more->app_certi_ib_id      = $report->app_certi_ib_id ?? null;
            $certi_ib_attach_more->ref_id               = $report->id;
            $certi_ib_attach_more->table_name           = $tb->getTable();
            $certi_ib_attach_more->file_section         = '1';
            $certi_ib_attach_more->file                 = $copiedScopes[0]['attachs'];
            $certi_ib_attach_more->file_client_name     = $copiedScopes[0]['file_client_name'];
            $certi_ib_attach_more->token                = str_random(16);
            $certi_ib_attach_more->save();
        }
        $tracking = $app_certi_ib->tracking;
        if($tracking !== null)
        {
            $inspection = TrackingInspection::where('tracking_id',$tracking->id)  
                    ->where('reference_refno',$tracking->reference_refno)
                    ->first();
            if($inspection !== null){
                    $certiIbFileAll = CertiIBAttachAll::where('app_certi_ib_id',$app_certi_ib->id)
                        ->where('table_name',$tb->getTable())
                        ->where('file_section',1)
                        ->latest() // เรียงจาก created_at จากมากไปน้อย
                        ->first();
            
                    $filePath = 'files/applicants/check_files_ib/' . $certiIbFileAll->file ;
            
                    $localFilePath = HP::downloadFileFromTisiCloud($filePath);

                    // dd($app_certi_ib ,$certiIbFileAll,$filePath,$localFilePath);

                    $check = AttachFile::where('systems','Center')
                            ->where('ref_id',$inspection->id)
                            ->where('ref_table',(new TrackingInspection)->getTable())
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
                                
                    $attach_path = "files/trackingib";
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
        }


    }

    public function genThPage($app_certi_ib,$ibScopeTransactions)
    {
        $mpdf = $this->setMpdf(12, 12, 80, 20);
        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        
        $header = view('certify.scope_pdf.ib.pdf-scope-header', [
            'app_certi_ib' => $app_certi_ib
        ]);
        $mpdf->SetHTMLHeader($header);
        
        $html = view('certify.scope_pdf.ib.pdf-scope', [
            'ibScopeTransactions' => $ibScopeTransactions,
            'app_certi_ib' => $app_certi_ib,
        ]);
        $mpdf->WriteHTML($html);

        // $title = "combined_final.pdf";
        // $mpdf->Output($title, "I");
        return  $mpdf;
    }

    public function genEnPage($app_certi_ib,$ibScopeTransactions)
    {
        $mpdf = $this->setMpdf(12, 12, 60, 20);
        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        
        $header = view('certify.scope_pdf.ib.pdf-scope-header-eng', [
            'app_certi_ib' => $app_certi_ib
        ]);
        $mpdf->SetHTMLHeader($header);
        
        $html = view('certify.scope_pdf.ib.pdf-scope-eng', [
            'ibScopeTransactions' => $ibScopeTransactions,
            'app_certi_ib' => $app_certi_ib,
        ]);
        $mpdf->WriteHTML($html);

        // $title = "combined_final.pdf";
        // $mpdf->Output($title, "I");
        return $mpdf;
    }
    public function generatePdf_()
    { 
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        // dd($app_certi_ib);
        $result = $this->splitDataToPageList();
       

        // เข้าถึงค่าด้วยคีย์
        $firstPageIbScopeTransactions = $result['firstPageIbScopeTransactions'];
        $remainingIbScopeTransactions = $result['remainingIbScopeTransactions'];

        $mpdfArray = []; 
        
        array_unshift($remainingIbScopeTransactions, $firstPageIbScopeTransactions);
        

        $remainingIbScopeTransactions = array_filter($remainingIbScopeTransactions, function ($collection) {
            return $collection->isNotEmpty();
        });

        
   
        foreach($remainingIbScopeTransactions as $key => $remainingIbScopeTransaction)
        {
            $mpdf =  $this->setMpdf(12,12,80,20);     
    
            $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
            
            $mpdf->WriteHTML($stylesheet, 1);
    
            // ตรวจสอบว่าหน้าเป็นหน้าสุดท้ายหรือไม่
            $isLastPage = ($key == count($remainingIbScopeTransactions) - 1);

            

            if(count($remainingIbScopeTransactions) == 1){
                // dd(count($remainingIbScopeTransactions),$isLastPage);
                $mpdf->SetWatermarkImage(public_path('images/nc_hq_cb.png'), 1, '', [175, 2]); // กำหนด opacity, ตำแหน่ง
                    $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark
    
                    $header = view('certify.scope_pdf.ib.pdf-scope-header', [
                        'app_certi_ib' => $app_certi_ib
                    ]);
                    $mpdf->SetHTMLHeader($header);
                    $html = view('certify.scope_pdf.ib.pdf-scope', [
                        'ibScopeTransactions' => $remainingIbScopeTransaction
                    ]);

                    $mpdf->WriteHTML($html);
                    $mpdfArray[$key] = $mpdf;

                    $lastMpdf =  $this->setMpdf(12, 12, 20, 20);  
                    $lastMpdf->WriteHTML($stylesheet, 1);
                    $html = view('certify.scope_pdf.ib.pdf-scope-single-last', [
                        'app_certi_ib' => $app_certi_ib
                    ]);
                    $lastMpdf->WriteHTML($html);
                    $mpdfArray[$key+1] = $lastMpdf;



            }else if(count($remainingIbScopeTransactions) > 1)
            {
                if($key == 0)
                {
                    $mpdf->SetWatermarkImage(public_path('images/nc_hq_cb.png'), 1, '', [175, 2]); // กำหนด opacity, ตำแหน่ง
                    $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark
    
                    $header = view('certify.scope_pdf.ib.pdf-scope-header', [
                        'app_certi_ib' => $app_certi_ib
                    ]);
                    $mpdf->SetHTMLHeader($header);
                    $html = view('certify.scope_pdf.ib.pdf-scope', [
                        'ibScopeTransactions' => $remainingIbScopeTransaction
                    ]);
                }else{
                    $mpdf->AddPage('', '', '', '', '', 12, 12, 20, 20); 
                    if ($isLastPage) {
                        $html = view('certify.scope_pdf.ib.pdf-scope-last', [
                            'ibScopeTransactions' => $remainingIbScopeTransaction,
                            'app_certi_ib' => $app_certi_ib
                        ]);
                    } else {
                        $html = view('certify.scope_pdf.ib.pdf-scope', [
                            'ibScopeTransactions' => $remainingIbScopeTransaction
                        ]);
    
                    }    
                }
    
                $mpdf->WriteHTML($html);
                $mpdfArray[$key] = $mpdf;
            }


    
        }

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
        
        $combinedPdf = new \Mpdf\Mpdf([
                'PDFA' 	=>  $type == 'F' ? true : false,
                'PDFAauto'	 =>  $type == 'F' ? true : false,
                'format'           => 'A4',
                'mode'             => 'utf-8',
                'default_font_size'=> '15',
                'fontDir'          => array_merge((new ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                'fontdata'         => array_merge((new FontVariables())->getDefaults()['fontdata'], $fontData),
                'default_font'     => 'thsarabunnew',
        ]);

        $combinedEnPdf = new \Mpdf\Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'           => 'A4',
            'mode'             => 'utf-8',
            'default_font_size'=> '15',
            'fontDir'          => array_merge((new ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew',
    ]);

        //  $combinedPdf->SetImportUse();

        
        $mpdfEnArray = []; 

        $resultEn = $this->splitDataToPageListEn();
        $firstPageIbScopeEnTransactions = $resultEn['firstPageIbScopeEnTransactions'];
        $remainingIbScopeEnTransactions = $resultEn['remainingIbScopeEnTransactions'];

        array_unshift($remainingIbScopeEnTransactions, $firstPageIbScopeEnTransactions);

        $remainingIbScopeEnTransactions = array_filter($remainingIbScopeEnTransactions, function ($collection) {
            return $collection->isNotEmpty();
        });
        // dd(count($remainingIbScopeEnTransactions));
        foreach($remainingIbScopeEnTransactions as $key => $remainingIbScopeEnTransaction)
        {
            
            $mpdfEn =  $this->setMpdf(12,12,60,20);     
    
            $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
            
            $mpdfEn->WriteHTML($stylesheet, 1);
    
            // ตรวจสอบว่าหน้าเป็นหน้าสุดท้ายหรือไม่
            $isLastPageEn = ($key == count($remainingIbScopeEnTransactions) - 1);

            if(count($remainingIbScopeEnTransactions) == 1){
                $mpdfEn->SetWatermarkImage(public_path('images/nc_hq_cb.png'), 1, '', [175, 2]); // กำหนด opacity, ตำแหน่ง
                    $mpdfEn->showWatermarkImage = true; // เปิดใช้งาน watermark
    
                    $headerEn = view('certify.scope_pdf.ib.pdf-scope-header-eng', [
                        'app_certi_ib' => $app_certi_ib
                    ]);
                    $mpdfEn->SetHTMLHeader($headerEn);
                    $htmlEn = view('certify.scope_pdf.ib.pdf-scope-eng', [
                        'ibScopeTransactions' => $remainingIbScopeEnTransaction
                ]);

                $mpdfEn->WriteHTML($htmlEn);
                $mpdfEnArray[$key] = $mpdfEn;

                $lastMpdfEn =  $this->setMpdf(12,12,20,20);  
                $lastMpdfEn->WriteHTML($stylesheet, 1); 

                $htmlEn = view('certify.scope_pdf.ib.pdf-scope-single-last-eng', [
                    'ibScopeTransactions' => $remainingIbScopeEnTransaction,
                    'app_certi_ib' => $app_certi_ib
                ]);

                $lastMpdfEn->WriteHTML($htmlEn);
                $mpdfEnArray[$key+1] = $lastMpdfEn;

            }else if(count($remainingIbScopeEnTransactions) > 1){
                if($key == 0)
                {
                    $mpdfEn->SetWatermarkImage(public_path('images/nc_hq_cb.png'), 1, '', [175, 2]); // กำหนด opacity, ตำแหน่ง
                    $mpdfEn->showWatermarkImage = true; // เปิดใช้งาน watermark
    
                    $headerEn = view('certify.scope_pdf.ib.pdf-scope-header-eng', [
                        'app_certi_ib' => $app_certi_ib
                    ]);
                    $mpdfEn->SetHTMLHeader($headerEn);
                    $htmlEn = view('certify.scope_pdf.ib.pdf-scope-eng', [
                        'ibScopeTransactions' => $remainingIbScopeEnTransaction
                    ]);
                }else{
                    $mpdfEn->AddPage('', '', '', '', '', 12, 12, 20, 20); 
                    if ($isLastPageEn) {
                        $htmlEn = view('certify.scope_pdf.ib.pdf-scope-last-eng', [
                            'ibScopeTransactions' => $remainingIbScopeEnTransaction,
                            'app_certi_ib' => $app_certi_ib
                        ]);
                    } else {
                        $htmlEn = view('certify.scope_pdf.ib.pdf-scope-eng', [
                            'ibScopeTransactions' => $remainingIbScopeEnTransaction
                        ]);
    
                    }    
                }
    
                $mpdfEn->WriteHTML($htmlEn);
                $mpdfEnArray[$key] = $mpdfEn;
            }

    
        }


        // สร้างอ็อบเจ็กต์ PDF ใหม่สำหรับรวมไฟล์ทั้งหมด

        $finalPdf = new \Mpdf\Mpdf([
                'PDFA' 	=>  $type == 'F' ? true : false,
                'PDFAauto'	 =>  $type == 'F' ? true : false,
                'format'           => 'A4',
                'mode'             => 'utf-8',
                'default_font_size'=> '15',
                'fontDir'          => array_merge((new ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
                'fontdata'         => array_merge((new FontVariables())->getDefaults()['fontdata'], $fontData),
                'default_font'     => 'thsarabunnew',
        ]);

        // เพิ่ม stylesheet
        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $finalPdf->WriteHTML($stylesheet, 1); // โหมด 1 = เขียนเฉพาะ CSS

        // 1. ประมวลผล tempFiles (combinedPdf) ก่อน
        $tempFiles = []; // เก็บรายชื่อไฟล์ชั่วคราว
        foreach ($mpdfArray as $key => $mpdf) {
            $tempFileName = "temp_{$key}.pdf"; // เช่น temp_0.pdf, temp_1.pdf
            $mpdf->Output($tempFileName, \Mpdf\Output\Destination::FILE); // บันทึก PDF ชั่วคราว
            $tempFiles[] = $tempFileName;
        }

        // 2. ประมวลผล tempEnFiles (combinedEnPdf) ต่อ
        $tempEnFiles = []; // เก็บรายชื่อไฟล์ชั่วคราว
        foreach ($mpdfEnArray as $key => $mpdf_en) {
            $tempEnFileName = "temp_en_{$key}.pdf"; // เช่น temp_en_0.pdf, temp_en_1.pdf
            $mpdf_en->Output($tempEnFileName, \Mpdf\Output\Destination::FILE); // บันทึก PDF ชั่วคราว
            $tempEnFiles[] = $tempEnFileName;
        }

        // 3. คำนวณจำนวนหน้าทั้งหมดก่อน
        $totalPages = 0;
        foreach ($tempFiles as $fileName) {
            $totalPages += $finalPdf->SetSourceFile($fileName); // นับจำนวนหน้าจาก tempFiles
        }
        foreach ($tempEnFiles as $fileNameEn) {
            $totalPages += $finalPdf->SetSourceFile($fileNameEn); // นับจำนวนหน้าจาก tempEnFiles
        }
        $totalPagesThai = HP::toThaiNumber($totalPages); // จำนวนหน้าทั้งหมดในรูปแบบเลขไทย

        // 4. รวมไฟล์ทั้งหมด โดยเริ่มจาก tempFiles
        $currentPage = 1; // ตัวนับหน้าเริ่มต้น
        foreach ($tempFiles as $key => $fileName) {
            $pageCount = $finalPdf->SetSourceFile($fileName); // เปิดไฟล์ PDF
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $finalPdf->ImportPage($i);
                $finalPdf->AddPage();
                $finalPdf->UseTemplate($templateId);

                $sign1Image = public_path('images/sign.jpg');
                $footer = view('certify.scope_pdf.ib.pdf-scope-footer', [
                    'qrImage' => null,
                    'sign1Image' => $sign1Image,
                    'sign2Image' => null,
                    'sign3Image' => null,
                    'totalPages' => HP::toThaiNumber(count($tempFiles)), // จำนวนหน้าทั้งหมด
                    'currentPage' => HP::toThaiNumber($key+1), // หน้าปัจจุบัน
                    'app_certi_ib' => $app_certi_ib
                    

                ]);
                $finalPdf->SetHTMLFooter($footer);
                $currentPage++; // เพิ่มหน้าปัจจุบัน
            }
        }

        // 5. ตามด้วย tempEnFiles
        foreach ($tempEnFiles as $key => $fileNameEn) {
            $pageEnCount = $finalPdf->SetSourceFile($fileNameEn); // เปิดไฟล์ PDF
            for ($i = 1; $i <= $pageEnCount; $i++) {
                $templateEnId = $finalPdf->ImportPage($i);
                $finalPdf->AddPage();
                $finalPdf->UseTemplate($templateEnId);

                $sign1Image = public_path('images/sign.jpg');
                $footerEn = view('certify.scope_pdf.ib.pdf-scope-footer-eng', [
                    'qrImage' => null,
                    'sign1Image' => $sign1Image,
                    'sign2Image' => null,
                    'sign3Image' => null,
                    'totalPages' => count($tempEnFiles), // จำนวนหน้าทั้งหมด
                    'currentPage' => $key+1, // หน้าปัจจุบันต่อจาก tempFiles
                    'app_certi_ib' => $app_certi_ib
                ]);
                $finalPdf->SetHTMLFooter($footerEn);
                $currentPage++; // เพิ่มหน้าปัจจุบัน
            }
        }

        // 6. Render ไฟล์ที่รวมแล้วออกมา
        // $title = "combined_final.pdf";
        // $finalPdf->Output($title, "I");

        // 7. ลบไฟล์ชั่วคราว (ถ้าต้องการ)
        foreach ($tempFiles as $file) {
            unlink($file);
        }
        foreach ($tempEnFiles as $file) {
            unlink($file);
        }



        $tbx = new CertiIBSaveAssessment;
        $tb = new CertiIBReport;



        // $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        $no = str_replace("RQ-", "", $app_certi_ib->app_no);
        $no = str_replace("-", "_", $no);


        $attachPath = '/files/applicants/check_files_ib/' . $no . '/';
        $fullFileName = uniqid() . '_' . now()->format('Ymd_His') . '.pdf';
    
        // สร้างไฟล์ชั่วคราว
        $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
        // บันทึก PDF ไปยังไฟล์ชั่วคราว
        $finalPdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);
        // ใช้ Storage::putFileAs เพื่อย้ายไฟล์
        Storage::putFileAs($attachPath, new \Illuminate\Http\File($tempFilePath), $fullFileName);
    
        $storePath = $no  . '/' . $fullFileName;
    
        // ลบไฟล์ชั่วคราว
        // foreach ($tempFiles as $fileName) {
        //     unlink($fileName);
        // }
    
        $tb = new CertiIb;
        $certi_ib_attach                   = new CertiIBAttachAll();
        $certi_ib_attach->app_certi_ib_id = $app_certi_ib->id;
        $certi_ib_attach->table_name       = $tb->getTable();
        $certi_ib_attach->file_section     = '3';
        $certi_ib_attach->file_desc        = null;
        $certi_ib_attach->file             = $storePath;
        $certi_ib_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
        $certi_ib_attach->token            = str_random(16);
        $certi_ib_attach->save();

        $checkScopeCertiIBSaveAssessment = CertiIBAttachAll::where('app_certi_ib_id',$this->certi_ib_id)
        ->where('table_name', (new CertiIBSaveAssessment)->getTable())
        ->where('file_section', 2)
        ->latest() // ใช้ latest() เพื่อให้เรียงตาม created_at โดยอัตโนมัติ
        ->first(); // ดึง record ล่าสุดเพียงตัวเดียว


        if($checkScopeCertiIBSaveAssessment != null)
        {
            $assessment = CertiIBSaveAssessment::find($checkScopeCertiIBSaveAssessment->ref_id);
            $json = $this->copyScopeIbFromAttachement($assessment->app_certi_ib_id);
            $copiedScopes = json_decode($json, true);
            $tbx = new CertiIBSaveAssessment;
            $certi_ib_attach_more = new CertiIBAttachAll();
            $certi_ib_attach_more->app_certi_ib_id      = $assessment->app_certi_ib_id ?? null;
            $certi_ib_attach_more->ref_id               = $assessment->id;
            $certi_ib_attach_more->table_name           = $tbx->getTable();
            $certi_ib_attach_more->file_section         = '2';
            $certi_ib_attach_more->file                 = $copiedScopes[0]['attachs'];
            $certi_ib_attach_more->file_client_name     = $copiedScopes[0]['file_client_name'];
            $certi_ib_attach_more->token                = str_random(16);
            $certi_ib_attach_more->save();
        }

        $checkScopeCertiIBReport= CertiIBAttachAll::where('app_certi_ib_id',$this->certi_ib_id)
        ->where('table_name',(new CertiIBReport)->getTable())
        ->where('file_section',1)
        ->latest() // ใช้ latest() เพื่อให้เรียงตาม created_at โดยอัตโนมัติ
        ->first(); // ดึง record ล่าสุดเพียงตัวเดียว

        if($checkScopeCertiIBReport != null)
        {
            $report = CertiIBReport::find($checkScopeCertiIBReport->ref_id);
            $json = $this->copyScopeIbFromAttachement($report->app_certi_ib_id);
            $copiedScopes = json_decode($json, true);
            $tb = new CertiIBReport;
            $certi_ib_attach_more = new CertiIBAttachAll();
            $certi_ib_attach_more->app_certi_ib_id      = $report->app_certi_ib_id ?? null;
            $certi_ib_attach_more->ref_id               = $report->id;
            $certi_ib_attach_more->table_name           = $tb->getTable();
            $certi_ib_attach_more->file_section         = '1';
            $certi_ib_attach_more->file                 = $copiedScopes[0]['attachs'];
            $certi_ib_attach_more->file_client_name     = $copiedScopes[0]['file_client_name'];
            $certi_ib_attach_more->token                = str_random(16);
            $certi_ib_attach_more->save();
        }




    }

    public function copyScopeIbFromAttachement($certiIbId)
    {
        $copiedScoped = null;
        $fileSection = null;
    
        $app = CertiIb::find($certiIbId);
    
        $latestRecord = CertiIBAttachAll::where('app_certi_ib_id', $certiIbId)
        ->where('file_section', 3)
        ->where('table_name', 'app_certi_ib')
        ->orderBy('created_at', 'desc') // เรียงลำดับจากใหม่ไปเก่า
        ->first();
    
        $existingFilePath = 'files/applicants/check_files_ib/' . $latestRecord->file ;
    
        // ตรวจสอบว่าไฟล์มีอยู่ใน FTP และดาวน์โหลดลงมา
        if (HP::checkFileStorage($existingFilePath)) {
            $localFilePath = HP::getFileStoragePath($existingFilePath); // ดึงไฟล์ลงมาที่เซิร์ฟเวอร์
            $no  = str_replace("RQ-","",$app->app_no);
            $no  = str_replace("-","_",$no);
            $dlName = 'scope_'.basename($existingFilePath);
            $attach_path  =  'files/applicants/check_files_ib/'.$no.'/';
    
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
    public function setMpdf($margin_left,$margin_right,$margin_top,$margin_bottom)
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
        return new Mpdf([
            'PDFA' 	=>  false,
            'PDFAauto'	 =>  false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => $margin_left, // ระบุขอบด้านซ้าย
            'margin_right'     => $margin_right, // ระบุขอบด้านขวา
            'margin_top'       => $margin_top, // ระบุขอบด้านบน
            'margin_bottom'    => $margin_bottom, // ระบุขอบด้านล่าง
        ]); 
    }

    public function splitDataToPageList()
    {
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id',$app_certi_ib->id)->get();

        // dd($ibScopeTransactions);
        
        $mpdf =  $this->setMpdf(12,12,80,20);

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        
        $mpdf->WriteHTML($stylesheet, 1);

        $header = view('certify.scope_pdf.ib.pdf-scope-header', [
            'app_certi_ib' => $app_certi_ib
          ]);
          $mpdf->SetHTMLHeader($header);
        
        $html = view('certify.scope_pdf.ib.pdf-scope', [
                'ibScopeTransactions' => $ibScopeTransactions
            ]);
        $mpdf->WriteHTML($html);

        
        // $title = "ibscope.pdf";
        
        // $mpdf->Output($title, "I");  

        // return;

        // แปลง PDF เป็น String
        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);


        // dd($pdf);

        $chunks = $this->splitDataToChunk($ibScopeTransactions,$pdf);

        // dd($chunks);

        $firstPage = array_slice($chunks, 0, 1);

        $firstPageIbScopeTransactions = $ibScopeTransactions->take(count($firstPage[0]));

        
        $remainingIbScopeTransactions = $ibScopeTransactions->slice(count($firstPage[0]))->values();


        // dd($chunks,$firstPage,$ibScopeTransactions,$remainingIbScopeTransactions);
        // ดึงหน้าอื่น ๆ จาก view หน้าถัดไป ที่ไม่ใช่หน้าแรก

        
        if(count($remainingIbScopeTransactions) != 0)
        {
            $mpdf =  $this->setMpdf(12,12,13,20);

            $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            $html = view('certify.scope_pdf.ib.pdf-scope', [
                    'ibScopeTransactions' => $remainingIbScopeTransactions
                ]);
            $mpdf->WriteHTML($html);
    
    
            
            // $title = "ibscope.pdf";
            
            // $mpdf->Output($title, "I");  
    
    
            $pdfContent = $mpdf->Output('', 'S');
    
            // ใช้ PdfParser อ่าน PDF จาก String
            $parser = new Parser();
            $pdf = $parser->parseContent($pdfContent);
    
            $chunks = $this->splitDataToChunk($remainingIbScopeTransactions,$pdf);
    

    
        }

        $remainingIbScopeIsicTransactionArray = [];
        $offset = 0; // ตำแหน่งเริ่มต้นของ slice

        // dd($remainingIbScopeTransactions);
        foreach ($chunks as $chunk) {
            $count = count($chunk);
            $remainingIbScopeIsicTransactionArray[] = $remainingIbScopeTransactions->slice($offset, $count);
            $offset += $count; // ปรับตำแหน่งเริ่มต้นของ slice สำหรับรอบถัดไป
        }

        // foreach ($chunks as $chunk) {
        //     $count = count($chunk);
        //     $slicedCollection = $remainingIbScopeTransactions->slice($offset, $count);
        //     if ($slicedCollection->count() > 0) {
        //         $remainingIbScopeIsicTransactionArray[] = $slicedCollection;
        //     }
        //     $offset += $count;
        // }

        // dd($remainingIbScopeIsicTransactionArray);


        return [
            'firstPageIbScopeTransactions' => $firstPageIbScopeTransactions,
            'remainingIbScopeTransactions' => $remainingIbScopeIsicTransactionArray,
        ];
    }

    public function splitDataToPageListEn()
    {
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id',$app_certi_ib->id)->get();

        
        $mpdf =  $this->setMpdf(12,12,60,20);

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        
        $mpdf->WriteHTML($stylesheet, 1);

        $header = view('certify.scope_pdf.ib.pdf-scope-header-eng', [
            'app_certi_ib' => $app_certi_ib
          ]);
          $mpdf->SetHTMLHeader($header);
        
        $html = view('certify.scope_pdf.ib.pdf-scope-eng', [
                'ibScopeTransactions' => $ibScopeTransactions
            ]);
        $mpdf->WriteHTML($html);

        
        // $title = "ibscope.pdf";
        
        // $mpdf->Output($title, "I");  

        // return;

        // แปลง PDF เป็น String
        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);


        // dd($pdf);

        $chunks = $this->splitDataToChunk($ibScopeTransactions,$pdf);

        // dd($ibScopeTransactions,$pdf);

        $firstPage = array_slice($chunks, 0, 1);

        $firstPageIbScopeEnTransactions = $ibScopeTransactions->take(count($firstPage[0]));

       
        
        $remainingIbScopeEnTransactions = $ibScopeTransactions->slice(count($firstPage[0]))->values();

      
        // ดึงหน้าอื่น ๆ จาก view หน้าถัดไป ที่ไม่ใช่หน้าแรก

        if(count($remainingIbScopeEnTransactions) != 0)
        {

            $mpdf =  $this->setMpdf(12,12,13,20);

            $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            $html = view('certify.scope_pdf.ib.pdf-scope-eng', [
                    'ibScopeTransactions' => $remainingIbScopeEnTransactions
                ]);
            $mpdf->WriteHTML($html);
    
            
            // $title = "ibscope.pdf";
            
            // $mpdf->Output($title, "I");  
    
            // return;
    
            $pdfContent = $mpdf->Output('', 'S');
    
            // ใช้ PdfParser อ่าน PDF จาก String
            $parser = new Parser();
            $pdf = $parser->parseContent($pdfContent);
    
            $chunks = $this->splitDataToChunk($remainingIbScopeEnTransactions,$pdf);
        }


        $remainingIbScopeIsicTransactionArray = [];
        $offset = 0; // ตำแหน่งเริ่มต้นของ slice

        foreach ($chunks as $chunk) {
            $count = count($chunk);
            $remainingIbScopeIsicTransactionArray[] = $remainingIbScopeEnTransactions->slice($offset, $count);
            $offset += $count; // ปรับตำแหน่งเริ่มต้นของ slice สำหรับรอบถัดไป
        }

        // foreach ($chunks as $chunk) {
        //     $count = count($chunk);
        //     $slicedCollection = $remainingIbScopeEnTransactions->slice($offset, $count);
        //     if ($slicedCollection->count() > 0) {
        //         $remainingIbScopeIsicTransactionArray[] = $slicedCollection;
        //     }
        //     $offset += $count;
        // }



        return [
            'firstPageIbScopeEnTransactions' => $firstPageIbScopeEnTransactions,
            'remainingIbScopeEnTransactions' => $remainingIbScopeIsicTransactionArray,
        ];
    }


    function splitDataToChunk($data, $pdf)
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
        $pageList = array_map(function ($end) use (&$start, $data) {
            $range = range($start, (int)$end); // สร้างช่วง index
            $start = (int)$end + 1; // อัปเดตค่าเริ่มต้นสำหรับช่วงถัดไป
            return array_map(function ($index) use ($data) {
                return $data[$index] ?? null; // ดึงค่าจาก $data ตาม index
            }, $range);
        }, $maxNumber);

        return $pageList;
        
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


 


 



}
