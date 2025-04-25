<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CheckFile extends Model
{
    protected $table = "app_certi_lab_check_files";
    protected $fillable = [
        'check_id', 'file_desc', 'file', 'created_by', 'updated_by','status'
    ];

    public function checker() {
        return $this->belongsTo(Check::class, 'checker_id');
    }
}
