<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use App\User;
class CheckExaminer extends Model
{
    protected $table = "app_cert_lab_checks_examiner";
    protected $fillable = [
        'app_certi_lab_checks_id', 'user_id','app_certi_lab_id'
        
    ];

    public function Checks() {
        return $this->belongsTo(Check::class, 'app_certi_lab_checks_id');
    }
    public function CertiLabs() {
        return $this->belongsTo(CertiLab::class, 'app_certi_lab_id');
    }
    
    public function checker() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
