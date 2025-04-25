<?php

namespace App\Services;
use HP;
use stdClass;
use Mpdf\Mpdf;
use Carbon\Carbon;
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
use App\Models\Certify\ApplicantCB\CertiCb;
use App\Models\Certify\ApplicantIB\CertiIb;
use App\Models\Certificate\IbScopeTransaction;
use App\Models\Certify\ApplicantCB\CertiCBReport;
use App\Models\Certificate\CbScopeIsicTransaction;
use App\Models\Certify\Applicant\CertiLabAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrument;
use App\Models\Certify\ApplicantCB\CertiCBAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;
use App\Models\Certify\ApplicantCB\CertiCBSaveAssessment;

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
        // dd($app_certi_ib);
        $result = $this->splitDataToPageList();
       

        // เข้าถึงค่าด้วยคีย์
        $firstPageIbScopeTransactions = $result['firstPageIbScopeTransactions'];
        $remainingIbScopeTransactions = $result['remainingIbScopeTransactions'];


        $mpdfArray = []; 
        
        array_unshift($remainingIbScopeTransactions, $firstPageIbScopeTransactions);
   
        foreach($remainingIbScopeTransactions as $key => $remainingCbScopeIsicTransaction)
        {
            $mpdf =  $this->setMpdf(12,12,80,20);     
    
            $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
            
            $mpdf->WriteHTML($stylesheet, 1);
    
            // ตรวจสอบว่าหน้าเป็นหน้าสุดท้ายหรือไม่
            $isLastPage = ($key == count($remainingIbScopeTransactions) - 1);

            if($key == 0)
            {
                $mpdf->SetWatermarkImage(public_path('images/nc_hq_cb.png'), 1, '', [175, 2]); // กำหนด opacity, ตำแหน่ง
                $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark

                $header = view('certify.scope_pdf.ib.pdf-scope-header', [
                    'app_certi_ib' => $app_certi_ib
                ]);
                $mpdf->SetHTMLHeader($header);
                $html = view('certify.scope_pdf.ib.pdf-scope', [
                    'ibScopeTransactions' => $remainingCbScopeIsicTransaction
                ]);
            }else{
                $mpdf->AddPage('', '', '', '', '', 12, 12, 20, 20); 
                if ($isLastPage) {
                    $html = view('certify.scope_pdf.ib.pdf-scope-last', [
                        'ibScopeTransactions' => $remainingCbScopeIsicTransaction,
                        'app_certi_ib' => $app_certi_ib
                    ]);
                } else {
                    $html = view('certify.scope_pdf.ib.pdf-scope', [
                        'ibScopeTransactions' => $remainingCbScopeIsicTransaction
                    ]);

                }    
            }

            $mpdf->WriteHTML($html);
            $mpdfArray[$key] = $mpdf;
    
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

        //  $combinedPdf->SetImportUse();

        


        // $resultEn = $this->splitDataToPageListEn();

        
        // สร้างไฟล์ PDF ชั่วคราวจาก `$mpdfArray`
        $tempFiles = []; // เก็บรายชื่อไฟล์ชั่วคราว
        foreach ($mpdfArray as $key => $mpdf) {
            $tempFileName = "{$key}.pdf"; // เช่น main.pdf, branch0.pdf
            $mpdf->Output($tempFileName, \Mpdf\Output\Destination::FILE); // บันทึก PDF ชั่วคราว
            $tempFiles[] = $tempFileName;
        }

        // รวม PDF
        foreach ($tempFiles as $key => $fileName) {
            $pageCount = $combinedPdf->SetSourceFile($fileName); // เปิดไฟล์ PDF
            // dd($pageCount);
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $combinedPdf->ImportPage($i);
                $combinedPdf->AddPage();
                $combinedPdf->UseTemplate($templateId);

            $signImage = null;
            $sign1Image = public_path('images/sign.jpg');
            // dd($sign1Image);
            $footer = view('certify.scope_pdf.ib.pdf-scope-footer', [
                'qrImage' => null,
                'sign1Image' => $sign1Image,
                'sign2Image' => null,
                'sign3Image' => null,
                'totalPages' => HP::toThaiNumber(count($tempFiles)),
                'currentPage' => HP::toThaiNumber($key+1),
            ]);

                // ตั้งค่า Footer ใหม่สำหรับหน้า PDF
                $combinedPdf->SetHTMLFooter($footer);
            }
        }


        $title = "cbscopeisic.pdf";
        
        $combinedPdf->Output($title, "I");  

        $tbx = new CertiCBSaveAssessment;
        $tb = new CertiCBReport;


        // dd($checkScopeCertiCBSaveAssessment,$checkScopeCertiCBReport);



        // $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);
        $app_certi_ib = CertiCb::find($this->certi_ib_id);
        $no = str_replace("RQ-", "", $app_certi_ib->app_no);
        $no = str_replace("-", "_", $no);


        $attachPath = '/files/applicants/check_files_cb/' . $no . '/';
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
    
        $tb = new CertiCb;
        $certi_cb_attach                   = new CertiCBAttachAll();
        $certi_cb_attach->app_certi_ib_id = $app_certi_ib->id;
        $certi_cb_attach->table_name       = $tb->getTable();
        $certi_cb_attach->file_section     = 3;
        $certi_cb_attach->file_desc        = null;
        $certi_cb_attach->file             = $storePath;
        $certi_cb_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
        $certi_cb_attach->token            = str_random(16);
        $certi_cb_attach->save();

        $checkScopeCertiCBSaveAssessment = CertiCBAttachAll::where('app_certi_ib_id',$this->certi_ib_id)
        ->where('table_name', (new CertiCBSaveAssessment)->getTable())
        ->where('file_section', 2)
        ->latest() // ใช้ latest() เพื่อให้เรียงตาม created_at โดยอัตโนมัติ
        ->first(); // ดึง record ล่าสุดเพียงตัวเดียว


        if($checkScopeCertiCBSaveAssessment != null)
        {
            $assessment = CertiCBSaveAssessment::find($checkScopeCertiCBSaveAssessment->ref_id);
            $json = $this->copyScopeCbFromAttachement($assessment->app_certi_ib_id);
            $copiedScopes = json_decode($json, true);
            $tbx = new CertiCBSaveAssessment;
            $certi_cb_attach_more = new CertiCBAttachAll();
            $certi_cb_attach_more->app_certi_ib_id      = $assessment->app_certi_ib_id ?? null;
            $certi_cb_attach_more->ref_id               = $assessment->id;
            $certi_cb_attach_more->table_name           = $tbx->getTable();
            $certi_cb_attach_more->file_section         = '2';
            $certi_cb_attach_more->file                 = $copiedScopes[0]['attachs'];
            $certi_cb_attach_more->file_client_name     = $copiedScopes[0]['file_client_name'];
            $certi_cb_attach_more->token                = str_random(16);
            $certi_cb_attach_more->save();
        }

        $checkScopeCertiCBReport= CertiCBAttachAll::where('app_certi_ib_id',$this->certi_ib_id)
        ->where('table_name',(new CertiCBReport)->getTable())
        ->where('file_section',1)
        ->latest() // ใช้ latest() เพื่อให้เรียงตาม created_at โดยอัตโนมัติ
        ->first(); // ดึง record ล่าสุดเพียงตัวเดียว

        if($checkScopeCertiCBReport != null)
        {
            $report = CertiCBReport::find($checkScopeCertiCBReport->ref_id);
            $json = $this->copyScopeCbFromAttachement($report->app_certi_ib_id);
            $copiedScopes = json_decode($json, true);
            $tb = new CertiCBReport;
            $certi_cb_attach_more = new CertiCBAttachAll();
            $certi_cb_attach_more->app_certi_ib_id      = $report->app_certi_ib_id ?? null;
            $certi_cb_attach_more->ref_id               = $report->id;
            $certi_cb_attach_more->table_name           = $tb->getTable();
            $certi_cb_attach_more->file_section         = '1';
            $certi_cb_attach_more->file                 = $copiedScopes[0]['attachs'];
            $certi_cb_attach_more->file_client_name     = $copiedScopes[0]['file_client_name'];
            $certi_cb_attach_more->token                = str_random(16);
            $certi_cb_attach_more->save();
        }


    }

    public function copyScopeCbFromAttachement($certiCbId)
    {
        $copiedScoped = null;
        $fileSection = null;
    
        $app = CertiCb::find($certiCbId);
    
        $latestRecord = CertiCBAttachAll::where('app_certi_ib_id', $certiCbId)
        ->where('file_section', 3)
        ->where('table_name', 'app_certi_ib')
        ->orderBy('created_at', 'desc') // เรียงลำดับจากใหม่ไปเก่า
        ->first();
    
        $existingFilePath = 'files/applicants/check_files_cb/' . $latestRecord->file ;
    
        // ตรวจสอบว่าไฟล์มีอยู่ใน FTP และดาวน์โหลดลงมา
        if (HP::checkFileStorage($existingFilePath)) {
            $localFilePath = HP::getFileStoragePath($existingFilePath); // ดึงไฟล์ลงมาที่เซิร์ฟเวอร์
            $no  = str_replace("RQ-","",$app->app_no);
            $no  = str_replace("-","_",$no);
            $dlName = 'scope_'.basename($existingFilePath);
            $attach_path  =  'files/applicants/check_files_cb/'.$no.'/';
    
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

        // $ibScopeTransactions = CbScopeIsicTransaction::with([
        //     'cbScopeIsicCategoryTransactions.cbScopeIsicSubCategoryTransactions'
        // ])->where('certi_ib_id', $app_certi_ib->id)->get();

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

        
        // $title = "cbscopeisic.pdf";
        
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

        $firstPageIbScopeTransactions = $ibScopeTransactions->take(count($firstPage[0]));

       
        
        $remainingIbScopeTransactions = $ibScopeTransactions->slice(count($firstPage[0]))->values();

      
        // ดึงหน้าอื่น ๆ จาก view หน้าถัดไป ที่ไม่ใช่หน้าแรก

        

        $mpdf =  $this->setMpdf(12,12,13,20);

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        $html = view('certify.scope_pdf.ib.pdf-scope', [
                'ibScopeTransactions' => $remainingIbScopeTransactions
            ]);
        $mpdf->WriteHTML($html);


        
        // $title = "cbscopeisic.pdf";
        
        // $mpdf->Output($title, "I");  

        // return;

        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $chunks = $this->splitDataToChunk($remainingIbScopeTransactions,$pdf);

        $remainingCbScopeIsicTransactionArray = [];
        $offset = 0; // ตำแหน่งเริ่มต้นของ slice

        foreach ($chunks as $chunk) {
            $count = count($chunk);
            $remainingCbScopeIsicTransactionArray[] = $remainingIbScopeTransactions->slice($offset, $count);
            $offset += $count; // ปรับตำแหน่งเริ่มต้นของ slice สำหรับรอบถัดไป
        }

        // dd('ok');

        // $title = "cbscopeisic.pdf";
        
        // $mpdf->Output($title, "I");  

        // return;

        return [
            'firstPageIbScopeTransactions' => $firstPageIbScopeTransactions,
            'remainingIbScopeTransactions' => $remainingCbScopeIsicTransactionArray,
        ];
    }

    public function splitDataToPageListEn()
    {
        $app_certi_ib = CertiIb::find($this->certi_ib_id);
        $ibScopeTransactions = IbScopeTransaction::where('certi_ib_id',$app_certi_ib->id)->get();

        // $ibScopeTransactions = CbScopeIsicTransaction::with([
        //     'cbScopeIsicCategoryTransactions.cbScopeIsicSubCategoryTransactions'
        // ])->where('certi_ib_id', $app_certi_ib->id)->get();

        // dd($ibScopeTransactions);
        
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

        
        // $title = "cbscopeisic.pdf";
        
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

        

        $mpdf =  $this->setMpdf(12,12,13,20);

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        $html = view('certify.scope_pdf.ib.pdf-scope-eng', [
                'ibScopeTransactions' => $remainingIbScopeEnTransactions
            ]);
        $mpdf->WriteHTML($html);

        
        $title = "cbscopeisic.pdf";
        
        $mpdf->Output($title, "I");  

        // return;

        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $chunks = $this->splitDataToChunk($remainingIbScopeEnTransactions,$pdf);

        $remainingCbScopeIsicTransactionArray = [];
        $offset = 0; // ตำแหน่งเริ่มต้นของ slice

        foreach ($chunks as $chunk) {
            $count = count($chunk);
            $remainingCbScopeIsicTransactionArray[] = $remainingIbScopeEnTransactions->slice($offset, $count);
            $offset += $count; // ปรับตำแหน่งเริ่มต้นของ slice สำหรับรอบถัดไป
        }

        // dd('ok');

        // $title = "cbscopeisic.pdf";
        
        // $mpdf->Output($title, "I");  

        // return;

        return [
            'firstPageIbScopeEnTransactions' => $firstPageIbScopeEnTransactions,
            'remainingIbScopeEnTransactions' => $remainingCbScopeIsicTransactionArray,
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
