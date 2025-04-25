<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\TrackingLabReportInfo;

class SignAssessmentTrackingReportTransaction extends Model
{
    use Sortable;
    protected $table = "sign_assessment_tracking_report_transactions";
    protected $primaryKey = 'id';
    protected $fillable = [
        'tracking_report_info_id', 'signer_id','app_id',  'certificate_type', 'signer_name', 'signer_position','signer_order','file_path','linesapce','view_url','approval'
    ];

    // public function trackingLabReportInfo(){
    //     return $this->belongsTo(TrackingLabReportInfo::class, 'tracking_report_info_id', 'id');
    // }

    public function trackingLabReportInfo(){
        return $this->belongsTo(TrackingLabReportInfo::class, 'tracking_report_info_id', 'id')
                    ->where('certificate_type', 2);
    }
}
