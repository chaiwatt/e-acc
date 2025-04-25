<?php

namespace App\Certify;

use App\Certify\CbReportInfo;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbReportInfoSigner extends Model
{
    use Sortable;
    protected $table = 'cb_report_info_signers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cb_report_info_id',
        'signer_id',
        'app_id',
        'certificate_type',
        'signer_name',
        'signer_position',
        'signer_order',
        'file_path',
        'linesapce',
        'view_url',
        'approval'
    ];

    public function cbReportInfo(){
        return $this->belongsTo(CbReportInfo::class, 'cb_report_info_id', 'id');
    }
}
