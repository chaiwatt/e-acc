<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Basic\Staff;
class Other extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_others';

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
    protected $fillable = ['title', 'inform_type', 'detail', 'attach', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by','tax_id'];

    /*
      Sorting
    */
    public $sortable = ['title', 'inform_type', 'detail', 'attach', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by','tax_id'];

    /*
      User Relation
    */
    public function user_created(){
      return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
      return $this->belongsTo(User::class, 'updated_by');
    }
    public function Staff_updated(){
      return $this->belongsTo(Staff::class, 'updated_by');
    }
    public function getCreatedNameAttribute() {
  		return $this->user_created->trader_operater_name;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->trader_operater_name;
  	}

    /* Tis */
    public function tis_list(){
      return $this->hasMany(OtherTis::class, 'other_id');
    }

}
