<?php

namespace App\Models\Esurv;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;

class Volume20Ter extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'esurv_volume_20ters';

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
    protected $fillable = ['applicant_20ter_id', 'start_date', 'end_date', 'attach', 'inform_close', 'because_close', 'applicant_name', 'tel', 'email', 'state', 'created_by', 'updated_by', 'khrang_thi','tax_id'];

    /*
      Sorting
    */
    public $sortable = ['applicant_20ter_id', 'start_date', 'end_date', 'attach', 'inform_close', 'because_close', 'applicant_name', 'tel', 'email', 'state', 'created_at', 'created_by', 'updated_by', 'khrang_thi','tax_id'];



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

    /* Referrent */
    public function applicant(){
      return $this->belongsTo(Applicant20Ter::class, 'applicant_20ter_id');
    }
}
