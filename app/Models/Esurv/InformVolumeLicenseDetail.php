<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class InformVolumeLicenseDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_inform_volume_license_details';

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
    protected $fillable = ['inform_volume_license_id', 'elicense_detail_id', 'volume1', 'volume2', 'volume3', 'unit', 'created_at', 'updated_at'];

    /*
      Sorting
    */
    public $sortable = ['inform_volume_license_id', 'elicense_detail_id', 'volume1', 'volume2', 'volume3', 'unit', 'created_at', 'updated_at'];

}
