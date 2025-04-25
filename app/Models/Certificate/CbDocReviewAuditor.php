<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class CbDocReviewAuditor extends Model
{
    use Sortable;
    protected $table = "cb_doc_review_auditors";
    protected $primaryKey = 'id';
    protected $fillable = [
        'app_certi_cb_id',
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
}
