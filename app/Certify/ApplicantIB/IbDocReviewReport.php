<?php

namespace App\Certify\ApplicantIB;

use App\Models\Certify\ApplicantIB\CertiIb;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIBSaveAssessment;

class IbDocReviewReport extends Model
{
    use Sortable;
    protected $table = "ib_doc_review_reports";
    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_ib_id','template','report_type','status' ,'signers' ];

      public function certiIb(){
        return $this->belongsTo(CertiIb::class, 'app_certi_ib_id', 'id');
    }
}
