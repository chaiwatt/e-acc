<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate\TrackingAuditors;

class BoardAuditoExpertTracking extends Model
{
    use Sortable;
    protected $fillable = [
        'tracking_auditor_id',
        'expert'
    ];
    protected $table = 'board_audito_expert_trackings';
    protected $primaryKey = 'id';

    public function trackingAuditor()
    {
        return $this->belongsTo(TrackingAuditors::class, 'tracking_auditor_id', 'id');
    }
}
