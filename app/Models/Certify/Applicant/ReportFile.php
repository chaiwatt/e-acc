<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class ReportFile extends Model
{
    protected $table = "app_certi_lab_report_assessment_files";
    protected $fillable = [
        'app_certi_report_assessment_id', 'file_desc', 'file', 'created_by', 'updated_by'
    ];

    public function report() {
        return $this->belongsTo(Report::class, 'app_certi_report_assessment_id');
    }
}
