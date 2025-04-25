<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;

class CertiCbExportMapreq extends Model
{
    protected $table = 'certificate_cb_export_mapreq';

    protected $fillable = [
            'app_certi_cb_id',
            'certificate_exports_id'
    ];
   
}
