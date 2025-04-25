<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bcertify\CertificationBranch;

class CbTrustMark extends Model
{
    use Sortable;
    protected $table = "cb_trust_marks";
    protected $primaryKey = 'id';
    protected $fillable = [
        'bcertify_certification_branche_id',
        'tis_no'
    ];

    public function certificationBranch(){
        return $this->belongsTo(CertificationBranch::class, 'bcertify_certification_branche_id', 'id');
    }
}
