<?php

namespace App\Models\Certificate;

use App\AttachFile;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class TrackingLabReportTwo extends Model
{
    use Sortable;
    protected $table = 'tracking_lab_report_twos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'tracking_assessment_id',
        'observation_count_text',
        'lab_letter_received_date_text',
        'email_sent_date_secondary_text',
        'email_sent_date_tertiary_text',
        'checkbox_corrective_action_completed',
        'checkbox_corrective_action_incomplete',
        'remaining_nonconformities_count_text',
        'remaining_nonconformities_list_text',
        'checkbox_extend_certification',
        'checkbox_reject_extend_certification',
        'reason_for_extension_decision_text',
        'checkbox_submit_remaining_evidence',
        'remaining_evidence_items_text',
        'remaining_evidence_due_date_text',
        'checkbox_unresolved_nonconformities',
        'checkbox_reduce_scope',
        'checkbox_suspend_certificate',
        'attached_files',
        'persons',
        'status',
    ];

    public function trackingAssessment()
    {
        return $this->belongsTo(TrackingAssessment::class,'tracking_assessment_id');
    }


    public function attachments()
    {
        return $this->hasMany(AttachFile::class, 'ref_id', 'id')
                    ->where('ref_table', 'tracking_lab_report_twos')
                    ->where('section', '11111');
    }

    /**
     * Accessor สำหรับ compatibility (ถ้ายังต้องการ)
     */
    public function getAttachmentsAttribute()
    {
        // ใช้ relationship แทนการ query ใหม่
        return $this->attachments()->get();
    }
}
