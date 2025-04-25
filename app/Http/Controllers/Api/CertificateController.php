<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use HP;
use App\CertificateExport;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certify\Applicant\CertLabsFileAll;
class CertificateController extends Controller
{
    public function check_files_lab($id)
    {

           $certi_id = base64_decode(str_pad(strtr($id, '-_', '+/'), strlen($id) % 4, '=', STR_PAD_RIGHT));
           $certi_lab = CertiLab::findOrFail($certi_id);
     
           $public = public_path();
           $attach_path1 = 'files/applicants/check_files/';
           $arrContextOptions = array();

            // ใบรับรอง และ ขอบข่าย    
              if(!is_null($certi_lab->certi_lab_export_mapreq_to)){
                  $certificate_no =  !empty($certi_lab->certi_lab_export_mapreq_to->certificate_export->certificate_no) ? $certi_lab->certi_lab_export_mapreq_to->certificate_export->certificate_no : null;
                  if(!is_null($certificate_no)){
                      $export_no         =  CertificateExport::where('certificate_no',$certificate_no);
                      if(count($export_no->get()) > 0){
                          
                          $lab_ids = [];
                          if($export_no->pluck('certificate_for')->count() > 0){
                              foreach ($export_no->pluck('certificate_for') as $item) {
                                  if(!in_array($item,$lab_ids)){
                                     $lab_ids[] =  $item;
                                  }
                              }
                          }

                          if($certi_lab->certi_lab_export_mapreq_to->certilab_export_mapreq_group_many->count() > 0){
                              foreach ($certi_lab->certi_lab_export_mapreq_to->certilab_export_mapreq_group_many->pluck('app_certi_lab_id') as $item) {
                                  if(!in_array($item,$lab_ids)){
                                      $lab_ids[] =  $item;
                                  }
                              }
                          }

                          // ขอบข่าย
                          $attach_pdf =  CertLabsFileAll::whereIn('app_certi_lab_id',$lab_ids)->where('state', 1)->orderby('id','desc')->value('attach_pdf');
                    } 
               }
            }
  
  if(!empty($attach_pdf)){

      try {       
          if(!empty($attach_pdf)  && HP::checkFileStorage($attach_pdf)){
                 $attach_path2 = $attach_pdf;
                 HP::getFileStorage($attach_path2);

                 // $mpdf->SetImportUse();
                 $dashboard_pdf_file         =  url('uploads/'.$attach_path2);
                 $arrContextOptions = array();
                 if(strpos($dashboard_pdf_file, 'https')===0){//ถ้าเป็น https
                     $arrContextOptions["ssl"] = array(
                                                     "verify_peer" => false,
                                                     "verify_peer_name" => false,
                                                 );
                 }
                 $content_pdf =  file_get_contents($dashboard_pdf_file, false, stream_context_create($arrContextOptions));
                                     //Specify that the content has PDF Mime Type
                 header("Content-Type: application/pdf");
                 //Display it
                 echo $content_pdf;
                 exit;

                 
           }else   if(!empty($attach_pdf)  && HP::checkFileStorage($attach_path1.$attach_pdf)){
                 $attach_path2 = $attach_path1.$attach_pdf;
                 HP::getFileStorage($attach_path2);


                 $dashboard_pdf_file             =  url('uploads/'.$attach_path2);
                 $arrContextOptions = array();
                 if(strpos($dashboard_pdf_file, 'https')===0){//ถ้าเป็น https
                     $arrContextOptions["ssl"] = array(
                                                     "verify_peer" => false,
                                                     "verify_peer_name" => false,
                                                 );
                 }
                 $content_pdf =  file_get_contents($dashboard_pdf_file, false, stream_context_create($arrContextOptions));
                                     //Specify that the content has PDF Mime Type
                 header("Content-Type: application/pdf");
 
                 //Display it
                 echo $content_pdf;
                 exit;


          }else if(HP::checkFileStorage($attach_path1.'/' .$certi_lab->attach_pdf)){
                 $attach_path2 = $attach_path1.$certi_lab->attach_pdf;
                 HP::getFileStorage($attach_path2);
                 // $mpdf->SetImportUse();
                 $dashboard_pdf_file         =  url('uploads/'.$attach_path2);
                 $arrContextOptions = array();
                 if(strpos($setting_payment->data, 'https')===0){//ถ้าเป็น https
                     $arrContextOptions["ssl"] = array(
                                                     "verify_peer" => false,
                                                     "verify_peer_name" => false,
                                                 );
                 }
                 $content_pdf =  file_get_contents($dashboard_pdf_file, false, stream_context_create($arrContextOptions));
                                     //Specify that the content has PDF Mime Type
                 header("Content-Type: application/pdf");
                 //Display it
      
                 echo $content_pdf;
                 exit;


          }else{
             return 'ไม่พบไฟล์';
          }
    } catch (\Exception $e) {
             if(!empty($attach_pdf)  && HP::checkFileStorage($attach_pdf)){
                 $attach_path2 = $attach_pdf;
                 HP::getFileStorage($attach_path2);
                 $filePath =  response()->file($public.'/uploads/'.$attach_path2);
                  return $filePath;
               }else   if(!empty($attach_pdf)  && HP::checkFileStorage($attach_path1.$attach_pdf)){
                     $attach_path2 = $attach_path1.$attach_pdf;
                     HP::getFileStorage($attach_path2);
                     $filePath =  response()->file($public.'/uploads/'.$attach_path2);
                      return $filePath;
              }else if(HP::checkFileStorage($attach_path1.'/' .$certi_lab->attach_pdf)){
                  HP::getFileStorage($attach_path1.'/' .$certi_lab->attach_pdf);
                  $filePath =  response()->file($public.'/uploads/'.$attach_path1.'/' . $certi_lab->attach_pdf);
                   return $filePath;
              }else{
                 return 'ไม่พบไฟล์';
              }
     }


  }else{


    try {       
           if(!empty($certi_lab->Certi_Lab_State1_FileTo->attach_pdf)  && HP::checkFileStorage($certi_lab->Certi_Lab_State1_FileTo->attach_pdf)){
                  $attach_path2 = $certi_lab->Certi_Lab_State1_FileTo->attach_pdf;
                  HP::getFileStorage($attach_path2);

                  // $mpdf->SetImportUse();
                  $dashboard_pdf_file         =  url('uploads/'.$attach_path2);
                  $arrContextOptions = array();
                  if(strpos($dashboard_pdf_file, 'https')===0){//ถ้าเป็น https
                      $arrContextOptions["ssl"] = array(
                                                      "verify_peer" => false,
                                                      "verify_peer_name" => false,
                                                  );
                  }
                  $content_pdf =  file_get_contents($dashboard_pdf_file, false, stream_context_create($arrContextOptions));
                                      //Specify that the content has PDF Mime Type
                  header("Content-Type: application/pdf");
                  //Display it
                  echo $content_pdf;
                  exit;

                  
            }else   if(!empty($certi_lab->Certi_Lab_State1_FileTo->attach_pdf)  && HP::checkFileStorage($attach_path1.$certi_lab->Certi_Lab_State1_FileTo->attach_pdf)){
                  $attach_path2 = $attach_path1.$certi_lab->Certi_Lab_State1_FileTo->attach_pdf;
                  HP::getFileStorage($attach_path2);


                  $dashboard_pdf_file             =  url('uploads/'.$attach_path2);
                  $arrContextOptions = array();
                  if(strpos($dashboard_pdf_file, 'https')===0){//ถ้าเป็น https
                      $arrContextOptions["ssl"] = array(
                                                      "verify_peer" => false,
                                                      "verify_peer_name" => false,
                                                  );
                  }
                  $content_pdf =  file_get_contents($dashboard_pdf_file, false, stream_context_create($arrContextOptions));
                                      //Specify that the content has PDF Mime Type
                  header("Content-Type: application/pdf");
  
                  //Display it
                  echo $content_pdf;
                  exit;


           }else if(HP::checkFileStorage($attach_path1.'/' .$certi_lab->attach_pdf)){
                  $attach_path2 = $attach_path1.$certi_lab->attach_pdf;
                  HP::getFileStorage($attach_path2);
                  // $mpdf->SetImportUse();
                  $dashboard_pdf_file         =  url('uploads/'.$attach_path2);
                  $arrContextOptions = array();
                  if(strpos($setting_payment->data, 'https')===0){//ถ้าเป็น https
                      $arrContextOptions["ssl"] = array(
                                                      "verify_peer" => false,
                                                      "verify_peer_name" => false,
                                                  );
                  }
                  $content_pdf =  file_get_contents($dashboard_pdf_file, false, stream_context_create($arrContextOptions));
                                      //Specify that the content has PDF Mime Type
                  header("Content-Type: application/pdf");
                  //Display it
       
                  echo $content_pdf;
                  exit;


           }else{
              return 'ไม่พบไฟล์';
           }
     } catch (\Exception $e) {
              if(!empty($certi_lab->Certi_Lab_State1_FileTo->attach_pdf)  && HP::checkFileStorage($certi_lab->Certi_Lab_State1_FileTo->attach_pdf)){
                  $attach_path2 = $certi_lab->Certi_Lab_State1_FileTo->attach_pdf;
                  HP::getFileStorage($attach_path2);
                  $filePath =  response()->file($public.'/uploads/'.$attach_path2);
                   return $filePath;
                }else   if(!empty($certi_lab->Certi_Lab_State1_FileTo->attach_pdf)  && HP::checkFileStorage($attach_path1.$certi_lab->Certi_Lab_State1_FileTo->attach_pdf)){
                      $attach_path2 = $attach_path1.$certi_lab->Certi_Lab_State1_FileTo->attach_pdf;
                      HP::getFileStorage($attach_path2);
                      $filePath =  response()->file($public.'/uploads/'.$attach_path2);
                       return $filePath;
               }else if(HP::checkFileStorage($attach_path1.'/' .$certi_lab->attach_pdf)){
                   HP::getFileStorage($attach_path1.'/' .$certi_lab->attach_pdf);
                   $filePath =  response()->file($public.'/uploads/'.$attach_path1.'/' . $certi_lab->attach_pdf);
                    return $filePath;
               }else{
                  return 'ไม่พบไฟล์';
               }
      }
            }
    }
}
