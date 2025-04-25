<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\CertificateExport;
use App\AttachFile;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;
class  TrackingPayInOne extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_pay_in1";
    protected $primaryKey = 'id';
    protected $fillable = ['tracking_id','certificate_type', 'reference_refno', 'ref_table', 'ref_id', 'conditional_type', 'auditors_id', 'amount', 'start_date', 'status', 'remark', 'detail', 'start_date_feewaiver', 'end_date_feewaiver', 'created_by', 'updated_by'];



    public function tracking_to()
    {
        return $this->belongsTo(Tracking::class,'tracking_id');
    }


    public function auditors_to()
    {
     return $this->belongsTo(TrackingAuditors::class, 'auditors_id','id' );
    }

    public function certificate_export_to()
    {
        if($this->certificate_type == 1){
            return $this->belongsTo(CertiCBExport::class,'ref_id','id');
          }else if($this->certificate_type == 2){
            return $this->belongsTo(CertiIBExport::class,'ref_id','id');
          }else{
            return $this->belongsTo(CertificateExport::class,'ref_id','id');
          }
    }
 

   // หลักฐานการชำระ จนท.
    public function FileAttachPayInOne1To()
    {
 
        return $this->belongsTo(AttachFile::class, 'id','ref_id')
                        ->select('id','new_filename','filename','url')
                        ->where('ref_table',$this->table)
                        ->where('section','attach_payin1')
                        ->orderby('id','desc');
    }
    // หลักฐานการชำระ ผปก.
    public function FileAttachPayInOne2To()
    {
 
        return $this->belongsTo(AttachFile::class, 'id','ref_id')
                        ->select('id','new_filename','filename','url')
                        ->where('ref_table',$this->table)
                        ->where('section','attachs_file')
                        ->orderby('id','desc');
    }
}
