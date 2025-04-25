<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;

class CertiLabDeleteFile extends Model
{
    //

    protected $table = 'app_certi_lab_check_delete_files';

    protected $fillable = [
        'app_certi_lab_id', 'name', 'path'
    ];
}
