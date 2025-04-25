<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\CertificateExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\Applicant\CertiLab;
use App\Models\Certify\ApplicantIB\CertiIb;
use App\Models\Certify\ApplicantCB\CertiCb;

class SendCertificateLists extends Model
{
    use Sortable;
    protected $table = "certify_send_certificate_lists";
    protected $primaryKey = 'id';
    protected $fillable = ['send_certificate_id', 'certificate_type','certificate_tb','certificate_id','sign_status','sign_path', 'app_certi_id'  ];


    public function getSignStatusTitleAttribute() {
        $status = ['1'=>'รอดำเนินการ','2'=>'อยู่ระหว่างลงนาม','3'=>'ลงนามใบรับรองเรีบยร้อย','4'=>'ไม่อนุมัติการลงนาม'];
          return array_key_exists($this->sign_status,$status) ? $status[$this->sign_status] : null;
      }
      
    public function send_certificates_to(){
        return $this->belongsTo(SendCertificates::class, 'send_certificate_id');
    }

    public function sign_certificate_confirms_to() {
        return $this->belongsTo(SignCertificateConfirms::class, 'id','send_certificate_list_id');
    }
  
     
    public function cert_export_to() {
         return $this->belongsTo(CertificateExport::class, 'certificate_id');
    }

    public function cert_export_ib_to() {
        return $this->belongsTo(CertiIBExport::class, 'certificate_id');
    }
    public function cert_export_cb_to() {
        return $this->belongsTo(CertiCBExport::class, 'certificate_id');
    }


    public function app_cert_to() {
        return $this->belongsTo(CertiLab::class, 'app_certi_id');
   }

   public function app_cert_ib_to() {
       return $this->belongsTo(CertiIb::class, 'app_certi_id');
   }
   public function app_cert_cb_to() {
       return $this->belongsTo(CertiCb::class, 'app_certi_id');
   }



}
