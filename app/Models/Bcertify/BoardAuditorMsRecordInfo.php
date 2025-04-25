<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use App\Models\Certify\BoardAuditor;
use Illuminate\Database\Eloquent\Model;

class BoardAuditorMsRecordInfo extends Model
{
    use Sortable;
    protected $fillable = [
        'board_auditor_id',
        'header_text1',
        'header_text2',
        'header_text3',
        'header_text4',
        'body_text1',
        'body_text2'
    ];
    protected $table = 'board_auditor_ms_record_infos';
    protected $primaryKey = 'id';

    public function boardAuditor()
    {
        return $this->belongsTo(BoardAuditor::class, 'board_auditor_id', 'id');
    }
}

