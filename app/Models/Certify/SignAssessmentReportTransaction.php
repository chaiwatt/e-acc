<?php

namespace App\Models\Certify;

use App\Certify\CbReportInfo;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Certify\LabReportInfo;
use Illuminate\Database\Eloquent\Model;

class SignAssessmentReportTransaction extends Model
{
    use Sortable;
    protected $table = 'sign_assessment_report_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'report_info_id',
        'signer_id',
        'app_id',
        'certificate_type',
        'signer_name',
        'signer_position',
        'signer_order',
        'file_path',
        'linesapce',
        'view_url',
        'approval',
        'report_type'
    ];

    // public function labReportInfo(){
    //     return $this->belongsTo(LabReportInfo::class, 'report_info_id', 'id');
    // }
    public function reportInfo()
    {
        if ($this->certificate_type == 2) 
        {
            return $this->belongsTo(LabReportInfo::class, 'report_info_id', 'id');
        }else if($this->certificate_type == 0)
        {
            return $this->belongsTo(CbReportInfo::class, 'report_info_id', 'id');
        }
    }


}
