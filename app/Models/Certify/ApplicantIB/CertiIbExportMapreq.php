<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;

class CertiIbExportMapreq extends Model
{
    protected $table = 'certificate_ib_export_mapreq';

    protected $fillable = [
            'app_certi_ib_id',
            'certificate_exports_id'
    ];
   
}
