<?php

namespace App\Models\Certify\Applicant;

use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\Applicant\CertLabsFileAll;
use App\CertificateExport;
class CertiLabExportMapreq extends Model
{
    protected $table = 'certificate_export_mapreq';

    protected $fillable = [
            'app_certi_lab_id',
            'certificate_exports_id'
    ];

    public function certilab_export_mapreq_group_many()
    {
        return $this->hasMany(CertiLabExportMapreq::class, 'certificate_exports_id','certificate_exports_id');
    }
    
    public function certificate_export() {
        return $this->belongsTo(CertificateExport::class, 'certificate_exports_id','id');
    }

    public function cert_labs_file_all(){
        return $this->belongsTo(CertLabsFileAll::class,'app_certi_lab_id','app_certi_lab_id')->where('state',1)->orderby('id','desc');
    }
    
}
