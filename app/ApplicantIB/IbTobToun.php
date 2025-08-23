<?php

namespace App\ApplicantIB;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certify\ApplicantIB\CertiIb;

class IbTobToun extends Model
{
    use Sortable;
    protected $table = "ib_tob_touns";
    protected $primaryKey = 'id';
    protected $fillable = ['app_certi_ib_id','template','report_type','status' ,'signers' ];

    public function certiIb(){
        return $this->belongsTo(CertiIb::class, 'app_certi_ib_id', 'id');
    }
}
