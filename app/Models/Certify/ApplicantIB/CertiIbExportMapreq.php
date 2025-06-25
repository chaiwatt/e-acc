<?php

namespace App\Models\Certify\ApplicantIB;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIb;
use App\Models\Certify\ApplicantIB\CertiIBExport;

class CertiIbExportMapreq extends Model
{
    protected $table = 'certificate_ib_export_mapreq';

    protected $fillable = [
            'app_certi_ib_id',
            'certificate_exports_id'
    ];

    public function app_certi_ib_to()
    {
        return $this->belongsTo(CertiIb::class, 'app_certi_ib_id');
    }

    public function app_certi_ib_export_to() {
        return $this->belongsTo(CertiIBExport::class,'certificate_exports_id', 'id');
    }

    public function certiib_export_mapreq_group_many()
    {
        return $this->hasMany(CertiIbExportMapreq::class, 'certificate_exports_id','certificate_exports_id');
    }
   
}
