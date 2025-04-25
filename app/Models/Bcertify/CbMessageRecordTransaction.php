<?php

namespace App\Models\Bcertify;

use App\Models\Besurv\Signer;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\CertiCBAuditors;

class CbMessageRecordTransaction extends Model
{
    use Sortable;
    protected $table = 'cb_message_record_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'board_auditor_id',
        'certificate_type',
        'app_id',
        'view_url',
        'signer_id',
        'signature_id',
        'is_enable',
        'show_name',
        'show_position',
        'signer_name',
        'signer_position',
        'signer_order',
        'file_path',
        'page_no',
        'pos_x',
        'pos_y',
        'linesapce',
        'approval',
    ];

    public function certiCBAuditor()
    {
        return $this->belongsTo(CertiCBAuditors::class, 'board_auditor_id', 'id');
    }
}
