<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Basic\Tis;
use App\Models\Esurv\InformCalibrateLicense;

class InformCalibrate extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_inform_calibrates';

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
    protected $fillable = ['tb3_Tisno', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by','tax_id'];

    /*
      Sorting
    */
    public $sortable = ['id', 'tb3_Tisno', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by','tax_id'];

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

    /*
      Tis Relation มาตรฐาน
    */
    public function tis(){
      return $this->belongsTo(Tis::class, 'tb3_Tisno', 'tb3_Tisno');
    }

    /* License */
    public function license_list(){
      return $this->hasMany(InformCalibrateLicense::class);
    }

}
