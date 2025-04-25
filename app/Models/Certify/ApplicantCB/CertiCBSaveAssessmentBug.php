<?php

namespace App\Models\Certify\ApplicantCB;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use HP;
use DB;

use App\User; 

use  App\Models\Esurv\Trader;

class CertiCBSaveAssessmentBug extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_certi_cb_assessment_bug';

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
    protected $fillable = ['assessment_id', 'report','remark','no','type','reporter_id','details','status','comment','file_status','file_comment','attachs','attach_client_name'];


}
