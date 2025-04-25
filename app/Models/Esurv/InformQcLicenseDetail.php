<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class InformQcLicenseDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_inform_qc_license_details';

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
    protected $fillable = ['inform_qc_license_id', 'factory_name', 'factory_address', 'result_attach', 'inspector', 'inspector_other', 'check_date', 'detail'];

    /*
      Sorting
    */
    public $sortable = ['inform_qc_license_id', 'factory_name', 'factory_address', 'result_attach', 'inspector', 'inspector_other', 'check_date', 'detail'];

}
