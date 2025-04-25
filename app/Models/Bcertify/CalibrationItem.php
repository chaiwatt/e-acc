<?php

namespace App\Models\Bcertify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Bcertify\Formula;
use App\Models\Bcertify\CalibrationBranch;
use App\Models\Bcertify\CalibrationGroup;

class CalibrationItem extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bcertify_calibration_items';

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
    protected $fillable = ['title', 'formula_id', 'calibration_branch_id', 'calibration_group_id', 'state', 'created_by', 'updated_by'];

    /*
      Sorting
    */
    public $sortable = ['title', 'formula_id', 'calibration_branch_id', 'calibration_group_id', 'state', 'created_by', 'updated_by'];


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
  		return $this->user_created->reg_fname.' '.$this->user_created->reg_lname;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
  	}

    /* Formula */
    public function formula(){
      return $this->belongsTo(Formula::class, 'formula_id');
    }

    /* Calibration Branch */
    public function calibration_branch(){
      return $this->belongsTo(CalibrationBranch::class, 'calibration_branch_id');
    }

    /* Calibration Group */
    public function calibration_group(){
      return $this->belongsTo(CalibrationGroup::class, 'calibration_group_id');
    }

    public function expertise()
    {
        return $this->hasMany(AuditorExpertise::class,'calibration_list');
    }
    public function assessment()
    {
        return $this->hasMany(AuditorAssessmentExperience::class,'calibration_list');
    }
}
