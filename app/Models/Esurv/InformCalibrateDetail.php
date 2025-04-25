<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;

class InformCalibrateDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_inform_calibrate_details';

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
    protected $fillable = ['tool', 'detail', 'exam_date', 'attach_result', 'inform_calibrate_id', 'created_at', 'updated_at'];

    /*
      Sorting
    */
    public $sortable = ['tool', 'detail', 'exam_date', 'attach_result', 'inform_calibrate_id', 'created_at', 'updated_at'];

}
