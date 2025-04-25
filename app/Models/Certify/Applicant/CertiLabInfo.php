<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabInfo extends Model
{
    protected $table = "app_certi_lab_info";

    protected $fillable = [
                            'app_certi_lab_id',
                            'petitioner',
                            'lab_type_other',
                            'file_section',
                            'desc_main_file',
                            'only_own_depart',
                            'depart_other',
                            'over_twenty',
                            'not_bankrupt',
                            'not_being_incompetent',
                            'suspended_using_a_certificate',
                            'never_revoke_a_certificate',
                            'token',
                            'activity_client_name', 'file_client_name'
                            ];
    public function certi_lab()
    {
        return $this->belongsTo(CertiLab::class ,'app_certi_lab_id' );
    }
}
 