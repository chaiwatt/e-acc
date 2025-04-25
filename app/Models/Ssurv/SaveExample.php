<?php

namespace App\Models\Ssurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SaveExample extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'save_example';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tis_standard', 'licensee', 'verification', 'sample_submission', 'stored_add', 'room_anchor'
        , 'sample_submission_date', 'sample_pay', 'permission_submiss', 'tel_submiss', 'email_submiss', 'sample_collect_date'
        , 'sample_recipient', 'permission_receive', 'tel_receive', 'email_receive', 'sample_return', 'status', 'user_create'
        , 'remark','user_register','remake_assign','remake_report','remake_test','res_status','no','status2','status3','single_attach'];

    /*
      Sorting
    */
    public $sortable = ['tis_standard', 'licensee', 'verification', 'sample_submission', 'stored_add', 'room_anchor'
        , 'sample_submission_date', 'sample_pay', 'permission_submiss', 'tel_submiss', 'email_submiss', 'sample_collect_date'
        , 'sample_recipient', 'permission_receive', 'tel_receive', 'email_receive', 'sample_return', 'status', 'user_create'
        , 'remark','user_register','remake_assign','remake_report','remake_test','res_status','no','status2','status3'];

    public function tis(){
        return $this->belongsTo(Tis::class, 'tis_standard','tb3_Tisno');
    }
}
