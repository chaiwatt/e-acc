<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;

class StatusProgressApplicantType extends Model
{
    use Sortable;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bcertify_status_progress_applicant_types';

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
    protected $fillable = ['status_progress_id', 'applicant_type'];

    /*
      Sorting
    */
    public $sortable = ['status_progress_id', 'applicant_type'];

}
