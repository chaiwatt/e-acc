<?php

namespace App\Models\Certify;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Besurv\Department;
use App\Models\Basic\SubDepartment;

use App\Models\Certify\SetStandardUserSub;

class SetStandardUser extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'set_standard_user';

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
    protected $fillable = ['department_id', 'sub_department_id','lab_ability', 'created_by', 'updated_by'];

    /*
      Sorting
    */
    public $sortable = ['department_id', 'sub_department_id','lab_ability', 'created_by', 'updated_by'];


    

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
    
        /*
      Department Relation
    */
    public function department(){
      return $this->belongsTo(Department::class, 'department_id', 'did');
    }
    public function subdepartment(){
      return $this->belongsTo(SubDepartment::class, 'sub_department_id', 'sub_id');
    }
    public function DataSetStandardUserSub(){
      return $this->hasMany(SetStandardUserSub::class, 'standard_user_id', 'id');
    }


    
}
