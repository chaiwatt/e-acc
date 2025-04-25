<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIBAuditors;

class IbBoardAuditorMsRecordInfo extends Model
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
    protected $table = 'ib_board_auditor_ms_record_infos';
    protected $primaryKey = 'id';

    public function certiIBAuditor()
    {
        return $this->belongsTo(CertiIBAuditors::class, 'board_auditor_id', 'id');
    }
}
