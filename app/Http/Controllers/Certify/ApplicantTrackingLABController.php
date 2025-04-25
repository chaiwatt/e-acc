<?php

namespace App\Http\Controllers\Certify;

use DB;
use HP;

use stdClass;
use App\AttachFile;
use App\CertificateExport;
use Illuminate\Http\Request;
use App\Mail\Tracking\ReportMail;
use App\Mail\Tracking\AuditorsMail;
use App\Mail\Tracking\PayInTwoMail;
use App\Http\Controllers\Controller;
use App\Mail\Tracking\PayInOneMail; 
use App\Models\Certificate\Tracking;
use Illuminate\Support\Facades\Mail; 
use App\Mail\Tracking\EvaluationMail; 
use App\Mail\Tracking\InspectiontMail;
use App\Mail\Tracking\SaveAssessmentMail;
use App\Mail\Tracking\ConFirmAuditorsMail;
use App\Models\Certificate\TrackingReport;
use App\Models\Certificate\TrackingReview;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certificate\TrackingAuditors;
use App\Models\Certificate\TrackingHistory; 
use App\Models\Certificate\TrackingPayInOne;
use App\Models\Certificate\TrackingPayInTwo;
use App\Models\Certificate\TrackingInspection;
use App\Models\Certificate\TrackingAssessment; 
use App\Models\Certificate\TrackingAssessmentBug;
use App\Models\Certify\Applicant\CertLabsFileAll;

class ApplicantTrackingLABController extends Controller
{

    private $attach_path;//ที่เก็บไฟล์แนบ
    public function __construct()
    {
       $this->middleware('auth');
        $this->attach_path = 'files/trackinglabs';
    }


