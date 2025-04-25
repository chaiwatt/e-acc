<?php

namespace App\Models\Bcertify;

use App\Models\Basic\Department;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AuditorInformation extends Model
{

    use Sortable;
    protected $table = "auditor_informations";
    protected $primaryKey = 'id';
    protected $fillable = [
        'number_auditor',
        'title_th',
        'fname_th',
        'lname_th',
        'title_en',
        'fname_en',
        'lname_en',
        'address',
        'province_id',
        'amphur_id',
        'district_id',
        'email',
        'tel',
        'department_id',
        'position',
        'status_ab',
        'group_id',
        'status',
        'token',
        'user_id',
        'tax_id','created_by','agent_id','checkbox_confirm'
    ];

    protected $appends = ['name_th', 'name_en'];

    public function auditor_assessment(){
        return $this->hasMany(AuditorAssessmentExperience::class, 'auditor_id');
    }

    public function auditor_education(){
        return $this->hasMany(AuditorEducation::class, 'auditor_id');
    }

    public function auditor_expertise(){
        return $this->hasMany(AuditorExpertise::class, 'auditor_id');
    }

    public function auditor_training(){
        return $this->hasMany(AuditorTraining::class, 'auditor_id');
    }

    public function auditor_work_experience(){
        return $this->hasMany(AuditorWorkExperience::class, 'auditor_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNameThAttribute()
    {
        return "{$this->title_th} {$this->fname_th} {$this->lname_th}";
    }

    public function getNameEnAttribute()
    {
        return "{$this->title_en} {$this->fname_en} {$this->lname_en}";
    }

        //  ความเชี่ยวชาญ cb
        public function auditor_expertise_cb(){
            return $this->hasMany(AuditorExpertise::class, 'auditor_id')->where('type_of_assessment',1);
        }
        //  ความเชี่ยวชาญ ib
        public function auditor_expertise_ib(){
            return $this->hasMany(AuditorExpertise::class, 'auditor_id')->where('type_of_assessment',2);
        }
             //  ความเชี่ยวชาญ LAB สอบเทียบ
        public function auditor_expertise_calibration(){
           return $this->hasMany(AuditorExpertise::class, 'auditor_id')->where('type_of_assessment',3);
        }
         //  ความเชี่ยวชาญ LAB ทดสอบ
         public function auditor_expertise_test(){
            return $this->hasMany(AuditorExpertise::class, 'auditor_id')->where('type_of_assessment',4);
         }
    
    
        //  ประสบการณ์การตรวจประเมิน cb
        public function auditor_assessment_experience_cb(){
            return $this->hasMany(AuditorAssessmentExperience::class, 'auditor_id')->where('type_of_assessment',1);
        }
        //  ประสบการณ์การตรวจประเมิน ib
        public function auditor_assessment_experience_ib(){
            return $this->hasMany(AuditorAssessmentExperience::class, 'auditor_id')->where('type_of_assessment',2);
        }
             //  ประสบการณ์การตรวจประเมิน LAB สอบเทียบ
             public function auditor_assessment_experience_lab_calibration(){
                return $this->hasMany(AuditorAssessmentExperience::class, 'auditor_id')->where('type_of_assessment',3);
             }
         //  ประสบการณ์การตรวจประเมิน LAB ทดสอบ
         public function auditor_assessment_experience_lab_test(){
            return $this->hasMany(AuditorAssessmentExperience::class, 'auditor_id')->where('type_of_assessment',4);
         }
}
