<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\TrackingAuditors;

class BoardAuditorTrackingMsRecordInfo extends Model
{
    use Sortable;
    protected $fillable = [
        'tracking_auditor_id',
        'header_text1',
        'header_text2',
        'header_text3',
        'header_text4',
        'body_text1',
        'body_text2'
    ];
    protected $table = 'board_auditor_tracking_ms_record_infos';
    protected $primaryKey = 'id';

    public function trackingAuditor()
    {
        return $this->belongsTo(TrackingAuditors::class, 'tracking_auditor_id', 'id');
    }
}
