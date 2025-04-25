<?php

namespace App\Models\Bcertify;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\CertiCb;

class CbRequestRejectTracking extends Model
{
    use Sortable;

    protected $table = 'cb_request_reject_trackings';


    protected $primaryKey = 'id';


    protected $fillable = ['app_certi_cb_id', 'date'];

    public function certiCb()
    {
        return $this->belongsTo(CertiCb::class, 'app_certi_cb_id');
    }
}
