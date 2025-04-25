<?php

namespace App\Models\Certify\Applicant;

use App\Models\Bcertify\AuditorInformation;
use Illuminate\Database\Eloquent\Model;

class NoticeItem extends Model
{
    protected $table = "app_certi_lab_notice_items";
    protected $fillable = ['app_certi_lab_notice_id','remark','report','no','type','status','reporter','reporter_id','attachs','comment','comment_file','details','attachs_client_name','owner_id','cause'];
    public function notice() {
        return $this->belongsTo(Notice::class, 'app_certi_lab_notice_id');
    }

    public function reporter() {
        return $this->belongsTo(AuditorInformation::class, 'reporter_id');
    }
}
