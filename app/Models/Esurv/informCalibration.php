<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Esurv\InformCalibrationLicense;

class informCalibration extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_inform_calibrations';

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
    protected $fillable = ['tb3_Tisno', 'calibration_date', 'detail', 'attach', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by'];

    /*
      Sorting
    */
    public $sortable = ['tb3_Tisno', 'calibration_date', 'detail', 'attach', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by'];



    /*
      User Relation
    */
    public function user_created(){
      return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
      return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCreatedNameAttribute() {
  		return $this->user_created->trader_operater_name;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->trader_operater_name;
  	}

    /* License */
    public function license_list(){
      return $this->hasMany(InformCalibrationLicense::class);
    }

}
