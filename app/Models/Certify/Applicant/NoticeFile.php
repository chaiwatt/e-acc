<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class NoticeFile extends Model
{
    protected $table = "app_certi_lab_notice_files";

    public function notice() {
        return $this->belongsTo(Notice::class, 'app_certi_lab_notice_id');
    }
}
