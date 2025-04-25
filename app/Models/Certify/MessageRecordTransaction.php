<?php

namespace App\Models\Certify;

use App\Models\Bcertify\Signer;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class MessageRecordTransaction extends Model
{
    use Sortable;
    protected $table = 'message_record_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'board_auditor_id',
        'certificate_type',
        'view_url',
        'app_id',
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


}
