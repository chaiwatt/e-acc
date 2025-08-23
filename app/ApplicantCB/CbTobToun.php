<?php

namespace App\ApplicantCB;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantCB\CertiCb;

class CbTobToun extends Model
{
    use Sortable;
    protected $table = "cb_tob_touns";
    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_cb_id','template','report_type','status' ,'signers' ];

    public function certiCb(){
        return $this->belongsTo(CertiCb::class, 'app_certi_cb_id', 'id');
    }
}
