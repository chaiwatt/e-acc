<?php

namespace App\ApplicantIB;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIb;

class IbDocReviewAssessment extends Model
{
    use Sortable;
    protected $table = "ib_doc_review_assessments";
    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_ib_id','template','report_type','status' ,'signers' ];

    public function certiIb(){
        return $this->belongsTo(CertiIb::class, 'app_certi_ib_id', 'id');
    }
}
