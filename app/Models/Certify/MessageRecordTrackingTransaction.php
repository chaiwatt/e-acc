<?php

namespace App\Models\Certify;

use App\CertificateExport;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\TrackingAuditors;

class MessageRecordTrackingTransaction extends Model
{
    use Sortable;
    protected $table = 'message_record_tracking_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ba_tracking_id',
        'signer_id',
        'signature_id',
        'certificate_export_id',
        'certificate_type',
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
        'view_url',
        'approval',
  
    ];

    public function certificateExport() {
        return $this->belongsTo(CertificateExport::class, 'certificate_export_id');
    }

    public function trackingAuditor()
    {
        return $this->belongsTo(TrackingAuditors::class, 'ba_tracking_id', 'id');
    }
}

