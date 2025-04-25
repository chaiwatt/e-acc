<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIb;

class IbDocReviewAuditor extends Model
{
    use Sortable;
    protected $table = "ib_doc_review_auditors";
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_ib_id',
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

    public function certiIb()
    {
        return $this->belongsTo(CertiIb::class, 'app_certi_ib_id');
    }

}
