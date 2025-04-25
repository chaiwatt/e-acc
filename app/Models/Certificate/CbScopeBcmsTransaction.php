<?php

namespace App\Models\Certificate;

use Kyslik\ColumnSortable\Sortable;
use App\Models\Certificate\CbScopeBcms;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\CertiCb;

class CbScopeBcmsTransaction extends Model
{
    use Sortable;
    protected $table = "cb_scope_bcms_transactions";
    protected $primaryKey = 'id';
    protected $fillable = [
        'certi_cb_id',
        'bcms_id'
    ];

    public function certiCb()
    {
        return $this->belongsTo(CertiCb::class, 'certi_cb_id', 'id');
    }
    public function cbScopeBcms()
    {
        return $this->belongsTo(CbScopeBcms::class, 'bcms_id', 'id');
    }
}
