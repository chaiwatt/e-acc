<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
 
use App\Models\Basic\Province;
use App\Models\Basic\Amphur;
use App\Models\Basic\District;


class AppointDepartment extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'basic_appoint_departments';

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
    protected $fillable = ['title', 'address', 'province_id', 'amphur_id', 'district_id', 'poscode', 'tel', 'mobile', 'fax', 'email', 'state', 'created_by', 'updated_by'];

    /*
      Sorting
    */
    public $sortable = ['title', 'address', 'province_id', 'amphur_id', 'district_id', 'poscode', 'tel', 'mobile', 'fax', 'email', 'state', 'created_by', 'updated_by'];



 

    public function getCreatedNameAttribute() {
  		return @$this->user_created->reg_fname.' '.@$this->user_created->reg_lname;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
  	}

    //Address Relation
    public function province(){
      return $this->belongsTo(Province::class, 'province_id');
    }

    public function amphur(){
      return $this->belongsTo(Amphur::class, 'amphur_id');
    }

    public function district(){
      return $this->belongsTo(District::class, 'district_id');
    }

}
