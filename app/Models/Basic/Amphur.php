<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use App\Models\Basic\Province;

class Amphur extends Model
{
    use Sortable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amphur';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'AMPHUR_ID';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['AMPHUR_CODE', 'AMPHUR_NAME', 'AMPHUR_NAME_EN', 'POSTCODE', 'GEO_ID', 'PROVINCE_ID', 'state', 'created_by', 'updated_by'];

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
  		return @$this->user_created->reg_fname.' '.@$this->user_created->reg_lname;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
  	}

    /*
      Province Relation
    */
    public function province(){
      return $this->belongsTo(Province::class, 'PROVINCE_ID');
    }


}
