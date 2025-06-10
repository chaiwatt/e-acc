<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use App\Models\Certificate\Tracking;
use Illuminate\Database\Eloquent\Model;

class TrackingDocReviewAuditor extends Model
{
    use Sortable;
    protected $table = "tracking_doc_review_auditors";
    protected $primaryKey = 'id';
    protected $fillable = [
        'tracking_id',
        'doc_type',
        'team_name',
        'from_date',
        'to_date',
        'type',
        'file',
        'filename',
        'auditors',
        'remark_text',
        'status',
    ];

    public function tracking()
    {
        return $this->belongsTo(Tracking::class,'tracking_id');
    }
}
