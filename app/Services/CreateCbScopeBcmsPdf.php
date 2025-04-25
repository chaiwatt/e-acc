<?php

namespace App\Services;
use HP;
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
use App\Models\Certificate\CbScopeBcmsTransaction;
use App\Models\Certificate\CbScopeIsicTransaction;
use App\Models\Certify\Applicant\CertiLabAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrument;
use App\Models\Certify\ApplicantCB\CertiCBAttachAll;
use App\Models\Bcertify\CalibrationBranchInstrumentGroup;

class CreateCbScopeBcmsPdf
{
    protected $certi_cb_id;
    protected $app_no;

    public function __construct($certi_cb)
    {
        $this->certi_cb_id = $certi_cb->id;
        $this->app_no = $certi_cb->app_no;
    }

    public function generatePdf()
    { 
        $app_certi_cb = CertiCb::find($this->certi_cb_id);
        // dd($app_certi_cb);
        $result = $this->splitDataToPageList();

        // เข้าถึงค่าด้วยคีย์
        $firstPageCbScopeBcmsTransactions = $result['firstPageCbScopeBcmsTransactions'];
        $remainingCbScopeBcmsTransactions = $result['remainingCbScopeBcmsTransactions'];
        

        $mpdfArray = []; 
        
        array_unshift($remainingCbScopeBcmsTransactions, $firstPageCbScopeBcmsTransactions);

        foreach($remainingCbScopeBcmsTransactions as $key => $remainingCbScopeBcmsTransaction)
        {
            $mpdf =  $this->setMpdf(14,8,125,20);     
    
            $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
            
            $mpdf->WriteHTML($stylesheet, 1);
    
            // ตรวจสอบว่าหน้าเป็นหน้าสุดท้ายหรือไม่
            $isLastPage = ($key == count($remainingCbScopeBcmsTransactions) - 1);

            if($key == 0)
            {
                $mpdf->SetWatermarkImage(public_path('images/nc_hq_cb.png'), 1, '', [175, 2]); // กำหนด opacity, ตำแหน่ง
                $mpdf->showWatermarkImage = true; // เปิดใช้งาน watermark

                $header = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope-header', [
                    'app_certi_cb' => $app_certi_cb
                ]);
                $mpdf->SetHTMLHeader($header);
                $html = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope', [
                    'cbScopeBcmsTransactions' => $remainingCbScopeBcmsTransaction
                ]);
            }else{
                $mpdf->AddPage('', '', '', '', '', 14, 8, 20, 20); 
                if ($isLastPage) {
                    $html = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope-last', [
                        'cbScopeBcmsTransactions' => $remainingCbScopeBcmsTransaction,
                        'app_certi_cb' => $app_certi_cb
                    ]);
                } else {
                    $html = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope', [
                        'cbScopeBcmsTransactions' => $remainingCbScopeBcmsTransaction
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
            $footer = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope-footer', [
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

        // $combinedPdf->Output('combined.pdf', \Mpdf\Output\Destination::INLINE);

        $app_certi_cb = CertiCb::find($this->certi_cb_id);
        $no = str_replace("RQ-", "", $app_certi_cb->app_no);
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
        $certi_cb_attach->app_certi_cb_id = $app_certi_cb->id;
        $certi_cb_attach->table_name       = $tb->getTable();
        $certi_cb_attach->file_section     = 3;
        $certi_cb_attach->file_desc        = null;
        $certi_cb_attach->file             = $storePath;
        $certi_cb_attach->file_client_name = $no . '_scope_'.now()->format('Ymd_His').'.pdf';
        $certi_cb_attach->token            = str_random(16);
        $certi_cb_attach->save();

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
        $app_certi_cb = CertiCb::find($this->certi_cb_id);
        $cbScopeBcmsTransactions = CbScopeBcmsTransaction::where('certi_cb_id',$app_certi_cb->id)->get();

        
        $mpdf =  $this->setMpdf(14,3,125,30);

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        
        $mpdf->WriteHTML($stylesheet, 1);

        $header = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope-header', [
            'app_certi_cb' => $app_certi_cb
          ]);
          $mpdf->SetHTMLHeader($header);
        
        $html = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope', [
                'cbScopeBcmsTransactions' => $cbScopeBcmsTransactions
            ]);
        $mpdf->WriteHTML($html);

        // $title = "cbscopeisic.pdf";
        
        // $mpdf->Output($title, "I");  

        // แปลง PDF เป็น String
        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $chunks = $this->splitDataToChunk($cbScopeBcmsTransactions,$pdf);

        $firstPage = array_slice($chunks, 0, 1);

        $firstPageCbScopeBcmsTransactions = $cbScopeBcmsTransactions->take(count($firstPage[0]));
        
        $remainingCbScopeBcmsTransactions = $cbScopeBcmsTransactions->slice(count($firstPage[0]))->values();

        // ดึงหน้าอื่น ๆ จาก view หน้าถัดไป ที่ไม่ใช่หน้าแรก

        $mpdf =  $this->setMpdf(14,3,20,50);

        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        $html = view('certify.scope_pdf.cb.bcms.pdf-bcms-scope-other', [
                'cbScopeBcmsTransactions' => $remainingCbScopeBcmsTransactions
            ]);
        $mpdf->WriteHTML($html);

        //   $title = "cbscopeisic.pdf";
        
        // $mpdf->Output($title, "I");  

        $pdfContent = $mpdf->Output('', 'S');

        // ใช้ PdfParser อ่าน PDF จาก String
        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $chunks = $this->splitDataToChunk($remainingCbScopeBcmsTransactions,$pdf);

        $remainingCbScopeBcmsTransactionArray = [];
        $offset = 0; // ตำแหน่งเริ่มต้นของ slice

        foreach ($chunks as $chunk) {
            $count = count($chunk);
            $remainingCbScopeBcmsTransactionArray[] = $remainingCbScopeBcmsTransactions->slice($offset, $count);
            $offset += $count; // ปรับตำแหน่งเริ่มต้นของ slice สำหรับรอบถัดไป
        }

        // $title = "cbscopeisic.pdf";
        
        // $mpdf->Output($title, "I");  

        return [
            'firstPageCbScopeBcmsTransactions' => $firstPageCbScopeBcmsTransactions,
            'remainingCbScopeBcmsTransactions' => $remainingCbScopeBcmsTransactionArray,
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
