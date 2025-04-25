<?php

namespace App\Models\Certificate;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\AttachFile;
use App\CertificateExport;
use App\Models\Certify\ApplicantCB\CertiCBExport;
use App\Models\Certify\ApplicantIB\CertiIBExport;

class TrackingAssessmentBug extends Model
{
    use Sortable;
    protected $table = "app_certi_tracking_assessment_bug";
    protected $primaryKey = 'id';
    protected $fillable = ['assessment_id', 'report', 'remark', 'no', 'type', 'status', 'details', 'comment', 'file_status', 'file_comment', 'reporter_id' , 'owner_id','cause'];
 
    public function tracking_assessment_to(){
        return $this->belongsTo(TrackingAssessment::class, 'assessment_id');
    }
  
    public function FileAttachAssessmentBugTo()
    {
        return $this->belongsTo(AttachFile::class, 'id','ref_id')
                     ->select('id','new_filename','filename','url')
                     ->where('ref_table',$this->table)
                    ->where('section','attachs')
                    ->orderby('id','desc');
    }
    
}
