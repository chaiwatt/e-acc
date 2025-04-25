<?php

namespace App\Models\Certify\Applicant;

use App\Models\Certify\BoardAuditor;
use App\Models\Certify\BoardAuditorGroup;
use App\Models\Certify\BoardAuditorInformation;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = "app_certi_lab_assessments";
    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_lab_id','checker_id','agree_status','assessment_status','created_by','auditor_id'];
    public function applicant() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }

    public function checker() {
        return $this->belongsTo('App\User', 'checker_id');
    }

    public static function getCertiLabs() {
        return CertiLab::where('status', '>=', StatusTrait::$STATUS_REQUEST)->orderBy('created_at', 'desc');
    }

    public function groups() {
        return $this->hasMany(AssessmentGroup::class, 'app_certi_assessment_id');
    }

    public function cost_assessment() {
        return $this->hasOne(CostAssessment::class, 'app_certi_assessment_id');
    }

    public function report() {
        return $this->hasOne(Report::class, 'app_certi_assessment_id');
    }

    public function cost_certificate() {
        return $this->hasOne(CostCertificate::class, 'app_certi_assessment_id');
    }

    public function notices() {
        return $this->hasMany(Notice::class, 'app_certi_assessment_id');
    }
    public function board_auditor_to() {
        return $this->belongsTo(BoardAuditor::class, 'auditor_id');
    }


    public function notice_items() {
        return $this->hasManyThrough(
            NoticeItem::class,
            Notice::class,
            'app_certi_assessment_id',
            'app_certi_lab_notice_id'
        );
    }

    public function getSelectAuditors() {
        $group = $this->groups()->where('status', 1)->first();
        $af_ids = collect();
        foreach ($group->auditors as $ag) {
            $auditor = $ag->auditor;

            // Board Auditor Information
            $bfs =  $auditor->hasManyThrough(
                BoardAuditorInformation::class,
                BoardAuditorGroup::class,
                'board_auditor_id',
                'group_id'
            )->get();
            foreach ($bfs as $bf) {
                // Auditor Information
                $af = $bf->auditor;
                if (!$af_ids->has($af->id)) {
                    $af_ids->put($af->id, $af);
                }
            }
        }
        return $af_ids;
    }
}