    public function index(Request $request)
    {
        $model = str_slug('view-tracking-lab','-');
         $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
            if(HP::CheckPermission($model)){
                $filter = [];
                $filter['filter_status'] = $request->get('filter_status', '');
                $filter_status =   $filter['filter_status'];
                $filter['filter_search'] = $request->get('filter_search', '');
                $filter_search =   $filter['filter_search'];
                $filter['perPage'] = $request->get('perPage', 10);

 
                $query = Tracking::WhereNotNull('status_id')
                                ->Where('ref_table',(new CertificateExport)->getTable())
                                ->when($data_session, function ($query, $data_session){
                                    $ids = [];
                                    if(!is_null($data_session->agent_id)){  // ตัวแทน
                                        return  $query->where('agent_id',  $data_session->agent_id ) ;
                                }else{
                                    if($data_session->branch_type == 1){  // สำนักงานใหญ่
                                        return  $query->where('tax_id',  $data_session->tax_number ) ;
                                    }else{   // ผู้บันทึก
                                        return  $query->where('user_id',   auth()->user()->getKey()) ;
                                    }
                                    } 
                                }) 
                                ->when($filter_status, function ($query,$filter_status ){
                                    return  $query->where('status_id',$filter_status);
                                }) 
                                ->when($filter_search, function ($query,$filter_search){
                                    return  $query->where(DB::raw("REPLACE(reference_refno,' ','')"), 'LIKE', "%".$filter_search."%");
                                }) 
                                    ->orderby('id','desc')
                                ->paginate($filter['perPage']); 
                                    
 
                return view('certify.tracking-labs.index', compact('filter','query'));
            }
            abort(403);
        }else{
            return  redirect(HP::DomainTisiSso());  
        }
    }


    public function auditor(Request $request,$id)
    {

        $model = str_slug('view-tracking-lab','-');
        $data_session     =    HP::CheckSession();
        if(!empty($data_session)){
          if(HP::CheckPermission($model)){
            $tracking =   Tracking::findOrFail(base64_decode($id));
             return view('certify.tracking-labs.form.auditor', compact('tracking'));                    
           }
            abort(403);
         }else{
            return  redirect(HP::DomainTisiSso());  
       }
    }


    public function updateAuditor(Request $request,$id = null)
    {
 
      $data_session     =    HP::CheckSession();
// try{
      $tb = new TrackingAuditors;
      $tracking =   Tracking::findOrFail($id);
      if(!is_null($tracking)){
          $authorities = [];
          $data = [];

          foreach ($request->auditors_id as $key => $item){
                $auditors = TrackingAuditors::where('id',$item)->orderby('id','desc')->first();
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
                            $attach_more =   HP::singleFileUploadRefno(
                                                    $attach ,
                                                    $this->attach_path.'/'.$auditors->reference_refno,
                                                    ( $data_session->tax_number ?? null),
                                                    (auth()->user()->FullName ?? null),
                                                    'Center',
                                                    $tb->getTable(),
                                                    $auditors->id,
                                                    'attach_files',
                                                    $request->file_desc[$item][$key] ?? null
                                                  );

                              $find                   = new stdClass();
                              $find->caption          = $attach_more->caption ?? null;
                              $find->url              = $attach_more->url ?? null;
                              $find->filename         = $attach_more->filename ?? null;
                              $find->new_filename     = $attach_more->new_filename  ?? null;
                              $attachs[]              =  $find;
                          }
                       }
                    }



                  $history = TrackingHistory::where('tracking_id',$tracking->id)
                                            ->where('refid',$auditors->id)
                                            ->where('system',4)
                                            ->orderby('id','desc')
                                            ->first();
                  if(!is_null($history)){
                     $history->details_one  =  json_encode($auditors) ?? null;
                     $history->status       =  $auditors->status ??  null;
                     $history->attachs_file  =   count($attachs)  > 0  ? json_encode($attachs) : null;
                     $history->user_id      =   auth()->user()->getKey();
                     $history->date          =     date('Y-m-d');
                     $history->save();
 
                  }

                  // pay in ครั้งที่ 1
                 if($auditors->status == 1){
                      $payin =  new TrackingPayInOne ;
                      $payin->certificate_type  =  3;
                      $payin->reference_refno   =  $tracking->reference_refno;
                      $payin->ref_table         =  (new CertificateExport)->getTable();
                      $payin->ref_id            =  $tracking->ref_id;
                      $payin->tracking_id       =  $tracking->id;
                      $payin->auditors_id       =  $auditors->id;
                      $payin->save();
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
        if(count($tracking->AssignEmails) > 0  && count($authorities) > 0 && !empty($tracking->certificate_export_to->CertiLabTo)){  //  ส่ง E-mail ผก. + เจ้าหน้าที่รับผิดชอบ
            $certi =    $tracking->certificate_export_to->CertiLabTo;
              $data_app = ['title'         =>  '',
                            'email'        => $certi->email,
                            'auditors'     =>$auditors,
                            'certi'        =>$certi,
                            'export'       =>$tracking,
                            'name'         => !empty($certi->name)  ?  $certi->name  : '',
                            'authorities'  => count($authorities) > 0 ?  $authorities : '',
                            'url'          => $url.'certificate/tracking-labs/'.$tracking->id .'/edit',
                            'email_cc'     => (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC :  []
                          ];
        
                $log_email =  HP::getInsertCertifyLogEmail(!empty($auditors->tracking_to->reference_refno)? $auditors->tracking_to->reference_refno:null,   
                                                            $auditors->tracking_id,
                                                            (new Tracking)->getTable(),
                                                            $auditors->id ?? null,
                                                            (new TrackingAuditors)->getTable(),
                                                            4,
                                                            'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                            view('mail.Tracking.auditors', $data_app),
                                                            !empty($certi->created_by)? $certi->created_by:null,   
                                                            !empty($certi->agent_id)? $certi->agent_id:null, 
                                                            auth()->user()->getKey(),
                                                            $certi->email,
                                                            implode(",",$tracking->AssignEmails),
                                                            (count($certi->DataEmailDirectorLABCC) > 0 ) ? implode(",",$certi->DataEmailDirectorLABCC) : null,
                                                             null
                                                          );

                $html = new AuditorsMail($data_app); 
                $mail =  Mail::to($tracking->AssignEmails)->send($html);   
             
                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                }   
 
        }
 
 
             if(!empty($tracking->certificate_export_to->CertiLabTo->CertiEmailLt)  && count($authorities) > 0){  //  ส่ง E-mail เจ้าหน้าที ลท. CB   + เจ้าหน้าที่รับผิดชอบ
                 $certi =  $tracking->certificate_export_to->CertiLabTo;
                 $data_app = [   'title'       =>  '',
                                'email'        => $certi->email,
                                'auditors'     => $auditors,
                                'certi'        => $certi,
                                'export'       => $tracking->certificate_export_to,
                                'name'         => !empty($certi->name)  ?  $certi->name  : '',
                                'authorities'  => count($authorities) > 0 ?  $authorities : '-',
                                'url'          => $url.'certificate/tracking-labs/'.$tracking->id .'/edit',
                                'email_cc'     => (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC :  []
                            ];
          
                  $log_email =  HP::getInsertCertifyLogEmail(!empty($auditors->tracking_to->reference_refno)? $auditors->tracking_to->reference_refno:null,   
                                                              $auditors->tracking_id,
                                                              (new Tracking)->getTable(),
                                                              $auditors->id ?? null,
                                                              (new TrackingAuditors)->getTable(),
                                                              4,
                                                              'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                              view('mail.Tracking.con_firm_auditors', $data_app),
                                                              !empty($certi->created_by)? $certi->created_by:null,   
                                                              !empty($certi->agent_id)? $certi->agent_id:null, 
                                                              auth()->user()->getKey(),
                                                              $certi->email,
                                                              implode(",",$certi->CertiEmailLt),
                                                              (count($certi->DataEmailDirectorLABCC) > 0 ) ? implode(",",$certi->DataEmailDirectorLABCC) : null,
                                                               null
                                                            );
  
                  $html = new ConFirmAuditorsMail($data_app); 
                  $mail =  Mail::to($certi->CertiEmailLt)->send($html);   
              
                  if(is_null($mail) && !empty($log_email)){
                      HP::getUpdateCertifyLogEmail($log_email->id);
                  }   
 
         
              }


      if($request->previousUrl){
          return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
      }else{
          return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
      }
//   } catch (\Exception $e) {
//       return redirect('certify/tracking-labs')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
//   }    

  }

  public function pay_in1(Request $request,$id)
  {
      $model = str_slug('view-tracking-lab','-');
      $data_session     =    HP::CheckSession();
      if(!empty($data_session)){
        if(HP::CheckPermission($model)){
           $pay_in =   TrackingPayInOne::findOrFail(base64_decode($id));
           return view('certify.tracking-labs.form.pay_in1', compact('pay_in'));                    
         }
          abort(403);
       }else{
          return  redirect(HP::DomainTisiSso());  
     }
  }


  public function update_pay_in1(Request $request, $id){
        // dd($request->all());
        $data_session     =    HP::CheckSession();
 
         $tb       = new TrackingPayInOne;
         $pay_in   = TrackingPayInOne::findOrFail($id);
         $config   = HP::getConfig();
         $url      =  !empty($config->url_center) ? $config->url_center : url('');
         $file     = [];
        if(!is_null($pay_in) && isset($request->attachs_file)  && $request->hasFile('attachs_file')){
                // dd( $this->attach_path.'/'.$pay_in->reference_refno,$data_session->tax_number,$data_session->name,'ACC',$pay_in->id,$tb->getTable(),'attachs_file');
 
                $file_payin  =   HP::singleFileUploadRefno(
                                                            $request->file('attachs_file') ,
                                                            $this->attach_path.'/'.$pay_in->reference_refno,
                                                            ( $data_session->tax_number ),
                                                            ( $data_session->name ),
                                                            'ACC',
                                                            ( $tb->getTable() ),
                                                            $pay_in->id,
                                                            'attachs_file',
                                                            null
                                                         );
 
                if(!is_null($file_payin) && HP::checkFileStorage($file_payin->url)){
                    HP::getFileStorage($file_payin->url);
                }
                
            
               if( !empty($file_payin->url)){
                   $file['url'] =  $file_payin->url;
               }
               if( !empty($file_payin->new_filename)){
                   $file['new_filename'] =  $file_payin->new_filename;
               }
               if( !empty($file_payin->filename)){
                   $file['filename'] =  $file_payin->filename;
               }  
         
             $pay_in->state = 2;
             $pay_in->status =  null;
             $pay_in->remark = null;
             $pay_in->save();
          

          // สถานะ แต่งตั้งคณะกรรมการ
            $auditor = TrackingAuditors::findOrFail($pay_in->auditors_id);
            if(!is_null($auditor) && $pay_in->state == 2){
                $auditor->step_id = 5; // แจ้งหลักฐานการชำระเงิน
                $auditor->save();
             }


           //  Log
            $history = TrackingHistory::where('tracking_id',$pay_in->tracking_id)
                                        ->where('refid',$pay_in->id)
                                        ->where('system',5)
                                        ->orderby('id','desc')
                                        ->first();

            if(!is_null($history)){
                $history->attachs_file  =   count($file) > 0  ? json_encode($file) : null;
                $history->user_id       =   auth()->user()->getKey();
                $history->date          =     date('Y-m-d');
                $history->save();
            }
            

            // Mail ลท.
            $export =   CertificateExport::findOrFail($pay_in->ref_id);
            if(!empty($export)  && !empty($export->CertiLabTo->CertiEmailLt)){
                
                    $certi  =  $export->CertiLabTo;
                    $data_app = [ 'certi'      => $certi  ,
                                    'pay_in'    => $pay_in  ,
                                    'files'     => !empty($file_payin->url) ? $file_payin->url : null,
                                    'email'     => $certi->email,
                                    'url'       => $url.'/certificate/tracking-labs/Pay_In1/'.$pay_in->id,
                                    'email_cc'  =>  (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC :  []
                                ];
            
                    $log_email =  HP::getInsertCertifyLogEmail(!empty($pay_in->tracking_to->reference_refno)? $pay_in->tracking_to->reference_refno:null,   
                                                                $pay_in->tracking_id,
                                                                (new Tracking)->getTable(),
                                                                $pay_in->id ?? null,
                                                                (new TrackingPayInOne)->getTable(),
                                                                4,
                                                                'แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน',
                                                                view('mail.Tracking.pay_in_one', $data_app),
                                                                !empty($certi->created_by)? $certi->created_by:null,   
                                                                !empty($certi->agent_id)? $certi->agent_id:null, 
                                                                auth()->user()->getKey(),
                                                                $certi->email,
                                                                implode(",",$certi->CertiEmailLt),
                                                                (count($certi->DataEmailDirectorLABCC) > 0 ) ? implode(",",$certi->DataEmailDirectorLABCC) : null,
                                                                null
                                                                );
    
                    $html = new PayInOneMail($data_app); 
                     $mail = Mail::to($certi->CertiEmailLt)->send($html);   
                  
                    if(is_null($mail) && !empty($log_email)){
                        HP::getUpdateCertifyLogEmail($log_email->id);
                    } 
               }


                try{
                    //  เช็คการชำระ
                    $arrContextOptions=array();
                    if(strpos($url, 'https')===0){//ถ้าเป็น https
                        $arrContextOptions["ssl"] = array(
                                                        "verify_peer" => false,
                                                        "verify_peer_name" => false,
                                                    );
                    }
                    file_get_contents($url.'api/v1/checkbill?ref1='.$pay_in->reference_refno.'-'.$pay_in->auditors_id, false, stream_context_create($arrContextOptions));
                } catch (\Exception $e) {
    
                }  

        }
    
    

      if($request->previousUrl){
          return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
      }else{
          return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
      }

 

  }

  

  public function assessment(Request $request,$id)
  {

      $model = str_slug('view-tracking-lab','-');
      $data_session     =    HP::CheckSession();
      if(!empty($data_session)){
        if(HP::CheckPermission($model)){
           $assessment =   TrackingAssessment::findOrFail(base64_decode($id));
           return view('certify.tracking-labs.form.assessment', compact('assessment'));                    
         }
          abort(403);
       }else{
          return  redirect(HP::DomainTisiSso());  
     }
  }
  public function update_assessment(Request $request, $id){
    $data_session     =    HP::CheckSession();
// try{
        $requestData = $request->all();
        $assessment =   TrackingAssessment::findOrFail($id);
        $assessment->degree = 2;
        $assessment->save();
  
     if(isset($requestData["detail"]) ){
        $detail = (array)$requestData["detail"];
        foreach ($detail['id'] as $key => $item) {
                $bug = TrackingAssessmentBug::where('id',$item)->first();
                if(!is_null($bug)){
                    $bug->details = $detail["details"][$key] ?? $bug->details;
                    $assessment->check_file = 'false';
                    if($request->attachs  && $request->hasFile('attachs')){
                        if(array_key_exists($key, $request->attachs)){

                                HP::singleFileUploadRefno(
                                    $request->attachs[$key],
                                    $this->attach_path.'/'.$assessment->reference_refno,
                                    ( $data_session->tax_number  ?? null),
                                    ( $data_session->name ?? null ),
                                    'ACC',
                                    ( (new TrackingAssessmentBug)->getTable() ),
                                     $bug->id,
                                    'attachs',
                                    null
                                );
                        }
                        $assessment->check_file  = 'true';
                    }
                    $bug->save();
                }
        }
     }


     $tracking =   Tracking::findOrFail($assessment->tracking_id);
     if(!is_null($tracking)){
   
    
            $history = TrackingHistory::where('tracking_id',$assessment->tracking_id)
                                        ->where('refid',$assessment->id)
                                        ->where('system',6)
                                        ->orderby('id','desc')
                                        ->first();
            $bugs = TrackingAssessmentBug::select('report','remark','no','type','reporter_id','details','status','comment','file_status','file_comment','id')
                                        ->where('assessment_id',$id)
                                        ->get();
            $datas = [];
            if(count($bugs) > 0) {
                foreach($bugs as $key => $item){
                    $object                 = (object)[];
                    $object->report         = $item->report ?? null;
                    $object->remark         = $item->remark ?? null;
                    $object->no             = $item->no ?? null;
                    $object->type           = $item->type ?? null;
                    $object->reporter_id    = $item->reporter_id ?? null;
                    $object->details        = $item->details ?? null;
                    $object->status         = $item->status ?? null;
                    $object->comment        = $item->comment ?? null;
                    $object->file_status    = $item->file_status ?? null;
                    $object->file_comment   = $item->file_comment ?? null;
                    if(!empty($item->FileAttachAssessmentBugTo)){
                        $attachs = [];
                          if( !empty($item->FileAttachAssessmentBugTo->url)){
                            $attachs['url'] =  $item->FileAttachAssessmentBugTo->url;
                          }
                          if( !empty($item->FileAttachAssessmentBugTo->new_filename)){
                              $attachs['new_filename'] =  $item->FileAttachAssessmentBugTo->new_filename;
                          }
                          if( !empty($item->FileAttachAssessmentBugTo->filename)){
                              $attachs['filename'] =  $item->FileAttachAssessmentBugTo->filename;
                          }
                        $object->attachs    = $attachs;
                    }else{
                        $object->attachs    =  null;
                    }
                    $datas[] = $object;
                }
            }

 
            if(!is_null($history)){
                $history->details_two   =   count($datas) > 0  ? json_encode($datas) : null;
                $history->user_id       =   auth()->user()->getKey();
                $history->date          =     date('Y-m-d');
                $history->save();
            }


 
           // ส่ง Email เจ้าหน้าที่มอบหมาย
            if(!empty($tracking->certificate_export_to->CertiLabTo->email)){

                $config = HP::getConfig();
                $url  =   !empty($config->url_center) ? $config->url_center : url('');   

                $certi  =  $tracking->certificate_export_to->CertiLabTo;

                $data_app = [
                                'email'         => $certi->email,
                                'assessment'    => $assessment,
                                'certi'         => $certi,
                                'url'           => $url.'certificate/assessment-labs/'.$assessment->id.'/edit',
                                'email_cc'      => (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC : []
                            ];
            
                    $log_email =  HP::getInsertCertifyLogEmail(!empty($assessment->tracking_to->reference_refno)? $assessment->tracking_to->reference_refno:null,   
                                                                $assessment->tracking_id,
                                                                (new Tracking)->getTable(),
                                                                $assessment->id ?? null,
                                                                (new TrackingAssessment)->getTable(),
                                                                4,
                                                                'แจ้งแนวทางแก้ไข/ส่งหลักฐานการแก้ไขข้อบกพร่อง',
                                                                view('mail.Tracking.assessment', $data_app),
                                                                !empty($certi->created_by)? $certi->created_by:null,   
                                                                !empty($certi->agent_id)? $certi->agent_id:null, 
                                                                auth()->user()->getKey(),
                                                                $certi->email,
                                                                implode(",",$tracking->AssignEmails),
                                                                (count($certi->DataEmailDirectorLABCC) > 0 ) ? implode(",",$certi->DataEmailDirectorLABCC) : null,
                                                                null
                                                                );
    
                    $html = new SaveAssessmentMail($data_app); 
                    $mail = Mail::to($tracking->AssignEmails)->send($html);   
                                                           
                    if(is_null($mail) && !empty($log_email)){
                        HP::getUpdateCertifyLogEmail($log_email->id);
                    } 
             
            }
     }  
 
        

     if($request->previousUrl){
          return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
      }else{
          return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
      }
// } catch (\Exception $e) {
//     return redirect('certify/tracking-labs')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
// }  

  }

  public function evaluation(Request $request,$id)
  {
      $model = str_slug('view-tracking-lab','-');
      $data_session     =    HP::CheckSession();
      if(!empty($data_session)){
        if(HP::CheckPermission($model)){
           $evaluation =   TrackingAssessment::findOrFail(base64_decode($id));
           return view('certify.tracking-labs.form.evaluation', compact('evaluation'));                    
         }
          abort(403);
       }else{
          return  redirect(HP::DomainTisiSso());  
     }
  }


  public function update_evaluation(Request $request, $id)
  {
     $data_session     =    HP::CheckSession();
// try{   
      $evaluation = TrackingAssessment::findOrFail($id);

      
           // สถานะ แต่งตั้งคณะกรรมการ
      $auditor = TrackingAuditors::findOrFail($evaluation->auditors_id);
      $export =   CertificateExport::findOrFail($evaluation->ref_id);

       if(!is_null($evaluation)){

          if($request->status_scope == 1){  // update สถานะ

              AttachFile::where('ref_table',(new TrackingAssessment)->getTable())  ->where('section',6)   ->where('ref_id',$evaluation->id)   ->delete();
            
              $evaluation->details = null;
              $evaluation->status = 1;
              $evaluation->degree = 7;
              $evaluation->save();

             // สถานะ แต่งตั้งคณะกรรมการ
              $auditor->step_id = 10; //ยืนยัน Scope
              $auditor->save();

              // สถานะ แต่งตั้งคณะกรรมการ
                if(!is_null($export)){
                    // สถานะ แต่งตั้งคณะกรรมการ
                    $auditor = TrackingAuditors::where('ref_id',$export->id)
                                                ->where('ref_table',(new CertificateExport)->getTable())
                                                ->where('certificate_type',3)
                                                ->where('reference_refno',$evaluation->reference_refno)
                                                ->get(); 
                    if(count($auditor) == count($export->auditors_status_cancel_many)){
                        // $export->review     = 1;
                        $export->status_id  = 11;
                        $export->save();
                         
                       $inspection =   TrackingInspection::where('ref_id',$export->id)  ->where('ref_table',(new CertificateExport)->getTable())   ->where('certificate_type',3)  ->where('reference_refno',$export->reference_refno)->first();
                       if(is_null($inspection)){
                        $inspection = new TrackingInspection;
                       }
                       $inspection->ref_id              = $export->id;
                       $inspection->ref_table           = (new CertificateExport)->getTable();
                       $inspection->certificate_type    = 3;
                       $inspection->reference_refno     = $evaluation->reference_refno;
                       $inspection->save();
                    }
                }


 

          }else{

            // $evaluation->date_scope_edit = date('Y-m-d h:m:s');
            $evaluation->status         = 2;
            $evaluation->degree         = 5;
            $evaluation->details        = $request->details ?? null;
            $evaluation->save();

           
            $export->status_id  = 10;
            $export->save();
            // ไฟล์แนบ
            if($request->attach_files  && $request->hasFile('attach_files')){
                 AttachFile::where('ref_table',(new TrackingAssessment)->getTable())  ->where('section',6)   ->where('ref_id',$evaluation->id)   ->delete();
                foreach ($request->attach_files as $index => $item){
                        HP::singleFileUploadRefno(
                                                    $item ,
                                                    $this->attach_path.'/'.$evaluation->reference_refno,
                                                    ( $data_session->tax_number  ?? null),
                                                    ( $data_session->name ?? null ),
                                                    'ACC',
                                                    (  (new TrackingAssessment)->getTable() ),
                                                        $evaluation->id,
                                                    '6',
                                                    null
                                                 );

                }
            }

            $auditor->step_id = 11; // ขอแก้ไข Scope
            $auditor->save();
          }

      
          if(!is_null($export)){
                //Log
                $history = TrackingHistory::where('ref_table',(new CertificateExport)->getTable())
                                                        ->where('ref_id',$export->id)
                                                        ->where('table_name',(new TrackingAssessment)->getTable())
                                                        ->where('refid',$evaluation->id)
                                                        ->where('system',8)
                                                        ->orderby('id','desc')
                                                        ->first();
                if(!is_null($history)){

                     $history->status           = $evaluation->status  ??  null;
                     $history->remark           = $evaluation->details  ??  null;
                     $history->attachs_file     =  (count($evaluation->FileAttachAssessment6Many) > 0) ? json_encode($evaluation->FileAttachAssessment6Many) : null;
                     $history->user_id          =   auth()->user()->getKey();
                     $history->date             =  date('Y-m-d');
                     $history->save();   
                
                }

                //Mail
                if(!empty($export->CertiLabTo)){
                    $config = HP::getConfig();
                    $url  =   !empty($config->url_center) ? $config->url_center : url('');    
                    $certi  =  $export->CertiLabTo;

                    $mail = new EvaluationMail(['certi'        => $certi ?? '-',
                                                    'export'      => $export ?? '' ,
                                                    'email'       => $certi->email,
                                                    'evaluation'  => $evaluation,
                                                    'url'         => $url.'/certificate/tracking-labs/'.$export->id .'/edit',
                                                    'email_cc'    =>  (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                                                    ]);
                    if(count($certi->DataEmailDirectorLAB) > 0 ){
                          Mail::to($certi->DataEmailDirectorLAB)->send($mail);
                    }
                }
          }


        }
        if($request->previousUrl){
            return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
        }else{
            return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
        }
// } catch (\Exception $e) {
//            return redirect('certify/tracking-labs')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
// } 
}

// ยืนยัน Scope 
public function update_inspection(Request $request, $id)
{
   
 // try{  

   $data_session     =    HP::CheckSession();
   $inspection                  = TrackingInspection::findOrFail($id);
//    dd($inspection->reference_refno);
   $inspection->status          = $request->status ?? null;
   $inspection->details         =  ((!empty($request->details) &&  $inspection->status == 2) ? $request->details : null);
   $inspection->created_date    = date('Y-m-d H:i:s');
   $inspection->save();


    // $certiLab = TrackingAssessment::where('reference_refno',$inspection->reference_refno)->first()->certificate_export_to->applications;

    // $certiLabFileAll = CertLabsFileAll::where('app_certi_lab_id',$certiLab->id)->first();

    // $filePath = 'files/applicants/check_files/' . $certiLabFileAll->attach_pdf ;

    // $localFilePath = HP::downloadFileFromTisiCloud($filePath);

    // $check = AttachFile::where('systems','Center')
    // ->where('ref_id',$inspection->id)
    // ->where('section','file_scope')
    // ->first();
    // if($check != null)
    // {
    //     $check->delete();
    // }

    // $tax_number = (!empty(auth()->user()->reg_13ID) ?  str_replace("-","", auth()->user()->reg_13ID )  : '0000000000000');

    // $uploadedFile = new \Illuminate\Http\UploadedFile(
    //     $localFilePath,      // Path ของไฟล์
    //     basename($localFilePath), // ชื่อไฟล์
    //     mime_content_type($localFilePath), // MIME type
    //     null,               // ขนาดไฟล์ (null ถ้าไม่ทราบ)
    //     true                // เป็นไฟล์ที่ valid แล้ว
    // );

    // $attach_path = "files/trackinglabs";
    // // ใช้ไฟล์ที่จำลองในการอัปโหลด
    // HP::singleFileUploadRefno(
    //     $uploadedFile,
    //     $attach_path.'/'.$inspection->reference_refno,
    //     ( $tax_number),
    //     (auth()->user()->FullName ?? null),
    //     'Center',
    //     (  (new TrackingInspection)->getTable() ),
    //     $inspection->id,
    //     'file_scope',
    //     null
    // );


    $attach_files = [];
   if($inspection->status == 2 && $request->attach_files  && $request->hasFile('attach_files')){
        AttachFile::where('ref_table',(new TrackingInspection)->getTable())  ->where('section','attach_files')  ->where('ref_id',$inspection->id)   ->delete();
        foreach ($request->attach_files as $index => $item){
                $request =  HP::singleFileUploadRefno(
                                            $item ,
                                            $this->attach_path.'/'.$inspection->reference_refno,
                                            ( $data_session->tax_number  ?? null),
                                            ( $data_session->name ?? null ),
                                            'ACC',
                                            (  (new TrackingInspection)->getTable() ),
                                            $inspection->id,
                                            'attach_files',
                                            ( $request->file_desc_text[$index] ?? null )
                                        );
                if(!is_null($request)){
                    $object = (object)[];
                    $object->url                = $request->url ?? null;
                    $object->filename           = $request->filename ?? null;
                    $object->new_filename       = $request->new_filename ?? null;
                    $object->caption            = $request->caption ?? null;
                    $attach_files[]             =  $object;                     
                }

        }
   }



   $tracking =   Tracking::findOrFail($inspection->tracking_id);
   if(!is_null($tracking)){
            if($inspection->status  == 1){
                // $tracking->status_id  = 6 ;
                // $report =   TrackingReport::where('tracking_id',$tracking->id)->where('reference_refno',$tracking->reference_refno)->first();
                // if(is_null($report)){
                //  $report = new TrackingReport;
                // }
                // $report->tracking_id         = $tracking->id;
                // $report->ref_id              = $tracking->ref_id;
                // $report->ref_table           = (new CertificateExport)->getTable();
                // $report->certificate_type    = 3;
                // $report->reference_refno     = $tracking->reference_refno;
                // $report->save();
                $tracking->status_id  = 6  ; // ทบทวนฯ
                // $tracking->status_id  = 7  ; // แนบท้าย
                $review =   TrackingReview::where('tracking_id',$tracking->id)->where('reference_refno',$tracking->reference_refno)->first();
                if(is_null($review)){
                 $review = new TrackingReview;
                }
                $review->tracking_id         = $tracking->id;
                $review->ref_id              = $tracking->ref_id;
                $review->ref_table           = (new CertificateExport)->getTable();
                $review->certificate_type    = 3;
                $review->reference_refno     = $tracking->reference_refno;
                $review->save();
            }else{
                $tracking->status_id = 4;
            }
            $tracking->save();

            $history = TrackingHistory::where('tracking_id',$tracking->id)
                                        ->where('refid',$inspection->id)
                                        ->where('system',8)
                                        ->orderby('id','desc')
                                        ->first();
            if(!is_null($history)){
                $history->status        =    $inspection->status   ;
                $history->details_one   =    $inspection->created_date   ;
                $history->details_two   =   isset($request->details) ?  $request->details : null   ;
                $history->attachs_file   =  (count($attach_files) > 0) ? json_encode($attach_files) : null;
                $history->user_id       =    auth()->user()->getKey();
                $history->date          =    date('Y-m-d');
                $history->save();
            }

         //Mail
        if(!empty($tracking->certificate_export_to->CertiLabTo)  && (count($tracking->AssignEmails) > 0 )){

            $config = HP::getConfig();
            $url  =   !empty($config->url_center) ? $config->url_center : url(''); 

            $certi  =  $tracking->certificate_export_to->CertiLabTo;

            $data_app =   [ 'certi'       => $certi ?? '-',
                            'export'      => $tracking->certificate_export_to ,
                            'email'       => $certi->email,
                            'inspection'  => $inspection,
                            'url'         => $url.'/certificate/tracking-labs/'.$tracking->id .'/edit',
                            'email_cc'    =>  (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC :  []
                          ];
        
                $log_email =  HP::getInsertCertifyLogEmail(!empty($inspection->tracking_to->reference_refno)? $inspection->tracking_to->reference_refno:null,   
                                                            $inspection->tracking_id,
                                                            (new Tracking)->getTable(),
                                                            $inspection->id ?? null,
                                                            (new TrackingInspection)->getTable(),
                                                            4,
                                                            'ยืนยันขอบข่ายการรับรอง',
                                                            view('mail.Tracking.inspection', $data_app),
                                                            !empty($certi->created_by)? $certi->created_by:null,   
                                                            !empty($certi->agent_id)? $certi->agent_id:null, 
                                                            auth()->user()->getKey(),
                                                            $certi->email,
                                                            implode(",",$tracking->AssignEmails),
                                                            (count($certi->DataEmailDirectorLABCC) > 0 ) ? implode(",",$certi->DataEmailDirectorLABCC) : null,
                                                            null
                                                            );

                $html = new InspectiontMail($data_app); 
                  $mail = Mail::to($tracking->AssignEmails)->send($html); 
                                               
                if(is_null($mail) && !empty($log_email)){
                    HP::getUpdateCertifyLogEmail($log_email->id);
                } 
        }

   } 


if($request->previousUrl){
    return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
}else{
    return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
}
// } catch (\Exception $e) {
//            return redirect('certify/tracking-labs')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
// }  
}

public function update_report(Request $request, $id)
{

// try{  
    $data_session                    =    HP::CheckSession();

    $report                             = TrackingReport::findOrFail($id);
    $report->status_confirm             = isset($request->status_confirm) ? $request->status_confirm  : null;
    $report->date_confirm               = date('Y-m-d H:i:s');
    $report->save();
 
    if($report->status_confirm == 1){

 
        $tracking =   Tracking::findOrFail($report->tracking_id);
        if(!is_null($tracking)){
          
                     $tracking->status_id  = 8 ;
                     $tracking->save();


                     $review =   TrackingReview::where('tracking_id',$tracking->id)->where('reference_refno',$tracking->reference_refno)->first();
                     if(is_null($review)){
                      $review = new TrackingReview;
                     }
                     $review->tracking_id         = $tracking->id;
                     $review->ref_id              = $tracking->ref_id;
                     $review->ref_table           = (new CertificateExport)->getTable();
                     $review->certificate_type    = 3;
                     $review->reference_refno     = $tracking->reference_refno;
                     $review->save();

                     $object1 = (object)[];
                     $object1->status_confirm       = $report->status_confirm ?? null;
                     $object1->date_confirm         = $report->date_confirm ?? null;
 
    
           $history = TrackingHistory::where('tracking_id',$tracking->id)
                                    ->where('refid',$report->id)
                                    ->where('system',9)
                                    ->orderby('id','desc')
                                    ->first();
            if(!is_null($history)){
                $history->details_two   =   !empty($object1) ?  json_encode($object1) : null   ;
                $history->user_id       =    auth()->user()->getKey();
                $history->date          =    date('Y-m-d');
                $history->save();
            }

            //Mail
            if(!empty($tracking->certificate_export_to->CertiLabTo)){
                $config = HP::getConfig();
                $url  =   !empty($config->url_center) ? $config->url_center : url('');    
                $certi  =  $tracking->certificate_export_to->CertiLabTo;

                $mail = new ReportMail(['certi'      => $certi ?? '-',
                                        'export'      => $tracking->certificate_export_to ,
                                        'email'       => $certi->email,
                                        'report'      => $report,
                                        'url'         => $url.'/certificate/tracking-labs/'.$tracking->id .'/edit',
                                        'email_cc'    =>  (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                                        ]);
               if(count($tracking->AssignEmails) > 0 ){
                      Mail::to($tracking->AssignEmails)->send($mail);
                }
            }

        }    

    }


   if($request->previousUrl){
         return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
    }else{
        return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
    }

// } catch (\Exception $e) {
//            return redirect('certify/tracking-labs')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
// }  
}

public function update_payin2(Request $request, $id)
{

// try{  

    $data_session                    =    HP::CheckSession();

    $pay_in                             = TrackingPayInTwo::findOrFail($id);
    $pay_in->state                      = 2;
    $pay_in->save();

    $attach =  [];
   if($request->attach  && $request->hasFile('attach')){
      $request =  HP::singleFileUploadRefno(
                                $request->file('attach') , 
                                    $this->attach_path.'/'.$pay_in->reference_refno,
                                    ( $data_session->tax_number  ?? null),
                                    ( $data_session->name ?? null ),
                                    'ACC',
                                    (  (new TrackingPayInTwo)->getTable() ),
                                    $pay_in->id,
                                    'attach_files',
                                   null
                                );
        if(!is_null($request)){
            $attach['url']          =  $request->url ?? null;        
            $attach['new_filename'] =  $request->new_filename ?? null;      
            $attach['filename']     =  $request->filename ?? null;  
        }
   }



   $tracking =  Tracking::findOrFail($pay_in->tracking_id);
   if(!is_null($tracking)){

       $tracking->status_id  = 11 ;
       $tracking->save();

        $history = TrackingHistory::where('tracking_id',$tracking->id)
                                ->where('refid',$pay_in->id)
                                ->where('system',11)
                                ->orderby('id','desc')
                                ->first();
        if(!is_null($history)){
            $history->attachs_file   =   count($attach) > 0 ?  json_encode($attach) : null   ;
            $history->user_id       =    auth()->user()->getKey();
            $history->date          =    date('Y-m-d');
            $history->save();
        }

        //Mail
        if(!empty($tracking->certificate_export_to->CertiLabTo)){

            $config  = HP::getConfig();
            $url        =   !empty($config->url_center) ? $config->url_center : url('');    
            $certi      =  $tracking->certificate_export_to->CertiLabTo;

            $pay_in     = TrackingPayInTwo::findOrFail($id);
            if(!is_null($pay_in->FileAttachPayInTwo2To) && HP::checkFileStorage($pay_in->FileAttachPayInTwo2To->url)){
                HP::getFileStorage($pay_in->FileAttachPayInTwo2To->url);
            }


            $mail = new PayInTwoMail(['certi'         => $certi ?? '-',
                                        'export'       =>  $tracking->certificate_export_to ,
                                        'email'       => $certi->email,
                                        'attach'      =>  !empty($pay_in->FileAttachPayInTwo2To->url) ? $pay_in->FileAttachPayInTwo2To->url : '',
                                        'pay_in'      => $pay_in,
                                        'url'         => $url.'/certificate/tracking-labs/'.$tracking->id .'/edit',
                                        'email_cc'    =>  (count($certi->DataEmailDirectorLABCC) > 0 ) ? $certi->DataEmailDirectorLABCC : 'lab1@tisi.mail.go.th'
                                    ]);
              if(count($tracking->AssignEmails) > 0 ){
                   Mail::to($tracking->AssignEmails)->send($mail);
            }
        }
      }

    if($request->previousUrl){
        return redirect("$request->previousUrl")->with('message', 'เรียบร้อยแล้ว!');
   }else{
       return redirect('certify/tracking-labs')->with('message', 'เรียบร้อยแล้ว!');
   }

// } catch (\Exception $e) {
//            return redirect('certify/tracking-labs')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
// }  
}

public function confirmNotice(Request $request)
{
//   dd(TrackingAssessment::find($request->notice_id));
//   $assessment =   TrackingAssessment::findOrFail($id);
  $notice = TrackingAssessment::find($request->notice_id)->update([
      'accept_fault' => 1
  ]);
  return response()->json($notice);
}


}
