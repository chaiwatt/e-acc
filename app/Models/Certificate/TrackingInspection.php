<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\CertificateExport;
use App\AttachFile;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;
class  TrackingInspection extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_inspection";
    protected $primaryKey = 'id';
    protected $fillable = ['tracking_id','certificate_type', 'reference_refno', 'ref_table', 'ref_id', 'status','details', 'created_date',  'created_by', 'updated_by'];

    public function tracking_to()
    {
        return $this->belongsTo(Tracking::class,'tracking_id');
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
 

   // Scope
    public function FileAttachScopeTo()
    {
        return $this->belongsTo(AttachFile::class, 'id','ref_id')
                        ->select('id','new_filename','filename','url')
                        ->where('ref_table',$this->table)
                        ->where('section','file_scope')
                        ->orderby('id','desc');
    }
    // สรุปรายงานการตรวจทุกครั้ง
    public function FileAttachReportTo()
    {
        return $this->belongsTo(AttachFile::class, 'id','ref_id')
                        ->select('id','new_filename','filename','url')
                        ->where('ref_table',$this->table)
                        ->where('section','file_report')
                        ->orderby('id','desc');
    }
     // ไฟล์แนบ (ถ้ามี)   ยืนยัน Scope 
     public function FileAttachFilesMany()
     {
      return $this->hasMany(AttachFile::class, 'ref_id','id')
                    ->select('id','new_filename','filename','url','caption')
                    ->where('ref_table',$this->table)
                    ->where('section','attach_files');
     }

}
