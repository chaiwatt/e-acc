<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class InformCalibrationLicense extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_inform_calibration_licenses';

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
    protected $fillable = ['tbl_licenseNo', 'inform_calibration_id', 'created_at', 'updated_at'];

    /*
      Sorting
    */
    public $sortable = ['tbl_licenseNo', 'inform_calibration_id', 'created_at', 'updated_at'];

}
