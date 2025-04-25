<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabAttachAll extends Model
{
    protected $table = 'app_certi_lab_attach_all';
    protected $fillable = [
        'app_certi_lab_id',
        'file_section',
        'file_desc',
        'file',
        'token',
        'default_disk'
    ];
}
